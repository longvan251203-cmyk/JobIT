<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Job;
use App\Models\Applicant;
use App\Models\NhaTuyenDung;

class JobInvitation extends Model
{
    use HasFactory;

    protected $table = 'job_invitations';
    protected $primaryKey = 'id';

    protected $fillable = [
        'job_id',
        'applicant_id',
        'company_id',
        'status',
        'message',
        'invited_at',
        'responded_at',
        'response_message'
    ];

    protected $casts = [
        'invited_at' => 'datetime',
        'responded_at' => 'datetime',
    ];

    protected $dates = ['invited_at', 'responded_at'];

    // ============ RELATIONSHIPS ============

    /**
     * Relationship: Job
     */
    public function job()
    {
        return $this->belongsTo(JobPost::class, 'job_id', 'id');
    }

    /**
     * Relationship: Applicant
     */
    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id', 'id_uv');
    }

    /**
     * Relationship: Company
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    // ============ SCOPES ============

    /**
     * Scope: Pending invitations
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Accepted invitations
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    /**
     * Scope: Rejected invitations
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope: Expired invitations
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    // ============ METHODS ============

    /**
     * Check if invitation is expired (30 days)
     */
    public function isExpired()
    {
        if (!$this->invited_at) return false;

        return $this->invited_at->addDays(30)->isPast()
            && $this->status === 'pending';
    }

    /**
     * Mark as expired
     */
    public function markAsExpired()
    {
        $this->update(['status' => 'expired']);
    }

    /**
     * Accept invitation
     */
    public function accept($message = null)
    {
        $this->update([
            'status' => 'accepted',
            'responded_at' => now(),
            'response_message' => $message
        ]);
    }

    /**
     * Reject invitation
     */
    public function reject($message = null)
    {
        $this->update([
            'status' => 'rejected',
            'responded_at' => now(),
            'response_message' => $message
        ]);
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColor()
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'accepted' => 'green',
            'rejected' => 'red',
            'expired' => 'gray',
            default => 'gray'
        };
    }

    /**
     * Get status label in Vietnamese
     */
    public function getStatusLabel()
    {
        return match ($this->status) {
            'pending' => 'Chờ phản hồi',
            'accepted' => 'Chấp nhận',
            'rejected' => 'Từ chối',
            'expired' => 'Hết hạn',
            default => 'Không xác định'
        };
    }
}
