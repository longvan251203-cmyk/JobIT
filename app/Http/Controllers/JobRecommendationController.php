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

        // ✅ Kiểm tra: Nếu chưa có recommendations, tạo mới
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
            $cacheKey = "recommendations_applicant_{$applicant->id_uv}";
            Cache::forget($cacheKey);
            Log::info('✅ Cache cleared', ['key' => $cacheKey]);

            // ========== BƯỚC 3: TẠO RECOMMENDATIONS MỚI ==========
            $newCount = $this->recommendationService
                ->generateRecommendationsForApplicant($applicant, 50);

            Log::info('✅ Generated new recommendations', [
                'applicant_id' => $applicant->id_uv,
                'count' => $newCount
            ]);

            // ========== BƯỚC 4: LẤY DỮ LIỆU MỚI ==========
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

            // ========== BƯỚC 5: TÍNH THỐNG KÊ ==========
            $stats = [
                'total' => $recommendedJobs->count(),
                'high_match' => $recommendedJobs->where('score', '>=', 80)->count(),
                'medium_match' => $recommendedJobs->where('score', '>=', 60)->where('score', '<', 80)->count(),
                'low_match' => $recommendedJobs->where('score', '<', 60)->count(),
                'not_viewed' => $recommendedJobs->where('is_viewed', false)->count(),
            ];

            // ========== BƯỚC 6: RENDER HTML MỚI ==========
            // ✅ FIX: Dùng đúng tên biến $recommendedJobs thay vì $recommendations
            $html = view('applicant.partials.recommendations-list', [
                'recommendedJobs' => $recommendedJobs,  // ← ĐÃ SỬA
                'stats' => $stats
            ])->render();

            Log::info('✅ Refresh completed successfully', [
                'new_count' => $newCount,
                'displayed_count' => $recommendedJobs->count(),
                'stats' => $stats
            ]);

            return response()->json([
                'success' => true,
                'message' => "✅ Đã cập nhật {$newCount} công việc phù hợp",
                'count' => $newCount,
                'displayed_count' => $recommendedJobs->count(),
                'recommendations' => $recommendedJobs,
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
    public function recalculate(Request $request)
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

            $count = $this->recommendationService
                ->generateRecommendationsForApplicant($applicant, 50);

            // ========== LẤY DỮ LIỆU MỚI ==========
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

            // ========== TÍNH STATS ==========
            $stats = [
                'total' => $recommendedJobs->count(),
                'high_match' => $recommendedJobs->where('score', '>=', 80)->count(),
                'not_viewed' => $recommendedJobs->where('is_viewed', false)->count(),
            ];

            return response()->json([
                'success' => true,
                'message' => "✅ Đã cập nhật lại {$count} công việc phù hợp",
                'count' => $count,
                'recommendations' => $recommendedJobs,
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
     * ✅ Lấy recommendations dạng HTML cho home page
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

            // Lấy 6 gợi ý top
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
            Log::error('❌ Error getting recommendations for home', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ Recalculate recommendations khi job được update
     * Xóa recommendations cũ của job này từ tất cả ứng viên
     */
    public function recalculateForJob($jobId)
    {
        try {
            // Kiểm tra job tồn tại
            $job = \App\Models\JobPost::where('job_id', $jobId)->firstOrFail();

            Log::info('🔄 Recalculating recommendations for job', [
                'job_id' => $jobId,
                'title' => $job->title
            ]);

            // Xóa tất cả recommendations cũ của job này
            $deletedCount = \App\Models\JobRecommendation::where('job_id', $jobId)->delete();

            Log::info('✅ Deleted old job recommendations', [
                'job_id' => $jobId,
                'count' => $deletedCount
            ]);

            // Lấy tất cả ứng viên có đủ thông tin
            $applicants = \App\Models\Applicant::whereNotNull('vitriungtuyen')
                ->whereNotNull('diachi_uv')
                ->with(['kynang', 'hocvan', 'kinhnghiem', 'ngoaiNgu'])
                ->get();

            $newCount = 0;

            // Tính toán lại recommendations cho mỗi ứng viên
            foreach ($applicants as $applicant) {
                try {
                    $matchData = $this->recommendationService->calculateMatchScore($applicant, $job);
                    $score = $matchData['score'];

                    if ($score >= 40) {
                        \App\Models\JobRecommendation::create([
                            'applicant_id' => $applicant->id_uv,
                            'job_id' => $job->job_id,
                            'score' => $score,
                            'match_details' => json_encode($matchData['breakdown']),
                            'is_viewed' => false,
                            'is_applied' => false
                        ]);
                        $newCount++;
                    }
                } catch (\Exception $e) {
                    Log::error('❌ Error calculating match for applicant', [
                        'applicant_id' => $applicant->id_uv,
                        'job_id' => $jobId,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            Log::info('✅ Recalculated recommendations for job', [
                'job_id' => $jobId,
                'new_count' => $newCount,
                'applicants_processed' => $applicants->count()
            ]);

            return response()->json([
                'success' => true,
                'message' => "✅ Đã cập nhật gợi ý cho {$newCount} ứng viên",
                'count' => $newCount,
                'applicants_processed' => $applicants->count()
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error recalculating for job', [
                'job_id' => $jobId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }
}
