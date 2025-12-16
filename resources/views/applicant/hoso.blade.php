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

    /* ... existing styles ... */

    /* Make header fixed at the top but minimal for the profile edit page.
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
    body {
        padding-top: 84px;
    }

    /* ✅ FIX AVATAR BỊCO DÃNCO DÃN */
    #avatarPreview {
        width: 150px !important;
        height: 150px !important;
        object-fit: cover !important;
        object-position: center !important;
        border-radius: 50% !important;
        border: 5px solid #667eea !important;
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3) !important;
        flex-shrink: 0;
    }

    /* Container avatar */
    .position-relative.d-inline-block {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
<style>
    /* Custom style cho ngoại ngữ section */
    /* Custom style cho ngoại ngữ section */
    #mota_duan {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        resize: vertical;
    }

    #mota_duan:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
    }

    /* Button insert template */
    #insertTemplateBtn {
        transition: all 0.3s ease;
    }

    #insertTemplateBtn:hover {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    #selectedLanguages .badge {
        font-size: 0.9rem;
    }

    .removeLanguageBtn:hover {
        opacity: 0.8;
    }

    .deleteNgoaiNguBtn {
        text-decoration: none;
    }

    .deleteNgoaiNguBtn:hover {
        transform: scale(1.1);
    }

    :root {
        --primary-color: #4f46e5;
        --secondary-color: #06b6d4;
        --accent-color: #f59e0b;
        --dark-bg: #0f172a;
        --light-bg: #f8fafc;
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        --hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        min-height: 100vh;
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
        position: sticky;
        top: 100px;
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
        }

        50% {
            transform: scale(1.1);
        }
    }

    .nav-link {
        border-radius: 12px;
        padding: 0.75rem 1rem;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .nav-link:hover {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white !important;
        transform: translateX(5px);
    }

    .nav-link.active {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white !important;
    }

    /* Profile Cards */
    .card.shadow-sm {
        background: white;
        border-radius: 24px !important;
        box-shadow: var(--card-shadow) !important;
        border: none !important;
        transition: all 0.3s ease;
    }

    .card.shadow-sm:hover {
        box-shadow: var(--hover-shadow) !important;
        transform: translateY(-4px);
    }

    /* Header Card with Gradient */
    .header-card-gradient {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
        color: white !important;
        position: relative;
        overflow: hidden;
    }

    .header-card-gradient::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .header-card-gradient .card-body {
        position: relative;
        z-index: 1;
    }

    .profile-avatar-modern {
        width: 140px;
        height: 140px;
        border-radius: 24px;
        object-fit: cover;
        border: 5px solid white;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    /* Section Headers */
    .section-header-modern {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .section-icon-modern {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    /* Buttons Modern */
    .btn-modern {
        border-radius: 12px !important;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-primary,
    .btn-danger {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
        border: none !important;
    }

    .btn-primary:hover,
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(79, 70, 229, 0.4) !important;
    }

    .btn-outline-primary {
        border: 2px solid var(--primary-color) !important;
        color: var(--primary-color) !important;
    }

    .btn-outline-primary:hover {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
        color: white !important;
        border-color: transparent !important;
    }

    .btn-light.rounded-circle {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
        color: white !important;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
    }

    .btn-light.rounded-circle:hover {
        transform: rotate(90deg) scale(1.1);
        box-shadow: 0 8px 25px rgba(79, 70, 229, 0.5) !important;
    }

    /* Timeline Design */
    .timeline-item-modern {
        position: relative;
        padding-left: 2.5rem;
        padding-bottom: 1.5rem;
        border-left: 3px solid var(--primary-color);
    }

    .timeline-item-modern:last-child {
        border-left: 3px solid transparent;
    }

    .timeline-dot-modern {
        position: absolute;
        left: -9px;
        top: 0;
        width: 18px;
        height: 18px;
        background: var(--primary-color);
        border: 4px solid white;
        border-radius: 50%;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.2);
    }

    .timeline-content-modern {
        background: var(--light-bg);
        padding: 1.5rem;
        border-radius: 16px;
        transition: all 0.3s ease;
    }

    .timeline-content-modern:hover {
        background: white;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        transform: translateX(5px);
    }

    /* Skills Badge */
    .badge.bg-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
        padding: 0.6rem 1.2rem !important;
        border-radius: 50px !important;
        font-weight: 600 !important;
        transition: all 0.3s ease;
    }

    .badge.bg-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(79, 70, 229, 0.4);
    }

    /* Info Tags */
    .info-tag-modern {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        margin: 0.25rem;
        color: white;
    }

    .info-tag-modern i {
        opacity: 0.9;
    }

    /* Modal Styling */
    .modal-content {
        border-radius: 24px !important;
        border: none !important;
    }

    .modal-header {
        border-radius: 24px 24px 0 0 !important;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border-bottom: none !important;
    }

    /* ✅ CV MODAL STYLING */
    .cv-modal-content {
        border-radius: 24px !important;
        border: none !important;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3) !important;
    }

    .cv-modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        border: none !important;
        border-radius: 24px 24px 0 0 !important;
        color: white;
    }

    .cv-modal-body {
        background: #f8fafc;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .cv-sidebar {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
    }

    .cv-avatar {
        border: 5px solid #667eea;
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
        width: 150px;
        height: 150px;
        object-fit: cover;
    }

    .cv-section-title {
        color: #1f2937;
        border-bottom: 3px solid #667eea;
        padding-bottom: 12px;
        margin-bottom: 16px;
        font-weight: 700;
        font-size: 1.05rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .cv-info-item {
        padding: 12px 0;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .cv-info-item:last-child {
        border-bottom: none;
    }

    .cv-info-item i {
        color: #667eea;
        font-size: 1.1rem;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .cv-info-label {
        font-size: 0.75rem;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        display: block;
        margin-bottom: 2px;
    }

    .cv-info-value {
        font-size: 0.9rem;
        color: #1f2937;
        font-weight: 500;
    }

    .cv-content-section {
        margin-bottom: 28px;
        padding-bottom: 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .cv-content-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .cv-timeline-item {
        padding-left: 20px;
        border-left: 3px solid #667eea;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 16px;
    }

    .cv-timeline-item:last-child {
        padding-bottom: 0;
    }

    .cv-timeline-item::before {
        content: '';
        position: absolute;
        left: -8px;
        top: 4px;
        width: 12px;
        height: 12px;
        background: #667eea;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 0 0 2px #667eea;
    }

    .cv-job-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 6px;
    }

    .cv-company {
        font-size: 0.95rem;
        color: #667eea;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .cv-date {
        font-size: 0.85rem;
        color: #6b7280;
        margin-bottom: 12px;
    }

    .cv-description {
        font-size: 0.9rem;
        color: #374151;
        line-height: 1.6;
        margin-bottom: 8px;
    }

    .cv-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 8px 14px;
        border-radius: 50px;
        font-size: 0.85rem;
        margin-right: 8px;
        margin-bottom: 10px;
        display: inline-block;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .cv-modal-footer {
        background: white;
        border-top: 1px solid #e5e7eb;
        border-radius: 0 0 24px 24px;
        padding: 20px 24px;
    }

    .cv-modal-footer .btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .cv-modal-footer .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }

    .cv-modal-footer .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }

    @media print {

        .cv-modal-header,
        .cv-modal-footer {
            display: none !important;
        }

        .cv-modal-body {
            background: white !important;
            max-height: none !important;
        }
    }

    /* Larger textarea helper for desktop; mobile override exists below */
    .textarea-large {
        min-height: 350px;
        font-size: 14px;
        line-height: 1.5;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .main {
            padding: 1rem 0;
        }

        .card {
            margin-bottom: 1rem !important;
        }

        /* Make avatar and profile images smaller on mobile */
        .avatar-wrapper-modern,
        .avatar-wrapper-modern img,
        .profile-avatar-modern {
            width: 84px !important;
            height: 84px !important;
        }

        /* Slightly reduce padding in header card */
        .header-card-gradient .card-body {
            padding: 0.75rem !important;
        }

        /* Sidebar card spacing for stacked layout */
        #profileSidebar {
            margin-bottom: 1rem;
        }

        /* Ensure modals use full width comfortably on small devices */
        .modal-dialog {
            max-width: 95% !important;
            margin: 0.5rem auto;
        }

        /* Reduce tall textareas on mobile to avoid huge scroll gaps */
        textarea.form-control {
            min-height: 160px !important;
            font-size: 13px !important;
        }
    }
</style>

