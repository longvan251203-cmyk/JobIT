# 🧪 End-to-End Testing Checklist - JobIT System

**Date:** December 12, 2025  
**Scope:** Full applicant and employer workflows  
**Status:** Ready for Testing

---

## ✅ PRE-TESTING SETUP

### 1. Browser Setup
- [ ] Test in Chrome/Firefox/Edge (latest versions)
- [ ] Clear browser cache (Ctrl+Shift+Delete)
- [ ] Check console for JavaScript errors (F12 → Console)
- [ ] Verify localStorage is enabled

### 2. Database Setup
- [ ] Run migrations: `php artisan migrate:fresh --seed`
- [ ] Verify tables exist: users, applicants, applications, job_posts
- [ ] Check sample data loaded

### 3. Server Setup
- [ ] Start Laravel dev server: `php artisan serve`
- [ ] Start Vite: `npm run dev`
- [ ] Check no errors in terminal
- [ ] Verify API endpoints accessible

---

## 🚀 TEST SCENARIO 1: APPLICANT FULL WORKFLOW

### Section 1.1: User Registration & Profile Setup

#### Test 1.1.1: User Registration
- [ ] Navigate to `/register`
- [ ] Fill registration form with valid data
  - [ ] Email: unique email
  - [ ] Password: strong password (min 8 chars)
  - [ ] Role: "Applicant"
- [ ] Submit form
- [ ] **VERIFY:** Success message shown (toast notification)
- [ ] **VERIFY:** Redirected to login page
- [ ] Login with registered credentials
- [ ] **VERIFY:** Dashboard loads successfully

#### Test 1.1.2: Profile Completion
- [ ] Click "Hồ Sơ Cá Nhân"
- [ ] Update "Giới thiệu" section
  - [ ] Enter short bio (100-500 chars)
  - [ ] Save
  - [ ] **VERIFY:** Toast notification "Saved successfully" appears
  - [ ] **VERIFY:** Data persists after page reload
- [ ] Add "Học Vấn" (Education)
  - [ ] Select school, degree, graduation date
  - [ ] Save
  - [ ] **VERIFY:** Toast success notification appears
  - [ ] **VERIFY:** Education appears in list
  - [ ] Edit education
  - [ ] **VERIFY:** Form pre-fills with existing data
  - [ ] Update and save
  - [ ] **VERIFY:** Changes reflected immediately
  - [ ] Delete education
  - [ ] **VERIFY:** Item removed from list
- [ ] Add "Kỹ Năng" (Skills)
  - [ ] Enter skill name
  - [ ] Select proficiency level
  - [ ] Save
  - [ ] **VERIFY:** Toast success appears
  - [ ] **VERIFY:** Skill appears in list
  - [ ] Edit skill (click Edit on skill card)
  - [ ] **VERIFY:** Form shows existing data
  - [ ] Update and save
  - [ ] **VERIFY:** Changes reflected
  - [ ] Delete skill
  - [ ] **VERIFY:** Removed from list
- [ ] Add "Ngoại Ngữ" (Languages)
  - [ ] Select language
  - [ ] Select proficiency level
  - [ ] Save
  - [ ] **VERIFY:** Toast success appears
  - [ ] **VERIFY:** Language appears in list
  - [ ] Edit language (click Edit)
  - [ ] **VERIFY:** Pre-filled with existing data
  - [ ] Update and save
  - [ ] **VERIFY:** Changes reflected
  - [ ] Delete language
  - [ ] **VERIFY:** Removed
- [ ] Add "Kinh Nghiệm" (Experience)
  - [ ] Enter company, position, duration
  - [ ] Save
  - [ ] **VERIFY:** Toast success
  - [ ] **VERIFY:** Appears in list
  - [ ] Edit experience
  - [ ] **VERIFY:** Pre-filled form
  - [ ] Update and save
  - [ ] **VERIFY:** Changes reflected
  - [ ] Delete experience
  - [ ] **VERIFY:** Removed
- [ ] Upload CV
  - [ ] Click "Upload CV"
  - [ ] Select PDF file
  - [ ] **VERIFY:** Toast "Upload successful"
  - [ ] **VERIFY:** CV button shows "View CV" option
  - [ ] View CV
  - [ ] **VERIFY:** PDF opens in new tab
  - [ ] Delete CV
  - [ ] **VERIFY:** Toast "Deleted successfully"
  - [ ] **VERIFY:** Upload button returns

