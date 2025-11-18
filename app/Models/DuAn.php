<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuAn extends Model
{
    use HasFactory;

    protected $table = 'du_an';
    protected $primaryKey = 'id_duan';
    public $timestamps = true;

    protected $fillable = [
        'applicant_id',
        'ten_duan',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'mota_duan',
        'duongdan_website',
        'dang_lam',
    ];

    protected $casts = [
        'dang_lam' => 'boolean',
        'ngay_bat_dau' => 'date',
        'ngay_ket_thuc' => 'date',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id', 'id_uv');
    }
}
