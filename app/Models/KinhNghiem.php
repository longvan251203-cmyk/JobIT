<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KinhNghiem extends Model
{
    use HasFactory;

    protected $table = 'kinh_nghiem';

    // Primary key là id_kn
    protected $primaryKey = 'id_kn';

    protected $fillable = [
        'applicant_id',
        'chucdanh',
        'congty',
        'dang_lam_viec',
        'tu_ngay',
        'den_ngay',
        'mota',
        'duan',
    ];

    protected $casts = [
        'dang_lam_viec' => 'boolean',
        'tu_ngay' => 'date',
        'den_ngay' => 'date',
    ];

    // Quan hệ với Applicant
    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id', 'id_uv');
    }
}
