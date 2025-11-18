<header id="header" class="header d-flex align-items-center fixed-top shadow-sm">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

        {{-- Logo --}}
        <a href="{{ route('applicant.dashboard') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('assets/img/logo.png') }}" alt="">
            <h1 class="sitename ms-2">Job-IT</h1>
        </a>

        {{-- Menu chính --}}
        <nav id="navmenu" class="navmenu">
            <ul class="d-flex align-items-center mb-0">
                <li><a href="{{ route('applicant.dashboard') }}" class="active">Trang chủ</a></li>
                <li class="dropdown">
                    <a href="#"><span>Việc làm</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="#">Theo khu vực</a></li>
                        <li><a href="#">Theo lĩnh vực</a></li>
                        <li><a href="#">Theo kỹ năng</a></li>
                        <li><a href="#">Theo từ khóa</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#"><span>Công ty</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="#">Theo khu vực</a></li>
                        <li><a href="#">Theo lĩnh vực</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#"><span>Blog</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="#">Cẩm nang tìm việc</a></li>
                        <li><a href="#">Kỹ năng văn phòng</a></li>
                        <li><a href="#">Kiến thức chuyên ngành</a></li>
                        <li><a href="#">Tin tức tổng hợp</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        {{-- User session --}}
        @if(!Auth::check())
        <a class="btn btn-primary px-3" href="{{ route('login') }}">Đăng nhập</a>
        @else
        <div class="dropdown">
            <button class="btn btn-primary d-flex align-items-center dropdown-toggle" id="dropdownUser"
                data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('assets/img/user.png') }}" alt="" width="30" height="30" class="rounded-circle me-2">
                <span>
                    {{ Auth::user()->applicant->hoten_uv ?? Auth::user()->email }}
                </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2" aria-labelledby="dropdownUser">
                <li><a class="dropdown-item" href="{{ route('applicant.profile') }}">Hồ sơ</a></li>
                <li><a class="dropdown-item" href="#">Thông tin cá nhân</a></li>
                <li><a class="dropdown-item" href="#">Hồ sơ đính kèm</a></li>
                <li><a class="dropdown-item" href="#">Việc làm của tôi</a></li>
                <li><a class="dropdown-item" href="#">Lời mời công việc</a></li>
                <li><a class="dropdown-item" href="#">Thông báo</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">🚪 Đăng xuất</button>
                    </form>
                </li>
            </ul>
        </div>
        @endif

    </div>
    <style>
        /* fix header che nội dung */
        body {
            padding-top: 120px;
            /* đúng bằng chiều cao header */
        }
    </style>
</header>