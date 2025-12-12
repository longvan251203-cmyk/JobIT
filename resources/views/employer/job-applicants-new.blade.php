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
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 24px;
        }

        /* Header */
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 32px;
            border-radius: 16px;
            margin-bottom: 32px;
            box-shadow: 0 10px 40px rgba(102, 126, 234, 0.2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .page-header-content h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .page-header-content p {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Statistics */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 14px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.15);
            border-color: #667eea;
        }

        .stat-value {
            font-size: 36px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 13px;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Tabs Navigation */
        .tabs-container {
            background: white;
            border-radius: 14px;
            margin-bottom: 24px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            display: flex;
            border: 1px solid #e5e7eb;
        }

        .tab-btn {
            flex: 1;
            padding: 16px 20px;
            border: none;
            background: white;
            color: #6b7280;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
            position: relative;
        }

        .tab-btn:hover {
            background: #f9fafb;
            color: #1f2937;
        }

        .tab-btn.active {
            color: #667eea;
            border-bottom-color: #667eea;
            background: linear-gradient(to bottom, rgba(102, 126, 234, 0.05), transparent);
        }

        .tab-btn i {
            margin-right: 8px;
        }

        /* Table */
        .table-container {
            background: white;
            border-radius: 14px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: linear-gradient(135deg, #f5f7ff 0%, #f0f0ff 100%);
            border-bottom: 2px solid #e5e7eb;
        }

        th {
            padding: 18px 16px;
            text-align: left;
            font-size: 13px;
            font-weight: 700;
            color: #1f2937;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 18px 16px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
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
            border: 2px solid #667eea;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
        }

        /* Status badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .status-cho_xu_ly {
            background: linear-gradient(135deg, #fef3c7 0%, #fcd34d 100%);
            color: #92400e;
        }

        .status-dang_phong_van {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
        }

        .status-duoc_chon {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
        }

        .status-khong_phu_hop {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #7f1d1d;
        }

        /* Action buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(72, 187, 120, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(72, 187, 120, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(245, 101, 101, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(245, 101, 101, 0.4);
        }

        .btn-secondary {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
            transform: translateY(-2px);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Modal */
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

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
            border-radius: 16px 16px 0 0;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 700;
        }

        .modal-close {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: none;
            background: rgba(255, 255, 255, 0.2);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.2s;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.3);
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
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s;
            font-family: inherit;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-radio-group {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
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
            flex: 1;
            min-width: 120px;
        }

        .form-radio-label:hover {
            border-color: #667eea;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
        }

        .form-radio-label input[type="radio"] {
            accent-color: #667eea;
        }

        .form-radio-label input[type="radio"]:checked~span {
            color: #667eea;
            font-weight: 700;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6b7280;
        }

        .empty-state i {
            font-size: 48px;
            color: #d1d5db;
            margin-bottom: 16px;
            display: block;
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

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Tab content visibility */
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Back button */
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateX(-4px);
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="page-header">
            <div class="page-header-content">
                <h1>{{ $job->title }}</h1>
                <p>
                    <i class="bi bi-building"></i>
                    {{ $job->company->ten_cty ?? 'N/A' }}
                </p>
            </div>
            <a href="{{ route('employer.dashboard') }}" class="back-btn">
                <i class="bi bi-arrow-left"></i>
                Quay lại
            </a>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">{{ $statistics['total'] }}</div>
                <div class="stat-label">Tổng số ứng tuyển</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $statistics['cho_xu_ly'] }}</div>
                <div class="stat-label">Chờ xử lý</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $statistics['dang_phong_van'] }}</div>
                <div class="stat-label">Đang phỏng vấn</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $statistics['duoc_chon'] }}</div>
                <div class="stat-label">Được chọn</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $statistics['khong_phu_hop'] }}</div>
                <div class="stat-label">Không phù hợp</div>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="tabs-container">
            <button class="tab-btn active" onclick="switchTab('applicants')">
                <i class="bi bi-file-earmark-person"></i>
                Ứng viên ứng tuyển
            </button>
            <button class="tab-btn" onclick="switchTab('invited')">
                <i class="bi bi-envelope-open"></i>
                Ứng viên được mời
            </button>
        </div>

        <!-- Tab Content: Applicants -->
        <div id="applicants" class="tab-content active">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 50px;">STT</th>
                            <th>Ứng viên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Trạng thái</th>
                            <th style="width: 350px;">Hành động</th>
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
                                        <div style="font-weight: 700; color: #1f2937;">{{ $application->hoten }}</div>
                                        <div style="font-size: 13px; color: #6b7280;">{{ $application->applicant->vitritungtuyen ?? 'Chưa cập nhật' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 14px; color: #374151;">{{ $application->email }}</div>
                            </td>
                            <td>
                                <div style="font-size: 14px; color: #374151;">{{ $application->sdt }}</div>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $application->trang_thai }}" id="status-badge-{{ $application->application_id }}">
                                    @switch($application->trang_thai)
                                    @case('cho_xu_ly')
                                    <i class="bi bi-clock-history"></i> Chờ xử lý
                                    @break
                                    @case('dang_phong_van')
                                    <i class="bi bi-calendar-check"></i> Đang PV
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
                                        <i class="bi bi-eye"></i> CV
                                    </button>

                                    @if($application->trang_thai == 'cho_xu_ly')
                                    <button class="btn btn-success" onclick="openInterviewModal('{{ $application->application_id }}', '{{ $application->hoten }}', '{{ $application->email }}')">
                                        <i class="bi bi-calendar-check"></i> Mời PV
                                    </button>
                                    <button class="btn btn-danger" onclick="rejectApplicant('{{ $application->application_id }}')">
                                        <i class="bi bi-x-circle"></i> Từ chối
                                    </button>
                                    @elseif($application->trang_thai == 'dang_phong_van')
                                    <button class="btn btn-success" onclick="approveApplicant('{{ $application->application_id }}', '{{ $application->hoten }}', '{{ $application->email }}')">
                                        <i class="bi bi-check-circle"></i> Chọn đậu
                                    </button>
                                    <button class="btn btn-danger" onclick="rejectApplicant('{{ $application->application_id }}')">
                                        <i class="bi bi-x-circle"></i> Từ chối
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <p>Chưa có ứng viên nào ứng tuyển</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab Content: Invited Applicants -->
        <div id="invited" class="tab-content">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 50px;">STT</th>
                            <th>Ứng viên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Trạng thái lời mời</th>
                            <th style="width: 200px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invitations as $index => $invitation)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <img src="{{ $invitation->applicant->avatar ? asset('assets/img/avt/'.$invitation->applicant->avatar) : asset('assets/img/avt/default-avatar.png') }}"
                                        alt="Avatar" class="avatar">
                                    <div>
                                        <div style="font-weight: 700; color: #1f2937;">{{ $invitation->applicant->hoten ?? 'N/A' }}</div>
                                        <div style="font-size: 13px; color: #6b7280;">{{ $invitation->applicant->vitritungtuyen ?? 'Chưa cập nhật' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 14px; color: #374151;">{{ $invitation->applicant->email_uv ?? 'N/A' }}</div>
                            </td>
                            <td>
                                <div style="font-size: 14px; color: #374151;">{{ $invitation->applicant->sdt_uv ?? 'N/A' }}</div>
                            </td>
                            <td>
                                @switch($invitation->status)
                                @case('pending')
                                <span class="status-badge status-cho_xu_ly">
                                    <i class="bi bi-clock-history"></i> Chờ phản hồi
                                </span>
                                @break
                                @case('accepted')
                                <span class="status-badge status-duoc_chon">
                                    <i class="bi bi-check-circle"></i> Đã chấp nhận
                                </span>
                                @break
                                @case('rejected')
                                <span class="status-badge status-khong_phu_hop">
                                    <i class="bi bi-x-circle"></i> Đã từ chối
                                </span>
                                @break
                                @endswitch
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-primary" onclick="viewCV('{{ $invitation->id }}', true)">
                                        <i class="bi bi-eye"></i> CV
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="bi bi-envelope"></i>
                                    <p>Chưa có ứng viên nào được mời</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal: Result -->
    <div id="resultModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="bi bi-check-circle"></i>
                    Kết quả phỏng vấn
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
                    <div id="resultCandidateName" style="padding: 12px; background: #f9fafb; border-radius: 8px; font-weight: 600; border-left: 3px solid #667eea;"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Ghi chú (tùy chọn)</label>
                    <textarea id="resultNote" class="form-textarea" placeholder="VD: Kỹ năng tốt, kinh nghiệm phù hợp..."></textarea>
                </div>

                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" id="sendEmailResult" checked style="width: 18px; height: 18px; accent-color: #667eea;">
                        <span style="font-size: 14px; color: #374151;">Gửi email thông báo kết quả cho ứng viên</span>
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

    <!-- Modal: CV -->
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

    <!-- Modal: Interview -->
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
                    <div id="interviewCandidateName" style="padding: 12px; background: #f9fafb; border-radius: 8px; font-weight: 600; border-left: 3px solid #667eea;"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Hình thức phỏng vấn</label>
                    <div class="form-radio-group">
                        <label class="form-radio-label" style="border-color: #667eea;">
                            <input type="radio" name="interviewType" value="online" checked>
                            <span><i class="bi bi-camera-video"></i> Online</span>
                        </label>
                        <label class="form-radio-label">
                            <input type="radio" name="interviewType" value="offline">
                            <span><i class="bi bi-building"></i> Offline</span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="bi bi-calendar"></i> Ngày phỏng vấn</label>
                    <input type="date" id="interviewDate" class="form-input" min="{{ date('Y-m-d') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="bi bi-clock"></i> Giờ phỏng vấn</label>
                    <input type="time" id="interviewTime" class="form-input" value="09:00" required>
                </div>

                <div class="form-group" id="locationGroup">
                    <label class="form-label"><i class="bi bi-camera-video"></i> Link meeting</label>
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
        // TAB SWITCHING
        // =====================================
        function switchTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            // Remove active from all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Show selected tab
            document.getElementById(tabName).classList.add('active');

            // Add active to clicked button
            event.target.closest('.tab-btn').classList.add('active');
        }

        // =====================================
        // INTERVIEW TYPE CHANGE
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
        // VIEW CV
        // =====================================
        // VIEW CV
        // =====================================
        async function viewCV(id, isInvitation = false) {
            try {
                // Sử dụng endpoint khác nhau cho application và invitation
                const url = isInvitation ? `/job-invitation/${id}/view-cv` : `/application/${id}/view-cv`;

                const response = await fetch(url, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }

                const data = await response.json();

                if (data.success) {
                    const applicant = data.applicant;
                    const context = isInvitation ? data.invitation : data.application;

                    console.log('✅ CV Data:', {
                        applicant,
                        context
                    });
                    generateEmployerCVHTML(applicant, context);
                    openModal('cvModal');
                } else {
                    console.error('❌ API Response:', data);
                    alert('Không thể tải CV: ' + (data.message || 'Lỗi không xác định'));
                }
            } catch (error) {
                console.error('❌ Fetch Error:', error);
                alert('Có lỗi xảy ra khi tải CV: ' + error.message);
            }
        }

        // =====================================
        // GENERATE EMPLOYER CV HTML
        // =====================================
        function generateEmployerCVHTML(candidate, application) {
            let cvHTML = `<div style="display: flex; gap: 24px;">
                <!-- Left Column -->
                <div style="width: 280px; background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%); padding: 24px; border-radius: 12px; border-left: 3px solid #667eea; display: flex; flex-direction: column; align-items: center;">
                    <div style="text-align: center; margin-bottom: 24px; width: 100%;">
                        <img src="${candidate.avatar ? '/assets/img/avt/' + candidate.avatar : '/assets/img/avt/default-avatar.png'}" 
                             alt="Avatar" style="width: 120px; height: 120px; border-radius: 50%; margin: 0 auto 16px; display: block; border: 4px solid #667eea; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);">
                        <h4 style="font-size: 18px; font-weight: 700; color: #1f2937; margin-bottom: 4px;">${application ? application.hoten : candidate.hoten_uv}</h4>
                        <p style="font-size: 14px; color: #6b7280;">${candidate.vitriungtuyen || 'Chức danh'}</p>
                    </div>
                    
                    <div style="display: flex; flex-direction: column; gap: 12px; font-size: 13px; width: 100%;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="bi bi-envelope" style="color: #667eea;"></i>
                            <span style="color: #374151; word-break: break-word;">${application ? application.email : candidate.email_uv}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="bi bi-telephone" style="color: #667eea;"></i>
                            <span style="color: #374151;">${application ? application.sdt : candidate.sdt_uv}</span>
                        </div>
                        ${application && application.diachi ? `
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="bi bi-geo-alt" style="color: #667eea;"></i>
                            <span style="color: #374151;">${application.diachi}</span>
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
                    ${application && application.thu_gioi_thieu ? `
                    <div style="margin-bottom: 24px;">
                        <h5 style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; border-bottom: 2px solid #667eea; padding-bottom: 8px;">
                            <i class="bi bi-person-lines-fill" style="color: #667eea;"></i>
                            Thư giới thiệu
                        </h5>
                        <p style="color: #374151; line-height: 1.6; white-space: pre-line;">${application.thu_gioi_thieu}</p>
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
        }

        // =====================================
        // INTERVIEW MODAL
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

        async function sendInterviewInvitation() {
            const appId = document.getElementById('interviewAppId').value;
            const email = document.getElementById('interviewEmail').value;
            const date = document.getElementById('interviewDate').value;
            const time = document.getElementById('interviewTime').value;
            const location = document.getElementById('interviewLocation').value;
            const type = document.querySelector('input[name="interviewType"]:checked').value;

            if (!date || !time) {
                alert('Vui lòng chọn ngày và giờ phỏng vấn');
                return;
            }

            if (type === 'offline' && !location) {
                alert('Vui lòng nhập địa điểm phỏng vấn');
                return;
            }

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

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success) {
                    alert('✅ Đã gửi lời mời phỏng vấn thành công!');
                    closeModal('interviewModal');
                    setTimeout(() => {
                        location.reload();
                    }, 300);
                } else {
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
        // REJECT APPLICANT
        // =====================================
        async function rejectApplicant(appId) {
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
                const candidateName = row.querySelector('td:nth-child(2)').textContent.trim().split('\n')[0];
                const email = row.querySelector('td:nth-child(3)').textContent.trim();
                openResultModal(appId, candidateName, email, 'rejected');
            }
        }

        // =====================================
        // RESULT MODAL
        // =====================================
        let resultType = null;

        function openResultModal(appId, candidateName, candidateEmail, type) {
            resultType = type;
            document.getElementById('resultAppId').value = appId;
            document.getElementById('resultEmail').value = candidateEmail;
            document.getElementById('resultName').value = candidateName;
            document.getElementById('resultCandidateName').textContent = candidateName;
            document.getElementById('resultNote').value = '';
            document.getElementById('sendEmailResult').checked = true;

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

        function approveApplicant(appId, candidateName, candidateEmail) {
            openResultModal(appId, candidateName, candidateEmail, 'approved');
        }

        async function submitResult() {
            const appId = document.getElementById('resultAppId').value;
            const email = document.getElementById('resultEmail').value;
            const note = document.getElementById('resultNote').value;
            const sendEmail = document.getElementById('sendEmailResult').checked;

            let newStatus = resultType === 'approved' ? 'duoc_chon' : 'khong_phu_hop';

            const btn = document.getElementById('resultBtn');
            const originalHTML = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="loading"></span> Đang xử lý...';

            try {
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

                if (note.trim()) {
                    await fetch(`/application/${appId}/add-note`, {
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
                }

                if (sendEmail) {
                    await fetch(`/application/${appId}/send-result-email`, {
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
                }

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

        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal(this.id);
                }
            });
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal.active').forEach(modal => {
                    closeModal(modal.id);
                });
            }
        });
    </script>
</body>

</html>