<body>
    @include('applicant.partials.header')

    <!-- Notifications: use header's global notification UI when available (kept generic here) -->

    <!-- Page-scoped notification script and header tweaks (kept inside hoso.blade.php) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Prefer header's global notification UI; fall back to page-scoped if present
            const btn = document.getElementById('btnNotifications') || document.getElementById('btnNotificationsPage');
            const dropdown = document.getElementById('notificationDropdown') || document.getElementById('notificationDropdownPage');
            const listEl = document.getElementById('notificationList') || document.getElementById('notificationListPage');
            const badge = document.getElementById('notificationBadge') || document.getElementById('notificationBadgePage');
            const markAllBtn = document.getElementById('btnMarkAllRead') || document.getElementById('btnMarkAllReadPage');

            // Default routes (explicit paths so JS works even if route() names are missing)
            const defaultNotificationsApi = '/applicant/api/notifications';
            const defaultNotificationsReadAll = '/applicant/notifications/read-all';
            const defaultNotificationsUnread = '/applicant/notifications/unread-count';

            // Read notification route URLs from the button's data-attributes or fall back to defaults
            let notificationsApi = btn?.dataset.notificationsApi || defaultNotificationsApi || null;
            let notificationsReadAll = btn?.dataset.notificationsReadall || defaultNotificationsReadAll || null;
            let notificationsUnread = btn?.dataset.notificationsUnread || defaultNotificationsUnread || null;

            if (!btn) return; // nothing to bind to on this page

            async function fetchNotifications() {
                try {
                    if (!notificationsApi) return null;
                    console.debug('[notifications] fetching from', notificationsApi);
                    const res = await fetch(notificationsApi, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    if (!res.ok) throw new Error('Network');
                    const data = await res.json();
                    console.debug('[notifications] response', data);
                    // Controller returns { success: true, notifications: [...] }
                    if (data && Array.isArray(data.notifications)) return data.notifications;
                    if (Array.isArray(data)) return data;
                    return [];
                } catch (e) {
                    console.error('[notifications] fetch error', e);
                    return null;
                }
            }

            function renderEmpty() {
                listEl.innerHTML = '<div style="padding:2.5rem 1.5rem;text-align:center;color:#9ca3af;">' +
                    '<i class="bi bi-inbox" style="font-size:2.5rem;display:block;margin-bottom:.75rem;color:#d1d5db;"></i>' +
                    '<p style="margin:0;">Chưa có thông báo nào</p></div>';
                badge && badge.classList.add('d-none');
            }

            function escapeHtml(str) {
                if (!str) return '';
                return String(str).replace(/[&<>"']/g, function(s) {
                    return ({
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&quot;',
                        "'": "&#39;"
                    })[s];
                });
            }

            async function loadAndRender() {
                const items = await fetchNotifications();
                if (!items || items.length === 0) {
                    renderEmpty();
                    return;
                }

                badge && badge.classList.remove('d-none');
                listEl.innerHTML = '';
                items.forEach(n => {
                    const row = document.createElement('div');
                    row.style.padding = '0.85rem 1rem';
                    row.style.borderBottom = '1px solid #eef2f6';
                    row.innerHTML = `
                        <div style="display:flex;gap:.75rem;align-items:flex-start;">
                            <div style="flex:1">
                                <div style="font-weight:600;color:#1f2937">${escapeHtml(n.message || '')} ${!n.is_read ? '<span class="badge bg-danger ms-2" style="font-size:.6rem;">Mới</span>' : ''}</div>
                                <div style="color:#9ca3af;font-size:.8rem;margin-top:6px">${n.created_at || ''}</div>
                            </div>
                            <div style="flex-shrink:0;margin-left:8px">
                                <button data-id="${n.id}" class="mark-read-btn" style="background:none;border:1px solid #e6eefc;border-radius:6px;padding:.35rem .5rem;cursor:pointer">Đã đọc</button>
                            </div>
                        </div>
                    `;
                    listEl.appendChild(row);
                });

                listEl.querySelectorAll('.mark-read-btn').forEach(b => {
                    b.addEventListener('click', async function(ev) {
                        ev.preventDefault();
                        const id = this.dataset.id;
                        await markAsRead(id);
                        this.closest('div').remove();
                    });
                });
            }

            async function markAsRead(id) {
                try {
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    await fetch(`/applicant/notifications/${id}/read`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token
                        }
                    });
                    updateUnreadCount();
                } catch (e) {
                    console.error(e);
                }
            }

            async function markAll() {
                try {
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    if (!notificationsReadAll) return;
                    const res = await fetch(notificationsReadAll, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token
                        }
                    });
                    if (res.ok) {
                        renderEmpty();
                    }
                    updateUnreadCount();
                } catch (e) {
                    console.error(e);
                }
            }

            async function updateUnreadCount() {
                try {
                    if (!notificationsUnread) return;
                    const res = await fetch(notificationsUnread, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    if (!res.ok) return;
                    const data = await res.json();
                    console.debug('[notifications] unread count response', data);
                    const count = data.count ?? data;
                    if (badge) {
                        if (count > 0) {
                            badge.textContent = count > 99 ? '99+' : count;
                            badge.classList.remove('d-none');
                        } else badge.classList.add('d-none');
                    }
                } catch (e) {
                    console.error(e);
                }
            }

            btn.addEventListener('click', function(e) {
                const expanded = btn.getAttribute('aria-expanded') === 'true';
                if (!expanded) {
                    btn.setAttribute('aria-expanded', 'true');
                    if (dropdown) dropdown.style.display = 'block';
                    loadAndRender();
                } else {
                    btn.setAttribute('aria-expanded', 'false');
                    if (dropdown) dropdown.style.display = 'none';
                }
            });

            if (markAllBtn) markAllBtn.addEventListener('click', function(e) {
                e.preventDefault();
                markAll();
            });

            // initial count
            updateUnreadCount();
        });
    </script>

    <main class="main">
        <div class="container-fluid">

            <!-- ✅ TOAST NOTIFICATION CONTAINER -->
            <div id="toastContainer" style="position: fixed; top: 100px; right: 20px; z-index: 9999; min-width: 300px;"></div>

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
                                    <a href="#" class="nav-link active fw-bold text-primary tab-link-personal" data-tab="personal">
                                        <i class="bi bi-person-badge"></i> Thông tin cá nhân
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#" class="nav-link text-dark tab-link-attachments" data-tab="attachments"><i class="bi bi-file-earmark-text"></i> Hồ sơ đính kèm</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="{{ route('applicant.myJobs') }}" class="nav-link text-dark"><i class="bi bi-briefcase"></i> Việc làm của tôi</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="{{ route('applicant.jobInvitations') }}" class="nav-link text-dark"><i class="bi bi-envelope"></i> Lời mời công việc</a>
                                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link text-dark"><i class="bi bi-gear"></i> Cài đặt</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Nội dung chính -->
                <div class="col-md-9 col-lg-9 order-1 order-md-2">

                    <!-- Mobile: button to toggle profile sidebar -->
                    <div class="d-md-none mb-3">
                        <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#profileSidebar" aria-expanded="false" aria-controls="profileSidebar">
                            <i class="bi bi-list"></i> Menu hồ sơ
                        </button>
                    </div>

                    <!-- Thông tin cá nhân - SHARED ACROSS ALL TABS -->
                    <div class="card header-card-gradient shadow-sm border-0 rounded-3 mb-4">
                        <div class="card-body row align-items-center">

                            <!-- Avatar bên trái -->
                            <div class="col-md-3 text-center">
                                <img src="{{ $applicant->avatar ? asset('assets/img/avt/'.$applicant->avatar) : asset('assets/img/avt/default-avatar.png') }}"
                                    alt="Avatar"
                                    class="profile-avatar-modern">
                            </div>

                            <!-- Thông tin cá nhân -->
                            <div class="col-md-9">
                                <h2 class="fw-bold mb-2">{{ $applicant->hoten_uv ?? 'Họ tên ứng viên' }}</h2>
                                <p class="mb-3 opacity-90">{{ $applicant->vitriungtuyen ?? 'Chưa cập nhật chức danh' }}</p>

                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span class="info-tag-modern">
                                        <i class="bi bi-envelope"></i> {{ Auth::user()->email }}
                                    </span>
                                    <span class="info-tag-modern">
                                        <i class="bi bi-telephone"></i> {{ $applicant->sdt_uv ?? 'Chưa cập nhật' }}
                                    </span>
                                    <span class="info-tag-modern">
                                        <i class="bi bi-calendar"></i> {{ $applicant->ngaysinh ?? 'Chưa cập nhật' }}
                                    </span>
                                    <span class="info-tag-modern">
                                        <i class="bi bi-gender-ambiguous"></i> {{ $applicant->gioitinh_uv ?? 'Chưa cập nhật' }}
                                    </span>
                                    <span class="info-tag-modern">
                                        <i class="bi bi-geo-alt"></i> {{ $applicant->diachi_uv ?? 'Chưa cập nhật' }}
                                    </span>
                                    <!-- Thêm vào div .d-flex.flex-wrap.gap-2.mb-3 trong header card -->
                                    @if($applicant->mucluong_mongmuon)
                                    <span class="info-tag-modern">
                                        <i class="bi bi-cash-coin"></i> {{ $applicant->mucluong_mongmuon }}
                                    </span>
                                    @endif
                                </div>

                                <!-- Nút chỉnh sửa -->
                                <a href="#" class="btn btn-light btn-modern btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                    <i class="bi bi-pencil-square"></i> Chỉnh sửa hồ sơ
                                </a>
                                <a href="#" class="btn btn-light btn-modern btn-sm" data-bs-toggle="modal" data-bs-target="#viewCVModal">
                                    <i class="bi bi-file-earmark-person"></i> Xem CV
                                </a>
                            </div>

                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-personal" role="tabpanel" aria-labelledby="tab-personal-pill">

                            <!-- Giới thiệu bản thân -->
                            <div class="card shadow-sm border-0 rounded-3 mb-3">
                                <div class="card-body d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="section-header-modern">
                                            <div class="section-icon-modern">
                                                <i class="bi bi-person"></i>
                                            </div>
                                            <h5 class="fw-bold mb-0">Giới thiệu bản thân</h5>
                                        </div>
                                        <p class="text-muted mb-0">
                                            {!! $applicant->gioithieu ?? 'Chưa có nội dung.' !!}
                                        </p>
                                    </div>
                                    <a href="#" class="btn btn-light rounded-circle shadow-sm ms-3" data-bs-toggle="modal" data-bs-target="#editGioiThieuModal">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- Học vấn Section -->
                            <div class="card shadow-sm border-0 rounded-3 mb-3">
                                <div class="card-body d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="section-header-modern">
                                            <div class="section-icon-modern">
                                                <i class="bi bi-mortarboard"></i>
                                            </div>
                                            <h5 class="fw-bold mb-0">Học vấn</h5>
                                        </div>

                                        @if(isset($hocvan) && count($hocvan) > 0)
                                        @foreach($hocvan as $hv)
                                        <div class="timeline-item-modern">
                                            <div class="timeline-dot-modern"></div>
                                            <div class="timeline-content-modern">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <p class="mb-1">
                                                            <strong>{{ $hv->truong }}</strong><br>
                                                            {{ $hv->nganh }} - {{ $hv->trinhdo }}<br>
                                                            {{ date('m/Y', strtotime($hv->tu_ngay)) }} -
                                                            {{ $hv->dang_hoc ? 'Hiện tại' : date('m/Y', strtotime($hv->den_ngay)) }}
                                                            @if(!empty($hv->thongtin_khac))
                                                            <br><span class="text-muted fst-italic">{{ $hv->thongtin_khac }}</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="ms-3">
                                                        <!-- Nút Sửa -->
                                                        <button class="btn btn-sm btn-outline-primary editHocVanBtn me-1"
                                                            data-id="{{ $hv->id_hocvan }}"
                                                            title="Chỉnh sửa">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>

                                                        <!-- Nút Xóa -->
                                                        <form action="{{ route('hocvan.delete', $hv->id_hocvan) }}"
                                                            method="POST"
                                                            class="d-inline"
                                                            onsubmit="return confirm('Bạn có chắc muốn xóa học vấn này?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <p class="text-muted mb-0">Chưa có nội dung.</p>
                                        @endif
                                    </div>

                                    <!-- Nút thêm -->
                                    <a href="#" class="btn btn-light rounded-circle shadow-sm ms-3"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addHocVanModal">
                                        <i class="bi bi-plus-lg"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- Kinh nghiệm làm việc -->
                            <div class="card shadow-sm border-0 rounded-3 mb-3">
                                <div class="card-body d-flex justify-content-between align-items-start">
                                    <div class="w-100">
                                        <div class="section-header-modern">
                                            <div class="section-icon-modern">
                                                <i class="bi bi-briefcase"></i>
                                            </div>
                                            <h5 class="fw-bold mb-0">Kinh nghiệm làm việc</h5>
                                        </div>

                                        @if(isset($kinhnghiem) && count($kinhnghiem) > 0)
                                        @foreach($kinhnghiem as $kn)
                                        <div class="timeline-item-modern">
                                            <div class="timeline-dot-modern"></div>
                                            <div class="timeline-content-modern">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <!-- Chức danh + Công ty -->
                                                        <p class="mb-1">
                                                            <strong class="text-dark fs-6">{{ $kn->chucdanh }}</strong>
                                                            <span class="text-muted"> - {{ $kn->congty }}</span>
                                                        </p>

                                                        <!-- Thời gian -->
                                                        <p class="text-muted small mb-2">
                                                            <i class="bi bi-calendar me-1"></i>
                                                            {{ date('m/Y', strtotime($kn->tu_ngay)) }} -
                                                            {{ $kn->dang_lam_viec ? 'Hiện tại' : date('m/Y', strtotime($kn->den_ngay)) }}
                                                        </p>

                                                        <!-- Mô tả -->
                                                        @if(!empty($kn->mota))
                                                        <p class="mb-2">
                                                            <span class="fw-semibold">Mô tả:</span><br>
                                                            {!! nl2br(e($kn->mota)) !!}
                                                        </p>
                                                        @endif

                                                        <!-- Dự án -->
                                                        @if(!empty($kn->duan))
                                                        <p class="mb-0">
                                                            <span class="fw-semibold">Dự án đã tham gia:</span><br>
                                                            {!! nl2br(e($kn->duan)) !!}
                                                        </p>
                                                        @endif
                                                    </div>

                                                    <!-- Nút Sửa & Xóa -->
                                                    <div class="ms-3">
                                                        <!-- Nút Sửa -->
                                                        <button class="btn btn-sm btn-outline-primary editKinhNghiemBtn me-1"
                                                            data-id="{{ $kn->id_kn }}"
                                                            title="Chỉnh sửa">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>

                                                        <!-- Nút Xóa -->
                                                        <form action="{{ route('kinhnghiem.delete', $kn->id_kn) }}"
                                                            method="POST"
                                                            class="d-inline"
                                                            onsubmit="return confirm('Bạn có chắc muốn xóa kinh nghiệm này?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <p class="text-muted mb-0">Chưa có nội dung.</p>
                                        @endif
                                    </div>

                                    <!-- Nút mở modal thêm -->
                                    <a href="#" class="btn btn-light rounded-circle shadow-sm ms-3"
                                        data-bs-toggle="modal" data-bs-target="#addKinhNghiemModal">
                                        <i class="bi bi-plus-lg"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- Section mức lương mong muốn -->
                            <!-- ✅ SECTION MỨC LƯƠNG MONG MUỐN -->
                            <div class="card shadow-sm border-0 rounded-3 mb-3">
                                <div class="card-body d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="section-header-modern">
                                            <div class="section-icon-modern">
                                                <i class="bi bi-cash-coin"></i>
                                            </div>
                                            <h5 class="fw-bold mb-0">Mức lương mong muốn</h5>
                                        </div>

                                        @if($applicant->mucluong_mongmuon)
                                        <div class="mt-3">
                                            <div class="alert alert-info py-3 mb-0">
                                                <i class="bi bi-info-circle me-2"></i>
                                                <strong>{{ $applicant->mucluong_mongmuon }}</strong>
                                            </div>
                                        </div>
                                        @else
                                        <p class="text-muted mb-0 mt-3">Chưa cập nhật mức lương mong muốn.</p>
                                        @endif
                                    </div>

                                    <!-- Nút chỉnh sửa -->
                                    <a href="#" class="btn btn-light rounded-circle shadow-sm ms-3" data-bs-toggle="modal" data-bs-target="#editMucLuongModal">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- Section Kỹ năng -->
                            <!-- Section Kỹ năng -->
                            <div class="card shadow-sm border-0 rounded-3 mb-3">
                                <div class="card-body d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="section-header-modern">
                                            <div class="section-icon-modern">
                                                <i class="bi bi-lightbulb"></i>
                                            </div>
                                            <h5 class="fw-bold mb-0">Kỹ năng</h5>
                                        </div>
                                        @if(isset($kynang) && count($kynang) > 0)
                                        <div class="mt-3">
                                            @foreach($kynang as $kn)
                                            <div class="d-inline-flex align-items-center badge bg-primary text-white me-2 mb-2 p-2 fs-6">
                                                <div class="me-2">
                                                    <strong>{{ $kn->ten_ky_nang }}</strong>
                                                    <span class="opacity-75">
                                                        ({{ $kn->nam_kinh_nghiem == 0 ? '<1 năm' : $kn->nam_kinh_nghiem . ' năm' }})
                                                    </span>
                                                </div>
                                                <button type="button"
                                                    class="btn btn-sm btn-link text-white p-0 deleteKyNangBtn"
                                                    data-id="{{ $kn->id }}"
                                                    title="Xóa">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </div>
                                            @endforeach
                                        </div>
                                        @else
                                        <p class="text-muted mb-0">Chưa có kỹ năng nào.</p>
                                        @endif
                                    </div>

                                    <!-- Nút mở modal -->
                                    <a href="#" class="btn btn-light rounded-circle shadow-sm ms-3" data-bs-toggle="modal" data-bs-target="#addKyNangModal">
                                        <i class="bi bi-plus-lg"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- Section Ngoại Ngữ - PHIÊN BẢN SỬA LỖI HIỂN THỊ -->
                            <div class="card shadow-sm border-0 rounded-3 mb-3">
                                <div class="card-body d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="section-header-modern">
                                            <div class="section-icon-modern">
                                                <i class="bi bi-translate"></i>
                                            </div>
                                            <h5 class="fw-bold mb-0">Ngoại ngữ</h5>
                                        </div>

                                        @if(isset($ngoaiNgu) && $ngoaiNgu->count() > 0)
                                        <div class="mt-3">
                                            @foreach($ngoaiNgu as $nn)
                                            <div class="d-inline-flex align-items-center badge bg-primary text-white me-2 mb-2 p-2 fs-6">
                                                <div class="me-2">
                                                    <strong>{{ $nn->ten_ngoai_ngu }}</strong>
                                                    <span class="opacity-75"> - {{ $nn->trinh_do }}</span>
                                                </div>
                                                <button type="button"
                                                    class="btn btn-sm btn-link text-white p-0 deleteNgoaiNguBtn"
                                                    data-id="{{ $nn->ngoai_ngu_id }}"
                                                    title="Xóa">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </div>
                                            @endforeach
                                        </div>
                                        @else
                                        <p class="text-muted mb-0">Chưa có ngoại ngữ nào.</p>
                                        @endif
                                    </div>

                                    <!-- Nút mở modal -->
                                    <a href="#" class="btn btn-light rounded-circle shadow-sm ms-3"
                                        data-bs-toggle="modal" data-bs-target="#addNgoaiNguModal">
                                        <i class="bi bi-plus-lg"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- Section Dự Án Nổi Bật -->
                            <div class="card shadow-sm border-0 rounded-3 mb-3">
                                <div class="card-body d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="section-header-modern">
                                            <div class="section-icon-modern">
                                                <i class="bi bi-kanban"></i>
                                            </div>
                                            <h5 class="fw-bold mb-0">Dự án nổi bật</h5>
                                        </div>

                                        @if(isset($duAn) && count($duAn) > 0)
                                        @foreach($duAn as $da)
                                        <div class="timeline-item-modern">
                                            <div class="timeline-dot-modern"></div>
                                            <div class="timeline-content-modern">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <!-- Tên dự án -->
                                                        <p class="mb-1">
                                                            <strong class="text-dark fs-6">{{ $da->ten_duan }}</strong>
                                                        </p>

                                                        <!-- Thời gian -->
                                                        <p class="text-muted small mb-2">
                                                            <i class="bi bi-calendar me-1"></i>
                                                            {{ date('m/Y', strtotime($da->ngay_bat_dau)) }} -
                                                            {{ $da->dang_lam ? 'Hiện tại' : date('m/Y', strtotime($da->ngay_ket_thuc)) }}
                                                        </p>

                                                        <!-- Mô tả -->
                                                        @if(!empty($da->mota_duan))
                                                        <div class="mb-2">
                                                            {!! nl2br(e($da->mota_duan)) !!}
                                                        </div>
                                                        @endif

                                                        <!-- Link website -->
                                                        @if(!empty($da->duongdan_website))
                                                        <p class="mb-0">
                                                            <i class="bi bi-link-45deg text-primary"></i>
                                                            <a href="{{ $da->duongdan_website }}" target="_blank" class="text-decoration-none">
                                                                {{ $da->duongdan_website }}
                                                            </a>
                                                        </p>
                                                        @endif
                                                    </div>

                                                    <!-- Nút Sửa & Xóa -->
                                                    <div class="ms-3">
                                                        <!-- Nút Sửa -->
                                                        <button class="btn btn-sm btn-outline-primary editDuAnBtn me-1"
                                                            data-id="{{ $da->id_duan }}"
                                                            title="Chỉnh sửa">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>

                                                        <!-- Nút Xóa -->
                                                        <form action="{{ route('duan.delete', $da->id_duan) }}"
                                                            method="POST"
                                                            class="d-inline"
                                                            onsubmit="return confirm('Bạn có chắc muốn xóa dự án này?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <p class="text-muted mb-0">Chưa có nội dung.</p>
                                        @endif
                                    </div>

                                    <!-- Nút mở modal thêm -->
                                    <a href="#" class="btn btn-light rounded-circle shadow-sm ms-3"
                                        data-bs-toggle="modal" data-bs-target="#addDuAnModal">
                                        <i class="bi bi-plus-lg"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- SECTION HIỂN THỊ CHỨNG CHỈ -->
                            <div class="card shadow-sm border-0 rounded-3 mb-3">
                                <div class="card-body d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="section-header-modern">
                                            <div class="section-icon-modern">
                                                <i class="bi bi-award"></i>
                                            </div>
                                            <h5 class="fw-bold mb-0">Chứng chỉ</h5>
                                        </div>

                                        @if(isset($chungChi) && count($chungChi) > 0)
                                        @foreach($chungChi as $cc)
                                        <div class="timeline-item-modern">
                                            <div class="timeline-dot-modern"></div>
                                            <div class="timeline-content-modern">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <!-- Tên chứng chỉ -->
                                                        <p class="mb-1">
                                                            <strong class="text-dark fs-6">{{ $cc->ten_chungchi }}</strong>
                                                        </p>

                                                        <!-- Tổ chức cấp -->
                                                        <p class="text-muted small mb-2">
                                                            <i class="bi bi-building me-1"></i>
                                                            {{ $cc->to_chuc }}
                                                        </p>

                                                        <!-- Thời gian -->
                                                        <p class="text-muted small mb-2">
                                                            <i class="bi bi-calendar me-1"></i>
                                                            {{ date('m/Y', strtotime($cc->thoigian)) }}
                                                        </p>

                                                        <!-- Mô tả -->
                                                        @if(!empty($cc->mo_ta))
                                                        <div class="mb-2">
                                                            {!! nl2br(e($cc->mo_ta)) !!}
                                                        </div>
                                                        @endif

                                                        <!-- Link chứng chỉ -->
                                                        @if(!empty($cc->link_chungchi))
                                                        <p class="mb-0">
                                                            <i class="bi bi-link-45deg text-primary"></i>
                                                            <a href="{{ $cc->link_chungchi }}" target="_blank" class="text-decoration-none">
                                                                Xem chứng chỉ
                                                            </a>
                                                        </p>
                                                        @endif
                                                    </div>

                                                    <!-- Nút Sửa & Xóa -->
                                                    <div class="ms-3">
                                                        <button class="btn btn-sm btn-outline-primary editChungChiBtn me-1"
                                                            data-id="{{ $cc->id_chungchi }}"
                                                            title="Chỉnh sửa">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>

                                                        <form action="{{ route('chungchi.delete', $cc->id_chungchi) }}"
                                                            method="POST"
                                                            class="d-inline"
                                                            onsubmit="return confirm('Bạn có chắc muốn xóa chứng chỉ này?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <p class="text-muted mb-0">Chưa có nội dung.</p>
                                        @endif
                                    </div>

                                    <!-- Nút mở modal thêm -->
                                    <a href="#" class="btn btn-light rounded-circle shadow-sm ms-3"
                                        data-bs-toggle="modal" data-bs-target="#addChungChiModal">
                                        <i class="bi bi-plus-lg"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- SECTION HIỂN THỊ GIẢI THƯỞNG -->
                            <div class="card shadow-sm border-0 rounded-3 mb-3">
                                <div class="card-body d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="section-header-modern">
                                            <div class="section-icon-modern">
                                                <i class="bi bi-trophy"></i>
                                            </div>
                                            <h5 class="fw-bold mb-0">Giải thưởng</h5>
                                        </div>

                                        @if(isset($giaiThuong) && count($giaiThuong) > 0)
                                        @foreach($giaiThuong as $gt)
                                        <div class="timeline-item-modern">
                                            <div class="timeline-dot-modern"></div>
                                            <div class="timeline-content-modern">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <!-- Tên giải thưởng -->
                                                        <p class="mb-1">
                                                            <strong class="text-dark fs-6">
                                                                <i class="bi bi-trophy-fill text-warning me-1"></i>
                                                                {{ $gt->ten_giaithuong }}
                                                            </strong>
                                                        </p>

                                                        <!-- Tổ chức trao -->
                                                        <p class="text-muted small mb-2">
                                                            <i class="bi bi-building me-1"></i>
                                                            {{ $gt->to_chuc }}
                                                        </p>

                                                        <!-- Thời gian -->
                                                        <p class="text-muted small mb-2">
                                                            <i class="bi bi-calendar-event me-1"></i>
                                                            {{ date('m/Y', strtotime($gt->thoigian)) }}
                                                        </p>

                                                        <!-- Mô tả -->
                                                        @if(!empty($gt->mo_ta))
                                                        <div class="mb-0">
                                                            {!! nl2br(e($gt->mo_ta)) !!}
                                                        </div>
                                                        @endif
                                                    </div>

                                                    <!-- Nút Sửa & Xóa -->
                                                    <div class="ms-3">
                                                        <button class="btn btn-sm btn-outline-primary editGiaiThuongBtn me-1"
                                                            data-id="{{ $gt->id_giaithuong }}"
                                                            title="Chỉnh sửa">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>

                                                        <form action="{{ route('giaithuong.delete', $gt->id_giaithuong) }}"
                                                            method="POST"
                                                            class="d-inline"
                                                            onsubmit="return confirm('Bạn có chắc muốn xóa giải thưởng này?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <p class="text-muted mb-0">Chưa có nội dung.</p>
                                        @endif
                                    </div>

                                    <!-- Nút mở modal thêm -->
                                    <a href="#" class="btn btn-light rounded-circle shadow-sm ms-3"
                                        data-bs-toggle="modal" data-bs-target="#addGiaiThuongModal">
                                        <i class="bi bi-plus-lg"></i>
                                    </a>
                                </div>
                            </div>
                        </div> <!-- end tab-personal -->

                        <div class="tab-pane fade" id="tab-attachments" role="tabpanel" aria-labelledby="tab-attachments-pill">
                            <div class="card shadow-sm border-0 rounded-3 mb-3">
                                <div class="card-body">
                                    <div class="section-header-modern mb-3">
                                        <div class="section-icon-modern">
                                            <i class="bi bi-file-earmark-arrow-up"></i>
                                        </div>
                                        <div>
                                            <h5 class="fw-bold mb-1">Hồ sơ đính kèm</h5>
                                            <p class="text-muted mb-0">Tải CV/đính kèm hồ sơ để gửi cho nhà tuyển dụng. Hỗ trợ .pdf, .doc, .docx (tối đa 5MB).</p>
                                        </div>
                                    </div>

                                    <form action="{{ route('applicant.uploadCv') }}" method="POST" enctype="multipart/form-data" class="mb-3">
                                        @csrf
                                        <div class="input-group">
                                            <input type="file" name="hosodinhkem" class="form-control" accept=".pdf,.doc,.docx" required>
                                            <button class="btn btn-primary" type="submit">
                                                <i class="bi bi-cloud-upload"></i> Tải lên
                                            </button>
                                        </div>
                                        <small class="text-muted">Lưu ý: Nếu tải mới, CV cũ sẽ được thay thế.</small>
                                    </form>

                                    @if(!empty($applicant->hosodinhkem))
                                    <div class="d-flex align-items-center justify-content-between p-3 border rounded-3 bg-light">
                                        <div>
                                            <div class="fw-semibold text-dark">{{ basename($applicant->hosodinhkem) }}</div>
                                            <div class="text-muted small">Đã lưu vào hồ sơ</div>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('applicant.viewCv') }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-eye"></i> Xem
                                            </a>
                                            <a href="{{ route('applicant.viewCv') }}" class="btn btn-outline-secondary btn-sm">
                                                <i class="bi bi-download"></i> Tải xuống
                                            </a>
                                            <a href="{{ route('applicant.deleteCv') }}" class="btn btn-outline-danger btn-sm" onclick="return confirm('Xóa CV hiện tại?');">
                                                <i class="bi bi-trash"></i> Xóa
                                            </a>
                                        </div>
                                    </div>
                                    @else
                                    <div class="p-3 border rounded-3 bg-light d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-file-earmark text-primary fs-4"></i>
                                            <div>
                                                <div class="fw-semibold">Chưa có CV đính kèm</div>
                                                <div class="text-muted small">Hãy tải lên để tăng tỷ lệ ứng tuyển thành công.</div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div> <!-- end tab-content -->
                    <!-- MODAL -->
                    <!-- MODAL THÊM KỸ NĂNG -->
                    <div class="modal fade" id="addKyNangModal" tabindex="-1" aria-labelledby="addKyNangModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content rounded-3 shadow">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold" id="addKyNangModalLabel">
                                        <i class="bi bi-lightbulb me-2"></i>Thêm Kỹ Năng
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <form id="kyNangForm" action="{{ route('applicant.storeKyNang') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <p class="text-muted mb-3">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Thêm các kỹ năng bạn sở hữu và số năm kinh nghiệm
                                        </p>

                                        <!-- Danh sách kỹ năng đã chọn -->
                                        <div id="selectedSkills" class="mb-3"></div>

                                        <!-- Form nhập kỹ năng mới -->
                                        <div class="border rounded p-3 bg-light">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold">
                                                        Tên kỹ năng <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text"
                                                        id="skillInput"
                                                        class="form-control"
                                                        placeholder="VD: Java, PHP, React..."
                                                        list="skills-list">
                                                    <datalist id="skills-list">
                                                        <option value="Java">
                                                        <option value="PHP">
                                                        <option value="Python">
                                                        <option value="JavaScript">
                                                        <option value="React">
                                                        <option value="Node.js">
                                                        <option value="Laravel">
                                                        <option value="SQL">
                                                    </datalist>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold">
                                                        Năm kinh nghiệm <span class="text-danger">*</span>
                                                    </label>
                                                    <select id="experienceSelect" class="form-select">
                                                        <option value="">-- Chọn số năm --</option>
                                                        <option value="0">
                                                            < 1 năm</option>
                                                        <option value="1">1 năm</option>
                                                        <option value="2">2 năm</option>
                                                        <option value="3">3 năm</option>
                                                        <option value="4">4 năm</option>
                                                        <option value="5">5 năm</option>
                                                        <option value="6">6 năm</option>
                                                        <option value="7">7 năm</option>
                                                        <option value="8">8 năm</option>
                                                        <option value="9">9 năm</option>
                                                        <option value="10+">10+ năm</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <button type="button" class="btn btn-primary btn-sm" id="addSkillBtn">
                                                <i class="bi bi-plus-lg"></i> Thêm
                                            </button>
                                        </div>

                                        <!-- Hidden inputs -->
                                        <div id="hiddenSkillInputs"></div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-danger" id="submitKyNangBtn" disabled>
                                            <i class="bi bi-check-lg"></i> Lưu
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- MODAL THÊM/SỬA DỰ ÁN -->
                    <div class="modal fade" id="addDuAnModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content rounded-3">
                                <form id="duAnForm" method="POST" action="{{ route('duan.store') }}">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold" id="addDuAnModalLabel">
                                            <i class="bi bi-kanban me-2"></i>Dự án nổi bật
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <!-- Tên dự án -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Tên dự án <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control"
                                                name="ten_duan"
                                                id="ten_duan"
                                                placeholder="VD: Website Thương mại điện tử, Mobile App Banking..."
                                                required>
                                        </div>

                                        <!-- Thời gian -->
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label fw-bold">Tháng bắt đầu <span class="text-danger">*</span></label>
                                                <select class="form-select" name="thang_bat_dau" id="thang_bat_dau" required>
                                                    <option value="">Tháng</option>
                                                    @for($i = 1; $i <= 12; $i++)
                                                        <option value="{{ $i }}">Tháng {{ $i }}</option>
                                                        @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label fw-bold">Năm bắt đầu <span class="text-danger">*</span></label>
                                                <select class="form-select" name="nam_bat_dau" id="nam_bat_dau" required>
                                                    <option value="">Năm</option>
                                                    @for($year = date('Y'); $year >= 2000; $year--)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label fw-bold">Tháng kết thúc</label>
                                                <select class="form-select" name="thang_ket_thuc" id="thang_ket_thuc">
                                                    <option value="">Tháng</option>
                                                    @for($i = 1; $i <= 12; $i++)
                                                        <option value="{{ $i }}">Tháng {{ $i }}</option>
                                                        @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label fw-bold">Năm kết thúc</label>
                                                <select class="form-select" name="nam_ket_thuc" id="nam_ket_thuc">
                                                    <option value="">Năm</option>
                                                    @for($year = date('Y'); $year >= 2000; $year--)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Checkbox đang làm -->
                                        <div class="form-check mb-3">
                                            <input class="form-check-input"
                                                type="checkbox"
                                                id="dang_lam"
                                                name="dang_lam"
                                                value="1">
                                            <label class="form-check-label" for="dang_lam">
                                                Dự án đang thực hiện
                                            </label>
                                        </div>

                                        <!-- Mô tả dự án -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Mô tả dự án</label>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div class="alert alert-info py-2 mb-0 flex-grow-1 me-2">
                                                    <i class="bi bi-lightbulb text-warning me-1"></i>
                                                    <strong>Tips:</strong> Mô tả vai trò, công nghệ, kết quả đạt được
                                                </div>
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-primary"
                                                    id="insertTemplateBtn">
                                                    <i class="bi bi-file-earmark-text"></i> Chèn mẫu
                                                </button>
                                            </div>
                                            <textarea class="form-control textarea-large"
                                                name="mota_duan"
                                                id="mota_duan"
                                                rows="12"
                                                maxlength="1200"
                                                placeholder="VD:
