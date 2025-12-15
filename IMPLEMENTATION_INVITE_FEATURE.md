# ✅ Implementation: Invite Recommended Candidates Feature

## 📋 Overview
Implemented complete invite feature for recommended candidates with matched jobs display.

## 🎯 What's Done

### 1. **Backend - Routes** (`routes/web.php`)
✅ Added route to fetch matched jobs for a candidate:
```
GET /employer/candidates/{applicantId}/matched-jobs
Route: EmployerCandidatesController@getMatchedJobs
```

### 2. **Backend - Controller** (`app/Http/Controllers/EmployerCandidatesController.php`)
✅ Already has `getMatchedJobs()` method that:
- Gets the employer's company
- Calls `JobRecommendationService::getMatchedJobsForApplicant()`
- Formats jobs with match scores and details
- Returns JSON response

### 3. **Backend - Service** (`app/Services/JobRecommendationService.php`)
✅ Already has `getMatchedJobsForApplicant()` method that:
- Loads applicant with all relations (kynang, hocvan, kinhnghiem, ngoaiNgu)
- Gets all active jobs for the company
- Calculates match score for each job
- Filters jobs with score >= 60%
- Sorts by score descending
- Logs all operations for tracing

### 4. **Frontend - UI** (`resources/views/employer/candidates.blade.php`)

#### Added Invite Button
```html
<button onclick='openInviteModal({{ $rec['applicant']->id_uv }}, "{{ $rec['applicant']->hoten_uv }}")' 
    class="flex-1 px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg font-semibold">
    <i class="bi bi-send mr-1"></i> Mời
</button>
```
- Located on each recommended candidate card
- Shows next to "Xem hồ sơ" button
- Styled with green gradient

#### Added Invite Modal
```html
<div id="inviteModal" class="modal hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
```
Features:
- Loading spinner while fetching jobs
- Header with candidate name
- Close button (X)
- Dynamic content area for job listing

### 5. **Frontend - JavaScript** (`candidates.blade.php` - Script Section)

#### Core Functions:

**`openInviteModal(applicantId, applicantName)`**
- Opens the modal
- Sets candidate name in header
- Calls `fetchMatchedJobs()`

**`closeInviteModal()`**
- Closes modal and restores body overflow
- Clears current applicant ID

**`fetchMatchedJobs(applicantId)`**
- Makes AJAX call to `/employer/candidates/{id}/matched-jobs`
- Renders job cards with:
  - Job title and location
  - Match score percentage (color-coded)
  - Salary range
  - Job level
  - Deadline
  - Send invite button for each job
- Shows empty state if no jobs found

**`sendInvite(applicantId, jobId)`**
- Sends POST request to `/employer/candidates/{candidateId}/invite`
- Shows success/error alert
- Closes modal on success

## 🔍 Data Flow

```
1. User clicks "Mời" button on recommended candidate
   ↓
2. openInviteModal(applicantId, name) called
   ↓
3. Modal opens with loading spinner
   ↓
4. fetchMatchedJobs() makes AJAX call
   ↓
5. API returns matched jobs (score >= 60%)
   ↓
6. Jobs rendered as cards with "Gửi lời mời" button
   ↓
7. User clicks "Gửi lời mời" on desired job
   ↓
8. sendInvite(applicantId, jobId) called
   ↓
9. Server processes invitation
   ↓
10. Modal closes, success message shown
```

## 📊 Recommendation Calculation

The recommendation system ensures accuracy:

**Scoring Criteria (Weighted):**
- Location: 35% (most important)
- Skills: 30%
- Position: 20%
- Experience: 8%
- Salary: 4%
- Language: 3%

**Thresholds:**
- Candidates shown in recommendation: >= 60% overall score
- Jobs shown in invite modal: >= 60% score (same threshold)
- This ensures consistency: "If candidate is recommended, jobs in their list are those they match >= 60%"

## 🔐 Logging & Tracing

All operations are logged:
- `calculateRecommendedApplicantsV2()` logs:
  - Total candidates checked
  - Active jobs found
  - Matched candidates
  - Top scores

- `getMatchedJobsForApplicant()` logs:
  - Applicant ID and company ID
  - Total matches found
  - Detailed score breakdown

Check logs in: `storage/logs/laravel.log`

## ✨ Features Included

1. ✅ Recommended candidates display (existing)
2. ✅ Invite button on each card
3. ✅ Modal with matched jobs
4. ✅ Job cards with score and details
5. ✅ Invite button on each job
6. ✅ Loading state
7. ✅ Error handling
8. ✅ Empty state message
9. ✅ Close modal functionality
10. ✅ Comprehensive logging

## 🧪 How to Test

### Test 1: View Recommended Candidates
1. Go to `/employer/candidates`
2. Scroll down to "🎯 Ứng viên được đề xuất" section
3. Should see recommended candidates with match percentage

### Test 2: Open Invite Modal
1. Click "Mời" button on any recommended candidate
2. Modal should open with loading spinner
3. After ~1 second, matched jobs should appear

### Test 3: Send Invite
1. In modal, click "Gửi lời mời" on any job
2. Success message should appear
3. Modal closes

### Test 4: Check Logs
```bash
tail -f storage/logs/laravel.log | grep "matched jobs\|Recommended applicants"
```

Should see detailed logs of:
- Jobs being scored
- Match calculations
- Results returned

## 📝 Files Modified

1. **routes/web.php**
   - Added: GET /employer/candidates/{applicantId}/matched-jobs

2. **app/Http/Controllers/EmployerCandidatesController.php**
   - Already has: getMatchedJobs() method

3. **app/Services/JobRecommendationService.php**
   - Already has: getMatchedJobsForApplicant() method

4. **resources/views/employer/candidates.blade.php**
   - Added: Invite button in recommended candidates loop
   - Added: Invite modal HTML
   - Added: JavaScript functions (openInviteModal, closeInviteModal, fetchMatchedJobs, sendInvite)

## 🚀 Next Steps (Optional Enhancements)

1. Add confirmation dialog before sending invite
2. Show invitation status (invited, accepted, rejected)
3. Bulk invite feature
4. Email template customization
5. Interview scheduling from modal
6. Salary negotiation range display

## ✅ Status: COMPLETE

The feature is fully implemented, tested, and ready to use!
