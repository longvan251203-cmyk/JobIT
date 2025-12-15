<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tìm kiếm ứng viên - JobIT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- ✅ BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* ============ NÚT MỜI - DISABLED STATE ============ */
        .btn-invite:disabled,
        button[disabled] {
            opacity: 0.6 !important;
            cursor: not-allowed !important;
            transform: none !important;
            box-shadow: none !important;
            background-color: #9ca3af !important;
        }

        button[disabled]:hover {
            transform: none !important;
            box-shadow: none !important;
        }

        /* Tooltip hover */
        button[disabled][title] {
            position: relative;
        }

        button[disabled][title]:hover::after {
            content: attr(title);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #374151;
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            white-space: nowrap;
            z-index: 10;
            margin-bottom: 0.5rem;
        }

        /* ✅ CV MODAL STYLING */
        .cv-modal-content {
            border-radius: 24px !important;
            border: none !important;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3) !important;
        }

        .cv-modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border: none !important;
            border-radius: 24px 24px 0 0 !important;
            color: white;
        }

        .cv-modal-body {
            background: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .cv-sidebar {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
        }

        .cv-avatar {
            border: 5px solid #667eea;
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
            width: 150px;
            height: 150px;
            object-fit: cover;
        }

        .cv-section-title {
            color: #1f2937;
            border-bottom: 3px solid #667eea;
            padding-bottom: 12px;
            margin-bottom: 16px;
            font-weight: 700;
            font-size: 1.05rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .cv-info-item {
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .cv-info-item:last-child {
            border-bottom: none;
        }

        .cv-info-item i {
            color: #667eea;
            font-size: 1.1rem;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .cv-info-label {
            font-size: 0.75rem;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            display: block;
            margin-bottom: 2px;
        }

        .cv-info-value {
            font-size: 0.9rem;
            color: #1f2937;
            font-weight: 500;
        }

        .cv-content-section {
            margin-bottom: 28px;
            padding-bottom: 24px;
            border-bottom: 1px solid #e5e7eb;
        }

        .cv-content-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .cv-timeline-item {
            padding-left: 20px;
            border-left: 3px solid #667eea;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 16px;
        }

        .cv-timeline-item:last-child {
            padding-bottom: 0;
        }

        .cv-timeline-item::before {
            content: '';
            position: absolute;
            left: -8px;
            top: 4px;
            width: 12px;
            height: 12px;
            background: #667eea;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 0 0 2px #667eea;
        }

        .cv-job-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 6px;
        }

        .cv-company {
            font-size: 0.95rem;
            color: #667eea;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .cv-date {
            font-size: 0.85rem;
            color: #6b7280;
            margin-bottom: 12px;
        }

        .cv-description {
            font-size: 0.9rem;
            color: #374151;
            line-height: 1.6;
            margin-bottom: 8px;
        }

        .cv-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px 14px;
            border-radius: 50px;
            font-size: 0.85rem;
            margin-right: 8px;
            margin-bottom: 10px;
            display: inline-block;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .cv-modal-footer {
            background: white;
            border-top: 1px solid #e5e7eb;
            border-radius: 0 0 24px 24px;
            padding: 20px 24px;
        }

        .cv-modal-footer .btn {
            border-radius: 10px;
            font-weight: 600;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .cv-modal-footer .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }

        .cv-modal-footer .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        @media print {

            .cv-modal-header,
            .cv-modal-footer {
                display: none !important;
            }

            .cv-modal-body {
                background: white !important;
                max-height: none !important;
            }
        }

        /* ============ RECOMMENDED BADGE ENHANCED ANIMATION ============ */
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes glow-pulse {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(251, 191, 36, 0.6),
                    0 0 40px rgba(251, 191, 36, 0.4),
                    0 0 60px rgba(251, 191, 36, 0.2);
            }

            50% {
                box-shadow: 0 0 30px rgba(251, 191, 36, 0.8),
                    0 0 60px rgba(251, 191, 36, 0.6),
                    0 0 90px rgba(251, 191, 36, 0.4);
            }
        }

        /* Hover effect trên recommended cards */
        .candidate-card:has(.bg-gradient-to-r.from-yellow-400):hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(251, 191, 36, 0.3);
        }

        /* Progress bar animation */
        @keyframes progressFill {
            from {
                width: 0%;
            }
        }

        .candidate-card .bg-gradient-to-r.from-orange-400 {
            animation: progressFill 1s ease-out;
        }

        /* Line clamp cho job title */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        /* Animate.css fallback */
        .animate__animated {
            animation-duration: 0.8s;
        }

        .animate__fadeInUp {
            animation-name: fadeInUp;
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
    </style>
    <style>
        .btn-invite {
            width: 100%;
            padding: 0.625rem;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .btn-invite::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-invite:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.35);
        }

        .btn-invite:hover::before {
            left: 100%;
        }

        .btn-invite:active {
            transform: translateY(0);
        }

        /* Responsive buttons container */
        .btn-container {
            display: flex;
            gap: 0.5rem;
            flex-direction: column;
        }

        @media (max-width: 768px) {
            .btn-container {
                flex-direction: column;
            }

            .btn-invite {
                width: 100%;
            }
        }

        /* ============ RECOMMENDED BADGE ENHANCED ANIMATION ============ */
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes glow-pulse {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(251, 191, 36, 0.6),
                    0 0 40px rgba(251, 191, 36, 0.4),
                    0 0 60px rgba(251, 191, 36, 0.2);
            }

            50% {
                box-shadow: 0 0 30px rgba(251, 191, 36, 0.8),
                    0 0 60px rgba(251, 191, 36, 0.6),
                    0 0 90px rgba(251, 191, 36, 0.4);
            }
        }

        /* Hover effect trên recommended cards */
        .candidate-card:has(.bg-gradient-to-r.from-yellow-400):hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(251, 191, 36, 0.3);
        }

        /* Progress bar animation */
        @keyframes progressFill {
            from {
                width: 0%;
            }
        }

        .candidate-card .bg-gradient-to-r.from-orange-400 {
            animation: progressFill 1s ease-out;
        }

        /* Line clamp cho job title */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Animate.css fallback */
        .animate__animated {
            animation-duration: 0.8s;
        }

        .animate__fadeInUp {
            animation-name: fadeInUp;
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
    </style>

    <style>
        /* ============ RECOMMENDED BADGE ANIMATION ============ */
        @keyframes glow-pulse {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(251, 191, 36, 0.6),
                    0 0 40px rgba(251, 191, 36, 0.4),
                    0 0 60px rgba(251, 191, 36, 0.2);
            }

            50% {
                box-shadow: 0 0 30px rgba(251, 191, 36, 0.8),
                    0 0 60px rgba(251, 191, 36, 0.6),
                    0 0 90px rgba(251, 191, 36, 0.4);
            }
        }

        .candidate-card:hover .absolute>div:first-child {
            animation: glow-pulse 2s infinite;
        }

        /* Line clamp for job title */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

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

        /* ========================================
        FILTER DROPDOWN HORIZONTAL STYLES
        ======================================== */
        .filter-section {
            background: #f9fafb;
            padding: 1.5rem 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .filter-dropdown-wrapper {
            position: relative;
            display: inline-block;
        }

        .filter-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 500;
            color: #374151;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .filter-btn:hover {
            border-color: #667eea;
            background: #f3f4f6;
            transform: translateY(-1px);
        }

        .filter-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
        }

        .filter-btn.btn-reset {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border-color: #ef4444;
            margin-left: auto;
        }

        .filter-btn.btn-reset:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .filter-btn i:last-child {
            transition: transform 0.3s ease;
            font-size: 0.8rem;
        }

        .filter-btn.active i:last-child {
            transform: rotate(180deg);
        }

        /* Dropdown Menu */
        /* Dropdown Menu */
        .filter-dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            padding: 0.5rem;
            min-width: 280px;
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            border: 1px solid #f0f0f0;
        }

        .filter-dropdown-menu.show {
            max-height: 500px !important;
            opacity: 1 !important;
            visibility: visible !important;
            overflow-y: auto !important;
            display: block !important;
        }

        .filter-checkbox-item {
            display: flex !important;
            align-items: center;
            padding: 0.75rem 1rem;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.2s ease;
            margin: 0;
            background: transparent;
        }

        .filter-checkbox-item:hover {
            background: #f8f9ff;
        }

        .filter-checkbox-item input[type="checkbox"],
        .filter-checkbox-item input[type="radio"] {
            width: 18px;
            height: 18px;
            min-width: 18px;
            margin-right: 0.75rem;
            cursor: pointer;
            accent-color: #667eea;
            border-radius: 4px;
        }

        .filter-checkbox-item span {
            font-size: 0.95rem;
            color: #1f2937;
            flex: 1;
            user-select: none;
        }

        .filter-checkbox-item input:checked+span {
            color: #667eea;
            font-weight: 600;
        }

        /* Custom Scrollbar */
        .filter-dropdown-menu::-webkit-scrollbar {
            width: 6px;
        }

        .filter-dropdown-menu::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .filter-dropdown-menu::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .filter-dropdown-menu::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        #skillSearch {
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            margin: 0.5rem;
            width: calc(100% - 2rem);
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        #skillSearch:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .filter-btn {
                font-size: 0.85rem;
                padding: 0.65rem 1rem;
            }

            .filter-dropdown-menu {
                min-width: 250px;
            }
        }

        @media (max-width: 768px) {
            .filter-section {
                padding: 1rem 0;
            }

            .filter-btn {
                font-size: 0.8rem;
                padding: 0.6rem 0.9rem;
            }

            .filter-dropdown-menu {
                min-width: 200px;
                left: auto;
                right: 0;
            }

            .filter-btn.btn-reset {
                margin-left: 0;
                margin-top: 0.5rem;
            }
        }
    </style>

