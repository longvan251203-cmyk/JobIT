# JobIT - Visual Reference Guide

## Architecture Overview

```
┌─────────────────────────────────────────────────────────┐
│                    USER INTERFACE                        │
├──────────────────┬──────────────────┬──────────────────┤
│   APPLICANT      │    EMPLOYER      │      ADMIN       │
│   Dashboard      │    Dashboard     │    (Missing)     │
│   Profile        │    Job Posts     │                  │
│   Jobs           │    Applications  │                  │
│   Applications   │    Invitations   │                  │
│   Notifications  │    Notifications │                  │
└──────────────────┴──────────────────┴──────────────────┘
         │                  │                  │
         └──────────────────┼──────────────────┘
                            │
┌─────────────────────────────────────────────────────────┐
│                   LARAVEL ROUTES                         │
├──────────────────┬──────────────────────────────────────┤
│  Web Routes      │          API Routes                  │
│  (350+ lines)    │          (30 lines)                  │
│  ✅ Auth         │          ❌ Minimal coverage         │
│  ✅ CRUD         │          ⚠️  Some endpoints missing  │
│  ❌ Duplicates   │          ⚠️  No auth checks          │
│  ❌ Missing MW   │                                      │
└──────────────────┴──────────────────────────────────────┘
         │                         │
         └────────┬────────────────┘
                  │
┌─────────────────────────────────────────────────────────┐
│               CONTROLLERS (9 Files)                      │
├────────────────────────────────────────────────────────┤
│                                                         │
│  HomeController                JobController           │
│  ├─ index() ✅              ├─ show() ✅             │
│  └─ applicantDashboard() ✅  ├─ store() ✅            │
│                             ├─ update() ✅            │
│  AuthController             └─ destroy() ✅           │
│  ├─ login() ✅                                        │
│  ├─ register() ✅            ApplicantController      │
│  └─ logout() ✅              ├─ showProfile() ✅      │
│                             ├─ updateProfile() ✅     │
│  CompanyController           ├─ storeSKill() ✅       │
│  ├─ edit() ⚠️  (wrong name)  ├─ deleteSkill() ✅      │
│  └─ update() ✅              ├─ uploadCV() ⚠️         │
│                             └─ ...many more...        │
│  EmployerController          (1264 lines, complex)    │
│  ├─ jobApplicants() ✅       
│  └─ sendInterview() ⚠️       ApplicationController    │
│                             ├─ store() ✅            │
│  CandidatesController        ├─ updateStatus() ⚠️    │
│  ├─ index() ⚠️  (complex)    └─ ...                  │
│  └─ sendInvite() ✅          (746 lines)             │
│                                                         │
└────────────────────────────────────────────────────────┘
         │
         └───────────────────┬───────────────────┐
                             │                   │
┌─────────────────────────────────────────────────────────┐
│              MODELS (13 Files)                          │
├───────────────────────────────┬───────────────────────┤
│  User                         │   JobPost             │
│  ├─ applicant() ✅            │   ├─ company() ✅     │
│  └─ employer() ⚠️ (incomplete)│   ├─ applications() ✅│
│                               │   ├─ invitations() ❌ │
│  Applicant                    │   └─ details() ✅     │
│  ├─ kinhnghiem() ✅           │                       │
│  ├─ hocvan() ✅               │   Application         │
│  ├─ kynang() ✅               │   ├─ job() ✅         │
│  └─ ...many more...           │   ├─ applicant() ✅   │
│  (129 lines, well-structured) │   └─ status() ⚠️     │
│                               │   (160 lines)         │
│  Company ✅                    │                       │
│  JobInvitation ✅             │   Notification ✅     │
│  SavedJob ✅                   │   (199 lines)         │
│  JobRecommendation ✅         │                       │
│                               │   ...+ 4 more models  │
└───────────────────────────────┴───────────────────────┘
         │
         └────────────────────┬────────────────────┘
                              │
┌─────────────────────────────────────────────────────────┐
│           DATABASE (13+ Tables)                         │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  users ←────┬────→ applicants                           │
│      ↓      │          │                               │
│      │      ├────→ applications                         │
│      │      │          ↓                               │
│      │      └────→ job_recommendations                 │
│      │              ↓                                  │
│      ├─────→ employers ←──┬────→ companies             │
│      │                    │                            │
│      └─────→ notifications│                            │
│                           └────→ job_posts ←─────────┐ │
│              saved_jobs ──────────────────────────→┘  │ │
│              job_invitations ────────────────────────┘ │
│              ...+ more tables                          │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

---

## User Flow Diagrams

### Applicant Flow (Job Seeker)

```
┌────────────┐
│  Register  │
└─────┬──────┘
      │ ✅ Works
      ↓
