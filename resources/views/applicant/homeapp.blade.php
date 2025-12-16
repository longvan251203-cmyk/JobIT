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
    /* Smooth scroll behavior */
    html {
        scroll-behavior: smooth;
    }

    /* Scroll margin for fixed header */
    #jobs-section,
    #companies-section,
    #blog-section {
        scroll-margin-top: 120px;
    }

    /* Thêm vào phần style của file */

    .btn-notifications {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        position: relative;
    }

    .btn-notifications:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-notifications i {
        font-size: 1.1rem;
    }

    .btn-notifications .badge-count {
        background: #ef4444;
        color: white;
        font-size: 0.7rem;
        padding: 0.15rem 0.4rem;
        border-radius: 10px;
        font-weight: 700;
        min-width: 20px;
        text-align: center;
        animation: badgePulse 2s ease-in-out infinite;
    }

    @keyframes badgePulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
    }

    /* ========================================
   RECOMMENDED JOBS - APPLY BUTTON COLORS
======================================== */
    .rec-btn-primary {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: white;
        flex: 2;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .rec-btn-primary:hover:not(:disabled):not(.applied) {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
        background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
    }

    .rec-btn-primary:active:not(:disabled):not(.applied) {
        transform: translateY(0);
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }

    /* ✅ APPLIED STATE - XANH DƯƠNG */
    .rec-btn-primary.applied {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%) !important;
        cursor: not-allowed;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        opacity: 0.9;
    }

    .rec-btn-primary.applied:hover {
        transform: none;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%) !important;
    }

    .rec-btn-primary.applied i {
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
   RECOMMENDED JOBS - ĐỒNG BỘ VỚI JOB BÌNH THƯỜNG
======================================== */

    /* Grid View - Recommended Jobs */
    .recommended-jobs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
        gap: 1.5rem;
        margin: 2rem 0;
    }

    /* Recommended Job Card - Đồng bộ với job-card-grid */
    .recommended-job-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        border: 2px solid transparent;
        cursor: pointer;
        min-height: 420px;
        display: flex;
        flex-direction: column;
    }

    .recommended-job-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
        border-color: rgba(102, 126, 234, 0.3);
    }

    /* Match Badge - Đặt ở góc trên phải */
    .match-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 1.1rem;
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

    /* Company Header - Đồng bộ với job-card-grid-header */
    .rec-job-header {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        padding-right: 70px;
        /* Space for match badge */
    }

    .rec-company-logo {
        width: 64px;
        height: 64px;
        border-radius: 12px;
        flex-shrink: 0;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        background: #f3f4f6;
    }

    .rec-company-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .rec-job-info {
        flex: 1;
        min-width: 0;
    }

    .rec-job-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 0.5rem 0;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .rec-company-name {
        font-size: 0.9rem;
        color: #718096;
        margin: 0;
        font-weight: 500;
    }

    /* Meta Information */
    .rec-job-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e5e7eb;
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
        font-size: 1.15rem;
        font-weight: 700;
        color: #10b981;
        margin-bottom: 1rem;
        padding: 0.75rem 1rem;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(16, 185, 129, 0.05) 100%);
        border-radius: 10px;
        text-align: center;
        border-left: 4px solid #10b981;
    }

    .rec-job-salary .negotiable {
        color: #667eea;
    }

    /* Tags */
    .rec-job-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
        min-height: 36px;
    }

    .rec-tag {
        font-size: 0.75rem;
        padding: 0.35rem 0.75rem;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(102, 126, 234, 0.05) 100%);
        color: #667eea;
        border-radius: 16px;
        font-weight: 600;
        white-space: nowrap;
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
        margin-bottom: auto;
        padding-bottom: 1rem;
    }

    .rec-job-deadline i {
        color: #fa709a;
    }

    /* Action Buttons */
    .rec-job-actions {
        display: flex;
        gap: 0.6rem;
        margin-top: auto;
    }

    .rec-btn {
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
        min-height: 44px;
    }

    .rec-btn-primary {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        flex: 1;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .rec-btn-primary:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
    }

    .rec-btn-primary.applied {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        cursor: not-allowed;
        opacity: 0.9;
    }

    .rec-btn-detail {
        width: 44px;
        min-width: 44px;
        padding: 0;
        background: white;
        color: #718096;
        border: 2px solid #e5e7eb;
    }

    .rec-btn-detail:hover {
        border-color: #667eea;
        color: #667eea;
        background: rgba(102, 126, 234, 0.05);
    }

    .rec-btn-icon {
        width: 44px;
        min-width: 44px;
        padding: 0;
        background: white;
        color: #718096;
        border: 2px solid #e5e7eb;
    }

    .rec-btn-icon:hover {
        border-color: #ef4444;
        color: #ef4444;
        background: rgba(239, 68, 68, 0.05);
    }

    .rec-btn-icon.saved {
        border-color: #ef4444;
        color: #ef4444;
        background: rgba(239, 68, 68, 0.08);
    }

    /* ========================================
   RECOMMENDED DETAIL VIEW - 2 COLUMNS
======================================== */
    .recommended-detail-view {
        display: grid;
        grid-template-columns: 450px 1fr;
        gap: 1.5rem;
        margin-top: 2rem;
        position: relative;
        align-items: start;
        min-height: calc(100vh - 250px);
    }

    .back-to-grid-rec {
        position: absolute;
        top: -50px;
        left: 0;
        background: none;
        border: none;
        color: #667eea;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        z-index: 10;
    }

    .back-to-grid-rec:hover {
        background: rgba(102, 126, 234, 0.1);
    }

    /* Left Column - Job List */
    .rec-list-column {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1rem;
        height: calc(100vh - 250px);
        overflow-y: auto;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .rec-list-header {
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e5e7eb;
        flex-shrink: 0;
    }

    .rec-list-header h3 {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 0.5rem 0;
    }

    .rec-list-header p {
        margin: 0;
        font-size: 0.9rem;
        color: #718096;
    }

    #recJobsList {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        flex: 1;
        overflow-y: auto;
    }

    /* Job List Item - Đồng bộ với job-card */
    .rec-job-list-item {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.25rem;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        gap: 1rem;
    }

    .rec-job-list-item:hover,
    .rec-job-list-item.active {
        border-color: #667eea;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
        transform: translateX(4px);
    }

    .rec-job-list-item.active {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    }

    .rec-list-match-badge {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 1rem;
        flex-shrink: 0;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }

    .rec-job-list-item.high-match .rec-list-match-badge {
        background: linear-gradient(135deg, #11998e, #38ef7d);
    }

    .rec-list-logo {
        width: 56px;
        height: 56px;
        border-radius: 10px;
        flex-shrink: 0;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .rec-list-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .rec-list-content {
        flex: 1;
        min-width: 0;
    }

    .rec-list-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 0.4rem 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .rec-list-company {
        font-size: 0.85rem;
        color: #718096;
        margin: 0 0 0.5rem 0;
    }

    .rec-list-meta {
        display: flex;
        gap: 1rem;
        margin-bottom: 0.5rem;
        font-size: 0.8rem;
        color: #6b7280;
    }

    .rec-list-meta span {
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .rec-list-meta i {
        color: #667eea;
    }

    .rec-list-salary {
        font-size: 0.95rem;
        font-weight: 700;
        color: #10b981;
    }

    .rec-list-actions {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        flex-shrink: 0;
    }

    .rec-list-apply,
    .rec-list-save {
        width: 40px;
        height: 40px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        background: white;
        color: #718096;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .rec-list-apply i,
    .rec-list-save i {
        color: inherit;
    }

    .rec-list-apply:hover {
        border-color: #10b981;
        color: #10b981;
        background: rgba(16, 185, 129, 0.05);
    }

    .rec-list-save:hover {
        border-color: #ef4444;
        color: #ef4444;
        background: rgba(239, 68, 68, 0.05);
    }

    .rec-list-save.saved {
        border-color: #ef4444;
        color: #ef4444;
        background: rgba(239, 68, 68, 0.08);
    }

    .rec-list-save.saved i {
        color: #ef4444 !important;
    }

    /* Right Column - Job Detail */
    .rec-detail-column {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        height: calc(100vh - 250px);
        overflow-y: auto;
        position: relative;
    }

    .rec-job-detail-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #9ca3af;
        padding: 2rem;
        text-align: center;
    }

    .rec-job-detail-empty i {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        opacity: 0.4;
    }

    /* Job Detail Header */
    .job-detail-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        margin-bottom: 0;
    }

    .job-detail-company {
        display: flex;
        gap: 1rem;
        align-items: start;
        margin-bottom: 1.5rem;
    }

    .company-logo-large {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: none;
        flex-shrink: 0;
        background: #f7fafc;
        border: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .company-logo-large img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .job-detail-title-section {
        flex: 1;
    }

    .job-detail-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 0.5rem 0;
        line-height: 1.3;
    }

    .job-detail-title a:hover {
        color: #667eea !important;
    }

    .job-detail-company-name {
        font-size: 1.1rem;
        color: #6b7280;
        font-weight: 600;
        margin-bottom: 1rem;
        display: block;
    }

    .job-detail-salary {
        display: inline-block;
        font-size: 1.3rem;
        font-weight: 700;
        color: #10b981;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
        border-radius: 12px;
        border-left: 4px solid #10b981;
    }

    .job-detail-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .save-btn-large {
        padding: 0.875rem 1.25rem;
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        color: #6b7280;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .save-btn-large:hover {
        border-color: #fa709a;
        color: #fa709a;
        transform: scale(1.05);
    }

    .save-btn-large.saved {
        background: #fa709a;
        border-color: #fa709a;
        color: white;
    }

    /* Job Detail Content */
    .job-detail-content {
        padding: 1.5rem;
        margin-top: 0;
    }

    .detail-section {
        margin-bottom: 1.5rem;
    }

    .detail-section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-section-title i {
        color: #667eea;
        font-size: 1.3rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-top: 1rem;
    }

    .info-item {
        background: #f9fafb;
        padding: 1rem;
        border-radius: 12px;
        border-left: 4px solid #667eea;
    }

    .info-label {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-label i {
        color: #667eea;
    }

    .info-value {
        font-size: 1rem;
        color: #1f2937;
        font-weight: 600;
    }

    .job-description {
        font-size: 1rem;
        line-height: 1.8;
        color: #4b5563;
        white-space: pre-wrap;
    }

    /* Custom Scrollbar */
    .rec-list-column::-webkit-scrollbar,
    .rec-detail-column::-webkit-scrollbar {
        width: 6px;
    }

    .rec-list-column::-webkit-scrollbar-track,
    .rec-detail-column::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .rec-list-column::-webkit-scrollbar-thumb,
    .rec-detail-column::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    .rec-list-column::-webkit-scrollbar-thumb:hover,
    .rec-detail-column::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* ========================================
   RESPONSIVE
======================================== */
    @media (max-width: 1400px) {
        .recommended-jobs-grid {
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        }

        .recommended-detail-view {
            grid-template-columns: 450px 1fr;
        }
    }

    @media (max-width: 1200px) {
        .recommended-detail-view {
            grid-template-columns: 450px 1fr;
            gap: 1.5rem;
        }
    }

    @media (max-width: 992px) {
        .recommended-jobs-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        }

        .recommended-detail-view {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .rec-list-column {
            height: auto;
            max-height: 400px;
            position: relative;
            top: auto;
            order: 2;
        }

        .rec-detail-column {
            height: auto;
            min-height: 500px;
            order: 1;
        }

        .back-to-grid-rec {
            position: relative;
            top: auto;
            margin-bottom: 1rem;
        }
    }

    @media (max-width: 768px) {
        .recommended-jobs-grid {
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }

        .recommended-job-card {
            min-height: auto;
        }

        .match-badge {
            width: 55px;
            height: 55px;
            font-size: 1rem;
        }

        .rec-job-header {
            padding-right: 60px;
        }

        .rec-job-list-item {
            flex-wrap: wrap;
        }

        .rec-list-actions {
            flex-direction: row;
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .match-badge {
            width: 50px;
            height: 50px;
            font-size: 0.9rem;
        }

        .rec-btn {
            font-size: 0.85rem;
            padding: 0.65rem;
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

    /* ========================================
   NÚT ĐƯỢC MỜI - INVITED STATE (PENDING)
======================================== */
    .btn-apply-now.invited:not(.accepted):not(.rejected) {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        animation: invitePulse 2s ease-in-out infinite;
    }

    .btn-apply-now.invited:not(.accepted):not(.rejected):hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.4);
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    }

    @keyframes invitePulse {

        0%,
        100% {
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        50% {
            box-shadow: 0 8px 20px rgba(245, 158, 11, 0.5);
        }
    }

    .btn-apply-now.invited:not(.accepted):not(.rejected) i {
        animation: starSpin 2s linear infinite;
    }

    @keyframes starSpin {
        0% {
            transform: rotate(0deg) scale(1);
        }

        50% {
            transform: rotate(180deg) scale(1.1);
        }

        100% {
            transform: rotate(360deg) scale(1);
        }
    }

    /* ========================================
   NÚT CHẤP NHẬN LỜI MỜI - ACCEPTED STATE
======================================== */
    .btn-apply-now.invited.accepted {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        cursor: not-allowed;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        opacity: 0.9;
    }

    .btn-apply-now.invited.accepted:hover {
        transform: none;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .btn-apply-now.invited.accepted i {
        animation: checkPulse 1.5s ease-in-out infinite;
    }

    /* ========================================
   NÚT TỪ CHỐI LỜI MỜI - REJECTED STATE
======================================== */
    .btn-apply-now.invited.rejected {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        cursor: not-allowed;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        opacity: 0.9;
    }

    .btn-apply-now.invited.rejected:hover {
        transform: none;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .btn-apply-now.invited.rejected i {
        animation: xRotate 1.5s ease-in-out infinite;
    }

    @keyframes xRotate {

        0%,
        100% {
            transform: rotate(0deg) scale(1);
        }

        50% {
            transform: rotate(90deg) scale(1.05);
        }
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
   2 NÚT CHẤP NHẬN/TỪ CHỐI LỜI MỜI
======================================== */
    .invitation-response-buttons {
        display: flex;
        gap: 0.75rem;
    }

    .invitation-response-buttons .btn {
        padding: 0.6rem 1rem;
        font-size: 0.95rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
    }

    .invitation-response-buttons .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .invitation-response-buttons .btn-success:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    }

    .invitation-response-buttons .btn-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .invitation-response-buttons .btn-danger:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
    }

    .invitation-response-buttons .btn i {
        margin-right: 0.4rem;
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
   MODAL LỜI MỜI
======================================== */
    #invitationResponseModal .modal-content {
        border: none;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    #invitationResponseModal .modal-body {
        padding: 2rem;
    }

    #invitationResponseModal .btn-outline-danger,
    #invitationResponseModal .btn-primary {
        padding: 0.75rem 2rem;
        font-weight: 600;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    #invitationResponseModal .btn-outline-danger {
        color: #ef4444;
        border-color: #ef4444;
    }

    #invitationResponseModal .btn-outline-danger:hover {
        background: #ef4444;
        border-color: #ef4444;
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(239, 68, 68, 0.3);
    }

    #invitationResponseModal .btn-primary {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
    }

    #invitationResponseModal .btn-primary:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(16, 185, 129, 0.3);
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
        border-radius: 12px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .rec-btn-icon:hover {
        border-color: #ef4444;
        color: #ef4444;
        background: rgba(239, 68, 68, 0.05);
    }

    /* ✅ THÊM PHẦN NÀY: Style cho state đã lưu */
    .rec-btn-icon.saved {
        border-color: #ef4444;
        color: #ef4444;
        background: rgba(239, 68, 68, 0.08);
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.2);
    }

    .rec-btn-icon.saved:hover {
        border-color: #dc2626;
        color: #dc2626;
        background: rgba(239, 68, 68, 0.15);
    }

    .rec-btn-icon.saved i {
        animation: heartBeat 0.6s ease;
    }

    @keyframes heartBeat {

        0%,
        100% {
            transform: scale(1);
        }

        25% {
            transform: scale(1.3);
        }

        50% {
            transform: scale(1);
        }
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
                    <li><a href="#jobs-section">Việc làm</a></li>
                    <li><a href="#companies-section">Công ty</a></li>
                    <li><a href="#blog-section">Blog</a></li>
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
                <!-- ✨ NÚT THÔNG BÁO - GIỐNG HOME.BLADE -->
                <div class="position-relative">
                    <button id="btnNotifications" style="background: none; border: none; cursor: pointer; padding: 0.5rem;" class="position-relative">
                        <i class="bi bi-bell-fill" style="font-size: 1.3rem; color: #667eea;"></i>
                        @php
                        $unreadCount = \App\Models\Notification::where('user_id', Auth::id())
                        ->where('is_read', false)
                        ->count();
                        @endphp
                        @if($unreadCount > 0)
                        <span id="notificationBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem; min-width: 20px;">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
                        @else
                        <span id="notificationBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none" style="font-size: 0.6rem; min-width: 20px;">0</span>
                        @endif
                    </button>

                    <!-- DROPDOWN THÔNG BÁO -->
                    <div id="notificationDropdown" class="position-absolute" style="top: calc(100% + 8px); right: 0; width: 500px; background: white; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); border: 1px solid #e5e7eb; z-index: 1000; max-height: 600px; display: none; flex-direction: column;">
                        <!-- Header -->
                        <div style="padding: 1.25rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                            <h3 style="margin: 0; font-size: 1.2rem; font-weight: 700; color: #1f2937;">Thông báo</h3>
                            <button id="btnMarkAllRead" style="background: none; border: none; color: #667eea; font-size: 0.8rem; font-weight: 600; cursor: pointer;">Đánh dấu tất cả đã đọc</button>
                        </div>

                        <!-- Notification List -->
                        <div id="notificationList" style="flex: 1; overflow-y: auto;">
                            <div style="padding: 2.5rem 1.5rem; text-align: center; color: #9ca3af;">
                                <i class="bi bi-inbox" style="font-size: 2.5rem; display: block; margin-bottom: 0.75rem; color: #d1d5db;"></i>
                                <p style="margin: 0;">Chưa có thông báo nào</p>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="user-dropdown">
                    <button class="user-btn" id="userDropdownBtn">
                        <img src="{{ Auth::user()->applicant->avatar ? asset('assets/img/avt/'.Auth::user()->applicant->avatar) : asset('assets/img/avt/default-avatar.png') }}" alt="" class="user-avatar">
                        <span class="user-name">{{ Auth::user()->applicant->hoten_uv ?? Auth::user()->email }}</span>
                        <i class="bi bi-chevron-down"></i>
                    </button>
                    <ul class="user-dropdown-menu" id="userDropdownMenu">
                        <li><a href="{{ route('applicant.profile') }}"><i class="bi bi-person"></i> Hồ sơ</a></li>
                        <li><a href="{{ route('applicant.hoso') }}"><i class="bi bi-info-circle"></i> Thông tin cá nhân</a></li>
                        <li><a href="{{ route('applicant.hoso') }}"><i class="bi bi-file-earmark-text"></i> Hồ sơ đính kèm</a></li>

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
                        <li><a href="{{ route('applicant.jobInvitations') }}"><i class="bi bi-envelope"></i> Lời mời công việc</a></li>

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
            <!-- 1. Dropdown Mức lương -->
            <div class="filter-dropdown-wrapper">
                <button class="filter-btn" id="salaryFilterBtn">
                    <i class="bi bi-cash-coin"></i>
                    <span>Mức lương</span>
                    <i class="bi bi-chevron-down ms-2"></i>
                </button>
                <div class="filter-dropdown-menu" id="salaryDropdown">
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="salary" value="all" checked>
                        <span>-- Tất cả mức lương --</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="salary" value="under_5">
                        <span>Dưới 5 triệu VNĐ</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="salary" value="5_10">
                        <span>5 - 10 triệu VNĐ</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="salary" value="10_15">
                        <span>10 - 15 triệu VNĐ</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="salary" value="15_20">
                        <span>15 - 20 triệu VNĐ</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="salary" value="20_30">
                        <span>20 - 30 triệu VNĐ</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="salary" value="30_plus">
                        <span>Trên 30 triệu VNĐ</span>
                    </label>
                </div>
            </div>

            <!-- 2. Dropdown Vị trí tuyển dụng -->
            <!-- 2. Dropdown Vị trí tuyển dụng -->
            <div class="filter-dropdown-wrapper">
                <button class="filter-btn" id="positionFilterBtn">
                    <i class="bi bi-briefcase"></i>
                    <span>Vị trí tuyển dụng</span>
                    <i class="bi bi-chevron-down ms-2"></i>
                </button>
                <div class="filter-dropdown-menu" id="positionDropdown">
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="position" value="all" checked>
                        <span>-- Tất cả vị trí --</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="position" value="Thực tập sinh">
                        <span>Thực tập sinh</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="position" value="Cộng tác viên">
                        <span>Cộng tác viên</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="position" value="Nhân viên chính thức">
                        <span>Nhân viên chính thức</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="position" value="Nhân viên part-time">
                        <span>Nhân viên part-time</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="position" value="Nhân viên hợp đồng">
                        <span>Nhân viên hợp đồng</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="position" value="Nhân viên thử việc">
                        <span>Nhân viên thử việc</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="position" value="Freelancer">
                        <span>Freelancer</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="position" value="Nhân viên dự án">
                        <span>Nhân viên dự án</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="position" value="Quản lý">
                        <span>Quản lý</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="position" value="Giám đốc">
                        <span>Giám đốc</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="position" value="Giám đốc bộ phận">
                        <span>Giám đốc bộ phận</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="position" value="Trưởng nhóm">
                        <span>Trưởng nhóm</span>
                    </label>
                </div>
            </div>

            <!-- 3. Dropdown Kinh nghiệm -->
            <div class="filter-dropdown-wrapper">
                <button class="filter-btn" id="experienceFilterBtn">
                    <i class="bi bi-award"></i>
                    <span>Kinh nghiệm</span>
                    <i class="bi bi-chevron-down ms-2"></i>
                </button>
                <div class="filter-dropdown-menu" id="experienceDropdown">
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="experience" value="all" checked>
                        <span>-- Tất cả kinh nghiệm --</span>
                    </label>
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
                        <span>1 - 2 năm</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="experience" value="2_5">
                        <span>2 - 5 năm</span>
                    </label>
                    <label class="filter-checkbox-item">
                        <input type="checkbox" name="experience" value="5_plus">
                        <span>Trên 5 năm</span>
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
    <!-- ========== OVERVIEW SECTION ========== tổng quan -->
    <section class="overview-section">
        <div class="main-container">
            <div class="row g-4">
                <!-- Total Jobs -->
                <div class="col-md-3">
                    <div class="overview-card">
                        <div class="overview-number">{{ $stats['total_jobs'] ?? 0 }}</div>
                        <div class="overview-label">Công việc IT</div>
                    </div>
                </div>

                <!-- Total Companies -->
                <div class="col-md-3">
                    <div class="overview-card">
                        <div class="overview-number">{{ $stats['total_companies'] ?? 0 }}</div>
                        <div class="overview-label">Công ty hàng đầu</div>
                    </div>
                </div>

                <!-- Total Applicants (ĐÃ TÌMVIỆC) -->
                <div class="col-md-3">
                    <div class="overview-card">
                        <div class="overview-number">{{ $stats['total_applicants'] ?? 0 }}</div>
                        <div class="overview-label">Ứng viên đã tìm việc</div>
                    </div>
                </div>

                <!-- Total Applications (ĐÃ ỨNG TUYỂN) -->
                <div class="col-md-3">
                    <div class="overview-card">
                        <div class="overview-number">{{ $stats['total_applications'] ?? 0 }}</div>
                        <div class="overview-label">Hồ sơ ứng tuyển</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== ALL JOBS SECTION ========== -->
    <div class="main-container" id="jobs-section">
        <div class="featured-section">
            <div class="section-title-highlight">
                <div class="section-subtitle">TẤT CẢ CÔNG VIỆC</div>
                <h2 id="totalJobsTitle">{{ $stats['total_jobs'] }} cơ hội việc làm IT</h2>
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
                        @php
                        // ✅ Ẩn job đã đủ số lượng nhận
                        $selectedCount = $job->selected_count ?? 0;
                        $recruitmentCount = $job->recruitment_count ?? 0;
                        if ($recruitmentCount > 0 && $selectedCount >= $recruitmentCount) {
                        continue; // Bỏ qua job này
                        }
                        @endphp

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
    <div class="main-container" id="companies-section">
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


    <!-- ========== RECOMMENDED JOBS SECTION (FIXED) ========== -->
    <div class="main-container">
        <div class="featured-section" style="position: relative;">
            <div class="section-title-highlight">
                <div class="section-subtitle">DÀNH CHO BẠN</div>
                <h2>Các công việc được gợi ý</h2>
                <p style="color: #718096; margin-top: 0.5rem;">Được cá nhân hóa dựa trên kỹ năng và kinh nghiệm của bạn</p>
            </div>

            <!-- ✅ LOADING CONTAINER - ĐÃ SỬA -->
            <div id="recLoadingOverlay" style="
        display: none; 
        position: absolute; 
        top: 0; left: 0; right: 0; bottom: 0; 
        background: rgba(255, 255, 255, 0.9); 
        z-index: 100; 
        border-radius: 20px;
        align-items: center;
        justify-content: center;
    ">
                <div style="text-align: center;">
                    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div>
                    <p style="margin-top: 1rem; font-weight: 600; color: #667eea;">Đang tải gợi ý...</p>
                </div>
            </div>

            <!-- ✅ RECOMMENDED JOBS CONTAINER -->
            <div id="recommendedJobsContainer">
                @if(Auth::check() && isset($recommendedJobs) && $recommendedJobs && $recommendedJobs->count() > 0)
                @include('applicant.partials.recommended-jobs-grid', ['recommendedJobs' => $recommendedJobs])
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
    </div>


    <!-- ========== BLOG SECTION ========== -->
    <!-- ...existing code... -->
    <!-- ========== BLOG SECTION ========== -->
    <div class="main-container" id="blog-section">
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
                    <input type="hidden" name="job_id" id="modalJobId" value="">
                    <input type="hidden" name="invitation_id" id="modalInvitationId" value="">
                    <input type="hidden" name="accept_invitation" id="modalAcceptInvitation" value="0">
                    <input type="hidden" name="cv_type" id="modalCvType" value="profile">
                    <div class="modal-body p-4">
                        <!-- Profile Preview Section (REQUIRED) -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-person-badge me-2 text-primary"></i>Hồ sơ ứng tuyển <span class="required-mark">*</span>
                            </h6>
                            <div class="profile-preview-card">
                                <div class="d-flex align-items-start">
                                    @php
                                    $applicant = Auth::user()->applicant ?? null;
                                    @endphp
                                    <img src="{{ $applicant && $applicant->avatar ? asset('assets/img/avt/'.$applicant->avatar) : asset('assets/img/avt/default-avatar.png') }}"
                                        alt="Avatar" class="profile-avatar">
                                    <div class="profile-info flex-grow-1">
                                        <div class="profile-name">{{ $applicant->hoten_uv ?? 'Họ tên ứng viên' }}</div>
                                        <div class="profile-title">{{ $applicant->vitriungtuyen ?? 'Vị trí ứng tuyển' }}</div>
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

                        <!-- Optional: Add Additional CV Section -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-cloud-upload me-2 text-success"></i>CV Đính kèm thêm <span class="badge bg-secondary" style="font-size: 0.75rem; font-weight: 500;">Tùy chọn</span>
                            </h6>
                            <p class="text-muted small mb-3">Bạn có thể tải lên thêm CV để nâng cao cơ hội được chọn</p>

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
                            <div id="fileNameDisplay" class="mt-3 text-start" style="display: none;">
                                <div class="alert alert-success d-inline-flex align-items-center">
                                    <i class="bi bi-file-earmark-check me-2"></i>
                                    <span id="fileName"></span>
                                    <button type="button" class="btn-close ms-3" id="removeFile"></button>
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

            // ✅ STORE CURRENT FILTERED JOBS TO DISPLAY IN DETAIL VIEW
            let currentFilteredJobs = []; // Lưu danh sách job hiện tại (từ search/filter)

            // ✅ Helper function to extract job data from HTML
            function extractJobsFromHtml(html) {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const jobCards = doc.querySelectorAll('.job-card-grid');
                const jobs = [];

                jobCards.forEach(card => {
                    const jobId = card.getAttribute('data-job-id');
                    const title = card.querySelector('.job-card-title')?.textContent?.trim() || '';
                    const company = card.querySelector('.company-name-small')?.textContent?.trim() || '';
                    const salary = card.querySelector('.job-card-salary')?.textContent?.trim() || '';

                    // ✅ Extract text từ meta items (loại bỏ icon bằng cách clone và remove icon)
                    const getMetaText = (selector) => {
                        const elem = card.querySelector(selector);
                        if (!elem) return '';
                        const clone = elem.cloneNode(true);
                        // Remove all icons
                        clone.querySelectorAll('i').forEach(icon => icon.remove());
                        return clone.textContent.replace(/\s+/g, ' ').trim();
                    };

                    const province = getMetaText('.job-card-meta-item:nth-child(1)');
                    const level = getMetaText('.job-card-meta-item:nth-child(2)');
                    const experience = getMetaText('.job-card-meta-item:nth-child(3)');
                    const deadline = getMetaText('.job-card-deadline');

                    if (jobId) {
                        jobs.push({
                            job_id: jobId,
                            title: title,
                            company: company,
                            salary: salary,
                            province: province,
                            level: level,
                            experience: experience,
                            deadline: deadline,
                            htmlCard: card.outerHTML // ✅ Lưu HTML gốc
                        });
                    }
                });

                console.log('✅ Extracted jobs:', jobs); // DEBUG
                return jobs;
            }

            // ✅ Helper function to render job list HTML
            function renderJobListColumnFromJobs(jobs) {
                if (!jobs || jobs.length === 0) {
                    return `<div style="text-align: center; padding: 2rem; color: #999;">Không có công việc để hiển thị</div>`;
                }

                console.log('🔄 Rendering', jobs.length, 'jobs to sidebar'); // DEBUG

                let html = '';
                jobs.forEach((job, index) => {
                    console.log(`📝 Job ${index + 1}:`, job.title, '|', job.company); // DEBUG

                    // ✅ Safe escape function for HTML content
                    const escapeHtml = (text) => {
                        if (!text) return '';
                        const div = document.createElement('div');
                        div.textContent = text;
                        return div.innerHTML;
                    };

                    const companyInitial = job.company ? job.company.charAt(0).toUpperCase() : 'C';
                    const salaryClass = !job.salary || job.salary.includes('Thỏa thuận') ? 'negotiable' : '';

                    const cardHtml = `
                        <article class="job-card" data-job-id="${job.job_id}" style="background: white; border: 1px solid #E2E8F0; border-radius: 0.75rem; padding: 1rem; margin-bottom: 1rem; cursor: pointer;">
                            <div class="job-card-header" style="display: flex; gap: 0.75rem; margin-bottom: 0.75rem;">
                                <div class="company-logo-small" style="width: 48px; height: 48px; border-radius: 0.5rem; overflow: hidden; flex-shrink: 0; background: #F7FAFC; display: flex; align-items: center; justify-content: center;">
                                    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667EEA, #764BA2); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.2rem;">
                                        ${companyInitial}
                                    </div>
                                </div>
                                <div class="job-card-info" style="flex: 1; min-width: 0;">
                                    <h3 class="job-card-title" style="font-size: 0.95rem; font-weight: 600; color: #2D3748; margin-bottom: 0.25rem;">${job.title}</h3>
                                    <div class="company-name-small" style="font-size: 0.85rem; color: #718096; margin-bottom: 0.5rem;">${job.company}</div>
                                    <span class="job-card-salary ${salaryClass}" style="display: inline-block; background: ${salaryClass ? '#6B7280' : '#10B981'}; color: #FFFFFF; padding: 0.2rem 0.6rem; border-radius: 0.25rem; font-size: 0.8rem; font-weight: 600;">${job.salary || 'Thỏa thuận'}</span>
                                </div>
                            </div>
                            <div class="job-card-meta" style="display: flex; gap: 0.75rem; flex-wrap: wrap; margin-top: 0.5rem; font-size: 0.8rem; color: #718096;">
                                <div class="job-card-meta-item" style="display: flex; align-items: center; gap: 0.25rem;">
                                    <i class="bi bi-geo-alt" style="color: #3B82F6;"></i>
                                    <span>${job.province}</span>
                                </div>
                                <div class="job-card-meta-item" style="display: flex; align-items: center; gap: 0.25rem;">
                                    <i class="bi bi-briefcase" style="color: #3B82F6;"></i>
                                    <span>${job.level}</span>
                                </div>
                                <div class="job-card-meta-item" style="display: flex; align-items: center; gap: 0.25rem;">
                                    <i class="bi bi-award" style="color: #3B82F6;"></i>
                                    <span>${job.experience}</span>
                                </div>
                            </div>
                            <div class="job-card-footer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid #F1F5F9;">
                                <div class="job-card-deadline" style="font-size: 0.75rem; color: #EF4444; display: flex; align-items: center; gap: 0.25rem;">
                                    <i class="bi bi-clock-history" style="color: #EF4444;"></i>
                                    <span>${job.deadline}</span>
                                </div>
                                <button class="save-btn-small" title="Lưu công việc" style="background: transparent; border: none; color: #CBD5E0; cursor: pointer; padding: 0.25rem;">
                                    <i class="bi bi-heart" style="font-size: 1.1rem;"></i>
                                </button>
                            </div>
                        </article>
                    `;

                    html += cardHtml;
                });

                console.log('✅ Rendered HTML length:', html.length); // DEBUG
                return html;
            }

            // Search & Filter Elements
            const searchInput = document.getElementById('searchInput');
            const locationSelect = document.getElementById('locationSelect');
            const searchBtn = document.getElementById('searchBtn');
            const resetBtn = document.getElementById('resetFiltersBtn');

            // DOM Elements - Cập nhật lại
            const salaryBtn = document.getElementById('salaryFilterBtn');
            const positionBtn = document.getElementById('positionFilterBtn');
            const experienceBtn = document.getElementById('experienceFilterBtn');

            const salaryDropdown = document.getElementById('salaryDropdown');
            const positionDropdown = document.getElementById('positionDropdown');
            const experienceDropdown = document.getElementById('experienceDropdown');


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

            function updateApplyButton(button, hasApplied, isInvited = false, invitationStatus = null, invitationId = null) {
                if (!button) return;

                // ✅ XỬ LÝ LỜI MỜI PENDING: HIỂN THỊ 2 NÚT
                if (isInvited && invitationStatus === 'pending') {
                    // Ẩn nút chính
                    button.style.display = 'none';

                    // Tìm container để chèn 2 nút
                    const buttonGroup = button.closest('.job-card-actions') || button.parentElement;
                    if (!buttonGroup) return;

                    // Xóa group nút cũ nếu có
                    const oldGroup = buttonGroup.querySelector('.invitation-response-buttons');
                    if (oldGroup) oldGroup.remove();

                    // Tạo group chứa 2 nút
                    const jobId = button.getAttribute('data-job-id');

                    // Tạo wrapper
                    const wrapper = document.createElement('div');
                    wrapper.className = 'invitation-response-buttons d-flex gap-2';
                    wrapper.style.width = '100%';

                    // Tạo nút Chấp nhận
                    const acceptBtn = document.createElement('button');
                    acceptBtn.type = 'button';
                    acceptBtn.className = 'btn btn-success flex-grow-1 btn-sm';
                    acceptBtn.setAttribute('data-invitation-id', invitationId);
                    acceptBtn.setAttribute('data-job-id', jobId);
                    acceptBtn.innerHTML = '<i class="bi bi-check-lg"></i><span>Chấp nhận ứng tuyển</span>';

                    // Tạo nút Từ chối
                    const rejectBtn = document.createElement('button');
                    rejectBtn.type = 'button';
                    rejectBtn.className = 'btn btn-danger flex-grow-1 btn-sm';
                    rejectBtn.setAttribute('data-invitation-id', invitationId);
                    rejectBtn.setAttribute('data-job-id', jobId);
                    rejectBtn.innerHTML = '<i class="bi bi-x-lg"></i><span>Từ chối</span>';

                    // Gắn event listeners
                    acceptBtn.addEventListener('click', function(e) {
                        handleAcceptInvitationButton(this, e);
                    });

                    rejectBtn.addEventListener('click', function(e) {
                        handleRejectInvitationButton(this, e);
                    });

                    wrapper.appendChild(acceptBtn);
                    wrapper.appendChild(rejectBtn);
                    button.insertAdjacentElement('afterend', wrapper);
                    return;
                }

                // ✅ Xóa group nút nếu chuyển từ pending sang trạng thái khác
                const buttonGroup = button.closest('.job-card-actions') || button.parentElement;
                if (buttonGroup) {
                    const oldGroup = buttonGroup.querySelector('.invitation-response-buttons');
                    if (oldGroup) oldGroup.remove();
                }

                // Hiển thị nút chính lại
                button.style.display = '';

                const icon = button.querySelector('i');
                const textSpan = button.querySelector('span');

                if (isInvited && invitationStatus === 'accepted') {
                    // ✅ ĐÃ CHẤP NHẬN LỜI MỜI
                    button.classList.add('invited', 'accepted');
                    button.classList.remove('applied');
                    button.disabled = true;
                    button.title = 'Bạn đã chấp nhận lời mời';

                    if (icon) {
                        icon.classList.remove('bi-send-fill');
                        icon.classList.add('bi-check-circle-fill');
                    }

                    if (textSpan) {
                        textSpan.textContent = 'Đã chấp nhận';
                    }
                } else if (isInvited && invitationStatus === 'rejected') {
                    // ✅ ĐÃ TỪ CHỐI LỜI MỜI
                    button.classList.add('invited', 'rejected');
                    button.classList.remove('applied');
                    button.disabled = true;
                    button.title = 'Bạn đã từ chối lời mời';

                    if (icon) {
                        icon.classList.remove('bi-send-fill', 'bi-check-circle-fill');
                        icon.classList.add('bi-x-circle-fill');
                    }

                    if (textSpan) {
                        textSpan.textContent = 'Đã từ chối';
                    }
                } else if (hasApplied) {
                    // ✅ ĐÃ ỨNG TUYỂN BÌNH THƯỜNG
                    button.classList.toggle('applied', true);
                    button.classList.remove('invited', 'accepted', 'rejected');
                    button.disabled = true;
                    button.title = 'Bạn đã ứng tuyển công việc này';

                    if (icon) {
                        icon.classList.remove('bi-send-fill', 'bi-star-fill', 'bi-x-circle-fill');
                        icon.classList.add('bi-check-circle-fill');
                    }

                    if (textSpan) {
                        textSpan.textContent = 'Đã ứng tuyển';
                    }
                } else {
                    // ✅ CHƯA ỨNG TUYỂN / CHƯA CÓ LỜI MỜI
                    button.classList.remove('applied', 'invited', 'accepted', 'rejected');
                    button.disabled = false;
                    button.title = 'Ứng tuyển ngay';

                    if (icon) {
                        icon.classList.remove('bi-check-circle-fill', 'bi-star-fill', 'bi-x-circle-fill');
                        icon.classList.add('bi-send-fill');
                    }

                    if (textSpan) {
                        textSpan.textContent = 'Ứng tuyển ngay';
                    }
                }
            }


            function syncApplyButtons(jobId, hasApplied, isInvited = false, invitationStatus = null, invitationId = null) {
                const gridCard = document.querySelector(`.job-card-grid[data-job-id="${jobId}"]`);
                if (gridCard) {
                    const gridBtn = gridCard.querySelector('.btn-apply-now');
                    if (gridBtn) updateApplyButton(gridBtn, hasApplied, isInvited, invitationStatus, invitationId);
                }

                const detailBtn = document.querySelector(`.btn-apply-now[data-job-id="${jobId}"]`);
                if (detailBtn) updateApplyButton(detailBtn, hasApplied, isInvited, invitationStatus, invitationId);

                // ✅ THÊM PHẦN NÀY: Cập nhật nút trong recommended jobs
                const recCard = document.querySelector(`#recommendedJobsContainer .recommended-job-card[data-job-id="${jobId}"]`);
                if (recCard) {
                    const recBtn = recCard.querySelector('.rec-btn-primary');
                    if (recBtn) updateApplyButton(recBtn, hasApplied, isInvited, invitationStatus, invitationId);
                }
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

            // ✅ LOAD ALL INVITATIONS FOR CURRENT USER
            function loadAllInvitations() {
                if (!checkAuth()) return;

                fetch('/api/job-invitations', {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.invitations?.length > 0) {
                            // ✅ Cập nhật từng job với invitation status
                            data.invitations.forEach(invitation => {
                                syncApplyButtons(
                                    invitation.job_id,
                                    false, // hasApplied - sẽ được update riêng
                                    true, // isInvited
                                    invitation.status, // status: pending, accepted, rejected
                                    invitation.id // invitationId
                                );
                            });
                        }
                    })
                    .catch(error => console.error('Error loading invitations:', error));
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
                            // ✅ Xử lý trạng thái invitation
                            syncApplyButtons(
                                jobId,
                                data.applied,
                                data.invited,
                                data.invitation_status,
                                data.invitation_id
                            );
                        }
                    })
                    .catch(error => console.error('Error checking application status:', error));
            }

            // ========================================
            // SAVE BUTTON FUNCTIONS - FIX TOÀN BỘ
            // ========================================

            let savedJobsLoaded = false;

            function updateSaveButton(button, isSaved) {
                if (!button) return;

                const icon = button.querySelector('i');
                button.classList.toggle('saved', isSaved);

                if (icon) {
                    icon.classList.remove('bi-heart', 'bi-heart-fill');
                    if (isSaved) {
                        icon.classList.add('bi-heart-fill');
                    } else {
                        icon.classList.add('bi-heart');
                    }
                }

                button.title = isSaved ? 'Bỏ lưu công việc' : 'Lưu công việc';
            }

            function updateSaveButtonDirect(jobId) {
                // Grid
                const gridBtn = document.querySelector(`.job-card-grid[data-job-id="${jobId}"] .save-btn-grid`);
                if (gridBtn) {
                    const icon = gridBtn.querySelector('i');
                    gridBtn.classList.add('saved');
                    if (icon) {
                        icon.classList.remove('bi-heart');
                        icon.classList.add('bi-heart-fill');
                    }
                }

                // List
                const listBtn = document.querySelector(`.job-card[data-job-id="${jobId}"] .save-btn-small`);
                if (listBtn) {
                    const icon = listBtn.querySelector('i');
                    listBtn.classList.add('saved');
                    if (icon) {
                        icon.classList.remove('bi-heart');
                        icon.classList.add('bi-heart-fill');
                    }
                }

                // Detail
                const detailBtn = document.querySelector(`.save-btn-large[data-job-id="${jobId}"]`);
                if (detailBtn) {
                    const icon = detailBtn.querySelector('i');
                    detailBtn.classList.add('saved');
                    if (icon) {
                        icon.classList.remove('bi-heart');
                        icon.classList.add('bi-heart-fill');
                    }
                }

                // Recommended grid
                const recBtn = document.querySelector(`#recommendedJobsContainer .recommended-job-card[data-job-id="${jobId}"] .rec-btn-icon`);
                if (recBtn) {
                    const icon = recBtn.querySelector('i');
                    recBtn.classList.add('saved');
                    if (icon) {
                        icon.classList.remove('bi-heart');
                        icon.classList.add('bi-heart-fill');
                    }
                }

                // ✅ THÊM: Recommended list item
                const recListBtn = document.querySelector(`.rec-job-list-item[data-job-id="${jobId}"] .rec-list-save`);
                if (recListBtn) {
                    const icon = recListBtn.querySelector('i');
                    recListBtn.classList.add('saved');
                    if (icon) {
                        icon.classList.remove('bi-heart');
                        icon.classList.add('bi-heart-fill');
                    }
                }
            }

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

                const detailBtn = document.querySelector(`.save-btn-large[data-job-id="${jobId}"]`);
                if (detailBtn) {
                    updateSaveButton(detailBtn, isSaved);
                }

                const recCard = document.querySelector(`#recommendedJobsContainer .recommended-job-card[data-job-id="${jobId}"]`);
                if (recCard) {
                    const recBtn = recCard.querySelector('.rec-btn-icon');
                    if (recBtn) {
                        updateSaveButton(recBtn, isSaved);
                    }
                }

                // ✅ THÊM: Cập nhật nút save trong recommended list items
                const recListItem = document.querySelector(`.rec-job-list-item[data-job-id="${jobId}"]`);
                if (recListItem) {
                    const recListBtn = recListItem.querySelector('.rec-list-save');
                    if (recListBtn) {
                        updateSaveButton(recListBtn, isSaved);
                    }
                }

                console.log(`✅ Synced save status for job ${jobId}: ${isSaved ? 'Saved' : 'Unsaved'}`);
            }

            function loadSavedJobs() {
                if (!checkAuth() || savedJobsLoaded) return;

                savedJobsLoaded = true;

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
                            console.log(`✅ Loaded ${data.savedJobIds.length} saved jobs`);
                            data.savedJobIds.forEach(jobId => {
                                updateSaveButtonDirect(jobId);
                            });
                        }
                    })
                    .catch(error => console.error('Error loading saved jobs:', error));
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
                            // ✅ DÙNG syncSaveButtons THAY VÌ CẬP NHẬT RIÊNG
                            const newState = !isSaved;
                            syncSaveButtons(jobId, newState);
                            const message = newState ? 'Đã lưu công việc' : 'Đã bỏ lưu công việc';
                            showToast(message, 'success');
                            console.log(`✅ Job ${jobId} save status: ${newState}`);
                        } else {
                            if (data.code === 'ALREADY_SAVED') {
                                syncSaveButtons(jobId, true);
                                showToast('Bạn đã lưu công việc này rồi', 'info');
                            } else {
                                showToast(data.message || 'Có lỗi xảy ra!', 'error');
                            }
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
            // ========================================
            // VIEW SWITCHING
            // ========================================

            function showGridView() {
                if (gridView && detailView) {
                    gridView.classList.remove('hidden');
                    detailView.classList.remove('active');

                    // ✅ KHI QUAY LẠI GRID VIEW, HIỂN THỊ LẠI TẤT CẢ JOB CARDS TRONG SIDEBAR
                    document.querySelectorAll('.job-card').forEach(card => {
                        card.style.display = '';
                        card.classList.remove('active');
                    });

                    // ✅ Gắn lại event cho các nút trong sidebar
                    attachListCardEvents();

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

                    setTimeout(() => {
                        // ✅ LẤY DANH SÁCH JOB IDs TỪ KẾT QUẢ LỌC HIỆN TẠI
                        const filteredJobIds = currentFilteredJobs.map(job => String(job.job_id));
                        console.log('🔍 Filtered Job IDs:', filteredJobIds);

                        // ✅ LỌC VÀ HIỂN THỊ CHỈ NHỮNG JOB CARDS TRONG KẾT QUẢ LỌC
                        document.querySelectorAll('.job-card').forEach(card => {
                            const cardJobId = String(card.getAttribute('data-job-id'));

                            // Kiểm tra xem job card có trong kết quả lọc không
                            if (filteredJobIds.includes(cardJobId)) {
                                // Hiển thị job card nếu nằm trong kết quả lọc
                                card.style.display = '';
                                // Highlight nếu là job được chọn
                                card.classList.toggle('active', cardJobId == jobId);
                            } else {
                                // Ẩn job card nếu không nằm trong kết quả lọc
                                card.style.display = 'none';
                                card.classList.remove('active');
                            }
                        });

                        console.log('✅ Sidebar filtered to show only', filteredJobIds.length, 'jobs');

                        // ✅ Gắn lại event cho các nút trong sidebar sau khi lọc
                        attachListCardEvents();

                        // Load chi tiết job
                        loadJobDetail(jobId);
                    }, 0);
                }
            }

            if (backToGridBtn) {
                backToGridBtn.addEventListener('click', showGridView);
            }

            // Expose functions to window for event handlers
            window.loadJobDetail = loadJobDetail;
            window.showDetailView = showDetailView;
            window.handleAcceptInvitationButton = handleAcceptInvitationButton;
            window.handleRejectInvitationButton = handleRejectInvitationButton;

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

                console.log(`🔄 Loading job detail for job ${jobId}`);

                fetch(`/api/jobs/${jobId}`, {
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => {
                        console.log('📡 Response status:', response.status);

                        if (!response.ok) {
                            return response.json().then(errorData => {
                                throw new Error(errorData.error || errorData.message || `HTTP ${response.status}: ${response.statusText}`);
                            }).catch(jsonError => {
                                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                            });
                        }
                        return response.json();
                    })
                    .then(job => {
                        console.log('✅ Job data received:', job);
                        renderJobDetail(job);
                        checkApplicationStatus(jobId);
                    })
                    .catch(error => {
                        console.error('❌ Error loading job detail:', error);

                        let errorMessage = 'Không thể tải thông tin công việc';
                        let errorDetail = error.message;

                        if (error.message.includes('404')) {
                            errorMessage = 'Công việc không tồn tại';
                            errorDetail = 'Công việc này có thể đã bị xóa hoặc hết hạn ứng tuyển.';
                        } else if (error.message.includes('500')) {
                            errorMessage = 'Lỗi máy chủ';
                            errorDetail = 'Vui lòng thử lại sau hoặc liên hệ quản trị viên.';
                        } else if (error.message.includes('Network')) {
                            errorMessage = 'Lỗi kết nối';
                            errorDetail = 'Vui lòng kiểm tra kết nối internet của bạn.';
                        }

                        jobDetailColumn.innerHTML = `
                    <div class="job-detail-empty">
                        <i class="bi bi-exclamation-circle text-danger" style="font-size: 3rem;"></i>
                        <h4 style="color: #dc3545; margin-top: 1rem;">${errorMessage}</h4>
                        <p style="color: #6c757d; margin-top: 0.5rem;">${errorDetail}</p>
                        <button onclick="showGridView()" class="btn btn-primary mt-3">
                            <i class="bi bi-arrow-left me-2"></i>Quay lại danh sách
                        </button>
                    </div>
                `;

                        showToast(errorMessage, 'error');
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
            <i class="bi bi-send-fill me-2"></i><span>Ứng tuyển ngay</span>
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
                    // ✅ Clone card để remove tất cả event listeners cũ
                    const oldCard = card;
                    const newCard = card.cloneNode(true);
                    card.parentNode.replaceChild(newCard, card);

                    // Click vào card để xem detail
                    newCard.addEventListener('click', function(e) {
                        if (!e.target.closest('.save-btn-small')) {
                            document.querySelectorAll('.job-card').forEach(c => c.classList.remove('active'));
                            this.classList.add('active');
                            const jobId = this.getAttribute('data-job-id');
                            loadJobDetail(jobId);
                        }
                    });

                    // ✅ Gắn sự kiện cho nút lưu trong sidebar
                    const saveBtn = newCard.querySelector('.save-btn-small');
                    if (saveBtn) {
                        saveBtn.addEventListener('click', function(e) {
                            e.stopPropagation();
                            e.preventDefault();

                            const jobId = newCard.getAttribute('data-job-id');
                            const isSaved = this.classList.contains('saved');

                            if (!jobId) {
                                showToast('Không xác định được công việc!', 'error');
                                return;
                            }

                            handleSaveJob(jobId, isSaved, this);
                        });
                    }
                });
            }

            function attachSaveButtons() {
                // ✅ CHỈ GẮN CHO .save-btn-grid, KHÔNG GẮN CHO .save-btn-small (đã được xử lý trong attachListCardEvents)
                document.querySelectorAll('.save-btn-grid').forEach(btn => {
                    btn.removeEventListener('click', handleSaveClick);
                    btn.addEventListener('click', handleSaveClick);
                });
            }

            function showInvitationModal(invitationId) {
                const modalHtml = `
                <div class="modal fade" id="invitationResponseModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header border-0 pb-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <div style="font-size: 3rem; margin-bottom: 1rem;">
                                    <i class="bi bi-star-fill" style="color: #667eea;"></i>
                                </div>
                                <h4 class="fw-bold" style="color: #1f2937; margin-bottom: 0.5rem;">Bạn được mời ứng tuyển!</h4>
                                <p class="text-muted" style="margin-bottom: 2rem;">
                                    Hãy chấp nhận hoặc từ chối lời mời ứng tuyển này.
                                </p>
                            </div>
                            <div class="modal-footer border-0 pt-0 gap-2">
                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
                                    <i class="bi bi-x-lg me-2"></i>Từ chối
                                </button>
                                <button type="button" class="btn btn-primary" id="acceptInvitationBtn">
                                    <i class="bi bi-check-lg me-2"></i>Chấp nhận
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                `;

                // Xóa modal cũ nếu có
                const oldModal = document.getElementById('invitationResponseModal');
                if (oldModal) oldModal.remove();

                // Thêm modal mới
                document.body.insertAdjacentHTML('beforeend', modalHtml);

                const modal = new bootstrap.Modal(document.getElementById('invitationResponseModal'));

                // Xử lý chấp nhận
                document.getElementById('acceptInvitationBtn').addEventListener('click', function() {
                    respondToInvitation(invitationId, 'accepted', modal);
                });

                // Xử lý từ chối
                const rejectBtn = document.querySelector('#invitationResponseModal .btn-outline-danger');
                rejectBtn.addEventListener('click', function() {
                    respondToInvitation(invitationId, 'rejected', modal);
                });

                modal.show();
            }

            function respondToInvitation(invitationId, response, jobId = null) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                if (!csrfToken) {
                    console.error('❌ CSRF token not found!');
                    showToast('Có lỗi bảo mật. Vui lòng tải lại trang!', 'error');
                    return;
                }

                console.log(`📤 Sending request to /api/job-invitations/${invitationId}/respond with:`, {
                    invitationId,
                    response,
                    jobId,
                    csrfToken: csrfToken.substring(0, 20) + '...'
                });

                fetch(`/api/job-invitations/${invitationId}/respond`, {
                        method: 'POST',
                        credentials: 'include',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            response: response
                        })
                    })
                    .then(res => {
                        console.log(`📥 Response status:`, res.status);
                        return res.json().then(data => ({
                            status: res.status,
                            data
                        }));
                    })
                    .then(({
                        status,
                        data
                    }) => {
                        console.log(`📊 Response data:`, data);

                        if (status === 401) {
                            showToast('Vui lòng đăng nhập!', 'error');
                            setTimeout(() => window.location.href = '/login', 1500);
                            return;
                        }

                        if (data.success) {
                            const message = response === 'accepted' ?
                                '✅ Bạn đã chấp nhận lời mời!' :
                                '❌ Bạn đã từ chối lời mời!';
                            showToast(message, 'success');

                            // ✅ CẬP NHẬT CÁC NÚT TRÊN TRANG
                            if (jobId) {
                                checkApplicationStatus(jobId);
                            }
                        } else {
                            showToast(data.message || 'Có lỗi xảy ra!', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('❌ Fetch error:', error);
                        showToast('Có lỗi xảy ra: ' + error.message, 'error');
                    });
            }

            function handleApplyClick() {
                // ✅ XỬ LÝ LỜI MỜI
                if (this.classList.contains('invited') && this.dataset.invitationId) {
                    const invitationId = this.dataset.invitationId;
                    showInvitationModal(invitationId);
                    return;
                }

                if (this.classList.contains('applied')) {
                    showToast('Bạn đã ứng tuyển công việc này rồi!', 'info');
                    return;
                }

                if (this.classList.contains('accepted')) {
                    showToast('Bạn đã chấp nhận lời mời này!', 'info');
                    return;
                }

                if (this.classList.contains('rejected')) {
                    showToast('Bạn đã từ chối lời mời này!', 'info');
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

            // ✅ XỬ LÝ CHẤP NHẬN LỜI MỜI
            function handleAcceptInvitationButton(button, event) {
                event.stopPropagation();
                event.preventDefault();

                if (!checkAuth()) {
                    showToast('Vui lòng đăng nhập!', 'error');
                    setTimeout(() => window.location.href = '/login', 1500);
                    return;
                }

                const invitationId = button.dataset.invitationId;
                const jobId = button.dataset.jobId;

                if (!invitationId || !jobId) {
                    console.error('Missing invitationId or jobId', {
                        invitationId,
                        jobId
                    });
                    showToast('Không xác định được công việc!', 'error');
                    return;
                }

                console.log(`✅ Accepting invitation:`, {
                    invitationId,
                    jobId
                });

                // ✅ LƯU invitationId VÀO MODAL (CHƯA GỬI API)
                document.getElementById('modalInvitationId').value = invitationId;
                document.getElementById('modalAcceptInvitation').value = '1';
                document.getElementById('modalJobId').value = jobId;

                // ✅ HIỂN THỊ MODAL ỨNG TUYỂN
                showToast('📋 Vui lòng hoàn tất thông tin ứng tuyển để gửi hồ sơ', 'info');
                const modal = document.getElementById('applyJobModal');
                if (modal) {
                    const bsModal = new bootstrap.Modal(modal);
                    bsModal.show();
                }
            }

            // ✅ XỬ LÝ TỪ CHỐI LỜI MỜI
            function handleRejectInvitationButton(button, event) {
                event.stopPropagation();
                event.preventDefault();

                if (!checkAuth()) {
                    showToast('Vui lòng đăng nhập!', 'error');
                    setTimeout(() => window.location.href = '/login', 1500);
                    return;
                }

                const invitationId = button.dataset.invitationId;
                const jobId = button.dataset.jobId;

                if (!invitationId || !jobId) {
                    console.error('Missing invitationId or jobId', {
                        invitationId,
                        jobId
                    });
                    showToast('Không xác định được công việc!', 'error');
                    return;
                }

                // Hiển thị xác nhận trước khi từ chối
                if (!confirm('Bạn có chắc muốn từ chối lời mời này?')) {
                    return;
                }

                console.log(`❌ Rejecting invitation:`, {
                    invitationId,
                    jobId
                });

                // ✅ GỌI API TỪ CHỐI LỜI MỜI
                respondToInvitation(invitationId, 'rejected', jobId);
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
                loadAllInvitations(); // ✅ LẤY CÁC LỜI MỜI
                attachRecommendedJobsEvents();
            }


            window.attachJobCardEvents = attachJobCardEvents;

            // ========================================
            // MODAL ỨNG TUYỂN
            // ========================================

            const uploadSection = document.getElementById('uploadSection');
            const profileSection = document.getElementById('profileSection');
            // ✅ Không còn lựa chọn CV type, luôn sử dụng hồ sơ + CV đính kèm tùy chọn

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

                // ✅ Set cv_type to 'upload' khi user chọn file mới
                const cvTypeInput = document.getElementById('modalCvType');
                if (cvTypeInput) cvTypeInput.value = 'upload';
            }

            if (removeFile) {
                removeFile.addEventListener('click', function() {
                    if (cvFileInput) cvFileInput.value = '';
                    if (fileNameDisplay) fileNameDisplay.style.display = 'none';
                    if (uploadArea) uploadArea.style.display = 'block';

                    // ✅ Reset cv_type to 'profile' khi xóa file
                    const cvTypeInput = document.getElementById('modalCvType');
                    if (cvTypeInput) cvTypeInput.value = 'profile';
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

                                // ✅ KIỂM TRA XEM CÓ CHẤP NHẬN LỜI MỜI KHÔNG
                                const invitationId = document.getElementById('modalInvitationId').value;
                                const acceptInvitation = document.getElementById('modalAcceptInvitation').value;
                                const jobId = document.getElementById('modalJobId').value;

                                console.log(`📋 Form submitted with:`, {
                                    invitationId,
                                    acceptInvitation,
                                    jobId
                                });

                                // Nếu có invitationId và đánh dấu accept, gửi API chấp nhận lời mời
                                if (invitationId && acceptInvitation === '1') {
                                    console.log(`✅ Accepting invitation after application submitted...`);
                                    respondToInvitation(invitationId, 'accepted', jobId);
                                }

                                syncApplyButtons(jobId, true); // ✅ THÊM DÒNG NÀY

                                const modal = bootstrap.Modal.getInstance(applyJobModal);
                                if (modal) modal.hide();

                                applyJobForm.reset();
                                document.getElementById('modalInvitationId').value = '';
                                document.getElementById('modalAcceptInvitation').value = '0';
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
                // ✅ THÊM: Load CV khi modal show
                applyModal.addEventListener('show.bs.modal', function() {
                    if (checkAuth()) {
                        loadApplicantCVForModal();
                    }
                });

                applyModal.addEventListener('hidden.bs.modal', function() {
                    if (applyJobForm) applyJobForm.reset();
                    if (fileNameDisplay) fileNameDisplay.style.display = 'none';
                    if (uploadArea) uploadArea.style.display = 'block';
                    if (charCount) charCount.textContent = '0';
                });
            }

            // ✅ THÊM: Function tải CV từ hồ sơ
            async function loadApplicantCVForModal() {
                try {
                    console.log('📞 Calling /api/applicant-cv...');
                    const response = await fetch('/api/applicant-cv', {
                        method: 'GET',
                        credentials: 'include', // ✅ THÊM: Include cookies for auth
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                        }
                    });

                    console.log('📡 Response status:', response.status);
                    const result = await response.json();

                    console.log('📥 API Response:', result);

                    if (result.success && result.data && result.data.filename) {
                        const filename = result.data.filename;
                        const filepath = result.data.path;

                        console.log('✅ CV found - Filename:', filename, 'Path:', filepath);

                        // Cập nhật hiển thị file name + link xem
                        if (fileName) {
                            fileName.innerHTML = `
                                <span>${filename}</span>
                                <a href="{{ route('applicant.viewCv') }}" target="_blank" class="btn btn-sm btn-outline-primary ms-2" style="font-size: 0.75rem;">
                                    <i class="bi bi-eye"></i> Xem
                                </a>
                            `;
                            console.log('✅ Updated fileName element:', filename);
                        }
                        if (fileNameDisplay) fileNameDisplay.style.display = 'block';
                        if (uploadArea) uploadArea.style.display = 'none';

                        // ✅ Ensure cv_type is set to 'profile'
                        const cvTypeInput = document.getElementById('modalCvType');
                        if (cvTypeInput) {
                            cvTypeInput.value = 'profile';
                            console.log('✅ Set cv_type to: profile');
                        }

                        console.log('✅ Loaded CV from profile:', filename);
                    } else {
                        // Nếu chưa có CV, hiển thị form upload
                        console.log('⚠️ No CV found in profile or API returned null');
                        if (fileNameDisplay) fileNameDisplay.style.display = 'none';
                        if (uploadArea) uploadArea.style.display = 'block';

                        // Set default cv_type to 'profile'
                        const cvTypeInput = document.getElementById('modalCvType');
                        if (cvTypeInput) cvTypeInput.value = 'profile';
                    }
                } catch (error) {
                    console.error('❌ Error loading CV:', error);
                    if (fileNameDisplay) fileNameDisplay.style.display = 'none';
                    if (uploadArea) uploadArea.style.display = 'block';
                }
            }

            // ========================================
            // FILTER DROPDOWNS
            // ========================================

            function toggleDropdown(menu) {
                if (!menu) return;

                const isShown = menu.classList.contains('show');

                // ✅ DÙNG document.querySelectorAll THAY VÌ xóa tất cả
                document.querySelectorAll('.filter-dropdown-menu.show').forEach(m => {
                    if (m !== menu) m.classList.remove('show');
                });

                if (!isShown) {
                    menu.classList.add('show');
                    console.log('✅ Dropdown opened');
                } else {
                    menu.classList.remove('show');
                    console.log('❌ Dropdown closed');
                }
            }

            document.addEventListener('click', function(e) {
                if (!e.target.closest('.filter-dropdown-wrapper')) {
                    document.querySelectorAll('.filter-dropdown-menu').forEach(menu => {
                        menu.classList.remove('show');
                    });
                }
            });

            // Filter buttons array - Cập nhật lại
            [{
                    btn: salaryBtn,
                    menu: salaryDropdown
                },
                {
                    btn: positionBtn,
                    menu: positionDropdown
                },
                {
                    btn: experienceBtn,
                    menu: experienceDropdown
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

            // ✅ THÊM PHẦN NÀY: Attach checkbox events
            document.querySelectorAll('.filter-checkbox-item input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Handle "all" checkbox
                    const filterName = this.name;
                    if (this.value === 'all' && this.checked) {
                        document.querySelectorAll(`input[name="${filterName}"]:not([value="all"])`).forEach(cb => {
                            cb.checked = false;
                        });
                    } else if (this.value !== 'all' && this.checked) {
                        const allCheckbox = document.querySelector(`input[name="${filterName}"][value="all"]`);
                        if (allCheckbox) allCheckbox.checked = false;
                    }

                    collectFilters();
                    performSearch();
                });
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

            // Cập nhật collectFilters()
            function collectFilters() {
                currentFilters = {
                    search: searchInput?.value.trim() || '',
                    location: locationSelect?.value || '',
                    salary: Array.from(document.querySelectorAll('input[name="salary"]:checked'))
                        .filter(cb => cb.value !== 'all')
                        .map(cb => cb.value),
                    positions: Array.from(document.querySelectorAll('input[name="position"]:checked'))
                        .filter(cb => cb.value !== 'all')
                        .map(cb => cb.value),
                    experiences: Array.from(document.querySelectorAll('input[name="experience"]:checked'))
                        .filter(cb => cb.value !== 'all')
                        .map(cb => cb.value)
                };

                updateFilterBadge(salaryBtn, currentFilters.salary.length);
                updateFilterBadge(positionBtn, currentFilters.positions.length);
                updateFilterBadge(experienceBtn, currentFilters.experiences.length);

                return currentFilters;
            }

            // Cập nhật hasActiveFilters()
            function hasActiveFilters(filters) {
                return !!(filters.search ||
                    filters.location ||
                    filters.salary.length > 0 ||
                    filters.positions.length > 0 ||
                    filters.experiences.length > 0);
            }


            function updateResultCount(total, locationMessage = '') {
                const titleElement = document.getElementById('totalJobsTitle') || document.querySelector('.section-title-highlight h2');
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

                            // ✅ LƯUU LẠI DANH SÁCH JOB HIỆN TẠI CHO DETAIL VIEW
                            currentFilteredJobs = extractJobsFromHtml(data.html);
                            console.log('✅ Stored current filtered jobs:', currentFilteredJobs.length, 'jobs');

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

                // ✅ FIX: Gửi salary với format đúng
                if (filters.salary && filters.salary.length > 0) {
                    params.append('salary_ranges', filters.salary.join(','));
                    console.log('💰 Salary filters:', filters.salary.join(','));
                }

                if (filters.positions && filters.positions.length > 0) {
                    params.append('positions', filters.positions.join(','));
                }
                if (filters.experiences && filters.experiences.length > 0) {
                    params.append('experiences', filters.experiences.join(','));
                }

                console.log('🔍 Full search params:', params.toString());

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
                        console.log('✅ API Response:', data);

                        if (data.success) {
                            if (gridView) gridView.innerHTML = data.html;
                            if (paginationWrapper) paginationWrapper.innerHTML = data.pagination || '';

                            // ✅ LƯUU LẠI DANH SÁCH JOB HIỆN TẠI CHO DETAIL VIEW
                            currentFilteredJobs = extractJobsFromHtml(data.html);
                            console.log('✅ Stored current filtered jobs:', currentFilteredJobs.length, 'jobs');

                            const locationName = filters.location || '';
                            const locationMsg = locationName ? `tại ${formatLocationDisplay(locationName)}` : '';
                            updateResultCount(data.total, locationMsg);

                            setTimeout(() => {
                                if (typeof window.attachJobCardEvents === 'function') {
                                    window.attachJobCardEvents();
                                }
                            }, 100);

                            console.log(`✅ Found ${data.total} jobs`);

                            if (data.total === 0) {
                                showToast('Không tìm thấy công việc phù hợp', 'info');
                            } else {
                                showToast(`Tìm thấy ${data.total} công việc`, 'success');
                            }
                        } else {
                            showToast(data.message || 'Tìm kiếm không thành công', 'error');
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
            // Cập nhật Reset button
            if (resetBtn) {
                resetBtn.addEventListener('click', function() {
                    if (searchInput) searchInput.value = '';
                    if (locationSelect) locationSelect.value = '';

                    document.querySelectorAll('.filter-checkbox-item input[type="checkbox"]').forEach(cb => {
                        cb.checked = cb.value === 'all';
                    });

                    updateFilterBadge(salaryBtn, 0);
                    updateFilterBadge(positionBtn, 0);
                    updateFilterBadge(experienceBtn, 0);

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

            function attachRecommendedJobsEvents() {
                attachRecommendedDetailButtons();

                // Apply buttons for recommended jobs
                document.querySelectorAll('#recommendedJobsContainer .rec-btn-primary').forEach(btn => {
                    btn.removeEventListener('click', handleRecommendedApply);
                    btn.addEventListener('click', handleRecommendedApply);
                });

                // Save buttons for recommended jobs
                document.querySelectorAll('#recommendedJobsContainer .rec-btn-icon').forEach(btn => {
                    btn.removeEventListener('click', handleRecommendedSave);
                    btn.addEventListener('click', handleRecommendedSave);
                });

                // ✅ THÊM HANDLER CHO NÚT DETAIL (MŨI TEN)
                document.querySelectorAll('#recommendedJobsContainer .rec-btn-detail').forEach(btn => {
                    btn.removeEventListener('click', handleRecommendedDetailClick);
                    btn.addEventListener('click', handleRecommendedDetailClick);
                });

            }

            // ✅ THÊM FUNCTION: Check saved jobs cho list items
            function checkSavedJobsForListItems() {
                if (!savedJobIds || !Array.isArray(savedJobIds)) return;

                document.querySelectorAll('.rec-job-list-item').forEach(item => {
                    const jobId = item.getAttribute('data-job-id');
                    const saveBtn = item.querySelector('.rec-list-save');

                    if (saveBtn && savedJobIds.includes(parseInt(jobId))) {
                        saveBtn.classList.add('saved');
                        saveBtn.innerHTML = '<i class="bi bi-heart-fill" style="color: #ef4444;"></i>';
                    }
                });
            }

            function attachRecommendedDetailButtons() {
                // ✅ ATTACH: Click vào card grid để xem chi tiết
                document.querySelectorAll('#recommendedJobsContainer .recommended-job-card').forEach(card => {
                    card.removeEventListener('click', handleRecommendedCardClick);
                    card.addEventListener('click', handleRecommendedCardClick);
                });

                // ✅ ATTACH: Apply và Save buttons cho grid cards
                document.querySelectorAll('#recommendedJobsContainer .rec-btn-primary').forEach(btn => {
                    btn.removeEventListener('click', handleRecommendedApply);
                    btn.addEventListener('click', handleRecommendedApply);
                });

                document.querySelectorAll('#recommendedJobsContainer .rec-btn-icon').forEach(btn => {
                    btn.removeEventListener('click', handleRecommendedSave);
                    btn.addEventListener('click', handleRecommendedSave);
                });

                document.querySelectorAll('#recommendedJobsContainer .rec-btn-detail').forEach(btn => {
                    btn.removeEventListener('click', handleRecommendedDetailClick);
                    btn.addEventListener('click', handleRecommendedDetailClick);
                });

                // ✅ ATTACH: Click vào list items để xem chi tiết
                document.querySelectorAll('.rec-job-list-item').forEach(item => {
                    item.removeEventListener('click', handleRecListItemClick);
                    item.addEventListener('click', handleRecListItemClick);

                    // ✅ ATTACH: Apply button
                    const applyBtn = item.querySelector('.rec-list-apply');
                    if (applyBtn) {
                        applyBtn.removeEventListener('click', handleRecListApply);
                        applyBtn.addEventListener('click', handleRecListApply);
                    }

                    // ✅ ATTACH: Save button
                    const saveBtn = item.querySelector('.rec-list-save');
                    if (saveBtn) {
                        saveBtn.removeEventListener('click', handleRecListSave);
                        saveBtn.addEventListener('click', handleRecListSave);
                    }
                });

                // ✅ Check và load saved status cho các list items
                checkSavedJobsForListItems();
            }
            // ✅ THÊM FUNCTION NÀY: Handle click card
            function handleRecommendedCardClick(e) {
                // Bỏ qua nếu click vào nút
                if (e.target.closest('.rec-btn-primary, .rec-btn-detail, .rec-btn-icon')) {
                    return;
                }

                const jobId = this.getAttribute('data-job-id');
                if (jobId) {
                    console.log(`✅ Card clicked, opening detail for job ${jobId}`);
                    showRecommendedDetailView(jobId);
                }
            }

            // ✅ THÊM FUNCTION NÀY: Handle click nút mũi tên
            function handleRecommendedDetailClick(e) {
                e.preventDefault();
                e.stopPropagation();

                const card = this.closest('.recommended-job-card');
                const jobId = card?.getAttribute('data-job-id');

                if (jobId) {
                    console.log(`✅ Opening recommended detail view for job ${jobId}`);
                    showRecommendedDetailView(jobId);
                }
            }

            function handleRecommendedApply(e) {
                e.preventDefault();
                e.stopPropagation();

                if (!checkAuth()) {
                    showToast('Vui lòng đăng nhập để ứng tuyển!', 'error');
                    setTimeout(() => window.location.href = '/login', 1500);
                    return;
                }

                const card = this.closest('.recommended-job-card');
                const jobId = card?.getAttribute('data-job-id');

                if (!jobId) {
                    showToast('Không xác định được công việc!', 'error');
                    return;
                }

                if (this.classList.contains('applied')) {
                    showToast('Bạn đã ứng tuyển công việc này rồi!', 'info');
                    return;
                }

                window.currentJobId = jobId;

                const modal = document.getElementById('applyJobModal');
                if (modal) {
                    const bsModal = new bootstrap.Modal(modal);
                    bsModal.show();
                }
            }

            function handleRecommendedSave(e) {
                e.preventDefault();
                e.stopPropagation();

                console.log('🔥 handleRecommendedSave triggered');

                if (!checkAuth()) {
                    showToast('Vui lòng đăng nhập để lưu công việc!', 'error');
                    setTimeout(() => window.location.href = '/login', 1500);
                    return;
                }

                const card = this.closest('.recommended-job-card');
                const jobId = card?.getAttribute('data-job-id');

                console.log('🔥 Job ID:', jobId, 'Card:', card);

                if (!jobId) {
                    showToast('Không xác định được công việc!', 'error');
                    return;
                }

                const isSaved = this.classList.contains('saved');
                const button = this;
                button.disabled = true;

                console.log('🔥 Is saved:', isSaved, 'Button:', button);

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
                            // ✅ DÙNG syncSaveButtons THAY VÌ CẬP NHẬT RIÊNG
                            const newState = !isSaved;
                            syncSaveButtons(jobId, newState);
                            const message = newState ? 'Đã lưu công việc' : 'Đã bỏ lưu công việc';
                            showToast(message, 'success');
                            console.log(`✅ Job ${jobId} save status: ${newState}`);
                        } else {
                            if (data.code === 'ALREADY_SAVED') {
                                syncSaveButtons(jobId, true);
                                showToast('Bạn đã lưu công việc này rồi', 'info');
                            } else {
                                showToast(data.message || 'Có lỗi xảy ra!', 'error');
                            }
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
            // ========================================
            // RECOMMENDED JOBS DETAIL VIEW
            // ========================================

            function showRecommendedGridView() {
                const gridView = document.getElementById('recommendedJobsGrid');
                const detailView = document.getElementById('recommendedDetailView');
                const viewAll = document.querySelector('.btn-view-all');

                if (gridView) gridView.style.display = 'grid';
                if (detailView) detailView.style.display = 'none';
                if (viewAll) viewAll.style.display = 'block';
            }

            // ✅ Expose function to window for onclick
            window.showRecommendedGrid = showRecommendedGridView;

            function showRecommendedDetailView(jobId) {
                const gridView = document.getElementById('recommendedJobsGrid');
                const detailView = document.getElementById('recommendedDetailView');
                const viewAll = document.querySelector('.btn-view-all');
                const listColumn = document.getElementById('recListColumn');
                const detailColumn = document.getElementById('recDetailColumn');

                if (gridView) gridView.style.display = 'none';
                if (detailView) {
                    detailView.style.display = 'grid';
                    detailView.style.gridTemplateColumns = '450px 1fr';
                }
                if (listColumn) {
                    listColumn.style.display = 'block';
                    listColumn.style.visibility = 'visible';
                    listColumn.style.height = 'calc(100vh - 250px)';
                }
                if (detailColumn) {
                    detailColumn.style.display = 'block';
                    detailColumn.style.visibility = 'visible';
                    detailColumn.style.height = 'calc(100vh - 250px)';
                }
                if (viewAll) viewAll.style.display = 'none';

                // Set active item
                document.querySelectorAll('.rec-job-list-item').forEach(item => {
                    item.classList.toggle('active', item.getAttribute('data-job-id') == jobId);
                });

                loadRecommendedJobDetail(jobId);

                // ✅ FIX: Scroll tới section recommended jobs CHÍNH XÁC
                setTimeout(() => {
                    const recommendedContainer = document.getElementById('recommendedJobsContainer');
                    if (recommendedContainer) {
                        // Lấy vị trí của container
                        const containerRect = recommendedContainer.getBoundingClientRect();
                        const containerTop = window.pageYOffset + containerRect.top;

                        // Scroll tới container với offset 60px (phía trên header)
                        window.scrollTo({
                            top: containerTop - 60,
                            behavior: 'smooth'
                        });

                        console.log(`✅ Scrolled to recommended container at ${containerTop - 60}px`);
                    }
                }, 100);
            }

            function loadRecommendedJobDetail(jobId) {
                const detailColumn = document.getElementById('recDetailColumn');
                if (!detailColumn) {
                    console.error('❌ recDetailColumn not found');
                    return;
                }

                detailColumn.innerHTML = `
                    <div class="rec-job-detail-empty">
                        <i class="bi bi-hourglass-split"></i>
                        <p>Đang tải thông tin...</p>
                    </div>
                `;

                console.log(`🔄 Loading recommended job detail for job ${jobId}`);

                fetch(`/api/jobs/${jobId}`, {
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => {
                        console.log('📡 Response status:', response.status);
                        console.log('📡 Response headers:', response.headers);

                        // ✅ Xử lý chi tiết các lỗi HTTP
                        if (!response.ok) {
                            return response.json().then(errorData => {
                                throw new Error(errorData.error || errorData.message || `HTTP ${response.status}: ${response.statusText}`);
                            }).catch(jsonError => {
                                // Nếu response không phải JSON
                                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                            });
                        }
                        return response.json();
                    })
                    .then(job => {
                        console.log('✅ Job data received:', job);
                        renderRecommendedJobDetail(job);
                        // Check application status
                        checkApplicationStatus(jobId);
                    })
                    .catch(error => {
                        console.error('❌ Error loading job detail:', error);

                        // ✅ Hiển thị thông báo lỗi chi tiết
                        let errorMessage = 'Không thể tải thông tin công việc';
                        let errorDetail = error.message;

                        if (error.message.includes('404')) {
                            errorMessage = 'Công việc không tồn tại';
                            errorDetail = 'Công việc này có thể đã bị xóa hoặc hết hạn ứng tuyển.';
                        } else if (error.message.includes('500')) {
                            errorMessage = 'Lỗi máy chủ';
                            errorDetail = 'Vui lòng thử lại sau hoặc liên hệ quản trị viên.';
                        } else if (error.message.includes('Network')) {
                            errorMessage = 'Lỗi kết nối';
                            errorDetail = 'Vui lòng kiểm tra kết nối internet của bạn.';
                        }

                        detailColumn.innerHTML = `
                            <div class="rec-job-detail-empty">
                                <i class="bi bi-exclamation-circle text-danger" style="font-size: 3rem;"></i>
                                <h4 style="color: #dc3545; margin-top: 1rem;">${errorMessage}</h4>
                                <p style="color: #6c757d; margin-top: 0.5rem;">${errorDetail}</p>
                                <button onclick="showRecommendedGrid()" class="btn btn-primary mt-3">
                                    <i class="bi bi-arrow-left me-2"></i>Quay lại danh sách
                                </button>
                            </div>
                        `;

                        showToast(errorMessage, 'error');
                    });
            }

            function renderRecommendedJobDetail(job) {
                const formatMoney = (num) => new Intl.NumberFormat('vi-VN').format(num);
                const detailColumn = document.getElementById('recDetailColumn');

                if (!detailColumn) {
                    console.error('❌ recDetailColumn not found');
                    return;
                }

                if (!job || !job.job_id) {
                    console.error('❌ Invalid job data:', job);
                    detailColumn.innerHTML = `
                        <div class="rec-job-detail-empty">
                            <i class="bi bi-exclamation-circle"></i>
                            <p>Dữ liệu công việc không hợp lệ</p>
                        </div>
                    `;
                    return;
                }

                console.log('✅ Rendering job detail:', job);

                let salaryHtml = '';
                if (job.salary_min && job.salary_max) {
                    salaryHtml = `${formatMoney(job.salary_min)} - ${formatMoney(job.salary_max)} ${(job.salary_type || 'VND').toUpperCase()}`;
                } else {
                    salaryHtml = 'Thỏa thuận';
                }

                const logoHtml = job.company?.logo ?
                    `<img src="/assets/img/${job.company.logo}" alt="Company Logo" onerror="this.parentElement.innerHTML='<div style=\\'width: 100%; height: 100%; background: linear-gradient(135deg, #667EEA, #764BA2); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; font-weight: bold;\\'>${(job.company?.tencty?.charAt(0) || 'C')}</div>'">` :
                    `<div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667EEA, #764BA2); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; font-weight: bold;">${job.company?.tencty?.charAt(0) || 'C'}</div>`;

                detailColumn.innerHTML = `
                    <div class="job-detail-header">
                        <div class="job-detail-company">
                            <div class="company-logo-large">${logoHtml}</div>
                            <div class="job-detail-title-section">
                                <h2 class="job-detail-title">
                                    <a href="/job-detail/${job.job_id}" class="text-decoration-none text-dark hover-link-primary">
                                        ${job.title || 'Tiêu đề công việc'}
                                    </a>
                                </h2>
                                <div class="job-detail-company-name">${job.company?.tencty || 'Công ty'}</div>
                                <div class="job-detail-salary">${salaryHtml}</div>
                            </div>
                        </div>
                        <div class="job-detail-actions">
                            <button type="button" class="btn-apply-now" data-job-id="${job.job_id}">
                                <i class="bi bi-send-fill me-2"></i><span>Ứng tuyển ngay</span>
                            </button>
                            <button class="save-btn-large" data-job-id="${job.job_id}" title="Lưu công việc">
                                <i class="bi bi-heart" style="font-size: 1.2rem;"></i>
                            </button>
                        </div>
                    </div>
                    <div class="job-detail-content">
                        ${job.is_expired ? `
                        <div class="alert alert-warning" style="border-left: 4px solid #f59e0b; background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(245, 158, 11, 0.05) 100%); border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem;">
                            <i class="bi bi-exclamation-triangle-fill me-2" style="color: #f59e0b;"></i>
                            <strong>Công việc đã hết hạn ứng tuyển</strong>
                        </div>
                        ` : ''}
                        <div class="detail-section">
                            <h3 class="detail-section-title"><i class="bi bi-info-circle-fill"></i> Thông tin chung</h3>
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label"><i class="bi bi-briefcase"></i> Cấp bậc</div>
                                    <div class="info-value">${job.level || 'N/A'}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label"><i class="bi bi-geo-alt"></i> Địa điểm</div>
                                    <div class="info-value">${job.province || 'N/A'}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label"><i class="bi bi-calendar"></i> Hạn nộp</div>
                                    <div class="info-value">${job.deadline ? new Date(job.deadline).toLocaleDateString('vi-VN') : 'N/A'}</div>
                                </div>
                            </div>
                        </div>
                        ${job.description ? `
                        <div class="detail-section">
                            <h3 class="detail-section-title"><i class="bi bi-file-text-fill"></i> Mô tả công việc</h3>
                            <div class="job-description">${job.description.replace(/\n/g, '<br>')}</div>
                        </div>
                        ` : ''}
                        ${job.requirements ? `
                        <div class="detail-section">
                            <h3 class="detail-section-title"><i class="bi bi-list-check"></i> Yêu cầu ứng viên</h3>
                            <div class="job-description">${job.requirements.replace(/\n/g, '<br>')}</div>
                        </div>
                        ` : ''}
                        ${job.benefits ? `
                        <div class="detail-section">
                            <h3 class="detail-section-title"><i class="bi bi-gift-fill"></i> Quyền lợi</h3>
                            <div class="job-description">${job.benefits.replace(/\n/g, '<br>')}</div>
                        </div>
                        ` : ''}
                    </div>
                `;

                console.log('✅ Job detail rendered successfully');

                // ✅ ATTACH BUTTONS BẰNG JAVASCRIPT, KHÔNG DÙNG ONCLICK
                setTimeout(() => {
                    const applyBtn = detailColumn.querySelector('.btn-apply-now');
                    const saveBtn = detailColumn.querySelector('.save-btn-large');

                    if (applyBtn) {
                        // ✅ Disable nút nếu đã hết hạn
                        if (job.is_expired) {
                            applyBtn.disabled = true;
                            applyBtn.innerHTML = '<i class="bi bi-clock-history me-2"></i><span>Đã hết hạn</span>';
                            applyBtn.style.opacity = '0.6';
                            applyBtn.style.cursor = 'not-allowed';
                        } else {
                            applyBtn.addEventListener('click', function() {
                                if (!checkAuth()) {
                                    showToast('Vui lòng đăng nhập để ứng tuyển!', 'error');
                                    setTimeout(() => window.location.href = '/login', 1500);
                                    return;
                                }

                                if (this.classList.contains('applied')) {
                                    showToast('Bạn đã ứng tuyển công việc này rồi!', 'info');
                                    return;
                                }

                                window.currentJobId = job.job_id;
                                const modal = document.getElementById('applyJobModal');
                                if (modal) {
                                    const bsModal = new bootstrap.Modal(modal);
                                    bsModal.show();
                                }
                            });
                        }
                    }

                    if (saveBtn) {
                        saveBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            const isSaved = this.classList.contains('saved');
                            handleSaveJob(job.job_id, isSaved, this);
                        });
                    }
                }, 0);
            }

            // Back button handler
            const backRecBtn = document.getElementById('backToRecGrid');
            if (backRecBtn) {
                backRecBtn.addEventListener('click', showRecommendedGridView);
            }

            function handleRecListItemClick(e) {
                // ✅ Bỏ qua nếu click vào nút
                if (e.target.closest('.rec-list-apply, .rec-list-save')) {
                    return;
                }

                // ✅ Tìm job ID từ element cha (list item)
                const listItem = e.currentTarget; // Sử dụng currentTarget để lấy element mà event listener được attach vào
                const jobId = listItem?.getAttribute('data-job-id');

                if (jobId) {
                    console.log(`✅ List item clicked, opening detail for job ${jobId}`);
                    showRecommendedDetailView(jobId);
                }
            }

            function handleRecListApply(e) {
                e.preventDefault();
                e.stopPropagation();

                const item = this.closest('.rec-job-list-item');
                const jobId = item?.getAttribute('data-job-id');

                if (jobId) {
                    window.currentJobId = jobId;
                    const modal = document.getElementById('applyJobModal');
                    if (modal) {
                        const bsModal = new bootstrap.Modal(modal);
                        bsModal.show();
                    }
                }
            }

            function handleRecListSave(e) {
                e.preventDefault();
                e.stopPropagation();

                const item = this.closest('.rec-job-list-item');
                const jobId = item?.getAttribute('data-job-id');
                const isSaved = this.classList.contains('saved');

                if (jobId) {
                    handleSaveJob(jobId, isSaved, this);
                }
            }

            // Call attach function when document ready
            document.addEventListener('DOMContentLoaded', function() {
                // ✅ Cập nhật tổng số jobs - Chờ 500ms để chắc DOM đã load xong
                setTimeout(() => {
                    console.log('📊 Fetching total jobs count from API...');

                    fetch('/api/jobs/count/total')
                        .then(response => {
                            console.log('✅ API Response Status:', response.status);
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('📥 API Response Data:', data);
                            const titleElement = document.getElementById('totalJobsTitle');
                            console.log('🎯 Found title element:', titleElement);

                            if (data.success && titleElement) {
                                console.log('✏️ Updating total from', titleElement.textContent, 'to', data.total, 'cơ hội việc làm IT');
                                titleElement.textContent = data.total + ' cơ hội việc làm IT';
                                console.log('✅ Updated! New text:', titleElement.textContent);
                            } else {
                                console.warn('⚠️ Cannot update: success=' + data.success + ', element=' + !!titleElement);
                            }
                        })
                        .catch(error => {
                            console.error('❌ Error fetching job count:', error);
                        });
                }, 500);

                setTimeout(() => {
                    attachRecommendedDetailButtons();
                }, 300);
            });

            // Re-attach khi load thêm recommended jobs (nếu có)
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'childList') {
                        setTimeout(() => {
                            attachRecommendedDetailButtons();
                        }, 200);
                    }
                });
            });

            const recommendedGrid = document.getElementById('recommendedJobsGrid');
            if (recommendedGrid) {
                observer.observe(recommendedGrid, {
                    childList: true
                });
            }
            window.attachRecommendedJobsEvents = attachRecommendedJobsEvents;
            // ========================================
            // INITIALIZE
            // ========================================

            // ✅ INITIALIZE CURRENT FILTERED JOBS FROM GRID VIEW
            function initializeFilteredJobs() {
                if (gridView && gridView.innerHTML.trim()) {
                    const extracted = extractJobsFromHtml(gridView.innerHTML);

                    if (extracted && extracted.length > 0) {
                        currentFilteredJobs = extracted;
                        console.log('✅ Initialized current filtered jobs on page load:', currentFilteredJobs.length, 'jobs');
                    } else {
                        // ✅ FALLBACK: If extraction fails, use original sidebar jobs
                        console.log('⚠️ Failed to extract jobs from grid, using fallback');
                        if (jobListColumn && jobListColumn.innerHTML.trim()) {
                            // Jobs are already in sidebar, just mark them
                            const fallbackCards = jobListColumn.querySelectorAll('.job-card');
                            currentFilteredJobs = Array.from(fallbackCards).map(card => ({
                                job_id: card.getAttribute('data-job-id'),
                                title: card.querySelector('.job-card-title')?.textContent?.trim() || '',
                                company: card.querySelector('.company-name-small')?.textContent?.trim() || '',
                                salary: card.querySelector('.job-card-salary')?.textContent?.trim() || '',
                                province: card.querySelector('.job-card-meta-item:nth-child(1)')?.textContent?.trim() || '',
                                level: card.querySelector('.job-card-meta-item:nth-child(2)')?.textContent?.trim() || '',
                                experience: card.querySelector('.job-card-meta-item:nth-child(3)')?.textContent?.trim() || '',
                                deadline: card.querySelector('.job-card-deadline')?.textContent?.trim() || ''
                            }));
                            console.log('✅ Fallback: Loaded jobs from existing sidebar:', currentFilteredJobs.length, 'jobs');
                        }
                    }
                }
            }

            // Call initialization
            initializeFilteredJobs();

            attachJobCardEvents();

            // ✅ ATTACH RECOMMENDED JOBS EVENTS
            attachRecommendedDetailButtons();

            console.log('✅ All features initialized successfully');
        });
    </script>

    <!-- DROPDOWN THÔNG BÁO - GIỐNG HOME.BLADE -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnNotifications = document.getElementById('btnNotifications');
            const notificationDropdown = document.getElementById('notificationDropdown');
            const notificationList = document.getElementById('notificationList');
            const btnMarkAllRead = document.getElementById('btnMarkAllRead');
            const notificationBadge = document.getElementById('notificationBadge');

            // Toggle dropdown khi nhấn nút
            btnNotifications.addEventListener('click', function() {
                if (notificationDropdown.style.display === 'none' || notificationDropdown.style.display === '') {
                    loadNotifications();
                    notificationDropdown.style.display = 'flex';
                } else {
                    notificationDropdown.style.display = 'none';
                }
            });

            // Đóng dropdown khi nhấn ngoài
            document.addEventListener('click', function(e) {
                if (!e.target.closest('#btnNotifications') && !e.target.closest('#notificationDropdown')) {
                    notificationDropdown.style.display = 'none';
                }
            });

            // Load thông báo từ API
            async function loadNotifications() {
                try {
                    const response = await fetch('/applicant/api/notifications', {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const data = await response.json();

                    if (!data.success || data.notifications.length === 0) {
                        notificationList.innerHTML = '<div style="padding: 2rem 1rem; text-align: center; color: #9ca3af;"><i class="bi bi-inbox" style="font-size: 2rem; display: block; margin-bottom: 0.5rem; color: #d1d5db;"></i><p style="margin: 0;">Chưa có thông báo nào</p></div>';
                        return;
                    }

                    let html = '';
                    data.notifications.forEach(notification => {
                        html += `
                            <div class="notification-item" data-notification-id="${notification.id}" style="padding: 1.25rem; border-bottom: 1px solid #e5e7eb; transition: all 0.2s; cursor: pointer; ${!notification.is_read ? 'background-color: #eff6ff; border-left: 4px solid #3b82f6;' : ''}">
                                <div style="display: flex; justify-content: space-between; align-items: start; gap: 0.75rem;">
                                    <div style="flex: 1; min-width: 0;">
                                        <h6 style="margin: 0 0 0.75rem 0; font-weight: 600; color: #1f2937; font-size: 0.95rem; line-height: 1.4; word-wrap: break-word;">
                                            ${notification.message}
                                            ${!notification.is_read ? '<span class="badge bg-danger ms-2" style="font-size: 0.6rem;">Mới</span>' : ''}
                                        </h6>
                                        <small style="color: #9ca3af; font-size: 0.85rem;"><i class="bi bi-clock me-1"></i>${getTimeAgo(notification.created_at)}</small>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-sm" type="button" data-bs-toggle="dropdown" style="background: none; border: none; color: #9ca3af; padding: 0.25rem; flex-shrink: 0;">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            ${!notification.is_read ? `<li><a class="dropdown-item mark-read-btn" href="#" data-notification-id="${notification.id}"><i class="bi bi-check2 me-2"></i>Đánh dấu đã đọc</a></li>` : ''}
                                            <li><a class="dropdown-item text-danger delete-notification-btn" href="#" data-notification-id="${notification.id}"><i class="bi bi-trash me-2"></i>Xóa</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    notificationList.innerHTML = html;
                    attachNotificationEvents();
                } catch (error) {
                    console.error('Error loading notifications:', error);
                    notificationList.innerHTML = '<div style="padding: 2rem 1rem; text-align: center; color: #ef4444;"><p>Có lỗi xảy ra</p></div>';
                }
            }

            // Attach event listeners
            function attachNotificationEvents() {
                // ✅ CLICK VÀO THÔNG BÁO LỜI MỜI
                document.querySelectorAll('.notification-item').forEach(item => {
                    item.addEventListener('click', async (e) => {
                        if (e.target.closest('.dropdown-menu') || e.target.closest('button')) {
                            return; // Nếu click vào dropdown, skip
                        }

                        const notificationId = item.dataset.notificationId;
                        const notification = await getNotificationDetail(notificationId);

                        if (notification && notification.type === 'job_invitation' && notification.data?.job_id) {
                            const jobId = notification.data.job_id;

                            // ✅ ĐÁH DẤU ĐÃ ĐỌC
                            if (!notification.is_read) {
                                await markNotificationAsRead(notificationId);
                            }

                            // ✅ ĐÓNG DROPDOWN
                            notificationDropdown.style.display = 'none';

                            // ✅ REDIRECT ĐẾN TRANG JOB DETAIL VỚI JOB ĐƯỢC MỜI
                            // Thay vì load trong homeapp, redirect sang trang job-detail mới
                            setTimeout(() => {
                                window.location.href = `/job-detail/${jobId}`;
                            }, 500);

                            // ✅ RELOAD THÔNG BÁO
                            setTimeout(() => loadNotifications(), 1000);
                        }
                    });
                });

                // Mark as read
                document.querySelectorAll('.mark-read-btn').forEach(btn => {
                    btn.addEventListener('click', async (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        const notificationId = btn.dataset.notificationId;
                        await markNotificationAsRead(notificationId);
                        loadNotifications();
                    });
                });

                // Delete notification
                document.querySelectorAll('.delete-notification-btn').forEach(btn => {
                    btn.addEventListener('click', async (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        const notificationId = btn.dataset.notificationId;
                        await deleteNotification(notificationId);
                        loadNotifications();
                    });
                });
            }

            // ✅ LẤY CHI TIẾT THÔNG BÁO
            async function getNotificationDetail(notificationId) {
                try {
                    const response = await fetch(`/applicant/api/notifications/${notificationId}`, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        }
                    });
                    return await response.json();
                } catch (error) {
                    console.error('Error getting notification detail:', error);
                    return null;
                }
            }

            // Mark as read
            async function markNotificationAsRead(id) {
                try {
                    await fetch(`/applicant/notifications/${id}/read`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        }
                    });
                } catch (error) {
                    console.error('Error:', error);
                }
            }

            // Delete notification
            async function deleteNotification(id) {
                try {
                    await fetch(`/applicant/notifications/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        }
                    });
                } catch (error) {
                    console.error('Error:', error);
                }
            }

            // Mark all as read
            btnMarkAllRead.addEventListener('click', async () => {
                try {
                    const response = await fetch('/applicant/notifications/read-all', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        }
                    });
                    const data = await response.json();
                    if (data.success) {
                        loadNotifications();
                        notificationBadge.classList.add('d-none');
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            });

            // Time formatter
            function getTimeAgo(dateString) {
                const date = new Date(dateString);
                const now = new Date();
                const seconds = Math.floor((now - date) / 1000);

                if (seconds < 60) return 'Vừa xong';
                if (seconds < 3600) return Math.floor(seconds / 60) + ' phút trước';
                if (seconds < 86400) return Math.floor(seconds / 3600) + ' giờ trước';
                if (seconds < 604800) return Math.floor(seconds / 86400) + ' ngày trước';
                return date.toLocaleDateString('vi-VN');
            }
        });
    </script>
</body>

</html>