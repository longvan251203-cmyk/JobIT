# JobIT - Audit Summary & Quick Action Items

## 📊 Audit Statistics
- **Total Issues Found:** 50
- **Critical Issues:** 5
- **High Priority:** 5
- **Medium Priority:** 20
- **Low Priority:** 20

---

## 🚨 CRITICAL FIXES (Do First - 1-2 days)

### Issue #1: Save/Unsave Jobs TODO
**File:** `resources/views/applicant/recommendations.blade.php` (lines 997, 1003)
```javascript
// Currently:
// TODO: Call API to save job
// TODO: Call API to unsave job

// Implement:
async function toggleSave(btn, jobId) {
    const isSaved = btn.classList.contains('saved');
    const endpoint = isSaved ? `/job/unsave/${jobId}` : `/job/save/${jobId}`;
    const method = isSaved ? 'DELETE' : 'POST';
    
    try {
        const response = await fetch(endpoint, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            }
        });
        // Update UI based on response
    } catch (error) {
        console.error('Error:', error);
    }
}
```

### Issue #2: Create Employer Model & Middleware
**Missing Files:**
- `app/Models/Employer.php`
- `app/Http/Middleware/IsEmployer.php`

```php
// app/Models/Employer.php
class Employer extends Model {
    protected $table = 'employers';
    public function user() { return $this->belongsTo(User::class); }
    public function company() { return $this->hasOne(Company::class); }
}

// app/Http/Middleware/IsEmployer.php
class IsEmployer {
    public function handle($request, $next) {
        if (Auth::user()?->role !== 'employer') {
            abort(403);
        }
        return $next($request);
    }
}
```

Then register in `app/Http/Kernel.php`:
```php
protected $routeMiddleware = [
    // ... other middleware
    'employer' => \App\Http\Middleware\IsEmployer::class,
];
```

### Issue #3: Add Missing Validation
**Files to Update:**
1. `ApplicantController.php` - `updateGioiThieu()` method
2. `ApplicantController.php` - `storeNgoaiNgu()` method  
3. `ApplicantController.php` - `updateMucLuong()` method

```php
// Example for updateGioiThieu
public function updateGioiThieu(Request $request) {
    $validated = $request->validate([
        'gioithieu' => 'nullable|string|max:1000', // ADD THIS
    ]);
    // ... rest of code
}
```

### Issue #4: Remove Duplicate Routes
**In `routes/web.php`:**
- Remove duplicate `applicant.dashboard` (appears at lines 110 and 231)
- Remove duplicate `job.detail` routes (lines 55 and 309)
- Keep one version, delete duplicates

### Issue #5: Complete Interview Notification System
**File:** `ApplicationController.php`

Need to add notification creation after interview invitation:
```php
public function sendInterviewInvitation(Request $request, $applicationId) {
    // ... existing code ...
    
    // ADD THIS:
    if ($application->applicant->user) {
        Notification::createJobInvitationNotification(
            $application->applicant->user->id,
            $jobInvitation
        );
    }
}
```

---

## ⚡ HIGH PRIORITY (3-5 days)

### Issue #6: Add Application Status Validation
**File:** `app/Models/Application.php`

```php
const VALID_TRANSITIONS = [
    'cho_xu_ly' => ['dang_phong_van', 'khong_phu_hop'],
    'dang_phong_van' => ['duoc_chon', 'khong_phu_hop'],
    'duoc_chon' => [],
    'khong_phu_hop' => [],
];

public function canTransitionTo($newStatus) {
    $allowed = self::VALID_TRANSITIONS[$this->trang_thai] ?? [];
    return in_array($newStatus, $allowed);
}
```

