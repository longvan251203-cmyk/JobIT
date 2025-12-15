<!DOCTYPE html>
<html lang="vi">

<head>
    <meta name="user-authenticated" content="{{ Auth::check() ? 'true' : 'false' }}">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/homeapp.css') }}" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>{{ $job->title ?? 'Chi tiết công việc' }} - JobIT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
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
   MODAL ỨNG TUYỂN STYLES - GIỐNG HOMEAPP
======================================== */

        /* Modal Dialog Size */
        .modal-apply-job .modal-dialog {
            max-height: 90vh;
            margin: 1.75rem auto;
            max-width: 900px !important;
            width: 90% !important;
        }

        /* Modal Content */
        .modal-apply-job .modal-content {
            border-radius: 24px;
            border: none;
            overflow: hidden;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            z-index: 10001 !important;
            pointer-events: auto !important;
        }

        /* Modal Header */
        .modal-apply-job .modal-header {
            background: linear-gradient(135deg, #4f46e5, #06b6d4);
            color: white;
            border: none;
            padding: 1.5rem;
            flex-shrink: 0;
        }

        .modal-apply-job .modal-title {
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }

        .modal-apply-job .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        .modal-apply-job .btn-close:hover {
            opacity: 1;
        }

        /* Modal Body with Scrollbar */
        .modal-apply-job .modal-body {
            overflow-y: auto;
            max-height: calc(90vh - 180px);
            flex: 1;
            padding: 2rem;
        }

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

        /* Modal Footer */
        .modal-apply-job .modal-footer {
            flex-shrink: 0;
            border-top: 1px solid #e5e7eb;
            padding: 1.5rem 2rem;
        }

        /* CV Options */
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

        /* Upload Area */
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

        /* Profile Preview Card */
        .profile-preview-card {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-radius: 16px;
            padding: 1.5rem;
            border: 2px solid #e5e7eb;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .profile-info {
            margin-left: 1rem;
        }

        .profile-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        .profile-title {
            color: #6b7280;
            font-size: 0.95rem;
            margin-bottom: 0.75rem;
        }

        .profile-contact {
            display: flex;
            gap: 1rem;
            margin-top: 0.75rem;
            flex-wrap: wrap;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #4b5563;
            font-size: 0.85rem;
        }

        .contact-item i {
            color: #4f46e5;
            width: 16px;
        }

        /* Form Controls */
        .modal-apply-job .form-control,
        .modal-apply-job .form-select {
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .modal-apply-job .form-control:focus,
        .modal-apply-job .form-select:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .modal-apply-job .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .required-mark {
            color: #ef4444;
            margin-left: 0.25rem;
        }

        /* Letter Textarea */
        .letter-textarea {
            min-height: 150px;
            resize: vertical;
        }

        .char-count {
            text-align: right;
            color: #9ca3af;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        /* Buttons */
        .modal-apply-job .btn-submit-apply {
            background: linear-gradient(135deg, #4f46e5, #06b6d4);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
        }

        .modal-apply-job .btn-submit-apply:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.3);
        }

        .modal-apply-job .btn-submit-apply:disabled {
            background: #9ca3af;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .modal-apply-job .btn-cancel {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            background: white;
            color: #374151;
        }

        .modal-apply-job .btn-cancel:hover {
            border-color: #cbd5e1;
            background: #f9fafb;
        }

        /* Z-Index Fix */
        .modal-apply-job {
            z-index: 9999 !important;
        }

        .modal-backdrop {
            z-index: 9998 !important;
        }

        body.modal-open {
            overflow: hidden !important;
            padding-right: 0 !important;
        }

        /* Animation */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .content-section {
            animation: slideInUp 0.4s ease-out;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .modal-apply-job .modal-dialog {
                max-width: 95% !important;
                width: 95% !important;
                margin: 1rem auto;
            }

            .modal-apply-job .modal-header,
            .modal-apply-job .modal-body,
            .modal-apply-job .modal-footer {
                padding: 1rem;
            }

            .cv-option-card {
                padding: 1rem;
            }

            .cv-option-icon {
                width: 48px;
                height: 48px;
                font-size: 1.25rem;
            }

            .upload-area {
                padding: 1.5rem 1rem;
            }

            .profile-avatar {
                width: 60px;
                height: 60px;
            }

            .profile-contact {
                flex-direction: column;
                gap: 0.5rem;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            .modal-apply-job .modal-dialog {
                max-width: 750px !important;
                width: 85% !important;
            }
        }

        @media (min-width: 992px) {
            .modal-apply-job .modal-dialog {
                max-width: 900px !important;
                width: 80% !important;
            }
        }

        @media (min-width: 1200px) {
            .modal-apply-job .modal-dialog {
                max-width: 1000px !important;
                width: 75% !important;
            }
        }

        /* ========================================
   2 NÚT CHẤP NHẬN/TỪ CHỐI LỜI MỜI
======================================== */
        .invitation-response-buttons {
            display: flex;
            gap: 0.75rem;
            width: 100%;
        }

        .invitation-response-buttons .btn {
            padding: 0.75rem 1.5rem;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            flex: 1;
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
            margin-right: 0.5rem;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans antialiased">

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

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
        <div class="lg:flex lg:space-x-8">

            <div class="lg:w-2/3 space-y-8">
                <div class="bg-white p-6 sm:p-8 rounded-xl job-detail-card">
                    <div class="flex items-start space-x-6">
                        <div class="flex-shrink-0">
                            <div class="company-logo-small">
                                @if($job->company && $job->company->logo)
                                <img src="{{ asset('assets/img/' . $job->company->logo) }}" alt="Company Logo" />
                                @else
                                <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667EEA, #764BA2); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                    {{ substr($job->company->tencty ?? 'C', 0, 1) }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex-grow">
                            <h1 class="text-3xl font-extrabold text-gray-900 mb-1 job-title">
                                {{ $job->title ?? 'Senior Front-end Developer (React/Vue)' }}
                            </h1>
                            <a href="{{ route('company.profile', $company->companies_id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-lg company-link">
                                {{ $company->tencty ?? 'Công ty TNHH Phần mềm ABC' }}
                            </a>
                            <div class="flex items-center text-gray-500 text-sm mt-2 space-x-4">
                                <span class="flex items-center"><i class="fas fa-map-marker-alt mr-2"></i>{{ $job->location ?? 'TP. Hồ Chí Minh' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between border-t pt-6">
                        <div class="text-xl font-bold text-indigo-600 mb-4 sm:mb-0 salary-badge">
                            Mức lương: <span class="text-2xl">{{ $job->salary ?? '15 - 30 Triệu VNĐ' }}</span>
                        </div>
                        <button id="openApplyModal"
                            class="bg-indigo-600 text-white font-semibold py-3 px-8 rounded-lg hover:bg-indigo-700 transition duration-300 transform hover:scale-105 shadow-lg apply-button"
                            @if(Auth::check())
                            data-bs-toggle="modal"
                            data-bs-target="#applyJobModal"
                            @endif
                            data-job-id="{{ $job->job_id }}">
                            <i class="fas fa-paper-plane mr-2"></i> Ứng Tuyển Ngay
                        </button>
                    </div>
                </div>

                <div class="bg-white p-6 sm:p-8 rounded-xl job-detail-card content-section">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-3">Chi Tiết Công Việc</h2>

                    <section id="description">
                        <h3>Mô Tả Công Việc</h3>
                        <div class="text-gray-700 leading-relaxed">
                            {!! $job->description ?? '<p>Phát triển và duy trì các thành phần giao diện người dùng bằng React/Vue.js. Đảm bảo tính nhất quán và hiệu suất của ứng dụng web.</p>
                            <ul>
                                <li>Tham gia vào quá trình thiết kế, phát triển và thử nghiệm các tính năng mới.</li>
                                <li>Làm việc với đội ngũ Back-end để tích hợp các API.</li>
                                <li>Tối ưu hóa ứng dụng để đạt hiệu suất cao nhất trên nhiều thiết bị.</li>
                                <li>Nghiên cứu và áp dụng các công nghệ Front-end mới nhất.</li>
                            </ul>
                            <p>Đây là một vị trí quan trọng, đòi hỏi kinh nghiệm thực chiến và khả năng tự học cao.</p>' !!}
                        </div>
                    </section>

                    <section id="requirements">
                        <h3>Yêu Cầu Công Việc</h3>
                        <div class="text-gray-700 leading-relaxed">
                            {!! $job->requirements ?? '<ul>
                                <li>Có ít nhất 3 năm kinh nghiệm làm việc với Front-end Development.</li>
                                <li>Thành thạo một trong các framework: **ReactJS** (ưa tiên), VueJS hoặc Angular.</li>
                                <li>Nắm vững HTML5, CSS3 (SASS/LESS), và JavaScript (ES6+).</li>
                                <li>Kinh nghiệm làm việc với RESTful APIs và Git.</li>
                                <li>Tư duy logic tốt, khả năng giải quyết vấn đề độc lập.</li>
                            </ul>' !!}
                        </div>
                    </section>

                    <section id="benefits">
                        <h3>Quyền Lợi</h3>
                        <div class="text-gray-700 leading-relaxed">
                            {!! $job->benefits ?? '<p>Chúng tôi cam kết mang đến một môi trường làm việc lý tưởng:</p>
                            <ul>
                                <li>Lương tháng 13, thưởng hiệu suất công việc (lên đến 3 tháng lương).</li>
                                <li>Bảo hiểm y tế, xã hội đầy đủ theo quy định nhà nước và bảo hiểm sức khỏe cá nhân cao cấp.</li>
                                <li>Cơ hội làm việc với các dự án lớn, công nghệ mới.</li>
                                <li>Văn phòng làm việc hiện đại, có khu giải trí, phòng gym.</li>
                                <li>Nghỉ phép 15 ngày/năm, du lịch công ty hàng năm.</li>
                            </ul>' !!}
                        </div>
                    </section>
                </div>
            </div>

            <div class="lg:w-1/3 mt-8 lg:mt-0 space-y-8">

                <div class="bg-white p-6 rounded-xl job-detail-card info-card">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Thông Tin Chung</h3>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex items-center"><i
                                class="fas fa-dollar-sign w-5 text-center text-indigo-500 mr-3"></i>
                            <span class="font-semibold">Mức lương:</span> <span class="ml-auto">{{ $job->salary ?? '15 - 30 Triệu VNĐ' }}</span>
                        </li>
                        <li class="flex items-center"><i
                                class="fas fa-briefcase w-5 text-center text-indigo-500 mr-3"></i>
                            <span class="font-semibold">Kinh nghiệm:</span> <span class="ml-auto">{{ $job->experience ?? '3+ Năm' }}</span>
                        </li>
                        <li class="flex items-center"><i
                                class="fas fa-user-tie w-5 text-center text-indigo-500 mr-3"></i>
                            <span class="font-semibold">Cấp bậc:</span> <span class="ml-auto">{{ $job->level ?? 'Nhân viên/Chuyên gia' }}</span>
                        </li>
                        <li class="flex items-center"><i
                                class="fas fa-handshake w-5 text-center text-indigo-500 mr-3"></i>
                            <span class="font-semibold">Hình thức:</span> <span class="ml-auto">{{ $job->working_type ?? 'Toàn thời gian' }}</span>
                        </li>
                        <li class="flex items-center"><i
                                class="fas fa-users w-5 text-center text-indigo-500 mr-3"></i>
                            <span class="font-semibold">Số lượng:</span> <span class="ml-auto">{{ $job->quantity ?? '5 người' }}</span>
                        </li>
                        <li class="flex items-center"><i
                                class="fas fa-calendar-alt w-5 text-center text-indigo-500 mr-3"></i>
                            <span class="font-semibold">Hạn nộp:</span> <span class="ml-auto">{{ $job->deadline ?? '30/12/2025' }}</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-white p-6 rounded-xl job-detail-card info-card">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Thông Tin Công Ty</h3>
                    <div class="flex items-center mb-4">
                        <img class="w-12 h-12 rounded-full object-cover mr-4"
                            src="{{ $company->logo_url ?? 'https://via.placeholder.com/50?text=Logo' }}"
                            alt="{{ $company->tencty ?? 'Tên công ty' }}">
                        <a href="{{ route('company.profile', $company->companies_id) }}"
                            class="text-lg font-semibold text-indigo-600 hover:text-indigo-800">
                            {{ $company->tencty ?? 'Công ty TNHH Phần mềm ABC' }}
                        </a>
                    </div>
                    <ul class="space-y-3 text-gray-700 text-sm">
                        <li class="flex items-center"><i
                                class="fas fa-building w-5 text-center text-gray-500 mr-3"></i>
                            <span class="font-semibold">Quy mô:</span> <span class="ml-auto">{{ $company->scale ?? '100 - 500 nhân viên' }}</span>
                        </li>
                        <li class="flex items-center"><i
                                class="fas fa-map-marked-alt w-5 text-center text-gray-500 mr-3"></i>
                            <span class="font-semibold">Địa chỉ:</span> <span class="ml-auto text-right">{{ $company->address ?? 'Lầu 5, Tòa nhà Bitexco, Q.1, TP.HCM' }}</span>
                        </li>
                        <li class="flex items-center"><i
                                class="fas fa-globe w-5 text-center text-gray-500 mr-3"></i>
                            <span class="font-semibold">Website:</span> <a href="{{ $company->website ?? '#' }}" target="_blank"
                                class="ml-auto text-indigo-500 hover:text-indigo-700 truncate">{{ $company->website ?? 'abcsoftware.com' }}</a>
                        </li>
                    </ul>
                    <a href="{{ route('company.profile', $company->companies_id) }}"
                        class="block mt-4 text-center text-sm font-medium text-indigo-600 hover:text-indigo-800 border border-indigo-200 rounded-lg py-2 transition duration-300">
                        Xem trang công ty
                    </a>
                </div>
            </div>
        </div>

        <section class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Công Việc Liên Quan Khác</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedJobs ?? [] as $relatedJob)
                <a href="{{ route('job.detail', $relatedJob->job_id) }}" class="bg-white p-5 rounded-xl job-detail-card related-job-card block hover:shadow-xl">
                    <div class="flex items-start space-x-4">
                        <img class="w-10 h-10 rounded-lg object-cover"
                            src="{{ $relatedJob->company->logo_url ?? 'https://via.placeholder.com/40?text=Logo' }}" alt="Related Company Logo">
                        <div>
                            <h4 class="text-base font-semibold text-gray-900 truncate">{{ $relatedJob->title }}</h4>
                            <p class="text-sm text-indigo-600">{{ $relatedJob->company->tencty }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $relatedJob->salary }} | {{ $relatedJob->location }}</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </section>

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
                    <input type="hidden" name="job_id" id="modalJobId" value="{{ $job->job_id }}">
                    <input type="hidden" name="invitation_id" id="modalInvitationId" value="">
                    <input type="hidden" name="accept_invitation" id="modalAcceptInvitation" value="0">

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
                                    $applicant = Auth::check() ? Auth::user()->applicant : null;
                                    @endphp
                                    <img src="{{ $applicant && $applicant->avatar ? asset('assets/img/avt/'.$applicant->avatar) : asset('assets/img/avt/default-avatar.png') }}"
                                        alt="Avatar" class="profile-avatar">
                                    <div class="profile-info flex-grow-1">
                                        <div class="profile-name">{{ $applicant->hoten_uv ?? 'Họ tên ứng viên' }}</div>
                                        <div class="profile-title">{{ $applicant->vitritungtuyen ?? 'Chức danh' }}</div>
                                        <div class="profile-contact">
                                            <div class="contact-item">
                                                <i class="bi bi-envelope"></i>
                                                <span>{{ Auth::check() ? Auth::user()->email : 'Email' }}</span>
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
                                    @if(Auth::check())
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('applicant.hoso') }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                            <i class="bi bi-pencil me-1"></i>Chỉnh sửa
                                        </a>
                                    </div>
                                    @endif
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
                                    value="{{ Auth::check() ? Auth::user()->email : '' }}" required>
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

    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center">
            <p>&copy; 2025 JobIT. All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

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

            // ========== CHECK AUTH ==========
            function checkAuth() {
                const isLoggedIn = document.querySelector('meta[name="user-authenticated"]');
                return isLoggedIn && isLoggedIn.content === 'true';
            }

            // ========== CẬP NHẬT NÚT ỨNG TUYỂN ==========
            function updateApplyButton(button, hasApplied, isInvited = false, invitationStatus = null, invitationId = null) {
                if (!button) return;

                console.log(`🔍 updateApplyButton:`, {
                    hasApplied,
                    isInvited,
                    invitationStatus,
                    invitationId
                });

                // ✅ XỬ LÝ LỜI MỜI PENDING: HIỂN THỊ 2 NÚT
                if (isInvited && invitationStatus === 'pending') {
                    console.log(`🎯 Creating 2 invitation buttons (Accept/Reject)`);

                    // Tìm container để thay thế
                    const buttonParent = button.parentElement;
                    if (!buttonParent) return;

                    // Xóa group nút cũ nếu có
                    const oldGroup = buttonParent.querySelector('.invitation-response-buttons');
                    if (oldGroup) {
                        oldGroup.remove();
                    }

                    // Ẩn button chính
                    button.style.display = 'none';

                    // Tạo wrapper chứa 2 nút
                    const wrapper = document.createElement('div');
                    wrapper.className = 'invitation-response-buttons';
                    const jobId = button.getAttribute('data-job-id');

                    // Tạo nút Chấp nhận
                    const acceptBtn = document.createElement('button');
                    acceptBtn.type = 'button';
                    acceptBtn.className = 'btn btn-success';
                    acceptBtn.setAttribute('data-invitation-id', invitationId);
                    acceptBtn.setAttribute('data-job-id', jobId);
                    acceptBtn.innerHTML = '<i class="bi bi-check-lg"></i><span>Chấp nhận</span>';

                    // Tạo nút Từ chối
                    const rejectBtn = document.createElement('button');
                    rejectBtn.type = 'button';
                    rejectBtn.className = 'btn btn-danger';
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
                    button.parentElement.insertBefore(wrapper, button.nextSibling);
                    return;
                }

                // ✅ Xóa group nút nếu chuyển từ pending sang trạng thái khác
                const buttonParent = button.parentElement;
                if (buttonParent) {
                    const oldGroup = buttonParent.querySelector('.invitation-response-buttons');
                    if (oldGroup) oldGroup.remove();
                }

                // Hiển thị nút chính lại
                button.style.display = '';

                const icon = button.querySelector('i');

                if (isInvited && invitationStatus === 'accepted') {
                    button.classList.add('applied');
                    button.disabled = true;
                    button.title = 'Bạn đã chấp nhận lời mời';

                    if (icon) {
                        icon.classList.remove('bi-send-fill', 'fa-paper-plane');
                        icon.classList.add('bi-check-circle-fill');
                    }

                    button.childNodes.forEach(node => {
                        if (node.nodeType === Node.TEXT_NODE) {
                            node.remove();
                        }
                    });
                    button.appendChild(document.createTextNode('Đã chấp nhận'));

                } else if (isInvited && invitationStatus === 'rejected') {
                    button.classList.add('applied');
                    button.disabled = true;
                    button.title = 'Bạn đã từ chối lời mời';

                    if (icon) {
                        icon.classList.remove('bi-send-fill', 'fa-paper-plane');
                        icon.classList.add('bi-x-circle-fill');
                    }

                    button.childNodes.forEach(node => {
                        if (node.nodeType === Node.TEXT_NODE) {
                            node.remove();
                        }
                    });
                    button.appendChild(document.createTextNode('Đã từ chối'));

                } else if (hasApplied) {
                    button.classList.add('applied');
                    button.disabled = true;
                    button.title = 'Bạn đã ứng tuyển công việc này';

                    if (icon) {
                        icon.classList.remove('bi-send-fill', 'fa-paper-plane', 'bi-x-circle-fill');
                        icon.classList.add('bi-check-circle-fill');
                    }

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
                        icon.classList.remove('bi-check-circle-fill', 'bi-x-circle-fill');
                        icon.classList.add('bi-send-fill', 'fa-paper-plane');
                    }

                    button.childNodes.forEach(node => {
                        if (node.nodeType === Node.TEXT_NODE) {
                            node.remove();
                        }
                    });
                    button.appendChild(document.createTextNode('Ứng tuyển ngay'));
                }
            }

            // ========== ĐỒNG BỘ NÚT ỨNG TUYỂN ==========
            function syncApplyButtons(jobId, hasApplied, isInvited = false, invitationStatus = null, invitationId = null) {
                console.log(`🔍 syncApplyButtons called:`, {
                    jobId,
                    hasApplied,
                    isInvited,
                    invitationStatus,
                    invitationId
                });

                // Detail view - tìm nút bằng ID
                const detailBtn = document.getElementById('openApplyModal');
                console.log(`🔎 Looking for button #openApplyModal:`, detailBtn);

                if (detailBtn) {
                    const btnJobId = detailBtn.getAttribute('data-job-id');
                    console.log(`✅ Found button with data-job-id="${btnJobId}", comparing with jobId="${jobId}"`);

                    // ✅ CẬP NHẬT NÚT CHO JOB HIỆN TẠI
                    if (btnJobId == jobId) {
                        console.log(`✅ Job IDs match! Updating button...`);
                        updateApplyButton(detailBtn, hasApplied, isInvited, invitationStatus, invitationId);
                    } else {
                        console.log(`⚠️ Job IDs don't match, skipping: "${btnJobId}" !== "${jobId}"`);
                    }
                } else {
                    console.log(`❌ Button not found`);
                }

                // Grid view nếu có
                const gridCard = document.querySelector(`.job-card-grid[data-job-id="${jobId}"]`);
                if (gridCard) {
                    const gridBtn = gridCard.querySelector('.btn-apply-now');
                    if (gridBtn) updateApplyButton(gridBtn, hasApplied, isInvited, invitationStatus, invitationId);
                }
            }

            // ========== KIỂM TRA TRẠNG THÁI ỨNG TUYỂN + LỜI MỜI ==========
            function checkApplicationStatus(jobId) {
                if (!checkAuth()) {
                    console.log('❌ User not authenticated');
                    return;
                }

                console.log(`🔍 checkApplicationStatus for jobId:`, jobId);

                fetch(`/api/jobs/${jobId}/check-application`, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(`📦 checkApplicationStatus response:`, data);
                        if (data.success) {
                            // ✅ Truyền ĐẦY ĐỦ parameters cho syncApplyButtons
                            syncApplyButtons(
                                jobId,
                                data.applied || false,
                                data.invited || false,
                                data.invitation_status || null,
                                data.invitation_id || null
                            );
                        }
                    })
                    .catch(error => {
                        console.error('❌ Error checking application status:', error);
                    });
            }

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

            // ========== XỬ LÝ NÚT APPLY ==========
            const openApplyModal = document.getElementById('openApplyModal');

            if (openApplyModal) {
                openApplyModal.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    if (!checkAuth()) {
                        showToast('Vui lòng đăng nhập để ứng tuyển!', 'error');
                        setTimeout(() => window.location.href = '/login', 1500);
                        return;
                    }

                    const jobId = this.getAttribute('data-job-id');
                    const modalJobIdInput = document.getElementById('modalJobId');
                    if (modalJobIdInput && jobId) {
                        modalJobIdInput.value = jobId;
                    }
                });
            }

            // ✅ XỬ LÝ CHẤP NHẬN LỜI MỜI
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
                showToast('📋 Vui lòng hoàn tất thông tin ứng tuyển để gửi hồ sơ', 'info');
                const modal = new bootstrap.Modal(document.getElementById('applyJobModal'));
                modal.show();
            };

            // ✅ XỬ LÝ TỪ CHỐI LỜI MỜI
            window.handleRejectInvitationButton = function(button, event) {
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
                respondToInvitation(invitationId, 'rejected', jobId, null);
            };

            // ✅ HÀM LÝ API TỪ CHỐI/CHẤP NHẬN LỜI MỜI
            function respondToInvitation(invitationId, response, jobId, modal = null) {
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

                            // ✅ Cập nhật nút ngay lập tức (thay vì reload)
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

            // ========== XỬ LÝ CV TYPE SELECTION ==========
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

            // ========== FILE UPLOAD ==========
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
            const letterTextarea = document.querySelector('.letter-textarea');
            const charCount = document.getElementById('charCount');

            if (letterTextarea) {
                letterTextarea.addEventListener('input', function() {
                    charCount.textContent = this.value.length;
                });
                charCount.textContent = letterTextarea.value.length;
            }

            // ========== FORM SUBMIT ==========
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
                                    respondToInvitation(invitationId, 'accepted', jobId, null);
                                }

                                // ✅ CẬP NHẬT NÚT NGAY - Gọi checkApplicationStatus để lấy data đầy đủ
                                checkApplicationStatus(jobId);

                                // Đóng modal
                                const modal = bootstrap.Modal.getInstance(document.getElementById('applyJobModal'));
                                if (modal) modal.hide();

                                // Reset form
                                applyJobForm.reset();
                                document.getElementById('modalInvitationId').value = '';
                                document.getElementById('modalAcceptInvitation').value = '0';

                                // Reset file
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

            // ========== RESET MODAL KHI ĐÓNG ==========
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

            // ========== KHỞI TẠO - CHECK APPLICATION STATUS ==========
            const jobButton = document.querySelector('[data-job-id]');
            if (jobButton) {
                const jobId = jobButton.getAttribute('data-job-id');
                console.log(`🎯 Initializing with jobId:`, jobId);

                // ✅ Check application status (bao gồm cả invitation)
                checkApplicationStatus(jobId);
            } else {
                console.log('❌ No job button found on page');
            }

            console.log('✅ Job Detail Script Initialized');
        });
    </script>
    <!-- ✅ THÊM DÒNG NÀY -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>