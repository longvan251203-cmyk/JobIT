<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

        <a href="/" class="logo d-flex align-items-center me-auto">
            <img src="{{ asset('assets/img/logo.png') }}" alt="">
            <h1 class="sitename">Job-IT</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="/">Trang chủ</a></li>
                <li><a href="/#about">Giới thiệu</a></li>
                <li><a href="/#cty">Công ty</a></li>
                <li><a href="/#job">Việc làm</a></li>
                <li><a href="/#blog">Blog</a></li>
                <li><a href="/#contact">Contact</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <div class="header-buttons d-flex gap-2">
            <a class="btn-getstarted flex-md-shrink-0" href="#employer">Nhà tuyển dụng</a>

            @guest
                <a class="btn-getstarted flex-md-shrink-0" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                    Đăng nhập
                </a>
            @else
                <div class="dropdown">
                    <a class="btn-getstarted dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Trang cá nhân</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item" type="submit">Đăng xuất</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endguest
        </div>
    </div>
</header>
