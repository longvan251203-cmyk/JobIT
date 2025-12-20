<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đăng Tin Tuyển Dụng - JobIT</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Loading state cho select */
        select.form-control:disabled {
            background-color: #f7fafc;
            cursor: not-allowed;
            opacity: 0.7;
        }

        select.form-control option:disabled {
            color: #a0aec0;
        }

        /* Highlight khi đang load */
        select.form-control[disabled] {
            border-color: #667eea;
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            color: white;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .progress-bar {
            display: flex;
            justify-content: space-between;
            padding: 30px 50px;
            background: #f8f9fa;
            border-bottom: 2px solid #e9ecef;
        }

        .progress-step {
            flex: 1;
            text-align: center;
            position: relative;
        }

        .progress-step::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 50%;
            width: 100%;
            height: 2px;
            background: #e9ecef;
            z-index: 1;
        }

        .progress-step:first-child::before {
            display: none;
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-weight: 600;
            position: relative;
            z-index: 2;
            transition: all 0.3s ease;
        }

        .progress-step.active .step-circle {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .progress-step.completed .step-circle {
            background: #28a745;
            color: white;
        }

        .step-label {
            font-size: 13px;
            color: #6c757d;
            font-weight: 500;
        }

        .progress-step.active .step-label {
            color: #667eea;
            font-weight: 600;
        }

        .form-container {
            padding: 40px 50px;
        }

        .form-slide {
            display: none;
            animation: slideIn 0.5s ease;
        }

        .form-slide.active {
            display: block;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .slide-title {
            font-size: 24px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 10px;
        }

        .slide-description {
            color: #718096;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-row.full-width {
            grid-template-columns: 1fr;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group label .required {
            color: #e53e3e;
            margin-left: 3px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        select.form-control {
            cursor: pointer;
            background: white;
        }

        .salary-group {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
        }

        /* Hashtag Styles */
        .hashtag-input-wrapper {
            position: relative;
        }

        .hashtag-input {
            padding-right: 80px;
        }

        .add-hashtag-btn {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .add-hashtag-btn:hover {
            transform: translateY(-50%) scale(1.05);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        /* Autocomplete Suggestions */
        .hashtag-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 80px;
            background: white;
            border: 2px solid #667eea;
            border-top: none;
            border-radius: 0 0 10px 10px;
            max-height: 250px;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            display: none;
            margin-top: -2px;
        }

        .hashtag-suggestions.show {
            display: block;
        }

        .suggestion-item {
            padding: 12px 16px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            border-bottom: 1px solid #f0f0f0;
        }

        .suggestion-item:last-child {
            border-bottom: none;
        }

        .suggestion-item:hover {
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.12) 0%, rgba(118, 75, 162, 0.12) 100%);
            padding-left: 20px;
        }

        .suggestion-item .hashtag-icon {
            color: #667eea;
            font-weight: 700;
            font-size: 16px;
        }

        .suggestion-item .hashtag-text {
            color: #2d3748;
            font-weight: 500;
        }

        .suggestion-empty {
            padding: 16px;
            text-align: center;
            color: #a0aec0;
            font-size: 13px;
            font-style: italic;
        }

        .suggestion-loading {
            padding: 16px;
            text-align: center;
            color: #667eea;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .loading-spinner {
            width: 18px;
            height: 18px;
            border: 2px solid #e2e8f0;
            border-top-color: #667eea;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .hashtags-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 12px;
            min-height: 40px;
            padding: 12px;
            background: #f7fafc;
            border-radius: 8px;
            border: 2px dashed #e2e8f0;
        }

        .hashtag-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: default;
            animation: popIn 0.3s ease;
        }

        @keyframes popIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .hashtag-tag.color-1 {
            background: #E3F2FD;
            color: #1976D2;
        }

        .hashtag-tag.color-2 {
            background: #F3E5F5;
            color: #7B1FA2;
        }

        .hashtag-tag.color-3 {
            background: #E8F5E9;
            color: #388E3C;
        }

        .hashtag-tag.color-4 {
            background: #FFF3E0;
            color: #F57C00;
        }

        .hashtag-tag.color-5 {
            background: #FCE4EC;
            color: #C2185B;
        }

        .hashtag-tag.color-6 {
            background: #E0F2F1;
            color: #00796B;
        }

        .hashtag-tag.color-7 {
            background: #FFF9C4;
            color: #F57F17;
        }

        .hashtag-tag.color-8 {
            background: #FFEBEE;
            color: #C62828;
        }

        .remove-hashtag {
            background: rgba(0, 0, 0, 0.1);
            border: none;
            color: inherit;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: all 0.2s ease;
            padding: 0;
            line-height: 1;
        }

        .remove-hashtag:hover {
            background: rgba(0, 0, 0, 0.2);
            transform: scale(1.1);
        }

        .hashtags-empty {
            color: #a0aec0;
            font-size: 13px;
            font-style: italic;
            width: 100%;
            text-align: center;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #e9ecef;
        }

        .btn {
            flex: 1;
            padding: 14px 24px;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #4a5568;
        }

        .btn-secondary:hover {
            background: #cbd5e0;
        }

        .btn-success {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(72, 187, 120, 0.4);
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .info-box {
            background: #f7fafc;
            border-left: 4px solid #667eea;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .info-box p {
            color: #4a5568;
            font-size: 13px;
            line-height: 1.6;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            margin: 20px 0 0 20px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .back-link:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateX(-3px);
        }

        .char-counter {
            text-align: right;
            font-size: 12px;
            color: #a0aec0;
            margin-top: 5px;
        }

        /* Success Modal */
        .success-modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            animation: fadeIn 0.3s ease;
        }

        .success-modal.show {
            display: flex;
        }

        .success-modal-content {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 500px;
            width: 90%;
            text-align: center;
            animation: slideUp 0.4s ease;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .success-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: scaleIn 0.5s ease;
        }

        @keyframes scaleIn {
            0% {
                transform: scale(0);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .success-icon svg {
            width: 50px;
            height: 50px;
            color: white;
        }

        .success-title {
            font-size: 24px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 10px;
        }

        .success-message {
            color: #718096;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .modal-buttons {
            display: flex;
            gap: 12px;
        }

        .modal-btn {
            flex: 1;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .modal-btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .modal-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .modal-btn-secondary {
            background: #e2e8f0;
            color: #4a5568;
        }

        .modal-btn-secondary:hover {
            background: #cbd5e0;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .salary-group {
                grid-template-columns: 1fr;
            }

            .progress-bar {
                padding: 20px;
            }

            .form-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <a href="/employer-dashboard" class="back-link">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7" />
        </svg>
        Quay lại Dashboard
    </a>

    <div class="container">
        <div class="header">
            <h1>📝 Đăng Tin Tuyển Dụng</h1>
            <p>Tìm kiếm ứng viên tài năng cho công ty của bạn</p>
        </div>

        <div class="progress-bar">
            <div class="progress-step active" data-step="1">
                <div class="step-circle">1</div>
                <div class="step-label">Thông tin chung</div>
            </div>
            <div class="progress-step" data-step="2">
                <div class="step-circle">2</div>
                <div class="step-label">Thông tin chi tiết</div>
            </div>
        </div>

        <form id="postJobForm" method="POST" action="{{ route('job.store') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="hashtags" id="hashtagsInput">

            <div class="form-container">
                <!-- Slide 1 -->
                <div class="form-slide active" id="slide1">
                    <h2 class="slide-title">Thông Tin Tổng Quan</h2>
                    <p class="slide-description">Vui lòng điền đầy đủ các thông tin cơ bản về vị trí tuyển dụng</p>

                    <div class="info-box">
                        <p>💡 <strong>Lưu ý:</strong> Tiêu đề hấp dẫn và rõ ràng sẽ giúp thu hút nhiều ứng viên tiềm năng hơn!</p>
                    </div>

                    <div class="form-group">
                        <label for="title">Tiêu đề công việc <span class="required">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="VD: Senior Frontend Developer" required maxlength="200">
                        <div class="char-counter"><span id="titleCount">0</span>/200 ký tự</div>
                    </div>

                    <!-- Hashtags Section with Autocomplete -->
                    <div class="form-group">
                        <label for="hashtagInput">Hashtags (Từ khóa)</label>
                        <div class="hashtag-input-wrapper">
                            <input
                                type="text"
                                class="form-control hashtag-input"
                                id="hashtagInput"
                                placeholder="VD: ReactJS, NodeJS, Remote..."
                                maxlength="50"
                                autocomplete="off">
                            <button type="button" class="add-hashtag-btn" onclick="addHashtag()">+ Thêm</button>

                            <!-- Suggestions Dropdown -->
                            <div class="hashtag-suggestions" id="hashtagSuggestions"></div>
                        </div>
                        <div class="hashtags-container" id="hashtagsContainer">
                            <span class="hashtags-empty">Chưa có hashtag nào. Nhấn Enter hoặc nút Thêm để thêm hashtag</span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="level">Cấp bậc <span class="required">*</span></label>
                            <select class="form-control" id="level" name="level" required>
                                <option value="">-- Chọn cấp bậc --</option>
                                <option value="intern">Thực tập sinh</option>
                                <option value="fresher">Fresher</option>
                                <option value="junior">Junior</option>
                                <option value="middle">Middle/Senior</option>
                                <option value="senior">Senior</option>
                                <option value="leader">Leader/Manager</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="experience">Kinh nghiệm <span class="required">*</span></label>
                            <select class="form-control" id="experience" name="experience" required>
                                <option value="">-- Chọn kinh nghiệm --</option>
                                <option value="no_experience">Không yêu cầu</option>
                                <option value="under_1">Dưới 1 năm</option>
                                <option value="1_2">1-2 năm</option>
                                <option value="2_5">2-5 năm</option>
                                <option value="5_plus">Trên 5 năm</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Mức lương <span class="required">*</span></label>
                        <div class="salary-group">
                            <select class="form-control" id="salary_type" name="salary_type" required>
                                <option value="">Loại lương</option>
                                <option value="vnd">VNĐ</option>
                                <option value="usd">USD</option>
                                <option value="negotiable">Thỏa thuận</option>
                            </select>
                            <input type="number" class="form-control" id="salary_min" name="salary_min" placeholder="Từ (triệu)" min="0">
                            <input type="number" class="form-control" id="salary_max" name="salary_max" placeholder="Đến (triệu)" min="0">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="working_type">Hình thức làm việc <span class="required">*</span></label>
                            <select class="form-control" id="working_type" name="working_type" required>
                                <option value="">-- Chọn hình thức --</option>
                                <option value="fulltime">Toàn thời gian</option>
                                <option value="parttime">Bán thời gian</option>
                                <option value="remote">Remote</option>
                                <option value="hybrid">Hybrid</option>
                                <option value="freelance">Freelance</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="recruitment_count">Số lượng tuyển <span class="required">*</span></label>
                            <input type="number" class="form-control" id="recruitment_count" name="recruitment_count" placeholder="VD: 3" min="1" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="province">Tỉnh/Thành phố <span class="required">*</span></label>
                            <select class="form-control" id="province" name="province" required>
                                <option value="">-- Đang tải... --</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="district">Quận/Huyện <span class="required">*</span></label>
                            <select class="form-control" id="district" name="district" required>
                                <option value="">-- Chọn tỉnh trước --</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address_detail">Địa chỉ cụ thể <span class="required">*</span></label>
                        <input type="text" class="form-control" id="address_detail" name="address_detail"
                            placeholder="VD: 123 Nguyễn Văn Linh, Phường Tân Phú..." required maxlength="500">
                        <div class="char-counter"><span id="addressCount">0</span>/500 ký tự</div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="foreign_language">Ngoại ngữ yêu cầu <span class="required">*</span></label>
                            <select class="form-control" id="foreign_language" name="foreign_language" required>
                                <option value="">-- Chọn ngoại ngữ --</option>
                                <option value="no_requirement">Không yêu cầu</option>
                                <option value="english">Tiếng Anh</option>
                                <option value="japanese">Tiếng Nhật</option>
                                <option value="korean">Tiếng Hàn</option>
                                <option value="chinese">Tiếng Trung</option>
                                <option value="french">Tiếng Pháp</option>
                                <option value="german">Tiếng Đức</option>
                                <option value="spanish">Tiếng Tây Ban Nha</option>
                                <option value="russian">Tiếng Nga</option>
                                <option value="thai">Tiếng Thái</option>
                                <option value="indonesian">Tiếng Indonesia</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="language_level">Trình độ ngoại ngữ</label>
                            <select class="form-control" id="language_level" name="language_level" disabled>
                                <option value="">-- Chọn trình độ --</option>
                                <option value="basic">Sơ cấp</option>
                                <option value="intermediate">Trung cấp</option>
                                <option value="advanced">Cao cấp</option>
                                <option value="fluent">Thành thạo</option>
                                <option value="native">Bản ngữ</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="deadline">Hạn nộp hồ sơ <span class="required">*</span></label>
                            <input type="date" class="form-control" id="deadline" name="deadline" required>
                        </div>

                        <div class="form-group">
                            <!-- Để trống để giữ layout cân đối -->
                        </div>
                    </div>

                    <div class="button-group">
                        <button type="button" class="btn btn-primary" onclick="nextSlide()">
                            Tiếp tục
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="form-slide" id="slide2">
                    <h2 class="slide-title">Thông Tin Chi Tiết</h2>
                    <p class="slide-description">Mô tả chi tiết về công việc và yêu cầu ứng viên</p>

                    <div class="form-group">
                        <label for="description">Mô tả công việc <span class="required">*</span></label>
                        <textarea class="form-control" id="description" name="description" placeholder="Mô tả chi tiết về vị trí công việc, vai trò và trách nhiệm..." required maxlength="2000"></textarea>
                        <div class="char-counter"><span id="descCount">0</span>/2000 ký tự</div>
                    </div>

                    <div class="form-group">
                        <label for="responsibilities">Trách nhiệm công việc <span class="required">*</span></label>
                        <textarea class="form-control" id="responsibilities" name="responsibilities" placeholder="• Phát triển và bảo trì ứng dụng web&#10;• Tham gia các cuộc họp nhóm&#10;• ..." required maxlength="2000"></textarea>
                        <div class="char-counter"><span id="respCount">0</span>/2000 ký tự</div>
                    </div>

                    <div class="form-group">
                        <label for="requirements">Yêu cầu ứng viên <span class="required">*</span></label>
                        <textarea class="form-control" id="requirements" name="requirements" placeholder="• Tốt nghiệp đại học chuyên ngành IT&#10;• Thành thạo React, TypeScript&#10;• ..." required maxlength="2000"></textarea>
                        <div class="char-counter"><span id="reqCount">0</span>/2000 ký tự</div>
                    </div>

                    <div class="form-group">
                        <label for="benefits">Quyền lợi <span class="required">*</span></label>
                        <textarea class="form-control" id="benefits" name="benefits" placeholder="• Lương tháng 13, thưởng theo hiệu suất&#10;• Bảo hiểm đầy đủ&#10;• ..." required maxlength="2000"></textarea>
                        <div class="char-counter"><span id="benefitsCount">0</span>/2000 ký tự</div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="gender_requirement">Yêu cầu giới tính</label>
                            <select class="form-control" id="gender_requirement" name="gender_requirement">
                                <option value="any">Không yêu cầu</option>
                                <option value="male">Nam</option>
                                <option value="female">Nữ</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="working_environment">Môi trường làm việc</label>
                            <select class="form-control" id="working_environment" name="working_environment">
                                <option value="dynamic">Năng động, sáng tạo</option>
                                <option value="professional">Chuyên nghiệp</option>
                                <option value="friendly">Thân thiện</option>
                                <option value="startup">Startup</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="contact_method">Phương thức liên hệ <span class="required">*</span></label>
                        <textarea class="form-control" id="contact_method" name="contact_method" placeholder="Email: hr@company.com&#10;Hotline: 0123 456 789&#10;Địa chỉ: ..." required maxlength="500"></textarea>
                        <div class="char-counter"><span id="contactCount">0</span>/500 ký tự</div>
                    </div>

                    <div class="button-group">
                        <button type="button" class="btn btn-secondary" onclick="prevSlide()">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M19 12H5M12 19l-7-7 7-7" />
                            </svg>
                            Quay lại
                        </button>
                        <button type="submit" class="btn btn-success" id="submitBtn">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 13l4 4L19 7" />
                            </svg>
                            Đăng tin tuyển dụng
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="success-modal">
        <div class="success-modal-content">
            <div class="success-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h2 class="success-title">Đăng tin thành công!</h2>
            <p class="success-message">Tin tuyển dụng của bạn đã được đăng thành công. Bạn có thể quản lý tin đăng trong phần "Quản lý tin đăng".</p>
            <div class="modal-buttons">
                <button type="button" class="modal-btn modal-btn-secondary" onclick="postAnother()">Đăng tin khác</button>
                <button type="button" class="modal-btn modal-btn-primary" onclick="goToDashboard()">Về Dashboard</button>
            </div>
        </div>
    </div>

    <script>
        let currentSlide = 1;
        let hashtags = [];
        const colorClasses = ['color-1', 'color-2', 'color-3', 'color-4', 'color-5', 'color-6', 'color-7', 'color-8'];
        let searchTimeout = null;

        // Character counter setup
        function setupCharCounter(inputId, counterId) {
            const input = document.getElementById(inputId);
            const counter = document.getElementById(counterId);
            if (!input || !counter) return;
            input.addEventListener('input', function() {
                counter.textContent = this.value.length;
            });
        }

        const counterMap = {
            title: 'titleCount',
            description: 'descCount',
            responsibilities: 'respCount',
            requirements: 'reqCount',
            benefits: 'benefitsCount',
            contact_method: 'contactCount',
            address_detail: 'addressCount'
        };

        for (const inputId in counterMap) {
            setupCharCounter(inputId, counterMap[inputId]);
        }

        // Set minimum deadline
        const deadlineInput = document.getElementById('deadline');
        if (deadlineInput) {
            deadlineInput.min = new Date().toISOString().split('T')[0];
        }

        // ========== HASHTAG AUTOCOMPLETE FUNCTIONALITY ==========

        const hashtagInput = document.getElementById('hashtagInput');
        const suggestionBox = document.getElementById('hashtagSuggestions');

        // Search hashtags from database
        async function searchHashtags(query) {
            if (!query || query.length < 1) {
                hideSuggestions();
                return;
            }

            // Show loading state
            suggestionBox.innerHTML = '<div class="suggestion-loading"><div class="loading-spinner"></div> Đang tìm kiếm...</div>';
            suggestionBox.classList.add('show');

            try {
                const response = await fetch(`/api/hashtags/search?query=${encodeURIComponent(query)}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (!response.ok) {
                    throw new Error('Không thể tải gợi ý hashtag');
                }

                const data = await response.json();

                if (data.success && data.hashtags && data.hashtags.length > 0) {
                    // Filter out already added hashtags
                    const filteredHashtags = data.hashtags.filter(tag =>
                        !hashtags.includes(tag.toLowerCase())
                    );

                    if (filteredHashtags.length > 0) {
                        displaySuggestions(filteredHashtags);
                    } else {
                        showNoResults();
                    }
                } else {
                    showNoResults();
                }
            } catch (error) {
                console.error('Error searching hashtags:', error);
                suggestionBox.innerHTML = '<div class="suggestion-empty">⚠️ Không thể tải gợi ý</div>';
            }
        }

        // Display suggestions
        function displaySuggestions(suggestions) {
            suggestionBox.innerHTML = suggestions.map(tag => `
                <div class="suggestion-item" onclick="selectSuggestion('${tag}')">
                    <span class="hashtag-icon">#</span>
                    <span class="hashtag-text">${tag}</span>
                </div>
            `).join('');
            suggestionBox.classList.add('show');
        }

        // Show no results message
        function showNoResults() {
            suggestionBox.innerHTML = '<div class="suggestion-empty">💡 Không tìm thấy hashtag. Nhấn Enter để tạo mới!</div>';
            suggestionBox.classList.add('show');
        }

        // Hide suggestions
        function hideSuggestions() {
            suggestionBox.classList.remove('show');
            suggestionBox.innerHTML = '';
        }

        // Select a suggestion
        function selectSuggestion(tag) {
            hashtagInput.value = tag;
            addHashtag();
            hideSuggestions();
        }

        // Input event listener with debounce
        hashtagInput.addEventListener('input', function() {
            const query = this.value.trim().replace(/^#/, '');

            // Clear previous timeout
            if (searchTimeout) {
                clearTimeout(searchTimeout);
            }

            // Set new timeout for search (300ms delay)
            searchTimeout = setTimeout(() => {
                searchHashtags(query);
            }, 300);
        });

        // Handle keyboard navigation
        hashtagInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addHashtag();
            } else if (e.key === 'Escape') {
                hideSuggestions();
            }
        });

        // Close suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.hashtag-input-wrapper')) {
                hideSuggestions();
            }
        });

        // ========== ADD/REMOVE HASHTAG ==========

        function addHashtag() {
            const input = document.getElementById('hashtagInput');
            const value = input.value.trim();

            if (!value) return;

            // Remove # if user added it
            const cleanValue = value.replace(/^#/, '');

            // Check if hashtag already exists
            if (hashtags.includes(cleanValue.toLowerCase())) {
                alert('⚠️ Hashtag này đã tồn tại!');
                input.value = '';
                hideSuggestions();
                return;
            }

            // Add to array
            hashtags.push(cleanValue.toLowerCase());

            // Update UI
            renderHashtags();

            // Clear input
            input.value = '';

            // Hide suggestions
            hideSuggestions();

            // Update hidden input
            updateHashtagsInput();
        }

        function renderHashtags() {
            const container = document.getElementById('hashtagsContainer');

            if (hashtags.length === 0) {
                container.innerHTML = '<span class="hashtags-empty">Chưa có hashtag nào. Nhấn Enter hoặc nút Thêm để thêm hashtag</span>';
                return;
            }

            container.innerHTML = hashtags.map((tag, index) => {
                const colorClass = colorClasses[index % colorClasses.length];
                return `
                    <span class="hashtag-tag ${colorClass}">
                        #${tag}
                        <button type="button" class="remove-hashtag" onclick="removeHashtag(${index})" title="Xóa hashtag">×</button>
                    </span>
                `;
            }).join('');
        }

        function removeHashtag(index) {
            hashtags.splice(index, 1);
            renderHashtags();
            updateHashtagsInput();
        }

        function updateHashtagsInput() {
            document.getElementById('hashtagsInput').value = JSON.stringify(hashtags);
        }

        // ========== SLIDE NAVIGATION ==========

        function nextSlide() {
            const slide1Inputs = document.querySelectorAll('#slide1 input[required], #slide1 select[required]');
            let isValid = true;

            slide1Inputs.forEach(input => {
                if (!input.value) {
                    isValid = false;
                    input.style.borderColor = '#e53e3e';
                    setTimeout(() => {
                        input.style.borderColor = '#e2e8f0';
                    }, 2000);
                }
            });

            const salaryType = document.getElementById('salary_type').value;
            const salaryMin = document.getElementById('salary_min').value;
            const salaryMax = document.getElementById('salary_max').value;

            if (salaryType !== 'negotiable' && (!salaryMin || !salaryMax)) {
                isValid = false;
                alert('⚠️ Vui lòng nhập khoảng lương!');
            }

            if (salaryMin && salaryMax && parseFloat(salaryMin) > parseFloat(salaryMax)) {
                isValid = false;
                alert('⚠️ Mức lương tối thiểu không thể lớn hơn mức lương tối đa!');
            }

            if (!isValid) return;

            currentSlide = 2;
            updateSlides();
        }

        function prevSlide() {
            currentSlide = 1;
            updateSlides();
        }

        function updateSlides() {
            document.querySelectorAll('.form-slide').forEach((slide, index) => {
                slide.classList.toggle('active', index + 1 === currentSlide);
            });

            document.querySelectorAll('.progress-step').forEach((step, index) => {
                step.classList.remove('active', 'completed');
                const stepNum = index + 1;
                if (stepNum < currentSlide) step.classList.add('completed');
                else if (stepNum === currentSlide) step.classList.add('active');
            });

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // ========== SALARY TYPE HANDLER ==========

        const salaryTypeSelect = document.getElementById('salary_type');
        if (salaryTypeSelect) {
            salaryTypeSelect.addEventListener('change', function() {
                const salaryMin = document.getElementById('salary_min');
                const salaryMax = document.getElementById('salary_max');
                if (!salaryMin || !salaryMax) return;

                if (this.value === 'negotiable') {
                    salaryMin.disabled = salaryMax.disabled = true;
                    salaryMin.value = salaryMax.value = '';
                } else {
                    salaryMin.disabled = salaryMax.disabled = false;
                }
            });
        }

        // ========== FOREIGN LANGUAGE HANDLER ==========

        const foreignLanguageSelect = document.getElementById('foreign_language');
        const languageLevelSelect = document.getElementById('language_level');

        if (foreignLanguageSelect && languageLevelSelect) {
            foreignLanguageSelect.addEventListener('change', function() {
                if (this.value === 'no_requirement' || this.value === '') {
                    languageLevelSelect.disabled = true;
                    languageLevelSelect.value = '';
                    languageLevelSelect.style.opacity = '0.5';
                    languageLevelSelect.style.backgroundColor = '#f7fafc';
                } else {
                    languageLevelSelect.disabled = false;
                    languageLevelSelect.style.opacity = '1';
                    languageLevelSelect.style.backgroundColor = '#ffffff';
                }
            });

            // Initialize on page load
            if (foreignLanguageSelect.value === 'no_requirement' || foreignLanguageSelect.value === '') {
                languageLevelSelect.disabled = true;
                languageLevelSelect.style.opacity = '0.5';
                languageLevelSelect.style.backgroundColor = '#f7fafc';
            }
        }

        // ========== FORM SUBMISSION ==========

        const jobPostForm = document.getElementById('postJobForm');
        if (jobPostForm) {
            jobPostForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const submitBtn = document.getElementById('submitBtn');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                        <div class="loading-spinner"></div> Đang xử lý...
                    `;
                }

                const formData = new FormData(this);

                fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw new Error(data.error || 'Có lỗi xảy ra');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            document.getElementById('successModal').classList.add('show');
                        } else if (data.errors) {
                            let messages = [];
                            for (const key in data.errors) messages.push(data.errors[key].join(', '));
                            alert('⚠️ Lỗi: \n' + messages.join('\n'));
                            resetSubmitBtn();
                        } else {
                            alert('⚠️ ' + (data.error || 'Có lỗi xảy ra, vui lòng thử lại.'));
                            resetSubmitBtn();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('⚠️ ' + error.message);
                        resetSubmitBtn();
                    });

                function resetSubmitBtn() {
                    if (!submitBtn) return;
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = `
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 13l4 4L19 7" />
                        </svg>
                        Đăng tin tuyển dụng
                    `;
                }
            });
        }

        // ========== MODAL FUNCTIONS ==========

        function goToDashboard() {
            sessionStorage.setItem('openJobsTab', 'true');
            window.location.href = '/employer-dashboard';
        }

        function postAnother() {
            window.location.reload();
        }
    </script>
    <!-- ========== VIETNAM LOCATION API ========== -->
    <script>
        class VietnamLocationAPI {
            constructor() {
                this.baseURL = 'https://provinces.open-api.vn/api';
            }

            async getProvinces() {
                try {
                    const response = await fetch(`${this.baseURL}/p/`);
                    if (!response.ok) throw new Error('Không thể tải danh sách tỉnh');
                    return await response.json();
                } catch (error) {
                    console.error('Error:', error);
                    return this.getFallbackProvinces();
                }
            }

            async getDistricts(provinceCode) {
                try {
                    const response = await fetch(`${this.baseURL}/p/${provinceCode}?depth=2`);
                    if (!response.ok) throw new Error('Không thể tải danh sách quận/huyện');
                    const data = await response.json();
                    return data.districts || [];
                } catch (error) {
                    console.error('Error:', error);
                    return [];
                }
            }

            getFallbackProvinces() {
                return [{
                        code: 1,
                        name: "Hà Nội"
                    },
                    {
                        code: 79,
                        name: "TP. Hồ Chí Minh"
                    },
                    {
                        code: 48,
                        name: "Đà Nẵng"
                    },
                    {
                        code: 31,
                        name: "Hải Phòng"
                    },
                    {
                        code: 92,
                        name: "Cần Thơ"
                    }
                ];
            }
        }

        const locationAPI = new VietnamLocationAPI();

        async function initLocationSelects() {
            const provinceSelect = document.getElementById('province');
            const districtSelect = document.getElementById('district');

            if (!provinceSelect) return;

            // Load provinces
            provinceSelect.innerHTML = '<option value="">Đang tải...</option>';
            const provinces = await locationAPI.getProvinces();

            provinces.sort((a, b) => a.name.localeCompare(b.name, 'vi'));

            provinceSelect.innerHTML = '<option value="">-- Chọn tỉnh/thành phố --</option>';
            provinces.forEach(p => {
                const option = document.createElement('option');
                option.value = p.name;
                option.dataset.code = p.code;
                option.textContent = p.name;
                provinceSelect.appendChild(option);
            });

            // Handle province change
            provinceSelect.addEventListener('change', async function() {
                const code = this.options[this.selectedIndex]?.dataset?.code;

                if (!code) {
                    districtSelect.innerHTML = '<option value="">-- Chọn quận/huyện --</option>';
                    return;
                }

                districtSelect.innerHTML = '<option value="">Đang tải...</option>';
                const districts = await locationAPI.getDistricts(code);

                districts.sort((a, b) => a.name.localeCompare(b.name, 'vi'));

                districtSelect.innerHTML = '<option value="">-- Chọn quận/huyện --</option>';
                districts.forEach(d => {
                    const option = document.createElement('option');
                    option.value = d.name;
                    option.textContent = d.name;
                    districtSelect.appendChild(option);
                });
            });
        }

        // Khởi tạo khi DOM ready
        document.addEventListener('DOMContentLoaded', initLocationSelects);
    </script>
</body>

</html>