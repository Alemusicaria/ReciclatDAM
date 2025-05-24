<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">{{ __('messages.admin.premis.list_title') }}</h5>
    <button id="newPremiBtn" class="btn btn-success btn-sm admin-action-btn" data-bs-toggle="modal" data-bs-target="#detailModal"
        data-detail-type="create-premi" data-detail-title="{{ __('messages.admin.premis.new_prize') }}">
        <i class="fas fa-plus-circle me-1"></i> {{ __('messages.admin.premis.new_prize') }}
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped admin-table" id="dynamicTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('messages.admin.premis.name') }}</th>
                <th>{{ __('messages.admin.premis.points_required') }}</th>
                <th>{{ __('messages.admin.premis.claimed') }}</th>
                <th>{{ __('messages.admin.common.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($premis as $premi)
                <tr>
                    <td>{{ $premi->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($premi->imatge)
                                <img src="{{ asset($premi->imatge) }}" class="prize-image rounded me-2" alt="{{ __('messages.admin.premis.prize_image') }}">
                            @else
                                <div class="prize-icon-placeholder rounded me-2 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-gift text-white"></i>
                                </div>
                            @endif
                            <span>{{ $premi->nom }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-primary">
                            {{ $premi->punts_requerits }} {{ __('messages.admin.common.points_abbreviation') }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-info">
                            {{ $premi->premiReclamats()->count() }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="premi" data-detail-id="{{ $premi->id }}" title="{{ __('messages.admin.common.view_details') }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary editPremiBtn" data-premi-id="{{ $premi->id }}"
                                title="{{ __('messages.admin.common.edit') }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm deleteBtn" 
                                data-item-id="{{ $premi->id }}" 
                                data-item-name="{{ $premi->nom }}"
                                data-item-type="premi"
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