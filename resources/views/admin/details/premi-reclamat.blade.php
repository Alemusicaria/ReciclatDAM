<div class="detail-container premi-reclamat-detail-container">
    <div class="detail-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="d-flex align-items-start">
                    <div class="detail-icon-container me-4">
                        @if($premiReclamat->premi && $premiReclamat->premi->imatge)
                            <img src="{{ asset($premiReclamat->premi->imatge) }}" alt="{{ __('messages.admin.claimed_prizes.prize') }}" class="detail-image rounded">
                        @else
                            <div class="detail-icon premi-reclamat-icon d-flex align-items-center justify-content-center rounded">
                                <i class="fas fa-gift fa-2x"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h2 class="detail-name mb-1">
                            {{ $premiReclamat->premi ? $premiReclamat->premi->nom : __('messages.admin.claimed_prizes.unknown_prize') }}
                        </h2>
                        <div class="detail-badge mb-2">
                            <span class="badge bg-primary">{{ $premiReclamat->punts_gastats }} {{ __('messages.admin.claimed_prizes.points') }}</span>
                            @if($premiReclamat->estat == 'pendent')
                                <span class="badge bg-warning text-dark ms-2">{{ __('messages.admin.claimed_prizes.pending') }}</span>
                            @elseif($premiReclamat->estat == 'procesant')
                                <span class="badge bg-info ms-2">{{ __('messages.admin.claimed_prizes.processing') }}</span>
                            @elseif($premiReclamat->estat == 'entregat')
                                <span class="badge bg-success ms-2">{{ __('messages.admin.claimed_prizes.delivered') }}</span>
                            @elseif($premiReclamat->estat == 'cancelat')
                                <span class="badge bg-danger ms-2">{{ __('messages.admin.claimed_prizes.canceled') }}</span>
                            @endif
                        </div>
                        <div class="detail-date">
                            <i class="fas fa-calendar-day text-muted me-2"></i>
                            <span class="text-muted">{{ __('messages.admin.claimed_prizes.claimed_on') }}
                                {{ $premiReclamat->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="d-flex justify-content-md-end">
                    @if($premiReclamat->estat == 'pendent')
                        <div class="d-flex justify-content-md-end">
                            <button type="button" class="btn btn-success me-2 approveBtn" data-id="{{ $premiReclamat->id }}">
                                <i class="fas fa-check me-2"></i>{{ __('messages.admin.claimed_prizes.approve_request') }}
                            </button>
                            <button type="button" class="btn btn-danger rejectBtn" data-id="{{ $premiReclamat->id }}">
                                <i class="fas fa-times me-2"></i>{{ __('messages.admin.claimed_prizes.reject_request') }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Información del usuario -->
        <div class="col-md-6 mb-4">
            <div class="info-card">
                <h4 class="card-title mb-3">
                    <i class="fas fa-user text-primary me-2"></i>{{ __('messages.admin.claimed_prizes.user_info') }}
                </h4>

                @if($premiReclamat->user)
                    <div class="user-info-container">
                        <div class="d-flex align-items-center mb-3">
                            @if($premiReclamat->user->foto_perfil)
                                <img src="{{ Str::startsWith($premiReclamat->user->foto_perfil, ['http://', 'https://']) ?
                                    $premiReclamat->user->foto_perfil :
                                    asset('storage/' . $premiReclamat->user->foto_perfil) }}" class="user-avatar rounded-circle me-3" 
                                    alt="{{ __('messages.admin.profile_photo') }}">
                            @else
                                <div class="user-icon-placeholder rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            @endif

                            <div>
                                <h5 class="mb-1">{{ $premiReclamat->user->nom }} {{ $premiReclamat->user->cognoms }}</h5>
                                <p class="mb-0 text-muted">{{ $premiReclamat->user->email }}</p>
                            </div>
                        </div>

                        <div class="user-details mb-3">
                            <div class="row mb-2">
                                <div class="col-md-4 fw-bold">{{ __('messages.admin.claimed_prizes.current_points') }}:</div>
                                <div class="col-md-8">{{ $premiReclamat->user->punts_actuals }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4 fw-bold">{{ __('messages.admin.claimed_prizes.total_points') }}:</div>
                                <div class="col-md-8">{{ $premiReclamat->user->punts_totals }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4 fw-bold">{{ __('messages.admin.claimed_prizes.spent_points') }}:</div>
                                <div class="col-md-8">{{ $premiReclamat->user->punts_gastats }}</div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ __('messages.admin.claimed_prizes.user_no_longer_exists') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Información de envío -->
        <div class="col-md-6 mb-4">
            <div class="info-card">
                <h4 class="card-title mb-3">
                    <i class="fas fa-shipping-fast text-success me-2"></i>{{ __('messages.admin.claimed_prizes.shipping_info') }}
                </h4>

                @if($premiReclamat->codi_seguiment)
                    <div class="shipping-info mb-3">
                        <div class="row mb-2">
                            <div class="col-md-5 fw-bold">{{ __('messages.admin.claimed_prizes.tracking_code') }}:</div>
                            <div class="col-md-7">{{ $premiReclamat->codi_seguiment }}</div>
                        </div>
                    </div>
                @else
                    <p>{{ __('messages.admin.claimed_prizes.no_tracking_code') }}</p>
                @endif

                @if($premiReclamat->estat != 'entregat' && $premiReclamat->estat != 'cancelat')
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button class="btn btn-primary editStatusBtn" data-id="{{ $premiReclamat->id }}">
                                    <i class="fas fa-edit me-2"></i>{{ __('messages.admin.claimed_prizes.update_status') }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Comentarios -->
    @if($premiReclamat->comentaris)
        <div class="row">
            <div class="col-12">
                <div class="info-card mb-4">
                    <h4 class="card-title mb-3">
                        <i class="fas fa-comment-alt text-info me-2"></i>{{ __('messages.admin.claimed_prizes.comments') }}
                    </h4>
                    <div class="comentaris">
                        <p class="mb-0">{{ $premiReclamat->comentaris }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($premiReclamat->estat != 'entregat' && $premiReclamat->estat != 'cancelat')
        <div class="row mt-3">
            <div class="col-12">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-primary editStatusBtn" data-id="{{ $premiReclamat->id }}">
                        <i class="fas fa-edit me-2"></i>{{ __('messages.admin.claimed_prizes.update_status') }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>