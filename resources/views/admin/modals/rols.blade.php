<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">{{ __('messages.admin.roles.list_title') }}</h5>
    <button id="newRolBtn" class="btn btn-success btn-sm admin-action-btn" data-bs-toggle="modal" data-bs-target="#detailModal"
        data-detail-type="create-rol" data-detail-title="{{ __('messages.admin.roles.new_role') }}">
        <i class="fas fa-plus-circle me-1"></i> {{ __('messages.admin.roles.new_role') }}
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped admin-table" id="dynamicTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('messages.admin.roles.name') }}</th>
                <th>{{ __('messages.admin.roles.users') }}</th>
                <th>{{ __('messages.admin.common.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rols as $rol)
                <tr>
                    <td>{{ $rol->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="rol-icon-container me-2">
                                <span class="rol-badge rol-badge-{{ $rol->id }}">
                                    <i class="fas fa-user-tag"></i>
                                </span>
                            </div>
                            <span>{{ $rol->nom }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-info">
                            {{ $rol->users_count ?? $rol->users()->count() }} {{ __('messages.admin.roles.users_count') }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="rol" data-detail-id="{{ $rol->id }}" title="{{ __('messages.admin.common.view_details') }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary editRolBtn" data-rol-id="{{ $rol->id }}"
                                title="{{ __('messages.admin.common.edit') }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm deleteBtn" 
                                data-item-id="{{ $rol->id }}" 
                                data-item-name="{{ $rol->nom }}"
                                data-item-type="rol"
                                @if($rol->users()->count() > 0) disabled @endif
                                title="@if($rol->users()->count() > 0) {{ __('messages.admin.roles.cannot_delete') }} @else {{ __('messages.admin.common.delete') }} @endif">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>