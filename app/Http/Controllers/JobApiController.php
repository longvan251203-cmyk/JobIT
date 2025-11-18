<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobApiController extends Controller
{
    /**
     * Lấy chi tiết job theo ID
     */
    public function show($id)
    {
        try {
            $job = JobPost::with([
                'company',
                'hashtags'
            ])
                ->findOrFail($id);

            // Format dữ liệu trả về
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

                // Nội dung chi tiết
                'description' => $job->description,
                'responsibilities' => $job->responsibilities,
                'requirements' => $job->requirements,
                'benefits' => $job->benefits,
                'working_environment' => $job->working_environment,
                'contact_method' => $job->contact_method,

                // Thông tin công ty
                'company' => [
                    'companies_id' => $job->company->companies_id ?? null,
                    'name' => $job->company->tencty ?? 'Công ty',
                    'logo' => $job->company->logo ? asset('storage/' . $job->company->logo) : null,
                    'address' => ($job->company->quan_huyen ? $job->company->quan_huyen . ', ' : '') . ($job->company->tinh_thanh ?? ''),
                    'website' => $job->company->website_cty ?? null,
                    'description' => $job->company->mota_cty ?? null,
                    'quymo' => $job->company->quymo ?? null,
                ],

                // Hashtags
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
