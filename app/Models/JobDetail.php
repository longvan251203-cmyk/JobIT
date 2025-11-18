<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobDetail extends Model
{
    use HasFactory;

    protected $table = 'job_post_detail';
    protected $primaryKey = 'detail_id';
    public $timestamps = false;

    protected $fillable = [
        'job_id',
        'description',
        'responsibilities',
        'requirements',
        'benefits',
        'gender_requirement',
        'contact_method',
        'working_environment'
    ];

    public function job()
    {
        return $this->belongsTo(JobPost::class, 'job_id');
    }
}
