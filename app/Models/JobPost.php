<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'deadline',
        'description',
        'responsibilities',
        'requirements',
        'benefits',
        'gender_requirement',
        'working_environment',
        'contact_method'
    ];

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
}
