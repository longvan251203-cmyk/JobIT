<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lời mời phỏng vấn</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 16px;
            opacity: 0.9;
        }

        .content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .message {
            font-size: 15px;
            color: #555;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .info-box {
            background: #f9fafb;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 25px 0;
            border-radius: 8px;
        }

        .info-row {
            display: flex;
            margin-bottom: 15px;
            font-size: 15px;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-weight: 600;
            color: #333;
            min-width: 140px;
        }

        .info-value {
            color: #555;
            flex: 1;
        }

        .highlight {
            background: #fef3c7;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 600;
            color: #d97706;
        }

        .meeting-link {
            background: #dbeafe;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }

        .meeting-link a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            word-break: break-all;
        }

        .meeting-link a:hover {
            text-decoration: underline;
        }

        .note {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 25px 0;
            border-radius: 8px;
            font-size: 14px;
            color: #92400e;
        }

        .note ul {
            margin: 10px 0 0 20px;
            line-height: 1.8;
        }

        .footer {
            background: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }

        .footer-company {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 15px;
        }

        .footer-info {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.6;
        }

        .footer-info a {
            color: #2563eb;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>🎯 Lời mời phỏng vấn</h1>
            <p>Chúc mừng! Hồ sơ của bạn đã được chọn</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Xin chào <strong>{{ $candidate_name }}</strong>,
            </div>

            <div class="message">
                Cảm ơn bạn đã ứng tuyển vị trí <strong>{{ $job_title }}</strong> tại <strong>{{ $company_name }}</strong>.
                <br><br>
                Chúng tôi rất ấn tượng với hồ sơ của bạn và muốn mời bạn tham gia buổi phỏng vấn với các thông tin sau:
            </div>

            <!-- Interview Info Box -->
            <div class="info-box">
                <div class="info-row">
                    <div class="info-label">📅 Ngày phỏng vấn:</div>
                    <div class="info-value"><span class="highlight">{{ $interview_date }}</span></div>
                </div>

                <div class="info-row">
                    <div class="info-label">🕐 Thời gian:</div>
                    <div class="info-value"><span class="highlight">{{ $interview_time }}</span></div>
                </div>

                <div class="info-row">
                    <div class="info-label">💼 Hình thức:</div>
                    <div class="info-value">{{ $interview_type }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">📍 Địa điểm/Link:</div>
                    <div class="info-value">{{ $location }}</div>
                </div>
            </div>

            <!-- Meeting Link (nếu có) -->
            @if(isset($auto_generated_link) && $auto_generated_link)
            <div class="meeting-link">
                🎥 <strong>Link phỏng vấn:</strong><br>
                <a href="{{ $location }}" target="_blank">{{ $location }}</a>
            </div>
            @endif

            <!-- Note -->
            <div class="note">
                ⚠️ <strong>Lưu ý:</strong>
                <ul>
                    <li>Vui lòng xác nhận lại với chúng tôi qua email này</li>
                    <li>Chuẩn bị trước các câu hỏi và tài liệu liên quan đến vị trí ứng tuyển</li>
                    <li>Đảm bảo kết nối internet ổn định nếu phỏng vấn online</li>
                </ul>
            </div>

            <div class="message">
                Chúng tôi rất mong được gặp bạn. Nếu có bất kỳ thắc mắc nào, đừng ngần ngại liên hệ với chúng tôi.
                <br><br>
                Chúc bạn may mắn! 🍀
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-company">{{ $company_name }}</div>
            <div class="footer-info">
                @if(!empty($company_address))
                📍 {{ $company_address }}<br>
                @endif

                @if(!empty($company_phone))
                📞 {{ $company_phone }}<br>
                @endif

                @if(!empty($company_email))
                ✉️ <a href="mailto:{{ $company_email }}">{{ $company_email }}</a><br>
                @endif

                <br>
                <small style="color: #9ca3af;">
                    Email này được gửi tự động từ hệ thống Job Portal Vietnam.<br>
                    Vui lòng không trả lời trực tiếp email này.
                </small>
            </div>
        </div>
    </div>
</body>

</html>