<?php

namespace App\Services;

use App\Models\Applicant;
use App\Models\JobPost;
use App\Models\JobRecommendation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class JobRecommendationService
{
    // ✅ TRỌNG SỐ MỚI - ƯU TIÊN LOCATION, KỸ NĂNG, VỊ TRÍ ỨNG TUYỂN
    const WEIGHT_LOCATION = 0.35;       // ƯU TIÊN NHẤT - Địa điểm
    const WEIGHT_SKILLS = 0.30;         // Quan trọng thứ 2 - Kỹ năng
    const WEIGHT_POSITION = 0.20;       // Quan trọng thứ 3 - Vị trí ứng tuyển
    const WEIGHT_EXPERIENCE = 0.08;     // Giảm xuống
    const WEIGHT_SALARY = 0.04;         // Giảm xuống
    const WEIGHT_LANGUAGE = 0.03;       // Ít quan trọng nhất

    /**
     * Tính điểm phù hợp giữa ứng viên và job
     */
    public function calculateMatchScore(Applicant $applicant, JobPost $job): array
    {
        $scores = [
            'location' => $this->calculateLocationMatch($applicant, $job),
            'skills' => $this->calculateSkillsMatch($applicant, $job),
            'position' => $this->calculatePositionMatch($applicant, $job),
            'experience' => $this->calculateExperienceMatch($applicant, $job),
            'salary' => $this->calculateSalaryMatch($applicant, $job),
            'language' => $this->calculateLanguageMatch($applicant, $job),
        ];

        // Tính tổng điểm có trọng số - ƯU TIÊN LOCATION
        $totalScore =
            ($scores['location']['score'] * self::WEIGHT_LOCATION) +
            ($scores['skills']['score'] * self::WEIGHT_SKILLS) +
            ($scores['position']['score'] * self::WEIGHT_POSITION) +
            ($scores['experience']['score'] * self::WEIGHT_EXPERIENCE) +
            ($scores['salary']['score'] * self::WEIGHT_SALARY) +
            ($scores['language']['score'] * self::WEIGHT_LANGUAGE);

        return [
            'score' => round($totalScore, 2),
            'breakdown' => $scores
        ];
    }

    /**
     * ✅ LOCATION MATCH - CẢI TIẾN VỚI HỆ THỐNG KHOẢNG CÁCH
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
        if (
            stripos($job->working_type, 'remote') !== false ||
            stripos($job->working_type, 'work from home') !== false
        ) {
            return [
                'score' => 100,
                'reason' => '✓ Làm việc remote - không giới hạn địa điểm',
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

        // ✅ TÍNH ĐIỂM DỰA TRÊN KHOẢNG CÁCH
        $distance = $this->calculateProvinceDistance($normalizedApplicant, $normalizedJob);

        $score = 0;
        $reason = '';

        switch ($distance) {
            case 0:
                // Cùng tỉnh/thành phố
                $score = 100;
                $reason = "✓ Cùng tỉnh/thành: {$job->province}";
                break;
            case 1:
                // Tỉnh lân cận (cùng vùng)
                $score = 85;
                $reason = "Tỉnh lân cận: {$applicant->diachi_uv} → {$job->province} (Cùng vùng)";
                break;
            case 2:
                // Cùng miền nhưng khác vùng
                $score = 60;
                $reason = "Cùng miền: {$applicant->diachi_uv} → {$job->province}";
                break;
            default:
                // Khác miền
                $score = 30;
                $reason = "Khác miền: Bạn ở {$applicant->diachi_uv}, công việc tại {$job->province}";
                break;
        }

        return [
            'score' => round($score, 2),
            'reason' => $reason,
            'details' => [
                'applicant_location' => $applicant->diachi_uv,
                'job_location' => $job->province,
                'normalized_applicant' => $normalizedApplicant,
                'normalized_job' => $normalizedJob,
                'distance_level' => $distance,
                'is_same_province' => $distance === 0
            ]
        ];
    }

    /**
     * ✅ HỆ THỐNG TÍNH KHOẢNG CÁCH GIỮA CÁC TỈNH THÀNH VIỆT NAM
     * Distance Level:
     * 0 = Cùng tỉnh
     * 1 = Tỉnh lân cận (cùng vùng, gần nhau)
     * 2 = Cùng miền
     * 3 = Khác miền
     */
    private function calculateProvinceDistance(string $province1, string $province2): int
    {
        if ($province1 === $province2) {
            return 0;
        }

        // ✅ ĐỊNH NGHĨA CẤU TRÚC ĐỊA LÝ VIỆT NAM
        $regions = [
            // MIỀN BẮC
            'north' => [
                // Đồng bằng sông Hồng
                'red_river_delta' => [
                    'hanoi',
                    'haiphong',
                    'hanam',
                    'hungyen',
                    'thaibình',
                    'namdinh',
                    'ninhbinh',
                    'bacninh',
                    'haduong',
                    'vinhphuc',
                    'bacgiang',
                    'phuthy',
                    'quangninh'
                ],

                // Tây Bắc
                'northwest' => ['dienbien', 'laichau', 'sonla', 'hoabinh', 'laocai', 'yenbai'],

                // Đông Bắc
                'northeast' => ['hagiang', 'caobang', 'backan', 'tuyenquang', 'langson', 'thainguyen'],
            ],

            // MIỀN TRUNG
            'central' => [
                // Bắc Trung Bộ
                'north_central' => ['thanhhoa', 'nghean', 'hatinh', 'quangbinh', 'quangtri', 'thuathienhue'],

                // Duyên hải Nam Trung Bộ
                'south_central_coast' => ['danang', 'quangnam', 'quangngai', 'binhdinh', 'phuyen', 'khanhhoa', 'ninhthuan', 'binhthuan'],

                // Tây Nguyên
                'highland' => ['kontum', 'gialai', 'daklak', 'daknong', 'lamdong'],
            ],

            // MIỀN NAM
            'south' => [
                // Đông Nam Bộ
                'southeast' => [
                    'hcm',
                    'bienhoa',
                    'vungtau',
                    'binhduong',
                    'dongnai',
                    'tayninh',
                    'binhphuoc',
                    'longan'
                ],

                // Đồng bằng sông Cửu Long
                'mekong_delta' => [
                    'cantho',
                    'longan',
                    'tiengiang',
                    'bentre',
                    'travinh',
                    'vinhlong',
                    'angiang',
                    'dongthap',
                    'kiengiang',
                    'camau',
                    'haugiang',
                    'soctrang',
                    'baclieu'
                ],
            ],
        ];

        // ✅ TÌM VÙNG CỦA TỪNG TỈNH
        $region1 = $this->findRegion($province1, $regions);
        $region2 = $this->findRegion($province2, $regions);

        if (!$region1 || !$region2) {
            return 3; // Không xác định được → coi như khác miền
        }

        // Cùng vùng nhỏ (lân cận)
        if (
            $region1['sub_region'] === $region2['sub_region'] &&
            $region1['sub_region'] !== null
        ) {
            return 1;
        }

        // Cùng miền
        if ($region1['main_region'] === $region2['main_region']) {
            return 2;
        }

        // Khác miền
        return 3;
    }

    /**
     * Tìm vùng của một tỉnh
     */
    private function findRegion(string $province, array $regions): ?array
    {
        foreach ($regions as $mainRegion => $subRegions) {
            foreach ($subRegions as $subRegion => $provinces) {
                if (in_array($province, $provinces)) {
                    return [
                        'main_region' => $mainRegion,
                        'sub_region' => $subRegion
                    ];
                }
            }
        }
        return null;
    }

    /**
     * Chuẩn hóa tên địa điểm - CẢI TIẾN
     */
    private function normalizeLocation(string $location): string
    {
        $normalized = strtolower(trim($location));

        // Loại bỏ tiền tố
        $normalized = preg_replace('/^(thành phố|tỉnh|tp\.?|thanh pho|tinh)\s+/ui', '', $normalized);

        // Loại bỏ dấu
        $normalized = $this->removeDiacritics($normalized);

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
            'dong nai' => 'dongnai',
            'dongnai' => 'dongnai',

            // Vũng Tàu
            'vung tau' => 'vungtau',
            'vungtau' => 'vungtau',
            'ba ria vung tau' => 'vungtau',
            'ba ria' => 'vungtau',

            // Các tỉnh khác (Bắc)
            'hai duong' => 'haduong',
            'bac ninh' => 'bacninh',
            'vinh phuc' => 'vinhphuc',
            'hung yen' => 'hungyen',
            'ha nam' => 'hanam',
            'nam dinh' => 'namdinh',
            'thai binh' => 'thaibình',
            'ninh binh' => 'ninhbinh',
            'thanh hoa' => 'thanhhoa',
            'nghe an' => 'nghean',
            'ha tinh' => 'hatinh',
            'quang binh' => 'quangbinh',

            // Các tỉnh khác (Trung)
            'quang tri' => 'quangtri',
            'thua thien hue' => 'thuathienhue',
            'hue' => 'thuathienhue',
            'quang nam' => 'quangnam',
            'quang ngai' => 'quangngai',
            'binh dinh' => 'binhdinh',
            'phu yen' => 'phuyen',
            'khanh hoa' => 'khanhhoa',
            'nha trang' => 'khanhhoa',
            'ninh thuan' => 'ninhthuan',
            'binh thuan' => 'binhthuan',

            // Các tỉnh khác (Nam)
            'binh duong' => 'binhduong',
            'binh phuoc' => 'binhphuoc',
            'tay ninh' => 'tayninh',
            'long an' => 'longan',
            'tien giang' => 'tiengiang',
            'ben tre' => 'bentre',
            'tra vinh' => 'travinh',
            'vinh long' => 'vinhlong',
            'dong thap' => 'dongthap',
            'an giang' => 'angiang',
            'kien giang' => 'kiengiang',
            'hau giang' => 'haugiang',
            'soc trang' => 'soctrang',
            'bac lieu' => 'baclieu',
            'ca mau' => 'camau',

            // Tây Nguyên
            'dak lak' => 'daklak',
            'dak nong' => 'daknong',
            'lam dong' => 'lamdong',
            'gia lai' => 'gialai',
            'kon tum' => 'kontum',

            // Khác
            'quang ninh' => 'quangninh',
            'ha long' => 'quangninh',
            'bac giang' => 'bacgiang',
            'bac kan' => 'backan',
            'cao bang' => 'caobang',
            'ha giang' => 'hagiang',
            'lang son' => 'langson',
            'lao cai' => 'laocai',
            'son la' => 'sonla',
            'yen bai' => 'yenbai',
            'dien bien' => 'dienbien',
            'lai chau' => 'laichau',
            'hoa binh' => 'hoabinh',
            'thai nguyen' => 'thainguyen',
            'tuyen quang' => 'tuyenquang',
            'phu tho' => 'phuthy',
        ];

        foreach ($cityMap as $key => $value) {
            if ($normalized === $key || strpos($normalized, $key) === 0) {
                return $value;
            }
        }

        return $normalized;
    }

    /**
     * So sánh Vị trí ứng tuyển
     */
    private function calculatePositionMatch(Applicant $applicant, JobPost $job): array
    {
        $applicantPosition = strtolower(trim($applicant->vitriungtuyen ?? ''));
        $jobPosition = strtolower(trim($job->level ?? ''));

        $normalizedApplicant = $this->removeDiacritics($applicantPosition);
        $normalizedJob = $this->removeDiacritics($jobPosition);

        Log::info('🧪 Position comparison START', [
            'original_applicant' => $applicantPosition,
            'original_job' => $jobPosition,
            'normalized_applicant' => $normalizedApplicant,
            'normalized_job' => $normalizedJob,
        ]);

        // CHECK EMPTY
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

        $positionLevels = [
            // TIẾNG VIỆT
            'thuc tap sinh' => 0,
            'cong tac vien' => 1,
            'nhan vien thu viec' => 2,
            'nhan vien part-time' => 2,
            'freelancer' => 2,
            'nhan vien chinh thuc' => 3,
            'nhan vien hop dong' => 3,
            'nhan vien du an' => 3,
            'lap trinh vien' => 3,
            'truong nhom' => 4,
            'quan ly' => 5,
            'giam doc bo phan' => 6,
            'giam doc' => 7,
            'tong giam doc' => 8,

            // TIẾNG ANH
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

        $applicantLevel = $positionLevels[$normalizedApplicant] ?? -1;
        $jobLevel = $positionLevels[$normalizedJob] ?? -1;

        // EXACT MATCH
        if ($normalizedApplicant === $normalizedJob) {
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

        // KEYWORD MATCH
        if ($this->hasCommonKeyword($normalizedApplicant, $normalizedJob)) {
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

        // LEVEL MAPPING
        if ($applicantLevel >= 0 && $jobLevel >= 0) {
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

        // FALLBACK
        return [
            'score' => 75,
            'reason' => 'Vị trí không thể so sánh - xem xét Skills và Kinh nghiệm',
            'details' => [
                'applicant_position' => $applicant->vitriungtuyen,
                'job_position' => $job->level,
                'match_type' => 'no_match_fallback'
            ]
        ];
    }

    /**
     * Tính độ phù hợp về KỸ NĂNG
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

        $extraSkills = count($applicantSkills) - $totalRequired;
        if ($extraSkills > 0) {
            $bonus = min(10, $extraSkills * 2);
            $score = min(100, $score + $bonus);
        }

        $reason = '';
        if ($matchCount == $totalRequired) {
            $reason = "✓ Bạn có đầy đủ {$totalRequired} kỹ năng yêu cầu";
        } elseif ($matchCount > 0) {
            $reason = "Bạn có {$matchCount}/{$totalRequired} kỹ năng yêu cầu";
            if (!empty($missingSkills)) {
                $reason .= ". Còn thiếu: " . implode(', ', array_slice($missingSkills, 0, 3));
            }
        } else {
            $reason = "⚠ Bạn chưa có kỹ năng yêu cầu. Cần: " . implode(', ', array_slice($jobSkills, 0, 3));
        }

        return [
            'score' => round($score, 2),
            'reason' => $reason,
            'details' => [
                'applicant_skills' => $applicantSkills,
                'required_skills' => $jobSkills,
                'matched_skills' => array_values($matchedSkills),
                'missing_skills' => array_values($missingSkills),
                'match_count' => $matchCount,
                'total_required' => $totalRequired
            ]
        ];
    }

    /**
     * Tính độ phù hợp về KINH NGHIỆM
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
                $reason = "✓ Bạn có {$applicantYears} năm kinh nghiệm, phù hợp với yêu cầu {$requiredExp['label']}";
            } else {
                $score = max(80, 100 - ($excess * 5));
                $reason = "Bạn có {$applicantYears} năm kinh nghiệm, nhiều hơn yêu cầu {$requiredExp['label']}";
            }
        } else {
            $shortfall = $requiredYears - $applicantYears;
            $score = max(0, 100 - ($shortfall * 25));
            $reason = "⚠ Bạn có {$applicantYears} năm kinh nghiệm, còn thiếu " . round($shortfall, 1) . " năm";
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
     * Tính độ phù hợp về MỨC LƯƠNG
     */
    private function calculateSalaryMatch(Applicant $applicant, JobPost $job): array
    {
        $expectedSalary = (float) ($applicant->mucluong_mongmuon ?? 0);

        if (!$expectedSalary) {
            return [
                'score' => 70,
                'reason' => 'Bạn chưa cập nhật mức lương mong muốn',
                'details' => [
                    'expected_salary' => null,
                    'job_min' => $job->salary_min ?? 0,
                    'job_max' => $job->salary_max ?? 0
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

        $jobMinSalary = (float) ($job->salary_min ?? 0);
        $jobMaxSalary = (float) ($job->salary_max ?? 0);

        if (!$jobMinSalary || !$jobMaxSalary) {
            return [
                'score' => 70,
                'reason' => 'Công việc chưa công bố mức lương',
                'details' => [
                    'expected_salary' => $expectedSalary,
                    'salary_type' => 'Chưa công bố'
                ]
            ];
        }

        $score = 0;
        $reason = '';

        if ($expectedSalary >= $jobMinSalary && $expectedSalary <= $jobMaxSalary) {
            $score = 100;
            $reason = "✓ Mức lương mong muốn phù hợp";
        } elseif ($expectedSalary < $jobMinSalary) {
            $diff = $jobMinSalary - $expectedSalary;
            $percent = ($diff / $jobMinSalary) * 100;
            $score = max(50, 100 - $percent);
            $reason = "Mức lương mong muốn thấp hơn mức tối thiểu";
        } else {
            $diff = $expectedSalary - $jobMaxSalary;
            $percent = ($diff / $jobMaxSalary) * 100;
            $score = max(30, 100 - ($percent * 2));
            $reason = "⚠ Mức lương mong muốn cao hơn mức tối đa";
        }

        return [
            'score' => round($score, 2),
            'reason' => $reason,
            'details' => [
                'expected_salary' => $expectedSalary,
                'job_min' => $jobMinSalary,
                'job_max' => $jobMaxSalary
            ]
        ];
    }

    /**
     * Tính độ phù hợp về NGOẠI NGỮ
     */
    private function calculateLanguageMatch(Applicant $applicant, JobPost $job): array
    {
        $languages = $applicant->ngoaiNgu()->pluck('ten_ngoai_ngu')->toArray();

        if (empty($languages)) {
            return [
                'score' => 50,
                'reason' => 'Bạn chưa cập nhật ngoại ngữ',
                'details' => ['languages' => []]
            ];
        }

        $languagesWithLevel = $applicant->ngoaiNgu()->get();
        $priorityLanguages = ['Tiếng Anh', 'English'];

        $hasHighLevel = false;
        $hasIntermediate = false;
        $totalLanguages = count($languages);

        foreach ($languagesWithLevel as $lang) {
            $proficiency = strtolower(trim($lang->trinh_do ?? ''));

            if (in_array($lang->ten_ngoai_ngu, $priorityLanguages)) {
                if (in_array($proficiency, ['cao cap', 'cao cấp', 'advanced'])) {
                    $hasHighLevel = true;
                } elseif (in_array($proficiency, ['trung cap', 'trung cấp', 'intermediate'])) {
                    $hasIntermediate = true;
                }
            }
        }

        $score = 0;
        $reason = '';

        if ($hasHighLevel) {
            $score = 100;
            $reason = "✓ Bạn có trình độ cao cấp - lợi thế lớn";
        } elseif ($hasIntermediate) {
            $score = 80;
            $reason = "✓ Bạn có trình độ trung cấp - khá tốt";
        } elseif ($totalLanguages > 0) {
            $score = 60;
            $reason = "Bạn biết " . implode(', ', $languages) . " - cần nâng cao";
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
     * Kiểm tra từ khóa chung
     */
    private function hasCommonKeyword(string $applicantPosition, string $jobPosition): bool
    {
        $keywords = [
            'developer' => ['dev', 'developer', 'programmer', 'coder'],
            'engineer' => ['engineer', 'ky su'],
            'designer' => ['designer', 'thiet ke'],
            'manager' => ['manager', 'quan ly'],
            'leader' => ['lead', 'leader', 'truong'],
            'senior' => ['senior', 'cap cao'],
            'junior' => ['junior', 'sinh vien', 'thuc tap'],
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
     * Loại bỏ dấu tiếng Việt - HOÀN CHỈNH
     */
    private function removeDiacritics(string $str): string
    {
        $str = mb_strtolower($str, 'UTF-8');

        $replacements = [
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

            'ì' => 'i',
            'í' => 'i',
            'ị' => 'i',
            'ỉ' => 'i',
            'ĩ' => 'i',

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

            'ỳ' => 'y',
            'ý' => 'y',
            'ỵ' => 'y',
            'ỷ' => 'y',
            'ỹ' => 'y',
            'đ' => 'd',
        ];

        return strtr($str, $replacements);
    }

    /**
     * Tạo recommendations cho ứng viên
     */
    public function generateRecommendationsForApplicant(Applicant $applicant, $limit = 20): int
    {
        Log::info('🔄 Generating recommendations', [
            'applicant_id' => $applicant->id_uv,
            'vitriungtuyen' => $applicant->vitriungtuyen,
        ]);

        // XÓA TẤT CẢ CŨ
        JobRecommendation::where('applicant_id', $applicant->id_uv)->delete();

        $activeJobs = JobPost::where('deadline', '>=', now())
            ->with(['hashtags', 'company'])
            ->limit(100)
            ->get();

        $count = 0;

        foreach ($activeJobs as $job) {
            try {
                $matchData = $this->calculateMatchScore($applicant, $job);
                $score = $matchData['score'];

                if ($score >= 40) {
                    JobRecommendation::create([
                        'applicant_id' => $applicant->id_uv,
                        'job_id' => $job->job_id,
                        'score' => $score,
                        'match_details' => json_encode($matchData['breakdown']),
                        'is_viewed' => false,
                        'is_applied' => false
                    ]);
                    $count++;
                    if ($count >= $limit) break;
                }
            } catch (\Exception $e) {
                Log::error('❌ Lỗi tạo recommendation', [
                    'job_id' => $job->job_id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        Log::info('🎉 Tạo xong', ['total' => $count]);
        return $count;
    }

    /**
     * Lấy recommendations
     */
    public function getRecommendationsForApplicant(Applicant $applicant, $limit = 10)
    {
        return JobRecommendation::where('applicant_id', $applicant->id_uv)
            ->with(['job.company', 'job.hashtags'])
            ->orderByDesc('score')
            ->limit($limit)
            ->get();
    }
    /**
     * ✅ LẤY ỨNG VIÊN PHÙ HỢP CHO CÔNG TY (Chiều ngược lại)
     * Tìm ứng viên phù hợp nhất với các job đang tuyển của công ty
     */

    public function getRecommendedApplicantsForCompany($companyId, $limit = 12): array
    {
        try {
            Log::info('🔍 START: Recommend applicants for company', [
                'company_id' => $companyId,
                'limit' => $limit
            ]);

            // ✅ CACHE 30 phút
            $cacheKey = "recommended_applicants_v2_company_{$companyId}_limit_{$limit}";

            return Cache::remember($cacheKey, 1800, function () use ($companyId, $limit) {
                return $this->calculateRecommendedApplicantsV2($companyId, $limit);
            });
        } catch (\Exception $e) {
            Log::error('❌ Error in getRecommendedApplicantsForCompany', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return [];
        }
    }

    /**
     * ✅ TÍNH TOÁN THỰC TẾ - VERSION 2
     */
    private function calculateRecommendedApplicantsV2($companyId, $limit): array
    {
        // ========== BƯỚC 1: LẤY JOBS ĐANG ACTIVE ==========
        $activeJobs = JobPost::where('companies_id', $companyId)
            ->where('status', 'active')
            ->where('deadline', '>=', now())
            ->with(['hashtags'])
            ->get();

        Log::info('📋 Active jobs found', ['count' => $activeJobs->count()]);

        if ($activeJobs->isEmpty()) {
            Log::warning('⚠️ No active jobs for company');
            return [];
        }

        // ========== BƯỚC 2: LẤY ỨNG VIÊN PHÙ HỢP ==========
        $applicants = Applicant::whereNotNull('vitriungtuyen')
            ->whereNotNull('diachi_uv')
            ->whereHas('kynang')
            ->with(['kynang', 'hocvan', 'kinhnghiem', 'ngoaiNgu', 'user'])
            ->limit(500) // Tăng lên để có nhiều lựa chọn hơn
            ->get();

        Log::info('👥 Eligible applicants found', ['count' => $applicants->count()]);

        if ($applicants->isEmpty()) {
            Log::warning('⚠️ No eligible applicants found');
            return [];
        }

        // ========== BƯỚC 3: TÍNH ĐIỂM CHO TỪNG ỨNG VIÊN VỚI TẤT CẢ JOB ==========
        $recommendations = [];

        foreach ($applicants as $applicant) {
            $applicantJobMatches = []; // Lưu tất cả job phù hợp với ứng viên này
            $bestScore = 0;
            $bestJob = null;

            // Tính điểm với TỪNG job
            foreach ($activeJobs as $job) {
                $matchData = $this->calculateMatchScore($applicant, $job);
                $score = $matchData['score'];

                // ✅ CHỈ LƯU JOB CÓ ĐIỂM >= 60%
                if ($score >= 60) {
                    $applicantJobMatches[] = [
                        'job' => $job,
                        'score' => $score,
                        'match_details' => $matchData['breakdown']
                    ];

                    // Cập nhật best match
                    if ($score > $bestScore) {
                        $bestScore = $score;
                        $bestJob = $job;
                    }

                    // 💾 LƯU MATCHED JOB VÀO DATABASE
                    JobRecommendation::updateOrCreate(
                        [
                            'applicant_id' => $applicant->id_uv,  // ✅ Applicant PK: id_uv
                            'job_id' => $job->job_id,  // ✅ Job PK: job_id (không phải id)
                        ],
                        [
                            'score' => $score,
                            'match_details' => json_encode($matchData['breakdown']),
                            'is_viewed' => false,
                            'is_applied' => false
                        ]
                    );
                }
            }

            // ✅ CHỈ THÊM ỨNG VIÊN NẾU CÓ ÍT NHẤT 1 JOB PHÙ HỢP
            if (!empty($applicantJobMatches)) {
                // Sắp xếp job theo điểm giảm dần
                usort($applicantJobMatches, function ($a, $b) {
                    return $b['score'] <=> $a['score'];
                });

                $recommendations[] = [
                    'applicant' => $applicant,
                    'best_score' => $bestScore, // Điểm cao nhất
                    'best_job' => $bestJob, // Job phù hợp nhất
                    'matched_jobs' => $applicantJobMatches, // TẤT CẢ các job phù hợp
                    'total_matches' => count($applicantJobMatches)
                ];
            }
        }

        Log::info('✅ Calculations completed', [
            'total_recommendations' => count($recommendations)
        ]);

        // ========== BƯỚC 4: SẮP XẾP VÀ LẤY TOP ==========
        // Sắp xếp theo: 1) Số lượng job match, 2) Best score
        usort($recommendations, function ($a, $b) {
            if ($a['total_matches'] !== $b['total_matches']) {
                return $b['total_matches'] <=> $a['total_matches'];
            }
            return $b['best_score'] <=> $a['best_score'];
        });

        $result = array_slice($recommendations, 0, $limit);

        Log::info('🎉 Final recommendations', [
            'count' => count($result),
            'top_score' => $result[0]['best_score'] ?? 'N/A',
            'top_matches' => $result[0]['total_matches'] ?? 'N/A'
        ]);

        return $result;
    }

    /**
     * ✅ API: LẤY DANH SÁCH JOB PHÙ HỢP CHO MỘT ỨNG VIÊN CỤ THỂ
     * Dùng khi nhấn nút "Mời" trên UI
     */
    public function getMatchedJobsForApplicant($companyId, $applicantId): array
    {
        try {
            Log::info('🔍 Get matched jobs for applicant', [
                'company_id' => $companyId,
                'applicant_id' => $applicantId
            ]);

            // Lấy ứng viên
            $applicant = Applicant::with(['kynang', 'hocvan', 'kinhnghiem', 'ngoaiNgu', 'user'])
                ->findOrFail($applicantId);

            // Lấy jobs đang active của công ty
            $activeJobs = JobPost::where('companies_id', $companyId)
                ->where('status', 'active')
                ->where('deadline', '>=', now())
                ->with(['hashtags', 'company'])
                ->get();

            $matchedJobs = [];

            // Tính điểm với từng job
            foreach ($activeJobs as $job) {
                $matchData = $this->calculateMatchScore($applicant, $job);
                $score = $matchData['score'];

                // Chỉ lưu job có điểm >= 60%
                if ($score >= 60) {
                    $matchedJobs[] = [
                        'job' => $job,
                        'score' => $score,
                        'match_details' => $matchData['breakdown'],
                        // Thêm thông tin bổ sung
                        'received_count' => $this->getJobReceivedCount($job->job_id),
                        'is_full' => $this->isJobFull($job->job_id, $job->quantity)
                    ];
                }
            }

            // Sắp xếp theo điểm giảm dần
            usort($matchedJobs, function ($a, $b) {
                return $b['score'] <=> $a['score'];
            });

            Log::info('✅ Matched jobs found', [
                'applicant_id' => $applicantId,
                'total_matches' => count($matchedJobs)
            ]);

            return $matchedJobs;
        } catch (\Exception $e) {
            Log::error('❌ Error getting matched jobs', [
                'message' => $e->getMessage()
            ]);
            return [];
        }
    }

    /**
     * Đếm số lượng ứng viên đã nhận cho job
     */
    private function getJobReceivedCount($jobId): int
    {
        return DB::table('job_applications')
            ->where('job_id', $jobId)
            ->whereIn('status', ['accepted', 'pending'])
            ->count();
    }

    /**
     * Kiểm tra job đã đủ số lượng chưa
     */
    private function isJobFull($jobId, $quantity): bool
    {
        $receivedCount = $this->getJobReceivedCount($jobId);
        return $receivedCount >= $quantity;
    }

    /**
     * ✅ XÓA CACHE KHI CẬP NHẬT
     */
    public function clearCompanyRecommendationsCache($companyId): void
    {
        $keys = [
            "recommended_applicants_v2_company_{$companyId}_limit_12",
            "recommended_applicants_v2_company_{$companyId}_limit_20",
            "recommended_applicants_v2_company_{$companyId}_limit_50",
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }

        Log::info('🗑️ Cache cleared for company', ['company_id' => $companyId]);
    }
}
