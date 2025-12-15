# Filtered Jobs Sidebar Fix - Architecture Diagram

## System Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                      APPLICANT HOME PAGE                         │
│                    (homeapp.blade.php)                           │
└─────────────────────────────────────────────────────────────────┘
         │                                                  │
         ├─────────────────────────────────────────────────┤
         │                                                  │
    ┌────▼─────┐                              ┌────────────▼────┐
    │  GRID    │                              │  DETAIL VIEW    │
    │  VIEW    │                              │   (Hidden)      │
    │          │                              │                 │
    │ Shows    │                              │  LEFT: Sidebar  │
    │ All Jobs │                              │  RIGHT: Detail  │
    └────┬─────┘                              └────────────┬────┘
         │                                                  │
         │ Click Job                                        │
         └───────────────────────────────────────────────┬─┘
                                                         │
                                                    ┌────▼─────────┐
                                                    │ showDetail   │
                                                    │ View(jobId)  │
                                                    └────┬─────────┘
                                                         │
                    ┌────────────────────────────────────┘
                    │
         ┌──────────▼──────────┐
         │ SIDEBAR POPULATION  │
         │ (NEW!)              │
         └──────────┬──────────┘
                    │
         ┌──────────▼──────────────────┐
         │ jobListColumn.innerHTML =    │
         │ renderJobList...             │
         │ (currentFilteredJobs)        │
         └──────────┬──────────────────┘
                    │
         ┌──────────▼──────────┐
         │ SIDEBAR DISPLAYS    │
         │ FILTERED RESULTS    │
         │ ✅ CORRECT JOBS!   │
         └─────────────────────┘
```

---

## Data Flow Diagram

```
┌──────────────────────────────────────────────────────────────┐
│                    USER INTERACTION FLOW                      │
└──────────────────────────────────────────────────────────────┘

     ┌─────────────────┐
     │ PAGE LOAD       │
     └────────┬────────┘
              │
              ▼
     ┌────────────────────────────┐
     │ Grid View Rendered         │
     │ (12 initial jobs)          │
     └────────┬───────────────────┘
              │
              ▼
     ┌────────────────────────────────────┐
     │ extractJobsFromHtml()              │
     │ ↓                                  │
     │ currentFilteredJobs = [12 jobs]   │
     └────────┬───────────────────────────┘
              │
              ▼
     ┌────────────────────────────┐
     │ User Ready to Interact     │
     │ ✅ Can search/filter      │
     └────────┬───────────────────┘
              │
     ┌────────┴────────┐
     │                 │
     ▼                 ▼
┌──────────┐    ┌─────────────┐
│ SEARCH   │    │ FILTER      │
└────┬─────┘    └────┬────────┘
     │               │
     ▼               ▼
┌────────────────────────────┐
│ performSearch() or         │
│ loadAllJobs()              │
└────┬───────────────────────┘
     │
     ▼
┌────────────────────────────┐
│ API Call                   │
│ /api/jobs/search?...       │
└────┬───────────────────────┘
     │
     ▼
┌─────────────────────────────────┐
│ API Response (HTML)             │
│ Returns filtered job cards      │
└────┬────────────────────────────┘
     │
     ▼
┌──────────────────────────────────┐
│ gridView.innerHTML = data.html   │
│ (Grid updated with filters)      │
└────┬─────────────────────────────┘
     │
     ▼
┌────────────────────────────────────┐
│ extractJobsFromHtml(data.html)     │
│ ↓                                  │
│ currentFilteredJobs = [filtered]   │
│ ✅ UPDATED!                        │
└────┬──────────────────────────────┘
     │
     ▼
┌────────────────────────────────┐
│ User clicks job in grid        │
│ showDetailView(jobId)          │
└────┬───────────────────────────┘
     │
     ▼
┌──────────────────────────────────┐
│ renderJobList...                 │
│ (currentFilteredJobs)            │
│ ↓                                │
│ Sidebar HTML generated           │
│ ✅ With filtered jobs            │
└────┬─────────────────────────────┘
     │
     ▼
┌──────────────────────────────────┐
│ jobListColumn.innerHTML = html   │
│ ↓                                │
│ attachListCardEvents()           │
│ ↓                                │
│ Sidebar fully functional         │
└──────────────────────────────────┘
     │
     ▼
