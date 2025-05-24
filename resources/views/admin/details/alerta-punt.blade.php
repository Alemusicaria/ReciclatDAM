<div class="detail-container alerta-detail-container">
    <div class="detail-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-start">
                    <div class="detail-icon-container me-4">
                        <div class="detail-icon alerta-icon d-flex align-items-center justify-content-center rounded">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="detail-name mb-1">
                            {{ __('messages.admin.alerts.alert_at') }} {{ $alerta->puntDeRecollida ? $alerta->puntDeRecollida->nom : __('messages.admin.alerts.unknown_point') }}
                        </h2>
                        <div class="detail-tipus mb-2">
                            <span class="badge bg-warning py-1 px-2">
                                <i class="fas fa-bell me-1"></i>{{ $alerta->tipus ? $alerta->tipus->nom : __('messages.admin.alerts.unknown_type') }}
                            </span>
                        </div>
                        <div class="detail-date">
                            <i class="fas fa-calendar-day text-muted me-2"></i>
                            <span class="text-muted">{{ __('messages.admin.alerts.created_on') }} {{ $alerta->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($alerta->updated_at && $alerta->updated_at->ne($alerta->created_at))
                            <div class="detail-update">
                                <i class="fas fa-edit text-muted me-2"></i>
                                <span class="text-muted">{{ __('messages.admin.alerts.updated_on') }} {{ $alerta->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="punt-info">
                    <h5 class="punt-title mb-2">{{ __('messages.admin.alerts.collection_point') }}</h5>
                    <div class="punt-details p-3 rounded-3 shadow-sm">
                        @if($alerta->puntDeRecollida)
                            <div class="d-flex align-items-center mb-2">
                                <div class="punto-icon punto-{{ strtolower(str_replace(' ', '-', $alerta->puntDeRecollida->fraccio)) }} rounded-circle me-2 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-recycle text-white small"></i>
                                </div>
                                <span class="ms-1 fw-medium">{{ $alerta->puntDeRecollida->nom }}</span>
                            </div>
                            <div class="punt-location small text-muted">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                {{ $alerta->puntDeRecollida->adreca }}, {{ $alerta->puntDeRecollida->ciutat }}
                            </div>
                        @else
                            <div class="text-muted">{{ __('messages.admin.alerts.point_no_longer_exists') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Descripción de la alerta -->
    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="info-card mb-4">
                <h4 class="card-title mb-3">
                    <i class="fas fa-align-left text-primary me-2"></i>{{ __('messages.admin.alerts.description') }}
                </h4>
                <div class="alert-description">
                    <p class="mb-0">{{ $alerta->descripció ?: __('messages.admin.alerts.no_description') }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            @if($alerta->imatge)
                <div class="info-card mb-4">
                    <h4 class="card-title mb-3">
                        <i class="fas fa-image text-success me-2"></i>{{ __('messages.admin.alerts.image') }}
                    </h4>
                    <div class="alert-image">
                        <img src="{{ asset($alerta->imatge) }}" alt="{{ __('messages.admin.alerts.alert_image') }}" class="img-fluid rounded">
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>