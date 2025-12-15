# 🔀 SO SÁNH: ACCEPT INVITATION FLOW

## 📍 2 CÁC CHẤP NHẬN LỜI MỜI

### **1️⃣ ACCEPT từ JOB-INVITATIONS PAGE** ✅
**File**: `resources/views/applicant/job-invitations.blade.php`

```
User Click "Chấp nhận"
         ↓
respondToInvitation(invitationId, 'accepted')
         ↓
POST /api/job-invitations/{id}/respond
         ↓
JobController::respondToInvitation()
         ↓
UPDATE job_invitations SET status = 'accepted', responded_at = NOW()
         ↓
CREATE Notification (invitation_accepted) for employer
         ↓
Return: {success: true}
         ↓
JavaScript: location.reload() (tải lại trang)
         ↓
Page shows updated status: GREEN "Đã chấp nhận"
         ↓
Buttons: Only "Xem chi tiết" (disabled)
```

### **2️⃣ ACCEPT từ HOMEAPP** ✅ (Sẽ có sau)
**File**: `resources/views/applicant/homeapp.blade.php`

```
User Click "Chấp nhận"
         ↓
handleAcceptInvitationButton()
         ↓
Set modal fields:
- modalInvitationId = invitationId
- modalAcceptInvitation = '1'
- modalJobId = jobId
         ↓
Show applyJobModal
         ↓
User fills application form:
- CV type (upload/profile)
- Personal info (name, email, phone, address)
- Introduction letter
         ↓
User click "Nộp hồ sơ ứng tuyển"
         ↓
applyJobForm.submit()
         ↓
ApplicationController::store()
         ↓
CREATE Application record
         ↓
Check: if accept_invitation === '1':
  - DON'T send 'new_application' notification
  (vì sẽ gửi 'invitation_accepted' notification thay vào)
         ↓
Return: {success: true}
         ↓
JavaScript: .then()
         ↓
respondToInvitation(invitationId, 'accepted')
         ↓
POST /api/job-invitations/{id}/respond
         ↓
JobController::respondToInvitation()
         ↓
UPDATE job_invitations SET status = 'accepted'
         ↓
CREATE Notification (invitation_accepted) for employer
         ↓
JavaScript: syncApplyButtons() + Show toast
         ↓
Page shows: "Đã ứng tuyển" + "Đã chấp nhận"
```

---

## 🔄 CHI TIẾT SO SÁNH

| Aspect | Job-Invitations | HomeApp |
|--------|-----------------|---------|
| **Nơi khởi động** | job-invitations.blade.php | homeapp.blade.php |
| **Button name** | "Chấp nhận" (green) | "Chấp nhận" (2-in-1) |
| **First action** | API: respondToInvitation | Modal: applyJobModal show |
| **Requires form** | ❌ NO | ✅ YES (CV, name, email, etc.) |
| **Create Application** | ❌ NO | ✅ YES |
| **API calls** | 1 call | 2 calls (apply + respond) |
| **Order** | Update invitation only | Apply first, then accept invitation |
| **Notifications sent** | 1: invitation_accepted | 1: invitation_accepted (NOT new_application) |
| **Final status** | invitation: accepted | invitation: accepted + application: created |

---

## 🎯 LOGIC FLOW - SIDE BY SIDE

### **JOB-INVITATIONS**
```
respondToInvitation()
│
├─ POST /api/job-invitations/{id}/respond
│  │
│  └─ JobController::respondToInvitation()
│     ├─ Find invitation
│     ├─ Check permission
│     ├─ Validate response ('accepted' or 'rejected')
│     ├─ UPDATE invitation.status = 'accepted'
│     ├─ UPDATE invitation.responded_at = NOW()
│     ├─ CREATE notification (invitation_accepted)
│     └─ RETURN {success: true}
│
├─ Show toast: "✅ Đã chấp nhận!"
├─ Wait 1.5s
├─ location.reload()
└─ Page refreshes with new status
```

### **HOMEAPP (2-step)**
```
Step 1: SHOW MODAL + FILL FORM
─────────────────────────────
handleAcceptInvitationButton()
│
├─ Set form fields:
│  ├─ modalInvitationId = invitationId
│  ├─ modalAcceptInvitation = '1'
│  └─ modalJobId = jobId
│
├─ Show applyJobModal
└─ User fills form...


Step 2: SUBMIT FORM
───────────────────
applyJobForm.submit()
│
├─ POST /apply-job (or /apply-job via action route)
│  │
│  └─ ApplicationController::store()
│     ├─ Validate form data
│     ├─ Check if already applied
│     ├─ Handle CV upload/profile
│     ├─ CREATE Application record
│     ├─ Check: if accept_invitation === '1'
│     │  └─ SKIP 'new_application' notification
│     │     (vì sẽ gửi 'invitation_accepted' thay vào)
│     └─ RETURN {success: true}
│
├─ JavaScript: .then()
│  │
│  ├─ Check invitationId && acceptInvitation === '1'
│  │
│  └─ respondToInvitation(invitationId, 'accepted')
│     │
│     └─ POST /api/job-invitations/{id}/respond
│        │
│        └─ JobController::respondToInvitation()
│           ├─ UPDATE invitation.status = 'accepted'
│           ├─ CREATE notification (invitation_accepted)
│           └─ RETURN {success: true}
│
├─ JavaScript: .then()
│  │
│  ├─ syncApplyButtons(jobId, true, true, 'accepted')
│  ├─ Show toast: "✅ Nộp hồ sơ + Chấp nhận lời mời!"
│  └─ Close modal + Reset form
└─ Page updated without reload
```

