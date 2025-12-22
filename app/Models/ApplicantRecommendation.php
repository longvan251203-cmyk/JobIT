<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantRecommendation extends Model
{
    protected $table = 'applicant_recommendations';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'company_id',
        'applicant_id',
        'best_score',
        'match_details',
    ];

    protected $casts = [
        'match_details' => 'array',
    ];

    // Relationships (optional)
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'companies_id');
    }

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id', 'id_uv');
    }
}
