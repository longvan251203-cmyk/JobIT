<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhanVienCty extends Model
{
    protected $table = 'nhanviencty';
    protected $primaryKey = 'ma_nv';
    public $timestamps = false;

    protected $fillable = [
        'ten_nv',
        'chucvu',
        'email_nv',
        'sdt_nv',
        'companies_id'
    ];

    // ✅ Thêm relationship với Company
    public function company()
    {
        return $this->belongsTo(Company::class, 'companies_id', 'companies_id');
    }
}