---

## 📊 KEY DIFFERENCES - DETAILED

### **1. ENTRY POINT**

**Job-Invitations:**
```html
<button onclick="respondToInvitation({{ $invitation->id }}, 'accepted')">
    Chấp nhận
</button>
```
→ Directly calls `respondToInvitation()`
→ One click = Done

**HomeApp:**
```html
<button onclick="handleAcceptInvitationButton(this, event)">
    Chấp nhận
</button>
```
→ Calls `handleAcceptInvitationButton()`
→ Shows modal → User fills form → Submit

---

### **2. FORM REQUIREMENT**

**Job-Invitations:**
- ❌ NO form
- Tính năng: Chỉ cập nhật invitation status
- Result: invitation.status = 'accepted'

**HomeApp:**
- ✅ REQUIRED form
- Tính năng: Vừa ứng tuyển vừa chấp nhận lời mời
- Result: 
  - application.created
  - invitation.status = 'accepted'

---

### **3. NOTIFICATION STRATEGY**

**Job-Invitations:**
```php
if ($response === 'accepted') {
    Notification::createInvitationAcceptedNotification(
        $employer->user_id,
        $invitation
    );
}
```
→ Always 1 notification: "Ứng viên chấp nhận lời mời"

**HomeApp (accept_invitation=1):**
```php
$acceptInvitation = $request->input('accept_invitation', '0');

if ($acceptInvitation !== '1') {
    // Send 'new_application' notification
    Notification::createNewApplicationNotification(...);
} else {
    // SKIP 'new_application' notification
    // Will send 'invitation_accepted' instead
    Log::info('✅ Skipped new_application notification (accepted invitation + applied)');
}
```

→ Then in respondToInvitation():
```php
Notification::createInvitationAcceptedNotification(
    $employer->user_id,
    $invitation
);
```

**Result:**
- 1 notification: "Ứng viên chấp nhận lời mời" (không phải "ứng viên ứng tuyển")
- Tránh trùng lặp notification

---

### **4. DATABASE CHANGES**

**Job-Invitations:**
```sql
UPDATE job_invitations 
SET status = 'accepted',
    responded_at = NOW()
WHERE id = 123;
```
✅ Only `job_invitations` table updated
❌ NO new record in `applications`

**HomeApp:**
```sql
-- 1. Create application
INSERT INTO applications (
    job_id, applicant_id, company_id, 
    cv_type, hoten, email, sdt, ...
) VALUES (...);

-- 2. Update invitation
UPDATE job_invitations 
SET status = 'accepted',
    responded_at = NOW()
WHERE id = 123;
```
✅ Both `applications` + `job_invitations` updated
✅ Complete applicant record created

---

### **5. UI/UX FLOW**

**Job-Invitations:**
```
BEFORE:
├─ Status: Yellow "Chờ phản hồi"
├─ Buttons: [Chấp nhận] [Từ chối]
└─ Action: Click → Confirm → API → Reload

AFTER (instant):
├─ Status: Green "Đã chấp nhận" 
├─ Buttons: [Xem chi tiết] (disabled)
└─ Action: Done
```

**HomeApp:**
```
BEFORE:
├─ Button: Yellow "Chấp nhận"
└─ Action: Click

AFTER Click:
├─ Modal opens
├─ User fills form
├─ Buttons: [Nộp hồ sơ] [Hủy]
└─ Action: Submit

AFTER Submit:
├─ Button: Green "Đã ứng tuyển + Chấp nhận"
├─ Toast: "✅ Nộp hồ sơ thành công!"
└─ Action: Done (no reload)
```

---

## 🔌 CONNECTING CODE SNIPPETS

### **Job-Invitations.blade.php - respondToInvitation()**
```javascript
function respondToInvitation(invitationId, response) {
    if (!confirm(`Bạn chắc chắn muốn ${response === 'accepted' ? 'chấp nhận' : 'từ chối'} lời mời này?`)) {
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    fetch(`/api/job-invitations/${invitationId}/respond`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            response: response,
            message: ''
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => {
                location.reload();  // ← RELOAD PAGE
            }, 1500);
        } else {
            showToast(data.message || 'Có lỗi xảy ra', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Có lỗi xảy ra khi xử lý yêu cầu', 'error');
    });
}
```

