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
    /* ✨ Style cho nút Gợi ý việc làm */
    .btn-recommendations {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        position: relative;
        margin-right: 12px;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }

    .btn-recommendations:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }

    .btn-recommendations i {
        font-size: 18px;
    }

    .btn-recommendations .badge-count {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #ff4757;
        color: white;
        font-size: 11px;
        font-weight: 600;
        padding: 2px 6px;
        border-radius: 10px;
        min-width: 20px;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
    }

    /* Style cho badge nhỏ trong dropdown */
    .badge-small {
        background: #667eea;
        color: white;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 8px;
        margin-left: 8px;
        font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .btn-recommendations span {
            display: none;
        }

        .btn-recommendations {
            padding: 10px 14px;
        }

        .btn-recommendations i {
            margin: 0;
        }
    }
</style>
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

    /* ========== TOP COMPANIES SECTION ========== */
    .main-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .featured-section {
        margin: 2rem 0;
    }

    .section-title-highlight {
        margin-bottom: 1.5rem;
    }

    .section-subtitle {
        font-size: 0.9rem;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    h2 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 1rem 0;
        line-height: 1.2;
    }

    /* TOP COMPANIES - COMPANY CARD */
    .companies-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .company-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .company-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    .company-card-logo {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .company-card-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .company-card-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1f2937;
        margin: 0 0 0.5rem 0;
    }

    .company-card-meta {
        font-size: 0.85rem;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .company-card-meta i {
        color: #10b981;
        font-size: 0.9rem;
    }

    /* ========== RECOMMENDED JOBS SECTION (NEW) ========== */
    .recommended-jobs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
        margin: 2rem 0;
    }

    .recommended-job-card {
        background: white;
        border-radius: 18px;
        padding: 1.5rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        border: 2px solid transparent;
    }

    .recommended-job-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .recommended-job-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
        border-color: rgba(102, 126, 234, 0.2);
    }

    .recommended-job-card:hover::before {
        opacity: 1;
    }

    .recommended-job-card.high-match {
        border-color: rgba(17, 153, 142, 0.2);
    }

    .recommended-job-card.high-match::before {
        background: linear-gradient(90deg, #11998e, #38ef7d);
    }

    .recommended-job-card.medium-match {
        border-color: rgba(102, 126, 234, 0.2);
    }

    /* Match Badge */
    .match-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 1.4rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 10;
    }

    .match-badge.high-match {
        background: linear-gradient(135deg, #11998e, #38ef7d);
        color: white;
    }

    .match-badge.medium-match {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    .match-badge.low-match {
        background: linear-gradient(135deg, #fa709a, #fee140);
        color: white;
    }

    .match-percentage {
        text-align: center;
    }

    /* Company Header */
    .rec-job-header {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.2rem;
        padding-top: 0.5rem;
    }

    .rec-company-logo {
        width: 60px;
        height: 60px;
        border-radius: 14px;
        flex-shrink: 0;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .rec-company-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .rec-job-info {
        flex: 1;
    }

    .rec-job-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 0.4rem 0;
        line-height: 1.4;
    }

    .rec-company-name {
        font-size: 0.85rem;
        color: #718096;
        margin: 0;
        font-weight: 500;
    }

    /* Meta Information */
    .rec-job-meta {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .meta-item {
        font-size: 0.85rem;
        color: #4b5563;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .meta-item i {
        color: #667eea;
        font-size: 0.9rem;
    }

    /* Salary */
    .rec-job-salary {
        font-size: 1.1rem;
        font-weight: 700;
        color: #11998e;
        margin-bottom: 1rem;
        padding: 0.75rem;
        background: linear-gradient(135deg, rgba(17, 153, 142, 0.05) 0%, rgba(56, 239, 125, 0.05) 100%);
        border-radius: 10px;
        text-align: center;
    }

    .rec-job-salary .negotiable {
        color: #667eea;
    }

    /* Tags */
    .rec-job-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
        margin-bottom: 1rem;
    }

    .rec-tag {
        font-size: 0.8rem;
        padding: 0.4rem 0.8rem;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(102, 126, 234, 0.05) 100%);
        color: #667eea;
        border-radius: 20px;
        font-weight: 600;
        white-space: nowrap;
        transition: all 0.2s ease;
    }

    .rec-tag:hover {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.2) 0%, rgba(102, 126, 234, 0.15) 100%);
    }

    .rec-tag.more {
        background: linear-gradient(135deg, rgba(250, 112, 154, 0.1) 0%, rgba(250, 112, 154, 0.05) 100%);
        color: #fa709a;
    }

    /* Deadline */
    .rec-job-deadline {
        font-size: 0.85rem;
        color: #718096;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .rec-job-deadline i {
        color: #fa709a;
    }

    /* Action Buttons */
    .rec-job-actions {
        display: flex;
        gap: 0.6rem;
    }

    .rec-btn {
        flex: 1;
        padding: 0.75rem;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        min-height: 40px;
    }

    .rec-btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        flex: 2;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .rec-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
    }

    .rec-btn-primary:active {
        transform: translateY(0);
    }

    .rec-btn-icon {
        width: 40px;
        min-width: 40px;
        padding: 0;
        background: white;
        color: #718096;
        border: 2px solid #e5e7eb;
    }

    .rec-btn-icon:hover {
        border-color: #667eea;
        color: #667eea;
        background: rgba(102, 126, 234, 0.05);
    }

    .rec-btn-icon.saved {
        border-color: #ef4444;
        color: #ef4444;
        background: rgba(239, 68, 68, 0.05);
    }

    /* Match Indicator Line */
    .match-indicator {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: #e5e7eb;
    }

    .match-indicator.high-match {
        background: linear-gradient(90deg, #11998e, #38ef7d);
    }

    .match-indicator.medium-match {
        background: linear-gradient(90deg, #667eea, #764ba2);
    }

    .match-indicator.low-match {
        background: linear-gradient(90deg, #fa709a, #fee140);
    }

    /* View All Button */
    .btn-view-all {
        display: inline-flex;
        align-items: center;
        gap: 0.8rem;
        padding: 1rem 2.5rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
    }

    .btn-view-all:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(102, 126, 234, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-view-all i:last-child {
        transition: transform 0.3s ease;
    }

    .btn-view-all:hover i:last-child {
        transform: translateX(4px);
    }

    /* Empty State */
    .rec-empty-state {
        text-align: center;
        padding: 3rem 2rem;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        border-radius: 20px;
        border: 2px dashed #e5e7eb;
    }

    .empty-icon {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
    }

    .rec-empty-state h4 {
        font-size: 1.3rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .rec-empty-state p {
        color: #718096;
        margin-bottom: 1.5rem;
    }

    .btn-complete-profile {
        display: inline-flex;
        align-items: center;
        gap: 0.8rem;
        padding: 0.9rem 2rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 700;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
    }

    .btn-complete-profile:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(102, 126, 234, 0.4);
        color: white;
        text-decoration: none;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .recommended-jobs-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .recommended-jobs-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .match-badge {
            width: 60px;
            height: 60px;
            font-size: 1.2rem;
        }

        .rec-btn {
            font-size: 0.8rem;
            padding: 0.6rem;
        }

        .rec-btn-primary {
            flex: 1.5;
        }
    }

    @media (max-width: 480px) {
        .recommended-jobs-grid {
            grid-template-columns: 1fr;
        }

        .rec-job-actions {
            gap: 0.4rem;
        }

        .rec-btn {
            min-height: 36px;
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

                <!-- ✨ NÚT GỢI Ý VIỆC LÀM MỚI -->
                <a class="btn-recommendations" href="{{ route('applicant.recommendations') }}">
                    <i class="bi bi-stars"></i>
                    <span>Gợi ý việc làm</span>
                    @php
                    $recsCount = \App\Models\JobRecommendation::where('applicant_id', Auth::user()->applicant->id ?? 0)
                    ->where('score', '>=', 60)
                    ->count();
                    @endphp
                    @if($recsCount > 0)
                    <span class="badge-count">{{ $recsCount }}</span>
                    @endif
                </a>

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

                        <!-- ✨ THÊM VÀO DROPDOWN MENU -->
                        <li>
                            <a href="{{ route('applicant.recommendations') }}">
                                <i class="bi bi-stars"></i>
                                Gợi ý việc làm
                                @if($recsCount > 0)
                                <span class="badge-small">{{ $recsCount }}</span>
                                @endif
                            </a>
                        </li>

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


    <!-- ========== RECOMMENDED JOBS SECTION (NEW) ========== -->
    <div class="main-container">
        <div class="featured-section">
            <div class="section-title-highlight">
                <div class="section-subtitle">DÀNH CHO BẠN</div>
                <h2>Các công việc được gợi ý</h2>
                <p style="color: #718096; margin-top: 0.5rem;">Được cá nhân hóa dựa trên kỹ năng và kinh nghiệm của bạn</p>
            </div>

            @if(Auth::check() && $recommendedJobs && $recommendedJobs->count() > 0)
            <div class="recommended-jobs-grid">
                @foreach($recommendedJobs as $rec)
                @php
                $job = $rec->job;
                $matchScore = $rec->score ?? 0;
                $matchClass = $matchScore >= 80 ? 'high-match' : ($matchScore >= 60 ? 'medium-match' : 'low-match');
                @endphp

                <div class="recommended-job-card {{ $matchClass }}" data-job-id="{{ $job->job_id }}">
                    <div class="match-badge {{ $matchClass }}">
                        <div class="match-percentage">{{ number_format($matchScore, 0) }}%</div>
                    </div>

                    <div class="rec-job-header">
                        <div class="rec-company-logo">
                            @if($job->company && $job->company->logo)
                            <img src="{{ asset('assets/img/' . $job->company->logo) }}" alt="{{ $job->company->tencty }}">
                            @else
                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667EEA, #764BA2); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.5rem;">
                                {{ substr($job->company->tencty ?? 'C', 0, 1) }}
                            </div>
                            @endif
                        </div>
                        <div class="rec-job-info">
                            <h4 class="rec-job-title">{{ Str::limit($job->title, 45) }}</h4>
                            <p class="rec-company-name">{{ $job->company->tencty ?? 'Công ty' }}</p>
                        </div>
                    </div>

                    <div class="rec-job-meta">
                        <span class="meta-item">
                            <i class="bi bi-geo-alt"></i>
                            {{ $job->province }}
                        </span>
                        <span class="meta-item">
                            <i class="bi bi-briefcase"></i>
                            {{ ucfirst($job->level) }}
                        </span>
                    </div>

                    <div class="rec-job-salary">
                        @if($job->salary_min && $job->salary_max)
                        {{ number_format($job->salary_min, 0, ',', '.') }} - {{ number_format($job->salary_max, 0, ',', '.') }} {{ strtoupper($job->salary_type) }}
                        @else
                        <span class="negotiable">Thỏa thuận</span>
                        @endif
                    </div>

                    @if($job->hashtags && $job->hashtags->count() > 0)
                    <div class="rec-job-tags">
                        @foreach($job->hashtags->take(3) as $tag)
                        <span class="rec-tag">{{ $tag->tag_name }}</span>
                        @endforeach
                        @if($job->hashtags->count() > 3)
                        <span class="rec-tag more">+{{ $job->hashtags->count() - 3 }}</span>
                        @endif
                    </div>
                    @endif

                    <div class="rec-job-deadline">
                        <i class="bi bi-clock-history"></i>
                        Hạn: {{ \Carbon\Carbon::parse($job->deadline)->format('d/m/Y') }}
                    </div>

                    <div class="rec-job-actions">
                        <button class="rec-btn rec-btn-primary" onclick="openApplyModal('{{ $job->job_id }}')">
                            <i class="bi bi-send-fill"></i>
                            Ứng tuyển
                        </button>
                        <button class="rec-btn rec-btn-icon save-btn-rec" data-job-id="{{ $job->job_id }}" title="Lưu công việc">
                            <i class="bi bi-heart"></i>
                        </button>
                        <a href="{{ route('job.detail', $job->job_id) }}" class="rec-btn rec-btn-icon" title="Xem chi tiết">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <div class="match-indicator {{ $matchClass }}"></div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('applicant.recommendations') }}" class="btn-view-all">
                    <i class="bi bi-stars"></i>
                    <span>Xem tất cả gợi ý ({{ $recommendedJobs->count() }})</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            @else
            <div class="rec-empty-state">
                <div class="empty-icon">
                    <i class="bi bi-stars"></i>
                </div>
                <h4>Chưa có gợi ý</h4>
                <p>Hoàn thành hồ sơ của bạn để nhận những gợi ý công việc tốt nhất</p>
                <a href="{{ route('applicant.profile') }}" class="btn-complete-profile">
                    <i class="bi bi-pencil-square"></i>
                    Hoàn thành hồ sơ
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- ========== BLOG SECTION ========== -->
    <!-- ...existing code... -->
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
                                        <div class="profile-title">{{ $applicant->vitritungtuyen ?? 'Vị trí ứng tuyển' }}</div>
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

    <!-- Main Application Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            'use strict';

            // ========================================
            // HELPER FUNCTIONS
            // ========================================

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

            function formatLocationDisplay(locationName) {
                if (!locationName) return '';
                return locationName
                    .replace('Thành phố ', '')
                    .replace('Tỉnh ', '')
                    .trim();
            }

            function checkAuth() {
                const isLoggedIn = document.querySelector('meta[name="user-authenticated"]');
                return isLoggedIn && isLoggedIn.content === 'true';
            }

            // ========================================
            // TOAST NOTIFICATION
            // ========================================

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

            // Add animation styles
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

            // ========================================
            // DOM ELEMENTS
            // ========================================

            const gridView = document.getElementById('gridView');
            const detailView = document.getElementById('detailView');
            const backToGridBtn = document.getElementById('backToGrid');
            const jobDetailColumn = document.getElementById('jobDetailColumn');
            const jobListColumn = document.getElementById('jobListColumn');
            const loadingOverlay = document.getElementById('jobsLoadingOverlay');
            const paginationWrapper = document.getElementById('paginationWrapper');

            // Search & Filter Elements
            const searchInput = document.getElementById('searchInput');
            const locationSelect = document.getElementById('locationSelect');
            const searchBtn = document.getElementById('searchBtn');
            const resetBtn = document.getElementById('resetFiltersBtn');

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

            // ========================================
            // USER DROPDOWN
            // ========================================

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

            // ========================================
            // APPLY & SAVE BUTTON MANAGEMENT
            // ========================================

            function updateApplyButton(button, hasApplied) {
                if (!button) return;

                const icon = button.querySelector('i');
                button.classList.toggle('applied', hasApplied);
                button.disabled = hasApplied;
                button.title = hasApplied ? 'Bạn đã ứng tuyển công việc này' : 'Ứng tuyển ngay';

                if (icon) {
                    icon.classList.toggle('bi-send-fill', !hasApplied);
                    icon.classList.toggle('bi-check-circle-fill', hasApplied);
                }

                const textContent = hasApplied ? 'Đã ứng tuyển' : 'Ứng tuyển ngay';
                const textNode = Array.from(button.childNodes).find(node => node.nodeType === Node.TEXT_NODE);

                if (textNode) {
                    textNode.textContent = textContent;
                } else {
                    button.appendChild(document.createTextNode(textContent));
                }
            }

            function syncApplyButtons(jobId, hasApplied) {
                const gridCard = document.querySelector(`.job-card-grid[data-job-id="${jobId}"]`);
                if (gridCard) {
                    const gridBtn = gridCard.querySelector('.btn-apply-now');
                    if (gridBtn) updateApplyButton(gridBtn, hasApplied);
                }

                const detailBtn = document.querySelector(`.btn-apply-now[data-job-id="${jobId}"]`);
                if (detailBtn) updateApplyButton(detailBtn, hasApplied);
            }

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
                        if (data.success && data.appliedJobIds?.length > 0) {
                            data.appliedJobIds.forEach(jobId => {
                                syncApplyButtons(jobId, true);
                            });
                        }
                    })
                    .catch(error => console.error('Error loading applied jobs:', error));
            }

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

            // ========================================
            // SAVE BUTTON FUNCTIONS
            // ========================================

            function updateSaveButton(button, isSaved) {
                if (!button) return;

                const icon = button.querySelector('i');
                button.classList.toggle('saved', isSaved);

                if (icon) {
                    icon.classList.toggle('bi-heart', !isSaved);
                    icon.classList.toggle('bi-heart-fill', isSaved);
                }
            }

            function syncSaveButtons(jobId, isSaved) {
                ['job-card-grid', 'job-card', 'save-btn-large'].forEach(selector => {
                    let btn;
                    if (selector === 'save-btn-large') {
                        btn = document.querySelector(`.${selector}[data-job-id="${jobId}"]`);
                    } else {
                        const card = document.querySelector(`.${selector}[data-job-id="${jobId}"]`);
                        btn = card?.querySelector(selector === 'job-card-grid' ? '.save-btn-grid' : '.save-btn-small');
                    }
                    if (btn) updateSaveButton(btn, isSaved);
                });
            }

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
                        if (data.success && data.savedJobIds?.length) {
                            data.savedJobIds.forEach(jobId => {
                                syncSaveButtons(jobId, true);
                            });
                        }
                    })
                    .catch(error => console.error('Error loading saved jobs:', error));
            }

            // ========================================
            // VIEW SWITCHING
            // ========================================

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
                            card.classList.toggle('active', card.getAttribute('data-job-id') == jobId);
                        });
                        loadJobDetail(jobId);
                    }, 0);
                }
            }

            if (backToGridBtn) {
                backToGridBtn.addEventListener('click', showGridView);
            }

            // ========================================
            // JOB DETAIL LOADING
            // ========================================

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

                const logoHtml = job.company?.logo ?
                    `<img src="/assets/img/${job.company.logo}" alt="Company Logo">` :
                    `<div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667EEA, #764BA2); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; font-weight: bold;">${job.company?.tencty?.charAt(0) || 'C'}</div>`;

                const hashtagsHtml = job.hashtags?.length ?
                    job.hashtags.map(tag => `<span class="tag-item">${tag.tag_name}</span>`).join('') :
                    '<p class="text-muted">Không có thông tin</p>';

                const buildDetailSection = (title, icon, content) => {
                    return content ? `
                    <div class="detail-section">
                        <h3 class="detail-section-title"><i class="bi ${icon}"></i> ${title}</h3>
                        <div class="job-description">${content.replace(/\n/g, '<br>')}</div>
                    </div>
                ` : '';
                };

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
                            <div class="job-detail-company-name">${job.company?.tencty || 'Công ty'}</div>
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
                    ${buildDetailSection('Mô tả công việc', 'bi-file-text-fill', job.description)}
                    ${buildDetailSection('Yêu cầu ứng viên', 'bi-list-check', job.requirements)}
                    ${buildDetailSection('Quyền lợi', 'bi-gift-fill', job.benefits)}
                    ${job.hashtags?.length ? `
                    <div class="detail-section">
                        <h3 class="detail-section-title"><i class="bi bi-code-slash"></i> Kỹ năng yêu cầu</h3>
                        <div class="tags-list">${hashtagsHtml}</div>
                    </div>` : ''}
                </div>
            `;

                jobDetailColumn.scrollTop = 0;
                attachDetailButtons();
            }

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

            // ========================================
            // EVENT ATTACHMENTS
            // ========================================

            function attachGridCardEvents() {
                document.querySelectorAll('.job-card-grid').forEach(card => {
                    const applyBtn = card.querySelector('.btn-apply-now');
                    const saveBtn = card.querySelector('.save-btn-grid');

                    card.addEventListener('click', function(e) {
                        if (!e.target.closest('.save-btn-grid, .btn-apply-now')) {
                            const jobId = this.getAttribute('data-job-id');
                            if (jobId) showDetailView(jobId);
                        }
                    });

                    if (applyBtn) {
                        applyBtn.addEventListener('click', function(e) {
                            e.stopPropagation();
                            handleApplyClick.call(this);
                        });
                    }

                    if (saveBtn) {
                        saveBtn.addEventListener('click', function(e) {
                            e.stopPropagation();
                            const jobId = card.getAttribute('data-job-id');
                            const isSaved = this.classList.contains('saved');
                            handleSaveJob(jobId, isSaved, this);
                        });
                    }
                });
            }

            function attachListCardEvents() {
                document.querySelectorAll('.job-card').forEach(card => {
                    card.addEventListener('click', function(e) {
                        if (!e.target.closest('.save-btn-small')) {
                            document.querySelectorAll('.job-card').forEach(c => c.classList.remove('active'));
                            this.classList.add('active');
                            const jobId = this.getAttribute('data-job-id');
                            loadJobDetail(jobId);
                        }
                    });
                });
            }

            function attachSaveButtons() {
                document.querySelectorAll('.save-btn-grid, .save-btn-small').forEach(btn => {
                    btn.removeEventListener('click', handleSaveClick);
                    btn.addEventListener('click', handleSaveClick);
                });
            }

            function handleApplyClick() {
                if (this.classList.contains('applied')) {
                    showToast('Bạn đã ứng tuyển công việc này rồi!', 'info');
                    return;
                }

                if (!checkAuth()) {
                    showToast('Vui lòng đăng nhập để ứng tuyển!', 'error');
                    setTimeout(() => window.location.href = '/login', 1500);
                    return;
                }

                const jobId = this.getAttribute('data-job-id') || this.closest('[data-job-id]')?.getAttribute('data-job-id');
                window.currentJobId = jobId;

                const modal = document.getElementById('applyJobModal');
                if (modal) {
                    const bsModal = new bootstrap.Modal(modal);
                    bsModal.show();
                }
            }

            function handleSaveClick(e) {
                e.stopPropagation();
                e.preventDefault();

                const card = this.closest('[data-job-id]');
                const jobId = card?.getAttribute('data-job-id');

                if (!jobId) {
                    showToast('Không xác định được công việc!', 'error');
                    return;
                }

                const isSaved = this.classList.contains('saved');
                handleSaveJob(jobId, isSaved, this);
            }

            function attachJobCardEvents() {
                attachGridCardEvents();
                attachListCardEvents();
                attachSaveButtons();
                loadSavedJobs();
                loadAppliedJobs();
            }

            window.attachJobCardEvents = attachJobCardEvents;

            // ========================================
            // MODAL ỨNG TUYỂN
            // ========================================

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

                    const isUpload = this.value === 'upload';
                    if (uploadSection) uploadSection.style.display = isUpload ? 'block' : 'none';
                    if (profileSection) profileSection.style.display = isUpload ? 'none' : 'block';
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
                selectFileBtn.addEventListener('click', () => cvFileInput?.click());
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
                    handleFile(e.dataTransfer.files[0]);
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

                if (fileName) fileName.textContent = file.name;
                if (fileNameDisplay) fileNameDisplay.style.display = 'block';
                if (uploadArea) uploadArea.style.display = 'none';
            }

            if (removeFile) {
                removeFile.addEventListener('click', function() {
                    if (cvFileInput) cvFileInput.value = '';
                    if (fileNameDisplay) fileNameDisplay.style.display = 'none';
                    if (uploadArea) uploadArea.style.display = 'block';
                });
            }

            // Character Count
            const letterTextarea = document.querySelector('.letter-textarea');
            const charCount = document.getElementById('charCount');

            if (letterTextarea) {
                letterTextarea.addEventListener('input', function() {
                    if (charCount) charCount.textContent = this.value.length;
                });
                if (charCount) charCount.textContent = letterTextarea.value.length;
            }

            // Form Submit
            const applyJobForm = document.getElementById('applyJobForm');
            if (applyJobForm) {
                applyJobForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const cvType = document.querySelector('input[name="cv_type"]:checked')?.value;
                    if (cvType === 'upload' && !cvFileInput?.files.length) {
                        showToast('Vui lòng tải lên CV của bạn', 'error');
                        return;
                    }

                    let jobId = window.currentJobId ||
                        document.querySelector('.job-card.active')?.getAttribute('data-job-id') ||
                        document.querySelector('.btn-apply-now')?.getAttribute('data-job-id');

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
                                syncApplyButtons(jobId, true);

                                const modal = bootstrap.Modal.getInstance(applyJobModal);
                                if (modal) modal.hide();

                                applyJobForm.reset();
                                window.currentJobId = null;

                                if (fileNameDisplay) fileNameDisplay.style.display = 'none';
                                if (uploadArea) uploadArea.style.display = 'block';
                            } else {
                                const errorMsg = data.errors ?
                                    Object.values(data.errors).flat().join('\n') :
                                    data.message || 'Có lỗi xảy ra. Vui lòng thử lại!';
                                showToast(errorMsg, 'error');
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
                    if (applyJobForm) applyJobForm.reset();
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

            // ========================================
            // FILTER DROPDOWNS
            // ========================================

            function toggleDropdown(menu) {
                if (!menu) return;

                const isShown = menu.classList.contains('show');
                document.querySelectorAll('.filter-dropdown-menu').forEach(m => {
                    m.classList.remove('show');
                });

                if (!isShown) {
                    menu.classList.add('show');
                }
            }

            document.addEventListener('click', function(e) {
                if (!e.target.closest('.filter-dropdown-wrapper')) {
                    document.querySelectorAll('.filter-dropdown-menu').forEach(menu => {
                        menu.classList.remove('show');
                    });
                }
            });

            [{
                    btn: categoryBtn,
                    menu: categoryDropdown
                },
                {
                    btn: levelBtn,
                    menu: levelDropdown
                },
                {
                    btn: experienceBtn,
                    menu: experienceDropdown
                },
                {
                    btn: workingTypeBtn,
                    menu: workingTypeDropdown
                }
            ].forEach(({
                btn,
                menu
            }) => {
                if (btn) {
                    btn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        toggleDropdown(menu);
                    });
                }
            });

            // ========================================
            // SEARCH & FILTER
            // ========================================

            let searchTimeout = null;
            let currentFilters = {
                search: '',
                location: '',
                categories: [],
                levels: [],
                experiences: [],
                working_types: []
            };

            function updateFilterBadge(button, count) {
                if (!button) return;

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
                    badge?.remove();
                    button.classList.remove('active');
                }
            }

            function collectFilters() {
                currentFilters = {
                    search: searchInput?.value.trim() || '',
                    location: locationSelect?.value || '',
                    categories: Array.from(document.querySelectorAll('input[name="category"]:checked'))
                        .filter(cb => cb.value !== 'all')
                        .map(cb => cb.value),
                    levels: Array.from(document.querySelectorAll('input[name="level"]:checked'))
                        .map(cb => cb.value),
                    experiences: Array.from(document.querySelectorAll('input[name="experience"]:checked'))
                        .map(cb => cb.value),
                    working_types: Array.from(document.querySelectorAll('input[name="working_type"]:checked'))
                        .map(cb => cb.value)
                };

                updateFilterBadge(categoryBtn, currentFilters.categories.length);
                updateFilterBadge(levelBtn, currentFilters.levels.length);
                updateFilterBadge(experienceBtn, currentFilters.experiences.length);
                updateFilterBadge(workingTypeBtn, currentFilters.working_types.length);

                return currentFilters;
            }

            function hasActiveFilters(filters) {
                return !!(filters.search ||
                    filters.location ||
                    filters.categories.length > 0 ||
                    filters.levels.length > 0 ||
                    filters.experiences.length > 0 ||
                    filters.working_types.length > 0);
            }

            function updateResultCount(total, locationMessage = '') {
                const titleElement = document.querySelector('.section-title-highlight h2');
                if (titleElement) {
                    if (locationMessage) {
                        const match = locationMessage.match(/tại (.+)$/);
                        if (match) {
                            locationMessage = ` tại ${formatLocationDisplay(match[1])}`;
                        }
                    }
                    titleElement.textContent = `${total} cơ hội việc làm IT${locationMessage}`;
                }
            }

            function loadAllJobs(page = 1) {
                if (loadingOverlay) loadingOverlay.style.display = 'flex';

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
                            if (gridView) gridView.innerHTML = data.html;
                            if (paginationWrapper) paginationWrapper.innerHTML = data.pagination || '';
                            updateResultCount(data.total);

                            setTimeout(() => {
                                if (typeof window.attachJobCardEvents === 'function') {
                                    window.attachJobCardEvents();
                                }
                            }, 100);

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
                        if (loadingOverlay) loadingOverlay.style.display = 'none';
                    });
            }

            function performSearch(page = 1) {
                const filters = collectFilters();

                if (loadingOverlay) loadingOverlay.style.display = 'flex';

                if (!hasActiveFilters(filters)) {
                    console.log('ℹ️ No filters applied, loading all jobs...');
                    loadAllJobs(page);
                    return;
                }

                const params = new URLSearchParams();
                params.append('page', page);

                if (filters.search) params.append('search', filters.search);
                if (filters.location) params.append('location', filters.location);
                if (filters.categories.length) params.append('categories', filters.categories.join(','));
                if (filters.levels.length) params.append('levels', filters.levels.join(','));
                if (filters.experiences.length) params.append('experiences', filters.experiences.join(','));
                if (filters.working_types.length) params.append('working_types', filters.working_types.join(','));

                console.log('🔍 Searching with filters:', filters);

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
                            if (gridView) gridView.innerHTML = data.html;
                            if (paginationWrapper) paginationWrapper.innerHTML = data.pagination || '';

                            if (data.location_message) {
                                const formattedMessage = data.location_message.replace(/tại (.+)$/, (match, location) => {
                                    return `tại ${formatLocationDisplay(location)}`;
                                });
                                updateResultCount(data.total, formattedMessage);
                            } else {
                                updateResultCount(data.total, '');
                            }

                            setTimeout(() => {
                                if (typeof window.attachJobCardEvents === 'function') {
                                    window.attachJobCardEvents();
                                    console.log('✅ Events re-attached after search');
                                }
                            }, 100);

                            if (data.total === 0) {
                                showToast('Không tìm thấy công việc phù hợp', 'info');
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
                        if (loadingOverlay) loadingOverlay.style.display = 'none';
                    });
            }

            // Search button
            if (searchBtn) {
                searchBtn.addEventListener('click', () => performSearch());
            }

            // Enter key
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        performSearch();
                    }
                });

                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => performSearch(), 800);
                });
            }

            // Location select
            if (locationSelect) {
                locationSelect.addEventListener('change', () => performSearch());
            }

            // Checkboxes
            document.querySelectorAll('.filter-checkbox-item input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.name === 'category' && this.value === 'all' && this.checked) {
                        document.querySelectorAll('input[name="category"]:not([value="all"])').forEach(cb => {
                            cb.checked = false;
                        });
                    } else if (this.name === 'category' && this.value !== 'all' && this.checked) {
                        const allCheckbox = document.querySelector('input[name="category"][value="all"]');
                        if (allCheckbox) allCheckbox.checked = false;
                    }

                    performSearch();
                });
            });

            // Reset button
            if (resetBtn) {
                resetBtn.addEventListener('click', function() {
                    if (searchInput) searchInput.value = '';
                    if (locationSelect) locationSelect.value = '';

                    document.querySelectorAll('.filter-checkbox-item input[type="checkbox"]').forEach(cb => {
                        cb.checked = false;
                    });

                    const allCheckbox = document.querySelector('input[name="category"][value="all"]');
                    if (allCheckbox) allCheckbox.checked = true;

                    updateFilterBadge(categoryBtn, 0);
                    updateFilterBadge(levelBtn, 0);
                    updateFilterBadge(experienceBtn, 0);
                    updateFilterBadge(workingTypeBtn, 0);

                    loadAllJobs();
                    showToast('Đã đặt lại bộ lọc', 'info');
                });
            }

            // ========================================
            // PAGINATION
            // ========================================

            if (paginationWrapper) {
                paginationWrapper.addEventListener('click', function(e) {
                    const target = e.target.closest('.page-link');
                    if (!target) return;

                    e.preventDefault();

                    const pageItem = target.closest('.page-item');
                    if (pageItem?.classList.contains('disabled')) return;

                    const page = parseInt(target.getAttribute('data-page'));
                    if (!page || page < 1) return;

                    const filters = collectFilters();
                    if (hasActiveFilters(filters)) {
                        performSearch(page);
                    } else {
                        loadAllJobs(page);
                    }
                });
            }

            // ========================================
            // INITIALIZE
            // ========================================

            attachJobCardEvents();

            console.log('✅ All features initialized successfully');
        });
    </script>
</body>

</html>