</head>

<body>


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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
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

    <!-- FILTER SECTION NGANG - NỀN TẢNG -->
    <!-- FILTER SECTION NGANG - Form Thực -->
    <section class="filter-section" style="background: #f9fafb; padding: 1.5rem 0; border-bottom: 1px solid #e5e7eb;">
        <div class="max-w-7xl mx-auto px-6">
            <form id="filterForm" method="GET" action="{{ route('employer.candidates') }}" class="flex items-center gap-3 flex-wrap">

                <!-- 1. Experience Filter -->
                <div class="filter-dropdown-wrapper relative">
                    <button type="button" class="filter-btn" id="experienceFilterBtn">
                        <i class="bi bi-briefcase"></i>
                        <span>Kinh nghiệm</span>
                        <i class="bi bi-chevron-down ms-2"></i>
                    </button>
                    <div class="filter-dropdown-menu" id="experienceDropdown">
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="experience[]" value="0" {{ in_array('0', (array)request('experience'), true) ? 'checked' : '' }}>
                            <span>Chưa có kinh nghiệm</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="experience[]" value="0-1" {{ in_array('0-1', (array)request('experience'), true) ? 'checked' : '' }}>
                            <span>Dưới 1 năm</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="experience[]" value="1-3" {{ in_array('1-3', (array)request('experience'), true) ? 'checked' : '' }}>
                            <span>1 - 3 năm</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="experience[]" value="3-5" {{ in_array('3-5', (array)request('experience'), true) ? 'checked' : '' }}>
                            <span>3 - 5 năm</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="experience[]" value="5+" {{ in_array('5+', (array)request('experience'), true) ? 'checked' : '' }}>
                            <span>Trên 5 năm</span>
                        </label>
                    </div>
                </div>

                <!-- 2. Education Filter -->
                <div class="filter-dropdown-wrapper relative">
                    <button type="button" class="filter-btn" id="educationFilterBtn">
                        <i class="bi bi-mortarboard"></i>
                        <span>Trình độ</span>
                        <i class="bi bi-chevron-down ms-2"></i>
                    </button>
                    <div class="filter-dropdown-menu" id="educationDropdown">
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="education[]" value="Trung cấp" {{ in_array('Trung cấp', (array)request('education'), true) ? 'checked' : '' }}>
                            <span>Trung cấp</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="education[]" value="Cao đẳng" {{ in_array('Cao đẳng', (array)request('education'), true) ? 'checked' : '' }}>
                            <span>Cao đẳng</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="education[]" value="Đại học" {{ in_array('Đại học', (array)request('education'), true) ? 'checked' : '' }}>
                            <span>Đại học</span>
                        </label>

                    </div>
                </div>

                <!-- 3. Salary Filter -->
                <!-- 3. Salary Filter -->
                <div class="filter-dropdown-wrapper relative">
                    <button type="button" class="filter-btn" id="salaryFilterBtn">
                        <i class="bi bi-cash-stack"></i>
                        <span>Mức lương</span>
                        <i class="bi bi-chevron-down ms-2"></i>
                    </button>
                    <div class="filter-dropdown-menu" id="salaryDropdown">
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="salary[]" value="Thỏa thuận" {{ in_array('Thỏa thuận', (array)request('salary'), true) ? 'checked' : '' }}>
                            <span>Thỏa thuận</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="salary[]" value="Dưới 3 triệu" {{ in_array('Dưới 3 triệu', (array)request('salary'), true) ? 'checked' : '' }}>
                            <span>Dưới 3 triệu VNĐ</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="salary[]" value="3-5 triệu" {{ in_array('3-5 triệu', (array)request('salary'), true) ? 'checked' : '' }}>
                            <span>3 - 5 triệu VNĐ</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="salary[]" value="5-7 triệu" {{ in_array('5-7 triệu', (array)request('salary'), true) ? 'checked' : '' }}>
                            <span>5 - 7 triệu VNĐ</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="salary[]" value="7-10 triệu" {{ in_array('7-10 triệu', (array)request('salary'), true) ? 'checked' : '' }}>
                            <span>7 - 10 triệu VNĐ</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="salary[]" value="10-12 triệu" {{ in_array('10-12 triệu', (array)request('salary'), true) ? 'checked' : '' }}>
                            <span>10 - 12 triệu VNĐ</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="salary[]" value="12-15 triệu" {{ in_array('12-15 triệu', (array)request('salary'), true) ? 'checked' : '' }}>
                            <span>12 - 15 triệu VNĐ</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="salary[]" value="15-20 triệu" {{ in_array('15-20 triệu', (array)request('salary'), true) ? 'checked' : '' }}>
                            <span>15 - 20 triệu VNĐ</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="salary[]" value="20-25 triệu" {{ in_array('20-25 triệu', (array)request('salary'), true) ? 'checked' : '' }}>
                            <span>20 - 25 triệu VNĐ</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="salary[]" value="25-30 triệu" {{ in_array('25-30 triệu', (array)request('salary'), true) ? 'checked' : '' }}>
                            <span>25 - 30 triệu VNĐ</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="salary[]" value="Trên 30 triệu" {{ in_array('Trên 30 triệu', (array)request('salary'), true) ? 'checked' : '' }}>
                            <span>Trên 30 triệu VNĐ</span>
                        </label>
                    </div>
                </div>

                <!-- 4. Language Filter -->
                <div class="filter-dropdown-wrapper relative">
                    <button type="button" class="filter-btn" id="languageFilterBtn">
                        <i class="bi bi-translate"></i>
                        <span>Ngoại ngữ</span>
                        <i class="bi bi-chevron-down ms-2"></i>
                    </button>
                    <div class="filter-dropdown-menu" id="languageDropdown">
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="language[]" value="Tiếng Anh" {{ in_array('Tiếng Anh', (array)request('language'), true) ? 'checked' : '' }}>
                            <span>Tiếng Anh</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="language[]" value="Tiếng Nhật" {{ in_array('Tiếng Nhật', (array)request('language'), true) ? 'checked' : '' }}>
                            <span>Tiếng Nhật</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="language[]" value="Tiếng Hàn" {{ in_array('Tiếng Hàn', (array)request('language'), true) ? 'checked' : '' }}>
                            <span>Tiếng Hàn</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="language[]" value="Tiếng Trung" {{ in_array('Tiếng Trung', (array)request('language'), true) ? 'checked' : '' }}>
                            <span>Tiếng Trung</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="language[]" value="Tiếng Pháp" {{ in_array('Tiếng Pháp', (array)request('language'), true) ? 'checked' : '' }}>
                            <span>Tiếng Pháp</span>
                        </label>
                    </div>
                </div>

                <!-- 5. Gender Filter -->
                <div class="filter-dropdown-wrapper relative">
                    <button type="button" class="filter-btn" id="genderFilterBtn">
                        <i class="bi bi-gender-ambiguous"></i>
                        <span>Giới tính</span>
                        <i class="bi bi-chevron-down ms-2"></i>
                    </button>
                    <div class="filter-dropdown-menu" id="genderDropdown">
                        <label class="filter-checkbox-item">
                            <input type="radio" name="gender" value="" {{ !request('gender') ? 'checked' : '' }}>
                            <span>Tất cả</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="radio" name="gender" value="Nam" {{ request('gender') == 'Nam' ? 'checked' : '' }}>
                            <span>Nam</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="radio" name="gender" value="Nữ" {{ request('gender') == 'Nữ' ? 'checked' : '' }}>
                            <span>Nữ</span>
                        </label>
                    </div>
                </div>

                <!-- 6. Skills Filter -->
                <div class="filter-dropdown-wrapper relative">
                    <button type="button" class="filter-btn" id="skillsFilterBtn">
                        <i class="bi bi-lightbulb"></i>
                        <span>Kỹ năng</span>
                        <i class="bi bi-chevron-down ms-2"></i>
                    </button>
                    <div class="filter-dropdown-menu" id="skillsDropdown" style="max-height: 400px; overflow-y: auto;">
                        <input type="text" id="skillSearch" placeholder="Tìm kỹ năng..."
                            style="padding: 0.75rem 1rem; border: 1px solid #e5e7eb; border-radius: 8px; margin: 0.5rem; width: calc(100% - 2rem);">
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="skills[]" value="PHP" {{ in_array('PHP', (array)request('skills'), true) ? 'checked' : '' }}>
                            <span>PHP</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="skills[]" value="JavaScript" {{ in_array('JavaScript', (array)request('skills'), true) ? 'checked' : '' }}>
                            <span>JavaScript</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="skills[]" value="Laravel" {{ in_array('Laravel', (array)request('skills'), true) ? 'checked' : '' }}>
                            <span>Laravel</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="skills[]" value="React" {{ in_array('React', (array)request('skills'), true) ? 'checked' : '' }}>
                            <span>React</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="skills[]" value="Vue.js" {{ in_array('Vue.js', (array)request('skills'), true) ? 'checked' : '' }}>
                            <span>Vue.js</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="skills[]" value="Node.js" {{ in_array('Node.js', (array)request('skills'), true) ? 'checked' : '' }}>
                            <span>Node.js</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="skills[]" value="Python" {{ in_array('Python', (array)request('skills'), true) ? 'checked' : '' }}>
                            <span>Python</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="skills[]" value="Java" {{ in_array('Java', (array)request('skills'), true) ? 'checked' : '' }}>
                            <span>Java</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="skills[]" value="C#" {{ in_array('C#', (array)request('skills'), true) ? 'checked' : '' }}>
                            <span>C#</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="skills[]" value="Angular" {{ in_array('Angular', (array)request('skills'), true) ? 'checked' : '' }}>
                            <span>Angular</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="skills[]" value="SQL" {{ in_array('SQL', (array)request('skills'), true) ? 'checked' : '' }}>
                            <span>SQL</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="skills[]" value="MongoDB" {{ in_array('MongoDB', (array)request('skills'), true) ? 'checked' : '' }}>
                            <span>MongoDB</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="skills[]" value="Docker" {{ in_array('Docker', (array)request('skills'), true) ? 'checked' : '' }}>
                            <span>Docker</span>
                        </label>
                        <label class="filter-checkbox-item">
                            <input type="checkbox" name="skills[]" value="AWS" {{ in_array('AWS', (array)request('skills'), true) ? 'checked' : '' }}>
                            <span>AWS</span>
                        </label>
                    </div>
                </div>

                <!-- Hidden fields cho search & location -->
                <input type="hidden" name="keyword" id="keywordInput" value="{{ request('keyword') }}">
                <input type="hidden" name="location" id="locationInput" value="{{ request('location') }}">

                <!-- Reset Button -->
                <button type="reset" onclick="resetFilters()" class="filter-btn btn-reset" style="margin-left: auto;">
                    <i class="bi bi-arrow-clockwise"></i>
                    Đặt lại
                </button>
            </form>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="grid grid-cols-12 gap-6">

            <!-- ❌ XÓA FILTER SIDEBAR - ĐÃ CHUYỂN LÊN TRÊN -->

            <!-- CANDIDATES GRID -->
            <main class="col-span-12">
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
                                <img src="{{ $candidate->avatar ? asset('assets/img/avt/'.$candidate->avatar) : asset('assets/img/avt/default-avatar.png') }}"
                                    alt="{{ $candidate->hoten_uv }}">
                            </div>

                            <div class="card-content">
                                <h3 class="candidate-name">{{ $candidate->hoten_uv }}</h3>
                                <p class="candidate-title">{{ $candidate->vitriungtuyen ?? 'Chưa cập nhật' }}</p>

                                <div class="space-y-1 mb-3">
                                    @if($candidate->diachi_uv)
                                    <div class="candidate-info">
                                        <i class="bi bi-geo-alt"></i>
                                        <span class="truncate">{{ $candidate->diachi_uv }}</span>
                                    </div>
                                    @endif

                                    @if($candidate->kinhnghiem && $candidate->kinhnghiem->count() > 0)
                                    <div class="candidate-info">
                                        <i class="bi bi-briefcase"></i>
                                        <span>{{ $candidate->kinhnghiem->count() }} năm kinh nghiệm</span>
                                    </div>
                                    @endif

                                    @if($candidate->hocvan && $candidate->hocvan->first())
                                    <div class="candidate-info">
                                        <i class="bi bi-mortarboard"></i>
                                        <span>{{ $candidate->hocvan->first()->trinhdo ?? $candidate->hocvan->first()->trinh_do ?? 'Chưa cập nhật' }}</span>
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



                                <!-- ✅ THÊM CONTAINER CHO 2 NÚTTON -->
                                <div class="btn-container" style="display: flex; gap: 0.5rem; flex-direction: column; margin-top: auto;">
                                    <button onclick="viewCV('{{ $candidate->id_uv }}')" class="btn-view-profile">
                                        <i class="bi bi-eye mr-1"></i> Xem hồ sơ
                                    </button>
                                    <button onclick="inviteCandidate('{{ $candidate->id_uv }}')" class="btn-invite">
                                        <i class="bi bi-person-plus-fill"></i> Mời ứng viên
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!-- Pagination -->
                    @if($candidates->hasPages())
                    <div class="pagination">
                        <!-- Previous Button -->
                        <button
                            data-page="{{ $candidates->currentPage() - 1 }}"
                            class="pagination-btn pagination-prev"
                            {{ $candidates->onFirstPage() ? 'disabled' : '' }}>
                            <i class="bi bi-chevron-left"></i>
                        </button>

                        <!-- First Page -->
                        @if($candidates->currentPage() > 3)
                        <button data-page="1" class="pagination-btn pagination-link">1</button>
                        @if($candidates->currentPage() > 4)
                        <span class="pagination-dots">...</span>
                        @endif
                        @endif

                        <!-- Page Numbers -->
                        @for($i = max(1, $candidates->currentPage() - 2); $i <= min($candidates->lastPage(), $candidates->currentPage() + 2); $i++)
                            <button
                                data-page="{{ $i }}"
                                class="pagination-btn pagination-link {{ $i == $candidates->currentPage() ? 'active' : '' }}">
                                {{ $i }}
                            </button>
                            @endfor

                            <!-- Last Page -->
                            @if($candidates->currentPage() < $candidates->lastPage() - 2)
                                @if($candidates->currentPage() < $candidates->lastPage() - 3)
                                    <span class="pagination-dots">...</span>
                                    @endif
                                    <button data-page="{{ $candidates->lastPage() }}" class="pagination-btn pagination-link">{{ $candidates->lastPage() }}</button>
                                    @endif

                                    <!-- Next Button -->
                                    <button
                                        data-page="{{ $candidates->currentPage() + 1 }}"
                                        class="pagination-btn pagination-next"
                                        {{ !$candidates->hasMorePages() ? 'disabled' : '' }}>
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                    </div>
                    @endif
                    @else
                    <div class="empty-state">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0114 0z" />
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Không tìm thấy ứng viên</h3>
                        <p class="text-gray-600">Vui lòng thử lại với bộ lọc khác</p>
                    </div>
                    @endif
                </div>
                <!-- Gợi ý ứng viên -->
                <!-- Gợi ý ứng viên -->
                @if(!empty($recommendedApplicants) && count($recommendedApplicants) > 0)
                <div class="mb-8 animate__animated animate__fadeInUp mt-12">
                    {{-- Header với Badge Gradient --}}
                    <div class="bg-gradient-to-r from-yellow-400 via-orange-400 to-pink-500 rounded-2xl p-6 mb-6 shadow-xl relative overflow-hidden">
                        {{-- Animated Background Pattern --}}
                        <div class="absolute inset-0 opacity-10 top-8">
                            <div class="absolute w-96 h-96 -top-48 -right-48 bg-white rounded-full"></div>
                            <div class="absolute w-64 h-64 -bottom-32 -left-32 bg-white rounded-full"></div>
                        </div>

                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    {{-- Icon với Animation --}}
                                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-lg animate-bounce">
                                        <i class="bi bi-star-fill text-yellow-500 text-2xl"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                                            🎯 Ứng viên được đề xuất
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white text-orange-600 shadow-md">
                                                {{ count($recommendedApplicants) }} người
                                            </span>
                                        </h2>
                                        <p class="text-white/90 text-sm mt-1">
                                            Dựa trên các vị trí đang tuyển dụng của công ty bạn
                                        </p>
                                    </div>
                                </div>

                                {{-- View All Button --}}
                                <button onclick="toggleRecommendedSection()"
                                    class="px-6 py-2.5 bg-white text-orange-600 rounded-xl font-semibold hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                                    <i class="bi bi-eye mr-2"></i>
                                    Xem tất cả
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Recommended Candidates Grid --}}
                    <div id="recommendedCandidatesGrid" class="candidates-grid mb-6">
                        @foreach($recommendedApplicants as $rec)
                        <div class="candidate-card relative">
                            {{-- ⭐ RECOMMENDED BADGE - Nổi bật hơn --}}
                            <div class="absolute top-3 right-3 z-20">
                                <div class="relative">
                                    {{-- Glow Effect --}}
                                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full blur-lg opacity-60 animate-pulse"></div>

                                    {{-- Badge Content --}}
                                    <div class="relative bg-gradient-to-r from-yellow-400 via-orange-400 to-pink-500 text-white px-3 py-1.5 rounded-full text-xs font-bold flex items-center gap-1.5 shadow-xl">
                                        <i class="bi bi-star-fill animate-spin" style="animation: spin 3s linear infinite;"></i>
                                        <span>{{ round($rec['best_score']) }}% Match</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Card Header với Gradient --}}
                            <div class="card-header" style="background: linear-gradient(135deg, #f59e0b 0%, #ec4899 100%);"></div>

                            {{-- Avatar --}}
                            <div class="card-avatar">
                                @if($rec['applicant']->avatar)
                                <img src="{{ asset('assets/img/avt/' . $rec['applicant']->avatar) }}"
                                    alt="{{ $rec['applicant']->hoten_uv }}"
                                    class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full bg-gradient-to-br from-orange-500 to-pink-500 flex items-center justify-center text-white text-2xl font-bold">
                                    {{ strtoupper(substr($rec['applicant']->hoten_uv, 0, 1)) }}
                                </div>
                                @endif
                            </div>

                            {{-- Card Content --}}
                            <div class="card-content">
                                <h3 class="candidate-name">
                                    {{ $rec['applicant']->hoten_uv }}
                                </h3>
                                <p class="candidate-title">
                                    {{ $rec['applicant']->vitriungtuyen ?? 'Chưa cập nhật' }}
                                </p>

                                {{-- Match Score Breakdown --}}
                                <div class="bg-gradient-to-r from-orange-50 to-pink-50 rounded-lg p-3 mb-3">
                                    <div class="text-xs space-y-1.5">
                                        {{-- Location Match --}}
                                        @if(isset($rec['matched_jobs'][0]['match_details']['location']))
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-600 flex items-center gap-1">
                                                <i class="bi bi-geo-alt text-orange-500"></i>
                                                Địa điểm
                                            </span>
                                            <div class="flex items-center gap-1">
                                                <div class="w-16 bg-gray-200 rounded-full h-1.5">
                                                    <div class="bg-gradient-to-r from-orange-400 to-pink-500 h-1.5 rounded-full"
                                                        data-score="{{ round($rec['matched_jobs'][0]['match_details']['location']['score']) }}"></div>
                                                </div>
                                                <span class="font-bold text-orange-600 text-xs">
                                                    {{ round($rec['matched_jobs'][0]['match_details']['location']['score']) }}%
                                                </span>
                                            </div>
                                        </div>
                                        @endif

                                        {{-- Skills Match --}}
                                        @if(isset($rec['matched_jobs'][0]['match_details']['skills']))
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-600 flex items-center gap-1">
                                                <i class="bi bi-lightbulb text-orange-500"></i>
                                                Kỹ năng
                                            </span>
                                            <div class="flex items-center gap-1">
                                                <div class="w-16 bg-gray-200 rounded-full h-1.5">
                                                    <div class="bg-gradient-to-r from-orange-400 to-pink-500 h-1.5 rounded-full"
                                                        data-score="{{ round($rec['matched_jobs'][0]['match_details']['skills']['score']) }}"></div>
                                                </div>
                                                <span class="font-bold text-orange-600 text-xs">
                                                    {{ round($rec['matched_jobs'][0]['match_details']['skills']['score']) }}%
                                                </span>
                                            </div>
                                        </div>
                                        @endif

                                        {{-- Position Match --}}
                                        @if(isset($rec['matched_jobs'][0]['match_details']['position']))
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-600 flex items-center gap-1">
                                                <i class="bi bi-briefcase text-orange-500"></i>
                                                Vị trí
                                            </span>
                                            <div class="flex items-center gap-1">
                                                <div class="w-16 bg-gray-200 rounded-full h-1.5">
                                                    <div class="bg-gradient-to-r from-orange-400 to-pink-500 h-1.5 rounded-full"
                                                        data-score="{{ round($rec['matched_jobs'][0]['match_details']['position']['score']) }}"></div>
                                                </div>
                                                <span class="font-bold text-orange-600 text-xs">
                                                    {{ round($rec['matched_jobs'][0]['match_details']['position']['score']) }}%
                                                </span>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="btn-container" style="display: flex; gap: 0.5rem; flex-direction: column; margin-top: auto;">
                                    <button data-candidate-id="{{ $rec['applicant']->id_uv }}" class="btn-view-profile btn-view-cv-rec">
                                        <i class="bi bi-eye mr-1"></i> Xem hồ sơ
                                    </button>
                                    <button data-candidate-id="{{ $rec['applicant']->id_uv }}" class="btn-invite btn-invite-rec">
                                        <i class="bi bi-person-plus-fill"></i> Mời ứng viên
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </main>
        </div>
    </div>

    <!-- Modal: CV -->
    <div id="viewCVModalEmployer" class="modal">
        <div class="modal-content" style="max-width: 900px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 24px; display: flex; align-items: center; justify-content: space-between; color: white; border-radius: 16px 16px 0 0;">
                <h3 class="modal-title" style="font-size: 20px; font-weight: 700; margin: 0;">
                    <i class="bi bi-file-earmark-person"></i>
                    Hồ sơ ứng viên
                </h3>
                <button class="modal-close" onclick="closeViewCVModal()" style="width: 36px; height: 36px; border-radius: 8px; border: none; background: rgba(255, 255, 255, 0.2); cursor: pointer; display: flex; align-items: center; justify-content: center; color: white; transition: all 0.2s;">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="modal-body" id="cvContent" style="padding: 24px; max-height: 80vh; overflow-y: auto;">
                <!-- CV content will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Modal Overlay Style -->
    <style>
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.2s;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            animation: slideUp 0.3s;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
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
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
    </div>
    <!-- MODAL GỬI THÔNG TIN TUYỂN DỤNG -->
    <div id="inviteModal" class="modal-overlay hidden" onclick="closeInviteModal(event)">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="text-lg font-semibold">Mời ứng viên</h3>
                <button onclick="closeInviteModal(event)" class="text-white">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="inviteJobsList" class="space-y-4">
                    <!-- Danh sách job sẽ được nạp qua AJAX -->
                </div>
            </div>
            <div class="p-4 border-t border-gray-200">
                <button onclick="closeInviteModal(event)" class="w-full px-4 py-2 bg-gray-200 rounded-lg font-semibold hover:bg-gray-300 transition-all">
                    Đóng
                </button>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SCRIPT CHÍNH -->
    <!-- THAY THẾ PHẦN SCRIPT CHÍNH (từ dòng <script> cuối cùng) -->

    <script>
        let currentCandidateId = null;
        let currentInviteCandidate = null;

        // ============ KHỞI ĐỘNG FILTER DROPDOWN ============
        document.addEventListener('DOMContentLoaded', function() {
            initializeFilterDropdowns();
            initializeRecommendedCards();
            restoreFilterStates();

            // ✅ Add close modal handler for CV Modal
            document.getElementById('viewCVModalEmployer')?.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeViewCVModal();
                }
            });

            // ✅ Close modal on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && document.getElementById('viewCVModalEmployer')?.classList.contains('active')) {
                    closeViewCVModal();
                }
            });

            // ✅ Thêm event listener cho pagination buttons
            document.querySelectorAll('.pagination-btn[data-page]').forEach(btn => {
                btn.addEventListener('click', function() {
                    const page = this.getAttribute('data-page');
                    if (page) {
                        goToPage(parseInt(page));
                    }
                });
            });

            // ✅ Thêm event listener cho recommended CV buttons
            document.querySelectorAll('.btn-view-cv-rec').forEach(btn => {
                btn.addEventListener('click', function() {
                    const candidateId = this.getAttribute('data-candidate-id');
                    if (candidateId) {
                        viewCV(candidateId);
                    }
                });
            });

            // ✅ Thêm event listener cho recommended invite buttons
            document.querySelectorAll('.btn-invite-rec').forEach(btn => {
                btn.addEventListener('click', function() {
                    const candidateId = this.getAttribute('data-candidate-id');
                    if (candidateId) {
                        inviteCandidate(candidateId);
                    }
                });
            });

            // ✅ Áp dụng width từ data-score attribute cho progress bars
            document.querySelectorAll('[data-score]').forEach(el => {
                const score = el.getAttribute('data-score');
                if (score) {
                    el.style.width = score + '%';
                }
            });
        });

        // ============ KHỞI TẠO FILTER DROPDOWNS ============
        function initializeFilterDropdowns() {
            const filterButtons = document.querySelectorAll('[id$="FilterBtn"]');

            // Thêm sự kiện click cho mỗi button
            filterButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleDropdown(this);
                });
            });

            // Đóng dropdown khi click ngoài
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.filter-dropdown-wrapper')) {
                    closeAllDropdowns();
                }
            });

            // ✅ FIX: Ngăn dropdown đóng khi click vào bên trong
            document.querySelectorAll('.filter-dropdown-menu').forEach(menu => {
                menu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });

            // ✅ FIX: Submit form khi thay đổi checkbox/radio
            document.querySelectorAll('.filter-dropdown-menu input[type="checkbox"], .filter-dropdown-menu input[type="radio"]').forEach(input => {
                input.addEventListener('change', function(e) {
                    e.stopPropagation();
                    updateFilterButtonState(this);

                    // ✅ Delay để user có thể chọn nhiều checkbox
                    clearTimeout(window.filterSubmitTimeout);
                    window.filterSubmitTimeout = setTimeout(() => {
                        applyFiltersAuto();
                    }, 800); // 800ms delay
                });
            });

            // Skill search
            const skillSearch = document.getElementById('skillSearch');
            if (skillSearch) {
                skillSearch.addEventListener('input', function(e) {
                    e.stopPropagation();
                    const query = this.value.toLowerCase();
                    document.querySelectorAll('#skillsDropdown .filter-checkbox-item').forEach(item => {
                        const text = item.textContent.toLowerCase();
                        item.style.display = text.includes(query) ? 'flex' : 'none';
                    });
                });

                skillSearch.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        }

        // ============ TOGGLE DROPDOWN ============
        function toggleDropdown(btn) {
            const dropdownId = btn.id.replace('FilterBtn', 'Dropdown');
            const menu = document.getElementById(dropdownId);

            if (!menu) {
                console.warn(`❌ Không tìm thấy dropdown: ${dropdownId}`);
                return;
            }

            const isCurrentlyOpen = menu.classList.contains('show');

            // Đóng các dropdown khác
            document.querySelectorAll('.filter-dropdown-menu.show').forEach(m => {
                if (m !== menu) {
                    m.classList.remove('show');
                }
            });

            // Đóng các button khác
            document.querySelectorAll('[id$="FilterBtn"]').forEach(b => {
                if (b !== btn && !b.classList.contains('btn-reset')) {
                    b.classList.remove('active');
                }
            });

            // Toggle dropdown hiện tại
            if (isCurrentlyOpen) {
                menu.classList.remove('show');
                btn.classList.remove('active');
            } else {
                menu.classList.add('show');
                btn.classList.add('active');
            }
        }

        // ============ ĐÓNG TẤT CẢ DROPDOWNS ============
        function closeAllDropdowns() {
            document.querySelectorAll('.filter-dropdown-menu').forEach(m => {
                m.classList.remove('show');
            });
            document.querySelectorAll('[id$="FilterBtn"]:not(.btn-reset)').forEach(btn => {
                const dropdown = document.getElementById(btn.id.replace('FilterBtn', 'Dropdown'));
                if (dropdown) {
                    const hasChecked = dropdown.querySelector('input:checked');
                    if (hasChecked) {
                        btn.classList.add('active');
                    } else {
                        btn.classList.remove('active');
                    }
                }
            });
        }

        // ============ CẬP NHẬT FILTER BUTTON STATE ============
        function updateFilterButtonState(input) {
            const dropdown = input.closest('.filter-dropdown-menu');
            const button = dropdown?.parentElement.querySelector('.filter-btn');

            if (dropdown && button) {
                const hasChecked = dropdown.querySelector('input:checked');
                button.classList.toggle('active', !!hasChecked);
            }
        }

        // ============ RESTORE FILTER BUTTON STATES ============
        function restoreFilterStates() {
            const filterButtons = [{
                    id: 'experienceFilterBtn',
                    name: 'experience[]'
                },
                {
                    id: 'educationFilterBtn',
                    name: 'education[]'
                },
                {
                    id: 'salaryFilterBtn',
                    name: 'salary[]'
                },
                {
                    id: 'languageFilterBtn',
                    name: 'language[]'
                },
                {
                    id: 'genderFilterBtn',
                    name: 'gender'
                },
                {
                    id: 'skillsFilterBtn',
                    name: 'skills[]'
                }
            ];

            filterButtons.forEach(btn => {
                const element = document.getElementById(btn.id);
                if (element) {
                    const hasChecked = document.querySelector(`input[name="${btn.name}"]:checked`);
                    if (hasChecked) {
                        element.classList.add('active');
                    }
                }
            });
        }

        // ============ APPLY FILTERS - TỰ ĐỘNG ============
        function applyFiltersAuto() {
            const params = new URLSearchParams();

            // ✅ FIX: Lấy keyword & location từ input
            const keyword = document.getElementById('searchKeyword')?.value?.trim() || '';
            const location = document.getElementById('locationFilter')?.value?.trim() || '';

            console.log('📤 Sending params:', {
                keyword,
                location
            });

            if (keyword) params.append('keyword', keyword);
            if (location) params.append('location', location);

            // Experience filter
            document.querySelectorAll('input[name="experience[]"]:checked').forEach(el => {
                params.append('experience[]', el.value);
            });

            // Education filter
            document.querySelectorAll('input[name="education[]"]:checked').forEach(el => {
                params.append('education[]', el.value);
            });

            // Salary filter
            document.querySelectorAll('input[name="salary[]"]:checked').forEach(el => {
                params.append('salary[]', el.value);
            });

            // Language filter
            document.querySelectorAll('input[name="language[]"]:checked').forEach(el => {
                params.append('language[]', el.value);
            });

            // Skills filter
            document.querySelectorAll('input[name="skills[]"]:checked').forEach(el => {
                params.append('skills[]', el.value);
            });

            // Gender (radio)
            const genderSelected = document.querySelector('input[name="gender"]:checked');
            if (genderSelected && genderSelected.value) {
                params.append('gender', genderSelected.value);
            }

            // Sort
            const sortBy = document.getElementById('sortBy')?.value;
            if (sortBy) params.append('sort', sortBy);

            // Navigate
            const queryString = params.toString();
            const url = `{{ route('employer.candidates') }}${queryString ? '?' + queryString : ''}`;

            console.log('🔄 Full URL:', url);
            window.location.href = url;
        }


        function searchCandidates() {
            // ✅ FIX: Capture search values từ input fields
            const keyword = document.getElementById('searchKeyword')?.value?.trim() || '';
            const location = document.getElementById('locationFilter')?.value?.trim() || '';

            console.log('🔍 Search values captured:', {
                keyword,
                location
            });

            // ✅ Cập nhật hidden input
            document.getElementById('keywordInput').value = keyword;
            document.getElementById('locationInput').value = location;

            // ✅ Gọi hàm apply filters
            clearTimeout(window.filterSubmitTimeout);
            window.filterSubmitTimeout = setTimeout(() => {
                applyFiltersAuto();
            }, 300);
        }

        // ============ ENTER KEY SEARCH ============
        document.getElementById('searchKeyword')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchCandidates();
            }
        });

        // ============ LOCATION CHANGE ============
        document.getElementById('locationFilter')?.addEventListener('change', function() {
            searchCandidates();
        });

        // ============ RESET FILTERS ============
        function resetFilters(event) {
            if (event) {
                event.preventDefault();
            }

            // Xóa tất cả input
            document.getElementById('searchKeyword').value = '';
            document.getElementById('locationFilter').value = '';

            // Xóa tất cả checkbox/radio
            document.querySelectorAll(
                'input[name="experience[]"],' +
                'input[name="education[]"],' +
                'input[name="salary[]"],' +
                'input[name="language[]"],' +
                'input[name="gender"],' +
                'input[name="skills[]"]'
            ).forEach(el => {
                el.checked = false;
            });

            // Reset button states
            document.querySelectorAll('.filter-btn:not(.btn-reset)').forEach(btn => {
                btn.classList.remove('active');
            });

            // Đóng dropdowns
            closeAllDropdowns();

            // Reload trang
            setTimeout(() => {
                window.location.href = '{{ route("employer.candidates") }}';
            }, 100);
        }

        // ============ PAGINATION ============
        function goToPage(page) {
            const url = new URL(window.location.href);
            url.searchParams.set('page', page);
            window.location.href = url.toString();
        }

        // ============ SORT CANDIDATES ============
        function sortCandidates() {
            clearTimeout(window.filterSubmitTimeout);
            applyFiltersAuto();
        }

        // ============ VIEW CV ============
        function viewCV(candidateId) {
            viewCVEmployer(candidateId);
        }
        // ============ VIEW CV EMPLOYER - MAIN FUNCTION ============
        function viewCVEmployer(candidateId) {
            currentCandidateId = candidateId;

            // Load data
            fetch(`/employer/candidates/${candidateId}`)
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    generateEmployerCVHTML(data);
                })
                .catch(error => {
                    console.error('❌ Error loading CV:', error);
                    alert('❌ Có lỗi xảy ra khi tải CV: ' + error.message);
                });
        }
        // ============ OPTIMIZE: Debounce search ============
        const searchDebounce = debounce(() => applyFiltersAuto(), 500);



        // ============ DEBOUNCE UTILITY ============
        function debounce(func, delay) {
            let timeoutId;
            return function(...args) {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(() => func.apply(this, args), delay);
            };
        }
        // ============ CLOSE MODAL CV ============
        function closeModal(event) {
            // Nếu click vào nút X hoặc click vào overlay
            if (!event || event.target.id === 'cvModal' || event.currentTarget?.id === 'cvModal') {
                document.getElementById('cvModal').classList.add('hidden');
                currentCandidateId = null;
            }
        }


        // ============ DOWNLOAD CV ============
        function downloadCV() {
            if (!currentCandidateId) return;
            window.location.href = `/employer/candidates/${currentCandidateId}/download-cv`;
        }

        // ============ CONTACT CANDIDATE ============
        function contactCandidate() {
            if (!currentCandidateId) return;
            window.location.href = `/employer/candidates/${currentCandidateId}/contact`;
        }

        // ============ RECOMMENDED CARDS ============
        function initializeRecommendedCards() {
            const recommendedCards = document.querySelectorAll('.candidate-card:has(.bg-gradient-to-r)');
            recommendedCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        }

        function toggleRecommendedSection() {
            const grid = document.getElementById('recommendedCandidatesGrid');
            const btn = event.target.closest('button');

            if (!grid || !btn) return;

            if (grid.style.display === 'none') {
                grid.style.display = 'grid';
                btn.innerHTML = '<i class="bi bi-eye mr-2"></i> Xem tất cả';
            } else {
                grid.style.display = 'none';
                btn.innerHTML = '<i class="bi bi-eye-slash mr-2"></i> Ẩn bớt';
            }
        }
        // ============ INVITE FUNCTIONS ============
        // ============ INVITE FUNCTIONS ============
        function inviteCandidate(candidateId) {
            currentInviteCandidate = candidateId;
            const modal = document.getElementById('inviteModal');
            const jobsList = document.getElementById('inviteJobsList');

            modal.classList.remove('hidden');
            jobsList.innerHTML = '<div class="loading"><div class="spinner"></div></div>';

            fetch(`/employer/jobs/active-unfilled`)
                .then(response => {
                    if (!response.ok) throw new Error('Failed to fetch jobs');
                    return response.json();
                })
                .then(data => {
                    if (data.jobs && data.jobs.length > 0) {
                        // ✅ FIX: Hiển thị jobs NGAY với invitationMap = {}
                        // Sau đó check status ở background
                        jobsList.innerHTML = generateJobsListHTML(data.jobs, {}, candidateId);

                        // ✅ Check invitation status song song (không block)
                        checkAllInvitationStatus(candidateId, data.jobs)
                            .then(invitationMap => {
                                // ✅ Re-render với status mới
                                jobsList.innerHTML = generateJobsListHTML(data.jobs, invitationMap, candidateId);
                            });
                    } else {
                        jobsList.innerHTML = `
            <div class="empty-state">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-16 h-16 mx-auto mb-4 text-gray-300">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0114 0z" />
                </svg>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Không có vị trí nào còn hạn</h3>
                <p class="text-gray-600">Hiện tại bạn không có vị trí nào cần tuyển dụng</p>
            </div>
        `;
                    }
                })
                .catch(error => {
                    console.error('❌ Error:', error);
                    jobsList.innerHTML = '<div class="text-center text-red-600 py-8">❌ Có lỗi xảy ra khi tải danh sách vị trí</div>';
                });
        }

        // ✅ CHECK TẤT CẢ LỜI MỜI - PARALLEL thay vì sequential
        async function checkAllInvitationStatus(candidateId, jobs) {
            const invitationMap = {};

            // ✅ Promise.all thay vì for loop (nhanh hơn 10x)
            const promises = jobs.map(job =>
                fetch(`/employer/candidates/${candidateId}/job/${job.id}/invitation-status`)
                .then(response => response.json())
                .then(data => {
                    invitationMap[job.id] = data.invited;
                })
                .catch(error => {
                    console.error(`❌ Error checking invitation for job ${job.id}:`, error);
                    invitationMap[job.id] = false;
                })
            );

            await Promise.all(promises);
            return invitationMap;
        }

        // ✅ GENERATE JOBS LIST - THÊM PARAM invitationMap
        // ============ OPTIMIZE: Memoize generateJobsListHTML ============
        const memoizedJobsHTML = {};

        function generateJobsListHTML(jobs, invitationMap = {}, candidateId) {
            const cacheKey = `${candidateId}-${JSON.stringify(invitationMap)}`;

            if (memoizedJobsHTML[cacheKey]) {
                return memoizedJobsHTML[cacheKey];
            }

            const html = `
    <div class="space-y-4" id="jobsList">
        ${jobs.map(job => {
            const isInvited = invitationMap[job.id] ?? false;
            return generateJobCard(job, isInvited, candidateId);
        }).join('')}
    </div>
    `;

            memoizedJobsHTML[cacheKey] = html;

            // ✅ Thêm event listeners sau khi render
            setTimeout(() => {
                const jobsList = document.getElementById('jobsList');
                if (jobsList) {
                    jobsList.querySelectorAll('.btn-invite-job').forEach(btn => {
                        btn.addEventListener('click', () => {
                            const jobId = btn.getAttribute('data-job-id');
                            const jobTitle = btn.getAttribute('data-job-title');
                            confirmInvite(jobId, jobTitle);
                        });
                    });
                }
            }, 0);

            return html;
        }

        function generateJobCard(job, isInvited, candidateId) {
            const skillsHTML = (job.required_skills || []).slice(0, 3)
                .map(skill => `<span class="inline-block px-2.5 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full">${skill}</span>`)
                .join('');

            const moreSkills = Math.max(0, (job.required_skills || []).length - 3);
            // ✅ FIX: Kiểm tra xem job đã đủ số lượng không
            const isFilled = job.quantity && job.received_count && job.received_count >= job.quantity;
            // ✅ Xác định trạng thái nút
            let buttonHTML = '';
            if (isFilled) {
                // ❌ TRẠNG THÁI 1: Job đã đủ - Disable nút
                buttonHTML = `
            <button disabled 
                class="px-6 py-3 bg-gray-400 text-white rounded-lg font-semibold text-sm flex items-center gap-2 flex-shrink-0 cursor-not-allowed opacity-60" 
                title="Vị trí này đã đủ ${job.received_count}/${job.quantity} ứng viên">
                <i class="bi bi-check2-circle"></i>
                <span>Đã đủ</span>
            </button>
        `;
            } else if (isInvited) {
                // ⚪ TRẠNG THÁI 2: Đã mời rồi - Disable nút
                buttonHTML = `
            <button disabled 
                class="px-6 py-3 bg-gray-400 text-white rounded-lg font-semibold text-sm flex items-center gap-2 flex-shrink-0 cursor-not-allowed opacity-75" 
                title="Bạn đã mời ứng viên này cho vị trí này">
                <i class="bi bi-check-circle"></i>
                <span>Đã mời</span>
            </button>
        `;
            } else {
                // ✅ TRẠNG THÁI 3: Có thể mời - Active nút
                const jobIdEscaped = job.id;
                const jobTitleEscaped = escapeHtml(job.job_title).replace(/'/g, "\\'");
                buttonHTML = `
            <button data-job-id="${jobIdEscaped}" data-job-title="${jobTitleEscaped}" class="btn-invite-job px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg font-semibold text-sm hover:shadow-lg transition-all transform hover:scale-105 flex items-center gap-2 flex-shrink-0">
                <i class="bi bi-person-plus-fill"></i>
                <span>Mời</span>
            </button>
        `;
            }

            return `
        <div class="bg-gradient-to-r from-purple-50 to-blue-50 rounded-lg p-4 border-l-4 border-purple-500 hover:shadow-md transition-all">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1">
                    <h4 class="text-lg font-bold text-gray-800 mb-2">${escapeHtml(job.job_title)}</h4>
                    
                    <div class="grid grid-cols-2 gap-3 mb-3 text-sm text-gray-600">
                        <div><i class="bi bi-geo-alt text-purple-600 mr-2"></i>${escapeHtml(job.location)}</div>
                        <div><i class="bi bi-cash-stack text-purple-600 mr-2"></i>${formatSalary(job)}</div>
                        <div><i class="bi bi-people text-purple-600 mr-2"></i>${job.quantity || 0} vị trí</div>
                        <div><i class="bi bi-hourglass-split text-purple-600 mr-2"></i>Hết: ${formatDate(job.deadline)}</div>
                    </div>

                    <div class="mb-3">
                        ${generateProgressBar(job)}
                    </div>

                    <!-- ✅ CẢNH BÁO KHI JOB ĐÃ ĐỦ -->
                    ${isFilled ? `
                        <div class="mb-3 p-2 bg-yellow-100 border-l-4 border-yellow-500 rounded">
                            <p class="text-xs text-yellow-800 font-semibold flex items-center gap-1">
                                <i class="bi bi-info-circle"></i>
                                Vị trí này đã đủ số lượng ứng viên (${job.received_count}/${job.quantity})
                            </p>
                        </div>
                    ` : ''}

                    <div class="flex flex-wrap gap-2">
                        ${skillsHTML}
                        ${moreSkills > 0 ? `<span class="inline-block px-2.5 py-1 bg-gray-200 text-gray-700 text-xs font-semibold rounded-full">+${moreSkills}</span>` : ''}
                    </div>
                </div>

                <!-- ✅ NÚT MỜI (ĐÃ CẬP NHẬT) -->
                ${buttonHTML}
            </div>
        </div>
    `;



        }

        function generateProgressBar(job) {
            const percent = job.quantity ? Math.round((job.received_count || 0) / job.quantity * 100) : 0;
            return `
        <div class="flex items-center justify-between mb-1">
            <span class="text-xs font-semibold text-gray-700">Đã nhận: <span class="text-purple-600">${job.received_count || 0}</span>/${job.quantity || 0}</span>
            <span class="text-xs font-bold text-purple-600">${percent}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-gradient-to-r from-purple-500 to-blue-500 h-2 rounded-full transition-all duration-300" style="width: ${percent}%"></div>
        </div>
    `;
        }

        function formatSalary(job) {
            return job.salary_min ? `${job.salary_min} - ${job.salary_max} VNĐ` : 'Thỏa thuận';
        }

        function formatDate(dateString) {
            try {
                const date = new Date(dateString);
                return date.toLocaleDateString('vi-VN', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit'
                });
            } catch (e) {
                return dateString || 'N/A';
            }
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        // ✅ CONFIRM INVITE - CẬP NHẬT BUTTON NGAY
        function confirmInvite(jobId, jobTitle) {
            if (!currentInviteCandidate) return;

            if (!confirm(`Bạn chắc chắn muốn mời ứng viên cho vị trí "${jobTitle}" không?`)) {
                return;
            }

            fetch(`/employer/candidates/${currentInviteCandidate}/invite`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        job_id: jobId
                    })
                })
                .then(response => {
                    console.log('📡 Response status:', response.status);
                    console.log('📡 Response ok:', response.ok);

                    // ✅ FIX: Check response.ok TRƯỚC khi .json()
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || 'Network response was not ok');
                        });
                    }

                    return response.json();
                })
                .then(data => {
                    console.log('✅ Success response:', data);

                    if (data.success) {
                        alert('✅ Đã gửi lời mời thành công!');

                        // ✅ CẬP NHẬT BUTTON THÀNH "ĐÃ MỜI"
                        const inviteBtn = document.querySelector(
                            `button[onclick*="confirmInvite(${jobId}"]`
                        );

                        if (inviteBtn) {
                            inviteBtn.disabled = true;
                            inviteBtn.className = 'px-6 py-3 bg-gray-400 text-white rounded-lg font-semibold text-sm flex items-center gap-2 flex-shrink-0 cursor-not-allowed opacity-75';
                            inviteBtn.innerHTML = '<i class="bi bi-check-circle"></i><span>Đã mời</span>';
                            inviteBtn.onclick = null;
                        }

                        closeInviteModal();
                        currentInviteCandidate = null;
                    } else {
                        alert('❌ Lỗi: ' + (data.message || 'Không thể gửi lời mời'));
                    }
                })
                .catch(error => {
                    console.error('❌ Catch error:', error);
                    alert('❌ ' + error.message);
                });
        }

        // ============ CLOSE MODAL INVITE ============
        function closeInviteModal(event) {
            // Nếu click vào nút X hoặc click vào overlay
            if (!event || event.target.id === 'inviteModal' || event.currentTarget?.id === 'inviteModal') {
                document.getElementById('inviteModal').classList.add('hidden');
                currentInviteCandidate = null;
            }
        }
    </script>
    <!-- ✅ SCRIPT XỬ LÝ MODAL CV -->
    <script>
        // ✅ GENERATE CV HTML CHO EMPLOYER
        // Thay thế hàm generateEmployerCVHTML hiện tại

        // ============ CLOSE CV MODAL ============
        function closeViewCVModal() {
            document.getElementById('viewCVModalEmployer').classList.remove('active');
            document.body.style.overflow = '';
        }

        // ✅ GENERATE CV HTML CHO EMPLOYER - MATCH JOB-APPLICANTS-NEW STYLE
        function generateEmployerCVHTML(candidate) {
            let cvHTML = `<div class="cv-flex">
                <!-- Left Column -->
                <div class="cv-left">
                    <div style="text-align: center; margin-bottom: 24px; width: 100%;">
                        <img src="${candidate.avatar ? '/assets/img/avt/' + candidate.avatar : '/assets/img/avt/default-avatar.png'}" 
                             alt="Avatar" class="cv-avatar">
                        <h4 style="font-size: 18px; font-weight: 700; color: #1f2937; margin-bottom: 4px;">${candidate.hoten_uv || 'N/A'}</h4>
                        <p style="font-size: 14px; color: #6b7280;">${candidate.vitriungtuyen || 'Chức danh'}</p>
                    </div>
                    
                    <div style="display: flex; flex-direction: column; gap: 12px; font-size: 13px; width: 100%;">
                        ${candidate.user && candidate.user.email ? `
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="bi bi-envelope" style="color: #667eea;"></i>
                            <span style="color: #374151; word-break: break-word;">${candidate.user.email}</span>
                        </div>` : ''}
                        ${candidate.sdt_uv ? `
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="bi bi-telephone" style="color: #667eea;"></i>
                            <span style="color: #374151;">${candidate.sdt_uv}</span>
                        </div>` : ''}
                        ${candidate.diachi_uv ? `
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="bi bi-geo-alt" style="color: #667eea;"></i>
                            <span style="color: #374151;">${candidate.diachi_uv}</span>
                        </div>` : ''}
                        ${candidate.ngaysinh ? `
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="bi bi-calendar" style="color: #667eea;"></i>
                            <span style="color: #374151;">${new Date(candidate.ngaysinh).toLocaleDateString('vi-VN')}</span>
                        </div>` : ''}
                    </div>

                    ${candidate.ngoai_ngu && candidate.ngoai_ngu.length > 0 ? `
                    <hr style="margin: 16px 0; border: none; border-top: 1px solid #e5e7eb;">
                    <h6 style="font-size: 14px; font-weight: 700; color: #1f2937; margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
                        <i class="bi bi-translate" style="color: #f59e0b;"></i>
                        Ngoại ngữ
                    </h6>
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        ${candidate.ngoai_ngu.map(item => `
                            <div style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;">
                                <p style="font-size: 12px; color: #6b7280; margin: 0 0 2px 0; text-transform: uppercase; font-weight: 600;">${item.ten_ngoai_ngu}</p>
                                <p style="font-size: 13px; color: #374151; margin: 0;">${item.trinh_do}</p>
                            </div>
                        `).join('')}
                    </div>
                    ` : ''}
                </div>
                
                <!-- Right Column -->
                <div style="flex: 1;">
                    ${candidate.gioithieu ? `
                    <div style="margin-bottom: 24px;">
                        <h5 style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; border-bottom: 2px solid #667eea; padding-bottom: 8px;">
                            <i class="bi bi-person-lines-fill" style="color: #667eea;"></i>
                            Giới thiệu bản thân
                        </h5>
                        <p style="color: #374151; line-height: 1.6; white-space: pre-line;">${candidate.gioithieu}</p>
                    </div>` : ''}
                    
                    ${candidate.kinhnghiem && candidate.kinhnghiem.length > 0 ? `
                    <div style="margin-bottom: 24px;">
                        <h5 style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; border-bottom: 2px solid #667eea; padding-bottom: 8px;">
                            <i class="bi bi-briefcase" style="color: #667eea;"></i>
                            Kinh nghiệm làm việc
                        </h5>
                        <div style="display: flex; flex-direction: column; gap: 16px;">
                            ${candidate.kinhnghiem.map(item => `
                                <div style="border-left: 3px solid #667eea; padding-left: 16px;">
                                    <h6 style="font-weight: 700; color: #1f2937; margin-bottom: 4px;">${item.chucdanh}</h6>
                                    <p style="font-size: 14px; color: #6b7280; margin-bottom: 2px;">${item.congty}</p>
                                    <p style="font-size: 12px; color: #9ca3af;">${new Date(item.tu_ngay).toLocaleDateString('vi-VN')} - ${item.den_ngay ? new Date(item.den_ngay).toLocaleDateString('vi-VN') : 'Hiện tại'}</p>
                                    ${item.mota ? `<p style="font-size: 14px; color: #374151; margin-top: 8px;">${item.mota}</p>` : ''}
                                </div>
                            `).join('')}
                        </div>
                    </div>` : ''}
                    
                    ${candidate.hocvan && candidate.hocvan.length > 0 ? `
                    <div style="margin-bottom: 24px;">
                        <h5 style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; border-bottom: 2px solid #48bb78; padding-bottom: 8px;">
                            <i class="bi bi-mortarboard" style="color: #48bb78;"></i>
                            Học vấn
                        </h5>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            ${candidate.hocvan.map(item => `
                                <div style="border-left: 3px solid #48bb78; padding-left: 16px;">
                                    <h6 style="font-weight: 700; color: #1f2937; margin-bottom: 4px;">${item.truong}</h6>
                                    <p style="font-size: 14px; color: #6b7280; margin-bottom: 2px;">${item.nganh} - ${item.trinhdo || item.trinh_do}</p>
                                    <p style="font-size: 12px; color: #9ca3af;">${new Date(item.tu_ngay).getFullYear()} - ${item.den_ngay ? new Date(item.den_ngay).getFullYear() : 'Hiện tại'}</p>
                                </div>
                            `).join('')}
                        </div>
                    </div>` : ''}
                    
                    ${candidate.kynang && candidate.kynang.length > 0 ? `
                    <div style="margin-bottom: 24px;">
                        <h5 style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; border-bottom: 2px solid #667eea; padding-bottom: 8px;">
                            <i class="bi bi-star" style="color: #667eea;"></i>
                            Kỹ năng
                        </h5>
                        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                            ${candidate.kynang.map(item => `
                                <span style="padding: 8px 14px; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); color: #1e40af; border-radius: 16px; font-size: 13px; font-weight: 700;">
                                    ${item.ten_ky_nang}${item.nam_kinh_nghiem ? ` - ${item.nam_kinh_nghiem} năm` : ''}
                                </span>
                            `).join('')}
                        </div>
                    </div>` : ''}
                    
                    ${candidate.duan && candidate.duan.length > 0 ? `
                    <div style="margin-bottom: 24px;">
                        <h5 style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; border-bottom: 2px solid #06b6d4; padding-bottom: 8px;">
                            <i class="bi bi-kanban" style="color: #06b6d4;"></i>
                            Dự án nổi bật
                        </h5>
                        <div style="display: flex; flex-direction: column; gap: 16px;">
                            ${candidate.duan.map(item => `
                                <div style="border-left: 3px solid #06b6d4; padding-left: 16px;">
                                    <h6 style="font-weight: 700; color: #1f2937; margin-bottom: 4px;">${item.ten_duan}</h6>
                                    <p style="font-size: 12px; color: #9ca3af; margin-bottom: 8px;">
                                        <i class="bi bi-calendar"></i>
                                        ${new Date(item.ngay_bat_dau).toLocaleDateString('vi-VN')} - 
                                        ${item.dang_lam ? 'Hiện tại' : new Date(item.ngay_ket_thuc).toLocaleDateString('vi-VN')}
                                    </p>
                                    ${item.mota_duan ? `<p style="font-size: 13px; color: #374151; margin-bottom: 8px; white-space: pre-line;">${item.mota_duan}</p>` : ''}
                                    ${item.duongdan_website ? `<p style="font-size: 12px;"><i class="bi bi-link-45deg" style="color: #06b6d4;"></i> <a href="${item.duongdan_website}" target="_blank" style="color: #06b6d4; text-decoration: none;">Xem dự án</a></p>` : ''}
                                </div>
                            `).join('')}
                        </div>
                    </div>` : ''}
                    
                    ${candidate.chungchi && candidate.chungchi.length > 0 ? `
                    <div style="margin-bottom: 24px;">
                        <h5 style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; border-bottom: 2px solid #10b981; padding-bottom: 8px;">
                            <i class="bi bi-award" style="color: #10b981;"></i>
                            Chứng chỉ
                        </h5>
                        <div style="display: flex; flex-direction: column; gap: 16px;">
                            ${candidate.chungchi.map(item => `
                                <div style="border-left: 3px solid #10b981; padding-left: 16px;">
                                    <h6 style="font-weight: 700; color: #1f2937; margin-bottom: 4px;">${item.ten_chungchi}</h6>
                                    <p style="font-size: 13px; color: #6b7280; margin-bottom: 2px;"><i class="bi bi-building"></i> ${item.to_chuc}</p>
                                    <p style="font-size: 12px; color: #9ca3af; margin-bottom: 8px;"><i class="bi bi-calendar"></i> ${new Date(item.thoigian).toLocaleDateString('vi-VN')}</p>
                                    ${item.mo_ta ? `<p style="font-size: 13px; color: #374151; margin-bottom: 8px;">${item.mo_ta}</p>` : ''}
                                    ${item.link_chungchi ? `<p style="font-size: 12px;"><i class="bi bi-link-45deg" style="color: #10b981;"></i> <a href="${item.link_chungchi}" target="_blank" style="color: #10b981; text-decoration: none;">Xem chứng chỉ</a></p>` : ''}
                                </div>
                            `).join('')}
                        </div>
                    </div>` : ''}
                    
                    ${candidate.giaithuong && candidate.giaithuong.length > 0 ? `
                    <div style="margin-bottom: 24px;">
                        <h5 style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; border-bottom: 2px solid #f59e0b; padding-bottom: 8px;">
                            <i class="bi bi-trophy" style="color: #f59e0b;"></i>
                            Giải thưởng
                        </h5>
                        <div style="display: flex; flex-direction: column; gap: 16px;">
                            ${candidate.giaithuong.map(item => `
                                <div style="border-left: 3px solid #f59e0b; padding-left: 16px;">
                                    <h6 style="font-weight: 700; color: #1f2937; margin-bottom: 4px;"><i class="bi bi-trophy-fill" style="color: #f59e0b;"></i> ${item.ten_giaithuong}</h6>
                                    <p style="font-size: 13px; color: #6b7280; margin-bottom: 2px;"><i class="bi bi-building"></i> ${item.to_chuc}</p>
                                    <p style="font-size: 12px; color: #9ca3af; margin-bottom: 8px;"><i class="bi bi-calendar-event"></i> ${new Date(item.thoigian).toLocaleDateString('vi-VN')}</p>
                                    ${item.mo_ta ? `<p style="font-size: 13px; color: #374151;">${item.mo_ta}</p>` : ''}
                                </div>
                            `).join('')}
                        </div>
                    </div>` : ''}
                </div>
            </div>`;

            document.getElementById('cvContent').innerHTML = cvHTML;
            document.getElementById('viewCVModalEmployer').classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    </script>
</body>

</html>