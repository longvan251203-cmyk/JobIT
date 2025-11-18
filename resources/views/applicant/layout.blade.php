<!DOCTYPE html>
<html lang="vi">

@include('applicant.partials.head') {{-- phần <head> chung --}}

<body>

    {{-- Header chung --}}
    @include('applicant.partials.header')

    {{-- Nội dung chính của từng trang --}}
    <main id="main" class="main">
        <div class="container-fluid py-4">
            @yield('content')
        </div>
    </main>

    {{-- Footer chung --}}
    @include('applicant.partials.footer')

</body>

</html>