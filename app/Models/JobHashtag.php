<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobHashtag extends Model
{
    use HasFactory;

    protected $table = 'job_hashtag';
    protected $primaryKey = 'hashtag_id';  // ✅ Primary key là 'hashtag_id'
    public $timestamps = false;  // ✅ Không dùng timestamps mặc dù có created_at

    protected $fillable = ['tag_name'];

    /**
     * ✅ Relationship với JobPost
     */
    public function jobs()
    {
        return $this->belongsToMany(
            JobPost::class,              // Related model
            'job_post_hashtag',          // Pivot table name
            'job_hashtag_id',            // Foreign key của JobHashtag trong pivot
            'job_post_id',               // Foreign key của JobPost trong pivot
            'hashtag_id',                // Local key của JobHashtag (primary key)
            'job_id'                     // Local key của JobPost
        );
    }
}
