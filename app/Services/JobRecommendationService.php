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
    const WEIGHT_SKILLS = 0.30;      // Giảm từ 0.35
    const WEIGHT_POSITION = 0.15;    // MỚI - So sánh vị trí
    const WEIGHT_EXPERIENCE = 0.20;
    const WEIGHT_LOCATION = 0.15;
    const WEIGHT_SALARY = 0.10;      // Giảm từ 0.15
    const WEIGHT_LANGUAGE = 0.10;    // Giảm từ 0.15

    /**
     * Tính điểm phù hợp giữa ứng viên và job
     */
    public function calculateMatchScore(Applicant $applicant, JobPost $job): array
    {
        $scores = [
            'skills' => $this->calculateSkillsMatch($applicant, $job),
            'position' => $this->calculatePositionMatch($applicant, $job), // MỚI
            'experience' => $this->calculateExperienceMatch($applicant, $job),
            'location' => $this->calculateLocationMatch($applicant, $job),
            'salary' => $this->calculateSalaryMatch($applicant, $job),
            'language' => $this->calculateLanguageMatch($applicant, $job),
        ];

        // Tính tổng điểm có trọng số
        $totalScore =
            ($scores['skills']['score'] * self::WEIGHT_SKILLS) +
            ($scores['position']['score'] * self::WEIGHT_POSITION) +
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
     * So sánh Vị trí ứng tuyển
     */

    private function calculatePositionMatch(Applicant $applicant, JobPost $job): array
    {
        $applicantPosition = strtolower(trim($applicant->vitriungtuyen ?? ''));
        $jobPosition = strtolower(trim($job->level ?? ''));

        // ========== BƯỚC 1: REMOVE DIACRITICS TRƯỚC ==========
        $normalizedApplicant = $this->removeDiacritics($applicantPosition);
        $normalizedJob = $this->removeDiacritics($jobPosition);

        Log::info('🧪 Position comparison START', [
            'original_applicant' => $applicantPosition,
            'original_job' => $jobPosition,
            'normalized_applicant' => $normalizedApplicant,
            'normalized_job' => $normalizedJob,
        ]);

        // ========== BƯỚC 2: CHECK EMPTY ==========
        if (empty($applicantPosition)) {
            Log::warning('⚠️ Applicant position is EMPTY');
            return [
                'score' => 70,
                'reason' => 'Chưa cập nhật vị trí ứng tuyển',
                'details' => [
                    'applicant_position' => 'Chưa cập nhật',
                    'job_position' => $job->level ?? 'Chưa rõ'
                ]
            ];
        }

        if (empty($jobPosition)) {
            Log::warning('⚠️ Job position is EMPTY');
            return [
                'score' => 80,
                'reason' => 'Công việc không giới hạn vị trí',
                'details' => [
                    'applicant_position' => $applicant->vitriungtuyen,
                    'job_position' => 'Mọi cấp bậc'
                ]
            ];
        }

        // ========== BƯỚC 3: ĐỊNH NGHĨA VỊ TRÍ - TIẾNG VIỆT + TIẾNG ANH ==========
        $positionLevels = [
            // ===== TIẾNG VIỆT =====
            'thuc tap sinh' => 0,
            'cong tac vien' => 1,
            'nhan vien thu viec' => 2,
            'nhan vien part-time' => 2,
            'freelancer' => 2,
            'nhan vien chinh thuc' => 3,
            'nhan vien hop dong' => 3,
            'nhan vien du an' => 3,
            'truong nhom' => 4,
            'quan ly' => 5,
            'giam doc bo phan' => 6,
            'giam doc' => 7,
            'tong giam doc' => 8,

            // ===== TIẾNG ANH =====
            'intern' => 0,
            'internship' => 0,
            'contract' => 1,
            'contractor' => 1,
            'freelance' => 2,
            'part-time' => 2,
            'parttime' => 2,
            'junior' => 3,
            'junior developer' => 3,
            'junior engineer' => 3,
            'staff' => 3,
            'employee' => 3,
            'mid-level' => 4,
            'midlevel' => 4,
            'mid' => 4,
            'team lead' => 4,
            'team leader' => 4,
            'lead' => 4,
            'leader' => 4,
            'senior' => 5,
            'senior developer' => 5,
            'senior engineer' => 5,
            'architect' => 5,
            'tech lead' => 5,
            'technical lead' => 5,
            'manager' => 6,
            'project manager' => 6,
            'product manager' => 6,
            'director' => 7,
            'department director' => 7,
            'chief' => 7,
            'cto' => 8,
            'ceo' => 8,
            'vp' => 8,
            'vice president' => 8,
        ];

        // ========== BƯỚC 4: LOOKUP VỊ TRÍ ==========
        $applicantLevel = $positionLevels[$normalizedApplicant] ?? -1;
        $jobLevel = $positionLevels[$normalizedJob] ?? -1;

        Log::info('Position levels lookup:', [
            'applicant_level' => $applicantLevel,
            'job_level' => $jobLevel,
            'applicant_found' => isset($positionLevels[$normalizedApplicant]),
            'job_found' => isset($positionLevels[$normalizedJob]),
            'available_keys' => array_slice(array_keys($positionLevels), 0, 10) // Hiển thị 10 key đầu
        ]);

        // ========== BƯỚC 5: NẾU CÓ EXACT STRING MATCH ==========
        if ($normalizedApplicant === $normalizedJob) {
            Log::info('✓ Exact string match found');
            return [
                'score' => 100,
                'reason' => "✓ Vị trí khớp: {$job->level}",
                'details' => [
                    'applicant_position' => $applicant->vitriungtuyen,
                    'job_position' => $job->level,
                    'match_type' => 'exact_string'
                ]
            ];
        }

        // ========== BƯỚC 6: NẾU CÓ KEYWORD MATCH ==========
        if ($this->hasCommonKeyword($normalizedApplicant, $normalizedJob)) {
            Log::info('✓ Common keyword found');
            return [
                'score' => 90,
                'reason' => "✓ Vị trí tương tự: {$applicant->vitriungtuyen} ↔ {$job->level}",
                'details' => [
                    'applicant_position' => $applicant->vitriungtuyen,
                    'job_position' => $job->level,
                    'match_type' => 'keyword_match'
                ]
            ];
        }

        // ========== BƯỚC 7: NẾU CÓ LEVEL MAPPING ==========
        if ($applicantLevel >= 0 && $jobLevel >= 0) {
            Log::info('✓ Level mapping found');

            $diff = abs($applicantLevel - $jobLevel);
            $score = 0;
            $reason = '';

            if ($applicantLevel === $jobLevel) {
                $score = 100;
                $reason = "✓ Vị trí phù hợp: {$job->level}";
            } elseif ($diff === 1) {
                $score = 95;
                $reason = $applicantLevel > $jobLevel
                    ? "Bạn có kinh nghiệm cao hơn 1 bậc"
                    : "Có thể phát triển lên vị trí này";
            } elseif ($diff === 2) {
                $score = 85;
                $reason = $applicantLevel > $jobLevel
                    ? "Bạn có kinh nghiệm cao hơn 2 bậc"
                    : "Cần thêm kinh nghiệm";
            } else {
                $score = 70;
                $reason = "Chênh lệch {$diff} bậc";
            }

            Log::info('✓ Position match result:', [
                'score' => $score,
                'reason' => $reason,
                'diff' => $diff,
            ]);

            return [
                'score' => round($score, 2),
                'reason' => $reason,
                'details' => [
                    'applicant_position' => $applicant->vitriungtuyen,
                    'job_position' => $job->level,
                    'applicant_level' => $applicantLevel,
                    'job_level' => $jobLevel,
                    'match_type' => 'level_mapping'
                ]
            ];
        }

        // ========== BƯỚC 8: NẾU KHÔNG MATCH ĐƯỢC ==========
        Log::warning('⚠️ Cannot match position', [
            'normalized_applicant' => $normalizedApplicant,
            'normalized_job' => $normalizedJob,
        ]);

        return [
            'score' => 75,
            'reason' => 'Vị trí không thể so sánh - xem xét Skills và Kinh nghiệm',
            'details' => [
                'applicant_position' => $applicant->vitriungtuyen,
                'job_position' => $job->level,
                'normalized_applicant' => $normalizedApplicant,
                'normalized_job' => $normalizedJob,
                'match_type' => 'no_match_fallback'
            ]
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
    /**
     * Kiểm tra xem hai vị trí có từ khóa chung không
     */
    private function hasCommonKeyword(string $applicantPosition, string $jobPosition): bool
    {
        $keywords = [
            'developer' => ['dev', 'developer', 'programmer', 'coder'],
            'engineer' => ['engineer', 'kỹ sư', 'ky su'],
            'designer' => ['designer', 'thiết kế', 'thiet ke'],
            'manager' => ['manager', 'quản lý', 'quan ly'],
            'leader' => ['lead', 'leader', 'trưởng', 'truong'],
            'senior' => ['senior', 'cấp cao', 'cap cao'],
            'junior' => ['junior', 'sinh viên', 'thực tập sinh'],
        ];

        foreach ($keywords as $keywordGroup) {
            $applicantHasKeyword = false;
            $jobHasKeyword = false;

            foreach ($keywordGroup as $keyword) {
                if (strpos($applicantPosition, $keyword) !== false) {
                    $applicantHasKeyword = true;
                }
                if (strpos($jobPosition, $keyword) !== false) {
                    $jobHasKeyword = true;
                }
            }

            if ($applicantHasKeyword && $jobHasKeyword) {
                return true;
            }
        }

        return false;
    }

    /**
     * Loại bỏ dấu tiếng Việt - FIXED HOÀN CHỈNH
     */
    private function removeDiacritics(string $str): string
    {
        $str = mb_strtolower($str, 'UTF-8');

        // Bảng chuyển đổi HOÀN CHỈNH
        $replacements = [
            // Chữ a
            'à' => 'a',
            'á' => 'a',
            'ạ' => 'a',
            'ả' => 'a',
            'ã' => 'a',
            'â' => 'a',
            'ầ' => 'a',
            'ấ' => 'a',
            'ậ' => 'a',
            'ẩ' => 'a',
            'ẫ' => 'a',
            'ă' => 'a',
            'ằ' => 'a',
            'ắ' => 'a',
            'ặ' => 'a',
            'ẳ' => 'a',
            'ẵ' => 'a',

            // Chữ e
            'è' => 'e',
            'é' => 'e',
            'ẹ' => 'e',
            'ẻ' => 'e',
            'ẽ' => 'e',
            'ê' => 'e',
            'ề' => 'e',
            'ế' => 'e',
            'ệ' => 'e',
            'ể' => 'e',
            'ễ' => 'e',

            // Chữ i
            'ì' => 'i',
            'í' => 'i',
            'ị' => 'i',
            'ỉ' => 'i',
            'ĩ' => 'i',

            // Chữ o
            'ò' => 'o',
            'ó' => 'o',
            'ọ' => 'o',
            'ỏ' => 'o',
            'õ' => 'o',
            'ô' => 'o',
            'ồ' => 'o',
            'ố' => 'o',
            'ộ' => 'o',
            'ổ' => 'o',
            'ỗ' => 'o',
            'ơ' => 'o',
            'ờ' => 'o',
            'ớ' => 'o',
            'ợ' => 'o',
            'ở' => 'o',
            'ỡ' => 'o',

            // Chữ u - ✅ FIXED HOÀN CHỈNH
            'ù' => 'u',
            'ú' => 'u',
            'ụ' => 'u',
            'ủ' => 'u',
            'ũ' => 'u',
            'ư' => 'u',
            'ừ' => 'u',
            'ứ' => 'u',
            'ự' => 'u',
            'ử' => 'u',
            'ữ' => 'u',

            // Chữ y
            'ỳ' => 'y',
            'ý' => 'y',
            'ỵ' => 'y',
            'ỷ' => 'y',
            'ỹ' => 'y',

            // Chữ d
            'đ' => 'd',
        ];

        return strtr($str, $replacements);
    }
    /**
     * Tạo hoặc cập nhật recommendations cho ứng viên
     */
    /**
     * Tạo hoặc cập nhật recommendations cho ứng viên
     */
    public function generateRecommendationsForApplicant(Applicant $applicant, $limit = 20): int
    {
        Log::info('🔄 Generating recommendations', [
            'applicant_id' => $applicant->id_uv,
            'vitriungtuyen' => $applicant->vitriungtuyen,
            'has_vitriungtuyen' => !empty($applicant->vitriungtuyen)
        ]);

        // ✅ XÓA TẤT CẢ RECOMMENDATIONS CŨ TRƯỚC
        JobRecommendation::where('applicant_id', $applicant->id_uv)->delete();

        Log::info('🗑️ Deleted old recommendations for applicant', [
            'applicant_id' => $applicant->id_uv
        ]);

        $activeJobs = JobPost::where('deadline', '>=', now())
            ->with(['hashtags', 'company'])
            ->get();

        $count = 0;

        foreach ($activeJobs as $job) {
            try {
                Log::info('📊 Calculating match', [
                    'job_id' => $job->job_id,
                    'job_title' => $job->title,
                    'applicant_vitriungtuyen' => $applicant->vitriungtuyen,
                    'job_level' => $job->level
                ]);

                $matchData = $this->calculateMatchScore($applicant, $job);
                $score = $matchData['score'];

                Log::info('✅ Match calculated', [
                    'job_id' => $job->job_id,
                    'score' => $score,
                    'position_score' => $matchData['breakdown']['position']['score'] ?? 'N/A',
                    'position_reason' => $matchData['breakdown']['position']['reason'] ?? 'N/A'
                ]);

                // CHỈ lưu jobs có điểm >= 40
                if ($score >= 40) {
                    // ✅ THAY ĐỔI: Dùng create() thay vì updateOrCreate()
                    JobRecommendation::create([
                        'applicant_id' => $applicant->id_uv,
                        'job_id' => $job->job_id,
                        'score' => $score,
                        'match_details' => json_encode($matchData['breakdown']),
                        'is_viewed' => false,
                        'is_applied' => false
                    ]);
                    $count++;
                }
            } catch (\Exception $e) {
                Log::error('❌ Error generating recommendation', [
                    'applicant_id' => $applicant->id_uv,
                    'job_id' => $job->job_id,
                    'error' => $e->getMessage(),
                    'line' => $e->getLine()
                ]);
            }
        }

        Log::info('🎉 Generation complete', [
            'applicant_id' => $applicant->id_uv,
            'total_recommendations' => $count
        ]);

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
