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
        'ngay_ung_tuyen',
        'rating'
    ];

    protected $casts = [
        'ngay_ung_tuyen' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ✅ CÁC TRẠNG THÁI HỢP LỆ
    const STATUS_CHO_XU_LY = 'cho_xu_ly';
    const STATUS_DANG_PHONG_VAN = 'dang_phong_van';
    const STATUS_DUOC_CHON = 'duoc_chon';
    const STATUS_KHONG_PHU_HOP = 'khong_phu_hop';

    // Relationships
    public function job()
    {
        return $this->belongsTo(JobPost::class, 'job_id', 'job_id');
    }

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id', 'id_uv');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'companies_id');
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

    // Accessor cho status badge
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'cho_xu_ly' => '<span class="badge bg-warning">Chờ xử lý</span>',
            'dang_phong_van' => '<span class="badge bg-info">Đang phỏng vấn</span>',
            'duoc_chon' => '<span class="badge bg-success">Được chọn</span>',
            'khong_phu_hop' => '<span class="badge bg-danger">Không phù hợp</span>',
        ];

        return $badges[$this->trang_thai] ?? '<span class="badge bg-secondary">N/A</span>';
    }

    // ✅ Helper method để lấy tên trạng thái
    public function getStatusNameAttribute()
    {
        $names = [
            'cho_xu_ly' => 'Chờ xử lý',
            'dang_phong_van' => 'Đang phỏng vấn',
            'duoc_chon' => 'Được chọn',
            'khong_phu_hop' => 'Không phù hợp',
        ];

        return $names[$this->trang_thai] ?? 'N/A';
    }
}