┌──────────────────────────────────┐
│ Detail View Complete             │
│ - Left: Correct filtered jobs   │
│ - Right: Job details            │
│ ✅ PERFECT!                     │
└──────────────────────────────────┘
```

---

## Component Interaction

```
┌─────────────────────────────────────────────────────────────┐
│                    COMPONENT DIAGRAM                         │
└─────────────────────────────────────────────────────────────┘

    ┌──────────────────────────┐
    │  HTML Elements           │
    │                          │
    │  • gridView              │
    │  • detailView            │
    │  • jobListColumn         │
    │  • jobDetailColumn       │
    └──────────┬───────────────┘
               │
               ▼
    ┌──────────────────────────────┐
    │  Data Storage (NEW!)         │
    │                              │
    │  currentFilteredJobs = [     │
    │    {                         │
    │      job_id,               │
    │      title,                │
    │      company,              │
    │      salary,               │
    │      province,             │
    │      level,                │
    │      experience,           │
    │      deadline              │
    │    },                       │
    │    ...                      │
    │  ]                          │
    └──────────┬──────────────────┘
               │
    ┌──────────┴──────────┐
    │                     │
    ▼                     ▼
┌─────────────────┐  ┌──────────────────┐
│ extractJobs     │  │ renderJobList    │
│ FromHtml        │  │ Column           │
│                 │  │                  │
│ Input: HTML     │  │ Input: Jobs      │
│ ↓               │  │ ↓                │
│ Parse & Extract │  │ Generate HTML    │
│ ↓               │  │ ↓                │
│ Output: Jobs    │  │ Output: HTML     │
└────────┬────────┘  └──────────┬───────┘
         │                      │
         └──────────────────────┤
                                │
                                ▼
                    ┌───────────────────────┐
                    │  showDetailView()     │
                    │                       │
                    │  1. Hide grid         │
                    │  2. Show detail       │
                    │  3. Populate sidebar  │
                    │  4. Load job detail   │
                    │  5. Attach events     │
                    └───────────────────────┘
```

---

## State Transitions

```
┌──────────────────────────────────────────────────────────────┐
│                    STATE MACHINE                              │
└──────────────────────────────────────────────────────────────┘

                        PAGE_LOAD
                          │
                          ▼
            ┌─────────────────────────────┐
            │ currentFilteredJobs = []    │
            │ (empty state)               │
            └──────────┬──────────────────┘
                       │
                       ▼
            ┌──────────────────────────────────┐
            │ Page Renders Initial Jobs        │
            │ currentFilteredJobs = [12 jobs]  │
            │ STATE: READY                     │
            └──────────┬─────────────────────┘
                       │
            ┌──────────┴──────────┐
            │                     │
            ▼                     ▼
       SEARCH          FILTER/LOAD
         │                │
         ▼                ▼
    ┌──────────────────────────────────┐
    │ performSearch() or loadAllJobs() │
    │ API Call Triggered              │
    │ STATE: LOADING                  │
    └──────────┬─────────────────────┘
               │
               ▼
    ┌──────────────────────────────────┐
    │ API Response Received            │
    │ HTML Returned with Filtered Jobs │
    │ STATE: RECEIVED                  │
    └──────────┬─────────────────────┘
               │
               ▼
    ┌──────────────────────────────────┐
    │ Grid Updated                     │
    │ currentFiltered = extractJobs()  │
    │ STATE: UPDATED                   │
    └──────────┬─────────────────────┘
               │
               ▼
    ┌──────────────────────────────────┐
    │ User Ready for Detail View       │
    │ STATE: READY_FOR_DETAIL          │
    └──────────┬─────────────────────┘
               │
               ▼ (Click Job)
    ┌──────────────────────────────────┐
    │ showDetailView() Called          │
    │ STATE: SHOWING_DETAIL            │
    └──────────┬─────────────────────┘
               │
               ▼
    ┌──────────────────────────────────┐
    │ Sidebar Rendered from            │
    │ currentFilteredJobs              │
    │ STATE: DETAIL_COMPLETE           │
    └──────────┬─────────────────────┘
               │
        ┌──────┴──────┐
        │             │
        ▼             ▼
   [Back]         [Click Job]
     │               │
     └──────┬────────┘
            │
            ▼
    ┌──────────────────────────────┐
    │ Grid View                    │
    │ Ready for New Search/Filter  │
    │ STATE: READY                 │
    └──────────────────────────────┘
