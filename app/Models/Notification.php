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

    // ==================== RELATIONSHIPS ====================

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // ==================== SCOPES ====================

    /**
     * Scope: Lấy thông báo chưa đọc
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope: Lọc theo type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope: Lấy thông báo gần đây
     */
    public function scopeRecent($query, $limit = 20)
    {
        return $query->orderByDesc('created_at')->limit($limit);
    }

    /**
     * Scope: Lấy theo user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ==================== HELPER METHODS ====================

    /**
     * ✅ Tạo thông báo khi có ứng tuyển mới (cho NTD)
     */
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

    /**
     * ✅ Tạo thông báo lời mời job (cho ứng viên)
     */
    public static function createJobInvitationNotification($applicantUserId, $invitation)
    {
        $job = $invitation->job;
        $company = $job->company;

        return self::create([
            'user_id' => $applicantUserId,
            'type' => 'job_invitation',
            'message' => "{$company->ten_cty} đã mời bạn ứng tuyển vào vị trí: {$job->title}",
            'data' => [
                'invitation_id' => $invitation->id,
                'job_id' => $job->job_id,
                'job_title' => $job->title,
                'company_id' => $company->companies_id,
                'company_name' => $company->ten_cty,
                'company_logo' => $company->logo,
                'salary_min' => $job->salary_min,
                'salary_max' => $job->salary_max,
                'location' => $job->province . ($job->district ? ', ' . $job->district : ''),
                'deadline' => $job->deadline,
                'message' => $invitation->message ?? '',
                'invited_at' => $invitation->invited_at
            ]
        ]);
    }

    /**
     * ✅ Tạo thông báo khi ứng viên chấp nhận lời mời (cho NTD)
     */
    public static function createInvitationAcceptedNotification($employerUserId, $invitation)
    {
        $applicant = $invitation->applicant;
        $job = $invitation->job;

        return self::create([
            'user_id' => $employerUserId,
            'type' => 'invitation_accepted',
            'message' => "{$applicant->hoten_uv} đã chấp nhận lời mời ứng tuyển vào vị trí: {$job->title}",
            'data' => [
                'invitation_id' => $invitation->id,
                'job_id' => $job->job_id,
                'job_title' => $job->title,
                'applicant_id' => $applicant->id_uv,
                'applicant_name' => $applicant->hoten_uv,
                'applicant_avatar' => $applicant->avatar,
                'accepted_at' => now()
            ]
        ]);
    }

    /**
     * ✅ Tạo thông báo khi ứng viên từ chối lời mời (cho NTD)
     */
    public static function createInvitationRejectedNotification($employerUserId, $invitation)
    {
        $applicant = $invitation->applicant;
        $job = $invitation->job;

        return self::create([
            'user_id' => $employerUserId,
            'type' => 'invitation_rejected',
            'message' => "{$applicant->hoten_uv} đã từ chối lời mời ứng tuyển vào vị trí: {$job->title}",
            'data' => [
                'invitation_id' => $invitation->id,
                'job_id' => $job->job_id,
                'job_title' => $job->title,
                'applicant_id' => $applicant->id_uv,
                'applicant_name' => $applicant->hoten_uv,
                'rejected_at' => now()
            ]
        ]);
    }

    // ==================== ACCESSORS ====================

    /**
     * Get time ago format
     */
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get icon based on type
     */
    public function getIconAttribute()
    {
        return match ($this->type) {
            'job_invitation' => 'bi-briefcase-fill',
            'invitation_accepted' => 'bi-check-circle-fill',
            'invitation_rejected' => 'bi-x-circle-fill',
            'new_application' => 'bi-file-earmark-text-fill',
            default => 'bi-bell-fill'
        };
    }

    /**
     * Get color based on type
     */
    public function getColorAttribute()
    {
        return match ($this->type) {
            'job_invitation' => 'primary',
            'invitation_accepted' => 'success',
            'invitation_rejected' => 'danger',
            'new_application' => 'info',
            default => 'secondary'
        };
    }
}
