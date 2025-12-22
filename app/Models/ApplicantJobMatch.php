<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantJobMatch extends Model
{
    protected $table = 'applicant_job_matches';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'company_id',
        'applicant_id',
        'job_id',
        'match_score',
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

    public function job()
    {
        return $this->belongsTo(JobPost::class, 'job_id', 'job_id');
    }
}
