<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">{{ __('messages.admin.tipus_alertes.list_title') }}</h5>
    <button id="newTipusAlertaBtn" class="btn btn-success btn-sm admin-action-btn" data-bs-toggle="modal" data-bs-target="#detailModal"
        data-detail-type="create-tipus-alerta" data-detail-title="{{ __('messages.admin.tipus_alertes.new_type') }}">
        <i class="fas fa-plus-circle me-1"></i> {{ __('messages.admin.tipus_alertes.new_type_short') }}
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped admin-table" id="dynamicTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('messages.admin.tipus_alertes.name') }}</th>
                <th>{{ __('messages.admin.tipus_alertes.creation_date') }}</th>
                <th>{{ __('messages.admin.tipus_alertes.active_alerts') }}</th>
                <th>{{ __('messages.admin.common.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tipusAlertes as $tipusAlerta)
                <tr>
                    <td>{{ $tipusAlerta->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="tipus-alerta-icon rounded-circle me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-bell text-white"></i>
                            </div>
                            <span>{{ $tipusAlerta->nom }}</span>
                        </div>
                    </td>
                    <td>{{ $tipusAlerta->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <span class="badge bg-info">
                            {{ $tipusAlerta->alertes()->count() }} {{ __('messages.admin.tipus_alertes.alerts_count') }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="tipus-alerta" data-detail-id="{{ $tipusAlerta->id }}" title="{{ __('messages.admin.common.view_details') }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary editTipusAlertaBtn" data-tipus-alerta-id="{{ $tipusAlerta->id }}"
                                title="{{ __('messages.admin.common.edit') }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm deleteBtn" 
                                data-item-id="{{ $tipusAlerta->id }}" 
                                data-item-name="{{ $tipusAlerta->nom }}"
                                data-item-type="tipus-alerta"
                                @if($tipusAlerta->alertes()->count() > 0) disabled @endif
                                title="@if($tipusAlerta->alertes()->count() > 0) {{ __('messages.admin.tipus_alertes.cannot_delete') }} @else {{ __('messages.admin.common.delete') }} @endif">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>