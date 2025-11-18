<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChungChi extends Model
{
    use HasFactory;

    protected $table = 'chung_chi';
    protected $primaryKey = 'id_chungchi';

    protected $fillable = [
        'applicant_id',
        'ten_chungchi',
        'to_chuc',
        'thoigian',
        'link_chungchi',
        'mo_ta',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id', 'id_uv');
    }
}
