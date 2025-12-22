<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AI\AIRecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * AIRecommendationController
 * 
 * API Controller cho hệ thống AI Job Recommendation
 * Sử dụng OpenAI GPT để phân tích và đề xuất
 */
class AIRecommendationController extends Controller
{
    protected AIRecommendationService $aiService;

    public function __construct()
    {
        $this->aiService = new AIRecommendationService();
    }

    // ========================================================================
    // API CHO ỨNG VIÊN
    // ========================================================================

    /**
     * Tạo AI recommendations cho ứng viên đang đăng nhập
     * 
     * POST /api/ai/recommendations/generate
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateForApplicant(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user || !$user->applicant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng đăng nhập với tài khoản ứng viên'
                ], 401);
            }

            // Check API Key first
            $apiKey = env('OPENAI_API_KEY');
            if (empty($apiKey)) {
                return response()->json([
                    'success' => false,
                    'message' => 'OpenAI API Key chưa được cấu hình. Vui lòng liên hệ admin.'
                ], 500);
            }

            $applicantId = $user->applicant->id_uv;
            $limit = $request->input('limit', 20);
            $forceRefresh = $request->boolean('refresh', false);

            $result = $this->aiService->recommendJobsForApplicant(
                $applicantId,
                $limit,
                $forceRefresh
            );

            // Normalize response
            if (!isset($result['success'])) {
                $result['success'] = false;
            }
            if (isset($result['error']) && !isset($result['message'])) {
                $result['message'] = $result['error'];
            }

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('AIRecommendationController::generateForApplicant Error', [
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy danh sách AI recommendations của ứng viên
     * 
     * GET /api/ai/recommendations
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getApplicantRecommendations(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user || !$user->applicant) {
                return response()->json([
                    'success' => false,
                    'error' => 'Vui lòng đăng nhập với tài khoản ứng viên'
                ], 401);
            }

            $applicantId = $user->applicant->id_uv;
            $limit = $request->input('limit', 10);

            $result = $this->aiService->getJobRecommendations($applicantId, $limit);

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('AIRecommendationController::getApplicantRecommendations Error', [
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Lỗi hệ thống'
            ], 500);
        }
    }

    /**
     * Phân tích độ phù hợp của ứng viên với một job cụ thể
     * 
     * GET /api/ai/analyze/{jobId}
     * 
     * @param int $jobId
     * @return \Illuminate\Http\JsonResponse
     */
    public function analyzeJobMatch(int $jobId)
    {
        try {
            $user = Auth::user();

            if (!$user || !$user->applicant) {
                return response()->json([
                    'success' => false,
                    'error' => 'Vui lòng đăng nhập với tài khoản ứng viên'
                ], 401);
            }

            $applicantId = $user->applicant->id_uv;

            $result = $this->aiService->analyzeMatch($applicantId, $jobId);

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('AIRecommendationController::analyzeJobMatch Error', [
                'job_id' => $jobId,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Lỗi hệ thống'
            ], 500);
        }
    }

    /**
     * Refresh recommendations khi ứng viên cập nhật profile
     * 
     * POST /api/ai/recommendations/refresh
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshApplicantRecommendations()
    {
        try {
            $user = Auth::user();

            if (!$user || !$user->applicant) {
                return response()->json([
                    'success' => false,
                    'error' => 'Vui lòng đăng nhập với tài khoản ứng viên'
                ], 401);
            }

            $applicantId = $user->applicant->id_uv;
            $result = $this->aiService->refreshApplicantRecommendations($applicantId);

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('AIRecommendationController::refreshApplicantRecommendations Error', [
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Lỗi hệ thống'
            ], 500);
        }
    }

    // ========================================================================
    // API CHO NHÀ TUYỂN DỤNG (EMPLOYER/COMPANY)
    // ========================================================================

    /**
     * Tìm ứng viên phù hợp cho một job
     * 
     * POST /api/ai/employer/find-candidates/{jobId}
     * 
     * @param Request $request
     * @param int $jobId
     * @return \Illuminate\Http\JsonResponse
     */
    public function findCandidatesForJob(Request $request, int $jobId)
    {
        try {
            $user = Auth::user();

            if (!$user || !$user->employer) {
                return response()->json([
                    'success' => false,
                    'error' => 'Vui lòng đăng nhập với tài khoản nhà tuyển dụng'
                ], 401);
            }

            // Kiểm tra job thuộc về company của employer
            $company = $user->employer->company;
            if (!$company) {
                return response()->json([
                    'success' => false,
                    'error' => 'Không tìm thấy thông tin công ty'
                ], 403);
            }

            // TODO: Verify job belongs to this company

            $limit = $request->input('limit', 20);
            $result = $this->aiService->recommendApplicantsForJob($jobId, $limit);

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('AIRecommendationController::findCandidatesForJob Error', [
                'job_id' => $jobId,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Lỗi hệ thống'
            ], 500);
        }
    }

