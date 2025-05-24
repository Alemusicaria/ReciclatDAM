<div class="detail-container premi-detail-container">
    <!-- Encabezado del premio -->
    <div class="detail-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="detail-image-container me-4">
                        @if($premi->imatge)
                            <img src="{{ asset($premi->imatge) }}" class="detail-image rounded" alt="{{ __('messages.admin.premis.prize_image') }}">
                        @else
                            <div class="detail-icon premi-icon d-flex align-items-center justify-content-center rounded">
                                <i class="fas fa-gift fa-3x"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h2 class="detail-name mb-1">{{ $premi->nom }}</h2>
                        <div class="detail-badge mb-2">
                            <span class="badge bg-primary py-1 px-2">
                                <i class="fas fa-coins me-1"></i>{{ $premi->punts_requerits }} {{ __('messages.admin.premis.points') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="stats-card bg-success-subtle p-3 rounded-3 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">{{ __('messages.admin.premis.claims') }}</h6>
                            <small class="text-muted">{{ __('messages.admin.premis.total_history') }}</small>
                        </div>
                        <div class="stats-value">
                            <span class="fs-4 fw-bold text-success">{{ $premi->premiReclamats()->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información detallada -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="info-card mb-4">
                <h4 class="card-title mb-3">
                    <i class="fas fa-align-left text-success me-2"></i>{{ __('messages.admin.premis.description') }}
                </h4>
                <div class="premi-description">
                    <p class="mb-0">{{ $premi->descripcio ?: __('messages.admin.premis.no_description') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de usuarios que han reclamado el premio -->
    <div class="row mt-2">
        <div class="col-12">
            <div class="info-card">
                <h4 class="card-title mb-3">
                    <i class="fas fa-users text-warning me-2"></i>{{ __('messages.admin.premis.prize_claims') }}
                </h4>
                
                @if($premi->premiReclamats->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('messages.admin.premis.user') }}</th>
                                    <th scope="col">{{ __('messages.admin.premis.claim_date') }}</th>
                                    <th scope="col">{{ __('messages.admin.premis.status') }}</th>
                                    <th scope="col">{{ __('messages.admin.premis.points') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($premi->premiReclamats as $reclamat)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($reclamat->user && $reclamat->user->foto_perfil)
                                                    <img src="{{ asset('storage/' . $reclamat->user->foto_perfil) }}" 
                                                         alt="{{ $reclamat->user->nom }}" 
                                                         class="user-avatar rounded-circle me-2">
                                                @else
                                                    <span class="user-icon-placeholder rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-user text-white"></i>
                                                    </span>
                                                @endif
                                                <span>{{ $reclamat->user ? $reclamat->user->nom . ' ' . $reclamat->user->cognoms : __('messages.admin.premis.user_not_available') }}</span>
                                            </div>
                                        </td>
                                        <td>{{ date('d/m/Y', strtotime($reclamat->data_reclamacio)) }}</td>
                                        <td>
                                            <span class="badge {{ $reclamat->estat === 'entregat' ? 'bg-success' : 
                                                           ($reclamat->estat === 'pendent' ? 'bg-warning' : 'bg-secondary') }}">
                                                {{ ucfirst($reclamat->estat) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $reclamat->punts_gastats }} pts</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state text-center p-4">
                        <i class="fas fa-gift text-muted fa-3x mb-3"></i>
                        <p class="lead">{{ __('messages.admin.premis.not_claimed_yet') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>