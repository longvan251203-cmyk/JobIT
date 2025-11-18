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
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .status-chua_xem {
            background: #f3f4f6;
            color: #6b7280;
        }

        .status-da_xem {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-phong_van {
            background: #fef3c7;
            color: #b45309;
        }

        .status-duoc_chon {
            background: #d1fae5;
            color: #065f46;
        }

        .status-tu_choi {
            background: #fee2e2;
            color: #991b1b;
        }

        .filter-btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            border: 2px solid #e5e7eb;
            background: white;
            color: #6b7280;
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-btn:hover {
            border-color: #9333ea;
            color: #9333ea;
        }

        .filter-btn.active {
            background: linear-gradient(135deg, #9333ea 0%, #3b82f6 100%);
            color: white;
            border-color: transparent;
        }

        .applicant-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s;
        }

        .applicant-card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .avatar-circle {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #f3f4f6;
        }

        .action-btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
            border: 1px solid;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

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
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            max-width: 900px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            animation: fadeIn 0.3s ease-out;
        }

        .star {
            transition: color 0.2s;
        }

        .star.active {
            color: #fbbf24 !important;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 via-purple-50 to-blue-50">

    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 max-w-7xl mx-auto">
            <div class="flex items-center gap-4">
                <a href="{{ route('employer.dashboard') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="bi bi-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">Danh sách ứng viên</h1>
                    <p class="text-sm text-gray-600">{{ $job->title }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button onclick="exportAllApplicants()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all">
                    <i class="bi bi-download me-2"></i>Xuất báo cáo
                </button>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8">

        <!-- Statistics Cards -->
        <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-8">
            <div class="bg-white rounded-xl p-4 border border-gray-200 hover:shadow-lg transition-all">
                <div class="text-2xl font-bold text-gray-800">{{ $statistics['total'] }}</div>
                <div class="text-sm text-gray-600">Tổng số</div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-gray-200 hover:shadow-lg transition-all">
                <div class="text-2xl font-bold text-gray-500">{{ $statistics['chua_xem'] }}</div>
                <div class="text-sm text-gray-600">Chưa xem</div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-blue-200 hover:shadow-lg transition-all">
                <div class="text-2xl font-bold text-blue-600">{{ $statistics['da_xem'] }}</div>
                <div class="text-sm text-gray-600">Đã xem</div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-yellow-200 hover:shadow-lg transition-all">
                <div class="text-2xl font-bold text-yellow-600">{{ $statistics['phong_van'] }}</div>
                <div class="text-sm text-gray-600">Phỏng vấn</div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-green-200 hover:shadow-lg transition-all">
                <div class="text-2xl font-bold text-green-600">{{ $statistics['duoc_chon'] }}</div>
                <div class="text-sm text-gray-600">Được chọn</div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-red-200 hover:shadow-lg transition-all">
                <div class="text-2xl font-bold text-red-600">{{ $statistics['tu_choi'] }}</div>
                <div class="text-sm text-gray-600">Từ chối</div>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="bg-white rounded-xl p-6 mb-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)"
                        class="w-5 h-5 text-purple-600 rounded focus:ring-2 focus:ring-purple-500">
                    <label for="selectAll" class="text-sm font-medium text-gray-700 cursor-pointer">Chọn tất cả</label>
                </div>

                <div class="flex gap-2">
                    <button onclick="exportApplicants('excel')" class="px-3 py-2 text-sm bg-green-50 text-green-600 border border-green-200 rounded-lg hover:bg-green-100">
                        <i class="bi bi-file-excel me-1"></i>Excel
                    </button>
                    <button onclick="exportApplicants('csv')" class="px-3 py-2 text-sm bg-blue-50 text-blue-600 border border-blue-200 rounded-lg hover:bg-blue-100">
                        <i class="bi bi-filetype-csv me-1"></i>CSV
                    </button>
                    <button onclick="printApplicants()" class="px-3 py-2 text-sm bg-gray-50 text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-100">
                        <i class="bi bi-printer me-1"></i>In
                    </button>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex flex-wrap gap-2">
                    <button class="filter-btn active" data-status="all">
                        <i class="bi bi-list-ul me-1"></i>Tất cả
                    </button>
                    <button class="filter-btn" data-status="chua_xem">
                        <i class="bi bi-eye-slash me-1"></i>Chưa xem
                    </button>
                    <button class="filter-btn" data-status="da_xem">
                        <i class="bi bi-eye me-1"></i>Đã xem
                    </button>
                    <button class="filter-btn" data-status="phong_van">
                        <i class="bi bi-calendar-check me-1"></i>Phỏng vấn
                    </button>
                    <button class="filter-btn" data-status="duoc_chon">
                        <i class="bi bi-check-circle me-1"></i>Được chọn
                    </button>
                    <button class="filter-btn" data-status="tu_choi">
                        <i class="bi bi-x-circle me-1"></i>Từ chối
                    </button>
                </div>

                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Tìm kiếm theo tên, email, SĐT..."
                        class="pl-10 pr-4 py-2 w-80 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <i class="bi bi-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Bulk Actions Panel -->
        <div id="bulkActionsPanel" class="hidden bg-white rounded-xl p-4 mb-6 shadow-sm border border-purple-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="bi bi-check-circle text-purple-600 text-xl"></i>
                    <span class="font-semibold">Đã chọn <span id="selectedCount">0</span> ứng viên</span>
                </div>
                <div class="flex gap-2">
                    <button onclick="bulkUpdateStatus()" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                        <i class="bi bi-pencil me-1"></i>Cập nhật trạng thái
                    </button>
                    <button onclick="sendBulkEmail()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="bi bi-envelope me-1"></i>Gửi email
                    </button>
                    <button onclick="clearSelection()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        <i class="bi bi-x-lg me-1"></i>Bỏ chọn
                    </button>
                </div>
            </div>
        </div>

        <!-- Applicants List -->
        <div id="applicantsList" class="space-y-4">
            @forelse($applications as $application)
            <div class="applicant-card animate-fadeIn" data-status="{{ $application->trang_thai }}">
                <div class="flex items-start gap-4">
                    <!-- Checkbox -->
                    <input type="checkbox" class="applicant-checkbox mt-4" value="{{ $application->application_id }}"
                        onchange="toggleApplicant(this)">

                    <!-- Avatar -->
                    <img src="{{ $application->applicant->avatar ? asset('assets/img/avt/'.$application->applicant->avatar) : asset('assets/img/avt/default-avatar.png') }}"
                        alt="Avatar" class="avatar-circle">

                    <!-- Info -->
                    <div class="flex-1">
                        <div class="flex items-start justify-between mb-2">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">{{ $application->hoten }}</h3>
                                <p class="text-sm text-gray-600">{{ $application->applicant->chucdanh ?? 'Chưa cập nhật' }}</p>
                            </div>
                            <span class="status-badge status-{{ $application->trang_thai }}" id="status-{{ $application->application_id }}">
                                @switch($application->trang_thai)
                                @case('chua_xem')
                                <i class="bi bi-eye-slash"></i> Chưa xem
                                @break
                                @case('da_xem')
                                <i class="bi bi-eye"></i> Đã xem
                                @break
                                @case('phong_van')
                                <i class="bi bi-calendar-check"></i> Phỏng vấn
                                @break
                                @case('duoc_chon')
                                <i class="bi bi-check-circle"></i> Được chọn
                                @break
                                @case('tu_choi')
                                <i class="bi bi-x-circle"></i> Từ chối
                                @break
                                @endswitch
                            </span>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-3 text-sm">
                            <div class="flex items-center gap-2 text-gray-600">
                                <i class="bi bi-envelope"></i>
                                <span>{{ $application->email }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-gray-600">
                                <i class="bi bi-telephone"></i>
                                <span>{{ $application->sdt }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-gray-600">
                                <i class="bi bi-calendar"></i>
                                <span>{{ $application->ngay_ung_tuyen->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-gray-600">
                                <i class="bi bi-file-earmark"></i>
                                <span>{{ $application->cv_type == 'upload' ? 'CV Upload' : 'Hồ sơ' }}</span>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="flex items-center gap-2 mb-3" data-app-id="{{ $application->application_id }}">
                            <span class="text-sm text-gray-600">Đánh giá:</span>
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star-fill star text-gray-300 cursor-pointer text-lg hover:text-yellow-400"
                                data-rating="{{ $i }}"
                                onclick="rateApplicant({{ $application->application_id }}, {{ $i }})"></i>
                                @endfor
                        </div>

                        @if($application->thu_gioi_thieu)
                        <div class="bg-gray-50 rounded-lg p-3 mb-3">
                            <p class="text-sm text-gray-700 line-clamp-2">{{ $application->thu_gioi_thieu }}</p>
                        </div>
                        @endif

                        <!-- Actions -->
                        <div class="flex flex-wrap gap-2">
                            <button class="action-btn bg-blue-50 text-blue-600 border-blue-200 hover:bg-blue-100 btn-view-cv"
                                data-app-id="{{ $application->application_id }}">
                                <i class="bi bi-eye"></i>Xem CV
                            </button>

                            @if($application->cv_type == 'upload')
                            <a href="{{ route('application.downloadCV', $application->application_id) }}"
                                class="action-btn bg-green-50 text-green-600 border-green-200 hover:bg-green-100">
                                <i class="bi bi-download"></i>Tải CV
                            </a>
                            @endif

                            <button class="action-btn bg-yellow-50 text-yellow-600 border-yellow-200 hover:bg-yellow-100 btn-schedule-interview"
                                data-app-id="{{ $application->application_id }}">
                                <i class="bi bi-calendar-check"></i>Lịch PV
                            </button>

                            <button class="action-btn bg-purple-50 text-purple-600 border-purple-200 hover:bg-purple-100 btn-change-status"
                                data-app-id="{{ $application->application_id }}"
                                data-current-status="{{ $application->trang_thai }}">
                                <i class="bi bi-pencil"></i>Đổi trạng thái
                            </button>

                            <button class="action-btn bg-orange-50 text-orange-600 border-orange-200 hover:bg-orange-100 btn-add-note"
                                data-app-id="{{ $application->application_id }}"
                                data-note="{{ e($application->ghi_chu ?? '') }}">
                                <i class="bi bi-sticky"></i>Ghi chú
                            </button>

                            <a href="mailto:{{ $application->email }}"
                                class="action-btn bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100">
                                <i class="bi bi-envelope"></i>Email
                            </a>

                            <a href="tel:{{ $application->sdt }}"
                                class="action-btn bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100">
                                <i class="bi bi-telephone"></i>Gọi
                            </a>

                            @if($application->trang_thai != 'duoc_chon')
                            <button class="action-btn bg-green-50 text-green-600 border-green-200 hover:bg-green-100 btn-quick-action"
                                data-app-id="{{ $application->application_id }}"
                                data-action="accept">
                                <i class="bi bi-check-circle"></i>Chấp nhận
                            </button>
                            @endif

                            @if($application->trang_thai != 'tu_choi')
                            <button class="action-btn bg-red-50 text-red-600 border-red-200 hover:bg-red-100 btn-quick-action"
                                data-app-id="{{ $application->application_id }}"
                                data-action="reject">
                                <i class="bi bi-x-circle"></i>Từ chối
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-16">
                <i class="bi bi-inbox text-6xl text-gray-300"></i>
                <p class="text-gray-500 mt-4">Chưa có ứng viên nào ứng tuyển</p>
            </div>
            @endforelse
        </div>

    </main>

    <!-- Modal: View CV -->
    <div id="cvModal" class="modal">
        <div class="modal-content">
            <div class="bg-gradient-to-r from-purple-600 to-blue-600 p-6 text-white flex items-center justify-between rounded-t-2xl">
                <h3 class="text-2xl font-bold">
                    <i class="bi bi-file-earmark-person me-2"></i>Hồ sơ ứng viên
                </h3>
                <button onclick="closeCVModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-all">
                    <i class="bi bi-x-lg text-xl"></i>
                </button>
            </div>
            <div id="cvContent" class="p-6">
                <!-- CV content will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Modal: Change Status -->
    <div id="statusModal" class="modal">
        <div class="modal-content max-w-md">
            <div class="p-6">
                <h3 class="text-xl font-bold mb-4">Cập nhật trạng thái</h3>
                <form id="statusForm">
                    <input type="hidden" id="statusAppId">
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Trạng thái mới</label>
                        <select id="newStatus" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                            <option value="chua_xem">Chưa xem</option>
                            <option value="da_xem">Đã xem</option>
                            <option value="phong_van">Phỏng vấn</option>
                            <option value="duoc_chon">Được chọn</option>
                            <option value="tu_choi">Từ chối</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Ghi chú (tùy chọn)</label>
                        <textarea id="statusNote" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"></textarea>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" onclick="closeStatusModal()" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                            Hủy
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                            Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Note -->
    <div id="noteModal" class="modal">
        <div class="modal-content max-w-md">
            <div class="p-6">
                <h3 class="text-xl font-bold mb-4">Thêm ghi chú</h3>
                <form id="noteForm">
                    <input type="hidden" id="noteAppId">
                    <div class="mb-4">
                        <textarea id="noteContent" rows="5" placeholder="Nhập ghi chú về ứng viên..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"></textarea>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" onclick="closeNoteModal()" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                            Hủy
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                            Lưu ghi chú
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Bulk Status Update -->
    <div id="bulkStatusModal" class="modal">
        <div class="modal-content max-w-md">
            <div class="p-6">
                <h3 class="text-xl font-bold mb-4">Cập nhật trạng thái hàng loạt</h3>
                <form id="bulkStatusForm">
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Trạng thái mới</label>
                        <select id="bulkNewStatus" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                            <option value="chua_xem">Chưa xem</option>
                            <option value="da_xem">Đã xem</option>
                            <option value="phong_van">Phỏng vấn</option>
                            <option value="duoc_chon">Được chọn</option>
                            <option value="tu_choi">Từ chối</option>
                        </select>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" onclick="closeBulkStatusModal()" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                            Hủy
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                            Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let selectedApplicants = new Set();

        // Filter by status
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const status = this.dataset.status;
                const cards = document.querySelectorAll('.applicant-card');

                cards.forEach(card => {
                    if (status === 'all' || card.dataset.status === status) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const cards = document.querySelectorAll('.applicant-card');

            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(searchTerm) ? 'block' : 'none';
            });
        });

        // Selection functions
        function toggleSelectAll(checkbox) {
            const checkboxes = document.querySelectorAll('.applicant-checkbox');
            checkboxes.forEach(cb => {
                cb.checked = checkbox.checked;
                if (checkbox.checked) {
                    selectedApplicants.add(parseInt(cb.value));
                } else {
                    selectedApplicants.delete(parseInt(cb.value));
                }
            });
            updateBulkActions();
        }

        function toggleApplicant(checkbox) {
            const appId = parseInt(checkbox.value);
            if (checkbox.checked) {
                selectedApplicants.add(appId);
            } else {
                selectedApplicants.delete(appId);
            }
            updateBulkActions();
        }

        function updateBulkActions() {
            const panel = document.getElementById('bulkActionsPanel');
            const count = document.getElementById('selectedCount');
            count.textContent = selectedApplicants.size;

            if (selectedApplicants.size > 0) {
                panel.classList.remove('hidden');
            } else {
                panel.classList.add('hidden');
            }
        }

        function clearSelection() {
            selectedApplicants.clear();
            document.querySelectorAll('.applicant-checkbox').forEach(cb => cb.checked = false);
            document.getElementById('selectAll').checked = false;
            updateBulkActions();
        }

        // View CV
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-view-cv')) {
                const btn = e.target.closest('.btn-view-cv');
                const appId = btn.dataset.appId;
                viewCV(appId);
            }
        });

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
                <div class="flex gap-6">
                    <!-- Left Column -->
                    <div class="w-1/3 bg-gradient-to-br from-purple-50 to-blue-50 p-6 rounded-xl">
                        <div class="text-center mb-6">
                            <img src="${applicant.avatar ? '/assets/img/avt/' + applicant.avatar : '/assets/img/avt/default-avatar.png'}" 
                                 alt="Avatar" class="w-32 h-32 rounded-full mx-auto mb-4 border-4 border-white shadow-lg">
                            <h4 class="text-xl font-bold text-gray-800">${application.hoten}</h4>
                            <p class="text-gray-600">${applicant.chucdanh || 'Chức danh'}</p>
                        </div>
                        
                        <div class="space-y-3 text-sm">
                            <div class="flex items-center gap-2 text-gray-700">
                                <i class="bi bi-envelope"></i>
                                <span>${application.email}</span>
                            </div>
                            <div class="flex items-center gap-2 text-gray-700">
                                <i class="bi bi-telephone"></i>
                                <span>${application.sdt}</span>
                            </div>
                            ${application.diachi ? `
                            <div class="flex items-center gap-2 text-gray-700">
                                <i class="bi bi-geo-alt"></i>
                                <span>${application.diachi}</span>
                            </div>` : ''}
                            ${applicant.ngaysinh ? `
                            <div class="flex items-center gap-2 text-gray-700">
                                <i class="bi bi-calendar"></i>
                                <span>${new Date(applicant.ngaysinh).toLocaleDateString('vi-VN')}</span>
                            </div>` : ''}
                            ${applicant.gioitinh_uv ? `
                            <div class="flex items-center gap-2 text-gray-700">
                                <i class="bi bi-gender-ambiguous"></i>
                                <span>${applicant.gioitinh_uv}</span>
                            </div>` : ''}
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="flex-1">
                        ${application.thu_gioi_thieu ? `
                        <div class="mb-6">
                            <h5 class="text-lg font-bold text-purple-600 mb-3 flex items-center gap-2">
                                <i class="bi bi-person-lines-fill"></i>Thư giới thiệu
                            </h5>
                            <p class="text-gray-700 whitespace-pre-line">${application.thu_gioi_thieu}</p>
                        </div>` : ''}
                        
                        ${applicant.gioithieu ? `
                        <div class="mb-6">
                            <h5 class="text-lg font-bold text-purple-600 mb-3 flex items-center gap-2">
                                <i class="bi bi-person"></i>Giới thiệu bản thân
                            </h5>
                            <div class="text-gray-700">${applicant.gioithieu}</div>
                        </div>` : ''}
                        
                        ${applicant.kinhnghiem && applicant.kinhnghiem.length > 0 ? `
                        <div class="mb-6">
                            <h5 class="text-lg font-bold text-purple-600 mb-3 flex items-center gap-2">
                                <i class="bi bi-briefcase"></i>Kinh nghiệm làm việc
                            </h5>
                            <div class="space-y-4">
                                ${applicant.kinhnghiem.map(item => `
                                    <div class="border-l-4 border-purple-400 pl-4">
                                        <h6 class="font-bold text-gray-800">${item.chucdanh}</h6>
                                        <p class="text-sm text-gray-600">${item.congty}</p>
                                        <p class="text-xs text-gray-500">${new Date(item.tu_ngay).toLocaleDateString('vi-VN')} - ${item.den_ngay ? new Date(item.den_ngay).toLocaleDateString('vi-VN') : 'Hiện tại'}</p>
                                        ${item.mota ? `<p class="text-sm text-gray-700 mt-2">${item.mota}</p>` : ''}
                                    </div>
                                `).join('')}
                            </div>
                        </div>` : ''}
                        
                        ${applicant.hocvan && applicant.hocvan.length > 0 ? `
                        <div class="mb-6">
                            <h5 class="text-lg font-bold text-purple-600 mb-3 flex items-center gap-2">
                                <i class="bi bi-mortarboard"></i>Học vấn
                            </h5>
                            <div class="space-y-3">
                                ${applicant.hocvan.map(item => `
                                    <div class="border-l-4 border-blue-400 pl-4">
                                        <h6 class="font-bold text-gray-800">${item.truong}</h6>
                                        <p class="text-sm text-gray-600">${item.nganh} - ${item.trinhdo}</p>
                                        <p class="text-xs text-gray-500">${new Date(item.tu_ngay).getFullYear()} - ${item.den_ngay ? new Date(item.den_ngay).getFullYear() : 'Hiện tại'}</p>
                                    </div>
                                `).join('')}
                            </div>
                        </div>` : ''}
                        
                        ${applicant.kynang && applicant.kynang.length > 0 ? `
                        <div class="mb-6">
                            <h5 class="text-lg font-bold text-purple-600 mb-3 flex items-center gap-2">
                                <i class="bi bi-star"></i>Kỹ năng
                            </h5>
                            <div class="flex flex-wrap gap-2">
                                ${applicant.kynang.map(item => `
                                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm">
                                        ${item.ten_ky_nang}${item.nam_kinh_nghiem ? ` - ${item.nam_kinh_nghiem} năm` : ''}
                                    </span>
                                `).join('')}
                            </div>
                        </div>` : ''}
                    </div>
                </div>
            `;

                    document.getElementById('cvContent').innerHTML = cvHTML;
                    document.getElementById('cvModal').classList.add('show');

                    // Update status badge if changed from chua_xem to da_xem
                    const badge = document.getElementById(`status-${appId}`);
                    if (badge && badge.classList.contains('status-chua_xem')) {
                        badge.className = 'status-badge status-da_xem';
                        badge.innerHTML = '<i class="bi bi-eye"></i> Đã xem';
                        badge.closest('.applicant-card').dataset.status = 'da_xem';
                    }
                } else {
                    alert('Không thể tải CV');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi tải CV');
            }
        }

        function closeCVModal() {
            document.getElementById('cvModal').classList.remove('show');
        }

        // Change Status Modal
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-change-status')) {
                const btn = e.target.closest('.btn-change-status');
                const appId = btn.dataset.appId;
                const currentStatus = btn.dataset.currentStatus;
                openStatusModal(appId, currentStatus);
            }
        });

        function openStatusModal(appId, currentStatus) {
            document.getElementById('statusAppId').value = appId;
            document.getElementById('newStatus').value = currentStatus;
            document.getElementById('statusNote').value = '';
            document.getElementById('statusModal').classList.add('show');
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.remove('show');
        }

        document.getElementById('statusForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const appId = document.getElementById('statusAppId').value;
            const status = document.getElementById('newStatus').value;
            const note = document.getElementById('statusNote').value;

            try {
                const response = await fetch(`/application/${appId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status,
                        note
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Update status badge
                    const badge = document.getElementById(`status-${appId}`);
                    badge.className = `status-badge status-${status}`;

                    let icon, text;
                    switch (status) {
                        case 'chua_xem':
                            icon = 'eye-slash';
                            text = 'Chưa xem';
                            break;
                        case 'da_xem':
                            icon = 'eye';
                            text = 'Đã xem';
                            break;
                        case 'phong_van':
                            icon = 'calendar-check';
                            text = 'Phỏng vấn';
                            break;
                        case 'duoc_chon':
                            icon = 'check-circle';
                            text = 'Được chọn';
                            break;
                        case 'tu_choi':
                            icon = 'x-circle';
                            text = 'Từ chối';
                            break;
                    }
                    badge.innerHTML = `<i class="bi bi-${icon}"></i> ${text}`;

                    // Update card data-status
                    badge.closest('.applicant-card').dataset.status = status;

                    closeStatusModal();
                    alert('✅ Cập nhật trạng thái thành công!');

                    // Reload to update statistics
                    setTimeout(() => location.reload(), 1000);
                } else {
                    alert('❌ ' + data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('❌ Có lỗi xảy ra');
            }
        });

        // Note Modal
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-add-note')) {
                const btn = e.target.closest('.btn-add-note');
                const appId = btn.dataset.appId;
                const currentNote = btn.dataset.note || '';
                openNoteModal(appId, currentNote);
            }
        });

        function openNoteModal(appId, currentNote) {
            document.getElementById('noteAppId').value = appId;
            document.getElementById('noteContent').value = currentNote;
            document.getElementById('noteModal').classList.add('show');
        }

        function closeNoteModal() {
            document.getElementById('noteModal').classList.remove('show');
        }

        document.getElementById('noteForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const appId = document.getElementById('noteAppId').value;
            const note = document.getElementById('noteContent').value;

            try {
                const response = await fetch(`/application/${appId}/add-note`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        note
                    })
                });

                const data = await response.json();

                if (data.success) {
                    closeNoteModal();
                    alert('✅ Đã lưu ghi chú!');
                } else {
                    alert('❌ ' + data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('❌ Có lỗi xảy ra');
            }
        });

        // Rating function
        function rateApplicant(appId, rating) {
            const container = document.querySelector(`[data-app-id="${appId}"]`);
            const stars = container.querySelectorAll('.star');

            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('active', 'text-yellow-400');
                } else {
                    star.classList.remove('active', 'text-yellow-400');
                    star.classList.add('text-gray-300');
                }
            });

            // TODO: Save rating to backend
            console.log(`Rated applicant ${appId} with ${rating} stars`);
        }

        // Quick actions
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-quick-action')) {
                const btn = e.target.closest('.btn-quick-action');
                const appId = btn.dataset.appId;
                const action = btn.dataset.action;

                if (action === 'accept') {
                    quickAccept(appId);
                } else if (action === 'reject') {
                    quickReject(appId);
                }
            }
        });

        async function quickAccept(appId) {
            if (!confirm('Bạn có chắc muốn chấp nhận ứng viên này?')) return;

            try {
                const response = await fetch(`/application/${appId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: 'duoc_chon'
                    })
                });

                const data = await response.json();
                if (data.success) {
                    alert('✅ Đã chấp nhận ứng viên!');
                    location.reload();
                } else {
                    alert('❌ ' + data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('❌ Có lỗi xảy ra');
            }
        }

        async function quickReject(appId) {
            if (!confirm('Bạn có chắc muốn từ chối ứng viên này?')) return;

            try {
                const response = await fetch(`/application/${appId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: 'tu_choi'
                    })
                });

                const data = await response.json();
                if (data.success) {
                    alert('✅ Đã từ chối ứng viên!');
                    location.reload();
                } else {
                    alert('❌ ' + data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('❌ Có lỗi xảy ra');
            }
        }

        // Schedule interview
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-schedule-interview')) {
                const btn = e.target.closest('.btn-schedule-interview');
                const appId = btn.dataset.appId;
                scheduleInterview(appId);
            }
        });

        function scheduleInterview(appId) {
            // TODO: Implement interview scheduling
            alert('Tính năng lịch phỏng vấn đang được phát triển');
        }

        // Bulk actions
        function bulkUpdateStatus() {
            if (selectedApplicants.size === 0) {
                alert('Vui lòng chọn ít nhất một ứng viên');
                return;
            }
            document.getElementById('bulkStatusModal').classList.add('show');
        }

        function closeBulkStatusModal() {
            document.getElementById('bulkStatusModal').classList.remove('show');
        }

        document.getElementById('bulkStatusForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const status = document.getElementById('bulkNewStatus').value;
            const appIds = Array.from(selectedApplicants);

            try {
                const promises = appIds.map(appId =>
                    fetch(`/application/${appId}/update-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            status
                        })
                    })
                );

                await Promise.all(promises);

                closeBulkStatusModal();
                alert(`✅ Đã cập nhật trạng thái cho ${appIds.length} ứng viên!`);
                location.reload();
            } catch (error) {
                console.error('Error:', error);
                alert('❌ Có lỗi xảy ra');
            }
        });

        function sendBulkEmail() {
            if (selectedApplicants.size === 0) {
                alert('Vui lòng chọn ít nhất một ứng viên');
                return;
            }

            // Get all selected emails
            const emails = [];
            selectedApplicants.forEach(appId => {
                const card = document.querySelector(`input[value="${appId}"]`).closest('.applicant-card');
                const emailElement = card.querySelector('[class*="bi-envelope"]').nextElementSibling;
                if (emailElement) {
                    emails.push(emailElement.textContent.trim());
                }
            });

            // Open email client with all recipients
            window.location.href = `mailto:${emails.join(',')}`;
        }

        // Export functions
        function exportApplicants(format) {
            alert(`Đang xuất dữ liệu theo định dạng ${format.toUpperCase()}...`);
            // TODO: Implement export functionality
        }

        function exportAllApplicants() {
            alert('Đang xuất báo cáo tổng hợp...');
            // TODO: Implement full report export
        }

        function printApplicants() {
            window.print();
        }

        // Close modals when clicking outside
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('show');
                }
            });
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal').forEach(modal => {
                    modal.classList.remove('show');
                });
            }
        });
    </script>
</body>

</html>