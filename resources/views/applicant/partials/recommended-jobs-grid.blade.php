@if($recommendedJobs && $recommendedJobs->count() > 0)
<!-- ✅ RECOMMENDED JOBS GRID VIEW (MẶC ĐỊNH) -->
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

        <div class="match-indicator {{ $matchClass }}"></div>
    </div>
    @endforeach
</div>

<div class="text-center mt-4">
    <a href="{{ route('applicant.recommendations') }}" class="btn-view-all">
        <i class="bi bi-stars"></i>
        <span>Xem tất cả gợi ý ({{ $recommendedJobs->total() }})</span>
        <i class="bi bi-arrow-right"></i>
    </a>
</div>

<!-- ✅ RECOMMENDED JOBS DETAIL VIEW (2 COLUMNS - MỚI THÊM) -->
<div class="recommended-detail-view" id="recommendedDetailView" style="display: none;">
    <button class="back-to-grid-rec" id="backToRecGrid">
        <i class="bi bi-arrow-left"></i>
        Quay lại danh sách
    </button>

    <!-- Left Column - Recommended Jobs List -->
    <div class="rec-list-column" id="recListColumn">
        <div class="rec-list-header">
            <h3>Công việc được gợi ý</h3>
            <p class="text-muted">{{ $recommendedJobs->total() }} công việc</p>
        </div>
        <div id="recJobsList">
            @foreach($recommendedJobs as $rec)
            @php
            $job = $rec->job;
            $matchScore = $rec->score ?? 0;
            $matchClass = $matchScore >= 80 ? 'high-match' : ($matchScore >= 60 ? 'medium-match' : 'low-match');
            @endphp
            <div class="rec-job-list-item {{ $matchClass }}" data-job-id="{{ $job->job_id }}">
                <div class="rec-list-match-badge">
                    {{ number_format($matchScore, 0) }}%
                </div>

                <div class="rec-list-logo">
                    @if($job->company && $job->company->logo)
                    <img src="{{ asset('assets/img/' . $job->company->logo) }}" alt="{{ $job->company->tencty }}">
                    @else
                    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667EEA, #764BA2); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                        {{ substr($job->company->tencty ?? 'C', 0, 1) }}
                    </div>
                    @endif
                </div>

                <div class="rec-list-content">
                    <h4 class="rec-list-title">{{ Str::limit($job->title, 40) }}</h4>
                    <p class="rec-list-company">{{ $job->company->tencty ?? 'Công ty' }}</p>
                    <div class="rec-list-meta">
                        <span><i class="bi bi-geo-alt"></i> {{ $job->province }}</span>
                        <span><i class="bi bi-briefcase"></i> {{ ucfirst($job->level) }}</span>
                    </div>
                    <div class="rec-list-salary">
                        @if($job->salary_min && $job->salary_max)
                        {{ number_format($job->salary_min, 0, ',', '.') }} - {{ number_format($job->salary_max, 0, ',', '.') }}
                        @else
                        Thỏa thuận
                        @endif
                    </div>
                </div>

                <div class="rec-list-actions">
                    <button class="rec-list-apply" title="Ứng tuyển">
                        <i class="bi bi-send-fill"></i>
                    </button>
                    <button class="rec-list-save" title="Lưu công việc">
                        <i class="bi bi-heart"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Right Column - Job Detail -->
    <div class="rec-detail-column" id="recDetailColumn">
        <div class="rec-job-detail-empty">
            <i class="bi bi-briefcase"></i>
            <p>Chọn một công việc để xem chi tiết</p>
        </div>
    </div>
</div>

@else
<div class="rec-empty-state">
    <div class="empty-icon">
        <i class="bi bi-stars"></i>
    </div>
    <h4>Chưa có gợi ý</h4>
    <p>Hoàn thành hồ sơ của bạn để nhận những gợi ý công việc tốt nhất</p>
    <a href="{{ route('applicant.profile') }}" class="btn-complete-profile">
        <i class="bi bi-pencil-square"></i>
        Hoàn thành hồ sơ
    </a>
</div>
@endif