#### Test 1.1.3: Profile Avatar
- [ ] Upload avatar
  - [ ] Click avatar area
  - [ ] Select image
  - [ ] **VERIFY:** Toast success
  - [ ] **VERIFY:** Avatar displays in profile
- [ ] Delete avatar
  - [ ] Click delete icon
  - [ ] **VERIFY:** Toast "Deleted successfully"
  - [ ] **VERIFY:** Default avatar shows again

---

### Section 1.2: Job Search & Recommendations

#### Test 1.2.1: Job Recommendations
- [ ] Navigate to "Gợi ý việc làm"
- [ ] **VERIFY:** Page loads
- [ ] **VERIFY:** Job cards display with match score
- [ ] **VERIFY:** Score breakdown visible (location, skills, experience, etc.)
- [ ] Scroll through multiple jobs
- [ ] **VERIFY:** Cards load smoothly
- [ ] **VERIFY:** No console errors

#### Test 1.2.2: Save/Unsave Jobs
- [ ] Click heart icon on a job card
- [ ] **VERIFY:** Heart fills with color
- [ ] **VERIFY:** Toast "Job saved successfully" appears
- [ ] Click filled heart
- [ ] **VERIFY:** Heart returns to outline
- [ ] **VERIFY:** Toast "Job removed from saved" appears
- [ ] Save multiple jobs (5+)
- [ ] **VERIFY:** All save actions succeed

#### Test 1.2.3: Job Details
- [ ] Click on job card
- [ ] **VERIFY:** Job detail page loads
- [ ] **VERIFY:** All details visible:
  - [ ] Job title
  - [ ] Company info
  - [ ] Salary range
  - [ ] Location
  - [ ] Description
  - [ ] Requirements
  - [ ] Apply button
- [ ] Check Apply button
- [ ] **VERIFY:** Button is clickable

---

### Section 1.3: Job Application

#### Test 1.3.1: Apply for Job
- [ ] From job detail page, click "Apply Job"
- [ ] **VERIFY:** Modal opens
- [ ] **VERIFY:** Form pre-fills with profile data:
  - [ ] Name
  - [ ] Email
  - [ ] Phone
  - [ ] Cover letter field
  - [ ] CV selector
- [ ] Select existing CV or upload new
- [ ] Fill cover letter
- [ ] Click "Submit"
- [ ] **VERIFY:** Loading state shows "Đang gửi..."
- [ ] **VERIFY:** Success toast appears "Applied successfully"
- [ ] **VERIFY:** Modal closes
- [ ] **VERIFY:** Job card updates (remove from saved)

#### Test 1.3.2: Apply Multiple Jobs
- [ ] Apply for 3 different jobs
- [ ] **VERIFY:** All applications succeed
- [ ] **VERIFY:** Toast notifications appear for each

#### Test 1.3.3: Applied Jobs View
- [ ] Click "Việc làm của tôi"
- [ ] View "Đã lưu" tab
- [ ] **VERIFY:** Saved jobs display
- [ ] View "Đã ứng tuyển" tab
- [ ] **VERIFY:** Applied jobs display with status badges
- [ ] Check application statuses:
  - [ ] "Chờ xử lý" (Pending)
  - [ ] "Đang phỏng vấn" (Interview)
  - [ ] Other statuses if applicable

---

## 👔 TEST SCENARIO 2: EMPLOYER FULL WORKFLOW

### Section 2.1: Employer Registration & Setup

#### Test 2.1.1: Employer Registration
- [ ] Navigate to `/register/employer`
- [ ] Fill employer registration form
  - [ ] Email: unique email
  - [ ] Password: strong password
  - [ ] Company name
  - [ ] Role: "Employer"
- [ ] Submit
- [ ] **VERIFY:** Success message (toast)
- [ ] **VERIFY:** Redirected to company setup
- [ ] Complete company information:
  - [ ] Company description
  - [ ] Location
  - [ ] Contact info
  - [ ] Logo (optional)
- [ ] Save
- [ ] **VERIFY:** Toast success appears

