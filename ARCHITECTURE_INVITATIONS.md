# 📊 Implementation Architecture & Data Flow

## System Architecture Overview

```
┌─────────────────────────────────────────────────────────────────────┐
│                     APPLICANT BROWSER                               │
│                                                                     │
│  ┌────────────────────────────────────────────────────────────┐   │
│  │        Job Invitations Page (Blade Template)              │   │
│  │  - Displays list of invitations                          │   │
│  │  - Shows pending/accepted/rejected tabs                 │   │
│  │  - Each invitation has [Chấp nhận] [Từ chối] buttons   │   │
│  └─────────────────────────┬────────────────────────────────┘   │
│                            │                                      │
│                            ▼                                      │
│  ┌────────────────────────────────────────────────────────────┐   │
│  │     Modal Form (Bootstrap 5) - applyJobModal             │   │
│  │  ┌──────────────────────────────────────────────────────┐ │   │
│  │  │ CV Selection                                         │ │   │
│  │  │ ○ Tải lên CV        ● Dùng hồ sơ                  │ │   │
│  │  └──────────────────────────────────────────────────────┘ │   │
│  │  ┌──────────────────────────────────────────────────────┐ │   │
│  │  │ Upload Section (shown when cv_type='upload')       │ │   │
│  │  │ [Drag-drop area] [Select File Button]             │ │   │
│  │  └──────────────────────────────────────────────────────┘ │   │
│  │  ┌──────────────────────────────────────────────────────┐ │   │
│  │  │ Profile Section (shown when cv_type='profile')     │ │   │
│  │  │ [Avatar] [Name] [Email]                           │ │   │
│  │  └──────────────────────────────────────────────────────┘ │   │
│  │  ┌──────────────────────────────────────────────────────┐ │   │
│  │  │ Personal Information (pre-filled from profile)      │ │   │
│  │  │ [Họ tên] [Email] [SĐT] [Địa chỉ]               │ │   │
│  │  └──────────────────────────────────────────────────────┘ │   │
│  │  ┌──────────────────────────────────────────────────────┐ │   │
│  │  │ Introduction Letter (optional, max 2500 chars)     │ │   │
│  │  │ [Textarea] [Character Counter: 0/2500]           │ │   │
│  │  └──────────────────────────────────────────────────────┘ │   │
│  │  ┌──────────────────────────────────────────────────────┐ │   │
│  │  │ Hidden Fields (set by JavaScript)                 │ │   │
│  │  │ - job_id = modalJobId                            │ │   │
│  │  │ - invitation_id = modalInvitationId              │ │   │
│  │  │ - accept_invitation = "1"                        │ │   │
│  │  │ - _token = CSRF token (from @csrf)             │ │   │
│  │  └──────────────────────────────────────────────────────┘ │   │
│  │  ┌──────────────────────────────────────────────────────┐ │   │
│  │  │ Form Actions                                        │ │   │
│  │  │ [Hủy] [Gửi ứng tuyển]                           │ │   │
│  │  └──────────────────────────────────────────────────────┘ │   │
│  └────────────────────────┬────────────────────────────────────┘   │
│                            │                                      │
│                            ▼                                      │
│  ┌────────────────────────────────────────────────────────────┐   │
│  │     JavaScript Event Handlers                             │   │
│  │                                                             │   │
│  │  1. handleAcceptInvitationButton()                        │   │
│  │     - Check auth → Set hidden fields → Show modal       │   │
│  │                                                             │   │
│  │  2. CV Type Radio Change                                 │   │
│  │     - Toggle upload/profile visibility                  │   │
│  │                                                             │   │
│  │  3. File Input Change + Drag-Drop                        │   │
│  │     - Validate file → Display filename → Enable submit │   │
│  │                                                             │   │
│  │  4. Character Counter                                    │   │
│  │     - Count chars on input → Update display            │   │
│  │                                                             │   │
│  │  5. Form Submit                                          │   │
│  │     - Create FormData → POST /apply-job                │   │
│  │     - On success → POST /api/job-invitations/{}/respond│   │
│  │     - Close modal → Reload page                       │   │
│  │                                                             │   │
│  │  6. Toast Notifications                                 │   │
│  │     - Show success/error messages                      │   │
│  │     - Auto-dismiss after 3 seconds                    │   │
│  └────────────────────────┬────────────────────────────────────┘   │
│                            │                                      │
└────────────────────────────┼──────────────────────────────────────┘
                             │
                    ┌────────▼────────┐
                    │  HTTP Network   │
                    │  (HTTPS/TLS)    │
                    └────────┬────────┘
                             │
          ┌──────────────────┼──────────────────┐
          │                  │                  │
          ▼                  ▼                  ▼
┌──────────────────┐ ┌──────────────────┐ ┌──────────────────┐
│  POST /apply-job │ │   POST API       │ │  Session/Auth    │
│  (FormData)      │ │ /job-invitations/│ │  (X-CSRF-TOKEN)  │
│                  │ │   {id}/respond   │ │                  │
│  + File upload   │ │ (JSON)           │ │  Laravel Auth    │
│  + Form fields   │ │                  │ │  Middleware      │
└────────┬─────────┘ └────────┬─────────┘ └────────┬─────────┘
         │                    │                    │
         └────────────────────┼────────────────────┘
                              │
                              ▼
         ┌────────────────────────────────────────┐
         │  LARAVEL BACKEND                       │
         │                                        │
         │  ┌────────────────────────────────────┐│
         │  │ HTTP Request Handler               ││
         │  │ - Route matching                   ││
         │  │ - CSRF verification                ││
         │  │ - Authentication check             ││
         │  │ - Request validation               ││
         │  └────────────────┬───────────────────┘│
         │                   │                    │
         └───────────────────┼────────────────────┘
                             │
          ┌──────────────────┼──────────────────┐
          │                  │                  │
          ▼                  ▼                  ▼
     ┌─────────────┐  ┌──────────────┐  ┌────────────────┐
     │ APPLICATION│  │ JOBCONTROLLER│  │ FILE STORAGE   │
     │ CONTROLLER  │  │              │  │                │
     │             │  │ -respondTo   │  │ storage/app/   │
     │ -store()    │  │  Invitation()│  │ public/        │
     │             │  │              │  │ cv_uploads/    │
     │ 1. Validate │  │ 1. Update    │  │                │
     │ 2. Save CV  │  │    status    │  │ - Store CV     │
     │    file     │  │ 2. Log event │  │ - Return path  │
     │ 3. Create   │  │ 3. Send      │  │                │
     │    Application│  │    notification│ │                │
     │ 4. Conditional  │ 4. Return    │  │                │
     │    notification │    response   │  │                │
     └────────┬────┘  └──────┬───────┘  └────────┬───────┘
              │               │                   │
              └───────────────┼───────────────────┘
                              │
                    ┌─────────▼──────────┐
                    │  DATABASE          │
                    │                    │
                    │  ┌──────────────┐ │
                    │  │ applications │ │
                    │  │ (NEW RECORD) │ │
                    │  │              │ │
                    │  │ - job_id     │ │
                    │  │ - applicant  │ │
                    │  │ - cv_type    │ │
                    │  │ - cv_file    │ │
                    │  │ - hoten      │ │
                    │  │ - email      │ │
                    │  │ - sdt        │ │
                    │  │ - diachi     │ │
                    │  │ - thu_gioi   │ │
                    │  │ - status=0   │ │
                    │  └──────────────┘ │
                    │                    │
                    │  ┌──────────────┐ │
                    │  │ job_          │ │
                    │  │ invitations   │ │
                    │  │ (UPDATE)      │ │
                    │  │              │ │
                    │  │ - status =   │ │
                    │  │   "accepted" │ │
                    │  │ - updated_at │ │
                    │  │ - updated_by │ │
                    │  └──────────────┘ │
                    │                    │
                    │  ┌──────────────┐ │
                    │  │ notifications│ │
                    │  │ (NEW RECORD) │ │
                    │  │              │ │
                    │  │ - type:      │ │
                    │  │   invitation │ │
                    │  │   _accepted  │ │
                    │  │ - user_id:   │ │
                    │  │   employer   │ │
                    │  │ - data:      │ │
                    │  │   applicant  │ │
                    │  │   + job info │ │
                    │  └──────────────┘ │
                    │                    │
                    └────────┬───────────┘
                             │
                             ▼
                    ┌──────────────────┐
                    │  Notification    │
                    │  System          │
                    │                  │
                    │  Send to         │
                    │  Employer's      │
                    │  notifications   │
                    │  (Real-time      │
                    │   update)        │
                    └────────┬─────────┘
                             │
                    ┌────────▼──────────┐
                    │  JSON Response    │
                    │                   │
                    │  {                │
                    │    success: true, │
                    │    message: "...",│
                    │    data: {...}    │
                    │  }                │
                    └────────┬──────────┘
                             │
```

