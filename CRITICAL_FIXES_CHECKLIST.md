# JobIT - Critical Issues Checklist

## ✅ Immediate Action Items (Complete by EOD)

### [ ] 1. Remove TODO Comments in Recommendations
**File:** `resources/views/applicant/recommendations.blade.php`

**Current (Lines 997-1003):**
```javascript
// TODO: Call API to save job
// TODO: Call API to unsave job
```

**Action:**
- [ ] Replace with actual AJAX implementation
- [ ] Test save/unsave buttons work
- [ ] Verify job remains saved after refresh

**Test Command:**
```bash
# Go to /recommendations page
# Click heart icon
# Verify it changes appearance
# Refresh page - should stay saved
```

---

### [ ] 2. Create Missing Employer Model
**File:** Create `app/Models/Employer.php`

**Code to Add:**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    protected $table = 'employers';
    protected $fillable = ['user_id', 'companies_id', 'chuc_vu', 'so_dien_thoai'];

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relationship to Company
    public function company()
    {
        return $this->hasOne(Company::class, 'companies_id', 'companies_id');
    }
}
```

**Verification:**
- [ ] Model created in correct location
- [ ] No syntax errors
- [ ] Relationships defined correctly

---

### [ ] 3. Create IsEmployer Middleware
**File:** Create `app/Http/Middleware/IsEmployer.php`

**Code to Add:**
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsEmployer
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== 'employer') {
            return redirect()->route('home')
                ->with('error', 'Bạn không có quyền truy cập trang này');
        }

        return $next($request);
    }
}
```

**Register in `app/Http/Kernel.php`:**
```php
protected $routeMiddleware = [
    // ... existing middleware ...
    'employer' => \App\Http\Middleware\IsEmployer::class,
];
```

**Verification:**
- [ ] Middleware created
- [ ] Registered in Kernel.php
- [ ] Test accessing /employer-dashboard as applicant (should redirect)
- [ ] Test accessing /employer-dashboard as employer (should work)

---

### [ ] 4. Fix Duplicate Routes in `routes/web.php`

**Search for and identify duplicates:**
```bash
grep -n "applicant.dashboard\|job.detail" routes/web.php
```

**Duplicates to Remove:**
1. Line 110 - `applicant.dashboard` (REMOVE - using wrong controller)
   - Current: `HomeController::applicantDashboard`
   - Keep the one at line 231

2. Line 309 - `job.detail` (REMOVE)
   - Consolidate with line 55

3. Line 49 & Line 72 - `company.edit` (REVIEW - same controller?)

**After Cleanup:**
```php
// KEEP (around line 55):
Route::get('/job/{id}', [JobController::class, 'show'])->name('job.detail');

// KEEP (around line 231):
Route::get('/applicant-dashboard', [HomeController::class, 'applicantDashboard'])
    ->name('applicant.dashboard')
    ->middleware('auth');

// DELETE all other versions of these routes
```

**Verification:**
- [ ] Only ONE route per name
- [ ] Test both URLs work (if both names kept)
- [ ] No 404 errors on job detail page

---

### [ ] 5. Add Validation to Critical Methods

**File:** `app/Http/Controllers/ApplicantController.php`

**Method 1 - updateGioiThieu() (around line 120):**
```php
public function updateGioiThieu(Request $request)
{
    $validated = $request->validate([
        'gioithieu' => 'nullable|string|max:1000',
    ]);

    // ... rest of method
}
```

**Method 2 - storeNgoaiNgu() (around line 1015):**
```php
public function storeNgoaiNgu(Request $request)
{
    $validated = $request->validate([
        'ten_ngoai_ngu' => 'required|string|max:50',
        'trinhdo' => 'required|in:beginner,intermediate,advanced,fluent',
    ]);

    // ... rest of method
}
```

**Method 3 - updateMucLuong() (around line 1241):**
```php
public function updateMucLuong(Request $request)
{
    $validated = $request->validate([
        'mucluong_mongmuon' => 'required|numeric|min:0|max:999999999',
    ]);

    // ... rest of method
}
```

**Verification:**
- [ ] Try submitting empty values (should be rejected)
- [ ] Try submitting invalid values (should be rejected)
- [ ] Valid values accepted
- [ ] Error messages shown in response

---

### [ ] 6. Fix Interview Notification Bug

**File:** `app/Http/Controllers/ApplicationController.php`

**Find method:** `sendInterviewInvitation()` (around line 380)

**Add after JobInvitation creation:**
```php
// Create notification for applicant
if ($application->applicant && $application->applicant->user) {
    Notification::create([
        'user_id' => $application->applicant->user->id,
        'type' => 'interview_invitation',
        'message' => "Bạn được mời phỏng vấn vị trí {$application->job->title} tại {$application->job->company->tencty}",
        'data' => [
            'invitation_id' => $jobInvitation->id,
            'job_id' => $application->job->job_id,
            'company_id' => $application->job->companies_id,
        ],
        'is_read' => false
    ]);
}
```

**Verification:**
- [ ] Send interview invitation via UI
- [ ] Check notifications table in database
- [ ] Notification appears for applicant
- [ ] Notification contains correct data

