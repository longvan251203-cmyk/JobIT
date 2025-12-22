<div class="modal fade" id="analysisModal-{{ $rec->id }}" tabindex="-1" aria-labelledby="analysisModalLabel-{{ $rec->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="analysisModalLabel-{{ $rec->id }}">
                    <i class="bi bi-bar-chart-line text-primary"></i> Vì sao bạn phù hợp với công việc này?
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="match-analysis-compact">
                    <div class="criteria-compact">
                        @if(!empty($details) && is_array($details))
                        @foreach($details as $criteria)
                        <div class="criteria-item-compact mb-3">
                            <div class="criteria-header-compact">
                                <div class="criteria-name-compact">
                                    <i class="bi bi-graph-up"></i>
                                    @php
                                    // Lấy đúng tên tiêu chí từ trường name nếu có
                                    $name = isset($criteria['name']) ? trim($criteria['name']) : '';
                                    @endphp
                                    {{ $name !== '' ? $name : (isset($loop) && isset($loop->index) ? 'Tiêu chí '.($loop->index+1) : 'Tiêu chí') }}
                                </div>
                                <div class="criteria-score-compact {{ $getScoreLevel($criteria['score'] ?? 0) }}">
                                    {{ $criteria['score'] ?? 0 }}
                                </div>
                            </div>
                            <div class="progress-bar-compact">
                                <div class="progress-fill-compact {{ $getScoreLevel($criteria['score'] ?? 0) }}" style="width: {{ $criteria['score'] ?? 0 }}%;"></div>
                            </div>
                            @if(!empty($criteria['reason']))
                            <div class="criteria-reason-compact">
                                {{ $criteria['reason'] }}
                            </div>
                            @endif
                            @if(!empty($criteria['skills']))
                            <div class="skills-details-compact">
                                <div class="skills-section-title-compact">Kỹ năng phù hợp:</div>
                                <div class="skill-tags-compact">
                                    @foreach($criteria['skills'] as $skill)
                                    <span class="skill-tag-compact matched">{{ $skill }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @if(!empty($criteria['missing_skills']))
                            <div class="skills-details-compact">
                                <div class="skills-section-title-compact">Kỹ năng còn thiếu:</div>
                                <div class="skill-tags-compact">
                                    @foreach($criteria['missing_skills'] as $skill)
                                    <span class="skill-tag-compact missing">{{ $skill }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        @endforeach
                        @else
                        <div class="text-muted">Không có dữ liệu phân tích chi tiết.</div>
                        @endif
                    </div>
                </div>
                <div class="alert alert-success mt-4 d-flex align-items-center" role="alert">
                    <i class="bi bi-lightbulb me-2"></i>
                    <div>
                        <strong>Lời khuyên:</strong> Hồ sơ của bạn rất phù hợp với công việc này. Hãy tự tin ứng tuyển để tăng cơ hội thành công!
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ route('job.detail', $job->job_id) }}" class="btn btn-primary">
                    <i class="bi bi-send-check"></i> Ứng tuyển ngay
                </a>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>