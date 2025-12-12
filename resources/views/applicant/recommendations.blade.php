<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gợi ý việc làm phù hợp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- ✅ Toast Notification Styles -->
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .main-header {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 30px;
            padding: 2.5rem;
            margin: 2rem 0;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border-left: 4px solid;
            transition: all 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .stat-card.purple {
            border-color: #667eea;
        }

        .stat-card.green {
            border-color: #38ef7d;
        }

        .stat-card.blue {
            border-color: #4facfe;
        }

        .stat-card.orange {
            border-color: #fa709a;
        }

        /* JOB CARD - IMPROVED */
        .job-card {
            background: white;
            border-radius: 25px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            border-left: 5px solid;
        }

        .job-card.high-match {
            border-color: #38ef7d;
        }

        .job-card.medium-match {
            border-color: #667eea;
        }

        .job-card.low-match {
            border-color: #fa709a;
        }

        .job-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .job-header {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .company-logo {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: 900;
            flex-shrink: 0;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .job-info {
            flex: 1;
        }

        .job-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .company-name {
            color: #666;
            font-size: 1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .match-score {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem;
            border-radius: 15px;
            text-align: center;
            min-width: 100px;
        }

        .job-card.high-match .match-score {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .match-score .score {
            font-size: 2.5rem;
            font-weight: 900;
            line-height: 1;
        }

        .match-score .label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 0.3rem;
        }

        .job-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.8rem;
            margin-bottom: 1.5rem;
        }

        .job-tag {
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .job-tag.location {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(102, 126, 234, 0.2) 100%);
            color: #667eea;
        }

        .job-tag.salary {
            background: linear-gradient(135deg, rgba(17, 153, 142, 0.1) 0%, rgba(56, 239, 125, 0.2) 100%);
            color: #11998e;
        }

        .job-tag.level {
            background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(0, 242, 254, 0.2) 100%);
            color: #4facfe;
        }

        .job-tag.new {
            background: linear-gradient(135deg, rgba(250, 112, 154, 0.1) 0%, rgba(254, 225, 64, 0.2) 100%);
            color: #fa709a;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        /* MATCH ANALYSIS - IMPROVED */
        .match-analysis {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.03) 0%, rgba(118, 75, 162, 0.03) 100%);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 1.5rem;
        }

        .analysis-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: #333;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .analysis-title i {
            font-size: 1.5rem;
            color: #667eea;
        }

        .criteria-grid {
            display: grid;
            gap: 1.5rem;
        }

        .criteria-item {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
        }

        .criteria-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .criteria-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .criteria-name {
            font-size: 0.95rem;
            font-weight: 700;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .criteria-name i {
            font-size: 1.2rem;
        }

        .criteria-score {
            font-size: 1.8rem;
            font-weight: 900;
        }

        .criteria-score.high {
            color: #38ef7d;
        }

        .criteria-score.medium {
            color: #667eea;
        }

        .criteria-score.low {
            color: #fa709a;
        }

        .progress-bar-wrapper {
            height: 10px;
            background: #f0f0f0;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 0.8rem;
        }

        .progress-fill {
            height: 100%;
            border-radius: 10px;
            transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .progress-fill.high {
            background: linear-gradient(90deg, #11998e 0%, #38ef7d 100%);
        }

        .progress-fill.medium {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }

        .progress-fill.low {
            background: linear-gradient(90deg, #fa709a 0%, #fee140 100%);
        }

        .criteria-reason {
            font-size: 0.9rem;
            color: #666;
            line-height: 1.6;
            padding: 0.8rem;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 10px;
            border-left: 3px solid #667eea;
        }

        /* SKILLS DETAILS */
        .skills-details {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e0e0e0;
        }

        .skills-section {
            margin-bottom: 0.8rem;
        }

        .skills-section-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: #666;
            margin-bottom: 0.5rem;
        }

        .skill-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .skill-tag {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .skill-tag.matched {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .skill-tag.missing {
            background: #ffebee;
            color: #c62828;
        }

        /* ACTION BUTTONS */
        .job-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-action {
            flex: 1;
            min-width: 200px;
            padding: 1rem 2rem;
            border-radius: 50px;
            border: none;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.8rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: white;
            color: #667eea;
            border: 3px solid #667eea;
        }

        .btn-secondary:hover {
            background: #667eea;
            color: white;
        }

        .btn-icon {
            width: 50px;
            height: 50px;
            padding: 0;
            min-width: unset;
            flex: unset;
            background: white;
            color: #666;
            border: 2px solid #ddd;
        }

        .btn-icon:hover {
            border-color: #ff6b6b;
            color: #ff6b6b;
            background: #fff5f5;
        }

        .btn-icon.saved {
            border-color: #ff6b6b;
            color: #ff6b6b;
            background: #fff5f5;
        }

        .refresh-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            border: none;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
        }

        .refresh-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 768px) {
            .job-header {
                flex-direction: column;
            }

            .btn-action {
                min-width: 100%;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    {{-- Thêm vào đầu file recommendations.blade.php --}}

    <!-- Header -->
    <header class="main-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">JobMatch</div>
                <div class="d-flex gap-3 align-items-center">
                    <span class="text-muted">Xin chào, <strong>{{ Auth::user()->name }}</strong></span>
                    <a href="{{ route('home') }}" class="btn btn-outline-primary">
                        <i class="bi bi-house-door"></i> Trang chủ
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container my-5">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="mb-3" style="font-size: 2.5rem; font-weight: 900; color: #333;">
                        <i class="bi bi-stars text-primary"></i>
                        Gợi ý việc làm phù hợp với bạn
                    </h1>
                    <p class="text-muted" style="font-size: 1.1rem;">
                        Được cá nhân hóa dựa trên kỹ năng, kinh nghiệm, địa điểm và sở thích của bạn
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <button class="refresh-btn" onclick="refreshRecommendations()">
                        <i class="bi bi-arrow-clockwise"></i>
                        <span>Làm mới danh sách</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card purple">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div style="font-size: 2.5rem; font-weight: 900; color: #667eea;">
                            {{ $stats['total'] }}
                        </div>
                        <div style="font-size: 0.9rem; color: #666; font-weight: 600;">
                            Việc làm phù hợp
                        </div>
                    </div>
                    <i class="bi bi-briefcase-fill" style="font-size: 3rem; color: rgba(102, 126, 234, 0.2);"></i>
                </div>
            </div>

            <div class="stat-card green">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div style="font-size: 2.5rem; font-weight: 900; color: #38ef7d;">
                            {{ $stats['high_match'] }}
                        </div>
                        <div style="font-size: 0.9rem; color: #666; font-weight: 600;">
                            Phù hợp cao (≥80%)
                        </div>
                    </div>
                    <i class="bi bi-star-fill" style="font-size: 3rem; color: rgba(56, 239, 125, 0.2);"></i>
                </div>
            </div>

            <div class="stat-card blue">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div style="font-size: 2.5rem; font-weight: 900; color: #4facfe;">
                            {{ $stats['not_viewed'] }}
                        </div>
                        <div style="font-size: 0.9rem; color: #666; font-weight: 600;">
                            Chưa xem
                        </div>
                    </div>
                    <i class="bi bi-eye-slash-fill" style="font-size: 3rem; color: rgba(79, 172, 254, 0.2);"></i>
                </div>
            </div>

            <div class="stat-card orange">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div style="font-size: 2.5rem; font-weight: 900; color: #fa709a;">
                            {{ $stats['not_applied'] }}
                        </div>
                        <div style="font-size: 0.9rem; color: #666; font-weight: 600;">
                            Chưa ứng tuyển
                        </div>
                    </div>
                    <i class="bi bi-send-fill" style="font-size: 3rem; color: rgba(250, 112, 154, 0.2);"></i>
                </div>
            </div>
        </div>

        <!-- Job Listings -->
        <div class="job-listings mt-4">
            @forelse($recommendations as $rec)
            @php
            $job = $rec->job;
            $details = $rec->match_details_parsed;
            $matchClass = $rec->score >= 80 ? 'high-match' : ($rec->score >= 60 ? 'medium-match' : 'low-match');

            // Helper function to get score level
            $getScoreLevel = function($score) {
            if ($score >= 80) return 'high';
            if ($score >= 60) return 'medium';
            return 'low';
            };

            // ✅ Ẩn job đã đủ số lượng nhận
            $selectedCount = $job->selected_count ?? 0;
            $recruitmentCount = $job->recruitment_count ?? 0;
            if ($recruitmentCount > 0 && $selectedCount >= $recruitmentCount) {
            continue; // Bỏ qua job này
            }
            @endphp

            <div class="job-card {{ $matchClass }}">
                <!-- Job Header -->
                <div class="job-header">
                    @if($job->company && $job->company->logo)
                    <img src="{{ asset('assets/img/' . $job->company->logo) }}" alt="Company Logo" class="company-logo" style="width: 80px; height: 80px; object-fit: cover;" />
                    @else
                    <div class="company-logo">
                        {{ strtoupper(substr($job->company->ten_cty ?? 'C', 0, 1)) }}
                    </div>
                    @endif
                    <div class="job-info">
                        <h3 class="job-title">{{ $job->title }}</h3>
                        <div class="company-name">
                            <i class="bi bi-building"></i>
                            {{ $job->company->tencty ?? 'Công ty' }}
                        </div>
                    </div>
                    <div class="match-score">
                        <span class="score">{{ number_format($rec->score, 0) }}%</span>
                        <span class="label">Phù hợp</span>
                    </div>
                </div>

                <!-- Job Tags -->
                <div class="job-tags">
                    <span class="job-tag location">
                        <i class="bi bi-geo-alt-fill"></i>
                        {{ $job->province }}
                    </span>
                    @if($job->salary_type === 'negotiable')
                    <span class="job-tag salary">
                        <i class="bi bi-cash-stack"></i>
                        Thỏa thuận
                    </span>
                    @else
                    <span class="job-tag salary">
                        <i class="bi bi-cash-stack"></i>
                        {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }} VNĐ
                    </span>
                    @endif
                    <span class="job-tag level">
                        <i class="bi bi-briefcase-fill"></i>
                        {{ $job->experience }}
                    </span>
                    @if(\Carbon\Carbon::parse($job->created_at)->diffInDays(now()) < 7)
                        <span class="job-tag new">
                        <i class="bi bi-star-fill"></i>
                        Mới
                        </span>
                        @endif
                </div>

                <!-- Match Analysis -->
                <div class="match-analysis">
                    <div class="analysis-title">
                        <i class="bi bi-graph-up-arrow"></i>
                        Phân tích chi tiết độ phù hợp
                    </div>

                    <div class="criteria-grid">
                        <!-- 1. LOCATION - ƯU TIÊN NHẤT (35%) -->
                        @if(isset($details['location']) && is_array($details['location']))
                        <div class="criteria-item">
                            <div class="criteria-header">
                                <div class="criteria-name">
                                    <i class="bi bi-geo-alt"></i>
                                    🎯 Địa điểm (35%)
                                </div>
                                <div class="criteria-score {{ $getScoreLevel($details['location']['score']) }}">
                                    {{ number_format($details['location']['score'], 0) }}%
                                </div>
                            </div>
                            <div class="progress-bar-wrapper">
                                <div class="progress-fill {{ $getScoreLevel($details['location']['score']) }}"
                                    data-width="{{ $details['location']['score'] }}"></div>
                            </div>
                            <div class="criteria-reason">
                                {{ $details['location']['reason'] }}
                            </div>
                        </div>
                        @endif

                        <!-- 2. SKILLS (30%) -->
                        @if(isset($details['skills']) && is_array($details['skills']))
                        <div class="criteria-item">
                            <div class="criteria-header">
                                <div class="criteria-name">
                                    <i class="bi bi-code-square"></i>
                                    Kỹ năng (30%)
                                </div>
                                <div class="criteria-score {{ $getScoreLevel($details['skills']['score']) }}">
                                    {{ number_format($details['skills']['score'], 0) }}%
                                </div>
                            </div>
                            <div class="progress-bar-wrapper">
                                <div class="progress-fill {{ $getScoreLevel($details['skills']['score']) }}"
                                    data-width="{{ $details['skills']['score'] }}"></div>
                            </div>
                            <div class="criteria-reason">
                                {{ $details['skills']['reason'] }}
                            </div>

                            @if(!empty($details['skills']['details']['matched_skills']) || !empty($details['skills']['details']['missing_skills']))
                            <div class="skills-details">
                                @if(!empty($details['skills']['details']['matched_skills']))
                                <div class="skills-section">
                                    <div class="skills-section-title">✓ Kỹ năng phù hợp:</div>
                                    <div class="skill-tags">
                                        @foreach($details['skills']['details']['matched_skills'] as $skill)
                                        <span class="skill-tag matched">{{ $skill }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                @if(!empty($details['skills']['details']['missing_skills']))
                                <div class="skills-section">
                                    <div class="skills-section-title">✗ Kỹ năng còn thiếu:</div>
                                    <div class="skill-tags">
                                        @foreach($details['skills']['details']['missing_skills'] as $skill)
                                        <span class="skill-tag missing">{{ $skill }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endif

                        <!-- 3. POSITION (20%) -->
                        @if(isset($details['position']) && is_array($details['position']))
                        <div class="criteria-item">
                            <div class="criteria-header">
                                <div class="criteria-name">
                                    <i class="bi bi-person-badge"></i>
                                    Vị trí (20%)
                                </div>
                                <div class="criteria-score {{ $getScoreLevel($details['position']['score']) }}">
                                    {{ number_format($details['position']['score'], 0) }}%
                                </div>
                            </div>
                            <div class="progress-bar-wrapper">
                                <div class="progress-fill {{ $getScoreLevel($details['position']['score']) }}"
                                    data-width="{{ $details['position']['score'] }}"></div>
                            </div>
                            <div class="criteria-reason">
                                {{ $details['position']['reason'] }}
                            </div>
                        </div>
                        @endif

                        <!-- 4. Experience (8%) -->
                        @if(isset($details['experience']) && is_array($details['experience']))
                        <div class="criteria-item">
                            <div class="criteria-header">
                                <div class="criteria-name">
                                    <i class="bi bi-clock-history"></i>
                                    Kinh nghiệm (8%)
                                </div>
                                <div class="criteria-score {{ $getScoreLevel($details['experience']['score']) }}">
                                    {{ number_format($details['experience']['score'], 0) }}%
                                </div>
                            </div>
                            <div class="progress-bar-wrapper">
                                <div class="progress-fill {{ $getScoreLevel($details['experience']['score']) }}"
                                    data-width="{{ $details['experience']['score'] }}"></div>
                            </div>
                            <div class="criteria-reason">
                                {{ $details['experience']['reason'] }}
                            </div>
                        </div>
                        @endif

                        <!-- 5. Salary (4%) -->
                        @if(isset($details['salary']) && is_array($details['salary']))
                        <div class="criteria-item">
                            <div class="criteria-header">
                                <div class="criteria-name">
                                    <i class="bi bi-cash-coin"></i>
                                    Mức lương (4%)
                                </div>
                                <div class="criteria-score {{ $getScoreLevel($details['salary']['score']) }}">
                                    {{ number_format($details['salary']['score'], 0) }}%
                                </div>
                            </div>
                            <div class="progress-bar-wrapper">
                                <div class="progress-fill {{ $getScoreLevel($details['salary']['score']) }}"
                                    data-width="{{ $details['salary']['score'] }}"></div>
                            </div>
                            <div class="criteria-reason">
                                {{ $details['salary']['reason'] }}
                            </div>
                        </div>
                        @endif

                        <!-- 6. Language (3%) -->
                        @if(isset($details['language']) && is_array($details['language']))
                        <div class="criteria-item">
                            <div class="criteria-header">
                                <div class="criteria-name">
                                    <i class="bi bi-translate"></i>
                                    Ngoại ngữ (3%)
                                </div>
                                <div class="criteria-score {{ $getScoreLevel($details['language']['score']) }}">
                                    {{ number_format($details['language']['score'], 0) }}%
                                </div>
                            </div>
                            <div class="progress-bar-wrapper">
                                <div class="progress-fill {{ $getScoreLevel($details['language']['score']) }}"
                                    data-width="{{ $details['language']['score'] }}"></div>
                            </div>
                            <div class="criteria-reason">
                                {{ $details['language']['reason'] }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="job-actions">
                    <a href="{{ route('job.detail', $job->job_id) }}" class="btn-action btn-primary" onclick="markAsViewed('{{ $rec->id }}'); return false;">
                        <i class="bi bi-eye-fill"></i>
                        <span>Xem chi tiết</span>
                    </a>
                    <a href="{{ route('application.store', $job->job_id) }}"
                        class="btn-action btn-secondary">
                        <i class="bi bi-send-fill"></i>
                        <span>Ứng tuyển ngay</span>
                    </a>
                    <button class="btn-action btn-icon"
                        onclick="toggleSave(this, '{{ $job->job_id }}')">
                        <i class="bi bi-heart"></i>
                    </button>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <div style="font-size: 4rem; color: #ddd;">
                    <i class="bi bi-inbox"></i>
                </div>
                <h3 class="mt-3">Chưa có việc làm phù hợp</h3>
                <p class="text-muted">Hầu hết các vị trí đã đủ số lượng nhân viên cần tuyển hoặc không có việc làm nào phù hợp với hồ sơ của bạn</p>
                <div class="mt-4">
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="bi bi-house-door"></i> Về trang chủ
                    </a>
                    <a href="{{ route('profile') }}" class="btn btn-outline-primary ms-2">
                        <i class="bi bi-pencil"></i> Cập nhật hồ sơ
                    </a>
                </div>
            </div>
            @endforelse
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // CSRF Token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Refresh recommendations
        // Refresh recommendations
        async function refreshRecommendations() {
            const btn = event.target.closest('button');
            const originalHTML = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = '<span class="loading-spinner"></span><span class="ms-2">Đang tải...</span>';

            try {
                const response = await fetch('{{ route("applicant.recommendations.refresh") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // ✅ Hiển thị thông báo thành công
                    btn.innerHTML = '<i class="bi bi-check-circle-fill"></i><span class="ms-2">Thành công!</span>';

                    // ✅ Hiển thị số lượng
                    if (data.count) {
                        const message = document.createElement('div');
                        message.className = 'alert alert-success mt-3';
                        message.innerHTML = `
                    <i class="bi bi-check-circle-fill"></i>
                    Đã tạo <strong>${data.count}</strong> gợi ý mới với trọng số:
                    <ul class="mb-0 mt-2">
                        <li>🎯 Địa điểm: 35%</li>
                        <li>💻 Kỹ năng: 30%</li>
                        <li>👔 Vị trí: 20%</li>
                        <li>📅 Kinh nghiệm: 8%</li>
                        <li>💰 Lương: 4%</li>
                        <li>🌐 Ngoại ngữ: 3%</li>
                    </ul>
                `;
                        btn.parentElement.after(message);
                    }

                    // ✅ Reload page sau 1.5 giây
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Có lỗi xảy ra');
                }
            } catch (error) {
                console.error('Error:', error);
                btn.innerHTML = '<i class="bi bi-exclamation-circle-fill"></i><span class="ms-2">Thất bại!</span>';

                // Hiển thị lỗi
                alert('❌ ' + error.message);

                setTimeout(() => {
                    btn.disabled = false;
                    btn.innerHTML = originalHTML;
                }, 2000);
            }
        }

        // Mark as viewed
        async function markAsViewed(recommendationId) {
            try {
                const id = String(recommendationId).trim();
                await fetch(`/recommendations/${id}/viewed`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
            } catch (error) {
                console.error('Error marking as viewed:', error);
            }
        }

        // Toggle save job
        async function toggleSave(btn, jobId) {
            const icon = btn.querySelector('i');
            const isSaved = icon.classList.contains('bi-heart-fill');

            // Determine endpoint and method
            const endpoint = isSaved ? `/job/unsave/${jobId}` : `/job/save/${jobId}`;
            const method = isSaved ? 'DELETE' : 'POST';

            try {
                // Disable button while processing
                btn.disabled = true;

                const response = await fetch(endpoint, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    // Update UI based on save/unsave
                    if (isSaved) {
                        // Unsave: Change to heart outline
                        icon.classList.remove('bi-heart-fill');
                        icon.classList.add('bi-heart');
                        btn.classList.remove('saved');

                        // Show notification
                        showToast('Đã bỏ lưu công việc', 'info');
                    } else {
                        // Save: Change to filled heart
                        icon.classList.remove('bi-heart');
                        icon.classList.add('bi-heart-fill');
                        btn.classList.add('saved');

                        // Animation
                        btn.style.transform = 'scale(1.2)';
                        setTimeout(() => {
                            btn.style.transform = 'scale(1)';
                        }, 200);

                        // Show notification
                        showToast('Đã lưu công việc', 'success');
                    }
                } else {
                    showToast(data.message || 'Có lỗi xảy ra', 'error');
                }
            } catch (error) {
                console.error('Error toggling save:', error);
                showToast('Có lỗi xảy ra. Vui lòng thử lại', 'error');
            } finally {
                btn.disabled = false;
            }
        }

        // Helper function to show toast notification
        function showToast(message, type = 'info') {
            const toastHTML = `
                <div class="toast-notification ${type}">
                    <span>${message}</span>
                </div>
            `;

            // Create temporary container if doesn't exist
            let container = document.getElementById('toast-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toast-container';
                container.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; pointer-events: none;';
                document.body.appendChild(container);
            }

            const toast = document.createElement('div');
            toast.innerHTML = toastHTML;
            container.appendChild(toast.firstElementChild);

            // Auto remove after 3 seconds
            setTimeout(() => {
                toast.firstElementChild.remove();
            }, 3000);
        }

        // Animate progress bars on scroll
        const observerOptions = {
            threshold: 0.3
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const progressBars = entry.target.querySelectorAll('.progress-fill');
                    progressBars.forEach(bar => {
                        const width = bar.style.width;
                        bar.style.width = '0';
                        setTimeout(() => {
                            bar.style.width = width;
                        }, 100);
                    });
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', () => {
            // Apply progress bar widths from data attributes
            document.querySelectorAll('.progress-fill[data-width]').forEach(bar => {
                const width = bar.getAttribute('data-width');
                bar.style.width = `${width}% !important`;
            });

            document.querySelectorAll('.match-analysis').forEach(analysis => {
                observer.observe(analysis);
            });
        });

        /**
         * Cập nhật recommendations sau khi profile thay đổi
         * Gọi hàm này từ các trang profile update
         */
        async function recalculateRecommendations() {
            try {
                const response = await fetch('{{ route("recommendations.recalculate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Reload trang sau 1 giây
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    console.error('Error:', data.message);
                }
            } catch (error) {
                console.error('Error recalculating recommendations:', error);
            }
        }

        /**
         * Listen to changes từ localStorage (khi profile update hoàn tất)
         * Hoặc broadcast event nếu dùng WebSocket
         */
        window.addEventListener('profileUpdated', function() {
            recalculateRecommendations();
        });
    </script>

    <!-- ✅ Toast Notification System -->
    <script src="{{ asset('js/toast.js') }}"></script>
</body>

</html>