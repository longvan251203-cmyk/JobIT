# 🔍 PHÂN TÍCH CHI TIẾT: Logic Thuật Toán Gợi Ý Ứng Viên

**Ngày Phân Tích**: 16/12/2025  
**Dữ Liệu từ**: `JobRecommendationService.php` + `JobRecommendation.php` Model

---

## 📊 CÂU HỎI CHÍNH

### ❓ Hiện tại cách tìm ứng viên gợi ý như thế nào?

**Trả lời**: Hệ thống sử dụng **phương pháp Two-Way Matching**:

```
EMPLOYER SIDE (Tìm ứng viên gợi ý):
─────────────────────────────────────
Method: getRecommendedApplicantsForCompany($companyId, $limit = 12)
├─ BƯỚC 1: Lấy tất cả ACTIVE JOB của công ty
├─ BƯỚC 2: Lấy tất cả ứng viên có đủ thông tin
├─ BƯỚC 3: Tính điểm cho MỖI ứng viên vs MỖI job
│  └─ Chỉ lưu job có score >= 60%
├─ BƯỚC 4: Sắp xếp theo:
│  ├─ Số lượng job phù hợp (DESC)
│  └─ Best score (DESC)
└─ BƯỚC 5: Trả lại top 12 ứng viên

APPLICANT SIDE (Xem việc làm gợi ý):
────────────────────────────────────────
Method: getRecommendationsForApplicant($applicant, $limit = 10)
├─ Lấy JobRecommendation records
├─ Sắp xếp theo score DESC
└─ Trả lại top 10 job
```

---

### ❓ Có lưu lại được những job nào là phù hợp nhất với ứng viên đó chưa?

**Trả lời**: **CÓ, nhưng có vấn đề**

#### ✅ CÓ LƯU TRỮ:

**1. Model JobRecommendation** - Lưu mối quan hệ ứng viên-job:
```php
// Table job_recommendations
├─ applicant_id       (FK → Applicant)
├─ job_id             (FK → JobPost)
├─ score              (0-100 decimal)
├─ match_details      (JSON - breakdown điểm)
├─ is_viewed          (boolean)
├─ is_applied         (boolean)
└─ created_at, updated_at
```

**2. Trong calculateRecommendedApplicantsV2()** - Tính và lưu:
```php
$applicantJobMatches[] = [
    'job' => $job,
    'score' => $score,
    'match_details' => $matchData['breakdown']
];
// NHƯNG CHỈ TÍNH NHẤT THỜI, KHÔNG LƯU VÀO DATABASE
```

---

## ⚠️ VẤN ĐỀ PHÁT HIỆN

### Vấn đề 1: ❌ Không lưu chi tiết job phù hợp

**Hiện tại**:
```php
// EmployerCandidatesController@index
$recommendedApplicants = $this->recommendationService
    ->getRecommendedApplicantsForCompany($company->companies_id, 12);

// Trả về:
[
    [
        'applicant' => {...},
        'best_score' => 85,           ← Chỉ best score
        'best_job' => {...},          ← Chỉ best job
        'matched_jobs' => [...],      ← CÓ tất cả job phù hợp
        'total_matches' => 5
    ]
]
```

**Vấn đề**:
- `matched_jobs` được tính **nhất thời trong hàm** (tính rồi xóa)
- **Không lưu vào database** để dùng sau này
- Khi modal "Mời" mở → Phải **tính lại từ đầu**
- Làm **chậm** và **không nhất quán**

---

### Vấn đề 2: ❌ Modal "Mời" không biết job nào phù hợp

**Hiện tại**:
```php
// candidates.blade.php - inviteCandidate()
fetch('/employer/jobs/active-unfilled')  // ← LẤY TẤT CẢ JOB
    .then(data => {
        // Hiển thị 20 job, không biết cái nào phù hợp
    });
```

**Kết quả**: 
- Modal hiển thị **TẤT CẢ job** (20 cái)
- Không biết cái nào phù hợp với ứng viên này
- NTD phải tự nhận diện

