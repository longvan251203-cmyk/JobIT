<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\JobPost;
use App\Models\JobInvitation;
use App\Models\Notification;
use App\Models\JobRecommendation;
use App\Services\JobRecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CandidatesController extends Controller
{
    protected $recommendationService;

    public function __construct(JobRecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    /**
     * ✅ Hiển thị danh sách ứng viên + gợi ý
     */
    public function index(Request $request)
    {
        try {
            Log::info('🔍 CandidatesController@index - START', [
                'user_id' => Auth::id(),
                'filters' => $request->all()
            ]);

            // ============ BƯỚC 1: TẠO QUERY FILTER (CHƯA EAGER LOAD) ============
            // ❌ KHÔNG dùng with() ngay lúc này
            $query = Applicant::query();

            // ✅ Filter keyword
            if ($request->filled('keyword')) {
                $keyword = $request->keyword;
                Log::info('Applying keyword filter:', ['keyword' => $keyword]);

                $query->where(function ($q) use ($keyword) {
                    $q->where('hoten_uv', 'like', "%{$keyword}%")
                        ->orWhere('vitriungtuyen', 'like', "%{$keyword}%")
                        ->orWhereHas('kynang', function ($subQ) use ($keyword) {
                            $subQ->where('ten_ky_nang', 'like', "%{$keyword}%");
                        });
                });
            }

            // ✅ Filter location (hoạt động giống như trước)
            if ($request->filled('location')) {
                $location = $request->location;
                Log::info('Applying location filter:', ['location' => $location]);
                $query->where('diachi_uv', 'like', '%' . $location . '%');
            }

            // ✅ Filter experience
            if ($request->filled('experience')) {
                $experiences = is_array($request->experience)
                    ? $request->experience
                    : [$request->experience];
                Log::info('Applying experience filter:', ['experiences' => $experiences]);

                $query->where(function ($q) use ($experiences) {
                    foreach ($experiences as $exp) {
                        if ($exp === '0') {
                            $q->orWhereDoesntHave('kinhnghiem');
                        } elseif ($exp === '0-1') {
                            $q->orWhereHas('kinhnghiem', function ($subQ) {
                                $subQ->selectRaw('DISTINCT applicant_id')
                                    ->havingRaw('SUM(TIMESTAMPDIFF(YEAR, tu_ngay, IFNULL(den_ngay, NOW()))) < 1');
                            });
                        } elseif ($exp === '1-3') {
                            $q->orWhereHas('kinhnghiem', function ($subQ) {
                                $subQ->selectRaw('DISTINCT applicant_id')
                                    ->havingRaw('SUM(TIMESTAMPDIFF(YEAR, tu_ngay, IFNULL(den_ngay, NOW()))) BETWEEN 1 AND 3');
                            });
                        } elseif ($exp === '3-5') {
                            $q->orWhereHas('kinhnghiem', function ($subQ) {
                                $subQ->selectRaw('DISTINCT applicant_id')
                                    ->havingRaw('SUM(TIMESTAMPDIFF(YEAR, tu_ngay, IFNULL(den_ngay, NOW()))) BETWEEN 3 AND 5');
                            });
                        } elseif ($exp === '5+') {
                            $q->orWhereHas('kinhnghiem', function ($subQ) {
                                $subQ->selectRaw('DISTINCT applicant_id')
                                    ->havingRaw('SUM(TIMESTAMPDIFF(YEAR, tu_ngay, IFNULL(den_ngay, NOW()))) >= 5');
                            });
                        }
                    }
                });
            }

            // ✅ Filter education
            if ($request->filled('education')) {
                $educations = is_array($request->education)
                    ? $request->education
                    : [$request->education];
                Log::info('Applying education filter:', ['educations' => $educations]);

                $query->whereHas('hocvan', function ($q) use ($educations) {
                    $q->whereIn('trinhdo', $educations);
                });
            }

            // ✅ Filter salary
            if ($request->filled('salary')) {
                $salaries = is_array($request->salary)
                    ? $request->salary
                    : [$request->salary];

                Log::info('Applying salary filter:', ['salaries' => $salaries]);

                $query->where(function ($q) use ($salaries) {
                    foreach ($salaries as $salary) {
                        // ✅ FIX: Parse giá trị mục lương từ string
                        if ($salary === 'Thỏa thuận') {
                            // Tìm những người chưa cập nhật mức lương hoặc mức lương = 0
                            $q->orWhere('mucluong_mongmuon', '=', 0)
                                ->orWhereNull('mucluong_mongmuon');
                        } elseif ($salary === 'Dưới 3 triệu') {
                            $q->orWhereBetween('mucluong_mongmuon', [0, 3000000]);
                        } elseif ($salary === '3-5 triệu') {
                            $q->orWhereBetween('mucluong_mongmuon', [3000000, 5000000]);
                        } elseif ($salary === '5-7 triệu') {
                            $q->orWhereBetween('mucluong_mongmuon', [5000000, 7000000]);
                        } elseif ($salary === '7-10 triệu') {
                            $q->orWhereBetween('mucluong_mongmuon', [7000000, 10000000]);
                        } elseif ($salary === '10-12 triệu') {
                            $q->orWhereBetween('mucluong_mongmuon', [10000000, 12000000]);
                        } elseif ($salary === '12-15 triệu') {
                            $q->orWhereBetween('mucluong_mongmuon', [12000000, 15000000]);
                        } elseif ($salary === '15-20 triệu') {
                            $q->orWhereBetween('mucluong_mongmuon', [15000000, 20000000]);
                        } elseif ($salary === '20-25 triệu') {
                            $q->orWhereBetween('mucluong_mongmuon', [20000000, 25000000]);
                        } elseif ($salary === '25-30 triệu') {
                            $q->orWhereBetween('mucluong_mongmuon', [25000000, 30000000]);
                        } elseif ($salary === 'Trên 30 triệu') {
                            $q->orWhere('mucluong_mongmuon', '>=', 30000000);
                        }
                    }
                });
            }
            // ✅ Filter language
            if ($request->filled('language')) {
                $languages = is_array($request->language)
                    ? $request->language
                    : [$request->language];
                Log::info('Applying language filter:', ['languages' => $languages]);

                $query->whereHas('ngoaiNgu', function ($q) use ($languages) {
                    $q->whereIn('ten_ngoai_ngu', $languages);
                });
            }

            // ✅ Filter skills
            if ($request->filled('skills')) {
                $skills = is_array($request->skills)
                    ? $request->skills
                    : [$request->skills];
                Log::info('Applying skills filter:', ['skills' => $skills]);

                $query->whereHas('kynang', function ($q) use ($skills) {
                    $q->whereIn('ten_ky_nang', $skills);
                });
            }

            // ✅ Filter gender
            if ($request->filled('gender') && $request->gender !== '') {
                $gender = $request->gender;
                Log::info('Applying gender filter:', ['gender' => $gender]);
                $query->where('gioitinh_uv', $gender);
            }

            // ============ BƯỚC 2: XỬ LÝ SORT (CÓ THỂ CÓ JOIN) ============
            $sortBy = $request->get('sort', 'newest');
            Log::info('Applying sort:', ['sort' => $sortBy]);

            if ($sortBy === 'experience') {
                // ❌ LỖI: Join sau khi filter sẽ làm lệch dữ liệu
                // ✅ FIX: Tạo subquery để lấy total experience
                $query->withCount([
                    'kinhnghiem as total_exp' => function ($q) {
                        $q->selectRaw('COALESCE(SUM(TIMESTAMPDIFF(YEAR, tu_ngay, IFNULL(den_ngay, NOW()))), 0)');
                    }
                ])->orderByDesc('total_exp');
            } elseif ($sortBy === 'education') {
                // ✅ FIX: Sử dụng withMax() thay vì join
                $query->with([
                    'hocvan' => function ($q) {
                        $q->selectRaw('applicant_id, MAX(CASE 
                            WHEN trinh_do = "Tiến sĩ" THEN 5
                            WHEN trinh_do = "Thạc sĩ" THEN 4
                            WHEN trinh_do = "Đại học" THEN 3
                            WHEN trinh_do = "Cao đẳng" THEN 2
                            ELSE 1
                        END) as edu_level')
                            ->groupBy('applicant_id');
                    }
                ]);
                // Sắp xếp sau paginate (không thể sắp xếp raw field trước paginate)
            } else {
                $query->orderByDesc('applicants.created_at');
            }

            // ============ DEBUG SQL ============
            Log::debug('SQL Query before paginate:', [
                'sql' => $query->toSql(),
                'bindings' => $query->getBindings()
            ]);

            // ============ BƯỚC 3: PAGINATE ============
            $candidates = $query->distinct()  // ✅ DISTINCT để tránh duplicate
                ->paginate(12)
                ->appends($request->except('page'));

            // ============ BƯỚC 4: EAGER LOAD SAU PAGINATE ============
            // ✅ Load relationship TRONG paginated results
            $candidateIds = $candidates->pluck('id_uv')->toArray();

            if (!empty($candidateIds)) {
                $relationships = Applicant::whereIn('id_uv', $candidateIds)
                    ->with(['kynang', 'hocvan', 'kinhnghiem', 'ngoaiNgu', 'user'])
                    ->get()
                    ->keyBy('id_uv');

                // Map relationships vào paginated results
                foreach ($candidates as $candidate) {
                    if (isset($relationships[$candidate->id_uv])) {
                        $candidate->setRelations($relationships[$candidate->id_uv]->getRelations());
                    }
                }
            }

            Log::info('✅ Candidates query completed', ['total' => $candidates->total()]);

            // ============ LẤY GỢI Ý ỨNG VIÊN ============
            $recommendedApplicants = [];

            if (Auth::check() && Auth::user()->employer) {
                try {
                    $employer = Auth::user()->employer;
                    $employer->load('company');

                    $companyId = $employer->companies_id ?? $employer->company->id ?? null;

                    Log::info('✅ Company ID found:', ['companies_id' => $companyId]);

                    if ($companyId) {
                        $recommendedApplicants = $this->recommendationService
                            ->getRecommendedApplicantsForCompany($companyId, 12);

                        Log::info('✅ Recommendations result:', [
                            'count' => count($recommendedApplicants),
                            'data' => json_encode($recommendedApplicants, JSON_UNESCAPED_UNICODE)
                        ]);
                    } else {
                        Log::warning('⚠️ Company ID is NULL');
                        $recommendedApplicants = [];
                    }
                } catch (\Exception $e) {
                    Log::error('❌ Error getting recommendations', [
                        'message' => $e->getMessage(),
                        'line' => $e->getLine(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    $recommendedApplicants = [];
                }
            }

            return view('employer.candidates', compact('candidates', 'recommendedApplicants'));
        } catch (\Exception $e) {
            Log::error('❌ Error in CandidatesController@index', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString()
            ]);

            return view('employer.candidates', [
                'candidates' => Applicant::with(['kynang', 'hocvan', 'kinhnghiem', 'ngoaiNgu', 'user'])
                    ->orderByDesc('created_at')
                    ->paginate(12),
                'recommendedApplicants' => []
            ]);
        }
    }

    /**
     * ✅ Xem chi tiết CV ứng viên (JSON)
     */
    public function show($id)
    {
        try {
            $candidate = Applicant::with([
                'kynang',
                'hocvan',
                'kinhnghiem',
                'ngoaiNgu',
                'user',
                'chungchi',  // ✅ Thêm
                'giaithuong'
            ])->findOrFail($id);

            return response()->json($candidate);
        } catch (\Exception $e) {
            Log::error('❌ Error in CandidatesController@show', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Không tìm thấy ứng viên'
            ], 404);
        }
    }

    /**
     * ✅ Download CV
     */
    public function downloadCV($id)
    {
        try {
            $candidate = Applicant::findOrFail($id);

            return redirect()->route('employer.candidates.show', $id)
                ->with('info', 'Chức năng tải CV đang được phát triển');
        } catch (\Exception $e) {
            Log::error('❌ Error downloading CV', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('employer.candidates')
                ->with('error', 'Không thể tải CV');
        }
    }

    /**
     * ✅ Liên hệ ứng viên
     */
    public function contact($id)
    {
        try {
            $candidate = Applicant::with('user')->findOrFail($id);

            return redirect()->route('employer.candidates')
                ->with('success', "Email ứng viên: {$candidate->user->email}");
        } catch (\Exception $e) {
            Log::error('❌ Error contacting candidate', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('employer.candidates')
                ->with('error', 'Không thể liên hệ ứng viên');
        }
    }

    //  * ✅ Kiểm tra xem ứng viên đã được mời cho job chưa
    //  */
    public function checkInvitationStatus($candidateId, $jobId)
    {
        try {
            $invitation = JobInvitation::where('applicant_id', $candidateId)
                ->where('job_id', $jobId)
                ->whereIn('status', ['pending', 'accepted'])
                ->first();

            return response()->json([
                'success' => true,
                'invited' => $invitation ? true : false,
                'status' => $invitation?->status ?? null,
                'invited_at' => $invitation?->invited_at ?? null
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error checking invitation', [
                'error' => $e->getMessage(),
                'candidate_id' => $candidateId,
                'job_id' => $jobId
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * ✅ Lấy danh sách jobs active chưa đủ ứng viên
     */


    public function getActiveUnfilled()
    {
        try {
            $employer = Auth::user()->employer;
            $companiesId = $employer->companies_id;

            if (!$companiesId && $employer->company) {
                $companiesId = $employer->company->companies_id;
            }

            if (!$companiesId) {
                Log::warning('⚠️ No companies_id found for employer', [
                    'employer_id' => $employer->id
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Công ty chưa được cấu hình. Vui lòng liên hệ quản trị viên.'
                ], 400);
            }

            // ✅ LẤY DANH SÁCH JOBS + CHECK LỜI MỜI
            $jobs = JobPost::where('companies_id', $companiesId)
                ->where('status', 'active')
                ->where('deadline', '>=', now()->toDateString())
                ->get()
                ->map(function ($job) use ($companiesId) {
                    $location = [];
                    if ($job->province) $location[] = $job->province;
                    if ($job->district) $location[] = $job->district;

                    // ✅ FIX: Đếm chỉ những ứng viên được chọn (duoc_chon)
                    $selectedCount = \App\Models\Application::where('job_id', $job->job_id)
                        ->where('trang_thai', 'duoc_chon')
                        ->count();

                    return [
                        'id' => $job->job_id,
                        'job_title' => $job->title,
                        'location' => implode(', ', $location) ?: 'Không xác định',
                        'salary_min' => $job->salary_min ? number_format($job->salary_min, 0, ',', '.') : null,
                        'salary_max' => $job->salary_max ? number_format($job->salary_max, 0, ',', '.') : null,
                        'quantity' => $job->recruitment_count ?? 0,
                        'deadline' => $job->deadline,
                        'received_count' => $selectedCount,  // ✅ SỬA: Chỉ đếm những được chọn
                        'required_skills' => $job->requirements ? array_filter(array_map('trim', explode(',', $job->requirements))) : []
                    ];
                });

            Log::info('✅ Jobs fetched successfully', [
                'count' => $jobs->count(),
                'companies_id' => $companiesId
            ]);

            return response()->json([
                'success' => true,
                'jobs' => $jobs
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error getting active unfilled jobs', [
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Không thể lấy danh sách vị trí: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ Gửi lời mời ứng viên cho vị trí
     */
    public function sendInvite($candidateId)
    {
        try {
            $request = request();
            $employer = Auth::user()->employer;
            $jobId = $request->input('job_id');

            Log::info('📧 Processing invite', [
                'candidate_id' => $candidateId,
                'job_id' => $jobId,
                'employer_id' => $employer->id,
                'companies_id' => $employer->companies_id
            ]);

            // ============ VALIDATE JOB ============
            $job = JobPost::where('job_id', $jobId)
                ->where('companies_id', $employer->companies_id)
                ->with('company') // ✅ Eager load company
                ->first();

            if (!$job) {
                Log::warning('⚠️ Job not found', [
                    'job_id' => $jobId,
                    'companies_id' => $employer->companies_id
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Vị trí tuyển dụng không tồn tại hoặc không thuộc về công ty bạn'
                ], 404);
            }

            // ============ VALIDATE CANDIDATE ============
            $candidate = Applicant::with('user')->find($candidateId);

            if (!$candidate) {
                Log::warning('⚠️ Candidate not found', ['candidate_id' => $candidateId]);

                return response()->json([
                    'success' => false,
                    'message' => 'Ứng viên không tồn tại'
                ], 404);
            }

            if (!$candidate->user_id) {
                Log::error('❌ Candidate has no user_id', ['candidate_id' => $candidateId]);

                return response()->json([
                    'success' => false,
                    'message' => 'Ứng viên chưa có tài khoản người dùng'
                ], 400);
            }

            // ============ CHECK DUPLICATE INVITATION ============
            $existingInvite = JobInvitation::where('applicant_id', $candidateId)
                ->where('job_id', $jobId)
                ->whereIn('status', ['pending', 'accepted'])
                ->first();

            if ($existingInvite) {
                Log::warning('⚠️ Invitation already exists', [
                    'invitation_id' => $existingInvite->id,
                    'status' => $existingInvite->status
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã gửi lời mời cho ứng viên này cho vị trí này rồi'
                ], 409);
            }

            // ============ CREATE INVITATION ============
            $invitation = JobInvitation::create([
                'job_id' => $jobId,
                'applicant_id' => $candidateId,
                'company_id' => $employer->companies_id,
                'status' => 'pending',
                'message' => $request->input('message', ''),
                'invited_at' => now()
            ]);

            // ✅ Load relationships cho notification
            $invitation->load(['job.company', 'applicant']);

            Log::info('✅ Invitation created successfully', [
                'invitation_id' => $invitation->id,
                'job_id' => $jobId,
                'candidate_id' => $candidateId
            ]);

            // ============ 🔔 TẠO THÔNG BÁO CHO ỨNG VIÊN ============
            try {
                // Ensure company is loaded with fresh data
                $company = $job->company;
                if (!$company) {
                    $job->load('company');
                    $company = $job->company;
                }

                $companyName = $company?->tencty ?? 'Công ty không xác định';

                Notification::create([
                    'user_id' => $candidate->user_id,
                    'type' => 'job_invitation',
                    'message' => "Bạn nhận được lời mời ứng tuyển vị trí {$job->title} từ {$companyName}",
                    'data' => [
                        'invitation_id' => $invitation->id,
                        'job_id' => $jobId,
                        'company_name' => $companyName,
                        'job_title' => $job->title,
                        'applicant_id' => $candidateId
                    ],
                    'is_read' => false
                ]);

                Log::info('✅ Notification created for applicant', [
                    'user_id' => $candidate->user_id,
                    'invitation_id' => $invitation->id
                ]);
            } catch (\Exception $e) {
                Log::error('❌ Failed to create notification', [
                    'error' => $e->getMessage(),
                    'user_id' => $candidate->user_id
                ]);
                // Không throw error, vì invitation đã tạo thành công
            }

            // ============ OPTIONAL: SEND EMAIL ============
            // try {
            //     Mail::to($candidate->user->email)
            //         ->send(new JobInvitationMail($invitation));
            //     Log::info('✅ Email sent to applicant');
            // } catch (\Exception $e) {
            //     Log::warning('⚠️ Could not send email', ['error' => $e->getMessage()]);
            // }

            return response()->json([
                'success' => true,
                'message' => 'Đã gửi lời mời thành công',
                'invitation_id' => $invitation->id
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error sending invite', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'candidate_id' => $candidateId ?? 'unknown',
                'job_id' => $jobId ?? 'unknown'
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ API: Lấy matched jobs từ DB (TAB GỢI Ý)
     * Chỉ hiển thị job phù hợp từ tính toán trước
     * Route: GET /employer/candidates/{applicantId}/matched-jobs
     */
    public function getMatchedJobsFromDB($applicantId)
    {
        try {
            $user = Auth::user();
            $employer = $user->employer;

            if (!$employer || !$employer->companies_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy thông tin công ty'
                ], 404);
            }

            $companyId = $employer->companies_id;

            // 💾 LẤY MATCHED JOBS TỪ DATABASE
            $matchedJobs = JobRecommendation::where('applicant_id', $applicantId)
                ->where('score', '>=', 60) // Chỉ job có score >= 60%
                ->with(['job' => function ($query) use ($companyId) {
                    $query->where('companies_id', $companyId) // Chỉ job của công ty này
                        ->with(['company', 'hashtags']);
                }])
                ->orderByDesc('score') // Sắp xếp điểm cao nhất
                ->get();

            // Filter ra job không thuộc công ty
            $matchedJobs = $matchedJobs->filter(function ($rec) {
                return $rec->job !== null;
            })->values();

            // Format data để hiển thị
            $formattedJobs = $matchedJobs->map(function ($rec) {
                $job = $rec->job;
                $matchDetails = is_string($rec->match_details)
                    ? json_decode($rec->match_details, true)
                    : $rec->match_details;

                // Format mức lương
                $salaryMin = (int)($job->salary_min ?? 0);
                $salaryMax = (int)($job->salary_max ?? 0);
                $salaryDisplay = '';
                if ($salaryMin > 0 && $salaryMax > 0) {
                    $salaryDisplay = number_format($salaryMin / 1000000, 0) . 'M - ' . number_format($salaryMax / 1000000, 0) . 'M';
                } elseif ($job->salary_type === 'negotiable') {
                    $salaryDisplay = 'Thỏa thuận';
                }

                return [
                    'id' => $job->job_id,
                    'job_title' => $job->title,  // ✅ FIX: title chứ không phải job_title
                    'location' => $job->province ?? $job->location ?? 'Không xác định',
                    'salary_min' => $salaryMin,
                    'salary_max' => $salaryMax,
                    'salary_display' => $salaryDisplay,  // ✅ Hiển thị "5M - 8M"
                    'salary_type' => $job->salary_type ?? 'Tháng',
                    'quantity' => $job->quantity ?? 0,
                    'deadline' => $job->deadline,
                    'working_type' => $job->working_type ?? 'Full-time',
                    'level' => $job->level ?? 'Không xác định',
                    'match_score' => round($rec->score), // 95%, 92%, 80%
                    'match_details' => $matchDetails ?? [], // Chi tiết {skills, location, position, experience, salary, language}
                    'received_count' => $job->applicant_count ?? 0,
                    'is_full' => false,
                    'required_skills' => $job->hashtags?->pluck('tag_name')->toArray() ?? [],
                    'company_name' => $job->company->tencty ?? 'N/A',
                    'company_logo' => $job->company->logo ?? null,
                    'is_matched' => true // Flag để biết là từ matched
                ];
            })->values()->toArray();

            Log::info('✅ Matched jobs retrieved from DB', [
                'applicant_id' => $applicantId,
                'total' => count($formattedJobs)
            ]);

            return response()->json([
                'success' => true,
                'jobs' => $formattedJobs,
                'total' => count($formattedJobs),
                'is_matched' => true
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error getting matched jobs from DB', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 📋 Lấy danh sách ứng viên đã ứng tuyển/được mời của công ty
     * Route: GET /api/employer/applicants-history
     */
    public function getApplicantsHistory(Request $request)
    {
        try {
            $user = Auth::user();
            $employer = $user->employer;

            if (!$employer || !$employer->companies_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy thông tin công ty'
                ], 404);
            }

            $companyId = $employer->companies_id;
            $filter = $request->get('filter', 'all'); // all, applied, invited, interviewed, hired, rejected
            $keyword = $request->get('keyword', '');
            $sort = $request->get('sort', 'recent'); // recent, name, most_applied

            // Lấy tất cả job của công ty
            $jobIds = JobPost::where('companies_id', $companyId)
                ->pluck('job_id')
                ->toArray();

            if (empty($jobIds)) {
                return response()->json([
                    'success' => true,
                    'applicants' => [],
                    'total' => 0
                ]);
            }

            // Lấy ứng viên từ applications hoặc invitations
            $applicantQuery = Applicant::query();

            // Filter theo trạng thái
            if ($filter === 'applied') {
                $applicantQuery->whereHas('applications', function ($q) use ($jobIds) {
                    $q->whereIn('job_id', $jobIds);
                });
            } elseif ($filter === 'invited') {
                $applicantQuery->whereHas('jobInvitations', function ($q) use ($jobIds) {
                    $q->whereIn('job_id', $jobIds);
                });
            } elseif ($filter === 'interviewed') {
                $applicantQuery->whereHas('applications', function ($q) use ($jobIds) {
                    $q->whereIn('job_id', $jobIds)
                        ->where('trang_thai', 'dang_phong_van');
                });
            } elseif ($filter === 'hired') {
                $applicantQuery->whereHas('applications', function ($q) use ($jobIds) {
                    $q->whereIn('job_id', $jobIds)
                        ->where('trang_thai', 'duoc_chon');
                });
            } elseif ($filter === 'rejected') {
                $applicantQuery->whereHas('applications', function ($q) use ($jobIds) {
                    $q->whereIn('job_id', $jobIds)
                        ->where('trang_thai', 'tu_choi');
                });
            } else {
                // all - những ứng viên từng ứng tuyển hoặc được mời
                $applicantQuery->where(function ($q) use ($jobIds) {
                    $q->whereHas('applications', function ($sub) use ($jobIds) {
                        $sub->whereIn('job_id', $jobIds);
                    })->orWhereHas('jobInvitations', function ($sub) use ($jobIds) {
                        $sub->whereIn('job_id', $jobIds);
                    });
                });
            }

            // Tìm kiếm theo keyword
            if (!empty($keyword)) {
                $applicantQuery->where(function ($q) use ($keyword) {
                    $q->where('hoten_uv', 'like', "%{$keyword}%")
                        ->orWhere('vitriungtuyen', 'like', "%{$keyword}%")
                        ->orWhereHas('kynang', function ($subQ) use ($keyword) {
                            $subQ->where('ten_ky_nang', 'like', "%{$keyword}%");
                        });
                });
            }

            // Sắp xếp
            if ($sort === 'name') {
                $applicantQuery->orderBy('hoten_uv', 'asc');
            } elseif ($sort === 'most_applied') {
                // Sắp xếp theo số lần ứng tuyển
                $applicantQuery->withCount(['applications' => function ($q) use ($jobIds) {
                    $q->whereIn('job_id', $jobIds);
                }])->orderByDesc('applications_count');
            } else {
                // recent - mới nhất
                $applicantQuery->orderByDesc('created_at');
            }

            $applicants = $applicantQuery->with(['kynang', 'hocvan', 'kinhnghiem', 'ngoaiNgu'])
                ->paginate(15);

            // Format dữ liệu
            $formatted = $applicants->map(function ($applicant) use ($jobIds, $companyId) {
                // Đếm số lần ứng tuyển
                $applicationCount = DB::table('applications')
                    ->where('applicant_id', $applicant->id_uv)
                    ->whereIn('job_id', $jobIds)
                    ->count();

                // Đếm số lần được mời
                $invitationCount = DB::table('job_invitations')
                    ->where('applicant_id', $applicant->id_uv)
                    ->whereIn('job_id', $jobIds)
                    ->count();

                // Lấy trạng thái cuối cùng
                $lastApplication = DB::table('applications')
                    ->where('applicant_id', $applicant->id_uv)
                    ->whereIn('job_id', $jobIds)
                    ->orderByDesc('created_at')
                    ->first();

                // Lấy job cuối cùng ứng tuyển
                $lastJob = null;
                if ($lastApplication) {
                    $lastJob = JobPost::find($lastApplication->job_id);
                }

                // Lấy tất cả job đã ứng tuyển
                $appliedJobs = DB::table('applications')
                    ->where('applicant_id', $applicant->id_uv)
                    ->whereIn('job_id', $jobIds)
                    ->select('job_id', 'trang_thai', 'created_at')
                    ->orderByDesc('created_at')
                    ->get()
                    ->map(function ($app) {
                        $job = JobPost::find($app->job_id);
                        return [
                            'job_id' => $app->job_id,
                            'job_title' => $job?->title ?? 'N/A',
                            'status' => $this->translateStatus($app->trang_thai),
                            'status_code' => $app->trang_thai,
                            'applied_at' => $app->created_at,
                            'status_color' => $this->getStatusColor($app->trang_thai)
                        ];
                    })->toArray();

                return [
                    'id' => $applicant->id_uv,
                    'name' => $applicant->hoten_uv,
                    'avatar' => $applicant->avatar ? asset('assets/img/avatars/' . $applicant->avatar) : null,
                    'position' => $applicant->vitriungtuyen,
                    'location' => $applicant->diachi_uv,
                    'email' => $applicant->user?->email ?? 'N/A',
                    'phone' => $applicant->sdt_uv ?? 'N/A',
                    'skills' => $applicant->kynang?->pluck('ten_ky_nang')->toArray() ?? [],
                    'about' => $applicant->gioithieu,
                    'experience_years' => $applicant->kinhnghiem?->count() ?? 0,
                    'application_count' => $applicationCount,
                    'invitation_count' => $invitationCount,
                    'last_status' => $lastApplication ? $this->translateStatus($lastApplication->trang_thai) : 'Chưa ứng tuyển',
                    'last_status_code' => $lastApplication?->trang_thai ?? null,
                    'last_status_color' => $lastApplication ? $this->getStatusColor($lastApplication->trang_thai) : 'gray',
                    'last_applied_at' => $lastApplication?->created_at,
                    'last_job_title' => $lastJob?->title ?? 'N/A',
                    'applied_jobs' => $appliedJobs
                ];
            })->toArray();

            return response()->json([
                'success' => true,
                'applicants' => $formatted,
                'pagination' => [
                    'current_page' => $applicants->currentPage(),
                    'last_page' => $applicants->lastPage(),
                    'total' => $applicants->total(),
                    'per_page' => $applicants->perPage()
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error getting applicants history', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 🔄 Dịch trạng thái ứng tuyển
     */
    private function translateStatus($status)
    {
        $map = [
            'cho_xu_ly' => 'Chờ xử lý',
            'dang_phong_van' => 'Đang phỏng vấn',
            'duoc_chon' => 'Được chọn',
            'tu_choi' => 'Từ chối',
            'da_nhan' => 'Đã nhận việc'
        ];
        return $map[$status] ?? $status;
    }

    /**
     * 🎨 Lấy màu cho trạng thái
     */
    private function getStatusColor($status)
    {
        $colors = [
            'cho_xu_ly' => 'yellow',
            'dang_phong_van' => 'blue',
            'duoc_chon' => 'green',
            'tu_choi' => 'red',
            'da_nhan' => 'emerald'
        ];
        return $colors[$status] ?? 'gray';
    }
}
