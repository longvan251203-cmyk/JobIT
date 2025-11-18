<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-authenticated" content="{{ Auth::check() ? 'true' : 'false' }}">
    <title>Tìm Việc IT Chuyên Nghiệp</title>

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Roboto', sans-serif;
            background-color: #F5F7FA;
            color: #2D3748;
            padding-top: 70px;
        }

        /* ========== HEADER ========== */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: #FFFFFF;
            border-bottom: 1px solid #E2E8F0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            z-index: 1000;
            height: 70px;
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1.5rem;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            flex-shrink: 0;
        }

        .logo img {
            width: 40px;
            height: 40px;
        }

        .sitename {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2D3748;
            margin: 0;
        }

        .navmenu {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .navmenu ul {
            display: flex;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 0.25rem;
        }

        .navmenu a {
            color: #2D3748;
            font-weight: 500;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            white-space: nowrap;
        }

        .navmenu a:hover,
        .navmenu a.active {
            color: #3B82F6;
            background: #EFF6FF;
        }

        .navmenu .dropdown {
            position: relative;
        }

        .navmenu .dropdown>a i {
            font-size: 0.75rem;
            transition: transform 0.2s;
        }

        .navmenu .dropdown:hover>a i {
            transform: rotate(180deg);
        }

        .navmenu .dropdown ul {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: #FFFFFF;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-top: 0.5rem;
            padding: 0.5rem;
            border-radius: 0.75rem;
            min-width: 200px;
            z-index: 100;
            border: 1px solid #E2E8F0;
            flex-direction: column;
        }

        .navmenu .dropdown:hover ul {
            display: flex;
        }

        .navmenu .dropdown ul li {
            width: 100%;
        }

        .navmenu .dropdown ul li a {
            padding: 0.6rem 1rem;
            color: #4A5568;
            font-weight: 400;
        }

        .navmenu .dropdown ul li a:hover {
            background: #EFF6FF;
            color: #3B82F6;
        }

        .header-actions {
            flex-shrink: 0;
        }

        .btn-login {
            background: #3B82F6;
            color: #FFFFFF;
            padding: 0.6rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-block;
        }

        .btn-login:hover {
            background: #2563EB;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        /* User Dropdown */
        .user-dropdown {
            position: relative;
        }

        .user-btn {
            background: #3B82F6;
            color: #FFFFFF;
            border: none;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            transition: all 0.2s;
            font-weight: 500;
        }

        .user-btn:hover {
            background: #2563EB;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid #FFFFFF;
            object-fit: cover;
        }

        .user-name {
            font-size: 0.9rem;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .user-btn i {
            font-size: 0.75rem;
            transition: transform 0.2s;
        }

        .user-dropdown.active .user-btn i {
            transform: rotate(180deg);
        }

        .user-dropdown-menu {
            display: none;
            position: absolute;
            top: calc(100% + 0.5rem);
            right: 0;
            background: #FFFFFF;
            border-radius: 0.75rem;
            border: 1px solid #E2E8F0;
            padding: 0.5rem;
            min-width: 240px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            z-index: 100;
            list-style: none;
            margin: 0;
        }

        .user-dropdown.active .user-dropdown-menu {
            display: block;
            animation: fadeInDown 0.2s ease;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .user-dropdown-menu li a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #4A5568;
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.2s;
            font-size: 0.9rem;
        }

        .user-dropdown-menu li a:hover {
            background: #EFF6FF;
            color: #3B82F6;
        }

        .user-dropdown-menu li a i {
            font-size: 1.1rem;
            width: 20px;
        }

        .user-dropdown-menu .divider {
            height: 1px;
            background: #E2E8F0;
            margin: 0.5rem 0;
        }

        .user-dropdown-menu .logout-btn {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #EF4444;
            background: transparent;
            border: none;
            border-radius: 0.5rem;
            transition: all 0.2s;
            font-size: 0.9rem;
            cursor: pointer;
            font-weight: 500;
            text-align: left;
        }

        .user-dropdown-menu .logout-btn:hover {
            background: #FEF2F2;
            color: #DC2626;
        }

        .user-dropdown-menu .logout-btn i {
            font-size: 1.1rem;
            width: 20px;
        }

        /* Search Section */
        .search-section {
            background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%);
            padding: 2.5rem 0;
        }

        .search-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .search-box {
            background: #FFFFFF;
            border-radius: 0.75rem;
            padding: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 1rem;
            align-items: center;
        }

        .search-input-wrapper {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex: 1;
        }

        .search-input {
            flex: 1;
            border: none;
            outline: none;
            font-size: 0.95rem;
            color: #2D3748;
            padding: 0.5rem;
        }

        .search-input::placeholder {
            color: #A0AEC0;
        }

        .location-select {
            border: none;
            outline: none;
            font-size: 0.9rem;
            color: #2D3748;
            padding: 0.5rem;
            background: #F7FAFC;
            border-radius: 0.375rem;
            cursor: pointer;
        }

        .search-btn {
            background: #3B82F6;
            color: #FFFFFF;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 2rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .search-btn:hover {
            background: #2563EB;
        }

        /* Filter Section */
        .filter-section {
            background: #FFFFFF;
            border-bottom: 1px solid #E2E8F0;
            padding: 1rem 0;
        }

        .filter-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            gap: 0.75rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-btn {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            color: #4A5568;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-btn:hover {
            border-color: #3B82F6;
            color: #3B82F6;
        }

        .filter-btn.active {
            background: #EFF6FF;
            border-color: #3B82F6;
            color: #3B82F6;
        }

        .all-filters-btn {
            background: #3B82F6;
            color: #FFFFFF;
            border: none;
        }

        .all-filters-btn:hover {
            background: #2563EB;
        }

        /* Main Container */
        .main-container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding: 0 0.5rem;
        }

        .results-count {
            font-size: 0.95rem;
            color: #718096;
        }

        .view-controls {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .sort-select {
            border: 1px solid #E2E8F0;
            border-radius: 0.375rem;
            padding: 0.4rem 0.75rem;
            font-size: 0.85rem;
            color: #4A5568;
            cursor: pointer;
            outline: none;
        }

        /* Grid View - Default */
        .grid-view {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
            animation: fadeIn 0.3s ease;
        }

        /* Job Card Grid - UPDATED */
        .job-card-grid {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 0.75rem;
            padding: 1.25rem;
            transition: all 0.3s;
            cursor: pointer;
            height: 100%;
            display: flex;
            flex-direction: column;
            min-height: 380px;
            /* ✅ Đặt chiều cao tối thiểu cố định */
        }

        .job-card-grid:hover {
            border-color: #3B82F6;
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.15);
            transform: translateY(-4px);
        }

        .job-card-grid-header {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1rem;
            min-height: 72px;
            /* ✅ Chiều cao cố định cho header */
        }

        .company-logo-grid {
            width: 56px;
            height: 56px;
            border-radius: 0.5rem;
            overflow: hidden;
            flex-shrink: 0;
            background: #F7FAFC;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #E2E8F0;
        }

        .company-logo-grid img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .job-card-grid-info {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        .job-card-grid-title {
            font-size: 1.05rem;
            font-weight: 600;
            color: #2D3748;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* ✅ Giới hạn 2 dòng */
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
            min-height: 2.8rem;
            /* ✅ Chiều cao cố định cho 2 dòng */
        }

        .job-card-grid:hover .job-card-grid-title {
            color: #3B82F6;
        }

        .company-name-grid {
            font-size: 0.9rem;
            color: #718096;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            /* ✅ Giới hạn 1 dòng */
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 1.35rem;
            /* ✅ Chiều cao cố định */
        }

        /* ✅ Salary Section - Chiều cao cố định */
        .job-card-grid-salary-section {
            margin-bottom: 1rem;
            min-height: 32px;
            display: flex;
            align-items: center;
        }

        .job-card-grid-salary {
            display: inline-block;
            background: linear-gradient(135deg, #10B981, #059669);
            color: #FFFFFF;
            padding: 0.4rem 0.85rem;
            border-radius: 0.375rem;
            font-size: 0.85rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .job-card-grid-salary.negotiable {
            background: linear-gradient(135deg, #6B7280, #4B5563);
        }

        /* ✅ Meta Section - Chiều cao cố định */
        /* ✅ Meta Section - Hiển thị ngang hàng */
        .job-card-grid-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem 1rem;
            /* gap dọc 0.75rem, gap ngang 1rem */
            padding: 1rem 0;
            border-top: 1px solid #F1F5F9;
            border-bottom: 1px solid #F1F5F9;
            font-size: 0.85rem;
            color: #718096;
            min-height: 70px;
            /* ✅ Giảm chiều cao */
            align-items: flex-start;
        }

        .job-card-grid-meta-item {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            flex: 0 0 auto;
            /* ✅ Không co giãn */
            white-space: nowrap;
        }

        .job-card-grid-meta-item i {
            color: #3B82F6;
            width: 16px;
            flex-shrink: 0;
            font-size: 0.95rem;
        }

        .job-card-grid-meta-item span {
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 120px;
            /* ✅ Giới hạn độ dài text */
        }

        /* ✅ Tags Section - Chiều cao cố định */
        /* ✅ Tags Section */
        .job-card-grid-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.75rem;
            min-height: 60px;
            max-height: 60px;
            overflow: hidden;
            align-items: flex-start;
            align-content: flex-start;
            /* ✅ Căn từ trên xuống */
        }

        .job-card-grid-tag {
            background: #EFF6FF;
            color: #3B82F6;
            padding: 0.35rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 500;
            white-space: nowrap;
            line-height: 1.2;
            flex: 0 0 auto;
            /* ✅ Không co giãn */
        }

        .job-card-grid-tags-empty {
            color: #CBD5E0;
            font-size: 0.75rem;
            font-style: italic;
            display: flex;
            align-items: center;
            width: 100%;
            height: 100%;
            justify-content: center;
        }

        /* ✅ Footer - Luôn ở dưới cùng */
        .job-card-grid-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 0.75rem;
        }

        .job-card-grid-deadline {
            font-size: 0.8rem;
            color: #EF4444;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-weight: 500;
        }

        .save-btn-grid {
            background: transparent;
            border: none;
            color: #CBD5E0;
            cursor: pointer;
            padding: 0.25rem;
            transition: all 0.2s;
            font-size: 1.3rem;
        }

        .save-btn-grid:hover {
            color: #EF4444;
            transform: scale(1.15);
        }

        .save-btn-grid.saved {
            color: #EF4444;
        }

        /* ✅ Empty State cho Tags */
        .job-card-grid-tags-empty {
            color: #CBD5E0;
            font-size: 0.75rem;
            font-style: italic;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        /* Detail View - 2 Columns */
        .detail-view {
            display: none;
            grid-template-columns: 450px 1fr;
            gap: 1.5rem;
            align-items: start;
            animation: fadeIn 0.3s ease;
        }

        .detail-view.active {
            display: grid;
        }

        /* Back Button */
        .back-to-grid {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #3B82F6;
            font-weight: 600;
            cursor: pointer;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
            margin-bottom: 1rem;
            background: #EFF6FF;
            border: none;
        }

        .back-to-grid:hover {
            background: #DBEAFE;
            transform: translateX(-4px);
        }

        /* Left Column - Job List */
        .job-list-column {
            height: calc(100vh - 250px);
            overflow-y: auto;
            padding-right: 0.5rem;
        }

        .job-list-column::-webkit-scrollbar {
            width: 6px;
        }

        .job-list-column::-webkit-scrollbar-track {
            background: #F1F5F9;
            border-radius: 10px;
        }

        .job-list-column::-webkit-scrollbar-thumb {
            background: #CBD5E0;
            border-radius: 10px;
        }

        .job-list-column::-webkit-scrollbar-thumb:hover {
            background: #A0AEC0;
        }

        /* Job Card Compact */
        .job-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 1rem;
            transition: all 0.2s;
            cursor: pointer;
        }

        .job-card:hover,
        .job-card.active {
            border-color: #3B82F6;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        }

        .job-card.active {
            background: #F0F9FF;
        }

        .job-card-header {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .company-logo-small {
            width: 48px;
            height: 48px;
            border-radius: 0.5rem;
            overflow: hidden;
            flex-shrink: 0;
            background: #F7FAFC;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .company-logo-small img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .job-card-info {
            flex: 1;
            min-width: 0;
        }

        .job-card-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #2D3748;
            margin-bottom: 0.25rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .job-card:hover .job-card-title {
            color: #3B82F6;
        }

        .company-name-small {
            font-size: 0.85rem;
            color: #718096;
            margin-bottom: 0.5rem;
        }

        .job-card-salary {
            display: inline-block;
            background: #10B981;
            color: #FFFFFF;
            padding: 0.2rem 0.6rem;
            border-radius: 0.25rem;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .job-card-salary.negotiable {
            background: #6B7280;
        }

        .job-card-meta {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-top: 0.5rem;
            font-size: 0.8rem;
            color: #718096;
        }

        .job-card-meta-item {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .job-card-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
            margin-top: 0.75rem;
        }

        .job-card-tag {
            background: #EFF6FF;
            color: #3B82F6;
            padding: 0.25rem 0.6rem;
            border-radius: 0.3rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .job-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0.75rem;
            padding-top: 0.75rem;
            border-top: 1px solid #F1F5F9;
        }

        .job-card-deadline {
            font-size: 0.75rem;
            color: #EF4444;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .save-btn-small {
            background: transparent;
            border: none;
            color: #CBD5E0;
            cursor: pointer;
            padding: 0.25rem;
            transition: all 0.2s;
        }

        .save-btn-small:hover {
            color: #EF4444;
        }

        .save-btn-small.saved {
            color: #EF4444;
        }

        /* Right Column - Job Detail */
        .job-detail-column {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 0.75rem;
            height: calc(100vh - 250px);
            overflow-y: auto;
            position: sticky;
            top: 90px;
        }

        .job-detail-column::-webkit-scrollbar {
            width: 6px;
        }

        .job-detail-column::-webkit-scrollbar-track {
            background: #F1F5F9;
            border-radius: 10px;
        }

        .job-detail-column::-webkit-scrollbar-thumb {
            background: #CBD5E0;
            border-radius: 10px;
        }

        .job-detail-column::-webkit-scrollbar-thumb:hover {
            background: #A0AEC0;
        }

        .job-detail-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #A0AEC0;
            padding: 2rem;
            text-align: center;
        }

        .job-detail-empty i {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .job-detail-header {
            padding: 1.5rem;
            border-bottom: 1px solid #E2E8F0;
        }

        .job-detail-company {
            display: flex;
            gap: 1rem;
            align-items: start;
            margin-bottom: 1.5rem;
        }

        .company-logo-large {
            width: 80px;
            height: 80px;
            border-radius: 0.75rem;
            overflow: hidden;
            flex-shrink: 0;
            background: #F7FAFC;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #E2E8F0;
        }

        .company-logo-large img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .job-detail-title-section {
            flex: 1;
        }

        .job-detail-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2D3748;
            margin-bottom: 0.5rem;
        }

        .job-detail-company-name {
            font-size: 1.1rem;
            color: #3B82F6;
            font-weight: 500;
            margin-bottom: 0.75rem;
        }

        .job-detail-salary {
            display: inline-block;
            background: #10B981;
            color: #FFFFFF;
            padding: 0.4rem 1rem;
            border-radius: 0.375rem;
            font-size: 1rem;
            font-weight: 600;
        }

        .job-detail-salary.negotiable {
            background: #6B7280;
        }

        .job-detail-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        .btn-apply-now,
        .apply-btn-large {
            flex: 1;
            background: linear-gradient(135deg, #00c853, #00e676);
            color: #FFFFFF;
            border: none;
            border-radius: 0.5rem;
            padding: 0.875rem 1.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1rem;
            box-shadow: 0 4px 15px rgba(0, 200, 83, 0.3);
        }

        .btn-apply-now:hover,
        .apply-btn-large:hover {
            background: linear-gradient(135deg, #00e676, #00c853);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 200, 83, 0.4);
        }

        .save-btn-large {
            background: #FFFFFF;
            border: 2px solid #E2E8F0;
            color: #718096;
            cursor: pointer;
            padding: 0.875rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }

        .save-btn-large:hover {
            border-color: #EF4444;
            color: #EF4444;
        }

        .save-btn-large.saved {
            border-color: #EF4444;
            color: #EF4444;
            background: #FEF2F2;
        }

        .job-detail-content {
            padding: 1.5rem;
        }

        .detail-section {
            margin-bottom: 2rem;
        }

        .detail-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2D3748;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .detail-section-title i {
            color: #3B82F6;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .info-label {
            font-size: 0.85rem;
            color: #718096;
            font-weight: 500;
        }

        .info-value {
            font-size: 0.95rem;
            color: #2D3748;
            font-weight: 500;
        }

        .job-description {
            line-height: 1.8;
            color: #4A5568;
        }

        .job-description ul,
        .job-description ol {
            margin-left: 1.5rem;
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .job-description li {
            margin-bottom: 0.5rem;
        }

        .job-description h4 {
            font-size: 1rem;
            font-weight: 600;
            color: #2D3748;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }

        .tags-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .tag-item {
            background: #EFF6FF;
            color: #3B82F6;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Hidden State */
        .hidden {
            display: none !important;
        }

        /* Modal Styling */
        .modal-apply-job .modal-dialog {
            max-height: 90vh;
            margin: 1.75rem auto;
        }

        .modal-apply-job .modal-content {
            border-radius: 24px;
            border: none;
            overflow: hidden;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
        }

        .modal-apply-job .modal-header {
            background: linear-gradient(135deg, #4f46e5, #06b6d4);
            color: white;
            border: none;
            padding: 1.5rem;
            flex-shrink: 0;
        }

        .modal-apply-job .modal-title {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .modal-apply-job .btn-close {
            filter: brightness(0) invert(1);
        }

        .modal-apply-job .modal-body {
            overflow-y: auto;
            max-height: calc(90vh - 180px);
            flex: 1;
        }

        .modal-apply-job .modal-body::-webkit-scrollbar {
            width: 8px;
        }

        .modal-apply-job .modal-body::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .modal-apply-job .modal-body::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .modal-apply-job .modal-body::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .modal-apply-job .modal-footer {
            flex-shrink: 0;
            border-top: 1px solid #e5e7eb;
        }

        /* CV Options */
        .cv-option-card {
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            padding: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .cv-option-card:hover {
            border-color: #4f46e5;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.1);
            transform: translateY(-2px);
        }

        .cv-option-card.active {
            border-color: #4f46e5;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(6, 182, 212, 0.05));
        }

        .cv-option-card input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .cv-option-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #4f46e5, #06b6d4);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .cv-option-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .cv-option-desc {
            color: #6b7280;
            font-size: 0.9rem;
        }

        /* Upload Area */
        .upload-area {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            background: #f8fafc;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .upload-area:hover {
            border-color: #4f46e5;
            background: #f0f9ff;
        }

        .upload-area.dragover {
            border-color: #4f46e5;
            background: #eff6ff;
        }

        .upload-icon {
            font-size: 3rem;
            color: #94a3b8;
            margin-bottom: 1rem;
        }

        /* Form Controls */
        .form-control,
        .form-select {
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .required-mark {
            color: #ef4444;
        }

        /* Profile Preview Card */
        .profile-preview-card {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-radius: 16px;
            padding: 1.5rem;
            border: 2px solid #e5e7eb;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .profile-info {
            margin-left: 1rem;
        }

        .profile-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        .profile-title {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .profile-contact {
            display: flex;
            gap: 1rem;
            margin-top: 0.75rem;
            flex-wrap: wrap;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #4b5563;
            font-size: 0.85rem;
        }

        .contact-item i {
            color: #4f46e5;
        }

        /* Letter Section */
        .letter-textarea {
            min-height: 150px;
            resize: vertical;
        }

        .char-count {
            text-align: right;
            color: #9ca3af;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        /* Buttons */
        .btn-submit-apply {
            background: linear-gradient(135deg, #4f46e5, #06b6d4);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-submit-apply:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.3);
        }

        .btn-cancel {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            border-color: #cbd5e1;
            background: #f9fafb;
        }

        /* Animation */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .content-section {
            animation: slideInUp 0.4s ease-out;
        }

        /* Footer */
        .footer {
            background: #FFFFFF;
            border-top: 1px solid #E2E8F0;
            padding: 2rem 0;
            margin-top: 3rem;
        }

        .footer a {
            color: #718096;
            transition: color 0.2s;
            text-decoration: none;
        }

        .footer a:hover {
            color: #2D3748;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .grid-view {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }

            .detail-view {
                grid-template-columns: 400px 1fr;
            }
        }

        @media (max-width: 992px) {
            .grid-view {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 1rem;
            }

            .detail-view {
                grid-template-columns: 1fr;
            }

            .job-detail-column {
                position: static;
                height: auto;
            }
        }

        @media (max-width: 768px) {
            .grid-view {
                grid-template-columns: 1fr;
            }

            .search-box {
                grid-template-columns: 1fr;
            }

            .search-input-wrapper {
                flex-direction: column;
                align-items: stretch;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .filter-container {
                overflow-x: auto;
                flex-wrap: nowrap;
            }
        }
    </style>
</head>

<body>
    <header id="header" class="header">
        <div class="header-container">
            <a href="#" class="logo">
                <img src="https://cdn-icons-png.flaticon.com/512/3281/3281289.png" alt="">
                <h1 class="sitename">Job-IT</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#" class="active">Trang chủ</a></li>
                    <li class="dropdown">
                        <a href="#"><span>Việc làm</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="#">Theo khu vực</a></li>
                            <li><a href="#">Theo lĩnh vực</a></li>
                            <li><a href="#">Theo kỹ năng</a></li>
                            <li><a href="#">Theo từ khóa</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#"><span>Công ty</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="#">Theo khu vực</a></li>
                            <li><a href="#">Theo lĩnh vực</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#"><span>Blog</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="#">Cẩm nang tìm việc</a></li>
                            <li><a href="#">Kỹ năng văn phòng</a></li>
                            <li><a href="#">Kiến thức chuyên ngành</a></li>
                            <li><a href="#">Tin tức tổng hợp</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <div class="header-actions">
                @if(!Auth::check())
                <a class="btn-login" href="{{ route('login') }}">Đăng nhập</a>
                @else
                <div class="user-dropdown">
                    <button class="user-btn" id="userDropdownBtn">
                        <img src="{{ asset('assets/img/user.png') }}" alt="" class="user-avatar">
                        <span class="user-name">{{ Auth::user()->applicant->hoten_uv ?? Auth::user()->email }}</span>
                        <i class="bi bi-chevron-down"></i>
                    </button>
                    <ul class="user-dropdown-menu" id="userDropdownMenu">
                        <li><a href="{{ route('applicant.profile') }}"><i class="bi bi-person"></i> Hồ sơ</a></li>
                        <li><a href="#"><i class="bi bi-info-circle"></i> Thông tin cá nhân</a></li>
                        <li><a href="#"><i class="bi bi-file-earmark-text"></i> Hồ sơ Đính kèm</a></li>
                        <li><a href="{{ route('applicant.myJobs') }}"><i class="bi bi-briefcase"></i> Việc làm của tôi</a></li>
                        <li><a href="#"><i class="bi bi-envelope"></i> Lời mời công việc</a></li>
                        <li><a href="#"><i class="bi bi-bell"></i> Thông báo</a></li>
                        <li class="divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="logout-btn">
                                    <i class="bi bi-box-arrow-right"></i> Đăng xuất
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </header>

    <!-- Search Section -->
    <section class="search-section">
        <div class="search-container">
            <div class="search-box">
                <div class="search-input-wrapper">
                    <i class="bi bi-search" style="color: #A0AEC0; font-size: 1.2rem;"></i>
                    <input type="text" class="search-input" placeholder="Tìm theo kỹ năng, vị trí, công ty...">
                    <i class="bi bi-geo-alt" style="color: #A0AEC0; font-size: 1.2rem;"></i>
                    <select class="location-select">
                        <option value="">Địa Điểm</option>
                        <option value="HCM">Hồ Chí Minh</option>
                        <option value="HN">Hà Nội</option>
                        <option value="DN">Đà Nẵng</option>
                        <option value="Remote">Remote</option>
                    </select>
                </div>
                <button class="search-btn">Tìm kiếm</button>
            </div>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="filter-section">
        <div class="filter-container">
            <button class="filter-btn">
                <i class="bi bi-folder"></i>
                Tất cả danh mục (1)
            </button>
            <button class="filter-btn">
                <i class="bi bi-bar-chart"></i>
                Cấp bậc
            </button>
            <button class="filter-btn">
                <i class="bi bi-gift"></i>
                Phúc lợi
            </button>
            <button class="filter-btn">
                <i class="bi bi-briefcase"></i>
                Hình thức làm việc
            </button>
            <button class="filter-btn all-filters-btn">
                <i class="bi bi-sliders"></i>
                Tất cả bộ lọc
            </button>
        </div>
    </section>

    <!-- Main Container -->
    <div class="main-container">
        <div class="results-header">
            <div class="results-count">
                <strong id="jobCountDisplay">{{ isset($jobs) ? $jobs->count() : 0 }}</strong> kết quả
            </div>
            <div class="view-controls">
                <select class="sort-select">
                    <option>Lương (Cao - Thấp)</option>
                    <option>Ngày Đăng (Mới nhất)</option>
                    <option>Ngày Đăng (Cũ nhất)</option>
                </select>
            </div>
        </div>

        <!-- Grid View - Default -->
        <!-- Grid View - Default -->
        <div class="grid-view" id="gridView">
            @foreach($jobs as $job)
            <article class="job-card-grid" data-job-id="{{ $job->job_id }}">
                <!-- Header -->
                <div class="job-card-grid-header">
                    <div class="company-logo-grid">
                        @if($job->company && $job->company->logo)
                        <img src="{{ asset('assets/img/' . $job->company->logo) }}" alt="Company Logo" />
                        @else
                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667EEA, #764BA2); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: bold;">
                            {{ substr($job->company->tencty ?? 'C', 0, 1) }}
                        </div>
                        @endif
                    </div>
                    <div class="job-card-grid-info">
                        <h3 class="job-card-grid-title" title="{{ $job->title }}">{{ $job->title }}</h3>
                        <div class="company-name-grid" title="{{ $job->company->tencty ?? 'Công ty' }}">
                            {{ $job->company->tencty ?? 'Công ty' }}
                        </div>
                    </div>
                </div>

                <!-- Salary -->
                <div class="job-card-grid-salary-section">
                    <span class="job-card-grid-salary {{ (!$job->salary_min || !$job->salary_max) ? 'negotiable' : '' }}">
                        @if($job->salary_min && $job->salary_max)
                        {{ number_format($job->salary_min, 0, ',', '.') }} - {{ number_format($job->salary_max, 0, ',', '.') }} {{ strtoupper($job->salary_type) }}
                        @else
                        Thỏa thuận
                        @endif
                    </span>
                </div>

                <!-- Meta Info - ✅ Hiển thị ngang hàng -->
                <div class="job-card-grid-meta">
                    <div class="job-card-grid-meta-item" title="{{ $job->province }}">
                        <i class="bi bi-geo-alt-fill"></i>
                        <span>{{ $job->province }}</span>
                    </div>
                    <div class="job-card-grid-meta-item" title="{{ ucfirst($job->level) }}">
                        <i class="bi bi-briefcase-fill"></i>
                        <span>{{ ucfirst($job->level) }}</span>
                    </div>
                    <div class="job-card-grid-meta-item" title="{{ $job->experience }}">
                        <i class="bi bi-award-fill"></i>
                        <span>{{ $job->experience }}</span>
                    </div>
                </div>

                <!-- Hashtags - ✅ Hiển thị hashtags từ database -->
                <div class="job-card-grid-tags">
                    @if($job->hashtags && $job->hashtags->count() > 0)
                    @foreach($job->hashtags->take(4) as $tag)
                    <span class="job-card-grid-tag">#{{ $tag->tag_name }}</span>
                    @endforeach
                    @else
                    <span class="job-card-grid-tags-empty">Chưa có kỹ năng</span>
                    @endif
                </div>

                <!-- Footer -->
                <div class="job-card-grid-footer">
                    <div class="job-card-grid-deadline">
                        <i class="bi bi-clock-history"></i>
                        Hạn nộp: {{ \Carbon\Carbon::parse($job->deadline)->format('d/m/Y') }}
                    </div>
                    <button class="save-btn-grid" title="Lưu công việc">
                        <i class="bi bi-heart"></i>
                    </button>
                </div>
            </article>
            @endforeach
        </div>

        <!-- Detail View - 2 Columns -->
        <div class="detail-view" id="detailView">
            <div>
                <button class="back-to-grid" id="backToGrid">
                    <i class="bi bi-arrow-left"></i>
                    Quay lại danh sách
                </button>

                <!-- Left Column - Job List -->
                <div class="job-list-column" id="jobListColumn">
                    @foreach($jobs as $job)
                    <article class="job-card" data-job-id="{{ $job->job_id }}">
                        <div class="job-card-header">
                            <div class="company-logo-small">
                                @if($job->company && $job->company->logo)
                                <img src="{{ asset('assets/img/' . $job->company->logo) }}" alt="Company Logo" />
                                @else
                                <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667EEA, #764BA2); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                    {{ substr($job->company->tencty ?? 'C', 0, 1) }}
                                </div>
                                @endif
                            </div>

                            <div class="job-card-info">
                                <h3 class="job-card-title">{{ $job->title }}</h3>
                                <div class="company-name-small">{{ $job->company->tencty ?? 'Công ty' }}</div>
                                <span class="job-card-salary {{ (!$job->salary_min || !$job->salary_max) ? 'negotiable' : '' }}">
                                    @if($job->salary_min && $job->salary_max)
                                    {{ number_format($job->salary_min, 0, ',', '.') }} - {{ number_format($job->salary_max, 0, ',', '.') }} {{ strtoupper($job->salary_type) }}
                                    @else
                                    Thỏa thuận
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="job-card-meta">
                            <div class="job-card-meta-item">
                                <i class="bi bi-geo-alt"></i>
                                {{ $job->province }}
                            </div>
                            <div class="job-card-meta-item">
                                <i class="bi bi-briefcase"></i>
                                {{ ucfirst($job->level) }}
                            </div>
                            <div class="job-card-meta-item">
                                <i class="bi bi-award"></i>
                                {{ $job->experience }}
                            </div>
                        </div>

                        @if($job->hashtags && $job->hashtags->count() > 0)
                        <div class="job-card-tags">
                            @foreach($job->hashtags->take(3) as $tag)
                            <span class="job-card-tag">{{ $tag->tag_name }}</span>
                            @endforeach
                        </div>
                        @endif

                        <div class="job-card-footer">
                            <div class="job-card-deadline">
                                <i class="bi bi-clock-history"></i>
                                Hạn nộp: {{ \Carbon\Carbon::parse($job->deadline)->format('d/m/Y') }}
                            </div>
                            <button class="save-btn-small" title="Lưu công việc">
                                <i class="bi bi-heart" style="font-size: 1.1rem;"></i>
                            </button>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>

            <!-- Right Column - Job Detail -->
            <div class="job-detail-column" id="jobDetailColumn">
                <div class="job-detail-empty">
                    <i class="bi bi-briefcase"></i>
                    <p>Chọn một công việc để xem chi tiết</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ứng Tuyển -->
    <div class="modal fade modal-apply-job" id="applyJobModal" tabindex="-1" aria-labelledby="applyJobModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applyJobModalLabel">
                        <i class="bi bi-send-fill me-2"></i>Ứng tuyển công việc
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="applyJobForm" action="{{ route('application.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <!-- Step 1: Chọn cách ứng tuyển -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-file-earmark-person me-2 text-primary"></i>Chọn CV Để ứng tuyển <span class="required-mark">*</span>
                            </h6>
                            <div class="row g-3">
                                <!-- Option 1: Upload CV -->
                                <div class="col-md-6">
                                    <label class="cv-option-card active" id="uploadOption">
                                        <input type="radio" name="cv_type" value="upload" checked>
                                        <div class="cv-option-icon">
                                            <i class="bi bi-cloud-upload"></i>
                                        </div>
                                        <div class="cv-option-title">Tải lên CV từ máy tính</div>
                                        <div class="cv-option-desc">Hỗ trợ định dạng .doc, .docx, .pdf dưới 5MB</div>
                                    </label>
                                </div>

                                <!-- Option 2: Use Profile -->
                                <div class="col-md-6">
                                    <label class="cv-option-card" id="profileOption">
                                        <input type="radio" name="cv_type" value="profile">
                                        <div class="cv-option-icon">
                                            <i class="bi bi-person-badge"></i>
                                        </div>
                                        <div class="cv-option-title">Sử dụng hồ sơ có sẵn</div>
                                        <div class="cv-option-desc">Dùng thông tin từ hồ sơ đã tạo trên hệ thống</div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Upload CV Section -->
                        <div id="uploadSection" class="content-section mb-4">
                            <div class="upload-area" id="uploadArea">
                                <div class="upload-icon">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Kéo thả CV vào đây hoặc chọn file</h6>
                                <p class="text-muted small mb-3">Hỗ trợ .doc, .docx, .pdf (tối đa 5MB)</p>
                                <input type="file" id="cvFileInput" name="cv_file" accept=".doc,.docx,.pdf" class="d-none">
                                <button type="button" class="btn btn-outline-primary" id="selectFileBtn">
                                    <i class="bi bi-folder2-open me-2"></i>Chọn file
                                </button>
                            </div>
                            <div id="fileNameDisplay" class="mt-3 text-center" style="display: none;">
                                <div class="alert alert-success d-inline-flex align-items-center">
                                    <i class="bi bi-file-earmark-check me-2"></i>
                                    <span id="fileName"></span>
                                    <button type="button" class="btn-close ms-3" id="removeFile"></button>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Preview Section -->
                        <div id="profileSection" class="content-section mb-4" style="display: none;">
                            <div class="profile-preview-card">
                                <div class="d-flex align-items-start">
                                    @php
                                    $applicant = Auth::user()->applicant ?? null;
                                    @endphp
                                    <img src="{{ $applicant && $applicant->avatar ? asset('assets/img/avt/'.$applicant->avatar) : asset('assets/img/avt/default-avatar.png') }}"
                                        alt="Avatar" class="profile-avatar">
                                    <div class="profile-info flex-grow-1">
                                        <div class="profile-name">{{ $applicant->hoten_uv ?? 'Họ tên ứng viên' }}</div>
                                        <div class="profile-title">{{ $applicant->chucdanh ?? 'Chức danh' }}</div>
                                        <div class="profile-contact">
                                            <div class="contact-item">
                                                <i class="bi bi-envelope"></i>
                                                <span>{{ Auth::user()->email ?? 'Email' }}</span>
                                            </div>
                                            <div class="contact-item">
                                                <i class="bi bi-telephone"></i>
                                                <span>{{ $applicant->sdt_uv ?? 'Chưa cập nhật' }}</span>
                                            </div>
                                            <div class="contact-item">
                                                <i class="bi bi-geo-alt"></i>
                                                <span>{{ $applicant->diachi_uv ?? 'Chưa cập nhật' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('applicant.hoso') }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                            <i class="bi bi-pencil me-1"></i>Chỉnh sửa
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Thông tin bổ sung -->
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-card-text me-2 text-primary"></i>Thông tin bổ sung
                        </h6>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Họ và tên <span class="required-mark">*</span></label>
                                <input type="text" name="hoten" class="form-control" placeholder="Họ tên hiển thị với NTD"
                                    value="{{ $applicant->hoten_uv ?? '' }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="required-mark">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="Email hiển thị với NTD"
                                    value="{{ Auth::user()->email ?? '' }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Số Điện thoại <span class="required-mark">*</span></label>
                                <input type="tel" name="sdt" class="form-control" placeholder="Số điện thoại hiển thị với NTD"
                                    value="{{ $applicant->sdt_uv ?? '' }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Địa chỉ</label>
                                <input type="text" name="diachi" class="form-control" placeholder="Địa chỉ của bạn"
                                    value="{{ $applicant->diachi_uv ?? '' }}">
                            </div>
                        </div>

                        <!-- Thư giới thiệu -->
                        <div class="mb-4">
                            <label class="form-label d-flex align-items-center gap-2">
                                <i class="bi bi-pencil-square text-success" style="font-size: 1.2rem;"></i>
                                <span style="font-size: 1.05rem; font-weight: 600; color: #1f2937;">Thư giới thiệu:</span>
                            </label>
                            <p class="text-muted mb-3" style="font-size: 0.95rem; line-height: 1.6;">
                                Một thư giới thiệu ngắn gọn, chỉn chu sẽ giúp bạn trở nên chuyên nghiệp và gây ấn tượng hơn với nhà tuyển dụng.
                            </p>
                            <textarea name="thugioithieu" class="form-control letter-textarea" maxlength="2500"
                                placeholder="Viết giới thiệu ngắn gọn về bản thân (Điểm mạnh, điểm yếu) và nêu rõ mong muốn, lý do bạn muốn ứng tuyển cho vị trí này."
                                style="border: 2px solid #10b981; border-radius: 12px;"></textarea>
                            <div class="char-count">
                                <span id="charCount">0</span>/2500 ký tự
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 p-4">
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg me-2"></i>Hủy
                        </button>
                        <button type="submit" class="btn btn-primary btn-submit-apply">
                            <i class="bi bi-send-fill me-2"></i>Nộp hồ sơ ứng tuyển
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div style="max-width: 1400px; margin: 0 auto; padding: 0 1rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <p style="color: #718096;">© 2025 Tìm Việc IT. Giao diện chuyên nghiệp, hiện đại, dễ sử dụng.</p>
            <div style="display: flex; gap: 1.5rem;">
                <a href="#">Điều khoản</a>
                <a href="#">Chính sách</a>
                <a href="#">Liên hệ</a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const gridView = document.getElementById('gridView');
            const detailView = document.getElementById('detailView');
            const backToGridBtn = document.getElementById('backToGrid');
            const jobDetailColumn = document.getElementById('jobDetailColumn');
            const jobListColumn = document.getElementById('jobListColumn');

            // ========== XỬ LÝ USER DROPDOWN ==========
            const userDropdownBtn = document.getElementById('userDropdownBtn');
            const userDropdown = document.querySelector('.user-dropdown');

            if (userDropdownBtn) {
                userDropdownBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userDropdown.classList.toggle('active');
                });

                document.addEventListener('click', function(e) {
                    if (!userDropdown.contains(e.target)) {
                        userDropdown.classList.remove('active');
                    }
                });
            }

            // ========== TOAST NOTIFICATION ==========
            function showToast(message, type = 'success') {
                const oldToast = document.querySelector('.custom-toast');
                if (oldToast) oldToast.remove();

                const toast = document.createElement('div');
                toast.className = 'custom-toast';

                const bgColor = type === 'success' ? '#10b981' :
                    type === 'error' ? '#ef4444' :
                    type === 'info' ? '#3b82f6' : '#6b7280';

                const icon = type === 'success' ? 'bi-check-circle-fill' :
                    type === 'error' ? 'bi-x-circle-fill' :
                    type === 'info' ? 'bi-info-circle-fill' : 'bi-heart-fill';

                toast.style.cssText = `
                position: fixed;
                top: 80px;
                right: 20px;
                background: ${bgColor};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 12px;
                box-shadow: 0 8px 24px rgba(0,0,0,0.25);
                z-index: 9999;
                animation: slideIn 0.3s ease;
                display: flex;
                align-items: center;
                gap: 0.75rem;
                font-weight: 500;
                min-width: 280px;
            `;

                toast.innerHTML = `<i class="bi ${icon}" style="font-size: 1.2rem;"></i><span>${message}</span>`;
                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.style.animation = 'slideOut 0.3s ease';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }

            if (!document.getElementById('toast-animations')) {
                const style = document.createElement('style');
                style.id = 'toast-animations';
                style.textContent = `
                @keyframes slideIn {
                    from { transform: translateX(400px); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
                @keyframes slideOut {
                    from { transform: translateX(0); opacity: 1; }
                    to { transform: translateX(400px); opacity: 0; }
                }
            `;
                document.head.appendChild(style);
            }

            // ========== KIỂM TRA ĐĂNG NHẬP ==========
            function checkAuth() {
                const isLoggedIn = document.querySelector('meta[name="user-authenticated"]');
                return isLoggedIn && isLoggedIn.content === 'true';
            }

            // ========== SWITCH BETWEEN GRID AND DETAIL VIEW ==========
            function showGridView() {
                gridView.classList.remove('hidden');
                detailView.classList.remove('active');
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            function showDetailView(jobId) {
                gridView.classList.add('hidden');
                detailView.classList.add('active');
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });

                setTimeout(() => {
                    document.querySelectorAll('.job-card').forEach(card => {
                        card.classList.remove('active');
                        if (card.getAttribute('data-job-id') == jobId) {
                            card.classList.add('active');
                            card.scrollIntoView({
                                behavior: 'smooth',
                                block: 'nearest'
                            });
                        }
                    });
                    loadJobDetail(jobId);
                }, 0);
            }

            // ========== CLICK ON GRID CARD ==========
            function attachGridCardEvents() {
                document.querySelectorAll('.job-card-grid').forEach(card => {
                    card.addEventListener('click', function(e) {
                        if (e.target.closest('.save-btn-grid')) return;
                        const jobId = this.getAttribute('data-job-id');
                        showDetailView(jobId);
                    });
                });
            }

            // ========== BACK TO GRID BUTTON ==========
            backToGridBtn.addEventListener('click', function() {
                showGridView();
            });

            // ========== CLICK ON LIST CARD ==========
            function attachListCardEvents() {
                document.querySelectorAll('.job-card').forEach(card => {
                    card.addEventListener('click', function(e) {
                        if (e.target.closest('.save-btn-small')) return;
                        document.querySelectorAll('.job-card').forEach(c => c.classList.remove('active'));
                        this.classList.add('active');
                        const jobId = this.getAttribute('data-job-id');
                        loadJobDetail(jobId);
                    });
                });
            }

            // ========== LOAD JOB DETAIL ==========
            function loadJobDetail(jobId) {
                jobDetailColumn.innerHTML = `
                <div class="job-detail-empty">
                    <i class="bi bi-hourglass-split"></i>
                    <p>Đang tải thông tin...</p>
                </div>
            `;

                fetch(`/api/jobs/${jobId}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(job => {
                        renderJobDetail(job);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        jobDetailColumn.innerHTML = `
                        <div class="job-detail-empty">
                            <i class="bi bi-exclamation-circle"></i>
                            <p>Không thể tải thông tin công việc</p>
                        </div>
                    `;
                    });
            }

            // ========== RENDER JOB DETAIL ==========
            function renderJobDetail(job) {
                const formatMoney = (num) => new Intl.NumberFormat('vi-VN').format(num);

                let salaryHtml = '';
                let salaryClass = '';
                if (job.salary_min && job.salary_max) {
                    salaryHtml = `${formatMoney(job.salary_min)} - ${formatMoney(job.salary_max)} ${job.salary_type.toUpperCase()}`;
                } else {
                    salaryHtml = 'Thỏa thuận';
                    salaryClass = 'negotiable';
                }

                const deadline = new Date(job.deadline).toLocaleDateString('vi-VN');

                const logoHtml = job.company && job.company.logo ?
                    `<img src="/assets/img/${job.company.logo}" alt="Company Logo">` :
                    `<div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667EEA, #764BA2); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; font-weight: bold;">${job.company ? job.company.tencty.charAt(0) : 'C'}</div>`;

                const hashtagsHtml = job.hashtags && job.hashtags.length > 0 ?
                    job.hashtags.map(tag => `<span class="tag-item">${tag.tag_name}</span>`).join('') :
                    '<p class="text-muted">Không có thông tin</p>';

                jobDetailColumn.innerHTML = `
                <div class="job-detail-header">
                    <div class="job-detail-company">
                        <div class="company-logo-large">${logoHtml}</div>
                        <div class="job-detail-title-section">
                            <h2 class="job-detail-title">${job.title}</h2>
                            <div class="job-detail-company-name">${job.company ? job.company.tencty : 'Công ty'}</div>
                            <span class="job-detail-salary ${salaryClass}">${salaryHtml}</span>
                        </div>
                    </div>
                    <div class="job-detail-actions">
                        <button type="button" class="btn-apply-now" data-job-id="${job.job_id}">
                            <i class="bi bi-send-fill me-2"></i>Ứng tuyển ngay
                        </button>
                        <button class="save-btn-large" title="Lưu công việc" data-job-id="${job.job_id}">
                            <i class="bi bi-heart" style="font-size: 1.2rem;"></i>
                        </button>
                    </div>
                </div>
                <div class="job-detail-content">
                    <div class="detail-section">
                        <h3 class="detail-section-title"><i class="bi bi-info-circle-fill"></i> Thông tin chung</h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label"><i class="bi bi-briefcase"></i> Cấp bậc</div>
                                <div class="info-value">${job.level}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label"><i class="bi bi-award"></i> Kinh nghiệm</div>
                                <div class="info-value">${job.experience}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label"><i class="bi bi-people"></i> Số lượng tuyển</div>
                                <div class="info-value">${job.recruitment_count || 'Không giới hạn'}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label"><i class="bi bi-clock-history"></i> Hạn nộp hồ sơ</div>
                                <div class="info-value" style="color: #EF4444;">${deadline}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label"><i class="bi bi-laptop"></i> Hình thức làm việc</div>
                                <div class="info-value">${job.working_type}</div>
                            </div>
                            ${job.gender_requirement ? `
                            <div class="info-item">
                                <div class="info-label"><i class="bi bi-gender-ambiguous"></i> Yêu cầu giới tính</div>
                                <div class="info-value">${job.gender_requirement}</div>
                            </div>` : ''}
                        </div>
                    </div>
                    <div class="detail-section">
                        <h3 class="detail-section-title"><i class="bi bi-geo-alt-fill"></i> Địa điểm làm việc</h3>
                        <div class="info-value">${job.province}</div>
                    </div>
                    ${job.description ? `
                    <div class="detail-section">
                        <h3 class="detail-section-title"><i class="bi bi-file-text-fill"></i> Mô tả công việc</h3>
                        <div class="job-description">${job.description.replace(/\n/g, '<br>')}</div>
                    </div>` : ''}
                    ${job.responsibilities ? `
                    <div class="detail-section">
                        <h3 class="detail-section-title"><i class="bi bi-card-checklist"></i> Trách nhiệm công việc</h3>
                        <div class="job-description">${job.responsibilities.replace(/\n/g, '<br>')}</div>
                    </div>` : ''}
                    ${job.requirements ? `
                    <div class="detail-section">
                        <h3 class="detail-section-title"><i class="bi bi-list-check"></i> Yêu cầu ứng viên</h3>
                        <div class="job-description">${job.requirements.replace(/\n/g, '<br>')}</div>
                    </div>` : ''}
                    ${job.benefits ? `
                    <div class="detail-section">
                        <h3 class="detail-section-title"><i class="bi bi-gift-fill"></i> Quyền lợi</h3>
                        <div class="job-description">${job.benefits.replace(/\n/g, '<br>')}</div>
                    </div>` : ''}
                    ${job.hashtags && job.hashtags.length > 0 ? `
                    <div class="detail-section">
                        <h3 class="detail-section-title"><i class="bi bi-code-slash"></i> Kỹ năng yêu cầu</h3>
                        <div class="tags-list">${hashtagsHtml}</div>
                    </div>` : ''}
                </div>
            `;

                jobDetailColumn.scrollTop = 0;
                attachDetailButtons();
            }

            // ========== ATTACH DETAIL BUTTONS ==========
            function attachDetailButtons() {
                const saveBtnLarge = document.querySelector('.save-btn-large');
                const applyBtn = document.querySelector('.btn-apply-now');

                if (saveBtnLarge) {
                    saveBtnLarge.addEventListener('click', function(e) {
                        e.stopPropagation();
                        const jobId = this.getAttribute('data-job-id');
                        const isSaved = this.classList.contains('saved');
                        handleSaveJob(jobId, isSaved, this);
                    });
                }

                if (applyBtn) {
                    applyBtn.addEventListener('click', function() {
                        if (!checkAuth()) {
                            showToast('Vui lòng đăng nhập để ứng tuyển!', 'error');
                            setTimeout(() => window.location.href = '/login', 1500);
                            return;
                        }
                        const modal = document.getElementById('applyJobModal');
                        if (modal) {
                            const bsModal = new bootstrap.Modal(modal);
                            bsModal.show();
                        }
                    });
                }
            }

            // ========== CẬP NHẬT TRẠNG THÁI NÚT SAVE ==========
            function updateSaveButton(button, isSaved) {
                const icon = button.querySelector('i');
                if (isSaved) {
                    button.classList.add('saved');
                    if (icon) {
                        icon.classList.remove('bi-heart');
                        icon.classList.add('bi-heart-fill');
                    }
                } else {
                    button.classList.remove('saved');
                    if (icon) {
                        icon.classList.remove('bi-heart-fill');
                        icon.classList.add('bi-heart');
                    }
                }
            }

            // ========== ĐỒNG BỘ NÚT SAVE ==========
            function syncSaveButtons(jobId, isSaved) {
                const gridCard = document.querySelector(`.job-card-grid[data-job-id="${jobId}"]`);
                if (gridCard) {
                    const gridBtn = gridCard.querySelector('.save-btn-grid');
                    if (gridBtn) updateSaveButton(gridBtn, isSaved);
                }

                const listCard = document.querySelector(`.job-card[data-job-id="${jobId}"]`);
                if (listCard) {
                    const listBtn = listCard.querySelector('.save-btn-small');
                    if (listBtn) updateSaveButton(listBtn, isSaved);
                }

                const largeBtn = document.querySelector(`.save-btn-large[data-job-id="${jobId}"]`);
                if (largeBtn) updateSaveButton(largeBtn, isSaved);
            }

            // ========== XỬ LÝ SAVE/UNSAVE JOB ==========
            function handleSaveJob(jobId, isSaved, button) {
                if (!checkAuth()) {
                    showToast('Vui lòng đăng nhập để lưu công việc!', 'error');
                    setTimeout(() => window.location.href = '/login', 1500);
                    return;
                }

                button.disabled = true;

                const url = isSaved ? `/job/unsave/${jobId}` : `/job/save/${jobId}`;
                const method = isSaved ? 'DELETE' : 'POST';

                fetch(url, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            syncSaveButtons(jobId, !isSaved);
                            showToast(data.message, isSaved ? 'info' : 'success');
                        } else {
                            showToast(data.message || 'Có lỗi xảy ra!', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Có lỗi xảy ra khi lưu công việc!', 'error');
                    })
                    .finally(() => {
                        button.disabled = false;
                    });
            }

            // ========== ATTACH EVENT CHO NÚT SAVE GRID ==========
            function attachSaveButtonGrid() {
                document.querySelectorAll('.save-btn-grid').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        e.preventDefault();
                        const jobCard = this.closest('.job-card-grid');
                        const jobId = jobCard?.getAttribute('data-job-id');
                        if (!jobId) {
                            showToast('Không xác định được công việc!', 'error');
                            return;
                        }
                        const isSaved = this.classList.contains('saved');
                        handleSaveJob(jobId, isSaved, this);
                    });
                });
            }

            // ========== ATTACH EVENT CHO NÚT SAVE SMALL ==========
            function attachSaveButtonSmall() {
                document.querySelectorAll('.save-btn-small').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        e.preventDefault();
                        const jobCard = this.closest('.job-card');
                        const jobId = jobCard?.getAttribute('data-job-id');
                        if (!jobId) {
                            showToast('Không xác định được công việc!', 'error');
                            return;
                        }
                        const isSaved = this.classList.contains('saved');
                        handleSaveJob(jobId, isSaved, this);
                    });
                });
            }

            // ========== LOAD TRẠNG THÁI ĐÃ LƯU KHI VÀO TRANG ==========
            function loadSavedJobs() {
                if (!checkAuth()) return;

                fetch('/api/saved-jobs', {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.savedJobIds) {
                            data.savedJobIds.forEach(jobId => {
                                const gridCard = document.querySelector(`.job-card-grid[data-job-id="${jobId}"]`);
                                if (gridCard) {
                                    const saveBtn = gridCard.querySelector('.save-btn-grid');
                                    if (saveBtn) updateSaveButton(saveBtn, true);
                                }

                                const listCard = document.querySelector(`.job-card[data-job-id="${jobId}"]`);
                                if (listCard) {
                                    const saveBtn = listCard.querySelector('.save-btn-small');
                                    if (saveBtn) updateSaveButton(saveBtn, true);
                                }
                            });
                        }
                    })
                    .catch(error => console.error('Error loading saved jobs:', error));
            }

            // ========== Xử lý FILTER BUTTONS ==========
            const filterBtns = document.querySelectorAll('.filter-btn:not(.all-filters-btn)');
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    this.classList.toggle('active');
                });
            });

            // ========== Xử lý MODAL ỨNG TUYỂN ==========
            const uploadOption = document.getElementById('uploadOption');
            const profileOption = document.getElementById('profileOption');
            const uploadSection = document.getElementById('uploadSection');
            const profileSection = document.getElementById('profileSection');
            const cvTypeRadios = document.querySelectorAll('input[name="cv_type"]');

            cvTypeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    document.querySelectorAll('.cv-option-card').forEach(card => {
                        card.classList.remove('active');
                    });
                    this.closest('.cv-option-card').classList.add('active');

                    if (this.value === 'upload') {
                        uploadSection.style.display = 'block';
                        profileSection.style.display = 'none';
                    } else {
                        uploadSection.style.display = 'none';
                        profileSection.style.display = 'block';
                    }
                });
            });

            // File Upload
            const uploadArea = document.getElementById('uploadArea');
            const cvFileInput = document.getElementById('cvFileInput');
            const selectFileBtn = document.getElementById('selectFileBtn');
            const fileNameDisplay = document.getElementById('fileNameDisplay');
            const fileName = document.getElementById('fileName');
            const removeFile = document.getElementById('removeFile');

            if (selectFileBtn) {
                selectFileBtn.addEventListener('click', () => cvFileInput.click());
            }

            if (cvFileInput) {
                cvFileInput.addEventListener('change', function(e) {
                    handleFile(this.files[0]);
                });
            }

            if (uploadArea) {
                uploadArea.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    this.classList.add('dragover');
                });

                uploadArea.addEventListener('dragleave', function() {
                    this.classList.remove('dragover');
                });

                uploadArea.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.classList.remove('dragover');
                    const file = e.dataTransfer.files[0];
                    handleFile(file);
                });
            }

            function handleFile(file) {
                if (!file) return;

                const validTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                const maxSize = 5 * 1024 * 1024;

                if (!validTypes.includes(file.type)) {
                    alert('Chỉ chấp nhận file .doc, .docx, .pdf');
                    return;
                }

                if (file.size > maxSize) {
                    alert('File không được vượt quá 5MB');
                    return;
                }

                fileName.textContent = file.name;
                fileNameDisplay.style.display = 'block';
                uploadArea.style.display = 'none';
            }

            if (removeFile) {
                removeFile.addEventListener('click', function() {
                    cvFileInput.value = '';
                    fileNameDisplay.style.display = 'none';
                    uploadArea.style.display = 'block';
                });
            }

            // Character Count
            const letterTextarea = document.querySelector('.letter-textarea');
            const charCount = document.getElementById('charCount');

            if (letterTextarea) {
                letterTextarea.addEventListener('input', function() {
                    charCount.textContent = this.value.length;
                });
                charCount.textContent = letterTextarea.value.length;
            }

            // Form Submit
            const applyJobForm = document.getElementById('applyJobForm');
            if (applyJobForm) {
                applyJobForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const cvType = document.querySelector('input[name="cv_type"]:checked').value;
                    if (cvType === 'upload' && !cvFileInput.files.length) {
                        alert('Vui lòng tải lên CV của bạn');
                        return;
                    }

                    const activeJobCard = document.querySelector('.job-card.active');
                    const jobId = activeJobCard ? activeJobCard.getAttribute('data-job-id') : null;

                    if (!jobId) {
                        alert('Không xác định được công việc. Vui lòng thử lại!');
                        return;
                    }

                    const formData = new FormData(this);
                    formData.append('job_id', jobId);

                    const submitBtn = this.querySelector('.btn-submit-apply');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Đang gửi...';

                    fetch('/apply-job', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showToast(data.message, 'success');
                                const modal = bootstrap.Modal.getInstance(document.getElementById('applyJobModal'));
                                if (modal) modal.hide();
                                applyJobForm.reset();
                                if (fileNameDisplay) fileNameDisplay.style.display = 'none';
                                if (uploadArea) uploadArea.style.display = 'block';
                            } else {
                                showToast(data.message || 'Có lỗi xảy ra. Vui lòng thử lại!', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('Có lỗi xảy ra khi gửi hồ sơ. Vui lòng thử lại!', 'error');
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        });
                });
            }

            // Reset modal khi đóng
            const applyModal = document.getElementById('applyJobModal');
            if (applyModal) {
                applyModal.addEventListener('hidden.bs.modal', function() {
                    const form = document.getElementById('applyJobForm');
                    if (form) form.reset();
                    if (uploadSection) uploadSection.style.display = 'block';
                    if (profileSection) profileSection.style.display = 'none';
                    if (fileNameDisplay) fileNameDisplay.style.display = 'none';
                    if (uploadArea) uploadArea.style.display = 'block';
                    document.querySelectorAll('.cv-option-card').forEach(card => {
                        card.classList.remove('active');
                    });
                    if (uploadOption) uploadOption.classList.add('active');
                    if (charCount) charCount.textContent = '0';
                });
            }

            // ========== KHỞI TẠO ==========
            attachGridCardEvents();
            attachListCardEvents();
            attachSaveButtonGrid();
            attachSaveButtonSmall();
            loadSavedJobs();
        });
    </script>
</body>

</html>