---

### Vấn đề 3: ⚠️ Tính toán lặp lại nhiều lần

```
Timeline:
─────────
1. NTD xem trang candidates
   ↓
2. Backend: calculateRecommendedApplicantsV2()
   ├─ Tính điểm cho 500 ứng viên × N job = XYZ phép tính
   └─ Kết quả chỉ dùng 1 lần (hiển thị danh sách)

3. NTD bấy "Mời" ứng viên
   ↓
4. Modal mở, gọi getActiveUnfilled()
   └─ Không lấy job phù hợp, lấy tất cả
   
5. NTD khác bấy "Mời" ứng viên khác
   ↓
6. Backend: calculateRecommendedApplicantsV2() LẠI
   ├─ Tính từ đầu 500 ứng viên × N job
   └─ Kết quả lại chỉ dùng 1 lần
```

---

## 🔄 LOGIC HIỆN TẠI - CHI TIẾT

### Flow: NTD Xem Ứng Viên Gợi Ý

```
┌─────────────────────────────────────────────┐
│  /employer/candidates                       │
│  EmployerCandidatesController::index()      │
└──────────────┬──────────────────────────────┘
               │
               ↓
┌─────────────────────────────────────────────┐
│  $recommendedApplicants =                   │
│  $this->recommendationService               │
│    ->getRecommendedApplicantsForCompany(    │
│        $company->id, 12                     │
│    )                                        │
└──────────────┬──────────────────────────────┘
               │
               ↓
┌─────────────────────────────────────────────┐
│  JobRecommendationService::                 │
│  getRecommendedApplicantsForCompany()       │
│                                             │
│  1. Cache.remember(key, 1800)               │
│  2. Gọi calculateRecommendedApplicantsV2() │
│  3. Lưu kết quả trong memory (1 lần dùng)  │
│  4. Trả về array (không lưu DB)            │
└──────────────┬──────────────────────────────┘
               │
               ↓
┌─────────────────────────────────────────────┐
│  calculateRecommendedApplicantsV2()         │
│                                             │
│  Đầu vào:                                   │
│  ├─ 500 ứng viên (Applicant records)       │
│  └─ N active jobs (JobPost records)         │
│                                             │
│  Xử lý:                                     │
│  ├─ Loop 500 ứng viên:                     │
│  │  └─ Loop N job:                         │
│  │     ├─ calculateMatchScore()            │
│  │     ├─ score >= 60%?                    │
│  │     └─ Lưu vào $matched_jobs[]          │
│  │        (CHỈ TRONG MEMORY)               │
│  └─ Sort & return top 12                   │
│                                             │
│  Đầu ra:                                    │
│  [                                          │
│    {                                        │
│      'applicant': {...},                   │
│      'best_score': 85,                     │
│      'best_job': {...},                    │
│      'matched_jobs': [                     │  ← CÓ, nhưng CHỈ TẠNH THỜI
│        {job, score, match_details}         │
│      ]                                      │
│    }                                        │
│  ]                                          │
└──────────────┬──────────────────────────────┘
               │
               ↓
┌─────────────────────────────────────────────┐
│  Hiển thị trên View                         │
│                                             │
│  🎯 Ứng viên được đề xuất                   │
│  ├─ Nguyễn Văn A (best_score: 85%)        │
│  ├─ Trần Thị B (best_score: 80%)          │
│  └─ Phạm Minh C (best_score: 78%)         │
│                                             │
│  Bấy [Mời]                                 │
└──────────────┬──────────────────────────────┘
               │
               ↓ NTD bấy [Mời]
               │
               ↓
┌─────────────────────────────────────────────┐
│  Modal Mời Ứng Viên                         │
│                                             │
│  fetch('/employer/jobs/active-unfilled')  │
│  ← LẤY TẤT CẢ JOB (CHỈ ENDPOINT NÀY)      │
│                                             │
│  Vấn đề: matched_jobs từ bước trước đã     │
│  mất (nó là array trong RAM của 1 request) │
│  → Không biết job nào phù hợp             │
│  → Hiển thị 20 job đồng đều                │
└─────────────────────────────────────────────┘
```

