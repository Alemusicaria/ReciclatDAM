<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">{{ __('messages.admin.events.list_title') }}</h5>
    <button id="newEventBtn" class="btn btn-success btn-sm admin-action-btn" data-bs-toggle="modal" data-bs-target="#detailModal"
        data-detail-type="create-event" data-detail-title="{{ __('messages.admin.events.new_event') }}">
        <i class="fas fa-plus-circle me-1"></i> {{ __('messages.admin.events.new_event') }}
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped admin-table" id="eventsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('messages.admin.events.name') }}</th>
                <th>{{ __('messages.admin.events.start_date') }}</th>
                <th>{{ __('messages.admin.events.type') }}</th>
                <th>{{ __('messages.admin.events.participants') }}</th>
                <th>{{ __('messages.admin.common.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
                <tr>
                    <td>{{ $event->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($event->imatge)
                                <img src="{{ asset('storage/' . $event->imatge) }}" class="event-image rounded me-2"
                                    alt="{{ __('messages.admin.events.event_image') }}">
                            @else
                                <div class="event-icon-placeholder rounded me-2 d-flex align-items-center justify-content-center"
                                    style="background-color: {{ $event->tipus ? $event->tipus->color : '#3f51b5' }};">
                                    <i class="fas fa-calendar-alt text-white"></i>
                                </div>
                            @endif
                            <span>{{ $event->nom }}</span>
                        </div>
                    </td>
                    <td>{{ $event->data_inici->format('d/m/Y H:i') }}</td>
                    <td>
                        <span class="badge event-type-badge"
                            style="background-color: {{ $event->tipus ? $event->tipus->color : '#3f51b5' }};">
                            {{ $event->tipus ? $event->tipus->nom : __('messages.admin.events.no_type') }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-info">
                            {{ $event->participants()->count() }} / {{ $event->capacitat ?: '∞' }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="event" data-detail-id="{{ $event->id }}" 
                                title="{{ __('messages.admin.common.view_details') }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary editEventBtn" data-event-id="{{ $event->id }}"
                                title="{{ __('messages.admin.common.edit') }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm deleteBtn" 
                                data-item-id="{{ $event->id }}" 
                                data-item-name="{{ $event->nom }}"
                                data-item-type="event"
                                title="{{ __('messages.admin.common.delete') }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>