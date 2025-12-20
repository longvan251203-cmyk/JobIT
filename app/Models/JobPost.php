<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class JobPost extends Model
{
    use HasFactory;

    protected $table = 'job_post';
    protected $primaryKey = 'job_id';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'companies_id',
        'level',
        'experience',
        'salary_min',
        'salary_max',
        'salary_type',
        'working_type',
        'recruitment_count',
        'province',
        'district',
        'address_detail',
        'foreign_language',
        'language_level',
        'deadline',
        'description',
        'responsibilities',
        'requirements',
        'benefits',
        'gender_requirement',
        'working_environment',
        'contact_method'
    ];

    // ✅ Tự động append các accessor vào JSON
    protected $appends = ['selected_count', 'remaining_count', 'experience_label', 'foreign_language_label', 'language_level_label'];

    /**
     * Scope: Chỉ lấy jobs còn hạn và đang active
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('deadline', '>=', Carbon::now()->toDateString());
    }

    /**
     * Scope: Chỉ lấy jobs sắp hết hạn (còn <= 3 ngày)
     */
    public function scopeExpiringSoon($query)
    {
        $today = Carbon::now()->toDateString();
        $threeDaysLater = Carbon::now()->addDays(3)->toDateString();

        return $query->where('status', 'active')
            ->whereBetween('deadline', [$today, $threeDaysLater]);
    }
    // ✅ Sửa tên method cho chuẩn
    public function company()
    {
        return $this->belongsTo(Company::class, 'companies_id', 'companies_id');
    }

    // ✅ THÊM ACCESSOR ĐƠN GIẢN - Tự động chuyển đổi experience
    public function getExperienceLabelAttribute()
    {
        $labels = [
            'no_experience' => 'Không yêu cầu',
            'under_1' => 'Dưới 1 năm',
            '1_2' => '1-2 năm',
            '2_5' => '2-5 năm',
            '5_plus' => 'Trên 5 năm',
        ];

        return $labels[$this->experience] ?? $this->experience;
    }

    // ✅ THÊM ACCESSOR - Chuyển đổi foreign_language
    public function getForeignLanguageLabelAttribute()
    {
        $labels = [
            'no_requirement' => 'Không yêu cầu',
            'english' => 'Tiếng Anh',
            'japanese' => 'Tiếng Nhật',
            'korean' => 'Tiếng Hàn',
            'chinese' => 'Tiếng Trung',
            'french' => 'Tiếng Pháp',
            'german' => 'Tiếng Đức',
            'spanish' => 'Tiếng Tây Ban Nha',
            'russian' => 'Tiếng Nga',
            'thai' => 'Tiếng Thái',
            'indonesian' => 'Tiếng Indonesia',
        ];

        return $labels[$this->foreign_language] ?? $this->foreign_language;
    }

    // ✅ THÊM ACCESSOR - Chuyển đổi language_level
    public function getLanguageLevelLabelAttribute()
    {
        $labels = [
            'basic' => 'Sơ cấp',
            'intermediate' => 'Trung cấp',
            'advanced' => 'Cao cấp',
            'fluent' => 'Thành thạo',
            'native' => 'Bản ngữ',
        ];

        return $labels[$this->language_level] ?? $this->language_level;
    }

    public function detail()
    {
        return $this->hasOne(JobDetail::class, 'job_id');
    }
    public function hashtags()
    {
        return $this->belongsToMany(
            JobHashtag::class,           // Related model
            'job_post_hashtag',          // Pivot table name
            'job_post_id',               // Foreign key của JobPost trong pivot
            'job_hashtag_id',            // Foreign key của JobHashtag trong pivot
            'job_id',                    // Local key của JobPost
            'hashtag_id'                 // Local key của JobHashtag (primary key của job_hashtag)
        );
    }

    public function applications()
    {
        return $this->hasMany(\App\Models\Application::class, 'job_id', 'job_id');
    }

    /**
     * ✅ Lấy số lượng ứng viên đã được chọn (status = duoc_chon)
     */
    public function getSelectedCountAttribute()
    {
        return \App\Models\Application::where('job_id', $this->job_id)
            ->where('trang_thai', 'duoc_chon')
            ->count();
    }

    /**
     * ✅ Kiểm tra xem job đã đủ số lượng tuyển dụng không
     */
    public function isRecruitmentComplete()
    {
        return $this->selected_count >= $this->recruitment_count;
    }

    /**
     * ✅ Lấy số lượng còn lại cần tuyển
     */
    public function getRemainingCountAttribute()
    {
        $remaining = $this->recruitment_count - $this->selected_count;
        return $remaining > 0 ? $remaining : 0;
    }
}
