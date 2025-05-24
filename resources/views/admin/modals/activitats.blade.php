<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">{{ __('messages.admin.activities.list_title') }}</h5>
</div>

<div class="table-responsive">
    <table class="table table-striped admin-table" id="activitatsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('messages.admin.activities.user') }}</th>
                <th>{{ __('messages.admin.activities.action') }}</th>
                <th>{{ __('messages.admin.activities.date') }}</th>
                <th>{{ __('messages.admin.common.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activitats as $activitat)
                <tr>
                    <td>{{ $activitat->id }}</td>
                    <td>
                        @if($activitat->user)
                            <div class="d-flex align-items-center">
                                @if($activitat->user->foto_perfil)
                                    <img src="{{ ($activitat->user && $activitat->user->foto_perfil) ?
                                        (Str::startsWith($activitat->user->foto_perfil, ['http://', 'https://']) ?
                                            $activitat->user->foto_perfil :
                                            (file_exists(public_path('storage/' . $activitat->user->foto_perfil)) ?
                                                asset('storage/' . $activitat->user->foto_perfil) :
                                                asset('images/default-profile.png')
                                            )
                                        ) :
                                        asset('images/default-profile.png') 
                                    }}" class="user-avatar rounded-circle me-2" alt="{{ __('messages.admin.profile_photo') }}">
                                @else
                                    <div class="user-icon-placeholder rounded-circle me-2 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-user text-white small"></i>
                                    </div>
                                @endif
                                {{ $activitat->user->nom }} {{ $activitat->user->cognoms }}
                            </div>
                        @else
                            <span class="text-muted">{{ __('messages.admin.activities.unknown_user') }}</span>
                        @endif
                    </td>
                    <td>{{ $activitat->action }}</td>
                    <td>{{ $activitat->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info view-activity-details" 
                                data-detail-type="activitat" data-detail-id="{{ $activitat->id }}" 
                                title="{{ __('messages.admin.common.view_details') }}">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>