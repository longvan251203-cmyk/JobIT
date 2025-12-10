<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    protected $table = 'employers';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'companies_id',  // ✅ THÊM COLUMN NÀY
        'hoten_daidien',
        'gioitinh',
        'sdt'
    ];

    // ============ RELATIONSHIPS ============

    /**
     * Employer thuộc về 1 User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Employer thuộc về 1 Company
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'companies_id', 'companies_id');
    }
}