#### Test 2.1.2: Recruiter Accounts
- [ ] In employer dashboard, go to "Recruiter" section
- [ ] Add new recruiter
  - [ ] Enter email
  - [ ] Enter full name
  - [ ] Assign permissions
  - [ ] Save
  - [ ] **VERIFY:** Toast success
  - [ ] **VERIFY:** Recruiter appears in list
- [ ] Edit recruiter
  - [ ] Click edit button
  - [ ] Modify details
  - [ ] Save
  - [ ] **VERIFY:** Changes reflected
- [ ] Delete recruiter
  - [ ] Click delete button
  - [ ] **VERIFY:** Confirmation dialog
  - [ ] Confirm
  - [ ] **VERIFY:** Toast success
  - [ ] **VERIFY:** Removed from list

---

### Section 2.2: Job Posting

#### Test 2.2.1: Create Job Post
- [ ] Navigate to "Đăng tuyển"
- [ ] Fill job posting form:
  - [ ] Job title: e.g., "Senior Developer"
  - [ ] Description: detailed job description
  - [ ] Requirements: list requirements
  - [ ] Salary range: min and max salary
  - [ ] Location: job location
  - [ ] Job type: Full-time/Part-time/Contract
  - [ ] Number of positions: recruitment count
  - [ ] Deadline: application deadline
  - [ ] Required skills: select from list
- [ ] Submit
- [ ] **VERIFY:** Toast success "Job posted successfully"
- [ ] **VERIFY:** Redirected to dashboard
- [ ] **VERIFY:** New job appears in active jobs list

#### Test 2.2.2: View Posted Jobs
- [ ] Go to "Dashboard"
- [ ] Check stat cards:
  - [ ] "Đang tuyển" (Active): should increase
  - [ ] Update in real-time (auto-refresh)
  - [ ] **VERIFY:** Numbers update every 5 seconds (polling)
- [ ] View jobs in "Đang tuyển" tab
- [ ] **VERIFY:** Posted job appears
- [ ] **VERIFY:** Job details correct
- [ ] Check application count
- [ ] **VERIFY:** Matches number of applications

#### Test 2.2.3: Edit Job
- [ ] Click edit button on job
- [ ] Update job details
  - [ ] Change description
  - [ ] Update salary
  - [ ] Modify requirements
- [ ] Save
- [ ] **VERIFY:** Toast success
- [ ] **VERIFY:** Changes reflected in job card

#### Test 2.2.4: Job Status Transitions
- [ ] Post a job with deadline approaching
- [ ] Wait for deadline to pass (or manually set)
- [ ] Refresh page
- [ ] **VERIFY:** Job moves to "Hết hạn" tab
- [ ] Fill all positions
  - [ ] Select applicants for position
  - [ ] Mark as "Được chọn"
- [ ] **VERIFY:** Job moves to "Đã đủ" tab

---

### Section 2.3: Applicant Management

#### Test 2.3.1: View Applicants
- [ ] In dashboard, click "Ứng viên"
- [ ] **VERIFY:** Applicant list loads
- [ ] **VERIFY:** Shows:
  - [ ] Applicant name
  - [ ] Position applied for
  - [ ] Application date
  - [ ] Current status
  - [ ] Application score/match

#### Test 2.3.2: Review Application
- [ ] Click on applicant
- [ ] **VERIFY:** Full profile loads:
  - [ ] Resume/CV
  - [ ] Cover letter
  - [ ] Skills
  - [ ] Experience
  - [ ] Education
  - [ ] Contact info
- [ ] Check skills match
- [ ] **VERIFY:** Highlighted if matching

#### Test 2.3.3: Application Status Management
- [ ] Change application status:
  - [ ] From "Chờ xử lý" (Pending) → "Đang phỏng vấn" (Interview)
  - [ ] **VERIFY:** Status changes
  - [ ] **VERIFY:** Toast success
  - [ ] **VERIFY:** Stat card updates in real-time
- [ ] Send interview invitation:
  - [ ] Fill interview date/time/location
  - [ ] Add notes
  - [ ] Send
  - [ ] **VERIFY:** Toast success "Interview scheduled"
  - [ ] **VERIFY:** Notification sent to applicant (check applicant side)
- [ ] Accept applicant:
  - [ ] Status → "Được chọn"
  - [ ] **VERIFY:** Toast success
  - [ ] **VERIFY:** Job position count decreases
