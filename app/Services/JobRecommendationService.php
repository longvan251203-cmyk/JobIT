<?php

namespace App\Services;

use App\Models\Applicant;
use App\Models\JobPost;
use App\Models\JobRecommendation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JobRecommendationService
{
    // Trọng số cho từng yếu tố
    const WEIGHT_SKILLS = 0.35;
    const WEIGHT_EXPERIENCE = 0.20;
    const WEIGHT_LOCATION = 0.15;
    const WEIGHT_SALARY = 0.15;
    const WEIGHT_LANGUAGE = 0.15;

    /**
     * Tính điểm phù hợp giữa ứng viên và job
     */
    public function calculateMatchScore(Applicant $applicant, JobPost $job): array
    {
        $scores = [
            'skills' => $this->calculateSkillsMatch($applicant, $job),
            'experience' => $this->calculateExperienceMatch($applicant, $job),
            'location' => $this->calculateLocationMatch($applicant, $job),
            'salary' => $this->calculateSalaryMatch($applicant, $job),
            'language' => $this->calculateLanguageMatch($applicant, $job),
        ];

        // Tính tổng điểm có trọng số
        $totalScore =
            ($scores['skills']['score'] * self::WEIGHT_SKILLS) +
            ($scores['experience']['score'] * self::WEIGHT_EXPERIENCE) +
            ($scores['location']['score'] * self::WEIGHT_LOCATION) +
            ($scores['salary']['score'] * self::WEIGHT_SALARY) +
            ($scores['language']['score'] * self::WEIGHT_LANGUAGE);

        return [
            'score' => round($totalScore, 2),
            'breakdown' => $scores
        ];
    }

    /**
     * 1. Tính độ phù hợp về KỸ NĂNG
     */
    private function calculateSkillsMatch(Applicant $applicant, JobPost $job): array
    {
        $applicantSkills = $applicant->kynang()
            ->pluck('ten_ky_nang')
            ->map(fn($skill) => strtolower(trim($skill)))
            ->toArray();

        if (empty($applicantSkills)) {
            return [
                'score' => 0,
                'reason' => 'Bạn chưa cập nhật kỹ năng',
                'details' => [
                    'applicant_skills' => [],
                    'required_skills' => [],
                    'matched_skills' => [],
                    'missing_skills' => []
                ]
            ];
        }

        $jobSkills = $job->hashtags()
            ->pluck('tag_name')
            ->map(fn($skill) => strtolower(trim($skill)))
            ->toArray();

        if (empty($jobSkills)) {
            return [
                'score' => 50,
                'reason' => 'Công việc không yêu cầu kỹ năng cụ thể',
                'details' => [
                    'applicant_skills' => $applicantSkills,
                    'required_skills' => [],
                    'matched_skills' => [],
                    'missing_skills' => []
                ]
            ];
        }

        $matchedSkills = array_intersect($applicantSkills, $jobSkills);
        $missingSkills = array_diff($jobSkills, $applicantSkills);
        $matchCount = count($matchedSkills);
        $totalRequired = count($jobSkills);

        $score = ($matchCount / $totalRequired) * 100;

        // Bonus nếu có thêm kỹ năng
        $extraSkills = count($applicantSkills) - $totalRequired;
        if ($extraSkills > 0) {
            $bonus = min(10, $extraSkills * 2);
            $score = min(100, $score + $bonus);
        }

        // Tạo lý do
        $reason = '';
        if ($matchCount == $totalRequired) {
            $reason = "Bạn có đầy đủ {$totalRequired} kỹ năng yêu cầu";
        } elseif ($matchCount > 0) {
            $reason = "Bạn có {$matchCount}/{$totalRequired} kỹ năng yêu cầu";
            if (!empty($missingSkills)) {
                $reason .= ". Còn thiếu: " . implode(', ', array_slice($missingSkills, 0, 3));
            }
        } else {
            $reason = "Bạn chưa có kỹ năng yêu cầu. Cần: " . implode(', ', array_slice($jobSkills, 0, 3));
        }

        return [
            'score' => round($score, 2),
            'reason' => $reason,
            'details' => [
                'applicant_skills' => $applicantSkills,
                'required_skills' => $jobSkills,
                'matched_skills' => array_values($matchedSkills),
                'missing_skills' => array_values($missingSkills)
            ]
        ];
    }

    /**
     * 2. Tính độ phù hợp về KINH NGHIỆM
     */
    private function calculateExperienceMatch(Applicant $applicant, JobPost $job): array
    {
        $applicantYears = $applicant->kinhnghiem()->count();

        $experienceMap = [
            'no_experience' => ['years' => 0, 'label' => 'Không yêu cầu'],
            'under_1' => ['years' => 1, 'label' => 'Dưới 1 năm'],
            '1_2' => ['years' => 1.5, 'label' => '1-2 năm'],
            '2_5' => ['years' => 3.5, 'label' => '2-5 năm'],
            '5_plus' => ['years' => 5, 'label' => 'Trên 5 năm']
        ];

        $requiredExp = $experienceMap[$job->experience] ?? ['years' => 0, 'label' => 'Không rõ'];
        $requiredYears = $requiredExp['years'];

        if ($requiredYears == 0) {
            return [
                'score' => 100,
                'reason' => 'Công việc không yêu cầu kinh nghiệm',
                'details' => [
                    'applicant_years' => $applicantYears,
                    'required_years' => 0,
                    'required_label' => $requiredExp['label']
                ]
            ];
        }

        $score = 0;
        $reason = '';

        if ($applicantYears >= $requiredYears) {
            $excess = $applicantYears - $requiredYears;
            if ($excess <= 2) {
                $score = 100;
                $reason = "Bạn có {$applicantYears} năm kinh nghiệm, phù hợp với yêu cầu {$requiredExp['label']}";
            } else {
                $score = max(80, 100 - ($excess * 5));
                $reason = "Bạn có {$applicantYears} năm kinh nghiệm, nhiều hơn yêu cầu {$requiredExp['label']}";
            }
        } else {
            $shortfall = $requiredYears - $applicantYears;
            $score = max(0, 100 - ($shortfall * 25));
            $reason = "Bạn có {$applicantYears} năm kinh nghiệm, còn thiếu " . round($shortfall, 1) . " năm so với yêu cầu {$requiredExp['label']}";
        }

        return [
            'score' => round($score, 2),
            'reason' => $reason,
            'details' => [
                'applicant_years' => $applicantYears,
                'required_years' => $requiredYears,
                'required_label' => $requiredExp['label']
            ]
        ];
    }

    /**
     * 3. Tính độ phù hợp về ĐỊA ĐIỂM - CHỈ CỘNG ĐIỂM KHI ĐÚNG TỈNH
     */
    private function calculateLocationMatch(Applicant $applicant, JobPost $job): array
    {
        $applicantLocation = strtolower(trim($applicant->diachi_uv ?? ''));
        $jobLocation = strtolower(trim($job->province ?? ''));

        if (empty($applicantLocation) || empty($jobLocation)) {
            return [
                'score' => 50,
                'reason' => 'Không đủ thông tin về địa điểm',
                'details' => [
                    'applicant_location' => $applicant->diachi_uv ?? 'Chưa cập nhật',
                    'job_location' => $job->province ?? 'Chưa rõ'
                ]
            ];
        }

        // Kiểm tra remote
        if (stripos($job->working_type, 'remote') !== false) {
            return [
                'score' => 100,
                'reason' => 'Làm việc remote - không giới hạn địa điểm',
                'details' => [
                    'applicant_location' => $applicant->diachi_uv,
                    'job_location' => 'Remote',
                    'working_type' => $job->working_type
                ]
            ];
        }

        // Chuẩn hóa địa điểm
        $normalizedApplicant = $this->normalizeLocation($applicantLocation);
        $normalizedJob = $this->normalizeLocation($jobLocation);

        $score = 0;
        $reason = '';

        // ✅ FIXED: CHỈ CỘNG ĐIỂM KHI ĐÚNG TỈNH/THÀNH PHỐ
        if ($normalizedApplicant === $normalizedJob) {
            $score = 100;
            $reason = "✓ Cùng tỉnh/thành phố: {$job->province}";
        } else {
            $score = 0; // ✅ KHÁC TỈNH = 0 ĐIỂM
            $reason = "✗ Khác tỉnh/thành: Bạn ở {$applicant->diachi_uv}, công việc tại {$job->province}";
        }

        return [
            'score' => round($score, 2),
            'reason' => $reason,
            'details' => [
                'applicant_location' => $applicant->diachi_uv,
                'job_location' => $job->province,
                'normalized_applicant' => $normalizedApplicant,
                'normalized_job' => $normalizedJob,
                'is_match' => $normalizedApplicant === $normalizedJob
            ]
        ];
    }

    /**
     * 4. Tính độ phù hợp về MỨC LƯƠNG
     */
    private function calculateSalaryMatch(Applicant $applicant, JobPost $job): array
    {
        $expectedSalary = (float) $applicant->mucluong_mongmuon;

        if (!$expectedSalary) {
            return [
                'score' => 70,
                'reason' => 'Bạn chưa cập nhật mức lương mong muốn',
                'details' => [
                    'expected_salary' => null,
                    'job_min' => $job->salary_min,
                    'job_max' => $job->salary_max
                ]
            ];
        }

        if ($job->salary_type === 'negotiable') {
            return [
                'score' => 70,
                'reason' => 'Mức lương thỏa thuận',
                'details' => [
                    'expected_salary' => $expectedSalary,
                    'salary_type' => 'Thỏa thuận'
                ]
            ];
        }

        $jobMinSalary = (float) $job->salary_min;
        $jobMaxSalary = (float) $job->salary_max;

        if (!$jobMinSalary || !$jobMaxSalary) {
            return [
                'score' => 70,
                'reason' => 'Công việc chưa công bố mức lương',
                'details' => [
                    'expected_salary' => $expectedSalary,
                    'job_salary' => 'Chưa công bố'
                ]
            ];
        }

        $score = 0;
        $reason = '';

        if ($expectedSalary >= $jobMinSalary && $expectedSalary <= $jobMaxSalary) {
            $score = 100;
            $reason = "✓ Mức lương mong muốn " . number_format($expectedSalary) . " VNĐ nằm trong khoảng " .
                number_format($jobMinSalary) . " - " . number_format($jobMaxSalary) . " VNĐ";
        } elseif ($expectedSalary < $jobMinSalary) {
            $diff = $jobMinSalary - $expectedSalary;
            $percent = ($diff / $jobMinSalary) * 100;
            $score = max(50, 100 - $percent);
            $reason = "Mức lương mong muốn thấp hơn " . number_format($diff) . " VNĐ so với mức tối thiểu";
        } else {
            $diff = $expectedSalary - $jobMaxSalary;
            $percent = ($diff / $jobMaxSalary) * 100;
            $score = max(30, 100 - ($percent * 2));
            $reason = "⚠ Mức lương mong muốn cao hơn " . number_format($diff) . " VNĐ so với mức tối đa";
        }

        return [
            'score' => round($score, 2),
            'reason' => $reason,
            'details' => [
                'expected_salary' => $expectedSalary,
                'job_min' => $jobMinSalary,
                'job_max' => $jobMaxSalary,
                'formatted_expected' => number_format($expectedSalary) . ' VNĐ',
                'formatted_range' => number_format($jobMinSalary) . ' - ' . number_format($jobMaxSalary) . ' VNĐ'
            ]
        ];
    }

    /**
     * 5. Tính độ phù hợp về NGOẠI NGỮ
     */
    private function calculateLanguageMatch(Applicant $applicant, JobPost $job): array
    {
        $languages = $applicant->ngoaiNgu()->pluck('ten_ngoai_ngu')->toArray();

        if (empty($languages)) {
            return [
                'score' => 50,
                'reason' => 'Bạn chưa cập nhật ngoại ngữ',
                'details' => [
                    'languages' => [],
                    'proficiency_levels' => []
                ]
            ];
        }

        // Lấy danh sách ngoại ngữ với trình độ
        $languagesWithLevel = $applicant->ngoaiNgu()->get();

        // Định nghĩa các ngôn ngữ quan trọng trong IT
        $priorityLanguages = ['Tiếng Anh', 'English'];

        // Kiểm tra các ngôn ngữ
        $hasHighLevel = false;
        $hasIntermediate = false;
        $totalLanguages = count($languages);

        foreach ($languagesWithLevel as $lang) {
            $langName = strtolower(trim($lang->ten_ngoai_ngu));
            $proficiency = strtolower(trim($lang->trin_do ?? ''));

            // Kiểm tra ngôn ngữ ưu tiên và trình độ
            if (in_array($lang->ten_ngoai_ngu, $priorityLanguages)) {
                if (in_array($proficiency, ['cao cap', 'cao cấp', 'advanced'])) {
                    $hasHighLevel = true;
                } elseif (in_array($proficiency, ['trung cap', 'trung cấp', 'intermediate'])) {
                    $hasIntermediate = true;
                }
            }
        }

        // Tính điểm dựa trên trình độ và số lượng ngôn ngữ
        $score = 0;
        $reason = '';

        if ($hasHighLevel) {
            $score = 100;
            $reason = "✓ Bạn có trình độ cao cấp - lợi thế lớn trong ngành IT";
        } elseif ($hasIntermediate) {
            $score = 80;
            $reason = "✓ Bạn có trình độ trung cấp - khá tốt cho công việc IT";
        } elseif ($totalLanguages > 0) {
            $score = 60;
            $reason = "Bạn biết " . implode(', ', $languages) . " - cần nâng cao trình độ";
        } else {
            $score = 50;
            $reason = "Chưa có thông tin ngoại ngữ";
        }

        return [
            'score' => round($score, 2),
            'reason' => $reason,
            'details' => [
                'languages' => $languages,
                'total_languages' => $totalLanguages,
                'has_high_level' => $hasHighLevel,
                'has_intermediate' => $hasIntermediate
            ]
        ];
    }

    /**
     * Chuẩn hóa tên địa điểm - FIXED: Chuẩn hóa chính xác hơn
     */
    private function normalizeLocation(string $location): string
    {
        $normalized = strtolower(trim($location));

        // Loại bỏ tiền tố
        $normalized = preg_replace('/^(thành phố|tỉnh|tp\.?|thanh pho|tinh)\s*/ui', '', $normalized);

        // Loại bỏ dấu
        $normalized = $this->removeDiacritics($normalized);

        // Map các tên thành phố phổ biến - CHÍNH XÁC
        $cityMap = [
            // TP.HCM
            'ho chi minh' => 'hcm',
            'hcm' => 'hcm',
            'sai gon' => 'hcm',
            'saigon' => 'hcm',

            // Hà Nội
            'ha noi' => 'hanoi',
            'hanoi' => 'hanoi',

            // Đà Nẵng
            'da nang' => 'danang',
            'danang' => 'danang',

            // Cần Thơ
            'can tho' => 'cantho',
            'cantho' => 'cantho',

            // Hải Phòng
            'hai phong' => 'haiphong',
            'haiphong' => 'haiphong',

            // Biên Hòa
            'bien hoa' => 'bienhoa',
            'bienhoa' => 'bienhoa',

            // Vũng Tàu
            'vung tau' => 'vungtau',
            'vungtau' => 'vungtau',
            'ba ria vung tau' => 'vungtau',
        ];

        // Tìm match chính xác
        foreach ($cityMap as $key => $value) {
            if ($normalized === $key || strpos($normalized, $key) === 0) {
                return $value;
            }
        }

        return $normalized;
    }

    /**
     * Loại bỏ dấu tiếng Việt
     */
    private function removeDiacritics(string $str): string
    {
        $str = preg_replace('/[àáạảãâầấậẩẫăằắặẳẵ]/u', 'a', $str);
        $str = preg_replace('/[èéẹẻẽêềếệểễ]/u', 'e', $str);
        $str = preg_replace('/[ìíịỉĩ]/u', 'i', $str);
        $str = preg_replace('/[òóọỏõôồốộổỗơờớợởỡ]/u', 'o', $str);
        $str = preg_replace('/[ùúụủũưừứựửữ]/u', 'u', $str);
        $str = preg_replace('/[ỳýỵỷỹ]/u', 'y', $str);
        $str = preg_replace('/đ/u', 'd', $str);
        return $str;
    }

    /**
     * Tạo hoặc cập nhật recommendations cho ứng viên
     */
    public function generateRecommendationsForApplicant(Applicant $applicant, $limit = 20): int
    {
        $activeJobs = JobPost::where('deadline', '>=', now())
            ->with(['hashtags', 'company'])
            ->get();

        $count = 0;

        foreach ($activeJobs as $job) {
            try {
                $matchData = $this->calculateMatchScore($applicant, $job);
                $score = $matchData['score'];

                // CHỈ lưu jobs có điểm >= 40
                if ($score >= 40) {
                    JobRecommendation::updateOrCreate(
                        [
                            'applicant_id' => $applicant->id_uv,
                            'job_id' => $job->job_id
                        ],
                        [
                            'score' => $score,
                            'match_details' => json_encode($matchData['breakdown'])
                        ]
                    );
                    $count++;
                }
            } catch (\Exception $e) {
                Log::error('Error generating recommendation', [
                    'applicant_id' => $applicant->id_uv,
                    'job_id' => $job->job_id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $count;
    }

    /**
     * Lấy danh sách gợi ý cho ứng viên
     */
    public function getRecommendationsForApplicant(Applicant $applicant, $limit = 10)
    {
        return JobRecommendation::where('applicant_id', $applicant->id_uv)
            ->with(['job.company', 'job.hashtags'])
            ->orderByDesc('score')
            ->limit($limit)
            ->get();
    }
}
