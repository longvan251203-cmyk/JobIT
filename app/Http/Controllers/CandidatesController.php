<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;

class CandidatesController extends Controller
{
    public function index(Request $request)
    {
        // Start query với relationships
        $query = Applicant::with([
            'kynang',
            'hocvan',
            'kinhnghiem',
            'ngoaiNgu',
            'user'
        ]);

        // ============ SEARCH BY KEYWORD ============
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('hoten_uv', 'LIKE', "%{$keyword}%")
                    ->orWhere('chucdanh', 'LIKE', "%{$keyword}%")
                    ->orWhere('gioithieu', 'LIKE', "%{$keyword}%")
                    ->orWhereHas('kynang', function ($q) use ($keyword) {
                        $q->where('ten_ky_nang', 'LIKE', "%{$keyword}%");
                    });
            });
        }

        // ============ FILTER BY LOCATION (MỚI) ============
        if ($request->filled('location')) {
            $location = $request->location;
            $query->where('diachi_uv', 'LIKE', "%{$location}%");
        }

        // ============ FILTER BY EXPERIENCE ============
        if ($request->filled('experience')) {
            $experiences = $request->experience;
            $query->where(function ($q) use ($experiences) {
                foreach ($experiences as $exp) {
                    if ($exp === '0') {
                        $q->orWhereDoesntHave('kinhnghiem');
                    } elseif ($exp === '0-1') {
                        $q->orWhereHas('kinhnghiem', function ($q) {
                            $q->havingRaw('COUNT(*) < 1');
                        });
                    } elseif ($exp === '1-3') {
                        $q->orWhereHas('kinhnghiem', function ($q) {
                            $q->havingRaw('COUNT(*) BETWEEN 1 AND 3');
                        });
                    } elseif ($exp === '3-5') {
                        $q->orWhereHas('kinhnghiem', function ($q) {
                            $q->havingRaw('COUNT(*) BETWEEN 3 AND 5');
                        });
                    } elseif ($exp === '5+') {
                        $q->orWhereHas('kinhnghiem', function ($q) {
                            $q->havingRaw('COUNT(*) > 5');
                        });
                    }
                }
            });
        }

        // ============ FILTER BY EDUCATION ============
        if ($request->filled('education')) {
            $educations = $request->education;
            $query->whereHas('hocvan', function ($q) use ($educations) {
                $q->whereIn('trinh_do', $educations);
            });
        }

        // ============ FILTER BY SALARY ============
        if ($request->filled('salary')) {
            $salaries = $request->salary;
            $query->where(function ($q) use ($salaries) {
                foreach ($salaries as $salary) {
                    if ($salary === '0-10') {
                        $q->orWhere('mucluong_mongmuon', '<', 10000000);
                    } elseif ($salary === '10-15') {
                        $q->orWhereBetween('mucluong_mongmuon', [10000000, 15000000]);
                    } elseif ($salary === '15-20') {
                        $q->orWhereBetween('mucluong_mongmuon', [15000000, 20000000]);
                    } elseif ($salary === '20-30') {
                        $q->orWhereBetween('mucluong_mongmuon', [20000000, 30000000]);
                    } elseif ($salary === '30+') {
                        $q->orWhere('mucluong_mongmuon', '>', 30000000);
                    }
                }
            });
        }

        // ============ FILTER BY LANGUAGE ============
        if ($request->filled('language')) {
            $languages = $request->language;
            $query->whereHas('ngoaiNgu', function ($q) use ($languages) {
                $q->whereIn('ten_ngoai_ngu', $languages);
            });
        }

        // ============ FILTER BY GENDER ============
        if ($request->filled('gender')) {
            $query->where('gioitinh_uv', $request->gender);
        }

        // ============ FILTER BY SKILLS ============
        if ($request->filled('skills')) {
            $skills = $request->skills;
            $query->whereHas('kynang', function ($q) use ($skills) {
                $q->whereIn('ten_ky_nang', $skills);
            });
        }

        // ============ SORTING ============
        $sortBy = $request->get('sort', 'newest');
        switch ($sortBy) {
            case 'experience':
                $query->withCount('kinhnghiem')->orderBy('kinhnghiem_count', 'desc');
                break;
            case 'education':
                $query->join('hoc_van', 'applicants.id_uv', '=', 'hoc_van.applicant_id')
                    ->orderByRaw("FIELD(hoc_van.trinh_do, 'Tiến sĩ', 'Thạc sĩ', 'Đại học', 'Cao đẳng', 'Trung cấp')")
                    ->select('applicants.*');
                break;
            default: // newest
                $query->orderBy('applicants.created_at', 'desc');
                break;
        }

        // Pagination
        $candidates = $query->paginate(12)->withQueryString();

        return view('employer.candidates', compact('candidates'));
    }

    // ============ VIEW CANDIDATE DETAIL ============
    public function show($id)
    {
        $candidate = Applicant::with([
            'kynang',
            'hocvan',
            'kinhnghiem',
            'ngoaiNgu',
            'duan',
            'chungchi',
            'giaithuong',
            'user'
        ])->findOrFail($id);

        return response()->json($candidate);
    }

    // ============ DOWNLOAD CV ============
    public function downloadCV($id)
    {
        $candidate = Applicant::findOrFail($id);

        if (!$candidate->cv) {
            return back()->with('error', 'Ứng viên chưa tải lên CV');
        }

        $filePath = public_path('assets/cv/' . $candidate->cv);

        if (!file_exists($filePath)) {
            return back()->with('error', 'File CV không tồn tại');
        }

        return response()->download($filePath);
    }

    // ============ CONTACT CANDIDATE ============
    public function contact($id)
    {
        $candidate = Applicant::with('user')->findOrFail($id);

        // Redirect đến trang liên hệ hoặc gửi email
        return redirect()->route('employer.messages.create', [
            'recipient_id' => $candidate->user_id
        ]);
    }
}
