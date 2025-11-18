<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- THÃŠM META TAG NÃ€Y Äá»‚ CHECK ÄÄ‚NG NHáº¬P -->
    <meta name="user-authenticated" content="{{ Auth::check() ? 'true' : 'false' }}">
    <title>TÃ¬m Viá»‡c IT ChuyÃªn Nghiá»‡p</title>

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

        /* Main Layout - 2 columns */
        .main-layout {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 1rem;
            display: grid;
            grid-template-columns: 450px 1fr;
            gap: 1.5rem;
            align-items: start;
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

        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0 0.5rem;
        }

        .results-count {
            font-size: 0.95rem;
            color: #718096;
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

        /* Job Card - Compact */
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
            .main-layout {
                grid-template-columns: 400px 1fr;
            }
        }

        @media (max-width: 992px) {
            .main-layout {
                grid-template-columns: 1fr;
            }

            .job-detail-column {
                display: none;
            }

            .job-list-column {
                height: auto;
            }
        }

        @media (max-width: 768px) {
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
                    <li><a href="#" class="active">Trang chá»§</a></li>
                    <li class="dropdown">
                        <a href="#"><span>Viá»‡c lÃ m</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="#">Theo khu vá»±c</a></li>
                            <li><a href="#">Theo lÄ©nh vá»±c</a></li>
                            <li><a href="#">Theo ká»¹ nÄƒng</a></li>
                            <li><a href="#">Theo tá»« khÃ³a</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#"><span>CÃ´ng ty</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="#">Theo khu vá»±c</a></li>
                            <li><a href="#">Theo lÄ©nh vá»±c</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#"><span>Blog</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="#">Cáº©m nang tÃ¬m viá»‡c</a></li>
                            <li><a href="#">Ká»¹ nÄƒng vÄƒn phÃ²ng</a></li>
                            <li><a href="#">Kiáº¿n thá»©c chuyÃªn ngÃ nh</a></li>
                            <li><a href="#">Tin tá»©c tá»•ng há»£p</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <div class="header-actions">
                @if(!Auth::check())
                <a class="btn-login" href="{{ route('login') }}">ÄÄƒng nháº­p</a>
                @else
                <div class="user-dropdown">
                    <button class="user-btn" id="userDropdownBtn">
                        <img src="{{ asset('assets/img/user.png') }}" alt="" class="user-avatar">
                        <span class="user-name">{{ Auth::user()->applicant->hoten_uv ?? Auth::user()->email }}</span>
                        <i class="bi bi-chevron-down"></i>
                    </button>
                    <ul class="user-dropdown-menu" id="userDropdownMenu">
                        <li><a href="{{ route('applicant.profile') }}"><i class="bi bi-person"></i> Há»“ sÆ¡</a></li>
                        <li><a href="#"><i class="bi bi-info-circle"></i> ThÃ´ng tin cÃ¡ nhÃ¢n</a></li>
                        <li><a href="#"><i class="bi bi-file-earmark-text"></i> Há»“ sÆ¡ Ä‘Ã­nh kÃ¨m</a></li>
                        <li><a href="{{ route('applicant.myJobs') }}"><i class="bi bi-briefcase"></i> Viá»‡c lÃ m cá»§a tÃ´i</a></li>
                        <li><a href="#"><i class="bi bi-envelope"></i> Lá»i má»i cÃ´ng viá»‡c</a></li>
                        <li><a href="#"><i class="bi bi-bell"></i> ThÃ´ng bÃ¡o</a></li>
                        <li class="divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="logout-btn">
                                    <i class="bi bi-box-arrow-right"></i> ÄÄƒng xuáº¥t
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
                    <input type="text" class="search-input" placeholder="TÃ¬m theo ká»¹ nÄƒng, vá»‹ trÃ­, cÃ´ng ty...">
                    <i class="bi bi-geo-alt" style="color: #A0AEC0; font-size: 1.2rem;"></i>
                    <select class="location-select">
                        <option value="">Äá»‹a Ä‘iá»ƒm</option>
                        <option value="HCM">Há»“ ChÃ­ Minh</option>
                        <option value="HN">HÃ Ná»™i</option>
                        <option value="DN">ÄÃ Náºµng</option>
                        <option value="Remote">Remote</option>
                    </select>
                </div>
                <button class="search-btn">TÃ¬m kiáº¿m</button>
            </div>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="filter-section">
        <div class="filter-container">
            <button class="filter-btn">
                <i class="bi bi-folder"></i>
                Táº¥t cáº£ danh má»¥c (1)
            </button>
            <button class="filter-btn">
                <i class="bi bi-bar-chart"></i>
                Cáº¥p báº­c
            </button>
            <button class="filter-btn">
                <i class="bi bi-gift"></i>
                PhÃºc lá»£i
            </button>
            <button class="filter-btn">
                <i class="bi bi-briefcase"></i>
                HÃ¬nh thá»©c lÃ m viá»‡c
            </button>
            <button class="filter-btn all-filters-btn">
                <i class="bi bi-sliders"></i>
                Táº¥t cáº£ bá»™ lá»c
            </button>
        </div>
    </section>

    <!-- Main Layout - 2 Columns -->
    <div class="main-layout">
        <!-- Left Column - Job List -->
        <div class="job-list-column">
            <div class="results-header">
                <div class="results-count">
                    <strong>{{ isset($jobs) ? $jobs->count() : 0 }}</strong> káº¿t quáº£
                </div>
                <select class="sort-select">
                    <option>LÆ°Æ¡ng (Cao - Tháº¥p)</option>
                    <option>NgÃ y Ä‘Äƒng (Má»›i nháº¥t)</option>
                    <option>NgÃ y Ä‘Äƒng (CÅ© nháº¥t)</option>
                </select>
            </div>

            <div id="jobListContainer">
                @foreach($jobs as $job)
                <article class="job-card" data-job-id="{{ $job->job_id }}">
                    <div class="job-card-header">
                        <div class="company-logo-small flex-shrink-0">
                            @if($job->company && $job->company->logo)
                            <img src="{{ asset('assets/img/' . $job->company->logo) }}"
                                alt="Company Logo"
                                class="w-20 h-20 object-contain rounded-xl border-4 border-white shadow-lg bg-white" />
                            @else
                            <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-blue-500 rounded-xl flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                                {{ substr($job->company->tencty ?? 'C', 0, 1) }}
                            </div>
                            @endif
                        </div>

                        <div class="job-card-info">
                            <h3 class="job-card-title">{{ $job->title }}</h3>
                            <div class="company-name-small">
                                {{ $job->company->tencty ?? 'CÃ´ng ty' }}
                            </div>
                            <span class="job-card-salary {{ (!$job->salary_min || !$job->salary_max) ? 'negotiable' : '' }}">
                                @if($job->salary_min && $job->salary_max)
                                {{ number_format($job->salary_min, 0, ',', '.') }} -
                                {{ number_format($job->salary_max, 0, ',', '.') }}
                                {{ strtoupper($job->salary_type) }}
                                @else
                                Thá»a thuáº­n
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

                    <div class="job-card-tags">
                        @if($job->hashtags && $job->hashtags->count() > 0)
                        @foreach($job->hashtags->take(3) as $tag)
                        <span class="job-card-tag">{{ $tag->tag_name }}</span>
                        @endforeach
                        @endif
                    </div>

                    <div class="job-card-footer">
                        <div class="job-card-deadline">
                            <i class="bi bi-clock-history"></i>
                            Háº¡n ná»™p: {{ \Carbon\Carbon::parse($job->deadline)->format('d/m/Y') }}
                        </div>
                        <button class="save-btn-small" title="LÆ°u cÃ´ng viá»‡c">
                            <i class="bi bi-heart" style="font-size: 1.1rem;"></i>
                        </button>
                    </div>
                </article>
                @endforeach
            </div>
        </div>

        <!-- Right Column - Job Detail -->
        <div class="job-detail-column" id="jobDetailColumn">
            @if(isset($jobs) && $jobs->count() > 0)
            @php $firstJob = $jobs->first(); @endphp
            <div class="job-detail-header">
                <div class="job-detail-company">
                    <div class="company-logo-large">
                        @if($firstJob->company && $firstJob->company->logo)
                        <img src="{{ asset('storage/' . $firstJob->company->logo) }}" alt="Company Logo">
                        @else
                        <img src="{{ asset('assets/img/company-logo.png') }}" alt="Company Logo">
                        @endif
                    </div>
                    <div class="job-detail-title-section">
                        <h2 class="job-detail-title">{{ $firstJob->title }}</h2>
                        <div class="job-detail-company-name">
                            {{ $firstJob->company->tencty ?? 'CÃ´ng ty' }}
                        </div>
                        <span class="job-detail-salary {{ (!$firstJob->salary_min || !$firstJob->salary_max) ? 'negotiable' : '' }}">
                            @if($firstJob->salary_min && $firstJob->salary_max)
                            {{ number_format($firstJob->salary_min, 0, ',', '.') }} -
                            {{ number_format($firstJob->salary_max, 0, ',', '.') }}
                            {{ strtoupper($firstJob->salary_type) }}
                            @else
                            Thá»a thuáº­n
                            @endif
                        </span>
                    </div>
                </div>

                <div class="job-detail-actions">
                    <button type="button" class="btn-apply-now" data-job-id="{{ $firstJob->job_id }}">
                        <i class="bi bi-send-fill me-2"></i>á»¨ng tuyá»ƒn ngay
                    </button>
                    <button class="save-btn-large" title="LÆ°u cÃ´ng viá»‡c">
                        <i class="bi bi-heart" style="font-size: 1.2rem;"></i>
                    </button>
                </div>
            </div>

            <!-- Job Detail Content -->
            <div class="job-detail-content">
                <!-- ThÃ´ng tin chung -->
                <div class="detail-section">
                    <h3 class="detail-section-title">
                        <i class="bi bi-info-circle-fill"></i> ThÃ´ng tin chung
                    </h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label"><i class="bi bi-briefcase"></i> Cáº¥p báº­c</div>
                            <div class="info-value">{{ ucfirst($firstJob->level) }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="bi bi-award"></i> Kinh nghiá»‡m</div>
                            <div class="info-value">{{ $firstJob->experience }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="bi bi-people"></i> Sá»‘ lÆ°á»£ng tuyá»ƒn</div>
                            <div class="info-value">{{ $firstJob->recruitment_count ?? 'KhÃ´ng giá»›i háº¡n' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="bi bi-clock-history"></i> Háº¡n ná»™p há»“ sÆ¡</div>
                            <div class="info-value" style="color: #EF4444;">
                                {{ \Carbon\Carbon::parse($firstJob->deadline)->format('d/m/Y') }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label"><i class="bi bi-laptop"></i> HÃ¬nh thá»©c lÃ m viá»‡c</div>
                            <div class="info-value">{{ ucfirst($firstJob->working_type) }}</div>
                        </div>
                        @if($firstJob->gender_requirement)
                        <div class="info-item">
                            <div class="info-label"><i class="bi bi-gender-ambiguous"></i> YÃªu cáº§u giá»›i tÃ­nh</div>
                            <div class="info-value">{{ ucfirst($firstJob->gender_requirement) }}</div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Äá»‹a Ä‘iá»ƒm lÃ m viá»‡c -->
                <div class="detail-section">
                    <h3 class="detail-section-title"><i class="bi bi-geo-alt-fill"></i> Äá»‹a Ä‘iá»ƒm lÃ m viá»‡c</h3>
                    <div class="info-value">
                        {{ $firstJob->province }}
                    </div>
                </div>

                <!-- MÃ´ táº£ cÃ´ng viá»‡c -->
                @if($firstJob->detail && $firstJob->detail->description)
                <div class="detail-section">
                    <h3 class="detail-section-title"><i class="bi bi-file-text-fill"></i> MÃ´ táº£ cÃ´ng viá»‡c</h3>
                    <div class="job-description">
                        {!! nl2br(e($firstJob->detail->description)) !!}
                    </div>
                </div>
                @endif

                <!-- TrÃ¡ch nhiá»‡m -->
                @if($firstJob->detail && $firstJob->detail->responsibilities)
                <div class="detail-section">
                    <h3 class="detail-section-title"><i class="bi bi-card-checklist"></i> TrÃ¡ch nhiá»‡m cÃ´ng viá»‡c</h3>
                    <div class="job-description">
                        {!! nl2br(e($firstJob->detail->responsibilities)) !!}
                    </div>
                </div>
                @endif

                <!-- YÃªu cáº§u -->
                @if($firstJob->detail && $firstJob->detail->requirement)
                <div class="detail-section">
                    <h3 class="detail-section-title"><i class="bi bi-list-check"></i> YÃªu cáº§u á»©ng viÃªn</h3>
                    <div class="job-description">
                        {!! nl2br(e($firstJob->detail->requirement)) !!}
                    </div>
                </div>
                @endif

                <!-- Quyá»n lá»£i -->
                @if($firstJob->detail && $firstJob->detail->benefit)
                <div class="detail-section">
                    <h3 class="detail-section-title"><i class="bi bi-gift-fill"></i> Quyá»n lá»£i</h3>
                    <div class="job-description">
                        {!! nl2br(e($firstJob->detail->benefit)) !!}
                    </div>
                </div>
                @endif

                <!-- MÃ´i trÆ°á»ng lÃ m viá»‡c -->
                @if($firstJob->detail && $firstJob->detail->working_environment)
                <div class="detail-section">
                    <h3 class="detail-section-title"><i class="bi bi-building"></i> MÃ´i trÆ°á»ng lÃ m viá»‡c</h3>
                    <div class="job-description">
                        {!! nl2br(e($firstJob->detail->working_environment)) !!}
                    </div>
                </div>
                @endif

                <!-- Ká»¹ nÄƒng -->
                @if($firstJob->hashtags && $firstJob->hashtags->count() > 0)
                <div class="detail-section">
                    <h3 class="detail-section-title"><i class="bi bi-code-slash"></i> Ká»¹ nÄƒng yÃªu cáº§u</h3>
                    <div class="tags-list">
                        @foreach($firstJob->hashtags as $tag)
                        <span class="tag-item">{{ $tag->tag_name }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- ThÃ´ng tin cÃ´ng ty -->
                @if($firstJob->company)
                <div class="detail-section">
                    <h3 class="detail-section-title"><i class="bi bi-building"></i> ThÃ´ng tin cÃ´ng ty</h3>
                    <div class="job-description">
                        <h4>{{ $firstJob->company->tencty }}</h4>

                        @if($firstJob->company->tinh_thanh || $firstJob->company->quan_huyen)
                        <p>
                            <strong>Äá»‹a chá»‰:</strong>
                            {{ $firstJob->company->quan_huyen ? $firstJob->company->quan_huyen . ', ' : '' }}
                            {{ $firstJob->company->tinh_thanh }}
                        </p>
                        @endif

                        @if($firstJob->company->website_cty)
                        <p>
                            <strong>Website:</strong>
                            <a href="{{ $firstJob->company->website_cty }}" target="_blank">
                                {{ $firstJob->company->website_cty }}
                            </a>
                        </p>
                        @endif

                        @if($firstJob->company->quymo)
                        <p><strong>Quy mÃ´:</strong> {{ $firstJob->company->quymo }} nhÃ¢n viÃªn</p>
                        @endif

                        @if($firstJob->company->mota_cty)
                        <p>{{ $firstJob->company->mota_cty }}</p>
                        @endif
                    </div>
                </div>
                @endif

                <!-- CÃ¡ch thá»©c á»©ng tuyá»ƒn -->
                @if($firstJob->contact_method)
                <div class="detail-section">
                    <h3 class="detail-section-title"><i class="bi bi-envelope"></i> CÃ¡ch thá»©c á»©ng tuyá»ƒn</h3>
                    <div class="job-description">
                        {!! nl2br(e($firstJob->contact_method)) !!}
                    </div>
                </div>
                @endif
            </div>
            @else
            <div class="job-detail-empty">
                <i class="bi bi-briefcase"></i>
                <p>ChÆ°a cÃ³ cÃ´ng viá»‡c nÃ o</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Modal á»¨ng Tuyá»ƒn -->
    <div class="modal fade modal-apply-job" id="applyJobModal" tabindex="-1" aria-labelledby="applyJobModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applyJobModalLabel">
                        <i class="bi bi-send-fill me-2"></i>á»¨ng tuyá»ƒn cÃ´ng viá»‡c
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="applyJobForm" action="{{ route('application.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">

                        <!-- Step 1: Chá»n cÃ¡ch á»©ng tuyá»ƒn -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-file-earmark-person me-2 text-primary"></i>Chá»n CV Ä‘á»ƒ á»©ng tuyá»ƒn <span class="required-mark">*</span>
                            </h6>
                            <div class="row g-3">
                                <!-- Option 1: Upload CV -->
                                <div class="col-md-6">
                                    <label class="cv-option-card active" id="uploadOption">
                                        <input type="radio" name="cv_type" value="upload" checked>
                                        <div class="cv-option-icon">
                                            <i class="bi bi-cloud-upload"></i>
                                        </div>
                                        <div class="cv-option-title">Táº£i lÃªn CV tá»« mÃ¡y tÃ­nh</div>
                                        <div class="cv-option-desc">Há»— trá»£ Ä‘á»‹nh dáº¡ng .doc, .docx, .pdf dÆ°á»›i 5MB</div>
                                    </label>
                                </div>

                                <!-- Option 2: Use Profile -->
                                <div class="col-md-6">
                                    <label class="cv-option-card" id="profileOption">
                                        <input type="radio" name="cv_type" value="profile">
                                        <div class="cv-option-icon">
                                            <i class="bi bi-person-badge"></i>
                                        </div>
                                        <div class="cv-option-title">Sá»­ dá»¥ng há»“ sÆ¡ cÃ³ sáºµn</div>
                                        <div class="cv-option-desc">DÃ¹ng thÃ´ng tin tá»« há»“ sÆ¡ Ä‘Ã£ táº¡o trÃªn há»‡ thá»‘ng</div>
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
                                <h6 class="fw-bold mb-2">KÃ©o tháº£ CV vÃ o Ä‘Ã¢y hoáº·c chá»n file</h6>
                                <p class="text-muted small mb-3">Há»— trá»£ .doc, .docx, .pdf (tá»‘i Ä‘a 5MB)</p>
                                <input type="file" id="cvFileInput" name="cv_file" accept=".doc,.docx,.pdf" class="d-none">
                                <button type="button" class="btn btn-outline-primary" id="selectFileBtn">
                                    <i class="bi bi-folder2-open me-2"></i>Chá»n file
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
                                        <div class="profile-name">{{ $applicant->hoten_uv ?? 'Há» tÃªn á»©ng viÃªn' }}</div>
                                        <div class="profile-title">{{ $applicant->chucdanh ?? 'Chá»©c danh' }}</div>
                                        <div class="profile-contact">
                                            <div class="contact-item">
                                                <i class="bi bi-envelope"></i>
                                                <span>{{ Auth::user()->email ?? 'Email' }}</span>
                                            </div>
                                            <div class="contact-item">
                                                <i class="bi bi-telephone"></i>
                                                <span>{{ $applicant->sdt_uv ?? 'ChÆ°a cáº­p nháº­t' }}</span>
                                            </div>
                                            <div class="contact-item">
                                                <i class="bi bi-geo-alt"></i>
                                                <span>{{ $applicant->diachi_uv ?? 'ChÆ°a cáº­p nháº­t' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <!-- NÃºt Chá»‰nh sá»­a -->
                                        <a href="{{ route('applicant.hoso') }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                            <i class="bi bi-pencil me-1"></i>Chá»‰nh sá»­a
                                        </a>

                                        <!-- NÃºt Xem CV -->
                                        <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#viewCVModal">
                                            <i class="bi bi-eye me-1"></i>Xem CV
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- ThÃ´ng tin bá»• sung -->
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-card-text me-2 text-primary"></i>ThÃ´ng tin bá»• sung
                        </h6>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Há» vÃ tÃªn <span class="required-mark">*</span></label>
                                <input type="text" name="hoten" class="form-control" placeholder="Há» tÃªn hiá»ƒn thá»‹ vá»›i NTD"
                                    value="{{ $applicant->hoten_uv ?? '' }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="required-mark">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="Email hiá»ƒn thá»‹ vá»›i NTD"
                                    value="{{ Auth::user()->email ?? '' }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Sá»‘ Ä‘iá»‡n thoáº¡i <span class="required-mark">*</span></label>
                                <input type="tel" name="sdt" class="form-control" placeholder="Sá»‘ Ä‘iá»‡n thoáº¡i hiá»ƒn thá»‹ vá»›i NTD"
                                    value="{{ $applicant->sdt_uv ?? '' }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Äá»‹a chá»‰</label>
                                <input type="text" name="diachi" class="form-control" placeholder="Äá»‹a chá»‰ cá»§a báº¡n"
                                    value="{{ $applicant->diachi_uv ?? '' }}">
                            </div>
                        </div>

                        <!-- ThÆ° giá»›i thiá»‡u -->
                        <div class="mb-4">
                            <label class="form-label d-flex align-items-center gap-2">
                                <i class="bi bi-pencil-square text-success" style="font-size: 1.2rem;"></i>
                                <span style="font-size: 1.05rem; font-weight: 600; color: #1f2937;">ThÆ° giá»›i thiá»‡u:</span>
                            </label>
                            <p class="text-muted mb-3" style="font-size: 0.95rem; line-height: 1.6;">
                                Má»™t thÆ° giá»›i thiá»‡u ngáº¯n gá»n, chá»‰n chu sáº½ giÃºp báº¡n trá»Ÿ nÃªn chuyÃªn nghiá»‡p vÃ gÃ¢y áº¥n tÆ°á»£ng hÆ¡n vá»›i nhÃ tuyá»ƒn dá»¥ng.
                            </p>
                            <textarea name="thugioithieu" class="form-control letter-textarea" maxlength="2500"
                                placeholder="Viáº¿t giá»›i thiá»‡u ngáº¯n gá»n vá» báº£n thÃ¢n (Ä‘iá»ƒm máº¡nh, Ä‘iá»ƒm yáº¿u) vÃ  nÃªu rÃµ mong muá»‘n, lÃ½ do báº¡n muá»‘n á»©ng tuyá»ƒn cho vá»‹ trÃ­ nÃ y."
                                style="border: 2px solid #10b981; border-radius: 12px;"></textarea>
                            <div class="char-count">
                                <span id="charCount">0</span>/2500 kÃ½ tá»±
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer border-0 p-4">
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg me-2"></i>Há»§y
                        </button>
                        <button type="submit" class="btn btn-primary btn-submit-apply">
                            <i class="bi bi-send-fill me-2"></i>Ná»™p há»“ sÆ¡ á»©ng tuyá»ƒn
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Xem CV -->
    <div class="modal fade" id="viewCVModal" tabindex="-1" aria-labelledby="viewCVLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content rounded-3 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="viewCVLabel">
                        <i class="bi bi-file-earmark-person"></i> CV á»¨ng viÃªn
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row">
                        <!-- Cá»™t trÃ¡i: Avatar + ThÃ´ng tin -->
                        <div class="col-md-4 bg-light p-3 rounded-start">
                            <div class="text-center mb-3">
                                <img src="{{ $applicant->avatar ? asset('assets/img/avt/'.$applicant->avatar) : asset('assets/img/avt/default-avatar.png') }}"
                                    alt="Avatar" class="rounded-circle mb-2" width="140" height="140">
                                <h4 class="fw-bold">{{ $applicant->hoten_uv ?? 'Há» tÃªn á»©ng viÃªn' }}</h4>
                                <p class="text-muted">{{ $applicant->chucdanh ?? 'Chá»©c danh / Vá»‹ trÃ­' }}</p>
                            </div>
                            <hr>
                            <p><i class="bi bi-envelope"></i> {{ Auth::user()->email }}</p>
                            <p><i class="bi bi-telephone"></i> {{ $applicant->sdt_uv ?? 'ChÆ°a cáº­p nháº­t' }}</p>
                            <p><i class="bi bi-calendar"></i> {{ $applicant->ngaysinh ?? 'ChÆ°a cáº­p nháº­t' }}</p>
                            <p><i class="bi bi-gender-ambiguous"></i> {{ $applicant->gioitinh_uv ?? 'ChÆ°a cáº­p nháº­t' }}</p>
                            <p><i class="bi bi-geo-alt"></i> {{ $applicant->diachi_uv ?? 'ChÆ°a cáº­p nháº­t' }}</p>
                        </div>

                        <!-- Cá»™t pháº£i: Ná»™i dung CV -->
                        <div class="col-md-8 p-4">
                            <h5 class="fw-bold text-primary">Giá»›i thiá»‡u báº£n thÃ¢n</h5>
                            <p>{!! $applicant->gioithieu ?? 'ChÆ°a cáº­p nháº­t giá»›i thiá»‡u báº£n thÃ¢n.' !!}</p>

                            <h5 class="fw-bold text-primary mt-4">Kinh nghiá»‡m lÃ m viá»‡c</h5>
                            @if(isset($kinhnghiem) && $kinhnghiem->count())
                            <ul>
                                @foreach($kinhnghiem as $item)
                                <li>
                                    <strong>{{ $item->chucdanh }}</strong> táº¡i {{ $item->congty }}
                                    ({{ \Carbon\Carbon::parse($item->tu_ngay)->format('d/m/Y') }} -
                                    {{ $item->den_ngay ? \Carbon\Carbon::parse($item->den_ngay)->format('d/m/Y') : 'Hiá»‡n táº¡i' }})
                                    @if($item->mota)<br>{!! nl2br(e($item->mota)) !!}@endif
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <p>ChÆ°a cáº­p nháº­t kinh nghiá»‡m lÃ m viá»‡c.</p>
                            @endif

                            <h5 class="fw-bold text-primary mt-4">Há»c váº¥n</h5>
                            @if(isset($hocvan) && $hocvan->count())
                            <ul>
                                @foreach($hocvan as $item)
                                <li>
                                    {{ $item->truong }} - {{ $item->nganh }} ({{ $item->trinhdo }})
                                    ({{ \Carbon\Carbon::parse($item->tu_ngay)->format('Y') }} -
                                    {{ $item->den_ngay ? \Carbon\Carbon::parse($item->den_ngay)->format('Y') : 'Hiá»‡n táº¡i' }})
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <p>ChÆ°a cáº­p nháº­t há»c váº¥n.</p>
                            @endif

                            <h5 class="fw-bold text-primary mt-4">Ká»¹ nÄƒng</h5>
                            @if(isset($kynang) && $kynang->count())
                            <ul>
                                @foreach($kynang as $item)
                                <li>{{ $item->ten_ky_nang }} - {{ $item->nam_kinh_nghiem ?? 0 }} nÄƒm kinh nghiá»‡m</li>
                                @endforeach
                            </ul>
                            @else
                            <p>ChÆ°a cáº­p nháº­t ká»¹ nÄƒng.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="{{ route('applicant.downloadCV', $applicant->id_uv) }}" class="btn btn-primary">
                        <i class="bi bi-download"></i> Download CV
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ÄÃ³ng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div style="max-width: 1400px; margin: 0 auto; padding: 0 1rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <p style="color: #718096;">Â© 2025 TÃ¬m Viá»‡c IT. Giao diá»‡n chuyÃªn nghiá»‡p, hiá»‡n Ä‘áº¡i, dá»… sá»­ dá»¥ng.</p>
            <div style="display: flex; gap: 1.5rem;">
                <a href="#">Äiá»u khoáº£n</a>
                <a href="#">ChÃ­nh sÃ¡ch</a>
                <a href="#">LiÃªn há»‡</a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ========== Xá»¬ LÃ USER DROPDOWN ==========
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

            // ========== KIá»‚M TRA ÄÄ‚NG NHáº¬P ==========
            function checkAuth() {
                const isLoggedIn = document.querySelector('meta[name="user-authenticated"]');
                return isLoggedIn && isLoggedIn.content === 'true';
            }

            // ========== Cáº¬P NHáº¬T TRáº NG THÃI NÃšT SAVE ==========
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

            // ========== Äá»’NG Bá»˜ NÃšT NHá»Ž VÃ€ Lá»šN ==========
            function syncSaveButtons(jobId, isSaved) {
                const jobCard = document.querySelector(`.job-card[data-job-id="${jobId}"]`);
                if (jobCard) {
                    const smallBtn = jobCard.querySelector('.save-btn-small');
                    if (smallBtn) updateSaveButton(smallBtn, isSaved);
                }

                const activeCard = document.querySelector('.job-card.active');
                if (activeCard && activeCard.getAttribute('data-job-id') == jobId) {
                    const largeBtn = document.querySelector('.save-btn-large');
                    if (largeBtn) updateSaveButton(largeBtn, isSaved);
                }
            }

            // ========== Xá»¬ LÃ SAVE/UNSAVE JOB ==========
            function handleSaveJob(jobId, isSaved, button) {
                if (!checkAuth()) {
                    showToast('Vui lÃ²ng Ä‘Äƒng nháº­p Ä‘á»ƒ lÆ°u cÃ´ng viá»‡c!', 'error');
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
                            showToast(data.message || 'CÃ³ lá»—i xáº£y ra!', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('CÃ³ lá»—i xáº£y ra khi lÆ°u cÃ´ng viá»‡c!', 'error');
                    })
                    .finally(() => {
                        button.disabled = false;
                    });
            }

            // ========== ATTACH EVENT CHO NÃšT SAVE NHá»Ž ==========
            function attachSaveButtonSmall() {
                document.querySelectorAll('.save-btn-small').forEach(btn => {
                    const newBtn = btn.cloneNode(true);
                    btn.parentNode.replaceChild(newBtn, btn);

                    newBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        e.preventDefault();

                        const jobCard = this.closest('.job-card');
                        const jobId = jobCard?.getAttribute('data-job-id');

                        if (!jobId) {
                            showToast('KhÃ´ng xÃ¡c Ä‘á»‹nh Ä‘Æ°á»£c cÃ´ng viá»‡c!', 'error');
                            return;
                        }

                        const isSaved = this.classList.contains('saved');
                        handleSaveJob(jobId, isSaved, this);
                    });
                });
            }

            // ========== ATTACH EVENT CHO NÃšT SAVE Lá»šN ==========
            function attachSaveButtonLarge() {
                const saveButtonLarge = document.querySelector('.save-btn-large');
                if (!saveButtonLarge) return;

                const newBtn = saveButtonLarge.cloneNode(true);
                saveButtonLarge.parentNode.replaceChild(newBtn, saveButtonLarge);

                newBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    e.preventDefault();

                    const activeJobCard = document.querySelector('.job-card.active');
                    const jobId = activeJobCard?.getAttribute('data-job-id');

                    if (!jobId) {
                        showToast('KhÃ´ng xÃ¡c Ä‘á»‹nh Ä‘Æ°á»£c cÃ´ng viá»‡c!', 'error');
                        return;
                    }

                    const isSaved = this.classList.contains('saved');
                    handleSaveJob(jobId, isSaved, this);
                });
            }

            // ========== LOAD TRáº NG THÃI ÄÃƒ LÆ¯U KHI VÃ€O TRANG ==========
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
                                const jobCard = document.querySelector(`.job-card[data-job-id="${jobId}"]`);
                                if (jobCard) {
                                    const saveBtn = jobCard.querySelector('.save-btn-small');
                                    if (saveBtn) updateSaveButton(saveBtn, true);
                                }
                            });

                            const firstJobCard = document.querySelector('.job-card.active');
                            if (firstJobCard) {
                                const jobId = firstJobCard.getAttribute('data-job-id');
                                const isSaved = data.savedJobIds.includes(parseInt(jobId));
                                const largeBtn = document.querySelector('.save-btn-large');
                                if (largeBtn) updateSaveButton(largeBtn, isSaved);
                            }
                        }
                    })
                    .catch(error => console.error('Error loading saved jobs:', error));
            }

            // ========== Xá»¬ LÃ CLICK VÃ€O JOB CARD ==========
            function attachJobCardEvents() {
                const jobCards = document.querySelectorAll('.job-card');
                const jobDetailColumn = document.getElementById('jobDetailColumn');

                jobCards.forEach(card => {
                    card.addEventListener('click', function(e) {
                        if (e.target.closest('.save-btn-small')) return;

                        jobCards.forEach(c => c.classList.remove('active'));
                        this.classList.add('active');

                        const jobId = this.getAttribute('data-job-id');

                        // Cáº­p nháº­t tráº¡ng thÃ¡i nÃºt save lá»›n
                        const smallBtn = this.querySelector('.save-btn-small');
                        const isSaved = smallBtn && smallBtn.classList.contains('saved');
                        const largeBtn = document.querySelector('.save-btn-large');
                        if (largeBtn) updateSaveButton(largeBtn, isSaved);

                        jobDetailColumn.innerHTML = `
                    <div class="job-detail-empty">
                        <i class="bi bi-hourglass-split"></i>
                        <p>Äang táº£i thÃ´ng tin...</p>
                    </div>
                `;

                        fetch(`/api/jobs/${jobId}`)
                            .then(response => {
                                if (!response.ok) throw new Error('Network response was not ok');
                                return response.json();
                            })
                            .then(job => {
                                const formatMoney = (num) => new Intl.NumberFormat('vi-VN').format(num);

                                let salaryHtml = '';
                                let salaryClass = '';
                                if (job.salary_min && job.salary_max) {
                                    salaryHtml = `${formatMoney(job.salary_min)} - ${formatMoney(job.salary_max)} ${job.salary_type.toUpperCase()}`;
                                } else {
                                    salaryHtml = 'Thá»a thuáº­n';
                                    salaryClass = 'negotiable';
                                }

                                const deadline = new Date(job.deadline).toLocaleDateString('vi-VN');

                                const hashtagsHtml = job.hashtags && job.hashtags.length > 0 ?
                                    job.hashtags.map(tag => `<span class="tag-item">${tag.tag_name}</span>`).join('') :
                                    '<p class="text-muted">KhÃ´ng cÃ³ thÃ´ng tin</p>';

                                jobDetailColumn.innerHTML = `
                            <div class="job-detail-header">
                                <div class="job-detail-company">
                                    <div class="company-logo-large">
                                        ${job.company && job.company.logo 
                                            ? `<img src="/storage/${job.company.logo}" alt="Company Logo">`
                                            : `<img src="/assets/img/company-logo.png" alt="Company Logo">`
                                        }
                                    </div>
                                    <div class="job-detail-title-section">
                                        <h2 class="job-detail-title">${job.title}</h2>
                                        <div class="job-detail-company-name">${job.company ? job.company.tencty : 'CÃ´ng ty'}</div>
                                        <span class="job-detail-salary ${salaryClass}">${salaryHtml}</span>
                                    </div>
                                </div>
                                <div class="job-detail-actions">
                                    <button type="button" class="btn-apply-now" data-job-id="${job.job_id}">
                                        <i class="bi bi-send-fill me-2"></i>á»¨ng tuyá»ƒn ngay
                                    </button>
                                    <button class="save-btn-large" title="LÆ°u cÃ´ng viá»‡c">
                                        <i class="bi bi-heart" style="font-size: 1.2rem;"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="job-detail-content">
                                <div class="detail-section">
                                    <h3 class="detail-section-title">
                                        <i class="bi bi-info-circle-fill"></i> ThÃ´ng tin chung
                                    </h3>
                                    <div class="info-grid">
                                        <div class="info-item">
                                            <div class="info-label"><i class="bi bi-briefcase"></i> Cáº¥p báº­c</div>
                                            <div class="info-value">${job.level}</div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label"><i class="bi bi-award"></i> Kinh nghiá»‡m</div>
                                            <div class="info-value">${job.experience}</div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label"><i class="bi bi-people"></i> Sá»‘ lÆ°á»£ng tuyá»ƒn</div>
                                            <div class="info-value">${job.recruitment_count || 'KhÃ´ng giá»›i háº¡n'}</div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label"><i class="bi bi-clock-history"></i> Háº¡n ná»™p há»“ sÆ¡</div>
                                            <div class="info-value" style="color: #EF4444;">${deadline}</div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label"><i class="bi bi-laptop"></i> HÃ¬nh thá»©c lÃ m viá»‡c</div>
                                            <div class="info-value">${job.working_type}</div>
                                        </div>
                                        ${job.gender_requirement ? `
                                        <div class="info-item">
                                            <div class="info-label"><i class="bi bi-gender-ambiguous"></i> YÃªu cáº§u giá»›i tÃ­nh</div>
                                            <div class="info-value">${job.gender_requirement}</div>
                                        </div>
                                        ` : ''}
                                    </div>
                                </div>
                                <div class="detail-section">
                                    <h3 class="detail-section-title">
                                        <i class="bi bi-geo-alt-fill"></i> Äá»‹a Ä‘iá»ƒm lÃ m viá»‡c
                                    </h3>
                                    <div class="info-value">${job.province}</div>
                                </div>
                                ${job.description ? `
                                <div class="detail-section">
                                    <h3 class="detail-section-title">
                                        <i class="bi bi-file-text-fill"></i> MÃ´ táº£ cÃ´ng viá»‡c
                                    </h3>
                                    <div class="job-description">
                                        ${job.description.replace(/\n/g, '<br>')}
                                    </div>
                                </div>
                                ` : ''}
                                ${job.responsibilities ? `
                                <div class="detail-section">
                                    <h3 class="detail-section-title">
                                        <i class="bi bi-card-checklist"></i> TrÃ¡ch nhiá»‡m cÃ´ng viá»‡c
                                    </h3>
                                    <div class="job-description">
                                        ${job.responsibilities.replace(/\n/g, '<br>')}
                                    </div>
                                </div>
                                ` : ''}
                                ${job.requirements ? `
                                <div class="detail-section">
                                    <h3 class="detail-section-title">
                                        <i class="bi bi-list-check"></i> YÃªu cáº§u á»©ng viÃªn
                                    </h3>
                                    <div class="job-description">
                                        ${job.requirements.replace(/\n/g, '<br>')}
                                    </div>
                                </div>
                                ` : ''}
                                ${job.benefits ? `
                                <div class="detail-section">
                                    <h3 class="detail-section-title">
                                        <i class="bi bi-gift-fill"></i> Quyá»n lá»£i
                                    </h3>
                                    <div class="job-description">
                                        ${job.benefits.replace(/\n/g, '<br>')}
                                    </div>
                                </div>
                                ` : ''}
                                ${job.hashtags && job.hashtags.length > 0 ? `
                                <div class="detail-section">
                                    <h3 class="detail-section-title">
                                        <i class="bi bi-code-slash"></i> Ká»¹ nÄƒng yÃªu cáº§u
                                    </h3>
                                    <div class="tags-list">${hashtagsHtml}</div>
                                </div>
                                ` : ''}
                            </div>
                        `;

                                jobDetailColumn.scrollTop = 0;
                                attachSaveButtonLarge();
                                attachApplyButton();
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                jobDetailColumn.innerHTML = `
                            <div class="job-detail-empty">
                                <i class="bi bi-exclamation-circle"></i>
                                <p>KhÃ´ng thá»ƒ táº£i thÃ´ng tin cÃ´ng viá»‡c</p>
                            </div>
                        `;
                            });
                    });
                });
            }

            // ========== Xá»¬ LÃ NÃšT á»¨NG TUYá»‚N ==========
            function attachApplyButton() {
                document.querySelectorAll('.btn-apply-now, .apply-btn-large').forEach(function(btn) {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        const modal = document.getElementById('applyJobModal');
                        if (modal) {
                            const bsModal = new bootstrap.Modal(modal);
                            bsModal.show();
                        }
                    });
                });
            }

            // ========== Xá»¬ LÃ FILTER BUTTONS ==========
            const filterBtns = document.querySelectorAll('.filter-btn:not(.all-filters-btn)');
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    this.classList.toggle('active');
                });
            });

            // ========== Xá»¬ LÃ MODAL á»¨NG TUYá»‚N ==========
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
                    alert('Chá»‰ cháº¥p nháº­n file .doc, .docx, .pdf');
                    return;
                }

                if (file.size > maxSize) {
                    alert('File khÃ´ng Ä‘Æ°á»£c vÆ°á»£t quÃ¡ 5MB');
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
                        alert('Vui lÃ²ng táº£i lÃªn CV cá»§a báº¡n');
                        return;
                    }

                    const activeJobCard = document.querySelector('.job-card.active');
                    const jobId = activeJobCard ? activeJobCard.getAttribute('data-job-id') : null;

                    if (!jobId) {
                        alert('KhÃ´ng xÃ¡c Ä‘á»‹nh Ä‘Æ°á»£c cÃ´ng viá»‡c. Vui lÃ²ng thá»­ láº¡i!');
                        return;
                    }

                    const formData = new FormData(this);
                    formData.append('job_id', jobId);

                    const submitBtn = this.querySelector('.btn-submit-apply');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Äang gá»­i...';

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
                                alert(data.message);
                                const modal = bootstrap.Modal.getInstance(document.getElementById('applyJobModal'));
                                if (modal) modal.hide();
                                applyJobForm.reset();
                                if (fileNameDisplay) fileNameDisplay.style.display = 'none';
                                if (uploadArea) uploadArea.style.display = 'block';
                            } else {
                                alert(data.message || 'CÃ³ lá»—i xáº£y ra. Vui lÃ²ng thá»­ láº¡i!');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('CÃ³ lá»—i xáº£y ra khi gá»­i há»“ sÆ¡. Vui lÃ²ng thá»­ láº¡i!');
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        });
                });
            }

            // Reset modal khi Ä‘Ã³ng
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

            // ========== KHá»žI Táº O ==========
            attachSaveButtonSmall();
            attachSaveButtonLarge();
            attachJobCardEvents();
            attachApplyButton();
            loadSavedJobs(); // Load tráº¡ng thÃ¡i Ä‘Ã£ lÆ°u

            // Auto-select first job card
            const firstJobCard = document.querySelector('.job-card');
            if (firstJobCard) {
                firstJobCard.classList.add('active');
            }
        });
    </script>
</body>

</html>