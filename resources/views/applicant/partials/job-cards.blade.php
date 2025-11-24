@forelse($jobs as $job)
<article class="job-card-grid" data-job-id="{{ $job->job_id }}">
    <!-- Header -->
    <div class="job-card-grid-header">
        <div class="company-logo-grid">
            @if($job->company && $job->company->logo)
            <img src="{{ asset('assets/img/' . $job->company->logo) }}" alt="Company Logo" />
            @else
            <div class="default-logo">
                {{ substr($job->company->tencty ?? 'C', 0, 1) }}
            </div>
            @endif
        </div>
        <div class="job-card-grid-info">
            <h3 class="job-card-grid-title">{{ $job->title }}</h3>
            <div class="company-name-grid">{{ $job->company->tencty ?? 'Công ty' }}</div>
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

    <!-- Meta Info -->
    <div class="job-card-grid-meta">
        <div class="job-card-grid-meta-item">
            <i class="bi bi-geo-alt-fill"></i>
            <span>{{ $job->province }}</span>
        </div>
        <div class="job-card-grid-meta-item">
            <i class="bi bi-briefcase-fill"></i>
            <span>{{ ucfirst($job->level) }}</span>
        </div>
        <div class="job-card-grid-meta-item">
            <i class="bi bi-award-fill"></i>
            <span>{{ $job->experience }}</span>
        </div>
    </div>

    <!-- Hashtags -->
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
@empty
<div class="col-12 text-center py-5">
    <i class="bi bi-inbox" style="font-size: 4rem; color: #cbd5e0;"></i>
    <p class="text-muted mt-3">Không có công việc nào</p>
</div>
@endforelse