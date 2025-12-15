# 📋 LOGIC: CHẤP NHẬN LỜI MỜI + ỨNG TUYỂN

## 🎯 OVERVIEW
Khi ứng viên **chấp nhận lời mời** trên trang `job-invitations`, hệ thống thực hiện 2 bước:
1. **Chấp nhận lời mời** (Update invitation status = 'accepted')
2. **Gửi form ứng tuyển** (Create application + gửi thông báo cho NTD)

---

## 🔄 FLOW DIAGRAM

```
┌─────────────────────────────────────────┐
│  JOB INVITATIONS PAGE                   │
│  (job-invitations.blade.php)            │
└─────────────────┬───────────────────────┘
                  │
                  ▼
        ┌─────────────────────┐
        │ Nút "Chấp nhận"      │
        │ (btn-accept)        │
        └────────┬────────────┘
                 │
                 ▼
    ┌──────────────────────────────────┐
    │ respondToInvitation()            │
    │ (API: POST /api/job-invitations) │
    │                                  │
    │ ✅ Update: invitation.status     │
    │    = 'accepted'                  │
    │ ✅ Create notification for NTD  │
    └────────┬─────────────────────────┘
             │
             ▼
    ┌──────────────────────────────────┐
    │ Return: {success: true}          │
    │ + message + status               │
    └────────┬─────────────────────────┘
             │
             ▼
    ┌──────────────────────────────────┐
    │ JavaScript: .then()              │
    │ - Update button UI                │
    │ - Show toast: "Đã chấp nhận"     │
    │ - Reload page (optional)         │
    └──────────────────────────────────┘
```

---

## 📊 THÀNH PHẦN CHÍNH

### 1️⃣ FRONTEND: job-invitations.blade.php

#### **HTML - Nút Action**
```html
@if($invitation->status === 'pending')
<div class="action-buttons">
    <button class="btn-action btn-accept" 
            onclick="respondToInvitation({{ $invitation->id }}, 'accepted')">
        <i class="bi bi-check-lg"></i>
        <span>Chấp nhận</span>
    </button>
    <button class="btn-action btn-reject" 
            onclick="respondToInvitation({{ $invitation->id }}, 'rejected')">
        <i class="bi bi-x-lg"></i>
        <span>Từ chối</span>
    </button>
</div>
@endif
```

#### **JavaScript - respondToInvitation()**
```javascript
function respondToInvitation(invitationId, response) {
    // 1. Xác nhận hành động
    if (!confirm(`Bạn chắc chắn muốn ${response === 'accepted' ? 'chấp nhận' : 'từ chối'} lời mời này?`)) {
        return;
    }

    // 2. Lấy CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // 3. Gửi API request
    fetch(`/api/job-invitations/${invitationId}/respond`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            response: response,      // 'accepted' or 'rejected'
            message: ''
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // ✅ Thành công
            showToast(data.message, 'success');
            
            // ⏱️ Reload page sau 1.5 giây
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            // ❌ Lỗi
            showToast(data.message || 'Có lỗi xảy ra', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Có lỗi xảy ra khi xử lý yêu cầu', 'error');
    });
}
```

---

### 2️⃣ BACKEND: JobController.respondToInvitation()

#### **Endpoint**: `POST /api/job-invitations/{id}/respond`

#### **Route** (routes/api.php)
```php
Route::post('/job-invitations/{id}/respond', [JobController::class, 'respondToInvitation']);
```

