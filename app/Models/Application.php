<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    /**
     * ✅ KIỂM TRA JOB ĐÃ HẾT HẠN CHƯA
     */
    public function isJobExpired()
    {
        if (!$this->job || !$this->job->deadline) {
            return false;
        }

        return Carbon::parse($this->job->deadline)->endOfDay()->isPast();
    }

    /**
     * ✅ LẤY TRẠNG THÁI HIỂN THỊ (BAO GỒM CẢ HẾT HẠN)
     */
    public function getDisplayStatus()
    {


        // Trạng thái bình thường
        $statusMap = [
            'cho_xu_ly' => [
                'status' => 'cho_xu_ly',
                'class' => 'pending',
                'icon' => 'bi-hourglass-split',
                'text' => 'Chờ xử lý',
                'description' => 'Hồ sơ đang chờ nhà tuyển dụng xem xét'
            ],
            'dang_phong_van' => [
                'status' => 'dang_phong_van',
                'class' => 'interview',
                'icon' => 'bi-calendar-check',
                'text' => 'Mời phỏng vấn',
                'description' => 'Bạn đã được mời phỏng vấn'
            ],
            'duoc_chon' => [
                'status' => 'duoc_chon',
                'class' => 'accepted',
                'icon' => 'bi-check-circle-fill',
                'text' => 'Được chọn',
                'description' => 'Chúc mừng! Bạn đã được tuyển dụng'
            ],
            'khong_phu_hop' => [
                'status' => 'khong_phu_hop',
                'class' => 'rejected',
                'icon' => 'bi-x-circle-fill',
                'text' => 'Từ chối',
                'description' => 'Hồ sơ chưa phù hợp với vị trí này'
            ],
        ];

        return $statusMap[$this->trang_thai] ?? [
            'status' => 'unknown',
            'class' => 'secondary',
            'icon' => 'bi-question-circle',
            'text' => 'Không xác định',
            'description' => 'Trạng thái không rõ'
        ];
    }

    /**
     * ✅ LẤY BADGE HTML CHO STATUS
     */
    public function getStatusBadgeAttribute()
    {
        $status = $this->getDisplayStatus();
        $badgeMap = [
            'pending' => 'warning',
            'interview' => 'info',
            'accepted' => 'success',
            'rejected' => 'danger',
            'expired' => 'secondary',
            'secondary' => 'secondary'
        ];

        $badgeClass = $badgeMap[$status['class']] ?? 'secondary';

        return '<span class="badge bg-' . $badgeClass . '">' . $status['text'] . '</span>';
    }

    /**
     * ✅ LẤY TÊN TRẠNG THÁI
     */
    public function getStatusNameAttribute()
    {
        return $this->getDisplayStatus()['text'];
    }
}
