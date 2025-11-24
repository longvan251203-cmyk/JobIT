<!-- Lưu tại: resources/views/emails/application-approved.blade.php -->

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chúc mừng bạn được chọn</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background: #f5f5f5;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .email-wrapper {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            padding: 32px 24px;
            text-align: center;
            color: white;
        }

        .email-header-icon {
            font-size: 48px;
            margin-bottom: 16px;
        }

        .email-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .email-header p {
            font-size: 16px;
            opacity: 0.95;
        }

        .email-body {
            padding: 32px 24px;
        }

        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
            color: #1f2937;
        }

        .job-info {
            background: #f0fdf4;
            border-left: 4px solid #059669;
            padding: 16px;
            margin: 24px 0;
            border-radius: 8px;
        }

        .job-info-label {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .job-info-value {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
        }

        .next-steps {
            margin: 24px 0;
        }

        .next-steps h3 {
            font-size: 16px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 12px;
        }

        .next-steps ol {
            margin-left: 24px;
            color: #4b5563;
        }

        .next-steps li {
            margin-bottom: 12px;
            line-height: 1.6;
        }

        .contact-info {
            background: #f9fafb;
            padding: 16px;
            border-radius: 8px;
            margin: 24px 0;
            font-size: 14px;
        }

        .contact-info-item {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .contact-info-item:last-child {
            margin-bottom: 0;
        }

        .note-section {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 16px;
            margin: 24px 0;
            border-radius: 8px;
            font-size: 14px;
            color: #92400e;
        }

        .email-footer {
            background: #f9fafb;
            padding: 24px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            font-size: 13px;
            color: #6b7280;
        }

        .divider {
            height: 1px;
            background: #e5e7eb;
            margin: 24px 0;
        }

        strong {
            color: #1f2937;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="email-wrapper">
            <!-- Header -->
            <div class="email-header">
                <div class="email-header-icon">🎉</div>
                <h1>Chúc mừng bạn!</h1>
                <p>Bạn đã được chọn cho vị trí này</p>
            </div>

            <!-- Body -->
            <div class="email-body">
                <div class="greeting">
                    Xin chào <strong>{{ $candidate_name }}</strong>,
                </div>

                <p style="color: #4b5563; line-height: 1.6;">
                    Chúng tôi rất vui mừng thông báo rằng bạn đã hoàn thành thành công các vòng phỏng vấn
                    và <strong>được chọn</strong> cho vị trí <strong>{{ $job_title }}</strong> tại <strong>{{ $company_name }}</strong>.
                </p>

                <div class="job-info">
                    <div class="job-info-label">📌 Vị trí bạn được chọn</div>
                    <div class="job-info-value">{{ $job_title }}</div>
                </div>

                <!-- Ghi chú nếu có -->
                @if($note)
                <div class="note-section">
                    <strong>💬 Nhận xét từ nhà tuyển dụng:</strong><br>
                    {{ $note }}
                </div>
                @endif

                <!-- Bước tiếp theo -->
                <div class="next-steps">
                    <h3>📋 Các bước tiếp theo:</h3>
                    <ol>
                        <li>Vui lòng chú ý để không bỏ lỡ các cuộc gọi hoặc email từ chúng tôi</li>
                        <li>Chúng tôi sẽ liên hệ với bạn trong <strong>1-2 ngày</strong> với chi tiết về hợp đồng và lịch làm việc</li>
                        <li>Chuẩn bị các giấy tờ cần thiết theo hướng dẫn của HR</li>
                    </ol>
                </div>

                <!-- Thông tin liên hệ -->
                <div class="contact-info">
                    <strong>📞 Thông tin liên hệ:</strong>
                    @if($company_email)
                    <div class="contact-info-item">
                        📧 Email: <a href="mailto:{{ $company_email }}" style="color: #3b82f6; text-decoration: none;">{{ $company_email }}</a>
                    </div>
                    @endif
                    @if($company_phone)
                    <div class="contact-info-item">
                        📱 Điện thoại: {{ $company_phone }}
                    </div>
                    @endif
                </div>

                <p style="color: #4b5563; line-height: 1.6;">
                    Nếu có bất kỳ câu hỏi nào, vui lòng <strong>liên hệ trực tiếp</strong> với chúng tôi.
                </p>

                <p style="color: #4b5563; line-height: 1.6; margin-top: 16px;">
                    Cảm ơn bạn đã quan tâm và tham gia quá trình tuyển dụng!
                </p>

                <p style="margin-top: 16px;">
                    Trân trọng,<br>
                    <strong>{{ $company_name }}</strong>
                </p>
            </div>

            <!-- Footer -->
            <div class="email-footer">
                <p>© {{ date('Y') }} {{ $company_name }}. All rights reserved.</p>
                <p>Đây là email tự động, vui lòng không trả lời email này.</p>
            </div>
        </div>
    </div>
</body>

</html>