### Issue #7: Add Missing Edit Routes
**In `routes/web.php`, add:**
```php
Route::middleware(['auth'])->group(function () {
    // Ngoại Ngữ - add edit & update
    Route::get('/ngoai-ngu/{id}/edit', [ApplicantController::class, 'editNgoaiNgu'])
        ->name('applicant.editNgoaiNgu');
    Route::post('/ngoai-ngu/{id}/update', [ApplicantController::class, 'updateNgoaiNgu'])
        ->name('applicant.updateNgoaiNgu');
    
    // Kỹ Năng - add edit & update
    Route::get('/ky-nang/{id}/edit', [ApplicantController::class, 'editKyNang'])
        ->name('applicant.editKyNang');
    Route::post('/ky-nang/{id}/update', [ApplicantController::class, 'updateKyNang'])
        ->name('applicant.updateKyNang');
});
```

Then implement methods in `ApplicantController`.

### Issue #8: Fix Job Applicants Duplicate Views
**Action:** Choose one version
- Keep: `resources/views/employer/job-applicants.blade.php`
- Delete: `resources/views/employer/job-applicants-new.blade.php`
- Update route to use the correct one

### Issue #9: Implement Employer Dashboard
**File:** Create `resources/views/employer/dashboard.blade.php`

Remove edit form from dashboard and create dedicated dashboard with:
- Statistics cards (jobs, applications, etc.)
- Recent applications
- Quick actions
- Recruiter management

Update route:
```php
Route::get('/employer-dashboard', [EmployerDashboardController::class, 'index'])
    ->name('employer.dashboard')
    ->middleware('auth:employer');
```

### Issue #10: Fix Saved Jobs Implementation
**File:** `resources/views/applicant/recommendations.blade.php`

Complete the `toggleSave()` function:
```javascript
async function toggleSave(btn, jobId) {
    const isSaved = btn.classList.contains('saved');
    const endpoint = isSaved ? `/job/unsave/${jobId}` : `/job/save/${jobId}`;
    const method = isSaved ? 'DELETE' : 'POST';
    
    const response = await fetch(endpoint, {
        method: method,
        headers: { 'X-CSRF-TOKEN': csrfToken }
    });
    
    if (response.ok) {
        btn.classList.toggle('saved');
        btn.querySelector('i').classList.toggle('bi-heart');
        btn.querySelector('i').classList.toggle('bi-heart-fill');
    }
}
```

---

## 📋 MEDIUM PRIORITY CHECKLIST (1-2 weeks)

- [ ] Add client-side form validation in Blade templates
- [ ] Implement job expiry automatic status update
- [ ] Add N+1 query fixes with eager loading
- [ ] Implement caching strategy for recommendations
- [ ] Add authorization policies for resources
- [ ] Implement real-time notification system
- [ ] Add comprehensive error handling
- [ ] Create missing model relationships
- [ ] Add database cascade delete configuration
- [ ] Implement unit tests for critical functions

---

## 🔒 Security Issues to Address

### Issue #44: Add Authorization Checks
```php
// In routes:
Route::post('/company/update', [CompanyController::class, 'update'])
    ->middleware(['auth', 'employer']); // ADD EMPLOYER CHECK
```

### Issue #45: CV Upload Security
```php
// In ApplicantController::uploadCv()
$file->validate([
    'mimes' => 'pdf,doc,docx',
    'max' => 5120, // 5MB max
]);
```

---

## 📈 Testing Plan

Create tests for:
1. Application status transitions
2. Recommendation scoring
3. Notification creation
4. Job invitation workflow
5. Authorization checks

```bash
php artisan make:test ApplicationStatusTransitionTest --unit
php artisan make:test JobInvitationWorkflowTest --feature
```

---

## 🔄 Deployment Checklist

- [ ] Complete all CRITICAL issues
- [ ] Run all tests
- [ ] Review error logs
- [ ] Backup database
- [ ] Migrate any pending migrations
- [ ] Clear application cache
- [ ] Test all major user flows
- [ ] Monitor error logs post-deployment

---

## 📞 Support

Full detailed audit available in: **AUDIT_REPORT.md**

Each issue includes:
- Exact file location
- Line numbers
- Code examples
- Impact assessment
- Recommended fixes
