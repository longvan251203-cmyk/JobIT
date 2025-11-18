<?php
// app/Models/HocVan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HocVan extends Model
{
    use HasFactory;

    protected $table = 'hoc_van'; // ⚠️ Sửa lại cho đúng tên bảng
    protected $primaryKey = 'id_hocvan';
    public $timestamps = true;

    protected $fillable = [
        'applicant_id',
        'truong',
        'trinhdo',
        'nganh',
        'dang_hoc',
        'tu_ngay',
        'den_ngay',
        'thongtin_khac',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id', 'id_uv');
    }
}