---

## Data Flow Timeline

```
t=0ms   │ User clicks "Chấp nhận" button
        │
t=10ms  │ handleAcceptInvitationButton() executes
        │ ├─ Check authentication status
        │ ├─ Retrieve invitation_id from button data attribute
        │ ├─ Set hidden form fields:
        │ │  ├─ modalInvitationId = "456"
        │ │  ├─ modalAcceptInvitation = "1"
        │ │  └─ modalJobId = "123"
        │ ├─ Show info toast: "📋 Vui lòng hoàn tất..."
        │ └─ Open modal dialog
        │
t=50ms  │ Modal appears on screen
        │
t=100ms │ User selects CV type (upload or profile)
        │ └─ Radio change handler toggles visibility
        │
t=150ms │ User selects file (drag-drop or click)
        │ │
        │ ├─ File selected: document.getElementById('cvFileInput').files[0]
        │ ├─ Validate file type (.pdf, .doc, .docx)
        │ ├─ Validate file size (< 5MB)
        │ └─ Display: filename + checkmark
        │
t=200ms │ User fills personal information
        │ │
        │ ├─ Name (pre-filled, may edit)
        │ ├─ Email (pre-filled, may edit)
        │ ├─ Phone (pre-filled, may edit)
        │ ├─ Address (pre-filled, may edit)
        │ └─ Introduction letter (optional, free-text)
        │
t=250ms │ User types introduction letter
        │ │
        │ └─ Character counter updates: "50/2500", "100/2500", etc.
        │
t=300ms │ User clicks "Gửi ứng tuyển" button
        │ │
        │ ├─ Button disabled: true
        │ ├─ Button text: "Đang gửi..."
        │ └─ FormData created from form elements
        │
t=310ms │ *** STEP 1: POST /apply-job ***
        │ │
        │ ├─ Endpoint: POST /apply-job
        │ ├─ Content-Type: multipart/form-data
        │ ├─ Headers:
        │ │  ├─ X-CSRF-TOKEN: [token]
        │ │  └─ Accept: application/json
        │ │
        │ ├─ Body (FormData):
        │ │  ├─ job_id: "123"
        │ │  ├─ invitation_id: "456"
        │ │  ├─ accept_invitation: "1"
        │ │  ├─ cv_type: "upload"
        │ │  ├─ cv_file: [File object]
        │ │  ├─ hoten: "Nguyễn Văn A"
        │ │  ├─ email: "user@email.com"
        │ │  ├─ sdt: "0123456789"
        │ │  ├─ diachi: "123 Đường ABC"
        │ │  ├─ thugioithieu: "Tôi là..."
        │ │  └─ _token: [CSRF token]
        │ │
        │ └─ Sent over HTTPS
        │
t=350ms │ *** LARAVEL BACKEND: /apply-job ***
        │ │
        │ ├─ Route: POST /apply-job (routes/web.php)
        │ ├─ Controller: ApplicationController::store()
        │ │
        │ ├─ Validation:
        │ │  ├─ job_id exists in job_post table
        │ │  ├─ cv_type in [upload, profile]
        │ │  ├─ cv_file (if upload type)
        │ │     ├─ must be file
        │ │     ├─ mimes: pdf, doc, docx
        │ │     └─ max: 5120 KB
        │ │  ├─ hoten required, string, max 255
        │ │  ├─ email required, email, max 255
        │ │  ├─ sdt required, string, max 20
        │ │  ├─ diachi nullable, string, max 500
        │ │  ├─ thugioithieu nullable, string, max 2500
        │ │  └─ accept_invitation nullable, in [0,1]
        │ │
        │ ├─ File Processing (if upload):
        │ │  ├─ Store to: storage/app/public/cv_uploads/
        │ │  ├─ Filename: [timestamp]_[user_id]_[original].pdf
        │ │  └─ cvFilePath = "cv_uploads/[filename]"
        │ │
        │ ├─ Create Application Record:
        │ │  ├─ application_id: auto-increment
        │ │  ├─ job_id: 123
        │ │  ├─ applicant_id: [current user id]
        │ │  ├─ company_id: [from job]
        │ │  ├─ cv_type: "upload"
        │ │  ├─ cv_file_path: "cv_uploads/..."
        │ │  ├─ hoten: "Nguyễn Văn A"
        │ │  ├─ email: "user@email.com"
        │ │  ├─ sdt: "0123456789"
        │ │  ├─ diachi: "123 Đường ABC"
        │ │  ├─ thu_gioi_thieu: "Tôi là..."
        │ │  ├─ trang_thai: "0" (Chờ xử lý)
        │ │  └─ ngay_ung_tuyen: now()
        │ │
        │ ├─ Conditional Notification:
        │ │  │
        │ │  ├─ Check: $accept_invitation === '1' ?
        │ │  │
        │ │  ├─ YES (this case):
        │ │  │  └─ Skip createNewApplicationNotification()
        │ │  │     (log: "Skipped new_application notification...")
        │ │  │
        │ │  └─ NO (regular apply):
        │ │     └─ Notification::createNewApplicationNotification()
        │ │        (send to employer: "New application received")
        │ │
        │ └─ Return JSON Response:
        │    {
        │      "success": true,
        │      "message": "Nộp hồ sơ ứng tuyển thành công!...",
        │      "data": { application object }
        │    }
        │
t=500ms │ *** Browser receives response ***
        │ │
        │ ├─ Status: 200 OK
        │ ├─ Content-Type: application/json
        │ └─ Body: {success: true, ...}
        │
t=510ms │ *** JavaScript: Check response ***
        │ │
        │ ├─ if (data.success) {
        │ │    // Proceed to Step 2
        │ │ }
        │ │
        │ ├─ Retrieve form fields:
        │ │  ├─ invitationId = "456"
        │ │  ├─ acceptInvitation = "1"
        │ │  └─ jobId = "123"
        │ │
        │ └─ if (invitationId && acceptInvitation === '1') {
        │      respondToInvitationAfterApply(...)
        │    }
        │
t=520ms │ *** STEP 2: POST /api/job-invitations/{id}/respond ***
        │ │
        │ ├─ Endpoint: POST /api/job-invitations/456/respond
        │ ├─ Content-Type: application/json
        │ ├─ Headers:
        │ │  ├─ X-CSRF-TOKEN: [token]
        │ │  ├─ Accept: application/json
        │ │  └─ credentials: include
        │ │
        │ ├─ Body:
        │ │  {
        │ │    "response": "accepted"
        │ │  }
        │ │
        │ └─ Sent over HTTPS
        │
t=560ms │ *** LARAVEL BACKEND: /api/job-invitations/{id}/respond ***
        │ │
        │ ├─ Route: POST /api/job-invitations/{id}/respond
        │ ├─ Controller: JobController::respondToInvitation()
        │ │
        │ ├─ Validation:
        │ │  ├─ Invitation exists
        │ │  ├─ User is authenticated
        │ │  ├─ User owns this invitation
        │ │  └─ Invitation status is "pending"
        │ │
        │ ├─ Update JobInvitation:
        │ │  ├─ status: "accepted"
        │ │  ├─ response_date: now()
        │ │  ├─ updated_at: now()
        │ │  └─ updated_by: [current user]
        │ │
        │ ├─ Create Notification:
        │ │  ├─ Type: "invitation_accepted"
        │ │  ├─ user_id: [employer's user_id]
        │ │  ├─ data: {
        │ │  │   applicant_name: "Nguyễn Văn A",
        │ │  │   job_title: "Senior Developer",
        │ │  │   company_name: "Tech Corp",
        │ │  │   invitation_id: 456
        │ │  │ }
        │ │  └─ read_at: null
        │ │
        │ └─ Return JSON Response:
        │    {
        │      "success": true,
        │      "message": "Chấp nhận lời mời thành công!"
        │    }
        │
t=600ms │ *** Browser receives response ***
        │ │
        │ └─ Status: 200 OK
        │
t=610ms │ *** JavaScript: Handle success ***
        │ │
        │ ├─ Show success toast:
        │ │  "✅ Đã nộp hồ sơ + Chấp nhận lời mời!"
        │ │
        │ ├─ Get modal instance
        │ ├─ Call modal.hide()
        │ │
        │ ├─ Reset form:
        │ │  ├─ form.reset()
        │ │  ├─ Clear hidden fields
        │ │  ├─ Clear file selection
        │ │  └─ Reset file display
        │ │
        │ └─ setTimeout(() => {
        │      location.reload()
        │    }, 2000)
        │
t=650ms │ Toast notification visible
        │ (green gradient, auto-dismiss in 3s)
        │
t=2650ms│ *** Page Reload ***
        │ │
        │ └─ Browser sends: GET /job-invitations
        │    (with session/auth cookie)
        │
t=2700ms│ *** Backend: GET /job-invitations ***
        │ │
        │ ├─ Controller: ApplicantController::invitations()
        │ ├─ Query invitations filtered by status
        │ │
        │ ├─ Find the updated invitation:
        │ │  ├─ ID: 456
        │ │  ├─ Status: "accepted" (changed from "pending")
        │ │  └─ Notification sent to employer
        │ │
        │ └─ Render view with updated data
        │
t=2750ms│ *** Browser renders updated page ***
        │ │
        │ ├─ Invitation appears in "Đã chấp nhận" tab
        │ ├─ Button shows: "Đã chấp nhận" (disabled)
        │ ├─ Can no longer accept/reject
        │ └─ Application visible in "My Applications"
        │
✓       │ *** COMPLETE ***
```

