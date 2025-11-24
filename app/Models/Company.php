<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';
    protected $primaryKey = 'companies_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'employer_id',
        'tencty',
        'quoctich_cty',
        'tagline_cty',
        'quymo',
        'mota_cty',
        'website_cty',
        'mxh_cty',
        'tinh_thanh',
        'chedodaingo',
        'email_cty',
        'sdt_cty',
        'quan_huyen',
        'dia_chi_cu_the',
        'logo',      // ✅ Thêm
        'banner'     // ✅ Thêm
    ];

    public function employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id');
    }

    // ✅ Thêm relationship với JobPost
    public function jobPosts()
    {
        return $this->hasMany(JobPost::class, 'companies_id', 'companies_id');
    }

    // ✅ Thêm relationship với NhanVienCty
    public function nhanViens()
    {
        return $this->hasMany(NhanVienCty::class, 'companies_id', 'companies_id');
    }
    public function user()
    {
        return $this->hasOneThrough(
            User::class,
            Employer::class,
            'id',           // Foreign key on employers table
            'user_id',      // Foreign key on users table
            'employer_id',  // Local key on companies table
            'user_id'       // Local key on employers table
        );
    }
}
