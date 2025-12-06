<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\JobRecommendation;
use App\Services\JobRecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
    /**
     * Hiển thị trang gợi ý việc làm
     */
    public function index()
    {
        $applicant = Auth::user()->applicant;

        if (!$applicant) {
            return redirect()->route('home')->with('error', 'Vui lòng hoàn thiện hồ sơ');
        }

        // ✅ KIỂM TRA: Nếu chưa có recommendations hoặc dữ liệu cũ, tạo mới
        $existingCount = JobRecommendation::where('applicant_id', $applicant->id_uv)->count();

        // ✅ HOẶC kiểm tra nếu có dữ liệu cũ (position = "Chưa cập nhật")
        $hasOldData = JobRecommendation::where('applicant_id', $applicant->id_uv)
            ->whereRaw("JSON_EXTRACT(match_details, '$.position.details.applicant_position') = 'Chưa cập nhật'")
            ->exists();

        if ($existingCount === 0 || $hasOldData) {
            Log::info('🔄 Generating new recommendations', [
                'applicant_id' => $applicant->id_uv,
                'reason' => $existingCount === 0 ? 'No data' : 'Old data found'
            ]);

            // ✅ XÓA DỮ LIỆU CŨ
            JobRecommendation::where('applicant_id', $applicant->id_uv)->delete();

            // ✅ TẠO MỚI
            $this->recommendationService->generateRecommendationsForApplicant($applicant);
        }

        // Lấy recommendations với thông tin chi tiết
        $recommendations = $this->recommendationService
            ->getRecommendationsForApplicant($applicant, 20);

        // Parse match_details từ JSON
        $recommendations->transform(function ($recommendation) {
            if (is_string($recommendation->match_details)) {
                $recommendation->match_details_parsed = json_decode($recommendation->match_details, true);
            } else {
                $recommendation->match_details_parsed = $recommendation->match_details;
            }
            return $recommendation;
        });

        // Thống kê
        $stats = [
            'total' => $recommendations->count(),
            'high_match' => $recommendations->where('score', '>=', 80)->count(),
            'not_viewed' => $recommendations->where('is_viewed', false)->count(),
            'not_applied' => $recommendations->count()
        ];

        return view('applicant.recommendations', compact('recommendations', 'stats'));
    }

    /**
     * API: Làm mới danh sách gợi ý
     */
    public function refresh(Request $request)
    {
        try {
            $applicant = Applicant::where('user_id', Auth::id())->first();

            if (!$applicant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy hồ sơ ứng viên'
                ], 404);
            }

            Log::info('🔄 Starting recommendation refresh', [
                'applicant_id' => $applicant->id_uv,
                'user_id' => Auth::id(),
                'vitriungtuyen' => $applicant->vitriungtuyen
            ]);
            // ✅ XÓA RECOMMENDATIONS CŨ
            \App\Models\JobRecommendation::where('applicant_id', $applicant->id_uv)->delete();
            JobRecommendation::where('applicant_id', $applicant->id_uv)->delete();

            Log::info('🗑️ Deleted old recommendations', [
                'applicant_id' => $applicant->id_uv
            ]);

            // ✅ TẠO MỚI
            $service = new JobRecommendationService();
            $count = $service->generateRecommendationsForApplicant($applicant, 100);

            Log::info('✅ Recommendations generated', [
                'applicant_id' => $applicant->id_uv,
                'count' => $count
            ]);

            return response()->json([
                'success' => true,
                'message' => "Đã tạo {$count} gợi ý mới",
                'count' => $count
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error refreshing recommendations', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

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
