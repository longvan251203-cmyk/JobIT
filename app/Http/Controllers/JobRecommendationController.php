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
     * Hiển thị trang gợi ý việc làm (chỉ dùng thuật toán cũ)
     */
    public function index()
    {
        $applicant = Auth::user()->applicant;

        if (!$applicant) {
            return redirect()->route('home')->with('error', 'Vui lòng hoàn thiện hồ sơ');
        }

        // ========== Dùng thuật toán cũ ========== 
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
            'not_applied' => $recommendations->where('is_applied', false)->count(),
        ];

        return view('applicant.recommendations', [
            'recommendations' => $recommendations,
            'stats' => $stats
        ]);
    }

    /**
     * Làm mới danh sách gợi ý
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

            // XÓA DỮ LIỆU CŨ
            $oldCount = JobRecommendation::where('applicant_id', $applicant->id_uv)->count();
            JobRecommendation::where('applicant_id', $applicant->id_uv)->delete();
            Log::info('✅ Deleted old recommendations', ['count' => $oldCount]);

            // CLEAR CACHE
            $cacheKey = "recommendations_applicant_{$applicant->id_uv}";
            Cache::forget($cacheKey);
            Log::info('✅ Cache cleared', ['key' => $cacheKey]);

            // TẠO RECOMMENDATIONS MỚI
            $newCount = $this->recommendationService
                ->generateRecommendationsForApplicant($applicant, 50);

            Log::info('✅ Generated new recommendations', [
                'applicant_id' => $applicant->id_uv,
                'count' => $newCount
            ]);

            // LẤY DỮ LIỆU MỚI
            $recommendedJobs = $this->recommendationService
                ->getRecommendationsForApplicant($applicant, 20);

            // Parse JSON
            $recommendedJobs->transform(function ($rec) {
                if (is_string($rec->match_details)) {
                    $rec->match_details_parsed = json_decode($rec->match_details, true);
                } else {
                    $rec->match_details_parsed = $rec->match_details;
                }
                return $rec;
            });

            // TÍNH THỐNG KÊ
            $stats = [
                'total' => $recommendedJobs->count(),
                'high_match' => $recommendedJobs->where('score', '>=', 80)->count(),
                'medium_match' => $recommendedJobs->where('score', '>=', 60)->where('score', '<', 80)->count(),
                'not_viewed' => $recommendedJobs->where('is_viewed', false)->count(),
                'not_applied' => $recommendedJobs->where('is_applied', false)->count(),
            ];

            return response()->json([
                'success' => true,
                'count' => $recommendedJobs->count(),
                'html' => view('applicant.partials.job-cards', ['jobs' => $recommendedJobs])->render(),
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error refreshing recommendations', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi làm mới gợi ý việc làm'
            ], 500);
        }
    }
}
