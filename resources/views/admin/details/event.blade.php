<div class="detail-container event-detail-container">
    <div class="detail-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="event-image-container me-4">
                        @if($event->imatge)
                            <img src="{{ asset('storage/' . $event->imatge) }}" class="event-image rounded" alt="{{ __('messages.admin.events.event_image') }}">
                        @else
                            <div class="event-placeholder rounded d-flex align-items-center justify-content-center" 
                                style="background-color: {{ $event->tipus ? $event->tipus->color : '#3f51b5' }};">
                                <i class="fas fa-calendar-alt fa-3x text-white"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h2 class="event-name mb-1">{{ $event->nom }}</h2>
                        <div class="event-type mb-2">
                            <span class="badge py-1 px-2" style="background-color: {{ $event->tipus ? $event->tipus->color : '#3f51b5' }};">
                                <i class="fas fa-tag me-1"></i>{{ $event->tipus ? $event->tipus->nom : __('messages.admin.events.no_type') }}
                            </span>
                        </div>
                        <div class="detail-date">
                            <i class="fas fa-calendar-day text-muted me-2"></i>
                            <span class="text-muted">{{ $event->data_inici->format('d/m/Y H:i') }} - {{ $event->data_fi ? $event->data_fi->format('d/m/Y H:i') : __('messages.admin.events.indefinite') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="event-stats">
                    <div class="stats-card bg-primary-subtle p-3 rounded-3 shadow-sm mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">{{ __('messages.admin.events.participants') }}</h6>
                                <small class="text-muted">{{ __('messages.admin.events.registered_people') }}</small>
                            </div>
                            <div class="stats-value">
                                <span class="fs-4 fw-bold text-primary">{{ $event->participants()->count() }} / {{ $event->capacitat ?: '∞' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="stats-card bg-success-subtle p-3 rounded-3 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">{{ __('messages.admin.events.assigned_points') }}</h6>
                                <small class="text-muted">{{ __('messages.admin.events.for_this_event') }}</small>
                            </div>
                            <div class="stats-value">
                                <span class="fs-4 fw-bold text-success">{{ $event->punts_disponibles ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="info-card mb-4">
                <h4 class="card-title mb-3">
                    <i class="fas fa-info-circle text-primary me-2"></i>{{ __('messages.admin.events.event_info') }}
                </h4>
                <div class="event-info-list">
                    <div class="info-item d-flex mb-3">
                        <div class="info-label me-2 text-muted">
                            <i class="fas fa-map-marker-alt me-2"></i>{{ __('messages.admin.events.location') }}:
                        </div>
                        <div class="info-value fw-medium">
                            {{ $event->lloc ?: __('messages.admin.events.not_specified') }}
                        </div>
                    </div>
                    <div class="info-item d-flex mb-3">
                        <div class="info-label me-2 text-muted">
                            <i class="fas fa-users me-2"></i>{{ __('messages.admin.events.capacity') }}:
                        </div>
                        <div class="info-value fw-medium">
                            {{ $event->capacitat ?: __('messages.admin.events.no_limit') }}
                        </div>
                    </div>
                    <div class="info-item d-flex mb-3">
                        <div class="info-label me-2 text-muted">
                            <i class="fas fa-calendar-plus me-2"></i>{{ __('messages.admin.events.created') }}:
                        </div>
                        <div class="info-value fw-medium">
                            {{ date('d/m/Y', strtotime($event->created_at)) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="info-card mb-4">
                <h4 class="card-title mb-3">
                    <i class="fas fa-align-left text-success me-2"></i>{{ __('messages.admin.events.description') }}
                </h4>
                <div class="event-description">
                    <p class="mb-0">{{ $event->descripcio ?: __('messages.admin.events.no_description') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
            <div class="info-card">
                <h4 class="card-title mb-3">
                    <i class="fas fa-users text-warning me-2"></i>{{ __('messages.admin.events.participants') }}
                </h4>
                
                @if($event->participants->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.admin.events.user') }}</th>
                                    <th>{{ __('messages.admin.events.registration_date') }}</th>
                                    <th>{{ __('messages.admin.events.points') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($event->participants as $participant)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($participant->foto_perfil)
                                                    <img src="{{ asset('storage/' . $participant->foto_perfil) }}" 
                                                         alt="{{ $participant->nom }}" 
                                                         class="user-avatar rounded-circle me-2">
                                                @else
                                                    <span class="user-icon-placeholder me-2 rounded-circle d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-user"></i>
                                                    </span>
                                                @endif
                                                <span>{{ $participant->nom }} {{ $participant->cognoms }}</span>
                                            </div>
                                        </td>
                                        <td>{{ date('d/m/Y', strtotime($participant->pivot->created_at)) }}</td>
                                        <td>
                                            <span class="badge bg-success">{{ $participant->pivot->punts ?? 0 }} pts</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state text-center p-4">
                        <i class="fas fa-users text-muted fa-3x mb-3"></i>
                        <p class="lead">{{ __('messages.admin.events.no_participants_yet') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>