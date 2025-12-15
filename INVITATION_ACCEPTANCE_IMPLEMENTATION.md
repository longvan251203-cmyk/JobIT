# 🎯 Job Invitations - 2-Step Modal Form Implementation

**Status:** ✅ COMPLETED  
**Date:** 2024  
**File Updated:** `resources/views/applicant/job-invitations.blade.php`

---

## 📋 Overview

The job-invitations page has been successfully transformed from a **simple 1-click API call** to a **2-step modal form workflow**, matching the homeapp pattern.

### Previous Flow (1-step):
```
User clicks "Chấp nhận" button
    ↓
Direct API call: POST /api/job-invitations/{id}/respond
    ↓
Update invitation status to 'accepted'
```

### New Flow (2-step):
```
User clicks "Chấp nhận" button
    ↓
Show modal form (CV selection + personal info)
    ↓
User fills form + selects CV
    ↓
Submit form: POST /apply-job → create Application
    ↓
API call: POST /api/job-invitations/{id}/respond → accept invitation
    ↓
Show success notification + reload page
```

---

## 🔧 Implementation Details

### 1. **Button Logic Change (Line ~915)**

**Before:**
```blade
<button class="btn btn-sm btn-success" 
        onclick="respondToInvitation('{{ $invitation->id }}', 'accepted')">
    <i class="bi bi-check-circle me-1"></i>Chấp nhận
</button>
```

**After:**
```blade
<button class="btn btn-sm btn-success" 
        onclick="handleAcceptInvitationButton(this, event)"
        data-invitation-id="{{ $invitation->id }}"
        data-job-id="{{ $invitation->job->job_id }}">
    <i class="bi bi-check-circle me-1"></i>Chấp nhận
</button>
```

### 2. **Modal Form Structure (Lines ~955-1050)**

Added a complete Bootstrap 5 modal with:

**CV Selection Section:**
- Radio buttons: "Tải lên CV" (upload) and "Dùng hồ sơ" (use profile)
- Active card highlighting
- Icon indicators

**Upload Section (for cv_type='upload'):**
- Drag-drop area with visual feedback
- File input with PDF/DOC/DOCX support
- File size validation (max 5MB)
- Display selected filename with option to change

**Profile Section (for cv_type='profile'):**
- Displays user's avatar and basic info
- Uses profile from applicant's existing information

**Personal Information Fields:**
```html
<input name="hoten" value="{{ Auth::user()->applicant->hoten_uv }}">
<input name="email" value="{{ Auth::user()->email }}">
<input name="sdt" value="{{ Auth::user()->applicant->sdt_uv }}">
<input name="diachi" value="{{ Auth::user()->applicant->dia_chi_uv }}">
<textarea name="thugioithieu" maxlength="2500"></textarea>
```

**Hidden Fields:**
```blade
<input type="hidden" name="job_id" id="modalJobId">
<input type="hidden" name="invitation_id" id="modalInvitationId">
<input type="hidden" name="accept_invitation" id="modalAcceptInvitation" value="0">
```

---

## 🔌 JavaScript Implementation

### Key Functions Added:

#### 1. **handleAcceptInvitationButton(button, event)**
Triggered when user clicks "Chấp nhận" button:
```javascript
- Prevents default behavior
- Checks if user is authenticated
- Sets hidden form fields (invitationId, jobId, accept_invitation=1)
- Shows info toast
- Opens applyJobModal
```

#### 2. **CV Type Selection Handler**
```javascript
- Listens to cv_type radio button changes
- Toggles between uploadSection and profileSection visibility
- Highlights active card
```

#### 3. **File Upload Handler**
```javascript
- Click to select file
- Drag-drop file detection
- File validation:
  - Accepted types: PDF, DOC, DOCX
  - Max size: 5MB
- Display selected filename
- Option to change file
```

#### 4. **Character Counter**
```javascript
- Tracks introduction letter textarea input
- Updates character count in real-time
- Max 2500 characters
```

#### 5. **Form Submission Handler (2-Step Process)**

**STEP 1: POST /apply-job**
```javascript
- Create FormData from form
- Send with CV file (if upload) or cv_type='profile'
- Include personal info and introduction letter
- Submit with CSRF token
```

**STEP 2: POST /api/job-invitations/{id}/respond**
```javascript
- If accept_invitation === '1'
- Call respondToInvitationAfterApply()
- Update invitation status to 'accepted'
- Pass jobId for reference
```

**STEP 3: UI Update**
```javascript
- Show success notification
- Close modal
- Reset form fields
- Reload page after 2 seconds
```

#### 6. **respondToInvitationAfterApply(invitationId, response, jobId)**
```javascript
- Sends API request to /api/job-invitations/{id}/respond
- Includes CSRF token and credentials
- Handles 401 (unauthorized) redirects to login
- Shows combined success message:
  "✅ Đã nộp hồ sơ + Chấp nhận lời mời!"
- Reloads page on success
```

---

## 📧 Backend Integration

### ApplicationController::store() (Lines 102-197)

**Changes Made:**
1. Added validation for `accept_invitation` field
2. Added validation for `invitation_id` field
3. **Conditional Notification Logic:**
   ```php
   if ($acceptInvitation !== '1') {
       // Send "new_application" notification to employer
       Notification::createNewApplicationNotification(...)
   } else {
       // Skip notification - will be handled by invitation_accepted notification
       Log::info('Skipped new_application notification (accepted invitation + applied)')
   }
   ```

