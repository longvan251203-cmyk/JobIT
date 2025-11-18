<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobPost;
use App\Models\HocVan;
use App\Models\KinhNghiem;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $jobs = JobPost::with(['company', 'hashtags', 'detail'])->get();

        // Trả về home.blade.php cho route gốc '/'
        return view('home', [
            'jobs' => $jobs,
            'showLogin' => $request->get('showLogin', false),
        ]);
    }

    // Phương thức Dashboard của Applicant
    public function applicantDashboard()
    {
        $jobs = JobPost::with(['company', 'hashtags', 'detail'])->get();

        // ✅ Lấy thông tin applicant và các dữ liệu liên quan
        $applicant = null;
        $hocvan = collect();
        $kinhnghiem = collect();
        $kynang = collect();

        if (Auth::check() && Auth::user()->applicant) {
            $applicant = Auth::user()->applicant;

            // Lấy học vấn
            $hocvan = HocVan::where('applicant_id', $applicant->id_uv)
                ->orderBy('tu_ngay', 'desc')
                ->get();

            // Lấy kinh nghiệm
            $kinhnghiem = KinhNghiem::where('applicant_id', $applicant->id_uv)
                ->orderBy('tu_ngay', 'desc')
                ->get();

            // Lấy kỹ năng
            $kynang = DB::table('ky_nang')
                ->where('applicant_id', $applicant->id_uv)
                ->get();
        }

        // Trả về view với đầy đủ dữ liệu
        return view('applicant.homeapp', [
            'jobs' => $jobs,
            'showLogin' => false,
            'applicant' => $applicant,
            'hocvan' => $hocvan,
            'kinhnghiem' => $kinhnghiem,
            'kynang' => $kynang,
        ]);
    }
}