- [ ] Reject applicant:
  - [ ] Status → "Không phù hợp"
  - [ ] **VERIFY:** Toast success
  - [ ] **VERIFY:** Changes reflected immediately

#### Test 2.3.4: Invalid Status Transitions
- [ ] Try invalid status change:
  - [ ] From "Được chọn" → "Chờ xử lý"
  - [ ] **VERIFY:** Error toast appears "Cannot transition from..."
  - [ ] **VERIFY:** Status doesn't change
- [ ] From "Không phù hợp" → any status
  - [ ] **VERIFY:** Error shows
  - [ ] **VERIFY:** No change allowed

#### Test 2.3.5: Search & Filter
- [ ] In applicants list, use search:
  - [ ] Search by name
  - [ ] **VERIFY:** Results filter immediately
  - [ ] Search by email
  - [ ] **VERIFY:** Results update
- [ ] Filter by status:
  - [ ] Select "Chờ xử lý"
  - [ ] **VERIFY:** Only pending applicants show
  - [ ] Select "Đang phỏng vấn"
  - [ ] **VERIFY:** Only interview applicants show
- [ ] Filter by job:
  - [ ] Select specific job
  - [ ] **VERIFY:** Only that job's applicants show

---

### Section 2.4: Real-time Dashboard Updates

#### Test 2.4.1: Auto-Refresh Statistics
- [ ] Open dashboard in 2 browser windows:
  - [ ] Window A: Employer dashboard
  - [ ] Window B: Admin panel or another employer
- [ ] In Window B, change application status
- [ ] **VERIFY:** In Window A, stats update automatically every 5 seconds
- [ ] Check stat cards update:
  - [ ] "Đang xử lý" count
  - [ ] "Đang phỏng vấn" count
  - [ ] Total applicants

#### Test 2.4.2: Real-time Notifications
- [ ] Open dashboard
- [ ] New application arrives (from another user/applicant)
- [ ] **VERIFY:** Notification badge updates
- [ ] **VERIFY:** "Chờ xử lý" count increases
- [ ] Click notification
- [ ] **VERIFY:** Shows new applicant info

---

## 🔄 TEST SCENARIO 3: NOTIFICATION SYSTEM

### Section 3.1: Toast Notifications

#### Test 3.1.1: Success Toasts
- [ ] **Applicant side:**
  - [ ] Save job → Toast "Job saved" (green)
  - [ ] Apply job → Toast "Application sent" (green)
  - [ ] Update profile → Toast "Profile updated" (green)
- [ ] **Employer side:**
  - [ ] Change status → Toast "Status updated" (green)
  - [ ] Post job → Toast "Job posted" (green)
  - [ ] Add recruiter → Toast "Recruiter added" (green)

#### Test 3.1.2: Error Toasts
- [ ] Apply without CV when required → Toast "CV required" (red)
- [ ] Try invalid status change → Toast "Cannot transition" (red)
- [ ] Network error → Toast "Connection error" (red)

#### Test 3.1.3: Warning Toasts
- [ ] Delete without confirmation → Toast "Confirm deletion" (yellow)
- [ ] Incomplete form → Toast "Please fill required fields" (yellow)

#### Test 3.1.4: Info Toasts
- [ ] View saved job → Toast "Loading..." (blue)
- [ ] Refresh data → Toast "Updating..." (blue)

#### Test 3.1.5: Toast Behavior
- [ ] Toasts display in top-right corner
- [ ] **VERIFY:** Slide in animation
- [ ] Wait 3 seconds
- [ ] **VERIFY:** Auto-dismiss
- [ ] **VERIFY:** Slide out animation
- [ ] Click close button on toast
- [ ] **VERIFY:** Dismisses immediately
- [ ] Multiple toasts stack vertically
- [ ] **VERIFY:** All visible simultaneously
- [ ] Each has individual close button
- [ ] **VERIFY:** Close one doesn't affect others

---

## 🔐 TEST SCENARIO 4: VALIDATION & ERROR HANDLING

### Section 4.1: Form Validations

#### Test 4.1.1: Registration
- [ ] Submit empty form
  - [ ] **VERIFY:** Toast "All fields required"
- [ ] Invalid email
  - [ ] **VERIFY:** Toast "Invalid email format"
