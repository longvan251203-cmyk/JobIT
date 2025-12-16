<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\Application;
use App\Models\Applicant;
use App\Models\JobInvitation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmployerController extends Controller
{
    // ✅ DASHBOARD (existing)
    public function index()
    {
        $user = Auth::user();
        $employer = $user->employer;
        $company = $employer?->company;

        $jobPosts = $company
            ? JobPost::where('companies_id', $company->companies_id)
            ->with('detail')
            ->withCount('applications')
            ->orderBy('created_at', 'desc')
            ->get()
            : collect();

        $recruiters = $company
            ? \App\Models\Employer::where('companies_id', $company->companies_id)->get()
            : collect();

        return view('employer.home', compact('company', 'jobPosts', 'recruiters'));
    }

    // ✅ XEM TẤT CẢ ỨNG VIÊN
    public function applicantsIndex()
    {
        $user = Auth::user();
        $company = $user->employer->company ?? null;

        $applications = Application::whereIn('job_id', function ($query) use ($company) {
            $query->select('job_id')
                ->from('jobposts')
                ->where('companies_id', $company->companies_id ?? null);
        })
            ->with(['applicant', 'job', 'job.company'])
            ->paginate(12);

        return view('employer.applicants-dashboard', compact('applications'));
    }

    // ✅ XEM ỨNG VIÊN CHO 1 JOB CỤ THỂ
    public function jobApplicants($job_id)
    {
        $user = Auth::user();
        $company = $user->employer->company ?? null;

        $job = JobPost::where('job_id', $job_id)
            ->where('companies_id', $company->companies_id ?? null)
            ->firstOrFail();

        // 🆕 FILTER: Chỉ lấy applications KHÔNG từ invitation (job_invitation_id IS NULL)
        $applications = Application::where('job_id', $job_id)
            ->whereNull('job_invitation_id')
            ->with(['applicant', 'job', 'job.company'])
            ->paginate(12);

        // Lấy danh sách ứng viên được mời (có job_invitation_id)
        $invitations = JobInvitation::with(['applicant', 'application'])
            ->where('job_id', $job_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('employer.job-applicants', compact('job', 'applications', 'invitations'));
    }

    /**
     * Hiển thị danh sách ứng viên cho một công việc
     */
    public function showJobApplicants($jobId)
    {
        $job = JobPost::where('job_id', $jobId)->firstOrFail();

        // Lấy danh sách ứng viên được mời
        $invitations = JobInvitation::with(['applicant', 'application'])  // 🆕 Thêm 'application'
            ->where('job_id', $jobId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Lấy danh sách ứng viên ứng tuyển (loại bỏ những người được mời)
        // Loại bỏ cả applications có job_invitation_id (từ invitation)
        $applications = Application::with(['applicant', 'company'])
            ->where('job_id', $jobId)
            ->whereNull('job_invitation_id')
            ->orderBy('ngay_ung_tuyen', 'desc')
            ->get();

        // Tính toán thống kê (chỉ ứng viên ứng tuyển thường)
        $statistics = [
            'total' => $applications->count(),
            'cho_xu_ly' => $applications->where('trang_thai', 'cho_xu_ly')->count(),
            'dang_phong_van' => $applications->where('trang_thai', 'dang_phong_van')->count(),
            'duoc_chon' => $applications->where('trang_thai', 'duoc_chon')->count(),
            'khong_phu_hop' => $applications->where('trang_thai', 'khong_phu_hop')->count(),
        ];

        return view('employer.job-applicants', compact('job', 'applications', 'invitations', 'statistics'));
    }

    /**
     * Xem chi tiết CV ứng viên
     */
    public function viewCV($applicationId)
    {
        try {
            $application = Application::with(['applicant.kinhnghiem', 'applicant.hocvan', 'applicant.kynang'])
                ->findOrFail($applicationId);

            // Tự động cập nhật trạng thái từ "chưa xem" sang "đã xem"
            if ($application->trang_thai === 'chua_xem') {
                $application->update(['trang_thai' => 'da_xem']);
            }

            return response()->json([
                'success' => true,
                'application' => $application,
                'applicant' => $application->applicant
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể tải CV: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Gửi lời mời phỏng vấn
     */
    public function sendInterviewInvitation(Request $request, $applicationId)
    {
        try {
            $application = Application::with('applicant')->findOrFail($applicationId);

            $validated = $request->validate([
                'email' => 'required|email',
                'date' => 'required|date',
                'time' => 'required',
                'location' => 'nullable|string',
                'type' => 'required|in:online,offline'
            ]);

            // Cập nhật trạng thái thành "phong_van"
            $application->update([
                'trang_thai' => 'phong_van',
                'ghi_chu' => 'Đã gửi lời mời phỏng vấn vào ' . now()->format('d/m/Y H:i')
            ]);

            // Gửi email thông báo
            $this->sendInterviewEmail($application, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Đã gửi lời mời phỏng vấn thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Từ chối ứng viên
     */
    public function rejectApplicant(Request $request, $applicationId)
    {
        try {
            $application = Application::with('applicant')->findOrFail($applicationId);

            // Cập nhật trạng thái thành "tu_choi"
            $application->update([
                'trang_thai' => 'tu_choi',
                'ghi_chu' => 'Không phù hợp - ' . now()->format('d/m/Y H:i')
            ]);

            // Gửi email thông báo (nếu được yêu cầu)
            if ($request->input('send_email', false)) {
                $this->sendRejectionEmail($application);
            }

            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật trạng thái không phù hợp'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cập nhật trạng thái ứng viên
     */
    public function updateStatus(Request $request, $applicationId)
    {
        try {
            $application = Application::findOrFail($applicationId);

            $validated = $request->validate([
                'status' => 'required|in:chua_xem,da_xem,phong_van,duoc_chon,tu_choi',
                'note' => 'nullable|string'
            ]);

            $updateData = ['trang_thai' => $validated['status']];

            if (!empty($validated['note'])) {
                $updateData['ghi_chu'] = $validated['note'];
            }

            $application->update($updateData);

            // ✅ LOGIC: Khi update status thành "duoc_chon" (được chọn/đậu)
            if ($validated['status'] === 'duoc_chon') {
                try {
                    $job = JobPost::findOrFail($application->job_id);

                    // ✅ Kiểm tra số lượng đã chọn có vượt quá recruitment_count không
                    $selectedCount = Application::where('job_id', $job->job_id)
                        ->where('trang_thai', 'duoc_chon')
                        ->count();

                    Log::info('✅ Applicant selected', [
                        'application_id' => $applicationId,
                        'job_id' => $job->job_id,
                        'recruitment_count' => $job->recruitment_count,
                        'selected_count' => $selectedCount
                    ]);

                    // Thông báo cho employer nếu đã đủ số lượng
                    if ($selectedCount >= $job->recruitment_count) {
                        Log::info('✅ Job recruitment complete', [
                            'job_id' => $job->job_id,
                            'job_title' => $job->title,
                            'selected_count' => $selectedCount,
                            'recruitment_count' => $job->recruitment_count
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error('❌ Error checking selected count', [
                        'error' => $e->getMessage(),
                        'job_id' => $application->job_id
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Gửi email mời phỏng vấn
     */
    private function sendInterviewEmail($application, $details)
    {
        try {
            $data = [
                'name' => $application->hoten,
                'job_title' => $application->job->title ?? 'Vị trí tuyển dụng',
                'company_name' => $application->company->ten_cty ?? 'Công ty',
                'date' => date('d/m/Y', strtotime($details['date'])),
                'time' => $details['time'],
                'location' => $details['location'] ?? 'Sẽ được thông báo sau',
                'type' => $details['type']
            ];

            Mail::send('emails.interview-invitation', $data, function ($message) use ($application) {
                $message->to($application->email)
                    ->subject('Thông báo lịch phỏng vấn - ' . ($application->job->title ?? 'JobIT'));
            });

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send interview email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Gửi email từ chối
     */
    private function sendRejectionEmail($application)
    {
        try {
            $data = [
                'name' => $application->hoten,
                'job_title' => $application->job->title ?? 'Vị trí tuyển dụng',
                'company_name' => $application->company->ten_cty ?? 'Công ty'
            ];

            Mail::send('emails.application-rejection', $data, function ($message) use ($application) {
                $message->to($application->email)
                    ->subject('Thông báo kết quả ứng tuyển - ' . ($application->job->title ?? 'JobIT'));
            });

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send rejection email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Tải xuống CV
     */
    public function downloadCV($applicationId)
    {
        $application = Application::findOrFail($applicationId);

        if ($application->cv_type !== 'upload' || empty($application->cv_file_path)) {
            return redirect()->back()->with('error', 'CV không khả dụng');
        }

        $filePath = storage_path('app/public/' . $application->cv_file_path);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File CV không tồn tại');
        }

        return response()->download($filePath);
    }
    public function searchCandidates(Request $request)
    {
        $query = Applicant::query();

        // ✅ FIX: Filter theo từ khóa
        if ($request->has('keyword') && !empty($request->keyword)) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('hoten_uv', 'LIKE', "%{$keyword}%")
                    ->orWhere('vitritungtuyen', 'LIKE', "%{$keyword}%")
                    ->orWhere('gioithieu', 'LIKE', "%{$keyword}%");
            });
        }

        // ✅ FIX: Filter theo địa điểm - Kiểm tra array không rỗng
        if ($request->has('location')) {
            $locations = $request->location;

            // ✅ QUAN TRỌNG: Đảm bảo $locations là array và không rỗng
            if (is_array($locations) && count($locations) > 0) {
                $query->whereIn('diachi_uv', $locations);
            }
        }

        // ✅ FIX: Filter theo kinh nghiệm
        if ($request->has('experience')) {
            $experiences = $request->experience;

            if (is_array($experiences) && count($experiences) > 0) {
                $query->whereHas('kinhnghiem', function ($q) use ($experiences) {
                    $q->whereIn('experience_level', $experiences);
                });
            }
        }

        // ✅ FIX: Filter theo học vấn
        if ($request->has('education')) {
            $educations = $request->education;

            if (is_array($educations) && count($educations) > 0) {
                $query->whereHas('hocvan', function ($q) use ($educations) {
                    $q->whereIn('trinh_do', $educations);
                });
            }
        }

        // ✅ FIX: Filter theo kỹ năng
        if ($request->has('skills')) {
            $skills = $request->skills;

            if (is_array($skills) && count($skills) > 0) {
                $query->whereHas('kynang', function ($q) use ($skills) {
                    $q->whereIn('ten_ky_nang', $skills);
                });
            }
        }

        // Load relationships
        $candidates = $query->with(['kynang', 'kinhnghiem', 'hocvan', 'user'])
            ->paginate(12);

        return view('employer.candidates', compact('candidates'));
    }

    // ✅ API endpoint để lấy chi tiết ứng viên (cho modal)
    public function getCandidateDetail($candidateId)
    {
        $candidate = Applicant::with([
            'kynang',
            'kinhnghiem',
            'hocvan',
            'ngoaiNgu',
            'user'
        ])->findOrFail($candidateId);

        return response()->json($candidate);
    }
}