- Mô tả: Website bán hàng trực tuyến với 50k+ sản phẩm
- Vai trò: Full-stack Developer
- Trách nhiệm:
  ◦ Xây dựng API backend với Laravel
  ◦ Phát triển giao diện với Vue.js
- Công nghệ: PHP, Laravel, Vue.js, MySQL, Redis
- Nhóm: 6 thành viên"></textarea>
                                            <small class="text-muted">
                                                <span id="mota_count">0</span>/1200 ký tự
                                            </small>
                                        </div>

                                        <!-- Link website -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Link website/demo</label>
                                            <input type="url"
                                                class="form-control"
                                                name="duongdan_website"
                                                id="duongdan_website"
                                                placeholder="https://example.com">
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-danger" id="submitDuAnBtn">
                                            <i class="bi bi-check-lg"></i> Lưu
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- MODAL THÊM/SỬA KINH NGHIỆM -->
                    <div class="modal fade" id="addKinhNghiemModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content rounded-3">
                                <form id="kinhNghiemForm" method="POST" action="{{ route('kinhnghiem.store') }}">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold" id="kinhNghiemModalLabel">
                                            <i class="bi bi-briefcase me-2"></i>Kinh nghiệm làm việc
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <!-- Chức danh -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Chức danh <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control"
                                                name="chucdanh"
                                                id="kn_chucdanh"
                                                placeholder="VD: Senior Developer, Team Leader..."
                                                required>
                                        </div>

                                        <!-- Công ty -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Công ty <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control"
                                                name="congty"
                                                id="kn_congty"
                                                placeholder="VD: FPT Software, VNG Corporation..."
                                                required>
                                        </div>

                                        <!-- Thời gian -->
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">
                                                    Từ ngày <span class="text-danger">*</span>
                                                </label>
                                                <input type="month"
                                                    class="form-control"
                                                    name="tu_ngay"
                                                    id="kn_tuNgay"
                                                    required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Đến ngày</label>
                                                <input type="month"
                                                    class="form-control"
                                                    name="den_ngay"
                                                    id="kn_denNgay">
                                            </div>
                                        </div>

                                        <!-- Checkbox đang làm việc -->
                                        <div class="form-check mb-3">
                                            <input class="form-check-input"
                                                type="checkbox"
                                                id="kn_dangLamViec"
                                                name="dang_lam_viec"
                                                value="1">
                                            <label class="form-check-label" for="kn_dangLamViec">
                                                Tôi đang làm việc tại đây
                                            </label>
                                        </div>

                                        <!-- Mô tả công việc -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Mô tả công việc</label>
                                            <div class="alert alert-info py-2 mb-2">
                                                <i class="bi bi-lightbulb text-warning me-1"></i>
                                                <strong>Tips:</strong> Mô tả trách nhiệm, thành tích, công nghệ sử dụng
                                            </div>
                                            <textarea class="form-control"
                                                name="mota"
                                                id="kn_mota"
                                                rows="8"
                                                maxlength="1000"
                                                placeholder="VD:
- Phát triển và maintain hệ thống backend
- Quản lý team 5 developers
- Tối ưu database, giảm 40% thời gian query
- Công nghệ: PHP, Laravel, MySQL, Redis"></textarea>
                                            <small class="text-muted">
                                                <span id="mota_count">0</span>/1000 ký tự
                                            </small>
                                        </div>

                                        <!-- Dự án tham gia -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Dự án đã tham gia</label>
                                            <textarea class="form-control"
                                                name="duan"
                                                id="kn_duan"
                                                rows="6"
                                                maxlength="800"
                                                placeholder="VD:
- Dự án A: Hệ thống E-commerce (Laravel + Vue.js)
- Dự án B: Mobile App Backend (Node.js + MongoDB)"></textarea>
                                            <small class="text-muted">
                                                <span id="duan_count">0</span>/800 ký tự
                                            </small>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-danger" id="kinhNghiemSubmitBtn">
                                            <i class="bi bi-check-lg"></i> Lưu
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- MODAL THÊM/SỬA GIẢI THƯỞNG -->
                    <div class="modal fade" id="addGiaiThuongModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content rounded-3">
                                <form id="giaiThuongForm" method="POST" action="{{ route('giaithuong.store') }}">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold" id="giaiThuongModalLabel">
                                            <i class="bi bi-trophy me-2"></i>Giải thưởng
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <!-- Tên giải thưởng -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Tên giải thưởng <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control"
                                                name="ten_giaithuong"
                                                id="gt_ten"
                                                placeholder="VD: Nhân viên xuất sắc năm 2023, Top 10 Developer..."
                                                required>
                                        </div>

                                        <!-- Tổ chức trao -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Tổ chức trao <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control"
                                                name="to_chuc"
                                                id="gt_to_chuc"
                                                placeholder="VD: FPT Software, Microsoft, VietnamWorks..."
                                                required>
                                        </div>

                                        <!-- Thời gian -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Thời gian <span class="text-danger">*</span>
                                            </label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <select class="form-select" name="thang" id="gt_thang" required>
                                                        <option value="">Tháng</option>
                                                        @for($i = 1; $i <= 12; $i++)
                                                            <option value="{{ $i }}">Tháng {{ $i }}</option>
                                                            @endfor
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <select class="form-select" name="nam" id="gt_nam" required>
                                                        <option value="">Năm</option>
                                                        @for($year = date('Y'); $year >= 1990; $year--)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Mô tả chi tiết - KHUNG LỚN -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Mô tả chi tiết</label>
                                            <div class="alert alert-info py-2 mb-2">
                                                <i class="bi bi-lightbulb text-warning me-1"></i>
                                                <strong>Tips:</strong> Mô tả lý do nhận giải, thành tích đạt được, phạm vi giải thưởng
                                            </div>
                                            <textarea class="form-control"
                                                name="mo_ta"
                                                id="gt_mota"
                                                rows="15"
                                                maxlength="1000"

                                                placeholder="VD:
