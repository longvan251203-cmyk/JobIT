<!DOCTYPE html>
<html lang="vi">

@include('applicant.partials.head')
<style>
    /* Reset default page spacing */
    html,
    body {
        margin: 0;
        padding: 0;
    }

    /* Header fixed */
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
    }

    .header-container {
        padding: 10px 16px;
        max-width: 1200px;
        margin: 0 auto;
        align-items: center;
    }

    #navmenu ul li {
        display: none !important;
    }

    .btn-my-jobs {
        display: none !important;
    }

    .btn-recommendations {
        opacity: 0.9;
        font-size: 0.95rem;
        padding: 6px 10px;
    }

    body {
        padding-top: 84px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        min-height: 100vh;
    }

    :root {
        --primary-color: #4f46e5;
        --secondary-color: #06b6d4;
        --accent-color: #f59e0b;
        --success-color: #10b981;
        --danger-color: #ef4444;
        --dark-bg: #0f172a;
        --light-bg: #f8fafc;
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        --hover-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
    }

    .main {
        padding: 2rem 0;
    }

    /* Sidebar Card */
    .sidebar-card-modern {
        background: white;
        border-radius: 24px !important;
        box-shadow: var(--card-shadow) !important;
        border: none !important;
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .sidebar-card-modern:hover {
        box-shadow: var(--hover-shadow) !important;
        transform: translateY(-4px);
    }

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
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        }

        50% {
            transform: scale(1.05);
            box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
        }
    }

    .nav-link {
        border-radius: 12px;
        padding: 0.75rem 1rem;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .nav-link:hover {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white !important;
        transform: translateX(5px);
    }

    .nav-link.active {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white !important;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }

    /* Page Header */
    .page-header {
        margin-bottom: 2rem;
    }

    .page-title {
        color: white;
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    /* Filter Tabs - Redesigned */
    .filter-tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 0.875rem 1.75rem;
        border-radius: 16px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        background: transparent;
        backdrop-filter: blur(10px);
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
    }

    .filter-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .filter-btn.active {
        background: white;
        color: var(--primary-color);
        border-color: white;
        box-shadow: 0 8px 24px rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    .filter-btn i {
        font-size: 1.1rem;
    }

    /* Invitation Card - Completely Redesigned */
    .invitation-card {
        background: white;
        border-radius: 24px;
        box-shadow: var(--card-shadow);
        border: none;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        position: relative;
    }

    .invitation-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), var(--accent-color));
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .invitation-card:hover {
        box-shadow: var(--hover-shadow);
        transform: translateY(-8px);
    }

    .invitation-card:hover::before {
        opacity: 1;
    }

    /* Card Header */
    .invitation-header {
        display: flex;
        align-items: flex-start;
        gap: 1.5rem;
        padding: 2rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
        position: relative;
    }

    .company-logo-wrapper {
        position: relative;
        flex-shrink: 0;
    }

    .company-logo {
        width: 90px;
        height: 90px;
        border-radius: 20px;
        object-fit: cover;
        border: 3px solid white;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        transition: transform 0.3s ease;
    }

    .invitation-card:hover .company-logo {
        transform: scale(1.05) rotate(2deg);
    }

    .invitation-title-block {
        flex: 1;
        min-width: 0;
    }

    .invitation-title-block h5 {
        font-size: 1.35rem;
        font-weight: 800;
        color: #1e293b;
        margin: 0 0 0.75rem 0;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .company-name {
        color: var(--primary-color);
        font-weight: 600;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }

    .company-name i {
        font-size: 1.1rem;
    }

    /* Status Badge - Enhanced */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1.25rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .status-badge::before {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }

    .status-pending {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }

    .status-pending::before {
        background: #f59e0b;
        animation: blink 2s infinite;
    }

    .status-accepted {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    .status-accepted::before {
        background: #10b981;
    }

    .status-rejected {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #7f1d1d;
    }

    .status-rejected::before {
        background: #ef4444;
    }

    .status-expired {
        background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
        color: #374151;
    }

    .status-expired::before {
        background: #6b7280;
    }

    @keyframes blink {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.3;
        }
    }

    /* Card Content - New Grid Layout */
    .invitation-content {
        padding: 2rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    .info-section {
        background: #f8fafc;
        padding: 1.5rem;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .info-section:hover {
        background: #f1f5f9;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
    }

    .info-section h6 {
        font-size: 0.8rem;
        font-weight: 800;
        text-transform: uppercase;
        color: #64748b;
        letter-spacing: 1px;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .info-section h6 i {
        color: var(--primary-color);
        font-size: 1.2rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 0.875rem 0;
        border-bottom: 1px solid #e2e8f0;
        gap: 1rem;
    }

    .info-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-label {
        font-size: 0.9rem;
        color: #64748b;
        font-weight: 600;
        flex-shrink: 0;
    }

    .info-value {
        font-size: 0.95rem;
        color: #1e293b;
        font-weight: 700;
        text-align: right;
    }

    /* Message Box - Enhanced */
    .message-box {
        padding: 1.75rem;
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        border-left: 5px solid #f59e0b;
        border-radius: 16px;
        margin: 0 2rem 2rem;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.15);
        position: relative;
        overflow: hidden;
    }

    .message-box::before {
        content: '\f4ad';
        font-family: 'Bootstrap Icons';
        position: absolute;
        right: 1rem;
        top: 1rem;
        font-size: 3rem;
        color: rgba(245, 158, 11, 0.1);
    }

    .message-box h6 {
        margin: 0 0 0.75rem 0;
        color: #92400e;
        font-weight: 800;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .message-box p {
        margin: 0;
        color: #78350f;
        font-size: 0.95rem;
        line-height: 1.7;
        position: relative;
        z-index: 1;
    }

    /* Footer with Actions - Redesigned */
    .invitation-footer {
        padding: 1.75rem 2rem;
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .invited-date {
        font-size: 0.9rem;
        color: #64748b;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .invited-date i {
        color: var(--primary-color);
        font-size: 1.1rem;
    }

    /* Action Buttons - Enhanced */
    .action-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 0.875rem 1.75rem;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        cursor: pointer;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-action i {
        font-size: 1.1rem;
    }

    .btn-accept {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .btn-accept:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(16, 185, 129, 0.4);
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
    }

    .btn-reject {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .btn-reject:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(239, 68, 68, 0.4);
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    }

    .btn-view-detail {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }

    .btn-view-detail:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(59, 130, 246, 0.4);
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    }

    /* Empty State - Enhanced */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
    }

    .empty-state-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 2rem;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: float 3s ease-in-out infinite;
    }

    .empty-state-icon i {
        font-size: 3.5rem;
        color: #9ca3af;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    .empty-state h5 {
        color: #374151;
        font-weight: 700;
        margin-bottom: 0.75rem;
        font-size: 1.5rem;
    }

    .empty-state p {
        color: #6b7280;
        margin: 0;
        font-size: 1rem;
        max-width: 400px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-title {
            font-size: 1.5rem;
        }

        .filter-tabs {
            gap: 0.5rem;
        }

        .filter-btn {
            padding: 0.75rem 1.25rem;
            font-size: 0.85rem;
        }

        .invitation-content {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .invitation-header {
            flex-direction: column;
            text-align: center;
            align-items: center;
        }

        .company-name {
            justify-content: center;
        }

        .action-buttons {
            width: 100%;
            justify-content: center;
        }

        .btn-action {
            flex: 1;
            justify-content: center;
        }

        .invitation-footer {
            flex-direction: column;
            text-align: center;
        }

        .message-box {
            margin: 0 1rem 1.5rem;
        }
    }

    /* Smooth Scroll */
    html {
        scroll-behavior: smooth;
    }

    /* Loading Animation */
    @keyframes shimmer {
        0% {
            background-position: -1000px 0;
        }

        100% {
            background-position: 1000px 0;
        }
    }

    .loading {
        animation: shimmer 2s infinite;
        background: linear-gradient(to right, #f3f4f6 0%, #e5e7eb 50%, #f3f4f6 100%);
        background-size: 1000px 100%;
    }

    /* Modal Scrollable Fix */
    .modal-apply-job .modal-dialog {
        max-height: 100vh;
    }

    .modal-apply-job .modal-content {
        max-height: 90vh;
        display: flex;
        flex-direction: column;
    }

    .modal-apply-job .modal-body {
        overflow-y: auto;
        max-height: calc(90vh - 130px);
        flex: 1;
    }

    .modal-apply-job .modal-header {
        flex-shrink: 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .modal-apply-job .modal-footer {
        flex-shrink: 0;
        border-top: 1px solid #e5e7eb;
    }

    /* Custom scrollbar for modal */
    .modal-apply-job .modal-body::-webkit-scrollbar {
        width: 8px;
    }

    .modal-apply-job .modal-body::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .modal-apply-job .modal-body::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    .modal-apply-job .modal-body::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* ========== ENHANCED MODAL STYLING ========== */
    .modal-apply-job .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }

    .modal-apply-job .modal-header {
        background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
        color: white;
        border-bottom: none;
        border-radius: 20px 20px 0 0;
        padding: 2rem;
    }

    .modal-apply-job .modal-header .modal-title {
        font-weight: 700;
        font-size: 1.35rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modal-apply-job .modal-header .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.8;
    }

    .modal-apply-job .modal-header .btn-close:hover {
        opacity: 1;
    }

    .modal-apply-job .form-label {
        font-weight: 600;
        color: #1e293b;
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
    }

    .modal-apply-job .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .modal-apply-job .form-control:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        background-color: #f8fafc;
    }

    .modal-apply-job .form-control:hover {
        border-color: #cbd5e1;
    }

    .modal-apply-job textarea.form-control {
        resize: vertical;
        min-height: 150px;
    }

    .modal-apply-job textarea.form-control:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    .modal-apply-job .modal-footer {
        border-top: 1px solid #e2e8f0;
        background: #f8fafc;
        padding: 1.5rem 2rem;
    }

    /* Section Dividers */
    .modal-apply-job hr {
        border: none;
        border-top: 2px solid #e2e8f0;
        opacity: 1;
        margin: 2rem 0;
    }

    /* Section Titles */
    .modal-apply-job h6 {
        font-weight: 700;
        color: #1e293b;
        font-size: 1.05rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modal-apply-job h6 i {
        color: #4f46e5;
        font-size: 1.2rem;
    }

    /* ========== HOMEAPP MODAL STYLING ========== */
    .required-mark {
        color: #ef4444;
        font-weight: 700;
    }

    .content-section {
        /* Base styling for upload and profile sections */
    }

    /* Upload Area Improvements */
    .upload-area {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 2.5rem 1.5rem;
        text-align: center;
        background: #f8fafc;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .upload-area:hover {
        border-color: #4f46e5;
        background: #f0f9ff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.1);
    }

    .upload-area.dragover {
        border-color: #4f46e5;
        background: #eff6ff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
    }

    .upload-icon {
        font-size: 3rem;
        color: #94a3b8;
        margin-bottom: 1rem;
    }

    .upload-area h6 {
        color: #1f2937;
        font-size: 1.1rem;
    }

    /* File Success Display */
    .fileNameDisplay {
        text-align: center;
        margin-top: 1rem;
    }

    .fileNameDisplay .alert {
        margin: 0;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
    }

    /* Profile Preview Card */
    .profile-preview-card {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.75rem;
        transition: all 0.3s ease;
    }

    .profile-preview-card:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        border-color: #cbd5e1;
    }

    .profile-avatar {
        width: 90px;
        height: 90px;
        border-radius: 12px;
        object-fit: cover;
        border: 3px solid #4f46e5;
        flex-shrink: 0;
        margin-right: 1.5rem;
    }

    .profile-info {
        text-align: left;
    }

    .profile-name {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.25rem;
    }

    .profile-title {
        font-size: 0.95rem;
        color: #64748b;
        margin-bottom: 0.75rem;
        font-weight: 500;
    }

    .profile-contact {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.9rem;
        color: #475569;
    }

    .contact-item i {
        color: #4f46e5;
        font-size: 1rem;
        flex-shrink: 0;
    }

    /* Textarea Letter */
    .letter-textarea {
        border: 2px solid #10b981 !important;
        border-radius: 12px;
        min-height: 150px;
        padding: 1rem;
        font-size: 0.95rem;
        resize: vertical;
        transition: all 0.3s ease;
    }

    .letter-textarea:focus {
        border-color: #059669 !important;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        background-color: #f0fdf4;
    }

    /* Character Count */
    .char-count {
        text-align: right;
        color: #9ca3af;
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }

    /* CV Option Card Improvements */
    .cv-option-card {
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        text-align: center;
        background: white;
    }

    .cv-option-card:hover {
        border-color: #4f46e5;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.1);
        transform: translateY(-2px);
    }

    .cv-option-card.active {
        border-color: #4f46e5;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(6, 182, 212, 0.05));
        box-shadow: 0 4px 16px rgba(79, 70, 229, 0.15);
    }

    .cv-option-card input[type="radio"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .cv-option-icon {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin: 0 auto 1rem;
    }

    .cv-option-title {
        font-size: 1.05rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .cv-option-desc {
        color: #6b7280;
        font-size: 0.9rem;
        line-height: 1.4;
    }

    /* Modal Form Buttons */
    .btn-cancel {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
        background: white;
        color: #374151;
        cursor: pointer;
    }

    .btn-cancel:hover {
        border-color: #cbd5e1;
        background: #f9fafb;
    }

    .btn-submit-apply {
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        color: white;
        cursor: pointer;
    }

    .btn-submit-apply:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.3);
    }

    .btn-submit-apply:disabled {
        background: #9ca3af;
        cursor: not-allowed;
        opacity: 0.6;
    }

    /* Select File Button */
    .btn-outline-primary {
        color: #4f46e5;
        border-color: #4f46e5;
    }

    .btn-outline-primary:hover {
        background: #4f46e5;
        border-color: #4f46e5;
        color: white;
    }

    /* ========== NOTIFICATION BADGE ========== */
    .badge-notification {
        position: absolute;
        top: -8px;
        right: -8px;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        border: 2px solid white;
        animation: badgePulse 2s ease-in-out infinite;
    }

    @keyframes badgePulse {

        0%,
        100% {
            transform: scale(1);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }

        50% {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.6);
        }
    }

    .badge-notification.new {
        animation: badgePopIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes badgePopIn {
        0% {
            transform: scale(0) rotate(-180deg);
            opacity: 0;
        }

        50% {
            transform: scale(1.15);
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>

<body>
    @include('applicant.partials.header')

    <main class="main">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <div id="profileSidebar" class="col-md-3 col-lg-3 mb-4 order-2 order-md-1 d-none d-md-block">
                    <div class="card sidebar-card-modern shadow-sm border-0 rounded-3">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="avatar-wrapper-modern">
                                    <img src="{{ $applicant->avatar ? asset('assets/img/avt/'.$applicant->avatar) : asset('assets/img/avt/default-avatar.png') }}"
                                        alt="Avatar">
                                    <div class="status-badge-modern"></div>
                                </div>
                                <h5 class="fw-bold">{{ $applicant->hoten_uv ?? 'Ứng viên' }}</h5>
                                <p class="text-secondary small mb-1">{{ Auth::user()->email }}</p>
                            </div>

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
                                    <a href="{{ route('applicant.hoso') }}#tab-attachments" class="nav-link text-dark">
                                        <i class="bi bi-file-earmark-text"></i> Hồ sơ đính kèm
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="{{ route('applicant.myJobs') }}" class="nav-link text-dark">
                                        <i class="bi bi-briefcase"></i> Việc làm của tôi
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="{{ route('applicant.jobInvitations') }}" class="nav-link active fw-bold text-primary position-relative">
                                        <i class="bi bi-envelope"></i> Lời mời ứng tuyển
                                        @if($invitations->where('status', 'pending')->count() > 0)
                                        <span class="badge-notification" id="invitationBadge">
                                            {{ $invitations->where('status', 'pending')->count() }}
                                        </span>
                                        @endif
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
                <div class="col-md-9 col-lg-9 order-1 order-md-2">
                    <div class="page-header">
                        <h2 class="page-title">
                            <i class="bi bi-envelope-check"></i>
                            <span>Lời mời ứng tuyển</span>
                        </h2>

                        <!-- Filter Tabs -->
                        <div class="filter-tabs">
                            <button class="filter-btn active" onclick="filterInvitations('all')">
                                <i class="bi bi-funnel"></i>
                                <span>Tất cả</span>
                                <span>(<span id="count-all">{{ $invitations->count() }}</span>)</span>
                            </button>
                            <button class="filter-btn" onclick="filterInvitations('pending')">
                                <i class="bi bi-hourglass-split"></i>
                                <span>Chờ phản hồi</span>
                                <span>(<span id="count-pending">{{ $invitations->where('status', 'pending')->count() }}</span>)</span>
                            </button>
                            <button class="filter-btn" onclick="filterInvitations('accepted')">
                                <i class="bi bi-check-circle"></i>
                                <span>Đã chấp nhận</span>
                                <span>(<span id="count-accepted">{{ $invitations->where('status', 'accepted')->count() }}</span>)</span>
                            </button>
                            <button class="filter-btn" onclick="filterInvitations('rejected')">
                                <i class="bi bi-x-circle"></i>
                                <span>Đã từ chối</span>
                                <span>(<span id="count-rejected">{{ $invitations->where('status', 'rejected')->count() }}</span>)</span>
                            </button>
                        </div>
                    </div>

                    <!-- Invitations List -->
                    <div id="invitationsContainer">
                        @if($invitations->count() > 0)
                        @foreach($invitations as $invitation)
                        <div class="invitation-card mb-4" data-status="{{ $invitation->status }}">
                            <!-- Header -->
                            <div class="invitation-header">
                                <div class="company-logo-wrapper">
                                    @if($invitation->job->company->getLogoUrl())
                                    <img src="{{ $invitation->job->company->getLogoUrl() }}"
                                        alt="Logo" class="company-logo">
                                    @else
                                    <div class="company-logo" style="background: linear-gradient(135deg, #667EEA, #764BA2); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 2rem;">
                                        {{ substr($invitation->job->company->getTenCty() ?? 'C', 0, 1) }}
                                    </div>
                                    @endif
                                </div>
                                <div class="invitation-title-block">
                                    <h5>{{ $invitation->job->title }}</h5>
                                    <p class="company-name mb-2">
                                        <i class="bi bi-building"></i>
                                        <span>{{ $invitation->job->company->getTenCty() }}</span>
                                    </p>
                                    <span class="status-badge status-{{ $invitation->status }}">
                                        {{ $invitation->getStatusLabel() }}
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="invitation-content">
                                <div class="info-section">
                                    <h6><i class="bi bi-info-circle"></i>Thông tin công việc</h6>
                                    <div class="info-item">
                                        <span class="info-label">Mức lương</span>
                                        <span class="info-value">
                                            @if($invitation->job->salary_min && $invitation->job->salary_max)
                                            {{ number_format($invitation->job->salary_min, 0, ',', '.') }} - {{ number_format($invitation->job->salary_max, 0, ',', '.') }} VNĐ
                                            @else
                                            Thỏa thuận
                                            @endif
                                        </span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Địa điểm</span>
                                        <span class="info-value">
                                            <i class="bi bi-geo-alt me-1"></i>
                                            {{ $invitation->job->province }}{{ $invitation->job->district ? ', ' . $invitation->job->district : '' }}
                                        </span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Số lượng tuyển</span>
                                        <span class="info-value">{{ $invitation->job->recruitment_count ?? 'N/A' }} vị trí</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Hạn nộp</span>
                                        <span class="info-value">
                                            @if($invitation->job->deadline)
                                            {{ \Carbon\Carbon::parse($invitation->job->deadline)->format('d/m/Y') }}
                                            @else
                                            Không giới hạn
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <div class="info-section">
                                    <h6><i class="bi bi-building"></i>Thông tin công ty</h6>
                                    <div class="info-item">
                                        <span class="info-label">Tên công ty</span>
                                        <span class="info-value">{{ $invitation->job->company->getTenCty() }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Quy mô</span>
                                        <span class="info-value">{{ $invitation->job->company->getQuyMo() ?? 'N/A' }} nhân viên</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Địa chỉ</span>
                                        <span class="info-value">{{ $invitation->job->company->getDiaChi() ?? 'N/A' }}</span>
                                    </div>
                                    @if($invitation->job->company->getPhone())
                                    <div class="info-item">
                                        <span class="info-label">Điện thoại</span>
                                        <span class="info-value"><a href="tel:{{ $invitation->job->company->getPhone() }}" class="text-primary text-decoration-none">{{ $invitation->job->company->getPhone() }}</a></span>
                                    </div>
                                    @endif
                                    @if($invitation->job->company->getCompanyEmail())
                                    <div class="info-item">
                                        <span class="info-label">Email</span>
                                        <span class="info-value"><a href="mailto:{{ $invitation->job->company->getCompanyEmail() }}" class="text-primary text-decoration-none">{{ $invitation->job->company->getCompanyEmail() }}</a></span>
                                    </div>
                                    @endif
                                    <div class="info-item">
                                        <span class="info-label">Website</span>
                                        <span class="info-value">
                                            @if($invitation->job->company->getWebsite())
                                            <a href="{{ $invitation->job->company->getWebsite() }}" target="_blank" class="text-primary text-decoration-none">
                                                Truy cập <i class="bi bi-box-arrow-up-right"></i>
                                            </a>
                                            @else
                                            N/A
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Message Box -->
                            @if($invitation->message)
                            <div class="message-box">
                                <h6><i class="bi bi-chat-left-text"></i>Tin nhắn từ nhà tuyển dụng</h6>
                                <p>{{ $invitation->message }}</p>
                            </div>
                            @endif

                            <!-- Footer with Actions -->
                            <div class="invitation-footer">
                                <span class="invited-date">
                                    <i class="bi bi-calendar"></i>
                                    <span>Nhận lời mời: {{ $invitation->invited_at ? $invitation->invited_at->format('d/m/Y H:i') : 'N/A' }}</span>
                                </span>

                                @if($invitation->status === 'pending')
                                <div class="action-buttons">
                                    <button class="btn-action btn-accept"
                                        data-invitation-id="{{ $invitation->id }}"
                                        data-job-id="{{ $invitation->job->job_id }}"
                                        onclick="handleAcceptInvitationButton(this, event)">
                                        <i class="bi bi-check-circle"></i>Chấp nhận
                                    </button>
                                    <button class="btn-action btn-reject" onclick="respondToInvitation('{{ $invitation->id }}', 'rejected')">
                                        <i class="bi bi-x-circle"></i>Từ chối
                                    </button>
                                    <button class="btn-action btn-view-detail" onclick="showJobDetail('{{ $invitation->job->job_id }}')">
                                        <i class="bi bi-eye"></i>Xem chi tiết
                                    </button>
                                </div>
                                @else
                                <div class="action-buttons">
                                    <button class="btn-action btn-view-detail" onclick="showJobDetail('{{ $invitation->job->job_id }}')">
                                        <i class="bi bi-eye"></i>Xem chi tiết
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="invitation-card">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="bi bi-inbox"></i>
                                </div>
                                <h5>Chưa có lời mời nào</h5>
                                <p>Hãy cập nhật hồ sơ đầy đủ để nhận được lời mời từ các nhà tuyển dụng</p>
                            </div>
                        </div>
                        @endif
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
                    <input type="hidden" name="job_id" id="modalJobId" value="">
                    <input type="hidden" name="invitation_id" id="modalInvitationId" value="">
                    <input type="hidden" name="accept_invitation" id="modalAcceptInvitation" value="0">
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

    @include('applicant.partials.footer')

    <script>
        // ========== CV MODAL STYLES ==========
        const cvStyles = `
            .cv-option-card {
                border: 2px solid #e5e7eb;
                border-radius: 16px;
                padding: 1.5rem;
                cursor: pointer;
                transition: all 0.3s ease;
                position: relative;
                text-align: center;
            }
            .cv-option-card:hover {
                border-color: #4f46e5;
                box-shadow: 0 4px 12px rgba(79, 70, 229, 0.1);
                transform: translateY(-2px);
            }
            .cv-option-card.active {
                border-color: #4f46e5;
                background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(6, 182, 212, 0.05));
                box-shadow: 0 4px 16px rgba(79, 70, 229, 0.15);
            }
            .cv-option-card input[type="radio"] {
                position: absolute;
                opacity: 0;
                cursor: pointer;
            }
            .cv-option-icon {
                width: 56px;
                height: 56px;
                background: linear-gradient(135deg, #4f46e5, #06b6d4);
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.5rem;
                margin: 0 auto 1rem;
            }
            .cv-option-title {
                font-size: 1.1rem;
                font-weight: 600;
                color: #1f2937;
                margin-bottom: 0.5rem;
            }
            .cv-option-desc {
                color: #6b7280;
                font-size: 0.9rem;
            }
            .upload-area {
                border: 2px dashed #cbd5e1;
                border-radius: 12px;
                padding: 2rem;
                text-align: center;
                background: #f8fafc;
                transition: all 0.3s ease;
                cursor: pointer;
            }
            .upload-area:hover {
                border-color: #4f46e5;
                background: #f0f9ff;
            }
            .upload-area.dragover {
                border-color: #4f46e5;
                background: #eff6ff;
            }
            .upload-icon {
                font-size: 3rem;
                color: #94a3b8;
                margin-bottom: 1rem;
            }
            .btn-cancel {
                border: 2px solid #e5e7eb;
                border-radius: 12px;
                padding: 0.75rem 2rem;
                font-weight: 600;
                transition: all 0.3s ease;
                background: white;
                color: #374151;
            }
            .btn-cancel:hover {
                border-color: #cbd5e1;
                background: #f9fafb;
            }
            .btn-submit-apply {
                background: linear-gradient(135deg, #4f46e5, #06b6d4);
                border: none;
                padding: 0.75rem 2rem;
                border-radius: 12px;
                font-weight: 600;
                transition: all 0.3s ease;
                color: white;
            }
            .btn-submit-apply:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(79, 70, 229, 0.3);
            }
            .btn-submit-apply:disabled {
                background: #9ca3af;
                cursor: not-allowed;
                opacity: 0.6;
            }
        `;

        const styleSheet = document.createElement('style');
        styleSheet.textContent = cvStyles;
        document.head.appendChild(styleSheet);

        // ========== CHECK AUTH ==========
        function checkAuth() {
            var isAuth = '{{ Auth::check() ? "true" : "false" }}';
            return isAuth === 'true' || isAuth === true;
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
                position: fixed; top: 100px; right: 20px;
                background: ${bgColor}; color: white;
                padding: 1rem 1.5rem; border-radius: 12px;
                box-shadow: 0 8px 24px rgba(0,0,0,0.25);
                z-index: 9999; animation: slideInRight 0.3s ease;
                display: flex; align-items: center; gap: 0.75rem;
                font-weight: 500; min-width: 280px;
            `;

            toast.innerHTML = `<i class="bi ${icon}" style="font-size: 1.2rem;"></i><span>${message}</span>`;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        if (!document.getElementById('toast-animations')) {
            const style = document.createElement('style');
            style.id = 'toast-animations';
            style.textContent = `
                @keyframes slideInRight {
                    from { transform: translateX(400px); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
                @keyframes slideOutRight {
                    from { transform: translateX(0); opacity: 1; }
                    to { transform: translateX(400px); opacity: 0; }
                }
            `;
            document.head.appendChild(style);
        }

        // ========== HANDLE ACCEPT INVITATION (HOMEAPP LOGIC) ==========
        window.handleAcceptInvitationButton = function(button, event) {
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
            showToast('📋 Vui lòng hoàn tất thông tin ứng tuyển để gửi hồ sơ', 'success');
            const modal = new bootstrap.Modal(document.getElementById('applyJobModal'));
            modal.show();
        };

        function filterInvitations(status) {
            const buttons = document.querySelectorAll('.filter-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.closest('.filter-btn').classList.add('active');

            const cards = document.querySelectorAll('[data-status]');
            cards.forEach(card => {
                if (status === 'all' || card.getAttribute('data-status') === status) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function respondToInvitation(invitationId, response) {
            if (!confirm(`Bạn chắc chắn muốn ${response === 'accepted' ? 'chấp nhận' : 'từ chối'} lời mời này?`)) {
                return;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            fetch(`/api/job-invitations/${invitationId}/respond`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        response: response,
                        message: ''
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.message, 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        showToast(data.message || 'Có lỗi xảy ra', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Có lỗi xảy ra khi xử lý yêu cầu', 'error');
                });
        }

        // ========== CV TYPE SELECTION ==========
        document.addEventListener('DOMContentLoaded', function() {
            const cvTypeRadios = document.querySelectorAll('input[name="cv_type"]');
            const uploadSection = document.getElementById('uploadSection');
            const profileSection = document.getElementById('profileSection');

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

            // ========== FILE UPLOAD HANDLING ==========
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
                    showToast('Chỉ chấp nhận file .doc, .docx, .pdf', 'error');
                    return;
                }

                if (file.size > maxSize) {
                    showToast('File không được vượt quá 5MB', 'error');
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

            // ========== CHARACTER COUNT ==========
            const letterTextarea = document.querySelector('[name="thugioithieu"]');
            const charCount = document.getElementById('charCount');

            if (letterTextarea) {
                letterTextarea.addEventListener('input', function() {
                    charCount.textContent = this.value.length;
                });
                charCount.textContent = letterTextarea.value.length;
            }

            // ========== FORM SUBMISSION - 2-STEP (Apply + Respond) ==========
            const applyJobForm = document.getElementById('applyJobForm');

            if (applyJobForm) {
                applyJobForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const cvType = document.querySelector('input[name="cv_type"]:checked').value;

                    if (cvType === 'upload' && !cvFileInput.files.length) {
                        showToast('Vui lòng tải lên CV của bạn', 'error');
                        return;
                    }

                    const formData = new FormData(this);
                    const submitBtn = this.querySelector('.btn-submit-apply');
                    const originalText = submitBtn.innerHTML;

                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Đang gửi...';

                    // ✅ STEP 1: GỬI FORM ỨNG TUYỂN
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

                                // ✅ STEP 2: KIỂM TRA XEM CÓ CHẤP NHẬN LỜI MỜI KHÔNG
                                const invitationId = document.getElementById('modalInvitationId').value;
                                const acceptInvitation = document.getElementById('modalAcceptInvitation').value;
                                const jobId = document.getElementById('modalJobId').value;

                                console.log(`📋 Form submitted with:`, {
                                    invitationId,
                                    acceptInvitation,
                                    jobId
                                });

                                // Nếu có invitationId và đánh dấu accept
                                if (invitationId && acceptInvitation === '1') {
                                    console.log(`✅ Accepting invitation after application submitted...`);

                                    // ✅ STEP 3: GỬI API CHẤP NHẬN LỜI MỜI
                                    respondToInvitationAfterApply(invitationId, 'accepted', jobId);
                                }

                                // STEP 4: ĐÓNG MODAL
                                const modal = bootstrap.Modal.getInstance(document.getElementById('applyJobModal'));
                                if (modal) modal.hide();

                                // STEP 5: RESET FORM
                                applyJobForm.reset();
                                document.getElementById('modalInvitationId').value = '';
                                document.getElementById('modalAcceptInvitation').value = '0';
                                document.getElementById('modalJobId').value = '';
                                document.getElementById('fileNameDisplay').style.display = 'none';
                                document.getElementById('uploadArea').style.display = 'block';

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

            // ========== RESPOND TO INVITATION AFTER APPLY ==========
            window.respondToInvitationAfterApply = function(invitationId, response, jobId) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                if (!csrfToken) {
                    console.error('❌ CSRF token not found!');
                    showToast('Có lỗi bảo mật. Vui lòng tải lại trang!', 'error');
                    return;
                }

                console.log(`📤 Sending request to /api/job-invitations/${invitationId}/respond`, {
                    invitationId,
                    response,
                    jobId
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
                                '✅ Đã nộp hồ sơ + Chấp nhận lời mời!' :
                                '❌ Đã từ chối lời mời!';
                            showToast(message, 'success');

                            // Reload page sau 2 giây
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            showToast(data.message || 'Có lỗi xảy ra!', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('❌ Fetch error:', error);
                        showToast('Có lỗi xảy ra: ' + error.message, 'error');
                    });
            };
        });

        function showJobDetail(jobId) {
            window.location.href = `/job-post/${jobId}`;
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed;
                top: 100px;
                right: 20px;
                background: ${type === 'success' ? 'linear-gradient(135deg, #10b981, #059669)' : 'linear-gradient(135deg, #ef4444, #dc2626)'};
                color: white;
                padding: 18px 24px;
                border-radius: 16px;
                box-shadow: 0 12px 32px rgba(0,0,0,0.2);
                z-index: 9999;
                animation: slideInRight 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 12px;
                min-width: 300px;
            `;

            const icon = type === 'success' ? '✓' : '✕';
            toast.innerHTML = `
                <span style="font-size: 1.5rem;">${icon}</span>
                <span>${message}</span>
            `;

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.animation = 'slideOutRight 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                setTimeout(() => toast.remove(), 400);
            }, 3000);
        }

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from {
                    transform: translateX(400px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            @keyframes slideOutRight {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(400px);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // ========== UPDATE INVITATION BADGE ==========
        window.updateInvitationBadge = function(count) {
            const badge = document.getElementById('invitationBadge');
            if (count > 0) {
                if (!badge) {
                    const navLink = document.querySelector('a[href="{{ route("applicant.jobInvitations") }}"]');
                    if (navLink) {
                        const newBadge = document.createElement('span');
                        newBadge.id = 'invitationBadge';
                        newBadge.className = 'badge-notification new';
                        newBadge.textContent = count;
                        navLink.appendChild(newBadge);
                    }
                } else {
                    const oldCount = parseInt(badge.textContent);
                    if (count > oldCount) {
                        badge.classList.add('new');
                        setTimeout(() => badge.classList.remove('new'), 500);
                    }
                    badge.textContent = count;
                }
            } else if (badge) {
                badge.remove();
            }
        };

        // ========== POLLING FOR NEW INVITATIONS ==========
        setInterval(() => {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (!csrfToken) return;

            fetch('/api/invitations/pending-count', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.count !== undefined) {
                        window.updateInvitationBadge(data.count);
                    }
                })
                .catch(error => console.log('Polling invitation count...'));
        }, 30000); // Poll every 30 seconds
    </script>
</body>

</html>