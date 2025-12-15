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

    // ✅ HELPER METHODS để lấy thông tin công ty
    /**
     * Get company name (tên công ty)
     */
    public function getTenCty()
    {
        return $this->tencty;
    }

    /**
     * Get company scale (quy mô)
     */
    public function getQuyMo()
    {
        return $this->quymo;
    }

    /**
     * Get company address (địa chỉ)
     */
    public function getDiaChi()
    {
        return $this->dia_chi_cu_the;
    }

    /**
     * Get company phone (điện thoại)
     */
    public function getPhone()
    {
        return $this->sdt_cty;
    }

    /**
     * Get company email
     */
    public function getCompanyEmail()
    {
        return $this->email_cty;
    }

    /**
     * Get company website
     */
    public function getWebsite()
    {
        return $this->website_cty;
    }

    /**
     * Get company logo URL
     */
    public function getLogoUrl()
    {
        return $this->logo ? asset('assets/img/' . $this->logo) : null;
    }
}
