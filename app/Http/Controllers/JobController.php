<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobDetail;
use App\Models\JobPost;
use App\Models\JobHashtag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JobController extends Controller
{
    // Hiển thị chi tiết job
    public function show($id)
    {
        $job = JobPost::with(['company', 'hashtags', 'detail'])
            ->findOrFail($id);

        return view('applicant.jobdetail', compact('job'));
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
        $job = JobPost::with(['company', 'hashtags', 'detail'])
            ->where('job_id', $id)
            ->where('status', 'active')                      // 🎯 THÊM DÒNG NÀY
            ->where('deadline', '>=', now()->toDateString()) // 🎯 THÊM DÒNG NÀY
            ->first();

        if (!$job) {
            return response()->json([
                'error' => 'Công việc không tồn tại hoặc đã hết hạn' // 🎯 SỬA MESSAGE
            ], 404);
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
            'deadline' => $job->deadline,
            'gender_requirement' => $job->gender_requirement,

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
            })
        ]);
    }

    /**
     * Lấy thông tin job để edit
     */ public function edit($id)
    {
        try {
            $job = JobPost::with(['detail', 'hashtags'])->findOrFail($id);

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
            $job = JobPost::with('detail')->findOrFail($id);

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
                    'applied' => false
                ]);
            }

            $applicant = Auth::user()->applicant;

            if (!$applicant) {
                return response()->json([
                    'success' => true,
                    'applied' => false
                ]);
            }

            $application = Application::where('job_id', $id)
                ->where('applicant_id', $applicant->id_uv)
                ->first();

            return response()->json([
                'success' => true,
                'applied' => $application ? true : false,
                'application_status' => $application ? $application->trang_thai : null
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
    public function getJobsPaginated(Request $request)
    {
        try {
            $page = $request->input('page', 1);
            $perPage = 12; // Số job mỗi trang
            $jobs = JobPost::with(['company', 'hashtags'])
                ->where('status', 'active')                      // 🎯 THÊM DÒNG NÀY
                ->where('deadline', '>=', now()->toDateString()) // 🎯 THÊM DÒNG NÀY
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
    /**
     * ✅ TÌM KIẾM & LỌC JOB (AJAX)
     */
    /**
     * ✅ TÌM KIẾM & LỌC JOB (AJAX) - FIXED VERSION
     */
    /**
     * ✅ TÌM KIẾM & LỌC JOB (AJAX) - FIXED VERSION
     * Sửa lỗi: Khi chỉ chọn location mà không nhập search term thì vẫn hiển thị jobs
     */
    public function searchJobs(Request $request)
    {
        try {
            $query = JobPost::with(['company', 'hashtags', 'detail']);

            // Log input để debug
            Log::info('🔍 Search request received', [
                'all_params' => $request->all(),
                'search' => $request->input('search'),
                'location' => $request->input('location'),
                'categories' => $request->input('categories'),
                'levels' => $request->input('levels'),
                'experiences' => $request->input('experiences'),
                'working_types' => $request->input('working_types'),
            ]);

            // ✅ Đếm số lượng filters được áp dụng
            $hasFilters = false;

            // 🔍 TÌM KIẾM THEO TỪ KHÓA (tên job, công ty, kỹ năng)
            if ($request->filled('search')) {
                $hasFilters = true;
                $searchTerm = $request->input('search');

                $query->where(function ($q) use ($searchTerm) {
                    // Tìm trong title
                    $q->where('title', 'like', '%' . $searchTerm . '%')
                        // Tìm trong tên công ty
                        ->orWhereHas('company', function ($companyQuery) use ($searchTerm) {
                            $companyQuery->where('tencty', 'like', '%' . $searchTerm . '%');
                        })
                        // Tìm trong hashtags (kỹ năng)
                        ->orWhereHas('hashtags', function ($hashtagQuery) use ($searchTerm) {
                            $hashtagQuery->where('tag_name', 'like', '%' . $searchTerm . '%');
                        })
                        // Tìm trong description
                        ->orWhereHas('detail', function ($detailQuery) use ($searchTerm) {
                            $detailQuery->where('description', 'like', '%' . $searchTerm . '%')
                                ->orWhere('requirements', 'like', '%' . $searchTerm . '%');
                        });
                });

                Log::info('✅ Search term applied', ['term' => $searchTerm]);
            }

            // 🗺️ LỌC THEO ĐỊA ĐIỂM (hoạt động độc lập với search)
            if ($request->filled('location')) {
                $hasFilters = true;
                $location = $request->input('location');
                $query->where('province', $location);

                Log::info('✅ Location filter applied', ['location' => $location]);
            }

            // 📁 LỌC THEO DANH MỤC (categories - mapping với hashtags)
            if ($request->filled('categories')) {
                $hasFilters = true;
                $categories = explode(',', $request->input('categories'));

                // Map category với hashtags phổ biến
                $categoryMap = [
                    'backend' => ['php', 'laravel', 'nodejs', 'python', 'java', 'spring', 'c#', '.net', 'ruby', 'go'],
                    'frontend' => ['react', 'vuejs', 'vue', 'angular', 'javascript', 'html', 'css', 'typescript', 'nextjs'],
                    'fullstack' => ['fullstack', 'full-stack', 'full stack'],
                    'mobile' => ['android', 'ios', 'react native', 'flutter', 'swift', 'kotlin'],
                    'devops' => ['devops', 'docker', 'kubernetes', 'aws', 'ci/cd', 'jenkins', 'terraform']
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

                Log::info('✅ Categories filter applied', ['categories' => $categories]);
            }

            // 📊 LỌC THEO CẤP BẬC
            if ($request->filled('levels')) {
                $hasFilters = true;
                $levels = explode(',', $request->input('levels'));
                $query->whereIn('level', $levels);

                Log::info('✅ Levels filter applied', ['levels' => $levels]);
            }

            // 🎯 LỌC THEO KINH NGHIỆM
            if ($request->filled('experiences')) {
                $hasFilters = true;
                $experiences = explode(',', $request->input('experiences'));
                $query->whereIn('experience', $experiences);

                Log::info('✅ Experiences filter applied', ['experiences' => $experiences]);
            }

            // 💼 LỌC THEO HÌNH THỨC LÀM VIỆC
            if ($request->filled('working_types')) {
                $hasFilters = true;
                $workingTypes = explode(',', $request->input('working_types'));
                $query->whereIn('working_type', $workingTypes);

                Log::info('✅ Working types filter applied', ['working_types' => $workingTypes]);
            }

            // ✅ Chỉ lọc status = 'active' khi có bất kỳ filter nào
            // (Nếu không có filter gì cả, frontend sẽ gọi API /api/jobs thay vì search)
            if ($hasFilters) {
                // ✅ LUÔN LỌC JOB CÒN HẠN (không cần điều kiện $hasFilters)
                $query->where('status', 'active')
                    ->where('deadline', '>=', now()->toDateString()); // 🎯 THÊM DÒNG NÀY
            }

            // Sắp xếp: Mới nhất trước
            $query->orderBy('created_at', 'desc');

            // ✅ LOG QUERY ĐỂ DEBUG
            Log::info('🔍 Final SQL Query', [
                'sql' => $query->toSql(),
                'bindings' => $query->getBindings()
            ]);

            // Phân trang
            $perPage = 12;
            $jobs = $query->paginate($perPage);

            // ✅ LOG KẾT QUẢ
            Log::info('📊 Search results', [
                'total' => $jobs->total(),
                'per_page' => $jobs->perPage(),
                'current_page' => $jobs->currentPage(),
                'has_filters' => $hasFilters,
                'job_count' => $jobs->count(),
                'sample_job_ids' => $jobs->take(5)->pluck('job_id')->toArray()
            ]);

            // ✅ Kiểm tra nếu không có kết quả
            if ($jobs->total() === 0) {
                Log::warning('⚠️ No jobs found with current filters');
            }

            // Render HTML
            $html = view('applicant.partials.job-cards', ['jobs' => $jobs])->render();
            $paginationHtml = $this->buildPaginationHtml($jobs);

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => $paginationHtml,
                'total' => $jobs->total(),
                'current_page' => $jobs->currentPage(),
                'last_page' => $jobs->lastPage(),
                'per_page' => $jobs->perPage(),
                'has_filters' => $hasFilters,
                'message' => $jobs->total() === 0 ? 'Không tìm thấy công việc phù hợp' : null
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Search error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tìm kiếm: ' . $e->getMessage(),
                'error_details' => config('app.debug') ? [
                    'message' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => basename($e->getFile())
                ] : null
            ], 500);
        }
    }
}
