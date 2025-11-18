<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\NhanVienCty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    /**
     * Hiển thị trang thông tin công ty.
     */
    public function edit()
    {
        $user = Auth::user();
        $employer = $user->employer ?? null;
        $company = $employer ? $employer->company : null;

        // Lấy danh sách nhân viên thuộc công ty
        $recruiters = $company
            ? NhanVienCty::where('companies_id', $company->companies_id)->get()
            : collect([]);

        return view('employer.home', compact('user', 'company', 'recruiters'));
    }

    /**
     * Cập nhật thông tin công ty (bao gồm logo và banner).
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'tencty' => 'required|string|max:255',
                'quoctich_cty' => 'nullable|string|max:100',
                'tagline_cty' => 'nullable|string|max:255',
                'quymo' => 'nullable|string|max:100',
                'mota_cty' => 'nullable|string',
                'chedodaingo' => 'nullable|string|max:1000',
                'website_cty' => 'nullable|url|max:255',
                'mxh_cty' => 'nullable|string|max:500',
                'tinh_thanh' => 'nullable|string|max:255',
                'quan_huyen' => 'nullable|string|max:255',
                'dia_chi_cu_the' => 'nullable|string|max:255',
                'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,avif|max:2048',
                'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp,avif|max:4096'
            ]);

            $user = Auth::user();

            if (!$user->employer) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tài khoản chưa được liên kết với employer!'
                ], 404);
            }

            $company = $user->employer->company;

            if (!$company) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Không tìm thấy thông tin công ty!'
                ], 404);
            }

            // Upload logo vào thư mục logo
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');

                if (!$file->isValid()) {
                    throw new \Exception('File logo không hợp lệ');
                }

                $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/avif'];
                if (!in_array($file->getMimeType(), $allowedMimes)) {
                    throw new \Exception('Định dạng file logo không được hỗ trợ');
                }

                $logoPath = public_path('assets/img/logo');
                if (!File::exists($logoPath)) {
                    File::makeDirectory($logoPath, 0755, true);
                }

                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_logo_' . uniqid() . '.' . $extension;

                $file->move($logoPath, $filename);

                if (!empty($company->logo)) {
                    $oldLogoPath = public_path('assets/img/logo/' . $company->logo);
                    if (File::exists($oldLogoPath)) {
                        File::delete($oldLogoPath);
                    }
                }

                $company->logo = 'logo/' . $filename;
                Log::info('Logo uploaded: ' . $filename);
            }

            // Upload banner vào thư mục banner
            if ($request->hasFile('banner')) {
                $file = $request->file('banner');

                if (!$file->isValid()) {
                    throw new \Exception('File banner không hợp lệ');
                }

                $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/avif'];
                if (!in_array($file->getMimeType(), $allowedMimes)) {
                    throw new \Exception('Định dạng file banner không được hỗ trợ');
                }

                $bannerPath = public_path('assets/img/banner');
                if (!File::exists($bannerPath)) {
                    File::makeDirectory($bannerPath, 0755, true);
                }

                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_banner_' . uniqid() . '.' . $extension;

                $file->move($bannerPath, $filename);

                if (!empty($company->banner)) {
                    $oldBannerPath = public_path('assets/img/banner/' . $company->banner);
                    if (File::exists($oldBannerPath)) {
                        File::delete($oldBannerPath);
                    }
                }

                $company->banner = 'banner/' . $filename;
                Log::info('Banner uploaded: ' . $filename);
            }

            // Cập nhật các thông tin khác
            $company->update([
                'tencty' => $request->tencty,
                'quoctich_cty' => $request->quoctich_cty,
                'tagline_cty' => $request->tagline_cty,
                'quymo' => $request->quymo,
                'mota_cty' => $request->mota_cty,
                'chedodaingo' => $request->chedodaingo,
                'website_cty' => $request->website_cty,
                'mxh_cty' => $request->mxh_cty,
                'tinh_thanh' => $request->tinh_thanh,
                'quan_huyen' => $request->quan_huyen,
                'dia_chi_cu_the' => $request->dia_chi_cu_the,
            ]);

            Log::info('Company updated successfully', ['company_id' => $company->companies_id]);

            return response()->json([
                'status' => 'success',
                'message' => 'Lưu thông tin công ty thành công!',
                'company' => $company->fresh()
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error: ' . json_encode($e->errors()));

            return response()->json([
                'status' => 'error',
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Company Update Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cập nhật thông tin liên hệ công ty (email, số điện thoại).
     */
    public function updateContact(Request $request)
    {
        try {
            // Validation
            $validated = $request->validate([
                'email_cty' => 'nullable|email',
                'sdt_cty' => 'nullable|string|max:20',
                'dia_chi_cu_the' => 'nullable|string|max:255',
            ]);

            // Lấy employer_id từ user hiện tại
            $employer = Auth::user()->employer; // hoặc Employer::where('user_id', auth()->id())->first();

            if (!$employer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn chưa có thông tin nhà tuyển dụng!'
                ], 404);
            }

            // Lấy company qua employer_id
            $company = Company::where('employer_id', $employer->id)->first();

            if (!$company) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy thông tin công ty!'
                ], 404);
            }

            // Cập nhật thông tin
            $company->update($validated);

            // QUAN TRỌNG: Phải return JSON để không reload trang
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thành công!',
                'data' => $company
            ]);
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Có lỗi xảy ra!');
        }
    }
    /**
     * Thêm mới nhân viên (nhà tuyển dụng phụ).
     */
    public function storeRecruiter(Request $request)
    {
        $request->validate([
            'ten_nv' => 'required|string|max:100',
            'chucvu' => 'required|string|max:50',
            'email_nv' => 'required|email|unique:nhanviencty,email_nv',
            'sdt_nv' => 'nullable|string|max:20',
            'companies_id' => 'required|integer'
        ]);

        NhanVienCty::create([
            'ten_nv' => $request->ten_nv,
            'chucvu' => $request->chucvu,
            'email_nv' => $request->email_nv,
            'sdt_nv' => $request->sdt_nv,
            'companies_id' => $request->companies_id
        ]);

        return back()->with('success', 'Thêm tài khoản nhà tuyển dụng thành công!');
    }

    /**
     * Cập nhật thông tin nhân viên.
     */
    public function updateRecruiter(Request $request, $id)
    {
        $request->validate([
            'ten_nv' => 'required|string|max:100',
            'chucvu' => 'required|string|max:50',
            'email_nv' => 'required|email|unique:nhanviencty,email_nv,' . $id . ',ma_nv',
            'sdt_nv' => 'nullable|string|max:20',
        ]);

        $recruiter = NhanVienCty::findOrFail($id);
        $recruiter->update($request->only('ten_nv', 'chucvu', 'email_nv', 'sdt_nv'));

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật nhà tuyển dụng thành công!'
        ]);
    }

    /**
     * Xóa nhân viên công ty.
     */
    public function deleteRecruiter($id)
    {
        $recruiter = NhanVienCty::findOrFail($id);
        $recruiter->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Xóa nhà tuyển dụng thành công!'
        ]);
    }
}
