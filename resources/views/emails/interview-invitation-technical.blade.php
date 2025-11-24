<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thư mời phỏng vấn kỹ thuật</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #9333ea 0%, #3b82f6 100%);
            color: white;
            padding: 30px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }

        .content {
            background: #ffffff;
            padding: 30px;
            border: 1px solid #e5e7eb;
            border-top: none;
        }

        .info-box {
            background: #f9fafb;
            border-left: 4px solid #9333ea;
            padding: 15px;
            margin: 20px 0;
        }

        .checklist {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 15px;
            margin: 20px 0;
        }

        .checklist ul {
            margin: 10px 0;
            padding-left: 20px;
        }

        .info-row {
            display: flex;
            margin: 10px 0;
        }

        .info-label {
            font-weight: bold;
            min-width: 120px;
            color: #6b7280;
        }

        .footer {
            background: #f9fafb;
            padding: 20px;
            border-radius: 0 0 10px 10px;
            text-align: center;
            font-size: 14px;
            color: #6b7280;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>💻 Lời mời phỏng vấn kỹ thuật</h1>
    </div>

    <div class="content">
        <p>Chào <strong>{{ $candidate_name }}</strong>,</p>

        <p>Chúc mừng! Bạn đã vượt qua vòng sơ tuyển cho vị trí <strong>{{ $job_title }}</strong>.</p>

        <p>Chúng tôi muốn mời bạn tham gia vòng <strong>phỏng vấn kỹ thuật</strong> với các thông tin sau:</p>

        <div class="info-box">
            <div class="info-row">
                <span class="info-label">📅 Thời gian:</span>
                <span>{{ date('d/m/Y', strtotime($date)) }} lúc {{ $time }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">📍 Hình thức:</span>
                <span>{{ $location }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">👥 Người phỏng vấn:</span>
                <span>{{ $interviewers }}</span>
            </div>
        </div>

        <div class="checklist">
            <strong>📋 Nội dung phỏng vấn:</strong>
            <ul>
                <li>Kiểm tra kiến thức chuyên môn</li>
                <li>Kỹ năng giải quyết vấn đề</li>
                <li>Live coding (nếu có)</li>
                <li>Thảo luận về kinh nghiệm dự án</li>
            </ul>
        </div>

        <div class="checklist" style="border-left-color: #10b981; background: #f0fdf4;">
            <strong>✅ Chuẩn bị:</strong>
            <ul>
                <li>Laptop cá nhân (nếu phỏng vấn online/onsite)</li>
                <li>Môi trường code quen thuộc</li>
                <li>Tinh thần thoải mái và tự tin</li>
                <li>Câu hỏi muốn tìm hiểu về công ty</li>
            </ul>
        </div>

        @if($notes)
        <div class="info-box" style="border-left-color: #f59e0b; background: #fffbeb;">
            <strong>📝 Lưu ý thêm:</strong>
            <p style="margin: 10px 0 0 0;">{{ $notes }}</p>
        </div>
        @endif

        <p>Vui lòng xác nhận tham gia trước <strong>{{ date('d/m/Y', strtotime($date . ' -1 day')) }}</strong> bằng cách trả lời email này.</p>

        <p style="margin-top: 30px;">
            Chúc bạn may mắn!<br>
            <strong>{{ $company_name }}</strong>
        </p>
    </div>

    <div class="footer">
        <p>Email này được gửi tự động từ hệ thống tuyển dụng.</p>
        <p>Nếu có bất kỳ thắc mắc nào, vui lòng trả lời trực tiếp email này.</p>
    </div>
</body>

</html>