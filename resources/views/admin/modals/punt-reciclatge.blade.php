<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">{{ __('messages.admin.punts.list_title') }}</h5>
    <button id="newPuntBtn" class="btn btn-success btn-sm admin-action-btn" data-bs-toggle="modal" data-bs-target="#detailModal"
        data-detail-type="create-punt-reciclatge" data-detail-title="{{ __('messages.admin.punts.new_point') }}">
        <i class="fas fa-plus-circle me-1"></i> {{ __('messages.admin.punts.new_point_short') }}
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped admin-table" id="dynamicTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('messages.admin.punts.name') }}</th>
                <th>{{ __('messages.admin.punts.fraction') }}</th>
                <th>{{ __('messages.admin.punts.location') }}</th>
                <th>{{ __('messages.admin.common.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($punts as $punt)
                <tr>
                    <td>{{ $punt->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="punto-icon punto-{{ strtolower(str_replace(' ', '-', $punt->fraccio)) }} rounded-circle me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-recycle text-white"></i>
                            </div>
                            <span>{{ $punt->nom }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge fraccio-badge punto-{{ strtolower(str_replace(' ', '-', $punt->fraccio)) }}">
                            {{ $punt->fraccio }}
                        </span>
                    </td>
                    <td>{{ $punt->ciutat }}, {{ $punt->adreca }}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="punt-reciclatge" data-detail-id="{{ $punt->id }}" title="{{ __('messages.admin.common.view_details') }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary editPuntBtn" data-punt-id="{{ $punt->id }}"
                                title="{{ __('messages.admin.common.edit') }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm deleteBtn" 
                                data-item-id="{{ $punt->id }}" 
                                data-item-name="{{ $punt->nom }}"
                                data-item-type="punt-reciclatge"
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