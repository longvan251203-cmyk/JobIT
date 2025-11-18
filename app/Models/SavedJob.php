<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedJob extends Model
{
    use HasFactory;

    protected $table = 'saved_jobs';

    protected $fillable = [
        'applicant_id',
        'job_id'
    ];

    // Relationships
    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id', 'id_uv');
    }

    public function job()
    {
        return $this->belongsTo(JobPost::class, 'job_id', 'job_id');
    }
}
