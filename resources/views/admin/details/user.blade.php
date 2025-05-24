<div class="detail-container user-detail-container">
    <!-- Encabezado del perfil -->
    <div class="profile-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="user-avatar-container me-4">
                        @if($user->foto_perfil)
                            @if(str_starts_with($user->foto_perfil, 'https://'))
                                <img src="{{ $user->foto_perfil }}" class="user-avatar rounded-circle" alt="{{ __('messages.admin.profile_photo') }}">
                            @elseif(file_exists(public_path('storage/' . $user->foto_perfil)))
                                <img src="{{ asset('storage/' . $user->foto_perfil) }}" class="user-avatar rounded-circle" alt="{{ __('messages.admin.profile_photo') }}">
                            @else
                                <img src="{{ asset('images/default-profile.png') }}" class="user-avatar rounded-circle" alt="{{ __('messages.admin.profile_photo') }}">
                            @endif
                        @else
                            <img src="{{ asset('images/default-profile.png') }}" class="user-avatar rounded-circle" alt="{{ __('messages.admin.profile_photo') }}">
                        @endif
                    </div>
                    <div>
                        <h2 class="user-name mb-1">{{ $user->nom }} {{ $user->cognoms }}</h2>
                        <div class="user-email mb-2">
                            <i class="fas fa-envelope text-muted me-2"></i>{{ $user->email }}
                        </div>
                        <div class="user-status">
                            <span class="badge {{ $user->rol->nom === 'Administrador' ? 'bg-danger' : ($user->rol->nom === 'Gestor' ? 'bg-warning' : 'bg-success') }} py-1 px-2">
                                <i class="fas fa-user-shield me-1"></i>{{ $user->rol->nom }}
                            </span>
                            @if($user->nivell())
                                <span class="badge bg-info py-1 px-2 ms-2">
                                    <i class="fas fa-trophy me-1"></i>{{ $user->nivell()->nom }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="user-points-summary">
                    <div class="points-card bg-primary-subtle p-3 rounded-3 shadow-sm mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">{{ __('messages.admin.users.current_points') }}</h6>
                                <small class="text-muted">{{ __('messages.admin.users.available_to_use') }}</small>
                            </div>
                            <div class="points-value">
                                <span class="fs-4 fw-bold text-primary">{{ $user->punts_actuals }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="points-card bg-success-subtle p-3 rounded-3 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">{{ __('messages.admin.users.total_points') }}</h6>
                                <small class="text-muted">{{ __('messages.admin.users.historically_accumulated') }}</small>
                            </div>
                            <div class="points-value">
                                <span class="fs-4 fw-bold text-success">{{ $user->punts_totals }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información detallada -->
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="info-card mb-4">
                <h4 class="card-title mb-3">
                    <i class="fas fa-user-circle text-primary me-2"></i>{{ __('messages.admin.users.personal_info') }}
                </h4>
                <div class="user-info-list">
                    <div class="info-item d-flex mb-3">
                        <div class="info-label me-2 text-muted">
                            <i class="fas fa-calendar-day me-2"></i>{{ __('messages.admin.users.birth_date') }}:
                        </div>
                        <div class="info-value fw-medium">
                            {{ $user->data_naixement ? date('d/m/Y', strtotime($user->data_naixement)) : __('messages.admin.users.not_specified') }}
                        </div>
                    </div>
                    <div class="info-item d-flex mb-3">
                        <div class="info-label me-2 text-muted">
                            <i class="fas fa-phone me-2"></i>{{ __('messages.admin.users.phone') }}:
                        </div>
                        <div class="info-value fw-medium">
                            {{ $user->telefon ?: __('messages.admin.users.not_specified') }}
                        </div>
                    </div>
                    <div class="info-item d-flex mb-3">
                        <div class="info-label me-2 text-muted">
                            <i class="fas fa-map-marker-alt me-2"></i>{{ __('messages.admin.users.location') }}:
                        </div>
                        <div class="info-value fw-medium">
                            {{ $user->ubicacio ?: __('messages.admin.users.not_specified') }}
                        </div>
                    </div>
                    <div class="info-item d-flex mb-3">
                        <div class="info-label me-2 text-muted">
                            <i class="fas fa-calendar-check me-2"></i>{{ __('messages.admin.users.registration_date') }}:
                        </div>
                        <div class="info-value fw-medium">
                            {{ date('d/m/Y', strtotime($user->created_at)) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="info-card mb-4">
                <h4 class="card-title mb-3">
                    <i class="fas fa-recycle text-success me-2"></i>{{ __('messages.admin.users.recycling_activity') }}
                </h4>
                <div class="recycling-summary">
                    <!-- Resumen de puntos en tarjetas de colores -->
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="mini-stat-card bg-warning-subtle p-3 rounded-3">
                                <h6 class="mini-stat-title mb-1">{{ __('messages.admin.users.spent_points') }}</h6>
                                <div class="mini-stat-value fs-5 fw-bold text-warning">
                                    {{ $user->punts_gastats }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mini-stat-card bg-info-subtle p-3 rounded-3">
                                <h6 class="mini-stat-title mb-1">{{ __('messages.admin.users.scanned_codes') }}</h6>
                                <div class="mini-stat-value fs-5 fw-bold text-info">
                                    {{ $user->codis()->count() }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mt-2">
                            <div class="mini-stat-card bg-success-subtle p-3 rounded-3">
                                <h6 class="mini-stat-title mb-1">{{ __('messages.admin.users.obtained_prizes') }}</h6>
                                <div class="mini-stat-value fs-5 fw-bold text-success">
                                    {{ $user->premisReclamats()->count() }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mt-2">
                            <div class="mini-stat-card bg-danger-subtle p-3 rounded-3">
                                <h6 class="mini-stat-title mb-1">{{ __('messages.admin.users.attended_events') }}</h6>
                                <div class="mini-stat-value fs-5 fw-bold text-danger">
                                    {{ $user->events()->count() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de premios reclamados -->
    <div class="row mt-2">
        <div class="col-12">
            <div class="info-card">
                <h4 class="card-title mb-3">
                    <i class="fas fa-gift text-warning me-2"></i>{{ __('messages.admin.users.claimed_prizes') }}
                </h4>
                
                @if($user->premisReclamats->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.admin.users.prize') }}</th>
                                    <th>{{ __('messages.admin.users.date') }}</th>
                                    <th>{{ __('messages.admin.users.status') }}</th>
                                    <th>{{ __('messages.admin.users.points') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->premisReclamats as $reclamat)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($reclamat->premi && $reclamat->premi->imatge)
                                                    <img src="{{ asset($reclamat->premi->imatge) }}" 
                                                         alt="{{ $reclamat->premi->nom }}" 
                                                         class="prize-image me-2 rounded">
                                                @else
                                                    <span class="prize-placeholder me-2 bg-secondary rounded d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-gift text-white"></i>
                                                    </span>
                                                @endif
                                                <span>{{ $reclamat->premi ? $reclamat->premi->nom : __('messages.admin.users.deleted_prize') }}</span>
                                            </div>
                                        </td>
                                        <td>{{ date('d/m/Y', strtotime($reclamat->data_reclamacio)) }}</td>
                                        <td>
                                            <span class="badge {{ $reclamat->estat === 'Entregat' ? 'bg-success' : 
                                                           ($reclamat->estat === 'Pendent' ? 'bg-warning' : 'bg-secondary') }}">
                                                {{ $reclamat->estat }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $reclamat->premi ? $reclamat->premi->punts_requerits : 'N/A' }} pts</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state text-center p-4">
                        <i class="fas fa-gift text-muted fa-3x mb-3"></i>
                        <p class="lead">{{ __('messages.admin.users.no_prizes_claimed') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>