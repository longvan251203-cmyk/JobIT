<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobIT - Nền tảng việc làm IT hàng đầu</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

        :root {
            --primary: #4F46E5;
            --primary-dark: #4338CA;
            --primary-light: #6366F1;
            --secondary: #06B6D4;
            --accent: #F59E0B;
            --success: #10B981;
            --danger: #EF4444;
            --dark: #0F172A;
            --gray: #64748B;
            --light-bg: #F8FAFC;
            --white: #FFFFFF;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 50px rgba(0, 0, 0, 0.15);
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-hero: linear-gradient(135deg, rgba(79, 70, 229, 0.03) 0%, rgba(99, 102, 241, 0.03) 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--dark);
            background: var(--white);
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* ===== HEADER ===== */
        .header {
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            padding: 1rem 0;
        }

        .header.scrolled {
            padding: 0.7rem 0;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            text-decoration: none;
            font-size: 1.6rem;
            font-weight: 800;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .nav-link {
            color: var(--dark);
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.5rem 1rem;
            position: relative;
            transition: color 0.3s;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary);
            transform: translateX(-50%);
            transition: width 0.3s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary);
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 80%;
        }

        .btn-header {
            padding: 0.6rem 1.5rem;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-outline-header {
            border: 2px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }

        .btn-outline-header:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        .btn-primary-header {
            background: var(--gradient-primary);
            color: white;
            border: none;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }

        .btn-primary-header:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(79, 70, 229, 0.4);
            color: white;
        }

        /* ===== HERO ===== */
        .hero {
            padding: 180px 0 120px;
            background: var(--gradient-hero);
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, transparent 70%);
            animation: float 25s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg);
            }

            33% {
                transform: translate(30px, -30px) rotate(120deg);
            }

            66% {
                transform: translate(-20px, 20px) rotate(240deg);
            }
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 900;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            letter-spacing: -0.03em;
        }

        .hero .gradient-text {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 1.25rem;
            color: var(--gray);
            margin-bottom: 2.5rem;
            max-width: 600px;
        }

        .search-box {
            background: white;
            padding: 1rem;
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            display: flex;
            gap: 1rem;
            max-width: 700px;
            margin-top: 2rem;
        }

        .search-box input,
        .search-box select {
            border: 2px solid #E2E8F0;
            border-radius: 10px;
            padding: 0.8rem 1rem;
            font-size: 0.95rem;
            transition: border-color 0.3s;
        }

        .search-box input:focus,
        .search-box select:focus {
            outline: none;
            border-color: var(--primary);
        }

        .btn-search {
            padding: 0.8rem 2rem;
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            white-space: nowrap;
        }

        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
        }

        .hero-stats {
            display: flex;
            gap: 3rem;
            margin-top: 3rem;
        }

        .stat-item h3 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 0.3rem;
        }

        .stat-item p {
            color: var(--gray);
            font-size: 0.9rem;
        }

        /* ===== SECTION ===== */
        .section {
            padding: 100px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-subtitle {
            color: var(--primary);
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 0.5rem;
        }

        .section-title h2 {
            font-size: 2.8rem;
            font-weight: 900;
            margin-bottom: 1rem;
        }

        .section-title p {
            color: var(--gray);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        /* ===== COMPANIES ===== */
        .companies {
            background: var(--light-bg);
        }

        .company-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 2rem;
            align-items: center;
        }

        .company-logo {
            text-align: center;
            padding: 1.5rem;
            background: white;
            border-radius: 12px;
            transition: all 0.3s;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .company-logo:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .company-logo img {
            max-height: 50px;
            opacity: 0.7;
            transition: opacity 0.3s;
            filter: grayscale(100%);
        }

        .company-logo:hover img {
            opacity: 1;
            filter: grayscale(0%);
        }

        /* ===== JOB CARDS ===== */
        .job-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            border: 2px solid #F1F5F9;
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .job-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s;
        }

        .job-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
            border-color: transparent;
        }

        .job-card:hover::before {
            transform: scaleX(1);
        }

        .job-header {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .company-avatar {
            width: 60px;
            height: 60px;
            background: var(--gradient-primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .job-info h4 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
        }

        .job-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.85rem;
            color: var(--gray);
        }

        .job-meta span {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .job-title {
            font-size: 1.3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .job-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .tag {
            padding: 0.4rem 0.8rem;
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary);
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .job-salary {
            background: var(--light-bg);
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }

        .job-salary strong {
            color: var(--primary);
        }

        .job-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #F1F5F9;
        }

        .btn-apply {
            padding: 0.6rem 1.5rem;
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-apply:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }

        .btn-save {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #E2E8F0;
            background: white;
            color: var(--gray);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-save:hover,
        .btn-save.saved {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* ===== FEATURES ===== */
        .features {
            background: var(--light-bg);
        }

        .feature-card {
            text-align: center;
            padding: 2.5rem;
            background: white;
            border-radius: 16px;
            transition: all 0.3s;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: var(--gradient-primary);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
        }

        .feature-card h4 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: var(--gray);
            line-height: 1.7;
        }

        /* ===== BLOG ===== */
        .blog-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s;
            height: 100%;
        }

        .blog-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
        }

        .blog-image {
            height: 220px;
            overflow: hidden;
            position: relative;
        }

        .blog-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .blog-card:hover .blog-image img {
            transform: scale(1.1);
        }

        .blog-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: var(--gradient-primary);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .blog-content {
            padding: 1.5rem;
        }

        .blog-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.85rem;
            color: var(--gray);
            margin-bottom: 1rem;
        }

        .blog-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 0.8rem;
            color: var(--dark);
        }

        .blog-excerpt {
            color: var(--gray);
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .btn-read {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: gap 0.3s;
        }

        .btn-read:hover {
            gap: 1rem;
        }

        /* ===== FOOTER ===== */
        .footer {
            background: var(--dark);
            color: white;
            padding: 80px 0 30px;
        }

        .footer-brand {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: white;
        }

        .footer p {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 1.5rem;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 0.8rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
        }

        .footer-links a:hover {
            color: white;
            padding-left: 5px;
        }

        .footer h5 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-link {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s;
            text-decoration: none;
        }

        .social-link:hover {
            background: var(--primary);
            transform: translateY(-3px);
            color: white;
        }

        .footer-bottom {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
        }

        /* ===== MODAL ===== */
        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: var(--shadow-xl);
        }

        .modal-header {
            background: var(--gradient-primary);
            border-radius: 20px 20px 0 0;
            padding: 2rem;
            border-bottom: none;
        }

        .modal-title {
            color: white;
            font-size: 1.8rem;
            font-weight: 800;
            width: 100%;
            text-align: center;
        }

        .btn-close {
            background: rgba(255, 255, 255, 0.2);
            opacity: 1;
            border-radius: 50%;
            width: 35px;
            height: 35px;
        }

        .modal-body {
            padding: 3rem 2.5rem;
        }

        .modal-icon {
            width: 100px;
            height: 100px;
            margin: -80px auto 2rem;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-lg);
            border: 4px solid white;
        }

        .modal-icon i {
            font-size: 3rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-control {
            border: 2px solid #E2E8F0;
            border-radius: 10px;
            padding: 0.9rem 1rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            outline: none;
        }

        .btn-modal {
            width: 100%;
            padding: 1rem;
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-modal:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
        }

        .divider {
            text-align: center;
            margin: 2rem 0;
            position: relative;
        }

        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 45%;
            height: 1px;
            background: #E2E8F0;
        }

        .divider::before {
            left: 0;
        }

        .divider::after {
            right: 0;
        }

        .divider span {
            background: white;
            padding: 0 1rem;
            color: var(--gray);
            font-size: 0.85rem;
        }

        /* ===== SCROLL TOP ===== */
        .scroll-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--gradient-primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--shadow-lg);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
            z-index: 999;
        }

        .scroll-top.active {
            opacity: 1;
            visibility: visible;
        }

        .scroll-top:hover {
            transform: translateY(-5px);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .search-box {
                flex-direction: column;
            }

            .hero-stats {
                flex-direction: column;
                gap: 1.5rem;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            .company-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <header class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="#" class="logo">
                    <i class="bi bi-briefcase-fill"></i>
                    <span>JobIT</span>
                </a>

                <nav class="d-none d-lg-flex gap-1">
                    <a href="#hero" class="nav-link active">Trang chủ</a>
                    <a href="#jobs" class="nav-link">Việc làm</a>
                    <a href="#companies" class="nav-link">Công ty</a>
                    <a href="#features" class="nav-link">Tính năng</a>
                    <a href="#blog" class="nav-link">Blog</a>
                </nav>

                <div class="d-flex gap-2">
                    <a href="#" class="btn-header btn-outline-header" data-bs-toggle="modal" data-bs-target="#employerModal">
                        <i class="bi bi-building"></i>
                        Nhà tuyển dụng
                    </a>
                    <a href="#" class="btn-header btn-primary-header" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="bi bi-person-circle"></i>
                        Đăng nhập
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- HERO -->
    <section id="hero" class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1>
                        Tìm kiếm công việc <br>
                        <span class="gradient-text">IT lý tưởng</span> của bạn
                    </h1>
                    <p>Khám phá hàng ngàn cơ hội việc làm công nghệ thông tin tại các công ty hàng đầu Việt Nam</p>

                    <div class="search-box">
                        <input type="text" class="form-control flex-grow-1" placeholder="Tìm kiếm công việc, kỹ năng...">
                        <select class="form-control" style="width: 180px;">
                            <option>Tất cả địa điểm</option>
                            <option>Hà Nội</option>
                            <option>TP.HCM</option>
                            <option>Đà Nẵng</option>
                        </select>
                        <button class="btn-search">
                            <i class="bi bi-search"></i> Tìm kiếm
                        </button>
                    </div>

                    <div class="hero-stats">
                        <div class="stat-item">
                            <h3>2,500+</h3>
                            <p>Việc làm IT</p>
                        </div>
                        <div class="stat-item">
                            <h3>800+</h3>
                            <p>Công ty</p>
                        </div>
                        <div class="stat-item">
                            <h3>15,000+</h3>
                            <p>Ứng viên</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- COMPANIES -->
    <section id="companies" class="section companies">
        <div class="container">
            <div class="section-title">
                <div class="section-subtitle">ĐỐI TÁC</div>
                <h2>Nhà tuyển dụng hàng đầu</h2>
            </div>

            <div class="company-grid">
                <div class="company-logo">
                    <img src="https://via.placeholder.com/120x50/6366F1/FFFFFF?text=Viettel" alt="Viettel">
                </div>
                <div class="company-logo">
                    <img src="https://via.placeholder.com/120x50/6366F1/FFFFFF?text=VNG" alt="VNG">
                </div>
                <div class="company-logo">
                    <img src="https://via.placeholder.com/120x50/6366F1/FFFFFF?text=Tiki" alt="Tiki">
                </div>
                <div class="company-logo">
                    <img src="https://via.placeholder.com/120x50/6366F1/FFFFFF?text=Grab" alt="Grab">
                </div>
                <div class="company-logo">
                    <img src="https://via.placeholder.com/120x50/6366F1/FFFFFF?text=Shopee" alt="Shopee">
                </div>
            </div>
        </div>
    </section>

    <!-- JOBS -->
    <section id="jobs" class="section">
        <div class="container">
            <div class="section-title">
                <div class="section-subtitle">VIỆC LÀM</div>
                <h2>Công việc hàng đầu</h2>
                <p>Khám phá các cơ hội việc làm IT tốt nhất từ các công ty uy tín</p>
            </div>

            <div class="row g-4">
                <!-- Job Card 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="job-card">
                        <div class="job-header">
                            <div class="company-avatar">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="job-info flex-grow-1">
                                <h4>FPT Software</h4>
                                <div class="job-meta">
                                    <span><i class="bi bi-geo-alt"></i> Hà Nội</span>
                                    <span><i class="bi bi-clock"></i> Full-time</span>
                                </div>
                            </div>
                        </div>

                        <h3 class="job-title">Senior Frontend Developer</h3>

                        <div class="job-tags">
                            <span class="tag">React</span>
                            <span class="tag">TypeScript</span>
                            <span class="tag">Next.js</span>
                            <span class="tag">Tailwind</span>
                        </div>

                        <div class="job-salary">
                            <strong>Lương:</strong> 25-40 triệu VNĐ
                        </div>

                        <div class="job-footer">
                            <button class="btn-apply" data-bs-toggle="modal" data-bs-target="#loginModal">
                                Ứng tuyển ngay
                            </button>
                            <button class="btn-save">
                                <i class="bi bi-bookmark"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Job Card 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="job-card">
                        <div class="job-header">
                            <div class="company-avatar" style="background: linear-gradient(135deg, #F59E0B 0%, #EF4444 100%);">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="job-info flex-grow-1">
                                <h4>VNG Corporation</h4>
                                <div class="job-meta">
                                    <span><i class="bi bi-geo-alt"></i> TP.HCM</span>
                                    <span><i class="bi bi-clock"></i> Full-time</span>
                                </div>
                            </div>
                        </div>

                        <h3 class="job-title">Backend Java Developer</h3>

                        <div class="job-tags">
                            <span class="tag">Java</span>
                            <span class="tag">Spring Boot</span>
                            <span class="tag">MySQL</span>
                            <span class="tag">Docker</span>
                        </div>

                        <div class="job-salary">
                            <strong>Lương:</strong> 30-50 triệu VNĐ
                        </div>

                        <div class="job-footer">
                            <button class="btn-apply" data-bs-toggle="modal" data-bs-target="#loginModal">
                                Ứng tuyển ngay
                            </button>
                            <button class="btn-save">
                                <i class="bi bi-bookmark"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Job Card 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="job-card">
                        <div class="job-header">
                            <div class="company-avatar" style="background: linear-gradient(135deg, #10B981 0%, #06B6D4 100%);">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="job-info flex-grow-1">
                                <h4>Grab Vietnam</h4>
                                <div class="job-meta">
                                    <span><i class="bi bi-geo-alt"></i> Đà Nẵng</span>
                                    <span><i class="bi bi-clock"></i> Full-time</span>
                                </div>
                            </div>
                        </div>

                        <h3 class="job-title">Mobile Developer (Flutter)</h3>

                        <div class="job-tags">
                            <span class="tag">Flutter</span>
                            <span class="tag">Dart</span>
                            <span class="tag">Firebase</span>
                            <span class="tag">iOS/Android</span>
                        </div>

                        <div class="job-salary">
                            <strong>Lương:</strong> 28-45 triệu VNĐ
                        </div>

                        <div class="job-footer">
                            <button class="btn-apply" data-bs-toggle="modal" data-bs-target="#loginModal">
                                Ứng tuyển ngay
                            </button>
                            <button class="btn-save">
                                <i class="bi bi-bookmark"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Job Card 4 -->
                <div class="col-lg-4 col-md-6">
                    <div class="job-card">
                        <div class="job-header">
                            <div class="company-avatar" style="background: linear-gradient(135deg, #EC4899 0%, #8B5CF6 100%);">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="job-info flex-grow-1">
                                <h4>Tiki Corporation</h4>
                                <div class="job-meta">
                                    <span><i class="bi bi-geo-alt"></i> TP.HCM</span>
                                    <span><i class="bi bi-clock"></i> Full-time</span>
                                </div>
                            </div>
                        </div>

                        <h3 class="job-title">DevOps Engineer</h3>

                        <div class="job-tags">
                            <span class="tag">AWS</span>
                            <span class="tag">Kubernetes</span>
                            <span class="tag">CI/CD</span>
                            <span class="tag">Terraform</span>
                        </div>

                        <div class="job-salary">
                            <strong>Lương:</strong> 35-55 triệu VNĐ
                        </div>

                        <div class="job-footer">
                            <button class="btn-apply" data-bs-toggle="modal" data-bs-target="#loginModal">
                                Ứng tuyển ngay
                            </button>
                            <button class="btn-save">
                                <i class="bi bi-bookmark"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Job Card 5 -->
                <div class="col-lg-4 col-md-6">
                    <div class="job-card">
                        <div class="job-header">
                            <div class="company-avatar" style="background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="job-info flex-grow-1">
                                <h4>Viettel Solutions</h4>
                                <div class="job-meta">
                                    <span><i class="bi bi-geo-alt"></i> Hà Nội</span>
                                    <span><i class="bi bi-clock"></i> Full-time</span>
                                </div>
                            </div>
                        </div>

                        <h3 class="job-title">Data Scientist</h3>

                        <div class="job-tags">
                            <span class="tag">Python</span>
                            <span class="tag">Machine Learning</span>
                            <span class="tag">TensorFlow</span>
                            <span class="tag">SQL</span>
                        </div>

                        <div class="job-salary">
                            <strong>Lương:</strong> 32-50 triệu VNĐ
                        </div>

                        <div class="job-footer">
                            <button class="btn-apply" data-bs-toggle="modal" data-bs-target="#loginModal">
                                Ứng tuyển ngay
                            </button>
                            <button class="btn-save">
                                <i class="bi bi-bookmark"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Job Card 6 -->
                <div class="col-lg-4 col-md-6">
                    <div class="job-card">
                        <div class="job-header">
                            <div class="company-avatar" style="background: linear-gradient(135deg, #F97316 0%, #DC2626 100%);">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="job-info flex-grow-1">
                                <h4>Shopee Vietnam</h4>
                                <div class="job-meta">
                                    <span><i class="bi bi-geo-alt"></i> TP.HCM</span>
                                    <span><i class="bi bi-clock"></i> Full-time</span>
                                </div>
                            </div>
                        </div>

                        <h3 class="job-title">Full Stack Developer</h3>

                        <div class="job-tags">
                            <span class="tag">Node.js</span>
                            <span class="tag">React</span>
                            <span class="tag">MongoDB</span>
                            <span class="tag">Redis</span>
                        </div>

                        <div class="job-salary">
                            <strong>Lương:</strong> 30-48 triệu VNĐ
                        </div>

                        <div class="job-footer">
                            <button class="btn-apply" data-bs-toggle="modal" data-bs-target="#loginModal">
                                Ứng tuyển ngay
                            </button>
                            <button class="btn-save">
                                <i class="bi bi-bookmark"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="#" class="btn-header btn-primary-header" style="padding: 1rem 3rem;">
                    Xem tất cả việc làm <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section id="features" class="section features">
        <div class="container">
            <div class="section-title">
                <div class="section-subtitle">TÍNH NĂNG</div>
                <h2>Tại sao chọn JobIT?</h2>
                <p>Nền tảng tuyển dụng IT toàn diện với những tính năng vượt trội</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-search"></i>
                        </div>
                        <h4>Tìm kiếm thông minh</h4>
                        <p>Công nghệ AI giúp tìm việc phù hợp với kỹ năng và kinh nghiệm của bạn</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4>Công ty uy tín</h4>
                        <p>Kết nối với hàng trăm doanh nghiệp IT hàng đầu được xác thực</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-bell"></i>
                        </div>
                        <h4>Thông báo việc làm</h4>
                        <p>Nhận thông báo ngay khi có việc làm mới phù hợp với bạn</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <h4>Phát triển sự nghiệp</h4>
                        <p>Công cụ và tài nguyên giúp bạn phát triển kỹ năng IT</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BLOG -->
    <section id="blog" class="section">
        <div class="container">
            <div class="section-title">
                <div class="section-subtitle">BLOG</div>
                <h2>Tin tức & Kiến thức IT</h2>
                <p>Cập nhật xu hướng công nghệ và cơ hội nghề nghiệp</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <div class="blog-image">
                            <img src="https://via.placeholder.com/400x280/6366F1/FFFFFF?text=AI+Trends" alt="Blog">
                            <div class="blog-badge">Technology</div>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span><i class="bi bi-person"></i> Admin</span>
                                <span><i class="bi bi-calendar"></i> 15/12/2024</span>
                            </div>
                            <h3 class="blog-title">Xu hướng AI và Machine Learning năm 2025</h3>
                            <p class="blog-excerpt">Khám phá những công nghệ AI mới nhất và cơ hội nghề nghiệp trong lĩnh vực này...</p>
                            <a href="#" class="btn-read">
                                Đọc thêm <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <div class="blog-image">
                            <img src="https://via.placeholder.com/400x280/10B981/FFFFFF?text=Career+Guide" alt="Blog">
                            <div class="blog-badge">Career</div>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span><i class="bi bi-person"></i> Admin</span>
                                <span><i class="bi bi-calendar"></i> 12/12/2024</span>
                            </div>
                            <h3 class="blog-title">10 kỹ năng IT cần thiết cho năm 2025</h3>
                            <p class="blog-excerpt">Danh sách các kỹ năng lập trình và công nghệ được các nhà tuyển dụng săn đón nhất...</p>
                            <a href="#" class="btn-read">
                                Đọc thêm <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <div class="blog-image">
                            <img src="https://via.placeholder.com/400x280/F59E0B/FFFFFF?text=Interview+Tips" alt="Blog">
                            <div class="blog-badge">Tips</div>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span><i class="bi bi-person"></i> Admin</span>
                                <span><i class="bi bi-calendar"></i> 10/12/2024</span>
                            </div>
                            <h3 class="blog-title">Bí quyết phỏng vấn thành công cho IT</h3>
                            <p class="blog-excerpt">Những câu hỏi phỏng vấn phổ biến và cách trả lời ấn tượng để chinh phục nhà tuyển dụng...</p>
                            <a href="#" class="btn-read">
                                Đọc thêm <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4">
                    <h3 class="footer-brand">JobIT</h3>
                    <p>Nền tảng kết nối việc làm IT hàng đầu Việt Nam. Kết nối nhân tài với cơ hội nghề nghiệp tuyệt vời.</p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4">
                    <h5>Dành cho ứng viên</h5>
                    <ul class="footer-links">
                        <li><a href="#">Tìm việc làm</a></li>
                        <li><a href="#">Tạo CV</a></li>
                        <li><a href="#">Tư vấn nghề nghiệp</a></li>
                        <li><a href="#">Blog IT</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-4">
                    <h5>Nhà tuyển dụng</h5>
                    <ul class="footer-links">
                        <li><a href="#">Đăng tin tuyển dụng</a></li>
                        <li><a href="#">Tìm ứng viên</a></li>
                        <li><a href="#">Gói dịch vụ</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-4">
                    <h5>Về chúng tôi</h5>
                    <ul class="footer-links">
                        <li><a href="#">Giới thiệu</a></li>
                        <li><a href="#">Điều khoản</a></li>
                        <li><a href="#">Chính sách</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-4">
                    <h5>Hỗ trợ</h5>
                    <ul class="footer-links">
                        <li><a href="#">Trung tâm trợ giúp</a></li>
                        <li><a href="#">Câu hỏi thường gặp</a></li>
                        <li><a href="#">Báo cáo lỗi</a></li>
                        <li><a href="#">Góp ý</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2024 JobIT - Đại học Cần Thơ. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- LOGIN MODAL -->
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chào mừng trở lại!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-icon">
                        <i class="bi bi-person-circle"></i>
                    </div>

                    <div class="text-center mb-4">
                        <h6 class="text-muted">Đăng nhập để khám phá cơ hội việc làm IT</h6>
                    </div>

                    <form method="POST" action="{{ route('login.submit') }}">
                        @csrf
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email của bạn" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
                        </div>
                        <div class="mb-3 text-end">
                            <a href="#" style="color: var(--primary); font-size: 0.9rem;">Quên mật khẩu?</a>
                        </div>
                        <button type="submit" class="btn-modal">Đăng nhập</button>
                    </form>

                    <div class="divider">
                        <span>Hoặc đăng nhập với</span>
                    </div>

                    <div class="d-flex gap-2 mb-3">
                        <button class="btn btn-outline-secondary flex-fill">
                            <i class="fab fa-google"></i> Google
                        </button>
                        <button class="btn btn-outline-secondary flex-fill">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </button>
                    </div>

                    <div class="text-center">
                        <p class="text-muted mb-0">Chưa có tài khoản? <a href="{{ route('register') }}" style="color: var(--primary); font-weight: 600;">Đăng ký ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- EMPLOYER MODAL -->
    <div class="modal fade" id="employerModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nhà tuyển dụng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-icon">
                        <i class="bi bi-briefcase-fill"></i>
                    </div>

                    <div class="text-center mb-4">
                        <h6 class="text-muted">Đăng tin tuyển dụng và tìm ứng viên tiềm năng</h6>
                    </div>

                    <form method="POST" action="{{ route('employer.login') }}">
                        @csrf
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email doanh nghiệp" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
                        </div>
                        <button type="submit" class="btn-modal">Đăng nhập</button>
                    </form>


                    <div class="divider">
                        <span>Hoặc</span>
                    </div>

                    <div class="text-center">
                        <p class="text-muted mb-0">Chưa có tài khoản doanh nghiệp? <a href="{{ route('employer.register') }}" style="color: var(--primary); font-weight: 600;">Đăng ký ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCROLL TOP -->
    <div class="scroll-top">
        <i class="bi bi-arrow-up"></i>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Header scroll effect
        const header = document.querySelector('.header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Scroll to top
        const scrollTop = document.querySelector('.scroll-top');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollTop.classList.add('active');
            } else {
                scrollTop.classList.remove('active');
            }
        });

        scrollTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Active nav link
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-link');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                if (window.scrollY >= sectionTop - 200) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href.length > 1) {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        const headerHeight = header.offsetHeight;
                        const targetPosition = target.offsetTop - headerHeight;
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });

        // Save button toggle
        document.querySelectorAll('.btn-save').forEach(btn => {
            btn.addEventListener('click', function() {
                this.classList.toggle('saved');
                const icon = this.querySelector('i');
                if (this.classList.contains('saved')) {
                    icon.classList.remove('bi-bookmark');
                    icon.classList.add('bi-bookmark-fill');
                } else {
                    icon.classList.remove('bi-bookmark-fill');
                    icon.classList.add('bi-bookmark');
                }
            });
        });
    </script>

</body>

</html>