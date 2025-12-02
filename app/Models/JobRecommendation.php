<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobRecommendation extends Model
{
    protected $fillable = [
        'applicant_id',
        'job_id',
        'score', // Đây là tổng điểm (0-100)
        'match_details', // JSON chứa breakdown scores
        'is_viewed',
        'is_applied'
    ];

    protected $casts = [
        'match_details' => 'array',
        'is_viewed' => 'boolean',
        'is_applied' => 'boolean',
        'score' => 'decimal:2'
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

    // Accessor để lấy total_score (để code cũ vẫn chạy được)
    public function getTotalScoreAttribute()
    {
        return $this->score;
    }

    // Accessor để lấy breakdown scores từ JSON
    public function getSkillsScoreAttribute()
    {
        return $this->match_details['skills_score'] ?? 0;
    }

    public function getExperienceScoreAttribute()
    {
        return $this->match_details['experience_score'] ?? 0;
    }

    public function getLocationScoreAttribute()
    {
        return $this->match_details['location_score'] ?? 0;
    }

    public function getSalaryScoreAttribute()
    {
        return $this->match_details['salary_score'] ?? 0;
    }

    public function getEducationScoreAttribute()
    {
        return $this->match_details['education_score'] ?? 0;
    }

    public function getLanguageScoreAttribute()
    {
        return $this->match_details['language_score'] ?? 0;
    }

    // Scopes
    public function scopeHighScore($query, $minScore = 70)
    {
        return $query->where('score', '>=', $minScore);
    }

    public function scopeNotViewed($query)
    {
        return $query->where('is_viewed', false);
    }

    public function scopeNotApplied($query)
    {
        return $query->where('is_applied', false);
    }
}
