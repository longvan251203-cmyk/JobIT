<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
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

            // ============ QUERY ỨNG VIÊN VỚI FILTER ============
            $query = Applicant::with(['kynang', 'hocvan', 'kinhnghiem', 'ngoaiNgu', 'user']);

            // Filter keyword (tên, vị trí, kỹ năng)
            if ($request->filled('keyword')) {
                $keyword = $request->keyword;
                $query->where(function ($q) use ($keyword) {
                    $q->where('hoten_uv', 'like', "%{$keyword}%")
                        ->orWhere('vitriungtuyen', 'like', "%{$keyword}%")
                        ->orWhereHas('kynang', function ($subQ) use ($keyword) {
                            $subQ->where('ten_ky_nang', 'like', "%{$keyword}%");
                        });
                });
            }

            // Filter location
            if ($request->filled('location')) {
                $query->where('diachi_uv', 'like', '%' . $request->location . '%');
            }

            // Filter experience
            if ($request->filled('experience')) {
                $experiences = $request->experience;
                $query->where(function ($q) use ($experiences) {
                    foreach ($experiences as $exp) {
                        if ($exp === '0') {
                            $q->orWhereDoesntHave('kinhnghiem');
                        } elseif ($exp === '0-1') {
                            $q->orWhereHas('kinhnghiem', function ($subQ) {
                                $subQ->havingRaw('COUNT(*) <= 1');
                            });
                        } elseif ($exp === '1-3') {
                            $q->orWhereHas('kinhnghiem', function ($subQ) {
                                $subQ->havingRaw('COUNT(*) BETWEEN 1 AND 3');
                            });
                        } elseif ($exp === '3-5') {
                            $q->orWhereHas('kinhnghiem', function ($subQ) {
                                $subQ->havingRaw('COUNT(*) BETWEEN 3 AND 5');
                            });
                        } elseif ($exp === '5+') {
                            $q->orWhereHas('kinhnghiem', function ($subQ) {
                                $subQ->havingRaw('COUNT(*) > 5');
                            });
                        }
                    }
                });
            }

            // Filter education
            if ($request->filled('education')) {
                $query->whereHas('hocvan', function ($q) use ($request) {
                    $q->whereIn('trinh_do', $request->education);
                });
            }

            // Filter salary
            if ($request->filled('salary')) {
                $salaries = $request->salary;
                $query->where(function ($q) use ($salaries) {
                    foreach ($salaries as $salary) {
                        [$min, $max] = explode('-', $salary . '-999');
                        if ($max === '999') {
                            $q->orWhere('mucluong_mongmuon', '>=', $min * 1000000);
                        } else {
                            $q->orWhereBetween('mucluong_mongmuon', [$min * 1000000, $max * 1000000]);
                        }
                    }
                });
            }

            // Filter language
            if ($request->filled('language')) {
                $query->whereHas('ngoaiNgu', function ($q) use ($request) {
                    $q->whereIn('ten_ngoai_ngu', $request->language);
                });
            }

            // Filter gender
            if ($request->filled('gender')) {
                $query->where('gioitinh_uv', $request->gender);
            }

            // Filter skills
            if ($request->filled('skills')) {
                $query->whereHas('kynang', function ($q) use ($request) {
                    $q->whereIn('ten_ky_nang', $request->skills);
                });
            }

            // Sort
            switch ($request->get('sort', 'newest')) {
                case 'experience':
                    $query->withCount('kinhnghiem')->orderByDesc('kinhnghiem_count');
                    break;
                case 'education':
                    $query->leftJoin('hocvan', 'applicants.id_uv', '=', 'hocvan.applicant_id')
                        ->orderByRaw("CASE 
                            WHEN hocvan.trinh_do = 'Tiến sĩ' THEN 5
                            WHEN hocvan.trinh_do = 'Thạc sĩ' THEN 4
                            WHEN hocvan.trinh_do = 'Đại học' THEN 3
                            WHEN hocvan.trinh_do = 'Cao đẳng' THEN 2
                            ELSE 1
                        END DESC")
                        ->select('applicants.*');
                    break;
                default:
                    $query->orderByDesc('created_at');
            }

            $candidates = $query->paginate(12);

            Log::info('✅ Candidates query completed', ['total' => $candidates->total()]);

            // ============ LẤY GỢI Ý ỨNG VIÊN PHÙ HỢP ============
            $recommendedApplicants = [];

            // ✅ ĐÚNG - Sửa lại trong CandidatesController@index (dòng 45-75)
            if (Auth::check() && Auth::user()->employer) {
                try {
                    $employer = Auth::user()->employer;

                    // ✅ Load relationship để chắc chắn
                    $employer->load('company');

                    $companyId = null;

                    // Thử lấy từ field companies_id
                    if (isset($employer->companies_id)) {
                        $companyId = $employer->companies_id;
                    }
                    // Hoặc từ relationship
                    elseif ($employer->company && $employer->company->id) {
                        $companyId = $employer->company->id;
                    }

                    Log::info('✅ Company ID found:', ['companies_id' => $companyId]);

                    if ($companyId) {
                        $recommendedApplicants = $this->recommendationService
                            ->getRecommendedApplicantsForCompany($companyId, 12);

                        Log::info('✅ Recommendations result:', [
                            'count' => count($recommendedApplicants),
                            'sample' => !empty($recommendedApplicants) ?
                                ['score' => $recommendedApplicants[0]['score'] ?? 'N/A'] :
                                'EMPTY'
                        ]);
                    } else {
                        Log::warning('⚠️ Company ID is NULL - No recommendations');
                        $recommendedApplicants = [];
                    }
                } catch (\Exception $e) {
                    Log::error('❌ Error getting recommendations', [
                        'message' => $e->getMessage(),
                        'line' => $e->getLine()
                    ]);
                    $recommendedApplicants = [];
                }
            } else {
                $recommendedApplicants = [];
            }
            return view('employer.candidates', compact('candidates', 'recommendedApplicants'));
        } catch (\Exception $e) {
            Log::error('❌ Error in CandidatesController@index', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString()
            ]);

            // Trả về view với data rỗng nếu có lỗi
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
                'user'
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

            // TODO: Implement PDF generation logic
            // For now, redirect to profile
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

            // TODO: Implement contact/messaging system
            // For now, show email
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
}
