<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobApiController extends Controller
{
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

            // Trả về HTML của jobs
            $html = view('applicant.partials.job-cards', ['jobs' => $jobs])->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => [
                    'current_page' => $jobs->currentPage(),
                    'last_page' => $jobs->lastPage(),
                    'total' => $jobs->total(),
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