**Why?**
- When a user accepts a job invitation AND applies in one flow
- Only send **ONE** notification: `invitation_accepted` (from respondToInvitation API)
- Prevents duplicate notifications to employer

---

## 🎨 Styling

### CSS Classes & Styling Added:

**CV Option Card:**
```css
.cv-option-card {
    cursor: pointer;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
}
.cv-option-card.active {
    border-color: #4f46e5;
    background-color: #eef2ff;
}
```

**Upload Area:**
```css
.upload-area {
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
}
.upload-area.dragover {
    border-color: #4f46e5;
    background-color: #eef2ff;
}
```

**Toast Notifications:**
```css
- Success: Linear gradient green (#10b981 → #059669)
- Error: Linear gradient red (#ef4444 → #dc2626)
- Animations: slideInRight (0.4s), slideOutRight (0.4s)
- Fixed position: top: 100px, right: 20px
```

---

## ✅ Form Data Flow

```
HTML Form → FormData object
    ↓
Fields submitted:
├─ job_id (from modalJobId)
├─ invitation_id (from modalInvitationId)
├─ accept_invitation (1 = yes, 0 = no)
├─ cv_type (upload or profile)
├─ cv_file (if upload type)
├─ hoten (name)
├─ email
├─ sdt (phone)
├─ diachi (address)
├─ thugioithieu (introduction letter)
└─ _token (CSRF)
```

---

## 🔐 Security Features

1. **CSRF Token Protection:**
   - Form includes @csrf Blade directive
   - CSRF token in X-CSRF-TOKEN header for fetch requests

2. **Authentication Check:**
   - `checkAuth()` verifies user is logged in
   - Redirects to login if session expired (401 response)

3. **File Validation:**
   - Server-side: Validator in ApplicationController
   - Client-side: File type and size checks before submission

4. **Input Validation:**
   - All required fields validated
   - Email format validation
   - Invitation ID existence check

---

## 🧪 Testing Checklist

- [ ] Click "Chấp nhận" button → modal appears
- [ ] Modal shows correct invitation/job info
- [ ] Select "Tải lên CV" → upload area visible
- [ ] Select "Dùng hồ sơ" → profile preview visible
- [ ] Drag-drop file → filename displays
- [ ] Click to select file → file picker opens
- [ ] File validation:
  - [ ] PDF/DOC/DOCX accepted
  - [ ] Other formats rejected
  - [ ] Files > 5MB rejected
- [ ] Personal info pre-filled from applicant profile
- [ ] Introduction letter character counter works (max 2500)
- [ ] Submit form:
  - [ ] Application created ✓
  - [ ] Invitation status updated to 'accepted' ✓
  - [ ] Success notification shows ✓
  - [ ] Modal closes ✓
- [ ] Page reloads → button status changed
- [ ] Invitation appears in "Đã chấp nhận" tab
- [ ] Employer receives single "invitation_accepted" notification

---

## 📝 Error Handling

| Error | Handling |
|-------|----------|
| User not authenticated | Redirect to login page |
| Invalid file type | Show toast error + prevent submission |
| File too large | Show toast error + prevent submission |
| Missing required fields | Show validation errors from server |
| API errors (500) | Show error toast with message |
| Network error | Show connection error toast |

---

## 🚀 Deployment Notes

1. **Database:** No migrations needed (existing tables used)
2. **Routes:** Using existing routes:
   - `route('application.store')` = POST /apply-job
   - `/api/job-invitations/{id}/respond`
3. **Dependencies:** Only Bootstrap 5 modal (already included)
4. **File Uploads:** Uses Laravel's storage (configured in filesystems.php)
5. **Notifications:** Uses existing notification system

---

## 📊 Related Files

| File | Changes |
|------|---------|
| `resources/views/applicant/job-invitations.blade.php` | ✅ Button logic, modal form, JavaScript handlers |
| `app/Http/Controllers/ApplicationController.php` | ✅ Conditional notification logic (already implemented) |
| `app/Http/Controllers/JobController.php` | No changes needed |
| `app/Models/Notification.php` | No changes needed |

---

## 🎯 Benefits of New Implementation

1. **Better UX:** Users can review and confirm their personal info before submitting
2. **Reduced Errors:** Personal info pre-filled from profile
3. **Flexibility:** Choice between uploading new CV or using profile CV
4. **Single Submission:** One form submission = apply + accept invitation
5. **Clear Feedback:** Toast notifications guide user through process
6. **Employer Clarity:** Single notification (not double) for acceptance

---

## 📌 Key Metrics

- **Modal size:** Bootstrap modal-xl (extra large for form content)
- **CV file limit:** 5MB
- **Introduction letter limit:** 2500 characters
- **Form re-submission delay:** 2 seconds (time to reload)
- **Toast display duration:** 3 seconds

---

## 💡 Future Enhancements

1. Add drag-and-drop reordering for CV portfolio items
2. Add CV preview before submission
3. Add email confirmation notification to applicant
4. Add interview scheduling from modal
5. Add skill tags in introduction letter

---

## 📞 Support

For issues or questions about this implementation:
1. Check browser console for error messages
2. Check Laravel logs: `storage/logs/laravel.log`
3. Verify CSRF token is present in page: `<meta name="csrf-token" content="...">`
4. Test file upload permissions: `storage/app/public/cv_uploads/`

