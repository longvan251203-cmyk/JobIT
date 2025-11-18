<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NgoaiNgu extends Model
{
    use HasFactory;

    // Tên bảng trong database
    protected $table = 'ngoai_ngu';

    // Khóa chính
    protected $primaryKey = 'ngoai_ngu_id';

    // Laravel tự động quản lý created_at & updated_at
    public $timestamps = true;

    // Các cột có thể gán giá trị trực tiếp
    protected $fillable = [
        'applicant_id',
        'ten_ngoai_ngu',
        'trinh_do',
    ];

    // Relationship với Applicant
    public function applicant()
    {
        // Nếu model Applicant của bạn là App\Models\Applicant
        return $this->belongsTo(Applicant::class, 'applicant_id', 'id_uv');
    }
}