┌────────────┐
│  Login     │
└─────┬──────┘
      │ ✅ Works
      ↓
┌────────────────────┐
│  Update Profile    │
│  - Ngoại Ngữ  ❌   │ ← Can't edit
│  - Kỹ Năng   ❌    │ ← Can't edit
│  - Others    ✅    │
└─────┬──────────────┘
      │ ⚠️  Partial
      ↓
┌────────────────────┐
│  Browse Jobs       │
│  - Search   ✅     │
│  - Filter   ✅     │
│  - Save    ❌      │ ← TODO not implemented
└─────┬──────────────┘
      │ ⚠️  Partial
      ↓
┌────────────────────┐
│  Apply to Job      │
│  - Submit   ✅     │
│  - Status   ⚠️     │ ← Can't transition properly
└─────┬──────────────┘
      │ ⚠️  Partial
      ↓
┌────────────────────┐
│  View Notifications│
│  - Receive ⚠️      │ ← Only partial integration
│  - Read    ✅      │
│  - Reply   ❌      │
└─────┬──────────────┘
      │ ⚠️  Partial
      ↓
┌────────────────────┐
│  Interview        │
│  - Receive ⚠️      │ ← Notifications missing
│  - Respond ✅      │
│  - Prepare ⚠️      │
└─────┬──────────────┘
      │ ⚠️  Partial
      ↓
┌────────────────────┐
│  Get Hired        │
│  - Accept ✅       │
│  - Negotiate ❌    │
│  - Sign    ❌      │
└────────────────────┘
   ⚠️  Incomplete
```

### Employer Flow (Recruiter)

```
┌────────────┐
│  Register  │
│  (Employer)│
└─────┬──────┘
      │ ❌ Model missing
      ↓
┌────────────┐
│  Login     │ 
└─────┬──────┘
      │ ⚠️  Unclear
      ↓
┌────────────────────┐
│  Setup Company     │
│  - Profile ✅      │
│  - Logo   ✅       │
│  - Info   ✅       │
└─────┬──────────────┘
      │ ✅ Works
      ↓
┌────────────────────┐
│  Post Jobs        │
│  - Create  ✅      │
│  - Edit    ✅      │
│  - Delete  ✅      │
└─────┬──────────────┘
      │ ✅ Works
      ↓
┌────────────────────┐
│  View Applications │
│  - List    ✅      │
│  - Filter  ⚠️      │
│  - View   ✅       │
└─────┬──────────────┘
      │ ⚠️  Partial
      ↓
┌────────────────────┐
│  Manage Candidates │
│  - Search  ⚠️      │ ← API exists but UI missing
│  - Contact ❌      │ ← No messaging
│  - Rate   ❌       │
└─────┬──────────────┘
      │ ❌ Incomplete
      ↓
┌────────────────────┐
│  Send Invitations  │
│  - Interview ⚠️    │ ← Notifications missing
│  - Email   ⚠️      │
│  - Feedback ❌     │
└─────┬──────────────┘
      │ ⚠️  Partial
      ↓
┌────────────────────┐
│  Hire Candidate   │
│  - Select  ⚠️      │ ← Status confusion
│  - Notify  ⚠️      │ ← Notifications incomplete
│  - Onboard ❌      │
└────────────────────┘
   ⚠️  Incomplete
```

---

## File Quality Matrix

```
                Validation  Error Handling  Relationships  Tests
                -----------  ─────────────  ─────────────  ─────
ApplicantCtrl       ⚠️           ⚠️             ✅          ❌
JobCtrl             ✅           ✅             ✅          ❌
ApplicationCtrl     ⚠️           ✅             ✅          ❌
CompanyCtrl         ✅           ✅             ✅          ❌
AuthCtrl            ✅           ✅             ✅          ❌
CandidatesCtrl      ⚠️           ⚠️             ✅          ❌
EmployerCtrl        ⚠️           ⚠️             ✅          ❌

Applicant Model     ✅           ✅             ✅           ❌
Application Model   ✅           ✅             ✅           ❌
JobPost Model       ✅           ✅             ⚠️           ❌
Company Model       ✅           ✅             ✅           ❌
Employer Model      ❌           N/A            N/A          N/A

Routes (web.php)    ⚠️           N/A            N/A          ❌
Routes (api.php)    ⚠️           N/A            N/A          ❌

Applicant Views     ⚠️           ❌             N/A          ❌
Employer Views      ⚠️           ❌             N/A          ❌
```

---

## Issue Hotspot Map

```
CRITICAL HOTSPOTS (Must Fix First)
──────────────────────────────────