---

## Key Interactions Diagram

```
┌────────────────────────────────────────┐
│       USER INTERACTIONS                 │
└────────────────────────────────────────┘

1. BUTTON CLICK
   ┌──────────────────┐
   │ Accept Button    │
   │ onclick handler  │
   └────────┬─────────┘
            │
            ▼
   handleAcceptInvitationButton()
            │
            ├─ checkAuth() ──┐
            │                │
            │       ┌────────▼──────────┐
            │       │ if (!loggedIn)    │
            │       │ ├─ Show toast     │
            │       │ └─ return (exit)  │
            │       └───────────────────┘
            │
            ├─ Set data to modal
            ├─ Show notification
            └─ Open modal

2. CV TYPE SELECTION
   ┌──────────────────┐
   │ CV Option Cards  │
   │ Radio buttons    │
   └────────┬─────────┘
            │
            ▼
   Radio change event listener
            │
            ├─ Remove 'active' from all cards
            ├─ Add 'active' to clicked card
            │
            └─ if (value === 'upload') {
                 show uploadSection
                 hide profileSection
               } else {
                 show profileSection
                 hide uploadSection
               }

3. FILE UPLOAD
   ┌──────────────────┐
   │ Upload Area      │
   │ Select File Btn  │
   │ File Input       │
   └────────┬─────────┘
            │
            ├─ Click handler → cvFileInput.click()
            │
            └─ File input change event
               │
               ├─ Get: file = files[0]
               │
               ├─ Validate:
               │  ├─ type in ['pdf', 'doc', 'docx']
               │  └─ size < 5MB
               │
               ├─ if valid:
               │  ├─ Update display: show filename
               │  └─ fileNameDisplay.style.display = 'block'
               │
               └─ if invalid:
                  └─ showToast(error, 'error')

4. DRAG & DROP
   ┌──────────────────┐
   │ Upload Area      │
   │ (drop zone)      │
   └────────┬─────────┘
            │
            ├─ dragover event:
            │  └─ classList.add('dragover')
            │
            ├─ dragleave event:
            │  └─ classList.remove('dragover')
            │
            └─ drop event:
               ├─ e.preventDefault()
               ├─ Get: file = e.dataTransfer.files[0]
               ├─ classList.remove('dragover')
               └─ handleFile(file)

5. CHARACTER COUNTER
   ┌──────────────────┐
   │ Textarea         │
   │ Intro Letter     │
   └────────┬─────────┘
            │
            ▼
   input event listener
            │
            └─ Get: count = this.value.length
               └─ Update: charCount.textContent = count

6. FORM SUBMISSION
   ┌──────────────────┐
   │ Submit Button    │
   │ Gửi ứng tuyển    │
   └────────┬─────────┘
            │
            ▼
   form submit event
            │
            ├─ e.preventDefault()
            │
            ├─ Validate:
            │  ├─ CV type selected
            │  ├─ (if upload) File selected
            │  └─ Required fields filled
            │
            ├─ if error → showToast(error)
            │
            └─ if valid:
               │
               ├─ Create FormData
               ├─ Update button:
               │  ├─ disabled = true
               │  ├─ innerHTML = "Đang gửi..."
               │
               ├─ Fetch POST /apply-job
               │  ├─ body: FormData
               │  ├─ headers: X-CSRF-TOKEN
               │  └─ accept: application/json
               │
               └─ On response:
                  ├─ Parse JSON
                  │
                  ├─ if (success):
                  │  │
                  │  ├─ showToast("Nộp hồ sơ...")
                  │  │
                  │  ├─ if (accept_invitation === '1'):
                  │  │  └─ respondToInvitationAfterApply()
                  │  │     ├─ Fetch POST /api/job-invitations/{}/respond
                  │  │     └─ On success:
                  │  │        ├─ showToast("✅ Đã nộp...")
                  │  │        └─ setTimeout(reload, 2000)
                  │  │
                  │  ├─ modal.hide()
                  │  ├─ form.reset()
                  │  ├─ Clear hidden fields
                  │  │
                  │  └─ On error (after apply):
                  │     ├─ showToast(error, 'error')
                  │     └─ Keep form open for retry
                  │
                  └─ if (error):
                     ├─ showToast(error, 'error')
                     └─ Re-enable button
```

