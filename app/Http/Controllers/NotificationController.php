<?php
// app/Http/Controllers/NotificationController.php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * ✅ LẤY DANH SÁCH THÔNG BÁO
     */
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'notifications' => $notifications,
            'unread_count' => $notifications->where('is_read', false)->count()
        ]);
    }

    /**
     * ✅ ĐẾM SỐ THÔNG BÁO CHƯA ĐỌC
     */
    public function unreadCount()
    {
        $count = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }

    /**
     * ✅ ĐÁNH DẤU ĐÃ ĐỌC
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notification->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Đã đánh dấu đã đọc'
        ]);
    }

    /**
     * ✅ ĐÁNH DẤU TẤT CẢ ĐÃ ĐỌC
     */
    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Đã đánh dấu tất cả đã đọc'
        ]);
    }

    /**
     * ✅ XÓA THÔNG BÁO
     */
    public function delete($id)
    {
        Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa thông báo'
        ]);
    }
}
