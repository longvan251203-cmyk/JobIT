<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\JobPost;
use App\Models\JobInvitation;
use App\Services\JobRecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EmployerCandidatesController extends Controller
{
    protected $recommendationService;

    public function __construct(JobRecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    /**
     * Trang danh sách ứng viên
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            $employer = $user->employer;

            // ✅ LẤY COMPANY ĐÚNG CÁCH
            $company = $employer?->company;

            if (!$company) {
                return redirect()->route('employer.dashboard')
                    ->with('error', 'Vui lòng cập nhật thông tin công ty trước');
            }

            // ========== GỢI Ý ỨNG VIÊN CHO CÔNG TY ==========
            $recommendedApplicants = $this->recommendationService
                ->getRecommendedApplicantsForCompany($company->companies_id, 12);;

            Log::info('📊 Recommended applicants loaded', [
                'company_id' =>  $company->companies_id,
                'count' => count($recommendedApplicants)
            ]);

            // ========== DANH SÁCH ỨNG VIÊN THÔNG THƯỜNG ==========
            $query = Applicant::with(['kynang', 'hocvan', 'kinhnghiem', 'ngoaiNgu', 'user']);

            // Filter by keyword
            if ($request->filled('keyword')) {
                $keyword = $request->keyword;
                $query->where(function ($q) use ($keyword) {
                    $q->where('hoten_uv', 'like', "%{$keyword}%")
                        ->orWhere('vitriungtuyen', 'like', "%{$keyword}%")
                        ->orWhereHas('kynang', function ($q) use ($keyword) {
                            $q->where('ten_ky_nang', 'like', "%{$keyword}%");
                        });
                });
            }

            // Filter by location
            if ($request->filled('location')) {
                $query->where('diachi_uv', 'like', "%{$request->location}%");
            }

            // Filter by experience
            if ($request->filled('experience')) {
                $experiences = $request->input('experience');
                $query->whereHas('kinhnghiem', function ($q) use ($experiences) {
                    $q->whereIn('id', $experiences);
                });
            }

            // Filter by education
            if ($request->filled('education')) {
                $educations = $request->input('education');
                $query->whereHas('hocvan', function ($q) use ($educations) {
                    $q->whereIn('trinh_do', $educations);
                });
            }

            // Filter by skills
            if ($request->filled('skills')) {
                $skills = $request->input('skills');
                $query->whereHas('kynang', function ($q) use ($skills) {
                    $q->whereIn('ten_ky_nang', $skills);
                });
            }

            // Sort
            switch ($request->input('sort', 'newest')) {
                case 'experience':
                    $query->withCount('kinhnghiem')->orderByDesc('kinhnghiem_count');
                    break;
                case 'education':
                    $query->orderByDesc('id_uv');
                    break;
                default:
                    $query->latest('id_uv');
            }

            $candidates = $query->paginate(12);

            return view('employer.candidates', compact('candidates', 'recommendedApplicants'));
        } catch (\Exception $e) {
            Log::error('❌ Error loading candidates page', [
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ]);

            return back()->with('error', 'Có lỗi xảy ra khi tải danh sách ứng viên');
        }
    }

    /**
     * ✅ API: Lấy chi tiết ứng viên
     */
    public function show($id)
    {
        try {
            $applicant = Applicant::with([
                'kynang',
                'hocvan',
                'kinhnghiem',
                'ngoaiNgu',
                'duan',
                'chungchi',
                'giaithuong',
                'user'
            ])->findOrFail($id);

            return response()->json($applicant);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Không tìm thấy ứng viên'
            ], 404);
        }
    }

    /**
     * ✅ Gửi lời mời ứng tuyển
     */
    public function inviteToJob(Request $request, $applicantId)
    {
        try {
            $request->validate([
                'job_id' => 'required|exists:job_posts,job_id'
            ]);

            $company = Auth::user()->employer->company;
            $jobId = $request->job_id;

            // Kiểm tra job có thuộc công ty không
            $job = JobPost::where('job_id', $jobId)
                ->where('companies_id',  $company->companies_id)
                ->firstOrFail();

            // Kiểm tra đã mời chưa
            $existingInvite = JobInvitation::where('job_id', $jobId)
                ->where('applicant_id', $applicantId)
                ->first();

            if ($existingInvite) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã mời ứng viên này cho vị trí này rồi'
                ], 400);
            }

            // Tạo lời mời mới
            JobInvitation::create([
                'job_id' => $jobId,
                'applicant_id' => $applicantId,
                'company_id' =>  $company->companies_id,
                'status' => 'pending',
                'invited_at' => now(),
                'message' => "Công ty {$company->tencty} mời bạn ứng tuyển vào vị trí: {$job->job_title}"
            ]);

            Log::info('✅ Job invitation sent', [
                'job_id' => $jobId,
                'applicant_id' => $applicantId,
                'company_id' =>  $company->companies_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Đã gửi lời mời thành công!'
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error sending invitation', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi gửi lời mời'
            ], 500);
        }
    }

    /**
     * Tải CV
     */
    public function downloadCV($id)
    {
        try {
            $applicant = Applicant::findOrFail($id);
            // Implement logic tải CV
            return response()->download(storage_path("app/cvs/{$id}.pdf"));
        } catch (\Exception $e) {
            return back()->with('error', 'Không tìm thấy CV');
        }
    }

    /**
     * Liên hệ ứng viên
     */
    public function contact($id)
    {
        try {
            $applicant = Applicant::with('user')->findOrFail($id);
            return redirect()->away("mailto:{$applicant->user->email}");
        } catch (\Exception $e) {
            return back()->with('error', 'Không tìm thấy ứng viên');
        }
    }

    /**
     * ✅ API: Lấy danh sách job phù hợp cho ứng viên
     */
    public function getMatchedJobs($applicantId)
    {
        try {
            $company = Auth::user()->employer->company;

            if (!$company) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy thông tin công ty'
                ], 404);
            }

            $matchedJobs = $this->recommendationService
                ->getMatchedJobsForApplicant($company->companies_id, $applicantId);

            $formattedJobs = collect($matchedJobs)->map(function ($item) {
                $job = $item['job'];
                return [
                    'id' => $job->job_id,
                    'job_title' => $job->job_title,
                    'location' => $job->province ?? $job->location ?? 'Không xác định',
                    'salary_min' => $job->salary_min,
                    'salary_max' => $job->salary_max,
                    'salary_type' => $job->salary_type,
                    'quantity' => $job->quantity,
                    'deadline' => $job->deadline,
                    'working_type' => $job->working_type,
                    'level' => $job->level,
                    'match_score' => round($item['score']),
                    'match_details' => $item['match_details'],
                    'received_count' => $item['received_count'] ?? 0,
                    'is_full' => $item['is_full'] ?? false,
                    'required_skills' => $job->hashtags->pluck('tag_name')->toArray(),
                    'company_name' => $job->company->tencty ?? 'N/A',
                    'company_logo' => $job->company->logo ?? null
                ];
            })->values()->toArray();

            return response()->json([
                'success' => true,
                'jobs' => $formattedJobs,
                'total' => count($formattedJobs)
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error getting matched jobs', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra'
            ], 500);
        }
    }
}