#### **Controller Logic** (JobController.php)
```php
public function respondToInvitation(Request $request, $invitationId)
{
    try {
        $user = Auth::user();

        Log::info('🔐 respondToInvitation called', [
            'invitationId' => $invitationId,
            'auth_check' => Auth::check(),
            'auth_user' => $user?->id,
            'session_id' => session()->getId()
        ]);

        // ✅ BỨC 1: TÌM INVITATION
        $invitation = JobInvitation::with(['job', 'applicant'])
            ->find($invitationId);

        if (!$invitation) {
            Log::error('❌ Invitation not found', ['invitationId' => $invitationId]);
            return response()->json([
                'success' => false,
                'message' => 'Lời mời không tồn tại'
            ], 404);
        }

        Log::info('✅ Invitation found', [
            'invitation_id' => $invitation->id,
            'applicant_id' => $invitation->applicant_id,
            'applicant_user_id' => $invitation->applicant->user_id,
            'auth_user_id' => $user?->id
        ]);

        // ✅ BƯỚC 2: KIỂM TRA QUYỀN
        // Người dùng phải là applicant của lời mời này
        if ($user && $invitation->applicant->user_id !== $user->id) {
            Log::warning('⚠️ User tried to update someone else\'s invitation', [
                'user_id' => $user->id,
                'invitation_applicant_user_id' => $invitation->applicant->user_id
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền thực hiện hành động này'
            ], 403);
        }

        // ✅ BƯỚC 3: VALIDATE RESPONSE
        $response = $request->input('response'); // 'accepted' or 'rejected'

        if (!in_array($response, ['accepted', 'rejected'])) {
            return response()->json([
                'success' => false,
                'message' => 'Phản hồi không hợp lệ'
            ], 400);
        }

        // ✅ BƯỚC 4: CẬP NHẬT INVITATION STATUS
        $updated = $invitation->update([
            'status' => $response,                    // 'accepted' or 'rejected'
            'responded_at' => now(),
            'response_message' => $request->input('message', '')
        ]);

        Log::info('✅ Invitation updated', [
            'invitation_id' => $invitation->id,
            'new_status' => $response,
            'updated' => $updated,
            'user_id' => $user?->id
        ]);

        // ✅ BƯỚC 5: TẠO THÔNG BÁO CHO NTD (EMPLOYER)
        if ($invitation->job && $invitation->job->company) {
            $employer = $invitation->job->company->employer;

            if ($response === 'accepted') {
                // Thông báo: Ứng viên đã chấp nhận lời mời
                Notification::createInvitationAcceptedNotification(
                    $employer->user_id,
                    $invitation
                );
            } else {
                // Thông báo: Ứng viên đã từ chối lời mời
                Notification::createInvitationRejectedNotification(
                    $employer->user_id,
                    $invitation
                );
            }
        }

        Log::info('✅ Job invitation updated', [
            'invitation_id' => $invitation->id,
            'job_id' => $invitation->job_id,
            'applicant_id' => $invitation->applicant_id,
            'status' => $response
        ]);

        // ✅ BƯỚC 6: TRẢ VỀ RESPONSE
        $message = $response === 'accepted'
            ? '✅ Bạn đã chấp nhận lời mời! Hãy hoàn tất hồ sơ ứng tuyển.'
            : '❌ Bạn đã từ chối lời mời!';

        return response()->json([
            'success' => true,
            'message' => $message,
            'status' => $response
        ]);

    } catch (\Exception $e) {
        Log::error('❌ Error responding to invitation', [
            'error' => $e->getMessage(),
            'invitation_id' => $invitationId
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
        ], 500);
    }
}
```

---

## 🗂️ DATABASE - INVITATION STATUS FLOW

### **Job Invitations Table**
```
┌─────────────────────────────────────────────────────────┐
│ job_invitations                                         │
├─────────────────────────────────────────────────────────┤
│ id                  | INT (Primary Key)                 │
│ job_id              | INT (Foreign Key)                 │
│ applicant_id        | INT (Foreign Key)                 │
│ company_id          | INT                               │
│ status              | ENUM (pending, accepted, rejected)│
│ message             | TEXT (Lời mời từ NTD)            │
│ invited_at          | DATETIME                          │
│ responded_at        | DATETIME (NULL → Sau khi chấp nhận)│
│ response_message    | TEXT (Tin nhắn từ ứng viên)       │
│ created_at          | TIMESTAMP                         │
│ updated_at          | TIMESTAMP                         │
└─────────────────────────────────────────────────────────┘

✅ PENDING (Chờ phản hồi)
   ├─ invited_at: 2025-12-15 10:30:00
   ├─ responded_at: NULL
   └─ status: 'pending'

✅ ACCEPTED (Đã chấp nhận)
   ├─ invited_at: 2025-12-15 10:30:00
   ├─ responded_at: 2025-12-15 14:00:00 ← CẬP NHẬT KHI CHẤP NHẬN
   └─ status: 'accepted'

❌ REJECTED (Đã từ chối)
   ├─ invited_at: 2025-12-15 10:30:00
   ├─ responded_at: 2025-12-15 14:05:00 ← CẬP NHẬT KHI TỪ CHỐI
   └─ status: 'rejected'
```

