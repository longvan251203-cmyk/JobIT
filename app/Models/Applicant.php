<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $table = 'applicants';

    // Khóa chính thực sự
    protected $primaryKey = 'id_uv';

    // Nếu khóa không tự tăng
    // public $incrementing = false;

    protected $fillable = [
        'user_id',
        'hoten_uv',
        'chucdanh',
        'ngaysinh',
        'sdt_uv',
        'gioitinh_uv',
        'diachi_uv',
        'avatar',
        'cv',          // thêm nếu bạn lưu CV
        'gioithieu',
        'mucluong_mongmuon',
    ];

    protected $casts = [
        'ngaysinh' => 'date',
    ];

    // ==================== RELATIONSHIPS ====================

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship với Applications (Đơn ứng tuyển)
     */
    public function applications()
    {
        return $this->hasMany(Application::class, 'applicant_id', 'id_uv');
    }

    /**
     * Relationship với SavedJobs (Việc làm đã lưu)
     */
    public function savedJobs()
    {
        return $this->hasMany(SavedJob::class, 'applicant_id', 'id_uv');
    }

    /**
     * Relationship với Kinh nghiệm làm việc
     * Tên bảng: kinh_nghiem
     */
    public function kinhnghiem()
    {
        return $this->hasMany(KinhNghiem::class, 'applicant_id', 'id_uv')
            ->orderBy('tu_ngay', 'desc');
    }

    /**
     * Relationship với Học vấn
     * Tên bảng: hoc_van
     */
    public function hocvan()
    {
        return $this->hasMany(HocVan::class, 'applicant_id', 'id_uv')
            ->orderBy('tu_ngay', 'desc');
    }

    /**
     * Relationship với Kỹ năng
     * Tên bảng: ky_nang
     */
    public function kynang()
    {
        return $this->hasMany(KyNang::class, 'applicant_id', 'id_uv');
    }
    public function ngoaiNgu()
    {
        return $this->hasMany(NgoaiNgu::class, 'applicant_id', 'id_uv')
            ->orderBy('created_at', 'desc');
    }
    public function duan()
    {
        return $this->hasMany(DuAn::class, 'applicant_id', 'id_uv')
            ->orderBy('ngay_bat_dau', 'desc');
    }

    public function chungchi()
    {
        return $this->hasMany(ChungChi::class, 'applicant_id', 'id_uv')
            ->orderBy('created_at', 'desc');
    }
    public function giaithuong()
    {
        return $this->hasMany(GiaiThuong::class, 'applicant_id', 'id_uv')
            ->orderBy('thoigian', 'desc');
    }
    /**
     * Get avatar URL
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('assets/img/avt/' . $this->avatar);
        }
        return asset('assets/img/avt/default-avatar.png');
    }

    /**
     * Get age from birthdate
     */
    public function getAgeAttribute()
    {
        if (!$this->ngaysinh) {
            return null;
        }
        return $this->ngaysinh->age;
    }
}
