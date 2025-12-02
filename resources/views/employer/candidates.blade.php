<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tìm kiếm ứng viên - JobIT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        /* ============ ANIMATIONS ============ */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
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

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* ============ HEADER ============ */
        .main-header {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(139, 92, 246, 0.1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            animation: fadeIn 0.6s ease-out;
        }

        /* ============ SEARCH BAR WITH LOCATION ============ */
        .search-wrapper {
            display: flex;
            align-items: center;
            gap: 0;
            max-width: 900px;
            flex: 1;
            background: white;
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .search-wrapper:focus-within {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .search-input-container {
            flex: 1;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 0.875rem 3rem 0.875rem 3rem;
            border: none;
            font-size: 0.95rem;
            outline: none;
        }

        .location-select-container {
            position: relative;
            border-left: 1px solid #e5e7eb;
            min-width: 200px;
        }

        .location-select {
            width: 100%;
            padding: 0.875rem 2.5rem 0.875rem 2.5rem;
            border: none;
            font-size: 0.95rem;
            outline: none;
            cursor: pointer;
            appearance: none;
            background: transparent;
        }

        .search-btn {
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        /* ============ FILTER PANEL ============ */
        .filter-panel {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            animation: fadeInUp 0.6s ease-out;
        }

        .filter-section {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .filter-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .filter-title {
            font-size: 0.875rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            padding: 0.5rem 0;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .checkbox-item:hover {
            color: #667eea;
            transform: translateX(3px);
        }

        .checkbox-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 0.75rem;
            cursor: pointer;
            border-radius: 4px;
            border: 2px solid #d1d5db;
            transition: all 0.2s ease;
        }

        .checkbox-item input[type="checkbox"]:checked {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-color: #667eea;
        }

        .radio-item {
            display: flex;
            align-items: center;
            padding: 0.5rem 0;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .radio-item:hover {
            color: #667eea;
            transform: translateX(3px);
        }

        .radio-item input[type="radio"] {
            width: 18px;
            height: 18px;
            margin-right: 0.75rem;
            cursor: pointer;
        }

        /* ============ COMPACT CANDIDATE CARDS ============ */
        .candidates-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            animation: fadeIn 0.8s ease-out;
        }

        .candidate-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 2px solid transparent;
            min-height: 250px;
            display: flex;
            flex-direction: column;
        }

        .candidate-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.25);
            border-color: #667eea;
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 50px;
            position: relative;
        }

        .card-avatar {
            position: relative;
            width: 60px;
            height: 60px;
            margin: -30px auto 0.75rem;
            border-radius: 50%;
            border: 3px solid white;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .card-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-content {
            padding: 0 1rem 1rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .candidate-name {
            font-size: 1rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.25rem;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .candidate-title {
            font-size: 0.875rem;
            color: #667eea;
            font-weight: 600;
            text-align: center;
            margin-bottom: 0.75rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .candidate-info {
            font-size: 0.75rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .candidate-info i {
            width: 16px;
            color: #667eea;
            margin-right: 0.25rem;
        }

        .skill-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
            margin-bottom: 0.75rem;
            min-height: 24px;
            margin-top: auto;
        }

        .skill-tag {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            background: rgba(102, 126, 234, 0.1);
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
            color: #667eea;
        }

        .btn-view-profile {
            width: 100%;
            padding: 0.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: auto;
        }

        .btn-view-profile:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.35);
        }

        /* ============ PAGINATION ============ */
        .pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
            padding: 1.5rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .pagination-btn {
            padding: 0.5rem 1rem;
            border: 2px solid #e5e7eb;
            background: white;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #374151;
        }

        .pagination-btn:hover:not(:disabled) {
            border-color: #667eea;
            color: #667eea;
            background: #f3f4f6;
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination-btn.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-color: transparent;
        }

        .pagination-dots {
            padding: 0.5rem;
            color: #9ca3af;
        }

        /* ============ MODAL ============ */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            animation: fadeIn 0.3s ease;
        }

        .modal-content {
            background: white;
            border-radius: 24px;
            max-width: 1000px;
            width: 90%;
            max-height: 90vh;
            overflow: hidden;
            box-shadow: 0 25px 100px rgba(0, 0, 0, 0.3);
            animation: scaleIn 0.3s ease;
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-body {
            padding: 2rem;
            overflow-y: auto;
            max-height: calc(90vh - 180px);
        }

        .modal-body::-webkit-scrollbar {
            width: 10px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
        }

        .cv-section {
            background: #f8f9ff;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #667eea;
            animation: fadeInUp 0.5s ease;
        }

        .cv-section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .cv-section-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        /* ============ LOADING ============ */
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 3rem;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f4f6;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* ============ EMPTY STATE ============ */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            animation: fadeInUp 0.8s ease-out;
        }

        .empty-state svg {
            width: 120px;
            height: 120px;
            margin: 0 auto 1.5rem;
            opacity: 0.3;
        }

        /* ============ RESPONSIVE ============ */
        @media (max-width: 1024px) {
            .candidates-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .candidates-grid {
                grid-template-columns: 1fr;
            }

            .modal-content {
                width: 95%;
                max-height: 95vh;
            }

            .search-wrapper {
                flex-direction: column;
            }

            .location-select-container {
                width: 100%;
                border-left: none;
                border-top: 1px solid #e5e7eb;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <!-- HEADER -->
    <!-- HEADER -->
    <header class="main-header sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between gap-4">
                <!-- Logo -->
                <a href="{{ route('employer.dashboard') }}" class="flex-shrink-0">
                    <span class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">JobIT</span>
                </a>

                <!-- Search Bar with Location - Dài ra giữa -->
                <div class="flex-1 flex items-center gap-3 mx-6">
                    <!-- Search Input -->
                    <div class="search-input-container flex-1">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35" />
                        </svg>
                        <input type="text"
                            id="searchKeyword"
                            class="search-input"
                            placeholder="Tìm theo kỹ năng, vị trí..."
                            value="{{ request('keyword') }}">
                    </div>

                    <!-- Location Filter Dropdown -->
                    <div class="location-select-container relative">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <select id="locationFilter" class="location-select">
                            <option value="">Tất cả tỉnh/thành</option>
                            <!-- Miền Bắc -->
                            <option value="Hà Nội" {{ request('location') == 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                            <option value="Hải Phòng" {{ request('location') == 'Hải Phòng' ? 'selected' : '' }}>Hải Phòng</option>
                            <option value="Quảng Ninh" {{ request('location') == 'Quảng Ninh' ? 'selected' : '' }}>Quảng Ninh</option>
                            <option value="Bắc Giang" {{ request('location') == 'Bắc Giang' ? 'selected' : '' }}>Bắc Giang</option>
                            <option value="Bắc Kạn" {{ request('location') == 'Bắc Kạn' ? 'selected' : '' }}>Bắc Kạn</option>
                            <option value="Cao Bằng" {{ request('location') == 'Cao Bằng' ? 'selected' : '' }}>Cao Bằng</option>
                            <option value="Lạng Sơn" {{ request('location') == 'Lạng Sơn' ? 'selected' : '' }}>Lạng Sơn</option>
                            <option value="Tuyên Quang" {{ request('location') == 'Tuyên Quang' ? 'selected' : '' }}>Tuyên Quang</option>
                            <option value="Yên Bái" {{ request('location') == 'Yên Bái' ? 'selected' : '' }}>Yên Bái</option>
                            <option value="Thái Nguyên" {{ request('location') == 'Thái Nguyên' ? 'selected' : '' }}>Thái Nguyên</option>
                            <option value="Phú Thọ" {{ request('location') == 'Phú Thọ' ? 'selected' : '' }}>Phú Thọ</option>
                            <option value="Vĩnh Phúc" {{ request('location') == 'Vĩnh Phúc' ? 'selected' : '' }}>Vĩnh Phúc</option>
                            <option value="Hà Giang" {{ request('location') == 'Hà Giang' ? 'selected' : '' }}>Hà Giang</option>
                            <!-- Miền Trung -->
                            <option value="Thanh Hóa" {{ request('location') == 'Thanh Hóa' ? 'selected' : '' }}>Thanh Hóa</option>
                            <option value="Nghệ An" {{ request('location') == 'Nghệ An' ? 'selected' : '' }}>Nghệ An</option>
                            <option value="Hà Tĩnh" {{ request('location') == 'Hà Tĩnh' ? 'selected' : '' }}>Hà Tĩnh</option>
                            <option value="Quảng Bình" {{ request('location') == 'Quảng Bình' ? 'selected' : '' }}>Quảng Bình</option>
                            <option value="Quảng Trị" {{ request('location') == 'Quảng Trị' ? 'selected' : '' }}>Quảng Trị</option>
                            <option value="Thừa Thiên Huế" {{ request('location') == 'Thừa Thiên Huế' ? 'selected' : '' }}>Thừa Thiên Huế</option>
                            <option value="Đà Nẵng" {{ request('location') == 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng</option>
                            <option value="Quảng Nam" {{ request('location') == 'Quảng Nam' ? 'selected' : '' }}>Quảng Nam</option>
                            <option value="Quảng Ngãi" {{ request('location') == 'Quảng Ngãi' ? 'selected' : '' }}>Quảng Ngãi</option>
                            <option value="Bình Định" {{ request('location') == 'Bình Định' ? 'selected' : '' }}>Bình Định</option>
                            <option value="Phú Yên" {{ request('location') == 'Phú Yên' ? 'selected' : '' }}>Phú Yên</option>
                            <option value="Khánh Hòa" {{ request('location') == 'Khánh Hòa' ? 'selected' : '' }}>Khánh Hòa</option>
                            <option value="Ninh Thuận" {{ request('location') == 'Ninh Thuận' ? 'selected' : '' }}>Ninh Thuận</option>
                            <option value="Bình Thuận" {{ request('location') == 'Bình Thuận' ? 'selected' : '' }}>Bình Thuận</option>
                            <!-- Miền Nam -->
                            <option value="Hồ Chí Minh" {{ request('location') == 'Hồ Chí Minh' ? 'selected' : '' }}>Hồ Chí Minh</option>
                            <option value="Hà Nội" {{ request('location') == 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                            <option value="Bình Dương" {{ request('location') == 'Bình Dương' ? 'selected' : '' }}>Bình Dương</option>
                            <option value="Đồng Nai" {{ request('location') == 'Đồng Nai' ? 'selected' : '' }}>Đồng Nai</option>
                            <option value="Bà Rịa - Vũng Tàu" {{ request('location') == 'Bà Rịa - Vũng Tàu' ? 'selected' : '' }}>Bà Rịa - Vũng Tàu</option>
                            <option value="Long An" {{ request('location') == 'Long An' ? 'selected' : '' }}>Long An</option>
                            <option value="Tiền Giang" {{ request('location') == 'Tiền Giang' ? 'selected' : '' }}>Tiền Giang</option>
                            <option value="Bến Tre" {{ request('location') == 'Bến Tre' ? 'selected' : '' }}>Bến Tre</option>
                            <option value="Vĩnh Long" {{ request('location') == 'Vĩnh Long' ? 'selected' : '' }}>Vĩnh Long</option>
                            <option value="Cần Thơ" {{ request('location') == 'Cần Thơ' ? 'selected' : '' }}>Cần Thơ</option>
                            <option value="An Giang" {{ request('location') == 'An Giang' ? 'selected' : '' }}>An Giang</option>
                            <option value="Kiên Giang" {{ request('location') == 'Kiên Giang' ? 'selected' : '' }}>Kiên Giang</option>
                            <option value="Cà Mau" {{ request('location') == 'Cà Mau' ? 'selected' : '' }}>Cà Mau</option>
                            <option value="Sóc Trăng" {{ request('location') == 'Sóc Trăng' ? 'selected' : '' }}>Sóc Trăng</option>
                            <option value="Bạc Liêu" {{ request('location') == 'Bạc Liêu' ? 'selected' : '' }}>Bạc Liêu</option>
                            <option value="Hậu Giang" {{ request('location') == 'Hậu Giang' ? 'selected' : '' }}>Hậu Giang</option>
                            <option value="Đắk Lắk" {{ request('location') == 'Đắk Lắk' ? 'selected' : '' }}>Đắk Lắk</option>
                            <option value="Đắk Nông" {{ request('location') == 'Đắk Nông' ? 'selected' : '' }}>Đắk Nông</option>
                            <option value="Gia Lai" {{ request('location') == 'Gia Lai' ? 'selected' : '' }}>Gia Lai</option>
                            <option value="Kon Tum" {{ request('location') == 'Kon Tum' ? 'selected' : '' }}>Kon Tum</option>
                            <option value="Lâm Đồng" {{ request('location') == 'Lâm Đồng' ? 'selected' : '' }}>Lâm Đồng</option>
                        </select>
                        <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>

                    <!-- Search Button -->
                    <button onclick="searchCandidates()" class="search-btn flex-shrink-0">
                        <i class="bi bi-search"></i>
                    </button>
                </div>

                <!-- Right Actions - Notifications & Profile -->
                <div class="flex items-center gap-4 flex-shrink-0">
                    <!-- Notifications Bell -->
                    <div class="relative">
                        <button id="btnNotifications" class="relative p-2 rounded-lg hover:bg-gray-100 transition-all duration-300">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span id="notificationBadge" class="hidden absolute top-0 right-0 min-w-[20px] h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center px-1.5 animate-pulse">0</span>
                        </button>

                        <!-- Notification Dropdown -->
                        <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-96 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 max-h-[500px] flex flex-col">
                            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                                <h3 class="font-semibold text-gray-800">Thông báo</h3>
                                <button id="btnMarkAllRead" class="text-xs text-purple-600 hover:text-purple-700 font-medium transition-colors">
                                    Đánh dấu đã đọc
                                </button>
                            </div>
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

                    <!-- Profile Menu -->
                    <div class="relative">
                        <button id="btnProfile" class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-100 transition-all">
                            @php
                            $company = auth()->user()->employer->company ?? null;
                            $logoPath = $company && $company->logo ? asset('assets/img/' . $company->logo) : null;
                            @endphp

                            @if($logoPath)
                            <img src="{{ $logoPath }}" alt="Company Logo" class="w-10 h-10 rounded-lg object-cover shadow-md">
                            @else
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-blue-500 rounded-lg flex items-center justify-center text-white font-semibold text-sm shadow-md">
                                {{ strtoupper(substr($company->tencty ?? 'TD', 0, 2)) }}
                            </div>
                            @endif

                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Profile Dropdown Menu -->
                        <div id="profileMenu" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-100 py-2">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="font-semibold text-gray-800">{{ $company->tencty ?? 'Chưa cập nhật' }}</p>
                                <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('employer.dashboard') }}" class="block px-4 py-2 hover:bg-gray-50 text-gray-700 transition-colors">
                                <i class="bi bi-house-door mr-2"></i> Dashboard
                            </a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-50 text-red-600 transition-colors">
                                    <i class="bi bi-box-arrow-right mr-2"></i> Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="grid grid-cols-12 gap-6">

            <!-- FILTER SIDEBAR -->
            <aside class="col-span-12 lg:col-span-3">
                <div class="filter-panel sticky top-24">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-800">Bộ lọc</h3>
                        <button onclick="resetFilters()" class="text-sm text-purple-600 hover:text-purple-700 font-semibold">
                            Đặt lại
                        </button>
                    </div>

                    <form id="filterForm">
                        <!-- Kinh nghiệm -->
                        <div class="filter-section">
                            <div class="filter-title">
                                <i class="bi bi-briefcase text-purple-600"></i> Kinh nghiệm
                            </div>
                            <div class="space-y-2">
                                <label class="checkbox-item">
                                    <input type="checkbox" name="experience[]" value="0" {{ in_array('0', request('experience', [])) ? 'checked' : '' }}>
                                    <span>Chưa có kinh nghiệm</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="experience[]" value="0-1" {{ in_array('0-1', request('experience', [])) ? 'checked' : '' }}>
                                    <span>Dưới 1 năm</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="experience[]" value="1-3" {{ in_array('1-3', request('experience', [])) ? 'checked' : '' }}>
                                    <span>1 - 3 năm</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="experience[]" value="3-5" {{ in_array('3-5', request('experience', [])) ? 'checked' : '' }}>
                                    <span>3 - 5 năm</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="experience[]" value="5+" {{ in_array('5+', request('experience', [])) ? 'checked' : '' }}>
                                    <span>Trên 5 năm</span>
                                </label>
                            </div>
                        </div>

                        <!-- Trình độ học vấn -->
                        <div class="filter-section">
                            <div class="filter-title">
                                <i class="bi bi-mortarboard text-purple-600"></i> Trình độ
                            </div>
                            <div class="space-y-2">
                                <label class="checkbox-item">
                                    <input type="checkbox" name="education[]" value="Trung cấp" {{ in_array('Trung cấp', request('education', [])) ? 'checked' : '' }}>
                                    <span>Trung cấp</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="education[]" value="Cao đẳng" {{ in_array('Cao đẳng', request('education', [])) ? 'checked' : '' }}>
                                    <span>Cao đẳng</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="education[]" value="Đại học" {{ in_array('Đại học', request('education', [])) ? 'checked' : '' }}>
                                    <span>Đại học</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="education[]" value="Thạc sĩ" {{ in_array('Thạc sĩ', request('education', [])) ? 'checked' : '' }}>
                                    <span>Thạc sĩ</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="education[]" value="Tiến sĩ" {{ in_array('Tiến sĩ', request('education', [])) ? 'checked' : '' }}>
                                    <span>Tiến sĩ</span>
                                </label>
                            </div>
                        </div>

                        <!-- Mức lương mong muốn -->
                        <div class="filter-section">
                            <div class="filter-title">
                                <i class="bi bi-cash-stack text-purple-600"></i> Mức lương (triệu VNĐ)
                            </div>
                            <div class="space-y-2">
                                <label class="checkbox-item">
                                    <input type="checkbox" name="salary[]" value="0-10" {{ in_array('0-10', request('salary', [])) ? 'checked' : '' }}>
                                    <span>Dưới 10 triệu</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="salary[]" value="10-15" {{ in_array('10-15', request('salary', [])) ? 'checked' : '' }}>
                                    <span>10 - 15 triệu</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="salary[]" value="15-20" {{ in_array('15-20', request('salary', [])) ? 'checked' : '' }}>
                                    <span>15 - 20 triệu</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="salary[]" value="20-30" {{ in_array('20-30', request('salary', [])) ? 'checked' : '' }}>
                                    <span>20 - 30 triệu</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="salary[]" value="30+" {{ in_array('30+', request('salary', [])) ? 'checked' : '' }}>
                                    <span>Trên 30 triệu</span>
                                </label>
                            </div>
                        </div>

                        <!-- Ngoại ngữ -->
                        <div class="filter-section">
                            <div class="filter-title">
                                <i class="bi bi-translate text-purple-600"></i> Ngoại ngữ
                            </div>
                            <div class="space-y-2">
                                <label class="checkbox-item">
                                    <input type="checkbox" name="language[]" value="Tiếng Anh" {{ in_array('Tiếng Anh', request('language', [])) ? 'checked' : '' }}>
                                    <span>Tiếng Anh</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="language[]" value="Tiếng Nhật" {{ in_array('Tiếng Nhật', request('language', [])) ? 'checked' : '' }}>
                                    <span>Tiếng Nhật</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="language[]" value="Tiếng Hàn" {{ in_array('Tiếng Hàn', request('language', [])) ? 'checked' : '' }}>
                                    <span>Tiếng Hàn</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="language[]" value="Tiếng Trung" {{ in_array('Tiếng Trung', request('language', [])) ? 'checked' : '' }}>
                                    <span>Tiếng Trung</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="language[]" value="Tiếng Pháp" {{ in_array('Tiếng Pháp', request('language', [])) ? 'checked' : '' }}>
                                    <span>Tiếng Pháp</span>
                                </label>
                            </div>
                        </div>

                        <!-- Giới tính -->
                        <div class="filter-section">
                            <div class="filter-title">
                                <i class="bi bi-gender-ambiguous text-purple-600"></i> Giới tính
                            </div>
                            <div class="space-y-2">
                                <label class="radio-item">
                                    <input type="radio" name="gender" value="" {{ !request('gender') ? 'checked' : '' }}>
                                    <span>Tất cả</span>
                                </label>
                                <label class="radio-item">
                                    <input type="radio" name="gender" value="Nam" {{ request('gender') == 'Nam' ? 'checked' : '' }}>
                                    <span>Nam</span>
                                </label>
                                <label class="radio-item">
                                    <input type="radio" name="gender" value="Nữ" {{ request('gender') == 'Nữ' ? 'checked' : '' }}>
                                    <span>Nữ</span>
                                </label>
                            </div>
                        </div>

                        <!-- Kỹ năng -->
                        <div class="filter-section">
                            <div class="filter-title">
                                <i class="bi bi-lightbulb text-purple-600"></i> Kỹ năng
                            </div>
                            <input type="text"
                                id="skillSearch"
                                placeholder="Tìm kỹ năng..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm mb-3 focus:outline-none focus:border-purple-500">
                            <div class="space-y-2 max-h-64 overflow-y-auto" id="skillsList">
                                <label class="checkbox-item">
                                    <input type="checkbox" name="skills[]" value="PHP" {{ in_array('PHP', request('skills', [])) ? 'checked' : '' }}>
                                    <span>PHP</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="skills[]" value="JavaScript" {{ in_array('JavaScript', request('skills', [])) ? 'checked' : '' }}>
                                    <span>JavaScript</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="skills[]" value="Laravel" {{ in_array('Laravel', request('skills', [])) ? 'checked' : '' }}>
                                    <span>Laravel</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="skills[]" value="React" {{ in_array('React', request('skills', [])) ? 'checked' : '' }}>
                                    <span>React</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="skills[]" value="Vue.js" {{ in_array('Vue.js', request('skills', [])) ? 'checked' : '' }}>
                                    <span>Vue.js</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="skills[]" value="Node.js" {{ in_array('Node.js', request('skills', [])) ? 'checked' : '' }}>
                                    <span>Node.js</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="skills[]" value="Python" {{ in_array('Python', request('skills', [])) ? 'checked' : '' }}>
                                    <span>Python</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="skills[]" value="Java" {{ in_array('Java', request('skills', [])) ? 'checked' : '' }}>
                                    <span>Java</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="skills[]" value="C#" {{ in_array('C#', request('skills', [])) ? 'checked' : '' }}>
                                    <span>C#</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="skills[]" value="Angular" {{ in_array('Angular', request('skills', [])) ? 'checked' : '' }}>
                                    <span>Angular</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="skills[]" value="SQL" {{ in_array('SQL', request('skills', [])) ? 'checked' : '' }}>
                                    <span>SQL</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="skills[]" value="MongoDB" {{ in_array('MongoDB', request('skills', [])) ? 'checked' : '' }}>
                                    <span>MongoDB</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="skills[]" value="Docker" {{ in_array('Docker', request('skills', [])) ? 'checked' : '' }}>
                                    <span>Docker</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="skills[]" value="AWS" {{ in_array('AWS', request('skills', [])) ? 'checked' : '' }}>
                                    <span>AWS</span>
                                </label>
                            </div>
                        </div>

                        <button type="button" onclick="applyFilters()" class="w-full py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all mt-4">
                            <i class="bi bi-funnel mr-2"></i> Áp dụng bộ lọc
                        </button>
                    </form>
                </div>
            </aside>

            <!-- CANDIDATES GRID -->
            <main class="col-span-12 lg:col-span-9">
                <!-- Result Info -->
                <div class="bg-white rounded-xl shadow-sm p-4 mb-6 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">
                            Tìm thấy <span class="text-purple-600">{{ $candidates->total() }}</span> ứng viên
                        </h2>
                    </div>
                    <div class="flex items-center gap-3">
                        <select id="sortBy" onchange="sortCandidates()" class="px-4 py-2 border border-gray-300 rounded-lg text-sm">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="experience" {{ request('sort') == 'experience' ? 'selected' : '' }}>Kinh nghiệm cao</option>
                            <option value="education" {{ request('sort') == 'education' ? 'selected' : '' }}>Học vấn cao nhất</option>
                        </select>
                    </div>
                </div>

                <!-- Candidates Grid -->
                <div id="candidatesContainer">
                    @if($candidates->count() > 0)
                    <div class="candidates-grid">
                        @foreach($candidates as $candidate)
                        <div class="candidate-card">
                            <div class="card-header"></div>

                            <div class="card-avatar">
                                @if($candidate->avatar)
                                <img src="{{ asset('assets/img/avt/' . $candidate->avatar) }}" alt="{{ $candidate->hoten_uv }}">
                                @else
                                <div class="w-full h-full bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white text-2xl font-bold">
                                    {{ strtoupper(substr($candidate->hoten_uv, 0, 1)) }}
                                </div>
                                @endif
                            </div>

                            <div class="card-content">
                                <h3 class="candidate-name">
                                    {{ $candidate->hoten_uv }}
                                </h3>
                                <p class="candidate-title">
                                    {{ $candidate->chucdanh ?? 'Chưa cập nhật' }}
                                </p>

                                <div class="space-y-1 mb-3">
                                    <div class="candidate-info flex items-center">
                                        <i class="bi bi-geo-alt"></i>
                                        <span class="truncate">{{ $candidate->diachi_uv ?? 'Chưa cập nhật' }}</span>
                                    </div>
                                    @if($candidate->kinhnghiem && $candidate->kinhnghiem->count() > 0)
                                    <div class="candidate-info flex items-center">
                                        <i class="bi bi-briefcase"></i>
                                        <span>{{ $candidate->kinhnghiem->count() }} năm kinh nghiệm</span>
                                    </div>
                                    @endif
                                    @if($candidate->hocvan && $candidate->hocvan->first())
                                    <div class="candidate-info flex items-center">
                                        <i class="bi bi-mortarboard"></i>
                                        <span>{{ $candidate->hocvan->first()->trinh_do ?? 'Đại học' }}</span>
                                    </div>
                                    @endif
                                </div>

                                @if($candidate->kynang && $candidate->kynang->count() > 0)
                                <div class="skill-tags">
                                    @foreach($candidate->kynang->take(3) as $skill)
                                    <span class="skill-tag">{{ $skill->ten_ky_nang }}</span>
                                    @endforeach
                                    @if($candidate->kynang->count() > 3)
                                    <span class="skill-tag">+{{ $candidate->kynang->count() - 3 }}</span>
                                    @endif
                                </div>
                                @endif

                                <button onclick="viewCV('{{ $candidate->id_uv }}')" class="btn-view-profile">
                                    <i class="bi bi-eye mr-1"></i> Xem hồ sơ
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!-- Pagination -->
                    @if($candidates->hasPages())
                    <div class="pagination">
                        <!-- Previous Button -->
                        <button
                            onclick="goToPage({{ $candidates->currentPage() - 1 }})"
                            class="pagination-btn"
                            {{ $candidates->onFirstPage() ? 'disabled' : '' }}>
                            <i class="bi bi-chevron-left"></i>
                        </button>

                        <!-- First Page -->
                        @if($candidates->currentPage() > 3)
                        <button onclick="goToPage(1)" class="pagination-btn">1</button>
                        @if($candidates->currentPage() > 4)
                        <span class="pagination-dots">...</span>
                        @endif
                        @endif

                        <!-- Page Numbers -->
                        @for($i = max(1, $candidates->currentPage() - 2); $i <= min($candidates->lastPage(), $candidates->currentPage() + 2); $i++)
                            <button
                                onclick="goToPage({{ $i }})"
                                class="pagination-btn {{ $i == $candidates->currentPage() ? 'active' : '' }}">
                                {{ $i }}
                            </button>
                            @endfor

                            <!-- Last Page -->
                            @if($candidates->currentPage() < $candidates->lastPage() - 2)
                                @if($candidates->currentPage() < $candidates->lastPage() - 3)
                                    <span class="pagination-dots">...</span>
                                    @endif
                                    <button onclick="goToPage({{ $candidates->lastPage() }})" class="pagination-btn">{{ $candidates->lastPage() }}</button>
                                    @endif

                                    <!-- Next Button -->
                                    <button
                                        onclick="goToPage({{ $candidates->currentPage() + 1 }})"
                                        class="pagination-btn"
                                        {{ !$candidates->hasMorePages() ? 'disabled' : '' }}>
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                    </div>
                    @endif
                    @else
                    <div class="empty-state">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Không tìm thấy ứng viên</h3>
                        <p class="text-gray-600">Vui lòng thử lại với bộ lọc khác</p>
                    </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <!-- CV MODAL -->
    <div id="cvModal" class="hidden modal-overlay" onclick="closeModal(event)">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h3 class="text-2xl font-bold">Hồ sơ ứng viên</h3>
                <button onclick="closeModal()" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-white/20 transition-all">
                    <i class="bi bi-x-lg text-2xl"></i>
                </button>
            </div>
            <div class="modal-body" id="cvContent">
                <div class="loading">
                    <div class="spinner"></div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex items-center justify-end gap-3">
                <button onclick="downloadCV()" class="px-6 py-2.5 border border-gray-300 rounded-lg hover:bg-gray-100 transition-all font-semibold">
                    <i class="bi bi-download mr-2"></i> Tải CV
                </button>
                <button onclick="contactCandidate()" class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:shadow-lg transition-all font-semibold">
                    <i class="bi bi-envelope mr-2"></i> Liên hệ
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentCandidateId = null;

        // Profile menu toggle
        document.getElementById('btnProfile')?.addEventListener('click', function(e) {
            e.stopPropagation();
            document.getElementById('profileMenu').classList.toggle('hidden');
        });

        document.addEventListener('click', function(e) {
            const menu = document.getElementById('profileMenu');
            if (menu && !menu.contains(e.target) && !document.getElementById('btnProfile').contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

        // Search function - CHỈ TÌM KHI NHẤN NÚT
        function searchCandidates() {
            const keyword = document.getElementById('searchKeyword').value.trim();
            const location = document.getElementById('locationFilter').value.trim();

            const url = new URL("{{ route('employer.candidates') }}");

            // Thêm keyword nếu có
            if (keyword) {
                url.searchParams.set('keyword', keyword);
            }

            // Thêm location nếu có
            if (location) {
                url.searchParams.set('location', location);
            }

            // Giữ lại các filter đã chọn
            const formData = new FormData(document.getElementById('filterForm'));
            for (let [key, value] of formData.entries()) {
                if (value) {
                    url.searchParams.append(key, value);
                }
            }

            // Giữ lại sort
            const sortBy = document.getElementById('sortBy')?.value;
            if (sortBy) {
                url.searchParams.set('sort', sortBy);
            }

            window.location.href = url.toString();
        }

        // ============ SORT - GIỮ LẠI CÁC FILTER KHI SORT ============
        function sortCandidates() {
            const sortBy = document.getElementById('sortBy').value;
            const url = new URL(window.location.href);
            url.searchParams.set('sort', sortBy);
            window.location.href = url.toString();
        }

        // ============ APPLY FILTERS - CẬP NHẬT ============
        function applyFilters() {
            const form = document.getElementById('filterForm');
            const formData = new FormData(form);
            const params = new URLSearchParams();

            // Add all form data từ filter
            for (let [key, value] of formData.entries()) {
                if (value) {
                    params.append(key, value);
                }
            }

            // Add search keyword (nếu có)
            const keyword = document.getElementById('searchKeyword').value.trim();
            if (keyword) {
                params.set('keyword', keyword);
            }

            // Add location (nếu có)
            const location = document.getElementById('locationFilter').value.trim();
            if (location) {
                params.set('location', location);
            }

            // Add sort if exists
            const sortBy = document.getElementById('sortBy')?.value;
            if (sortBy) {
                params.set('sort', sortBy);
            }

            window.location.href = `{{ route('employer.candidates') }}?${params.toString()}`;
        }

        /// ============ RESET FILTERS - CẬP NHẬT ============
        function resetFilters() {
            // Reset form
            document.getElementById('filterForm').reset();

            // Reset search inputs
            document.getElementById('searchKeyword').value = '';
            document.getElementById('locationFilter').value = '';

            // Redirect về trang không filter
            window.location.href = "{{ route('employer.candidates') }}";
        }

        // ============ ENTER KEY SEARCH ============
        document.getElementById('searchKeyword')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchCandidates();
            }
        });

        // Pagination
        function goToPage(page) {
            const url = new URL(window.location.href);
            url.searchParams.set('page', page);
            window.location.href = url.toString();
        }

        // View CV
        function viewCV(candidateId) {
            currentCandidateId = candidateId;
            const modal = document.getElementById('cvModal');
            const content = document.getElementById('cvContent');

            modal.classList.remove('hidden');
            content.innerHTML = '<div class="loading"><div class="spinner"></div></div>';

            fetch(`/employer/candidates/${candidateId}`)
                .then(response => response.json())
                .then(data => {
                    content.innerHTML = generateCVHTML(data);
                })
                .catch(error => {
                    content.innerHTML = '<div class="text-center text-red-600 py-8">Có lỗi xảy ra khi tải dữ liệu</div>';
                });
        }

        function generateCVHTML(candidate) {
            return `
            <div class="space-y-6">
                <!-- Profile Header -->
                <div class="cv-section">
                    <div class="flex items-start gap-6">
                        ${candidate.avatar 
                            ? `<img src="/assets/img/avt/${candidate.avatar}" class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">`
                            : `<div class="w-32 h-32 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white text-4xl font-bold border-4 border-white shadow-lg">
                                ${candidate.hoten_uv.charAt(0)}
                              </div>`
                        }
                        <div class="flex-1">
                            <h2 class="text-3xl font-bold text-gray-800 mb-2">${candidate.hoten_uv}</h2>
                            <p class="text-xl text-purple-600 font-semibold mb-4">${candidate.chucdanh || 'Chưa cập nhật'}</p>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                ${candidate.sdt_uv ? `
                                <div class="flex items-center text-gray-700">
                                    <i class="bi bi-telephone mr-2"></i>
                                    ${candidate.sdt_uv}
                                </div>
                                ` : ''}
                                ${candidate.user && candidate.user.email ? `
                                <div class="flex items-center text-gray-700">
                                    <i class="bi bi-envelope mr-2"></i>
                                    ${candidate.user.email}
                                </div>
                                ` : ''}
                                ${candidate.diachi_uv ? `
                                <div class="flex items-center text-gray-700">
                                    <i class="bi bi-geo-alt mr-2"></i>
                                    ${candidate.diachi_uv}
                                </div>
                                ` : ''}
                                ${candidate.gioitinh_uv ? `
                                <div class="flex items-center text-gray-700">
                                    <i class="bi bi-gender-ambiguous mr-2"></i>
                                    ${candidate.gioitinh_uv}
                                </div>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                </div>

                ${candidate.gioithieu ? `
                <div class="cv-section">
                    <div class="cv-section-title">
                        <div class="cv-section-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        Giới thiệu bản thân
                    </div>
                    <p class="text-gray-700 leading-relaxed">${candidate.gioithieu}</p>
                </div>
                ` : ''}

                ${candidate.kinhnghiem && candidate.kinhnghiem.length > 0 ? `
                <div class="cv-section">
                    <div class="cv-section-title">
                        <div class="cv-section-icon">
                            <i class="bi bi-briefcase"></i>
                        </div>
                        Kinh nghiệm làm việc
                    </div>
                    <div class="space-y-4">
                        ${candidate.kinhnghiem.map(exp => `
                            <div class="border-l-4 border-purple-500 pl-4">
                                <h4 class="font-semibold text-gray-800 text-lg">${exp.chuc_vu || exp.chucdanh || 'N/A'}</h4>
                                <p class="text-purple-600 font-medium">${exp.ten_cong_ty || exp.congty || 'N/A'}</p>
                                <p class="text-sm text-gray-600 mb-2">
                                    ${exp.tu_ngay ? new Date(exp.tu_ngay).toLocaleDateString('vi-VN') : 'N/A'} - 
                                    ${exp.dang_lam_viec ? 'Hiện tại' : (exp.den_ngay ? new Date(exp.den_ngay).toLocaleDateString('vi-VN') : 'N/A')}
                                </p>
                                ${exp.mo_ta || exp.mota ? `<p class="text-gray-700">${(exp.mo_ta || exp.mota).replace(/\\n/g, '<br>')}</p>` : ''}
                            </div>
                        `).join('')}
                    </div>
                </div>
                ` : ''}

                ${candidate.hocvan && candidate.hocvan.length > 0 ? `
                <div class="cv-section">
                    <div class="cv-section-title">
                        <div class="cv-section-icon">
                            <i class="bi bi-mortarboard"></i>
                        </div>
                        Học vấn
                    </div>
                    <div class="space-y-4">
                        ${candidate.hocvan.map(edu => `
                            <div class="border-l-4 border-blue-500 pl-4">
                                <h4 class="font-semibold text-gray-800">${edu.ten_truong || edu.truong || 'N/A'}</h4>
                                <p class="text-blue-600 font-medium">${edu.trinh_do || edu.trinhdo || 'N/A'} - ${edu.chuyen_nganh || edu.nganh || ''}</p>
                                <p class="text-sm text-gray-600">
                                    ${edu.tu_ngay ? new Date(edu.tu_ngay).toLocaleDateString('vi-VN') : 'N/A'} - 
                                    ${edu.dang_hoc ? 'Hiện tại' : (edu.den_ngay ? new Date(edu.den_ngay).toLocaleDateString('vi-VN') : 'N/A')}
                                </p>
                            </div>
                        `).join('')}
                    </div>
                </div>
                ` : ''}

                ${candidate.kynang && candidate.kynang.length > 0 ? `
                <div class="cv-section">
                    <div class="cv-section-title">
                        <div class="cv-section-icon">
                            <i class="bi bi-lightbulb"></i>
                        </div>
                        Kỹ năng
                    </div>
                    <div class="flex flex-wrap gap-2">
                        ${candidate.kynang.map(skill => `
                            <span class="skill-tag">
                                ${skill.ten_ky_nang}
                                ${skill.nam_kinh_nghiem ? ` (${skill.nam_kinh_nghiem == 0 ? '<1 năm' : skill.nam_kinh_nghiem + ' năm'})` : ''}
                            </span>
                        `).join('')}
                    </div>
                </div>
                ` : ''}

                ${candidate.ngoai_ngu && candidate.ngoai_ngu.length > 0 ? `
                <div class="cv-section">
                    <div class="cv-section-title">
                        <div class="cv-section-icon">
                            <i class="bi bi-translate"></i>
                        </div>
                        Ngoại ngữ
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        ${candidate.ngoai_ngu.map(lang => `
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                                <span class="font-medium">${lang.ten_ngoai_ngu}</span>
                                <span class="text-sm text-gray-600">${lang.trinh_do}</span>
                            </div>
                        `).join('')}
                    </div>
                </div>
                ` : ''}
            </div>
        `;
        }

        function closeModal(event) {
            if (!event || event.target.id === 'cvModal') {
                document.getElementById('cvModal').classList.add('hidden');
                currentCandidateId = null;
            }
        }

        function downloadCV() {
            if (!currentCandidateId) return;
            window.location.href = `/employer/candidates/${currentCandidateId}/download-cv`;
        }

        function contactCandidate() {
            if (!currentCandidateId) return;
            window.location.href = `/employer/candidates/${currentCandidateId}/contact`;
        }

        // Enter key search - CHỈ KHI NHẤN ENTER
        document.getElementById('searchKeyword')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchCandidates();
            }
        });
        // ============ SKILL SEARCH FILTER ============
        document.getElementById('skillSearch')?.addEventListener('input', function(e) {
            const search = e.target.value.toLowerCase();
            const items = document.querySelectorAll('#skillsList .checkbox-item');

            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(search) ? 'flex' : 'none';
            });
        });

        // Location select change - KHÔNG TỰ ĐỘNG, CHỈ LÀM HIGHLIGHT
        document.getElementById('locationFilter')?.addEventListener('change', function(e) {
            // Chỉ highlight lựa chọn, không tự động tìm
            console.log('Location selected:', this.value);
        });
    </script>
</body>

</html>