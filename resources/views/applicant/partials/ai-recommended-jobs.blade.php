{{-- AI Recommended Jobs Partial --}}
{{-- File: resources/views/applicant/partials/ai-recommended-jobs.blade.php --}}


@if($recommendedJobs && $recommendedJobs->count() > 0)
<!-- ✅ RECOMMENDED JOBS GRID VIEW (THUẬT TOÁN CŨ) -->
<div class="recommended-jobs-grid" id="recommendedJobsGrid">
    @foreach($recommendedJobs as $rec)
    @php
    $job = $rec->job;
    $matchScore = $rec->score ?? 0;
    $matchClass = $matchScore >= 80 ? 'high-match' : ($matchScore >= 60 ? 'medium-match' : 'low-match');
    @endphp

    <div class="recommended-job-card {{ $matchClass }}" data-job-id="{{ $job->job_id }}">
        <div class="match-badge {{ $matchClass }}">
            <div class="match-percentage">{{ number_format($matchScore, 0) }}%</div>
        </div>

        <div class="rec-job-header">
            <div class="rec-company-logo">
                @if($job->company && $job->company->logo)
                <img src="{{ asset('assets/img/' . $job->company->logo) }}" alt="{{ $job->company->tencty }}">
                @else
                <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667EEA, #764BA2); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.5rem;">
                    {{ substr($job->company->tencty ?? 'C', 0, 1) }}
                </div>
                @endif
            </div>
            <div class="rec-job-info">
                <h4 class="rec-job-title">{{ Str::limit($job->title, 45) }}</h4>
                <p class="rec-company-name">{{ $job->company->tencty ?? 'Công ty' }}</p>
            </div>
        </div>

        <div class="rec-job-meta">
            <span class="meta-item">
                <i class="bi bi-geo-alt"></i>
                {{ $job->province }}
            </span>
            <span class="meta-item">
                <i class="bi bi-briefcase"></i>
                {{ ucfirst($job->level) }}
            </span>
        </div>

        <div class="rec-job-salary">
            @if($job->salary_min && $job->salary_max)
            {{ number_format($job->salary_min, 0, ',', '.') }} - {{ number_format($job->salary_max, 0, ',', '.') }} {{ strtoupper($job->salary_type) }}
            @else
            <span class="negotiable">Thỏa thuận</span>
            @endif
        </div>

        @if($job->hashtags && $job->hashtags->count() > 0)
        <div class="rec-job-tags">
            @foreach($job->hashtags->take(3) as $tag)
            <span class="rec-tag">{{ $tag->tag_name }}</span>
            @endforeach
            @if($job->hashtags->count() > 3)
            <span class="rec-tag more">+{{ $job->hashtags->count() - 3 }}</span>
            @endif
        </div>
        @endif

        <div class="rec-job-deadline">
            <i class="bi bi-clock-history"></i>
            Hạn: {{ \Carbon\Carbon::parse($job->deadline)->format('d/m/Y') }}
        </div>

        <div class="rec-job-actions">
            <button type="button" class="rec-btn rec-btn-primary" title="Ứng tuyển">
                <i class="bi bi-send-fill"></i>
                <span>Ứng tuyển</span>
            </button>

            <button type="button" class="rec-btn rec-btn-detail" title="Xem chi tiết">
                <i class="bi bi-arrow-right"></i>
            </button>

            <button type="button" class="rec-btn rec-btn-icon" title="Lưu công việc">
                <i class="bi bi-heart"></i>
            </button>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="rec-empty-state" id="recEmptyState">
    <div class="empty-icon">
        <i class="bi bi-robot"></i>
    </div>
    <h4>Chưa có gợi ý việc làm phù hợp</h4>
    <p>Hãy cập nhật hồ sơ để nhận gợi ý việc làm tốt nhất</p>
</div>
@endif