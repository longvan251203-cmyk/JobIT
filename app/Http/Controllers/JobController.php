<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobDetail;
use App\Models\JobPost;
use App\Models\JobHashtag;
use App\Models\JobInvitation;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JobController extends Controller
{
    // Hiển thị chi tiết job
    public function show($id)
    {
        $job = JobPost::with(['company', 'hashtags', 'detail'])
            ->findOrFail($id);
        // Lấy thông tin công ty từ quan hệ
        $company = $job->company;
        return view('applicant.job-detail', compact('job', 'company'));
    }

    // Trả về JSON job
    public function getJobJson($id)
    {
        $job = JobPost::with(['company', 'hashtags', 'detail'])
            ->findOrFail($id);

        return response()->json($job);
    }

    // Hiển thị form đăng job
    public function create()
    {
        return view('employer.postjob');
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();

            // Kiểm tra user có role employer không
            if (!$user || $user->role !== 'employer') {
                return response()->json([
                    'success' => false,
                    'error' => 'Bạn không có quyền đăng tin tuyển dụng'
                ], 403);
            }

            $employer = $user->employer;

            // Debug log
            Log::info('== DEBUG Employer info ==', [
                'user_id' => $user->id,
                'employer' => $employer ? $employer->toArray() : null,
                'has_company' => $employer && $employer->company ? true : false,
                'company_id' => $employer && $employer->company ? $employer->company->companies_id : null
            ]);

            // Kiểm tra employer tồn tại
            if (!$employer) {
                return response()->json([
                    'success' => false,
                    'error' => 'Vui lòng hoàn thiện thông tin nhà tuyển dụng trước'
                ], 400);
            }

            // Kiểm tra có company chưa (quan hệ hasOne)
            if (!$employer->company) {
                return response()->json([
                    'success' => false,
                    'error' => 'Bạn chưa có công ty, không thể đăng tin'
                ], 400);
            }

            $companyId = $employer->company->companies_id;

            // Validate input
            $validated = $request->validate([
                'title' => 'required|string|max:200',
                'level' => 'required|string',
                'experience' => 'required|string',
                'salary_type' => 'required|string',
                'salary_min' => 'nullable|numeric|min:0',
                'salary_max' => 'nullable|numeric|min:0',
                'working_type' => 'required|string',
                'recruitment_count' => 'required|integer|min:1',
                'province' => 'required|string',
                'district' => 'required|string',
                'address_detail' => 'required|string|max:500',
                'foreign_language' => 'required|string|in:no_requirement,english,japanese,korean,chinese,french,german,spanish,russian,thai,indonesian',
                'language_level' => 'nullable|string|in:basic,intermediate,advanced,fluent,native',
                'deadline' => 'required|date|after_or_equal:today',
                'description' => 'required|string|max:2000',
                'responsibilities' => 'required|string|max:2000',
                'requirements' => 'required|string|max:2000',
                'benefits' => 'required|string|max:2000',
                'contact_method' => 'required|string|max:500',
                'gender_requirement' => 'nullable|string',
                'working_environment' => 'nullable|string',
                'hashtags' => 'nullable|string', // JSON string từ frontend
            ]);

            // Xử lý salary - nếu negotiable thì set null
            $salaryMin = null;
            $salaryMax = null;

            if ($validated['salary_type'] !== 'negotiable') {
                $salaryMin = $request->input('salary_min', null);
                $salaryMax = $request->input('salary_max', null);
            }

            // Bắt đầu transaction để đảm bảo dữ liệu nhất quán
            DB::beginTransaction();

            try {
                // Tạo JobPost
                $jobPost = JobPost::create([
                    'title' => $validated['title'],
                    'companies_id' => $companyId,
                    'level' => $validated['level'],
                    'experience' => $validated['experience'],
                    'salary_min' => $salaryMin,
                    'salary_max' => $salaryMax,
                    'salary_type' => $validated['salary_type'],
                    'working_type' => $validated['working_type'],
                    'recruitment_count' => $validated['recruitment_count'],
                    'province' => $validated['province'],
                    'district' => $validated['district'],
                    'address_detail' => $validated['address_detail'],
                    'foreign_language' => $validated['foreign_language'] ?? null,
                    'language_level' => $validated['language_level'] ?? null,
                    'deadline' => $validated['deadline'],
                ]);

                Log::info('JobPost created successfully', ['job_id' => $jobPost->job_id]);

                // Tạo JobDetail
                JobDetail::create([
                    'job_id' => $jobPost->job_id,
                    'description' => $validated['description'],
                    'responsibilities' => $validated['responsibilities'],
                    'requirements' => $validated['requirements'],
                    'benefits' => $validated['benefits'],
                    'gender_requirement' => $request->gender_requirement ?? 'any',
                    'contact_method' => $validated['contact_method'],
                    'working_environment' => $request->working_environment ?? null,
                ]);

                Log::info('JobDetail created successfully');

                // ✅ Xử lý Hashtags
                if ($request->has('hashtags') && !empty($request->hashtags)) {
                    $hashtagsJson = $request->input('hashtags');
                    $hashtags = json_decode($hashtagsJson, true);

                    if (is_array($hashtags) && count($hashtags) > 0) {
                        $hashtagIds = [];

                        foreach ($hashtags as $tagName) {
                            $tagName = strtolower(trim($tagName));

                            if (!empty($tagName)) {
                                // Tìm hoặc tạo hashtag mới
                                $hashtag = JobHashtag::firstOrCreate(
                                    ['tag_name' => $tagName]
                                );

                                $hashtagIds[] = $hashtag->hashtag_id;
                            }
                        }

                        // Gắn các hashtags vào job post (sử dụng bảng pivot job_post_hashtag)
                        if (!empty($hashtagIds)) {
                            $jobPost->hashtags()->attach($hashtagIds);
                            Log::info('Hashtags attached successfully', [
                                'job_id' => $jobPost->job_id,
                                'hashtag_count' => count($hashtagIds)
                            ]);
                        }
                    }
                }

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Đăng tin tuyển dụng thành công',
                    'job_id' => $jobPost->job_id
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error creating job post', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = Auth::user();

            if (!$user || $user->role !== 'employer') {
                return response()->json([
                    'success' => false,
                    'error' => 'Bạn không có quyền xóa tin tuyển dụng'
                ], 403);
            }

            $employer = $user->employer;

            if (!$employer || !$employer->company) {
                return response()->json([
                    'success' => false,
                    'error' => 'Không tìm thấy thông tin công ty'
                ], 400);
            }

            // Tìm job post
            $jobPost = JobPost::find($id);

            if (!$jobPost) {
                return response()->json([
                    'success' => false,
                    'error' => 'Không tìm thấy tin tuyển dụng'
                ], 404);
            }

            // Kiểm tra xem job có thuộc công ty của employer không
            if ($jobPost->companies_id !== $employer->company->companies_id) {
                return response()->json([
                    'success' => false,
                    'error' => 'Bạn không có quyền xóa tin tuyển dụng này'
                ], 403);
            }

            DB::beginTransaction();

            try {
                // Xóa job detail trước (nếu có foreign key constraint)
                if ($jobPost->detail) {
                    $jobPost->detail->delete();
                }

                // ✅ Detach hashtags (xóa trong bảng pivot, không xóa hashtag)
                $jobPost->hashtags()->detach();

                // Xóa job post
                $jobPost->delete();

                DB::commit();

                Log::info('Job post deleted successfully', ['job_id' => $id, 'employer_id' => $employer->id]);

                return response()->json([
                    'success' => true,
                    'message' => 'Đã xóa tin tuyển dụng thành công'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Error deleting job post', [
                'job_id' => $id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Có lỗi xảy ra khi xóa tin: ' . $e->getMessage()
            ], 500);
        }
    }

    // Controller API
    public function getJobDetail($id)
    {
        // ✅ Không lọc deadline để có thể xem recommended jobs đã hết hạn
        $job = JobPost::with(['company', 'hashtags', 'detail'])
            ->where('job_id', $id)
            ->where('status', 'active')
            ->first();

        if (!$job) {
            return response()->json([
                'error' => 'Công việc không tồn tại hoặc đã bị xóa'
            ], 404);
        }

        // ✅ Kiểm tra deadline nhưng vẫn trả về data, chỉ đánh dấu
        $isExpired = $job->deadline < now()->toDateString();

        // ✅ LẤY THÔNG TIN LỜI MỜI (nếu user đã đăng nhập)
        $invitationStatus = null;
        $invitationId = null;
        $invitationData = null;

        if (Auth::check()) {
            $applicant = Auth::user()->applicant;
            if ($applicant) {
                $invitation = JobInvitation::where('job_id', $job->job_id)
                    ->where('applicant_id', $applicant->id)
                    ->first();

                if ($invitation) {
                    $invitationStatus = $invitation->status; // pending, accepted, rejected
                    $invitationId = $invitation->id;
                    $invitationData = [
                        'id' => $invitation->id,
                        'status' => $invitation->status,
                        'message' => $invitation->message,
                        'invited_at' => $invitation->invited_at,
                        'responded_at' => $invitation->responded_at
                    ];
                }
            }
        }

        return response()->json([
            'job_id' => $job->job_id,
            'title' => $job->title,
            'level' => $job->level,
            'experience' => $job->experience_label,
            'salary_min' => $job->salary_min,
            'salary_max' => $job->salary_max,
            'salary_type' => $job->salary_type,
            'working_type' => $job->working_type,
            'recruitment_count' => $job->recruitment_count,
            'province' => $job->province,
            'district' => $job->district,
            'address_detail' => $job->address_detail,
            'foreign_language' => $job->foreign_language,
            'language_level' => $job->language_level,
            'deadline' => $job->deadline,
            'gender_requirement' => $job->gender_requirement,
            'is_expired' => $isExpired, // ✅ THÊM FLAG HẾT HẠN

            // Lấy từ detail relation
            'description' => $job->detail->description ?? null,
            'responsibilities' => $job->detail->responsibilities ?? null,
            'requirements' => $job->detail->requirements ?? null,
            'benefits' => $job->detail->benefits ?? null,
            'working_environment' => $job->detail->working_environment ?? null,
            'contact_method' => $job->detail->contact_method ?? null,

            'company' => $job->company ? [
                'tencty' => $job->company->tencty,
                'logo' => $job->company->logo,
                'tinh_thanh' => $job->company->tinh_thanh,
                'quan_huyen' => $job->company->quan_huyen,
                'website_cty' => $job->company->website_cty,
                'quymo' => $job->company->quymo,
                'mota_cty' => $job->company->mota_cty,
            ] : null,

            'hashtags' => $job->hashtags->map(function ($tag) {
                return ['tag_name' => $tag->tag_name];
            }),

            // ✅ THÊM THÔNG TIN LỜI MỜI
            'invitation_status' => $invitationStatus,
            'invitation_id' => $invitationId,
            'invitation' => $invitationData
        ]);
    }

    /**
     * Lấy thông tin job để edit
     */ public function edit($id)
    {
        try {
            $job = JobPost::with(['detail', 'hashtags'])->where('job_id', $id)->firstOrFail();

            $user = Auth::user();

            if (!$user || !$user->employer) {
                return response()->json([
                    'success' => false,
                    'error' => 'Không tìm thấy thông tin nhà tuyển dụng'
                ], 403);
            }

            $employer = $user->employer;

            // Kiểm tra quyền sở hữu
            if (!$employer->company || $job->companies_id !== $employer->company->companies_id) {
                return response()->json([
                    'success' => false,
                    'error' => 'Bạn không có quyền chỉnh sửa tin đăng này'
                ], 403);
            }

            // ✅ Format hashtags để frontend hiển thị
            $hashtagNames = $job->hashtags->pluck('tag_name')->toArray();

            return response()->json([
                'success' => true,
                'job' => $job,
                'hashtags' => $hashtagNames // Trả về mảng tên hashtags
            ]);
        } catch (\Exception $e) {
            Log::error('Error in edit method', [
                'job_id' => $id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Không tìm thấy tin đăng: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Cập nhật job
     */ public function update(Request $request, $id)
    {
        try {
            $job = JobPost::with('detail')->where('job_id', $id)->firstOrFail();

            $user = Auth::user();

            if (!$user || !$user->employer) {
                return response()->json([
                    'success' => false,
                    'error' => 'Không tìm thấy thông tin nhà tuyển dụng'
                ], 403);
            }

            $employer = $user->employer;

            // Kiểm tra quyền sở hữu
            if (!$employer->company || $job->companies_id !== $employer->company->companies_id) {
                return response()->json([
                    'success' => false,
                    'error' => 'Bạn không có quyền chỉnh sửa tin đăng này'
                ], 403);
            }

            // Validate dữ liệu
            $validated = $request->validate([
                'title' => 'required|string|max:200',
                'level' => 'required|string',
                'experience' => 'required|string',
                'salary_type' => 'required|string',
                'salary_min' => 'nullable|numeric|min:0',
                'salary_max' => 'nullable|numeric|min:0',
                'working_type' => 'required|string',
                'recruitment_count' => 'required|integer|min:1',
                'province' => 'required|string',
                'district' => 'required|string',
                'address_detail' => 'required|string|max:500',
                'foreign_language' => 'required|string|in:no_requirement,english,japanese,korean,chinese,french,german,spanish,russian,thai,indonesian',
                'language_level' => 'nullable|string|in:basic,intermediate,advanced,fluent,native',
                'deadline' => 'required|date',
                'description' => 'required|string|max:2000',
                'responsibilities' => 'required|string|max:2000',
                'requirements' => 'required|string|max:2000',
                'benefits' => 'required|string|max:2000',
                'gender_requirement' => 'nullable|string',
                'working_environment' => 'nullable|string',
                'contact_method' => 'required|string|max:500',
                'hashtags' => 'nullable|string', // JSON string
            ]);

            DB::beginTransaction();

            try {
                // Cập nhật JobPost
                $job->update([
                    'title' => $validated['title'],
                    'level' => $validated['level'],
                    'experience' => $validated['experience'],
                    'salary_type' => $validated['salary_type'],
                    'salary_min' => $validated['salary_type'] === 'negotiable' ? null : $validated['salary_min'],
                    'salary_max' => $validated['salary_type'] === 'negotiable' ? null : $validated['salary_max'],
                    'working_type' => $validated['working_type'],
                    'recruitment_count' => $validated['recruitment_count'],
                    'province' => $validated['province'],
                    'district' => $validated['district'],
                    'address_detail' => $validated['address_detail'],
                    'foreign_language' => $validated['foreign_language'] ?? null,
                    'language_level' => $validated['language_level'] ?? null,
                    'deadline' => $validated['deadline'],
                ]);

                // Cập nhật JobDetail
                if ($job->detail) {
                    $job->detail->update([
                        'description' => $validated['description'],
                        'responsibilities' => $validated['responsibilities'],
                        'requirements' => $validated['requirements'],
                        'benefits' => $validated['benefits'],
                        'gender_requirement' => $validated['gender_requirement'] ?? 'any',
                        'working_environment' => $validated['working_environment'] ?? 'dynamic',
                        'contact_method' => $validated['contact_method'],
                    ]);
                } else {
                    // Tạo mới nếu chưa có detail
                    JobDetail::create([
                        'job_id' => $job->job_id,
                        'description' => $validated['description'],
                        'responsibilities' => $validated['responsibilities'],
                        'requirements' => $validated['requirements'],
                        'benefits' => $validated['benefits'],
                        'gender_requirement' => $validated['gender_requirement'] ?? 'any',
                        'working_environment' => $validated['working_environment'] ?? 'dynamic',
                        'contact_method' => $validated['contact_method'],
                    ]);
                }

                // ✅ Cập nhật Hashtags - FIX HERE
                if ($request->has('hashtags')) {
                    $hashtagsJson = $request->input('hashtags');

                    // Parse JSON
                    $hashtagsArray = json_decode($hashtagsJson, true);

                    // Validate JSON
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        throw new \Exception('Invalid hashtags format');
                    }

                    // Detach tất cả hashtags cũ
                    $job->hashtags()->detach();

                    Log::info('Processing hashtags', [
                        'job_id' => $job->job_id,
                        'raw_hashtags' => $hashtagsJson,
                        'parsed_hashtags' => $hashtagsArray
                    ]);

                    // Attach hashtags mới
                    if (is_array($hashtagsArray) && count($hashtagsArray) > 0) {
                        $hashtagIds = [];

                        foreach ($hashtagsArray as $tagName) {
                            $tagName = strtolower(trim($tagName));

                            if (!empty($tagName)) {
                                // Tìm hoặc tạo hashtag
                                $hashtag = JobHashtag::firstOrCreate(
                                    ['tag_name' => $tagName]
                                );

                                // 🔧 FIX: Dùng hashtag_id thay vì id
                                $hashtagIds[] = $hashtag->hashtag_id;

                                Log::info('Hashtag processed', [
                                    'tag_name' => $tagName,
                                    'hashtag_id' => $hashtag->hashtag_id
                                ]);
                            }
                        }

                        if (!empty($hashtagIds)) {
                            // Sử dụng sync thay vì attach để tránh duplicate
                            $job->hashtags()->sync($hashtagIds);

                            Log::info('Hashtags synced successfully', [
                                'job_id' => $job->job_id,
                                'hashtag_ids' => $hashtagIds,
                                'hashtag_count' => count($hashtagIds)
                            ]);
                        }
                    } else {
                        Log::info('No hashtags to sync', ['job_id' => $job->job_id]);
                    }
                }

                DB::commit();

                Log::info('Job updated successfully', ['job_id' => $job->job_id]);

                // ✅ INVALIDATE CACHE cho gợi ý ứng viên
                Cache::forget("recommended_applicants_v2_company_*");
                Cache::flush();

                // ✅ TRIGGER: Recalculate recommendations cho tất cả ứng viên
                try {
                    Log::info('🔄 Triggering recalculate for job applicants', [
                        'job_id' => $job->job_id
                    ]);

                    $recommendationService = app(\App\Services\JobRecommendationService::class);

                    // Lấy tất cả ứng viên có đủ thông tin
                    $applicants = \App\Models\Applicant::whereNotNull('vitriungtuyen')
                        ->whereNotNull('diachi_uv')
                        ->with(['kynang', 'hocvan', 'kinhnghiem', 'ngoaiNgu'])
                        ->get();

                    // Xóa recommendations cũ của job này
                    \App\Models\JobRecommendation::where('job_id', $job->job_id)->delete();

                    $newCount = 0;
                    foreach ($applicants as $applicant) {
                        try {
                            $matchData = $recommendationService->calculateMatchScore($applicant, $job);
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
                            Log::error('❌ Error recalculating for applicant', [
                                'applicant_id' => $applicant->id_uv,
                                'job_id' => $job->job_id,
                                'error' => $e->getMessage()
                            ]);
                        }
                    }

                    Log::info('✅ Recalculated recommendations for job', [
                        'job_id' => $job->job_id,
                        'new_count' => $newCount
                    ]);
                } catch (\Exception $e) {
                    Log::error('❌ Error triggering recalculate', [
                        'job_id' => $job->job_id,
                        'error' => $e->getMessage()
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Cập nhật tin đăng thành công!',
                    'job' => $job->fresh(['detail', 'hashtags'])
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error updating job', [
                'job_id' => $id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Lỗi khi cập nhật: ' . $e->getMessage()
            ], 500);
        }
    }
    // Thêm method này vào JobController.php

    /**
     * Tìm kiếm hashtags để autocomplete
     */
    public function searchHashtags(Request $request)
    {
        try {
            $query = $request->input('query', '');

            // Loại bỏ ký tự # nếu có
            $query = str_replace('#', '', $query);

            if (empty($query)) {
                return response()->json([
                    'success' => true,
                    'hashtags' => []
                ]);
            }

            // Tìm kiếm hashtags có tag_name bắt đầu hoặc chứa query
            // Ưu tiên các tag bắt đầu bằng query
            $hashtags = JobHashtag::where('tag_name', 'like', $query . '%')
                ->orWhere('tag_name', 'like', '%' . $query . '%')
                ->orderByRaw("CASE WHEN tag_name LIKE ? THEN 1 ELSE 2 END", [$query . '%'])
                ->orderBy('tag_name', 'asc')
                ->limit(10)
                ->get(['tag_name']);

            return response()->json([
                'success' => true,
                'hashtags' => $hashtags->pluck('tag_name')
            ]);
        } catch (\Exception $e) {
            Log::error('Error searching hashtags', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Có lỗi xảy ra khi tìm kiếm hashtags'
            ], 500);
        }
    }
    public function checkApplicationStatus($id)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => true,
                    'applied' => false,
                    'invited' => false
                ]);
            }

            $applicant = Auth::user()->applicant;

            if (!$applicant) {
                return response()->json([
                    'success' => true,
                    'applied' => false,
                    'invited' => false
                ]);
            }

            // ✅ Kiểm tra application
            $application = Application::where('job_id', $id)
                ->where('applicant_id', $applicant->id_uv)
                ->first();

            // ✅ Kiểm tra invitation
            $invitation = JobInvitation::where('job_id', $id)
                ->where('applicant_id', $applicant->id_uv)
                ->first();

            return response()->json([
                'success' => true,
                'applied' => $application ? true : false,
                'application_status' => $application ? $application->trang_thai : null,
                'invited' => $invitation ? true : false,
                'invitation_status' => $invitation ? $invitation->status : null,
                'invitation_id' => $invitation ? $invitation->id : null,
                'invitation_data' => $invitation ? [
                    'id' => $invitation->id,
                    'status' => $invitation->status,
                    'message' => $invitation->message,
                    'invited_at' => $invitation->invited_at,
                    'responded_at' => $invitation->responded_at
                ] : null
            ]);
        } catch (\Exception $e) {
            Log::error('Error checking application status', [
                'job_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra'
            ], 500);
        }
    }

    /**
     * ✅ API: Lấy danh sách ID các job đã ứng tuyển
     */
    public function getAppliedJobIds()
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => true,
                    'appliedJobIds' => []
                ]);
            }

            $applicant = Auth::user()->applicant;

            if (!$applicant) {
                return response()->json([
                    'success' => true,
                    'appliedJobIds' => []
                ]);
            }

            $appliedJobIds = Application::where('applicant_id', $applicant->id_uv)
                ->pluck('job_id')
                ->toArray();

            return response()->json([
                'success' => true,
                'appliedJobIds' => $appliedJobIds
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting applied job IDs', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra'
            ], 500);
        }
    }

    // ✅ LẤY CÁC LỜI MỜI CỦA ỨNG VIÊN
    public function getUserInvitations()
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => true,
                    'invitations' => []
                ]);
            }

            $applicant = Auth::user()->applicant;

            if (!$applicant) {
                return response()->json([
                    'success' => true,
                    'invitations' => []
                ]);
            }

            // Lấy tất cả invitations của applicant
            $invitations = JobInvitation::where('applicant_id', $applicant->id_uv)
                ->select('id', 'job_id', 'status', 'invited_at', 'responded_at')
                ->get();

            return response()->json([
                'success' => true,
                'invitations' => $invitations
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting user invitations', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra'
            ], 500);
        }
    }

    public function getJobsPaginated(Request $request)
    {
        try {
            $page = $request->input('page', 1);
            $perPage = 8; // Số job mỗi trang
            $jobs = JobPost::with(['company', 'hashtags'])
                ->where('status', 'active')
                ->where('deadline', '>=', now()->toDateString())
                ->whereRaw('(recruitment_count = 0 OR recruitment_count > (
                    SELECT COUNT(*) FROM applications 
                    WHERE applications.job_id = job_post.job_id 
                    AND applications.trang_thai = "duoc_chon"
                ))')
                ->orderBy('created_at', 'desc')
                ->paginate($perPage, ['*'], 'page', $page);
            // Render HTML cho job cards
            $html = view('applicant.partials.job-cards', ['jobs' => $jobs])->render();

            // Tạo HTML cho pagination
            $paginationHtml = $this->buildPaginationHtml($jobs);

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => $paginationHtml,
                'current_page' => $jobs->currentPage(),
                'last_page' => $jobs->lastPage(),
                'total' => $jobs->total()
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting paginated jobs', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tải dữ liệu'
            ], 500);
        }
    }

    /**
     * ✅ Helper: Tạo HTML cho pagination
     */
    private function buildPaginationHtml($jobs)
    {
        if ($jobs->lastPage() <= 1) {
            return '';
        }

        $html = '<nav class="custom-pagination"><ul class="pagination">';

        // Previous Button
        $prevDisabled = $jobs->currentPage() == 1 ? 'disabled' : '';
        $html .= '<li class="page-item ' . $prevDisabled . '">';
        $html .= '<a class="page-link" href="#" data-page="' . ($jobs->currentPage() - 1) . '">';
        $html .= '<i class="bi bi-chevron-left"></i></a></li>';

        // Page Numbers
        $start = max(1, $jobs->currentPage() - 2);
        $end = min($jobs->lastPage(), $jobs->currentPage() + 2);

        // First page + ellipsis
        if ($start > 1) {
            $html .= '<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>';
            if ($start > 2) {
                $html .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        }

        // Page numbers
        for ($i = $start; $i <= $end; $i++) {
            $active = $i == $jobs->currentPage() ? 'active' : '';
            $html .= '<li class="page-item ' . $active . '">';
            $html .= '<a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a></li>';
        }

        // Ellipsis + last page
        if ($end < $jobs->lastPage()) {
            if ($end < $jobs->lastPage() - 1) {
                $html .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
            $html .= '<li class="page-item"><a class="page-link" href="#" data-page="' . $jobs->lastPage() . '">';
            $html .= $jobs->lastPage() . '</a></li>';
        }

        // Next Button
        $nextDisabled = $jobs->currentPage() == $jobs->lastPage() ? 'disabled' : '';
        $html .= '<li class="page-item ' . $nextDisabled . '">';
        $html .= '<a class="page-link" href="#" data-page="' . ($jobs->currentPage() + 1) . '">';
        $html .= '<i class="bi bi-chevron-right"></i></a></li>';

        $html .= '</ul></nav>';

        return $html;
    }
    // ============================================
    // JobController.php - FIXED LOCATION SEARCH
    // ============================================
    private function buildLocationMapping()
    {
        return [
            // Hà Nội
            'ha-noi' => [
                'Hà Nội',
                'Ha Noi',
                'hanoi',
                'hn',
                'Thành phố Hà Nội',
                'Thanh pho Ha Noi',
            ],

            // TP. Hồ Chí Minh
            'ho-chi-minh' => [
                'TP. Hồ Chí Minh',
                'TP.HCM',
                'TPHCM',
                'Ho Chi Minh',
                'hcm',
                'hochiminh',
                'Thành phố Hồ Chí Minh',
                'Thanh pho Ho Chi Minh',
                'Saigon',
                'SaiGon',
                'Sài Gòn',
            ],

            // Đà Nẵng
            'da-nang' => [
                'Đà Nẵng',
                'Da Nang',
                'danang',
                'dn',
                'Thành phố Đà Nẵng',
                'Thanh pho Da Nang',
            ],

            // Cần Thơ
            'can-tho' => [
                'Thành phố Cần Thơ',
                'Cần Thơ',
                'Can Tho',
                'cantho',
                'can tho',
                'ct',
                'Thanh pho Can Tho',
            ],

            // Hải Phòng
            'hai-phong' => [
                'Hải Phòng',
                'Hai Phong',
                'haiphong',
                'hp',
                'Thành phố Hải Phòng',
                'Thanh pho Hai Phong',
            ],

            // Bình Dương
            'binh-duong' => [
                'Bình Dương',
                'Binh Duong',
                'binhduong',
                'bd',
                'Tỉnh Bình Dương',
                'Tinh Binh Duong',
            ],

            // Đồng Nai
            'dong-nai' => [
                'Đồng Nai',
                'Dong Nai',
                'dongnai',
                'dn',
                'Tỉnh Đồng Nai',
                'Tinh Dong Nai',
            ],

            // Bà Rịa - Vũng Tàu
            'ba-ria-vung-tau' => [
                'Bà Rịa - Vũng Tàu',
                'Ba Ria Vung Tau',
                'ba ria vung tau',
                'brvt',
                'Tỉnh Bà Rịa - Vũng Tàu',
            ],

            // An Giang
            'an-giang' => [
                'An Giang',
                'angiang',
                'ag',
                'Tỉnh An Giang',
            ],

            // Các tỉnh khác
            'bac-giang' => ['Bắc Giang', 'Bac Giang', 'bacgiang', 'bg'],
            'bac-kan' => ['Bắc Kạn', 'Bac Kan', 'backan', 'bk'],
            'bac-ninh' => ['Bắc Ninh', 'Bac Ninh', 'bacninh', 'bn'],
            'ben-tre' => ['Bến Tre', 'Ben Tre', 'bentre', 'bt'],
            'binh-dinh' => ['Bình Định', 'Binh Dinh', 'binhdinh'],
            'binh-phuoc' => ['Bình Phước', 'Binh Phuoc', 'binhphuoc', 'bp'],
            'binh-thuan' => ['Bình Thuận', 'Binh Thuan', 'binhthuan'],
            'ca-mau' => ['Cà Mau', 'Ca Mau', 'camau', 'cm'],
            'cao-bang' => ['Cao Bằng', 'Cao Bang', 'caobang', 'cb'],
            'dak-lak' => ['Đắk Lắk', 'Dak Lak', 'daklak', 'dl'],
            'dak-nong' => ['Đắk Nông', 'Dak Nong', 'daknong', 'dn'],
            'dien-bien' => ['Điện Biên', 'Dien Bien', 'dienbien', 'db'],
            'gia-lai' => ['Gia Lai', 'gialai', 'gl'],
            'ha-giang' => ['Hà Giang', 'Ha Giang', 'hagiang', 'hg'],
            'ha-nam' => ['Hà Nam', 'Ha Nam', 'hanam', 'hnam'],
            'ha-tinh' => ['Hà Tĩnh', 'Ha Tinh', 'hatinh', 'ht'],
            'hai-duong' => ['Hải Dương', 'Hai Duong', 'haiduong', 'hd'],
            'hau-giang' => ['Hậu Giang', 'Hau Giang', 'haugiang', 'hgi'],
            'hoa-binh' => ['Hòa Bình', 'Hoa Binh', 'hoabinh', 'hb'],
            'hung-yen' => ['Hưng Yên', 'Hung Yen', 'hungyen', 'hy'],
            'khanh-hoa' => ['Khánh Hòa', 'Khanh Hoa', 'khanhhoa', 'kh'],
            'kien-giang' => ['Kiên Giang', 'Kien Giang', 'kiengiang', 'kg'],
            'kon-tum' => ['Kon Tum', 'kontum', 'kt'],
            'lai-chau' => ['Lai Châu', 'Lai Chau', 'laichau', 'lc'],
            'lam-dong' => ['Lâm Đồng', 'Lam Dong', 'lamdong', 'ld'],
            'lang-son' => ['Lạng Sơn', 'Lang Son', 'langson', 'ls'],
            'lao-cai' => ['Lào Cai', 'Lao Cai', 'laocai', 'lcai'],
            'long-an' => ['Long An', 'longan', 'la'],
            'nam-dinh' => ['Nam Định', 'Nam Dinh', 'namdinh', 'nd'],
            'nghe-an' => ['Nghệ An', 'Nghe An', 'nghean', 'na'],
            'ninh-binh' => ['Ninh Bình', 'Ninh Binh', 'ninhbinh', 'nb'],
            'ninh-thuan' => ['Ninh Thuận', 'Ninh Thuan', 'ninhthuan'],
            'phu-tho' => ['Phú Thọ', 'Phu Tho', 'phutho', 'pt'],
            'phu-yen' => ['Phú Yên', 'Phu Yen', 'phuyen', 'py'],
            'quang-binh' => ['Quảng Bình', 'Quang Binh', 'quangbinh', 'qb'],
            'quang-nam' => ['Quảng Nam', 'Quang Nam', 'quangnam', 'qnam'],
            'quang-ngai' => ['Quảng Ngãi', 'Quang Ngai', 'quangngai', 'qng'],
            'quang-ninh' => ['Quảng Ninh', 'Quang Ninh', 'quangninh', 'qn'],
            'quang-tri' => ['Quảng Trị', 'Quang Tri', 'quangtri', 'qt'],
            'soc-trang' => ['Sóc Trăng', 'Soc Trang', 'soctrang', 'st'],
            'son-la' => ['Sơn La', 'Son La', 'sonla', 'sl'],
            'tay-ninh' => ['Tây Ninh', 'Tay Ninh', 'tayninh', 'tn'],
            'thai-binh' => ['Thái Bình', 'Thai Binh', 'thaibinh', 'tb'],
            'thai-nguyen' => ['Thái Nguyên', 'Thai Nguyen', 'thainguyen', 'tng'],
            'thanh-hoa' => ['Thanh Hóa', 'Thanh Hoa', 'thanhhoa', 'th'],
            'thua-thien-hue' => ['Thừa Thiên Huế', 'Thua Thien Hue', 'thuathienhue', 'tth', 'Huế'],
            'tien-giang' => ['Tiền Giang', 'Tien Giang', 'tiengiang', 'tg'],
            'tra-vinh' => ['Trà Vinh', 'Tra Vinh', 'travinh', 'tv'],
            'tuyen-quang' => ['Tuyên Quang', 'Tuyen Quang', 'tuyenquang', 'tq'],
            'vinh-long' => ['Vĩnh Long', 'Vinh Long', 'vinhlong', 'vl'],
            'vinh-phuc' => ['Vĩnh Phúc', 'Vinh Phuc', 'vinhphuc', 'vp'],
            'yen-bai' => ['Yên Bái', 'Yen Bai', 'yenbai', 'yb'],
            'remote' => ['Remote', 'remote', 'WFH', 'Work from home', 'Làm từ xa'],
        ];
    }
    private function normalizeText($text)
    {
        // Chuyển sang lowercase
        $text = strtolower(trim($text));

        // Loại bỏ dấu Vietnamese
        $text = preg_replace(
            '/[^a-z0-9\s]/i',
            '',
            iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text)
        );

        return trim(preg_replace('/\s+/', ' ', $text));
    }

    /**
     * ✅ Tìm khớp location từ input user
     */
    private function findMatchingLocationKey($userInput)
    {
        $mapping = $this->buildLocationMapping();
        $normalizedInput = $this->normalizeText($userInput);

        Log::info('🔍 Finding location match', [
            'user_input' => $userInput,
            'normalized_input' => $normalizedInput
        ]);

        // Tìm khớp chính xác
        foreach ($mapping as $key => $variations) {
            foreach ($variations as $variation) {
                $normalizedVariation = $this->normalizeText($variation);

                if ($normalizedVariation === $normalizedInput) {
                    Log::info('✅ Location matched exactly', [
                        'key' => $key,
                        'variation' => $variation,
                        'normalized' => $normalizedVariation
                    ]);
                    return $key;
                }
            }
        }

        // Tìm khớp từng phần (fallback)
        foreach ($mapping as $key => $variations) {
            foreach ($variations as $variation) {
                $normalizedVariation = $this->normalizeText($variation);

                if (
                    strpos($normalizedVariation, $normalizedInput) !== false ||
                    strpos($normalizedInput, $normalizedVariation) !== false
                ) {
                    Log::info('✅ Location matched partially', [
                        'key' => $key,
                        'variation' => $variation
                    ]);
                    return $key;
                }
            }
        }

        Log::warning('⚠️ No location match found', ['input' => $userInput]);
        return null;
    }

    /**
     * ✅ Lấy tất cả variations của một location key
     */
    private function getLocationVariations($locationKey)
    {
        $mapping = $this->buildLocationMapping();

        if (isset($mapping[$locationKey])) {
            $variations = $mapping[$locationKey];
            Log::info('📍 Got location variations', [
                'key' => $locationKey,
                'variations_count' => count($variations),
                'variations' => $variations
            ]);
            return $variations;
        }

        return [];
    }



    /**
     * ✅ SEARCH JOBS - UPDATED WITH BETTER LOCATION MATCHING
     */
    public function searchJobs(Request $request)
    {
        try {
            $query = JobPost::with(['company', 'hashtags', 'detail']);
            $hasFilters = false;
            $locationMessage = '';

            // ========== SEARCH BY KEYWORD ==========
            if ($request->filled('search')) {
                $hasFilters = true;
                $searchTerm = $request->input('search');

                $query->where(function ($q) use ($searchTerm) {
                    $q->where('title', 'like', '%' . $searchTerm . '%')
                        ->orWhereHas('company', function ($companyQuery) use ($searchTerm) {
                            $companyQuery->where('tencty', 'like', '%' . $searchTerm . '%');
                        })
                        ->orWhereHas('hashtags', function ($hashtagQuery) use ($searchTerm) {
                            $hashtagQuery->where('tag_name', 'like', '%' . $searchTerm . '%');
                        })
                        ->orWhereHas('detail', function ($detailQuery) use ($searchTerm) {
                            $detailQuery->where('description', 'like', '%' . $searchTerm . '%')
                                ->orWhere('requirements', 'like', '%' . $searchTerm . '%');
                        });
                });

                Log::info('✅ Search keyword applied', ['term' => $searchTerm]);
            }

            // ========== FILTER BY LOCATION - COMPLETE VERSION ==========
            if ($request->filled('location')) {
                $hasFilters = true;
                $userLocation = $request->input('location');

                // 1️⃣ Tìm khớp location key
                $locationKey = $this->findMatchingLocationKey($userLocation);

                if ($locationKey) {
                    // 2️⃣ Lấy tất cả variations
                    $variations = $this->getLocationVariations($locationKey);

                    if (!empty($variations)) {
                        // 3️⃣ Query với LIKE pattern để match tất cả variations
                        $query->where(function ($q) use ($variations) {
                            foreach ($variations as $variation) {
                                $q->orWhere('province', 'like', '%' . $variation . '%');
                            }
                        });

                        Log::info('✅ Location filter applied successfully', [
                            'user_input' => $userLocation,
                            'matched_key' => $locationKey,
                            'variations_used' => $variations,
                            'variation_count' => count($variations)
                        ]);

                        // Lấy display name cho message
                        $displayName = $variations[0]; // Tên đầu tiên là tên chính
                        $locationMessage = " tại {$displayName}";
                    }
                } else {
                    Log::warning('⚠️ Location not found in mapping', ['input' => $userLocation]);
                    // Fallback: search trực tiếp nếu không match
                    $query->where('province', 'like', '%' . $userLocation . '%');
                    $locationMessage = " tại {$userLocation}";
                }
            }

            // ========== FILTER BY CATEGORY ==========
            if ($request->filled('categories')) {
                $hasFilters = true;
                $categories = explode(',', $request->input('categories'));

                $categoryMap = [
                    'backend' => ['php', 'laravel', 'nodejs', 'python', 'java', 'spring', 'c#', '.net'],
                    'frontend' => ['react', 'vuejs', 'vue', 'angular', 'javascript', 'html', 'css', 'typescript'],
                    'fullstack' => ['fullstack', 'full-stack'],
                    'mobile' => ['android', 'ios', 'react native', 'flutter'],
                    'devops' => ['devops', 'docker', 'kubernetes', 'aws'],
                ];

                $query->where(function ($q) use ($categories, $categoryMap) {
                    foreach ($categories as $category) {
                        if (isset($categoryMap[$category])) {
                            $q->orWhereHas('hashtags', function ($hashtagQuery) use ($categoryMap, $category) {
                                $hashtagQuery->whereIn('tag_name', $categoryMap[$category]);
                            });
                        }
                    }
                });
            }

            // ========== FILTER BY POSITIONS (VỊ TRÍ TUYỂN DỤNG) ==========
            if ($request->filled('positions')) {
                $hasFilters = true;
                $positions = explode(',', $request->input('positions'));
                $query->whereIn('level', $positions);  // ✅ DÙNG 'level' COLUMN
                Log::info('✅ Position filter applied', ['positions' => $positions]);
            }

            // ========== FILTER BY EXPERIENCE ==========
            if ($request->filled('experiences')) {
                $hasFilters = true;
                $experiences = explode(',', $request->input('experiences'));
                $query->whereIn('experience', $experiences);
            }
            // ========== FILTER BY SALARY - FIXED VERSION ==========
            if ($request->filled('salary_ranges')) {
                $hasFilters = true;
                $ranges = explode(',', $request->input('salary_ranges'));

                $query->where(function ($q) use ($ranges) {
                    foreach ($ranges as $range) {
                        $range = trim($range);

                        switch ($range) {
                            // ✅ Dưới 5 triệu: job_max < 5M HOẶC job_min < 5M
                            case 'under_5':
                                $q->orWhere(function ($subQ) {
                                    $subQ->where('salary_max', '<', 5000000)
                                        ->orWhere('salary_min', '<', 5000000);
                                });
                                break;

                            // ✅ 5-10 triệu: job range OVERLAP với 5-10M
                            // VD: job 8-15M vẫn match vì 8M nằm trong 5-10M hoặc > 5M
                            case '5_10':
                                $q->orWhere(function ($subQ) {
                                    $subQ->whereNotNull('salary_min')
                                        ->whereNotNull('salary_max')
                                        ->where('salary_min', '<', 10000000)  // job_min < 10M
                                        ->where('salary_max', '>=', 5000000); // job_max >= 5M
                                });
                                break;

                            // ✅ 10-15 triệu
                            case '10_15':
                                $q->orWhere(function ($subQ) {
                                    $subQ->whereNotNull('salary_min')
                                        ->whereNotNull('salary_max')
                                        ->where('salary_min', '<', 15000000)
                                        ->where('salary_max', '>=', 10000000);
                                });
                                break;

                            // ✅ 15-20 triệu
                            case '15_20':
                                $q->orWhere(function ($subQ) {
                                    $subQ->whereNotNull('salary_min')
                                        ->whereNotNull('salary_max')
                                        ->where('salary_min', '<', 20000000)
                                        ->where('salary_max', '>=', 15000000);
                                });
                                break;

                            // ✅ 20-30 triệu
                            case '20_30':
                                $q->orWhere(function ($subQ) {
                                    $subQ->whereNotNull('salary_min')
                                        ->whereNotNull('salary_max')
                                        ->where('salary_min', '<', 30000000)
                                        ->where('salary_max', '>=', 20000000);
                                });
                                break;

                            // ✅ Trên 30 triệu: job_min >= 30M HOẶC job_max >= 30M
                            case '30_plus':
                                $q->orWhere(function ($subQ) {
                                    $subQ->where('salary_min', '>=', 30000000)
                                        ->orWhere('salary_max', '>=', 30000000);
                                });
                                break;
                        }
                    }
                });

                Log::info('✅ Salary filter applied', ['ranges' => $ranges]);
            }

            // ========== FILTER BY WORKING TYPE ==========
            if ($request->filled('working_types')) {
                $hasFilters = true;
                $workingTypes = explode(',', $request->input('working_types'));
                $query->whereIn('working_type', $workingTypes);
            }


            // ========== APPLY STATUS & DEADLINE FILTERS ==========
            if ($hasFilters) {
                $query->where('status', 'active')
                    ->where('deadline', '>=', now()->toDateString());
            }

            $query->orderBy('created_at', 'desc');

            $perPage = 12;
            $jobs = $query->paginate($perPage);

            // Render HTML
            $html = view('applicant.partials.job-cards', ['jobs' => $jobs])->render();
            $paginationHtml = $this->buildPaginationHtml($jobs);

            Log::info('✅ Search completed', [
                'has_filters' => $hasFilters,
                'total_results' => $jobs->total(),
                'location_message' => $locationMessage
            ]);

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => $paginationHtml,
                'total' => $jobs->total(),
                'current_page' => $jobs->currentPage(),
                'last_page' => $jobs->lastPage(),
                'per_page' => $jobs->perPage(),
                'has_filters' => $hasFilters,
                'location_message' => $locationMessage,
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Search error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tìm kiếm: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ XỬ LÝ CHẤP NHẬN/TỪ CHỐI LỜI MỜI
     */
    public function respondToInvitation(Request $request, $invitationId)
    {
        try {
            $user = Auth::user();

            Log::info('🔐 respondToInvitation called', [
                'invitationId' => $invitationId,
                'auth_check' => Auth::check(),
                'auth_user' => $user?->id,
                'session_id' => session()->getId()
            ]);

            // Tìm invitation
            $invitation = JobInvitation::with(['job', 'applicant'])
                ->find($invitationId);

            if (!$invitation) {
                Log::error('❌ Invitation not found', ['invitationId' => $invitationId]);
                return response()->json([
                    'success' => false,
                    'message' => 'Lời mời không tồn tại'
                ], 404);
            }

            Log::info('✅ Invitation found', [
                'invitation_id' => $invitation->id,
                'applicant_id' => $invitation->applicant_id,
                'applicant_user_id' => $invitation->applicant->user_id,
                'auth_user_id' => $user?->id
            ]);

            // Kiểm tra quyền: nếu đã đăng nhập, phải là applicant của invitation này
            if ($user && $invitation->applicant->user_id !== $user->id) {
                Log::warning('⚠️ User tried to update someone else\'s invitation', [
                    'user_id' => $user->id,
                    'invitation_applicant_user_id' => $invitation->applicant->user_id
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền thực hiện hành động này'
                ], 403);
            }

            $response = $request->input('response'); // 'accepted' or 'rejected'

            if (!in_array($response, ['accepted', 'rejected'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Phản hồi không hợp lệ'
                ], 400);
            }

            // Cập nhật invitation status
            $updated = $invitation->update([
                'status' => $response,
                'responded_at' => now(),
                'response_message' => $request->input('message', '')
            ]);

            Log::info('✅ Invitation updated', [
                'invitation_id' => $invitation->id,
                'new_status' => $response,
                'updated' => $updated,
                'user_id' => $user?->id
            ]);

            // ✅ TẠO THÔNG BÁO CHO NTD (EMPLOYER)
            if ($invitation->job && $invitation->job->company) {
                $company = $invitation->job->company;
                $employer = $company->employer; // Lấy employer từ company

                if ($employer && $employer->user_id) {
                    if ($response === 'accepted') {
                        Notification::createInvitationAcceptedNotification(
                            $employer->user_id,
                            $invitation
                        );
                    } else {
                        Notification::createInvitationRejectedNotification(
                            $employer->user_id,
                            $invitation
                        );
                    }
                }
            }

            Log::info('✅ Job invitation updated', [
                'invitation_id' => $invitationId,
                'status' => $response
            ]);

            $message = $response === 'accepted'
                ? 'Bạn đã chấp nhận lời mời'
                : 'Bạn đã từ chối lời mời';

            return response()->json([
                'success' => true,
                'message' => $message,
                'invitation_id' => $invitationId,
                'status' => $response
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error responding to invitation', [
                'error' => $e->getMessage(),
                'invitation_id' => $invitationId
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    // ========== GET PENDING INVITATION COUNT ==========
    public function getPendingInvitationCount()
    {
        try {
            // Check nếu user chưa login
            if (!Auth::check()) {
                return response()->json(['count' => 0]);
            }

            $user = Auth::user();

            // Lấy số lời mời ứng tuyển đang pending (chờ phản hồi)
            $pendingCount = JobInvitation::where('applicant_id', $user->id)
                ->where('status', 'pending')
                ->count();

            return response()->json([
                'count' => $pendingCount,
                'success' => true
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error getting pending invitation count', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'count' => 0,
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