```

---

## Data Transformation

```
┌──────────────────────────────────────────────────────────────┐
│          DATA FLOW: HTML → JOBS → HTML                       │
└──────────────────────────────────────────────────────────────┘

STEP 1: API Response (HTML)
┌───────────────────────────────────────┐
│ <article class="job-card-grid"        │
│   data-job-id="123">                  │
│   <div class="job-card-title">        │
│     Senior React Developer            │
│   </div>                               │
│   <div class="company-name-small">    │
│     Tech Company                       │
│   </div>                               │
│   ... more job data ...               │
│ </article>                             │
└──────────────────┬────────────────────┘
                   │
         (extractJobsFromHtml)
                   │
                   ▼
STEP 2: Job Objects
┌───────────────────────────────────────┐
│ {                                     │
│   job_id: "123",                      │
│   title: "Senior React Developer",   │
│   company: "Tech Company",            │
│   salary: "20-30 VND",                │
│   province: "Hà Nội",                 │
│   level: "Senior",                    │
│   experience: "5+ years",             │
│   deadline: "31/12/2025"              │
│ }                                     │
│ ... more jobs ...                     │
└──────────────────┬────────────────────┘
                   │
         (renderJobListColumnFromJobs)
                   │
                   ▼
STEP 3: Job List HTML (for Sidebar)
┌────────────────────────────────────────┐
│ <article class="job-card"              │
│   data-job-id="123">                   │
│   <div class="job-card-header">        │
│     <div class="company-logo-small">   │
│       T                                 │
│     </div>                              │
│     <div class="job-card-info">        │
│       <h3>Senior React Developer</h3>  │
│       <div>Tech Company</div>           │
│       <span>20-30 VND</span>            │
│     </div>                              │
│   </div>                                │
│   ... more markup ...                   │
│ </article>                              │
│ ... more jobs ...                       │
└────────────────────────────────────────┘
         │
         │ (Insert into DOM)
         │
         ▼
STEP 4: Rendered Sidebar
┌─────────────────────────────┐
│  ✅ Sidebar with correct    │
│     filtered jobs           │
│                             │
│  □ Job 1 (filtered)        │
│  □ Job 2 (filtered)        │
│  □ Job 3 (filtered)        │
│  ✓ Job 4 (selected)        │
│  □ Job 5 (filtered)        │
└─────────────────────────────┘
```

---

## Integration Points

```
┌──────────────────────────────────────────────────────────────┐
│                  INTEGRATION DIAGRAM                          │
└──────────────────────────────────────────────────────────────┘

┌─────────────────────────────────┐
│ Existing Code                   │
│                                 │
│ • performSearch()               │
│ • loadAllJobs()                 │
│ • showDetailView()              │
│ • attachListCardEvents()        │
│ • loadJobDetail()               │
│ • DOMParser                     │
│ • fetch() API                   │
└────┬──────────────────────────┬─┘
     │                          │
     │ (Uses)                   │ (Calls)
     │                          │
     ▼                          ▼
┌─────────────────────────────────────────┐
│  NEW CODE                               │
│                                         │
│  • currentFilteredJobs (variable)       │
│  • extractJobsFromHtml() (function)     │
│  • renderJobListColumnFromJobs()        │
│    (function)                           │
│  • Initialization code                  │
└─────────────────────────────────────────┘
     │                          │
     │ (Updates)                │ (Renders)
     │                          │
     ▼                          ▼
┌─────────────────────────────────────────┐
│  DOM ELEMENTS                           │
│                                         │
│  • gridView (read)                      │
│  • jobListColumn (write)                │
│  • detailView (read/write)              │
│  • .job-card (search/populate)          │
└─────────────────────────────────────────┘
```

---

## Summary

The filtered jobs sidebar fix works by:

1. **Capturing** filtered results in `currentFilteredJobs`
2. **Extracting** job data from API HTML responses
3. **Rendering** job HTML from the extracted data
4. **Populating** the sidebar with the correct filtered jobs
5. **Maintaining** state across search/filter and detail view transitions

This ensures the sidebar **always displays the correct filtered results** that match the user's search or filter criteria.

---

**Architecture Design**: Clean, modular, maintainable  
**Integration**: Seamless with existing code  
**Performance**: Minimal overhead  
**Reliability**: Robust error handling  

✅ **Production Ready**
