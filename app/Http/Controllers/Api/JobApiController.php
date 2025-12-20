<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JobApiController extends Controller
{
    /**
     * Lấy tổng số jobs còn tuyển (loại bỏ đã đủ số lượng)
     */
    public function getTotalCount()
    {
        try {
            $allActiveJobs = JobPost::where('status', 'active')->get();
            Log::info('getTotalCount: Total active jobs: ' . $allActiveJobs->count());

            $availableJobs = $allActiveJobs->filter(function ($job) {
                $selectedCount = $job->selected_count ?? 0;
                $recruitmentCount = $job->recruitment_count ?? 0;
                $isAvailable = !($recruitmentCount > 0 && $selectedCount >= $recruitmentCount);

                if (!$isAvailable) {
                    Log::info('Job hidden: ' . $job->job_title . ' (selected: ' . $selectedCount . ', recruitment: ' . $recruitmentCount . ')');
                }

                return $isAvailable;
            });

            Log::info('getTotalCount: Available jobs after filter: ' . $availableJobs->count());

            return response()->json([
                'success' => true,
                'total' => $availableJobs->count()
            ]);
        } catch (\Exception $e) {
            Log::error('getTotalCount error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'total' => 0,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy danh sách jobs với phân trang
     */
    public function index(Request $request)
    {
        try {
            $jobs = JobPost::with(['company', 'hashtags', 'detail'])
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->paginate(12);

            // ✅ Lọc bỏ job đã đủ số lượng nhân sự
            $filteredJobs = $jobs->filter(function ($job) {
                $selectedCount = $job->selected_count ?? 0;
                $recruitmentCount = $job->recruitment_count ?? 0;
                // Chỉ giữ những job chưa đủ số lượng
                return !($recruitmentCount > 0 && $selectedCount >= $recruitmentCount);
            })->values();

            // Trả về HTML của jobs
            $html = view('applicant.partials.job-cards', ['jobs' => $filteredJobs])->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => [
                    'current_page' => $jobs->currentPage(),
                    'last_page' => $jobs->lastPage(),
                    'total' => $filteredJobs->count(), // ✅ Trả về số lượng sau khi filter
                    'per_page' => $jobs->perPage(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy chi tiết job theo ID
     */
    public function show($id)
    {
        try {
            $job = JobPost::with(['company', 'hashtags'])
                ->findOrFail($id);

            $response = [
                'job_id' => $job->job_id,
                'title' => $job->title,
                'level' => ucfirst($job->level),
                'experience' => $job->experience,
                'salary_min' => $job->salary_min,
                'salary_max' => $job->salary_max,
                'salary_type' => strtoupper($job->salary_type),
                'working_type' => ucfirst($job->working_type),
                'recruitment_count' => $job->recruitment_count,
                'province' => $job->province,
                'deadline' => $job->deadline,
                'foreign_language' => $job->foreign_language,
                'language_level' => $job->language_level,
                'gender_requirement' => $job->gender_requirement,
                'description' => $job->description,
                'responsibilities' => $job->responsibilities,
                'requirements' => $job->requirements,
                'benefits' => $job->benefits,
                'working_environment' => $job->working_environment,
                'contact_method' => $job->contact_method,
                'company' => [
                    'companies_id' => $job->company->companies_id ?? null,
                    'tencty' => $job->company->tencty ?? 'Công ty',
                    'logo' => $job->company->logo ?? null,
                ],
                'hashtags' => $job->hashtags->map(function ($tag) {
                    return [
                        'hashtag_id' => $tag->hashtag_id,
                        'tag_name' => $tag->tag_name
                    ];
                })
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Không tìm thấy công việc',
                'message' => $e->getMessage()
            ], 404);
        }
    }
}
