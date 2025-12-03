<?php

namespace App\Http\Controllers;

use App\Services\JobRecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobRecommendationController extends Controller
{
    protected $recommendationService;

    public function __construct(JobRecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    /**
     * Hiển thị trang gợi ý việc làm
     */
    public function index()
    {
        $applicant = Auth::user()->applicant;

        if (!$applicant) {
            return redirect()->route('home')->with('error', 'Vui lòng hoàn thiện hồ sơ');
        }

        // Tạo/cập nhật recommendations
        $this->recommendationService->generateRecommendationsForApplicant($applicant);

        // Lấy recommendations với thông tin chi tiết
        $recommendations = $this->recommendationService
            ->getRecommendationsForApplicant($applicant, 20);

        // Parse match_details từ JSON - Kiểm tra kiểu dữ liệu trước
        $recommendations->transform(function ($recommendation) {
            if (is_string($recommendation->match_details)) {
                $recommendation->match_details_parsed = json_decode($recommendation->match_details, true);
            } else {
                // Nếu đã là array thì dùng trực tiếp
                $recommendation->match_details_parsed = $recommendation->match_details;
            }
            return $recommendation;
        });

        // Thống kê
        $stats = [
            'total' => $recommendations->count(),
            'high_match' => $recommendations->where('score', '>=', 80)->count(),
            'not_viewed' => $recommendations->where('is_viewed', false)->count(),
            'not_applied' => $recommendations->count() // Tạm thời
        ];

        return view('applicant.recommendations', compact('recommendations', 'stats'));
    }

    /**
     * API: Làm mới danh sách gợi ý
     */
    public function refresh(Request $request)
    {
        $applicant = Auth::user()->applicant;

        if (!$applicant) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thông tin ứng viên'
            ], 404);
        }

        try {
            $count = $this->recommendationService
                ->generateRecommendationsForApplicant($applicant);

            return response()->json([
                'success' => true,
                'message' => "Đã tìm thấy {$count} việc làm phù hợp",
                'count' => $count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Đánh dấu đã xem recommendation
     */
    public function markAsViewed($recommendationId)
    {
        try {
            $recommendation = \App\Models\JobRecommendation::findOrFail($recommendationId);

            if ($recommendation->applicant_id != Auth::user()->applicant->id_uv) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            $recommendation->update(['is_viewed' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Đã đánh dấu xem'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Cập nhật lại recommendations sau khi thay đổi hồ sơ
     */
    public function recalculateAfterProfileUpdate(Request $request)
    {
        try {
            $applicant = Auth::user()->applicant;

            if (!$applicant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy thông tin ứng viên'
                ], 404);
            }

            // Regenerate recommendations (xóa cũ, tạo mới)
            \App\Models\JobRecommendation::where('applicant_id', $applicant->id_uv)->delete();

            $count = $this->recommendationService
                ->generateRecommendationsForApplicant($applicant);

            // Lấy top 20 recommendations mới
            $recommendations = $this->recommendationService
                ->getRecommendationsForApplicant($applicant, 20);

            // Parse match_details
            $recommendations->transform(function ($recommendation) {
                if (is_string($recommendation->match_details)) {
                    $recommendation->match_details_parsed = json_decode($recommendation->match_details, true);
                } else {
                    $recommendation->match_details_parsed = $recommendation->match_details;
                }
                return $recommendation;
            });

            // Stats mới
            $stats = [
                'total' => $recommendations->count(),
                'high_match' => $recommendations->where('score', '>=', 80)->count(),
                'not_viewed' => $recommendations->where('is_viewed', false)->count(),
                'not_applied' => $recommendations->count()
            ];

            return response()->json([
                'success' => true,
                'message' => "Đã cập nhật lại {$count} công việc phù hợp",
                'count' => $count,
                'recommendations' => $recommendations,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Lấy recommendations dạng HTML cho home page
     * Route: GET /api/recommendations/home
     */
    public function getRecommendedJobsForHome()
    {
        try {
            if (!Auth::check() || !Auth::user()->applicant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chưa đăng nhập'
                ], 401);
            }

            $applicant = Auth::user()->applicant;

            // Lấy top 6 recommendations
            $recommendedJobs = $this->recommendationService
                ->getRecommendationsForApplicant($applicant, 6);

            // Parse match_details
            $recommendedJobs->transform(function ($recommendation) {
                if (is_string($recommendation->match_details)) {
                    $recommendation->match_details_parsed = json_decode($recommendation->match_details, true);
                } else {
                    $recommendation->match_details_parsed = $recommendation->match_details;
                }
                return $recommendation;
            });

            // Render HTML từ partial view
            $html = view('applicant.partials.recommended-jobs-grid', [
                'recommendedJobs' => $recommendedJobs
            ])->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'count' => $recommendedJobs->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }
}