---

## 📋 DATA FLOW - CHI TIẾT

### Dữ Liệu Tính Toán

```
Ứng viên: Nguyễn Văn A
──────────────────────

Kỳ tính:
├─ Vị trí ứng tuyển: Senior Developer
├─ Địa chỉ: Hồ Chí Minh
├─ Kỹ năng: PHP (5 năm), Laravel (4 năm), MySQL (5 năm)
├─ Kinh nghiệm: 5 năm
└─ Lương mong muốn: 15-20 triệu

Công ty có 5 active job:
────────────────────────
1. PHP Developer (HCMC) → Score: 95%
   └─ Matched: ✓ (lưu vào matched_jobs[])
2. Java Developer (HCMC) → Score: 45%
   └─ Matched: ✗ (loại, < 60%)
3. Senior PHP (HCMC) → Score: 92%
   └─ Matched: ✓ (lưu vào matched_jobs[])
4. Frontend Dev (Hà Nội) → Score: 35%
   └─ Matched: ✗ (loại, < 60%)
5. Backend Dev (HCMC) → Score: 80%
   └─ Matched: ✓ (lưu vào matched_jobs[])

Kết quả calculateRecommendedApplicantsV2():
─────────────────────────────────────────────
$applicantJobMatches = [
    {job: PHP Dev, score: 95, match_details: {...}},
    {job: Senior PHP, score: 92, match_details: {...}},
    {job: Backend Dev, score: 80, match_details: {...}}
]

Nhưng: ⚠️ ĐẶT ĐỨC SAU HÀM KẾT THÚC, MẢNG NÀY BỊ MẤT!
Không lưu vào database, không cache, GC sẽ xóa nó.
```

---

## 💾 DATABASE TABLE

### JobRecommendation Model

```sql
CREATE TABLE job_recommendations (
    id BIGINT PRIMARY KEY,
    applicant_id INT,                -- FK: applicants
    job_id INT,                      -- FK: job_posts
    score DECIMAL(5,2),              -- 0-100
    match_details JSON,              -- Breakdown:
                                     -- {
                                     --   location: {score, reason},
                                     --   skills: {score, reason},
                                     --   experience: {score, reason},
                                     --   ...
                                     -- }
    is_viewed BOOLEAN DEFAULT FALSE,
    is_applied BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

Index: (applicant_id, job_id) UNIQUE
Index: (applicant_id, score DESC)
Index: (job_id, score DESC)
```

**Trạng thái**: ✅ Có table, ✅ Có cấu trúc tốt

---

## 🔧 CÁCH SỬ DỤNG HIỆN TẠI

### 1. Ứng Viên Xem Gợi Ý Việc Làm

```php
// JobRecommendationController::index()
$recommendedJobs = JobRecommendation::where('applicant_id', $applicant->id)
    ->with(['job.company', 'job.hashtags'])
    ->orderByDesc('score')
    ->limit(10)
    ->get();

// ✅ HOẠT ĐỘNG TỐT - Lấy từ database
```

---

### 2. Nhà Tuyển Dụng Xem Ứng Viên Gợi Ý

```php
// EmployerCandidatesController::index()
$recommendedApplicants = $this->recommendationService
    ->getRecommendedApplicantsForCompany($companyId, 12);

// ❌ VẤNĐỀ:
// - Tính nhất thời (calculateRecommendedApplicantsV2)
// - Không lưu vào database
// - Không lưu matched_jobs chi tiết
// - Khi modal mở, phải gọi API khác để lấy all jobs
```

---

## 🎯 PHƯƠNG ÁN CẢI THIỆN

### Phương Án A: Lưu matched_jobs vào database

