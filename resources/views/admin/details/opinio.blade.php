<div class="detail-container opinio-detail-container">
    <div class="detail-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-start">
                    <div class="detail-icon-container me-4">
                        <div class="detail-icon opinio-icon d-flex align-items-center justify-content-center rounded">
                            <i class="fas fa-comment-dots fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="detail-name mb-1">{{ __('messages.admin.opinions.opinion_number', ['id' => $opinio->id]) }}</h2>
                        <div class="stars mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $opinio->estrelles ? 'text-warning' : 'text-muted' }} fa-lg"></i>
                            @endfor
                            <span class="ms-2 fw-bold">{{ $opinio->estrelles }}/5</span>
                        </div>
                        <div class="detail-date">
                            <i class="fas fa-calendar-day text-muted me-2"></i>
                            <span class="text-muted">{{ __('messages.admin.opinions.published_on') }} {{ $opinio->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($opinio->updated_at->ne($opinio->created_at))
                            <div class="detail-update mt-1">
                                <i class="fas fa-edit text-muted me-2"></i>
                                <span class="text-muted">{{ __('messages.admin.opinions.updated_on') }} {{ $opinio->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="autor-info">
                    <div class="info-card p-3">
                        <div class="d-flex align-items-center">
                            <div class="autor-icon rounded-circle me-2 d-flex align-items-center justify-content-center bg-primary text-white">
                                {{ substr($opinio->autor, 0, 1) }}
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $opinio->autor }}</h6>
                                <small class="text-muted">{{ __('messages.admin.opinions.author') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido de la opinión -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="info-card mb-4">
                <h4 class="card-title mb-3">
                    <i class="fas fa-comment text-primary me-2"></i>{{ __('messages.admin.opinions.comment') }}
                </h4>
                <div class="opinio-text">
                    <p class="mb-0">{{ $opinio->comentari ?: __('messages.admin.opinions.no_comment_available') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>