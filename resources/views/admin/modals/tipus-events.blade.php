<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">{{ __('messages.admin.tipus_events.list_title') }}</h5>
    <button id="newTipusEventBtn" class="btn btn-success btn-sm admin-action-btn" data-bs-toggle="modal" data-bs-target="#detailModal"
        data-detail-type="create-tipus-event" data-detail-title="{{ __('messages.admin.tipus_events.new_type') }}">
        <i class="fas fa-plus-circle me-1"></i> {{ __('messages.admin.tipus_events.new_type_short') }}
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped admin-table" id="dynamicTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('messages.admin.tipus_events.name') }}</th>
                <th>{{ __('messages.admin.tipus_events.color') }}</th>
                <th>{{ __('messages.admin.tipus_events.events') }}</th>
                <th>{{ __('messages.admin.common.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tipusEvents as $tipus)
                <tr>
                    <td>{{ $tipus->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="tipus-event-icon rounded-circle me-2 d-flex align-items-center justify-content-center"
                                style="background-color: {{ $tipus->color }}">
                                <i class="fas fa-calendar-day text-white"></i>
                            </div>
                            <span>{{ $tipus->nom }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge" style="background-color: {{ $tipus->color }}">
                            {{ $tipus->color }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-info">
                            {{ $tipus->events_count ?? $tipus->events()->count() }} {{ __('messages.admin.tipus_events.events_count') }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="tipus-event" data-detail-id="{{ $tipus->id }}" title="{{ __('messages.admin.common.view_details') }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary editTipusEventBtn" data-tipus-event-id="{{ $tipus->id }}"
                                title="{{ __('messages.admin.common.edit') }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm deleteBtn" 
                                data-item-id="{{ $tipus->id }}" 
                                data-item-name="{{ $tipus->nom }}"
                                data-item-type="tipus-event"
                                @if($tipus->events()->count() > 0) disabled @endif
                                title="@if($tipus->events()->count() > 0) {{ __('messages.admin.tipus_events.cannot_delete') }} @else {{ __('messages.admin.common.delete') }} @endif">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>