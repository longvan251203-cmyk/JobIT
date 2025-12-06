<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\JobRecommendation;
use App\Services\JobRecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
    public function index()
    {
        $applicant = Auth::user()->applicant;

        if (!$applicant) {
            return redirect()->route('home')->with('error', 'Vui lòng hoàn thiện hồ sơ');
        }

        // ✅ KIỂM TRA: Nếu chưa có recommendations, tạo mới
        $existingCount = JobRecommendation::where('applicant_id', $applicant->id_uv)->count();

        if ($existingCount === 0) {
            Log::info('🔄 Generating new recommendations (first time)', [
                'applicant_id' => $applicant->id_uv,
            ]);

            $this->recommendationService->generateRecommendationsForApplicant($applicant);
        }

        // Lấy recommendations
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
            'medium_match' => $recommendations->where('score', '>=', 60)->where('score', '<', 80)->count(),
            'not_viewed' => $recommendations->where('is_viewed', false)->count(),
            'not_applied' => $recommendations->where('is_applied', false)->count()
        ];

        return view('applicant.recommendations', compact('recommendations', 'stats'));
    }

    /**
     * ✅ REFRESH: Làm mới danh sách gợi ý
     */
    public function refresh(Request $request)
    {
        try {
            $applicant = Auth::user()->applicant;

            if (!$applicant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy hồ sơ ứng viên'
                ], 404);
            }

            Log::info('🔄 Starting refresh recommendations', [
                'applicant_id' => $applicant->id_uv,
                'vitriungtuyen' => $applicant->vitriungtuyen,
                'diachi_uv' => $applicant->diachi_uv,
            ]);

            // ========== BƯỚC 1: XÓA DỮ LIỆU CŨ ==========
            $oldCount = JobRecommendation::where('applicant_id', $applicant->id_uv)->count();
            JobRecommendation::where('applicant_id', $applicant->id_uv)->delete();
            Log::info('✅ Deleted old recommendations', ['count' => $oldCount]);

            // ========== BƯỚC 2: CLEAR CACHE ==========
            // Xóa cache recommendations của user này
            $cacheKey = "recommendations_applicant_{$applicant->id_uv}";
            Cache::forget($cacheKey);
            Log::info('✅ Cache cleared', ['key' => $cacheKey]);

            // ========== BƯỚC 3: TẠO RECOMMENDATIONS MỚI ==========
            // ✅ DÙNG DEPENDENCY INJECTION từ __construct
            $newCount = $this->recommendationService
                ->generateRecommendationsForApplicant($applicant, 50);

            Log::info('✅ Generated new recommendations', [
                'applicant_id' => $applicant->id_uv,
                'count' => $newCount
            ]);

            // ========== BƯỚC 4: LẤY DỮ LIỆU MỚI ==========
            $recommendations = $this->recommendationService
                ->getRecommendationsForApplicant($applicant, 20);

            // Parse JSON
            $recommendations->transform(function ($rec) {
                if (is_string($rec->match_details)) {
                    $rec->match_details_parsed = json_decode($rec->match_details, true);
                } else {
                    $rec->match_details_parsed = $rec->match_details;
                }
                return $rec;
            });

            // ========== BƯỚC 5: TÍNH THỐNG KÊ ==========
            $stats = [
                'total' => $recommendations->count(),
                'high_match' => $recommendations->where('score', '>=', 80)->count(),
                'medium_match' => $recommendations->where('score', '>=', 60)->where('score', '<', 80)->count(),
                'low_match' => $recommendations->where('score', '<', 60)->count(),
                'not_viewed' => $recommendations->where('is_viewed', false)->count(),
            ];

            // ========== BƯỚC 6: RENDER HTML MỚI ==========
            $html = view('applicant.partials.recommendations-list', [
                'recommendations' => $recommendations,
                'stats' => $stats
            ])->render();

            Log::info('✅ Refresh completed successfully', [
                'new_count' => $newCount,
                'displayed_count' => $recommendations->count(),
                'stats' => $stats
            ]);

            return response()->json([
                'success' => true,
                'message' => "✅ Đã cập nhật {$newCount} công việc phù hợp",
                'count' => $newCount,
                'displayed_count' => $recommendations->count(),
                'recommendations' => $recommendations,
                'stats' => $stats,
                'html' => $html // ✅ THÊM HTML để frontend render
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error refreshing recommendations', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => '❌ Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Đánh dấu đã xem recommendation
     */
    public function markAsViewed($recommendationId)
    {
        try {
            $recommendation = JobRecommendation::findOrFail($recommendationId);

            // ✅ KIỂM TRA QUYỀN
            if ($recommendation->applicant_id !== Auth::user()->applicant->id_uv) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            $recommendation->update(['is_viewed' => true]);

            Log::info('✅ Recommendation marked as viewed', [
                'recommendation_id' => $recommendationId,
                'applicant_id' => $recommendation->applicant_id
            ]);

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
     * Cập nhật lại recommendations sau khi thay đổi hồ sơ
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

            Log::info('🔄 Profile updated - recalculating recommendations', [
                'applicant_id' => $applicant->id_uv,
                'updated_fields' => $request->getModifiedFields() ?? 'all'
            ]);

            // ========== XÓA CŨ, TẠO MỚI ==========
            JobRecommendation::where('applicant_id', $applicant->id_uv)->delete();

            // ✅ DÙNG DEPENDENCY INJECTION
            $count = $this->recommendationService
                ->generateRecommendationsForApplicant($applicant, 50);

            // ========== LẤY DỮ LIỆU MỚI ==========
            $recommendations = $this->recommendationService
                ->getRecommendationsForApplicant($applicant, 20);

            // Parse JSON
            $recommendations->transform(function ($rec) {
                if (is_string($rec->match_details)) {
                    $rec->match_details_parsed = json_decode($rec->match_details, true);
                } else {
                    $rec->match_details_parsed = $rec->match_details;
                }
                return $rec;
            });

            // ========== TÍNH STATS ==========
            $stats = [
                'total' => $recommendations->count(),
                'high_match' => $recommendations->where('score', '>=', 80)->count(),
                'not_viewed' => $recommendations->where('is_viewed', false)->count(),
            ];

            return response()->json([
                'success' => true,
                'message' => "✅ Đã cập nhật lại {$count} công việc phù hợp",
                'count' => $count,
                'recommendations' => $recommendations,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error recalculating', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy recommendations dạng HTML cho home page
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

            // ✅ DÙNG DEPENDENCY INJECTION
            $recommendedJobs = $this->recommendationService
                ->getRecommendationsForApplicant($applicant, 6);

            // Parse JSON
            $recommendedJobs->transform(function ($rec) {
                if (is_string($rec->match_details)) {
                    $rec->match_details_parsed = json_decode($rec->match_details, true);
                } else {
                    $rec->match_details_parsed = $rec->match_details;
                }
                return $rec;
            });

            // Render HTML
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
