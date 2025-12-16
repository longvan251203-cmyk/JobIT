<!DOCTYPE html>
<html lang="vi">
@include('applicant.partials.head')
<style>
    /* Reset default page spacing so header sits at the very top */
    html,
    body {
        margin: 0;
        padding: 0;
    }

    /* Make header fixed at the top but minimal for consistent experience.
       - Hide the main nav links (Việc làm, Công ty, Blog) and "Việc Làm Của Tôi" button.
       - Use a subtle background and small height so it doesn't overpower the page.
       - Adjust `body` padding to match header height. */
    header#header.header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1050;
        width: 100%;
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 6px 18px rgba(16, 24, 40, 0.06);
        backdrop-filter: blur(4px);
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }

    /* Reduce header internal spacing for a compact look */
    .header-container {
        padding: 10px 16px;
        max-width: 1200px;
        margin: 0 auto;
        align-items: center;
    }

    /* Hide entire nav on this page (logo already links home) */
    #navmenu ul li {
        display: none !important;
    }

    /* Hide "Việc Làm Của Tôi" action button in header */
    .btn-my-jobs {
        display: none !important;
    }

    /* Optionally hide recommendations button to keep header minimal */
    .btn-recommendations {
        opacity: 0.9;
        font-size: 0.95rem;
        padding: 6px 10px;
    }

    /* Body padding to prevent content being hidden under fixed header (adjust if needed) */

    /* Thêm vào phần <style> của my-jobs.blade.php */
    /* Job Title Hover Effect */
    .job-title a {
        transition: all 0.3s ease;
        position: relative;
    }

    .job-title a:hover {
        color: var(--primary-color) !important;
    }

    .job-title a::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--primary-color);
        transition: width 0.3s ease;
    }

    .job-title a:hover::after {
        width: 100%;
    }

    /* Job Card Hover Effect */
    .job-card-modern {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .job-card-modern:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        border-color: var(--primary-color);
    }

    /* Prevent hover effect when clicking buttons */
    .btn-action,
    .cancel-application-btn,
    .unsave-job-btn,
    .btn-apply-now {
        position: relative;
        z-index: 10;
    }

    /* Job Title Clickable */
    .job-title {
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .job-title:hover {
        color: var(--primary-color);
        text-decoration: underline;
    }

    /* Thêm vào phần CSS của my-jobs.blade.php */
    /* Status Filter Pills */
    /* Modal Styling */
    /* Fix Modal Scroll - Simple Version */
    .modal-apply-job .modal-body {
        max-height: calc(90vh - 200px);
        overflow-y: auto;
    }

    .modal-apply-job .modal-content {
        border-radius: 20px;
        border: none;
    }

    .modal-apply-job .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px 20px 0 0;
        padding: 1.5rem;
    }

    .modal-apply-job .modal-title {
        font-weight: 700;
        font-size: 1.25rem;
    }

    .modal-apply-job .btn-close {
        filter: brightness(0) invert(1);
    }

    /* CV Option Cards */
    .cv-option-card {
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: block;
        height: 100%;
    }

    .cv-option-card input[type="radio"] {
        display: none;
    }

    .cv-option-card:hover {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.05);
    }

    .cv-option-card.active {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.1);
    }

    .cv-option-icon {
        font-size: 2.5rem;
        color: #667eea;
        margin-bottom: 1rem;
    }

    .cv-option-title {
        font-weight: 600;
        font-size: 1.1rem;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .cv-option-desc {
        color: #6b7280;
        font-size: 0.9rem;
    }

    /* Upload Area */
    .upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 16px;
        padding: 3rem 2rem;
        text-align: center;
        transition: all 0.3s ease;
        background: #f9fafb;
    }

    .upload-area:hover,
    .upload-area.dragover {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.05);
    }

    .upload-icon {
        font-size: 3rem;
        color: #667eea;
        margin-bottom: 1rem;
    }

    /* Profile Preview */
    .profile-preview-card {
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        padding: 1.5rem;
        background: #f9fafb;
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        object-fit: cover;
        margin-right: 1.5rem;
    }

    .profile-name {
        font-weight: 700;
        font-size: 1.25rem;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }

    .profile-title {
        color: #667eea;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .profile-contact {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6b7280;
        font-size: 0.9rem;
    }

    .contact-item i {
        color: #667eea;
    }

    /* Form Styling */
    .form-control {
        border-radius: 10px;
        border: 2px solid #e5e7eb;
        padding: 0.75rem 1rem;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .letter-textarea {
        min-height: 150px;
        resize: vertical;
    }

    .char-count {
        text-align: right;
        color: #6b7280;
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }

    .required-mark {
        color: #ef4444;
    }

    /* Buttons */
    .btn-cancel {
        background: #f3f4f6;
        color: #374151;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #e5e7eb;
        color: #1f2937;
    }

    .btn-submit-apply {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-submit-apply:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
    }

    .btn-apply-now {
        transition: all 0.3s ease !important;
    }

    .btn-apply-now:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4) !important;
        color: white !important;
    }

    .btn-apply-now:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .status-filter-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        background: white;
        padding: 1.25rem;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
    }

    .filter-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        background: white;
        color: #64748b;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .filter-pill i {
        font-size: 1.1rem;
    }

    .filter-pill:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
        background: rgba(79, 70, 229, 0.05);
        transform: translateY(-2px);
    }

    .filter-pill.active {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border-color: transparent;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    }

    .pill-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 24px;
        height: 24px;
        padding: 0 0.5rem;
        background: rgba(79, 70, 229, 0.15);
        color: var(--primary-color);
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .filter-pill.active .pill-badge {
        background: rgba(255, 255, 255, 0.3);
        color: white;
    }

    .filter-pill:hover .pill-badge {
        background: rgba(79, 70, 229, 0.2);
    }

    /* Hide/Show jobs based on filter */
    .job-card-modern {
        transition: all 0.3s ease;
    }

    .job-card-modern.hidden {
        display: none;
    }

    /* Status Badge - Thêm trạng thái Hết hạn */
    .status-badge.expired {
        background: rgba(107, 114, 128, 0.15);
        color: #6b7280;
        border: 1px dashed #9ca3af;
    }

    .status-badge.secondary {
        background: rgba(148, 163, 184, 0.1);
        color: #64748b;
    }



    /* Alert boxes nhỏ gọn */
    .alert.p-2 {
        border-radius: 8px;
        font-size: 0.85rem;
        line-height: 1.4;
    }

    /* Icon trong status badge */
    .status-badge i {
        font-size: 1rem;
    }

    /* Tooltip cho status badge */
    .status-badge[title] {
        cursor: help;
    }

    :root {
        --primary-color: #4f46e5;
        --secondary-color: #06b6d4;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #3b82f6;
        --light-bg: #f8fafc;
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        --hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
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
        padding-top: 84px;
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
        border-radius: 24px !important;
        box-shadow: var(--card-shadow) !important;
        border: none !important;
        transition: all 0.3s ease;
        position: sticky;
        top: 100px;
        overflow: hidden;
    }

    .sidebar-card:hover {
        box-shadow: var(--hover-shadow) !important;
        transform: translateY(-4px);
    }

    .sidebar-card .card-body {
        padding: 2rem;
    }

    /* Avatar Wrapper */
    .avatar-wrapper-modern {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 1rem;
    }

    .avatar-wrapper-modern img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid var(--primary-color);
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
    }

    .status-badge-modern {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 24px;
        height: 24px;
        background: #10b981;
        border: 3px solid white;
        border-radius: 50%;
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
        .status-filter-pills {
            padding: 1rem;
            gap: 0.5rem;
        }

        .filter-pill {
            padding: 0.6rem 1rem;
            font-size: 0.85rem;
        }

        .filter-pill span:not(.pill-badge) {
            display: none;
        }

        .filter-pill i {
            margin: 0;
        }

        .pill-badge {
            min-width: 20px;
            height: 20px;
            font-size: 0.7rem;
        }

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

        /* Make avatar smaller on mobile */
        .avatar-wrapper-modern,
        .avatar-wrapper-modern img {
            width: 84px !important;
            height: 84px !important;
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
                            <a href="{{ route('applicant.hoso') }}" class="btn btn-primary btn-sm w-100 mb-3">
                                <i class="bi bi-pencil-square me-2"></i>Cập nhật hồ sơ
                            </a>
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
                                    <a href="#" class="nav-link text-dark tab-link-attachments" data-tab="attachments"><i class="bi bi-file-earmark-text"></i> Hồ sơ đính kèm</a>

                                </li>
                                <li class="nav-item mb-2">
                                    <a href="{{ route('applicant.myJobs') }}" class="nav-link active text-primary fw-bold">
                                        <i class="bi bi-briefcase"></i> Việc làm của tôi
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="{{ route('applicant.jobInvitations') }}" class="nav-link text-dark">
                                        <i class="bi bi-envelope"></i> Lời mời công việc
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

                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h3 class="text-white fw-bold mb-0">
                            <i class="bi bi-briefcase-fill me-2"></i>Việc làm của tôi
                        </h3>
                        <a href="{{ route('applicant.hoso') }}#tab-attachments" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-file-earmark-arrow-up me-2"></i>Cập nhật CV
                        </a>
                    </div>

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
                        <!-- Tab Đã ứng tuyển -->
                        <div class="tab-pane fade show active" id="applied" role="tabpanel">
                            <!-- Status Filter Pills -->
                            @if($applications->count() > 0)
                            <div class="status-filter-pills mb-4">
                                <button class="filter-pill active" data-status="all">
                                    <i class="bi bi-grid-fill"></i>
                                    <span>Tất cả</span>
                                    <span class="pill-badge">{{ $applications->count() }}</span>
                                </button>
                                <button class="filter-pill" data-status="cho_xu_ly">
                                    <i class="bi bi-hourglass-split"></i>
                                    <span>Chờ xử lý</span>
                                    <span class="pill-badge">{{ $applications->where('trang_thai', 'cho_xu_ly')->count() }}</span>
                                </button>
                                <button class="filter-pill" data-status="dang_phong_van">
                                    <i class="bi bi-calendar-check"></i>
                                    <span>Mời phỏng vấn</span>
                                    <span class="pill-badge">{{ $applications->where('trang_thai', 'dang_phong_van')->count() }}</span>
                                </button>
                                <button class="filter-pill" data-status="duoc_chon">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Được chọn</span>
                                    <span class="pill-badge">{{ $applications->where('trang_thai', 'duoc_chon')->count() }}</span>
                                </button>
                                <button class="filter-pill" data-status="khong_phu_hop">
                                    <i class="bi bi-x-circle-fill"></i>
                                    <span>Từ chối</span>
                                    <span class="pill-badge">{{ $applications->where('trang_thai', 'khong_phu_hop')->count() }}</span>
                                </button>

                            </div>
                            @endif

                            @if($applications->count() > 0)
                            @foreach($applications as $app)
                            @php
                            $status = $app->getDisplayStatus();
                            $isExpired = $app->isJobExpired();
                            @endphp

                            <div class="job-card-modern {{ $isExpired ? 'expired' : '' }}" data-status="{{ $status['status'] }}" data-job-id="{{ $app->job_id }}">
                                <div class="row align-items-start">
                                    <!-- Logo công ty -->
                                    <div class="col-md-2 text-center">
                                        <div class="company-logo-wrapper">
                                            @if($app->job && $app->job->company && $app->job->company->logo)
                                            <img src="{{ asset('assets/img/' . $app->job->company->logo) }}" alt="Logo">
                                            @else
                                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667EEA, #764BA2); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.5rem;">
                                                {{ substr($app->job->company->tencty ?? 'C', 0, 1) }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Thông tin công việc -->
                                    <div class="col-md-7">
                                        <!-- ✅ CẬP NHẬT: Thêm link vào job title -->
                                        <h4 class="job-title">
                                            <a href="{{ route('job.detail', $app->job_id) }}"
                                                class="text-decoration-none text-dark hover-underline"
                                                style="color: inherit;">
                                                {{ $app->job->title ?? 'Tiêu đề công việc' }}
                                            </a>
                                            @if($isExpired)
                                            <span class="badge bg-secondary ms-2" style="font-size: 0.7rem;">Hết hạn</span>
                                            @endif
                                        </h4>

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
                                                <strong>Ứng tuyển:</strong>
                                                {{ \Carbon\Carbon::parse($app->ngay_ung_tuyen)->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') }}
                                            </div>
                                            <div>
                                                <i class="bi bi-clock-history"></i>
                                                <strong>Hạn nộp:</strong>
                                                {{ \Carbon\Carbon::parse($app->job->deadline)->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Trạng thái và Actions -->
                                    <div class="col-md-3 text-end">
                                        <div class="status-badge {{ $status['class'] }} mb-3"
                                            title="{{ $status['description'] }}">
                                            <i class="bi {{ $status['icon'] }}"></i>
                                            {{ $status['text'] }}
                                        </div>

                                        <!-- Nút Actions -->
                                        <div class="d-flex flex-column gap-2">
                                            <!-- ✅ CẬP NHẬT: Sử dụng route thay vì anchor link -->
                                            <a href="{{ route('job.detail', $app->job_id) }}"
                                                class="btn btn-action btn-view">
                                                <i class="bi bi-eye me-2"></i>Xem chi tiết
                                            </a>

                                            @if(in_array($status['status'], ['cho_xu_ly', 'dang_phong_van']))
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
                            @php
                            $isExpired = \Carbon\Carbon::now()->isAfter(\Carbon\Carbon::parse($saved->job->deadline));
                            $hasApplied = $applications->where('job_id', $saved->job_id)->count() > 0;
                            @endphp

                            <div class="job-card-modern" data-job-id="{{ $saved->job_id }}">
                                <div class="row align-items-start">
                                    <div class="col-md-2 text-center">
                                        <div class="company-logo-wrapper">
                                            @if($saved->job && $saved->job->company && $saved->job->company->logo)
                                            <img src="{{ asset('assets/img/' . $saved->job->company->logo) }}" alt="Logo">
                                            @else
                                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667EEA, #764BA2); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.5rem;">
                                                {{ substr($saved->job->company->tencty ?? 'C', 0, 1) }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-7">
                                        <!-- ✅ CẬP NHẬT: Thêm link vào job title -->
                                        <h4 class="job-title">
                                            <a href="{{ route('job.detail', $saved->job_id) }}"
                                                class="text-decoration-none text-dark hover-underline"
                                                style="color: inherit;">
                                                {{ $saved->job->title ?? 'Tiêu đề công việc' }}
                                            </a>
                                            @if($isExpired)
                                            <span class="badge bg-secondary ms-2" style="font-size: 0.7rem;">Hết hạn</span>
                                            @endif
                                        </h4>

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
                                                <strong>Đã lưu:</strong>
                                                {{ \Carbon\Carbon::parse($saved->created_at)->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') }}
                                            </div>
                                            <div>
                                                <i class="bi bi-clock-history"></i>
                                                <strong>Hạn nộp:</strong>
                                                {{ \Carbon\Carbon::parse($saved->job->deadline)->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
                                            </div>
                                        </div>

                                        @if($isExpired)
                                        <div class="alert alert-danger p-2 mt-3" style="font-size: 0.8rem; text-align: left;">
                                            <i class="bi bi-exclamation-circle-fill me-2"></i>
                                            <strong>Công việc này đã hết hạn nộp hồ sơ!</strong>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Actions -->
                                    <div class="col-md-3 text-end">
                                        <div class="d-flex flex-column gap-2">
                                            <!-- ✅ CẬP NHẬT: Sử dụng route -->
                                            <a href="{{ route('job.detail', $saved->job_id) }}"
                                                class="btn btn-action btn-view">
                                                <i class="bi bi-eye me-2"></i>Xem chi tiết
                                            </a>

                                            @if($hasApplied)
                                            <button class="btn btn-action" disabled
                                                style="background: #6366f1; color: white; border: none; cursor: not-allowed;">
                                                <i class="bi bi-check-circle me-2"></i>Đã ứng tuyển
                                            </button>
                                            @elseif(!$isExpired)
                                            <button class="btn btn-action btn-apply-now"
                                                style="background: linear-gradient(135deg, #10b981, #34d399); color: white; border: none;"
                                                data-job-id="{{ $saved->job_id }}"
                                                data-job-title="{{ $saved->job->title }}">
                                                <i class="bi bi-send-check me-2"></i>Ứng tuyển ngay
                                            </button>
                                            @else
                                            <button class="btn btn-action" disabled
                                                style="background: #d1d5db; color: #6b7280; border: none; cursor: not-allowed;">
                                                <i class="bi bi-x-circle me-2"></i>Hết hạn nộp
                                            </button>
                                            @endif

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
                                <i class="bi bi-file-earmark-person me-2 text-primary"></i>Chọn CV để ứng tuyển <span class="required-mark">*</span>
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
                                        <div class="profile-title">{{ $applicant->vitritungtuyen ?? 'Chức danh' }}</div>
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
                                <label class="form-label">Số điện thoại <span class="required-mark">*</span></label>
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
                                style="border: 2px solid #10b981; border-radius: 12px; min-height: 150px;"></textarea>
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
    @include('applicant.partials.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ========== XỬ LÝ LINK HỒ SƠ ĐÍNH KÈM ==========
            const attachmentsLink = document.querySelector('.tab-link-attachments');
            if (attachmentsLink) {
                attachmentsLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Chuyển đến trang hoso với tab attachments được kích hoạt
                    window.location.href = "{{ route('applicant.hoso') }}#tab-attachments";
                });
            }

            // ========== XỬ LÝ NÚT ỨNG TUYỂN NGAY ==========
            // ========== XỬ LÝ NÚT ỨNG TUYỂN NGAY ==========
            const applyNowButtons = document.querySelectorAll('.btn-apply-now');

            applyNowButtons.forEach(btn => {
                btn.addEventListener('click', async function() {
                    const jobId = this.dataset.jobId;
                    const jobTitle = this.dataset.jobTitle;

                    // Lưu jobId vào biến global để form biết
                    window.currentJobId = jobId;

                    // Mở modal
                    const modal = new bootstrap.Modal(document.getElementById('applyJobModal'));
                    modal.show();
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
                        showToast('Vui lòng tải lên CV của bạn', 'warning');
                        return;
                    }

                    const jobId = window.currentJobId;

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

                                const modal = bootstrap.Modal.getInstance(document.getElementById('applyJobModal'));
                                if (modal) modal.hide();

                                // Xóa job card khỏi tab "Đã lưu"
                                const savedCard = document.querySelector(`#saved .job-card-modern[data-job-id="${jobId}"]`);
                                if (savedCard) {
                                    savedCard.remove();
                                }

                                // Cập nhật badge count
                                const savedBadge = document.querySelector('#saved-tab .badge');
                                if (savedBadge) {
                                    const currentCount = parseInt(savedBadge.textContent);
                                    savedBadge.textContent = Math.max(0, currentCount - 1);
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

                                // Reset form
                                applyJobForm.reset();
                                window.currentJobId = null;
                                if (fileNameDisplay) fileNameDisplay.style.display = 'none';
                                if (uploadArea) uploadArea.style.display = 'block';
                            } else {
                                if (data.errors) {
                                    const errorMessages = Object.values(data.errors).flat().join(', ');
                                    showToast(errorMessages, 'error');
                                } else {
                                    showToast(data.message || 'Có lỗi xảy ra. Vui lòng thử lại!', 'error');
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('❌ Có lỗi xảy ra khi gửi hồ sơ. Vui lòng thử lại!');
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
            // ========== XỬ LÝ LỌC THEO TRẠNG THÁI ==========
            const filterPills = document.querySelectorAll('.filter-pill');
            const jobCards = document.querySelectorAll('.job-card-modern[data-status]');

            filterPills.forEach(pill => {
                pill.addEventListener('click', function() {
                    const selectedStatus = this.dataset.status;

                    // Cập nhật active state
                    filterPills.forEach(p => p.classList.remove('active'));
                    this.classList.add('active');

                    // Lọc job cards
                    jobCards.forEach(card => {
                        const cardStatus = card.dataset.status;

                        if (selectedStatus === 'all') {
                            card.classList.remove('hidden');
                        } else {
                            if (cardStatus === selectedStatus) {
                                card.classList.remove('hidden');
                            } else {
                                card.classList.add('hidden');
                            }
                        }
                    });

                    // Smooth scroll animation
                    const visibleCards = document.querySelectorAll('.job-card-modern:not(.hidden)');
                    visibleCards.forEach((card, index) => {
                        card.style.animation = 'none';
                        setTimeout(() => {
                            card.style.animation = `fadeInUp 0.4s ease ${index * 0.05}s forwards`;
                        }, 10);
                    });
                });
            });

            // Animation CSS
            const style = document.createElement('style');
            style.textContent = `
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
        `;
            document.head.appendChild(style);
            // ========== KIỂM TRA VÀ CẬP NHẬT TRẠNG THÁI HỦY ỨNG TUYỂN ==========
            const initializeCancelButtons = () => {
                const cancelButtons = document.querySelectorAll('.cancel-application-btn');

                cancelButtons.forEach(btn => {
                    const applicationId = btn.dataset.applicationId;
                    checkCancelEligibility(applicationId, btn);
                });
            };

            /**
             * ✅ KIỂM TRA CÓ THỂ HỦY KHÔNG VÀ CẬP NHẬT TRẠNG THÁI NÚT
             */
            const checkCancelEligibility = async (applicationId, btn) => {
                try {
                    const response = await fetch(`/application/${applicationId}/can-cancel`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (!data.success) return;

                    const {
                        can_cancel,
                        hours_elapsed,
                        minutes_remaining,
                        cancel_deadline,
                        reason_if_cannot
                    } = data;

                    // ✅ CẬP NHẬT TRẠNG THÁI NÚT
                    if (!can_cancel) {
                        btn.disabled = true;
                        btn.style.opacity = '0.5';
                        btn.style.cursor = 'not-allowed';
                        btn.title = reason_if_cannot || 'Không thể hủy ứng tuyển này';

                        // Cập nhật text nút
                        if (hours_elapsed > 24) {
                            btn.innerHTML = '<i class="bi bi-x-lg me-2"></i>Quá hạn hủy';
                        }
                    } else {
                        // ✅ CÒN CÓ THỂ HỦY - HIỂN THỊ THỜI GIÃ CÒN LẠI
                        btn.disabled = false;
                        btn.style.opacity = '1';
                        btn.style.cursor = 'pointer';

                        // Hiển thị thời gian còn lại trong title
                        if (minutes_remaining > 0) {
                            const hoursLeft = Math.floor(minutes_remaining / 60);
                            const minsLeft = minutes_remaining % 60;
                            let timeText = '';

                            if (hoursLeft > 0) {
                                timeText = `${hoursLeft}h ${minsLeft}p`;
                            } else {
                                timeText = `${minsLeft}p`;
                            }

                            btn.title = `Hủy được trong vòng 24h (Còn ${timeText})`;
                            btn.setAttribute('data-time-remaining', timeText);
                        }
                    }

                    // ✅ THÊM DATA ATTRIBUTES CHO THÔNG BÁO
                    btn.dataset.canCancel = can_cancel;
                    btn.dataset.hoursElapsed = hours_elapsed;
                    btn.dataset.cancelDeadline = cancel_deadline;

                } catch (error) {
                    console.error('Lỗi kiểm tra trạng thái hủy:', error);
                }
            };
            // ========== XỬ LÝ HỦY ỨNG TUYỂN ==========
            const cancelButtons = document.querySelectorAll('.cancel-application-btn');

            cancelButtons.forEach(btn => {
                btn.addEventListener('click', async function(e) {
                    const applicationId = this.dataset.applicationId;
                    const jobTitle = this.dataset.jobTitle;
                    const canCancel = this.dataset.canCancel === 'true';
                    const hoursElapsed = parseInt(this.dataset.hoursElapsed);
                    const cancelDeadline = this.dataset.cancelDeadline;

                    // Nếu không được phép hủy, hiển thị thông báo
                    if (!canCancel) {
                        if (hoursElapsed > 24) {
                            alert(`❌ Quá hạn hủy ứng tuyển!\n\nHạn thời gian hủy ứng tuyển đã hết (24 giờ kể từ khi ứng tuyển).\nHạn kết thúc lúc: ${cancelDeadline}`);
                        } else {
                            alert(`❌ Không thể hủy ứng tuyển này.`);
                        }
                        return;
                    }

                    // Xác nhận hủy
                    if (!confirm(`Bạn có chắc muốn hủy đơn ứng tuyển vào vị trí "${jobTitle}"?\n\n⚠️ Lưu ý: Bạn chỉ có thể hủy trong vòng 24 giờ kể từ khi ứng tuyển.`)) {
                        return;
                    }

                    // Hiển thị loading
                    const originalHtml = this.innerHTML;
                    this.disabled = true;
                    this.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Đang hủy...';

                    try {
                        const response = await fetch(`/application/${applicationId}/cancel`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (data.success) {
                            alert('✅ ' + data.message);

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
                            alert('❌ ' + (data.message || 'Có lỗi xảy ra!'));
                            this.disabled = false;
                            this.innerHTML = originalHtml;
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('❌ Có lỗi xảy ra khi hủy đơn ứng tuyển!');
                        this.disabled = false;
                        this.innerHTML = originalHtml;
                    }
                });
            });
            // ✅ Khởi tạo kiểm tra khi trang load
            initializeCancelButtons();

            // ✅ CẬP NHẬT LẶP LẠI MỖI 1 PHÚT ĐỂ KIỂM TRA THỜI GIAN CÒN LẠI
            setInterval(() => {
                initializeCancelButtons();
            }, 60000); // 60 giây

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
                                showToast(data.message || 'Có lỗi xảy ra!', 'error');
                                this.disabled = false;
                                this.innerHTML = originalHtml;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('Có lỗi xảy ra khi bỏ lưu công việc!', 'error');
                            this.disabled = false;
                            this.innerHTML = originalHtml;
                        });
                });
            });

        });
    </script>

    <!-- ✅ Toast Notification System -->
    <script src="{{ asset('js/toast.js') }}"></script>
</body>

</html>