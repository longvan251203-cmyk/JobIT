<?php

namespace App\Http\Controllers;

use App\Models\KyNang;
use App\Models\GiaiThuong;
use App\Models\ChungChi;
use App\Models\KinhNghiem;
use App\Models\HocVan;
use App\Models\NgoaiNgu;
use App\Models\DuAn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Applicant;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SavedJob;
use App\Models\Application;
use Illuminate\Support\Facades\Log;


class ApplicantController extends Controller
{
    // Hiển thị form chi tiết hồ sơ
    // Cập nhật method showProfileDetail
    public function showProfileDetail()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập trước.');
        }

        $applicant = DB::table('applicants')->where('user_id', $user->id)->first();

        // ✅ FIXED: Dùng Model thay vì DB::table
        $hocvan = HocVan::where('applicant_id', $applicant->id_uv)
            ->orderBy('tu_ngay', 'desc')
            ->get();

        $kinhnghiem = KinhNghiem::where('applicant_id', $applicant->id_uv)
            ->orderBy('tu_ngay', 'desc')
            ->get();

        $kynang = DB::table('ky_nang')
            ->where('applicant_id', $applicant->id_uv)
            ->get();
        $ngoaiNgu = DB::table('ngoai_ngu')
            ->where('applicant_id', $applicant->id_uv)
            ->orderBy('created_at', 'desc')
            ->get();
        $duAn = DB::table('du_an')
            ->where('applicant_id', $applicant->id_uv)
            ->orderBy('ngay_bat_dau', 'desc')
            ->get();
        $chungChi = ChungChi::where('applicant_id', $applicant->id_uv)
            ->orderBy('thoigian', 'desc')
            ->get();
        $giaiThuong = GiaiThuong::where('applicant_id', $applicant->id_uv)
            ->orderBy('thoigian', 'desc')
            ->get();
        return view('applicant.hoso', compact('user', 'applicant', 'hocvan', 'kinhnghiem', 'kynang', 'ngoaiNgu', 'duAn', 'chungChi', 'giaiThuong'));
    }

    // Cập nhật hồ sơ
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập trước.');
        }

        $request->validate([
            'hoten_uv' => 'required|string|max:255',
            'chucdanh' => 'nullable|string|max:255',
            'ngaysinh' => 'nullable|date',
            'sdt_uv' => 'nullable|string|max:20',
            'gioitinh_uv' => 'nullable|string|max:10',
            'diachi_uv' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $updateData = [
            'hoten_uv'   => $request->hoten_uv,
            'chucdanh'   => $request->chucdanh,
            'ngaysinh'   => $request->ngaysinh,
            'sdt_uv'     => $request->sdt_uv,
            'gioitinh_uv' => $request->gioitinh_uv,
            'diachi_uv'  => $request->diachi_uv,
            'updated_at' => now(),
        ];

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img/avt'), $filename);

            $oldAvatar = DB::table('applicants')->where('user_id', $user->id)->value('avatar');
            if ($oldAvatar && file_exists(public_path('assets/img/avt/' . $oldAvatar))) {
                unlink(public_path('assets/img/avt/' . $oldAvatar));
            }

            $updateData['avatar'] = $filename;
        }

        DB::table('applicants')->where('user_id', $user->id)->update($updateData);

        return redirect()->route('applicant.hoso')->with('success', 'Cập nhật hồ sơ thành công!');
    }

    public function updateGioiThieu(Request $request)
    {
        $request->validate([
            'gioithieu' => 'nullable|string',
        ]);

        $user = Auth::user();

        DB::table('applicants')
            ->where('user_id', $user->id)
            ->update([
                'gioithieu' => $request->gioithieu,
                'updated_at' => now(),
            ]);

        return redirect()->route('applicant.hoso')->with('success', 'Cập nhật giới thiệu bản thân thành công!');
    }

    // ============ HỌC VẤN ============

    public function hoSo()
    {
        $user = Auth::user();
        $applicant = $user->applicant;

        $hocvan = HocVan::where('applicant_id', $applicant->id_uv)
            ->orderBy('tu_ngay', 'desc')
            ->get();

        $kinhnghiem = DB::table('kinh_nghiem')
            ->where('applicant_id', $applicant->id_uv)
            ->orderBy('tu_ngay', 'desc')
            ->get();

        $kynang = DB::table('ky_nang')
            ->where('applicant_id', $applicant->id_uv)
            ->get();

        $ngoaiNgu = DB::table('ngoai_ngu')
            ->where('applicant_id', $applicant->id_uv)
            ->orderBy('created_at', 'desc')
            ->get();
        $duAn = DB::table('du_an')
            ->where('applicant_id', $applicant->id_uv)
            ->orderBy('ngay_bat_dau', 'desc')
            ->get();
        $chungChi = DB::table('chung_chi')
            ->where('applicant_id', $applicant->id_uv)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('applicant.hoso', compact('applicant', 'hocvan', 'kinhnghiem', 'kynang', 'ngoaiNgu', 'duAn', 'chungChi'));
    }
    // ========== STORE - THÊM MỚI GIẢI THƯỞNG ==========
    public function storeGiaiThuong(Request $request)
    {
        $request->validate([
            'ten_giaithuong' => 'required|string|max:255',
            'to_chuc' => 'required|string|max:255',
            'thang' => 'required|integer|min:1|max:12',
            'nam' => 'required|integer',
            'mo_ta' => 'nullable|string|max:1000',
        ]);

        $thoigian = $request->nam . '-' . str_pad($request->thang, 2, '0', STR_PAD_LEFT) . '-01';

        GiaiThuong::create([
            'applicant_id' => Auth::user()->applicant->id_uv,
            'ten_giaithuong' => $request->ten_giaithuong,
            'to_chuc' => $request->to_chuc,
            'thoigian' => $thoigian,
            'mo_ta' => $request->mo_ta,
        ]);

        return redirect()->back()->with('success', 'Đã thêm giải thưởng thành công!');
    }

    // ========== EDIT - LẤY DỮ LIỆU ĐỂ SỬA ==========
    public function editGiaiThuong($id)
    {
        $giaiThuong = GiaiThuong::where('id_giaithuong', $id)
            ->where('applicant_id', Auth::user()->applicant->id_uv)
            ->firstOrFail();

        return response()->json($giaiThuong);
    }

    // ========== UPDATE - CẬP NHẬT GIẢI THƯỞNG ==========
    public function updateGiaiThuong(Request $request, $id)
    {
        $request->validate([
            'ten_giaithuong' => 'required|string|max:255',
            'to_chuc' => 'required|string|max:255',
            'thang' => 'required|integer|min:1|max:12',
            'nam' => 'required|integer',
            'mo_ta' => 'nullable|string|max:1000',
        ]);

        $giaiThuong = GiaiThuong::where('id_giaithuong', $id)
            ->where('applicant_id', Auth::user()->applicant->id_uv)
            ->firstOrFail();

        $thoigian = $request->nam . '-' . str_pad($request->thang, 2, '0', STR_PAD_LEFT) . '-01';

        $giaiThuong->update([
            'ten_giaithuong' => $request->ten_giaithuong,
            'to_chuc' => $request->to_chuc,
            'thoigian' => $thoigian,
            'mo_ta' => $request->mo_ta,
        ]);

        return redirect()->back()->with('success', 'Cập nhật giải thưởng thành công!');
    }

    // ========== DELETE - XÓA GIẢI THƯỞNG ==========
    public function deleteGiaiThuong($id)
    {
        $giaiThuong = GiaiThuong::where('id_giaithuong', $id)
            ->where('applicant_id', Auth::user()->applicant->id_uv)
            ->firstOrFail();

        $giaiThuong->delete();

        return redirect()->back()->with('success', 'Đã xóa giải thưởng!');
    }
    // CHỨNG CHỈ
    // ========== STORE - THÊM MỚI CHỨNG CHỈ ==========
    public function storeChungChi(Request $request)
    {
        $request->validate([
            'to_chuc' => 'required|string|max:255',
            'thang' => 'required|integer|min:1|max:12',
            'nam' => 'required|integer',
            'link_chungchi' => 'nullable|url|max:500',
            'mo_ta' => 'nullable|string|max:1000',
        ]);

        $thoigian = $request->nam . '-' . str_pad($request->thang, 2, '0', STR_PAD_LEFT) . '-01';

        ChungChi::create([
            'applicant_id' => Auth::user()->applicant->id_uv,
            'ten_chungchi' => $request->to_chuc, // Hoặc có thể thêm field riêng
            'to_chuc' => $request->to_chuc,
            'thoigian' => $thoigian,
            'link_chungchi' => $request->link_chungchi,
            'mo_ta' => $request->mo_ta,
        ]);

        return redirect()->back()->with('success', 'Đã thêm chứng chỉ thành công!');
    }

    // ========== EDIT - LẤY DỮ LIỆU ĐỂ SỬA ==========
    public function editChungChi($id)
    {
        $chungChi = ChungChi::where('id_chungchi', $id)
            ->where('applicant_id', Auth::user()->applicant->id_uv)
            ->firstOrFail();

        return response()->json($chungChi);
    }

    // ========== UPDATE - CẬP NHẬT CHỨNG CHỈ ==========
    public function updateChungChi(Request $request, $id)
    {
        $request->validate([
            'to_chuc' => 'required|string|max:255',
            'thang' => 'required|integer|min:1|max:12',
            'nam' => 'required|integer',
            'link_chungchi' => 'nullable|url|max:500',
            'mo_ta' => 'nullable|string|max:1000',
        ]);

        $chungChi = ChungChi::where('id_chungchi', $id)
            ->where('applicant_id', Auth::user()->applicant->id_uv)
            ->firstOrFail();

        $thoigian = $request->nam . '-' . str_pad($request->thang, 2, '0', STR_PAD_LEFT) . '-01';

        $chungChi->update([
            'ten_chungchi' => $request->to_chuc,
            'to_chuc' => $request->to_chuc,
            'thoigian' => $thoigian,
            'link_chungchi' => $request->link_chungchi,
            'mo_ta' => $request->mo_ta,
        ]);

        return redirect()->back()->with('success', 'Cập nhật chứng chỉ thành công!');
    }

    // ========== DELETE - XÓA CHỨNG CHỈ ==========
    public function deleteChungChi($id)
    {
        $chungChi = ChungChi::where('id_chungchi', $id)
            ->where('applicant_id', Auth::user()->applicant->id_uv)
            ->firstOrFail();

        $chungChi->delete();

        return redirect()->back()->with('success', 'Đã xóa chứng chỉ!');
    }

    // ============ DỰ ÁN ============
    public function storeDuAn(Request $request)
    {
        $request->validate([
            'ten_duan' => 'required|string|max:255',
            'thang_bat_dau' => 'required|integer|min:1|max:12',
            'nam_bat_dau' => 'required|integer',
            'mota_duan' => 'nullable|string|max:2500',
            'duongdan_website' => 'nullable|url',
        ]);

        $ngayBatDau = $request->nam_bat_dau . '-' . str_pad($request->thang_bat_dau, 2, '0', STR_PAD_LEFT) . '-01';

        $ngayKetThuc = null;
        if (!$request->dang_lam && $request->thang_ket_thuc && $request->nam_ket_thuc) {
            $ngayKetThuc = $request->nam_ket_thuc . '-' . str_pad($request->thang_ket_thuc, 2, '0', STR_PAD_LEFT) . '-01';
        }

        DuAn::create([
            'applicant_id' => Auth::user()->applicant->id_uv,
            'ten_duan' => $request->ten_duan,
            'ngay_bat_dau' => $ngayBatDau,
            'ngay_ket_thuc' => $ngayKetThuc,
            'mota_duan' => $request->mota_duan,
            'duongdan_website' => $request->duongdan_website,
            'dang_lam' => $request->has('dang_lam'),
        ]);

        return redirect()->back()->with('success', 'Đã thêm dự án thành công!');
    }

    public function editDuAn($id)
    {
        $duAn = DuAn::where('id_duan', $id)
            ->where('applicant_id', Auth::user()->applicant->id_uv)
            ->firstOrFail();

        return response()->json($duAn);
    }

    public function updateDuAn(Request $request, $id)
    {
        $request->validate([
            'ten_duan' => 'required|string|max:255',
            'thang_bat_dau' => 'required|integer|min:1|max:12',
            'nam_bat_dau' => 'required|integer',
            'mota_duan' => 'nullable|string|max:2500',
            'duongdan_website' => 'nullable|url',
        ]);

        $duAn = DuAn::where('id_duan', $id)
            ->where('applicant_id', Auth::user()->applicant->id_uv)
            ->firstOrFail();

        $ngayBatDau = $request->nam_bat_dau . '-' . str_pad($request->thang_bat_dau, 2, '0', STR_PAD_LEFT) . '-01';

        $ngayKetThuc = null;
        if (!$request->dang_lam && $request->thang_ket_thuc && $request->nam_ket_thuc) {
            $ngayKetThuc = $request->nam_ket_thuc . '-' . str_pad($request->thang_ket_thuc, 2, '0', STR_PAD_LEFT) . '-01';
        }

        $duAn->update([
            'ten_duan' => $request->ten_duan,
            'ngay_bat_dau' => $ngayBatDau,
            'ngay_ket_thuc' => $ngayKetThuc,
            'mota_duan' => $request->mota_duan,
            'duongdan_website' => $request->duongdan_website,
            'dang_lam' => $request->has('dang_lam'),
        ]);

        return redirect()->back()->with('success', 'Cập nhật dự án thành công!');
    }

    public function deleteDuAn($id)
    {
        $duAn = DuAn::where('id_duan', $id)
            ->where('applicant_id', Auth::user()->applicant->id_uv)
            ->firstOrFail();

        $duAn->delete();

        return redirect()->back()->with('success', 'Đã xóa dự án!');
    }
    public function storeHocVan(Request $request)
    {
        $request->validate([
            'truong' => 'required|string|max:255',
            'trinhdo' => 'required|string',
            'nganh' => 'required|string|max:255',
            'tu_ngay' => 'required|date',
            'den_ngay' => 'nullable|date',
        ]);

        $user = Auth::user();

        HocVan::create([
            'applicant_id'  => $user->applicant->id_uv,
            'truong'        => $request->truong,
            'trinhdo'       => $request->trinhdo,
            'nganh'         => $request->nganh,
            'dang_hoc'      => $request->dang_hoc ? 1 : 0,
            'tu_ngay'       => $request->tu_ngay,
            'den_ngay'      => $request->dang_hoc ? null : $request->den_ngay,
            'thongtin_khac' => $request->thongtin_khac,
        ]);

        return redirect()->route('applicant.hoso')->with('success', 'Thêm học vấn thành công!');
    }

    public function editHocVan($id)
    {
        $hocvan = HocVan::findOrFail($id);

        if ($hocvan->applicant_id !== Auth::user()->applicant->id_uv) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($hocvan);
    }

    public function updateHocVan(Request $request, $id)
    {
        $request->validate([
            'truong' => 'required|string|max:255',
            'trinhdo' => 'required|string|max:255',
            'nganh' => 'required|string|max:255',
            'tu_ngay' => 'required|date',
            'den_ngay' => 'nullable|date',
        ]);

        $hocvan = HocVan::findOrFail($id);

        if ($hocvan->applicant_id !== Auth::user()->applicant->id_uv) {
            return redirect()->route('applicant.hoso')->with('error', 'Bạn không có quyền cập nhật học vấn này!');
        }

        $hocvan->update([
            'truong' => $request->truong,
            'trinhdo' => $request->trinhdo,
            'nganh' => $request->nganh,
            'dang_hoc' => $request->dang_hoc ? 1 : 0,
            'tu_ngay' => $request->tu_ngay,
            'den_ngay' => $request->dang_hoc ? null : $request->den_ngay,
            'thongtin_khac' => $request->thongtin_khac,
        ]);

        return redirect()->route('applicant.hoso')->with('success', 'Cập nhật học vấn thành công!');
    }

    public function deleteHocVan($id)
    {
        $hocvan = HocVan::findOrFail($id);

        if ($hocvan->applicant_id !== Auth::user()->applicant->id_uv) {
            return redirect()->route('applicant.hoso')->with('error', 'Bạn không có quyền xóa học vấn này!');
        }

        $hocvan->delete();

        return redirect()->route('applicant.hoso')->with('success', 'Xóa học vấn thành công!');
    }

    // ============ KINH NGHIỆM ============
    // Trong ApplicantController.php - Sửa method storeKinhnghiem
    public function storeKinhnghiem(Request $request)
    {
        $request->validate([
            'chucdanh' => 'required|string|max:255',
            'congty' => 'required|string|max:255',
            'tu_ngay' => 'required|date',
            'den_ngay' => 'nullable|date',
            'mota' => 'nullable|string',
            'duan' => 'nullable|string',
        ]);

        $user = Auth::user();

        KinhNghiem::create([
            'applicant_id' => $user->applicant->id_uv,
            'chucdanh' => $request->chucdanh,
            'congty' => $request->congty,
            'dang_lam_viec' => $request->dang_lam_viec ? 1 : 0,
            'tu_ngay' => date('Y-m-d', strtotime($request->tu_ngay)),
            'den_ngay' => $request->dang_lam_viec ? null : ($request->den_ngay ? date('Y-m-d', strtotime($request->den_ngay)) : null),
            'mota' => $request->mota,
            'duan' => $request->duan,
        ]);



        return redirect()->route('applicant.hoso')->with('success', 'Thêm kinh nghiệm thành công!');
    }
    public function editKinhnghiem($id)
    {
        try {
            $kinhnghiem = KinhNghiem::findOrFail($id);

            // Sửa từ id_uv thành applicant_id (theo Model)
            if ($kinhnghiem->applicant_id !== Auth::user()->applicant->id_uv) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            return response()->json($kinhnghiem);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Không tìm thấy kinh nghiệm'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }
    public function updateKinhnghiem(Request $request, $id)
    {
        $request->validate([
            'chucdanh' => 'required|string|max:255',
            'congty' => 'required|string|max:255',
            'tu_ngay' => 'required|date',
            'den_ngay' => 'nullable|date',
            'mota' => 'nullable|string',
            'duan' => 'nullable|string',
        ]);

        $kinhnghiem = KinhNghiem::findOrFail($id);

        if ($kinhnghiem->applicant_id !== Auth::user()->applicant->id_uv) {
            return redirect()->route('applicant.hoso')->with('error', 'Bạn không có quyền cập nhật kinh nghiệm này!');
        }

        $kinhnghiem->update([
            'chucdanh' => $request->chucdanh,
            'congty' => $request->congty,
            'dang_lam_viec' => $request->dang_lam_viec ? 1 : 0,
            'tu_ngay' => $request->tu_ngay,
            'den_ngay' => $request->dang_lam_viec ? null : $request->den_ngay,
            'mota' => $request->mota,
            'duan' => $request->duan,
        ]);

        return redirect()->route('applicant.hoso')->with('success', 'Cập nhật kinh nghiệm thành công!');
    }

    public function deleteKinhnghiem($id)
    {
        $kinhnghiem = KinhNghiem::findOrFail($id);

        if ($kinhnghiem->applicant_id !== Auth::user()->applicant->id_uv) {
            return redirect()->route('applicant.hoso')->with('error', 'Bạn không có quyền xóa kinh nghiệm này!');
        }

        $kinhnghiem->delete();

        return redirect()->route('applicant.hoso')->with('success', 'Xóa kinh nghiệm thành công!');
    }

    // ============ KỸ NĂNG ============
    /**
     * Xóa kỹ năng - RETURN JSON cho AJAX
     */
    public function deleteKyNang($id)
    {
        try {
            Log::info('=== XÓA KỸ NĂNG ===');
            Log::info('ID nhận: ' . $id);

            $user = Auth::user();

            if (!$user || !$user->applicant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy thông tin ứng viên'
                ], 404);
            }

            Log::info('Applicant ID: ' . $user->applicant->id_uv);

            // Tìm kỹ năng theo ID
            $kyNang = KyNang::where('id', $id)
                ->where('applicant_id', $user->applicant->id_uv)
                ->first();

            if (!$kyNang) {
                Log::warning('Không tìm thấy kỹ năng với ID: ' . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy kỹ năng'
                ], 404);
            }

            // Xóa
            $kyNang->delete();

            Log::info('✅ Đã xóa kỹ năng thành công!');

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa kỹ năng thành công'
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Lỗi xóa kỹ năng: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Lưu kỹ năng mới (nhiều kỹ năng cùng lúc)
     */
    public function storeKyNang(Request $request)
    {
        $request->validate([
            'ten_ky_nang' => 'required|array|min:1',
            'ten_ky_nang.*' => 'required|string|max:100',
            'nam_kinh_nghiem' => 'required|array|min:1',
            'nam_kinh_nghiem.*' => 'required'
        ], [
            'ten_ky_nang.required' => 'Vui lòng nhập ít nhất một kỹ năng',
            'ten_ky_nang.*.required' => 'Tên kỹ năng không được để trống',
            'nam_kinh_nghiem.required' => 'Vui lòng chọn năm kinh nghiệm',
        ]);

        try {
            $tenKyNang = $request->ten_ky_nang;
            $namKinhNghiem = $request->nam_kinh_nghiem;

            // Lưu từng kỹ năng
            foreach ($tenKyNang as $index => $ten) {
                // Kiểm tra trùng lặp
                $exists = KyNang::where('applicant_id', Auth::user()->id_uv)
                    ->where('ten_ky_nang', $ten)
                    ->exists();

                if (!$exists) {
                    KyNang::create([
                        'applicant_id' => Auth::user()->id_uv,
                        'ten_ky_nang' => $ten,
                        'nam_kinh_nghiem' => $namKinhNghiem[$index] ?? 0,
                        'mo_ta' => null // Có thể thêm mô tả sau
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Đã thêm kỹ năng thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi khi lưu kỹ năng: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi lưu kỹ năng!');
        }
    }

    // ============ AVATAR & CV ============

    public function deleteAvatar()
    {
        $user = Auth::user();
        $applicant = DB::table('applicants')->where('user_id', $user->id)->first();

        if ($applicant && $applicant->avatar && file_exists(public_path('assets/img/avt/' . $applicant->avatar))) {
            unlink(public_path('assets/img/avt/' . $applicant->avatar));
        }

        DB::table('applicants')
            ->where('user_id', $user->id)
            ->update([
                'avatar' => null,
                'updated_at' => now(),
            ]);

        return redirect()->back()->with('success', 'Đã xóa avatar thành công.');
    }

    public function uploadCv(Request $request)
    {
        $request->validate([
            'cv' => 'required|mimes:pdf,doc,docx|max:5120',
        ]);

        $user = Auth::user();
        $applicant = DB::table('applicants')->where('user_id', $user->id)->first();

        if ($applicant && $applicant->cv) {
            $oldPath = public_path('assets/cv/' . $applicant->cv);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }

        $file = $request->file('cv');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('assets/cv'), $fileName);

        DB::table('applicants')->where('user_id', $user->id)->update([
            'cv' => $fileName,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Tải CV lên thành công.');
    }

    public function viewCv()
    {
        $user = Auth::user();
        $applicant = DB::table('applicants')->where('user_id', $user->id)->first();

        if (!$applicant || !$applicant->cv) {
            return back()->with('error', 'Bạn chưa upload CV.');
        }

        $filePath = public_path('assets/cv/' . $applicant->cv);

        if (!File::exists($filePath)) {
            return back()->with('error', 'CV không tồn tại.');
        }

        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        if ($extension === 'pdf') {
            return response()->file($filePath);
        } else {
            return response()->download($filePath);
        }
    }

    public function deleteCv()
    {
        $user = Auth::user();
        $applicant = DB::table('applicants')->where('user_id', $user->id)->first();

        if ($applicant && $applicant->cv) {
            $filePath = public_path('assets/cv/' . $applicant->cv);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            DB::table('applicants')->where('user_id', $user->id)->update([
                'cv' => null,
                'updated_at' => now(),
            ]);
        }

        return back()->with('success', 'Đã xoá CV thành công.');
    }

    public function downloadCV($id)
    {
        $applicant = Applicant::with(['hocvan', 'kinhnghiem', 'kynang'])->findOrFail($id);
        $pdf = Pdf::loadView('applicant.cv_pdf', compact('applicant'));
        return $pdf->download($applicant->hoten_uv . '_CV.pdf');
    }
    // ============ XEM CV ============

    public function showApplicantCV($id)
    {
        // Lấy thông tin ứng viên theo id
        $applicant = DB::table('applicants')->where('id_uv', $id)->first();

        if (!$applicant) {
            return redirect()->back()->with('error', 'Không tìm thấy ứng viên.');
        }

        // Lấy TẤT CẢ dữ liệu liên quan
        $hocvan = HocVan::where('applicant_id', $id)
            ->orderBy('tu_ngay', 'desc')
            ->get();

        $kinhnghiem = KinhNghiem::where('applicant_id', $id)
            ->orderBy('tu_ngay', 'desc')
            ->get();

        $kynang = DB::table('ky_nang')
            ->where('applicant_id', $id)
            ->get();

        $ngoaiNgu = DB::table('ngoai_ngu')
            ->where('applicant_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        $duAn = DB::table('du_an')
            ->where('applicant_id', $id)
            ->orderBy('ngay_bat_dau', 'desc')
            ->get();

        $chungChi = ChungChi::where('applicant_id', $id)
            ->orderBy('thoigian', 'desc')
            ->get();

        $giaiThuong = GiaiThuong::where('applicant_id', $id)
            ->orderBy('thoigian', 'desc')
            ->get();

        // Trả về view chứa modal xem CV với ĐẦY ĐỦ dữ liệu
        return view('home', compact(
            'applicant',
            'hocvan',
            'kinhnghiem',
            'kynang',
            'ngoaiNgu',
            'duAn',
            'chungChi',
            'giaiThuong'
        ));
    }
    // Thêm method myJobs
    public function myJobs()
    {
        $applicant = Auth::user()->applicant;

        if (!$applicant) {
            return redirect()->route('applicant.profile')->with('error', 'Vui lòng cập nhật thông tin cá nhân trước!');
        }

        // Lấy danh sách đã ứng tuyển
        $applications = Application::where('applicant_id', $applicant->id_uv)
            ->with(['job.company', 'job.hashtags'])
            ->orderBy('ngay_ung_tuyen', 'desc')
            ->get();

        // Lấy danh sách đã lưu
        $savedJobs = SavedJob::where('applicant_id', $applicant->id_uv)
            ->with(['job.company', 'job.hashtags'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('applicant.my-jobs', compact('applications', 'savedJobs', 'applicant'));
    }

    // Lưu công việc
    public function saveJob($jobId)
    {
        try {
            $applicant = Auth::user()->applicant;

            if (!$applicant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng cập nhật thông tin cá nhân trước!'
                ], 403);
            }

            // Kiểm tra đã lưu chưa
            $exists = SavedJob::where('applicant_id', $applicant->id_uv)
                ->where('job_id', $jobId)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã lưu công việc này rồi!'
                ], 422);
            }

            SavedJob::create([
                'applicant_id' => $applicant->id_uv,
                'job_id' => $jobId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Đã lưu công việc!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    // Bỏ lưu công việc
    public function unsaveJob($jobId)
    {
        try {
            $applicant = Auth::user()->applicant;

            $deleted = SavedJob::where('applicant_id', $applicant->id_uv)
                ->where('job_id', $jobId)
                ->delete();

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Đã bỏ lưu công việc!'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy công việc đã lưu!'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
    // Thêm method này vào ApplicantController

    /**
     * Lấy danh sách job_id đã lưu của user (dùng cho JavaScript)
     */
    public function getSavedJobIds()
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'savedJobIds' => []
                ]);
            }

            $applicant = Auth::user()->applicant;

            if (!$applicant) {
                return response()->json([
                    'success' => false,
                    'savedJobIds' => []
                ]);
            }

            $savedJobIds = SavedJob::where('applicant_id', $applicant->id_uv)
                ->pluck('job_id')
                ->toArray();

            return response()->json([
                'success' => true,
                'savedJobIds' => $savedJobIds
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting saved jobs: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'savedJobIds' => []
            ]);
        }
    }

     // ============ NGOẠI NGỮ ============

    /**
     * Lưu nhiều ngoại ngữ cùng lúc
     */
    public function storeNgoaiNgu(Request $request)
    {
        // Validate
        $request->validate([
            'ten_ngoai_ngu' => 'required|array|min:1',
            'ten_ngoai_ngu.*' => 'required|string|max:255',
            'trinh_do' => 'required|array|min:1',
            'trinh_do.*' => 'required|string|max:50',
        ], [
            'ten_ngoai_ngu.required' => 'Vui lòng chọn ít nhất một ngoại ngữ',
            'ten_ngoai_ngu.*.required' => 'Tên ngoại ngữ không được để trống',
            'trinh_do.required' => 'Vui lòng chọn trình độ cho từng ngoại ngữ',
            'trinh_do.*.required' => 'Trình độ không được để trống',
        ]);

        try {
            $user = Auth::user();
            $applicant = $user->applicant;

            if (!$applicant) {
                return redirect()->back()->with('error', 'Không tìm thấy thông tin ứng viên!');
            }

            $tenNgoaiNgu = $request->ten_ngoai_ngu;
            $trinhDo = $request->trinh_do;

            $added = 0;
            $skipped = 0;

            // Lưu từng ngoại ngữ
            for ($i = 0; $i < count($tenNgoaiNgu); $i++) {
                // Kiểm tra trùng lặp
                $exists = NgoaiNgu::where('applicant_id', $applicant->id_uv)
                    ->where('ten_ngoai_ngu', $tenNgoaiNgu[$i])
                    ->exists();

                if (!$exists) {
                    NgoaiNgu::create([
                        'applicant_id' => $applicant->id_uv,
                        'ten_ngoai_ngu' => $tenNgoaiNgu[$i],
                        'trinh_do' => $trinhDo[$i],
                    ]);
                    $added++;
                } else {
                    $skipped++;
                }
            }

            if ($added > 0 && $skipped > 0) {
                return redirect()->route('applicant.hoso')
                    ->with('success', "Đã thêm {$added} ngoại ngữ thành công! ({$skipped} ngoại ngữ bị trùng)");
            } elseif ($added > 0) {
                return redirect()->route('applicant.hoso')
                    ->with('success', "Đã thêm {$added} ngoại ngữ thành công!");
            } else {
                return redirect()->route('applicant.hoso')
                    ->with('info', 'Tất cả ngoại ngữ đã tồn tại trong hồ sơ của bạn!');
            }
        } catch (\Exception $e) {
            Log::error('Error storing ngoai ngu: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Xóa ngoại ngữ
     */
    /**
     * Xóa ngoại ngữ - PHIÊN BẢN HOÀN CHỈNH
     */
    public function deleteNgoaiNgu($id)
    {
        try {
            Log::info('=== XÓA NGOẠI NGỮ ===');
            Log::info('ID nhận: ' . $id);

            $user = Auth::user();
            $applicant = $user->applicant;

            if (!$applicant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy thông tin ứng viên'
                ], 404);
            }

            Log::info('Applicant ID: ' . $applicant->id_uv);

            // ✅ CHỈ DÙNG ngoai_ngu_id, KHÔNG DÙNG id
            $deleted = DB::table('ngoai_ngu')
                ->where('applicant_id', $applicant->id_uv)
                ->where('ngoai_ngu_id', $id)
                ->delete();

            Log::info('Số bản ghi đã xóa: ' . $deleted);

            if ($deleted > 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Đã xóa ngoại ngữ thành công'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy ngoại ngữ'
                ], 404);
            }
        } catch (\Exception $e) {
            Log::error('Lỗi xóa: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }
}