- [ ] Weak password
  - [ ] **VERIFY:** Toast "Password too short"
- [ ] Passwords don't match
  - [ ] **VERIFY:** Toast "Passwords don't match"

#### Test 4.1.2: Profile Updates
- [ ] Update with invalid data
  - [ ] **VERIFY:** Validation error shown
  - [ ] **VERIFY:** Toast error appears
  - [ ] Data not saved

#### Test 4.1.3: Job Application
- [ ] Submit without selecting CV
  - [ ] **VERIFY:** Toast error
  - [ ] **VERIFY:** Modal doesn't close
- [ ] Duplicate application
  - [ ] Apply for same job twice
  - [ ] **VERIFY:** Error toast "Already applied"

#### Test 4.1.4: Job Posting
- [ ] Missing required fields
  - [ ] **VERIFY:** Toast error
  - [ ] **VERIFY:** Form highlights empty fields
- [ ] Invalid salary range
  - [ ] **VERIFY:** Toast error
  - [ ] **VERIFY:** Min > Max error shown

---

### Section 4.2: Authorization & Security

#### Test 4.2.1: Route Protection
- [ ] Try accessing `/employer-dashboard` as applicant
  - [ ] **VERIFY:** Redirected to login or error
- [ ] Try accessing `/applicant-dashboard` as employer
  - [ ] **VERIFY:** Access denied or redirect

#### Test 4.2.2: CSRF Protection
- [ ] All forms include CSRF token
  - [ ] **VERIFY:** `{{ csrf_token() }}` in meta
  - [ ] **VERIFY:** Token in forms
- [ ] Try request without CSRF
  - [ ] **VERIFY:** 403 error

---

## 🌐 TEST SCENARIO 5: CROSS-BROWSER & RESPONSIVE

### Section 5.1: Browser Compatibility
- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Edge (latest)
- [ ] Safari (if available)
- [ ] **For each:**
  - [ ] All features work
  - [ ] No console errors
  - [ ] Toasts display correctly
  - [ ] Animations smooth

### Section 5.2: Responsive Design
- [ ] Desktop (1920x1080)
  - [ ] All elements visible
  - [ ] Layout optimal
- [ ] Tablet (768px width)
  - [ ] Mobile menu works
  - [ ] Tables responsive
  - [ ] Modals fit screen
- [ ] Mobile (375px width)
  - [ ] Touch targets adequate (44x44px)
  - [ ] Toasts visible
  - [ ] Forms usable
  - [ ] No horizontal scroll

---

## ⚡ TEST SCENARIO 6: PERFORMANCE

### Section 6.1: Page Load Times
- [ ] Dashboard: < 2 seconds
- [ ] Job list: < 2 seconds
- [ ] Profile page: < 1.5 seconds
- [ ] Job detail: < 1.5 seconds

### Section 6.2: API Response Times
- [ ] Apply job: < 500ms
- [ ] Update status: < 300ms
- [ ] Search applicants: < 1s
- [ ] Load dashboard stats: < 300ms

### Section 6.3: Real-time Polling
- [ ] Interval: 5 seconds
- [ ] No excessive requests
- [ ] Stats update smoothly
- [ ] No memory leaks after 1+ hour

---

## 📊 TEST RESULTS SUMMARY

### Applicant Workflow: [ Pass / Fail / Partial ]
- Registration: ___
- Profile Setup: ___
- Job Search: ___
- Job Application: ___
- Application Tracking: ___

### Employer Workflow: [ Pass / Fail / Partial ]
- Registration: ___
- Job Posting: ___
- Applicant Review: ___
- Status Management: ___
- Interview Scheduling: ___

### Features: [ Pass / Fail / Partial ]
- Real-time Updates: ___
- Toast Notifications: ___
- Validations: ___
- Authorization: ___
- Responsive Design: ___

---

## 🐛 BUGS FOUND

| # | Severity | Feature | Description | Status |
|---|----------|---------|-------------|--------|
| 1 | | | | |
| 2 | | | | |
| 3 | | | | |

---

## ✅ SIGN-OFF

**Tested By:** ________________  
**Date:** ________________  
**Overall Result:** [ PASS / FAIL / NEEDS FIXES ]  
**Ready for Production:** [ YES / NO ]

