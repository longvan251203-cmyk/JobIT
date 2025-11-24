<?php
// app/Models/Notification.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'message',
        'data',
        'is_read'
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'created_at' => 'datetime'
    ];

    // Relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Helper methods
    public static function createNewApplicationNotification($employerUserId, $application)
    {
        return self::create([
            'user_id' => $employerUserId,
            'type' => 'new_application',
            'message' => "Có ứng viên mới ứng tuyển vào vị trí: {$application->job->title}",
            'data' => [
                'job_id' => $application->job_id,
                'application_id' => $application->application_id,
                'applicant_name' => $application->hoten,
                'job_title' => $application->job->title
            ]
        ]);
    }

    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