---

## State Machine Diagram

```
                    ┌─────────────────┐
                    │ INITIAL STATE   │
                    │ - Modal closed  │
                    │ - Button ready  │
                    └────────┬────────┘
                             │
                    User clicks accept
                             │
                             ▼
                    ┌─────────────────┐
                    │ MODAL OPEN      │
                    │ - Form visible  │
                    │ - Fields filled │
                    │ - CV type:      │
                    │   upload        │
                    └────────┬────────┘
                             │
        ┌────────────────────┼────────────────────┐
        │                    │                    │
User toggles CV type     User selects CV type
        │                    │                    │
        ▼                    ▼                    ▼
    ┌──────────┐         ┌──────────┐         ┌──────────┐
    │ UPLOAD   │         │ PROFILE  │         │ UPLOADING│
    │ SECTION  │         │ SECTION  │         │ (waiting)│
    │ visible  │         │ visible  │         │ for file │
    └────┬─────┘         └────┬─────┘         └────┬─────┘
         │                    │                    │
         │ User uploads file  │                    │
         │◄───────────────────┘                    │
         │                                         │
         │◄─────────────────────────────────────────┘
         │
         ▼
    ┌──────────────────┐
    │ FILE SELECTED    │
    │ - Filename shown │
    │ - Can change     │
    │ - Submit ready   │
    └────────┬─────────┘
             │
    User clicks submit
             │
             ▼
    ┌──────────────────┐
    │ SUBMITTING       │
    │ - Button showing │
    │   "Đang gửi..."  │
    │ - Form disabled  │
    │ - Request in-    │
    │   flight         │
    └────────┬─────────┘
             │
    Step 1: POST /apply-job
             │
             ├─ Success ────┐
             │              │
             └─ Error ──┐   │
                        │   │
                        ▼   ▼
            ┌───────────────────────┐
            │ STEP 2 EXECUTING      │
            │ POST /api/job-        │
            │ invitations/{}/       │
            │ respond               │
            │                       │
            │ OR                    │
            │                       │
            │ ERROR (modal stays)   │
            └─────┬──────┬──────────┘
                  │      │
            Success│      │Error
                  │      │
                  ▼      ▼
         ┌────────────────────────┐
         │ CLOSING / RELOADING    │
         │ - Modal closes         │
         │ - Form resets          │
         │ - Success toast shown  │
         │ - Page reloads in 2s   │
         │                        │
         │ OR                     │
         │                        │
         │ ERROR SHOWN            │
         │ - Error toast visible  │
         │ - Modal stays open     │
         │ - Can retry/fix        │
         └─────┬──────┬───────────┘
              │       │
              │       └─ User fixes and resubmits
              │           (loop back to SUBMITTING)
              │
              ▼
         ┌──────────────────┐
         │ PAGE RELOADED    │
         │ - Invitation in  │
         │   "Đã chấp nhận" │
         │ - Button updated │
         │ - Application    │
         │   visible        │
         └────────┬─────────┘
                  │
                  ▼
         ┌──────────────────┐
         │ FINAL STATE      │
         │ - Accepted ✓     │
         │ - Complete       │
         └──────────────────┘
```

---

## This completes the comprehensive architecture documentation for the 2-step invitation acceptance modal implementation.

