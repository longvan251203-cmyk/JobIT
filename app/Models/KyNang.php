<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KyNang extends Model
{
    use HasFactory;

    // Tên bảng trong database
    protected $table = 'ky_nang'; // Hoặc 'skills' tùy theo tên bảng của bạn

    protected $primaryKey = 'id_kynang'; // Hoặc tên primary key của bạn

    public $timestamps = true;

    protected $fillable = [
        'applicant_id',
        'ten_ky_nang',        // Tên kỹ năng
        'nam_kinh_nghiem',    // Số năm kinh nghiệm
        'mo_ta',              // Mô tả chi tiết
    ];

    protected $casts = [
        'nam_kinh_nghiem' => 'integer',
    ];

    // Relationship với Applicant
    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id', 'id_uv');
    }
}
