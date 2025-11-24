<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Danh sách ứng viên - {{ $job->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f8f9fa;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header */
        .page-header {
            background: white;
            padding: 24px;
            border-radius: 12px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .page-subtitle {
            font-size: 14px;
            color: #6b7280;
        }

        /* Statistics */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 13px;
            color: #6b7280;
        }

        /* Table */
        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f9fafb;
            border-bottom: 2px solid #e5e7eb;
        }

        th {
            padding: 16px;
            text-align: left;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background: #f9fafb;
        }

        /* Avatar */
        .avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Status badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-chua_xem {
            background: #fef3c7;
            color: #d97706;
        }

        .status-da_xem {
            background: #dbeafe;
            color: #2563eb;
        }

        .status-phong_van {
            background: #dbeafe;
            color: #2563eb;
        }

        .status-duoc_chon {
            background: #d1fae5;
            color: #059669;
        }

        .status-tu_choi {
            background: #fee2e2;
            color: #dc2626;
        }

        /* Action buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .btn-primary {
            background: #6366f1;
            color: white;
        }

        .btn-primary:hover {
            background: #4f46e5;
        }

        .btn-success {
            background: #8b5cf6;
            color: white;
        }

        .btn-success:hover {
            background: #7c3aed;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-secondary {
            background: white;
            color: #6366f1;
            border: 2px solid #6366f1;
        }

        .btn-secondary:hover {
            background: #eef2ff;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
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
        }

        .modal-header {
            padding: 24px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .modal-close {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            background: #f3f4f6;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .modal-close:hover {
            background: #e5e7eb;
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        /* Form elements */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-radio-group {
            display: flex;
            gap: 16px;
        }

        .form-radio-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .form-radio-label:hover {
            border-color: #3b82f6;
        }

        .form-radio-label input[type="radio"] {
            accent-color: #3b82f6;
        }

        .form-radio-label input[type="radio"]:checked+span {
            color: #3b82f6;
            font-weight: 600;
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

        /* Loading */
        .loading {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="page-header">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <h1 class="page-title">Danh sách ứng viên</h1>
                    <p class="page-subtitle">{{ $job->title }}</p>
                </div>
                <a href="{{ route('employer.dashboard') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Quay lại
                </a>
            </div>
        </div>

        <!-- Statistics -->
        <!-- Phần Statistics - FIX trạng thái -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value" style="color: #1f2937;">{{ $statistics['total'] }}</div>
                <div class="stat-label">Tổng số</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: #d97706;">{{ $statistics['cho_xu_ly'] }}</div>
                <div class="stat-label">Chờ xử lý</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: #2563eb;">{{ $statistics['dang_phong_van'] }}</div>
                <div class="stat-label">Đang phỏng vấn</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: #059669;">{{ $statistics['duoc_chon'] }}</div>
                <div class="stat-label">Được chọn</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: #dc2626;">{{ $statistics['khong_phu_hop'] }}</div>
                <div class="stat-label">Không phù hợp</div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">STT</th>
                        <th>Ứng viên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Trạng thái</th>
                        <th style="width: 300px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $index => $application)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <img src="{{ $application->applicant->avatar ? asset('assets/img/avt/'.$application->applicant->avatar) : asset('assets/img/avt/default-avatar.png') }}"
                                    alt="Avatar" class="avatar">
                                <div>
                                    <div style="font-weight: 600; color: #1a1a1a;">{{ $application->hoten }}</div>
                                    <div style="font-size: 13px; color: #6b7280;">{{ $application->applicant->chucdanh ?? 'Chưa cập nhật' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size: 14px; color: #374151;">{{ $application->email }}</div>
                        </td>
                        <td>
                            <div style="font-size: 14px; color: #374151;">{{ $application->sdt }}</div>
                        </td>
                        <!-- Phần Status Badge trong table - FIX -->
                        <td>
                            <span class="status-badge status-{{ $application->trang_thai }}" id="status-badge-{{ $application->application_id }}">
                                @switch($application->trang_thai)
                                @case('cho_xu_ly')
                                <i class="bi bi-clock-history"></i> Chờ xử lý
                                @break
                                @case('dang_phong_van')
                                <i class="bi bi-calendar-check"></i> Đang phỏng vấn
                                @break
                                @case('duoc_chon')
                                <i class="bi bi-check-circle"></i> Được chọn
                                @break
                                @case('khong_phu_hop')
                                <i class="bi bi-x-circle"></i> Không phù hợp
                                @break
                                @endswitch
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn btn-primary" onclick="viewCV('{{ $application->application_id }}')">
                                    <i class="bi bi-eye"></i>
                                    Xem CV
                                </button>

                                @if($application->trang_thai == 'cho_xu_ly')
                                <!-- Chờ xử lý: Hiển thị Mời PV và Không phù hợp -->
                                <button class="btn btn-success" onclick="openInterviewModal('{{ $application->application_id }}', '{{ $application->hoten }}', '{{ $application->email }}')">
                                    <i class="bi bi-calendar-check"></i>
                                    Mời PV
                                </button>
                                <button class="btn btn-danger" onclick="rejectApplicant('{{ $application->application_id }}')">
                                    <i class="bi bi-x-circle"></i>
                                    Không phù hợp
                                </button>
                                @elseif($application->trang_thai == 'dang_phong_van')
                                <!-- Đang phỏng vấn: Hiển thị Chọn đậu và Từ chối -->
                                <button class="btn btn-success" onclick="approveApplicant('{{ $application->application_id }}', '{{ $application->hoten }}', '{{ $application->email }}')">
                                    <i class="bi bi-check-circle"></i>
                                    Chọn đậu
                                </button>
                                <button class="btn btn-danger" onclick="rejectApplicant('{{ $application->application_id }}')">
                                    <i class="bi bi-x-circle"></i>
                                    Từ chối
                                </button>
                                @endif
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 60px 20px;">
                            <i class="bi bi-inbox" style="font-size: 48px; color: #d1d5db;"></i>
                            <p style="color: #6b7280; margin-top: 12px;">Chưa có ứng viên nào ứng tuyển</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- 2️⃣ THÊM MODAL PHẢN HỒI PHỎNG VẤN -->
    <div id="resultModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="bi bi-check-circle"></i>
                    Xác nhận kết quả phỏng vấn
                </h3>
                <button class="modal-close" onclick="closeModal('resultModal')">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="resultAppId">
                <input type="hidden" id="resultEmail">
                <input type="hidden" id="resultName">

                <div class="form-group">
                    <label class="form-label">Ứng viên</label>
                    <div id="resultCandidateName" style="padding: 12px; background: #f9fafb; border-radius: 8px; font-weight: 600;"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Ghi chú (tùy chọn)</label>
                    <textarea id="resultNote" class="form-textarea" placeholder="VD: Kỹ năng tốt, kinh nghiệm phù hợp..."></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <input type="checkbox" id="sendEmailResult" checked>
                        <span style="margin-left: 8px;">Gửi email thông báo kết quả cho ứng viên</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal('resultModal')">
                    Hủy
                </button>
                <button class="btn btn-success" id="resultBtn" onclick="submitResult()">
                    <i class="bi bi-check-circle"></i>
                    <span id="resultBtnText">Xác nhận</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal: View CV -->
    <div id="cvModal" class="modal">
        <div class="modal-content" style="max-width: 900px;">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="bi bi-file-earmark-person"></i>
                    Hồ sơ ứng viên
                </h3>
                <button class="modal-close" onclick="closeModal('cvModal')">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="modal-body" id="cvContent">
                <!-- CV content will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Modal: Interview Invitation -->
    <div id="interviewModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="bi bi-calendar-check"></i>
                    Mời phỏng vấn
                </h3>
                <button class="modal-close" onclick="closeModal('interviewModal')">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="interviewAppId">
                <input type="hidden" id="interviewEmail">

                <div class="form-group">
                    <label class="form-label">Ứng viên</label>
                    <div id="interviewCandidateName" style="padding: 12px; background: #f9fafb; border-radius: 8px; font-weight: 600;"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Hình thức phỏng vấn</label>
                    <div class="form-radio-group">
                        <label class="form-radio-label" style="flex: 1; border-color: #3b82f6;">
                            <input type="radio" name="interviewType" value="online" checked>
                            <span>
                                <i class="bi bi-camera-video"></i>
                                Online
                            </span>
                        </label>
                        <label class="form-radio-label" style="flex: 1;">
                            <input type="radio" name="interviewType" value="offline">
                            <span>
                                <i class="bi bi-building"></i>
                                Offline
                            </span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-calendar"></i>
                        Ngày phỏng vấn
                    </label>
                    <input type="date" id="interviewDate" class="form-input" min="{{ date('Y-m-d') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-clock"></i>
                        Giờ phỏng vấn
                    </label>
                    <input type="time" id="interviewTime" class="form-input" value="09:00" required>
                </div>

                <div class="form-group" id="locationGroup">
                    <label class="form-label">
                        <i class="bi bi-camera-video"></i>
                        Link meeting
                    </label>
                    <input type="text" id="interviewLocation" class="form-input" placeholder="https://meet.google.com/xxx hoặc để trống để tự tạo">
                    <small style="color: #6b7280; font-size: 12px; display: block; margin-top: 4px;">
                        💡 Có thể để trống, hệ thống sẽ tự tạo link Google Meet
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal('interviewModal')">
                    Hủy
                </button>
                <button class="btn btn-success" onclick="sendInterviewInvitation()">
                    <i class="bi bi-send"></i>
                    Gửi lời mời
                </button>
            </div>
        </div>
    </div>

    <script>
        // =====================================
        // THAY ĐỔI HÌNH THỨC PHỎNG VẤN
        // =====================================
        document.addEventListener('DOMContentLoaded', function() {
            const radioButtons = document.querySelectorAll('input[name="interviewType"]');
            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    const locationGroup = document.getElementById('locationGroup');
                    const locationInput = document.getElementById('interviewLocation');
                    const label = locationGroup.querySelector('.form-label');

                    if (this.value === 'online') {
                        label.innerHTML = '<i class="bi bi-camera-video"></i> Link meeting';
                        locationInput.placeholder = 'https://meet.google.com/xxx hoặc để trống để tự tạo';
                    } else {
                        label.innerHTML = '<i class="bi bi-building"></i> Địa điểm phỏng vấn';
                        locationInput.placeholder = 'VD: Tầng 5, Tòa nhà ABC, 123 Nguyễn Huệ, Q1';
                    }
                });
            });
        });

        // =====================================
        // XEM CV
        // =====================================
        async function viewCV(appId) {
            try {
                const response = await fetch(`/application/${appId}/view-cv`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    const applicant = data.applicant;
                    const application = data.application;

                    let cvHTML = `
                <div style="display: flex; gap: 24px;">
                    <!-- Left Column -->
                    <div style="width: 280px; background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%); padding: 24px; border-radius: 12px;">
                        <div style="text-align: center; margin-bottom: 24px;">
                            <img src="${applicant.avatar ? '/assets/img/avt/' + applicant.avatar : '/assets/img/avt/default-avatar.png'}" 
                                 alt="Avatar" style="width: 120px; height: 120px; border-radius: 50%; margin-bottom: 16px; border: 4px solid white; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                            <h4 style="font-size: 18px; font-weight: 700; color: #1a1a1a; margin-bottom: 4px;">${application.hoten}</h4>
                            <p style="font-size: 14px; color: #6b7280;">${applicant.chucdanh || 'Chức danh'}</p>
                        </div>
                        
                        <div style="display: flex; flex-direction: column; gap: 12px; font-size: 13px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="bi bi-envelope" style="color: #3b82f6;"></i>
                                <span style="color: #374151; word-break: break-word;">${application.email}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="bi bi-telephone" style="color: #3b82f6;"></i>
                                <span style="color: #374151;">${application.sdt}</span>
                            </div>
                            ${application.diachi ? `
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="bi bi-geo-alt" style="color: #3b82f6;"></i>
                                <span style="color: #374151;">${application.diachi}</span>
                            </div>` : ''}
                            ${applicant.ngaysinh ? `
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="bi bi-calendar" style="color: #3b82f6;"></i>
                                <span style="color: #374151;">${new Date(applicant.ngaysinh).toLocaleDateString('vi-VN')}</span>
                            </div>` : ''}
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div style="flex: 1;">
                        ${application.thu_gioi_thieu ? `
                        <div style="margin-bottom: 24px;">
                            <h5 style="font-size: 16px; font-weight: 700; color: #1a1a1a; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                                <i class="bi bi-person-lines-fill" style="color: #3b82f6;"></i>
                                Thư giới thiệu
                            </h5>
                            <p style="color: #374151; line-height: 1.6; white-space: pre-line;">${application.thu_gioi_thieu}</p>
                        </div>` : ''}
                        
                        ${applicant.kinhnghiem && applicant.kinhnghiem.length > 0 ? `
                        <div style="margin-bottom: 24px;">
                            <h5 style="font-size: 16px; font-weight: 700; color: #1a1a1a; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                                <i class="bi bi-briefcase" style="color: #3b82f6;"></i>
                                Kinh nghiệm làm việc
                            </h5>
                            <div style="display: flex; flex-direction: column; gap: 16px;">
                                ${applicant.kinhnghiem.map(item => `
                                    <div style="border-left: 3px solid #3b82f6; padding-left: 16px;">
                                        <h6 style="font-weight: 700; color: #1a1a1a; margin-bottom: 4px;">${item.chucdanh}</h6>
                                        <p style="font-size: 14px; color: #6b7280; margin-bottom: 2px;">${item.congty}</p>
                                        <p style="font-size: 12px; color: #9ca3af;">${new Date(item.tu_ngay).toLocaleDateString('vi-VN')} - ${item.den_ngay ? new Date(item.den_ngay).toLocaleDateString('vi-VN') : 'Hiện tại'}</p>
                                        ${item.mota ? `<p style="font-size: 14px; color: #374151; margin-top: 8px;">${item.mota}</p>` : ''}
                                    </div>
                                `).join('')}
                            </div>
                        </div>` : ''}
                        
                        ${applicant.hocvan && applicant.hocvan.length > 0 ? `
                        <div style="margin-bottom: 24px;">
                            <h5 style="font-size: 16px; font-weight: 700; color: #1a1a1a; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                                <i class="bi bi-mortarboard" style="color: #3b82f6;"></i>
                                Học vấn
                            </h5>
                            <div style="display: flex; flex-direction: column; gap: 12px;">
                                ${applicant.hocvan.map(item => `
                                    <div style="border-left: 3px solid #10b981; padding-left: 16px;">
                                        <h6 style="font-weight: 700; color: #1a1a1a; margin-bottom: 4px;">${item.truong}</h6>
                                        <p style="font-size: 14px; color: #6b7280; margin-bottom: 2px;">${item.nganh} - ${item.trinhdo}</p>
                                        <p style="font-size: 12px; color: #9ca3af;">${new Date(item.tu_ngay).getFullYear()} - ${item.den_ngay ? new Date(item.den_ngay).getFullYear() : 'Hiện tại'}</p>
                                    </div>
                                `).join('')}
                            </div>
                        </div>` : ''}
                        
                        ${applicant.kynang && applicant.kynang.length > 0 ? `
                        <div style="margin-bottom: 24px;">
                            <h5 style="font-size: 16px; font-weight: 700; color: #1a1a1a; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                                <i class="bi bi-star" style="color: #3b82f6;"></i>
                                Kỹ năng
                            </h5>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                                ${applicant.kynang.map(item => `
                                    <span style="padding: 6px 12px; background: #dbeafe; color: #1e40af; border-radius: 16px; font-size: 13px; font-weight: 600;">
                                        ${item.ten_ky_nang}${item.nam_kinh_nghiem ? ` - ${item.nam_kinh_nghiem} năm` : ''}
                                    </span>
                                `).join('')}
                            </div>
                        </div>` : ''}
                    </div>
                </div>
            `;

                    document.getElementById('cvContent').innerHTML = cvHTML;
                    openModal('cvModal');
                } else {
                    alert('Không thể tải CV');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi tải CV');
            }
        }

        // =====================================
        // MỞ MODAL PHỎNG VẤN
        // =====================================
        function openInterviewModal(appId, candidateName, candidateEmail) {
            document.getElementById('interviewAppId').value = appId;
            document.getElementById('interviewEmail').value = candidateEmail;
            document.getElementById('interviewCandidateName').textContent = candidateName;
            document.getElementById('interviewDate').value = '';
            document.getElementById('interviewTime').value = '09:00';
            document.getElementById('interviewLocation').value = '';
            openModal('interviewModal');
        }

        // ✅ FIXED - Gửi lời mời phỏng vấn (Không còn alert trùng)
        async function sendInterviewInvitation() {
            const appId = document.getElementById('interviewAppId').value;
            const email = document.getElementById('interviewEmail').value;
            const date = document.getElementById('interviewDate').value;
            const time = document.getElementById('interviewTime').value;
            const location = document.getElementById('interviewLocation').value;
            const type = document.querySelector('input[name="interviewType"]:checked').value;

            // Validate
            if (!date || !time) {
                alert('Vui lòng chọn ngày và giờ phỏng vấn');
                return;
            }

            if (type === 'offline' && !location) {
                alert('Vui lòng nhập địa điểm phỏng vấn');
                return;
            }

            // Show loading
            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="loading"></span> Đang gửi...';

            try {
                const response = await fetch(`/application/${appId}/send-interview`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email: email,
                        date: date,
                        time: time,
                        location: location || 'Sẽ gửi link sau',
                        type: type
                    })
                });

                // ✅ FIX: Kiểm tra response status trước
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success) {
                    // ✅ Chỉ show 1 thông báo thành công
                    alert('✅ Đã gửi lời mời phỏng vấn thành công!');

                    // Đóng modal
                    closeModal('interviewModal');

                    // Reload sau khi đóng modal
                    setTimeout(() => {
                        location.reload();
                    }, 300);
                } else {
                    // ✅ Chỉ show 1 thông báo lỗi
                    alert('❌ ' + (data.message || 'Có lỗi xảy ra'));
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            } catch (error) {
                console.error('Error:', error);
                alert('❌ Có lỗi xảy ra khi gửi lời mời. Vui lòng thử lại.');
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        }

        // =====================================
        // TỪ CHỐI ỨNG VIÊN
        // =====================================
        async function rejectApplicant(appId) {
            // Nếu đang ở trạng thái "chờ xử lý" thì xử lý thông thường
            const row = event.target.closest('tr');
            const statusBadge = row.querySelector('[id^="status-badge-"]');
            const currentStatus = statusBadge.className;

            if (currentStatus.includes('cho_xu_ly')) {
                if (!confirm('Bạn có chắc chắn ứng viên này không phù hợp?')) {
                    return;
                }

                try {
                    const response = await fetch(`/application/${appId}/reject`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            send_email: true
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        alert('✅ Đã xác nhận từ chối ứng viên');
                        location.reload();
                    } else {
                        alert('❌ ' + (data.message || 'Có lỗi xảy ra'));
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('❌ Có lỗi xảy ra');
                }
            } else if (currentStatus.includes('dang_phong_van')) {
                // Đang phỏng vấn: Mở modal để xác nhận
                const candidateName = row.querySelector('td:nth-child(2)').textContent.trim().split('\n')[0];
                const email = row.querySelector('td:nth-child(3)').textContent.trim();
                openResultModal(appId, candidateName, email, 'rejected');
            }
        }

        // =====================================
        // CẬP NHẬT TRẠNG THÁI
        // =====================================
        async function updateStatus(appId, status) {
            try {
                const response = await fetch(`/application/${appId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: status
                    })
                });

                const data = await response.json();

                if (data.success) {
                    const badge = document.getElementById(`status-badge-${appId}`);
                    if (badge) {
                        badge.className = `status-badge status-${status}`;

                        let icon, text;
                        switch (status) {
                            case 'cho_xu_ly':
                                icon = 'clock-history';
                                text = 'Chờ xử lý';
                                break;
                            case 'dang_phong_van':
                                icon = 'calendar-check';
                                text = 'Đang phỏng vấn';
                                break;
                            case 'duoc_chon':
                                icon = 'check-circle';
                                text = 'Được chọn';
                                break;
                            case 'khong_phu_hop':
                                icon = 'x-circle';
                                text = 'Không phù hợp';
                                break;
                        }
                        badge.innerHTML = `<i class="bi bi-${icon}"></i> ${text}`;
                    }
                    return true;
                }
                return false;
            } catch (error) {
                console.error('Error updating status:', error);
                return false;
            }
        }

        // =====================================
        // MODAL HELPERS
        // =====================================
        function openModal(modalId) {
            document.getElementById(modalId).classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
            document.body.style.overflow = '';
        }

        // Close modal when clicking outside
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal(this.id);
                }
            });
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal.active').forEach(modal => {
                    closeModal(modal.id);
                });
            }
        });


        // / ✅ PHÂN LOẠI HÀM
        let resultType = null; // 'approved' hoặc 'rejected'

        // ✅ MỞ MODAL PHẢN HỒI PHỎNG VẤN (CHỌN ĐẬU)
        function openResultModal(appId, candidateName, candidateEmail, type) {
            resultType = type;
            document.getElementById('resultAppId').value = appId;
            document.getElementById('resultEmail').value = candidateEmail;
            document.getElementById('resultName').value = candidateName;
            document.getElementById('resultCandidateName').textContent = candidateName;
            document.getElementById('resultNote').value = '';
            document.getElementById('sendEmailResult').checked = true;

            // Cập nhật nội dung nút
            const btn = document.getElementById('resultBtn');
            const btnText = document.getElementById('resultBtnText');
            if (type === 'approved') {
                btn.className = 'btn btn-success';
                btnText.textContent = 'Xác nhận chọn đậu';
            } else {
                btn.className = 'btn btn-danger';
                btnText.textContent = 'Xác nhận từ chối';
            }

            openModal('resultModal');
        }

        // ✅ CHỌN ĐẬU ỨNG VIÊN
        function approveApplicant(appId, candidateName, candidateEmail) {
            openResultModal(appId, candidateName, candidateEmail, 'approved');
        }

        // ✅ GỬI KẾT QUẢ PHỎNG VẤN (CHỌN ĐẬU HOẶC TỪ CHỐI)
        async function submitResult() {
            const appId = document.getElementById('resultAppId').value;
            const email = document.getElementById('resultEmail').value;
            const note = document.getElementById('resultNote').value;
            const sendEmail = document.getElementById('sendEmailResult').checked;

            // Xác định status
            let newStatus = resultType === 'approved' ? 'duoc_chon' : 'khong_phu_hop';

            // Show loading
            const btn = document.getElementById('resultBtn');
            const originalHTML = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="loading"></span> Đang xử lý...';

            try {
                // Bước 1: Cập nhật trạng thái
                const updateResponse = await fetch(`/application/${appId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                });

                if (!updateResponse.ok) {
                    throw new Error(`HTTP error! status: ${updateResponse.status}`);
                }

                const updateData = await updateResponse.json();

                if (!updateData.success) {
                    throw new Error(updateData.message || 'Lỗi cập nhật trạng thái');
                }

                // Bước 2: Thêm ghi chú nếu có
                if (note.trim()) {
                    const noteResponse = await fetch(`/application/${appId}/add-note`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            note: `[${resultType === 'approved' ? 'ĐẬU' : 'KHÔNG ĐỦ ĐIỀU KIỆN'}] ${note}`
                        })
                    });

                    if (!noteResponse.ok) {
                        console.warn('Lỗi thêm ghi chú');
                    }
                }

                // Bước 3: Gửi email nếu được phép
                if (sendEmail) {
                    const emailResponse = await fetch(`/application/${appId}/send-result-email`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            email: email,
                            type: resultType,
                            note: note
                        })
                    });

                    if (!emailResponse.ok) {
                        console.warn('Lỗi gửi email');
                    }
                }

                // ✅ Thành công
                const message = resultType === 'approved' ?
                    '✅ Đã xác nhận chọn đậu ứng viên!' :
                    '✅ Đã xác nhận từ chối ứng viên!';
                alert(message);

                closeModal('resultModal');
                setTimeout(() => {
                    location.reload();
                }, 300);

            } catch (error) {
                console.error('Error:', error);
                alert('❌ ' + (error.message || 'Có lỗi xảy ra'));
                btn.disabled = false;
                btn.innerHTML = originalHTML;
            }
        }
    </script>
</body>

</html>