---

## 🔔 NOTIFICATION SYSTEM

### **Khi Chấp Nhận Lời Mời (accepted)**
```php
// JobController.php - respondToInvitation()
Notification::createInvitationAcceptedNotification(
    $employer->user_id,
    $invitation
);
```

#### **Thông báo được tạo** (Notification.php)
```php
public static function createInvitationAcceptedNotification($employerUserId, $invitation)
{
    $applicant = $invitation->applicant;
    $job = $invitation->job;

    return self::create([
        'user_id' => $employerUserId,                    // Gửi cho NTD
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
```

### **Khi Từ Chối Lời Mời (rejected)**
```php
Notification::createInvitationRejectedNotification(
    $employer->user_id,
    $invitation
);
```

#### **Thông báo được tạo**
```php
public static function createInvitationRejectedNotification($employerUserId, $invitation)
{
    $applicant = $invitation->applicant;
    $job = $invitation->job;

    return self::create([
        'user_id' => $employerUserId,                    // Gửi cho NTD
        'type' => 'invitation_rejected',
        'message' => "{$applicant->hoten_uv} đã từ chối lời mời ứng tuyển vào vị trí: {$job->title}",
        'data' => [
            'invitation_id' => $invitation->id,
            'job_id' => $job->job_id,
            'job_title' => $job->title,
            'applicant_id' => $applicant->id_uv,
            'applicant_name' => $applicant->hoten_uv,
            'applicant_avatar' => $applicant->avatar,
            'rejected_at' => now()
        ]
    ]);
}
```

---

## 🎨 UI STATE CHANGES

### **PENDING (Chờ phản hồi)**
```html
<!-- Status Badge -->
<span class="status-badge status-pending">
    <i class="bi bi-hourglass-split"></i> Chờ phản hồi
</span>

<!-- Action Buttons -->
<div class="action-buttons">
    <button class="btn-action btn-accept">Chấp nhận</button>
    <button class="btn-action btn-reject">Từ chối</button>
</div>
```

**Styling:**
- 🟨 Background: Yellow gradient (`#fef3c7` → `#fde68a`)
- ⚪ Blinking dot indicator (animation: blink)
- ✅ Accept button (Green gradient)
- ❌ Reject button (Red gradient)

### **ACCEPTED (Đã chấp nhận)**
```html
<!-- Status Badge -->
<span class="status-badge status-accepted">
    <i class="bi bi-check-circle"></i> Đã chấp nhận
</span>

<!-- Action Buttons -->
<div class="action-buttons">
    <button class="btn-action btn-view-detail" disabled>Xem chi tiết</button>
</div>
```

**Styling:**
- 🟩 Background: Green gradient (`#d1fae5` → `#a7f3d0`)
- ✅ Static green dot
- 🔵 View detail button (Blue - disabled/read-only)

### **REJECTED (Đã từ chối)**
```html
<!-- Status Badge -->
<span class="status-badge status-rejected">
    <i class="bi bi-x-circle"></i> Đã từ chối
</span>

<!-- Action Buttons -->
<div class="action-buttons">
    <button class="btn-action btn-view-detail" disabled>Xem chi tiết</button>
</div>
```

**Styling:**
- 🟥 Background: Red gradient (`#fee2e2` → `#fecaca`)
- ❌ Static red dot
- 🔵 View detail button (Blue - disabled/read-only)

---

## 📝 COMPLETE SEQUENCE DIAGRAM

