<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class ApplicationController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validate dữ liệu
            $validator = Validator::make($request->all(), [
                'job_id' => 'required|exists:job_post,job_id',
                'cv_type' => 'required|in:upload,profile',
                'cv_file' => 'required_if:cv_type,upload|file|mimes:pdf,doc,docx|max:5120', // 5MB
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
            $job = JobPost::findOrFail($request->job_id);

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
                'trang_thai' => 'chua_xem',
                'ngay_ung_tuyen' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Nộp hồ sơ ứng tuyển thành công! Nhà tuyển dụng sẽ liên hệ với bạn sớm.',
                'data' => $application
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
    public function cancel($applicationId)
    {
        try {
            $application = Application::findOrFail($applicationId);

            // Kiểm tra quyền
            if ($application->applicant_id != Auth::user()->applicant->id_uv) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền hủy đơn ứng tuyển này!'
                ], 403);
            }

            // Chỉ cho phép hủy nếu chưa xem hoặc đã xem
            if (!in_array($application->trang_thai, ['chua_xem', 'da_xem'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể hủy đơn ứng tuyển ở trạng thái hiện tại!'
                ], 422);
            }

            // Xóa file CV nếu có
            if ($application->cv_file_path && Storage::disk('public')->exists($application->cv_file_path)) {
                Storage::disk('public')->delete($application->cv_file_path);
            }

            $application->delete();

            return response()->json([
                'success' => true,
                'message' => 'Đã hủy đơn ứng tuyển thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
    public function jobApplicants($job_id)
    {
        $employer = Auth::user()->employer;

        if (!$employer || !$employer->company) {
            return redirect()->route('employer.home')->with('error', 'Vui lòng cập nhật thông tin công ty');
        }

        // Lấy thông tin job và kiểm tra quyền sở hữu
        $job = JobPost::with('detail', 'company')
            ->where('job_id', $job_id)
            ->where('companies_id', $employer->company->companies_id)
            ->firstOrFail();

        // Lấy danh sách ứng viên
        $applications = Application::with(['applicant.user', 'applicant.kinhnghiem', 'applicant.hocvan', 'applicant.kynang'])
            ->where('job_id', $job_id)
            ->orderBy('ngay_ung_tuyen', 'desc')
            ->get();

        // Thống kê theo trạng thái
        $statistics = [
            'total' => $applications->count(),
            'chua_xem' => $applications->where('trang_thai', 'chua_xem')->count(),
            'da_xem' => $applications->where('trang_thai', 'da_xem')->count(),
            'phong_van' => $applications->where('trang_thai', 'phong_van')->count(),
            'duoc_chon' => $applications->where('trang_thai', 'duoc_chon')->count(),
            'tu_choi' => $applications->where('trang_thai', 'tu_choi')->count(),
        ];

        return view('employer.job-applicants', compact('job', 'applications', 'statistics'));
    }

    // Cập nhật trạng thái ứng viên
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:chua_xem,da_xem,phong_van,duoc_chon,tu_choi',
            'note' => 'nullable|string|max:1000'
        ]);

        $application = Application::findOrFail($id);

        // Kiểm tra quyền sở hữu
        $employer = Auth::user()->employer;
        if ($application->company_id != $employer->company->companies_id) {
            return response()->json(['success' => false, 'message' => 'Không có quyền truy cập'], 403);
        }

        $application->trang_thai = $request->status;

        if ($request->note) {
            $application->ghi_chu = $request->note;
        }

        $application->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái thành công',
            'badge' => $application->status_badge
        ]);
    }

    // Xem CV ứng viên
    public function viewCV($id)
    {
        $application = Application::with(['applicant.kinhnghiem', 'applicant.hocvan', 'applicant.kynang'])
            ->findOrFail($id);

        $employer = Auth::user()->employer;
        if ($application->company_id != $employer->company->companies_id) {
            abort(403, 'Không có quyền truy cập');
        }

        // Đánh dấu đã xem
        if ($application->trang_thai == 'chua_xem') {
            $application->trang_thai = 'da_xem';
            $application->save();
        }

        return response()->json([
            'success' => true,
            'applicant' => $application->applicant,
            'application' => $application
        ]);
    }

    // Thêm ghi chú
    public function addNote(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string|max:1000'
        ]);

        $application = Application::findOrFail($id);

        $employer = Auth::user()->employer;
        if ($application->company_id != $employer->company->companies_id) {
            return response()->json(['success' => false, 'message' => 'Không có quyền'], 403);
        }

        $application->ghi_chu = $request->note;
        $application->save();

        return response()->json(['success' => true, 'message' => 'Đã lưu ghi chú']);
    }

    // Download CV
    public function downloadCV($id)
    {
        $application = Application::with(['applicant'])->findOrFail($id);

        $employer = Auth::user()->employer;
        if ($application->company_id != $employer->company->companies_id) {
            abort(403);
        }

        if ($application->cv_type == 'upload' && $application->cv_file_path) {
            return Storage::download($application->cv_file_path);
        }

        // Nếu dùng profile, tạo PDF từ thông tin
        $pdf = Pdf::loadView('pdf.applicant-cv', ['applicant' => $application->applicant]);
        return $pdf->download('CV_' . $application->applicant->hoten_uv . '.pdf');
    }

    // Xử lý ứng tuyển (từ applicant)

}
