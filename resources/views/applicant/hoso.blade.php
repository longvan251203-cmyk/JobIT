<!DOCTYPE html>
<html lang="vi">

@include('applicant.partials.head')

<style>
    /* Custom style cho ngoại ngữ section */
    /* Custom style cho ngoại ngữ section */
    #mota_duan {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        resize: vertical;
    }

    #mota_duan:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
    }

    /* Button insert template */
    #insertTemplateBtn {
        transition: all 0.3s ease;
    }

    #insertTemplateBtn:hover {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    #selectedLanguages .badge {
        font-size: 0.9rem;
    }

    .removeLanguageBtn:hover {
        opacity: 0.8;
    }

    .deleteNgoaiNguBtn {
        text-decoration: none;
    }

    .deleteNgoaiNguBtn:hover {
        transform: scale(1.1);
    }

    :root {
        --primary-color: #4f46e5;
        --secondary-color: #06b6d4;
        --accent-color: #f59e0b;
        --dark-bg: #0f172a;
        --light-bg: #f8fafc;
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        --hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        min-height: 100vh;
    }

    .main {
        padding: 2rem 0;
    }

    /* Sidebar Card */
    .sidebar-card-modern {
        background: white;
        border-radius: 24px !important;
        box-shadow: var(--card-shadow) !important;
        border: none !important;
        transition: all 0.3s ease;
    }

    .sidebar-card-modern:hover {
        box-shadow: var(--hover-shadow) !important;
        transform: translateY(-4px);
    }

    .avatar-wrapper-modern {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 1rem;
    }

    .avatar-wrapper-modern img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid var(--primary-color);
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
    }

    .status-badge-modern {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 24px;
        height: 24px;
        background: #10b981;
        border: 3px solid white;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
    }

    .nav-link {
        border-radius: 12px;
        padding: 0.75rem 1rem;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .nav-link:hover {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white !important;
        transform: translateX(5px);
    }

    .nav-link.active {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white !important;
    }

    /* Profile Cards */
    .card.shadow-sm {
        background: white;
        border-radius: 24px !important;
        box-shadow: var(--card-shadow) !important;
        border: none !important;
        transition: all 0.3s ease;
    }

    .card.shadow-sm:hover {
        box-shadow: var(--hover-shadow) !important;
        transform: translateY(-4px);
    }

    /* Header Card with Gradient */
    .header-card-gradient {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
        color: white !important;
        position: relative;
        overflow: hidden;
    }

    .header-card-gradient::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .header-card-gradient .card-body {
        position: relative;
        z-index: 1;
    }

    .profile-avatar-modern {
        width: 140px;
        height: 140px;
        border-radius: 24px;
        object-fit: cover;
        border: 5px solid white;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    /* Section Headers */
    .section-header-modern {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .section-icon-modern {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    /* Buttons Modern */
    .btn-modern {
        border-radius: 12px !important;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-primary,
    .btn-danger {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
        border: none !important;
    }

    .btn-primary:hover,
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(79, 70, 229, 0.4) !important;
    }

    .btn-outline-primary {
        border: 2px solid var(--primary-color) !important;
        color: var(--primary-color) !important;
    }

    .btn-outline-primary:hover {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
        color: white !important;
        border-color: transparent !important;
    }

    .btn-light.rounded-circle {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
        color: white !important;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
    }

    .btn-light.rounded-circle:hover {
        transform: rotate(90deg) scale(1.1);
        box-shadow: 0 8px 25px rgba(79, 70, 229, 0.5) !important;
    }

    /* Timeline Design */
    .timeline-item-modern {
        position: relative;
        padding-left: 2.5rem;
        padding-bottom: 1.5rem;
        border-left: 3px solid var(--primary-color);
    }

    .timeline-item-modern:last-child {
        border-left: 3px solid transparent;
    }

    .timeline-dot-modern {
        position: absolute;
        left: -9px;
        top: 0;
        width: 18px;
        height: 18px;
        background: var(--primary-color);
        border: 4px solid white;
        border-radius: 50%;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.2);
    }

    .timeline-content-modern {
        background: var(--light-bg);
        padding: 1.5rem;
        border-radius: 16px;
        transition: all 0.3s ease;
    }

    .timeline-content-modern:hover {
        background: white;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        transform: translateX(5px);
    }

    /* Skills Badge */
    .badge.bg-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
        padding: 0.6rem 1.2rem !important;
        border-radius: 50px !important;
        font-weight: 600 !important;
        transition: all 0.3s ease;
    }

    .badge.bg-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(79, 70, 229, 0.4);
    }

    /* Info Tags */
    .info-tag-modern {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        margin: 0.25rem;
        color: white;
    }

    .info-tag-modern i {
        opacity: 0.9;
    }

    /* Modal Styling */
    .modal-content {
        border-radius: 24px !important;
        border: none !important;
    }

    .modal-header {
        border-radius: 24px 24px 0 0 !important;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border-bottom: none !important;
    }

    /* Animations */
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

    .card {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .main {
            padding: 1rem 0;
        }

        .card {
            margin-bottom: 1rem !important;
        }
    }
</style>

<body>
    @include('applicant.partials.header')

    <main class="main">
        <div class="container-fluid">
            <div class="row">

                <!-- Sidebar -->
                <div class="col-md-3 col-lg-3 mb-4">
                    <div class="card sidebar-card-modern shadow-sm border-0 rounded-3">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="avatar-wrapper-modern">
                                    <img src="{{ $applicant->avatar ? asset('assets/img/avt/'.$applicant->avatar) : asset('assets/img/avt/default-avatar.png') }}"
                                        alt="Avatar">
                                    <div class="status-badge-modern"></div>
                                </div>
                                <h5 class="fw-bold">{{ $applicant->hoten_uv ?? 'Ứng viên' }}</h5>
                                <p class="text-secondary small mb-1">{{ Auth::user()->email }}</p>
                            </div>

                            <hr>
                            <ul class="nav flex-column">
                                <li class="nav-item mb-2">
                                    <a href="{{ route('applicant.profile') }}" class="nav-link text-dark">
                                        <i class="bi bi-grid"></i> Tổng quan
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="{{ route('applicant.hoso') }}" class="nav-link active fw-bold text-primary">
                                        <i class="bi bi-person-badge"></i> Thông tin cá nhân
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#" class="nav-link text-dark"><i class="bi bi-file-earmark-text"></i> Hồ sơ đính kèm</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="{{ route('applicant.myJobs') }}" class="nav-link text-dark"><i class="bi bi-briefcase"></i> Việc làm của tôi</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#" class="nav-link text-dark"><i class="bi bi-envelope"></i> Lời mời công việc</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#" class="nav-link text-dark"><i class="bi bi-bell"></i> Thông báo</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link text-dark"><i class="bi bi-gear"></i> Cài đặt</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Nội dung chính -->
                <div class="col-md-9 col-lg-9">

                    <!-- Thông tin cá nhân -->
                    <div class="card header-card-gradient shadow-sm border-0 rounded-3 mb-4">
                        <div class="card-body row align-items-center">

                            <!-- Avatar bên trái -->
                            <div class="col-md-3 text-center">
                                <img src="{{ $applicant->avatar ? asset('assets/img/avt/'.$applicant->avatar) : asset('assets/img/avt/default-avatar.png') }}"
                                    alt="Avatar"
                                    class="profile-avatar-modern">
                            </div>

                            <!-- Thông tin cá nhân -->
                            <div class="col-md-9">
                                <h2 class="fw-bold mb-2">{{ $applicant->hoten_uv ?? 'Họ tên ứng viên' }}</h2>
                                <p class="mb-3 opacity-90">{{ $applicant->chucdanh ?? 'Chưa cập nhật chức danh' }}</p>

                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span class="info-tag-modern">
                                        <i class="bi bi-envelope"></i> {{ Auth::user()->email }}
                                    </span>
                                    <span class="info-tag-modern">
                                        <i class="bi bi-telephone"></i> {{ $applicant->sdt_uv ?? 'Chưa cập nhật' }}
                                    </span>
                                    <span class="info-tag-modern">
                                        <i class="bi bi-calendar"></i> {{ $applicant->ngaysinh ?? 'Chưa cập nhật' }}
                                    </span>
                                    <span class="info-tag-modern">
                                        <i class="bi bi-gender-ambiguous"></i> {{ $applicant->gioitinh_uv ?? 'Chưa cập nhật' }}
                                    </span>
                                    <span class="info-tag-modern">
                                        <i class="bi bi-geo-alt"></i> {{ $applicant->diachi_uv ?? 'Chưa cập nhật' }}
                                    </span>
                                </div>

                                <!-- Nút chỉnh sửa -->
                                <a href="#" class="btn btn-light btn-modern btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                    <i class="bi bi-pencil-square"></i> Chỉnh sửa hồ sơ
                                </a>
                                <a href="#" class="btn btn-light btn-modern btn-sm" data-bs-toggle="modal" data-bs-target="#viewCVModal">
                                    <i class="bi bi-file-earmark-person"></i> Xem CV
                                </a>
                            </div>

                        </div>
                    </div>
                    <!-- Giới thiệu bản thân -->
                    <div class="card shadow-sm border-0 rounded-3 mb-3">
                        <div class="card-body d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="section-header-modern">
                                    <div class="section-icon-modern">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0">Giới thiệu bản thân</h5>
                                </div>
                                <p class="text-muted mb-0">
                                    {!! $applicant->gioithieu ?? 'Chưa có nội dung.' !!}
                                </p>
                            </div>
                            <a href="#" class="btn btn-light rounded-circle shadow-sm ms-3" data-bs-toggle="modal" data-bs-target="#editGioiThieuModal">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Học vấn Section -->
                    <div class="card shadow-sm border-0 rounded-3 mb-3">
                        <div class="card-body d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="section-header-modern">
                                    <div class="section-icon-modern">
                                        <i class="bi bi-mortarboard"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0">Học vấn</h5>
                                </div>

                                @if(isset($hocvan) && count($hocvan) > 0)
                                @foreach($hocvan as $hv)
                                <div class="timeline-item-modern">
                                    <div class="timeline-dot-modern"></div>
                                    <div class="timeline-content-modern">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <p class="mb-1">
                                                    <strong>{{ $hv->truong }}</strong><br>
                                                    {{ $hv->nganh }} - {{ $hv->trinhdo }}<br>
                                                    {{ date('m/Y', strtotime($hv->tu_ngay)) }} -
                                                    {{ $hv->dang_hoc ? 'Hiện tại' : date('m/Y', strtotime($hv->den_ngay)) }}
                                                    @if(!empty($hv->thongtin_khac))
                                                    <br><span class="text-muted fst-italic">{{ $hv->thongtin_khac }}</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="ms-3">
                                                <!-- Nút Sửa -->
                                                <button class="btn btn-sm btn-outline-primary editHocVanBtn me-1"
                                                    data-id="{{ $hv->id_hocvan }}"
                                                    title="Chỉnh sửa">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <!-- Nút Xóa -->
                                                <form action="{{ route('hocvan.delete', $hv->id_hocvan) }}"
                                                    method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Bạn có chắc muốn xóa học vấn này?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <p class="text-muted mb-0">Chưa có nội dung.</p>
                                @endif
                            </div>

                            <!-- Nút thêm -->
                            <a href="#" class="btn btn-light rounded-circle shadow-sm ms-3"
                                data-bs-toggle="modal"
                                data-bs-target="#addHocVanModal">
                                <i class="bi bi-plus-lg"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Kinh nghiệm làm việc -->
                    <div class="card shadow-sm border-0 rounded-3 mb-3">
                        <div class="card-body d-flex justify-content-between align-items-start">
                            <div class="w-100">
                                <div class="section-header-modern">
                                    <div class="section-icon-modern">
                                        <i class="bi bi-briefcase"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0">Kinh nghiệm làm việc</h5>
                                </div>

                                @if(isset($kinhnghiem) && count($kinhnghiem) > 0)
                                @foreach($kinhnghiem as $kn)
                                <div class="timeline-item-modern">
                                    <div class="timeline-dot-modern"></div>
                                    <div class="timeline-content-modern">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <!-- Chức danh + Công ty -->
                                                <p class="mb-1">
                                                    <strong class="text-dark fs-6">{{ $kn->chucdanh }}</strong>
                                                    <span class="text-muted"> - {{ $kn->congty }}</span>
                                                </p>

                                                <!-- Thời gian -->
                                                <p class="text-muted small mb-2">
                                                    <i class="bi bi-calendar me-1"></i>
                                                    {{ date('m/Y', strtotime($kn->tu_ngay)) }} -
                                                    {{ $kn->dang_lam_viec ? 'Hiện tại' : date('m/Y', strtotime($kn->den_ngay)) }}
                                                </p>

                                                <!-- Mô tả -->
                                                @if(!empty($kn->mota))
                                                <p class="mb-2">
                                                    <span class="fw-semibold">Mô tả:</span><br>
                                                    {!! nl2br(e($kn->mota)) !!}
                                                </p>
                                                @endif

                                                <!-- Dự án -->
                                                @if(!empty($kn->duan))
                                                <p class="mb-0">
                                                    <span class="fw-semibold">Dự án đã tham gia:</span><br>
                                                    {!! nl2br(e($kn->duan)) !!}
                                                </p>
                                                @endif
                                            </div>

                                            <!-- Nút Sửa & Xóa -->
                                            <div class="ms-3">
                                                <!-- Nút Sửa -->
                                                <button class="btn btn-sm btn-outline-primary editKinhNghiemBtn me-1"
                                                    data-id="{{ $kn->id_kn }}"
                                                    title="Chỉnh sửa">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <!-- Nút Xóa -->
                                                <form action="{{ route('kinhnghiem.delete', $kn->id_kn) }}"
                                                    method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Bạn có chắc muốn xóa kinh nghiệm này?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <p class="text-muted mb-0">Chưa có nội dung.</p>
                                @endif
                            </div>

                            <!-- Nút mở modal thêm -->
                            <a href="#" class="btn btn-light rounded-circle shadow-sm ms-3"
                                data-bs-toggle="modal" data-bs-target="#addKinhNghiemModal">
                                <i class="bi bi-plus-lg"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Section Kỹ năng -->
                    <div class="card shadow-sm border-0 rounded-3 mb-3">
                        <div class="card-body d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="section-header-modern">
                                    <div class="section-icon-modern">
                                        <i class="bi bi-lightbulb"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0">Kỹ năng</h5>
                                </div>
                                @if(isset($kynang) && count($kynang) > 0)
                                <div>
                                    @foreach($kynang as $kn)
                                    <span class="badge bg-primary fs-6 me-1 mb-2">
                                        <strong>{{ $kn->ten_ky_nang }}</strong>
                                        ({{ $kn->nam_kinh_nghiem == 0 ? '<1 năm' : $kn->nam_kinh_nghiem . ' năm' }})
                                    </span>
                                    @endforeach
                                </div>
                                @else
                                <p class="text-muted mb-0">Chưa có kỹ năng nào.</p>
                                @endif
                            </div>

                            <!-- Nút mở modal -->
                            <a href="#" class="btn btn-light rounded-circle shadow-sm ms-3" data-bs-toggle="modal" data-bs-target="#addKyNangModal">
                                <i class="bi bi-plus-lg"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Section Ngoại Ngữ - PHIÊN BẢN SỬA LỖI HIỂN THỊ -->
                    <div class="card shadow-sm border-0 rounded-3 mb-3">
                        <div class="card-body d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="section-header-modern">
                                    <div class="section-icon-modern">
                                        <i class="bi bi-translate"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0">Ngoại ngữ</h5>
                                </div>

                                @if(isset($ngoaiNgu) && $ngoaiNgu->count() > 0)
                                <div class="mt-3">
                                    @foreach($ngoaiNgu as $nn)
                                    <div class="d-inline-flex align-items-center badge bg-primary text-white me-2 mb-2 p-2 fs-6">
                                        <div class="me-2">
                                            <strong>{{ $nn->ten_ngoai_ngu }}</strong>
                                            <span class="opacity-75"> - {{ $nn->trinh_do }}</span>
                                        </div>
                                        <button type="button"
                                            class="btn btn-sm btn-link text-white p-0 deleteNgoaiNguBtn"
                                            data-id="{{ $nn->ngoai_ngu_id }}"
                                            title="Xóa">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <p class="text-muted mb-0">Chưa có ngoại ngữ nào.</p>
                                @endif
                            </div>

                            <!-- Nút mở modal -->
                            <a href="#" class="btn btn-light rounded-circle shadow-sm ms-3"
                                data-bs-toggle="modal" data-bs-target="#addNgoaiNguModal">
                                <i class="bi bi-plus-lg"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Section Dự Án Nổi Bật -->
                    <div class="card shadow-sm border-0 rounded-3 mb-3">
                        <div class="card-body d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="section-header-modern">
                                    <div class="section-icon-modern">
                                        <i class="bi bi-kanban"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0">Dự án nổi bật</h5>
                                </div>

                                @if(isset($duAn) && count($duAn) > 0)
                                @foreach($duAn as $da)
                                <div class="timeline-item-modern">
                                    <div class="timeline-dot-modern"></div>
                                    <div class="timeline-content-modern">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <!-- Tên dự án -->
                                                <p class="mb-1">
                                                    <strong class="text-dark fs-6">{{ $da->ten_duan }}</strong>
                                                </p>

                                                <!-- Thời gian -->
                                                <p class="text-muted small mb-2">
                                                    <i class="bi bi-calendar me-1"></i>
                                                    {{ date('m/Y', strtotime($da->ngay_bat_dau)) }} -
                                                    {{ $da->dang_lam ? 'Hiện tại' : date('m/Y', strtotime($da->ngay_ket_thuc)) }}
                                                </p>

                                                <!-- Mô tả -->
                                                @if(!empty($da->mota_duan))
                                                <div class="mb-2">
                                                    {!! nl2br(e($da->mota_duan)) !!}
                                                </div>
                                                @endif

                                                <!-- Link website -->
                                                @if(!empty($da->duongdan_website))
                                                <p class="mb-0">
                                                    <i class="bi bi-link-45deg text-primary"></i>
                                                    <a href="{{ $da->duongdan_website }}" target="_blank" class="text-decoration-none">
                                                        {{ $da->duongdan_website }}
                                                    </a>
                                                </p>
                                                @endif
                                            </div>

                                            <!-- Nút Sửa & Xóa -->
                                            <div class="ms-3">
                                                <!-- Nút Sửa -->
                                                <button class="btn btn-sm btn-outline-primary editDuAnBtn me-1"
                                                    data-id="{{ $da->id_duan }}"
                                                    title="Chỉnh sửa">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <!-- Nút Xóa -->
                                                <form action="{{ route('duan.delete', $da->id_duan) }}"
                                                    method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Bạn có chắc muốn xóa dự án này?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <p class="text-muted mb-0">Chưa có nội dung.</p>
                                @endif
                            </div>

                            <!-- Nút mở modal thêm -->
                            <a href="#" class="btn btn-light rounded-circle shadow-sm ms-3"
                                data-bs-toggle="modal" data-bs-target="#addDuAnModal">
                                <i class="bi bi-plus-lg"></i>
                            </a>
                        </div>
                    </div>
                    <!-- SECTION HIỂN THỊ CHỨNG CHỈ -->
                    <div class="card shadow-sm border-0 rounded-3 mb-3">
                        <div class="card-body d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="section-header-modern">
                                    <div class="section-icon-modern">
                                        <i class="bi bi-award"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0">Chứng chỉ</h5>
                                </div>

                                @if(isset($chungChi) && count($chungChi) > 0)
                                @foreach($chungChi as $cc)
                                <div class="timeline-item-modern">
                                    <div class="timeline-dot-modern"></div>
                                    <div class="timeline-content-modern">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <!-- Tên chứng chỉ -->
                                                <p class="mb-1">
                                                    <strong class="text-dark fs-6">{{ $cc->ten_chungchi }}</strong>
                                                </p>

                                                <!-- Tổ chức cấp -->
                                                <p class="text-muted small mb-2">
                                                    <i class="bi bi-building me-1"></i>
                                                    {{ $cc->to_chuc }}
                                                </p>

                                                <!-- Thời gian -->
                                                <p class="text-muted small mb-2">
                                                    <i class="bi bi-calendar me-1"></i>
                                                    {{ date('m/Y', strtotime($cc->thoigian)) }}
                                                </p>

                                                <!-- Mô tả -->
                                                @if(!empty($cc->mo_ta))
                                                <div class="mb-2">
                                                    {!! nl2br(e($cc->mo_ta)) !!}
                                                </div>
                                                @endif

                                                <!-- Link chứng chỉ -->
                                                @if(!empty($cc->link_chungchi))
                                                <p class="mb-0">
                                                    <i class="bi bi-link-45deg text-primary"></i>
                                                    <a href="{{ $cc->link_chungchi }}" target="_blank" class="text-decoration-none">
                                                        Xem chứng chỉ
                                                    </a>
                                                </p>
                                                @endif
                                            </div>

                                            <!-- Nút Sửa & Xóa -->
                                            <div class="ms-3">
                                                <button class="btn btn-sm btn-outline-primary editChungChiBtn me-1"
                                                    data-id="{{ $cc->id_chungchi }}"
                                                    title="Chỉnh sửa">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <form action="{{ route('chungchi.delete', $cc->id_chungchi) }}"
                                                    method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Bạn có chắc muốn xóa chứng chỉ này?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <p class="text-muted mb-0">Chưa có nội dung.</p>
                                @endif
                            </div>

                            <!-- Nút mở modal thêm -->
                            <a href="#" class="btn btn-light rounded-circle shadow-sm ms-3"
                                data-bs-toggle="modal" data-bs-target="#addChungChiModal">
                                <i class="bi bi-plus-lg"></i>
                            </a>
                        </div>
                    </div>
                    <!-- SECTION HIỂN THỊ GIẢI THƯỞNG -->
                    <div class="card shadow-sm border-0 rounded-3 mb-3">
                        <div class="card-body d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="section-header-modern">
                                    <div class="section-icon-modern">
                                        <i class="bi bi-trophy"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0">Giải thưởng</h5>
                                </div>

                                @if(isset($giaiThuong) && count($giaiThuong) > 0)
                                @foreach($giaiThuong as $gt)
                                <div class="timeline-item-modern">
                                    <div class="timeline-dot-modern"></div>
                                    <div class="timeline-content-modern">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <!-- Tên giải thưởng -->
                                                <p class="mb-1">
                                                    <strong class="text-dark fs-6">
                                                        <i class="bi bi-trophy-fill text-warning me-1"></i>
                                                        {{ $gt->ten_giaithuong }}
                                                    </strong>
                                                </p>

                                                <!-- Tổ chức trao -->
                                                <p class="text-muted small mb-2">
                                                    <i class="bi bi-building me-1"></i>
                                                    {{ $gt->to_chuc }}
                                                </p>

                                                <!-- Thời gian -->
                                                <p class="text-muted small mb-2">
                                                    <i class="bi bi-calendar-event me-1"></i>
                                                    {{ date('m/Y', strtotime($gt->thoigian)) }}
                                                </p>

                                                <!-- Mô tả -->
                                                @if(!empty($gt->mo_ta))
                                                <div class="mb-0">
                                                    {!! nl2br(e($gt->mo_ta)) !!}
                                                </div>
                                                @endif
                                            </div>

                                            <!-- Nút Sửa & Xóa -->
                                            <div class="ms-3">
                                                <button class="btn btn-sm btn-outline-primary editGiaiThuongBtn me-1"
                                                    data-id="{{ $gt->id_giaithuong }}"
                                                    title="Chỉnh sửa">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <form action="{{ route('giaithuong.delete', $gt->id_giaithuong) }}"
                                                    method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Bạn có chắc muốn xóa giải thưởng này?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <p class="text-muted mb-0">Chưa có nội dung.</p>
                                @endif
                            </div>

                            <!-- Nút mở modal thêm -->
                            <a href="#" class="btn btn-light rounded-circle shadow-sm ms-3"
                                data-bs-toggle="modal" data-bs-target="#addGiaiThuongModal">
                                <i class="bi bi-plus-lg"></i>
                            </a>
                        </div>
                    </div>
                    <!-- MODAL -->
                    <!-- MODAL THÊM/SỬA GIẢI THƯỞNG -->
                    <div class="modal fade" id="addGiaiThuongModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content rounded-3">
                                <form id="giaiThuongForm" method="POST" action="{{ route('giaithuong.store') }}">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold" id="giaiThuongModalLabel">
                                            <i class="bi bi-trophy me-2"></i>Giải thưởng
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <!-- Tên giải thưởng -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Tên giải thưởng <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control"
                                                name="ten_giaithuong"
                                                id="gt_ten"
                                                placeholder="VD: Nhân viên xuất sắc năm 2023, Top 10 Developer..."
                                                required>
                                        </div>

                                        <!-- Tổ chức trao -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Tổ chức trao <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control"
                                                name="to_chuc"
                                                id="gt_to_chuc"
                                                placeholder="VD: FPT Software, Microsoft, VietnamWorks..."
                                                required>
                                        </div>

                                        <!-- Thời gian -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Thời gian <span class="text-danger">*</span>
                                            </label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <select class="form-select" name="thang" id="gt_thang" required>
                                                        <option value="">Tháng</option>
                                                        @for($i = 1; $i <= 12; $i++)
                                                            <option value="{{ $i }}">Tháng {{ $i }}</option>
                                                            @endfor
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <select class="form-select" name="nam" id="gt_nam" required>
                                                        <option value="">Năm</option>
                                                        @for($year = date('Y'); $year >= 1990; $year--)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Mô tả chi tiết - KHUNG LỚN -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Mô tả chi tiết</label>
                                            <div class="alert alert-info py-2 mb-2">
                                                <i class="bi bi-lightbulb text-warning me-1"></i>
                                                <strong>Tips:</strong> Mô tả lý do nhận giải, thành tích đạt được, phạm vi giải thưởng
                                            </div>
                                            <textarea class="form-control"
                                                name="mo_ta"
                                                id="gt_mota"
                                                rows="15"
                                                maxlength="1000"
                                                style="min-height: 350px; font-size: 14px;"
                                                placeholder="VD:
- Đạt doanh số cao nhất quý 4/2023
- Hoàn thành vượt 150% KPI
- Được trao tặng trước 500+ nhân viên
- Thành tích nổi bật:
  ◦ Ký được 20+ hợp đồng lớn
  ◦ Doanh thu: 5 tỷ VNĐ"></textarea>
                                            <small class="text-muted">
                                                <span id="gt_mota_count">0</span>/1000 ký tự
                                            </small>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-danger" id="submitGiaiThuongBtn">
                                            <i class="bi bi-check-lg"></i> Lưu
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Xem CV -->
                    <div class="modal fade" id="viewCVModal" tabindex="-1" aria-labelledby="viewCVLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content rounded-3 shadow-lg">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="viewCVLabel">
                                        <i class="bi bi-file-earmark-person"></i> CV Ứng viên
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body p-4" style="max-height: 80vh; overflow-y: auto;">
                                    <div class="row">
                                        <!-- Cột trái: Avatar + Thông tin liên hệ -->
                                        <div class="col-md-4 bg-light p-4 rounded-start">
                                            <div class="text-center mb-4">
                                                <img src="{{ $applicant->avatar ? asset('assets/img/avt/'.$applicant->avatar) : asset('assets/img/avt/default-avatar.png') }}"
                                                    alt="Avatar" class="rounded-circle mb-3 border border-3 border-primary"
                                                    width="150" height="150" style="object-fit: cover;">
                                                <h4 class="fw-bold mb-1">{{ $applicant->hoten_uv ?? 'Họ tên ứng viên' }}</h4>
                                                <p class="text-muted mb-0">{{ $applicant->chucdanh ?? 'Chức danh / Vị trí' }}</p>
                                            </div>

                                            <hr class="my-3">

                                            <h6 class="fw-bold text-primary mb-3">
                                                <i class="bi bi-person-lines-fill me-2"></i>Thông tin liên hệ
                                            </h6>

                                            <div class="mb-2">
                                                <i class="bi bi-envelope text-primary me-2"></i>
                                                <small>{{ Auth::user()->email }}</small>
                                            </div>

                                            <div class="mb-2">
                                                <i class="bi bi-telephone text-primary me-2"></i>
                                                <small>{{ $applicant->sdt_uv ?? 'Chưa cập nhật' }}</small>
                                            </div>

                                            <div class="mb-2">
                                                <i class="bi bi-calendar text-primary me-2"></i>
                                                <small>{{ $applicant->ngaysinh ?? 'Chưa cập nhật' }}</small>
                                            </div>

                                            <div class="mb-2">
                                                <i class="bi bi-gender-ambiguous text-primary me-2"></i>
                                                <small>{{ $applicant->gioitinh_uv ?? 'Chưa cập nhật' }}</small>
                                            </div>

                                            <div class="mb-2">
                                                <i class="bi bi-geo-alt text-primary me-2"></i>
                                                <small>{{ $applicant->diachi_uv ?? 'Chưa cập nhật' }}</small>
                                            </div>

                                            <!-- Ngoại ngữ -->
                                            @if(isset($ngoaiNgu) && $ngoaiNgu->count() > 0)
                                            <hr class="my-3">
                                            <h6 class="fw-bold text-primary mb-3">
                                                <i class="bi bi-translate me-2"></i>Ngoại ngữ
                                            </h6>
                                            @foreach($ngoaiNgu as $nn)
                                            <div class="mb-2">
                                                <i class="bi bi-check-circle text-success me-2"></i>
                                                <small><strong>{{ $nn->ten_ngoai_ngu }}</strong> - {{ $nn->trinh_do }}</small>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>

                                        <!-- Cột phải: Nội dung CV -->
                                        <div class="col-md-8 p-4">
                                            <!-- Giới thiệu bản thân -->
                                            <div class="mb-4">
                                                <h5 class="fw-bold text-primary border-bottom border-2 border-primary pb-2 mb-3">
                                                    <i class="bi bi-person me-2"></i>Giới thiệu bản thân
                                                </h5>
                                                <div class="text-muted">
                                                    {!! $applicant->gioithieu ?? '<em>Chưa cập nhật giới thiệu bản thân.</em>' !!}
                                                </div>
                                            </div>

                                            <!-- Kinh nghiệm làm việc -->
                                            <div class="mb-4">
                                                <h5 class="fw-bold text-primary border-bottom border-2 border-primary pb-2 mb-3">
                                                    <i class="bi bi-briefcase me-2"></i>Kinh nghiệm làm việc
                                                </h5>
                                                @if(isset($kinhnghiem) && $kinhnghiem->count())
                                                @foreach($kinhnghiem as $item)
                                                <div class="mb-3 ps-3 border-start border-3 border-secondary">
                                                    <h6 class="fw-bold mb-1">{{ $item->chucdanh }}</h6>
                                                    <p class="text-muted small mb-1">
                                                        <i class="bi bi-building me-1"></i>{{ $item->congty }}
                                                    </p>
                                                    <p class="text-muted small mb-2">
                                                        <i class="bi bi-calendar-range me-1"></i>
                                                        {{ \Carbon\Carbon::parse($item->tu_ngay)->format('m/Y') }} -
                                                        {{ $item->dang_lam_viec ? 'Hiện tại' : \Carbon\Carbon::parse($item->den_ngay)->format('m/Y') }}
                                                    </p>
                                                    @if($item->mota)
                                                    <div class="small mb-2">
                                                        <strong>Mô tả:</strong><br>
                                                        {!! nl2br(e($item->mota)) !!}
                                                    </div>
                                                    @endif
                                                    @if($item->duan)
                                                    <div class="small">
                                                        <strong>Dự án tham gia:</strong><br>
                                                        {!! nl2br(e($item->duan)) !!}
                                                    </div>
                                                    @endif
                                                </div>
                                                @endforeach
                                                @else
                                                <p class="text-muted"><em>Chưa cập nhật kinh nghiệm làm việc.</em></p>
                                                @endif
                                            </div>

                                            <!-- Học vấn -->
                                            <div class="mb-4">
                                                <h5 class="fw-bold text-primary border-bottom border-2 border-primary pb-2 mb-3">
                                                    <i class="bi bi-mortarboard me-2"></i>Học vấn
                                                </h5>
                                                @if(isset($hocvan) && $hocvan->count())
                                                @foreach($hocvan as $item)
                                                <div class="mb-3 ps-3 border-start border-3 border-secondary">
                                                    <h6 class="fw-bold mb-1">{{ $item->truong }}</h6>
                                                    <p class="mb-1 small">{{ $item->nganh }} - <span class="badge bg-info">{{ $item->trinhdo }}</span></p>
                                                    <p class="text-muted small mb-1">
                                                        <i class="bi bi-calendar-range me-1"></i>
                                                        {{ \Carbon\Carbon::parse($item->tu_ngay)->format('Y') }} -
                                                        {{ $item->dang_hoc ? 'Hiện tại' : \Carbon\Carbon::parse($item->den_ngay)->format('Y') }}
                                                    </p>
                                                    @if($item->thongtin_khac)
                                                    <p class="small text-muted fst-italic mb-0">{{ $item->thongtin_khac }}</p>
                                                    @endif
                                                </div>
                                                @endforeach
                                                @else
                                                <p class="text-muted"><em>Chưa cập nhật học vấn.</em></p>
                                                @endif
                                            </div>

                                            <!-- Kỹ năng -->
                                            <div class="mb-4">
                                                <h5 class="fw-bold text-primary border-bottom border-2 border-primary pb-2 mb-3">
                                                    <i class="bi bi-lightbulb me-2"></i>Kỹ năng
                                                </h5>
                                                @if(isset($kynang) && $kynang->count())
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach($kynang as $item)
                                                    <span class="badge bg-primary fs-6 py-2 px-3">
                                                        {{ $item->ten_ky_nang }}
                                                        <span class="opacity-75">({{ $item->nam_kinh_nghiem == 0 ? '<1 năm' : $item->nam_kinh_nghiem . ' năm' }})</span>
                                                    </span>
                                                    @endforeach
                                                </div>
                                                @else
                                                <p class="text-muted"><em>Chưa cập nhật kỹ năng.</em></p>
                                                @endif
                                            </div>

                                            <!-- Dự án nổi bật -->
                                            @if(isset($duAn) && $duAn->count() > 0)
                                            <div class="mb-4">
                                                <h5 class="fw-bold text-primary border-bottom border-2 border-primary pb-2 mb-3">
                                                    <i class="bi bi-kanban me-2"></i>Dự án nổi bật
                                                </h5>
                                                @foreach($duAn as $da)
                                                <div class="mb-3 ps-3 border-start border-3 border-secondary">
                                                    <h6 class="fw-bold mb-1">{{ $da->ten_duan }}</h6>
                                                    <p class="text-muted small mb-2">
                                                        <i class="bi bi-calendar-range me-1"></i>
                                                        {{ date('m/Y', strtotime($da->ngay_bat_dau)) }} -
                                                        {{ $da->dang_lam ? 'Hiện tại' : date('m/Y', strtotime($da->ngay_ket_thuc)) }}
                                                    </p>
                                                    @if($da->mota_duan)
                                                    <div class="small mb-2">
                                                        {!! nl2br(e($da->mota_duan)) !!}
                                                    </div>
                                                    @endif
                                                    @if($da->duongdan_website)
                                                    <p class="small mb-0">
                                                        <i class="bi bi-link-45deg text-primary"></i>
                                                        <a href="{{ $da->duongdan_website }}" target="_blank" class="text-decoration-none">
                                                            {{ $da->duongdan_website }}
                                                        </a>
                                                    </p>
                                                    @endif
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif

                                            <!-- Chứng chỉ -->
                                            @if(isset($chungChi) && $chungChi->count() > 0)
                                            <div class="mb-4">
                                                <h5 class="fw-bold text-primary border-bottom border-2 border-primary pb-2 mb-3">
                                                    <i class="bi bi-award me-2"></i>Chứng chỉ
                                                </h5>
                                                @foreach($chungChi as $cc)
                                                <div class="mb-3 ps-3 border-start border-3 border-secondary">
                                                    <h6 class="fw-bold mb-1">{{ $cc->ten_chungchi }}</h6>
                                                    <p class="text-muted small mb-1">
                                                        <i class="bi bi-building me-1"></i>{{ $cc->to_chuc }}
                                                    </p>
                                                    <p class="text-muted small mb-2">
                                                        <i class="bi bi-calendar me-1"></i>{{ date('m/Y', strtotime($cc->thoigian)) }}
                                                    </p>
                                                    @if($cc->mo_ta)
                                                    <div class="small mb-2">
                                                        {!! nl2br(e($cc->mo_ta)) !!}
                                                    </div>
                                                    @endif
                                                    @if($cc->link_chungchi)
                                                    <p class="small mb-0">
                                                        <i class="bi bi-link-45deg text-primary"></i>
                                                        <a href="{{ $cc->link_chungchi }}" target="_blank" class="text-decoration-none">
                                                            Xem chứng chỉ
                                                        </a>
                                                    </p>
                                                    @endif
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif

                                            <!-- Giải thưởng -->
                                            @if(isset($giaiThuong) && $giaiThuong->count() > 0)
                                            <div class="mb-4">
                                                <h5 class="fw-bold text-primary border-bottom border-2 border-primary pb-2 mb-3">
                                                    <i class="bi bi-trophy me-2"></i>Giải thưởng
                                                </h5>
                                                @foreach($giaiThuong as $gt)
                                                <div class="mb-3 ps-3 border-start border-3 border-warning">
                                                    <h6 class="fw-bold mb-1">
                                                        <i class="bi bi-trophy-fill text-warning me-1"></i>
                                                        {{ $gt->ten_giaithuong }}
                                                    </h6>
                                                    <p class="text-muted small mb-1">
                                                        <i class="bi bi-building me-1"></i>{{ $gt->to_chuc }}
                                                    </p>
                                                    <p class="text-muted small mb-2">
                                                        <i class="bi bi-calendar-event me-1"></i>{{ date('m/Y', strtotime($gt->thoigian)) }}
                                                    </p>
                                                    @if($gt->mo_ta)
                                                    <div class="small">
                                                        {!! nl2br(e($gt->mo_ta)) !!}
                                                    </div>
                                                    @endif
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer bg-light">
                                    <a href="{{ route('applicant.downloadCV', $applicant->id_uv) }}" class="btn btn-primary">
                                        <i class="bi bi-download"></i> Download CV
                                    </a>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal chỉnh sửa hồ sơ -->
                    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="{{ route('applicant.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editProfileModalLabel">Chỉnh sửa hồ sơ cá nhân</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">
                                            <!-- Cột Avatar -->
                                            <div class="col-md-4 text-center mb-3">
                                                <div class="position-relative d-inline-block">
                                                    <!-- Hiển thị avatar -->
                                                    <img src="{{ $applicant->avatar 
                                        ? asset('assets/img/avt/'.$applicant->avatar) 
                                        : asset('assets/img/avt/default-avatar.png') }}"
                                                        class="rounded-circle border"
                                                        alt="Avatar"
                                                        width="150" height="150">

                                                    <!-- Input upload ẩn -->
                                                    <input type="file" name="avatar" id="avatar" class="d-none" accept="image/*">

                                                    <!-- Nút sửa -->
                                                    <label for="avatar" class="btn btn-sm btn-danger position-absolute bottom-0 start-0">
                                                        <i class="bi bi-pencil"></i> Sửa
                                                    </label>

                                                    <!-- Nút xóa -->
                                                    @if($applicant->avatar)
                                                    <a href="{{ route('applicant.deleteAvatar') }}"
                                                        class="btn btn-sm btn-secondary position-absolute bottom-0 end-0">
                                                        <i class="bi bi-trash"></i> Xóa
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Cột thông tin -->
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <!-- Họ tên -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="hoten_uv" class="form-label">Họ và tên</label>
                                                        <input type="text" class="form-control" name="hoten_uv" id="hoten_uv"
                                                            value="{{ $applicant->hoten_uv ?? '' }}" required>
                                                    </div>
                                                    <!-- Chức danh -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="chucdanh" class="form-label">Chức danh</label>
                                                        <input type="text" class="form-control" name="chucdanh" id="chucdanh"
                                                            value="{{ $applicant->chucdanh ?? '' }}">
                                                    </div>
                                                    <!-- Ngày sinh -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="ngaysinh" class="form-label">Ngày sinh</label>
                                                        <input type="date" class="form-control" name="ngaysinh" id="ngaysinh"
                                                            value="{{ $applicant->ngaysinh ?? '' }}">
                                                    </div>
                                                    <!-- Số điện thoại -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="sdt_uv" class="form-label">Số điện thoại</label>
                                                        <input type="text" class="form-control" name="sdt_uv" id="sdt_uv"
                                                            value="{{ $applicant->sdt_uv ?? '' }}">
                                                    </div>
                                                    <!-- Giới tính -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="gioitinh_uv" class="form-label">Giới tính</label>
                                                        <select class="form-select" name="gioitinh_uv" id="gioitinh_uv">
                                                            <option value="">-- Chọn --</option>
                                                            <option value="Nam" {{ ($applicant->gioitinh_uv ?? '') == 'Nam' ? 'selected' : '' }}>Nam</option>
                                                            <option value="Nữ" {{ ($applicant->gioitinh_uv ?? '') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                                                            <option value="Khác" {{ ($applicant->gioitinh_uv ?? '') == 'Khác' ? 'selected' : '' }}>Khác</option>
                                                        </select>
                                                    </div>
                                                    <!-- Địa chỉ -->
                                                    <div class="col-12 mb-3">
                                                        <label for="diachi_uv" class="form-label">Địa chỉ</label>
                                                        <input type="text" class="form-control" name="diachi_uv" id="diachi_uv"
                                                            value="{{ $applicant->diachi_uv ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- đóng modal-body -->

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Giới thiệu bản thân -->
                    <div class="modal fade" id="editGioiThieuModal" tabindex="-1" aria-labelledby="editGioiThieuModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold" id="editGioiThieuModalLabel">
                                        Giới thiệu bản thân
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-muted">
                                        <strong>Tip:</strong> Tóm tắt kinh nghiệm chuyên môn, chú ý làm nổi bật các kỹ năng và điểm mạnh.
                                    </p>

                                    <form action="{{ route('applicant.updateGioiThieu') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="gioithieu-editor" class="form-label"></label>
                                            <textarea id="gioithieu-editor" name="gioithieu" rows="10">
                                            {{ old('gioithieu', $applicant->gioithieu) }}
                                            </textarea>
                                        </div>

                                        <div class="text-end">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Thêm/Sửa Học Vấn -->
                    <div class="modal fade" id="addHocVanModal" tabindex="-1" aria-labelledby="addHocVanModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form id="hocVanForm" method="POST" action="{{ route('hocvan.store') }}">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold" id="addHocVanModalLabel">Thêm Học Vấn</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Trường <span class="text-danger">*</span></label>
                                            <input type="text" name="truong" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Trình độ <span class="text-danger">*</span></label>
                                            <select name="trinhdo" class="form-select" required>
                                                <option value="">-- Chọn trình độ --</option>
                                                <option value="Cao đẳng">Cao đẳng</option>
                                                <option value="Cử nhân">Cử nhân</option>
                                                <option value="Kỹ sư">Kỹ sư</option>
                                                <option value="Thạc sĩ">Thạc sĩ</option>
                                                <option value="Tiến sĩ">Tiến sĩ</option>
                                                <option value="Khác">Khác</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Ngành học <span class="text-danger">*</span></label>
                                            <input type="text" name="nganh" class="form-control" required>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="dang_hoc" name="dang_hoc" value="1">
                                            <label class="form-check-label" for="dang_hoc">Tôi đang theo học tại đây</label>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Từ <span class="text-danger">*</span></label>
                                                <input type="date" name="tu_ngay" class="form-control" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Đến</label>
                                                <input type="date" name="den_ngay" id="den_ngay" class="form-control">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Thông tin chi tiết khác</label>
                                            <textarea name="thongtin_khac" class="form-control" rows="3" placeholder="Ví dụ: thành tích, hoạt động nổi bật..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-primary">Lưu</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- MODAL THÊM/SỬA CHỨNG CHỈ -->
                    <div class="modal fade" id="addChungChiModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content rounded-3">
                                <form id="chungChiForm" method="POST" action="{{ route('chungchi.store') }}">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold" id="chungChiModalLabel">
                                            <i class="bi bi-award me-2"></i>Chứng chỉ
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <!-- Tên chứng chỉ -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Tên chứng chỉ <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control"
                                                name="ten_chungchi"
                                                id="cc_ten"
                                                placeholder="VD: AWS Certified Solutions Architect, Google Analytics..."
                                                required>
                                        </div>

                                        <!-- Tổ chức -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Tổ chức cấp <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control"
                                                name="to_chuc"
                                                id="cc_to_chuc"
                                                placeholder="VD: Microsoft, AWS, Google..."
                                                required>
                                        </div>

                                        <!-- Thời gian -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Thời gian <span class="text-danger">*</span>
                                            </label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <select class="form-select" name="thang" id="cc_thang" required>
                                                        <option value="">Tháng</option>
                                                        @for($i = 1; $i <= 12; $i++)
                                                            <option value="{{ $i }}">Tháng {{ $i }}</option>
                                                            @endfor
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <select class="form-select" name="nam" id="cc_nam" required>
                                                        <option value="">Năm</option>
                                                        @for($year = date('Y'); $year >= 1990; $year--)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Link chứng chỉ -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Link chứng chỉ</label>
                                            <input type="url"
                                                class="form-control"
                                                name="link_chungchi"
                                                id="cc_link"
                                                placeholder="https://example.com/certificate">
                                            <small class="text-muted">URL xác thực chứng chỉ (nếu có)</small>
                                        </div>

                                        <!-- Mô tả chi tiết - KHUNG LỚN -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Mô tả chi tiết</label>
                                            <div class="alert alert-info py-2 mb-2">
                                                <i class="bi bi-lightbulb text-warning me-1"></i>
                                                <strong>Tips:</strong> Mô tả nội dung, phạm vi, kỹ năng đạt được từ chứng chỉ này
                                            </div>
                                            <textarea class="form-control"
                                                name="mo_ta"
                                                id="cc_mota"
                                                rows="15"
                                                maxlength="1000"
                                                style="min-height: 350px; font-size: 14px;"
                                                placeholder="VD:
- Chứng chỉ chứng nhận kiến thức về AWS Cloud
- Nội dung: Architecture Design, Security, Cost Optimization
- Điểm: 850/1000
- Có hiệu lực đến: 12/2026"></textarea>
                                            <small class="text-muted">
                                                <span id="cc_mota_count">0</span>/1000 ký tự
                                            </small>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-danger" id="submitChungChiBtn">
                                            <i class="bi bi-check-lg"></i> Lưu
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Thêm Ngoại Ngữ -->
                    <div class="modal fade" id="addNgoaiNguModal" tabindex="-1" aria-labelledby="addNgoaiNguModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content rounded-3 shadow">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold" id="addNgoaiNguModalLabel">
                                        <i class="bi bi-translate me-2"></i>Thêm Ngoại Ngữ
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <form id="ngoaiNguForm" action="{{ route('applicant.storeNgoaiNgu') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <p class="text-muted mb-3">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Thêm các ngoại ngữ bạn sử dụng được và trình độ của bạn
                                        </p>

                                        <!-- Danh sách ngôn ngữ đã chọn (hiển thị tạm thời) -->
                                        <div id="selectedLanguages" class="mb-3"></div>

                                        <!-- Form nhập ngôn ngữ mới -->
                                        <div class="border rounded p-3 bg-light">
                                            <div class="row">
                                                <!-- Tìm ngôn ngữ -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold">Tìm ngôn ngữ <span class="text-danger">*</span></label>
                                                    <select id="languageSelect" class="form-select">
                                                        <option value="">-- Chọn ngôn ngữ --</option>
                                                        <option value="Tiếng Anh">Tiếng Anh</option>
                                                        <option value="Tiếng Nhật">Tiếng Nhật</option>
                                                        <option value="Tiếng Hàn">Tiếng Hàn</option>
                                                        <option value="Tiếng Trung">Tiếng Trung</option>
                                                        <option value="Tiếng Pháp">Tiếng Pháp</option>
                                                        <option value="Tiếng Đức">Tiếng Đức</option>
                                                        <option value="Tiếng Tây Ban Nha">Tiếng Tây Ban Nha</option>
                                                        <option value="Tiếng Nga">Tiếng Nga</option>
                                                        <option value="Tiếng Thái">Tiếng Thái</option>
                                                        <option value="Tiếng Indonesia">Tiếng Indonesia</option>
                                                    </select>
                                                </div>

                                                <!-- Chọn trình độ -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold">Chọn trình độ <span class="text-danger">*</span></label>
                                                    <select id="levelSelect" class="form-select">
                                                        <option value="">-- Chọn trình độ --</option>
                                                        <option value="Sơ cấp">Sơ cấp</option>
                                                        <option value="Trung cấp">Trung cấp</option>
                                                        <option value="Cao cấp">Cao cấp</option>
                                                        <option value="Bản ngữ">Bản ngữ</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Nút thêm ngôn ngữ vào danh sách -->
                                            <button type="button" class="btn btn-primary btn-sm" id="addLanguageBtn">
                                                <i class="bi bi-plus-lg"></i> Thêm
                                            </button>
                                        </div>

                                        <!-- Hidden inputs cho form submit -->
                                        <div id="hiddenInputs"></div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-danger" id="submitNgoaiNguBtn" disabled>
                                            <i class="bi bi-check-lg"></i> Lưu
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Thêm/Sửa Kinh Nghiệm -->
                    <div class="modal fade" id="addKinhNghiemModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content rounded-3">
                                <form id="kinhNghiemForm" method="POST" action="{{ route('kinhnghiem.store') }}">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="kinhNghiemModalLabel">Thêm Kinh Nghiệm Làm Việc</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">

                                        <!-- Chức danh -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Chức danh <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="chucdanh" id="kn_chucdanh"
                                                placeholder="VD: Senior Developer, Marketing Manager..." required>
                                            <small class="text-muted">Nhập vị trí công việc của bạn</small>
                                        </div>

                                        <!-- Công ty -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Tên công ty <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="congty" id="kn_congty"
                                                placeholder="VD: FPT Software, Viettel..." required>
                                            <small class="text-muted">Nơi bạn đã/đang làm việc</small>
                                        </div>

                                        <!-- Đang làm việc -->
                                        <div class="form-check mb-3">
                                            <input type="checkbox" class="form-check-input" name="dang_lam_viec" id="kn_dangLamViec">
                                            <label for="kn_dangLamViec" class="form-check-label">
                                                <i class="bi bi-briefcase-fill text-primary me-1"></i>
                                                Tôi đang làm việc tại đây
                                            </label>
                                        </div>

                                        <!-- Thời gian -->
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Từ <span class="text-danger">*</span></label>
                                                <input type="month" class="form-control" name="tu_ngay" id="kn_tuNgay" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Đến</label>
                                                <input type="month" class="form-control" name="den_ngay" id="kn_denNgay">
                                            </div>
                                        </div>

                                        <!-- Mô tả chi tiết -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Mô tả chi tiết</label>
                                            <div class="alert alert-info py-2">
                                                <i class="bi bi-lightbulb text-warning me-1"></i>
                                                <strong>Tips:</strong> Tóm lược lĩnh vực công ty, vai trò, trách nhiệm và kết quả đạt được
                                            </div>
                                            <textarea class="form-control" name="mota" id="kn_mota"
                                                rows="6" maxlength="2500" style="height:200px"
                                                placeholder="VD: 
                                        - Phát triển và bảo trì hệ thống quản lý khách hàng cho 50+ doanh nghiệp
                                        - Dẫn dắt team 5 developers, áp dụng Agile/Scrum
                                        - Tăng hiệu suất hệ thống 40% thông qua tối ưu database..."></textarea>
                                            <small class="text-muted"><span id="mota_count">0</span>/2500 ký tự</small>
                                        </div>

                                        <!-- Dự án -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Dự án đã tham gia</label>
                                            <div class="alert alert-info py-2">
                                                <i class="bi bi-lightbulb text-warning me-1"></i>
                                                <strong>Tips:</strong> Mô tả dự án quan trọng, vai trò, công nghệ sử dụng
                                            </div>
                                            <textarea class="form-control" name="duan" id="kn_duan"
                                                rows="6" maxlength="2500" style="height:200px"
                                                placeholder="VD:
• E-commerce Platform (2023)
  - Vai trò: Lead Developer
  - Công nghệ: Laravel, Vue.js, MySQL
  - Quy mô: Team 8 người
  - Kết quả: Xử lý 10,000+ đơn hàng/ngày..."></textarea>
                                            <small class="text-muted"><span id="duan_count">0</span>/2500 ký tự</small>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-primary" id="kinhNghiemSubmitBtn">Lưu</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Thêm Kỹ Năng -->
                    <div class="modal fade" id="addKyNangModal" tabindex="-1" aria-labelledby="addKyNangModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content rounded-3 shadow">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold" id="addKyNangModalLabel">
                                        <i class="bi bi-lightbulb me-2"></i>Thêm Kỹ Năng
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <form action="{{ route('applicant.storeKyNang') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">

                                        <!-- Nhập kỹ năng (autocomplete) -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Tên kỹ năng</label>
                                            <input type="text" name="ten_ky_nang[]" class="form-control skill-input" placeholder="Nhập kỹ năng...">
                                            <div class="form-text">Ví dụ: Java, PHP, HTML, CSS...</div>
                                        </div>

                                        <!-- Năm kinh nghiệm -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Năm kinh nghiệm</label>
                                            <select name="nam_kinh_nghiem[]" class="form-select">
                                                <option value="<1"> &lt; 1 năm </option>
                                                @for($i=1; $i<=10; $i++)
                                                    <option value="{{ $i }}">{{ $i }} năm</option>
                                                    @endfor
                                            </select>
                                        </div>

                                        <!-- Nút thêm nhiều kỹ năng -->
                                        <div id="moreSkills"></div>
                                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="addMoreSkill">
                                            <i class="bi bi-plus-lg"></i> Thêm kỹ năng khác
                                        </button>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-danger">Lưu</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Thêm/Sửa Dự Án Nổi Bật -->
                    <div class="modal fade" id="addDuAnModal" tabindex="-1" aria-labelledby="addDuAnModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content rounded-3">
                                <form id="duAnForm" method="POST" action="{{ route('duan.store') }}">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold" id="addDuAnModalLabel">
                                            <i class="bi bi-kanban me-2"></i>Dự án nổi bật
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <!-- Tips -->
                                        <div class="alert alert-warning py-2 mb-3">
                                            <i class="bi bi-lightbulb text-warning me-1"></i>
                                            <strong>Tips:</strong> Thể hiện dự án liên quan đến kỹ năng và khả năng của bạn, và đảm bảo bao gồm mô tả dự án, vai trò của bạn, công nghệ sử dụng và số thành viên.
                                        </div>

                                        <!-- Tên dự án -->
                                        <div class="mb-3">
                                            <label for="ten_duan" class="form-label fw-bold">
                                                Tên dự án <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control"
                                                id="ten_duan"
                                                name="ten_duan"
                                                placeholder="VD: Hệ thống quản lý nhân sự, Website bán hàng..."
                                                required>
                                        </div>

                                        <!-- Checkbox đang làm -->
                                        <div class="form-check mb-3">
                                            <input class="form-check-input"
                                                type="checkbox"
                                                id="dang_lam"
                                                name="dang_lam"
                                                value="1">
                                            <label class="form-check-label" for="dang_lam">
                                                <i class="bi bi-briefcase-fill text-primary me-1"></i>
                                                Tôi vẫn đang làm dự án này
                                            </label>
                                        </div>

                                        <!-- Ngày bắt đầu và kết thúc -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="thang_bat_dau" class="form-label fw-bold">
                                                    Ngày bắt đầu <span class="text-danger">*</span>
                                                </label>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <select class="form-select" id="thang_bat_dau" name="thang_bat_dau" required>
                                                            <option value="">Tháng</option>
                                                            @for($i = 1; $i <= 12; $i++)
                                                                <option value="{{ $i }}">Tháng {{ $i }}</option>
                                                                @endfor
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <select class="form-select" id="nam_bat_dau" name="nam_bat_dau" required>
                                                            <option value="">Năm</option>
                                                            @for($year = date('Y'); $year >= 1990; $year--)
                                                            <option value="{{ $year }}">{{ $year }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="thang_ket_thuc" class="form-label fw-bold">
                                                    Ngày kết thúc <span class="text-danger">*</span>
                                                </label>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <select class="form-select" id="thang_ket_thuc" name="thang_ket_thuc">
                                                            <option value="">Tháng</option>
                                                            @for($i = 1; $i <= 12; $i++)
                                                                <option value="{{ $i }}">Tháng {{ $i }}</option>
                                                                @endfor
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <select class="form-select" id="nam_ket_thuc" name="nam_ket_thuc">
                                                            <option value="">Năm</option>
                                                            @for($year = date('Y'); $year >= 1990; $year--)
                                                            <option value="{{ $year }}">{{ $year }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Mô tả dự án - KHUNG LỚN -->
                                        <div class="mb-3">
                                            <label for="mota_duan" class="form-label fw-bold">Mô tả dự án</label>

                                            <textarea class="form-control"
                                                id="mota_duan"
                                                name="mota_duan"
                                                rows="15"
                                                maxlength="2500"
                                                style="min-height: 350px; font-size: 14px;"
                                                placeholder="• Mô tả: Viết mô tả ngắn gọn dự án
• Vai trò: Chức danh của bạn trong dự án
• Trách nhiệm:
  ◦ Trách nhiệm đầu tiên
  ◦ Trách nhiệm thứ hai
• Công nghệ: Liệt kê các công nghệ đã sử dụng
• Nhóm: x thành viên"></textarea>

                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <small class="text-muted">
                                                    <span id="mota_count">0</span>/2500 ký tự
                                                </small>
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-secondary"
                                                    id="insertTemplateBtn">
                                                    <i class="bi bi-file-text"></i> Chèn mẫu gợi ý
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Đường dẫn website -->
                                        <div class="mb-3">
                                            <label for="duongdan_website" class="form-label fw-bold">Đường dẫn website</label>
                                            <input type="url"
                                                class="form-control"
                                                id="duongdan_website"
                                                name="duongdan_website"
                                                placeholder="https://example.com">
                                            <small class="text-muted">URL demo hoặc source code (Github, Gitlab...)</small>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-danger" id="submitDuAnBtn">
                                            <i class="bi bi-check-lg"></i> Lưu
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>



                </div>
            </div>

        </div>
    </main>
    <!-- xử lý chứng chỉ -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chungChiForm = document.getElementById('chungChiForm');
            const modalTitle = document.getElementById('chungChiModalLabel');
            const submitButton = document.getElementById('submitChungChiBtn');

            const motaTextarea = document.getElementById('cc_mota');
            const motaCount = document.getElementById('cc_mota_count');

            // ========== CHARACTER COUNTER ==========
            if (motaTextarea) {
                motaTextarea.addEventListener('input', function() {
                    motaCount.textContent = this.value.length;
                });
            }

            // ========== RESET FORM ==========
            function resetFormToAdd() {
                chungChiForm.action = "{{ route('chungchi.store') }}";
                modalTitle.innerHTML = '<i class="bi bi-award me-2"></i>Chứng chỉ';
                submitButton.innerHTML = '<i class="bi bi-check-lg"></i> Lưu';

                const methodInput = chungChiForm.querySelector('input[name="_method"]');
                if (methodInput) methodInput.remove();

                chungChiForm.reset();
                motaCount.textContent = '0';
            }

            // ========== Mở MODAL THÊM MỚI ==========
            const addButton = document.querySelector('[data-bs-target="#addChungChiModal"]');
            if (addButton) {
                addButton.addEventListener('click', resetFormToAdd);
            }

            // ========== Xử LÝ NÚT EDIT ==========
            const editButtons = document.querySelectorAll('.editChungChiBtn');

            editButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.dataset.id;

                    fetch(`/chungchi/${id}/edit`)
                        .then(res => {
                            if (!res.ok) throw new Error('Không thể lấy dữ liệu');
                            return res.json();
                        })
                        .then(data => {
                            console.log('Data received:', data);

                            // Chuyển form sang update mode
                            chungChiForm.action = `/chungchi/${id}/update`;
                            modalTitle.innerHTML = '<i class="bi bi-award me-2"></i>Cập nhật chứng chỉ';
                            submitButton.innerHTML = '<i class="bi bi-check-lg"></i> Cập nhật';

                            // Thêm method POST
                            let methodInput = chungChiForm.querySelector('input[name="_method"]');
                            if (!methodInput) {
                                methodInput = document.createElement('input');
                                methodInput.type = 'hidden';
                                methodInput.name = '_method';
                                methodInput.value = 'POST';
                                chungChiForm.appendChild(methodInput);
                            }

                            // Fill dữ liệu
                            document.getElementById('cc_ten').value = data.ten_chungchi || '';
                            document.getElementById('cc_to_chuc').value = data.to_chuc || '';
                            document.getElementById('cc_link').value = data.link_chungchi || '';
                            document.getElementById('cc_mota').value = data.mo_ta || '';

                            // Xử lý thời gian
                            if (data.thoigian) {
                                const date = new Date(data.thoigian);
                                document.getElementById('cc_thang').value = date.getMonth() + 1;
                                document.getElementById('cc_nam').value = date.getFullYear();
                            }

                            // Update character count
                            motaCount.textContent = (data.mo_ta || '').length;

                            // Mở modal
                            const modal = new bootstrap.Modal(document.getElementById('addChungChiModal'));
                            modal.show();
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                            alert('Không thể tải dữ liệu chứng chỉ. Vui lòng thử lại!');
                        });
                });
            });

            // ========== RESET KHI ĐÓNG MODAL ==========
            const modal = document.getElementById('addChungChiModal');
            if (modal) {
                modal.addEventListener('hidden.bs.modal', resetFormToAdd);
            }
        });
    </script>

    <!-- xử lý giải thưởng -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const giaiThuongForm = document.getElementById('giaiThuongForm');
            const modalTitle = document.getElementById('giaiThuongModalLabel');
            const submitButton = document.getElementById('submitGiaiThuongBtn');

            const motaTextarea = document.getElementById('gt_mota');
            const motaCount = document.getElementById('gt_mota_count');

            // ========== CHARACTER COUNTER ==========
            if (motaTextarea) {
                motaTextarea.addEventListener('input', function() {
                    motaCount.textContent = this.value.length;
                });
            }

            // ========== RESET FORM ==========
            function resetFormToAdd() {
                giaiThuongForm.action = "{{ route('giaithuong.store') }}";
                modalTitle.innerHTML = '<i class="bi bi-trophy me-2"></i>Giải thưởng';
                submitButton.innerHTML = '<i class="bi bi-check-lg"></i> Lưu';

                const methodInput = giaiThuongForm.querySelector('input[name="_method"]');
                if (methodInput) methodInput.remove();

                giaiThuongForm.reset();
                motaCount.textContent = '0';
            }

            // ========== Mở MODAL THÊM MỚI ==========
            const addButton = document.querySelector('[data-bs-target="#addGiaiThuongModal"]');
            if (addButton) {
                addButton.addEventListener('click', resetFormToAdd);
            }

            // ========== Xử LÝ NÚT EDIT ==========
            const editButtons = document.querySelectorAll('.editGiaiThuongBtn');

            editButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.dataset.id;

                    fetch(`/giaithuong/${id}/edit`)
                        .then(res => {
                            if (!res.ok) throw new Error('Không thể lấy dữ liệu');
                            return res.json();
                        })
                        .then(data => {
                            console.log('Data received:', data);

                            // Chuyển form sang update mode
                            giaiThuongForm.action = `/giaithuong/${id}/update`;
                            modalTitle.innerHTML = '<i class="bi bi-trophy me-2"></i>Cập nhật giải thưởng';
                            submitButton.innerHTML = '<i class="bi bi-check-lg"></i> Cập nhật';

                            // Thêm method POST
                            let methodInput = giaiThuongForm.querySelector('input[name="_method"]');
                            if (!methodInput) {
                                methodInput = document.createElement('input');
                                methodInput.type = 'hidden';
                                methodInput.name = '_method';
                                methodInput.value = 'POST';
                                giaiThuongForm.appendChild(methodInput);
                            }

                            // Fill dữ liệu
                            document.getElementById('gt_ten').value = data.ten_giaithuong || '';
                            document.getElementById('gt_to_chuc').value = data.to_chuc || '';
                            document.getElementById('gt_mota').value = data.mo_ta || '';

                            // Xử lý thời gian
                            if (data.thoigian) {
                                const date = new Date(data.thoigian);
                                document.getElementById('gt_thang').value = date.getMonth() + 1;
                                document.getElementById('gt_nam').value = date.getFullYear();
                            }

                            // Update character count
                            motaCount.textContent = (data.mo_ta || '').length;

                            // Mở modal
                            const modal = new bootstrap.Modal(document.getElementById('addGiaiThuongModal'));
                            modal.show();
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                            alert('Không thể tải dữ liệu giải thưởng. Vui lòng thử lại!');
                        });
                });
            });

            // ========== RESET KHI ĐÓNG MODAL ==========
            const modal = document.getElementById('addGiaiThuongModal');
            if (modal) {
                modal.addEventListener('hidden.bs.modal', resetFormToAdd);
            }
        });
    </script>

    <!-- xử lý dự án -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const duAnForm = document.getElementById('duAnForm');
            const modalTitle = document.getElementById('addDuAnModalLabel');
            const submitButton = document.getElementById('submitDuAnBtn');

            // Elements
            const dangLamCheckbox = document.getElementById('dang_lam');
            const thangKetThuc = document.getElementById('thang_ket_thuc');
            const namKetThuc = document.getElementById('nam_ket_thuc');
            const motaTextarea = document.getElementById('mota_duan');
            const motaCount = document.getElementById('mota_count');
            const insertTemplateBtn = document.getElementById('insertTemplateBtn');

            // ========== RESET FORM KHI MỞ MODAL THÊM MỚI ==========
            function resetFormToAdd() {
                duAnForm.action = "{{ route('duan.store') }}";
                modalTitle.innerHTML = '<i class="bi bi-kanban me-2"></i>Dự án nổi bật';
                submitButton.innerHTML = '<i class="bi bi-check-lg"></i> Lưu';

                // Xóa method input cũ
                const methodInput = duAnForm.querySelector('input[name="_method"]');
                if (methodInput) methodInput.remove();

                // Reset form
                duAnForm.reset();
                motaCount.textContent = '0';
                toggleNgayKetThuc();
            }

            // ========== XỬ LÝ CHECKBOX "ĐANG LÀM" ==========
            function toggleNgayKetThuc() {
                if (dangLamCheckbox.checked) {
                    thangKetThuc.disabled = true;
                    namKetThuc.disabled = true;
                    thangKetThuc.value = '';
                    namKetThuc.value = '';
                    thangKetThuc.removeAttribute('required');
                    namKetThuc.removeAttribute('required');
                } else {
                    thangKetThuc.disabled = false;
                    namKetThuc.disabled = false;
                    thangKetThuc.setAttribute('required', 'required');
                    namKetThuc.setAttribute('required', 'required');
                }
            }

            dangLamCheckbox.addEventListener('change', toggleNgayKetThuc);

            // ========== CHARACTER COUNTER ==========
            if (motaTextarea) {
                motaTextarea.addEventListener('input', function() {
                    motaCount.textContent = this.value.length;
                });
            }

            // ========== NÚT CHÈN TEMPLATE ==========
            if (insertTemplateBtn) {
                insertTemplateBtn.addEventListener('click', function() {
                    const template = `• Mô tả: Viết mô tả ngắn gọn dự án
• Vai trò: Chức danh của bạn trong dự án
• Trách nhiệm:
  ◦ Trách nhiệm đầu tiên
  ◦ Trách nhiệm thứ hai
• Công nghệ: Liệt kê các công nghệ đã sử dụng
• Nhóm: x thành viên`;

                    motaTextarea.value = template;
                    motaCount.textContent = template.length;
                    motaTextarea.focus();
                });
            }

            // ========== MỞ MODAL THÊM MỚI ==========
            const addButton = document.querySelector('[data-bs-target="#addDuAnModal"]');
            if (addButton) {
                addButton.addEventListener('click', resetFormToAdd);
            }

            // ========== XỬ LÝ NÚT EDIT ==========
            const editButtons = document.querySelectorAll('.editDuAnBtn');

            editButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.dataset.id;

                    // Fetch dữ liệu dự án
                    fetch(`/duan/${id}/edit`)
                        .then(res => {
                            if (!res.ok) throw new Error('Không thể lấy dữ liệu');
                            return res.json();
                        })
                        .then(data => {
                            console.log('Data received:', data);

                            // Chuyển form sang update mode
                            duAnForm.action = `/duan/${id}/update`;
                            modalTitle.innerHTML = '<i class="bi bi-kanban me-2"></i>Cập nhật dự án';
                            submitButton.innerHTML = '<i class="bi bi-check-lg"></i> Cập nhật';

                            // Thêm method POST
                            let methodInput = duAnForm.querySelector('input[name="_method"]');
                            if (!methodInput) {
                                methodInput = document.createElement('input');
                                methodInput.type = 'hidden';
                                methodInput.name = '_method';
                                methodInput.value = 'POST';
                                duAnForm.appendChild(methodInput);
                            }

                            // Fill dữ liệu vào form
                            document.getElementById('ten_duan').value = data.ten_duan || '';

                            // Xử lý ngày bắt đầu
                            if (data.ngay_bat_dau) {
                                const startDate = new Date(data.ngay_bat_dau);
                                document.getElementById('thang_bat_dau').value = startDate.getMonth() + 1;
                                document.getElementById('nam_bat_dau').value = startDate.getFullYear();
                            }

                            // Xử lý ngày kết thúc
                            if (data.ngay_ket_thuc) {
                                const endDate = new Date(data.ngay_ket_thuc);
                                document.getElementById('thang_ket_thuc').value = endDate.getMonth() + 1;
                                document.getElementById('nam_ket_thuc').value = endDate.getFullYear();
                            }

                            // Mô tả và website
                            document.getElementById('mota_duan').value = data.mota_duan || '';
                            document.getElementById('duongdan_website').value = data.duongdan_website || '';

                            // Update character count
                            motaCount.textContent = (data.mota_duan || '').length;

                            // Checkbox đang làm
                            dangLamCheckbox.checked = data.dang_lam == 1;
                            toggleNgayKetThuc();

                            // Mở modal
                            const modal = new bootstrap.Modal(document.getElementById('addDuAnModal'));
                            modal.show();
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                            alert('Không thể tải dữ liệu dự án. Vui lòng thử lại!');
                        });
                });
            });

            // ========== RESET KHI ĐÓNG MODAL ==========
            const modal = document.getElementById('addDuAnModal');
            if (modal) {
                modal.addEventListener('hidden.bs.modal', resetFormToAdd);
            }

            // Khởi tạo ban đầu
            toggleNgayKetThuc();
        });
    </script>
    <!-- ✅ SCRIPT XỬ LÝ NGOẠI NGỮ - PHIÊN BẢN HOÀN CHỈNH -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const languageSelect = document.getElementById('languageSelect');
            const levelSelect = document.getElementById('levelSelect');
            const addLanguageBtn = document.getElementById('addLanguageBtn');
            const selectedLanguages = document.getElementById('selectedLanguages');
            const hiddenInputs = document.getElementById('hiddenInputs');
            const submitBtn = document.getElementById('submitNgoaiNguBtn');

            let languages = [];

            // ========== THÊM NGÔN NGỮ VÀO DANH SÁCH TẠM THỜI ==========
            if (addLanguageBtn) {
                addLanguageBtn.addEventListener('click', function() {
                    const language = languageSelect.value;
                    const level = levelSelect.value;

                    if (!language || !level) {
                        alert('Vui lòng chọn đầy đủ ngôn ngữ và trình độ!');
                        return;
                    }

                    const exists = languages.find(item => item.language === language);
                    if (exists) {
                        alert('Ngôn ngữ này đã được thêm!');
                        return;
                    }

                    languages.push({
                        language,
                        level
                    });
                    renderLanguages();
                    languageSelect.value = '';
                    levelSelect.value = '';
                    if (submitBtn) submitBtn.disabled = false;
                });
            }

            // ========== RENDER DANH SÁCH NGÔN NGỮ ĐÃ CHỌN ==========
            function renderLanguages() {
                if (languages.length === 0) {
                    if (selectedLanguages) selectedLanguages.innerHTML = '';
                    if (hiddenInputs) hiddenInputs.innerHTML = '';
                    if (submitBtn) submitBtn.disabled = true;
                    return;
                }

                if (selectedLanguages) {
                    selectedLanguages.innerHTML = `
                <div class="alert alert-success">
                    <strong><i class="bi bi-check-circle me-1"></i>Ngôn ngữ đã chọn (${languages.length}):</strong>
                </div>
            `;

                    languages.forEach((item, index) => {
                        selectedLanguages.innerHTML += `
                    <div class="d-inline-flex align-items-center badge bg-primary text-white me-2 mb-2 p-2 fs-6">
                        <div class="me-2">
                            <strong>${item.language}</strong>
                            <span class="opacity-75"> - ${item.level}</span>
                        </div>
                        <button type="button" class="btn btn-sm btn-link text-white p-0 removeLanguageBtn" 
                                data-index="${index}" title="Xóa">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                `;
                    });
                }

                if (hiddenInputs) {
                    hiddenInputs.innerHTML = '';
                    languages.forEach((item) => {
                        hiddenInputs.innerHTML += `
                    <input type="hidden" name="ten_ngoai_ngu[]" value="${item.language}">
                    <input type="hidden" name="trinh_do[]" value="${item.level}">
                `;
                    });
                }

                // Gắn event cho nút xóa trong danh sách tạm
                document.querySelectorAll('.removeLanguageBtn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.dataset.index);
                        languages.splice(index, 1);
                        renderLanguages();
                    });
                });
            }

            // ========== RESET KHI ĐÓNG MODAL ==========
            const modalElement = document.getElementById('addNgoaiNguModal');
            if (modalElement) {
                modalElement.addEventListener('hidden.bs.modal', function() {
                    languages = [];
                    renderLanguages();
                    if (languageSelect) languageSelect.value = '';
                    if (levelSelect) levelSelect.value = '';
                });
            }
        });

        // ========== XỬ LÝ XÓA NGOẠI NGỮ ĐÃ LƯU - EVENT DELEGATION ==========
        document.body.addEventListener('click', function(e) {
            const deleteBtn = e.target.closest('.deleteNgoaiNguBtn');

            if (deleteBtn) {
                e.preventDefault();
                e.stopPropagation();

                const id = deleteBtn.dataset.id;

                if (!id) {
                    console.error('Không tìm thấy ID ngoại ngữ');
                    alert('Lỗi: Không xác định được ngoại ngữ cần xóa!');
                    return;
                }

                // ✅ Lấy CSRF token và kiểm tra
                const csrfMeta = document.querySelector('meta[name="csrf-token"]');

                if (!csrfMeta) {
                    console.error('❌ KHÔNG TÌM THẤY meta tag csrf-token trong HTML!');
                    alert('Lỗi hệ thống: Không tìm thấy CSRF token. Vui lòng reload trang!');
                    return;
                }

                const csrfToken = csrfMeta.content;

                if (!csrfToken) {
                    console.error('❌ CSRF token rỗng!');
                    alert('Lỗi: CSRF token không hợp lệ. Vui lòng reload trang!');
                    return;
                }

                console.log('✅ CSRF Token:', csrfToken);
                console.log('Đang gửi yêu cầu xóa ngoại ngữ ID:', id);

                if (confirm('Bạn có chắc muốn xóa ngoại ngữ này?')) {
                    // Disable button và hiển thị loading
                    deleteBtn.disabled = true;
                    const originalHTML = deleteBtn.innerHTML;
                    deleteBtn.innerHTML = '<i class="bi bi-hourglass-split"></i>';

                    fetch(`/applicant/ngoai-ngu/${id}/delete`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => {
                            console.log('Response status:', res.status);
                            if (!res.ok) {
                                throw new Error(`HTTP ${res.status}: ${res.statusText}`);
                            }
                            return res.json();
                        })
                        .then(data => {
                            console.log('Response data:', data);
                            if (data.success) {
                                alert('Đã xóa ngoại ngữ thành công!');
                                location.reload();
                            } else {
                                alert(data.message || 'Có lỗi xảy ra khi xóa!');
                                deleteBtn.disabled = false;
                                deleteBtn.innerHTML = originalHTML;
                            }
                        })
                        .catch(error => {
                            console.error('Lỗi khi xóa:', error);
                            alert('Không thể xóa ngoại ngữ!\nLỗi: ' + error.message);
                            deleteBtn.disabled = false;
                            deleteBtn.innerHTML = originalHTML;
                        });
                }
            }
        });
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#gioithieu-editor'), {
                toolbar: [
                    'bold', 'italic', 'underline', '|',
                    'bulletedList', 'numberedList', '|',
                    'undo', 'redo'
                ]
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <!-- Script xử lý checkbox -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('dang_hoc');
            const denNgayInput = document.getElementById('den_ngay');

            function toggleDenNgay() {
                if (checkbox.checked) {
                    denNgayInput.disabled = true;
                    denNgayInput.value = ''; // clear khi disable
                } else {
                    denNgayInput.disabled = false;
                }
            }

            // chạy khi load trang
            toggleDenNgay();

            // lắng nghe sự kiện thay đổi
            checkbox.addEventListener('change', toggleDenNgay);
        });
    </script>
    <!-- // ============ XỬ LÝ HỌC VẤN ============  -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hocVanForm = document.getElementById('hocVanForm');
            const modalTitle = document.getElementById('addHocVanModalLabel');
            const submitButton = hocVanForm.querySelector('button[type="submit"]');

            // Checkbox đang học
            const checkbox = document.getElementById('dang_hoc');
            const denNgayInput = document.getElementById('den_ngay');

            // Hàm reset form về trạng thái thêm mới
            function resetFormToAdd() {
                hocVanForm.action = "{{ route('hocvan.store') }}";
                hocVanForm.method = "POST";
                modalTitle.textContent = "Thêm Học Vấn";
                submitButton.textContent = "Lưu";

                // Xóa input method cũ nếu có
                const methodInput = hocVanForm.querySelector('input[name="_method"]');
                if (methodInput) {
                    methodInput.remove();
                }

                // Reset form
                hocVanForm.reset();
                denNgayInput.disabled = false;
            }

            // Khi mở modal thêm mới
            document.querySelector('[data-bs-target="#addHocVanModal"]').addEventListener('click', function() {
                resetFormToAdd();
            });

            // Xử lý checkbox "đang học"
            function toggleDenNgay() {
                if (checkbox.checked) {
                    denNgayInput.disabled = true;
                    denNgayInput.value = '';
                } else {
                    denNgayInput.disabled = false;
                }
            }

            checkbox.addEventListener('change', toggleDenNgay);
            toggleDenNgay(); // Chạy khi load

            // Xử lý nút Edit
            const editButtons = document.querySelectorAll('.editHocVanBtn');

            editButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.dataset.id;

                    // Fetch dữ liệu học vấn
                    fetch(`/hocvan/${id}/edit`)
                        .then(res => {
                            if (!res.ok) throw new Error('Không thể lấy dữ liệu');
                            return res.json();
                        })
                        .then(data => {
                            // Thay đổi form thành update mode
                            hocVanForm.action = `/hocvan/${id}/update`;
                            modalTitle.textContent = "Cập Nhật Học Vấn";
                            submitButton.textContent = "Cập nhật";

                            // Thêm method PUT (nếu dùng Route::put)
                            // Hoặc giữ POST nếu route là Route::post
                            let methodInput = hocVanForm.querySelector('input[name="_method"]');
                            if (!methodInput) {
                                methodInput = document.createElement('input');
                                methodInput.type = 'hidden';
                                methodInput.name = '_method';
                                methodInput.value = 'POST'; // hoặc 'PUT' nếu route dùng PUT
                                hocVanForm.appendChild(methodInput);
                            }

                            // Fill dữ liệu vào form
                            hocVanForm.querySelector('input[name="truong"]').value = data.truong || '';
                            hocVanForm.querySelector('select[name="trinhdo"]').value = data.trinhdo || '';
                            hocVanForm.querySelector('input[name="nganh"]').value = data.nganh || '';
                            hocVanForm.querySelector('input[name="tu_ngay"]').value = data.tu_ngay || '';
                            hocVanForm.querySelector('input[name="den_ngay"]').value = data.den_ngay || '';
                            hocVanForm.querySelector('textarea[name="thongtin_khac"]').value = data.thongtin_khac || '';

                            // Set checkbox
                            checkbox.checked = data.dang_hoc == 1;
                            toggleDenNgay();

                            // Mở modal
                            const modal = new bootstrap.Modal(document.getElementById('addHocVanModal'));
                            modal.show();
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                            alert('Không thể tải dữ liệu học vấn. Vui lòng thử lại!');
                        });
                });
            });
        });

        // ============ XỬ LÝ KINH NGHIỆM LÀM VIỆC ============

        document.addEventListener("DOMContentLoaded", function() {
            const dangLamViec = document.getElementById('dangLamViec');
            const denNgay = document.getElementById('denNgay');

            function toggleDenNgay() {
                if (dangLamViec.checked) {
                    denNgay.disabled = true;
                    denNgay.value = "";
                } else {
                    denNgay.disabled = false;
                }
            }

            dangLamViec.addEventListener('change', toggleDenNgay);
            toggleDenNgay();
        });

        // ============ XỬ LÝ KỸ NĂNG ============

        document.getElementById('addMoreSkill').addEventListener('click', function() {
            const skillBlock = `
        <div class="skill-item border rounded p-3 mb-3">
            <label class="form-label fw-bold">Tên kỹ năng</label>
            <input type="text" name="ten_ky_nang[]" class="form-control skill-input" placeholder="Nhập kỹ năng...">

            <label class="form-label fw-bold mt-2">Năm kinh nghiệm</label>
            <select name="nam_kinh_nghiem[]" class="form-select">
                <option value="<1">&lt; 1 năm</option>
                ${[...Array(10).keys()].map(i => `<option value="${i+1}">${i+1} năm</option>`).join('')}
            </select>
            <button type="button" class="btn btn-sm btn-outline-danger mt-2 remove-skill">Xóa</button>
        </div>
    `;
            document.getElementById('moreSkills').insertAdjacentHTML('beforeend', skillBlock);
        });

        // Xóa skill block
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-skill')) {
                e.target.closest('.skill-item').remove();
            }
        });

        // Autocomplete cho input skill
        const skillSuggestions = ["Java", "PHP", "Python", "JavaScript", "HTML", "CSS", "Laravel", "React", "Node.js", "SQL"];
        document.addEventListener("input", function(e) {
            if (e.target.classList.contains("skill-input")) {
                let input = e.target;
                let list = skillSuggestions.filter(s => s.toLowerCase().includes(input.value.toLowerCase()));
                input.setAttribute("list", "skills-list");
                let datalist = document.getElementById("skills-list");
                if (!datalist) {
                    datalist = document.createElement("datalist");
                    datalist.id = "skills-list";
                    document.body.appendChild(datalist);
                }
                datalist.innerHTML = list.map(item => `<option value="${item}">`).join("");
            }
        });
    </script>
    <!-- xu ly kinh nghiem -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kinhNghiemForm = document.getElementById('kinhNghiemForm');
            const modalTitle = document.getElementById('kinhNghiemModalLabel');
            const submitButton = document.getElementById('kinhNghiemSubmitBtn');

            // Checkbox đang làm việc
            const checkbox = document.getElementById('kn_dangLamViec');
            const denNgayInput = document.getElementById('kn_denNgay');

            // Character counter
            const motaTextarea = document.getElementById('kn_mota');
            const duanTextarea = document.getElementById('kn_duan');
            const motaCount = document.getElementById('mota_count');
            const duanCount = document.getElementById('duan_count');

            // Hàm reset form về trạng thái thêm mới
            function resetFormToAdd() {
                kinhNghiemForm.action = "{{ route('kinhnghiem.store') }}";
                modalTitle.textContent = "Thêm Kinh Nghiệm Làm Việc";
                submitButton.textContent = "Lưu";

                // Xóa input method cũ nếu có
                const methodInput = kinhNghiemForm.querySelector('input[name="_method"]');
                if (methodInput) {
                    methodInput.remove();
                }

                // Reset form
                kinhNghiemForm.reset();
                denNgayInput.disabled = false;
                motaCount.textContent = '0';
                duanCount.textContent = '0';
            }

            // Khi mở modal thêm mới
            document.querySelector('[data-bs-target="#addKinhNghiemModal"]').addEventListener('click', function() {
                resetFormToAdd();
            });

            // Xử lý checkbox "đang làm việc"
            function toggleDenNgay() {
                if (checkbox.checked) {
                    denNgayInput.disabled = true;
                    denNgayInput.value = '';
                } else {
                    denNgayInput.disabled = false;
                }
            }

            checkbox.addEventListener('change', toggleDenNgay);
            toggleDenNgay();

            // Character counter
            if (motaTextarea) {
                motaTextarea.addEventListener('input', function() {
                    motaCount.textContent = this.value.length;
                });
            }

            if (duanTextarea) {
                duanTextarea.addEventListener('input', function() {
                    duanCount.textContent = this.value.length;
                });
            }

            // Xử lý nút Edit
            const editButtons = document.querySelectorAll('.editKinhNghiemBtn');

            editButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.dataset.id;

                    // Fetch dữ liệu kinh nghiệm
                    fetch(`/kinhnghiem/${id}/edit`)
                        .then(res => {
                            if (!res.ok) throw new Error('Không thể lấy dữ liệu');
                            return res.json();
                        })
                        .then(data => {
                            // Thay đổi form thành update mode
                            kinhNghiemForm.action = `/kinhnghiem/${id}/update`;
                            modalTitle.textContent = "Cập Nhật Kinh Nghiệm";
                            submitButton.textContent = "Cập nhật";

                            // Thêm method POST
                            let methodInput = kinhNghiemForm.querySelector('input[name="_method"]');
                            if (!methodInput) {
                                methodInput = document.createElement('input');
                                methodInput.type = 'hidden';
                                methodInput.name = '_method';
                                methodInput.value = 'POST';
                                kinhNghiemForm.appendChild(methodInput);
                            }

                            // Fill dữ liệu vào form
                            document.getElementById('kn_chucdanh').value = data.chucdanh || '';
                            document.getElementById('kn_congty').value = data.congty || '';

                            // Format date từ YYYY-MM-DD sang YYYY-MM
                            const tuNgay = data.tu_ngay ? data.tu_ngay.substring(0, 7) : '';
                            const denNgay = data.den_ngay ? data.den_ngay.substring(0, 7) : '';

                            document.getElementById('kn_tuNgay').value = tuNgay;
                            document.getElementById('kn_denNgay').value = denNgay;
                            document.getElementById('kn_mota').value = data.mota || '';
                            document.getElementById('kn_duan').value = data.duan || '';

                            // Update character count
                            motaCount.textContent = (data.mota || '').length;
                            duanCount.textContent = (data.duan || '').length;

                            // Set checkbox
                            checkbox.checked = data.dang_lam_viec == 1;
                            toggleDenNgay();

                            // Mở modal
                            const modal = new bootstrap.Modal(document.getElementById('addKinhNghiemModal'));
                            modal.show();
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                            alert('Không thể tải dữ liệu kinh nghiệm. Vui lòng thử lại!');
                        });
                });
            });
        });
    </script>

    @include('applicant.partials.footer')
</body>

</html>