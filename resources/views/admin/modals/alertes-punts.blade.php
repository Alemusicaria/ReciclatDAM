<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">{{ __('messages.admin.alerts.list_title') }}</h5>
    <button id="newAlertaBtn" class="btn btn-success btn-sm admin-action-btn" data-bs-toggle="modal" data-bs-target="#detailModal"
        data-detail-type="create-alerta-punt" data-detail-title="{{ __('messages.admin.alerts.new_alert') }}">
        <i class="fas fa-plus-circle me-1"></i> {{ __('messages.admin.alerts.new_alert') }}
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped admin-table" id="alertasTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('messages.admin.alerts.collection_point') }}</th>
                <th>{{ __('messages.admin.alerts.type') }}</th>
                <th>{{ __('messages.admin.alerts.creation_date') }}</th>
                <th>{{ __('messages.admin.common.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alertes as $alerta)
                <tr>
                    <td>{{ $alerta->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="punto-icon punto-{{ strtolower(str_replace(' ', '-', $alerta->puntDeRecollida ? $alerta->puntDeRecollida->fraccio : 'unknown')) }} rounded-circle me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-recycle text-white"></i>
                            </div>
                            <span>{{ $alerta->puntDeRecollida ? $alerta->puntDeRecollida->nom : __('messages.admin.alerts.unknown') }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-warning">{{ $alerta->tipus ? $alerta->tipus->nom : __('messages.admin.alerts.unknown_type') }}</span>
                    </td>
                    <td>{{ $alerta->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="alerta-punt" data-detail-id="{{ $alerta->id }}" title="{{ __('messages.admin.common.view_details') }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary editAlertaBtn" data-alerta-id="{{ $alerta->id }}"
                                title="{{ __('messages.admin.common.edit') }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm deleteBtn" 
                                data-item-id="{{ $alerta->id }}" 
                                data-item-name="{{ __('messages.admin.alerts.alert') }} #{{ $alerta->id }}"
                                data-item-type="alerta-punt"
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