<?php
// app/Http/Controllers/ApplicantNotificationController.php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\JobInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApplicantNotificationController extends Controller
{
    /**
     * ✅ Hiển thị trang thông báo cho ứng viên
     */
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('home', [
            'notifications' => $notifications,
            'activeTab' => 'notifications'
        ]);
    }

    /**
     * ✅ Lấy danh sách thông báo (API JSON)
     */
    public function getNotifications(Request $request)
    {
        try {
            $query = Notification::forUser(Auth::id());

            // Filter theo type nếu có
            if ($request->filled('type')) {
                $query->ofType($request->type);
            }

            // Filter theo is_read nếu có
            if ($request->filled('is_read')) {
                if ($request->is_read === 'true' || $request->is_read === '1') {
                    $query->where('is_read', true);
                } else {
                    $query->unread();
                }
            }

            $notifications = $query->recent(20)->get();

            return response()->json([
                'success' => true,
                'notifications' => $notifications,
                'unread_count' => Notification::forUser(Auth::id())->unread()->count()
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error getting notifications', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ Đếm số thông báo chưa đọc (API)
     */
    public function unreadCount()
    {
        try {
            $count = Notification::forUser(Auth::id())
                ->unread()
                ->count();

            return response()->json([
                'success' => true,
                'count' => $count
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error counting unread', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'count' => 0
            ], 500);
        }
    }

    /**
     * ✅ Đánh dấu đã đọc
     */
    public function markAsRead($id)
    {
        try {
            $notification = Notification::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $notification->update(['is_read' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Đã đánh dấu đã đọc'
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error marking as read', [
                'error' => $e->getMessage(),
                'notification_id' => $id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thông báo'
            ], 404);
        }
    }

    /**
     * ✅ Đánh dấu tất cả đã đọc
     */
    public function markAllAsRead()
    {
        try {
            $updated = Notification::forUser(Auth::id())
                ->unread()
                ->update(['is_read' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Đã đánh dấu tất cả đã đọc',
                'updated_count' => $updated
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error marking all as read', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ Xóa thông báo
     */
    public function delete($id)
    {
        try {
            $notification = Notification::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $notification->delete();

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa thông báo'
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error deleting notification', [
                'error' => $e->getMessage(),
                'notification_id' => $id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thông báo'
            ], 404);
        }
    }

    /**
     * ✅ Lấy chi tiết lời mời job
     */
    public function getInvitationDetail($invitationId)
    {
        try {
            $applicant = Auth::user()->applicant;

            if (!$applicant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy hồ sơ ứng viên'
                ], 404);
            }

            $invitation = JobInvitation::with(['job.company', 'job.applications'])
                ->where('id', $invitationId)
                ->where('applicant_id', $applicant->id_uv)
                ->firstOrFail();

            // Format salary
            $salaryRange = 'Thỏa thuận';
            if ($invitation->job->salary_min && $invitation->job->salary_max) {
                $salaryRange = number_format($invitation->job->salary_min, 0, ',', '.') . ' - ' .
                    number_format($invitation->job->salary_max, 0, ',', '.') . ' VNĐ';
            }

            return response()->json([
                'success' => true,
                'invitation' => [
                    'id' => $invitation->id,
                    'status' => $invitation->status,
                    'message' => $invitation->message,
                    'invited_at' => $invitation->invited_at,
                    'job' => [
                        'id' => $invitation->job->job_id,
                        'title' => $invitation->job->title,
                        'description' => $invitation->job->job_description,
                        'requirements' => $invitation->job->requirements,
                        'benefits' => $invitation->job->benefits,
                        'salary_range' => $salaryRange,
                        'location' => $invitation->job->province . ($invitation->job->district ? ', ' . $invitation->job->district : ''),
                        'deadline' => $invitation->job->deadline,
                        'recruitment_count' => $invitation->job->recruitment_count,
                        'applications_count' => $invitation->job->selected_count
                    ],
                    'company' => [
                        'id' => $invitation->job->company->companies_id,
                        'name' => $invitation->job->company->ten_cty,
                        'logo' => $invitation->job->company->logo ? asset('storage/' . $invitation->job->company->logo) : null,
                        'address' => $invitation->job->company->dia_chi_ct,
                        'website' => $invitation->job->company->website,
                        'employee_count' => $invitation->job->company->quy_mo
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error getting invitation detail', [
                'error' => $e->getMessage(),
                'invitation_id' => $invitationId
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy lời mời'
            ], 404);
        }
    }
}
