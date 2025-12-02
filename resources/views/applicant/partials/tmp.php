@extends('layouts.app')

@section('title', 'Gợi ý việc làm cho bạn')

@section('content')
<style>
    /* Giữ nguyên toàn bộ CSS cũ */
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
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
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
        margin-bottom: 0.5rem;
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

    .analysis-value.orange {
        color: #fa709a;
    }

    .analysis-value.yellow {
        color: #ffd700;
    }

    .analysis-reason {
        font-size: 0.75rem;
        color: #888;
        margin-top: 0.3rem;
        line-height: 1.3;
    }

    .progress-bar {
        height: 8px;
        background: #e0e0e0;
        border-radius: 10px;
        overflow: hidden;
        position: relative;
        margin-top: 0.5rem;
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

    .progress-fill.orange {
        background: linear-gradient(90deg, #fa709a 0%, #fee140 100%);
    }

    .progress-fill.yellow {
        background: linear-gradient(90deg, #ffd700 0%, #ffed4e 100%);
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

        .analysis-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

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
            <div class="stat-number">{{ $stats['total'] }}</div>
            <div class="stat-label">Việc làm phù hợp</div>
        </div>

        <div class="stat-card green">
            <div class="stat-icon">
                <i class="bi bi-star-fill"></i>
            </div>
            <div class="stat-number">{{ $stats['high_match'] }}</div>
            <div class="stat-label">Phù hợp cao (≥80%)</div>
        </div>

        <div class="stat-card blue">
            <div class="stat-icon">
                <i class="bi bi-eye-slash-fill"></i>
            </div>
            <div class="stat-number">{{ $stats['not_viewed'] }}</div>
            <div class="stat-label">Chưa xem</div>
        </div>

        <div class="stat-card orange">
            <div class="stat-icon">
                <i class="bi bi-send-fill"></i>
            </div>
            <div class="stat-number">{{ $stats['not_applied'] }}</div>
            <div class="stat-label">Chưa ứng tuyển</div>
        </div>
    </div>

    <!-- Job Listings -->
    <div class="job-listings mt-4">
        @forelse($recommendations as $recommendation)
        @php
        $job = $recommendation->job;
        $company = $job->company;
        $matchDetails = $recommendation->match_details_parsed;
        $isHighMatch = $recommendation->score >= 80;

        // Format salary
        $salaryText = 'Thỏa thuận';
        if ($job->salary_type !== 'negotiable' && $job->salary_min && $job->salary_max) {
        $salaryText = number_format($job->salary_min) . ' - ' . number_format($job->salary_max) . ' VND';
        }

        // Get experience label
        $experienceLabels = [
        'no_experience' => 'Không yêu cầu',
        'under_1' => 'Dưới 1 năm',
        '1_2' => '1-2 năm',
        '2_5' => '2-5 năm',
        '5_plus' => 'Trên 5 năm'
        ];
        $experienceText = $experienceLabels[$job->experience] ?? 'Không rõ';

        // Company logo initial
        $companyInitial = strtoupper(substr($company->ten_cty ?? 'C', 0, 1));
        @endphp

        <div class="job-card {{ $isHighMatch ? 'high-match' : '' }}">
            <div class="job-header">
                <div class="company-logo">{{ $companyInitial }}</div>
                <div class="job-info">
                    <h3 class="job-title">{{ $job->tieu_de }}</h3>
                    <div class="company-name">
                        <i class="bi bi-building"></i>
                        {{ $company->ten_cty ?? 'Công ty' }}
                    </div>
                </div>
                <div class="match-score">
                    <span class="score">{{ round($recommendation->score) }}%</span>
                    <span class="label">Phù hợp</span>
                </div>
            </div>

            <div class="job-tags">
                @if($job->province)
                <span class="job-tag location">
                    <i class="bi bi-geo-alt-fill"></i>
                    {{ $job->province }}
                </span>
                @endif

                <span class="job-tag salary">
                    <i class="bi bi-cash-stack"></i>
                    {{ $salaryText }}
                </span>

                <span class="job-tag level">
                    <i class="bi bi-briefcase-fill"></i>
                    {{ $experienceText }}
                </span>

                @if(\Carbon\Carbon::parse($job->created_at)->diffInDays() < 7)
                    <span class="job-tag new">
                    <i class="bi bi-star-fill"></i>
                    Mới
                    </span>
                    @endif
            </div>

            {{-- Match Analysis - CẬP NHẬT PHẦN NÀY --}}
            @if($matchDetails)
            <div class="match-analysis">
                <div class="analysis-title">
                    <i class="bi bi-graph-up-arrow"></i>
                    Phân tích mức độ phù hợp
                </div>
                <div class="analysis-grid">
                    {{-- Kỹ năng --}}
                    @if(isset($matchDetails['skills']))
                    <div class="analysis-item">
                        <div class="analysis-header">
                            <span class="analysis-label">Kỹ năng</span>
                            <span class="analysis-value purple">{{ round($matchDetails['skills']['score']) }}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill purple" style="width: {{ $matchDetails['skills']['score'] }}%"></div>
                        </div>
                        @if(isset($matchDetails['skills']['reason']))
                        <div class="analysis-reason">{{ $matchDetails['skills']['reason'] }}</div>
                        @endif
                    </div>
                    @endif

                    {{-- Kinh nghiệm --}}
                    @if(isset($matchDetails['experience']))
                    <div class="analysis-item">
                        <div class="analysis-header">
                            <span class="analysis-label">Kinh nghiệm</span>
                            <span class="analysis-value green">{{ round($matchDetails['experience']['score']) }}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill green" style="width: {{ $matchDetails['experience']['score'] }}%"></div>
                        </div>
                        @if(isset($matchDetails['experience']['reason']))
                        <div class="analysis-reason">{{ $matchDetails['experience']['reason'] }}</div>
                        @endif
                    </div>
                    @endif

                    {{-- Địa điểm --}}
                    @if(isset($matchDetails['location']))
                    <div class="analysis-item">
                        <div class="analysis-header">
                            <span class="analysis-label">Địa điểm</span>
                            <span class="analysis-value blue">{{ round($matchDetails['location']['score']) }}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill blue" style="width: {{ $matchDetails['location']['score'] }}%"></div>
                        </div>
                        @if(isset($matchDetails['location']['reason']))
                        <div class="analysis-reason">{{ $matchDetails['location']['reason'] }}</div>
                        @endif
                    </div>
                    @endif

                    {{-- Mức lương --}}
                    @if(isset($matchDetails['salary']))
                    <div class="analysis-item">
                        <div class="analysis-header">
                            <span class="analysis-label">Mức lương</span>
                            <span class="analysis-value orange">{{ round($matchDetails['salary']['score']) }}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill orange" style="width: {{ $matchDetails['salary']['score'] }}%"></div>
                        </div>
                        @if(isset($matchDetails['salary']['reason']))
                        <div class="analysis-reason">{{ $matchDetails['salary']['reason'] }}</div>
                        @endif
                    </div>
                    @endif

                    {{-- Học vấn --}}
                    @if(isset($matchDetails['education']))
                    <div class="analysis-item">
                        <div class="analysis-header">
                            <span class="analysis-label">Học vấn</span>
                            <span class="analysis-value purple">{{ round($matchDetails['education']['score']) }}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill purple" style="width: {{ $matchDetails['education']['score'] }}%"></div>
                        </div>
                        @if(isset($matchDetails['education']['reason']))
                        <div class="analysis-reason">{{ $matchDetails['education']['reason'] }}</div>
                        @endif
                    </div>
                    @endif

                    {{-- Ngoại ngữ --}}
                    @if(isset($matchDetails['language']))
                    <div class="analysis-item">
                        <div class="analysis-header">
                            <span class="analysis-label">Ngoại ngữ</span>
                            <span class="analysis-value yellow">{{ round($matchDetails['language']['score']) }}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill yellow" style="width: {{ $matchDetails['language']['score'] }}%"></div>
                        </div>
                        @if(isset($matchDetails['language']['reason']))
                        <div class="analysis-reason">{{ $matchDetails['language']['reason'] }}</div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            @endif
            <div class="job-actions">
                <button class="btn-action btn-primary" onclick="viewJob('{{ $job->job_id }}', {{ $recommendation->id }})">
                    <i class="bi bi-eye-fill"></i>
                    <span>Xem chi tiết</span>
                </button>
                <button class="btn-action btn-secondary" onclick="applyJob('{{ $job->job_id }}')">
                    <i class="bi bi-send-fill"></i>
                    <span>Ứng tuyển ngay</span>
                </button>
                <button class="btn-action btn-icon" onclick="toggleSave(this)">
                    <i class="bi bi-heart"></i>
                </button>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">
                <i class="bi bi-inbox"></i>
            </div>
            <h2 class="empty-title">Chưa có gợi ý việc làm</h2>
            <p class="empty-text">
                Vui lòng hoàn thiện hồ sơ của bạn để nhận được gợi ý việc làm phù hợp nhất.<br>
                Hoặc nhấn nút "Làm mới danh sách" để cập nhật.
            </p>
            <button class="refresh-btn" onclick="refreshRecommendations()">
                <i class="bi bi-arrow-clockwise"></i>
                <span>Làm mới danh sách</span>
            </button>
        </div>
        @endforelse
    </div>
</main>
<script>
    // Refresh recommendations
    async function refreshRecommendations() {
        const btn = event.target.closest('button');
        const originalHTML = btn.innerHTML;

        btn.disabled = true;
        btn.innerHTML = '<span class="loading"></span><span class="ms-2">Đang tải...</span>';

        try {
            const response = await fetch('{{ route("recommendations.refresh") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const data = await response.json();

            if (data.success) {
                btn.innerHTML = '<i class="bi bi-check-circle-fill"></i><span class="ms-2">Thành công!</span>';
                setTimeout(() => {
                    location.reload();
                }, 500);
            } else {
                throw new Error(data.message);
            }
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
    async function viewJob(jobId, recommendationId) {
        // Đánh dấu đã xem
        try {
            await fetch(`/recommendations/${recommendationId}/viewed`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
        } catch (error) {
            console.error('Error marking as viewed:', error);
        }

        // Chuyển đến trang chi tiết job
        window.location.href = `/jobs/${jobId}`;
    }

    // Apply for job
    function applyJob(jobId) {
        window.location.href = `/jobs/${jobId}/apply`;
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
@endsection