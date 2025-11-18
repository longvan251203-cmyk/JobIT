<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chào mừng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body {
        background: url("{{ asset('assets/img/welcome.jpg') }}") no-repeat center center;
        background-size: cover;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .welcome-box {
        background: rgba(0, 0, 0, 0.5);
        padding: 40px;
        border-radius: 15px;
        max-width: 800px;
        width: 100%;
    }

    .welcome-title {
        font-size: 2rem;
        font-weight: bold;
    }

    .btn-custom {
        padding: 12px 20px;
        font-size: 1rem;
        border-radius: 30px;
    }

    .feature-btn {
        background-color: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        margin: 5px;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
    }

    .feature-btn:hover {
        background-color: rgba(255, 255, 255, 0.4);
    }
    </style>
</head>

<body>

    <div class="welcome-box text-center">
        <h2 class="welcome-title">
            Chào mừng bạn đến với JobIT, <span class="text-warning">{{ $displayName }}</span>
        </h2>
        <p class="mb-4">Hãy bắt đầu bằng cách cung cấp một số thông tin cơ bản để chúng tôi có thể giúp bạn:</p>

        <!-- Các tính năng -->
        <div class="mb-4">
            <button class="feature-btn">🌟 Trải nghiệm tìm việc cá nhân hóa</button>
            <button class="feature-btn">💼 Gợi ý công việc phù hợp</button>
            <button class="feature-btn">🤖 Hỗ trợ bởi AI</button>
        </div>

        <!-- Nút điều hướng -->
        <div>
            <a href="{{ route('applicant.dashboard') }}" class="btn btn-outline-light btn-custom">
                Tôi sẽ hoàn thiện sau
            </a>

            <a href="#" class="btn btn-warning btn-custom">Bắt đầu</a>
        </div>
    </div>

</body>

</html>