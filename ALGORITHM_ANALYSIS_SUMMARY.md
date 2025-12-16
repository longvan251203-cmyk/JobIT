# 🎯 TÓM TẮT: Logic Thuật Toán Gợi Ý Ứng Viên

## 📊 CÂU HỎI 1: Hiện tại cách tìm ứng viên gợi ý như thế nào?

### 📍 Phương Pháp: Two-Way Matching

```
┌─────────────────────────────────────────┐
│ getRecommendedApplicantsForCompany()   │
├─────────────────────────────────────────┤
│ 1. Lấy tất cả ACTIVE JOB của công ty   │
│ 2. Lấy tất cả ứng viên (500 người)     │
│ 3. Tính điểm cho từng ứng viên:        │
│    ├─ vs Job 1 → Score 95%            │
│    ├─ vs Job 2 → Score 45% (loại)     │
│    ├─ vs Job 3 → Score 92%            │
│    └─ ...                              │
│ 4. Chỉ giữ job có score >= 60%        │
│ 5. Sắp xếp:                           │
│    ├─ Theo số lượng job phù hợp (DESC) │
│    └─ Theo best score (DESC)           │
│ 6. Trả lại top 12 ứng viên             │
└─────────────────────────────────────────┘
```

### 🧮 Công Thức Tính Score

```
TỔNG SCORE = (Loại 1 × 35%) + (Loại 2 × 30%) + ... + (Loại 6 × 3%)

Thành phần:
├─ Location:    35% (Địa điểm - ƯU TIÊN NHẤT)
├─ Skills:      30% (Kỹ năng)
├─ Position:    20% (Vị trí ứng tuyển)
├─ Experience:   8% (Kinh nghiệm)
├─ Salary:       4% (Mức lương)
└─ Language:     3% (Ngoại ngữ)

Mỗi thành phần:
├─ 0-100 điểm (dựa trên match)
└─ Lý do chi tiết (reason text)
```

### 📍 Quá Trình Chi Tiết

```
Input:
├─ Company ID: 1
└─ Limit: 12 ứng viên

Processing:
Step 1: Active Jobs Query
├─ WHERE companies_id = 1
├─ WHERE status = 'active'
├─ WHERE deadline >= NOW()
└─ RESULT: 5 jobs

Step 2: Eligible Applicants Query
├─ WHERE vitriungtuyen IS NOT NULL (có vị trí ứng tuyển)
├─ WHERE diachi_uv IS NOT NULL (có địa chỉ)
├─ WHERE HAS kynang (có kỹ năng)
├─ LIMIT 500
└─ RESULT: 450 ứng viên

Step 3: Calculate Scores
FOR EACH applicant (450):
  applicantJobMatches = []
  FOR EACH job (5):
    score = calculateMatchScore(applicant, job)
    IF score >= 60%:
      applicantJobMatches.add({job, score, details})
  
  IF applicantJobMatches.length > 0:
    recommendations.add({
      applicant,
      best_score: MAX(scores),
      matched_jobs: applicantJobMatches,
      total_matches: length
    })

Step 4: Sort Results
SORT BY:
  1. total_matches DESC
  2. best_score DESC

Step 5: Return Top
SLICE(0, 12)

Output:
[
  {
    applicant: {id, name, skills, ...},
    best_score: 95,
    best_job: {...},
    matched_jobs: [
      {job: PHP Dev, score: 95},
      {job: Senior PHP, score: 92},
      {job: Backend Dev, score: 80}
    ],
    total_matches: 3
  },
  ...
]
```

---

## 💾 CÂU HỎI 2: Có lưu lại được những job nào là phù hợp nhất với ứng viên đó chưa?

### ✅ CÓ LƯU - Nhưng có vấn đề