1. routes/web.php                    🔴 5 issues
   └─ Duplicates & missing middleware

2. ApplicantController.php            🔴 3 issues
   └─ Missing validation in 3 methods

3. ApplicationController.php          🔴 2 issues
   └─ Missing notifications & transitions

4. Missing Model: Employer            🔴 2 issues
   └─ Breaking entire employer system

5. recommendations.blade.php          🔴 1 issue
   └─ TODO comments for save/unsave


HIGH PRIORITY HOTSPOTS
───────────────────────

6. EmployerController.php             🟠 3 issues
7. CompanyController.php              🟠 2 issues
8. job-applicants views              🟠 2 issues
9. Models/Relationships              🟠 3 issues
10. Notification System              🟠 2 issues


MEDIUM HOTSPOTS
────────────────

11. API Routes                        🟡 3 issues
12. Security & Auth                  🟡 3 issues
13. Performance & Caching            🟡 2 issues
14. Client-side Validation           🟡 3 issues
15. Error Handling                   🟡 4 issues
```

---

## Quick Status Dashboard

```
╔═══════════════════════════════════════════════════════════════╗
║                     COMPONENT STATUS                          ║
╠═══════════════════════════════════════════════════════════════╣
║                                                               ║
║  Authentication System          ██████░░░░░░░░░░ 40% ⚠️      ║
║  Job Management                 █████████░░░░░░░ 60% ⚠️      ║
║  Application Workflow           ████████░░░░░░░░ 50% ⚠️      ║
║  Applicant Profile              ███████████░░░░░ 70% ✅      ║
║  Notifications                  ██████░░░░░░░░░░ 35% ❌      ║
║  Validation & Error Handling    ████░░░░░░░░░░░░ 25% ❌      ║
║  Testing                        ░░░░░░░░░░░░░░░░ 5%  ❌      ║
║  Security                       █████░░░░░░░░░░░ 30% ❌      ║
║  Performance                    ████░░░░░░░░░░░░ 25% ❌      ║
║                                                               ║
╠═══════════════════════════════════════════════════════════════╣
║  Overall Application Health:    ██████░░░░░░░░░░ 40%        ║
║  Ready for Production:                                        ║
║       ❌ NOT READY (Critical issues must be fixed first)      ║
╚═══════════════════════════════════════════════════════════════╝
```

---

## Dependency Resolution Order

```
TIER 1 (Must have)
│
├─ 1. Employer Model
│  └─ 2. Employer Middleware
│     └─ 3. Fix Employer Auth Routes
│
├─ 4. Remove Duplicate Routes
│  └─ Prevents routing confusion
│
├─ 5. Add Basic Validation
│  └─ Prevents data corruption
│
└─ 6. Complete Interview Notifications
   └─ Critical user communication

        ↓ After Tier 1 complete ↓

TIER 2 (Should have)
│
├─ 7. Application Status Validation
│  └─ 8. Status Transition Rules
│
├─ 9. Complete CRUD Endpoints
│  └─ 10. Edit Routes for Skills/Languages
│
└─ 11. Consolidate Views
   └─ 12. Create Proper Dashboards

        ↓ After Tier 2 complete ↓

TIER 3 (Nice to have)
│
├─ Authorization Checks
├─ Form Validation (JS)
├─ Error Handling
├─ Query Optimization
└─ Test Coverage

```

---

## Critical Path for Deployment

```
FRIDAY EOD            MONDAY 9AM           TUESDAY EOD
├─ Backup prod    ├─ Deploy fixes       ├─ Full QA test
├─ Test staging   ├─ Clear cache        ├─ User acceptance
├─ Review logs    ├─ Migrate DB         └─ Go live
└─ Go approval    └─ Test basics

TUESDAY EVENING
├─ Monitor errors
├─ Check logs
├─ User feedback
└─ Standby support
```

---

## Success Indicators

```
✅ BEFORE LAUNCH:
   • All 5 critical issues fixed
   • 10 critical path tests passing
   • 0 security issues
   • 0 SQL injection vulnerabilities
   • Error logging working
   • Backup tested

⚠️  AFTER LAUNCH (First 24 hours):
   • Error logs reviewed hourly
   • No 500 errors
   • <5% failed transactions
   • Notifications sending
   • Auth flows working
   • Job applications processing

📊 WEEK 1 METRICS:
   • 100% uptime
   • <2s page load
   • <500ms API response
   • 0 data loss incidents
   • 100+ new users
   • Positive feedback
```

---

This visual guide helps you understand the scope and interconnections of issues. Reference this when prioritizing fixes or explaining to stakeholders.
