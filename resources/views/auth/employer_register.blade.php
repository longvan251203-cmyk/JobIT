@extends('layouts.app')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .register-wrapper {
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        display: flex;
        position: relative;
        overflow: hidden;
        padding-top: 80px;
    }

    .register-wrapper::before {
        content: '';
        position: absolute;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
        border-radius: 50%;
        top: -250px;
        right: -150px;
        animation: floatOrb 12s ease-in-out infinite;
    }

    .register-wrapper::after {
        content: '';
        position: absolute;
        width: 450px;
        height: 450px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        bottom: -150px;
        left: -120px;
        animation: floatOrb 15s ease-in-out infinite reverse;
    }

    @keyframes floatOrb {

        0%,
        100% {
            transform: translate(0, 0) scale(1);
            opacity: 0.8;
        }

        50% {
            transform: translate(30px, -40px) scale(1.1);
            opacity: 1;
        }
    }

    .register-left {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 40px 60px;
        color: white;
        position: relative;
        z-index: 1;
    }

    .brand-section {
        text-align: center;
        max-width: 550px;
        animation: fadeInUp 0.8s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .floating-illustration {
        position: relative;
        width: 100%;
        max-width: 400px;
        height: 350px;
        margin-top: 40px;
    }

    .illustration-circle {
        position: absolute;
        border-radius: 50%;
        animation: floatSlow 6s ease-in-out infinite;
    }

    .circle-1 {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.05));
        top: 20%;
        left: 10%;
        animation-delay: 0s;
    }

    .circle-2 {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.03));
        top: 60%;
        right: 15%;
        animation-delay: 1s;
    }

    .circle-3 {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.25), rgba(255, 255, 255, 0.08));
        bottom: 15%;
        left: 25%;
        animation-delay: 2s;
    }

    @keyframes floatSlow {

        0%,
        100% {
            transform: translateY(0) scale(1);
        }

        50% {
            transform: translateY(-20px) scale(1.05);
        }
    }

    .illustration-icon {
        position: absolute;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        animation: floatIcon 4s ease-in-out infinite;
    }

    .icon-1 {
        top: 10%;
        right: 20%;
        animation-delay: 0.5s;
    }

    .icon-2 {
        bottom: 25%;
        right: 10%;
        animation-delay: 1.5s;
    }

    .icon-3 {
        top: 50%;
        left: 5%;
        animation-delay: 2.5s;
    }

    .illustration-icon svg {
        width: 40px;
        height: 40px;
        fill: white;
        opacity: 0.9;
    }

    @keyframes floatIcon {

        0%,
        100% {
            transform: translateY(0) rotate(0deg);
        }

        50% {
            transform: translateY(-15px) rotate(5deg);
        }
    }

    .brand-logo {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        font-size: 56px;
        font-weight: 900;
        margin-bottom: 30px;
        letter-spacing: -2px;
    }

    .brand-logo-icon {
        width: 56px;
        height: 56px;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    }

    .brand-logo-icon svg {
        width: 32px;
        height: 32px;
        fill: #667eea;
    }

    .brand-logo-text {
        background: linear-gradient(to right, #fff, #f3f4ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .brand-tagline {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 20px;
        line-height: 1.4;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
    }

    .brand-description {
        font-size: 17px;
        line-height: 1.8;
        opacity: 0.95;
        margin-bottom: 50px;
        font-weight: 400;
    }

    .feature-list {
        text-align: left;
        display: inline-block;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        padding: 35px 40px;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .feature-item {
        display: flex;
        align-items: center;
        margin-bottom: 24px;
        font-size: 16px;
        font-weight: 500;
        transition: transform 0.3s ease;
    }

    .feature-item:last-child {
        margin-bottom: 0;
    }

    .feature-item:hover {
        transform: translateX(8px);
    }

    .feature-icon {
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.15));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
        flex-shrink: 0;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .feature-icon svg {
        width: 20px;
        height: 20px;
        stroke: white;
        stroke-width: 3;
        fill: none;
    }

    .register-right {
        flex: 1;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 60px 60px;
        position: relative;
        z-index: 1;
        box-shadow: -10px 0 40px rgba(0, 0, 0, 0.1);
    }

    .register-form-container {
        width: 100%;
        max-width: 520px;
    }

    .form-header {
        margin-bottom: 45px;
        text-align: center;
    }

    .form-title {
        font-size: 36px;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 12px;
    }

    .form-subtitle {
        font-size: 16px;
        color: #64748b;
        font-weight: 500;
    }

    .alert-box {
        background: linear-gradient(135deg, #fff5f5 0%, #fee 100%);
        border: 2px solid #fecaca;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 35px;
        position: relative;
        overflow: hidden;
    }

    .alert-box::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 5px;
        background: linear-gradient(to bottom, #ef4444, #dc2626);
    }

    .alert-title {
        font-weight: 700;
        color: #991b1b;
        font-size: 15px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
    }

    .alert-title svg {
        width: 22px;
        height: 22px;
        margin-right: 10px;
        fill: #dc2626;
    }

    .alert-text {
        font-size: 14px;
        color: #7f1d1d;
        line-height: 1.7;
        margin-bottom: 14px;
    }

    .alert-text strong {
        color: #991b1b;
        font-weight: 700;
    }

    .alert-note {
        font-size: 13px;
        color: #991b1b;
        line-height: 1.6;
        background: rgba(239, 68, 68, 0.1);
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 16px;
    }

    .contact-info {
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
    }

    .contact-phone {
        display: flex;
        align-items: center;
        font-size: 14px;
        color: #667eea;
        font-weight: 700;
        background: rgba(102, 126, 234, 0.1);
        padding: 8px 14px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .contact-phone:hover {
        background: rgba(102, 126, 234, 0.15);
        transform: translateY(-2px);
    }

    .contact-phone svg {
        width: 18px;
        height: 18px;
        margin-right: 8px;
        fill: #667eea;
    }

    .form-section-title {
        font-size: 18px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 24px;
        margin-top: 40px;
        padding-bottom: 12px;
        border-bottom: 3px solid #e2e8f0;
        position: relative;
    }

    .form-section-title::after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 80px;
        height: 3px;
        background: linear-gradient(to right, #667eea, #764ba2);
        border-radius: 3px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 10px;
    }

    .form-label .required {
        color: #ef4444;
        margin-left: 4px;
        font-size: 16px;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        pointer-events: none;
        transition: color 0.3s ease;
    }

    .input-icon svg {
        width: 20px;
        height: 20px;
        stroke: currentColor;
        fill: none;
        stroke-width: 2;
    }

    .form-input {
        width: 100%;
        padding: 14px 16px 14px 48px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        color: #1e293b;
        transition: all 0.3s ease;
        background: #f8fafc;
        font-weight: 500;
    }

    .form-input:hover {
        border-color: #cbd5e1;
        background: white;
    }

    .form-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        background: white;
    }

    .form-input.error {
        border-color: #ef4444;
        background: #fef2f2;
    }

    .form-input:focus+.input-icon {
        color: #667eea;
    }

    .password-toggle {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #94a3b8;
        transition: all 0.3s ease;
        padding: 4px;
    }

    .password-toggle:hover {
        color: #667eea;
        transform: translateY(-50%) scale(1.1);
    }

    .password-toggle svg {
        width: 20px;
        height: 20px;
        stroke: currentColor;
        fill: none;
        stroke-width: 2;
    }

    .error-message {
        font-size: 13px;
        color: #ef4444;
        margin-top: 8px;
        display: flex;
        align-items: center;
        font-weight: 600;
    }

    .error-message svg {
        width: 16px;
        height: 16px;
        margin-right: 6px;
        fill: currentColor;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    .radio-group {
        display: flex;
        gap: 24px;
        margin-top: 10px;
    }

    .radio-item {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #f8fafc;
    }

    .radio-item:hover {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.05);
    }

    .radio-item input[type="radio"] {
        width: 20px;
        height: 20px;
        margin-right: 10px;
        cursor: pointer;
        accent-color: #667eea;
    }

    .radio-item input[type="radio"]:checked+label {
        color: #667eea;
        font-weight: 700;
    }

    .radio-item:has(input:checked) {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.1);
    }

    .radio-item label {
        font-size: 15px;
        color: #1e293b;
        cursor: pointer;
        font-weight: 600;
    }

    .form-select {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        color: #1e293b;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .form-select:hover {
        border-color: #cbd5e1;
        background: white;
    }

    .form-select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        background: white;
    }

    .terms-checkbox {
        display: flex;
        align-items: flex-start;
        margin: 30px 0;
        padding: 20px;
        background: #f8fafc;
        border-radius: 12px;
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .terms-checkbox:hover {
        border-color: #cbd5e1;
    }

    .terms-checkbox input[type="checkbox"] {
        width: 22px;
        height: 22px;
        margin-right: 12px;
        margin-top: 2px;
        cursor: pointer;
        accent-color: #667eea;
        flex-shrink: 0;
    }

    .terms-text {
        font-size: 14px;
        color: #475569;
        line-height: 1.7;
        font-weight: 500;
    }

    .terms-text a {
        color: #667eea;
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .terms-text a:hover {
        color: #764ba2;
        text-decoration: underline;
    }

    .btn-submit {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 12px;
        color: white;
        font-size: 17px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.35);
        position: relative;
        overflow: hidden;
    }

    .btn-submit::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s ease;
    }

    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 32px rgba(102, 126, 234, 0.45);
    }

    .btn-submit:hover::before {
        left: 100%;
    }

    .btn-submit:active {
        transform: translateY(-1px);
    }

    .divider {
        text-align: center;
        margin: 32px 0;
        position: relative;
    }

    .divider::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 2px;
        background: linear-gradient(to right, transparent, #e2e8f0, transparent);
    }

    .divider-text {
        background: white;
        padding: 0 20px;
        color: #64748b;
        font-size: 14px;
        position: relative;
        font-weight: 600;
    }

    .btn-google {
        width: 100%;
        padding: 14px;
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        color: #1e293b;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .btn-google:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .btn-google svg {
        width: 20px;
        height: 20px;
    }

    .login-link {
        text-align: center;
        margin-top: 32px;
        font-size: 15px;
        color: #64748b;
        font-weight: 500;
    }

    .login-link a {
        color: #667eea;
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .login-link a:hover {
        color: #764ba2;
        text-decoration: underline;
    }

    @media (max-width: 1200px) {
        .register-left {
            padding: 60px 40px;
        }

        .register-right {
            padding: 60px 40px;
        }
    }

    @media (max-width: 1024px) {
        .register-wrapper {
            padding-top: 80px;
        }

        .register-left {
            display: none;
        }

        .register-right {
            flex: 1;
            min-height: calc(100vh - 80px);
        }
    }

    @media (max-width: 768px) {
        .register-right {
            padding: 40px 24px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .form-title {
            font-size: 28px;
        }

        .radio-group {
            flex-direction: column;
            gap: 12px;
        }
    }

    @media (max-width: 480px) {
        .register-right {
            padding: 30px 20px;
        }

        .form-title {
            font-size: 24px;
        }

        .brand-logo {
            font-size: 42px;
        }

        .contact-info {
            flex-direction: column;
            gap: 12px;
        }
    }
</style>

<div class="register-wrapper">
    <div class="register-left">
        <div class="brand-section">
            <div class="brand-logo">
                <div class="brand-logo-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M20 7h-4V4c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v3H4c-1.1 0-2 .9-2 2v11c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V9c0-1.1-.9-2-2-2zM10 4h4v3h-4V4zm10 16H4V9h16v11z" />
                        <path d="M12 12c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                    </svg>
                </div>
                <span class="brand-logo-text">JobIT</span>
            </div>
            <h2 class="brand-tagline">Đăng ký tài khoản Nhà tuyển dụng</h2>
            <p class="brand-description">
                Kết nối với hàng nghìn ứng viên IT tài năng. Tối ưu quy trình tuyển dụng của bạn với công nghệ AI và nền tảng quản lý thông minh.
            </p>
            <div class="feature-list">
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <span>Tiếp cận ứng viên IT chất lượng cao</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <span>Công cụ tuyển dụng thông minh với AI</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <span>Quản lý ứng viên hiệu quả & dễ dàng</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <span>Hỗ trợ tư vấn 24/7 chuyên nghiệp</span>
                </div>
            </div>

            <div class="floating-illustration">
                <div class="illustration-circle circle-1"></div>
                <div class="illustration-circle circle-2"></div>
                <div class="illustration-circle circle-3"></div>

                <div class="illustration-icon icon-1">
                    <svg viewBox="0 0 24 24">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <polyline points="17 11 19 13 23 9"></polyline>
                    </svg>
                </div>

                <div class="illustration-icon icon-2">
                    <svg viewBox="0 0 24 24">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                    </svg>
                </div>

                <div class="illustration-icon icon-3">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
                        <path d="M2 17l10 5 10-5M2 12l10 5 10-5"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="register-right">
        <div class="register-form-container">
            <div class="form-header">
                <h1 class="form-title">Đăng ký tài khoản</h1>
                <p class="form-subtitle">Bắt đầu tuyển dụng nhân tài IT ngay hôm nay</p>
            </div>

            <div class="alert-box">
                <div class="alert-title">
                    <svg viewBox="0 0 24 24">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                    Quy định quan trọng
                </div>
                <p class="alert-text">
                    Để đảm bảo chất lượng dịch vụ, JobIT <strong>không cho phép một người dùng tạo nhiều tài khoản khác nhau.</strong>
                </p>
                <p class="alert-note">
                    ⚠️ Nếu phát hiện vi phạm, JobIT sẽ ngừng cung cấp dịch vụ tới tất cả các tài khoản trùng lặp hoặc chặn toàn bộ truy cập tới hệ thống.
                </p>
                <div class="contact-info">
                    <div class="contact-phone">
                        <svg viewBox="0 0 24 24">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        (024) 71079799
                    </div>
                    <div class="contact-phone">
                        <svg viewBox="0 0 24 24">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        0862 691929
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('employer.register.submit') }}">
                @csrf

                <div class="form-section-title">Thông tin tài khoản</div>

                <div class="form-group">
                    <label class="form-label">
                        Email đăng nhập<span class="required">*</span>
                    </label>
                    <div class="input-wrapper">
                        <input type="email"
                            name="email"
                            class="form-input @error('email') error @enderror"
                            value="{{ old('email') }}"
                            placeholder="example@company.com"
                            required>
                        <div class="input-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                    </div>
                    @error('email')
                    <div class="error-message">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        {{ $message }}
                    </div>
                    @enderror
                    <div class="error-message" style="display: none;" id="email-error">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        Email đăng nhập không đúng định dạng
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Mật khẩu<span class="required">*</span>
                    </label>
                    <div class="input-wrapper">
                        <input type="password"
                            name="password"
                            id="password"
                            class="form-input @error('password') error @enderror"
                            placeholder="Mật khẩu (tối thiểu 8 ký tự)"
                            required>
                        <div class="input-icon">
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </div>
                        <div class="password-toggle" onclick="togglePassword('password')">
                            <svg viewBox="0 0 24 24" id="eye-password">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </div>
                    </div>
                    @error('password')
                    <div class="error-message">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Nhập lại mật khẩu<span class="required">*</span>
                    </label>
                    <div class="input-wrapper">
                        <input type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="form-input"
                            placeholder="Nhập lại mật khẩu"
                            required>
                        <div class="input-icon">
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </div>
                        <div class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <svg viewBox="0 0 24 24" id="eye-password_confirmation">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="form-section-title">Thông tin nhà tuyển dụng</div>

                <div class="form-group">
                    <label class="form-label">
                        Họ và tên<span class="required">*</span>
                    </label>
                    <div class="input-wrapper">
                        <input type="text"
                            name="name"
                            class="form-input @error('name') error @enderror"
                            value="{{ old('name') }}"
                            placeholder="Nhập họ và tên đầy đủ"
                            required>
                        <div class="input-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                    </div>
                    @error('name')
                    <div class="error-message">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            Giới tính<span class="required">*</span>
                        </label>
                        <div class="radio-group">
                            <div class="radio-item">
                                <input type="radio" id="male" name="gender" value="male" checked>
                                <label for="male">Nam</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" id="female" name="gender" value="female">
                                <label for="female">Nữ</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Số điện thoại<span class="required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <input type="tel"
                                name="phone"
                                class="form-input"
                                placeholder="0123 456 789"
                                required>
                            <div class="input-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Tên công ty<span class="required">*</span>
                    </label>
                    <div class="input-wrapper">
                        <input type="text"
                            name="company"
                            class="form-input"
                            placeholder="Nhập tên công ty của bạn"
                            required>
                        <div class="input-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            Thành phố<span class="required">*</span>
                        </label>
                        <input type="text" name="location" class="form-control" placeholder="Nhập tên tỉnh/thành phố" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Quận/Huyện
                        </label>
                        <input type="text" name="district" class="form-control" placeholder="Nhập tên quận/huyện">
                    </div>
                </div>


                <div class="terms-checkbox">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms" class="terms-text">
                        Tôi đã đọc và đồng ý với <a href="#">Điều khoản dịch vụ</a> và <a href="#">Chính sách bảo mật</a> của JobIT.
                    </label>
                </div>

                <button type="submit" class="btn-submit">Đăng ký ngay</button>

                <div class="divider">
                    <span class="divider-text">Hoặc đăng ký với</span>
                </div>

                <button type="button" class="btn-google" onclick="loginWithGoogle()">
                    <svg viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                    </svg>
                    Đăng ký bằng Google
                </button>

                <div class="login-link">
                    Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById('eye-' + fieldId);

        if (field.type === 'password') {
            field.type = 'text';
            icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
        } else {
            field.type = 'password';
            icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
        }
    }

    function loginWithGoogle() {
        alert('Chức năng đăng nhập bằng Google đang được phát triển');
    }

    // Email validation
    const emailInput = document.querySelector('input[name="email"]');
    const emailError = document.getElementById('email-error');

    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (this.value && !emailRegex.test(this.value)) {
                emailError.style.display = 'flex';
                this.classList.add('error');
            } else {
                emailError.style.display = 'none';
                this.classList.remove('error');
            }
        });
    }

    // Dynamic district loading
    const locationSelect = document.querySelector('select[name="location"]');
    const districtSelect = document.querySelector('select[name="district"]');

    const districts = {
        hanoi: ['Ba Đình', 'Hoàn Kiếm', 'Tây Hồ', 'Long Biên', 'Cầu Giấy', 'Đống Đa', 'Hai Bà Trưng', 'Hoàng Mai', 'Thanh Xuân', 'Nam Từ Liêm', 'Bắc Từ Liêm', 'Hà Đông'],
        hochiminh: ['Quận 1', 'Quận 2', 'Quận 3', 'Quận 4', 'Quận 5', 'Quận 6', 'Quận 7', 'Quận 8', 'Quận 9', 'Quận 10', 'Quận 11', 'Quận 12', 'Bình Thạnh', 'Gò Vấp', 'Phú Nhuận', 'Tân Bình', 'Tân Phú', 'Thủ Đức'],
        danang: ['Hải Châu', 'Thanh Khê', 'Sơn Trà', 'Ngũ Hành Sơn', 'Liên Chiểu', 'Cẩm Lệ', 'Hòa Vang'],
        haiphong: ['Hồng Bàng', 'Ngô Quyền', 'Lê Chân', 'Hải An', 'Kiến An', 'Đồ Sơn', 'Dương Kinh'],
        cantho: ['Ninh Kiều', 'Bình Thủy', 'Cái Răng', 'Ô Môn', 'Thốt Nốt']
    };

    if (locationSelect && districtSelect) {
        locationSelect.addEventListener('change', function() {
            districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';

            if (this.value && districts[this.value]) {
                districts[this.value].forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.toLowerCase().replace(/\s+/g, '-');
                    option.textContent = district;
                    districtSelect.appendChild(option);
                });
            }
        });
    }

    // Form validation
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const passwordConfirm = document.getElementById('password_confirmation').value;

            if (password !== passwordConfirm) {
                e.preventDefault();
                alert('Mật khẩu xác nhận không khớp!');
                return false;
            }

            if (password.length < 8) {
                e.preventDefault();
                alert('Mật khẩu phải có ít nhất 8 ký tự!');
                return false;
            }

            const terms = document.getElementById('terms');
            if (!terms.checked) {
                e.preventDefault();
                alert('Vui lòng đồng ý với Điều khoản dịch vụ và Chính sách bảo mật!');
                return false;
            }
        });
    }

    // Add smooth animations on scroll
    window.addEventListener('load', function() {
        const formGroups = document.querySelectorAll('.form-group');
        formGroups.forEach((group, index) => {
            group.style.opacity = '0';
            group.style.transform = 'translateY(20px)';
            setTimeout(() => {
                group.style.transition = 'all 0.5s ease';
                group.style.opacity = '1';
                group.style.transform = 'translateY(0)';
            }, index * 50);
        });
    });
</script>
@endsection