```
Table: job_recommendations
────────────────────────────
┌─────────────────────────────────────┐
│ applicant_id: 123                  │
├─────────────────────────────────────┤
│ job_id: 1 (PHP Dev)                │
│ score: 95.00                       │
│ match_details: {                   │
│   location: {score: 100, ...},     │
│   skills: {score: 95, ...},        │
│   position: {score: 100, ...},     │
│   experience: {score: 90, ...},    │
│   salary: {score: 100, ...},       │
│   language: {score: 80, ...}       │
│ }                                  │
│ is_viewed: FALSE                   │
│ is_applied: FALSE                  │
└─────────────────────────────────────┘
```

### ❌ VẤN ĐỀ: Matched_Jobs không lưu

```
TRONG calculateRecommendedApplicantsV2():
────────────────────────────────────────

// Tính toán matched_jobs
$applicantJobMatches = [
  {job: PHP Dev, score: 95},
  {job: Senior PHP, score: 92},
  {job: Backend Dev, score: 80}
];

// LƯU VÀO: RAM (Memory) của request này
// KHI: Request kết thúc → GC xóa, mất hết!

// KHÔNG LƯU VÀO:
// ❌ JobRecommendation table
// ❌ Cache (Redis)
// ❌ File
// ❌ Bất kỳ nơi lưu trữ nào
```

### 🔄 Kết Quả

```
Timeline:
────────
1. NTD mở /employer/candidates
   ├─ Backend tính: matched_jobs cho mỗi ứng viên
   ├─ Hiển thị: 12 ứng viên + best_score (95%, 92%, ...)
   └─ matched_jobs lưu trong RAM

2. NTD bấy "Mời" ứng viên
   ├─ Frontend: fetch /employer/jobs/active-unfilled
   ├─ Backend: Lấy TẤT CẢ 20 job
   └─ VẤNĐỀ: matched_jobs từ bước 1 đã mất! ← RAM bị clear

3. Result:
   └─ Modal hiển thị 20 job (tất cả)
   └─ Không biết cái nào phù hợp
   └─ NTD phải tự nhận diện
```

---

## 📊 SO SÁNH

### ❌ HIỆN TẠI

```
Ứng viên: Nguyễn Văn A
Phù hợp với: 3 job (PHP Dev, Senior PHP, Backend Dev)

Khi xem danh sách ứng viên gợi ý:
├─ ✅ Hiển thị: Nguyễn Văn A
├─ ✅ Hiển thị: Best score (95%)
└─ ✅ Hiển thị: Best job (PHP Dev)

Khi bấy "Mời":
├─ ✅ Hiển thị: 20 job (tất cả công ty)
├─ ❌ Không hiển thị: Cái nào phù hợp
├─ ❌ Không hiển thị: Match score
├─ ❌ Không hiển thị: Lý do phù hợp
└─ ❌ NTD phải tự tìm

Vấnđề:
├─ Phải tính lại mỗi lần request
├─ Không biết matched_jobs là gì
└─ Chuỗi phải lấy tất cả job rồi tìm phù hợp
```

### ✅ LÝ TƯỞNG

```
Ứng viên: Nguyễn Văn A
Phù hợp với: 3 job (PHP Dev, Senior PHP, Backend Dev)

Khi xem danh sách ứng viên gợi ý:
├─ ✅ Hiển thị: Nguyễn Văn A
├─ ✅ Hiển thị: Best score (95%)
└─ ✅ Hiển thị: Best job (PHP Dev)

Khi bấy "Mời":
├─ ✅ Hiển thị: 3 job (chỉ phù hợp)
├─ ✅ Hiển thị: Match score (95%, 92%, 80%)
├─ ✅ Hiển thị: Lý do phù hợp
│  ├─ ✓ Kỹ năng match 95%
│  ├─ ✓ Vị trí phù hợp
│  └─ ✓ Mức lương phù hợp
└─ ✅ NTD dễ chọn

Lợi ích:
├─ Nhanh (lấy từ DB, không tính lại)
├─ Chính xác (dùng dữ liệu đã lưu)
└─ Tốt UX (rõ ràng, dễ hiểu)
```

