{{-- resources/views/applicant/partials/notification-item.blade.php --}}

<div class="card notification-item mb-3 {{ !$notification->is_read ? 'unread' : '' }}"
    data-notification-id="{{ $notification->id }}"
    data-is-read="{{ $notification->is_read ? '1' : '0' }}"
    style="cursor: pointer;">
    <div class="card-body">
        <div class="d-flex">

            {{-- Icon --}}
            <div class="notification-icon bg-{{ $notification->color }}-subtle text-{{ $notification->color }} me-3">
                <i class="{{ $notification->icon }}"></i>
            </div>

            {{-- Content --}}
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h6 class="mb-1">
                            {{ $notification->message }}
                            @if(!$notification->is_read)
                            <span class="notification-badge ms-2"></span>
                            @endif
                        </h6>
                        <small class="text-muted">
                            <i class="bi bi-clock me-1"></i>
                            {{ $notification->created_at->diffForHumans() }}
                        </small>
                    </div>

                    {{-- Actions dropdown --}}
                    <div class="dropdown">
                        <button class="btn btn-sm btn-link text-muted" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @if(!$notification->is_read)
                            <li>
                                <a class="dropdown-item mark-read-btn" href="#" data-notification-id="{{ $notification->id }}">
                                    <i class="bi bi-check2 me-2"></i>Đánh dấu đã đọc
                                </a>
                            </li>
                            @endif
                            <li>
                                <a class="dropdown-item text-danger delete-notification-btn" href="#" data-notification-id="{{ $notification->id }}">
                                    <i class="bi bi-trash me-2"></i>Xóa
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Notification details based on type --}}
                @if($notification->type === 'job_invitation')
                <div class="notification-details">
                    @if(isset($notification->data['company_logo']))
                    <img src="{{ asset('storage/' . $notification->data['company_logo']) }}"
                        alt="Company"
                        class="company-logo-small me-2"
                        style="width: 32px; height: 32px; object-fit: contain; border-radius: 4px;">
                    @endif

                    <div class="d-inline-block">
                        <p class="mb-1">
                            <i class="bi bi-briefcase-fill text-primary me-1"></i>
                            <strong>{{ $notification->data['job_title'] ?? 'Vị trí tuyển dụng' }}</strong>
                        </p>

                        @if(isset($notification->data['company_name']))
                        <p class="mb-1 text-muted">
                            <i class="bi bi-building me-1"></i>
                            {{ $notification->data['company_name'] }}
                        </p>
                        @endif

                        @if(isset($notification->data['salary_min']) && isset($notification->data['salary_max']))
                        <p class="mb-1 text-success">
                            <i class="bi bi-cash-stack me-1"></i>
                            {{ number_format($notification->data['salary_min'], 0, ',', '.') }} -
                            {{ number_format($notification->data['salary_max'], 0, ',', '.') }} VNĐ
                        </p>
                        @endif

                        @if(isset($notification->data['location']))
                        <p class="mb-2 text-muted">
                            <i class="bi bi-geo-alt-fill me-1"></i>
                            {{ $notification->data['location'] }}
                        </p>
                        @endif
                    </div>

                    {{-- Action buttons --}}
                    <div class="mt-3">
                        <button class="btn btn-sm btn-primary me-2 view-invitation-btn"
                            data-invitation-id="{{ $notification->data['invitation_id'] ?? '' }}">
                            <i class="bi bi-eye me-1"></i>Xem chi tiết
                        </button>

                        @if(isset($notification->data['job_id']))
                        <a href="{{ route('job.detail', $notification->data['job_id']) }}"
                            class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-arrow-right-circle me-1"></i>Đi đến công việc
                        </a>
                        @endif
                    </div>
                </div>

                @elseif($notification->type === 'new_application')
                {{-- For future: when applicant receives application updates --}}
                <div class="notification-details">
                    <p class="mb-1">
                        <i class="bi bi-file-earmark-text-fill text-info me-1"></i>
                        Đơn ứng tuyển của bạn đã được gửi thành công
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // ✅ Event delegation - tránh template literals trong onclick
    document.addEventListener('DOMContentLoaded', function() {
        // Mark as read
        document.addEventListener('click', function(e) {
            if (e.target.closest('.mark-read-btn')) {
                e.preventDefault();
                const notificationId = e.target.closest('.mark-read-btn').dataset.notificationId;
                markAsRead(notificationId);
            }

            // Delete notification
            if (e.target.closest('.delete-notification-btn')) {
                e.preventDefault();
                const notificationId = e.target.closest('.delete-notification-btn').dataset.notificationId;
                deleteNotification(notificationId);
            }

            // View invitation
            if (e.target.closest('.view-invitation-btn')) {
                e.preventDefault();
                const invitationId = e.target.closest('.view-invitation-btn').dataset.invitationId;
                viewInvitation(invitationId);
            }
        });
    });

    async function markAsRead(notificationId) {
        try {
            const response = await fetch('/applicant/api/notifications/' + notificationId + '/read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const data = await response.json();

            if (data.success) {
                const item = document.querySelector('[data-notification-id="' + notificationId + '"]');
                if (item) {
                    item.classList.remove('unread');
                    item.dataset.isRead = '1';
                    const badge = item.querySelector('.notification-badge');
                    if (badge) badge.style.display = 'none';
                }
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Có lỗi xảy ra');
        }
    }

    async function deleteNotification(notificationId) {
        if (!confirm('Bạn có chắc muốn xóa thông báo này?')) return;

        try {
            const response = await fetch('/applicant/api/notifications/' + notificationId, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const data = await response.json();

            if (data.success) {
                const item = document.querySelector('[data-notification-id="' + notificationId + '"]');
                if (item) {
                    item.style.transition = 'opacity 0.3s';
                    item.style.opacity = '0';
                    setTimeout(() => item.remove(), 300);
                }
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Có lỗi xảy ra');
        }
    }

    function viewInvitation(invitationId) {
        if (!invitationId) {
            alert('Không tìm thấy thông tin lời mời');
            return;
        }
        window.location.href = '/applicant/invitations/' + invitationId;
    }
</script>
@endpush