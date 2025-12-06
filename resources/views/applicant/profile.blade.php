<!DOCTYPE html>
<html lang="vi">

@include('applicant.partials.head')

<body>

    @include('applicant.partials.header')

    <!-- ======= Main ======= -->
    <main class="main">
        <div class="container-fluid">
            <div class="row">

                <!-- Sidebar -->
                <div class="col-md-3 col-lg-3 mb-4">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body">
                            <h6 class="text-muted">Xin chào</h6>
                            <h5 class="fw-bold">{{ Auth::user()->applicant->hoten_uv  ?? 'Ứng viên' }}</h5>
                            <p class="text-secondary small mb-1">{{ Auth::user()->email ?? '' }}</p>
                            <hr>
                            <ul class="nav flex-column">
                                <li class="nav-item mb-2">
                                    <a href="{{ route('applicant.profile') }}" class="nav-link active text-primary fw-bold">
                                        <i class="bi bi-grid"></i> Tổng quan
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="{{ route('applicant.hoso') }}" class="nav-link text-dark"><i class="bi bi-person-badge"></i> Thông tin cá nhân</a>
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
                    <div class="card shadow-sm border-0 rounded-3 mb-4">
                        <div class="card-body">
                            <h4 class="fw-bold mb-3">{{ Auth::user()->applicant->hoten_uv ?? 'Họ tên ứng viên' }}</h4>
                            <p class="mb-1"><i class="bi bi-envelope"></i> {{ Auth::user()->email ?? '' }}</p>
                            <p class="text-muted"><i class="bi bi-briefcase"></i> {{ Auth::user()->applicant->vitritungtuyen ?? 'Chưa cập nhật chức danh' }}</p>
                            <a href="{{ route('applicant.hoso') }}" class="btn btn-sm btn-outline-primary">Cập nhật thông tin</a>
                        </div>
                    </div>

                    <!-- Hồ sơ đính kèm -->
                    <div class="card shadow-sm border-0 rounded-3 mb-4">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Hồ sơ đính kèm của bạn</h5>
                            <div class="border p-4 rounded text-center text-muted">
                                <p>Bạn chưa đính kèm CV. Tải lên CV để tối ưu quá trình tìm việc.</p>
                                <a href="#" class="btn btn-sm btn-outline-secondary">Quản lý hồ sơ đính kèm</a>
                            </div>
                        </div>
                    </div>

                    <!-- Hồ sơ IT Job -->
                    <div class="card shadow-sm border-0 rounded-3 mb-4">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Hồ sơ IT Job</h5>
                            <div class="d-flex align-items-center">
                                <div class="progress w-50 me-3" style="height: 20px;">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 5%">5%</div>
                                </div>
                                <span class="text-muted">Hoàn thành</span>
                            </div>
                            <p class="mt-2">Nâng cấp hồ sơ của bạn lên <span class="fw-bold text-danger">70%</span> để bắt đầu tạo CV chuyên nghiệp.</p>
                            <a href="#" class="btn btn-sm btn-outline-primary">Nâng cấp hồ sơ</a>
                        </div>
                    </div>

                    <!-- Hoạt động -->
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Hoạt động của bạn</h5>
                            <div class="row text-center">
                                <div class="col-md-4 mb-3">
                                    <div class="p-3 border rounded bg-light">
                                        <h4 class="fw-bold text-primary">0</h4>
                                        <p class="mb-0">Việc làm đã ứng tuyển</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="p-3 border rounded bg-light">
                                        <h4 class="fw-bold text-danger">0</h4>
                                        <p class="mb-0">Việc làm đã lưu</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="p-3 border rounded bg-light">
                                        <h4 class="fw-bold text-success">0</h4>
                                        <p class="mb-0">Lời mời công việc</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- End col-9 -->
            </div>
        </div>
    </main><!-- End Main -->

    @include('applicant.partials.footer')

</body>

</html>