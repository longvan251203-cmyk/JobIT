<!DOCTYPE html>
<html lang="vi">
@include('applicant.partials.head')
<style>
    :root {
        --primary-color: #4f46e5;
        --secondary-color: #06b6d4;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #3b82f6;
        --light-bg: #f8fafc;
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        min-height: 100vh;
        overflow-x: hidden;
    }

    .main {
        padding: 2rem 0;
        min-height: calc(100vh - 200px);
    }

    .container-fluid {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 15px;
    }

    /* Sidebar Card */
    .sidebar-card {
        background: white;
        border-radius: 24px;
        box-shadow: var(--card-shadow);
        border: none;
        position: sticky;
        top: 20px;
        overflow: hidden;
    }

    .sidebar-card .card-body {
        padding: 2rem;
    }

    .sidebar-card h6 {
        font-size: 0.875rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .sidebar-card h5 {
        font-size: 1.25rem;
        margin-bottom: 0.25rem;
        color: #1e293b;
    }

    .sidebar-card .nav-link {
        padding: 0.875rem 1rem;
        border-radius: 12px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 500;
    }

    .sidebar-card .nav-link i {
        font-size: 1.1rem;
        width: 20px;
    }

    .sidebar-card .nav-link:hover {
        background: rgba(79, 70, 229, 0.08);
        color: var(--primary-color);
        transform: translateX(5px);
    }

    .sidebar-card .nav-link.active {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
    }

    /* Tab Navigation */
    .nav-tabs-modern {
        border: none;
        background: white;
        border-radius: 16px;
        padding: 0.75rem;
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        display: flex;
        gap: 0.5rem;
    }

    .nav-tabs-modern .nav-item {
        flex: 1;
    }

    .nav-tabs-modern .nav-link {
        border: none;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        font-weight: 600;
        color: #64748b;
        transition: all 0.3s ease;
        position: relative;
        text-align: center;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .nav-tabs-modern .nav-link:hover {
        color: var(--primary-color);
        background: rgba(79, 70, 229, 0.05);
    }

    .nav-tabs-modern .nav-link.active {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    }

    .nav-tabs-modern .nav-link .badge {
        margin-left: 0.5rem;
        padding: 0.25rem 0.6rem;
        font-size: 0.75rem;
        border-radius: 10px;
    }

    .nav-tabs-modern .nav-link.active .badge {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Job Card */
    .job-card-modern {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .job-card-modern:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        border-color: var(--primary-color);
    }

    .company-logo-wrapper {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        background: var(--light-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #e5e7eb;
    }

    .company-logo-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .job-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .company-name {
        color: var(--primary-color);
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 1rem;
    }

    .salary-badge {
        display: inline-block;
        background: linear-gradient(135deg, var(--success-color), #34d399);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .salary-badge.negotiable {
        background: linear-gradient(135deg, #6b7280, #9ca3af);
    }

    .job-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin: 1rem 0;
        padding: 1rem 0;
        border-top: 1px solid #e5e7eb;
        border-bottom: 1px solid #e5e7eb;
    }

    .job-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #64748b;
        font-size: 0.9rem;
    }

    .job-meta-item i {
        color: var(--primary-color);
        font-size: 1.1rem;
    }

    .job-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin: 1rem 0;
    }

    .job-tag {
        background: rgba(79, 70, 229, 0.1);
        color: var(--primary-color);
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .status-badge.pending {
        background: rgba(251, 191, 36, 0.1);
        color: #d97706;
    }

    .status-badge.viewed {
        background: rgba(59, 130, 246, 0.1);
        color: #2563eb;
    }

    .status-badge.interview {
        background: rgba(168, 85, 247, 0.1);
        color: #7c3aed;
    }

    .status-badge.accepted {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
    }

    .status-badge.rejected {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
    }

    /* Action Buttons */
    .btn-action {
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-view {
        background: var(--info-color);
        color: white;
    }

    .btn-view:hover {
        background: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        color: white;
    }

    .btn-unsave {
        background: var(--danger-color);
        color: white;
    }

    .btn-unsave:hover {
        background: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        color: white;
    }

    .btn-cancel {
        background: #f1f5f9;
        color: #475569;
        border: 2px solid #e2e8f0;
    }

    .btn-cancel:hover {
        background: #fef2f2;
        color: var(--danger-color);
        border-color: var(--danger-color);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
    }

    .empty-state i {
        font-size: 5rem;
        color: #cbd5e1;
        margin-bottom: 1.5rem;
    }

    .empty-state h5 {
        color: #475569;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #94a3b8;
        margin-bottom: 1.5rem;
    }

    .btn-find-jobs {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .btn-find-jobs:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
        color: white;
    }

    /* Timeline for Application */
    .timeline-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
        color: #64748b;
        font-size: 0.85rem;
    }

    .timeline-info i {
        color: var(--info-color);
    }

    /* Page Title */
    h3.text-white {
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .main {
            padding: 1rem 0;
        }

        .sidebar-card {
            position: relative;
            top: 0;
            margin-bottom: 1.5rem;
        }

        .sidebar-card .card-body {
            padding: 1.5rem;
        }

        .nav-tabs-modern {
            padding: 0.5rem;
            flex-direction: column;
        }

        .nav-tabs-modern .nav-link {
            padding: 0.875rem 1rem;
            font-size: 0.9rem;
        }

        .job-card-modern {
            padding: 1rem;
        }

        .job-card-modern .row {
            flex-direction: column;
        }

        .company-logo-wrapper {
            width: 60px;
            height: 60px;
            margin: 0 auto 1rem;
        }

        .job-title {
            font-size: 1.1rem;
            text-align: center;
        }

        .company-name {
            text-align: center;
        }

        .salary-badge {
            display: block;
            text-align: center;
            margin: 1rem auto;
        }

        .job-meta {
            flex-direction: column;
            gap: 0.75rem;
        }

        .job-meta-item {
            justify-content: center;
        }

        .job-tags {
            justify-content: center;
        }

        .timeline-info {
            flex-direction: column;
            gap: 0.75rem;
            text-align: center;
        }

        .status-badge {
            margin: 1rem auto;
        }

        .btn-action {
            width: 100%;
            margin-top: 0.5rem;
        }

        .col-md-3.text-end {
            text-align: center !important;
            margin-top: 1rem;
        }

        .empty-state {
            padding: 3rem 1.5rem;
        }

        .empty-state i {
            font-size: 4rem;
        }

        h3.text-white {
            font-size: 1.5rem;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .container-fluid {
            padding: 0 10px;
        }

        .job-title {
            font-size: 1rem;
        }

        .company-logo-wrapper {
            width: 50px;
            height: 50px;
        }

        .salary-badge {
            font-size: 0.85rem;
            padding: 0.4rem 0.8rem;
        }

        .job-meta-item {
            font-size: 0.85rem;
        }

        .job-tag {
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
        }

        .btn-action {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }

        .timeline-info {
            font-size: 0.8rem;
        }
    }
</style>

<body>
    @include('applicant.partials.header')
    <main class="main">
        <div class="container-fluid">
            <div class="row">

                <!-- Sidebar -->
                <div class="col-md-3 col-lg-3 mb-4">
                    <div class="card sidebar-card">
                        <div class="card-body">
                            <h6 class="text-muted">Xin chào</h6>
                            <h5 class="fw-bold">{{ $applicant->hoten_uv ?? 'Ứng viên' }}</h5>
                            <p class="text-secondary small mb-1">{{ Auth::user()->email }}</p>
                            <hr>
                            <ul class="nav flex-column">
                                <li class="nav-item mb-2">
                                    <a href="{{ route('applicant.profile') }}" class="nav-link text-dark">
                                        <i class="bi bi-grid"></i> Tổng quan
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="{{ route('applicant.hoso') }}" class="nav-link text-dark">
                                        <i class="bi bi-person-badge"></i> Thông tin cá nhân
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#" class="nav-link text-dark">
                                        <i class="bi bi-file-earmark-text"></i> Hồ sơ đính kèm
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="{{ route('applicant.myJobs') }}" class="nav-link active text-primary fw-bold">
                                        <i class="bi bi-briefcase"></i> Việc làm của tôi
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#" class="nav-link text-dark">
                                        <i class="bi bi-envelope"></i> Lời mời công việc
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#" class="nav-link text-dark">
                                        <i class="bi bi-bell"></i> Thông báo
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link text-dark">
                                        <i class="bi bi-gear"></i> Cài đặt
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-md-9 col-lg-9">

                    <h3 class="text-white fw-bold mb-4">
                        <i class="bi bi-briefcase-fill me-2"></i>Việc làm của tôi
                    </h3>

                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs nav-tabs-modern" id="myJobsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active position-relative" id="applied-tab"
                                data-bs-toggle="tab" data-bs-target="#applied" type="button">
                                <i class="bi bi-send-check me-2"></i>Đã ứng tuyển
                                <span class="badge bg-danger">{{ $applications->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link position-relative" id="saved-tab"
                                data-bs-toggle="tab" data-bs-target="#saved" type="button">
                                <i class="bi bi-heart-fill me-2"></i>Đã lưu
                                <span class="badge bg-danger">{{ $savedJobs->count() }}</span>
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="myJobsTabContent">

                        <!-- Tab Đã ứng tuyển -->
                        <div class="tab-pane fade show active" id="applied" role="tabpanel">
                            @if($applications->count() > 0)
                            @foreach($applications as $app)
                            <div class="job-card-modern">
                                <div class="row align-items-start">
                                    <div class="col-md-2 text-center">
                                        <div class="company-logo-wrapper">
                                            @if($app->job && $app->job->company && $app->job->company->logo)
                                            <img src="{{ asset('storage/' . $app->job->company->logo) }}" alt="Logo">
                                            @else
                                            <img src="{{ asset('assets/img/company-logo.png') }}" alt="Logo">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <h4 class="job-title">{{ $app->job->title ?? 'Tiêu đề công việc' }}</h4>
                                        <p class="company-name">{{ $app->job->company->tencty ?? 'Tên công ty' }}</p>

                                        <span class="salary-badge {{ (!$app->job->salary_min || !$app->job->salary_max) ? 'negotiable' : '' }}">
                                            @if($app->job->salary_min && $app->job->salary_max)
                                            {{ number_format($app->job->salary_min, 0, ',', '.') }} -
                                            {{ number_format($app->job->salary_max, 0, ',', '.') }}
                                            {{ strtoupper($app->job->salary_type) }}
                                            @else
                                            Thỏa thuận
                                            @endif
                                        </span>

                                        <div class="job-meta">
                                            <div class="job-meta-item">
                                                <i class="bi bi-geo-alt-fill"></i>
                                                <span>{{ $app->job->province ?? 'N/A' }}</span>
                                            </div>
                                            <div class="job-meta-item">
                                                <i class="bi bi-briefcase-fill"></i>
                                                <span>{{ ucfirst($app->job->level ?? 'N/A') }}</span>
                                            </div>
                                            <div class="job-meta-item">
                                                <i class="bi bi-award-fill"></i>
                                                <span>{{ $app->job->experience ?? 'N/A' }}</span>
                                            </div>
                                        </div>

                                        @if($app->job->hashtags && $app->job->hashtags->count() > 0)
                                        <div class="job-tags">
                                            @foreach($app->job->hashtags->take(5) as $tag)
                                            <span class="job-tag">{{ $tag->tag_name }}</span>
                                            @endforeach
                                        </div>
                                        @endif

                                        <div class="timeline-info">
                                            <div>
                                                <i class="bi bi-calendar-check"></i>
                                                <strong>Ứng tuyển:</strong> {{ \Carbon\Carbon::parse($app->ngay_ung_tuyen)->format('d/m/Y H:i') }}
                                            </div>
                                            <div>
                                                <i class="bi bi-clock-history"></i>
                                                <strong>Hạn nộp:</strong> {{ \Carbon\Carbon::parse($app->job->deadline)->format('d/m/Y') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        @php
                                        $statusMap = [
                                        'chua_xem' => ['class' => 'pending', 'icon' => 'bi-hourglass-split', 'text' => 'Chưa xem'],
                                        'da_xem' => ['class' => 'viewed', 'icon' => 'bi-eye-fill', 'text' => 'Đã xem'],
                                        'phong_van' => ['class' => 'interview', 'icon' => 'bi-calendar-check', 'text' => 'Phỏng vấn'],
                                        'duoc_chon' => ['class' => 'accepted', 'icon' => 'bi-check-circle-fill', 'text' => 'Được chọn'],
                                        'tu_choi' => ['class' => 'rejected', 'icon' => 'bi-x-circle-fill', 'text' => 'Từ chối'],
                                        ];
                                        $status = $statusMap[$app->trang_thai] ?? ['class' => 'pending', 'icon' => 'bi-question-circle', 'text' => 'N/A'];
                                        @endphp

                                        <div class="status-badge {{ $status['class'] }} mb-3">
                                            <i class="bi {{ $status['icon'] }}"></i>
                                            {{ $status['text'] }}
                                        </div>

                                        <div class="d-flex flex-column gap-2">
                                            <a href="{{ route('home') }}#job-{{ $app->job_id }}" class="btn btn-action btn-view">
                                                <i class="bi bi-eye me-2"></i>Xem chi tiết
                                            </a>

                                            @if(in_array($app->trang_thai, ['chua_xem', 'da_xem']))
                                            <button class="btn btn-action btn-cancel cancel-application-btn"
                                                data-application-id="{{ $app->application_id }}"
                                                data-job-title="{{ $app->job->title }}">
                                                <i class="bi bi-x-lg me-2"></i>Hủy ứng tuyển
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <h5>Chưa có công việc nào</h5>
                                <p>Bạn chưa ứng tuyển công việc nào. Hãy tìm và ứng tuyển ngay!</p>
                                <a href="{{ route('home') }}" class="btn-find-jobs">
                                    <i class="bi bi-search me-2"></i>Tìm việc ngay
                                </a>
                            </div>
                            @endif
                        </div>

                        <!-- Tab Đã lưu -->
                        <div class="tab-pane fade" id="saved" role="tabpanel">
                            @if($savedJobs->count() > 0)
                            @foreach($savedJobs as $saved)
                            <div class="job-card-modern">
                                <div class="row align-items-start">
                                    <div class="col-md-2 text-center">
                                        <div class="company-logo-wrapper">
                                            @if($saved->job && $saved->job->company && $saved->job->company->logo)
                                            <img src="{{ asset('storage/' . $saved->job->company->logo) }}" alt="Logo">
                                            @else
                                            <img src="{{ asset('assets/img/company-logo.png') }}" alt="Logo">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <h4 class="job-title">{{ $saved->job->title ?? 'Tiêu đề công việc' }}</h4>
                                        <p class="company-name">{{ $saved->job->company->tencty ?? 'Tên công ty' }}</p>

                                        <span class="salary-badge {{ (!$saved->job->salary_min || !$saved->job->salary_max) ? 'negotiable' : '' }}">
                                            @if($saved->job->salary_min && $saved->job->salary_max)
                                            {{ number_format($saved->job->salary_min, 0, ',', '.') }} -
                                            {{ number_format($saved->job->salary_max, 0, ',', '.') }}
                                            {{ strtoupper($saved->job->salary_type) }}
                                            @else
                                            Thỏa thuận
                                            @endif
                                        </span>

                                        <div class="job-meta">
                                            <div class="job-meta-item">
                                                <i class="bi bi-geo-alt-fill"></i>
                                                <span>{{ $saved->job->province ?? 'N/A' }}</span>
                                            </div>
                                            <div class="job-meta-item">
                                                <i class="bi bi-briefcase-fill"></i>
                                                <span>{{ ucfirst($saved->job->level ?? 'N/A') }}</span>
                                            </div>
                                            <div class="job-meta-item">
                                                <i class="bi bi-award-fill"></i>
                                                <span>{{ $saved->job->experience ?? 'N/A' }}</span>
                                            </div>
                                        </div>

                                        @if($saved->job->hashtags && $saved->job->hashtags->count() > 0)
                                        <div class="job-tags">
                                            @foreach($saved->job->hashtags->take(5) as $tag)
                                            <span class="job-tag">{{ $tag->tag_name }}</span>
                                            @endforeach
                                        </div>
                                        @endif

                                        <div class="timeline-info">
                                            <div>
                                                <i class="bi bi-heart-fill"></i>
                                                <strong>Đã lưu:</strong> {{ \Carbon\Carbon::parse($saved->created_at)->format('d/m/Y H:i') }}
                                            </div>
                                            <div>
                                                <i class="bi bi-clock-history"></i>
                                                <strong>Hạn nộp:</strong> {{ \Carbon\Carbon::parse($saved->job->deadline)->format('d/m/Y') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <div class="d-flex flex-column gap-2">
                                            <a href="{{ route('home') }}#job-{{ $saved->job_id }}" class="btn btn-action btn-view">
                                                <i class="bi bi-eye me-2"></i>Xem chi tiết
                                            </a>

                                            <button class="btn btn-action btn-unsave unsave-job-btn"
                                                data-job-id="{{ $saved->job_id }}"
                                                data-job-title="{{ $saved->job->title }}">
                                                <i class="bi bi-heart-fill me-2"></i>Bỏ lưu
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="empty-state">
                                <i class="bi bi-heart"></i>
                                <h5>Chưa có công việc đã lưu</h5>
                                <p>Bạn chưa lưu công việc nào. Hãy lưu những công việc yêu thích để xem sau!</p>
                                <a href="{{ route('home') }}" class="btn-find-jobs">
                                    <i class="bi bi-search me-2"></i>Tìm việc ngay
                                </a>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>

    @include('applicant.partials.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ========== XỬ LÝ HỦY ỨNG TUYỂN ==========
            const cancelButtons = document.querySelectorAll('.cancel-application-btn');

            cancelButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const applicationId = this.dataset.applicationId;
                    const jobTitle = this.dataset.jobTitle;

                    if (!confirm(`Bạn có chắc muốn hủy đơn ứng tuyển vào vị trí "${jobTitle}"?`)) {
                        return;
                    }

                    // Hiển thị loading
                    const originalHtml = this.innerHTML;
                    this.disabled = true;
                    this.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Đang hủy...';

                    // Gọi API
                    fetch(`/application/${applicationId}/cancel`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message);
                                // Xóa card khỏi DOM
                                this.closest('.job-card-modern').remove();

                                // Cập nhật số lượng badge
                                const badge = document.querySelector('#applied-tab .badge');
                                if (badge) {
                                    const currentCount = parseInt(badge.textContent);
                                    badge.textContent = currentCount - 1;
                                }

                                // Kiểm tra nếu không còn job nào
                                const remainingCards = document.querySelectorAll('#applied .job-card-modern');
                                if (remainingCards.length === 0) {
                                    document.querySelector('#applied').innerHTML = `
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <h5>Chưa có công việc nào</h5>
                            <p>Bạn chưa ứng tuyển công việc nào. Hãy tìm và ứng tuyển ngay!</p>
                            <a href="{{ route('home') }}" class="btn-find-jobs">
                                <i class="bi bi-search me-2"></i>Tìm việc ngay
                            </a>
                        </div>
                    `;
                                }
                            } else {
                                alert(data.message || 'Có lỗi xảy ra!');
                                this.disabled = false;
                                this.innerHTML = originalHtml;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Có lỗi xảy ra khi hủy đơn ứng tuyển!');
                            this.disabled = false;
                            this.innerHTML = originalHtml;
                        });
                });
            });

            // ========== XỬ LÝ BỎ LƯU CÔNG VIỆC ==========
            const unsaveButtons = document.querySelectorAll('.unsave-job-btn');

            unsaveButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const jobId = this.dataset.jobId;
                    const jobTitle = this.dataset.jobTitle;

                    if (!confirm(`Bạn có chắc muốn bỏ lưu công việc "${jobTitle}"?`)) {
                        return;
                    }

                    // Hiển thị loading
                    const originalHtml = this.innerHTML;
                    this.disabled = true;
                    this.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Đang xử lý...';

                    // Gọi API
                    fetch(`/job/unsave/${jobId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message);
                                // Xóa card khỏi DOM
                                this.closest('.job-card-modern').remove();

                                // Cập nhật số lượng badge
                                const badge = document.querySelector('#saved-tab .badge');
                                if (badge) {
                                    const currentCount = parseInt(badge.textContent);
                                    badge.textContent = currentCount - 1;
                                }

                                // Kiểm tra nếu không còn job nào
                                const remainingCards = document.querySelectorAll('#saved .job-card-modern');
                                if (remainingCards.length === 0) {
                                    document.querySelector('#saved').innerHTML = `
                        <div class="empty-state">
                            <i class="bi bi-heart"></i>
                            <h5>Chưa có công việc đã lưu</h5>
                            <p>Bạn chưa lưu công việc nào. Hãy lưu những công việc yêu thích để xem sau!</p>
                            <a href="{{ route('home') }}" class="btn-find-jobs">
                                <i class="bi bi-search me-2"></i>Tìm việc ngay
                            </a>
                        </div>
                    `;
                                }
                            } else {
                                alert(data.message || 'Có lỗi xảy ra!');
                                this.disabled = false;
                                this.innerHTML = originalHtml;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Có lỗi xảy ra khi bỏ lưu công việc!');
                            this.disabled = false;
                            this.innerHTML = originalHtml;
                        });
                });
            });

        });
    </script>
</body>

</html>