<?php


namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Http\Request;

class CandidatesController extends Controller
{
    public function index(Request $request)
    {
        $query = Applicant::query();

        // Tìm kiếm theo từ khóa (tên, chức danh, kỹ năng)
        if ($request->has('keyword') && !empty($request->input('keyword'))) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('hoten_uv', 'LIKE', "%{$keyword}%")
                    ->orWhere('chucdanh', 'LIKE', "%{$keyword}%")
                    ->orWhereHas('kynang', function ($q) use ($keyword) {
                        $q->where('ten_ky_nang', 'LIKE', "%{$keyword}%");
                    });
            });
        }

        // Lọc theo địa điểm - TÌM TRONG ĐỊA CHỈ CỦA ỨNG VIÊN
        if ($request->has('location') && !empty($request->input('location'))) {
            $location = $request->input('location');
            // Tìm từ khóa trong địa chỉ ứng viên (case-insensitive)
            $query->where('diachi_uv', 'LIKE', "%{$location}%");
        }

        // Lọc theo kinh nghiệm
        if ($request->has('experience') && !empty($request->input('experience'))) {
            $experiences = (array)$request->input('experience');
            if (!empty($experiences)) {
                $query->whereHas('kinhnghiem', function ($q) use ($experiences) {
                    $q->whereIn('experience_level', $experiences);
                });
            }
        }

        // Lọc theo trình độ học vấn
        if ($request->has('education') && !empty($request->input('education'))) {
            $educations = (array)$request->input('education');
            if (!empty($educations)) {
                $query->whereHas('hocvan', function ($q) use ($educations) {
                    $q->whereIn('trinh_do', $educations);
                });
            }
        }

        // Lọc theo mức lương mong muốn
        if ($request->has('salary') && !empty($request->input('salary'))) {
            $salaries = (array)$request->input('salary');
            if (!empty($salaries)) {
                $query->whereHas('kinhnghiem', function ($q) use ($salaries) {
                    $q->whereIn('salary_range', $salaries);
                });
            }
        }

        // Lọc theo ngoại ngữ
        if ($request->has('language') && !empty($request->input('language'))) {
            $languages = (array)$request->input('language');
            if (!empty($languages)) {
                $query->whereHas('ngoai_ngu', function ($q) use ($languages) {
                    $q->whereIn('ten_ngoai_ngu', $languages);
                });
            }
        }

        // Lọc theo giới tính
        if ($request->has('gender') && !empty($request->input('gender'))) {
            $gender = $request->input('gender');
            $query->where('gioitinh_uv', $gender);
        }

        // Lọc theo kỹ năng
        if ($request->has('skills') && !empty($request->input('skills'))) {
            $skills = (array)$request->input('skills');
            if (!empty($skills)) {
                $query->whereHas('kynang', function ($q) use ($skills) {
                    $q->whereIn('ten_ky_nang', $skills);
                });
            }
        }

        // Sắp xếp
        $sort = $request->input('sort', 'newest');
        switch ($sort) {
            case 'experience':
                $query->orderByDesc('kinhnghiem_count');
                break;
            case 'education':
                $query->orderByDesc('education_level');
                break;
            case 'newest':
            default:
                $query->latest();
        }

        $candidates = $query->with(['kynang', 'hocvan', 'kinhnghiem', 'ngoai_ngu'])->paginate(12);

        return view('employer.candidates', compact('candidates'));
    }

    public function show($id)
    {
        $candidate = Applicant::with(['kynang', 'hocvan', 'kinhnghiem', 'ngoai_ngu', 'user'])->findOrFail($id);
        return response()->json($candidate);
    }
}
