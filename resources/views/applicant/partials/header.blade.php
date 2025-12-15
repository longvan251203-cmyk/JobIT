<header id="header" class="header">
    <div class="header-container">
        <a href="{{ route('applicant.dashboard') }}" class="logo">
            <img src="https://cdn-icons-png.flaticon.com/512/3281/3281289.png" alt="">
            <h1 class="sitename">Job-IT</h1>
        </a>

        <button class="hamburger" id="hamburger" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ route('applicant.dashboard') }}" class="active">Trang chủ</a></li>
                <li><a href="#jobs-section">Việc làm</a></li>
                <li><a href="#companies-section">Công ty</a></li>
                <li><a href="#blog-section">Blog</a></li>
            </ul>
        </nav>

        <div class="header-actions">
            @if(!Auth::check())
            <a class="btn-login" href="{{ route('login') }}">Đăng nhập</a>
            @else

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

            <a class="btn-my-jobs" href="{{ route('applicant.myJobs') }}">
                <i class="bi bi-briefcase-fill"></i>
                Việc Làm Của Tôi
            </a>

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

                <div id="notificationDropdown" class="position-absolute" style="top: calc(100% + 8px); right: 0; width: 500px; background: white; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); border: 1px solid #e5e7eb; z-index: 1000; max-height: 600px; display: none; flex-direction: column;">
                    <div style="padding: 1.25rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                        <h3 style="margin: 0; font-size: 1.2rem; font-weight: 700; color: #1f2937;">Thông báo</h3>
                        <button id="btnMarkAllRead" style="background: none; border: none; color: #667eea; font-size: 0.8rem; font-weight: 600; cursor: pointer;">Đánh dấu tất cả đã đọc</button>
                    </div>

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
                    <img src="{{ asset('assets/img/user.png') }}" alt="" class="user-avatar">
                    <span class="user-name">{{ Auth::user()->applicant->hoten_uv ?? Auth::user()->email }}</span>
                    <i class="bi bi-chevron-down"></i>
                </button>
                <ul class="user-dropdown-menu" id="userDropdownMenu">
                    <li><a href="{{ route('applicant.profile') }}"><i class="bi bi-person"></i> Hồ sơ</a></li>
                    <li><a href="#"><i class="bi bi-info-circle"></i> Thông tin cá nhân</a></li>
                    <li><a href="#"><i class="bi bi-file-earmark-text"></i> Hồ sơ Đính kèm</a></li>
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

    <style>
        /* ============================================================
           RESPONSIVE HEADER STYLES - MOBILE FIRST
           ============================================================ */

        body {
            padding-top: 70px;
        }

        /* Mobile: 320px - 575px */
        .header-container {
            max-width: 100%;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem 0.75rem;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .header .logo {
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            flex-shrink: 0;
        }

        .header .logo img {
            height: 32px;
            width: 32px;
            object-fit: cover;
        }

        .header .logo .sitename {
            font-size: 1rem;
            margin: 0;
            color: var(--heading-color, #012970);
            font-weight: 700;
            white-space: nowrap;
        }

        #navmenu {
            display: none;
        }

        #navmenu.active {
            display: flex;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            flex-direction: column;
            width: 100%;
            border-top: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 999;
        }

        .navmenu ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .navmenu li {
            border-bottom: 1px solid #f3f4f6;
        }

        .navmenu a {
            display: block;
            color: var(--nav-color, #012970);
            padding: 12px 1rem;
            font-weight: 500;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .navmenu a.active {
            color: var(--nav-hover-color, #667eea);
            background-color: #f0f4ff;
        }

        /* Hamburger menu for mobile */
        .hamburger {
            display: flex;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            border: none;
            background: none;
            padding: 0;
            z-index: 1001;
        }

        .hamburger span {
            width: 24px;
            height: 2px;
            background-color: #1f2937;
            border-radius: 1px;
            transition: all 0.3s ease;
        }

        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(8px, 8px);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            width: 100%;
            justify-content: flex-end;
        }

        .btn-login {
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            text-decoration: none;
            font-size: 0.9rem;
            white-space: nowrap;
        }

        .btn-my-jobs {
            display: none;
        }

        .btn-recommendations {
            display: none;
        }

        .btn-recommendations span {
            display: none;
        }

        .btn-recommendations .badge-count {
            background: #ef4444;
            color: #fff;
            padding: 2px 6px;
            border-radius: 999px;
            font-size: 0.7rem;
            margin-left: 6px;
        }

        .user-dropdown {
            position: relative;
        }

        .user-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 4px 8px;
            border-radius: 8px;
            background: transparent;
            border: none;
            cursor: pointer;
        }

        .user-name {
            display: none;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            object-fit: cover;
            border-radius: 50%;
        }

        .user-dropdown-menu {
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
            padding: 8px 0;
            min-width: 200px;
            display: none;
            z-index: 1000;
        }

        .user-dropdown-menu a,
        .user-dropdown-menu button {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            padding: 10px 1rem;
            border: none;
            background: none;
            color: #6b7280;
            text-decoration: none;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .user-dropdown-menu a:hover,
        .user-dropdown-menu button:hover {
            background-color: #f3f4f6;
            color: #667eea;
        }

        .user-dropdown-menu .divider {
            border-top: 1px solid #e5e7eb;
            margin: 4px 0;
        }

        .user-dropdown:hover .user-dropdown-menu {
            display: block;
        }

        #notificationDropdown {
            display: none !important;
            width: calc(100vw - 16px) !important;
            max-width: 450px !important;
            top: calc(100% + 8px) !important;
            right: auto !important;
            left: 0 !important;
        }

        #notificationDropdown.show {
            display: flex !important;
        }

        /* ============================================================
           TABLET BREAKPOINT (576px+)
           ============================================================ */
        @media (min-width: 576px) {
            body {
                padding-top: 80px;
            }

            .header-container {
                padding: 0.75rem 1rem;
                gap: 1rem;
            }

            .header .logo img {
                height: 36px;
                width: 36px;
            }

            .header .logo .sitename {
                font-size: 1.2rem;
            }

            .user-avatar {
                width: 34px;
                height: 34px;
            }

            .btn-recommendations {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 8px 12px;
                border-radius: 10px;
                background: linear-gradient(135deg, #667eea, #764ba2);
                color: #fff;
                font-weight: 600;
                font-size: 0.85rem;
            }

            .btn-recommendations span {
                display: inline;
            }

            #notificationDropdown {
                width: 450px !important;
                right: 0 !important;
                left: auto !important;
            }
        }

        /* ============================================================
           MEDIUM TABLET (768px+)
           ============================================================ */
        @media (min-width: 768px) {
            body {
                padding-top: 90px;
            }

            .header-container {
                padding: 0 1.5rem;
                gap: 1.5rem;
                flex-wrap: nowrap;
            }

            .hamburger {
                display: none;
            }

            #navmenu {
                display: flex !important;
                position: static;
                border: none;
                box-shadow: none;
                background: transparent;
            }

            .navmenu ul {
                flex-direction: row;
                gap: 0.5rem;
            }

            .navmenu li {
                border: none;
            }

            .navmenu a {
                padding: 8px 12px;
                font-size: 1rem;
            }

            .header .logo .sitename {
                font-size: 1.3rem;
            }

            .btn-recommendations {
                display: inline-flex;
            }

            .btn-my-jobs {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 8px 12px;
                border-radius: 10px;
                background: transparent;
                border: 1px solid #d1d5db;
                color: #1f2937;
                font-weight: 500;
                text-decoration: none;
                font-size: 0.9rem;
                transition: all 0.2s ease;
            }

            .btn-my-jobs:hover {
                background-color: #f3f4f6;
                border-color: #9ca3af;
            }

            .user-name {
                display: inline;
                font-size: 0.9rem;
            }

            .header-actions {
                width: auto;
            }

            #notificationDropdown {
                width: 500px !important;
            }
        }

        /* ============================================================
           DESKTOP (992px+)
           ============================================================ */
        @media (min-width: 992px) {
            .header-container {
                max-width: 1200px;
                padding: 0 2rem;
            }

            .header .logo img {
                height: 40px;
                width: 40px;
            }

            .header .logo .sitename {
                font-size: 1.4rem;
            }

            .navmenu a {
                padding: 12px 16px;
                font-size: 1.05rem;
            }

            .btn-recommendations {
                padding: 10px 14px;
                font-size: 0.95rem;
            }

            .btn-my-jobs {
                padding: 10px 14px;
                font-size: 0.95rem;
            }

            .user-avatar {
                width: 36px;
                height: 36px;
            }
        }

        /* ============================================================
           LANDSCAPE MODE
           ============================================================ */
        @media (orientation: landscape) and (max-height: 600px) {
            body {
                padding-top: 56px;
            }

            .header-container {
                padding: 0.25rem 0.75rem;
                gap: 0.5rem;
            }

            .header .logo .sitename {
                font-size: 0.9rem;
            }

            .user-avatar {
                width: 28px;
                height: 28px;
            }

            .navmenu a {
                padding: 6px 10px;
                font-size: 0.85rem;
            }

            .btn-recommendations span {
                display: none;
            }
        }

        /* ============================================================
           DARK MODE
           ============================================================ */
        @media (prefers-color-scheme: dark) {
            .header-container {
                background: #1f2937;
            }

            .header .logo .sitename {
                color: #f3f4f6;
            }

            .navmenu a {
                color: #e5e7eb;
            }

            .navmenu a.active {
                color: #a5b4fc;
                background-color: #374151;
            }

            .user-dropdown-menu {
                background: #374151;
            }

            .user-dropdown-menu a,
            .user-dropdown-menu button {
                color: #d1d5db;
            }

            .user-dropdown-menu a:hover,
            .user-dropdown-menu button:hover {
                background-color: #4b5563;
                color: #a5b4fc;
            }

            .hamburger span {
                background-color: #f3f4f6;
            }

            #navmenu.active {
                background: #1f2937;
            }
        }
    </style>

    <script>
        // Hamburger menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.querySelector('.hamburger');
            const navmenu = document.getElementById('navmenu');

            if (hamburger) {
                hamburger.addEventListener('click', function() {
                    this.classList.toggle('active');
                    navmenu.classList.toggle('active');
                });

                // Close menu when link clicked
                const navLinks = navmenu.querySelectorAll('a');
                navLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        hamburger.classList.remove('active');
                        navmenu.classList.remove('active');
                    });
                });
            }

            // Notification dropdown toggle
            const btnNotifications = document.getElementById('btnNotifications');
            const notificationDropdown = document.getElementById('notificationDropdown');

            if (btnNotifications && notificationDropdown) {
                btnNotifications.addEventListener('click', function(e) {
                    e.stopPropagation();
                    notificationDropdown.classList.toggle('show');
                });

                document.addEventListener('click', function(e) {
                    if (!e.target.closest('.position-relative') && notificationDropdown) {
                        notificationDropdown.classList.remove('show');
                    }
                });
            }
        });
    </script>
</header>