- Đạt doanh số cao nhất quý 4/2023
- Hoàn thành vượt 150% KPI
- Được trao tặng trước 500+ nhân viên
- Thành tích nổi bật:
  ◦ Ký được 20+ hợp đồng lớn
  ◦ Doanh thu: 5 tỷ VNĐ"></textarea>
                                            <small class="text-muted">
                                                <span id="gt_mota_count">0</span>/1000 ký tự
                                            </small>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-danger" id="submitGiaiThuongBtn">
                                            <i class="bi bi-check-lg"></i> Lưu
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Xem CV -->
                    <!-- ✅ MODAL XEM CV - THIẾT KẾ CHUYÊN NGHIỆP -->
                    <!-- Modal: CV - SYNC WITH CANDIDATES.BLADE.PHP STYLE -->
                    <div class="modal fade" id="viewCVModal" tabindex="-1" aria-labelledby="viewCVLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content cv-modal-content" style="border-radius: 24px; border: none; box-shadow: 0 25px 100px rgba(0, 0, 0, 0.3);">

                                <!-- ✅ HEADER CV -->
                                <div class="modal-header cv-modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 28px; display: flex; align-items: center; justify-content: space-between; color: white; border-radius: 24px 24px 0 0;">
                                    <div class="d-flex align-items: center gap-3 flex-grow-1">
                                        <img src="{{ $applicant->avatar ? asset('assets/img/avt/'.$applicant->avatar) : asset('assets/img/avt/default-avatar.png') }}"
                                            alt="Avatar"
                                            style="width: 100px; height: 100px; border-radius: 50%; border: 4px solid white; object-fit: cover;">
                                        <div class="text-white">
                                            <h5 class="modal-title fw-bold mb-1" id="viewCVLabel" style="font-size: 24px;">
                                                {{ $applicant->hoten_uv ?? 'Họ tên ứng viên' }}
                                            </h5>
                                            <p class="mb-0 opacity-90" style="font-size: 16px;">
                                                <i class="bi bi-briefcase-fill me-1"></i>{{ $applicant->vitriungtuyen ?? 'Chức danh' }}
                                            </p>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" style="width: 40px; height: 40px;"></button>
                                </div>

                                <!-- ✅ BODY CV - TWO COLUMN LAYOUT -->
                                <div class="modal-body cv-modal-body p-0" style="max-height: 80vh; overflow-y: auto; background: #f8fafc;">
                                    <div style="display: grid; grid-template-columns: 300px 1fr; gap: 0; padding: 28px;">

                                        <!-- ===== CỘT TRÁI: SIDEBAR ===== -->
                                        <div class="cv-sidebar" style="padding-right: 24px; border-right: 1px solid #e5e7eb;">

                                            <!-- Avatar -->
                                            <div style="text-align: center; margin-bottom: 24px;">
                                                <img src="{{ $applicant->avatar ? asset('assets/img/avt/'.$applicant->avatar) : asset('assets/img/avt/default-avatar.png') }}"
                                                    alt="Avatar"
                                                    style="width: 140px; height: 140px; border-radius: 50%; border: 5px solid #667eea; object-fit: cover; box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3); display: inline-block;">
                                                <h5 class="fw-bold mt-3 mb-1">{{ $applicant->hoten_uv ?? 'N/A' }}</h5>
                                                <p class="text-muted small mb-0">{{ $applicant->vitriungtuyen ?? 'N/A' }}</p>
                                            </div>

                                            <hr class="my-3">

                                            <!-- ===== THÔNG TIN LIÊN HỆ ===== -->
                                            <h6 class="cv-section-title" style="font-size: 13px; font-weight: 700; color: #1f2937; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #667eea; padding-bottom: 8px;">
                                                <i class="bi bi-info-circle" style="color: #667eea;"></i> Thông tin
                                            </h6>

                                            @if(Auth::user()->email)
                                            <div class="cv-info-item" style="padding: 10px 0; border-bottom: 1px solid #e5e7eb; display: flex; align-items: flex-start; gap: 8px;">
                                                <i class="bi bi-envelope" style="color: #667eea; margin-top: 2px;"></i>
                                                <div style="font-size: 12px;">
                                                    <small class="cv-info-label" style="color: #6b7280; font-size: 11px; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 2px;">Email</small>
                                                    <small class="cv-info-value" style="color: #1f2937; font-weight: 500; word-break: break-all;">{{ Auth::user()->email }}</small>
                                                </div>
                                            </div>
                                            @endif

                                            @if($applicant->sdt_uv)
                                            <div class="cv-info-item" style="padding: 10px 0; border-bottom: 1px solid #e5e7eb; display: flex; align-items: flex-start; gap: 8px;">
                                                <i class="bi bi-telephone" style="color: #667eea; margin-top: 2px;"></i>
                                                <div style="font-size: 12px;">
                                                    <small class="cv-info-label" style="color: #6b7280; font-size: 11px; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 2px;">Điện thoại</small>
                                                    <small class="cv-info-value" style="color: #1f2937; font-weight: 500;">{{ $applicant->sdt_uv }}</small>
                                                </div>
                                            </div>
                                            @endif

                                            @if($applicant->diachi_uv)
                                            <div class="cv-info-item" style="padding: 10px 0; border-bottom: 1px solid #e5e7eb; display: flex; align-items: flex-start; gap: 8px;">
                                                <i class="bi bi-geo-alt" style="color: #667eea; margin-top: 2px;"></i>
                                                <div style="font-size: 12px;">
                                                    <small class="cv-info-label" style="color: #6b7280; font-size: 11px; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 2px;">Địa chỉ</small>
                                                    <small class="cv-info-value" style="color: #1f2937; font-weight: 500;">{{ $applicant->diachi_uv }}</small>
                                                </div>
                                            </div>
                                            @endif

                                            @if($applicant->ngaysinh)
                                            <div class="cv-info-item" style="padding: 10px 0; border-bottom: 1px solid #e5e7eb; display: flex; align-items: flex-start; gap: 8px;">
                                                <i class="bi bi-calendar" style="color: #667eea; margin-top: 2px;"></i>
                                                <div style="font-size: 12px;">
                                                    <small class="cv-info-label" style="color: #6b7280; font-size: 11px; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 2px;">Ngày sinh</small>
                                                    <small class="cv-info-value" style="color: #1f2937; font-weight: 500;">{{ date('d/m/Y', strtotime($applicant->ngaysinh)) }}</small>
                                                </div>
                                            </div>
                                            @endif

                                            <!-- ✅ MỨC LƯƠNG MONG MUỐN -->
                                            @if($applicant->mucluong_mongmuon)
                                            <hr class="my-3">
                                            <h6 class="cv-section-title" style="font-size: 13px; font-weight: 700; color: #1f2937; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #10b981; padding-bottom: 8px;">
                                                <i class="bi bi-cash-coin" style="color: #10b981;"></i> Mức lương
                                            </h6>
                                            <div class="cv-info-item" style="padding: 10px 0; border-bottom: 1px solid #e5e7eb; display: flex; align-items: flex-start; gap: 8px;">
                                                <i class="bi bi-cash-coin" style="color: #10b981; margin-top: 2px;"></i>
                                                <div style="font-size: 12px;">
                                                    <small class="cv-info-label" style="color: #6b7280; font-size: 11px; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 2px;">Mong muốn</small>
                                                    <small class="cv-info-value" style="color: #059669; font-weight: 700;">{{ $applicant->mucluong_mongmuon }}</small>
                                                </div>
                                            </div>
                                            @endif

                                            <!-- ===== NGOẠI NGỮ ===== -->
                                            @if(isset($ngoaiNgu) && $ngoaiNgu->count() > 0)
                                            <hr class="my-3">
                                            <h6 class="cv-section-title" style="font-size: 13px; font-weight: 700; color: #1f2937; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #f59e0b; padding-bottom: 8px;">
                                                <i class="bi bi-translate" style="color: #f59e0b;"></i> Ngoại ngữ
                                            </h6>
                                            @foreach($ngoaiNgu as $nn)
                                            <div class="cv-info-item" style="padding: 10px 0; border-bottom: 1px solid #e5e7eb; display: flex; align-items: flex-start; gap: 8px;">
                                                <i class="bi bi-translate" style="color: #f59e0b; margin-top: 2px;"></i>
                                                <div style="font-size: 12px;">
                                                    <small class="cv-info-label" style="color: #6b7280; font-size: 11px; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 2px;">{{ $nn->ten_ngoai_ngu }}</small>
                                                    <small class="cv-info-value" style="color: #1f2937; font-weight: 500;">{{ $nn->trinh_do }}</small>
                                                </div>
                                            </div>
                                            @endforeach
                                            @endif

                                            <!-- ===== KỸ NĂNG NỔI BẬT ===== -->
                                            @if(isset($kynang) && $kynang->count() > 0)
                                            <hr class="my-3">
                                            <h6 class="cv-section-title" style="font-size: 13px; font-weight: 700; color: #1f2937; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #667eea; padding-bottom: 8px;">
                                                <i class="bi bi-star" style="color: #667eea;"></i> Kỹ năng
                                            </h6>
                                            @foreach($kynang->take(6) as $kn)
                                            <div style="padding: 8px 12px; background: linear-gradient(135deg, #e0e7ff 0%, #f3e8ff 100%); border-radius: 8px; border-left: 3px solid #667eea; margin-bottom: 8px; font-size: 12px;">
                                                <p style="margin: 0; color: #4f46e5; font-weight: 600;">{{ $kn->ten_ky_nang }}</p>
                                                @if($kn->nam_kinh_nghiem)
                                                <small style="color: #9333ea; display: block; margin-top: 2px;">⚡ {{ $kn->nam_kinh_nghiem }} năm</small>
                                                @endif
                                            </div>
                                            @endforeach
                                            @endif

                                        </div>

                                        <!-- ===== CỘT PHẢI: NỘI DUNG CV ===== -->
                                        <div class="col-md-9 p-0" style="padding-left: 24px !important;">

                                            <!-- ===== GIỚI THIỆU BẢN THÂN ===== -->
                                            @if($applicant->gioithieu)
                                            <div style="margin-bottom: 28px; padding-bottom: 24px; border-bottom: 1px solid #e5e7eb;">
                                                <h5 style="font-size: 15px; font-weight: 700; color: #1f2937; margin: 0 0 12px 0; display: flex; align-items: center; gap: 8px; border-bottom: 3px solid #667eea; padding-bottom: 8px;">
                                                    <i class="bi bi-person" style="color: #667eea;"></i>
                                                    Giới thiệu bản thân
                                                </h5>
                                                <p style="color: #374151; line-height: 1.8; margin: 0; white-space: pre-line; font-size: 14px;">
                                                    {!! nl2br(e($applicant->gioithieu)) !!}
                                                </p>
                                            </div>
                                            @endif

                                            <!-- ===== KINH NGHIỆM LÀM VIỆC ===== -->
                                            @if(isset($kinhnghiem) && $kinhnghiem->count() > 0)
                                            <div style="margin-bottom: 28px; padding-bottom: 24px; border-bottom: 1px solid #e5e7eb;">
                                                <h5 style="font-size: 15px; font-weight: 700; color: #1f2937; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px; border-bottom: 3px solid #667eea; padding-bottom: 8px;">
                                                    <i class="bi bi-briefcase" style="color: #667eea;"></i>
                                                    Kinh nghiệm làm việc
                                                </h5>
                                                @foreach($kinhnghiem as $item)
                                                <div style="padding-left: 20px; border-left: 3px solid #667eea; position: relative; padding-bottom: 18px; margin-bottom: 18px;">
                                                    <div style="position: absolute; left: -8px; top: 4px; width: 12px; height: 12px; background: #667eea; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 0 2px #667eea;"></div>

                                                    <h6 style="font-size: 15px; font-weight: 700; color: #1f2937; margin: 0 0 6px 0;">{{ $item->chucdanh ?? 'N/A' }}</h6>
                                                    <p style="font-size: 14px; color: #667eea; font-weight: 600; margin: 0 0 8px 0;">{{ $item->congty ?? 'N/A' }}</p>
                                                    <p style="font-size: 12px; color: #6b7280; margin: 0 0 12px 0;">
                                                        <i class="bi bi-calendar"></i>
                                                        {{ \Carbon\Carbon::parse($item->tu_ngay)->format('m/Y') }} -
                                                        {{ $item->dang_lam_viec ? '<span class="badge bg-success text-white">Hiện tại</span>' : \Carbon\Carbon::parse($item->den_ngay)->format('m/Y') }}
                                                    </p>
                                                    @if($item->mota)
                                                    <div style="font-size: 13px; color: #374151; line-height: 1.6; margin: 0 0 8px 0; white-space: pre-line;">
                                                        <strong>Mô tả:</strong> {!! nl2br(e($item->mota)) !!}
                                                    </div>
                                                    @endif
                                                    @if($item->duan)
                                                    <div style="font-size: 13px; color: #374151; line-height: 1.6;">
                                                        <strong>Dự án tham gia:</strong> {!! nl2br(e($item->duan)) !!}
                                                    </div>
                                                    @endif
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif

                                            <!-- ===== HỌC VẤN ===== -->
                                            @if(isset($hocvan) && $hocvan->count() > 0)
                                            <div style="margin-bottom: 28px; padding-bottom: 24px; border-bottom: 1px solid #e5e7eb;">
                                                <h5 style="font-size: 15px; font-weight: 700; color: #1f2937; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px; border-bottom: 3px solid #10b981; padding-bottom: 8px;">
                                                    <i class="bi bi-mortarboard" style="color: #10b981;"></i>
                                                    Học vấn
                                                </h5>
                                                @foreach($hocvan as $item)
                                                <div style="padding-left: 20px; border-left: 3px solid #10b981; position: relative; padding-bottom: 16px; margin-bottom: 16px;">
                                                    <div style="position: absolute; left: -8px; top: 4px; width: 12px; height: 12px; background: #10b981; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 0 2px #10b981;"></div>

                                                    <h6 style="font-size: 15px; font-weight: 700; color: #1f2937; margin: 0 0 6px 0;">{{ $item->truong ?? 'N/A' }}</h6>
                                                    <p style="font-size: 14px; color: #6b7280; margin: 0 0 6px 0;">{{ $item->nganh ?? 'N/A' }} - <span style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); color: #1e40af; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: 600; display: inline-block;">{{ $item->trinhdo ?? 'N/A' }}</span></p>
                                                    <p style="font-size: 12px; color: #9ca3af; margin: 0;">
                                                        {{ \Carbon\Carbon::parse($item->tu_ngay)->format('Y') }} -
                                                        {{ $item->dang_hoc ? '<span class="badge bg-success text-white">Hiện tại</span>' : \Carbon\Carbon::parse($item->den_ngay)->format('Y') }}
                                                    </p>
                                                    @if($item->thongtin_khac)
                                                    <p style="font-size: 12px; color: #374151; margin-top: 8px; margin-bottom: 0; font-style: italic;">{{ $item->thongtin_khac }}</p>
                                                    @endif
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif

                                            <!-- ===== DỰ ÁN NỔI BẬT ===== -->
                                            @if(isset($duAn) && $duAn->count() > 0)
                                            <div style="margin-bottom: 28px; padding-bottom: 24px; border-bottom: 1px solid #e5e7eb;">
                                                <h5 style="font-size: 15px; font-weight: 700; color: #1f2937; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px; border-bottom: 3px solid #06b6d4; padding-bottom: 8px;">
                                                    <i class="bi bi-kanban" style="color: #06b6d4;"></i>
                                                    Dự án nổi bật
                                                </h5>
                                                @foreach($duAn as $da)
                                                <div style="padding-left: 20px; border-left: 3px solid #06b6d4; position: relative; padding-bottom: 18px; margin-bottom: 18px;">
                                                    <div style="position: absolute; left: -8px; top: 4px; width: 12px; height: 12px; background: #06b6d4; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 0 2px #06b6d4;"></div>

                                                    <h6 style="font-size: 15px; font-weight: 700; color: #1f2937; margin: 0 0 8px 0;">{{ $da->ten_duan ?? 'N/A' }}</h6>
                                                    <p style="font-size: 12px; color: #9ca3af; margin: 0 0 10px 0;">
                                                        <i class="bi bi-calendar"></i>
                                                        {{ date('m/Y', strtotime($da->ngay_bat_dau)) }} -
                                                        {{ $da->dang_lam ? '<span class="badge bg-success text-white">Hiện tại</span>' : date('m/Y', strtotime($da->ngay_ket_thuc)) }}
                                                    </p>
                                                    @if($da->mota_duan)
                                                    <p style="font-size: 13px; color: #374151; line-height: 1.6; margin: 0 0 8px 0; white-space: pre-line;">
                                                        {!! nl2br(e($da->mota_duan)) !!}
                                                    </p>
                                                    @endif
                                                    @if($da->duongdan_website)
                                                    <p style="margin: 0;">
                                                        <i class="bi bi-link-45deg" style="color: #06b6d4;"></i>
                                                        <a href="{{ $da->duongdan_website }}" target="_blank" style="color: #06b6d4; text-decoration: none; font-size: 12px;">Xem dự án →</a>
                                                    </p>
                                                    @endif
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif

                                            <!-- ===== CHỨNG CHỈ ===== -->
                                            @if(isset($chungChi) && $chungChi->count() > 0)
                                            <div style="margin-bottom: 28px; padding-bottom: 24px; border-bottom: 1px solid #e5e7eb;">
                                                <h5 style="font-size: 15px; font-weight: 700; color: #1f2937; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px; border-bottom: 3px solid #10b981; padding-bottom: 8px;">
                                                    <i class="bi bi-award" style="color: #10b981;"></i>
                                                    Chứng chỉ
                                                </h5>
                                                @foreach($chungChi as $cc)
                                                <div style="padding-left: 20px; border-left: 3px solid #10b981; position: relative; padding-bottom: 16px; margin-bottom: 16px;">
                                                    <div style="position: absolute; left: -8px; top: 4px; width: 12px; height: 12px; background: #10b981; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 0 2px #10b981;"></div>

                                                    <h6 style="font-size: 15px; font-weight: 700; color: #1f2937; margin: 0 0 6px 0;">{{ $cc->ten_chungchi ?? 'N/A' }}</h6>
                                                    <p style="font-size: 13px; color: #6b7280; margin: 0 0 4px 0;"><i class="bi bi-building"></i> {{ $cc->to_chuc ?? 'N/A' }}</p>
                                                    <p style="font-size: 12px; color: #9ca3af; margin: 0 0 6px 0;"><i class="bi bi-calendar"></i> {{ date('m/Y', strtotime($cc->thoigian)) }}</p>
                                                    @if($cc->mo_ta)
                                                    <p style="font-size: 13px; color: #374151; margin: 0 0 6px 0;">{{ $cc->mo_ta }}</p>
                                                    @endif
                                                    @if($cc->link_chungchi)
                                                    <p style="margin: 0;">
                                                        <i class="bi bi-link-45deg" style="color: #10b981;"></i>
                                                        <a href="{{ $cc->link_chungchi }}" target="_blank" style="color: #10b981; text-decoration: none; font-size: 12px;">Xem chứng chỉ →</a>
                                                    </p>
                                                    @endif
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif

                                            <!-- ===== GIẢI THƯỞNG ===== -->
                                            @if(isset($giaiThuong) && $giaiThuong->count() > 0)
                                            <div>
                                                <h5 style="font-size: 15px; font-weight: 700; color: #1f2937; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px; border-bottom: 3px solid #f59e0b; padding-bottom: 8px;">
                                                    <i class="bi bi-trophy" style="color: #f59e0b;"></i>
                                                    Giải thưởng
                                                </h5>
                                                @foreach($giaiThuong as $gt)
                                                <div style="padding-left: 20px; border-left: 3px solid #f59e0b; position: relative; padding-bottom: 16px; margin-bottom: 16px;">
                                                    <div style="position: absolute; left: -8px; top: 4px; width: 12px; height: 12px; background: #f59e0b; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 0 2px #f59e0b;"></div>

                                                    <h6 style="font-size: 15px; font-weight: 700; color: #1f2937; margin: 0 0 6px 0;">
                                                        <i class="bi bi-trophy-fill" style="color: #f59e0b;"></i> {{ $gt->ten_giaithuong ?? 'N/A' }}
                                                    </h6>
                                                    <p style="font-size: 13px; color: #6b7280; margin: 0 0 4px 0;"><i class="bi bi-building"></i> {{ $gt->to_chuc ?? 'N/A' }}</p>
                                                    <p style="font-size: 12px; color: #9ca3af; margin: 0 0 6px 0;"><i class="bi bi-calendar-event"></i> {{ date('m/Y', strtotime($gt->thoigian ?? now())) }}</p>
                                                    @if($gt->mo_ta)
                                                    <p style="font-size: 13px; color: #374151; margin: 0;">{{ $gt->mo_ta }}</p>
                                                    @endif
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <!-- ✅ FOOTER CV -->
                                <div class="modal-footer cv-modal-footer" style="background: white; border-top: 1px solid #e5e7eb; border-radius: 0 0 24px 24px; padding: 20px 28px; display: flex; gap: 12px; justify-content: flex-end;">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 10px; font-weight: 600; padding: 10px 20px; border: 1px solid #e5e7eb; cursor: pointer; transition: all 0.3s;">
                                        <i class="bi bi-x"></i> Đóng
                                    </button>
                                    <button type="button" class="btn btn-light" onclick="window.print()" style="border-radius: 10px; font-weight: 600; padding: 10px 20px; border: 1px solid #e5e7eb; cursor: pointer; transition: all 0.3s;">
                                        <i class="bi bi-printer"></i> In CV
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>


                    <!-- Modal chỉnh sửa hồ sơ -->
                    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="{{ route('applicant.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editProfileModalLabel">Chỉnh sửa hồ sơ cá nhân</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">
                                            <!-- Cột Avatar -->
                                            <div class="col-md-4 text-center mb-3">
                                                <div class="position-relative d-inline-block">
                                                    <!-- Hiển thị avatar -->
                                                    <img id="avatarPreview"
                                                        src="{{ $applicant->avatar 
                                        ? asset('assets/img/avt/'.$applicant->avatar) 
                                        : asset('assets/img/avt/default-avatar.png') }}"
                                                        class="rounded-circle border"
                                                        alt="Avatar"
                                                        width="150" height="150"
                                                        style="object-fit: cover;">

                                                    <!-- Input upload ẩn -->
                                                    <input type="file" name="avatar" id="avatar" class="d-none" accept="image/*">

                                                    <!-- Nút sửa -->
                                                    <label for="avatar" class="btn btn-sm btn-danger position-absolute bottom-0 start-0" title="Thay đổi ảnh">
                                                        <i class="bi bi-pencil"></i> Sửa
                                                    </label>

                                                    <!-- Nút xóa -->
                                                    @if($applicant->avatar)
                                                    <button type="button" class="btn btn-sm btn-secondary position-absolute bottom-0 end-0" id="deleteAvatarBtn" title="Xóa ảnh">
                                                        <i class="bi bi-trash"></i> Xóa
                                                    </button>
                                                    @endif
                                                </div>
                                                <p class="text-muted small mt-2">Tối đa 5MB, định dạng: JPG, PNG</p>
                                            </div>

                                            <!-- Cột thông tin -->
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <!-- Họ tên -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="hoten_uv" class="form-label">Họ và tên</label>
                                                        <input type="text" class="form-control" name="hoten_uv" id="hoten_uv"
                                                            value="{{ $applicant->hoten_uv ?? '' }}" required>
                                                    </div>
                                                    <!-- Chức danh -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="vitriungtuyen" class="form-label">Vị trí ứng tuyển</label>
                                                        <input type="text" class="form-control" name="vitriungtuyen" id="vitriungtuyen"
                                                            value="{{ $applicant->vitriungtuyen ?? '' }}">
                                                    </div>
                                                    <!-- Ngày sinh -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="ngaysinh" class="form-label">Ngày sinh</label>
                                                        <input type="date" class="form-control" name="ngaysinh" id="ngaysinh"
                                                            value="{{ $applicant->ngaysinh ?? '' }}">
                                                    </div>
                                                    <!-- Số điện thoại -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="sdt_uv" class="form-label">Số điện thoại</label>
                                                        <input type="text" class="form-control" name="sdt_uv" id="sdt_uv"
                                                            value="{{ $applicant->sdt_uv ?? '' }}">
                                                    </div>
                                                    <!-- Giới tính -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="gioitinh_uv" class="form-label">Giới tính</label>
                                                        <select class="form-select" name="gioitinh_uv" id="gioitinh_uv">
                                                            <option value="">-- Chọn --</option>
                                                            <option value="Nam" {{ ($applicant->gioitinh_uv ?? '') == 'Nam' ? 'selected' : '' }}>Nam</option>
                                                            <option value="Nữ" {{ ($applicant->gioitinh_uv ?? '') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                                                            <option value="Khác" {{ ($applicant->gioitinh_uv ?? '') == 'Khác' ? 'selected' : '' }}>Khác</option>
                                                        </select>
                                                    </div>

                                                    <!-- Địa chỉ -->
                                                    <div class="col-12 mb-3">
                                                        <label for="diachi_uv" class="form-label">Địa chỉ</label>
                                                        <input type="text" class="form-control" name="diachi_uv" id="diachi_uv"
                                                            value="{{ $applicant->diachi_uv ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Giới thiệu bản thân -->
                    <div class="modal fade" id="editGioiThieuModal" tabindex="-1" aria-labelledby="editGioiThieuModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold" id="editGioiThieuModalLabel">
                                        Giới thiệu bản thân
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-muted">
                                        <strong>Tip:</strong> Tóm tắt kinh nghiệm chuyên môn, chú ý làm nổi bật các kỹ năng và điểm mạnh.
                                    </p>

                                    <form action="{{ route('applicant.updateGioiThieu') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="gioithieu-editor" class="form-label"></label>
                                            <textarea id="gioithieu-editor" name="gioithieu" rows="10">
                                            {{ old('gioithieu', $applicant->gioithieu) }}
                                            </textarea>
                                        </div>

                                        <div class="text-end">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Thêm/Sửa Học Vấn -->
                    <div class="modal fade" id="addHocVanModal" tabindex="-1" aria-labelledby="addHocVanModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form id="hocVanForm" method="POST" action="{{ route('hocvan.store') }}">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold" id="addHocVanModalLabel">Thêm Học Vấn</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Trường <span class="text-danger">*</span></label>
                                            <input type="text" name="truong" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Trình độ <span class="text-danger">*</span></label>
                                            <select name="trinhdo" class="form-select" required>
                                                <option value="">-- Chọn trình độ --</option>
                                                <option value="Trung cấp">Trung cấp</option>
                                                <option value="Cao đẳng">Cao đẳng</option>
                                                <option value="Đại học">Đại học</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Ngành học <span class="text-danger">*</span></label>
                                            <input type="text" name="nganh" class="form-control" required>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="dang_hoc" name="dang_hoc" value="1">
                                            <label class="form-check-label" for="dang_hoc">Tôi đang theo học tại đây</label>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Từ <span class="text-danger">*</span></label>
                                                <input type="date" name="tu_ngay" class="form-control" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Đến</label>
                                                <input type="date" name="den_ngay" id="den_ngay" class="form-control">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Thông tin chi tiết khác</label>
                                            <textarea name="thongtin_khac" class="form-control" rows="3" placeholder="Ví dụ: thành tích, hoạt động nổi bật..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-primary">Lưu</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- MODAL THÊM/SỬA CHỨNG CHỈ -->
                    <div class="modal fade" id="addChungChiModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content rounded-3">
                                <form id="chungChiForm" method="POST" action="{{ route('chungchi.store') }}">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold" id="chungChiModalLabel">
                                            <i class="bi bi-award me-2"></i>Chứng chỉ
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <!-- Tên chứng chỉ -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Tên chứng chỉ <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control"
                                                name="ten_chungchi"
                                                id="cc_ten"
                                                placeholder="VD: AWS Certified Solutions Architect, Google Analytics..."
                                                required>
                                        </div>

                                        <!-- Tổ chức -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Tổ chức cấp <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control"
                                                name="to_chuc"
                                                id="cc_to_chuc"
                                                placeholder="VD: Microsoft, AWS, Google..."
                                                required>
                                        </div>

                                        <!-- Thời gian -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Thời gian <span class="text-danger">*</span>
                                            </label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <select class="form-select" name="thang" id="cc_thang" required>
                                                        <option value="">Tháng</option>
                                                        @for($i = 1; $i <= 12; $i++)
                                                            <option value="{{ $i }}">Tháng {{ $i }}</option>
                                                            @endfor
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <select class="form-select" name="nam" id="cc_nam" required>
                                                        <option value="">Năm</option>
                                                        @for($year = date('Y'); $year >= 1990; $year--)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Link chứng chỉ -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Link chứng chỉ</label>
                                            <input type="url"
                                                class="form-control"
                                                name="link_chungchi"
                                                id="cc_link"
                                                placeholder="https://example.com/certificate">
                                            <small class="text-muted">URL xác thực chứng chỉ (nếu có)</small>
                                        </div>

                                        <!-- Mô tả chi tiết - KHUNG LỚN -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Mô tả chi tiết</label>
                                            <div class="alert alert-info py-2 mb-2">
                                                <i class="bi bi-lightbulb text-warning me-1"></i>
                                                <strong>Tips:</strong> Mô tả nội dung, phạm vi, kỹ năng đạt được từ chứng chỉ này
                                            </div>
                                            <textarea class="form-control textarea-large"
                                                name="mo_ta"
                                                id="cc_mota"
                                                rows="15"
                                                maxlength="1000"

                                                placeholder="VD:
- Chứng chỉ chứng nhận kiến thức về AWS Cloud
- Nội dung: Architecture Design, Security, Cost Optimization
- Điểm: 850/1000
- Có hiệu lực đến: 12/2026"></textarea>
                                            <small class="text-muted">
                                                <span id="cc_mota_count">0</span>/1000 ký tự
                                            </small>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-danger" id="submitChungChiBtn">
                                            <i class="bi bi-check-lg"></i> Lưu
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- ✅ MODAL THÊM NGOẠI NGỮ - ĐẶT NGOÀI, KHÔNG BÊN TRONG MODAL KHÁC -->
                    <div class="modal fade" id="addNgoaiNguModal" tabindex="-1" aria-labelledby="addNgoaiNguModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content rounded-3 shadow">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold" id="addNgoaiNguModalLabel">
                                        <i class="bi bi-translate me-2"></i>Thêm Ngoại Ngữ
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <form id="ngoaiNguForm" action="{{ route('applicant.storeNgoaiNgu') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <p class="text-muted mb-3">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Thêm các ngoại ngữ bạn sử dụng được và trình độ của bạn
                                        </p>

                                        <!-- Danh sách ngôn ngữ đã chọn (hiển thị tạm thời) -->
                                        <div id="selectedLanguages" class="mb-3"></div>

                                        <!-- Form nhập ngôn ngữ mới -->
                                        <div class="border rounded p-3 bg-light">
                                            <div class="row">
                                                <!-- Tìm ngôn ngữ -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold">Tìm ngôn ngữ <span class="text-danger">*</span></label>
                                                    <select id="languageSelect" class="form-select">
                                                        <option value="">-- Chọn ngôn ngữ --</option>
                                                        <option value="Tiếng Anh">Tiếng Anh</option>
                                                        <option value="Tiếng Nhật">Tiếng Nhật</option>
                                                        <option value="Tiếng Hàn">Tiếng Hàn</option>
                                                        <option value="Tiếng Trung">Tiếng Trung</option>
                                                        <option value="Tiếng Pháp">Tiếng Pháp</option>
                                                        <option value="Tiếng Đức">Tiếng Đức</option>
                                                        <option value="Tiếng Tây Ban Nha">Tiếng Tây Ban Nha</option>
                                                        <option value="Tiếng Nga">Tiếng Nga</option>
                                                        <option value="Tiếng Thái">Tiếng Thái</option>
                                                        <option value="Tiếng Indonesia">Tiếng Indonesia</option>
                                                    </select>
                                                </div>

                                                <!-- Chọn trình độ -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold">Chọn trình độ <span class="text-danger">*</span></label>
                                                    <select id="levelSelect" class="form-select">
                                                        <option value="">-- Chọn trình độ --</option>
                                                        <option value="Sơ cấp">Sơ cấp</option>
                                                        <option value="Trung cấp">Trung cấp</option>
                                                        <option value="Cao cấp">Cao cấp</option>
                                                        <option value="Bản ngữ">Bản ngữ</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Nút thêm ngôn ngữ vào danh sách -->
                                            <button type="button" class="btn btn-primary btn-sm" id="addLanguageBtn">
                                                <i class="bi bi-plus-lg"></i> Thêm
                                            </button>
                                        </div>

                                        <!-- Hidden inputs cho form submit -->
                                        <div id="hiddenInputs"></div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-danger" id="submitNgoaiNguBtn" disabled>
                                            <i class="bi bi-check-lg"></i> Lưu
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- ...existing code... -->
                </div>
    </main>

    <!-- ✅ TOAST NOTIFICATION HELPER -->
    <script>
        // Toast Notification Function
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toastContainer');
            const toastId = 'toast-' + Date.now();

            const iconMap = {
                success: 'bi-check-circle-fill',
                error: 'bi-x-circle-fill',
                warning: 'bi-exclamation-triangle-fill',
                info: 'bi-info-circle-fill'
            };

            const bgMap = {
                success: 'linear-gradient(135deg, #10b981, #059669)',
                error: 'linear-gradient(135deg, #ef4444, #dc2626)',
                warning: 'linear-gradient(135deg, #f59e0b, #d97706)',
                info: 'linear-gradient(135deg, #3b82f6, #2563eb)'
            };

            const toast = document.createElement('div');
            toast.id = toastId;
            toast.style.cssText = `
                background: ${bgMap[type]};
                color: white;
                padding: 16px 20px;
                border-radius: 12px;
                margin-bottom: 10px;
                box-shadow: 0 8px 24px rgba(0,0,0,0.15);
                display: flex;
                align-items: center;
                gap: 12px;
                animation: slideInRight 0.3s ease-out;
                max-width: 400px;
            `;

            toast.innerHTML = `
                <i class="bi ${iconMap[type]}" style="font-size: 1.5rem;"></i>
                <div style="flex: 1; font-weight: 500;">${message}</div>
                <button onclick="this.parentElement.remove()" style="background: rgba(255,255,255,0.2); border: none; color: white; width: 24px; height: 24px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-x"></i>
                </button>
            `;

            toastContainer.appendChild(toast);

            // Auto remove after 4 seconds
            setTimeout(() => {
                toast.style.animation = 'slideOutRight 0.3s ease-out';
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }

        // Animation CSS
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
    </script>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.location.hash !== '#tab-attachments') {
                window.location.hash = '#tab-attachments';
            }
            showToast("{{ session('success') }}", 'success');
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.location.hash !== '#tab-attachments') {
                window.location.hash = '#tab-attachments';
            }
            showToast("{{ session('error') }}", 'error');
        });
    </script>
    @endif

    <!-- xử lý chứng chỉ -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chungChiForm = document.getElementById('chungChiForm');
            const modalTitle = document.getElementById('chungChiModalLabel');
            const submitButton = document.getElementById('submitChungChiBtn');

            const motaTextarea = document.getElementById('cc_mota');
            const motaCount = document.getElementById('cc_mota_count');

            // ========== CHARACTER COUNTER ==========
            if (motaTextarea) {
                motaTextarea.addEventListener('input', function() {
                    motaCount.textContent = this.value.length;
                });
            }

            // ========== RESET FORM ==========
            function resetFormToAdd() {
                chungChiForm.action = "{{ route('chungchi.store') }}";
                modalTitle.innerHTML = '<i class="bi bi-award me-2"></i>Chứng chỉ';
                submitButton.innerHTML = '<i class="bi bi-check-lg"></i> Lưu';

                const methodInput = chungChiForm.querySelector('input[name="_method"]');
                if (methodInput) methodInput.remove();

                chungChiForm.reset();
                motaCount.textContent = '0';
            }

            // ========== Mở MODAL THÊM MỚI ==========
            const addButton = document.querySelector('[data-bs-target="#addChungChiModal"]');
            if (addButton) {
                addButton.addEventListener('click', resetFormToAdd);
            }

            // ========== Xử LÝ NÚT EDIT ==========
            const editButtons = document.querySelectorAll('.editChungChiBtn');

            editButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.dataset.id;

                    fetch(`/chungchi/${id}/edit`)
                        .then(res => {
                            if (!res.ok) throw new Error('Không thể lấy dữ liệu');
                            return res.json();
                        })
                        .then(data => {
                            console.log('Data received:', data);

                            // Chuyển form sang update mode
                            chungChiForm.action = `/chungchi/${id}/update`;
                            modalTitle.innerHTML = '<i class="bi bi-award me-2"></i>Cập nhật chứng chỉ';
                            submitButton.innerHTML = '<i class="bi bi-check-lg"></i> Cập nhật';

                            // Thêm method POST
                            let methodInput = chungChiForm.querySelector('input[name="_method"]');
                            if (!methodInput) {
                                methodInput = document.createElement('input');
                                methodInput.type = 'hidden';
                                methodInput.name = '_method';
                                methodInput.value = 'POST';
                                chungChiForm.appendChild(methodInput);
                            }

                            // Fill dữ liệu
                            document.getElementById('cc_ten').value = data.ten_chungchi || '';
                            document.getElementById('cc_to_chuc').value = data.to_chuc || '';
                            document.getElementById('cc_link').value = data.link_chungchi || '';
                            document.getElementById('cc_mota').value = data.mo_ta || '';

                            // Xử lý thời gian
                            if (data.thoigian) {
                                const date = new Date(data.thoigian);
                                document.getElementById('cc_thang').value = date.getMonth() + 1;
                                document.getElementById('cc_nam').value = date.getFullYear();
                            }

                            // Update character count
                            motaCount.textContent = (data.mo_ta || '').length;

                            // Mở modal
                            const modal = new bootstrap.Modal(document.getElementById('addChungChiModal'));
                            modal.show();
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                            alert('Không thể tải dữ liệu chứng chỉ. Vui lòng thử lại!');
                        });
                });
            });

            // ========== RESET KHI ĐÓNG MODAL ==========
            const modal = document.getElementById('addChungChiModal');
            if (modal) {
                modal.addEventListener('hidden.bs.modal', resetFormToAdd);
            }
        });
    </script>

    <!-- xử lý giải thưởng -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const giaiThuongForm = document.getElementById('giaiThuongForm');
            const modalTitle = document.getElementById('giaiThuongModalLabel');
            const submitButton = document.getElementById('submitGiaiThuongBtn');

            const motaTextarea = document.getElementById('gt_mota');
            const motaCount = document.getElementById('gt_mota_count');

            // ========== CHARACTER COUNTER ==========
            if (motaTextarea) {
                motaTextarea.addEventListener('input', function() {
                    motaCount.textContent = this.value.length;
                });
            }

            // ========== RESET FORM ==========
            function resetFormToAdd() {
                giaiThuongForm.action = "{{ route('giaithuong.store') }}";
                modalTitle.innerHTML = '<i class="bi bi-trophy me-2"></i>Giải thưởng';
                submitButton.innerHTML = '<i class="bi bi-check-lg"></i> Lưu';

                const methodInput = giaiThuongForm.querySelector('input[name="_method"]');
                if (methodInput) methodInput.remove();

                giaiThuongForm.reset();
                motaCount.textContent = '0';
            }

            // ========== Mở MODAL THÊM MỚI ==========
            const addButton = document.querySelector('[data-bs-target="#addGiaiThuongModal"]');
            if (addButton) {
                addButton.addEventListener('click', resetFormToAdd);
            }

            // ========== Xử LÝ NÚT EDIT ==========
            const editButtons = document.querySelectorAll('.editGiaiThuongBtn');

            editButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.dataset.id;

                    fetch(`/giaithuong/${id}/edit`)
                        .then(res => {
                            if (!res.ok) throw new Error('Không thể lấy dữ liệu');
                            return res.json();
                        })
                        .then(data => {
                            console.log('Data received:', data);

                            // Chuyển form sang update mode
                            giaiThuongForm.action = `/giaithuong/${id}/update`;
                            modalTitle.innerHTML = '<i class="bi bi-trophy me-2"></i>Cập nhật giải thưởng';
                            submitButton.innerHTML = '<i class="bi bi-check-lg"></i> Cập nhật';

                            // Thêm method POST
                            let methodInput = giaiThuongForm.querySelector('input[name="_method"]');
                            if (!methodInput) {
                                methodInput = document.createElement('input');
                                methodInput.type = 'hidden';
                                methodInput.name = '_method';
                                methodInput.value = 'POST';
                                giaiThuongForm.appendChild(methodInput);
                            }

                            // Fill dữ liệu
                            document.getElementById('gt_ten').value = data.ten_giaithuong || '';
                            document.getElementById('gt_to_chuc').value = data.to_chuc || '';
                            document.getElementById('gt_mota').value = data.mo_ta || '';

                            // Xử lý thời gian
                            if (data.thoigian) {
                                const date = new Date(data.thoigian);
                                document.getElementById('gt_thang').value = date.getMonth() + 1;
                                document.getElementById('gt_nam').value = date.getFullYear();
                            }

                            // Update character count
                            motaCount.textContent = (data.mo_ta || '').length;

                            // Mở modal
                            const modal = new bootstrap.Modal(document.getElementById('addGiaiThuongModal'));
                            modal.show();
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                            alert('Không thể tải dữ liệu giải thưởng. Vui lòng thử lại!');
                        });
                });
            });

            // ========== RESET KHI ĐÓNG MODAL ==========
            const modal = document.getElementById('addGiaiThuongModal');
            if (modal) {
                modal.addEventListener('hidden.bs.modal', resetFormToAdd);
            }
        });
    </script>

    <!-- xử lý dự án -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const duAnForm = document.getElementById('duAnForm');
            const modalTitle = document.getElementById('addDuAnModalLabel');
            const submitButton = document.getElementById('submitDuAnBtn');

            // Elements
            const dangLamCheckbox = document.getElementById('dang_lam');
            const thangKetThuc = document.getElementById('thang_ket_thuc');
            const namKetThuc = document.getElementById('nam_ket_thuc');
            const motaTextarea = document.getElementById('mota_duan');
            const motaCount = document.getElementById('mota_count');
            const insertTemplateBtn = document.getElementById('insertTemplateBtn');

            // ========== RESET FORM KHI MỞ MODAL THÊM MỚI ==========
            function resetFormToAdd() {
                duAnForm.action = "{{ route('duan.store') }}";
                modalTitle.innerHTML = '<i class="bi bi-kanban me-2"></i>Dự án nổi bật';
                submitButton.innerHTML = '<i class="bi bi-check-lg"></i> Lưu';

                // Xóa method input cũ
                const methodInput = duAnForm.querySelector('input[name="_method"]');
                if (methodInput) methodInput.remove();

                // Reset form
                duAnForm.reset();
                motaCount.textContent = '0';
                toggleNgayKetThuc();
            }

            // ========== XỬ LÝ CHECKBOX "ĐANG LÀM" ==========
            function toggleNgayKetThuc() {
                if (dangLamCheckbox.checked) {
                    thangKetThuc.disabled = true;
                    namKetThuc.disabled = true;
                    thangKetThuc.value = '';
                    namKetThuc.value = '';
                    thangKetThuc.removeAttribute('required');
                    namKetThuc.removeAttribute('required');
                } else {
                    thangKetThuc.disabled = false;
                    namKetThuc.disabled = false;
                    thangKetThuc.setAttribute('required', 'required');
                    namKetThuc.setAttribute('required', 'required');
                }
            }

            dangLamCheckbox.addEventListener('change', toggleNgayKetThuc);

            // ========== CHARACTER COUNTER ==========
            if (motaTextarea) {
                motaTextarea.addEventListener('input', function() {
                    motaCount.textContent = this.value.length;
                });
            }

            // ========== NÚT CHÈN TEMPLATE ==========
            if (insertTemplateBtn) {
                insertTemplateBtn.addEventListener('click', function() {
                    const template = `• Mô tả: Viết mô tả ngắn gọn dự án
• Vai trò: Chức danh của bạn trong dự án
• Trách nhiệm:
  ◦ Trách nhiệm đầu tiên
  ◦ Trách nhiệm thứ hai
• Công nghệ: Liệt kê các công nghệ đã sử dụng
• Nhóm: x thành viên`;

                    motaTextarea.value = template;
                    motaCount.textContent = template.length;
                    motaTextarea.focus();
                });
            }

            // ========== MỞ MODAL THÊM MỚI ==========
            const addButton = document.querySelector('[data-bs-target="#addDuAnModal"]');
            if (addButton) {
                addButton.addEventListener('click', resetFormToAdd);
            }

            // ========== XỬ LÝ NÚT EDIT ==========
            const editButtons = document.querySelectorAll('.editDuAnBtn');

            editButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.dataset.id;

                    // Fetch dữ liệu dự án
                    fetch(`/duan/${id}/edit`)
                        .then(res => {
                            if (!res.ok) throw new Error('Không thể lấy dữ liệu');
                            return res.json();
                        })
                        .then(data => {
                            console.log('Data received:', data);

                            // Chuyển form sang update mode
                            duAnForm.action = `/duan/${id}/update`;
                            modalTitle.innerHTML = '<i class="bi bi-kanban me-2"></i>Cập nhật dự án';
                            submitButton.innerHTML = '<i class="bi bi-check-lg"></i> Cập nhật';

                            // Thêm method POST
                            let methodInput = duAnForm.querySelector('input[name="_method"]');
                            if (!methodInput) {
                                methodInput = document.createElement('input');
                                methodInput.type = 'hidden';
                                methodInput.name = '_method';
                                methodInput.value = 'POST';
                                duAnForm.appendChild(methodInput);
                            }

                            // Fill dữ liệu vào form
                            document.getElementById('ten_duan').value = data.ten_duan || '';

                            // Xử lý ngày bắt đầu
                            if (data.ngay_bat_dau) {
                                const startDate = new Date(data.ngay_bat_dau);
                                document.getElementById('thang_bat_dau').value = startDate.getMonth() + 1;
                                document.getElementById('nam_bat_dau').value = startDate.getFullYear();
                            }

                            // Xử lý ngày kết thúc
                            if (data.ngay_ket_thuc) {
                                const endDate = new Date(data.ngay_ket_thuc);
                                document.getElementById('thang_ket_thuc').value = endDate.getMonth() + 1;
                                document.getElementById('nam_ket_thuc').value = endDate.getFullYear();
                            }

                            // Mô tả và website
                            document.getElementById('mota_duan').value = data.mota_duan || '';
                            document.getElementById('duongdan_website').value = data.duongdan_website || '';

                            // Update character count
                            motaCount.textContent = (data.mota_duan || '').length;

                            // Checkbox đang làm
                            dangLamCheckbox.checked = data.dang_lam == 1;
                            toggleNgayKetThuc();

                            // Mở modal
                            const modal = new bootstrap.Modal(document.getElementById('addDuAnModal'));
                            modal.show();
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                            alert('Không thể tải dữ liệu dự án. Vui lòng thử lại!');
                        });
                });
            });

            // ========== RESET KHI ĐÓNG MODAL ==========
            const modal = document.getElementById('addDuAnModal');
            if (modal) {
                modal.addEventListener('hidden.bs.modal', resetFormToAdd);
            }

            // Khởi tạo ban đầu
            toggleNgayKetThuc();
        });
    </script>
    <!-- ✅ SCRIPT XỬ LÝ NGOẠI NGỮ - PHIÊN BẢN HOÀN CHỈNH -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const languageSelect = document.getElementById('languageSelect');
            const levelSelect = document.getElementById('levelSelect');
            const addLanguageBtn = document.getElementById('addLanguageBtn');
            const selectedLanguages = document.getElementById('selectedLanguages');
            const hiddenInputs = document.getElementById('hiddenInputs');
            const submitBtn = document.getElementById('submitNgoaiNguBtn');

            let languages = [];

            // ========== THÊM NGÔN NGỮ VÀO DANH SÁCH TẠM THỜI ==========
            if (addLanguageBtn) {
                addLanguageBtn.addEventListener('click', function() {
                    const language = languageSelect.value;
                    const level = levelSelect.value;

                    if (!language || !level) {
                        alert('Vui lòng chọn đầy đủ ngôn ngữ và trình độ!');
                        return;
                    }

                    const exists = languages.find(item => item.language === language);
                    if (exists) {
                        alert('Ngôn ngữ này đã được thêm!');
                        return;
                    }

                    languages.push({
                        language,
                        level
                    });
                    renderLanguages();
                    languageSelect.value = '';
                    levelSelect.value = '';
                    if (submitBtn) submitBtn.disabled = false;
                });
            }

            // ========== RENDER DANH SÁCH NGÔN NGỮ ĐÃ CHỌN ==========
            function renderLanguages() {
                if (languages.length === 0) {
                    if (selectedLanguages) selectedLanguages.innerHTML = '';
                    if (hiddenInputs) hiddenInputs.innerHTML = '';
                    if (submitBtn) submitBtn.disabled = true;
                    return;
                }

                if (selectedLanguages) {
                    selectedLanguages.innerHTML = `
                <div class="alert alert-success">
                    <strong><i class="bi bi-check-circle me-1"></i>Ngôn ngữ đã chọn (${languages.length}):</strong>
                </div>
            `;

                    languages.forEach((item, index) => {
                        selectedLanguages.innerHTML += `
                    <div class="d-inline-flex align-items-center badge bg-primary text-white me-2 mb-2 p-2 fs-6">
                        <div class="me-2">
                            <strong>${item.language}</strong>
                            <span class="opacity-75"> - ${item.level}</span>
                        </div>
                        <button type="button" class="btn btn-sm btn-link text-white p-0 removeLanguageBtn" 
                                data-index="${index}" title="Xóa">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                `;
                    });
                }

                if (hiddenInputs) {
                    hiddenInputs.innerHTML = '';
                    languages.forEach((item) => {
                        hiddenInputs.innerHTML += `
                    <input type="hidden" name="ten_ngoai_ngu[]" value="${item.language}">
                    <input type="hidden" name="trinh_do[]" value="${item.level}">
                `;
                    });
                }

                // Gắn event cho nút xóa trong danh sách tạm
                document.querySelectorAll('.removeLanguageBtn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.dataset.index);
                        languages.splice(index, 1);
                        renderLanguages();
                    });
                });
            }

            // ========== RESET KHI ĐÓNG MODAL ==========
            const modalElement = document.getElementById('addNgoaiNguModal');
            if (modalElement) {
                modalElement.addEventListener('hidden.bs.modal', function() {
                    languages = [];
                    renderLanguages();
                    if (languageSelect) languageSelect.value = '';
                    if (levelSelect) levelSelect.value = '';
                });
            }
        });

        // ========== XỬ LÝ XÓA NGOẠI NGỮ ĐÃ LƯU - EVENT DELEGATION ==========
        document.body.addEventListener('click', function(e) {
            const deleteBtn = e.target.closest('.deleteNgoaiNguBtn');

            if (deleteBtn) {
                e.preventDefault();
                e.stopPropagation();

                const id = deleteBtn.dataset.id;

                if (!id) {
                    console.error('Không tìm thấy ID ngoại ngữ');
                    alert('Lỗi: Không xác định được ngoại ngữ cần xóa!');
                    return;
                }

                // ✅ Lấy CSRF token và kiểm tra
                const csrfMeta = document.querySelector('meta[name="csrf-token"]');

                if (!csrfMeta) {
                    console.error('❌ KHÔNG TÌM THẤY meta tag csrf-token trong HTML!');
                    alert('Lỗi hệ thống: Không tìm thấy CSRF token. Vui lòng reload trang!');
                    return;
                }

                const csrfToken = csrfMeta.content;

                if (!csrfToken) {
                    console.error('❌ CSRF token rỗng!');
                    alert('Lỗi: CSRF token không hợp lệ. Vui lòng reload trang!');
                    return;
                }

                console.log('✅ CSRF Token:', csrfToken);
                console.log('Đang gửi yêu cầu xóa ngoại ngữ ID:', id);

                if (confirm('Bạn có chắc muốn xóa ngoại ngữ này?')) {
                    // Disable button và hiển thị loading
                    deleteBtn.disabled = true;
                    const originalHTML = deleteBtn.innerHTML;
                    deleteBtn.innerHTML = '<i class="bi bi-hourglass-split"></i>';

                    fetch(`/applicant/ngoai-ngu/${id}/delete`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => {
                            console.log('Response status:', res.status);
                            if (!res.ok) {
                                throw new Error(`HTTP ${res.status}: ${res.statusText}`);
                            }
                            return res.json();
                        })
                        .then(data => {
                            console.log('Response data:', data);
                            if (data.success) {
                                alert('Đã xóa ngoại ngữ thành công!');
                                location.reload();
                            } else {
                                alert(data.message || 'Có lỗi xảy ra khi xóa!');
                                deleteBtn.disabled = false;
                                deleteBtn.innerHTML = originalHTML;
                            }
                        })
                        .catch(error => {
                            console.error('Lỗi khi xóa:', error);
                            alert('Không thể xóa ngoại ngữ!\nLỗi: ' + error.message);
                            deleteBtn.disabled = false;
                            deleteBtn.innerHTML = originalHTML;
                        });
                }
            }
        });
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#gioithieu-editor'), {
                toolbar: [
                    'bold', 'italic', 'underline', '|',
                    'bulletedList', 'numberedList', '|',
                    'undo', 'redo'
                ]
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <!-- Script xử lý checkbox -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('dang_hoc');
            const denNgayInput = document.getElementById('den_ngay');

            function toggleDenNgay() {
                if (checkbox.checked) {
                    denNgayInput.disabled = true;
                    denNgayInput.value = ''; // clear khi disable
                } else {
                    denNgayInput.disabled = false;
                }
            }

            // chạy khi load trang
            toggleDenNgay();

            // lắng nghe sự kiện thay đổi
            checkbox.addEventListener('change', toggleDenNgay);
        });
    </script>
    <!-- // ============ XỬ LÝ HỌC VẤN ============  -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hocVanForm = document.getElementById('hocVanForm');
            const modalTitle = document.getElementById('addHocVanModalLabel');
            const submitButton = hocVanForm.querySelector('button[type="submit"]');

            // Checkbox đang học
            const checkbox = document.getElementById('dang_hoc');
            const denNgayInput = document.getElementById('den_ngay');

            // Hàm reset form về trạng thái thêm mới
            function resetFormToAdd() {
                hocVanForm.action = "{{ route('hocvan.store') }}";
                hocVanForm.method = "POST";
                modalTitle.textContent = "Thêm Học Vấn";
                submitButton.textContent = "Lưu";

                // Xóa input method cũ nếu có
                const methodInput = hocVanForm.querySelector('input[name="_method"]');
                if (methodInput) {
                    methodInput.remove();
                }

                // Reset form
                hocVanForm.reset();
                denNgayInput.disabled = false;
            }

            // Khi mở modal thêm mới
            document.querySelector('[data-bs-target="#addHocVanModal"]').addEventListener('click', function() {
                resetFormToAdd();
            });

            // Xử lý checkbox "đang học"
            function toggleDenNgay() {
                if (checkbox.checked) {
                    denNgayInput.disabled = true;
                    denNgayInput.value = '';
                } else {
                    denNgayInput.disabled = false;
                }
            }

            checkbox.addEventListener('change', toggleDenNgay);
            toggleDenNgay(); // Chạy khi load

            // Xử lý nút Edit
            const editButtons = document.querySelectorAll('.editHocVanBtn');

            editButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.dataset.id;

                    // Fetch dữ liệu học vấn
                    fetch(`/hocvan/${id}/edit`)
                        .then(res => {
                            if (!res.ok) throw new Error('Không thể lấy dữ liệu');
                            return res.json();
                        })
                        .then(data => {
                            // Thay đổi form thành update mode
                            hocVanForm.action = `/hocvan/${id}/update`;
                            modalTitle.textContent = "Cập Nhật Học Vấn";
                            submitButton.textContent = "Cập nhật";

                            // Thêm method PUT (nếu dùng Route::put)
                            // Hoặc giữ POST nếu route là Route::post
                            let methodInput = hocVanForm.querySelector('input[name="_method"]');
                            if (!methodInput) {
                                methodInput = document.createElement('input');
                                methodInput.type = 'hidden';
                                methodInput.name = '_method';
                                methodInput.value = 'POST'; // hoặc 'PUT' nếu route dùng PUT
                                hocVanForm.appendChild(methodInput);
                            }

                            // Fill dữ liệu vào form
                            hocVanForm.querySelector('input[name="truong"]').value = data.truong || '';
                            hocVanForm.querySelector('select[name="trinhdo"]').value = data.trinhdo || '';
                            hocVanForm.querySelector('input[name="nganh"]').value = data.nganh || '';
                            hocVanForm.querySelector('input[name="tu_ngay"]').value = data.tu_ngay || '';
                            hocVanForm.querySelector('input[name="den_ngay"]').value = data.den_ngay || '';
                            hocVanForm.querySelector('textarea[name="thongtin_khac"]').value = data.thongtin_khac || '';

                            // Set checkbox
                            checkbox.checked = data.dang_hoc == 1;
                            toggleDenNgay();

                            // Mở modal
                            const modal = new bootstrap.Modal(document.getElementById('addHocVanModal'));
                            modal.show();
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                            alert('Không thể tải dữ liệu học vấn. Vui lòng thử lại!');
                        });
                });
            });
        });

        // ============ XỬ LÝ KINH NGHIỆM LÀM VIỆC ============

        document.addEventListener("DOMContentLoaded", function() {
            const dangLamViec = document.getElementById('dangLamViec');
            const denNgay = document.getElementById('denNgay');

            function toggleDenNgay() {
                if (dangLamViec.checked) {
                    denNgay.disabled = true;
                    denNgay.value = "";
                } else {
                    denNgay.disabled = false;
                }
            }

            dangLamViec.addEventListener('change', toggleDenNgay);
            toggleDenNgay();
        });

        // ============ XỬ LÝ KỸ NĂNG ============
        // ============ XỬ LÝ KỸ NĂNG - THÊM VÀO DANH SÁCH TẠM THỜI ============

        document.addEventListener('DOMContentLoaded', function() {
            const skillInput = document.getElementById('skillInput');
            const experienceSelect = document.getElementById('experienceSelect');
            const addSkillBtn = document.getElementById('addSkillBtn');
            const selectedSkills = document.getElementById('selectedSkills');
            const hiddenSkillInputs = document.getElementById('hiddenSkillInputs');
            const submitBtn = document.getElementById('submitKyNangBtn');

            console.log('🔧 Kỹ năng elements:', {
                skillInput,
                experienceSelect,
                addSkillBtn,
                selectedSkills,
                hiddenSkillInputs,
                submitBtn
            });

            let skills = [];

            // ========== THÊM KỸ NĂNG VÀO DANH SÁCH TẠM THỜI ==========
            if (addSkillBtn) {
                addSkillBtn.addEventListener('click', function() {
                    console.log('🔵 Click nút thêm kỹ năng');

                    const skill = skillInput.value.trim();
                    const experience = experienceSelect.value;

                    console.log('📝 Input values:', {
                        skill,
                        experience
                    });

                    // Validate input
                    if (!skill || !experience) {
                        alert('Vui lòng nhập đầy đủ tên kỹ năng và năm kinh nghiệm!');
                        return;
                    }

                    // Kiểm tra trùng lặp (không phân biệt hoa thường)
                    const exists = skills.find(item => item.skill.toLowerCase() === skill.toLowerCase());
                    if (exists) {
                        alert('Kỹ năng này đã được thêm!');
                        return;
                    }

                    // Thêm vào mảng
                    skills.push({
                        skill,
                        experience
                    });

                    console.log('✅ Đã thêm kỹ năng:', skills);

                    // Render lại danh sách
                    renderSkills();

                    // Clear input và focus
                    skillInput.value = '';
                    experienceSelect.value = '';
                    skillInput.focus();

                    // Enable nút submit
                    if (submitBtn) submitBtn.disabled = false;
                });
            } else {
                console.error('❌ Không tìm thấy nút addSkillBtn');
            }

            // ========== RENDER DANH SÁCH KỸ NĂNG ĐÃ CHỌN ==========
            function renderSkills() {
                console.log('🎨 Rendering skills:', skills);
                console.log('📍 selectedSkills element:', selectedSkills);

                // Nếu không có kỹ năng nào
                if (skills.length === 0) {
                    console.log('⚠️ Không có kỹ năng nào để hiển thị');
                    if (selectedSkills) selectedSkills.innerHTML = '';
                    if (hiddenSkillInputs) hiddenSkillInputs.innerHTML = '';
                    if (submitBtn) submitBtn.disabled = true;
                    return;
                }

                console.log('✅ Bắt đầu render', skills.length, 'kỹ năng');

                // Render phần hiển thị
                if (selectedSkills) {
                    selectedSkills.innerHTML = `
                <div class="alert alert-success">
                    <strong><i class="bi bi-check-circle me-1"></i>Kỹ năng đã chọn (${skills.length}):</strong>
                </div>
            `;

                    skills.forEach((item, index) => {
                        console.log('  → Render item:', item);
                        const expText = item.experience == 0 ? '<1 năm' :
                            item.experience == '10+' ? '10+ năm' :
                            `${item.experience} năm`;

                        selectedSkills.innerHTML += `
                    <div class="d-inline-flex align-items-center badge bg-primary text-white me-2 mb-2 p-2 fs-6">
                        <div class="me-2">
                            <strong>${item.skill}</strong>
                            <span class="opacity-75"> (${expText})</span>
                        </div>
                        <button type="button" class="btn btn-sm btn-link text-white p-0 removeSkillBtn" 
                                data-index="${index}" title="Xóa">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                `;
                    });

                    console.log('✨ HTML sau khi render:', selectedSkills.innerHTML);
                    console.log('📏 Children count:', selectedSkills.children.length);

                    // Force scroll to view
                    selectedSkills.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });

                    // Force repaint
                    selectedSkills.style.display = 'none';
                    selectedSkills.offsetHeight; // trigger reflow
                    selectedSkills.style.display = 'block';
                } else {
                    console.error('❌ selectedSkills element không tồn tại!');
                }

                // Render hidden inputs cho form submit
                if (hiddenSkillInputs) {
                    hiddenSkillInputs.innerHTML = '';
                    skills.forEach((item) => {
                        hiddenSkillInputs.innerHTML += `
                    <input type="hidden" name="ten_ky_nang[]" value="${item.skill}">
                    <input type="hidden" name="nam_kinh_nghiem[]" value="${item.experience}">
                `;
                    });
                    console.log('📨 Hidden inputs HTML:', hiddenSkillInputs.innerHTML);
                    console.log('📦 Total hidden inputs:', hiddenSkillInputs.querySelectorAll('input').length);
                } else {
                    console.error('❌ hiddenSkillInputs element không tồn tại!');
                }

                // Gắn event cho nút xóa trong danh sách tạm
                document.querySelectorAll('.removeSkillBtn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.dataset.index);
                        skills.splice(index, 1);
                        renderSkills();
                    });
                });
            }

            // ========== RESET KHI ĐÓNG MODAL ==========
            const modalElement = document.getElementById('addKyNangModal');
            if (modalElement) {
                modalElement.addEventListener('hidden.bs.modal', function() {
                    skills = [];
                    renderSkills();
                    if (skillInput) skillInput.value = '';
                    if (experienceSelect) experienceSelect.value = '';
                });
            }

            // ========== FORM SUBMIT HANDLER ==========
            const kyNangForm = document.getElementById('kyNangForm');
            if (kyNangForm) {
                kyNangForm.addEventListener('submit', function(e) {
                    e.preventDefault(); // Chặn submit mặc định

                    console.log('📤 Form submit triggered');
                    console.log('📊 Skills array:', skills);

                    // Kiểm tra có kỹ năng không
                    if (skills.length === 0) {
                        showToast('Vui lòng thêm ít nhất 1 kỹ năng!', 'warning');
                        return false;
                    }

                    const formData = new FormData(this);
                    const hasSkillData = formData.getAll('ten_ky_nang[]').length > 0;

                    if (!hasSkillData) {
                        console.error('❌ KHÔNG CÓ DỮ LIỆU KỸ NĂNG TRONG FORM!');
                        showToast('Lỗi: Không có dữ liệu kỹ năng. Vui lòng thử lại!', 'error');
                        return false;
                    }

                    // Disable submit button
                    const submitBtn = document.getElementById('submitKyNangBtn');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Đang lưu...';

                    // AJAX Submit
                    fetch('{{ route("applicant.storeKyNang") }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showToast(data.message || 'Đã thêm kỹ năng thành công!', 'success');

                                // Đóng modal
                                const modal = bootstrap.Modal.getInstance(document.getElementById('addKyNangModal'));
                                modal.hide();

                                // Reset form
                                skills = [];
                                renderSkills();
                                kyNangForm.reset();

                                // Reload section kỹ năng
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            } else {
                                showToast(data.message || 'Có lỗi xảy ra!', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('Có lỗi xảy ra khi lưu kỹ năng!', 'error');
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        });
                });
            } else {
                console.error('❌ Không tìm thấy form kyNangForm');
            }

            // ========== HỖ TRỢ PHÍM ENTER ĐỂ THÊM NHANH ==========
            if (skillInput) {
                skillInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        addSkillBtn.click();
                    }
                });
            }

            if (experienceSelect) {
                experienceSelect.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        addSkillBtn.click();
                    }
                });
            }
        });
        // ========== XỬ LÝ XÓA KỸ NĂNG ĐÃ LƯU - EVENT DELEGATION ==========

        document.body.addEventListener('click', function(e) {
            // Tìm nút xóa kỹ năng
            const deleteBtn = e.target.closest('.deleteKyNangBtn');

            if (deleteBtn) {
                e.preventDefault();
                e.stopPropagation();

                const id = deleteBtn.dataset.id;

                // Validate ID
                if (!id) {
                    console.error('Không tìm thấy ID kỹ năng');
                    alert('Lỗi: Không xác định được kỹ năng cần xóa!');
                    return;
                }

                // Lấy CSRF token
                const csrfMeta = document.querySelector('meta[name="csrf-token"]');

                if (!csrfMeta) {
                    console.error('❌ KHÔNG TÌM THẤY meta tag csrf-token trong HTML!');
                    alert('Lỗi hệ thống: Không tìm thấy CSRF token. Vui lòng reload trang!');
                    return;
                }

                const csrfToken = csrfMeta.content;

                if (!csrfToken) {
                    console.error('❌ CSRF token rỗng!');
                    alert('Lỗi: CSRF token không hợp lệ. Vui lòng reload trang!');
                    return;
                }

                console.log('✅ CSRF Token:', csrfToken);
                console.log('Đang gửi yêu cầu xóa kỹ năng ID:', id);

                // Xác nhận xóa
                if (confirm('Bạn có chắc muốn xóa kỹ năng này?')) {
                    // Disable button và hiển thị loading
                    deleteBtn.disabled = true;
                    const originalHTML = deleteBtn.innerHTML;
                    deleteBtn.innerHTML = '<i class="bi bi-hourglass-split"></i>';

                    fetch(`/applicant/ky-nang/${id}/delete`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => {
                            console.log('Response status:', res.status);
                            if (!res.ok) {
                                throw new Error(`HTTP ${res.status}: ${res.statusText}`);
                            }
                            return res.json();
                        })
                        .then(data => {
                            console.log('Response data:', data);
                            if (data.success) {
                                alert('Đã xóa kỹ năng thành công!');
                                location.reload();
                            } else {
                                alert(data.message || 'Có lỗi xảy ra khi xóa!');
                                deleteBtn.disabled = false;
                                deleteBtn.innerHTML = originalHTML;
                            }
                        })
                        .catch(error => {
                            console.error('Lỗi khi xóa:', error);
                            alert('Không thể xóa kỹ năng!\nLỗi: ' + error.message);
                            deleteBtn.disabled = false;
                            deleteBtn.innerHTML = originalHTML;
                        });
                }
            }
        });
        // Xóa skill block
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-skill')) {
                e.target.closest('.skill-item').remove();
            }
        });

        // Autocomplete cho input skill
        const skillSuggestions = ["Java", "PHP", "Python", "JavaScript", "HTML", "CSS", "Laravel", "React", "Node.js", "SQL"];
        document.addEventListener("input", function(e) {
            if (e.target.classList.contains("skill-input")) {
                let input = e.target;
                let list = skillSuggestions.filter(s => s.toLowerCase().includes(input.value.toLowerCase()));
                input.setAttribute("list", "skills-list");
                let datalist = document.getElementById("skills-list");
                if (!datalist) {
                    datalist = document.createElement("datalist");
                    datalist.id = "skills-list";
                    document.body.appendChild(datalist);
                }
                datalist.innerHTML = list.map(item => `<option value="${item}">`).join("");
            }
        });
    </script>
    <!-- xu ly kinh nghiem -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kinhNghiemForm = document.getElementById('kinhNghiemForm');
            const modalTitle = document.getElementById('kinhNghiemModalLabel');
            const submitButton = document.getElementById('kinhNghiemSubmitBtn');

            // Checkbox đang làm việc
            const checkbox = document.getElementById('kn_dangLamViec');
            const denNgayInput = document.getElementById('kn_denNgay');

            // Character counter
            const motaTextarea = document.getElementById('kn_mota');
            const duanTextarea = document.getElementById('kn_duan');
            const motaCount = document.getElementById('mota_count');
            const duanCount = document.getElementById('duan_count');

            // Hàm reset form về trạng thái thêm mới
            function resetFormToAdd() {
                kinhNghiemForm.action = "{{ route('kinhnghiem.store') }}";
                modalTitle.textContent = "Thêm Kinh Nghiệm Làm Việc";
                submitButton.textContent = "Lưu";

                // Xóa input method cũ nếu có
                const methodInput = kinhNghiemForm.querySelector('input[name="_method"]');
                if (methodInput) {
                    methodInput.remove();
                }

                // Reset form
                kinhNghiemForm.reset();
                denNgayInput.disabled = false;
                motaCount.textContent = '0';
                duanCount.textContent = '0';
            }

            // Khi mở modal thêm mới
            document.querySelector('[data-bs-target="#addKinhNghiemModal"]').addEventListener('click', function() {
                resetFormToAdd();
            });

            // Xử lý checkbox "đang làm việc"
            function toggleDenNgay() {
                if (checkbox.checked) {
                    denNgayInput.disabled = true;
                    denNgayInput.value = '';
                } else {
                    denNgayInput.disabled = false;
                }
            }

            checkbox.addEventListener('change', toggleDenNgay);
            toggleDenNgay();

            // Character counter
            if (motaTextarea) {
                motaTextarea.addEventListener('input', function() {
                    motaCount.textContent = this.value.length;
                });
            }

            if (duanTextarea) {
                duanTextarea.addEventListener('input', function() {
                    duanCount.textContent = this.value.length;
                });
            }

            // Xử lý nút Edit
            const editButtons = document.querySelectorAll('.editKinhNghiemBtn');

            editButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.dataset.id;

                    // Fetch dữ liệu kinh nghiệm
                    fetch(`/kinhnghiem/${id}/edit`)
                        .then(res => {
                            if (!res.ok) throw new Error('Không thể lấy dữ liệu');
                            return res.json();
                        })
                        .then(data => {
                            // Thay đổi form thành update mode
                            kinhNghiemForm.action = `/kinhnghiem/${id}/update`;
                            modalTitle.textContent = "Cập Nhật Kinh Nghiệm";
                            submitButton.textContent = "Cập nhật";

                            // Thêm method POST
                            let methodInput = kinhNghiemForm.querySelector('input[name="_method"]');
                            if (!methodInput) {
                                methodInput = document.createElement('input');
                                methodInput.type = 'hidden';
                                methodInput.name = '_method';
                                methodInput.value = 'POST';
                                kinhNghiemForm.appendChild(methodInput);
                            }

                            // Fill dữ liệu vào form
                            document.getElementById('kn_chucdanh').value = data.chucdanh || '';
                            document.getElementById('kn_congty').value = data.congty || '';

                            // Format date từ YYYY-MM-DD sang YYYY-MM
                            const tuNgay = data.tu_ngay ? data.tu_ngay.substring(0, 7) : '';
                            const denNgay = data.den_ngay ? data.den_ngay.substring(0, 7) : '';

                            document.getElementById('kn_tuNgay').value = tuNgay;
                            document.getElementById('kn_denNgay').value = denNgay;
                            document.getElementById('kn_mota').value = data.mota || '';
                            document.getElementById('kn_duan').value = data.duan || '';

                            // Update character count
                            motaCount.textContent = (data.mota || '').length;
                            duanCount.textContent = (data.duan || '').length;

                            // Set checkbox
                            checkbox.checked = data.dang_lam_viec == 1;
                            toggleDenNgay();

                            // Mở modal
                            const modal = new bootstrap.Modal(document.getElementById('addKinhNghiemModal'));
                            modal.show();
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                            alert('Không thể tải dữ liệu kinh nghiệm. Vui lòng thử lại!');
                        });
                });
            });
        });
    </script>
    <!-- ✅ MODAL CHỈNH SỬA MỨC LƯƠNG MONG MUỐN -->
    <div class="modal fade" id="editMucLuongModal" tabindex="-1" aria-labelledby="editMucLuongModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-3">
                <form id="mucLuongForm" method="POST" action="{{ route('applicant.updateMucLuong') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="editMucLuongModalLabel">
                            <i class="bi bi-cash-coin me-2"></i>Cập nhật mức lương mong muốn
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-info py-2 mb-3">
                            <i class="bi bi-lightbulb text-warning me-1"></i>
                            <strong>Tips:</strong> Chọn mức lương phù hợp với kinh nghiệm và kỹ năng của bạn để tăng cơ hội được nhà tuyển dụng liên hệ
                        </div>

                        <div class="mb-3">
                            <label for="mucluong_mongmuon" class="form-label fw-bold">
                                Chọn mức lương <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-lg" name="mucluong_mongmuon" id="mucluong_mongmuon" required>
                                <option value="">-- Vui lòng chọn mức lương --</option>
                                <option value="Thỏa thuận" {{ ($applicant->mucluong_mongmuon ?? '') == 'Thỏa thuận' ? 'selected' : '' }}>
                                    Thỏa thuận
                                </option>
                                <option value="Dưới 3 triệu" {{ ($applicant->mucluong_mongmuon ?? '') == 'Dưới 3 triệu' ? 'selected' : '' }}>
                                    Dưới 3 triệu VNĐ
                                </option>
                                <option value="3 triệu - 5 triệu" {{ ($applicant->mucluong_mongmuon ?? '') == '3 triệu - 5 triệu' ? 'selected' : '' }}>
                                    3 - 5 triệu VNĐ
                                </option>
                                <option value="5 triệu - 7 triệu" {{ ($applicant->mucluong_mongmuon ?? '') == '5 triệu - 7 triệu' ? 'selected' : '' }}>
                                    5 - 7 triệu VNĐ
                                </option>
                                <option value="7 triệu - 10 triệu" {{ ($applicant->mucluong_mongmuon ?? '') == '7 triệu - 10 triệu' ? 'selected' : '' }}>
                                    7 - 10 triệu VNĐ
                                </option>
                                <option value="10 triệu - 12 triệu" {{ ($applicant->mucluong_mongmuon ?? '') == '10 triệu - 12 triệu' ? 'selected' : '' }}>
                                    10 - 12 triệu VNĐ
                                </option>
                                <option value="12 triệu - 15 triệu" {{ ($applicant->mucluong_mongmuon ?? '') == '12 triệu - 15 triệu' ? 'selected' : '' }}>
                                    12 - 15 triệu VNĐ
                                </option>
                                <option value="15 triệu - 20 triệu" {{ ($applicant->mucluong_mongmuon ?? '') == '15 triệu - 20 triệu' ? 'selected' : '' }}>
                                    15 - 20 triệu VNĐ
                                </option>
                                <option value="20 triệu - 25 triệu" {{ ($applicant->mucluong_mongmuon ?? '') == '20 triệu - 25 triệu' ? 'selected' : '' }}>
                                    20 - 25 triệu VNĐ
                                </option>
                                <option value="25 triệu - 30 triệu" {{ ($applicant->mucluong_mongmuon ?? '') == '25 triệu - 30 triệu' ? 'selected' : '' }}>
                                    25 - 30 triệu VNĐ
                                </option>
                                <option value="Trên 30 triệu" {{ ($applicant->mucluong_mongmuon ?? '') == 'Trên 30 triệu' ? 'selected' : '' }}>
                                    Trên 30 triệu VNĐ
                                </option>
                            </select>
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-info-circle me-1"></i>
                                Thông tin này sẽ giúp nhà tuyển dụng biết mức lương bạn đang mong muốn
                            </small>
                        </div>

                        <!-- Display preview -->
                        <div class="mt-4 p-3 bg-light rounded">
                            <p class="mb-2"><strong>Xem trước:</strong></p>
                            <div class="alert alert-success mb-0" id="previewSalary">
                                <i class="bi bi-check-circle me-2"></i>
                                <span id="previewText">Thỏa thuận</span>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary" id="submitMucLuongBtn">
                            <i class="bi bi-check-lg"></i> Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ✅ SCRIPT XỬ LÝ MỨC LƯƠNG -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectEl = document.getElementById('mucluong_mongmuon');
            const previewText = document.getElementById('previewText');

            // Cập nhật preview khi thay đổi select
            if (selectEl) {
                selectEl.addEventListener('change', function() {
                    previewText.textContent = this.value || 'Vui lòng chọn mức lương';
                });

                // Set preview khi load trang
                previewText.textContent = selectEl.value || 'Chưa cập nhật';
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const avatarInput = document.getElementById('avatar');
            const avatarPreview = document.getElementById('avatarPreview');
            const deleteAvatarBtn = document.getElementById('deleteAvatarBtn');

            // ========== PREVIEW AVATAR TRƯỚC KHI UPLOAD ==========
            if (avatarInput) {
                avatarInput.addEventListener('change', function(e) {
                    const file = this.files[0];

                    if (!file) return;

                    // Validate file size (5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('Kích thước ảnh không được vượt quá 5MB!');
                        this.value = '';
                        return;
                    }

                    // Validate file type
                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    if (!validTypes.includes(file.type)) {
                        alert('Chỉ chấp nhận định dạng JPG hoặc PNG!');
                        this.value = '';
                        return;
                    }

                    // Preview ảnh
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        avatarPreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                });
            }

            // ========== XÓA AVATAR ==========
            if (deleteAvatarBtn) {
                deleteAvatarBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    if (confirm('Bạn có chắc muốn xóa ảnh đại diện?')) {
                        // Disable button
                        deleteAvatarBtn.disabled = true;
                        deleteAvatarBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Đang xóa...';

                        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                        fetch('{{ route("applicant.deleteAvatar") }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Đã xóa ảnh đại diện!');
                                    // Reload trang
                                    location.reload();
                                } else {
                                    alert(data.message || 'Lỗi khi xóa ảnh!');
                                    deleteAvatarBtn.disabled = false;
                                    deleteAvatarBtn.innerHTML = '<i class="bi bi-trash"></i> Xóa';
                                }
                            })
                            .catch(error => {
                                console.error('Lỗi:', error);
                                alert('Không thể xóa ảnh. Vui lòng thử lại!');
                                deleteAvatarBtn.disabled = false;
                                deleteAvatarBtn.innerHTML = '<i class="bi bi-trash"></i> Xóa';
                            });
                    }
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const personalLink = document.querySelector('.tab-link-personal');
            const attachmentsLink = document.querySelector('.tab-link-attachments');
            const personalPane = document.getElementById('tab-personal');
            const attachmentsPane = document.getElementById('tab-attachments');

            function showPersonal() {
                if (personalPane) {
                    personalPane.classList.add('show', 'active');
                    personalPane.classList.remove('fade');
                }
                if (attachmentsPane) {
                    attachmentsPane.classList.remove('show', 'active');
                    attachmentsPane.classList.add('fade');
                }
                // Update sidebar active state
                personalLink?.classList.add('active', 'fw-bold', 'text-primary');
                personalLink?.classList.remove('text-dark');
                attachmentsLink?.classList.remove('active', 'fw-bold', 'text-primary');
                attachmentsLink?.classList.add('text-dark');
            }

            function showAttachments() {
                if (attachmentsPane) {
                    attachmentsPane.classList.add('show', 'active');
                    attachmentsPane.classList.remove('fade');
                }
                if (personalPane) {
                    personalPane.classList.remove('show', 'active');
                    personalPane.classList.add('fade');
                }
                // Update sidebar active state
                attachmentsLink?.classList.add('active', 'fw-bold', 'text-primary');
                attachmentsLink?.classList.remove('text-dark');
                personalLink?.classList.remove('active', 'fw-bold', 'text-primary');
                personalLink?.classList.add('text-dark');
            }

            // Click handlers for sidebar
            personalLink?.addEventListener('click', function(e) {
                e.preventDefault();
                showPersonal();
            });

            attachmentsLink?.addEventListener('click', function(e) {
                e.preventDefault();
                showAttachments();
            });

            // Auto-activate based on hash
            if (window.location.hash === '#tab-attachments') {
                showAttachments();
            } else {
                showPersonal();
            }
        });
    </script>
    @include('applicant.partials.footer')
</body>

</html>