<div class="detail-container tipus-event-detail-container">
    <div class="detail-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-start">
                    <div class="detail-icon-container me-4">
                        <div class="detail-icon d-flex align-items-center justify-content-center rounded"
                            style="background-color: {{ $tipusEvent->color }}">
                            <i class="fas fa-calendar-day fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="detail-name mb-1">{{ $tipusEvent->nom }}</h2>
                        <div class="detail-badge mb-2">
                            <span class="badge py-1 px-2" style="background-color: {{ $tipusEvent->color }}">
                                {{ $tipusEvent->color }}
                            </span>
                        </div>
                        <div class="detail-date">
                            <i class="fas fa-calendar-day text-muted me-2"></i>
                            <span class="text-muted">{{ __('messages.admin.tipus_events.created_on') }} {{ $tipusEvent->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($tipusEvent->updated_at && $tipusEvent->updated_at->ne($tipusEvent->created_at))
                            <div class="detail-update">
                                <i class="fas fa-edit text-muted me-2"></i>
                                <span class="text-muted">{{ __('messages.admin.tipus_events.updated_on') }} {{ $tipusEvent->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="event-count">
                    <h5 class="mb-2">{{ __('messages.admin.tipus_events.statistics') }}</h5>
                    <div class="event-count p-3 rounded-3 shadow-sm stats-card">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span>{{ __('messages.admin.tipus_events.total_events') }}:</span>
                            <span class="badge bg-primary">{{ $tipusEvent->events()->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Descripción del tipo de evento -->
    @if($tipusEvent->descripcio)
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="info-card mb-4">
                <h4 class="card-title mb-3">
                    <i class="fas fa-align-left text-primary me-2"></i>{{ __('messages.admin.tipus_events.description') }}
                </h4>
                <div class="tipus-event-description">
                    <p class="mb-0">{{ $tipusEvent->descripcio ?: __('messages.admin.tipus_events.no_description') }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Eventos de este tipo -->
    <div class="row mt-2">
        <div class="col-lg-12">
            <div class="info-card mb-4">
                <h4 class="card-title mb-3">
                    <i class="fas fa-calendar-alt text-success me-2"></i>{{ __('messages.admin.tipus_events.events_of_this_type') }}
                </h4>
                
                @if($tipusEvent->events()->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.admin.tipus_events.name') }}</th>
                                    <th>{{ __('messages.admin.tipus_events.start_date') }}</th>
                                    <th>{{ __('messages.admin.tipus_events.end_date') }}</th>
                                    <th>{{ __('messages.admin.tipus_events.participants') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tipusEvent->events()->take(10)->get() as $event)
                                    <tr>
                                        <td>{{ $event->nom }}</td>
                                        <td>{{ $event->data_inici->format('d/m/Y H:i') }}</td>
                                        <td>{{ $event->data_fi->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ $event->participants()->count() }} {{ __('messages.admin.tipus_events.participants') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        @if($tipusEvent->events()->count() > 10)
                            <div class="text-center mt-3">
                                <span class="text-muted">{{ __('messages.admin.tipus_events.showing_events', ['showing' => 10, 'total' => $tipusEvent->events()->count()]) }}</span>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-2"></i>{{ __('messages.admin.tipus_events.no_events') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>