```
┌──────────────┐                           ┌─────────────────┐
│  Applicant   │                           │  JobController  │
└──────────────┘                           └─────────────────┘
       │                                            │
       │ 1. Click "Chấp nhận" button               │
       │                                            │
       ├─ Get invitation ID: 123                    │
       ├─ Get CSRF token                           │
       │                                            │
       │ 2. Show confirmation dialog                │
       │    "Bạn chắc chắn muốn chấp nhận?"        │
       │                                            │
       │ 3. POST /api/job-invitations/123/respond  │
       │    {response: 'accepted', message: ''}    │
       ├──────────────────────────────────────────►│
       │                                            │
       │                                   ✅ 4. Find invitation
       │                                   ✅ 5. Check permission
       │                                   ✅ 6. Validate response
       │                                   ✅ 7. Update status
       │                                      UPDATE job_invitations
       │                                      SET status = 'accepted'
       │                                          responded_at = NOW()
       │                                      WHERE id = 123
       │                                            │
       │                                   ✅ 8. Create notification
       │                                      INSERT INTO notifications
       │                                      (type: 'invitation_accepted')
       │                                            │
       │ 9. Response: {success: true, ...}         │
       │◄──────────────────────────────────────────┤
       │                                            │
       │ 10. Show toast: "✅ Đã chấp nhận lời mời!"│
       │                                            │
       │ 11. Wait 1.5 seconds                       │
       │                                            │
       │ 12. Reload page (location.reload())       │
       │                                            │
       │ 13. Page refresh - query invitations again │
       │                                            │
       │ 14. Display updated status: ACCEPTED      │
       │     (Status badge changes to green)        │
       │     (Buttons change to "View Detail")      │

```

---

## 📌 KEY POINTS

### ✅ **CHO ỨNG VIÊN (Applicant)**
- Nhấp nút "Chấp nhận" → Gửi API request
- API cập nhật `invitation.status = 'accepted'`
- Received confirmation toast message
- Page reloads để hiển thị trạng thái mới (green badge)
- Buttons disabled → chỉ có "View Detail"

### ✅ **CHO NTD (Employer)**
- Nhận notification: "{Tên ứng viên} đã chấp nhận lời mời"
- Có thể xem chi tiết ứng viên
- Tiếp theo: Gửi lời mời phỏng vấn hoặc reject applicant

### ⚠️ **VALIDATION**
- ✅ CSRF token check
- ✅ User authentication check
- ✅ Permission check (ứng viên chỉ update lời mời của họ)
- ✅ Response validation (chỉ accept 'accepted' or 'rejected')
- ✅ Invitation exists check

### 🔄 **STATUS LIFECYCLE**
```
pending ──[Chấp nhận]──► accepted
   ▲                        │
   │                        └─► [Phỏng vấn/Reject]
   │
   └──[Từ chối]──► rejected
```

---

## 🚨 EDGE CASES & ERRORS

| Case | Status Code | Response |
|------|-------------|----------|
| Invitation not found | 404 | `{ success: false, message: "Lời mời không tồn tại" }` |
| Not authenticated | 401 | Auth middleware redirect |
| Wrong user (trying to update other's invitation) | 403 | `{ success: false, message: "Không có quyền" }` |
| Invalid response value | 400 | `{ success: false, message: "Phản hồi không hợp lệ" }` |
| Server error | 500 | `{ success: false, message: "Có lỗi xảy ra: ..." }` |
| Already responded | ❌ Không kiểm tra (cho phép update lại) | Update status thành giá trị mới |

---

## 📊 COMPARISON: Accept from job-invitations vs homeapp

### **Job-Invitations Page**
```javascript
// 1. Direct API call
respondToInvitation(invitationId, 'accepted')

fetch('/api/job-invitations/{id}/respond', {
    body: {response: 'accepted', message: ''}
})

// 2. Update status immediately
// 3. Reload page
```

### **Home App (Upcoming Applicant)**
```javascript
// 1. Accept button shows 2 options:
//    - Chấp nhận + Ứng tuyển (ngay)
//    - Từ chối (direct)

// 2. If accept:
//    - Set modal fields (invitationId, accept_invitation=1)
//    - Show apply modal
//    - User fills form + clicks submit

// 3. On form submit:
//    - Create application
//    - Then call respondToInvitation with 'accepted'
//    - Creates 1 notification for accepted
//    - NO notification for "new_application"
```

---

## 💡 SUMMARY

**Chấp nhận lời mời là một hành động đơn giản:**
1. ✅ Update `invitation.status = 'accepted'`
2. ✅ Set `responded_at = now()`
3. ✅ Create notification for employer
4. ✅ Return success response
5. ✅ UI updates + page reload

**Không liên quan trực tiếp đến Application tại job-invitations.**

Tuy nhiên:
- Nếu ứng viên chấp nhận từ **homeapp** → Buộc phải ứng tuyển (fill form)
- Nếu ứng viên chấp nhận từ **job-invitations** → Chỉ update invitation status
