<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Employer Dashboard - JobIT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* ============================================
   NOTIFICATION STYLES
   ============================================ */

        /* Notification dropdown positioning */
        #notificationDropdown {
            top: calc(100% + 8px);
            right: 0;
        }

        /* Notification item styles */
        .notification-item {
            transition: all 0.2s ease;
            cursor: pointer;
            position: relative;
        }

        .notification-item:hover {
            background-color: #f9fafb;
        }

        /* Unread notification styling */
        .notification-item.unread {
            background-color: #eff6ff;
            border-left: 3px solid #3b82f6;
        }

        .notification-item.unread::before {
            content: '';
            position: absolute;
            left: -3px;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(to bottom, #3b82f6, #8b5cf6);
        }

        /* Notification time text */
        .notification-time {
            font-size: 0.75rem;
            color: #9ca3af;
        }

        /* Badge animation */
        @keyframes badgePulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.9;
            }
        }

        #notificationBadge {
            animation: badgePulse 2s ease-in-out infinite;
        }

        /* Notification icon container */
        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        /* Scrollbar styling for notification list */
        #notificationList::-webkit-scrollbar {
            width: 6px;
        }

        #notificationList::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        #notificationList::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        #notificationList::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Empty state styling */
        .notification-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 1rem;
        }

        /* Notification action buttons */
        .notification-action {
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }

        .notification-action:hover {
            transform: translateY(-1px);
        }

        /* Loading state cho select */
        select.form-control:disabled {
            background-color: #f7fafc;
            cursor: not-allowed;
            opacity: 0.7;
        }

        select.form-control option:disabled {
            color: #a0aec0;
        }

        /* Highlight khi đang load */
        select.form-control[disabled] {
            border-color: #667eea;
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        /* Hashtag Styles - Được thêm từ postjob.blade.php */
        .hashtag-input-wrapper {
            position: relative;
        }

        .hashtag-input {
            padding-right: 80px;
        }

        .add-hashtag-btn {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 30;
            /* Ensure button is above suggestions */
        }

        .add-hashtag-btn:hover {
            transform: translateY(-50%) scale(1.05);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        /* Autocomplete Suggestions */
        .hashtag-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 80px;
            background: white;
            border: 2px solid #667eea;
            border-top: none;
            border-radius: 0 0 10px 10px;
            max-height: 250px;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            display: none;
            margin-top: -2px;
        }

        .suggestion-item {
            padding: 10px 16px;
            cursor: pointer;
            font-size: 14px;
            color: #4a5568;
            transition: background-color 0.2s;
        }

        .suggestion-item:hover {
            background-color: #f7fafc;
        }

        /* Displayed Hashtags */
        .hashtags-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 10px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            min-height: 50px;
            margin-top: 10px;
            align-items: center;
        }

        .hashtags-empty {
            color: #a0aec0;
            font-size: 14px;
        }

        .hashtag-tag {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            padding-right: 8px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: default;
        }

        /* Hashtag colors */
        .hashtag-tag.color-1 {
            background: #E6E0F8;
            color: #4338CA;
        }

        .hashtag-tag.color-2 {
            background: #F3E5F5;
            color: #7B1FA2;
        }

        .hashtag-tag.color-3 {
            background: #E8F5E9;
            color: #388E3C;
        }

        .hashtag-tag.color-4 {
            background: #FFF3E0;
            color: #F57C00;
        }

        .hashtag-tag.color-5 {
            background: #FCE4EC;
            color: #C2185B;
        }

        .hashtag-tag.color-6 {
            background: #E0F2F1;
            color: #00796B;
        }

        .hashtag-tag.color-7 {
            background: #FFF9C4;
            color: #F57F17;
        }

        .hashtag-tag.color-8 {
            background: #FFEBEE;
            color: #C62828;
        }

        .remove-hashtag {
            background: rgba(0, 0, 0, 0.1);
            border: none;
            color: inherit;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            margin-left: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 10px;
            transition: background-color 0.2s;
            line-height: 1;
        }

        .remove-hashtag:hover {
            background: rgba(0, 0, 0, 0.2);
        }

        /* Edit Job Modal Styles */
        #editJobModal {
            animation: fadeIn 0.3s ease;
        }

        #editJobModal .bg-white {
            animation: slideUp 0.4s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .edit-tab-content {
            animation: tabSlideIn 0.3s ease;
        }

        @keyframes tabSlideIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Smooth transitions for form inputs */
        #editJobForm input:focus,
        #editJobForm select:focus,
        #editJobForm textarea:focus {
            transition: all 0.3s ease;
        }

        /* Button hover effects */
        #editJobModal button {
            transition: all 0.3s ease;
        }

        #editJobModal button:hover {
            transform: translateY(-1px);
        }

        #editJobModal button:active {
            transform: translateY(0);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.5s ease-out both;
        }

        .animate-slideInLeft {
            animation: slideInLeft 0.4s ease-out both;
        }

        .file-upload-zone {
            position: relative;
            overflow: hidden;
        }

        .file-upload-zone input[type="file"] {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            opacity: 0;
            cursor: pointer;
        }

        .preview-image {
            max-width: 100%;
            max-height: 200px;
            object-fit: contain;
        }

        [contenteditable="true"].empty:before {
            content: attr(data-placeholder);
            color: #9CA3AF;
        }

        [contenteditable="true"]:focus {
            outline: none;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-gray-50 via-purple-50 to-blue-50">

    <!-- HEADER -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 max-w-7xl mx-auto">
            <div class="flex items-center gap-4">
                <button id="btnToggleSidebar" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <div class="flex items-center gap-3">
                    <span class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">JobIT</span>
                </div>
            </div>

            <div class="hidden md:flex items-center flex-1 max-w-2xl mx-8">
                <div class="relative w-full">
                    <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35"></path>
                    </svg>
                    <input type="text" placeholder="Tìm kiếm công việc, kỹ năng..." class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:bg-white transition-all" />
                </div>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ url('/employer/postjob') }}" class="hidden md:block px-4 py-2 text-purple-600 border border-purple-600 rounded-lg font-semibold hover:bg-purple-50 transition-all">Đăng tuyển</a>
                <button class="px-4 py-2 text-purple-600 border border-purple-600 rounded-lg font-semibold hover:bg-purple-50 transition-all">Thông tin ứng viên</button>

                <!-- ✅ NÚT THÔNG BÁO MỚI -->
                <div class="relative">
                    <button id="btnNotifications" class="relative p-2 rounded-xl hover:bg-gray-100 transition-all duration-300">
                        <svg class="w-6 h-6 text-purple-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span id="notificationBadge" class="hidden absolute top-0 right-0 min-w-[20px] h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center px-1.5 animate-pulse">0</span>
                    </button>

                    <!-- DROPDOWN THÔNG BÁO -->
                    <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50 max-h-[500px] flex flex-col">
                        <!-- Header -->
                        <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                            <h3 class="font-semibold text-gray-800">Thông báo</h3>
                            <button id="btnMarkAllRead" class="text-xs text-purple-600 hover:text-purple-700 font-medium transition-colors">
                                Đánh dấu tất cả đã đọc
                            </button>
                        </div>

                        <!-- Notification List -->
                        <div id="notificationList" class="flex-1 overflow-y-auto">
                            <div class="p-8 text-center text-gray-500">
                                <svg class="w-16 h-16 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                <p>Chưa có thông báo nào</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <button id="btnProfile" class="flex items-center gap-3 p-2 rounded-xl hover:bg-gray-100 transition-all">
                        @php
                        $company = auth()->user()->employer->company ?? null;
                        $logoPath = $company && $company->logo
                        ? asset('assets/img/' . $company->logo)
                        : null;
                        @endphp

                        @if($logoPath)
                        <img src="{{ $logoPath }}" alt="Company Logo" class="w-10 h-10 rounded-full object-cover shadow-lg">
                        @else
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-blue-500 rounded-full flex items-center justify-center text-white font-semibold shadow-lg">
                            {{ strtoupper(substr($company->tencty ?? 'TD', 0, 2)) }}
                        </div>
                        @endif

                        <svg class="w-4 h-4 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>

                    <div id="profileMenu" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-100 py-2">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="font-semibold text-gray-800">
                                {{ auth()->user()->employer->company->tencty ?? 'Chưa cập nhật' }}

                            </p>

                            <p class="text-sm text-gray-500">
                                {{ auth()->user()->email ?? 'Không có email' }}
                            </p>
                        </div>

                        <button class="w-full px-4 py-2 text-left hover:bg-gray-50 flex items-center gap-3 text-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Cài đặt
                        </button>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full px-4 py-2 text-left hover:bg-gray-50 flex items-center gap-3 text-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Đăng xuất
                            </button>
                        </form>

                    </div>
                </div>

                <button class="p-2 rounded-lg hover:bg-gray-100">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 60 30'%3E%3Crect width='60' height='10' fill='%23012169'/%3E%3Crect y='10' width='60' height='10' fill='%23FFF'/%3E%3Crect y='20' width='60' height='10' fill='%23C8102E'/%3E%3C/svg%3E" alt="EN" class="w-6 h-4" />
                </button>
            </div>
        </div>
    </header>

    <div class="flex pt-4">
        <!-- SIDEBAR -->
        <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-40 w-72 bg-white border-r border-gray-200 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 overflow-y-auto">
            <nav class="p-6 space-y-2">
                <div class="mb-6">
                    <a href="{{ url('/employer/postjob') }}" id="btnPostJob" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        ĐĂNG TUYỂN
                    </a>
                </div>

                <button data-id="dashboard" class="sidebar-item w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 text-gray-700 hover:bg-gray-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="flex-1 text-left font-medium">Bảng điều khiển</span>
                </button>

                <button data-id="company-info" class="sidebar-item w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 text-gray-700 hover:bg-gray-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="flex-1 text-left font-medium">Thông tin công ty</span>
                </button>

                <button data-id="contact-info" class="sidebar-item w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 text-gray-700 hover:bg-gray-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="flex-1 text-left font-medium">Thông tin liên hệ</span>
                </button>

                <button data-id="candidates" class="sidebar-item w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 text-gray-700 hover:bg-gray-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span class="flex-1 text-left font-medium">Tìm kiếm ứng viên</span>
                </button>
                @php
                $employer = auth()->user()->employer;
                $jobPostsCount = $employer && $employer->company
                ? \App\Models\JobPost::where('companies_id', $employer->company->companies_id)->count()
                : 0;
                @endphp
                <button data-id="jobs" class="sidebar-item w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 text-gray-700 hover:bg-gray-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span class="flex-1 text-left font-medium">Quản lý tin đăng</span>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-600">{{ $jobPostsCount }}</span>
                </button>

                <button data-id="applicants" class="sidebar-item w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 text-gray-700 hover:bg-gray-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="flex-1 text-left font-medium">Thông tin ứng viên</span>
                </button>

                <button data-id="history" class="sidebar-item w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 text-gray-700 hover:bg-gray-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="flex-1 text-left font-medium">Lịch sử sử dụng</span>
                </button>

                <div class="pt-6 mt-6 border-t border-gray-200">
                    <div class="p-4 bg-gradient-to-br from-purple-50 to-blue-50 rounded-xl border border-purple-100">
                        <p class="text-sm font-semibold text-gray-800 mb-1">Cần hỗ trợ?</p>
                        <p class="text-xs text-gray-600 mb-2">Hotline: +8428 6656 7848</p>
                        <p class="text-xs text-gray-600">Email: customercare@topdev.vn</p>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <main id="mainContent" class="flex-1 p-8 overflow-y-auto min-h-screen">
            <!-- Dashboard Tab -->
            <div id="dashboard" class="tab-content">
                <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent mb-8">Bảng điều khiển</h1>

                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all border border-gray-100 animate-fadeInUp">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mb-4 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-800 mb-2">12</h3>
                        <p class="text-sm text-gray-600 mb-2">Tin đăng tuyển</p>
                        <span class="inline-flex items-center text-sm font-semibold text-green-600">+3 tin mới</span>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all border border-gray-100 animate-fadeInUp" style="animation-delay: 0.08s;">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-4 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-800 mb-2">248</h3>
                        <p class="text-sm text-gray-600 mb-2">Ứng viên tiềm năng</p>
                        <span class="inline-flex items-center text-sm font-semibold text-green-600">+18 tuần này</span>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all border border-gray-100 animate-fadeInUp" style="animation-delay: 0.16s;">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mb-4 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-800 mb-2">1,432</h3>
                        <p class="text-sm text-gray-600 mb-2">Lượt xem hồ sơ</p>
                        <span class="inline-flex items-center text-sm font-semibold text-green-600">+124 hôm nay</span>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all border border-gray-100 animate-fadeInUp" style="animation-delay: 0.24s;">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mb-4 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-800 mb-2">8</h3>
                        <p class="text-sm text-gray-600 mb-2">Tin đang hoạt động</p>
                        <span class="inline-flex items-center text-sm font-semibold text-green-600">+2 tin mới</span>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                    <h2 class="text-2xl font-bold mb-6">Hoạt động gần đây</h2>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 p-4 bg-purple-50 rounded-xl">
                            <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center text-white font-semibold">AN</div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">Anh Nguyễn đã ứng tuyển</p>
                                <p class="text-sm text-gray-600">Senior Frontend Developer • 2 giờ trước</p>
                            </div>
                            <button class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">Xem hồ sơ</button>
                        </div>
                    </div>
                </div>
            </div>




            <!-- Contact Info Tab -->
            <form id="contactForm" action="{{ route('company.updateContact') }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Contact Info Tab -->
                <div id="contact-info" class="tab-content">
                    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">

                        <!-- Header -->
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">Thông tin liên hệ</h2>
                            <p class="text-sm text-gray-600">Bạn nên điền thông tin liên hệ chính của công ty tại đây. Chúng tôi sẽ liên hệ hỗ trợ & làm việc qua trên thông tin này</p>
                        </div>
                        @if(session('success'))
                        <script>
                            alert("{{ session('success') }}");
                        </script>
                        @endif

                        <!-- Email -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Địa chỉ email</label>
                            <div class="relative">
                                <input type="email"
                                    id="emailInput"
                                    name="email_cty"
                                    value="{{ $company->email_cty ?? '' }}"
                                    placeholder="Thêm email công ty"
                                    readonly
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 cursor-not-allowed" />
                                <button type="button" id="btnEditEmail"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                    <span class="btn-text">CHỈNH SỬA</span>
                                </button>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Số điện thoại</label>
                            <div class="relative">
                                <input type="tel"
                                    id="phoneInput"
                                    name="sdt_cty"
                                    value="{{ $company->sdt_cty ?? '' }}"
                                    placeholder="Thêm số điện thoại công ty"
                                    readonly
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 cursor-not-allowed" />
                                <button type="button" id="btnEditPhone"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                    <span class="btn-text">CHỈNH SỬA</span>
                                </button>
                            </div>
                        </div>
                        <!--  địa chỉ cụ thể -->
                        <!-- Địa chỉ cụ thể -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Địa chỉ cụ thể</label>
                            <div class="relative">
                                <input type="text"
                                    id="addressDetailInput"
                                    name="dia_chi_cu_the"
                                    value="{{ $company->dia_chi_cu_the ?? '' }}"
                                    placeholder="Thêm địa chỉ cụ thể của công ty"
                                    readonly
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 cursor-not-allowed" />
                                <button type="button" id="btnEditAddressDetail"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                    <span class="btn-text">CHỈNH SỬA</span>
                                </button>
                            </div>
                        </div>

                        <!-- ✅ BỔ SUNG: Recruiter Accounts Table lấy dữ liệu từ DB -->
                        <div class="mt-8">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Tài khoản Nhà tuyển dụng</h3>
                                    <p class="text-sm text-gray-600">
                                        Số lượng: <span class="font-semibold">{{ $recruiters->count() }}</span>
                                    </p>
                                </div>

                                <button type="button" id="btnEditRecruiters"
                                    class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5
                      21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                    <span>CHỈNH SỬA</span>
                                </button>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse bg-white">
                                    <thead>
                                        <tr class="bg-gray-50">
                                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">No</th>
                                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">Tên hiển thị</th>
                                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">Chức vụ</th>
                                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">Email</th>
                                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">Số điện thoại</th>
                                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b border-gray-200 action-column hidden">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody id="recruitersTableBody">

                                        @forelse($recruiters as $index => $recruiter)
                                        <tr class="hover:bg-gray-50 transition-colors recruiter-row" data-id="{{ $recruiter->ma_nv }}">
                                            <td class="px-4 py-3 text-sm text-gray-900 border-b border-gray-200">{{ $index + 1 }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-900 border-b border-gray-200">{{ $recruiter->ten_nv }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-900 border-b border-gray-200">{{ $recruiter->chucvu }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-900 border-b border-gray-200">{{ $recruiter->email_nv }}</td>
                                            <td class="px-4 py-3 text-m text-gray-900 border-b border-gray-200">{{ $recruiter->sdt_nv }}</td>

                                            <td class="px-4 py-3 text-sm border-b border-gray-200 action-column hidden">
                                                <div class="flex items-center gap-2">
                                                    <button type="button" class="btn-edit-recruiter text-blue-600 hover:text-blue-700 p-1 rounded hover:bg-blue-50">✏️</button>
                                                    <button type="button" class="btn-delete-recruiter text-red-600 hover:text-red-700 p-1 rounded hover:bg-red-50">🗑️</button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-3 text-gray-500">
                                                Chưa có nhà tuyển dụng nào.
                                            </td>
                                        </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 add-recruiter-section hidden">
                                <button type="button" id="btnAddRecruiter" data-modal-target="addRecruiterModal"
                                    class="flex items-center gap-2 px-4 py-2 text-blue-600 hover:text-blue-700 border border-blue-600 rounded-lg hover:bg-blue-50 transition-all">
                                    +
                                    <span class="font-medium">Thêm nhà tuyển dụng mới</span>
                                </button>
                            </div>
                        </div>
                        <!-- ✅ KẾT THÚC -->





                    </div>
                </div>

            </form> <!-- ✅ đóng form -->

            <!-- TAB QUẢN LÝ TIN ĐĂNG -->
            <div id="jobs" class="tab-content hidden">
                <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">
                            Quản lý tin đăng
                        </h2>
                        <a href="{{ url('/employer/postjob') }}"
                            class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:shadow-lg transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Đăng tin mới
                        </a>
                    </div>

                    @php
                    $employer = auth()->user()->employer;

                    $jobPosts = $employer && $employer->company
                    ? \App\Models\JobPost::where('companies_id', $employer->company->companies_id)
                    ->with('detail')
                    ->withCount('applications') // ✅ đếm số ứng viên
                    ->orderBy('job_id', 'desc')
                    ->get()
                    : collect();

                    @endphp

                    @if($jobPosts->count() > 0)
                    <div class="space-y-4">
                        @foreach($jobPosts as $job)
                        <div class="p-6 border border-gray-200 rounded-xl hover:shadow-lg transition-all">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <a href="{{ route('job.applicants', $job->job_id) }}"
                                        class="text-lg font-semibold text-gray-800 mb-2 hover:text-purple-600 transition-colors">
                                        {{ $job->title }}
                                    </a>
                                    <div class="flex items-center gap-4 text-sm text-gray-600 mb-3">
                                        @if(strtotime($job->deadline) >= time())
                                        <span class="px-3 py-1 rounded-full font-medium bg-green-100 text-green-700">
                                            Đang tuyển
                                        </span>
                                        @else
                                        <span class="px-3 py-1 rounded-full font-medium bg-red-100 text-red-700">
                                            Hết hạn
                                        </span>
                                        @endif
                                        <span>{{ $job->applications_count }} ứng viên</span>

                                        <span>0 lượt xem</span>
                                        <span>{{ date('d/m/Y', strtotime($job->deadline)) }}</span>
                                    </div>
                                    <div class="flex gap-2 flex-wrap">
                                        <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs">
                                            {{ ucfirst($job->level) }}
                                        </span>
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs">
                                            {{ ucfirst($job->working_type) }}
                                        </span>
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">
                                            {{ $job->province }}
                                        </span>
                                        @if($job->salary_type === 'negotiable')
                                        <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs">
                                            Thỏa thuận
                                        </span>
                                        @else
                                        <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs">
                                            {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
                                            {{ strtoupper($job->salary_type) }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex gap-2 ml-4">
                                    <a href="{{ route('job.detail', $job->job_id) }}"
                                        class="p-2 hover:bg-blue-50 rounded-lg transition-colors"
                                        title="Xem chi tiết">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <button data-job-id="{{ $job->job_id }}"
                                        class="btn-edit-job p-2 hover:bg-purple-50 rounded-lg transition-colors"
                                        title="Sửa">
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button data-job-id="{{ $job->job_id }}"
                                        data-job-title="{{ $job->title }}"
                                        class="btn-delete-job p-2 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Xóa">
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-16">
                        <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-gray-500 text-lg mb-4">Chưa có tin tuyển dụng nào</p>
                        <a href="{{ url('/employer/postjob') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:shadow-lg transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Đăng tin tuyển dụng đầu tiên
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Info company -->
            <div id="company-info" class="tab-content hidden"
                data-province="{{ $company->tinh_thanh ?? '' }}"
                data-district="{{ $company->quan_huyen ?? '' }}">
                <form id="companyForm" enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">
                                Thông tin công ty
                            </h2>
                            <div class="flex gap-3">
                                <!-- Nút Lưu thông tin -->
                                <button type="submit" id="btnSaveCompany"
                                    class="flex items-center gap-2 px-6 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:shadow-lg transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Lưu thông tin
                                </button>

                                <!-- Nút Preview -->

                                <a href="{{ route('company.preview') }}" target="_blank"
                                    id="btnPreviewCompany"
                                    class="flex items-center gap-2 px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Preview
                                </a>
                            </div>
                        </div>

                        @php
                        $company = auth()->user()->employer->company ?? null;
                        @endphp

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Logo <span class="text-red-500">*</span></label>
                                <input type="file" name="logo" accept="image/jpeg,image/jpg,image/png,image/webp,image/avif" id="logoUpload"
                                    class="w-full border border-gray-300 rounded-xl p-2" />
                                <div id="logoPreviewContainer" class="mt-2">
                                    @if($company && $company->logo)
                                    <!-- ✅ Đã có logo/ trong path từ DB rồi -->
                                    <img src="{{ asset('assets/img/' . $company->logo) }}"
                                        class="w-20 rounded-lg border" id="logoPreview" />
                                    @else
                                    <img src="" class="w-20 rounded-lg border hidden" id="logoPreview" />
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Hỗ trợ: JPG, PNG, WEBP, AVIF (Max 2MB)</p>
                            </div>

                        </div>

                        <!-- Banner Preview -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Banner</label>
                            <input type="file" name="banner" accept="image/jpeg,image/jpg,image/png,image/webp,image/avif" id="bannerUpload"
                                class="w-full border border-gray-300 rounded-xl p-2" />
                            <div id="bannerPreviewContainer" class="mt-2">
                                @if($company && $company->banner)
                                <!-- ✅ Đã có banner/ trong path từ DB rồi -->
                                <img src="{{ asset('assets/img/' . $company->banner) }}"
                                    class="w-full rounded-lg border" id="bannerPreview" />
                                @else
                                <img src="" class="w-full rounded-lg border hidden" id="bannerPreview" />
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Hỗ trợ: JPG, PNG, WEBP, AVIF (Max 4MB)</p>
                        </div>

                        <div class="space-y-6 md:col-span-2">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Tên công ty <span class="text-red-500">*</span></label>
                                <input type="text" name="tencty"
                                    value="{{ old('tencty', $company->tencty ?? '') }}"
                                    placeholder="Nhập tên công ty"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500" />
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Quốc tịch công ty <span class="text-red-500">*</span></label>
                                <select name="quoctich_cty"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500">
                                    <option value="">Chọn quốc tịch</option>
                                    <option value="Việt Nam"
                                        {{ old('quoctich_cty', $company->quoctich_cty ?? '') == 'Việt Nam' ? 'selected' : '' }}>
                                        Việt Nam
                                    </option>
                                    <option value="Nước ngoài"
                                        {{ old('quoctich_cty', $company->quoctich_cty ?? '') == 'Nước ngoài' ? 'selected' : '' }}>
                                        Nước ngoài
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tagline công ty</label>
                            <input type="text" name="tagline_cty"
                                value="{{ old('tagline_cty', $company->tagline_cty ?? '') }}"
                                placeholder="Nhập tagline"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500" />
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Quy mô công ty</label>
                            <select name="quymo"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500">
                                <option value="">Chọn quy mô</option>
                                @php
                                $quymoOptions = ['1-50', '51-200', '201-500', '500+', '1000+'];
                                $currentQuymo = old('quymo', $company->quymo ?? '');
                                @endphp

                                @foreach ($quymoOptions as $option)
                                <option value="{{ $option }}" {{ $currentQuymo == $option ? 'selected' : '' }}>
                                    {{ $option }} nhân viên
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Mô tả công ty</label>
                        <textarea name="mota_cty" rows="5" placeholder="Nhập mô tả công ty..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500">{{ old('mota_cty', $company->mota_cty ?? '') }}</textarea>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Chế độ đãi ngộ</label>
                        <textarea name="chedodaingo" rows="4" placeholder="Nhập chế độ đãi ngộ của công ty..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500">{{ old('chedodaingo', $company->chedodaingo ?? '') }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Website</label>
                        <input type="url" name="website_cty"
                            value="{{ old('website_cty', $company->website_cty ?? '') }}"
                            placeholder="https://example.com"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500" />
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Mạng xã hội</label>
                        <input type="url" name="mxh_cty"
                            value="{{ old('mxh_cty', $company->mxh_cty ?? '') }}"
                            placeholder="https://facebook.com/yourcompany"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500" />
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tỉnh / Thành</label>
                            <select id="company_province" name="tinh_thanh"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500">
                                <option value="">-- Đang tải... --</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Quận / Huyện</label>
                            <select id="company_district" name="quan_huyen"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500">
                                <option value="">-- Chọn tỉnh trước --</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Giấy phép Đăng ký kinh doanh <span class="text-red-500">*</span></h3>
                        <p class="text-sm text-gray-500 mb-4">
                            Việc này nhằm xác minh tính hợp pháp của công ty bạn.
                            Xin lưu ý tài liệu này sẽ không hiển thị trên trang web TopDev
                            và được đảm bảo bảo mật.
                        </p>
                        <div class="file-upload-zone border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-purple-500 transition-colors cursor-pointer">
                            <input type="file" accept=".pdf,.jpg,.jpeg,.png" id="businessLicense" />
                            <div id="licensePreview" class="hidden mb-4">
                                <p class="text-green-600 font-semibold" id="licenseFileName"></p>
                            </div>
                            <div id="licensePlaceholder">
                                <svg class="w-16 h-16 text-purple-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="text-lg font-semibold text-gray-700 mb-2">Drag and drop or Duyệt file</p>
                                <p class="text-sm text-gray-500">Hỗ trợ pdf, jpg, png < 5MB</p>
                            </div>
                        </div>
                    </div>

            </div>
            </form>


            <!-- Candidates Tab -->
            <div id="candidates" class="tab-content hidden">
                <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent mb-6">Tìm kiếm ứng viên</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <input type="text" placeholder="Tìm kiếm theo kỹ năng..." class="px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500" />
                        <select class="px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option>Kinh nghiệm</option>
                            <option>0-1 năm</option>
                            <option>1-3 năm</option>
                            <option>3-5 năm</option>
                        </select>
                        <button class="px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-xl font-semibold hover:shadow-lg">Tìm kiếm</button>
                    </div>
                    <div class="text-center py-12">
                        <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <p class="text-gray-500 text-lg">Nhập từ khóa để tìm kiếm</p>
                    </div>
                </div>
            </div>

            <!-- Applicants Tab -->
            <div id="applicants" class="tab-content hidden">
                <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent mb-6">Thông tin ứng viên</h2>
                    <div class="space-y-4">
                        <div class="p-6 border border-gray-200 rounded-xl hover:shadow-lg transition-all">
                            <div class="flex items-start justify-between">
                                <div class="flex gap-4 flex-1">
                                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-blue-500 rounded-full flex items-center justify-center text-white font-bold text-xl">AN</div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Anh Nguyễn</h3>
                                        <p class="text-sm text-gray-600 mb-2">Senior Frontend Developer</p>
                                        <div class="flex gap-2 mb-3">
                                            <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs">React</span>
                                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs">TypeScript</span>
                                        </div>
                                        <p class="text-sm text-gray-500">Ứng tuyển: 2 giờ trước</p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button class="px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:shadow-lg">Xem hồ sơ</button>
                                    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Liên hệ</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- History Tab -->
            <div id="history" class="tab-content hidden">
                <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent mb-6">Lịch sử</h2>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold text-gray-800">Đăng tin tuyển dụng</p>
                                    <p class="text-sm text-gray-600">Senior Frontend Developer</p>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">15/10/2025 14:30</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    </div>






    <!-- CÁC MODAL -->
    @if(session('showCompanyInfoModal'))
    <div id="companyInfoGuideModal"
        class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-lg p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">
                Hoàn tất thông tin công ty
            </h2>
            <p class="text-gray-600 mb-6">
                Hãy hoàn tất các thông tin công ty để đăng tuyển và quản lý hồ sơ ứng viên hiệu quả hơn.
            </p>

            <div class="flex justify-end gap-3">
                <button id="skipUpdateCompany"
                    class="px-4 py-2 rounded-xl bg-gray-200 text-gray-700 hover:bg-gray-300">
                    Để sau
                </button>
                <button id="goUpdateCompany"
                    class="px-4 py-2 rounded-xl bg-blue-600 text-white hover:bg-blue-700">
                    Tiếp tục
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- ✅ Modal thêm nhà tuyển dụng -->
    <div id="addRecruiterModal" class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm hidden flex items-center justify-center z-50">
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6">

            <h3 class="text-xl font-bold text-gray-800 mb-4">Thêm Nhà Tuyển Dụng</h3>

            <form action="{{ route('recruiter.store') }}" method="POST" id="addRecruiterForm">
                @csrf
                <input type="hidden" name="companies_id" value="{{ $company->companies_id }}">

                <div class="grid gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Tên hiển thị</label>
                        <input type="text" name="ten_nv" required
                            class="w-full mt-1 px-3 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Chức vụ</label>
                        <input type="text" name="chucvu" required
                            class="w-full mt-1 px-3 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email_nv" required
                            class="w-full mt-1 px-3 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Số điện thoại</label>
                        <input type="text" name="sdt_nv"
                            class="w-full mt-1 px-3 py-2 border rounded-lg">
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" id="btnCloseModal"
                        class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                        Hủy
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Thêm mới
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- Modal chỉnh sửa Recruiter -->
    <div id="editRecruiterModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
            <h3 class="text-lg font-semibold mb-4">Chỉnh sửa Nhà tuyển dụng</h3>
            <form id="editRecruiterForm">
                <input type="hidden" name="ma_nv" id="edit_ma_nv">
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700">Tên hiển thị</label>
                    <input type="text" id="edit_ten_nv" name="ten_nv" placeholder="Tên nhà tuyển dụng" class="mt-1 block w-full border rounded p-2">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700">Chức vụ</label>
                    <input type="text" id="edit_chucvu" name="chucvu" placeholder="Chức vụ" class="mt-1 block w-full border rounded p-2">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="edit_email_nv" name="email_nv" placeholder="Email" class="mt-1 block w-full border rounded p-2">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                    <input type="text" id="edit_sdt_nv" name="sdt_nv" placeholder="Số điện thoại" class="mt-1 block w-full border rounded p-2">
                </div>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" id="btnCloseEditModal" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Hủy</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Lưu</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Chỉnh Sửa Tin Đăng -->
    <div id="editJobModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden items-center justify-center z-50" style="display: none;">
        <div class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl max-h-[90vh] overflow-hidden flex flex-col">

            <!-- Header -->
            <div class="bg-gradient-to-r from-purple-600 to-blue-600 p-6 text-white flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold">✏️ Chỉnh Sửa Tin Đăng</h2>
                    <p class="text-sm opacity-90 mt-1">Cập nhật thông tin tuyển dụng</p>
                </div>
                <button type="button" id="btnCloseEditModal" class="text-white hover:bg-white/20 rounded-lg p-2 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Progress Bar -->
            <div class="flex border-b border-gray-200 bg-gray-50 px-6">
                <button type="button" class="edit-tab-btn flex-1 py-4 text-center font-semibold transition-all border-b-2 border-transparent text-gray-600 hover:text-purple-600" data-tab="edit-tab1">
                    <span class="inline-flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-gray-300 text-white text-sm flex items-center justify-center">1</span>
                        Thông tin chung
                    </span>
                </button>
                <button type="button" class="edit-tab-btn flex-1 py-4 text-center font-semibold transition-all border-b-2 border-transparent text-gray-600 hover:text-purple-600" data-tab="edit-tab2">
                    <span class="inline-flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-gray-300 text-white text-sm flex items-center justify-center">2</span>
                        Thông tin chi tiết
                    </span>
                </button>
            </div>

            <!-- Form Content -->
            <div class="flex-1 overflow-y-auto p-6">
                <form id="editJobForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_job_id" name="job_id">

                    <!-- Tab 1: Thông tin chung -->
                    <div id="edit-tab1" class="edit-tab-content">
                        <div class="space-y-5">

                            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                                <p class="text-sm text-blue-800">
                                    💡 <strong>Lưu ý:</strong> Cập nhật thông tin chính xác giúp thu hút ứng viên phù hợp hơn!
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tiêu đề công việc <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="edit_title" name="title" required maxlength="200"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <div class="text-right text-xs text-gray-500 mt-1">
                                    <span id="edit_titleCount">0</span>/200 ký tự
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Hashtags (Từ khóa)</label>
                                <div class="hashtag-input-wrapper">
                                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 hashtag-input" id="edit_hashtagInput" placeholder="VD: ReactJS, NodeJS, Remote..." maxlength="50" autocomplete="off">
                                    <button type="button" class="add-hashtag-btn" id="btnAddEditHashtag">+ Thêm</button>
                                    <div class="hashtag-suggestions" id="edit_hashtagSuggestions"></div>
                                </div>
                                <div class="hashtags-container" id="edit_hashtagsContainer">
                                    <span class="hashtags-empty">Chưa có hashtag nào. Nhấn Enter hoặc nút Thêm để thêm hashtag</span>
                                </div>
                                <input type="hidden" name="hashtags" id="edit_hashtagsHiddenInput">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Cấp bậc <span class="text-red-500">*</span>
                                    </label>
                                    <select id="edit_level" name="level" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500">
                                        <option value="">-- Chọn cấp bậc --</option>
                                        <option value="intern">Thực tập sinh</option>
                                        <option value="fresher">Fresher</option>
                                        <option value="junior">Junior</option>
                                        <option value="middle">Middle/Senior</option>
                                        <option value="senior">Senior</option>
                                        <option value="leader">Leader/Manager</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Kinh nghiệm <span class="text-red-500">*</span>
                                    </label>
                                    <select id="edit_experience" name="experience" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500">
                                        <option value="">-- Chọn kinh nghiệm --</option>
                                        <option value="no_experience">Không yêu cầu</option>
                                        <option value="under_1">Dưới 1 năm</option>
                                        <option value="1_2">1-2 năm</option>
                                        <option value="2_5">2-5 năm</option>
                                        <option value="5_plus">Trên 5 năm</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Mức lương <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-3 gap-3">
                                    <select id="edit_salary_type" name="salary_type" required
                                        class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500">
                                        <option value="">Loại lương</option>
                                        <option value="vnd">VNĐ</option>
                                        <option value="usd">USD</option>
                                        <option value="negotiable">Thỏa thuận</option>
                                    </select>
                                    <input type="number" id="edit_salary_min" name="salary_min" placeholder="Từ (triệu)" min="0"
                                        class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500">
                                    <input type="number" id="edit_salary_max" name="salary_max" placeholder="Đến (triệu)" min="0"
                                        class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Hình thức làm việc <span class="text-red-500">*</span>
                                    </label>
                                    <select id="edit_working_type" name="working_type" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500">
                                        <option value="">-- Chọn hình thức --</option>
                                        <option value="fulltime">Toàn thời gian</option>
                                        <option value="parttime">Bán thời gian</option>
                                        <option value="remote">Remote</option>
                                        <option value="hybrid">Hybrid</option>
                                        <option value="freelance">Freelance</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Số lượng tuyển <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" id="edit_recruitment_count" name="recruitment_count" min="1" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Tỉnh/Thành phố <span class="text-red-500">*</span>
                                    </label>
                                    <select id="edit_province" name="province" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500">
                                        <option value="">-- Đang tải... --</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Quận/Huyện <span class="text-red-500">*</span>
                                    </label>
                                    <select id="edit_district" name="district" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500">
                                        <option value="">-- Chọn tỉnh trước --</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Địa chỉ cụ thể <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="edit_address_detail" name="address_detail" required maxlength="500"
                                    placeholder="VD: 123 Nguyễn Văn Linh, Phường Tân Phú..."
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500">
                                <div class="text-right text-xs text-gray-500 mt-1">
                                    <span id="edit_addressCount">0</span>/500 ký tự
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Hạn nộp hồ sơ <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="edit_deadline" name="deadline" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500">
                                </div>
                                <div></div> <!-- Giữ layout cân đối -->
                            </div>

                        </div>
                    </div>

                    <!-- Tab 2: Thông tin chi tiết -->
                    <div id="edit-tab2" class="edit-tab-content hidden">
                        <div class="space-y-5">

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Mô tả công việc <span class="text-red-500">*</span>
                                </label>
                                <textarea id="edit_description" name="description" rows="5" required maxlength="2000"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500"></textarea>
                                <div class="text-right text-xs text-gray-500 mt-1">
                                    <span id="edit_descCount">0</span>/2000 ký tự
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Trách nhiệm công việc <span class="text-red-500">*</span>
                                </label>
                                <textarea id="edit_responsibilities" name="responsibilities" rows="5" required maxlength="2000"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500"></textarea>
                                <div class="text-right text-xs text-gray-500 mt-1">
                                    <span id="edit_respCount">0</span>/2000 ký tự
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Yêu cầu ứng viên <span class="text-red-500">*</span>
                                </label>
                                <textarea id="edit_requirements" name="requirements" rows="5" required maxlength="2000"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500"></textarea>
                                <div class="text-right text-xs text-gray-500 mt-1">
                                    <span id="edit_reqCount">0</span>/2000 ký tự
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Quyền lợi <span class="text-red-500">*</span>
                                </label>
                                <textarea id="edit_benefits" name="benefits" rows="5" required maxlength="2000"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500"></textarea>
                                <div class="text-right text-xs text-gray-500 mt-1">
                                    <span id="edit_benefitsCount">0</span>/2000 ký tự
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Yêu cầu giới tính
                                    </label>
                                    <select id="edit_gender_requirement" name="gender_requirement"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500">
                                        <option value="any">Không yêu cầu</option>
                                        <option value="male">Nam</option>
                                        <option value="female">Nữ</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Môi trường làm việc
                                    </label>
                                    <select id="edit_working_environment" name="working_environment"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500">
                                        <option value="dynamic">Năng động, sáng tạo</option>
                                        <option value="professional">Chuyên nghiệp</option>
                                        <option value="friendly">Thân thiện</option>
                                        <option value="startup">Startup</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Phương thức liên hệ <span class="text-red-500">*</span>
                                </label>
                                <textarea id="edit_contact_method" name="contact_method" rows="3" required maxlength="500"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500"></textarea>
                                <div class="text-right text-xs text-gray-500 mt-1">
                                    <span id="edit_contactCount">0</span>/500 ký tự
                                </div>
                            </div>

                        </div>
                    </div>

                </form>
            </div>

            <!-- Footer Buttons -->
            <div class="border-t border-gray-200 p-6 bg-gray-50">
                <div class="flex gap-3">
                    <button type="button" id="btnEditPrev" class="hidden flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition-all">
                        ← Quay lại
                    </button>
                    <button type="button" id="btnEditNext" class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                        Tiếp tục →
                    </button>
                    <button type="button" id="btnUpdateJob" class="hidden flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                        ✓ Cập nhật tin đăng
                    </button>
                    <button type="button" id="btnCancelEdit" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition-all">
                        Hủy
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- script chỉnh sửa tin đăng -->
    <script>
        // ===== FIX EDIT JOB MODAL FUNCTIONALITY =====
        document.addEventListener('DOMContentLoaded', function() {

            const editJobModal = document.getElementById('editJobModal');
            const btnCloseEditModal = document.getElementById('btnCloseEditModal');
            const btnCancelEdit = document.getElementById('btnCancelEdit');
            const btnEditNext = document.getElementById('btnEditNext');
            const btnEditPrev = document.getElementById('btnEditPrev');
            const btnUpdateJob = document.getElementById('btnUpdateJob');
            const editJobForm = document.getElementById('editJobForm');

            let currentEditTab = 1;

            // Character counters for edit form
            const editCounterMap = {
                'edit_title': 'edit_titleCount',
                'edit_description': 'edit_descCount',
                'edit_responsibilities': 'edit_respCount',
                'edit_requirements': 'edit_reqCount',
                'edit_benefits': 'edit_benefitsCount',
                'edit_contact_method': 'edit_contactCount',
                'edit_address_detail': 'edit_addressCount'
            };

            for (const inputId in editCounterMap) {
                const input = document.getElementById(inputId);
                const counter = document.getElementById(editCounterMap[inputId]);
                if (input && counter) {
                    input.addEventListener('input', function() {
                        counter.textContent = this.value.length;
                    });
                }
            }

            // Handle edit button clicks
            document.querySelectorAll('.btn-edit-job').forEach(btn => {
                btn.addEventListener('click', function() {
                    const jobId = this.getAttribute('data-job-id');
                    openEditJobModal(jobId);
                });
            });

            // Open modal and fetch job data
            function openEditJobModal(jobId) {
                // Show loading state
                // Reset Hashtags
                editHashtags = [];
                editRenderHashtags();
                editJobModal.style.display = 'flex';
                editJobModal.classList.remove('hidden');

                // Fetch job data
                fetch(`/job/${jobId}/edit`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('HTTP error! status: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('✅ Job data loaded:', data); // Debug log

                        if (data.success) {
                            populateEditForm(data.job);
                            currentEditTab = 1;
                            switchEditTab(1);
                        } else {
                            alert('❌ Không thể tải thông tin tin đăng: ' + (data.error || 'Lỗi không xác định'));
                            closeEditModal();
                        }
                    })
                    .catch(error => {
                        console.error('❌ Error:', error);
                        alert('❌ Không thể kết nối đến server: ' + error.message);
                        closeEditModal();
                    });
            }

            // Populate form with job data
            function populateEditForm(job) {
                console.log('📝 Populating form with:', job); // Debug log

                // Basic info
                document.getElementById('edit_job_id').value = job.job_id;
                document.getElementById('edit_title').value = job.title || '';
                document.getElementById('edit_level').value = job.level || '';
                document.getElementById('edit_experience').value = job.experience || '';

                // Salary
                document.getElementById('edit_salary_type').value = job.salary_type || '';
                if (job.salary_type !== 'negotiable') {
                    document.getElementById('edit_salary_min').value = job.salary_min || '';
                    document.getElementById('edit_salary_max').value = job.salary_max || '';
                    document.getElementById('edit_salary_min').disabled = false;
                    document.getElementById('edit_salary_max').disabled = false;
                } else {
                    document.getElementById('edit_salary_min').value = '';
                    document.getElementById('edit_salary_max').value = '';
                    document.getElementById('edit_salary_min').disabled = true;
                    document.getElementById('edit_salary_max').disabled = true;
                }

                // Other basic fields
                document.getElementById('edit_working_type').value = job.working_type || '';
                document.getElementById('edit_recruitment_count').value = job.recruitment_count || '';
                document.getElementById('edit_deadline').value = job.deadline || '';
                document.getElementById('edit_address_detail').value = job.address_detail || '';

                // ⭐ QUAN TRỌNG: Khởi tạo location selects TRƯỚC KHI set value
                const provinceName = job.province || '';
                const districtName = job.district || '';

                console.log('🌍 Initializing locations with:', {
                    provinceName,
                    districtName
                });

                // ⭐ FIX: Gọi hàm init location và đợi hoàn thành
                if (typeof window.initEditModalLocations === 'function') {
                    window.initEditModalLocations(provinceName, districtName)
                        .then(success => {
                            if (success) {
                                console.log('✅ Location selects initialized in populateEditForm');
                            } else {
                                console.error('❌ Failed to initialize location selects');
                            }
                        })
                        .catch(error => {
                            console.error('❌ Error initializing locations:', error);
                        });
                } else {
                    console.error('❌ window.initEditModalLocations is not defined!');
                }

                // Detail fields (from job.detail)
                if (job.detail) {
                    document.getElementById('edit_description').value = job.detail.description || '';
                    document.getElementById('edit_responsibilities').value = job.detail.responsibilities || '';
                    document.getElementById('edit_requirements').value = job.detail.requirements || '';
                    document.getElementById('edit_benefits').value = job.detail.benefits || '';
                    document.getElementById('edit_gender_requirement').value = job.detail.gender_requirement || 'any';
                    document.getElementById('edit_working_environment').value = job.detail.working_environment || 'dynamic';
                    document.getElementById('edit_contact_method').value = job.detail.contact_method || '';
                }

                // ✅ Load hashtags vào edit form
                editHashtags = [];
                if (job.hashtags && Array.isArray(job.hashtags)) {
                    job.hashtags.forEach(hashtag => {
                        if (hashtag.tag_name) {
                            editHashtags.push(hashtag.tag_name.toLowerCase());
                        }
                    });

                    console.log('✅ Loaded hashtags:', editHashtags);
                    editRenderHashtags();
                }

                // Update character counters
                for (const inputId in editCounterMap) {
                    const input = document.getElementById(inputId);
                    const counter = document.getElementById(editCounterMap[inputId]);
                    if (input && counter) {
                        counter.textContent = input.value.length;
                    }
                }
            }

            function switchEditTab(tabNum) {
                currentEditTab = tabNum;

                // Update tab buttons
                document.querySelectorAll('.edit-tab-btn').forEach(btn => {
                    const btnTabNum = parseInt(btn.getAttribute('data-tab').replace('edit-tab', ''));
                    if (btnTabNum === tabNum) {
                        btn.classList.add('border-purple-600', 'text-purple-600');
                        btn.classList.remove('text-gray-600');
                        const circle = btn.querySelector('span span');
                        if (circle) {
                            circle.classList.remove('bg-gray-300');
                            circle.classList.add('bg-purple-600');
                        }
                    } else {
                        btn.classList.remove('border-purple-600', 'text-purple-600');
                        btn.classList.add('text-gray-600');
                        const circle = btn.querySelector('span span');
                        if (circle) {
                            circle.classList.remove('bg-purple-600');
                            circle.classList.add('bg-gray-300');
                        }
                    }
                });

                // Show/hide tab content
                document.querySelectorAll('.edit-tab-content').forEach((content, index) => {
                    content.classList.toggle('hidden', index + 1 !== tabNum);
                });

                // Update buttons
                if (tabNum === 1) {
                    btnEditPrev.classList.add('hidden');
                    btnEditNext.classList.remove('hidden');
                    btnUpdateJob.classList.add('hidden');
                } else {
                    btnEditPrev.classList.remove('hidden');
                    btnEditNext.classList.add('hidden');
                    btnUpdateJob.classList.remove('hidden');
                }
            }

            // Next button
            btnEditNext.addEventListener('click', function() {
                if (validateEditTab1()) {
                    switchEditTab(2);
                }
            });

            // Previous button
            btnEditPrev.addEventListener('click', function() {
                switchEditTab(1);
            });

            // Validate tab 1
            function validateEditTab1() {
                const requiredFields = [
                    'edit_title',
                    'edit_level',
                    'edit_experience',
                    'edit_salary_type',
                    'edit_working_type',
                    'edit_recruitment_count',
                    'edit_province',
                    'edit_district', // ✅ THÊM
                    'edit_address_detail', // ✅ THÊM
                    'edit_deadline'
                ];

                let isValid = true;

                for (const fieldId of requiredFields) {
                    const field = document.getElementById(fieldId);
                    if (!field.value) {
                        isValid = false;
                        field.style.borderColor = '#e53e3e';
                        setTimeout(() => {
                            field.style.borderColor = '#e2e8f0';
                        }, 2000);
                    }
                }

                // Validate salary
                const salaryType = document.getElementById('edit_salary_type').value;
                const salaryMin = document.getElementById('edit_salary_min').value;
                const salaryMax = document.getElementById('edit_salary_max').value;

                if (salaryType !== 'negotiable') {
                    if (!salaryMin || !salaryMax) {
                        isValid = false;
                        alert('⚠️ Vui lòng nhập khoảng lương!');
                    } else if (parseFloat(salaryMin) > parseFloat(salaryMax)) {
                        isValid = false;
                        alert('⚠️ Mức lương tối thiểu không thể lớn hơn mức lương tối đa!');
                    }
                }

                if (!isValid) {
                    alert('⚠️ Vui lòng điền đầy đủ thông tin bắt buộc!');
                }

                return isValid;
            }

            // Salary type change handler
            const editSalaryTypeSelect = document.getElementById('edit_salary_type');
            if (editSalaryTypeSelect) {
                editSalaryTypeSelect.addEventListener('change', function() {
                    const salaryMin = document.getElementById('edit_salary_min');
                    const salaryMax = document.getElementById('edit_salary_max');

                    if (this.value === 'negotiable') {
                        salaryMin.disabled = true;
                        salaryMax.disabled = true;
                        salaryMin.value = '';
                        salaryMax.value = '';
                    } else {
                        salaryMin.disabled = false;
                        salaryMax.disabled = false;
                    }
                });
            }

            // Update job
            btnUpdateJob.addEventListener('click', function() {
                if (!validateEditTab1()) {
                    switchEditTab(1);
                    return;
                }

                // Validate tab 2
                const tab2RequiredFields = [
                    'edit_description',
                    'edit_responsibilities',
                    'edit_requirements',
                    'edit_benefits',
                    'edit_contact_method'
                ];

                let isValid = true;
                for (const fieldId of tab2RequiredFields) {
                    const field = document.getElementById(fieldId);
                    if (!field.value) {
                        isValid = false;
                        field.style.borderColor = '#e53e3e';
                        setTimeout(() => {
                            field.style.borderColor = '#e2e8f0';
                        }, 2000);
                    }
                }

                if (!isValid) {
                    alert('⚠️ Vui lòng điền đầy đủ thông tin chi tiết!');
                    return;
                }

                // Submit form
                submitEditForm();
            });

            function submitEditForm() {
                const jobId = document.getElementById('edit_job_id').value;
                const formData = new FormData(editJobForm);

                // ✅ QUAN TRỌNG: Thêm hashtags vào formData
                const hashtagsJson = JSON.stringify(editHashtags);
                formData.set('hashtags', hashtagsJson);

                // Log form data để debug
                console.log('📤 Submitting form data:');
                console.log('Job ID:', jobId);
                console.log('Hashtags JSON:', hashtagsJson);
                console.log('Hashtags Array:', editHashtags);

                for (let [key, value] of formData.entries()) {
                    console.log(`${key}: ${value}`);
                }

                btnUpdateJob.disabled = true;
                btnUpdateJob.innerHTML = '⏳ Đang cập nhật...';

                fetch(`/job/${jobId}/update`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        console.log('📥 Response status:', response.status);
                        if (!response.ok) {
                            throw new Error('HTTP error! status: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('✅ Response data:', data);

                        if (data.success) {
                            alert('✅ Cập nhật tin đăng thành công!');
                            closeEditModal();
                            location.reload(); // Reload to show updated data
                        } else {
                            alert('❌ Lỗi: ' + (data.error || 'Không thể cập nhật tin đăng'));
                            resetUpdateButton();
                        }
                    })
                    .catch(error => {
                        console.error('❌ Error:', error);
                        alert('❌ Không thể kết nối đến server: ' + error.message);
                        resetUpdateButton();
                    });
            }

            function resetUpdateButton() {
                btnUpdateJob.disabled = false;
                btnUpdateJob.innerHTML = '✓ Cập nhật tin đăng';
            }

            // Close modal
            function closeEditModal() {
                editJobModal.style.display = 'none';
                editJobModal.classList.add('hidden');
                editJobForm.reset();
                currentEditTab = 1;
                switchEditTab(1);
                resetUpdateButton();
            }

            btnCloseEditModal.addEventListener('click', closeEditModal);
            btnCancelEdit.addEventListener('click', closeEditModal);

            // Close on outside click
            editJobModal.addEventListener('click', function(e) {
                if (e.target === editJobModal) {
                    closeEditModal();
                }
            });

        });
    </script>

    <script>
        (function() {
            const sidebar = document.getElementById('sidebar');
            const btnToggle = document.getElementById('btnToggleSidebar');
            const btnProfile = document.getElementById('btnProfile');
            const profileMenu = document.getElementById('profileMenu');

            btnToggle && btnToggle.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
            });

            btnProfile && btnProfile.addEventListener('click', function(e) {
                e.stopPropagation();
                profileMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', function(e) {
                if (!profileMenu.contains(e.target) && !btnProfile.contains(e.target)) {
                    profileMenu.classList.add('hidden');
                }
            });

            // THAY THẾ đoạn xử lý sidebar click cho company-info
            document.querySelectorAll('.sidebar-item').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');

                    // Hide all tabs
                    document.querySelectorAll('.tab-content').forEach(t => t.classList.add('hidden'));

                    // Show target tab
                    const target = document.getElementById(id);
                    if (target) target.classList.remove('hidden');

                    // Update sidebar styling
                    document.querySelectorAll('.sidebar-item').forEach(i => {
                        i.classList.remove('bg-gradient-to-r', 'from-purple-600', 'to-blue-600', 'text-white');
                        i.classList.add('text-gray-700');
                    });
                    this.classList.remove('text-gray-700');
                    this.classList.add('bg-gradient-to-r', 'from-purple-600', 'to-blue-600', 'text-white');

                    // 🆕 Khởi tạo location selects khi mở tab Company Info
                    if (id === 'company-info') {
                        console.log('🎯 Company Info tab opened, initializing locations...');

                        setTimeout(() => {
                            const companyInfoTab = document.getElementById('company-info');

                            if (!companyInfoTab) {
                                console.error('❌ Company Info tab not found');
                                return;
                            }

                            // ⭐ Lấy dữ liệu từ data attributes
                            const currentProvince = companyInfoTab.getAttribute('data-province') || '';
                            const currentDistrict = companyInfoTab.getAttribute('data-district') || '';

                            console.log('🔍 Current location from data attributes:', {
                                currentProvince,
                                currentDistrict
                            });

                            if (typeof window.companyLocationManager !== 'undefined') {
                                window.companyLocationManager.initialize(currentProvince, currentDistrict)
                                    .then(success => {
                                        if (success) {
                                            console.log('✅ Company locations initialized successfully');
                                        } else {
                                            console.error('❌ Failed to initialize company locations');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('❌ Error initializing company locations:', error);
                                    });
                            } else {
                                console.error('❌ companyLocationManager not found');
                            }
                        }, 300); // Đợi 300ms để tab render xong
                    }

                    // Close sidebar on mobile
                    if (window.innerWidth < 1024) {
                        const sidebar = document.getElementById('sidebar');
                        if (sidebar) sidebar.classList.add('-translate-x-full');
                    }
                });
            });
            const defaultBtn = document.querySelector('.sidebar-item[data-id="dashboard"]');
            if (defaultBtn) defaultBtn.click();

            function setupFileUpload(inputId, previewId, placeholderId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);
                const placeholder = document.getElementById(placeholderId);
                if (!input) return;
                input.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (!file || !file.type.startsWith('image/')) return;
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        if (preview && placeholder) {
                            const img = preview.querySelector('img') || document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'preview-image mx-auto rounded-lg';
                            if (!preview.querySelector('img')) {
                                preview.appendChild(img);
                            }
                            preview.classList.remove('hidden');
                            placeholder.classList.add('hidden');
                        }
                    };
                    reader.readAsDataURL(file);
                });
            }

            setupFileUpload('logoUpload', 'logoPreview', 'logoPlaceholder');
            setupFileUpload('coverImage', 'coverPreview', 'coverPlaceholder');

            const licenseInput = document.getElementById('businessLicense');
            if (licenseInput) {
                licenseInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const preview = document.getElementById('licensePreview');
                        const placeholder = document.getElementById('licensePlaceholder');
                        const fileName = document.getElementById('licenseFileName');
                        if (fileName) fileName.textContent = '✓ ' + file.name;
                        if (preview) preview.classList.remove('hidden');
                        if (placeholder) placeholder.classList.add('hidden');
                    }
                });
            }

            const galleryInput = document.getElementById('galleryImages');
            if (galleryInput) {
                galleryInput.addEventListener('change', function(e) {
                    const files = e.target.files;
                    const preview = document.getElementById('galleryPreview');
                    const placeholder = document.getElementById('galleryPlaceholder');
                    if (!files.length) return;
                    preview.innerHTML = '';
                    Array.from(files).forEach(file => {
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.className = 'w-full h-24 object-cover rounded-lg';
                                preview.appendChild(img);
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                });
            }

            const btnAddSocial = document.getElementById('btnAddSocial');
            const extraSocials = document.getElementById('extraSocials');
            if (btnAddSocial && extraSocials) {
                btnAddSocial.addEventListener('click', function() {
                    const newInput = document.createElement('div');
                    newInput.className = 'flex items-center gap-3 mt-3';
                    newInput.innerHTML = `
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                        <input type="url" placeholder="Eg. https://..." class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500" />
                        <button type="button" class="p-2 text-red-600 hover:bg-red-50 rounded-lg" onclick="this.parentElement.remove()">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    `;
                    extraSocials.appendChild(newInput);
                });
            }

            const btnSaveCompany = document.getElementById('btnSaveCompany');
            if (btnSaveCompany) {
                btnSaveCompany.addEventListener('click', function() {
                    const companyName = document.getElementById('companyName').value;
                    const companyNationality = document.getElementById('companyNationality').value;
                    const companyTagline = document.getElementById('companyTagline').value;
                    const companyIndustry = document.getElementById('companyIndustry').value;
                    const companySize = document.getElementById('companySize').value;

                    if (!companyName || !companyNationality || !companyTagline || !companyIndustry || !companySize) {
                        alert('Vui lòng điền đầy đủ các trường bắt buộc (*)');
                        return;
                    }

                    const successMsg = document.createElement('div');
                    successMsg.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-xl shadow-lg z-50 animate-fadeInUp';
                    successMsg.innerHTML = `
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-semibold">Đã lưu thông tin công ty thành công!</span>
                        </div>
                    `;
                    document.body.appendChild(successMsg);
                    setTimeout(() => successMsg.remove(), 3000);
                });
            }

            const btnSaveContact = document.getElementById('btnSaveContact');
            if (btnSaveContact) {
                btnSaveContact.addEventListener('click', function() {
                    const businessLicense = document.getElementById('businessLicense').files[0];
                    if (!businessLicense) {
                        alert('Vui lòng tải lên Giấy phép Đăng ký kinh doanh (*)');
                        return;
                    }

                    const successMsg = document.createElement('div');
                    successMsg.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-xl shadow-lg z-50 animate-fadeInUp';
                    successMsg.innerHTML = `
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-semibold">Đã lưu thông tin liên hệ thành công!</span>
                        </div>
                    `;
                    document.body.appendChild(successMsg);
                    setTimeout(() => successMsg.remove(), 3000);
                });
            }



            document.querySelectorAll('[contenteditable="true"]').forEach(el => {
                const placeholder = el.getAttribute('placeholder');
                if (placeholder) {
                    if (!el.textContent.trim()) {
                        el.classList.add('empty');
                        el.dataset.placeholder = placeholder;
                    }
                    el.addEventListener('focus', function() {
                        if (this.classList.contains('empty')) {
                            this.textContent = '';
                            this.classList.remove('empty');
                        }
                    });
                    el.addEventListener('blur', function() {
                        if (!this.textContent.trim()) {
                            this.classList.add('empty');
                        }
                    });
                }
            });
        })();
    </script>
    <!-- companyform, -->
    <script>
        document.getElementById('companyForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const btnSave = document.getElementById('btnSaveCompany');
            const originalText = btnSave.innerHTML;
            btnSave.disabled = true;
            btnSave.innerHTML = '<svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

            fetch('{{ route("company.update") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(async res => {
                    const data = await res.json();

                    if (!res.ok) {
                        throw new Error(data.message || 'HTTP error! status: ' + res.status);
                    }

                    return data;
                })
                .then(data => {
                    if (data.status === 'success') {
                        const successMsg = document.createElement('div');
                        successMsg.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-xl shadow-lg z-50 animate-fadeInUp';
                        successMsg.innerHTML = `
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-semibold">${data.message}</span>
                </div>
            `;
                        document.body.appendChild(successMsg);

                        // ✅ Cập nhật preview logo (đã có logo/ trong path)
                        if (data.company.logo) {
                            const logoPreview = document.getElementById('logoPreview');
                            logoPreview.src = '/assets/img/' + data.company.logo + '?t=' + new Date().getTime();
                            logoPreview.classList.remove('hidden');
                        }

                        // ✅ Cập nhật preview banner (đã có banner/ trong path)
                        if (data.company.banner) {
                            const bannerPreview = document.getElementById('bannerPreview');
                            bannerPreview.src = '/assets/img/' + data.company.banner + '?t=' + new Date().getTime();
                            bannerPreview.classList.remove('hidden');
                        }

                        setTimeout(() => {
                            successMsg.remove();
                            location.reload();
                        }, 1500);
                    } else {
                        throw new Error(data.message || 'Có lỗi xảy ra');
                    }
                })
                .catch(err => {
                    console.error('Error:', err);

                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-xl shadow-lg z-50';
                    errorMsg.innerHTML = `
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span class="font-semibold">${err.message}</span>
            </div>
        `;
                    document.body.appendChild(errorMsg);

                    setTimeout(() => errorMsg.remove(), 3000);
                })
                .finally(() => {
                    btnSave.disabled = false;
                    btnSave.innerHTML = originalText;
                });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Email field handlers
            const emailInput = document.getElementById('emailInput');
            const btnEditEmail = document.getElementById('btnEditEmail');
            const contactForm = document.getElementById('contactForm');
            let isEditingEmail = false;

            btnEditEmail.addEventListener('click', function() {
                if (!isEditingEmail) {
                    // Chuyển sang chế độ chỉnh sửa
                    isEditingEmail = true;
                    emailInput.removeAttribute('readonly');
                    emailInput.classList.remove('bg-gray-50', 'cursor-not-allowed');
                    emailInput.classList.add('bg-white', 'cursor-text');
                    emailInput.focus();

                    // Đổi nút thành "Lưu thay đổi"
                    this.querySelector('.btn-text').textContent = 'LƯU THAY ĐỔI';
                    this.querySelector('svg').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>';
                    this.classList.remove('text-blue-600', 'hover:text-blue-700');
                    this.classList.add('text-green-600', 'hover:text-green-700');
                } else {
                    // Submit form qua AJAX
                    submitFormAjax('email_cty', emailInput.value, btnEditEmail, emailInput, () => {
                        isEditingEmail = false;
                    });
                }
            });

            // Phone field handlers
            const phoneInput = document.getElementById('phoneInput');
            const btnEditPhone = document.getElementById('btnEditPhone');
            let isEditingPhone = false;

            btnEditPhone.addEventListener('click', function() {
                if (!isEditingPhone) {
                    // Chuyển sang chế độ chỉnh sửa
                    isEditingPhone = true;
                    phoneInput.removeAttribute('readonly');
                    phoneInput.classList.remove('bg-gray-50', 'cursor-not-allowed');
                    phoneInput.classList.add('bg-white', 'cursor-text');
                    phoneInput.focus();

                    // Đổi nút thành "Lưu thay đổi"
                    this.querySelector('.btn-text').textContent = 'LƯU THAY ĐỔI';
                    this.querySelector('svg').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>';
                    this.classList.remove('text-blue-600', 'hover:text-blue-700');
                    this.classList.add('text-green-600', 'hover:text-green-700');
                } else {
                    // Submit form qua AJAX
                    submitFormAjax('sdt_cty', phoneInput.value, btnEditPhone, phoneInput, () => {
                        isEditingPhone = false;
                    });
                }
            });
            /* ==========================
                       ĐỊA CHỈ CỤ THỂ (NEW)
                    ========================== */
            const addressDetailInput = document.getElementById('addressDetailInput');
            const btnEditAddressDetail = document.getElementById('btnEditAddressDetail');
            let isEditingAddress = false;

            btnEditAddressDetail.addEventListener('click', function() {
                if (!isEditingAddress) {
                    isEditingAddress = true;
                    addressDetailInput.removeAttribute('readonly');
                    addressDetailInput.classList.remove('bg-gray-50', 'cursor-not-allowed');
                    addressDetailInput.classList.add('bg-white', 'cursor-text');
                    addressDetailInput.focus();

                    this.querySelector('.btn-text').textContent = 'LƯU THAY ĐỔI';
                    this.querySelector('svg').innerHTML =
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>';
                    this.classList.replace('text-blue-600', 'text-green-600');
                    this.classList.replace('hover:text-blue-700', 'hover:text-green-700');
                } else {
                    submitFormAjax('dia_chi_cu_the', addressDetailInput.value, btnEditAddressDetail, addressDetailInput, () => {
                        isEditingAddress = false;
                    });
                }
            });
            // ✅ Recruiters table edit handlers
            const btnEditRecruiters = document.getElementById('btnEditRecruiters');
            const actionColumns = document.querySelectorAll('.action-column');
            const addRecruiterSection = document.querySelector('.add-recruiter-section');
            let isEditingRecruiters = false;

            if (btnEditRecruiters) {
                btnEditRecruiters.addEventListener('click', function() {
                    isEditingRecruiters = !isEditingRecruiters;

                    if (isEditingRecruiters) {
                        // Hiện cột thao tác và nút thêm mới
                        actionColumns.forEach(col => col.classList.remove('hidden'));
                        addRecruiterSection.classList.remove('hidden');
                        this.querySelector('span').textContent = 'HOÀN TẤT';
                        this.classList.remove('text-blue-600', 'hover:text-blue-700');
                        this.classList.add('text-green-600', 'hover:text-green-700');
                    } else {
                        // Ẩn cột thao tác và nút thêm mới
                        actionColumns.forEach(col => col.classList.add('hidden'));
                        addRecruiterSection.classList.add('hidden');
                        this.querySelector('span').textContent = 'CHỈNH SỬA';
                        this.classList.remove('text-green-600', 'hover:text-green-700');
                        this.classList.add('text-blue-600', 'hover:text-blue-700');
                    }
                });
            }

            // Xử lý nút thêm mới
            const btnAddRecruiter = document.getElementById('btnAddRecruiter');
            if (btnAddRecruiter) {
                btnAddRecruiter.addEventListener('click', function() {
                    // Xử lý thêm recruiter
                });
            }

            // ✅ Function submit form qua AJAX
            function submitFormAjax(fieldName, fieldValue, button, input, resetCallback) {
                const formData = new FormData(contactForm);

                // Disable button để tránh submit nhiều lần
                button.disabled = true;
                button.querySelector('.btn-text').textContent = 'ĐANG LƯU...';

                fetch(contactForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Hiển thị thông báo thành công
                            showNotification('Cập nhật thành công!', 'success');

                            // Reset button về trạng thái ban đầu
                            resetButton(button, input);
                            resetCallback();
                        } else {
                            // Hiển thị thông báo lỗi
                            showNotification(data.message || 'Có lỗi xảy ra!', 'error');
                            button.disabled = false;
                            button.querySelector('.btn-text').textContent = 'LƯU THAY ĐỔI';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Có lỗi xảy ra khi cập nhật!', 'error');
                        button.disabled = false;
                        button.querySelector('.btn-text').textContent = 'LƯU THAY ĐỔI';
                    });
            }

            // ✅ Function reset button về trạng thái ban đầu
            function resetButton(button, input) {
                button.disabled = false;
                button.querySelector('.btn-text').textContent = 'CHỈNH SỬA';
                button.querySelector('svg').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>';
                button.classList.remove('text-green-600', 'hover:text-green-700');
                button.classList.add('text-blue-600', 'hover:text-blue-700');

                // Set input về readonly
                input.setAttribute('readonly', true);
                input.classList.remove('bg-white', 'cursor-text');
                input.classList.add('bg-gray-50', 'cursor-not-allowed');
            }

            // ✅ Function hiển thị thông báo
            function showNotification(message, type = 'success') {
                // Tạo notification element
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
                notification.innerHTML = `
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${type === 'success' 
                        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>'
                        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'
                    }
                </svg>
                <span class="font-medium">${message}</span>
            </div>
        `;

                document.body.appendChild(notification);

                // Tự động ẩn sau 3 giây
                setTimeout(() => {
                    notification.style.opacity = '0';
                    notification.style.transform = 'translateX(100%)';
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }
        });
    </script>
    <!-- modal thêm nhà tuyển dụng -->
    <script>
        const modal = document.getElementById("addRecruiterModal");
        document.getElementById("btnAddRecruiter").addEventListener("click", () => {
            modal.classList.remove("hidden");
        });
        document.getElementById("btnCloseModal").addEventListener("click", () => {
            modal.classList.add("hidden");
        });
    </script>
    <!-- MODAL CHỈNH SỬA NHÀ TUYEN DUNG -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.btn-edit-recruiter');
            const modal = document.getElementById('editRecruiterModal');
            const form = document.getElementById('editRecruiterForm');
            const btnClose = document.getElementById('btnCloseEditModal');

            // Open modal và fill data
            editButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const row = btn.closest('tr');
                    const ma_nv = row.dataset.id;
                    const ten_nv = row.children[1].innerText.trim();
                    const chucvu = row.children[2].innerText.trim();
                    const email_nv = row.children[3].innerText.trim();
                    const sdt_nv = row.children[4].innerText.trim();

                    // Fill modal
                    document.getElementById('edit_ma_nv').value = ma_nv;
                    document.getElementById('edit_ten_nv').value = ten_nv;
                    document.getElementById('edit_chucvu').value = chucvu;
                    document.getElementById('edit_email_nv').value = email_nv;
                    document.getElementById('edit_sdt_nv').value = sdt_nv;

                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });
            });

            // Close modal
            btnClose.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });

            // Submit form via AJAX
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const ma_nv = document.getElementById('edit_ma_nv').value;
                const ten_nv = document.getElementById('edit_ten_nv').value;
                const chucvu = document.getElementById('edit_chucvu').value;
                const email_nv = document.getElementById('edit_email_nv').value;
                const sdt_nv = document.getElementById('edit_sdt_nv').value;

                fetch(`/recruiter/update/${ma_nv}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            ten_nv,
                            chucvu,
                            email_nv,
                            sdt_nv
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            alert('Cập nhật thành công!');
                            location.reload(); // reload để cập nhật bảng
                        } else {
                            alert('Có lỗi xảy ra: ' + data.message);
                        }
                    })
                    .catch(err => console.error(err));
            });
        });
    </script>
    <!-- xóa nha tuyen dung -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete-recruiter');

            deleteButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const row = btn.closest('tr');
                    const ma_nv = row.dataset.id;

                    if (confirm('Bạn có chắc muốn xóa nhà tuyển dụng này không?')) {
                        fetch(`/recruiter/delete/${ma_nv}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    // Xóa row khỏi table
                                    row.remove();
                                    alert(data.message);
                                } else {
                                    alert('Có lỗi xảy ra: ' + data.message);
                                }
                            })
                            .catch(err => console.error(err));
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const modal = document.getElementById("companyInfoGuideModal");
            if (!modal) return;

            const btnSkip = document.getElementById("skipUpdateCompany");
            const btnGo = document.getElementById("goUpdateCompany");

            // ✅ Để sau → chỉ đóng modal
            btnSkip.addEventListener("click", () => {
                modal.remove();
            });

            // ✅ Tiếp tục → chọn tab “Thông tin công ty”
            btnGo.addEventListener("click", () => {
                modal.remove();

                const targetTab = document.querySelector('[data-id="company-info"]');
                if (targetTab) targetTab.click(); // 👉 tự động mở tab
            });
        });
    </script>
    <!-- Script preview Logo & Banner -->
    <script>
        document.getElementById('logoUpload').addEventListener('change', function(event) {
            const preview = document.getElementById('logoPreview');
            const file = event.target.files[0];
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            }
        });

        document.getElementById('bannerUpload').addEventListener('change', function(event) {
            const preview = document.getElementById('bannerPreview');
            const file = event.target.files[0];
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            }
        });
    </script>
    <script>
        // Edit Job
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-edit-job').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const jobId = this.getAttribute('data-job-id');
                    editJob(jobId);
                });
            });

            // Delete Job
            document.querySelectorAll('.btn-delete-job').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const jobId = this.getAttribute('data-job-id');
                    const jobTitle = this.getAttribute('data-job-title');
                    deleteJob(jobId, jobTitle);
                });
            });
        });



        function deleteJob(jobId, jobTitle) {
            if (confirm('Bạn có chắc chắn muốn xóa tin tuyển dụng "' + jobTitle + '" không?')) {
                fetch('/job/' + jobId + '/delete', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('✅ Xóa tin tuyển dụng thành công!');
                            location.reload();
                        } else {
                            alert('❌ Có lỗi xảy ra: ' + (data.error || 'Không thể xóa tin'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('❌ Không thể kết nối đến server');
                    });
            }
        }

        // Logic Hashtag cho Modal Chỉnh Sửa (editJobModal)
        // ===================================================================
        let editHashtags = [];
        const editHashtagColors = ['color-1', 'color-2', 'color-3', 'color-4', 'color-5', 'color-6', 'color-7', 'color-8'];
        let editSearchTimeout = null;

        const editHashtagInput = document.getElementById('edit_hashtagInput');
        const editSuggestionBox = document.getElementById('edit_hashtagSuggestions');
        const editHashtagsContainer = document.getElementById('edit_hashtagsContainer');
        const editHashtagsHiddenInput = document.getElementById('edit_hashtagsHiddenInput');
        const btnAddEditHashtag = document.getElementById('btnAddEditHashtag');

        // 1. Search hashtags from database (Sử dụng AJAX)
        async function editSearchHashtags(query) {
            if (!query || query.length < 1) {
                editHideSuggestions();
                return;
            }

            // Clear previous timeout
            clearTimeout(editSearchTimeout);

            editSearchTimeout = setTimeout(async () => {
                try {
                    // Giả định có một API endpoint để tìm kiếm hashtag
                    const response = await fetch('/api/hashtags/search?query=' + encodeURIComponent(query));
                    if (!response.ok) throw new Error('Network response was not ok');
                    const data = await response.json();
                    editRenderSuggestions(data.suggestions || []);
                } catch (error) {
                    console.error('Error searching hashtags:', error);
                    editHideSuggestions();
                }
            }, 300); // 300ms delay for search
        }

        // 2. Render Suggestions
        function editRenderSuggestions(suggestions) {
            editSuggestionBox.innerHTML = '';
            if (suggestions.length === 0) {
                editHideSuggestions();
                return;
            }

            suggestions.forEach(hashtag => {
                if (!editHashtags.includes(hashtag.toLowerCase())) {
                    const item = document.createElement('div');
                    item.className = 'suggestion-item';
                    item.textContent = '#' + hashtag;
                    item.dataset.hashtag = hashtag;
                    item.addEventListener('click', () => editHandleSuggestionClick(hashtag));
                    editSuggestionBox.appendChild(item);
                }
            });

            if (editSuggestionBox.children.length > 0) {
                editSuggestionBox.style.display = 'block';
            } else {
                editHideSuggestions();
            }
        }

        // 3. Handle suggestion click
        function editHandleSuggestionClick(hashtag) {
            editHashtagInput.value = hashtag;
            editAddHashtag();
        }

        // 4. Hide suggestions
        function editHideSuggestions() {
            editSuggestionBox.innerHTML = '';
            editSuggestionBox.style.display = 'none';
        }

        // 5. Update hidden input
        function editUpdateHashtagsInput() {
            editHashtagsHiddenInput.value = editHashtags.join(',');
        }

        // 6. Render selected hashtags
        function editRenderHashtags() {
            if (editHashtags.length === 0) {
                editHashtagsContainer.innerHTML = '<span class="hashtags-empty">Chưa có hashtag nào. Nhấn Enter hoặc nút Thêm để thêm hashtag</span>';
                editUpdateHashtagsInput();
                return;
            }

            editHashtagsContainer.innerHTML = '';
            editHashtags.forEach((hashtag, index) => {
                const tag = document.createElement('span');
                const colorClass = editHashtagColors[index % editHashtagColors.length];
                tag.className = `hashtag-tag ${colorClass}`;
                tag.innerHTML = `
                #${hashtag}
                <button type="button" class="remove-hashtag" data-hashtag="${hashtag}">x</button>
            `;
                editHashtagsContainer.appendChild(tag);
            });
            editUpdateHashtagsInput();
        }

        // 7. Add hashtag
        function editAddHashtag() {
            const value = editHashtagInput.value.trim();
            if (!value) return;

            // Remove # if user added it
            const cleanValue = value.replace(/^#/, '');

            // Check if hashtag already exists
            if (editHashtags.includes(cleanValue.toLowerCase())) {
                alert('⚠️ Hashtag này đã tồn tại!');
                editHashtagInput.value = '';
                editHideSuggestions();
                return;
            }

            // Add to array
            editHashtags.push(cleanValue.toLowerCase());

            // Update UI
            editRenderHashtags();

            // Clear input
            editHashtagInput.value = '';

            // Hide suggestions
            editHideSuggestions();
        }

        // 8. Remove hashtag
        editHashtagsContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-hashtag')) {
                const hashtagToRemove = e.target.dataset.hashtag;
                editHashtags = editHashtags.filter(h => h !== hashtagToRemove.toLowerCase());
                editRenderHashtags();
            }
        });


        // ========== EDIT HASHTAG EVENT LISTENERS ==========
        if (editHashtagInput) {
            // Autocomplete search
            editHashtagInput.addEventListener('input', (e) => editSearchHashtags(e.target.value));

            // Add on Enter key
            editHashtagInput.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    editAddHashtag();
                }
            });

            // Add on button click
            btnAddEditHashtag.addEventListener('click', editAddHashtag);

            // Handle suggestion click (outside listener)
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.hashtag-input-wrapper')) {
                    editHideSuggestions();
                }
            });
        }
    </script>
    <!-- PART 2: THÊM ĐOẠN NÀY VÀO CUỐI FILE, TRƯỚC </body> -->
    <!-- ========== VIETNAM LOCATION API FOR EDIT MODAL ========== -->
    <script>
        class VietnamLocationAPI {
            constructor() {
                this.baseURL = 'https://provinces.open-api.vn/api';
                this.provincesCache = null; // Cache để giảm API calls
            }

            async getProvinces() {
                // Sử dụng cache nếu đã load trước đó
                if (this.provincesCache) {
                    console.log('✅ Using cached provinces data');
                    return this.provincesCache;
                }

                try {
                    console.log('🔄 Fetching provinces from API...');
                    const response = await fetch(`${this.baseURL}/p/`);

                    if (!response.ok) {
                        throw new Error('API response not OK: ' + response.status);
                    }

                    const data = await response.json();
                    this.provincesCache = data; // Lưu vào cache
                    console.log('✅ Loaded provinces:', data.length);
                    return data;
                } catch (error) {
                    console.error('❌ Error loading provinces:', error);
                    console.log('⚠️ Using fallback provinces');
                    return this.getFallbackProvinces();
                }
            }

            async getDistricts(provinceCode) {
                try {
                    console.log('🔄 Fetching districts for province code:', provinceCode);
                    const response = await fetch(`${this.baseURL}/p/${provinceCode}?depth=2`);

                    if (!response.ok) {
                        throw new Error('API response not OK: ' + response.status);
                    }

                    const data = await response.json();
                    const districts = data.districts || [];
                    console.log('✅ Loaded districts:', districts.length);
                    return districts;
                } catch (error) {
                    console.error('❌ Error loading districts:', error);
                    return [];
                }
            }

            getFallbackProvinces() {
                return [{
                        code: 1,
                        name: "Hà Nội"
                    },
                    {
                        code: 79,
                        name: "TP. Hồ Chí Minh"
                    },
                    {
                        code: 48,
                        name: "Đà Nẵng"
                    },
                    {
                        code: 31,
                        name: "Hải Phòng"
                    },
                    {
                        code: 92,
                        name: "Cần Thơ"
                    },
                    {
                        code: 89,
                        name: "An Giang"
                    },
                    {
                        code: 77,
                        name: "Bà Rịa - Vũng Tàu"
                    },
                    {
                        code: 24,
                        name: "Bắc Giang"
                    },
                    {
                        code: 6,
                        name: "Bắc Kạn"
                    }
                ];
            }
        }

        // Khởi tạo API instance (Global variable)
        const editLocationAPI = new VietnamLocationAPI();

        console.log('✅ VietnamLocationAPI class loaded');
    </script>
    <!-- PART 3: THÊM TIẾP SAU PART 2 -->
    <script>
        // ============================================
        // MODULE 2: LOCATION SELECT MANAGER
        // ============================================
        class EditLocationManager {
            constructor() {
                this.provinceSelect = null;
                this.districtSelect = null;
                this.isInitialized = false;
            }

            // Lấy DOM elements
            getElements() {
                this.provinceSelect = document.getElementById('edit_province');
                this.districtSelect = document.getElementById('edit_district');

                if (!this.provinceSelect || !this.districtSelect) {
                    console.error('❌ Cannot find province/district select elements');
                    return false;
                }

                console.log('✅ Found province and district select elements');
                return true;
            }

            // Khởi tạo với dữ liệu hiện tại
            async initialize(currentProvince = '', currentDistrict = '') {
                console.log('🚀 Initializing EditLocationManager...', {
                    currentProvince,
                    currentDistrict
                });

                // Lấy DOM elements
                if (!this.getElements()) {
                    return false;
                }

                // Load provinces
                await this.loadProvinces(currentProvince);

                // Load districts nếu có province
                if (currentProvince) {
                    const provinceCode = this.getProvinceCode(currentProvince);
                    if (provinceCode) {
                        await this.loadDistricts(provinceCode, currentDistrict);
                    }
                }

                // Setup event listener
                this.setupEventListeners();

                this.isInitialized = true;
                console.log('✅ EditLocationManager initialized successfully');
                return true;
            }

            // Load danh sách provinces
            async loadProvinces(selectedProvince = '') {
                console.log('📋 Loading provinces...');

                // Hiển thị loading
                this.provinceSelect.innerHTML = '<option value="">⏳ Đang tải...</option>';
                this.provinceSelect.disabled = true;

                // Fetch data
                const provinces = await editLocationAPI.getProvinces();

                // Sort theo tên
                provinces.sort((a, b) => a.name.localeCompare(b.name, 'vi'));

                // Clear và populate
                this.provinceSelect.innerHTML = '<option value="">-- Chọn tỉnh/thành phố --</option>';

                provinces.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.name;
                    option.textContent = province.name;
                    option.dataset.code = province.code;

                    // Auto-select nếu match
                    if (this.matchProvinceName(province.name, selectedProvince)) {
                        option.selected = true;
                        console.log('✅ Auto-selected province:', province.name);
                    }

                    this.provinceSelect.appendChild(option);
                });

                // Enable select
                this.provinceSelect.disabled = false;
                console.log('✅ Provinces loaded:', provinces.length);
            }

            // Load danh sách districts
            async loadDistricts(provinceCode, selectedDistrict = '') {
                console.log('📋 Loading districts for province code:', provinceCode);

                // Hiển thị loading
                this.districtSelect.innerHTML = '<option value="">⏳ Đang tải...</option>';
                this.districtSelect.disabled = true;

                // Fetch data
                const districts = await editLocationAPI.getDistricts(provinceCode);

                // Sort theo tên
                districts.sort((a, b) => a.name.localeCompare(b.name, 'vi'));

                // Clear và populate
                this.districtSelect.innerHTML = '<option value="">-- Chọn quận/huyện --</option>';

                districts.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.name;
                    option.textContent = district.name;

                    // Auto-select nếu match
                    if (this.matchDistrictName(district.name, selectedDistrict)) {
                        option.selected = true;
                        console.log('✅ Auto-selected district:', district.name);
                    }

                    this.districtSelect.appendChild(option);
                });

                // Enable select
                this.districtSelect.disabled = false;
                console.log('✅ Districts loaded:', districts.length);
            }

            // Setup event listeners
            setupEventListeners() {
                // Remove old listener bằng cách clone node
                const newProvinceSelect = this.provinceSelect.cloneNode(true);
                this.provinceSelect.parentNode.replaceChild(newProvinceSelect, this.provinceSelect);
                this.provinceSelect = newProvinceSelect;

                // Add new listener
                this.provinceSelect.addEventListener('change', async (e) => {
                    const selectedOption = e.target.options[e.target.selectedIndex];
                    const provinceCode = selectedOption?.dataset?.code;

                    console.log('🔄 Province changed:', {
                        name: selectedOption?.value,
                        code: provinceCode
                    });

                    if (provinceCode) {
                        await this.loadDistricts(provinceCode);
                    } else {
                        this.districtSelect.innerHTML = '<option value="">-- Chọn quận/huyện --</option>';
                    }
                });

                console.log('✅ Event listeners setup complete');
            }

            // Helper: Lấy province code từ tên
            getProvinceCode(provinceName) {
                const option = Array.from(this.provinceSelect.options).find(opt =>
                    this.matchProvinceName(opt.value, provinceName)
                );
                return option?.dataset?.code || null;
            }

            // Helper: So sánh tên province (case-insensitive, ignore accents)
            matchProvinceName(name1, name2) {
                if (!name1 || !name2) return false;
                const normalize = (str) => str.toLowerCase().trim()
                    .replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, 'a')
                    .replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, 'e')
                    .replace(/ì|í|ị|ỉ|ĩ/g, 'i')
                    .replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, 'o')
                    .replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, 'u')
                    .replace(/ỳ|ý|ỵ|ỷ|ỹ/g, 'y')
                    .replace(/đ/g, 'd');

                return normalize(name1) === normalize(name2);
            }

            // Helper: So sánh tên district
            matchDistrictName(name1, name2) {
                return this.matchProvinceName(name1, name2); // Dùng chung logic
            }

            // Reset về trạng thái ban đầu
            reset() {
                if (this.provinceSelect) {
                    this.provinceSelect.innerHTML = '<option value="">-- Chọn tỉnh/thành phố --</option>';
                }
                if (this.districtSelect) {
                    this.districtSelect.innerHTML = '<option value="">-- Chọn quận/huyện --</option>';
                }
                this.isInitialized = false;
                console.log('🔄 EditLocationManager reset');
            }
        }

        // Khởi tạo manager instance (Global variable)
        window.editLocationManager = new EditLocationManager();


        console.log('✅ EditLocationManager class loaded');
    </script>
    <!-- THÊM SAU window.editLocationManager -->
    <script>
        // ============================================
        // COMPANY INFO LOCATION MANAGER
        // ============================================
        class CompanyLocationManager {
            constructor() {
                this.provinceSelect = null;
                this.districtSelect = null;
                this.isInitialized = false;
            }

            getElements() {
                this.provinceSelect = document.getElementById('company_province');
                this.districtSelect = document.getElementById('company_district');

                if (!this.provinceSelect || !this.districtSelect) {
                    console.error('❌ Cannot find company province/district select elements');
                    return false;
                }

                console.log('✅ Found company province and district select elements');
                return true;
            }

            async initialize(currentProvince = '', currentDistrict = '') {
                console.log('🚀 Initializing CompanyLocationManager...', {
                    currentProvince,
                    currentDistrict
                });

                if (!this.getElements()) {
                    return false;
                }

                // Load provinces
                await this.loadProvinces(currentProvince);

                // Load districts nếu có province
                if (currentProvince) {
                    const provinceCode = this.getProvinceCode(currentProvince);
                    if (provinceCode) {
                        await this.loadDistricts(provinceCode, currentDistrict);
                    }
                }

                // Setup event listener
                this.setupEventListeners();

                this.isInitialized = true;
                console.log('✅ CompanyLocationManager initialized successfully');
                return true;
            }

            async loadProvinces(selectedProvince = '') {
                console.log('📋 Loading company provinces...');

                this.provinceSelect.innerHTML = '<option value="">⏳ Đang tải...</option>';
                this.provinceSelect.disabled = true;

                const provinces = await editLocationAPI.getProvinces();
                provinces.sort((a, b) => a.name.localeCompare(b.name, 'vi'));

                this.provinceSelect.innerHTML = '<option value="">-- Chọn tỉnh/thành phố --</option>';

                provinces.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.name;
                    option.textContent = province.name;
                    option.dataset.code = province.code;

                    if (this.matchName(province.name, selectedProvince)) {
                        option.selected = true;
                        console.log('✅ Auto-selected company province:', province.name);
                    }

                    this.provinceSelect.appendChild(option);
                });

                this.provinceSelect.disabled = false;
                console.log('✅ Company provinces loaded:', provinces.length);
            }

            async loadDistricts(provinceCode, selectedDistrict = '') {
                console.log('📋 Loading company districts for province code:', provinceCode);

                this.districtSelect.innerHTML = '<option value="">⏳ Đang tải...</option>';
                this.districtSelect.disabled = true;

                const districts = await editLocationAPI.getDistricts(provinceCode);
                districts.sort((a, b) => a.name.localeCompare(b.name, 'vi'));

                this.districtSelect.innerHTML = '<option value="">-- Chọn quận/huyện --</option>';

                districts.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.name;
                    option.textContent = district.name;

                    if (this.matchName(district.name, selectedDistrict)) {
                        option.selected = true;
                        console.log('✅ Auto-selected company district:', district.name);
                    }

                    this.districtSelect.appendChild(option);
                });

                this.districtSelect.disabled = false;
                console.log('✅ Company districts loaded:', districts.length);
            }

            setupEventListeners() {
                const newProvinceSelect = this.provinceSelect.cloneNode(true);
                this.provinceSelect.parentNode.replaceChild(newProvinceSelect, this.provinceSelect);
                this.provinceSelect = newProvinceSelect;

                this.provinceSelect.addEventListener('change', async (e) => {
                    const selectedOption = e.target.options[e.target.selectedIndex];
                    const provinceCode = selectedOption?.dataset?.code;

                    console.log('🔄 Company province changed:', {
                        name: selectedOption?.value,
                        code: provinceCode
                    });

                    if (provinceCode) {
                        await this.loadDistricts(provinceCode);
                    } else {
                        this.districtSelect.innerHTML = '<option value="">-- Chọn quận/huyện --</option>';
                    }
                });

                console.log('✅ Company event listeners setup complete');
            }

            getProvinceCode(provinceName) {
                const option = Array.from(this.provinceSelect.options).find(opt =>
                    this.matchName(opt.value, provinceName)
                );
                return option?.dataset?.code || null;
            }

            matchName(name1, name2) {
                if (!name1 || !name2) return false;
                const normalize = (str) => str.toLowerCase().trim()
                    .replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, 'a')
                    .replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, 'e')
                    .replace(/ì|í|ị|ỉ|ĩ/g, 'i')
                    .replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, 'o')
                    .replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, 'u')
                    .replace(/ỳ|ý|ỵ|ỷ|ỹ/g, 'y')
                    .replace(/đ/g, 'd');

                return normalize(name1) === normalize(name2);
            }
        }

        // Khởi tạo manager instance
        window.companyLocationManager = new CompanyLocationManager();

        console.log('✅ CompanyLocationManager class loaded');
    </script>
    <!-- THÊM SAU window.companyLocationManager = new CompanyLocationManager(); -->
    <script>
        // ============================================
        // AUTO INIT COMPANY LOCATION ON PAGE LOAD
        // ============================================
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🔄 Checking if Company Info tab is visible on page load...');

            const companyInfoTab = document.getElementById('company-info');

            if (!companyInfoTab) {
                console.log('ℹ️ Company Info tab not found in DOM');
                return;
            }

            // Kiểm tra xem tab có đang hiển thị không
            const isVisible = !companyInfoTab.classList.contains('hidden');

            if (isVisible) {
                console.log('🎯 Company Info tab is visible, auto-initializing locations...');

                // Lấy dữ liệu từ data attributes
                const currentProvince = companyInfoTab.getAttribute('data-province') || '';
                const currentDistrict = companyInfoTab.getAttribute('data-district') || '';

                console.log('📍 Auto-init with location data:', {
                    currentProvince,
                    currentDistrict
                });

                // Đợi một chút để đảm bảo các class đã load xong
                setTimeout(() => {
                    if (typeof window.companyLocationManager !== 'undefined') {
                        window.companyLocationManager.initialize(currentProvince, currentDistrict)
                            .then(success => {
                                if (success) {
                                    console.log('✅ Company locations auto-initialized on page load');
                                } else {
                                    console.error('❌ Failed to auto-initialize company locations');
                                }
                            })
                            .catch(error => {
                                console.error('❌ Error auto-initializing company locations:', error);
                            });
                    } else {
                        console.error('❌ companyLocationManager not defined yet');
                    }
                }, 500);
            } else {
                console.log('ℹ️ Company Info tab is hidden, will init when user opens it');
            }
        });
    </script>
    <!-- PART 4: THÊM TIẾP SAU PART 3 -->
    <script>
        // ============================================
        // MODULE 3: PUBLIC INTERFACE
        // ============================================

        /**
         * Hàm này được gọi từ populateEditForm() 
         * để khởi tạo dropdowns với dữ liệu hiện tại
         * 
         * @param {string} provinceName - Tên tỉnh hiện tại (VD: "Hà Nội")
         * @param {string} districtName - Tên huyện hiện tại (VD: "Ba Đình")
         * @returns {Promise<boolean>} - true nếu thành công, false nếu thất bại
         */
        window.initEditModalLocations = async function(provinceName = '', districtName = '') {
            console.log('🎯 initEditModalLocations called with:', {
                provinceName,
                districtName
            });

            try {
                // Đợi một chút để đảm bảo modal đã render xong
                await new Promise(resolve => setTimeout(resolve, 300));

                // Initialize manager
                const success = await window.editLocationManager.initialize(
                    provinceName,
                    districtName
                );

                if (!success) {
                    console.error('❌ Failed to initialize location selects');
                    return false;
                }

                console.log('✅ Location selects initialized successfully');
                return true;

            } catch (error) {
                console.error('❌ Error in initEditModalLocations:', error);
                return false;
            }
        };

        console.log('✅ Public interface (initEditModalLocations) loaded');
    </script>
    <script>
        // 🔍 DEBUG: Test API trực tiếp
        async function testLocationAPI() {
            console.log('=== TESTING LOCATION API ===');

            try {
                const response = await fetch('https://provinces.open-api.vn/api/p/');
                const provinces = await response.json();

                console.log('📦 Total provinces:', provinces.length);
                console.log('📦 First 5 provinces:', provinces.slice(0, 5).map(p => ({
                    code: p.code,
                    name: p.name
                })));

                // Tìm TP. HCM
                const hcm = provinces.find(p => p.name.includes('Hồ Chí Minh'));
                console.log('🔍 TP. HCM:', hcm);

                // Tìm Hà Nội
                const hanoi = provinces.find(p => p.name.includes('Hà Nội'));
                console.log('🔍 Hà Nội:', hanoi);

            } catch (error) {
                console.error('❌ API Error:', error);
            }
        }

        // Gọi test ngay khi load trang
        testLocationAPI();
    </script>
    <!-- ============================================
     NOTIFICATION SYSTEM JAVASCRIPT
     ============================================ -->
    <script>
        (function() {
            'use strict';

            class NotificationManager {
                constructor() {
                    this.dropdownVisible = false;
                    this.notifications = [];
                    this.unreadCount = 0;
                    this.pollingInterval = null;
                    this.init();
                }

                init() {
                    console.log('🔔 Initializing Notification Manager...');
                    this.bindEvents();
                    this.loadNotifications();
                    this.startPolling();
                }

                bindEvents() {
                    const btnNotifications = document.getElementById('btnNotifications');
                    const dropdown = document.getElementById('notificationDropdown');
                    const btnMarkAllRead = document.getElementById('btnMarkAllRead');

                    // Toggle dropdown
                    if (btnNotifications) {
                        btnNotifications.addEventListener('click', (e) => {
                            e.stopPropagation();
                            this.toggleDropdown();
                        });
                    }

                    // Mark all as read
                    if (btnMarkAllRead) {
                        btnMarkAllRead.addEventListener('click', (e) => {
                            e.preventDefault();
                            this.markAllAsRead();
                        });
                    }

                    // Close dropdown when clicking outside
                    document.addEventListener('click', (e) => {
                        if (dropdown && !dropdown.contains(e.target) &&
                            btnNotifications && !btnNotifications.contains(e.target)) {
                            this.hideDropdown();
                        }
                    });
                }

                toggleDropdown() {
                    const dropdown = document.getElementById('notificationDropdown');
                    if (!dropdown) return;

                    this.dropdownVisible = !this.dropdownVisible;

                    if (this.dropdownVisible) {
                        dropdown.classList.remove('hidden');
                        this.loadNotifications();
                    } else {
                        dropdown.classList.add('hidden');
                    }
                }

                hideDropdown() {
                    const dropdown = document.getElementById('notificationDropdown');
                    if (dropdown) {
                        dropdown.classList.add('hidden');
                        this.dropdownVisible = false;
                    }
                }

                async loadNotifications() {
                    try {
                        const response = await fetch('/employer/notifications', {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                            }
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const data = await response.json();

                        if (data.success) {
                            this.notifications = data.notifications || [];
                            this.unreadCount = data.unread_count || 0;

                            console.log('✅ Loaded notifications:', this.notifications.length);
                            console.log('📬 Unread count:', this.unreadCount);

                            this.updateBadge();
                            this.renderNotifications();
                        } else {
                            console.error('❌ Failed to load notifications:', data.message);
                        }
                    } catch (error) {
                        console.error('❌ Error loading notifications:', error);
                    }
                }

                updateBadge() {
                    const badge = document.getElementById('notificationBadge');
                    if (!badge) return;

                    if (this.unreadCount > 0) {
                        badge.textContent = this.unreadCount > 99 ? '99+' : this.unreadCount;
                        badge.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                    }
                }

                renderNotifications() {
                    const container = document.getElementById('notificationList');
                    if (!container) return;

                    if (this.notifications.length === 0) {
                        container.innerHTML = `
                    <div class="notification-empty p-8 text-center text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <p class="text-sm font-medium">Chưa có thông báo nào</p>
                        <p class="text-xs text-gray-400 mt-1">Thông báo mới sẽ xuất hiện ở đây</p>
                    </div>
                `;
                        return;
                    }

                    const html = this.notifications.map(notif => this.renderNotificationItem(notif)).join('');
                    container.innerHTML = html;

                    // Bind click events
                    container.querySelectorAll('.notification-item').forEach(item => {
                        item.addEventListener('click', () => {
                            const id = item.dataset.id;
                            const jobId = item.dataset.jobId;
                            this.handleNotificationClick(id, jobId);
                        });
                    });
                }

                renderNotificationItem(notif) {
                    const unreadClass = !notif.is_read ? 'unread' : '';
                    const icon = this.getNotificationIcon(notif.type);
                    const timeAgo = this.formatTimeAgo(notif.created_at);
                    const unreadDot = !notif.is_read ?
                        '<div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0 mt-1"></div>' :
                        '';

                    return `
                <div class="notification-item ${unreadClass} p-4 border-b border-gray-100 hover:bg-gray-50" 
                     data-id="${notif.id}" 
                     data-job-id="${notif.data?.job_id || ''}">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-purple-100 to-blue-100 rounded-full flex items-center justify-center">
                            ${icon}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-800 font-medium mb-1 line-clamp-2">${this.escapeHtml(notif.message)}</p>
                            ${notif.data?.applicant_name ? `<p class="text-xs text-gray-600 mb-1">Ứng viên: ${this.escapeHtml(notif.data.applicant_name)}</p>` : ''}
                            <p class="notification-time">${timeAgo}</p>
                        </div>
                        ${unreadDot}
                    </div>
                </div>
            `;
                }

                getNotificationIcon(type) {
                    const icons = {
                        'new_application': `
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                `,
                        'interview_scheduled': `
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                `,
                        'default': `
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                `
                    };

                    return icons[type] || icons['default'];
                }

                formatTimeAgo(dateString) {
                    try {
                        const date = new Date(dateString);
                        const now = new Date();
                        const seconds = Math.floor((now - date) / 1000);

                        if (seconds < 60) return 'Vừa xong';
                        if (seconds < 3600) return `${Math.floor(seconds / 60)} phút trước`;
                        if (seconds < 86400) return `${Math.floor(seconds / 3600)} giờ trước`;
                        if (seconds < 604800) return `${Math.floor(seconds / 86400)} ngày trước`;

                        return date.toLocaleDateString('vi-VN', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });
                    } catch (e) {
                        return 'Không rõ';
                    }
                }

                async handleNotificationClick(notificationId, jobId) {
                    console.log('🖱️ Notification clicked:', {
                        notificationId,
                        jobId
                    });

                    // Mark as read
                    await this.markAsRead(notificationId);

                    // Navigate to job applicants page
                    if (jobId) {
                        window.location.href = `/job/${jobId}/applicants`;
                    }

                    this.hideDropdown();
                }

                async markAsRead(notificationId) {
                    try {
                        const response = await fetch(`/employer/notifications/${notificationId}/read`, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                            }
                        });

                        if (!response.ok) throw new Error('Failed to mark as read');

                        const data = await response.json();

                        if (data.success) {
                            // Update local state
                            const notif = this.notifications.find(n => n.id == notificationId);
                            if (notif && !notif.is_read) {
                                notif.is_read = true;
                                this.unreadCount = Math.max(0, this.unreadCount - 1);
                                this.updateBadge();
                                this.renderNotifications();
                            }
                        }
                    } catch (error) {
                        console.error('❌ Error marking as read:', error);
                    }
                }

                async markAllAsRead() {
                    try {
                        const response = await fetch('/employer/notifications/read-all', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                            }
                        });

                        if (!response.ok) throw new Error('Failed to mark all as read');

                        const data = await response.json();

                        if (data.success) {
                            // Update local state
                            this.notifications.forEach(notif => notif.is_read = true);
                            this.unreadCount = 0;
                            this.updateBadge();
                            this.renderNotifications();

                            console.log('✅ All notifications marked as read');
                        }
                    } catch (error) {
                        console.error('❌ Error marking all as read:', error);
                    }
                }

                startPolling() {
                    // Check for new notifications every 30 seconds
                    this.pollingInterval = setInterval(() => {
                        this.loadNotifications();
                    }, 30000);

                    console.log('🔄 Notification polling started (30s interval)');
                }

                stopPolling() {
                    if (this.pollingInterval) {
                        clearInterval(this.pollingInterval);
                        console.log('⏸️ Notification polling stopped');
                    }
                }

                escapeHtml(text) {
                    const div = document.createElement('div');
                    div.textContent = text;
                    return div.innerHTML;
                }
            }

            // Initialize when DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    window.notificationManager = new NotificationManager();
                });
            } else {
                window.notificationManager = new NotificationManager();
            }

        })();
    </script>
</body>

</html>