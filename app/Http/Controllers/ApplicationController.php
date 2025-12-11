<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Applicant;
use App\Models\JobPost;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ApplicationController extends Controller
{
    /**
     * ✅ HIỂN THỊ DANH SÁCH TẤT CẢ ỨNG VIÊN CỦA EMPLOYER
     */
    public function index(Request $request)
    {
        try {
            // Lấy employer hiện tại
            $employer = Auth::user()->employer;

            if (!$employer || !$employer->company) {
                return redirect()->route('company.edit')
                    ->with('error', 'Vui lòng hoàn tất thông tin công ty trước');
            }

            $company = $employer->company;

            // ✅ Lấy tất cả jobs của company này
            $jobIds = JobPost::where('companies_id', $company->companies_id)
                ->pluck('job_id');

            // ✅ Query applications với relationships đúng
            $applicationsQuery = Application::with(['job'])
                ->whereIn('job_id', $jobIds)
                ->orderBy('ngay_ung_tuyen', 'desc');

            // ✅ Search filter
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $applicationsQuery->where(function ($query) use ($search) {
                    $query->where('hoten', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('sdt', 'like', '%' . $search . '%');
                });
            }

            // ✅ Status filter
            if ($request->has('status') && $request->status != '') {
                $applicationsQuery->where('trang_thai', $request->status);
            }

            // ✅ Job filter
            if ($request->has('job_id') && $request->job_id != '') {
                $applicationsQuery->where('job_id', $request->job_id);
            }

            // ✅ Pagination
            $applicants = $applicationsQuery->paginate(12);

            // ✅ Statistics
            $totalApplicants = Application::whereIn('job_id', $jobIds)->count();

            $activeJobs = JobPost::where('companies_id', $company->companies_id)
                ->where('deadline', '>=', now())
                ->count();

            $newApplicants = Application::whereIn('job_id', $jobIds)
                ->where('ngay_ung_tuyen', '>=', Carbon::now()->startOfWeek())
                ->count();

            $interviewScheduled = Application::whereIn('job_id', $jobIds)
                ->where('trang_thai', Application::STATUS_DANG_PHONG_VAN)
                ->count();

            // ✅ Danh sách jobs cho filter dropdown
            $jobs = JobPost::where('companies_id', $company->companies_id)
                ->select('job_id', 'title')
                ->get();

            return view('employer.applicants-dashboard', compact(
                'applicants',
                'jobs',
                'totalApplicants',
                'activeJobs',
                'newApplicants',
                'interviewScheduled'
            ));
        } catch (\Exception $e) {
            Log::error('❌ Error in applicants index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra');
        }
    }
    public function store(Request $request)
    {
        try {
            // Validate dữ liệu
            $validator = Validator::make($request->all(), [
                'job_id' => 'required|exists:job_post,job_id',  // ✅ SỬA: job_post (không có s)
                'cv_type' => 'required|in:upload,profile',
                'cv_file' => 'required_if:cv_type,upload|file|mimes:pdf,doc,docx|max:5120',
                'hoten' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'sdt' => 'required|string|max:20',
                'diachi' => 'nullable|string|max:500',
                'thugioithieu' => 'nullable|string|max:2500',
            ], [
                'job_id.required' => 'Vui lòng chọn công việc để ứng tuyển',
                'job_id.exists' => 'Công việc không tồn tại',
                'cv_type.required' => 'Vui lòng chọn loại CV',
                'cv_file.required_if' => 'Vui lòng tải lên file CV',
                'cv_file.mimes' => 'File CV phải có định dạng: pdf, doc, docx',
                'cv_file.max' => 'File CV không được vượt quá 5MB',
                'hoten.required' => 'Vui lòng nhập họ tên',
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Email không hợp lệ',
                'sdt.required' => 'Vui lòng nhập số điện thoại',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            // Lấy thông tin job
            $job = JobPost::where('job_id', $request->job_id)->firstOrFail();

            // Kiểm tra đã ứng tuyển chưa
            $existingApplication = Application::where('job_id', $request->job_id)
                ->where('applicant_id', Auth::user()->applicant->id_uv)
                ->first();

            if ($existingApplication) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã ứng tuyển vào công việc này rồi!'
                ], 422);
            }

            // Xử lý file CV nếu upload
            $cvFilePath = null;
            if ($request->cv_type === 'upload' && $request->hasFile('cv_file')) {
                $file = $request->file('cv_file');
                $fileName = time() . '_' . Auth::id() . '_' . $file->getClientOriginalName();
                $cvFilePath = $file->storeAs('cv_uploads', $fileName, 'public');
            }

            // Tạo đơn ứng tuyển
            $application = Application::create([
                'job_id' => $request->job_id,
                'applicant_id' => Auth::user()->applicant->id_uv,
                'company_id' => $job->companies_id,
                'cv_type' => $request->cv_type,
                'cv_file_path' => $cvFilePath,
                'hoten' => $request->hoten,
                'email' => $request->email,
                'sdt' => $request->sdt,
                'diachi' => $request->diachi,
                'thu_gioi_thieu' => $request->thugioithieu,
                'trang_thai' => Application::STATUS_CHO_XU_LY,  // ✅ SỬA: dùng giá trị cũ
                'ngay_ung_tuyen' => now(),
            ]);
            // ✅ TẠO THÔNG BÁO CHO EMPLOYER
            $employer = $job->company->employer;
            if ($employer && $employer->user_id) {
                Notification::createNewApplicationNotification(
                    $employer->user_id,
                    $application->load('job')
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Nộp hồ sơ ứng tuyển thành công! Nhà tuyển dụng sẽ liên hệ với bạn sớm.',
                'data' => $application
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Lỗi ứng tuyển: ' . $e->getMessage(), [
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * ✅ HỦY ỨNG TUYỂN (CHO APPLICANT)
     */
    public function cancel($applicationId)
    {
        try {
            $applicant = Applicant::where('user_id', Auth::id())->first();

            $application = Application::where('application_id', $applicationId)
                ->where('applicant_id', $applicant->id_uv)
                ->firstOrFail();

            // ✅ ĐIỀU KIỆN 1: Chỉ được hủy khi trạng thái là "chờ xử lý"
            if ($application->trang_thai !== Application::STATUS_CHO_XU_LY) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chỉ có thể hủy ứng tuyển ở trạng thái chờ xử lý'
                ], 400);
            }

            // ✅ ĐIỀU KIỆN 2: Kiểm tra thời gian - chỉ cho phép hủy trong 24 giờ
            $applicationTime = Carbon::parse($application->ngay_ung_tuyen);
            $currentTime = Carbon::now();
            $hoursElapsed = $applicationTime->diffInHours($currentTime);

            if ($hoursElapsed > 24) {
                $timeExpired = $applicationTime->addHours(24)->format('d/m/Y H:i');
                return response()->json([
                    'success' => false,
                    'message' => "Hạn thời gian hủy ứng tuyển đã hết (24 giờ kể từ ứng tuyển). Thời hạn kết thúc lúc: $timeExpired",
                    'expired' => true,
                    'application_time' => $applicationTime->format('d/m/Y H:i'),
                    'cancel_deadline' => $applicationTime->addHours(24)->format('d/m/Y H:i'),
                    'hours_elapsed' => $hoursElapsed
                ], 400);
            }

            // ✅ Nếu vượt qua tất cả các điều kiện, tiến hành xóa
            if ($application->cv_file_path) {
                Storage::disk('public')->delete($application->cv_file_path);
            }

            $application->delete();

            Log::info('✅ Ứng viên hủy ứng tuyển thành công', [
                'application_id' => $applicationId,
                'applicant_id' => $applicant->id_uv,
                'hours_after_application' => $hoursElapsed
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Đã hủy ứng tuyển thành công'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi hủy ứng tuyển: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra'
            ], 500);
        }
    }
    public function canCancelApplication($applicationId)
    {
        try {
            $applicant = Applicant::where('user_id', Auth::id())->first();

            $application = Application::where('application_id', $applicationId)
                ->where('applicant_id', $applicant->id_uv)
                ->firstOrFail();

            $applicationTime = Carbon::parse($application->ngay_ung_tuyen);
            $currentTime = Carbon::now();
            $hoursElapsed = $applicationTime->diffInHours($currentTime);
            $minutesRemaining = $applicationTime->addHours(24)->diffInMinutes($currentTime, false);

            $canCancel = $application->trang_thai === Application::STATUS_CHO_XU_LY && $hoursElapsed <= 24;

            return response()->json([
                'success' => true,
                'can_cancel' => $canCancel,
                'status' => $application->trang_thai,
                'hours_elapsed' => $hoursElapsed,
                'application_time' => $applicationTime->format('d/m/Y H:i'),
                'cancel_deadline' => $applicationTime->addHours(24)->format('d/m/Y H:i'),
                'minutes_remaining' => max(0, $minutesRemaining),
                'reason_if_cannot' => !$canCancel ? $this->getCannotCancelReason($application, $hoursElapsed) : null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy đơn ứng tuyển'
            ], 404);
        }
    }

    /**
     * ✅ LẤY LÝDO KHÔNG THỂ HỦY
     */
    private function getCannotCancelReason($application, $hoursElapsed)
    {
        if ($hoursElapsed > 24) {
            return 'Quá 24 giờ kể từ khi ứng tuyển. Không thể hủy nữa.';
        }

        if ($application->trang_thai !== Application::STATUS_CHO_XU_LY) {
            $statusText = match ($application->trang_thai) {
                'dang_phong_van' => 'đang phỏng vấn',
                'duoc_chon' => 'được chọn',
                'khong_phu_hop' => 'bị từ chối',
                default => 'khác'
            };
            return "Ứng tuyển đang ở trạng thái \"$statusText\", không thể hủy.";
        }

        return 'Không thể hủy ứng tuyển này.';
    }
    // ✅ DANH SÁCH ỨNG VIÊN
    /**
     * ✅ DANH SÁCH ỨNG VIÊN (EMPLOYER)
     */
    public function jobApplicants($jobId)
    {
        try {
            $job = JobPost::with('company')->where('job_id', $jobId)->firstOrFail();

            $applications = Application::with(['applicant', 'job'])
                ->where('job_id', $jobId)
                ->orderBy('ngay_ung_tuyen', 'desc')
                ->get();

            $statistics = [
                'total' => $applications->count(),
                'cho_xu_ly' => $applications->where('trang_thai', Application::STATUS_CHO_XU_LY)->count(),
                'dang_phong_van' => $applications->where('trang_thai', Application::STATUS_DANG_PHONG_VAN)->count(),
                'duoc_chon' => $applications->where('trang_thai', Application::STATUS_DUOC_CHON)->count(),
                'khong_phu_hop' => $applications->where('trang_thai', Application::STATUS_KHONG_PHU_HOP)->count(),
            ];

            return view('employer.job-applicants', compact('job', 'applications', 'statistics'));
        } catch (\Exception $e) {
            Log::error('Lỗi xem ứng viên: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra');
        }
    }

    // ✅ CẬP NHẬT TRẠNG THÁI
    /**
     * ✅ CẬP NHẬT TRẠNG THÁI
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:cho_xu_ly,dang_phong_van,duoc_chon,khong_phu_hop'
            ]);

            $application = Application::with('company')->findOrFail($id);

            if (Auth::user()->user_id != $application->company->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có quyền'
                ], 403);
            }

            $application->update([
                'trang_thai' => $validated['status'],
                'ghi_chu' => ($application->ghi_chu ?? '') .
                    "\n[" . now()->format('d/m/Y H:i') . "] Cập nhật: " . $validated['status']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật trạng thái',
                'data' => [
                    'new_status' => $validated['status']
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra'
            ], 500);
        }
    }


    /**
     * ✅ XEM CV
     */
    public function viewCV($id)
    {
        try {
            $application = Application::with([
                'applicant.hocvan',
                'applicant.kinhnghiem',
                'applicant.kynang',
                'applicant.ngoaingu',
                'job',
                'company'
            ])->findOrFail($id);

            if (Auth::user()->user_id != $application->company->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có quyền'
                ], 403);
            }

            return response()->json([
                'success' => true,
                'applicant' => $application->applicant,
                'application' => $application
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra'
            ], 500);
        }
    }

    /**
     * ✅ THÊM GHI CHÚ
     */
    public function addNote(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'note' => 'required|string|max:1000'
            ]);

            $application = Application::with('company')->findOrFail($id);

            if (Auth::user()->user_id != $application->company->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có quyền'
                ], 403);
            }

            $newNote = "[" . now()->format('d/m/Y H:i') . "] " . $validated['note'];
            $application->update([
                'ghi_chu' => ($application->ghi_chu ?? '') . "\n" . $newNote
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Đã thêm ghi chú',
                'note' => $newNote
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra'
            ], 500);
        }
    }

    /**
     * ✅ TẢI CV
     */
    public function downloadCV($id)
    {
        try {
            $application = Application::with('company')->findOrFail($id);

            if (Auth::user()->user_id != $application->company->user_id) {
                abort(403);
            }

            if (!$application->cv_file_path) {
                return redirect()->back()->with('error', 'Không có file CV');
            }

            $filePath = storage_path('app/public/' . $application->cv_file_path);

            if (!file_exists($filePath)) {
                return redirect()->back()->with('error', 'File không tồn tại');
            }

            return response()->download($filePath);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra');
        }
    }
    public function sendResultEmail(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'type' => 'required|in:approved,rejected',
                'note' => 'nullable|string|max:500'
            ]);

            $application = Application::with(['job', 'applicant', 'company'])->findOrFail($id);

            if (Auth::user()->user_id != $application->company->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có quyền'
                ], 403);
            }

            $emailData = [
                'candidate_name' => $application->hoten,
                'job_title' => $application->job->title,
                'company_name' => $application->company->ten_cong_ty,
                'company_email' => $application->company->email ?? '',
                'company_phone' => $application->company->so_dien_thoai ?? '',
                'note' => $validated['note'] ?? '',
                'type' => $validated['type']
            ];

            if ($validated['type'] === 'approved') {
                // Email thông báo ĐẬU
                Mail::send('emails.application-approved', $emailData, function ($message) use ($validated, $application) {
                    $message->to($validated['email'])
                        ->subject('🎉 Chúc mừng! Bạn đã được chọn - ' . $application->job->title);
                });
            } else {
                // Email thông báo TỪ CHỐI
                Mail::send('emails.application-rejected', $emailData, function ($message) use ($validated, $application) {
                    $message->to($validated['email'])
                        ->subject('Thông báo kết quả ứng tuyển - ' . $application->job->title);
                });
            }

            Log::info('✅ Đã gửi email kết quả phỏng vấn', [
                'application_id' => $id,
                'type' => $validated['type'],
                'email' => $validated['email']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Đã gửi email kết quả'
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Lỗi gửi email kết quả: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    // Xử lý ứng tuyển (từ applicant)
    /**
     * ✅✅✅ GỬI LỜI MỜI PHỎNG VẤN - CHỨC NĂNG CHÍNH ✅✅✅
     */
    public function sendInterviewInvitation(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'date' => 'required|date|after_or_equal:today',
                'time' => 'required',
                'location' => 'nullable|string',
                'type' => 'required|in:online,offline'
            ]);

            $application = Application::with(['job', 'applicant', 'company'])->findOrFail($id);

            if (Auth::user()->user_id != $application->company->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có quyền'
                ], 403);
            }

            // Chuẩn bị dữ liệu email
            $interviewData = [
                'candidate_name' => $application->hoten,
                'job_title' => $application->job->title,
                'company_name' => $application->company->ten_cong_ty,
                'interview_date' => date('d/m/Y', strtotime($validated['date'])),
                'interview_time' => $validated['time'],
                'interview_type' => $validated['type'] === 'online' ? 'Phỏng vấn Online' : 'Phỏng vấn trực tiếp',
                'location' => $validated['location'] ?? 'Sẽ được thông báo sau',
                'company_address' => $application->company->dia_chi ?? '',
                'company_phone' => $application->company->so_dien_thoai ?? '',
                'company_email' => $application->company->email ?? ''
            ];

            // Tự động tạo link meeting
            if ($validated['type'] === 'online' && empty($validated['location'])) {
                $code = substr(md5($application->job->job_id . $id . time()), 0, 10);
                $interviewData['location'] = "https://meet.google.com/" .
                    substr($code, 0, 3) . '-' .
                    substr($code, 3, 4) . '-' .
                    substr($code, 7, 3);
                $interviewData['auto_generated_link'] = true;
            }

            // GỬI EMAIL
            Mail::send('emails.interview-invitation', $interviewData, function ($message) use ($validated, $application) {
                $message->to($validated['email'])
                    ->subject('🎯 Lời mời phỏng vấn - ' . $application->job->title);
            });

            // Cập nhật trạng thái
            $application->update([
                'trang_thai' => Application::STATUS_DANG_PHONG_VAN,
                'ghi_chu' => ($application->ghi_chu ?? '') .
                    "\n[" . now()->format('d/m/Y H:i') . "] Đã gửi lời mời phỏng vấn: " .
                    $validated['date'] . ' ' . $validated['time']
            ]);

            Log::info('✅ Đã gửi email phỏng vấn', [
                'application_id' => $id,
                'email' => $validated['email']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Đã gửi lời mời phỏng vấn thành công!',
                'data' => [
                    'new_status' => Application::STATUS_DANG_PHONG_VAN
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Lỗi gửi email: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ TỪ CHỐI ỨNG VIÊN
     */
    public function rejectApplication(Request $request, $id)
    {
        try {
            $application = Application::with(['job', 'company'])->findOrFail($id);

            if (Auth::user()->user_id != $application->company->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có quyền'
                ], 403);
            }

            $application->update([
                'trang_thai' => Application::STATUS_KHONG_PHU_HOP,
                'ghi_chu' => ($application->ghi_chu ?? '') .
                    "\n[" . now()->format('d/m/Y H:i') . "] Đã từ chối"
            ]);

            // Gửi email từ chối (nếu yêu cầu)
            if ($request->input('send_email', false)) {
                try {
                    Mail::send('emails.rejection', [
                        'candidate_name' => $application->hoten,
                        'job_title' => $application->job->title,
                        'company_name' => $application->company->ten_cong_ty
                    ], function ($message) use ($application) {
                        $message->to($application->email)
                            ->subject('Thông báo kết quả ứng tuyển - ' . $application->job->title);
                    });
                } catch (\Exception $e) {
                    Log::warning('Không gửi được email từ chối: ' . $e->getMessage());
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật trạng thái không phù hợp',
                'data' => [
                    'new_status' => Application::STATUS_KHONG_PHU_HOP
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra'
            ], 500);
        }
    }


    // ✅ Helper: Gửi email mời phỏng vấn
    private function sendInterviewEmail($application, $data)
    {
        try {
            Mail::send('emails.interview-invitation', [
                'applicant' => $application->applicant,
                'job' => $application->job,
                'company' => $application->company,
                'date' => $data['date'],
                'time' => $data['time'],
                'location' => $data['location'],
                'type' => $data['type']
            ], function ($message) use ($data) {
                $message->to($data['email'])
                    ->subject('Lời mời phỏng vấn - ' . config('app.name'));
            });
        } catch (\Exception $e) {
            Log::error('Send interview email failed: ' . $e->getMessage());
        }
    }

    // ✅ Helper: Gửi email từ chối
    private function sendRejectionEmail($application)
    {
        try {
            Mail::send('emails.application-rejected', [
                'applicant' => $application->applicant,
                'job' => $application->job,
                'company' => $application->company
            ], function ($message) use ($application) {
                $message->to($application->email)
                    ->subject('Thông báo kết quả ứng tuyển - ' . config('app.name'));
            });
        } catch (\Exception $e) {
            Log::error('Send rejection email failed: ' . $e->getMessage());
        }
    }
}