### **HomeApp.blade.php - handleAcceptInvitationButton()**
```javascript
window.handleAcceptInvitationButton = function(button, event) {
    event.stopPropagation();
    event.preventDefault();

    if (!checkAuth()) {
        showToast('Vui lòng đăng nhập!', 'error');
        setTimeout(() => window.location.href = '/login', 1500);
        return;
    }

    const invitationId = button.dataset.invitationId;
    const jobId = button.dataset.jobId;

    // ✅ LƯU invitationId VÀO MODAL (CHƯA GỬI API)
    document.getElementById('modalInvitationId').value = invitationId;
    document.getElementById('modalAcceptInvitation').value = '1';
    document.getElementById('modalJobId').value = jobId;

    // ✅ HIỂN THỊ MODAL ỨNG TUYỂN
    showToast('📋 Vui lòng hoàn tất thông tin ứng tuyển để gửi hồ sơ', 'info');
    const modal = new bootstrap.Modal(document.getElementById('applyJobModal'));
    modal.show();
};
```

### **HomeApp.blade.php - Form Submit (2-step)**
```javascript
const applyJobForm = document.getElementById('applyJobForm');
if (applyJobForm) {
    applyJobForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = this.querySelector('.btn-submit-apply');
        const originalText = submitBtn.innerHTML;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Đang gửi...';

        // STEP 1: GỬI FORM ỨNG TUYỂN
        fetch('/apply-job', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');

                // STEP 2: KIỂM TRA XEM CÓ CHẤP NHẬN LỜI MỜI KHÔNG
                const invitationId = document.getElementById('modalInvitationId').value;
                const acceptInvitation = document.getElementById('modalAcceptInvitation').value;
                const jobId = document.getElementById('modalJobId').value;

                // Nếu có invitationId và đánh dấu accept
                if (invitationId && acceptInvitation === '1') {
                    console.log(`✅ Accepting invitation after application submitted...`);
                    
                    // STEP 3: GỬI API CHẤP NHẬN LỜI MỜI
                    respondToInvitation(invitationId, 'accepted', jobId);
                }

                // STEP 4: CẬP NHẬT UI
                syncApplyButtons(jobId, true);

                // STEP 5: ĐÓNG MODAL
                const modal = bootstrap.Modal.getInstance(applyJobModal);
                if (modal) modal.hide();

                // STEP 6: RESET FORM
                applyJobForm.reset();
                document.getElementById('modalInvitationId').value = '';
                document.getElementById('modalAcceptInvitation').value = '0';

            } else {
                const errorMsg = data.errors ?
                    Object.values(data.errors).flat().join('\n') :
                    data.message || 'Có lỗi xảy ra. Vui lòng thử lại!';
                showToast(errorMsg, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Có lỗi xảy ra khi gửi hồ sơ. Vui lòng thử lại!', 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
}
```

### **respondToInvitation() - Used by HomeApp**
```javascript
function respondToInvitation(invitationId, response, jobId, modal = null) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    if (!csrfToken) {
        console.error('❌ CSRF token not found!');
        showToast('Có lỗi bảo mật. Vui lòng tải lại trang!', 'error');
        return;
    }

    fetch(`/api/job-invitations/${invitationId}/respond`, {
        method: 'POST',
        credentials: 'include',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            response: response
        })
    })
    .then(res => {
        console.log(`📥 Response status:`, res.status);
        return res.json().then(data => ({
            status: res.status,
            data
        }));
    })
    .then(({status, data}) => {
        console.log(`📊 Response data:`, data);

        if (status === 401) {
            showToast('Vui lòng đăng nhập!', 'error');
            setTimeout(() => window.location.href = '/login', 1500);
            return;
        }

        if (data.success) {
            const message = response === 'accepted' ?
                '✅ Bạn đã chấp nhận lời mời!' :
                '❌ Bạn đã từ chối lời mời!';
            showToast(message, 'success');

            // ✅ CẬP NHẬT CÁC NÚT TRÊN TRANG
            if (jobId) {
                checkApplicationStatus(jobId);
            }
        } else {
            showToast(data.message || 'Có lỗi xảy ra!', 'error');
        }
    })
    .catch(error => {
        console.error('❌ Fetch error:', error);
        showToast('Có lỗi xảy ra: ' + error.message, 'error');
    });
}
```

---

## 📌 SUMMARY TABLE

| Metric | Job-Invitations | HomeApp |
|--------|-----------------|---------|
| **Click to Complete** | 1 click | 3+ clicks (fill form) |
| **API Calls** | 1 | 2 |
| **Page Reload** | Yes | No |
| **Application Created** | No | Yes |
| **Form Required** | No | Yes |
| **User Flow** | Click → Confirm → Done | Click → Modal → Fill → Submit → Done |
| **Best For** | Quick response | Proper application |
| **Notifications** | 1: invitation_accepted | 1: invitation_accepted (skip new_application) |

---

## 🎯 WHEN TO USE WHICH?

### **Use Job-Invitations when:**
- ✅ User wants to just respond (accept/reject) quickly
- ✅ User will apply separately later
- ✅ Simple decision without committing to application

### **Use HomeApp when:**
- ✅ User wants to accept AND apply immediately
- ✅ Streamlined workflow (accept + provide info in one flow)
- ✅ Better user experience for committed applicants
- ✅ Complete application record needed right away
