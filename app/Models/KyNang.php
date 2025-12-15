<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KyNang extends Model
{
    use HasFactory;

    // Tên bảng trong database
    protected $table = 'ky_nang';

    // Primary key
    protected $primaryKey = 'id';

    // Timestamps
    public $timestamps = true;

    // Cho phép mass assignment
    protected $fillable = [
        'applicant_id',
        'ten_ky_nang',        // Tên kỹ năng
        'nam_kinh_nghiem',    // Số năm kinh nghiệm
        // 'mo_ta',           // Bỏ comment nếu có cột này trong DB
    ];

    // Casting
    protected $casts = [
        'nam_kinh_nghiem' => 'integer',
    ];

    /**
     * Relationship với Applicant
     */
    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id', 'id_uv');
    }

    /**
     * Accessor - Format hiển thị năm kinh nghiệm
     */
    public function getFormattedExperienceAttribute()
    {
        if ($this->nam_kinh_nghiem == 0) {
            return '<1 năm';
        } elseif ($this->nam_kinh_nghiem >= 10) {
            return '10+ năm';
        } else {
            return $this->nam_kinh_nghiem . ' năm';
        }
    }
}
