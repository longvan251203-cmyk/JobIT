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

        // Parse match_details từ JSON
        $recommendations->transform(function ($recommendation) {
            $recommendation->match_details_parsed = json_decode($recommendation->match_details, true);
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
}
