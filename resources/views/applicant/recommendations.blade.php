<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gợi ý việc làm phù hợp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
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
            padding-bottom: 3rem;
        }

        /* Header */
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

        /* Hero Section */
        .hero-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 30px;
            padding: 2.5rem;
            margin: 2rem 0;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .refresh-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            border: none;
            font-weight: 700;
            font-size: 1rem;
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

        /* Stats Grid */
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

        /* Jobs Grid Layout */
        .jobs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }

        /* Job Card Compact */
        .job-card-compact {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            transition: box-shadow 0.25s cubic-bezier(0.4, 0, 0.2, 1), transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .job-card-compact::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            transition: width 0.3s;
        }

        .job-card-compact.high-match::before {
            background: linear-gradient(180deg, #11998e 0%, #38ef7d 100%);
        }

        .job-card-compact.medium-match::before {
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        }

        .job-card-compact.low-match::before {
            background: linear-gradient(180deg, #fa709a 0%, #fee140 100%);
        }

        .job-card-compact:hover {
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.18);
            transform: translateY(-4px) scale(1.01);
        }

        .job-card-compact:hover::before {
            /* Loại bỏ hiệu ứng hover phức tạp cho before, giữ nguyên thanh màu bên trái */
        }

        /* Card Header */
        .card-header-compact {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .company-logo-small {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: 900;
            flex-shrink: 0;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .job-info-compact {
            flex: 1;
            min-width: 0;
        }

        .job-title-compact {
            font-size: 1.2rem;
            font-weight: 800;
            color: #333;
            margin-bottom: 0.3rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .company-name-compact {
            color: #666;
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Match Badge */
        .match-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 800;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.18);
            transition: background 0.2s;
        }

        .job-card-compact.high-match .match-badge {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        /* Tags Compact */
        .tags-compact {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin: 1rem 0;
        }

        .tag-compact {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .tag-compact.location {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .tag-compact.salary {
            background: rgba(56, 239, 125, 0.1);
            color: #11998e;
        }

        .tag-compact.level {
            background: rgba(79, 172, 254, 0.1);
            color: #4facfe;
        }

        .tag-compact.new {
            background: rgba(250, 112, 154, 0.1);
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

        /* Quick Actions */
        .quick-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .btn-quick {
            flex: 1;
            padding: 0.7rem;
            border-radius: 12px;
            border: none;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-view {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transition: box-shadow 0.2s, transform 0.2s;
        }

        .btn-view:hover {
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.18);
            transform: translateY(-2px) scale(1.03);
        }

        .btn-save {
            background: white;
            color: #666;
            border: 2px solid #ddd;
            transition: border-color 0.2s, color 0.2s, background 0.2s, transform 0.2s;
        }

        .btn-save:hover {
            border-color: #ff6b6b;
            color: #ff6b6b;
            background: #fff5f5;
            transform: scale(1.05);
        }

        .btn-save.saved {
            border-color: #ff6b6b;
            color: #ff6b6b;
            background: #fff5f5;
        }

        /* Expandable Details */
        .details-panel {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            margin-top: 0;
        }

        .details-panel.expanded {
            max-height: 2000px;
            margin-top: 1.5rem;
        }

        .expand-btn {
            width: 100%;
            padding: 0.7rem;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
            border: none;
            border-radius: 12px;
            color: #667eea;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .expand-btn:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.16) 0%, rgba(118, 75, 162, 0.16) 100%);
            color: #4facfe;
        }

        .expand-icon {
            transition: transform 0.3s;
        }

        .expand-btn.active .expand-icon {
            transform: rotate(180deg);
        }

        /* Match Analysis Compact */
        .match-analysis-compact {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.03) 0%, rgba(118, 75, 162, 0.03) 100%);
            border-radius: 15px;
            padding: 1.5rem;
        }

        .criteria-compact {
            display: grid;
            gap: 1rem;
        }

        .criteria-item-compact {
            background: white;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .criteria-header-compact {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.8rem;
        }

        .criteria-name-compact {
            font-size: 0.85rem;
            font-weight: 700;
            color: #666;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .criteria-score-compact {
            font-size: 1.5rem;
            font-weight: 900;
        }

        .criteria-score-compact.high {
            color: #38ef7d;
        }

        .criteria-score-compact.medium {
            color: #667eea;
        }

        .criteria-score-compact.low {
            color: #fa709a;
        }

        .progress-bar-compact {
            height: 8px;
            background: #f0f0f0;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }

        .progress-fill-compact {
            height: 100%;
            border-radius: 10px;
            transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .progress-fill-compact.high {
            background: linear-gradient(90deg, #11998e 0%, #38ef7d 100%);
        }

        .progress-fill-compact.medium {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }

        .progress-fill-compact.low {
            background: linear-gradient(90deg, #fa709a 0%, #fee140 100%);
        }

        .criteria-reason-compact {
            font-size: 0.8rem;
            color: #666;
            line-height: 1.5;
            padding: 0.6rem;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 8px;
        }

        /* Skills Details */
        .skills-details-compact {
            margin-top: 0.8rem;
            padding-top: 0.8rem;
            border-top: 1px solid #e0e0e0;
        }

        .skills-section-title-compact {
            font-size: 0.75rem;
            font-weight: 700;
            color: #666;
            margin-bottom: 0.4rem;
        }

        .skill-tags-compact {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
        }

        .skill-tag-compact {
            padding: 0.3rem 0.6rem;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .skill-tag-compact.matched {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .skill-tag-compact.missing {
            background: #ffebee;
            color: #c62828;
        }

        /* Empty State */
        .empty-state {
            background: white;
            border-radius: 30px;
            padding: 4rem 2rem;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .empty-icon {
            font-size: 5rem;
            color: #667eea;
            margin-bottom: 1.5rem;
        }

        /* Loading */
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

        /* Responsive */
        @media (max-width: 768px) {
            .jobs-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .hero-section {
                padding: 1.5rem;
            }

            .job-title-compact {
                font-size: 1.1rem;
            }

            .match-badge {
                font-size: 0.8rem;
                padding: 0.4rem 0.8rem;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .job-card-compact {
            animation: fadeInUp 0.5s ease-out;
        }

        .job-card-compact:nth-child(1) {
            animation-delay: 0.1s;
        }

        .job-card-compact:nth-child(2) {
            animation-delay: 0.2s;
        }

        .job-card-compact:nth-child(3) {
            animation-delay: 0.3s;
        }

        .job-card-compact:nth-child(4) {
            animation-delay: 0.4s;
        }

        .job-card-compact:nth-child(5) {
            animation-delay: 0.5s;
        }

        .job-card-compact:nth-child(6) {
            animation-delay: 0.6s;
        }
    </style>
</head>

<body>
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
                        Việc làm phù hợp với bạn
                    </h1>
                    <p class="text-muted" style="font-size: 1.1rem;">
                        Danh sách việc làm phù hợp dựa trên hồ sơ, kỹ năng và kinh nghiệm của bạn
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
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Tổng gợi ý</div>
                        <div class="h3 fw-bold mb-0">{{ $recommendations->count() }}</div>
                    </div>
                    <i class="bi bi-briefcase-fill" style="font-size: 2rem; color: #667eea;"></i>
                </div>
            </div>
            <div class="stat-card green">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Phù hợp cao</div>
                        <div class="h3 fw-bold mb-0">{{ $recommendations->where('score', '>=', 80)->count() }}</div>
                    </div>
                    <i class="bi bi-award-fill" style="font-size: 2rem; color: #38ef7d;"></i>
                </div>
            </div>
            <div class="stat-card blue">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Đã xem</div>
                        <div class="h3 fw-bold mb-0">{{ $recommendations->where('is_viewed', true)->count() }}</div>
                    </div>
                    <i class="bi bi-eye-fill" style="font-size: 2rem; color: #4facfe;"></i>
                </div>
            </div>
            <div class="stat-card orange">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Đã lưu</div>
                        <div class="h3 fw-bold mb-0">0</div>
                    </div>
                    <i class="bi bi-heart-fill" style="font-size: 2rem; color: #fa709a;"></i>
                </div>
            </div>
        </div>

        <!-- Jobs Grid -->
        @forelse($recommendations as $rec)
        @php
        $job = $rec->job;
        $details = $rec->match_details_parsed ?? [];
        $score = $rec->score ?? 0;
        if ($score >= 80) {
        $matchClass = 'high-match';
        } elseif ($score >= 60) {
        $matchClass = 'medium-match';
        } else {
        $matchClass = 'low-match';
        }
        $getScoreLevel = function($score) {
        if ($score >= 80) return 'high';
        if ($score >= 60) return 'medium';
        return 'low';
        };
        // Gom modal vào biến
        $modalsHtml = $modalsHtml ?? '';
        @endphp

        @if($loop->first)
        <div class="jobs-grid">
            @endif
            <div class="job-card-compact {{ $matchClass }}" data-job-id="{{ $job->job_id }}">
                <!-- Match Badge -->
                <div class="match-badge">
                    {{ number_format($rec->score, 0) }}%
                </div>

                <!-- Card Header -->
                <div class="card-header-compact">
                    @if($job->company && $job->company->logo)
                    <img src="{{ asset('assets/img/' . $job->company->logo) }}"
                        alt="Company Logo"
                        class="company-logo-small"
                        style="object-fit: cover;" />
                    @else
                    <div class="company-logo-small">
                        {{ strtoupper(substr($job->company->ten_cty ?? 'C', 0, 1)) }}
                    </div>
                    @endif

                    <div class="job-info-compact">
                        <h3 class="job-title-compact" title="{{ $job->title }}">
                            {{ $job->title }}
                        </h3>
                        <div class="company-name-compact" title="{{ $job->company->tencty ?? 'Công ty' }}">
                            <i class="bi bi-building"></i>
                            {{ $job->company->tencty ?? 'Công ty' }}
                        </div>
                    </div>
                </div>

                <!-- Tags -->
                <div class="tags-compact">
                    <span class="tag-compact location">
                        <i class="bi bi-geo-alt-fill"></i>
                        {{ $job->province }}
                    </span>

                    @if($job->salary_type === 'negotiable')
                    <span class="tag-compact salary">
                        <i class="bi bi-cash-stack"></i>
                        Thỏa thuận
                    </span>
                    @else
                    <span class="tag-compact salary">
                        <i class="bi bi-cash-stack"></i>
                        {{ number_format($job->salary_min/1000000, 0) }}-{{ number_format($job->salary_max/1000000, 0) }}M
                    </span>
                    @endif

                    <span class="tag-compact level">
                        <i class="bi bi-briefcase-fill"></i>
                        {{ $job->experience }}
                    </span>

                    @if(\Carbon\Carbon::parse($job->created_at)->diffInDays(now()) < 7)
                        <span class="tag-compact new">
                        <i class="bi bi-star-fill"></i>
                        Mới
                        </span>
                        @endif
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <a href="{{ route('job.detail', $job->job_id) }}"
                        class="btn-quick btn-view"
                        onclick="markAsViewed('{{ $rec->id }}')">
                        <i class="bi bi-eye-fill"></i>
                        Xem chi tiết
                    </a>
                    <button class="btn-quick btn-save"
                        onclick="toggleSave(this, '{{ $job->job_id }}', event)">
                        <i class="bi bi-heart"></i>
                    </button>
                </div>

                <!-- Modal Trigger Button -->
                <button type="button" class="expand-btn" data-bs-toggle="modal" data-bs-target="#analysisModal-{{ $rec->id }}">
                    <span>Vì sao phù hợp?</span>
                    <i class="bi bi-bar-chart-line"></i>
                </button>
                @php
                $modalsHtml .= view()->make('applicant._analysis_modal', [
                'rec' => $rec,
                'job' => $job,
                'details' => $details,
                'getScoreLevel' => $getScoreLevel
                ])->render();
                @endphp
            </div>

            @if($loop->last)
        </div>
        @endif

        @empty
        <div class="empty-state">
            <div class="empty-icon">
                <i class="bi bi-inbox"></i>
            </div>
            <h2 class="mb-3">Chưa có gợi ý việc làm</h2>
            <p class="text-muted mb-4">
                Hệ thống chưa tìm thấy việc làm phù hợp với hồ sơ của bạn.<br>
                Vui lòng cập nhật hồ sơ để nhận được gợi ý tốt hơn.
            </p>
            <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-pencil"></i> Cập nhật hồ sơ
            </a>
        </div>
        @endforelse
        {{-- Render all modals sau grid --}}
        @if(isset($modalsHtml))
        {!! $modalsHtml !!}
        @endif
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/toast.js') }}"></script>
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Toggle details panel
        function toggleDetails(btn, event) {
            event.stopPropagation();
            const card = btn.closest('.job-card-compact');
            const panel = card.querySelector('.details-panel');

            panel.classList.toggle('expanded');
            btn.classList.toggle('active');

            if (panel.classList.contains('expanded')) {
                btn.querySelector('span').textContent = 'Thu gọn';
            } else {
                btn.querySelector('span').textContent = 'Xem phân tích chi tiết';
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
        async function toggleSave(btn, jobId, event) {
            event.stopPropagation();
            event.preventDefault();

            const icon = btn.querySelector('i');
            const isSaved = icon.classList.contains('bi-heart-fill');
            const endpoint = isSaved ? `/job/unsave/${jobId}` : `/job/save/${jobId}`;
            const method = isSaved ? 'DELETE' : 'POST';

            try {
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
                    if (isSaved) {
                        icon.classList.remove('bi-heart-fill');
                        icon.classList.add('bi-heart');
                        btn.classList.remove('saved');
                        showToast('Đã bỏ lưu công việc', 'info');
                    } else {
                        icon.classList.remove('bi-heart');
                        icon.classList.add('bi-heart-fill');
                        btn.classList.add('saved');
                        btn.style.transform = 'scale(1.2)';
                        setTimeout(() => {
                            btn.style.transform = 'scale(1)';
                        }, 200);
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
                    btn.innerHTML = '<i class="bi bi-check-circle-fill"></i><span class="ms-2">Thành công!</span>';
                    showToast(`Đã tạo ${data.count} gợi ý mới`, 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    throw new Error(data.message || 'Có lỗi xảy ra');
                }
            } catch (error) {
                console.error('Error:', error);
                btn.innerHTML = '<i class="bi bi-exclamation-circle-fill"></i><span class="ms-2">Thất bại!</span>';
                showToast(error.message, 'error');
                setTimeout(() => {
                    btn.disabled = false;
                    btn.innerHTML = originalHTML;
                }, 2000);
            }
        }

        // Show toast notification
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            z-index: 9999;
            animation: slideIn 0.3s ease;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        `;
            toast.style.background = type === 'success' ? 'linear-gradient(135deg, #11998e, #38ef7d)' :
                type === 'error' ? 'linear-gradient(135deg, #eb3349, #f45c43)' :
                'linear-gradient(135deg, #667eea, #764ba2)';
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '0';
                    entry.target.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        entry.target.style.transition = 'all 0.5s ease';
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, 100);
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.job-card-compact').forEach(card => {
                observer.observe(card);
            });
        });
    </script>
</body>

</html>