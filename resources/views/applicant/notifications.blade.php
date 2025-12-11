@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>
                    <i class="bi bi-bell-fill"></i>
                    Thông báo
                </h3>
                @if($notifications->count() > 0)
                <button class="btn btn-sm btn-outline-secondary" id="markAllReadBtn">
                    <i class="bi bi-check-all me-1"></i>Đánh dấu tất cả đã đọc
                </button>
                @endif
            </div>

            <div id="notificationsContainer">
                @forelse($notifications as $notification)
                @include('applicant.partials.notification-item', ['notification' => $notification])
                @empty
                <div class="alert alert-info text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 2rem; display: block; margin-bottom: 1rem;"></i>
                    <p class="mb-0">Bạn không có thông báo nào</p>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($notifications->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $notifications->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const markAllReadBtn = document.getElementById('markAllReadBtn');
        if (markAllReadBtn) {
            markAllReadBtn.addEventListener('click', function() {
                markAllAsRead();
            });
        }
    });

    async function markAllAsRead() {
        try {
            const response = await fetch('/applicant/notifications/read-all', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const data = await response.json();

            if (data.success) {
                document.querySelectorAll('.notification-item.unread').forEach(item => {
                    item.classList.remove('unread');
                    item.dataset.isRead = '1';
                    const badge = item.querySelector('.notification-badge');
                    if (badge) badge.style.display = 'none';
                });
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Có lỗi xảy ra');
        }
    }
</script>
@endpush
@endsection