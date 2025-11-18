<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $company->tencty ?? 'Công ty' }} - JobIT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.6s ease-out;
        }

        .sticky-nav {
            position: sticky;
            top: 0;
            z-index: 40;
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- HEADER -->
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-blue-600 rounded-xl flex items-center justify-center shadow-lg text-white font-bold">JB</div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">JobIT</span>
                </div>

                <nav class="hidden md:flex items-center gap-6">
                    <a href="#about" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">Giới thiệu</a>
                    <a href="#jobs" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">Việc làm</a>
                    <a href="#culture" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">Văn hóa</a>
                    <a href="#contact" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">Liên hệ</a>
                </nav>

                <div class="flex items-center gap-3">
                    <a href="{{ route('employer.dashboard') }}" class="px-4 py-2 text-gray-600 hover:text-purple-600 font-medium transition-colors">
                        ← Quay lại
                    </a>
                    <button class="px-6 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg font-semibold hover:shadow-lg transition-all">
                        Theo dõi
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- BANNER SECTION -->
    <section class="relative h-80 bg-gradient-to-r from-purple-600 to-blue-600 overflow-hidden">
        @if($company->banner)
        <img src="{{ asset('assets/img/' . $company->banner) }}"
            alt="Company Banner"
            class="w-full h-full object-cover opacity-90" />
        @else
        <div class="absolute inset-0 bg-gradient-to-br from-purple-600 via-blue-600 to-purple-800"></div>
        @endif
        <div class="absolute inset-0 bg-black bg-opacity-30"></div>

        <!-- Company Info Card -->
        <div class="absolute bottom-0 left-0 right-0 transform translate-y-1/2">
            <div class="max-w-7xl mx-auto px-6">
                <div class="bg-white rounded-2xl shadow-2xl p-8 animate-fadeIn">
                    <div class="flex items-start gap-6">
                        <!-- Logo -->
                        <div class="flex-shrink-0">
                            <!-- Logo -->
                            @if($company->logo)
                            <img src="{{ asset('assets/img/' . $company->logo) }}"
                                alt="Logo"
                                class="w-32 h-32 object-contain rounded-xl border-4 border-white shadow-lg bg-white" />
                            @else
                            <div class="w-32 h-32 bg-gradient-to-br from-purple-500 to-blue-500 rounded-xl flex items-center justify-center text-white text-4xl font-bold shadow-lg">
                                {{ substr($company->tencty ?? 'C', 0, 1) }}
                            </div>
                            @endif
                        </div>

                        <!-- Company Details -->
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $company->tencty ?? 'Tên công ty' }}</h1>

                            @if($company->tagline_cty)
                            <p class="text-lg text-gray-600 mb-4">{{ $company->tagline_cty }}</p>
                            @endif

                            <div class="flex flex-wrap gap-4 mb-4">
                                @if($company->quymo)
                                <div class="flex items-center gap-2 text-gray-700">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span class="font-medium">{{ $company->quymo }} nhân viên</span>
                                </div>
                                @endif

                                @if($company->tinh_thanh)
                                <div class="flex items-center gap-2 text-gray-700">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="font-medium">{{ $company->tinh_thanh }}</span>
                                </div>
                                @endif

                                @if($company->quoctich_cty)
                                <div class="flex items-center gap-2 text-gray-700">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="font-medium">{{ $company->quoctich_cty }}</span>
                                </div>
                                @endif
                            </div>

                            <div class="flex items-center gap-3">
                                @if($company->website_cty)
                                <a href="{{ $company->website_cty }}" target="_blank" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                    </svg>
                                    Website
                                </a>
                                @endif

                                @if($company->mxh_cty)
                                <a href="{{ $company->mxh_cty }}" target="_blank" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                    </svg>
                                    Mạng xã hội
                                </a>
                                @endif
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="hidden lg:flex flex-col gap-4">
                            <div class="text-center px-6 py-3 bg-purple-50 rounded-lg">
                                <div class="text-2xl font-bold text-purple-600">{{ $jobCount ?? 0 }}</div>
                                <div class="text-sm text-gray-600">Việc làm</div>
                            </div>
                            <div class="text-center px-6 py-3 bg-blue-50 rounded-lg">
                                <div class="text-2xl font-bold text-blue-600">{{ $followerCount ?? 0 }}</div>
                                <div class="text-sm text-gray-600">Người theo dõi</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- STICKY NAVIGATION -->
    <nav class="sticky-nav bg-white border-b border-gray-200 shadow-sm mt-24">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex gap-8">
                <a href="#about" class="nav-link py-4 border-b-2 border-purple-600 text-purple-600 font-semibold">Giới thiệu</a>
                <a href="#jobs" class="nav-link py-4 border-b-2 border-transparent text-gray-600 hover:text-purple-600 font-medium">Việc làm đang tuyển</a>
                <a href="#culture" class="nav-link py-4 border-b-2 border-transparent text-gray-600 hover:text-purple-600 font-medium">Văn hóa công ty</a>
                <a href="#benefits" class="nav-link py-4 border-b-2 border-transparent text-gray-600 hover:text-purple-600 font-medium">Phúc lợi</a>
                <a href="#contact" class="nav-link py-4 border-b-2 border-transparent text-gray-600 hover:text-purple-600 font-medium">Liên hệ</a>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- LEFT COLUMN - Main Content -->
            <div class="lg:col-span-2 space-y-8">

                <!-- About Section -->
                <section id="about" class="bg-white rounded-2xl shadow-lg p-8 animate-fadeIn">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Giới thiệu công ty
                    </h2>

                    @if($company->mota_cty)
                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                        {!! nl2br(e($company->mota_cty)) !!}
                    </div>
                    @else
                    <p class="text-gray-500 italic">Chưa có thông tin giới thiệu</p>
                    @endif
                </section>

                <!-- Jobs Section -->
                <section id="jobs" class="bg-white rounded-2xl shadow-lg p-8 animate-fadeIn">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Việc làm đang tuyển ({{ $jobs->count() }})
                        </h2>
                        <button class="text-purple-600 hover:text-purple-700 font-medium">Xem tất cả →</button>
                    </div>

                    @if($jobs->count() > 0)
                    <div class="space-y-4">
                        @foreach($jobs as $job)
                        <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-all hover:border-purple-300">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2 hover:text-purple-600 cursor-pointer">
                                        {{ $job->title }}
                                    </h3>

                                    <div class="flex flex-wrap gap-2 mb-3">
                                        <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-medium">
                                            {{ ucfirst($job->level) }}
                                        </span>
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                                            {{ ucfirst($job->working_type) }}
                                        </span>
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                                            {{ $job->province }}
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-4 text-sm text-gray-600">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            @if($job->salary_type === 'negotiable')
                                            Thỏa thuận
                                            @else
                                            {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }} {{ strtoupper($job->salary_type) }}
                                            @endif
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Hạn nộp: {{ date('d/m/Y', strtotime($job->deadline)) }}
                                        </span>
                                    </div>
                                </div>

                                <a href="{{ route('job.detail', $job->job_id) }}" class="ml-4 px-6 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:shadow-lg transition-all font-semibold whitespace-nowrap">
                                    Ứng tuyển
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-12">
                        <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-gray-500 text-lg">Hiện tại chưa có vị trí tuyển dụng</p>
                    </div>
                    @endif
                </section>

                <!-- Culture Section -->
                <section id="culture" class="bg-white rounded-2xl shadow-lg p-8 animate-fadeIn">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Văn hóa công ty
                    </h2>
                    <p class="text-gray-700 leading-relaxed">
                        Chúng tôi xây dựng môi trường làm việc năng động, sáng tạo và chuyên nghiệp.
                        Tại đây, mọi ý tưởng đều được lắng nghe và phát triển.
                    </p>
                </section>

                <!-- Benefits Section -->
                <section id="benefits" class="bg-white rounded-2xl shadow-lg p-8 animate-fadeIn">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                        </svg>
                        Chế độ đãi ngộ
                    </h2>

                    @if($company->chedodaingo)
                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                        {!! nl2br(e($company->chedodaingo)) !!}
                    </div>
                    @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-start gap-3 p-4 bg-purple-50 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Lương thưởng cạnh tranh</h3>
                                <p class="text-sm text-gray-600">Mức lương hấp dẫn theo năng lực</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Bảo hiểm đầy đủ</h3>
                                <p class="text-sm text-gray-600">BHXH, BHYT, BHTN theo quy định</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-4 bg-green-50 rounded-lg">
                            <svg class="w-6 h-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Đào tạo & phát triển</h3>
                                <p class="text-sm text-gray-600">Cơ hội học hỏi và thăng tiến</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-4 bg-orange-50 rounded-lg">
                            <svg class="w-6 h-6 text-orange-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Môi trường thân thiện</h3>
                                <p class="text-sm text-gray-600">Team building, du lịch hàng năm</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </section>

            </div>

            <!-- RIGHT COLUMN - Sidebar -->
            <div class="space-y-6">

                <!-- Contact Card -->
                <div id="contact" class="bg-white rounded-2xl shadow-lg p-6 sticky top-24">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Thông tin liên hệ</h3>

                    @if($company->email_cty)
                    <div class="flex items-start gap-3 mb-4">
                        <svg class="w-5 h-5 text-purple-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Email</p>
                            <a href="mailto:{{ $company->email_cty }}" class="text-gray-900 hover:text-purple-600 font-medium">{{ $company->email_cty }}</a>
                        </div>
                    </div>
                    @endif

                    @if($company->sdt_cty)
                    <div class="flex items-start gap-3 mb-4">
                        <svg class="w-5 h-5 text-purple-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Điện thoại</p>
                            <a href="tel:{{ $company->sdt_cty }}" class="text-gray-900 hover:text-purple-600 font-medium">{{ $company->sdt_cty }}</a>
                        </div>
                    </div>
                    @endif


                    @if($company->dia_chi_cu_the)
                    <div class="flex items-start gap-3 mb-4">
                        <svg class="w-5 h-5 text-purple-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Địa chỉ</p>
                            <p class="text-gray-900 font-medium">
                                {{ $company->dia_chi_cu_the }}
                            </p>
                        </div>
                    </div>
                    @endif

                    <div class="pt-4 border-t border-gray-200">
                        <button class="w-full px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg font-semibold hover:shadow-lg transition-all">
                            Liên hệ ngay
                        </button>
                    </div>
                </div>

                <!-- Recruiters Card -->
                @if($recruiters->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Nhà tuyển dụng</h3>
                    <div class="space-y-4">
                        @foreach($recruiters->take(3) as $recruiter)
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                                {{ substr($recruiter->ten_nv, 0, 2) }}
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">{{ $recruiter->ten_nv }}</p>
                                <p class="text-sm text-gray-600">{{ $recruiter->chucvu }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Quick Stats -->
                <div class="bg-gradient-to-br from-purple-600 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
                    <h3 class="text-xl font-bold mb-4">Tại sao chọn chúng tôi?</h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Môi trường làm việc chuyên nghiệp</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Cơ hội thăng tiến rõ ràng</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Đãi ngộ hấp dẫn</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Đào tạo & phát triển</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold">JB</div>
                        <span class="text-xl font-bold">JobIT</span>
                    </div>
                    <p class="text-gray-400 text-sm">Nền tảng tuyển dụng IT hàng đầu Việt Nam</p>
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Về chúng tôi</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Giới thiệu</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Liên hệ</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Điều khoản</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Hỗ trợ</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Trung tâm trợ giúp</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Câu hỏi thường gặp</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Báo cáo</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Kết nối với chúng tôi</h4>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-purple-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-purple-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-purple-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
                <p>&copy; 2025 JobIT. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Smooth Scroll Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll for navigation
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        const headerOffset = 80;
                        const elementPosition = target.getBoundingClientRect().top;
                        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });

                        // Update active nav link
                        document.querySelectorAll('.nav-link').forEach(link => {
                            link.classList.remove('border-purple-600', 'text-purple-600');
                            link.classList.add('border-transparent', 'text-gray-600');
                        });
                        this.classList.remove('border-transparent', 'text-gray-600');
                        this.classList.add('border-purple-600', 'text-purple-600');
                    }
                });
            });

            // Highlight active section on scroll
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.nav-link');

            window.addEventListener('scroll', () => {
                let current = '';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;
                    if (pageYOffset >= sectionTop - 150) {
                        current = section.getAttribute('id');
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove('border-purple-600', 'text-purple-600');
                    link.classList.add('border-transparent', 'text-gray-600');
                    if (link.getAttribute('href') === `#${current}`) {
                        link.classList.remove('border-transparent', 'text-gray-600');
                        link.classList.add('border-purple-600', 'text-purple-600');
                    }
                });
            });
        });
    </script>

</body>

</html>