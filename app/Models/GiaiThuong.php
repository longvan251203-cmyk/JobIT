<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiaiThuong extends Model
{
    use HasFactory;

    protected $table = 'giai_thuong';
    protected $primaryKey = 'id_giaithuong';

    public $timestamps = true;

    protected $fillable = [
        'applicant_id',
        'ten_giaithuong',
        'to_chuc',
        'thoigian',
        'mo_ta',
    ];

    protected $casts = [
        'thoigian' => 'date',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id', 'id_uv');
    }
}
