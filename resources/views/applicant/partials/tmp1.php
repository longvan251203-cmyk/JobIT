<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gợi ý việc làm cho bạn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Header */
        .main-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-menu {
            display: flex;
            gap: 2rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-menu li a {
            color: #333;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            position: relative;
        }

        .nav-menu li a:hover {
            color: #667eea;
        }

        .nav-menu li a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: #667eea;
            transition: width 0.3s;
        }

        .nav-menu li a:hover::after {
            width: 100%;
        }

        .btn-employer {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            border: none;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-employer:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            padding: 3rem 0;
            margin: 2rem 0;
            border-radius: 30px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.2) 0%, transparent 70%);
            top: -250px;
            right: -250px;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(-20px, 20px);
            }
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 900;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 2rem;
        }

        .refresh-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            border: none;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .refresh-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
        }

        .refresh-btn i {
            transition: transform 0.5s;
        }

        .refresh-btn:hover i {
            transform: rotate(180deg);
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .stat-card.purple::before {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }

        .stat-card.green::before {
            background: linear-gradient(90deg, #11998e 0%, #38ef7d 100%);
        }

        .stat-card.blue::before {
            background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
        }

        .stat-card.orange::before {
            background: linear-gradient(90deg, #fa709a 0%, #fee140 100%);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            margin-bottom: 1rem;
        }

        .stat-card.purple .stat-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stat-card.green .stat-icon {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .stat-card.blue .stat-icon {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .stat-card.orange .stat-icon {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 900;
            color: #333;
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1rem;
            color: #666;
            font-weight: 600;
        }

        /* Job Cards */
        .job-card {
            background: white;
            border-radius: 25px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            opacity: 0;
            transform: translateY(30px);
            animation: slideUp 0.6s forwards;
        }

        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .job-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .job-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .job-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .job-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .job-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 5px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .job-card.high-match::before {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .job-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .job-header {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .company-logo {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: 900;
            flex-shrink: 0;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
            transition: all 0.3s;
        }

        .job-card:hover .company-logo {
            transform: rotate(5deg) scale(1.05);
        }

        .job-info {
            flex: 1;
        }

        .job-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: #333;
            margin-bottom: 0.5rem;
            transition: all 0.3s;
        }

        .job-card:hover .job-title {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .company-name {
            color: #666;
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .match-score {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
            min-width: 100px;
        }

        .job-card.high-match .match-score {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .match-score .score {
            font-size: 2.5rem;
            font-weight: 900;
            line-height: 1;
            display: block;
        }

        .match-score .label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 0.3rem;
        }

        .job-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.8rem;
            margin-bottom: 1.5rem;
        }

        .job-tag {
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
        }

        .job-tag.location {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(102, 126, 234, 0.2) 100%);
            color: #667eea;
        }

        .job-tag.salary {
            background: linear-gradient(135deg, rgba(17, 153, 142, 0.1) 0%, rgba(56, 239, 125, 0.2) 100%);
            color: #11998e;
        }

        .job-tag.level {
            background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(0, 242, 254, 0.2) 100%);
            color: #4facfe;
        }

        .job-tag.new {
            background: linear-gradient(135deg, rgba(250, 112, 154, 0.1) 0%, rgba(254, 225, 64, 0.2) 100%);
            color: #fa709a;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .job-tag:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        /* Match Analysis */
        .match-analysis {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .analysis-title {
            font-size: 1rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .analysis-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .analysis-item {
            background: white;
            border-radius: 15px;
            padding: 1rem;
            transition: all 0.3s;
        }

        .analysis-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .analysis-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.8rem;
        }

        .analysis-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: #666;
            text-transform: uppercase;
        }

        .analysis-value {
            font-size: 1.3rem;
            font-weight: 900;
        }

        .analysis-value.purple {
            color: #667eea;
        }

        .analysis-value.green {
            color: #11998e;
        }

        .analysis-value.blue {
            color: #4facfe;
        }

        .progress-bar {
            height: 8px;
            background: #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            border-radius: 10px;
            transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .progress-fill.purple {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }

        .progress-fill.green {
            background: linear-gradient(90deg, #11998e 0%, #38ef7d 100%);
        }

        .progress-fill.blue {
            background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
        }

        /* Action Buttons */
        .job-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-action {
            flex: 1;
            min-width: 200px;
            padding: 1rem 2rem;
            border-radius: 50px;
            border: none;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.8rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: white;
            color: #667eea;
            border: 3px solid #667eea;
        }

        .btn-secondary:hover {
            background: #667eea;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-icon {
            width: 50px;
            height: 50px;
            padding: 0;
            min-width: unset;
            flex: unset;
            background: white;
            color: #666;
            border: 2px solid #ddd;
        }

        .btn-icon:hover {
            border-color: #ff6b6b;
            color: #ff6b6b;
            background: #fff5f5;
        }

        .btn-icon.saved {
            border-color: #ff6b6b;
            color: #ff6b6b;
            background: #fff5f5;
        }

        /* Empty State */
        .empty-state {
            background: white;
            border-radius: 30px;
            padding: 4rem;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .empty-icon {
            width: 150px;
            height: 150px;
            margin: 0 auto 2rem;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: #667eea;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .empty-title {
            font-size: 2rem;
            font-weight: 900;
            color: #333;
            margin-bottom: 1rem;
        }

        .empty-text {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        /* Footer */
        .main-footer {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 2rem 0;
            margin-top: 4rem;
            box-shadow: 0 -4px 30px rgba(0, 0, 0, 0.1);
        }

        .footer-content {
            text-align: center;
            color: #666;
        }

        /* Loading State */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }

            .nav-menu {
                flex-direction: column;
                gap: 1rem;
            }

            .job-header {
                flex-direction: column;
            }

            .match-score {
                align-self: flex-start;
            }

            .btn-action {
                min-width: 100%;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="main-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">JobMatch</div>
                <nav class="d-none d-md-block">
                    <ul class="nav-menu">
                        <li><a href="#">Trang chủ</a></li>
                        <li><a href="#">Giới thiệu</a></li>
                        <li><a href="#">Công ty</a></li>
                        <li><a href="#">Việc làm</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </nav>
                <button class="btn-employer">
                    <i class="bi bi-briefcase me-2"></i>
                    Nhà tuyển dụng
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container my-5">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center mb-3">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                            <i class="bi bi-stars text-white" style="font-size: 1.8rem;"></i>
                        </div>
                        <h1 class="hero-title mb-0">Gợi ý việc làm cho bạn</h1>
                    </div>
                    <p class="hero-subtitle ms-5 ps-3">Được cá nhân hóa dựa trên kỹ năng, kinh nghiệm và sở thích của bạn</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <button class="refresh-btn" onclick="refreshRecommendations()">
                        <i class="bi bi-arrow-clockwise"></i>
                        <span>Làm mới danh sách</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card purple">
                <div class="stat-icon">
                    <i class="bi bi-briefcase-fill"></i>
                </div>
                <div class="stat-number">24</div>
                <div class="stat-label">Việc làm phù hợp</div>
            </div>

            <div class="stat-card green">
                <div class="stat-icon">
                    <i class="bi bi-star-fill"></i>
                </div>
                <div class="stat-number">18</div>
                <div class="stat-label">Phù hợp cao (≥80%)</div>
            </div>

            <div class="stat-card blue">
                <div class="stat-icon">
                    <i class="bi bi-eye-slash-fill"></i>
                </div>
                <div class="stat-number">12</div>
                <div class="stat-label">Chưa xem</div>
            </div>

            <div class="stat-card orange">
                <div class="stat-icon">
                    <i class="bi bi-send-fill"></i>
                </div>
                <div class="stat-number">20</div>
                <div class="stat-label">Chưa ứng tuyển</div>
            </div>
        </div>

        <!-- Job Listings -->
        <div class="job-listings mt-4">
            <!-- Job Card 1 -->
            <div class="job-card high-match">
                <div class="job-header">
                    <div class="company-logo">T</div>
                    <div class="job-info">
                        <h3 class="job-title">Senior Frontend Developer</h3>
                        <div class="company-name">
                            <i class="bi bi-building"></i>
                            Tech Innovation Vietnam
                        </div>
                    </div>
                    <div class="match-score">
                        <span class="score">92%</span>
                        <span class="label">Phù hợp</span>
                    </div>
                </div>

                <div class="job-tags">
                    <span class="job-tag location">
                        <i class="bi bi-geo-alt-fill"></i>
                        Hồ Chí Minh
                    </span>
                    <span class="job-tag salary">
                        <i class="bi bi-cash-stack"></i>
                        25,000,000 - 40,000,000 VND
                    </span>
                    <span class="job-tag level">
                        <i class="bi bi-briefcase-fill"></i>
                        Senior
                    </span>
                    <span class="job-tag new">
                        <i class="bi bi-star-fill"></i>
                        Mới
                    </span>
                </div>

                <div class="match-analysis">
                    <div class="analysis-title">
                        <i class="bi bi-graph-up-arrow"></i>
                        Phân tích mức độ phù hợp
                    </div>
                    <div class="analysis-grid">
                        <div class="analysis-item">
                            <div class="analysis-header">
                                <span class="analysis-label">Kỹ năng</span>
                                <span class="analysis-value purple">95%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill purple" style="width: 95%"></div>
                            </div>
                        </div>
                        <div class="analysis-item">
                            <div class="analysis-header">
                                <span class="analysis-label">Kinh nghiệm</span>
                                <span class="analysis-value green">90%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill green" style="width: 90%"></div>
                            </div>
                        </div>
                        <div class="analysis-item">
                            <div class="analysis-header">
                                <span class="analysis-label">Địa điểm</span>
                                <span class="analysis-value blue">90%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill blue" style="width: 90%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="job-actions">
                    <button class="btn-action btn-primary" onclick="viewJob('job-001')">
                        <i class="bi bi-eye-fill"></i>
                        <span>Xem chi tiết</span>
                    </button>
                    <button class="btn-action btn-secondary" onclick="applyJob('job-001')">
                        <i class="bi bi-send-fill"></i>
                        <span>Ứng tuyển ngay</span>
                    </button>
                    <button class="btn-action btn-icon" onclick="toggleSave(this)">
                        <i class="bi bi-heart"></i>
                    </button>
                </div>
            </div>

            <!-- Job Card 2 -->
            <div class="job-card">
                <div class="job-header">
                    <div class="company-logo">C</div>
                    <div class="job-info">
                        <h3 class="job-title">UI/UX Designer</h3>
                        <div class="company-name">
                            <i class="bi bi-building"></i>
                            Creative Studio
                        </div>
                    </div>
                    <div class="match-score">
                        <span class="score">78%</span>
                        <span class="label">Phù hợp</span>
                    </div>
                </div>
                <div class="job-tags">
                    <span class="job-tag location">
                        <i class="bi bi-geo-alt-fill"></i>
                        Hà Nội
                    </span>
                    <span class="job-tag salary">
                        <i class="bi bi-cash-stack"></i>
                        Thỏa thuận
                    </span>
                    <span class="job-tag level">
                        <i class="bi bi-briefcase-fill"></i>
                        Middle
                    </span>
                </div>
                <div class="match-analysis">
                    <div class="analysis-title">
                        <i class="bi bi-graph-up-arrow"></i>
                        Phân tích mức độ phù hợp
                    </div>
                    <div class="analysis-grid">
                        <div class="analysis-item">
                            <div class="analysis-header">
                                <span class="analysis-label">Kỹ năng</span>
                                <span class="analysis-value purple">82%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill purple" style="width: 82%"></div>
                            </div>
                        </div>
                        <div class="analysis-item">
                            <div class="analysis-header">
                                <span class="analysis-label">Kinh nghiệm</span>
                                <span class="analysis-value green">75%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill green" style="width: 75%"></div>
                            </div>
                        </div>
                        <div class="analysis-item">
                            <div class="analysis-header">
                                <span class="analysis-label">Địa điểm</span>
                                <span class="analysis-value blue">70%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill blue" style="width: 70%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="job-actions">
                    <button class="btn-action btn-primary" onclick="viewJob('job-002')">
                        <i class="bi bi-eye-fill"></i>
                        <span>Xem chi tiết</span>
                    </button>
                    <button class="btn-action btn-secondary" onclick="applyJob('job-002')">
                        <i class="bi bi-send-fill"></i>
                        <span>Ứng tuyển ngay</span>
                    </button>
                    <button class="btn-action btn-icon" onclick="toggleSave(this)">
                        <i class="bi bi-heart"></i>
                    </button>
                </div>
            </div>

            <!-- Job Card 3 -->
            <div class="job-card high-match">
                <div class="job-header">
                    <div class="company-logo">D</div>
                    <div class="job-info">
                        <h3 class="job-title">Full Stack Developer</h3>
                        <div class="company-name">
                            <i class="bi bi-building"></i>
                            Digital Solutions Co.
                        </div>
                    </div>
                    <div class="match-score">
                        <span class="score">88%</span>
                        <span class="label">Phù hợp</span>
                    </div>
                </div>

                <div class="job-tags">
                    <span class="job-tag location">
                        <i class="bi bi-geo-alt-fill"></i>
                        Đà Nẵng
                    </span>
                    <span class="job-tag salary">
                        <i class="bi bi-cash-stack"></i>
                        20,000,000 - 35,000,000 VND
                    </span>
                    <span class="job-tag level">
                        <i class="bi bi-briefcase-fill"></i>
                        Middle
                    </span>
                    <span class="job-tag new">
                        <i class="bi bi-star-fill"></i>
                        Mới
                    </span>
                </div>

                <div class="match-analysis">
                    <div class="analysis-title">
                        <i class="bi bi-graph-up-arrow"></i>
                        Phân tích mức độ phù hợp
                    </div>
                    <div class="analysis-grid">
                        <div class="analysis-item">
                            <div class="analysis-header">
                                <span class="analysis-label">Kỹ năng</span>
                                <span class="analysis-value purple">90%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill purple" style="width: 90%"></div>
                            </div>
                        </div>
                        <div class="analysis-item">
                            <div class="analysis-header">
                                <span class="analysis-label">Kinh nghiệm</span>
                                <span class="analysis-value green">88%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill green" style="width: 88%"></div>
                            </div>
                        </div>
                        <div class="analysis-item">
                            <div class="analysis-header">
                                <span class="analysis-label">Địa điểm</span>
                                <span class="analysis-value blue">85%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill blue" style="width: 85%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="job-actions">
                    <button class="btn-action btn-primary" onclick="viewJob('job-003')">
                        <i class="bi bi-eye-fill"></i>
                        <span>Xem chi tiết</span>
                    </button>
                    <button class="btn-action btn-secondary" onclick="applyJob('job-003')">
                        <i class="bi bi-send-fill"></i>
                        <span>Ứng tuyển ngay</span>
                    </button>
                    <button class="btn-action btn-icon" onclick="toggleSave(this)">
                        <i class="bi bi-heart"></i>
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <p class="mb-0">© 2025 JobMatch. Tất cả các quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>

    <script>
        // Refresh recommendations
        async function refreshRecommendations() {
            const btn = event.target.closest('button');
            const originalHTML = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = '<span class="loading"></span><span class="ms-2">Đang tải...</span>';

            try {
                // Simulate API call
                await new Promise(resolve => setTimeout(resolve, 2000));

                btn.innerHTML = '<i class="bi bi-check-circle-fill"></i><span class="ms-2">Thành công!</span>';

                setTimeout(() => {
                    location.reload();
                }, 500);
            } catch (error) {
                console.error('Error:', error);
                btn.innerHTML = '<i class="bi bi-exclamation-circle-fill"></i><span class="ms-2">Thất bại!</span>';

                setTimeout(() => {
                    btn.disabled = false;
                    btn.innerHTML = originalHTML;
                }, 2000);
            }
        }

        // View job details
        function viewJob(jobId) {
            console.log('Viewing job:', jobId);
            // Navigate to job details page
            // window.location.href = `/job/${jobId}`;
            alert(`Xem chi tiết công việc: ${jobId}`);
        }

        // Apply for job
        function applyJob(jobId) {
            console.log('Applying for job:', jobId);
            // Navigate to application page
            // window.location.href = `/job/${jobId}/apply`;
            alert(`Ứng tuyển công việc: ${jobId}`);
        }

        // Toggle save job
        function toggleSave(btn) {
            const icon = btn.querySelector('i');

            if (icon.classList.contains('bi-heart')) {
                icon.classList.remove('bi-heart');
                icon.classList.add('bi-heart-fill');
                btn.classList.add('saved');

                // Animation
                btn.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    btn.style.transform = 'scale(1)';
                }, 200);
            } else {
                icon.classList.remove('bi-heart-fill');
                icon.classList.add('bi-heart');
                btn.classList.remove('saved');
            }
        }

        // Animate progress bars on scroll
        const observerOptions = {
            threshold: 0.5
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const progressBars = entry.target.querySelectorAll('.progress-fill');
                    progressBars.forEach(bar => {
                        const width = bar.style.width;
                        bar.style.width = '0';
                        setTimeout(() => {
                            bar.style.width = width;
                        }, 100);
                    });
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.match-analysis').forEach(analysis => {
                observer.observe(analysis);
            });
        });
    </script>