---

## 🔍 Daily Verification Checklist

### Every Day - Run These Commands

```bash
# 1. Check for syntax errors
php artisan tinker
> Exit (should start without errors)

# 2. Check routes registered
php artisan route:list | grep "applicant\|job\|employer"

# 3. Check database migrations
php artisan migrate:status

# 4. Run existing tests
php artisan test

# 5. Clear cache and rebuild
php artisan cache:clear
php artisan config:cache
```

### Critical Path Test Flow

1. **Employer Registration:**
   ```
   GET /register/employer
   POST /register/employer (with valid data)
   → Should create user, employer, company records
   → Should redirect to dashboard
   ```

2. **Job Creation:**
   ```
   GET /employer/postjob
   POST /post-job (with valid data)
   → Should create job record
   → Should show success message
   → Job should appear in search
   ```

3. **Applicant Application:**
   ```
   GET /job/{id}
   POST /apply-job
   → Should create application record
   → Should show success message
   → Application should appear in applicant's list
   ```

4. **Interview Invitation:**
   ```
   POST /application/{id}/send-interview (with interview details)
   → Should create JobInvitation
   → Should send email
   → Should create notification
   → Applicant should see notification
   ```

5. **Save/Unsave Job:**
   ```
   POST /job/save/{jobId}
   → Should create SavedJob record
   → UI should show as saved
   DELETE /job/unsave/{jobId}
   → Should delete SavedJob record
   → UI should show as not saved
   ```

---

## 🧪 Test Cases for Critical Fixes

### Test 1: Employer Registration Flow
```php
// In tests/Feature/EmployerRegistrationTest.php
public function test_employer_can_register()
{
    $response = $this->post('/register/employer', [
        'name' => 'Test Employer',
        'email' => 'employer@test.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $this->assertDatabaseHas('users', [
        'email' => 'employer@test.com',
        'role' => 'employer'
    ]);

    $this->assertDatabaseHas('employers', [
        'user_id' => \App\Models\User::where('email', 'employer@test.com')->first()->id
    ]);
}
```

### Test 2: Application Status Validation
```php
// In tests/Unit/ApplicationStatusTest.php
public function test_cannot_transition_from_duoc_chon_to_cho_xu_ly()
{
    $application = Application::factory()
        ->create(['trang_thai' => 'duoc_chon']);

    $canTransition = $application->canTransitionTo('cho_xu_ly');

    $this->assertFalse($canTransition);
}
```

### Test 3: Save Job Functionality
```php
// In tests/Feature/SaveJobTest.php
public function test_applicant_can_save_job()
{
    $applicant = User::factory()->applicant()->create();
    $job = JobPost::factory()->create();

    $response = $this->actingAs($applicant)
        ->post("/job/save/{$job->job_id}");

    $this->assertDatabaseHas('saved_jobs', [
        'job_id' => $job->job_id,
        'applicant_id' => $applicant->applicant->id_uv
    ]);
}
```

---

## 🚨 Error Messages to Handle

Each critical fix should handle these error scenarios:

### Employer Registration Errors
- [ ] Email already exists
- [ ] Passwords don't match
- [ ] Required fields missing
- [ ] Invalid email format

### Job Creation Errors
- [ ] Employer has no company
- [ ] Required fields missing
- [ ] Salary min > salary max
- [ ] Deadline is in past

### Application Errors
- [ ] User already applied to job
- [ ] Job has expired
- [ ] Applicant profile incomplete
- [ ] No CV uploaded (if required)

### Interview Invitation Errors
- [ ] Invalid interview date/time
- [ ] Interview location URL invalid
- [ ] Applicant email missing

---

## 📊 Success Metrics

Track these after each fix:

```
METRIC                          BEFORE  AFTER   TARGET
=====================================================
Routes with duplicates            3       0       0
Missing validations              3       0       0
Uncaught exceptions              ?      <5      0
Critical path pass rate         50%    100%    100%
Employer auth success rate       ?      100%    100%
Job creation success rate        ?      100%    100%
Notification creation rate       50%    100%    100%
Save/Unsave function working    NO      YES     YES
```

---

## 📞 Emergency Contact Points

If any critical issue causes application failure:

### Database
- Check error logs: `storage/logs/laravel.log`
- Connection issues: Review `.env` database credentials
- Migration issues: Run `php artisan migrate:status`

### Routes
- List all routes: `php artisan route:list`
- Check 404 errors: Review route names and paths
- Clear cache: `php artisan route:cache --force`

### Auth
- Check session: `php artisan tinker` then `Session::all()`
- Verify middleware: Check `app/Http/Kernel.php`
- Test login: Try registering new test user

### Notifications
- Check if notifications created: `select * from notifications`
- Verify email sent: Check `storage/logs/laravel.log`
- Test notification creation directly in tinker

---

**IMPORTANT:** Complete ALL items in "Immediate Action Items" section before moving to next phase!

**Timeline:** These items should take 12-16 hours to complete properly with testing.

**Next Check-in:** After completion, verify with full system test before marking as done.
