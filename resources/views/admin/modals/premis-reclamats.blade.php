<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">{{ __('messages.admin.claimed_prizes.list_title') }}</h5>
    <div>
        <div class="btn-group me-2 filter-buttons">
            <button class="btn btn-sm btn-outline-primary" id="filterAllBtn">{{ __('messages.admin.claimed_prizes.filter_all') }}</button>
            <button class="btn btn-sm btn-outline-warning" id="filterPendingBtn">{{ __('messages.admin.claimed_prizes.filter_pending') }}</button>
            <button class="btn btn-sm btn-outline-info" id="filterProcessingBtn">{{ __('messages.admin.claimed_prizes.filter_processing') }}</button>
            <button class="btn btn-sm btn-outline-success" id="filterDeliveredBtn">{{ __('messages.admin.claimed_prizes.filter_delivered') }}</button>
            <button class="btn btn-sm btn-outline-danger" id="filterCanceledBtn">{{ __('messages.admin.claimed_prizes.filter_canceled') }}</button>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped admin-table" id="premisReclamatsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('messages.admin.claimed_prizes.user') }}</th>
                <th>{{ __('messages.admin.claimed_prizes.prize') }}</th>
                <th>{{ __('messages.admin.claimed_prizes.points') }}</th>
                <th>{{ __('messages.admin.claimed_prizes.status') }}</th>
                <th>{{ __('messages.admin.claimed_prizes.date') }}</th>
                <th>{{ __('messages.admin.common.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($premisReclamats as $premiReclamat)
                <tr data-status="{{ $premiReclamat->estat }}">
                    <td>{{ $premiReclamat->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($premiReclamat->user && $premiReclamat->user->foto_perfil)
                                <img src="{{ Str::startsWith($premiReclamat->user->foto_perfil, ['http://', 'https://']) ?
                                    $premiReclamat->user->foto_perfil :
                                    asset('storage/' . $premiReclamat->user->foto_perfil) }}" class="user-avatar rounded-circle me-2"
                                    alt="{{ __('messages.admin.profile_photo') }}">
                            @else
                                <div class="user-icon-placeholder rounded-circle me-2 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-user text-white small"></i>
                                </div>
                            @endif
                            {{ $premiReclamat->user ? $premiReclamat->user->nom . ' ' . $premiReclamat->user->cognoms : __('messages.admin.claimed_prizes.unknown_user') }}
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($premiReclamat->premi && $premiReclamat->premi->imatge)
                                <img src="{{ asset($premiReclamat->premi->imatge) }}" class="prize-image rounded me-2"
                                    alt="{{ __('messages.admin.claimed_prizes.prize_image') }}">
                            @else
                                <div class="prize-icon-placeholder rounded me-2 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-gift text-white small"></i>
                                </div>
                            @endif
                            {{ $premiReclamat->premi ? $premiReclamat->premi->nom : __('messages.admin.claimed_prizes.unknown_prize') }}
                        </div>
                    </td>
                    <td><span class="badge bg-primary">{{ $premiReclamat->punts_gastats }} {{ __('messages.admin.common.points_abbreviation') }}</span></td>
                    <td>
                        @if($premiReclamat->estat == 'pendent')
                            <span class="badge bg-warning text-dark">{{ __('messages.admin.claimed_prizes.pending') }}</span>
                        @elseif($premiReclamat->estat == 'procesant')
                            <span class="badge bg-info">{{ __('messages.admin.claimed_prizes.processing') }}</span>
                        @elseif($premiReclamat->estat == 'entregat')
                            <span class="badge bg-success">{{ __('messages.admin.claimed_prizes.delivered') }}</span>
                        @elseif($premiReclamat->estat == 'cancelat')
                            <span class="badge bg-danger">{{ __('messages.admin.claimed_prizes.canceled') }}</span>
                        @endif
                    </td>
                    <td>{{ $premiReclamat->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="premi-reclamat" data-detail-id="{{ $premiReclamat->id }}"
                                title="{{ __('messages.admin.common.view_details') }}">
                                <i class="fas fa-eye"></i>
                            </button>

                            @if($premiReclamat->estat == 'pendent')
                                <button class="btn btn-sm btn-success approveClaimBtn" 
                                       data-id="{{ $premiReclamat->id }}"
                                       title="{{ __('messages.admin.claimed_prizes.approve_request') }}">
                                    <i class="fas fa-check"></i>
                                </button>

                                <button class="btn btn-sm btn-danger rejectClaimBtn"
                                       data-id="{{ $premiReclamat->id }}"
                                       title="{{ __('messages.admin.claimed_prizes.reject_request') }}">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif

                            @if($premiReclamat->estat != 'entregat')
                                <button class="btn btn-sm btn-primary editPremiReclamatBtn" data-id="{{ $premiReclamat->id }}"
                                    title="{{ __('messages.admin.claimed_prizes.update_status') }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>