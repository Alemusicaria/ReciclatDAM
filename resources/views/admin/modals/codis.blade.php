<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">{{ __('messages.admin.codes.list_title') }}</h5>
    <button id="newCodiBtn" class="btn btn-success btn-sm admin-action-btn" data-bs-toggle="modal" data-bs-target="#detailModal"
        data-detail-type="create-codi" data-detail-title="{{ __('messages.admin.codes.new_code') }}">
        <i class="fas fa-plus-circle me-1"></i> {{ __('messages.admin.codes.new_code') }}
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped admin-table" id="codisTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('messages.admin.codes.code') }}</th>
                <th>{{ __('messages.admin.codes.user') }}</th>
                <th>{{ __('messages.admin.codes.points') }}</th>
                <th>{{ __('messages.admin.codes.scan_date') }}</th>
                <th>{{ __('messages.admin.common.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($codis as $codi)
                <tr>
                    <td>{{ $codi->id }}</td>
                    <td><code>{{ $codi->codi }}</code></td>
                    <td>
                        @if($codi->user)
                            <div class="d-flex align-items-center">
                                @if($codi->user->foto_perfil)
                                    <img src="{{ asset('storage/' . $codi->user->foto_perfil) }}" class="user-avatar rounded-circle me-2" alt="{{ __('messages.admin.profile_photo') }}">
                                @else
                                    <div class="user-icon-placeholder rounded-circle me-2 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-user text-white small"></i>
                                    </div>
                                @endif
                                {{ $codi->user->nom }} {{ $codi->user->cognoms }}
                            </div>
                        @else
                            <span class="text-muted">{{ __('messages.admin.codes.not_assigned') }}</span>
                        @endif
                    </td>
                    <td><span class="badge bg-success">{{ $codi->punts }} {{ __('messages.admin.common.points_abbreviation') }}</span></td>
                    <td>{{ $codi->data_escaneig->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="codi" data-detail-id="{{ $codi->id }}" title="{{ __('messages.admin.common.view_details') }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary editCodiBtn" data-codi-id="{{ $codi->id }}"
                                title="{{ __('messages.admin.common.edit') }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm deleteBtn" 
                                data-item-id="{{ $codi->id }}" 
                                data-item-name="{{ __('messages.admin.codes.code') }} #{{ $codi->id }}"
                                data-item-type="codi"
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