```php
// JobRecommendationService::generateRecommendationsForApplicant()
// Sau khi calculateMatchScore():

if ($score >= 60) {
    JobRecommendation::create([
        'applicant_id' => $applicant->id,
        'job_id' => $job->id,
        'score' => $score,
        'match_details' => $matchData['breakdown']
    ]);
}

// ✅ LỢI ÍCH:
// - Lưu vào DB → không mất khi request kết thúc
// - Modal "Mời" có thể lấy:
//   SELECT * FROM job_recommendations
//   WHERE applicant_id = ? AND score >= 60
//   ORDER BY score DESC
```

### Phương Án B: Thêm table applicant_matched_jobs

```sql
CREATE TABLE applicant_matched_jobs (
    id BIGINT PRIMARY KEY,
    applicant_id INT,      -- ứng viên
    job_ids JSON,          -- [1, 3, 5, ...] (các job phù hợp)
    best_job_id INT,       -- job phù hợp nhất
    best_score DECIMAL,    -- điểm cao nhất
    total_matches INT,     -- số job phù hợp
    company_id INT,        -- liên quan đến công ty nào
    is_valid BOOLEAN,      -- có còn valid không
    calculated_at TIMESTAMP
);

// Mục đích: Cache nhanh danh sách job phù hợp cho 1 ứng viên
// Dùng khi NTD bấy "Mời" → không phải tính lại
```

---

## 📊 SO SÁNH HIỆN TẠI vs LÝ TƯỞNG

### ❌ HIỆN TẠI

```
1. NTD xem candidates
   ├─ Backend tính: 500 ứng viên × 5 job = 2500 phép tính
   └─ Kết quả: [ứng viên gợi ý] (matched_jobs trong RAM)

2. NTD bấy "Mời"
   ├─ Frontend: fetch /employer/jobs/active-unfilled
   └─ Kết quả: [TẤT CẢ 20 job] (không biết phù hợp?)

3. NTD khác bấy "Mời"
   └─ Backend lại tính: 500 ứng viên × 5 job = 2500 phép tính (LẶP)
```

### ✅ LÝ TƯỞNG

```
1. NTD xem candidates
   ├─ Backend tính: 500 ứng viên × 5 job = 2500 phép tính
   ├─ Lưu vào JobRecommendation table
   └─ Kết quả: [ứng viên gợi ý] (matched_jobs lưu DB)

2. NTD bấy "Mời"
   ├─ Frontend: fetch /employer/candidates/{id}/matched-jobs
   ├─ Backend: SELECT FROM job_recommendations WHERE ...
   └─ Kết quả: [CHỈ 3-5 job phù hợp] + match_score

3. NTD khác bấy "Mời"
   ├─ Không cần tính lại
   ├─ Backend: SELECT FROM cached data
   └─ Nhanh, hiệu quả
```

---

## 🔑 KEY FINDINGS

| Câu hỏi | Trả lời | Chi tiết |
|--------|--------|---------|
| **Cách tìm ứng viên gợi ý?** | Two-way matching | `calculateRecommendedApplicantsV2()` |
| **Có lưu job phù hợp?** | Có nhưng tạm thời | Chỉ lưu trong RAM của 1 request |
| **Có table JobRecommendation?** | Có | Nhưng chỉ dùng cho ứng viên xem |
| **Modal "Mời" biết job phù hợp?** | Không | Lấy tất cả job, không lọc |
| **Tính toán có lặp?** | Có | Mỗi lần mở candidates lại tính |

---

## 📝 KẾT LUẬN

**Hệ thống gợi ý hiện tại**:
- ✅ Logic tính toán: **Tốt** (score, breakdown chi tiết)
- ✅ Lưu trữ cho ứng viên: **Tốt** (dùng JobRecommendation)
- ❌ Lưu trữ cho NTD: **Tồi** (chỉ RAM, mất sau request)
- ❌ Modal "Mời": **Sai** (hiển thị tất cả job, không biết phù hợp)

**Cần cải thiện**:
1. Lưu `matched_jobs` vào database (JobRecommendation)
2. API riêng cho modal "Mời" → lấy job phù hợp
3. Hiển thị match_score + match_details trong modal

---

**Generated**: 16/12/2025
