<div class="detail-container tipus-alerta-detail-container">
    <div class="detail-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-start">
                    <div class="detail-icon-container me-4">
                        <div class="detail-icon tipus-alerta-icon d-flex align-items-center justify-content-center rounded">
                            <i class="fas fa-bell fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="detail-name mb-1">{{ $tipusAlerta->nom }}</h2>
                        <div class="detail-date">
                            <i class="fas fa-calendar-day text-muted me-2"></i>
                            <span class="text-muted">{{ __('messages.admin.tipus_alertes.created_on') }} {{ $tipusAlerta->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($tipusAlerta->updated_at && $tipusAlerta->updated_at != $tipusAlerta->created_at)
                            <div class="detail-update">
                                <i class="fas fa-edit text-muted me-2"></i>
                                <span class="text-muted">{{ __('messages.admin.tipus_alertes.last_update') }}: {{ $tipusAlerta->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="alert-info">
                    <h5 class="mb-2">{{ __('messages.admin.tipus_alertes.statistics') }}</h5>
                    <div class="alert-count p-3 rounded-3 shadow-sm stats-card">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span>{{ __('messages.admin.tipus_alertes.total_alerts') }}:</span>
                            <span class="badge bg-primary">{{ $tipusAlerta->alertes()->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Historial d'alertes -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="info-card mb-4">
                <h4 class="card-title mb-3">
                    <i class="fas fa-history text-primary me-2"></i>{{ __('messages.admin.tipus_alertes.alerts_history') }}
                </h4>
                
                @if($tipusAlerta->alertes()->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.admin.tipus_alertes.collection_point') }}</th>
                                    <th>{{ __('messages.admin.tipus_alertes.alert_date') }}</th>
                                    <th>{{ __('messages.admin.tipus_alertes.status') }}</th>
                                    <th>{{ __('messages.admin.tipus_alertes.description') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tipusAlerta->alertes()->latest()->take(10)->get() as $alerta)
                                    <tr>
                                        <td>
                                            @if($alerta->puntDeRecollida)
                                                {{ $alerta->puntDeRecollida->nom }}
                                            @else
                                                {{ __('messages.admin.tipus_alertes.removed') }}
                                            @endif
                                        </td>
                                        <td>{{ $alerta->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge {{ $alerta->estat == 'activa' ? 'bg-danger' : 'bg-success' }}">
                                                {{ $alerta->estat }}
                                            </span>
                                        </td>
                                        <td>{{ $alerta->descripcio }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        @if($tipusAlerta->alertes()->count() > 10)
                            <div class="text-center mt-3">
                                <span class="text-muted">{{ __('messages.admin.tipus_alertes.showing_alerts', ['showing' => 10, 'total' => $tipusAlerta->alertes()->count()]) }}</span>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-2"></i>{{ __('messages.admin.tipus_alertes.no_alerts') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>