<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-pVrmwIFLQ8Cq+0Y7tUNPGYTRG2RorX8JzOaYXDVjzVtT8AhUuNfD7bF6P3LG2dS7zvM5spQtAvt8JL0ZSlE2vQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .register-card {
            display: flex;
            max-width: 1000px;
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            background: white;
        }

        .register-form {
            flex: 1;
            padding: 40px;
        }

        .register-banner {
            flex: 1;
            background: url("{{ asset('assets/img/alt-features.png') }}") no-repeat center center;
            background-size: cover;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);

        }

        .form-control {
            padding-left: 40px;
        }
    </style>
</head>

<body>

    <div class="register-card">
        <!-- Form đăng ký -->
        <div class="register-form">
            <h4 class="text-success">Chào mừng bạn đến với JobIT</h4>
            <p>Cùng xây dựng hồ sơ nổi bật và nhận được cơ hội sự nghiệp lý tưởng</p>

            <form method="POST" action="{{ route('register.submit') }}">
                @csrf

                <!-- Họ và tên -->
                <div class="mb-3">
                    <label class="form-label">Họ và tên</label>
                    <div class="position-relative">
                        <i class="fa-solid fa-circle-user"></i>
                        <input type="text" name="name" class="form-control" placeholder="Nhập họ tên" required>
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <div class="position-relative">
                        <i class="fa-solid fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-control" placeholder="Nhập email" required>
                    </div>
                </div>

                <!-- Mật khẩu -->
                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <div class="position-relative">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu"
                            required>
                    </div>
                </div>

                <!-- Xác nhận mật khẩu -->
                <div class="mb-3">
                    <label class="form-label">Xác nhận mật khẩu</label>
                    <div class="position-relative">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Nhập lại mật khẩu" required>
                    </div>
                </div>

                <!-- Điều khoản -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" required>
                    <label class="form-check-label">
                        Tôi đã đọc và đồng ý với <a href="#">Điều khoản dịch vụ</a> và <a href="#">Chính sách bảo
                            mật</a>
                    </label>
                </div>

                <!-- Nút đăng ký -->
                <button type="submit" class="btn btn-success w-100">Đăng ký</button>

                <p class="mt-3 text-center">
                    Bạn đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a>
                </p>
            </form>
        </div>

        <!-- Banner -->
        <div class="register-banner"></div>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>