    /**
     * Lấy danh sách ứng viên đã được AI recommend cho công ty
     * 
     * GET /api/ai/employer/candidates
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCompanyCandidates(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user || !$user->employer) {
                return response()->json([
                    'success' => false,
                    'error' => 'Vui lòng đăng nhập với tài khoản nhà tuyển dụng'
                ], 401);
            }

            $company = $user->employer->company;
            if (!$company) {
                return response()->json([
                    'success' => false,
                    'error' => 'Không tìm thấy thông tin công ty'
                ], 403);
            }

            $companyId = $company->companies_id;
            $jobId = $request->input('job_id'); // Optional filter
            $limit = $request->input('limit', 20);

            $result = $this->aiService->getApplicantRecommendations($companyId, $jobId, $limit);

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('AIRecommendationController::getCompanyCandidates Error', [
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Lỗi hệ thống'
            ], 500);
        }
    }

    /**
     * Phân tích một ứng viên cụ thể cho một job
     * 
     * GET /api/ai/employer/analyze/{applicantId}/{jobId}
     * 
     * @param int $applicantId
     * @param int $jobId
     * @return \Illuminate\Http\JsonResponse
     */
    public function analyzeCandidate(int $applicantId, int $jobId)
    {
        try {
            $user = Auth::user();

            if (!$user || !$user->employer) {
                return response()->json([
                    'success' => false,
                    'error' => 'Vui lòng đăng nhập với tài khoản nhà tuyển dụng'
                ], 401);
            }

            // TODO: Verify job belongs to employer's company

            $result = $this->aiService->analyzeMatch($applicantId, $jobId);

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('AIRecommendationController::analyzeCandidate Error', [
                'applicant_id' => $applicantId,
                'job_id' => $jobId,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Lỗi hệ thống'
            ], 500);
        }
    }

    // ========================================================================
    // API CÔNG KHAI (TESTING & UTILITIES)
    // ========================================================================

    /**
     * Test kết nối AI
     * 
     * GET /api/ai/test
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function testConnection()
    {
        try {
            $result = $this->aiService->testAIConnection();
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy thống kê AI recommendations
     * 
     * GET /api/ai/stats
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatistics()
    {
        try {
            $stats = $this->aiService->getStatistics();
            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tạo AI recommendations cho tất cả jobs của công ty
     * 
     * POST /api/ai/employer/recommendations/generate
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateForEmployer(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user || !$user->employer) {
                return response()->json([
                    'success' => false,
                    'error' => 'Vui lòng đăng nhập với tài khoản nhà tuyển dụng'
                ], 401);
            }

            $company = $user->employer->company;
            if (!$company) {
                return response()->json([
                    'success' => false,
                    'error' => 'Không tìm thấy thông tin công ty'
                ], 403);
            }

            $companyId = $company->companies_id;
            $limit = $request->input('limit', 20);

            // Lấy tất cả jobs của công ty
            $jobs = \App\Models\JobPost::where('companies_id', $companyId)
                ->where('status', 'published')
                ->where('deadline', '>=', now())
                ->get();

            $totalCount = 0;

            foreach ($jobs as $job) {
                $result = $this->aiService->recommendApplicantsForJob($job->job_id, $limit);
                if ($result['success']) {
                    $totalCount += $result['count'] ?? 0;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "AI đã phân tích và gợi ý {$totalCount} ứng viên phù hợp cho {$jobs->count()} vị trí tuyển dụng",
                'count' => $totalCount,
                'jobs_analyzed' => $jobs->count()
            ]);
        } catch (\Exception $e) {
            Log::error('AIRecommendationController::generateForEmployer Error', [
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Lỗi hệ thống: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Refresh AI recommendations cho công ty
     * 
     * POST /api/ai/employer/recommendations/refresh
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshEmployerRecommendations()
    {
        try {
            $user = Auth::user();

            if (!$user || !$user->employer) {
                return response()->json([
                    'success' => false,
                    'error' => 'Vui lòng đăng nhập với tài khoản nhà tuyển dụng'
                ], 401);
            }

            $company = $user->employer->company;
            if (!$company) {
                return response()->json([
                    'success' => false,
                    'error' => 'Không tìm thấy thông tin công ty'
                ], 403);
            }

            $companyId = $company->companies_id;

            // Xóa recommendations cũ
            \App\Models\AIApplicantRecommendation::where('company_id', $companyId)->delete();

            // Lấy tất cả jobs của công ty
            $jobs = \App\Models\JobPost::where('companies_id', $companyId)
                ->where('status', 'published')
                ->where('deadline', '>=', now())
                ->get();

            $totalCount = 0;

            foreach ($jobs as $job) {
                $result = $this->aiService->recommendApplicantsForJob($job->job_id, 20);
                if ($result['success']) {
                    $totalCount += $result['count'] ?? 0;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Đã cập nhật {$totalCount} gợi ý ứng viên mới",
                'count' => $totalCount,
                'jobs_analyzed' => $jobs->count()
            ]);
        } catch (\Exception $e) {
            Log::error('AIRecommendationController::refreshEmployerRecommendations Error', [
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Lỗi hệ thống: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Demo: Phân tích một cặp ứng viên-job bất kỳ (cho testing)
     * 
     * POST /api/ai/demo/analyze
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function demoAnalyze(Request $request)
    {
        try {
            $request->validate([
                'applicant_id' => 'required|integer',
                'job_id' => 'required|integer'
            ]);

            $result = $this->aiService->analyzeMatch(
                $request->input('applicant_id'),
                $request->input('job_id')
            );

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
