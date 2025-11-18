<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $table = 'applications';
    protected $primaryKey = 'application_id';

    protected $fillable = [
        'job_id',
        'applicant_id',
        'company_id',
        'cv_type',
        'cv_file_path',
        'hoten',
        'email',
        'sdt',
        'diachi',
        'thu_gioi_thieu',
        'trang_thai',
        'ghi_chu',
        'ngay_ung_tuyen' // THÊM DÒNG NÀY
    ];

    protected $casts = [
        'ngay_ung_tuyen' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function job()
    {
        return $this->belongsTo(JobPost::class, 'job_id', 'job_id'); // SỬA LẠI RELATIONSHIP
    }

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id', 'id_uv');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id_cty');
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('trang_thai', $status);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('ngay_ung_tuyen', 'desc');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'chua_xem' => '<span class="badge bg-secondary">Chưa xem</span>',
            'da_xem' => '<span class="badge bg-info">Đã xem</span>',
            'duoc_chon' => '<span class="badge bg-success">Được chọn</span>',
            'tu_choi' => '<span class="badge bg-danger">Từ chối</span>',
            'phong_van' => '<span class="badge bg-warning">Phỏng vấn</span>',
        ];

        return $badges[$this->trang_thai] ?? '<span class="badge bg-secondary">N/A</span>';
    }
    // THÊM VÀO class Applicant
    public function savedJobs()
    {
        return $this->hasMany(SavedJob::class, 'applicant_id', 'id_uv');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'applicant_id', 'id_uv');
    }
}