---

## 🔧 CÓ THỂ LÀM GÌ?

### Phương Án 1: Lưu matched_jobs vào JobRecommendation

```php
// Sau khi calculateMatchScore()
if ($score >= 60) {
    // Lưu TỪNG job phù hợp
    JobRecommendation::create([
        'applicant_id' => $applicant->id,
        'job_id' => $job->id,
        'score' => $score,
        'match_details' => $matchData['breakdown']
    ]);
}

// Khi NTD bấy "Mời":
$matchedJobs = JobRecommendation::where('applicant_id', $id)
    ->where('score', '>=', 60)
    ->orderByDesc('score')
    ->get();
```

**Ưu điểm**:
- ✅ Lưu vào DB
- ✅ Có thể lấy lại bất kỳ lúc nào
- ✅ Nhanh (không tính lại)
- ✅ Dễ filter/sort

**Nhược điểm**:
- ❌ Database lớn nếu 500 ứng viên × 5 job = 2500 records
- ❌ Cần cập nhật khi job/profile thay đổi

---

### Phương Án 2: Thêm table applicant_matched_jobs_cache

```sql
CREATE TABLE applicant_matched_jobs_cache (
    id,
    applicant_id,
    matched_job_ids,        -- JSON: [1, 3, 5]
    best_job_id,            -- 1
    best_score,             -- 95.00
    total_matches,          -- 3
    company_id,
    cached_at,
    expires_at
);
```

**Ưu điểm**:
- ✅ Nhanh (1 SELECT)
- ✅ Tiết kiệm space
- ✅ Dễ cache/invalidate

**Nhược điểm**:
- ❌ Cần maintain thêm 1 table
- ❌ Phức tạp logic cập nhật

---

### Phương Án 3: Dùng Redis Cache

```php
// Sau tính xong matched_jobs
Cache::put(
    "applicant_{$id}_matched_jobs",
    $matchedJobs,
    now()->addHours(24)  // Cache 24h
);

// Khi NTD bấy "Mời":
$matchedJobs = Cache::get("applicant_{$id}_matched_jobs");
```

**Ưu điểm**:
- ✅ Nhanh (Redis)
- ✅ TTL tự động
- ✅ Không cần DB changes

**Nhược điểm**:
- ❌ Cần Redis
- ❌ Mất khi server restart

---

## 🎯 KHUYẾN NGHỊ

### 🏆 Giải Pháp Tốt Nhất: **Kết Hợp**

```
1. Vẫn dùng JobRecommendation (ứng viên xem gợi ý)
   
2. Thêm logic lưu matched_jobs khi tính:
   FOR job IN matched_jobs:
       JobRecommendation::create({applicant, job, score})
   
3. API Modal "Mời":
   SELECT FROM job_recommendations 
   WHERE applicant_id = ? AND score >= 60
   ORDER BY score DESC
   
4. Hiển thị match_score + match_details trong modal
```

**Kết quả**:
- ✅ Lưu được matched_jobs
- ✅ Modal "Mời" chỉ hiển thị job phù hợp
- ✅ Nhanh (lấy từ DB)
- ✅ Dễ bảo trì (1 table)

---

## 📋 SUMMARY

| Vấn đề | Hiện Tạo | Lý Tưởng |
|--------|----------|---------|
| Tìm ứng viên gợi ý | ✅ Tốt (Two-way matching) | ✅ Tốt |
| Lưu matched_jobs | ⚠️ RAM (mất sau request) | ✅ Database |
| Modal "Mời" hiển thị | ❌ Tất cả 20 job | ✅ Chỉ 3-5 job phù hợp |
| Hiển thị match_score | ❌ Chỉ best_score | ✅ Từng job |
| Performance | ⚠️ Tính lại mỗi lần | ✅ Dùng cache |
| UX | ❌ Khó chọn | ✅ Dễ chọn |

---

**Generated**: 16/12/2025
