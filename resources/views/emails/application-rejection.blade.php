<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo kết quả ứng tuyển</title>
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
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
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

        .message-box {
            background: #f9fafb;
            border-left: 4px solid #9333ea;
            padding: 15px;
            margin: 20px 0;
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
        <h1>✉️ Thông báo kết quả ứng tuyển</h1>
    </div>

    <div class="content">
        <p>Kính gửi <strong>{{ $candidate_name }}</strong>,</p>

        <p>Cảm ơn bạn đã quan tâm và ứng tuyển vị trí <strong>{{ $job_title }}</strong> tại <strong>{{ $company_name }}</strong>.</p>

        <p>Chúng tôi đã xem xét kỹ lưỡng hồ sơ của bạn và rất ấn tượng với kinh nghiệm cũng như kỹ năng mà bạn sở hữu.</p>

        <p>Tuy nhiên, sau quá trình đánh giá, chúng tôi rất tiếc phải thông báo rằng hồ sơ của bạn chưa phù hợp với yêu cầu của vị trí này tại thời điểm hiện tại.</p>

        <div class="message-box">
            <p style="margin: 0;"><strong>🌟 Đừng nản lòng!</strong></p>
            <p style="margin: 10px 0 0 0;">Chúng tôi đánh giá cao sự quan tâm của bạn và khuyến khích bạn tiếp tục theo dõi các cơ hội nghề nghiệp khác tại công ty chúng tôi. Chúng tôi sẽ lưu giữ hồ sơ của bạn để xem xét cho các vị trí phù hợp hơn trong tương lai.</p>
        </div>

        <p>Một lần nữa, cảm ơn bạn đã dành thời gian ứng tuyển và chúng tôi chúc bạn thành công trong hành trình tìm kiếm việc làm.</p>

        <p style="margin-top: 30px;">
            Trân trọng,<br>
            <strong>{{ $company_name }}</strong>
        </p>
    </div>

    <div class="footer">
        <p>Email này được gửi tự động từ hệ thống tuyển dụng.</p>
        <p>© {{ date('Y') }} {{ $company_name }}. All rights reserved.</p>
    </div>
</body>

</html>