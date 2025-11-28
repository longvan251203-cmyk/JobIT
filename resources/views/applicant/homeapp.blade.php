<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-authenticated" content="{{ Auth::check() ? 'true' : 'false' }}">
    <title>Tìm Việc IT Chuyên Nghiệp</title>
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/homeapp.css') }}" rel="stylesheet">
</head>
<style>
    /* ========================================
   LOCATION DETAIL STYLES
======================================== */
    .location-detail-wrapper {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .location-row {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        border-radius: 12px;
        border-left: 4px solid #10b981;
        transition: all 0.3s ease;
    }

    .location-row:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
    }

    .location-row>i {
        font-size: 1.5rem;
        color: #10b981;
        margin-top: 0.25rem;
        flex-shrink: 0;
    }

    .location-info {
        flex: 1;
    }

    .location-label {
        font-size: 0.85rem;
        color: #6b7280;
        font-weight: 600;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .location-value {
        font-size: 1rem;
        color: #1f2937;
        font-weight: 500;
        line-height: 1.5;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .location-row {
            padding: 0.875rem;
        }

        .location-row>i {
            font-size: 1.25rem;
        }

        .location-label {
            font-size: 0.75rem;
        }

        .location-value {
            font-size: 0.9rem;
        }
    }

    /* ========================================
   BADGE SẮP HẾT HẠN - VERSION 2
======================================== */
    .badge-urgent-wrapper {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 15;
    }

    .badge-urgent {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 0.5rem 0.9rem;
        border-radius: 24px;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.3px;
        box-shadow:
            0 4px 12px rgba(245, 158, 11, 0.35),
            0 0 0 3px rgba(245, 158, 11, 0.1);
        animation: badgeGlow 2s ease-in-out infinite;
        white-space: nowrap;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .badge-urgent i {
        font-size: 0.95rem;
        animation: clockTick 1s ease-in-out infinite;
    }

    /* Badge đặc biệt cho "Hết hạn hôm nay" */
    .badge-urgent.badge-today {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        box-shadow:
            0 4px 12px rgba(239, 68, 68, 0.4),
            0 0 0 3px rgba(239, 68, 68, 0.15);
        animation: badgePulseRed 1.5s ease-in-out infinite;
    }

    /* Animation cho badge vàng */
    @keyframes badgeGlow {

        0%,
        100% {
            box-shadow:
                0 4px 12px rgba(245, 158, 11, 0.35),
                0 0 0 3px rgba(245, 158, 11, 0.1);
        }

        50% {
            box-shadow:
                0 6px 20px rgba(245, 158, 11, 0.5),
                0 0 0 5px rgba(245, 158, 11, 0.2);
        }
    }

    /* Animation cho badge đỏ (hết hạn hôm nay) */
    @keyframes badgePulseRed {

        0%,
        100% {
            box-shadow:
                0 4px 12px rgba(239, 68, 68, 0.4),
                0 0 0 3px rgba(239, 68, 68, 0.15);
            transform: scale(1);
        }

        50% {
            box-shadow:
                0 6px 20px rgba(239, 68, 68, 0.6),
                0 0 0 6px rgba(239, 68, 68, 0.25);
            transform: scale(1.03);
        }
    }

    /* Animation cho icon đồng hồ */
    @keyframes clockTick {

        0%,
        100% {
            transform: rotate(0deg);
        }

        25% {
            transform: rotate(-10deg);
        }

        75% {
            transform: rotate(10deg);
        }
    }

    /* Làm nổi bật deadline trong footer khi sắp hết hạn */
    .job-card-grid-footer .deadline-urgent {
        color: #d97706;
        font-weight: 600;
        animation: deadlineHighlight 2s ease-in-out infinite;
    }

    @keyframes deadlineHighlight {

        0%,
        100% {
            color: #d97706;
        }

        50% {
            color: #f59e0b;
        }
    }

    /* Đảm bảo job card có position relative */
    .job-card-grid {
        position: relative;
        /* ... các style khác giữ nguyên ... */
    }

    /* Responsive cho mobile */
    @media (max-width: 768px) {
        .badge-urgent {
            padding: 0.4rem 0.75rem;
            font-size: 0.75rem;
            gap: 0.3rem;
        }

        .badge-urgent i {
            font-size: 0.85rem;
        }

        .badge-urgent-wrapper {
            top: 8px;
            right: 8px;
        }
    }

    @media (max-width: 480px) {
        .badge-urgent {
            padding: 0.35rem 0.65rem;
            font-size: 0.7rem;
        }

        .badge-urgent i {
            font-size: 0.8rem;
        }
    }

    /* Đảm bảo badge không che logo */
    .job-card-grid-header {
        position: relative;
        z-index: 1;
    }

    /* Hiệu ứng khi hover vào card có badge */
    .job-card-grid:hover .badge-urgent {
        transform: translateY(-2px);
        transition: transform 0.3s ease;
    }

    .job-card-grid:hover .badge-urgent.badge-today {
        animation: badgePulseRed 1s ease-in-out infinite;
    }

    /* ========================================
   SEARCH INPUT IMPROVEMENTS
======================================== */
    .search-input-wrapper {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem 1.5rem;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        flex: 1;
    }

    .search-input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 1rem;
        color: #1f2937;
    }

    .search-input::placeholder {
        color: #9ca3af;
    }

    .location-select {
        border: none;
        outline: none;
        font-size: 1rem;
        color: #1f2937;
        background: transparent;
        cursor: pointer;
        min-width: 150px;
    }

    .search-btn {
        padding: 0.875rem 2.5rem;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .search-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
    }

    /* ========================================
   FILTER SECTION IMPROVEMENTS
======================================== */
    .filter-section {
        padding: 1.5rem 0;
        background: #f9fafb;
    }

    .filter-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 0.95rem;
        font-weight: 500;
        color: #374151;
        cursor: pointer;
        transition: all 0.2s;
    }

    .filter-btn:hover {
        border-color: #10b981;
        background: #f0fdf4;
        transform: translateY(-1px);
    }

    .filter-btn.active {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border-color: #10b981;
    }

    .filter-btn.btn-reset {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border-color: #ef4444;
    }

    .filter-btn.btn-reset:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        transform: translateY(-1px);
    }

    /* Badge trên filter button */
    .filter-btn .badge {
        background: #ef4444;
        color: white;
        font-size: 0.75rem;
        padding: 0.15rem 0.5rem;
        border-radius: 10px;
        margin-left: 0.25rem;
        font-weight: 600;
    }

    /* ========================================
   LOADING OVERLAY
======================================== */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(4px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .loading-overlay .spinner {
        width: 60px;
        height: 60px;
        border: 4px solid #e5e7eb;
        border-top-color: #10b981;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    .loading-overlay p {
        margin-top: 1.5rem;
        font-size: 1.1rem;
        font-weight: 600;
        color: #374151;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* ========================================
   JOB EMPTY STATE ENHANCEMENTS
======================================== */
    .job-empty-state .badge.bg-light:hover {
        background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%) !important;
        color: white !important;
        border-color: #667EEA !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    /* ========================================
   RESPONSIVE IMPROVEMENTS
======================================== */
    @media (max-width: 768px) {
        .search-input-wrapper {
            flex-direction: column;
            gap: 0.75rem;
        }

        .location-select {
            width: 100%;
            padding: 0.5rem;
            border-top: 1px solid #e5e7eb;
            padding-top: 0.75rem;
        }

        .search-btn {
            width: 100%;
            padding: 0.875rem 1.5rem;
        }

        .filter-container {
            gap: 0.75rem;
        }

        .filter-btn {
            font-size: 0.875rem;
            padding: 0.65rem 1rem;
        }
    }

    /* ========================================
   SMOOTH TRANSITIONS
======================================== */
    .jobs-grid {
        transition: opacity 0.3s ease;
    }

    .jobs-grid.loading {
        opacity: 0.5;
        pointer-events: none;
    }

    /* ========================================
   HIGHLIGHT SEARCH RESULTS
======================================== */
    .search-highlight {
        background: linear-gradient(120deg, #fef3c7 0%, #fde047 100%);
        padding: 0.1rem 0.3rem;
        border-radius: 4px;
        font-weight: 600;
    }

    /* Filter Dropdown Styles */
    .filter-dropdown-wrapper {
        position: relative;
    }

    .filter-dropdown-menu {
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        background: white;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        padding: 0.5rem;
        min-width: 250px;
        max-height: 400px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
        animation: dropdownFadeIn 0.2s ease;
    }

    .filter-dropdown-menu.show {
        display: block;
    }

    @keyframes dropdownFadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .filter-checkbox-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        cursor: pointer;
        border-radius: 8px;
        transition: background 0.2s;
        margin: 0;
    }

    .filter-checkbox-item:hover {
        background: #f3f4f6;
    }

    .filter-checkbox-item input[type="checkbox"] {
        width: 18px;
        height: 18px;
        margin-right: 0.75rem;
        cursor: pointer;
        accent-color: #10b981;
    }

    .filter-checkbox-item span {
        font-size: 0.95rem;
        color: #1f2937;
    }

    .filter-btn.active {
        background: #10b981;
        color: white;
    }

    .filter-btn.btn-reset {
        background: #ef4444;
        color: white;
    }

    .filter-btn.btn-reset:hover {
        background: #dc2626;
    }

    /* Active filter badge */
    .filter-btn .badge {
        background: #ef4444;
        color: white;
        font-size: 0.75rem;
        padding: 0.15rem 0.5rem;
        border-radius: 10px;
        margin-left: 0.5rem;
    }

    /* Custom scrollbar cho dropdown */
    .filter-dropdown-menu::-webkit-scrollbar {
        width: 6px;
    }

    .filter-dropdown-menu::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .filter-dropdown-menu::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .filter-dropdown-menu::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .btn-apply-now {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        border: none;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        position: relative;
        overflow: hidden;
    }

    .btn-apply-now:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
    }

    .btn-apply-now:active:not(:disabled) {
        transform: translateY(0);
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }

    .btn-apply-now i {
        transition: transform 0.3s ease;
    }

    .btn-apply-now:hover:not(:disabled) i {
        transform: translateX(3px);
    }

    /* ========================================
   NÚT ĐÃ ỨNG TUYỂN - APPLIED STATE
======================================== */
    .btn-apply-now.applied {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        cursor: not-allowed;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        opacity: 0.9;
    }

    .btn-apply-now.applied:hover {
        transform: none;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    }

    .btn-apply-now.applied i {
        animation: checkPulse 1.5s ease-in-out infinite;
    }

    @keyframes checkPulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
    }

    /* ========================================
   NÚT ỨNG TUYỂN TRONG GRID
======================================== */
    .job-card-grid .btn-apply-now {
        padding: 0.6rem 1.2rem;
        font-size: 0.95rem;
    }

    /* ========================================
   NÚT ỨNG TUYỂN TRONG DETAIL VIEW
======================================== */
    .job-detail-actions .btn-apply-now {
        padding: 0.875rem 2rem;
        font-size: 1.05rem;
        min-width: 180px;
        justify-content: center;
    }

    /* ========================================
   LOADING STATE
======================================== */
    .btn-apply-now:disabled:not(.applied) {
        background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%);
        cursor: wait;
        opacity: 0.7;
    }

    .btn-apply-now:disabled:not(.applied) i {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    /* ========================================
   RIPPLE EFFECT KHI CLICK
======================================== */
    .btn-apply-now::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn-apply-now:active:not(:disabled)::before {
        width: 300px;
        height: 300px;
    }

    /* ========================================
   TOOLTIP KHI ĐÃ ỨNG TUYỂN
======================================== */
    .btn-apply-now.applied[title] {
        position: relative;
    }

    .btn-apply-now.applied:hover::after {
        content: attr(title);
        position: absolute;
        bottom: 120%;
        left: 50%;
        transform: translateX(-50%);
        padding: 0.5rem 1rem;
        background: #1f2937;
        color: white;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 8px;
        white-space: nowrap;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        animation: tooltipFadeIn 0.3s ease;
    }

    .btn-apply-now.applied:hover::before {
        content: '';
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        border: 8px solid transparent;
        border-top-color: #1f2937;
        z-index: 1000;
    }

    @keyframes tooltipFadeIn {
        from {
            opacity: 0;
            transform: translateX(-50%) translateY(5px);
        }

        to {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
    }

    /* ========================================
   RESPONSIVE
======================================== */
    @media (max-width: 768px) {
        .btn-apply-now {
            padding: 0.65rem 1.25rem;
            font-size: 0.95rem;
        }

        .job-detail-actions .btn-apply-now {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            min-width: 150px;
        }
    }

    @media (max-width: 480px) {
        .btn-apply-now {
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
        }

        .job-detail-actions .btn-apply-now {
            width: 100%;
            min-width: auto;
        }
    }

    /* ========================================
   SUCCESS STATE (ANIMATION SAU KHI ỨNG TUYỂN)
======================================== */
    @keyframes successPulse {
        0% {
            box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.7);
        }

        50% {
            box-shadow: 0 0 0 10px rgba(99, 102, 241, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(99, 102, 241, 0);
        }
    }

    .btn-apply-now.applied.success-animation {
        animation: successPulse 1s ease-out;
    }

    /* ========================================
   BADGE "MỚI ỨNG TUYỂN"
======================================== */
    .job-card-grid.recently-applied {
        position: relative;
    }

    .job-card-grid.recently-applied::before {
        content: 'Vừa ứng tuyển';
        position: absolute;
        top: 10px;
        right: 10px;
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 10;
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.4);
        animation: badgeFadeIn 0.5s ease;
    }

    @keyframes badgeFadeIn {
        from {
            opacity: 0;
            transform: scale(0.8);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>

<body>
    <header id="header" class="header">
        <div class="header-container">
            <a href="#" class="logo">
                <img src="https://cdn-icons-png.flaticon.com/512/3281/3281289.png" alt="">
                <h1 class="sitename">Job-IT</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#" class="active">Trang chủ</a></li>
                    <li class="dropdown">
                        <a href="#"><span>Việc làm</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="#">Theo khu vực</a></li>
                            <li><a href="#">Theo lĩnh vực</a></li>
                            <li><a href="#">Theo kỹ năng</a></li>
                            <li><a href="#">Theo từ khóa</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#"><span>Công ty</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="#">Theo khu vực</a></li>
                            <li><a href="#">Theo lĩnh vực</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#"><span>Blog</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="#">Cẩm nang tìm việc</a></li>
                            <li><a href="#">Kỹ năng văn phòng</a></li>
                            <li><a href="#">Kiến thức chuyên ngành</a></li>
                            <li><a href="#">Tin tức tổng hợp</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <div class="header-actions">
                @if(!Auth::check())
                <a class="btn-login" href="{{ route('login') }}">Đăng nhập</a>
                @else
                <!-- ✅ Nút Việc Làm Của Tôi -->
                <a class="btn-my-jobs" href="{{ route('applicant.myJobs') }}">
                    <i class="bi bi-briefcase-fill"></i>
                    Việc Làm Của Tôi
                </a>
                <div class="user-dropdown">
                    <button class="user-btn" id="userDropdownBtn">
                        <img src="{{ asset('assets/img/user.png') }}" alt="" class="user-avatar">
                        <span class="user-name">{{ Auth::user()->applicant->hoten_uv ?? Auth::user()->email }}</span>
                        <i class="bi bi-chevron-down"></i>
                    </button>
                    <ul class="user-dropdown-menu" id="userDropdownMenu">
                        <li><a href="{{ route('applicant.profile') }}"><i class="bi bi-person"></i> Hồ sơ</a></li>
                        <li><a href="#"><i class="bi bi-info-circle"></i> Thông tin cá nhân</a></li>
                        <li><a href="#"><i class="bi bi-file-earmark-text"></i> Hồ sơ Đính kèm</a></li>
                        <li><a href="{{ route('applicant.myJobs') }}"><i class="bi bi-briefcase"></i> Việc làm của tôi</a></li>
                        <li><a href="#"><i class="bi bi-envelope"></i> Lời mời công việc</a></li>
                        <li><a href="#"><i class="bi bi-bell"></i> Thông báo</a></li>
                        <li class="divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="logout-btn">
                                    <i class="bi bi-box-arrow-right"></i> Đăng xuất
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </header>
    <!-- Search Section -->
    <!-- Search Section - Cập nhật -->
    <section class="search-section">
        <div class="search-container">
            <div class="search-box">
                <div class="search-input-wrapper">
                    <i class="bi bi-search" style="color: #A0AEC0; font-size: 1.2rem;"></i>
                    <input type="text" id="searchInput" class="search-input"
                        placeholder="Tìm theo kỹ năng, vị trí, công ty...">
                    <i class="bi bi-geo-alt" style="color: #A0AEC0; font-size: 1.2rem;"></i>
                    <select id="locationSelect" class="location-select">
                        <option value="">Tất cả địa điểm</option>
                        <option value="hanoi">Hà Nội</option>
                        <option value="hcm">TP. Hồ Chí Minh</option>
                        <option value="danang">Đà Nẵng</option>
                        <option value="cantho">Cần Thơ</option>
                        <option value="haiphong">Hải Phòng</option>
                        <option value="binhduong">Bình Dương</option>
                        <option value="dongnai">Đồng Nai</option>
                        <option value="remote">Remote</option>
                    </select>
                </div>
                <button class="search-btn" id="searchBtn">Tìm kiếm</button>
            </div>
        </div>
    </section>
    <!-- Filter Section - Nâng cao -->
    <section class="filter-section">
        <div class="filter-container">
            <!-- Dropdown Danh mục -->
            <div class="filter-dropdown-wrapper">
                <button class="filter-btn" id="categoryFilterBtn">
                    <i class="bi bi-folder"></i>
                    <span>Tất cả danh mục</span>
                    <i class="bi bi-chevron-down ms-2"></i>
                </button>
                <div class="filter-dropdown-menu" id="categoryDropdown">
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="category" value="all" checked>
                        <span>Tất cả</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="category" value="backend">
                        <span>Backend Developer</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="category" value="frontend">
                        <span>Frontend Developer</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="category" value="fullstack">
                        <span>Fullstack Developer</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="category" value="mobile">
                        <span>Mobile Developer</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="category" value="devops">
                        <span>DevOps Engineer</span>
                    </label>
                </div>
            </div>

            <!-- Dropdown Cấp bậc -->
            <div class="filter-dropdown-wrapper">
                <button class="filter-btn" id="levelFilterBtn">
                    <i class="bi bi-bar-chart"></i>
                    <span>Cấp bậc</span>
                    <i class="bi bi-chevron-down ms-2"></i>
                </button>
                <div class="filter-dropdown-menu" id="levelDropdown">
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="level" value="intern">
                        <span>Thực tập sinh</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="level" value="fresher">
                        <span>Fresher</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="level" value="junior">
                        <span>Junior</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="level" value="middle">
                        <span>Middle</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="level" value="senior">
                        <span>Senior</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="level" value="leader">
                        <span>Leader</span>
                    </label>
                </div>
            </div>

            <!-- Dropdown Kinh nghiệm -->
            <div class="filter-dropdown-wrapper">
                <button class="filter-btn" id="experienceFilterBtn">
                    <i class="bi bi-award"></i>
                    <span>Kinh nghiệm</span>
                    <i class="bi bi-chevron-down ms-2"></i>
                </button>
                <div class="filter-dropdown-menu" id="experienceDropdown">
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="experience" value="no_experience">
                        <span>Không yêu cầu</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="experience" value="under_1">
                        <span>Dưới 1 năm</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="experience" value="1_2">
                        <span>1-2 năm</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="experience" value="2_5">
                        <span>2-5 năm</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="experience" value="5_plus">
                        <span>Trên 5 năm</span>
                    </label>
                </div>
            </div>

            <!-- Dropdown Hình thức làm việc -->
            <div class="filter-dropdown-wrapper">
                <button class="filter-btn" id="workingTypeFilterBtn">
                    <i class="bi bi-briefcase"></i>
                    <span>Hình thức</span>
                    <i class="bi bi-chevron-down ms-2"></i>
                </button>
                <div class="filter-dropdown-menu" id="workingTypeDropdown">
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="working_type" value="full_time">
                        <span>Toàn thời gian</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="working_type" value="part_time">
                        <span>Bán thời gian</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="working_type" value="remote">
                        <span>Remote</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="working_type" value="freelance">
                        <span>Freelance</span>
                    </label>
                </div>
            </div>

            <!-- Nút Reset -->
            <button class="filter-btn btn-reset" id="resetFiltersBtn">
                <i class="bi bi-arrow-clockwise"></i>
                Đặt lại
            </button>
        </div>
    </section>
    <!-- ========== OVERVIEW SECTION ========== tổng quan -->
    <section class="overview-section">
        <div class="main-container">
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="overview-card">
                        <div class="overview-number">{{ $stats['total_jobs'] }}</div>
                        <div class="overview-label">Công việc IT</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="overview-card">
                        <div class="overview-number">{{ $stats['total_companies'] }}</div>
                        <div class="overview-label">Công ty hàng đầu</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="overview-card">
                        <div class="overview-number">15,000+</div>
                        <div class="overview-label">Ứng viên đã tìm việc</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="overview-card">
                        <div class="overview-number">98%</div>
                        <div class="overview-label">Tỷ lệ hài lòng</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== ALL JOBS SECTION ========== -->
    <div class="main-container">
        <div class="featured-section">
            <div class="section-title-highlight">
                <div class="section-subtitle">TẤT CẢ CÔNG VIỆC</div>
                <h2>{{ $stats['total_jobs'] }} cơ hội việc làm IT</h2>
            </div>

            <!-- ✅ Loading Overlay -->
            <div class="loading-overlay" id="jobsLoadingOverlay" style="display: none;">
                <div class="spinner"></div>
                <p>Đang tải việc làm...</p>
            </div>

            <!-- ✅ Grid View - Default -->
            <div class="grid-view jobs-grid" id="gridView">
                @include('applicant.partials.job-cards', ['jobs' => $jobs])
            </div>

            <!-- ✅ Detail View - 2 Columns (MỚI THÊM) -->
            <div class="detail-view" id="detailView">
                <div>
                    <button class="back-to-grid" id="backToGrid">
                        <i class="bi bi-arrow-left"></i>
                        Quay lại danh sách
                    </button>

                    <!-- Left Column - Job List -->
                    <div class="job-list-column" id="jobListColumn">
                        @foreach($jobs as $job)
                        <article class="job-card" data-job-id="{{ $job->job_id }}">
                            <div class="job-card-header">
                                <div class="company-logo-small">
                                    @if($job->company && $job->company->logo)
                                    <img src="{{ asset('assets/img/' . $job->company->logo) }}" alt="Company Logo" />
                                    @else
                                    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667EEA, #764BA2); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                        {{ substr($job->company->tencty ?? 'C', 0, 1) }}
                                    </div>
                                    @endif
                                </div>

                                <div class="job-card-info">
                                    <h3 class="job-card-title">{{ $job->title }}</h3>
                                    <div class="company-name-small">{{ $job->company->tencty ?? 'Công ty' }}</div>
                                    <span class="job-card-salary {{ (!$job->salary_min || !$job->salary_max) ? 'negotiable' : '' }}">
                                        @if($job->salary_min && $job->salary_max)
                                        {{ number_format($job->salary_min, 0, ',', '.') }} - {{ number_format($job->salary_max, 0, ',', '.') }} {{ strtoupper($job->salary_type) }}
                                        @else
                                        Thỏa thuận
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="job-card-meta">
                                <div class="job-card-meta-item">
                                    <i class="bi bi-geo-alt"></i>
                                    {{ $job->province }}
                                </div>
                                <div class="job-card-meta-item">
                                    <i class="bi bi-briefcase"></i>
                                    {{ ucfirst($job->level) }}
                                </div>
                                <div class="job-card-meta-item">
                                    <i class="bi bi-award"></i>
                                    {{ $job->experience_label }}
                                </div>
                            </div>

                            @if($job->hashtags && $job->hashtags->count() > 0)
                            <div class="job-card-tags">
                                @foreach($job->hashtags->take(3) as $tag)
                                <span class="job-card-tag">{{ $tag->tag_name }}</span>
                                @endforeach
                            </div>
                            @endif

                            <div class="job-card-footer">
                                <div class="job-card-deadline">
                                    <i class="bi bi-clock-history"></i>
                                    Hạn nộp: {{ \Carbon\Carbon::parse($job->deadline)->format('d/m/Y') }}
                                </div>
                                <button class="save-btn-small" title="Lưu công việc">
                                    <i class="bi bi-heart" style="font-size: 1.1rem;"></i>
                                </button>
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>

                <!-- Right Column - Job Detail -->
                <div class="job-detail-column" id="jobDetailColumn">
                    <div class="job-detail-empty">
                        <i class="bi bi-briefcase"></i>
                        <p>Chọn một công việc để xem chi tiết</p>
                    </div>
                </div>
            </div>

            <!-- ✅ Custom Pagination -->
            <div class="pagination-wrapper" id="paginationWrapper">
                @if($jobs->lastPage() > 1)
                <nav class="custom-pagination">
                    <ul class="pagination">
                        <!-- Previous Button -->
                        <li class="page-item {{ $jobs->currentPage() == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="#" data-page="{{ $jobs->currentPage() - 1 }}" {{ $jobs->currentPage() == 1 ? 'tabindex="-1"' : '' }}>
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>

                        <!-- Page Numbers -->
                        @php
                        $start = max(1, $jobs->currentPage() - 2);
                        $end = min($jobs->lastPage(), $jobs->currentPage() + 2);
                        @endphp

                        @if($start > 1)
                        <li class="page-item">
                            <a class="page-link" href="#" data-page="1">1</a>
                        </li>
                        @if($start > 2)
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                        @endif
                        @endif

                        @for($i = $start; $i <= $end; $i++)
                            <li class="page-item {{ $i == $jobs->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="#" data-page="{{ $i }}">{{ $i }}</a>
                            </li>
                            @endfor

                            @if($end < $jobs->lastPage())
                                @if($end < $jobs->lastPage() - 1)
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link" href="#" data-page="{{ $jobs->lastPage() }}">{{ $jobs->lastPage() }}</a>
                                    </li>
                                    @endif

                                    <!-- Next Button -->
                                    <li class="page-item {{ $jobs->currentPage() == $jobs->lastPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="#" data-page="{{ $jobs->currentPage() + 1 }}" {{ $jobs->currentPage() == $jobs->lastPage() ? 'tabindex="-1"' : '' }}>
                                            <i class="bi bi-chevron-right"></i>
                                        </a>
                                    </li>
                    </ul>
                </nav>
                @endif
            </div>
        </div>
    </div>
    <!-- ========== TOP COMPANIES SECTION ========== -->
    <div class="main-container">
        <div class="featured-section">
            <div class="section-title-highlight">
                <div class="section-subtitle">TOP CÔNG TY</div>
                <h2>Nhà tuyển dụng hàng đầu</h2>
            </div>

            <div class="companies-grid">
                @forelse($topCompanies as $item)
                <a href="{{ route('company.profile', $item['company']->companies_id) }}" class="company-card">
                    <div class="company-card-logo">
                        @if($item['company']->logo)
                        <img src="{{ asset('assets/img/' . $item['company']->logo) }}" alt="{{ $item['company']->tencty }}">
                        @else
                        <div class="default-company-logo">{{ substr($item['company']->tencty, 0, 1) }}</div>
                        @endif
                    </div>
                    <div class="company-card-info">
                        <h3 class="company-card-name">{{ $item['company']->tencty }}</h3>
                        <div class="company-card-meta">
                            <i class="bi bi-briefcase"></i>
                            <span>{{ $item['job_count'] }} việc làm</span>
                        </div>
                        @if($item['company']->diachi)
                        <div class="company-card-location">
                            <i class="bi bi-geo-alt"></i>
                            <span>{{ Str::limit($item['company']->diachi, 40) }}</span>
                        </div>
                        @endif
                    </div>
                </a>
                @empty
                <p class="text-muted text-center col-12">Không có công ty nào</p>
                @endforelse
            </div>
        </div>
    </div>
    <!-- ========== BLOG SECTION ========== -->
    <div class="main-container">
        <div class="featured-section">
            <div class="section-title-highlight">
                <div class="section-subtitle">BLOG</div>
                <h2>Tin tức & Kiến thức IT</h2>
                <p style="color: #718096; margin-top: 0.5rem;">Cập nhật xu hướng công nghệ và cơ hội nghề nghiệp</p>
            </div>

            <div class="row g-4">
                <!-- Blog Card 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <div class="blog-image">
                            <img src="https://via.placeholder.com/400x220/6366F1/FFFFFF?text=AI+Trends" alt="Blog">
                            <div class="blog-badge">Technology</div>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span><i class="bi bi-person"></i> Admin</span>
                                <span><i class="bi bi-calendar"></i> 15/12/2024</span>
                            </div>
                            <h3 class="blog-title">Xu hướng AI và Machine Learning năm 2025</h3>
                            <p class="blog-excerpt">Khám phá những công nghệ AI mới nhất và cơ hội nghề nghiệp trong lĩnh vực này...</p>
                            <a href="#" class="btn-read">Đọc thêm <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Blog Card 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <div class="blog-image">
                            <img src="https://via.placeholder.com/400x220/10B981/FFFFFF?text=Career+Guide" alt="Blog">
                            <div class="blog-badge">Career</div>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span><i class="bi bi-person"></i> Admin</span>
                                <span><i class="bi bi-calendar"></i> 12/12/2024</span>
                            </div>
                            <h3 class="blog-title">10 kỹ năng IT cần thiết cho năm 2025</h3>
                            <p class="blog-excerpt">Danh sách các kỹ năng lập trình và công nghệ được các nhà tuyển dụng săn đón nhất...</p>
                            <a href="#" class="btn-read">Đọc thêm <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Blog Card 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <div class="blog-image">
                            <img src="https://via.placeholder.com/400x220/F59E0B/FFFFFF?text=Interview+Tips" alt="Blog">
                            <div class="blog-badge">Tips</div>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span><i class="bi bi-person"></i> Admin</span>
                                <span><i class="bi bi-calendar"></i> 10/12/2024</span>
                            </div>
                            <h3 class="blog-title">Bí quyết phỏng vấn thành công cho IT</h3>
                            <p class="blog-excerpt">Những câu hỏi phỏng vấn phổ biến và cách trả lời ấn tượng để chinh phục nhà tuyển dụng...</p>
                            <a href="#" class="btn-read">Đọc thêm <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Modal Ứng Tuyển -->
    <div class="modal fade modal-apply-job" id="applyJobModal" tabindex="-1" aria-labelledby="applyJobModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applyJobModalLabel">
                        <i class="bi bi-send-fill me-2"></i>Ứng tuyển công việc
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="applyJobForm" action="{{ route('application.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <!-- Step 1: Chọn cách ứng tuyển -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-file-earmark-person me-2 text-primary"></i>Chọn CV Để ứng tuyển <span class="required-mark">*</span>
                            </h6>
                            <div class="row g-3">
                                <!-- Option 1: Upload CV -->
                                <div class="col-md-6">
                                    <label class="cv-option-card active" id="uploadOption">
                                        <input type="radio" name="cv_type" value="upload" checked>
                                        <div class="cv-option-icon">
                                            <i class="bi bi-cloud-upload"></i>
                                        </div>
                                        <div class="cv-option-title">Tải lên CV từ máy tính</div>
                                        <div class="cv-option-desc">Hỗ trợ định dạng .doc, .docx, .pdf dưới 5MB</div>
                                    </label>
                                </div>

                                <!-- Option 2: Use Profile -->
                                <div class="col-md-6">
                                    <label class="cv-option-card" id="profileOption">
                                        <input type="radio" name="cv_type" value="profile">
                                        <div class="cv-option-icon">
                                            <i class="bi bi-person-badge"></i>
                                        </div>
                                        <div class="cv-option-title">Sử dụng hồ sơ có sẵn</div>
                                        <div class="cv-option-desc">Dùng thông tin từ hồ sơ đã tạo trên hệ thống</div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Upload CV Section -->
                        <div id="uploadSection" class="content-section mb-4">
                            <div class="upload-area" id="uploadArea">
                                <div class="upload-icon">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Kéo thả CV vào đây hoặc chọn file</h6>
                                <p class="text-muted small mb-3">Hỗ trợ .doc, .docx, .pdf (tối đa 5MB)</p>
                                <input type="file" id="cvFileInput" name="cv_file" accept=".doc,.docx,.pdf" class="d-none">
                                <button type="button" class="btn btn-outline-primary" id="selectFileBtn">
                                    <i class="bi bi-folder2-open me-2"></i>Chọn file
                                </button>
                            </div>
                            <div id="fileNameDisplay" class="mt-3 text-center" style="display: none;">
                                <div class="alert alert-success d-inline-flex align-items-center">
                                    <i class="bi bi-file-earmark-check me-2"></i>
                                    <span id="fileName"></span>
                                    <button type="button" class="btn-close ms-3" id="removeFile"></button>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Preview Section -->
                        <div id="profileSection" class="content-section mb-4" style="display: none;">
                            <div class="profile-preview-card">
                                <div class="d-flex align-items-start">
                                    @php
                                    $applicant = Auth::user()->applicant ?? null;
                                    @endphp
                                    <img src="{{ $applicant && $applicant->avatar ? asset('assets/img/avt/'.$applicant->avatar) : asset('assets/img/avt/default-avatar.png') }}"
                                        alt="Avatar" class="profile-avatar">
                                    <div class="profile-info flex-grow-1">
                                        <div class="profile-name">{{ $applicant->hoten_uv ?? 'Họ tên ứng viên' }}</div>
                                        <div class="profile-title">{{ $applicant->chucdanh ?? 'Chức danh' }}</div>
                                        <div class="profile-contact">
                                            <div class="contact-item">
                                                <i class="bi bi-envelope"></i>
                                                <span>{{ Auth::user()->email ?? 'Email' }}</span>
                                            </div>
                                            <div class="contact-item">
                                                <i class="bi bi-telephone"></i>
                                                <span>{{ $applicant->sdt_uv ?? 'Chưa cập nhật' }}</span>
                                            </div>
                                            <div class="contact-item">
                                                <i class="bi bi-geo-alt"></i>
                                                <span>{{ $applicant->diachi_uv ?? 'Chưa cập nhật' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('applicant.hoso') }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                            <i class="bi bi-pencil me-1"></i>Chỉnh sửa
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Thông tin bổ sung -->
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-card-text me-2 text-primary"></i>Thông tin bổ sung
                        </h6>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Họ và tên <span class="required-mark">*</span></label>
                                <input type="text" name="hoten" class="form-control" placeholder="Họ tên hiển thị với NTD"
                                    value="{{ $applicant->hoten_uv ?? '' }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="required-mark">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="Email hiển thị với NTD"
                                    value="{{ Auth::user()->email ?? '' }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Số Điện thoại <span class="required-mark">*</span></label>
                                <input type="tel" name="sdt" class="form-control" placeholder="Số điện thoại hiển thị với NTD"
                                    value="{{ $applicant->sdt_uv ?? '' }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Địa chỉ</label>
                                <input type="text" name="diachi" class="form-control" placeholder="Địa chỉ của bạn"
                                    value="{{ $applicant->diachi_uv ?? '' }}">
                            </div>
                        </div>

                        <!-- Thư giới thiệu -->
                        <div class="mb-4">
                            <label class="form-label d-flex align-items-center gap-2">
                                <i class="bi bi-pencil-square text-success" style="font-size: 1.2rem;"></i>
                                <span style="font-size: 1.05rem; font-weight: 600; color: #1f2937;">Thư giới thiệu:</span>
                            </label>
                            <p class="text-muted mb-3" style="font-size: 0.95rem; line-height: 1.6;">
                                Một thư giới thiệu ngắn gọn, chỉn chu sẽ giúp bạn trở nên chuyên nghiệp và gây ấn tượng hơn với nhà tuyển dụng.
                            </p>
                            <textarea name="thugioithieu" class="form-control letter-textarea" maxlength="2500"
                                placeholder="Viết giới thiệu ngắn gọn về bản thân (Điểm mạnh, điểm yếu) và nêu rõ mong muốn, lý do bạn muốn ứng tuyển cho vị trí này."
                                style="border: 2px solid #10b981; border-radius: 12px;"></textarea>
                            <div class="char-count">
                                <span id="charCount">0</span>/2500 ký tự
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 p-4">
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg me-2"></i>Hủy
                        </button>
                        <button type="submit" class="btn btn-primary btn-submit-apply">
                            <i class="bi bi-send-fill me-2"></i>Nộp hồ sơ ứng tuyển
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div style="max-width: 1400px; margin: 0 auto; padding: 0 1rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <p style="color: #718096;">© 2025 Tìm Việc IT. Giao diện chuyên nghiệp, hiện đại, dễ sử dụng.</p>
            <div style="display: flex; gap: 1.5rem;">
                <a href="#">Điều khoản</a>
                <a href="#">Chính sách</a>
                <a href="#">Liên hệ</a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ✅ THÊM HÀM NÀY NGAY ĐẦU
            function getExperienceLabel(code) {
                const labels = {
                    'no_experience': 'Không yêu cầu',
                    'under_1': 'Dưới 1 năm',
                    '1_2': '1-2 năm',
                    '2_5': '2-5 năm',
                    '5_plus': 'Trên 5 năm'
                };
                return labels[code] || code;
            }
            // ========== BIẾN GLOBAL ==========
            const gridView = document.getElementById('gridView');
            const detailView = document.getElementById('detailView');
            const backToGridBtn = document.getElementById('backToGrid');
            const jobDetailColumn = document.getElementById('jobDetailColumn');
            const jobListColumn = document.getElementById('jobListColumn');
            const loadingOverlay = document.getElementById('jobsLoadingOverlay');
            const paginationWrapper = document.getElementById('paginationWrapper');

            // ========== XỬ LÝ USER DROPDOWN ==========
            const userDropdownBtn = document.getElementById('userDropdownBtn');
            const userDropdown = document.querySelector('.user-dropdown');

            if (userDropdownBtn) {
                userDropdownBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userDropdown.classList.toggle('active');
                });

                document.addEventListener('click', function(e) {
                    if (!userDropdown.contains(e.target)) {
                        userDropdown.classList.remove('active');
                    }
                });
            }

            // ========== TOAST NOTIFICATION ==========
            function showToast(message, type = 'success') {
                const oldToast = document.querySelector('.custom-toast');
                if (oldToast) oldToast.remove();

                const toast = document.createElement('div');
                toast.className = 'custom-toast';

                const bgColor = type === 'success' ? '#10b981' :
                    type === 'error' ? '#ef4444' :
                    type === 'info' ? '#3b82f6' : '#6b7280';

                const icon = type === 'success' ? 'bi-check-circle-fill' :
                    type === 'error' ? 'bi-x-circle-fill' :
                    type === 'info' ? 'bi-info-circle-fill' : 'bi-heart-fill';

                toast.style.cssText = `
            position: fixed; top: 80px; right: 20px;
            background: ${bgColor}; color: white;
            padding: 1rem 1.5rem; border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.25);
            z-index: 9999; animation: slideIn 0.3s ease;
            display: flex; align-items: center; gap: 0.75rem;
            font-weight: 500; min-width: 280px;
        `;

                toast.innerHTML = `<i class="bi ${icon}" style="font-size: 1.2rem;"></i><span>${message}</span>`;
                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.style.animation = 'slideOut 0.3s ease';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }

            if (!document.getElementById('toast-animations')) {
                const style = document.createElement('style');
                style.id = 'toast-animations';
                style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(400px); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(400px); opacity: 0; }
            }
        `;
                document.head.appendChild(style);
            }

            // ========== KIỂM TRA ĐĂNG NHẬP ==========
            function checkAuth() {
                const isLoggedIn = document.querySelector('meta[name="user-authenticated"]');
                return isLoggedIn && isLoggedIn.content === 'true';
            }

            // ========== CẬP NHẬT NÚT ỨNG TUYỂN ==========
            function updateApplyButton(button, hasApplied) {
                if (!button) return;

                const icon = button.querySelector('i');

                if (hasApplied) {
                    button.classList.add('applied');
                    button.disabled = true;
                    button.title = 'Bạn đã ứng tuyển công việc này';

                    if (icon) {
                        icon.classList.remove('bi-send-fill');
                        icon.classList.add('bi-check-circle-fill');
                    }

                    // ✅ FIX: Xóa toàn bộ text nodes và tạo mới
                    button.childNodes.forEach(node => {
                        if (node.nodeType === Node.TEXT_NODE) {
                            node.remove();
                        }
                    });
                    button.appendChild(document.createTextNode('Đã ứng tuyển'));

                } else {
                    button.classList.remove('applied');
                    button.disabled = false;
                    button.title = 'Ứng tuyển ngay';

                    if (icon) {
                        icon.classList.remove('bi-check-circle-fill');
                        icon.classList.add('bi-send-fill');
                    }

                    // ✅ FIX: Xóa toàn bộ text nodes và tạo mới
                    button.childNodes.forEach(node => {
                        if (node.nodeType === Node.TEXT_NODE) {
                            node.remove();
                        }
                    });
                    button.appendChild(document.createTextNode('Ứng tuyển ngay'));
                }
            }

            // ========== ĐỒNG BỘ NÚT ỨNG TUYỂN ==========
            function syncApplyButtons(jobId, hasApplied) {
                // Grid view
                const gridCard = document.querySelector(`.job-card-grid[data-job-id="${jobId}"]`);
                if (gridCard) {
                    const gridBtn = gridCard.querySelector('.btn-apply-now');
                    if (gridBtn) updateApplyButton(gridBtn, hasApplied);
                }

                // Detail view
                const detailBtn = document.querySelector(`.btn-apply-now[data-job-id="${jobId}"]`);
                if (detailBtn) updateApplyButton(detailBtn, hasApplied);
            }

            // ========== LOAD TRẠNG THÁI ĐÃ ỨNG TUYỂN ==========
            function loadAppliedJobs() {
                if (!checkAuth()) return;

                fetch('/api/applied-jobs', {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.appliedJobIds && data.appliedJobIds.length > 0) {
                            data.appliedJobIds.forEach(jobId => {
                                syncApplyButtons(jobId, true);
                            });
                        }
                    })
                    .catch(error => console.error('Error loading applied jobs:', error));
            }

            // ========== KIỂM TRA TRẠNG THÁI ỨNG TUYỂN CHO 1 JOB ==========
            function checkApplicationStatus(jobId) {
                if (!checkAuth()) return;

                fetch(`/api/jobs/${jobId}/check-application`, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            syncApplyButtons(jobId, data.applied);
                        }
                    })
                    .catch(error => console.error('Error checking application status:', error));
            }

            // ========== CẬP NHẬT TRẠNG THÁI NÚT SAVE ==========
            function updateSaveButton(button, isSaved) {
                const icon = button.querySelector('i');
                if (isSaved) {
                    button.classList.add('saved');
                    if (icon) {
                        icon.classList.remove('bi-heart');
                        icon.classList.add('bi-heart-fill');
                    }
                } else {
                    button.classList.remove('saved');
                    if (icon) {
                        icon.classList.remove('bi-heart-fill');
                        icon.classList.add('bi-heart');
                    }
                }
            }

            // ========== ĐỒNG BỘ NÚT SAVE ==========
            function syncSaveButtons(jobId, isSaved) {
                const gridCard = document.querySelector(`.job-card-grid[data-job-id="${jobId}"]`);
                if (gridCard) {
                    const gridBtn = gridCard.querySelector('.save-btn-grid');
                    if (gridBtn) updateSaveButton(gridBtn, isSaved);
                }

                const listCard = document.querySelector(`.job-card[data-job-id="${jobId}"]`);
                if (listCard) {
                    const listBtn = listCard.querySelector('.save-btn-small');
                    if (listBtn) updateSaveButton(listBtn, isSaved);
                }

                const largeBtn = document.querySelector(`.save-btn-large[data-job-id="${jobId}"]`);
                if (largeBtn) updateSaveButton(largeBtn, isSaved);
            }

            // ========== XỬ LÝ SAVE/UNSAVE JOB ==========
            function handleSaveJob(jobId, isSaved, button) {
                if (!checkAuth()) {
                    showToast('Vui lòng đăng nhập để lưu công việc!', 'error');
                    setTimeout(() => window.location.href = '/login', 1500);
                    return;
                }

                button.disabled = true;

                const url = isSaved ? `/job/unsave/${jobId}` : `/job/save/${jobId}`;
                const method = isSaved ? 'DELETE' : 'POST';

                fetch(url, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            syncSaveButtons(jobId, !isSaved);
                            showToast(data.message, isSaved ? 'info' : 'success');
                        } else {
                            showToast(data.message || 'Có lỗi xảy ra!', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Có lỗi xảy ra khi lưu công việc!', 'error');
                    })
                    .finally(() => {
                        button.disabled = false;
                    });
            }

            // ========== LOAD TRẠNG THÁI ĐÃ LƯU ==========
            function loadSavedJobs() {
                if (!checkAuth()) return;

                fetch('/api/saved-jobs', {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.savedJobIds) {
                            data.savedJobIds.forEach(jobId => {
                                syncSaveButtons(jobId, true);
                            });
                        }
                    })
                    .catch(error => console.error('Error loading saved jobs:', error));
            }

            // ========== SWITCH BETWEEN GRID AND DETAIL VIEW ==========
            function showGridView() {
                if (gridView && detailView) {
                    gridView.classList.remove('hidden');
                    detailView.classList.remove('active');
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            }

            function showDetailView(jobId) {
                if (gridView && detailView) {
                    gridView.classList.add('hidden');
                    detailView.classList.add('active');
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });

                    setTimeout(() => {
                        document.querySelectorAll('.job-card').forEach(card => {
                            card.classList.remove('active');
                            if (card.getAttribute('data-job-id') == jobId) {
                                card.classList.add('active');
                                card.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'nearest'
                                });
                            }
                        });
                        loadJobDetail(jobId);
                    }, 0);
                }
            }

            // ========== LOAD JOB DETAIL ==========
            function loadJobDetail(jobId) {
                if (!jobDetailColumn) return;

                jobDetailColumn.innerHTML = `
            <div class="job-detail-empty">
                <i class="bi bi-hourglass-split"></i>
                <p>Đang tải thông tin...</p>
            </div>
        `;

                fetch(`/api/jobs/${jobId}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(job => {
                        renderJobDetail(job);
                        checkApplicationStatus(jobId);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        jobDetailColumn.innerHTML = `
                <div class="job-detail-empty">
                    <i class="bi bi-exclamation-circle"></i>
                    <p>Không thể tải thông tin công việc</p>
                </div>
            `;
                    });
            }

            // ========== RENDER JOB DETAIL ==========
            function renderJobDetail(job) {
                const formatMoney = (num) => new Intl.NumberFormat('vi-VN').format(num);

                let salaryHtml = '';
                let salaryClass = '';
                if (job.salary_min && job.salary_max) {
                    salaryHtml = `${formatMoney(job.salary_min)} - ${formatMoney(job.salary_max)} ${job.salary_type.toUpperCase()}`;
                } else {
                    salaryHtml = 'Thỏa thuận';
                    salaryClass = 'negotiable';
                }

                const deadline = new Date(job.deadline).toLocaleDateString('vi-VN');

                const logoHtml = job.company && job.company.logo ?
                    `<img src="/assets/img/${job.company.logo}" alt="Company Logo">` :
                    `<div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667EEA, #764BA2); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; font-weight: bold;">${job.company ? job.company.tencty.charAt(0) : 'C'}</div>`;

                const hashtagsHtml = job.hashtags && job.hashtags.length > 0 ?
                    job.hashtags.map(tag => `<span class="tag-item">${tag.tag_name}</span>`).join('') :
                    '<p class="text-muted">Không có thông tin</p>';

                jobDetailColumn.innerHTML = `
            <div class="job-detail-header">
                <div class="job-detail-company">
                    <div class="company-logo-large">${logoHtml}</div>
                  <div class="job-detail-title-section">
    <h2 class="job-detail-title">
        <a href="/job-detail/${job.job_id}" class="text-decoration-none text-dark hover-link-primary">
            ${job.title}
        </a>
    </h2>
    <div class="job-detail-company-name">${job.company ? job.company.tencty : 'Công ty'}</div>
    <span class="job-detail-salary ${salaryClass}">${salaryHtml}</span>
</div>
                </div>
                <div class="job-detail-actions">
                    <button type="button" class="btn-apply-now" data-job-id="${job.job_id}">
                        <i class="bi bi-send-fill me-2"></i>Ứng tuyển ngay
                    </button>
                    <button class="save-btn-large" title="Lưu công việc" data-job-id="${job.job_id}">
                        <i class="bi bi-heart" style="font-size: 1.2rem;"></i>
                    </button>
                </div>
            </div>
            <div class="job-detail-content">
                <div class="detail-section">
                    <h3 class="detail-section-title"><i class="bi bi-info-circle-fill"></i> Thông tin chung</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label"><i class="bi bi-briefcase"></i> Cấp bậc</div>
                            <div class="info-value">${job.level}</div>
                        </div>
                       <div class="info-item">
    <div class="info-label"><i class="bi bi-award"></i> Kinh nghiệm</div>
    <div class="info-value">${getExperienceLabel(job.experience)}</div>
</div>
                        <div class="info-item">
                            <div class="info-label"><i class="bi bi-people"></i> Số lượng tuyển</div>
                            <div class="info-value">${job.recruitment_count || 'Không giới hạn'}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="bi bi-clock-history"></i> Hạn nộp hồ sơ</div>
                            <div class="info-value" style="color: #EF4444;">${deadline}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="bi bi-laptop"></i> Hình thức làm việc</div>
                            <div class="info-value">${job.working_type}</div>
                        </div>
                    </div>
                </div>
               <div class="detail-section">
    <h3 class="detail-section-title">
        <i class="bi bi-geo-alt-fill"></i> Địa điểm làm việc
    </h3>
    <div class="location-detail-wrapper">
        <div class="location-row">
            <i class="bi bi-building"></i>
            <div class="location-info">
                <div class="location-label">Tỉnh/Thành phố</div>
                <div class="location-value">${job.province || 'Chưa cập nhật'}</div>
            </div>
        </div>
        ${job.district ? `
        <div class="location-row">
            <i class="bi bi-map"></i>
            <div class="location-info">
                <div class="location-label">Quận/Huyện</div>
                <div class="location-value">${job.district}</div>
            </div>
        </div>
        ` : ''}
        ${job.address_detail ? `
        <div class="location-row">
            <i class="bi bi-geo-alt"></i>
            <div class="location-info">
                <div class="location-label">Địa chỉ cụ thể</div>
                <div class="location-value">${job.address_detail}</div>
            </div>
        </div>
        ` : ''}
    </div>
</div>
                ${job.description ? `
                <div class="detail-section">
                    <h3 class="detail-section-title"><i class="bi bi-file-text-fill"></i> Mô tả công việc</h3>
                    <div class="job-description">${job.description.replace(/\n/g, '<br>')}</div>
                </div>` : ''}
                ${job.requirements ? `
                <div class="detail-section">
                    <h3 class="detail-section-title"><i class="bi bi-list-check"></i> Yêu cầu ứng viên</h3>
                    <div class="job-description">${job.requirements.replace(/\n/g, '<br>')}</div>
                </div>` : ''}
                ${job.benefits ? `
                <div class="detail-section">
                    <h3 class="detail-section-title"><i class="bi bi-gift-fill"></i> Quyền lợi</h3>
                    <div class="job-description">${job.benefits.replace(/\n/g, '<br>')}</div>
                </div>` : ''}
                ${job.hashtags && job.hashtags.length > 0 ? `
                <div class="detail-section">
                    <h3 class="detail-section-title"><i class="bi bi-code-slash"></i> Kỹ năng yêu cầu</h3>
                    <div class="tags-list">${hashtagsHtml}</div>
                </div>` : ''}
            </div>
        `;

                jobDetailColumn.scrollTop = 0;
                attachDetailButtons();
            }

            // ========== ATTACH DETAIL BUTTONS ==========
            function attachDetailButtons() {
                const saveBtnLarge = document.querySelector('.save-btn-large');
                const applyBtn = document.querySelector('.btn-apply-now');

                if (saveBtnLarge) {
                    saveBtnLarge.addEventListener('click', function(e) {
                        e.stopPropagation();
                        const jobId = this.getAttribute('data-job-id');
                        const isSaved = this.classList.contains('saved');
                        handleSaveJob(jobId, isSaved, this);
                    });
                }

                if (applyBtn) {
                    applyBtn.addEventListener('click', function() {
                        if (this.classList.contains('applied')) {
                            showToast('Bạn đã ứng tuyển công việc này rồi!', 'info');
                            return;
                        }

                        if (!checkAuth()) {
                            showToast('Vui lòng đăng nhập để ứng tuyển!', 'error');
                            setTimeout(() => window.location.href = '/login', 1500);
                            return;
                        }

                        const jobId = this.getAttribute('data-job-id');
                        window.currentJobId = jobId;

                        const modal = document.getElementById('applyJobModal');
                        if (modal) {
                            const bsModal = new bootstrap.Modal(modal);
                            bsModal.show();
                        }
                    });
                }
            }

            // ========== ATTACH GRID CARD EVENTS ==========
            function attachGridCardEvents() {
                document.querySelectorAll('.job-card-grid').forEach(card => {
                    const newCard = card.cloneNode(true);
                    card.parentNode.replaceChild(newCard, card);

                    newCard.addEventListener('click', function(e) {
                        if (e.target.closest('.save-btn-grid') || e.target.closest('.btn-apply-now')) return;
                        const jobId = this.getAttribute('data-job-id');
                        if (jobId) showDetailView(jobId);
                    });

                    const applyBtn = newCard.querySelector('.btn-apply-now');
                    if (applyBtn) {
                        applyBtn.addEventListener('click', function(e) {
                            e.stopPropagation();

                            if (this.classList.contains('applied')) {
                                showToast('Bạn đã ứng tuyển công việc này rồi!', 'info');
                                return;
                            }

                            if (!checkAuth()) {
                                showToast('Vui lòng đăng nhập để ứng tuyển!', 'error');
                                setTimeout(() => window.location.href = '/login', 1500);
                                return;
                            }

                            const jobId = this.getAttribute('data-job-id');
                            window.currentJobId = jobId;

                            const modal = document.getElementById('applyJobModal');
                            if (modal) {
                                const bsModal = new bootstrap.Modal(modal);
                                bsModal.show();
                            }
                        });
                    }
                });
            }

            // ========== ATTACH LIST CARD EVENTS ==========
            function attachListCardEvents() {
                document.querySelectorAll('.job-card').forEach(card => {
                    card.addEventListener('click', function(e) {
                        if (e.target.closest('.save-btn-small')) return;
                        document.querySelectorAll('.job-card').forEach(c => c.classList.remove('active'));
                        this.classList.add('active');
                        const jobId = this.getAttribute('data-job-id');
                        loadJobDetail(jobId);
                    });
                });
            }

            // ========== ATTACH SAVE BUTTON EVENTS ==========
            function attachSaveButtonGrid() {
                document.querySelectorAll('.save-btn-grid').forEach(btn => {
                    const newBtn = btn.cloneNode(true);
                    btn.parentNode.replaceChild(newBtn, btn);

                    newBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        e.preventDefault();
                        const jobCard = this.closest('.job-card-grid');
                        const jobId = jobCard?.getAttribute('data-job-id');
                        if (!jobId) {
                            showToast('Không xác định được công việc!', 'error');
                            return;
                        }
                        const isSaved = this.classList.contains('saved');
                        handleSaveJob(jobId, isSaved, this);
                    });
                });
            }

            function attachSaveButtonSmall() {
                document.querySelectorAll('.save-btn-small').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        e.preventDefault();
                        const jobCard = this.closest('.job-card');
                        const jobId = jobCard?.getAttribute('data-job-id');
                        if (!jobId) {
                            showToast('Không xác định được công việc!', 'error');
                            return;
                        }
                        const isSaved = this.classList.contains('saved');
                        handleSaveJob(jobId, isSaved, this);
                    });
                });
            }

            // ========== ATTACH ALL JOB CARD EVENTS ==========
            function attachJobCardEvents() {
                attachGridCardEvents();
                attachListCardEvents();
                attachSaveButtonGrid();
                attachSaveButtonSmall();
                loadSavedJobs();
                loadAppliedJobs();
            }
            // ✅ Expose function to window scope
            window.attachJobCardEvents = attachJobCardEvents;

            // ========== BACK TO GRID BUTTON ==========
            if (backToGridBtn) {
                backToGridBtn.addEventListener('click', function() {
                    showGridView();
                });
            }

            // ========== XỬ LÝ FILTER BUTTONS ==========
            const filterBtns = document.querySelectorAll('.filter-btn:not(.all-filters-btn)');
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    this.classList.toggle('active');
                });
            });

            // ========== XỬ LÝ MODAL ỨNG TUYỂN ==========
            const uploadOption = document.getElementById('uploadOption');
            const profileOption = document.getElementById('profileOption');
            const uploadSection = document.getElementById('uploadSection');
            const profileSection = document.getElementById('profileSection');
            const cvTypeRadios = document.querySelectorAll('input[name="cv_type"]');

            cvTypeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    document.querySelectorAll('.cv-option-card').forEach(card => {
                        card.classList.remove('active');
                    });
                    this.closest('.cv-option-card').classList.add('active');

                    if (this.value === 'upload') {
                        uploadSection.style.display = 'block';
                        profileSection.style.display = 'none';
                    } else {
                        uploadSection.style.display = 'none';
                        profileSection.style.display = 'block';
                    }
                });
            });

            // File Upload
            const uploadArea = document.getElementById('uploadArea');
            const cvFileInput = document.getElementById('cvFileInput');
            const selectFileBtn = document.getElementById('selectFileBtn');
            const fileNameDisplay = document.getElementById('fileNameDisplay');
            const fileName = document.getElementById('fileName');
            const removeFile = document.getElementById('removeFile');

            if (selectFileBtn) {
                selectFileBtn.addEventListener('click', () => cvFileInput.click());
            }

            if (cvFileInput) {
                cvFileInput.addEventListener('change', function(e) {
                    handleFile(this.files[0]);
                });
            }

            if (uploadArea) {
                uploadArea.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    this.classList.add('dragover');
                });

                uploadArea.addEventListener('dragleave', function() {
                    this.classList.remove('dragover');
                });

                uploadArea.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.classList.remove('dragover');
                    const file = e.dataTransfer.files[0];
                    handleFile(file);
                });
            }

            function handleFile(file) {
                if (!file) return;

                const validTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                const maxSize = 5 * 1024 * 1024;

                if (!validTypes.includes(file.type)) {
                    alert('Chỉ chấp nhận file .doc, .docx, .pdf');
                    return;
                }

                if (file.size > maxSize) {
                    alert('File không được vượt quá 5MB');
                    return;
                }

                fileName.textContent = file.name;
                fileNameDisplay.style.display = 'block';
                uploadArea.style.display = 'none';
            }

            if (removeFile) {
                removeFile.addEventListener('click', function() {
                    cvFileInput.value = '';
                    fileNameDisplay.style.display = 'none';
                    uploadArea.style.display = 'block';
                });
            }

            // Character Count
            const letterTextarea = document.querySelector('.letter-textarea');
            const charCount = document.getElementById('charCount');

            if (letterTextarea) {
                letterTextarea.addEventListener('input', function() {
                    charCount.textContent = this.value.length;
                });
                charCount.textContent = letterTextarea.value.length;
            }

            // ========== FORM SUBMIT - ỨNG TUYỂN ==========
            const applyJobForm = document.getElementById('applyJobForm');
            if (applyJobForm) {
                applyJobForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const cvType = document.querySelector('input[name="cv_type"]:checked').value;
                    if (cvType === 'upload' && !cvFileInput.files.length) {
                        showToast('Vui lòng tải lên CV của bạn', 'error');
                        return;
                    }

                    let jobId = window.currentJobId;

                    if (!jobId) {
                        const activeCard = document.querySelector('.job-card.active');
                        jobId = activeCard ? activeCard.getAttribute('data-job-id') : null;
                    }

                    if (!jobId) {
                        const applyBtn = document.querySelector('.btn-apply-now');
                        jobId = applyBtn ? applyBtn.getAttribute('data-job-id') : null;
                    }

                    if (!jobId) {
                        showToast('Không xác định được công việc. Vui lòng thử lại!', 'error');
                        return;
                    }

                    const formData = new FormData(this);
                    formData.append('job_id', jobId);

                    const submitBtn = this.querySelector('.btn-submit-apply');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Đang gửi...';

                    fetch('/apply-job', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showToast(data.message, 'success');

                                // ✅ CẬP NHẬT NÚT ỨNG TUYỂN NGAY SAU KHI THÀNH CÔNG
                                syncApplyButtons(jobId, true);

                                const modal = bootstrap.Modal.getInstance(document.getElementById('applyJobModal'));
                                if (modal) modal.hide();

                                applyJobForm.reset();
                                window.currentJobId = null;

                                if (fileNameDisplay) fileNameDisplay.style.display = 'none';
                                if (uploadArea) uploadArea.style.display = 'block';
                            } else {
                                if (data.errors) {
                                    const errorMessages = Object.values(data.errors).flat().join('\n');
                                    showToast(errorMessages, 'error');
                                } else {
                                    showToast(data.message || 'Có lỗi xảy ra. Vui lòng thử lại!', 'error');
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('Có lỗi xảy ra khi gửi hồ sơ. Vui lòng thử lại!', 'error');
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        });
                });
            }

            // Reset modal khi đóng
            const applyModal = document.getElementById('applyJobModal');
            if (applyModal) {
                applyModal.addEventListener('hidden.bs.modal', function() {
                    const form = document.getElementById('applyJobForm');
                    if (form) form.reset();
                    if (uploadSection) uploadSection.style.display = 'block';
                    if (profileSection) profileSection.style.display = 'none';
                    if (fileNameDisplay) fileNameDisplay.style.display = 'none';
                    if (uploadArea) uploadArea.style.display = 'block';
                    document.querySelectorAll('.cv-option-card').forEach(card => {
                        card.classList.remove('active');
                    });
                    if (uploadOption) uploadOption.classList.add('active');
                    if (charCount) charCount.textContent = '0';
                });
            }

            // ========== KHỞI TẠO BAN ĐẦU ==========
            attachJobCardEvents();

            console.log('✅ All features initialized successfully');

            // ========== XỬ LÝ PAGINATION AJAX ==========
            function handlePagination() {
                const paginationWrapper = document.getElementById('paginationWrapper');

                if (!paginationWrapper) return;

                // Xử lý click vào các nút pagination
                paginationWrapper.addEventListener('click', function(e) {
                    e.preventDefault();

                    const target = e.target.closest('.page-link');
                    if (!target) return;

                    const pageItem = target.closest('.page-item');
                    if (pageItem && pageItem.classList.contains('disabled')) return;

                    const page = parseInt(target.getAttribute('data-page'));
                    if (!page || page < 1) return;

                    loadJobsByPage(page);
                });
            }

            // ========== LOAD JOBS BY PAGE ==========
            function loadJobsByPage(page) {
                // Hiển thị loading overlay
                if (loadingOverlay) {
                    loadingOverlay.style.display = 'flex';
                }

                // Scroll to top
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });

                fetch(`/api/jobs?page=${page}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Cập nhật grid view
                            if (gridView) {
                                gridView.innerHTML = data.html;
                            }

                            // Cập nhật pagination
                            if (paginationWrapper) {
                                paginationWrapper.innerHTML = data.pagination;
                            }

                            // Cập nhật URL (không reload trang)
                            const newUrl = `${window.location.pathname}?page=${page}`;
                            window.history.pushState({
                                page: page
                            }, '', newUrl);

                            // Re-attach events cho các job cards mới
                            attachJobCardEvents();

                            console.log(`✅ Loaded page ${page} successfully`);
                        } else {
                            showToast('Không thể tải dữ liệu', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error loading jobs:', error);
                        showToast('Có lỗi xảy ra khi tải dữ liệu', 'error');
                    })
                    .finally(() => {
                        // Ẩn loading overlay
                        if (loadingOverlay) {
                            loadingOverlay.style.display = 'none';
                        }
                    });
            }

            // ========== XỬ LÝ BROWSER BACK/FORWARD ==========
            window.addEventListener('popstate', function(e) {
                if (e.state && e.state.page) {
                    loadJobsByPage(e.state.page);
                } else {
                    // Nếu không có state, reload về page 1
                    const urlParams = new URLSearchParams(window.location.search);
                    const page = parseInt(urlParams.get('page')) || 1;
                    loadJobsByPage(page);
                }
            });

            // ========== KHỞI TẠO PAGINATION ==========
            handlePagination();
        });
        // ========== SEARCH & FILTER FUNCTIONALITY ==========
        (function() {
            let searchTimeout = null;
            let currentFilters = {
                search: '',
                location: '',
                categories: [],
                levels: [],
                experiences: [],
                working_types: []
            };

            // Elements
            const searchInput = document.getElementById('searchInput');
            const locationSelect = document.getElementById('locationSelect');
            const searchBtn = document.getElementById('searchBtn');
            const resetBtn = document.getElementById('resetFiltersBtn');
            const loadingOverlay = document.getElementById('jobsLoadingOverlay');
            const paginationWrapper = document.getElementById('paginationWrapper');
            const gridView = document.getElementById('gridView');

            // Dropdown buttons
            const categoryBtn = document.getElementById('categoryFilterBtn');
            const levelBtn = document.getElementById('levelFilterBtn');
            const experienceBtn = document.getElementById('experienceFilterBtn');
            const workingTypeBtn = document.getElementById('workingTypeFilterBtn');

            // Dropdown menus
            const categoryDropdown = document.getElementById('categoryDropdown');
            const levelDropdown = document.getElementById('levelDropdown');
            const experienceDropdown = document.getElementById('experienceDropdown');
            const workingTypeDropdown = document.getElementById('workingTypeDropdown');

            // ========== Toggle Dropdown ==========
            function toggleDropdown(menu) {
                const isShown = menu.classList.contains('show');

                // Đóng tất cả dropdown khác
                document.querySelectorAll('.filter-dropdown-menu').forEach(m => {
                    m.classList.remove('show');
                });

                // Toggle dropdown hiện tại
                if (!isShown) {
                    menu.classList.add('show');
                }
            }

            // ========== Đóng dropdown khi click outside ==========
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.filter-dropdown-wrapper')) {
                    document.querySelectorAll('.filter-dropdown-menu').forEach(menu => {
                        menu.classList.remove('show');
                    });
                }
            });

            // ========== Gắn sự kiện cho dropdown buttons ==========
            if (categoryBtn) {
                categoryBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    toggleDropdown(categoryDropdown);
                });
            }

            if (levelBtn) {
                levelBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    toggleDropdown(levelDropdown);
                });
            }

            if (experienceBtn) {
                experienceBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    toggleDropdown(experienceDropdown);
                });
            }

            if (workingTypeBtn) {
                workingTypeBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    toggleDropdown(workingTypeDropdown);
                });
            }

            // ========== Cập nhật filter badge ==========
            function updateFilterBadge(button, count) {
                let badge = button.querySelector('.badge');

                if (count > 0) {
                    if (!badge) {
                        badge = document.createElement('span');
                        badge.className = 'badge';
                        button.appendChild(badge);
                    }
                    badge.textContent = count;
                    button.classList.add('active');
                } else {
                    if (badge) {
                        badge.remove();
                    }
                    button.classList.remove('active');
                }
            }

            // ========== Thu thập filter data ==========
            function collectFilters() {
                currentFilters = {
                    search: searchInput ? searchInput.value.trim() : '',
                    location: locationSelect ? locationSelect.value : '',
                    categories: [],
                    levels: [],
                    experiences: [],
                    working_types: []
                };

                // Category filters
                document.querySelectorAll('input[name="category"]:checked').forEach(cb => {
                    if (cb.value !== 'all') {
                        currentFilters.categories.push(cb.value);
                    }
                });

                // Level filters
                document.querySelectorAll('input[name="level"]:checked').forEach(cb => {
                    currentFilters.levels.push(cb.value);
                });

                // Experience filters
                document.querySelectorAll('input[name="experience"]:checked').forEach(cb => {
                    currentFilters.experiences.push(cb.value);
                });

                // Working type filters
                document.querySelectorAll('input[name="working_type"]:checked').forEach(cb => {
                    currentFilters.working_types.push(cb.value);
                });

                // Cập nhật badge cho các button
                updateFilterBadge(categoryBtn, currentFilters.categories.length);
                updateFilterBadge(levelBtn, currentFilters.levels.length);
                updateFilterBadge(experienceBtn, currentFilters.experiences.length);
                updateFilterBadge(workingTypeBtn, currentFilters.working_types.length);

                return currentFilters;
            }

            // ========== Kiểm tra có filter nào được áp dụng không ==========
            function hasActiveFilters(filters) {
                return filters.search ||
                    filters.location ||
                    filters.categories.length > 0 ||
                    filters.levels.length > 0 ||
                    filters.experiences.length > 0 ||
                    filters.working_types.length > 0;
            }

            // ========== Thực hiện search & filter ==========
            function performSearch(page = 1) {
                const filters = collectFilters();

                // Hiển thị loading
                if (loadingOverlay) {
                    loadingOverlay.style.display = 'flex';
                }

                // ✅ FIX: Nếu KHÔNG có filter nào, load tất cả jobs
                if (!hasActiveFilters(filters)) {
                    console.log('ℹ️ No filters applied, loading all jobs...');
                    loadAllJobs(page);
                    return;
                }

                // Build query string
                const params = new URLSearchParams();
                params.append('page', page);

                // ✅ QUAN TRỌNG: Chỉ thêm param khi có giá trị
                if (filters.search) params.append('search', filters.search);
                if (filters.location) params.append('location', filters.location);
                if (filters.categories.length) params.append('categories', filters.categories.join(','));
                if (filters.levels.length) params.append('levels', filters.levels.join(','));
                if (filters.experiences.length) params.append('experiences', filters.experiences.join(','));
                if (filters.working_types.length) params.append('working_types', filters.working_types.join(','));

                // Log để debug
                console.log('🔍 Searching with filters:', filters);
                console.log('📡 API URL:', `/api/jobs/search?${params.toString()}`);

                // AJAX request
                fetch(`/api/jobs/search?${params.toString()}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Cập nhật grid view
                            if (gridView) {
                                gridView.innerHTML = data.html;
                            }

                            // Cập nhật pagination
                            if (paginationWrapper) {
                                paginationWrapper.innerHTML = data.pagination || '';
                            }

                            // Cập nhật số lượng kết quả
                            if (data.location_message) {
                                const formattedMessage = data.location_message.replace(/tại (.+)$/, (match, location) => {
                                    return `tại ${formatLocationDisplay(location)}`;
                                });
                                updateResultCount(data.total, formattedMessage);
                            } else {
                                updateResultCount(data.total, '');
                            }

                            console.log('✅ Location display helper loaded');

                            // Re-attach events
                            // ✅ Re-attach events với timeout để đảm bảo DOM đã render
                            setTimeout(() => {
                                if (typeof window.attachJobCardEvents === 'function') {
                                    window.attachJobCardEvents();
                                    console.log('✅ Events re-attached after search');
                                } else {
                                    console.error('❌ attachJobCardEvents not found');
                                }
                            }, 100);

                            // Scroll to results
                            const featuredSection = document.querySelector('.featured-section');
                            if (featuredSection) {
                                window.scrollTo({
                                    top: featuredSection.offsetTop - 100,
                                    behavior: 'smooth'
                                });
                            }

                            // Hiển thị thông báo kết quả
                            if (data.total === 0) {
                                showToast('Không tìm thấy công việc phù hợp', 'info');
                            } else {
                                console.log(`✅ Found ${data.total} jobs`);
                            }
                        } else {
                            showToast(data.message || 'Không tìm thấy kết quả', 'info');
                        }
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        showToast('Có lỗi xảy ra khi tìm kiếm', 'error');
                    })
                    .finally(() => {
                        if (loadingOverlay) {
                            loadingOverlay.style.display = 'none';
                        }
                    });
            }

            // ========== ✅ THÊM HÀM MỚI: Load tất cả jobs ==========
            function loadAllJobs(page = 1) {
                if (loadingOverlay) {
                    loadingOverlay.style.display = 'flex';
                }

                fetch(`/api/jobs?page=${page}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (gridView) {
                                gridView.innerHTML = data.html;
                            }

                            if (paginationWrapper) {
                                paginationWrapper.innerHTML = data.pagination || '';
                            }

                            updateResultCount(data.total);

                            if (typeof attachJobCardEvents === 'function') {
                                attachJobCardEvents();
                            }

                            console.log(`✅ Loaded ${data.total} jobs (page ${page})`);
                        } else {
                            showToast('Không thể tải dữ liệu', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error loading jobs:', error);
                        showToast('Có lỗi xảy ra khi tải dữ liệu', 'error');
                    })
                    .finally(() => {
                        if (loadingOverlay) {
                            loadingOverlay.style.display = 'none';
                        }
                    });
            }

            function formatLocationDisplay(locationName) {
                if (!locationName) return '';

                return locationName
                    .replace('Thành phố ', '')
                    .replace('Tỉnh ', '')
                    .trim();
            }

            // ========== Cập nhật số lượng kết quả ==========
            function updateResultCount(total, locationMessage = '') {
                const titleElement = document.querySelector('.section-title-highlight h2');
                if (titleElement) {
                    // ✅ Format location message nếu có
                    if (locationMessage) {
                        // Lấy tên từ backend (VD: " tại Hà Nội")
                        const parts = locationMessage.match(/tại (.+)$/);
                        if (parts && parts[1]) {
                            const formattedName = formatLocationDisplay(parts[1]);
                            locationMessage = ` tại ${formattedName}`;
                        }
                    }

                    titleElement.textContent = `${total} cơ hội việc làm IT${locationMessage}`;
                }
            }

            // ========== Search button click ==========
            if (searchBtn) {
                searchBtn.addEventListener('click', function() {
                    performSearch();
                });
            }

            // ========== Enter key in search input ==========
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        performSearch();
                    }
                });

                // Real-time search (debounced)
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);

                    const searchValue = this.value.trim();

                    // ✅ FIX: Cho phép search ngay cả khi rỗng (để load lại tất cả jobs)
                    searchTimeout = setTimeout(() => {
                        performSearch();
                    }, 800);
                });
            }

            // ========== Location select change ==========
            if (locationSelect) {
                locationSelect.addEventListener('change', function() {
                    // ✅ FIX: Luôn gọi performSearch, không cần check điều kiện
                    // performSearch();
                });
            }

            // ========== Checkbox change ==========
            document.querySelectorAll('.filter-checkbox-item input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Xử lý "Tất cả" trong category
                    if (this.name === 'category' && this.value === 'all' && this.checked) {
                        document.querySelectorAll('input[name="category"]').forEach(cb => {
                            if (cb.value !== 'all') cb.checked = false;
                        });
                    } else if (this.name === 'category' && this.value !== 'all' && this.checked) {
                        const allCheckbox = document.querySelector('input[name="category"][value="all"]');
                        if (allCheckbox) allCheckbox.checked = false;
                    }

                    // Tự động search khi thay đổi filter
                    performSearch();
                });
            });

            // ========== Reset filters ==========
            if (resetBtn) {
                resetBtn.addEventListener('click', function() {
                    // Reset search input
                    if (searchInput) searchInput.value = '';

                    // Reset location
                    if (locationSelect) locationSelect.value = '';

                    // Uncheck all checkboxes
                    document.querySelectorAll('.filter-checkbox-item input[type="checkbox"]').forEach(cb => {
                        cb.checked = false;
                    });

                    // Check "Tất cả" in category
                    const allCheckbox = document.querySelector('input[name="category"][value="all"]');
                    if (allCheckbox) allCheckbox.checked = true;

                    // Reset badges
                    updateFilterBadge(categoryBtn, 0);
                    updateFilterBadge(levelBtn, 0);
                    updateFilterBadge(experienceBtn, 0);
                    updateFilterBadge(workingTypeBtn, 0);

                    // ✅ FIX: Load lại tất cả jobs thay vì search
                    loadAllJobs();

                    showToast('Đã đặt lại bộ lọc', 'info');
                });
            }

            // ========== Xử lý pagination ==========
            if (paginationWrapper) {
                paginationWrapper.addEventListener('click', function(e) {
                    e.preventDefault();

                    const target = e.target.closest('.page-link');
                    if (!target) return;

                    const pageItem = target.closest('.page-item');
                    if (pageItem && pageItem.classList.contains('disabled')) return;

                    const page = parseInt(target.getAttribute('data-page'));
                    if (!page || page < 1) return;

                    // ✅ FIX: Kiểm tra xem có filter không
                    const filters = collectFilters();
                    if (hasActiveFilters(filters)) {
                        performSearch(page);
                    } else {
                        loadAllJobs(page);
                    }
                });
            }

            console.log('✅ Search & Filter initialized (Fixed Version)');
        })();
    </script>


</body>

</html>