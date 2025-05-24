<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">{{ __('messages.admin.users_ranking.title') }}</h5>
</div>

<div class="table-responsive">
    <table class="table table-striped admin-table" id="usersRankingTable">
        <thead>
            <tr>
                <th>{{ __('messages.admin.users_ranking.position') }}</th>
                <th>{{ __('messages.admin.users_ranking.user') }}</th>
                <th>{{ __('messages.admin.users_ranking.level') }}</th>
                <th>{{ __('messages.admin.users_ranking.total_points') }}</th>
                <th>{{ __('messages.admin.users_ranking.current_points') }}</th>
                <th>{{ __('messages.admin.common.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $key => $user)
                <tr>
                    <td>
                        <div class="ranking-position {{ $key < 3 ? 'top-' . ($key + 1) : '' }}">{{ $key + 1 }}</div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ $user->foto_perfil ?
                                (Str::startsWith($user->foto_perfil, ['http://', 'https://']) ?
                                    $user->foto_perfil :
                                    (file_exists(public_path('storage/' . $user->foto_perfil)) ?
                                        asset('storage/' . $user->foto_perfil) :
                                        asset('images/default-profile.png')
                                    )
                                ) :
                                asset('images/default-profile.png') 
                            }}" class="user-avatar rounded-circle me-2" alt="{{ __('messages.admin.profile_photo') }}">
                            <div>
                                <span class="d-block fw-medium">{{ $user->nom }} {{ $user->cognoms }}</span>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <?php $nivellInfo = $user->nivell(); ?>
                        <span class="badge bg-info">{{ $nivellInfo ? $nivellInfo->nom : __('messages.admin.users_ranking.default_level') }}</span>
                    </td>
                    <td>
                        <span class="badge bg-success">{{ $user->punts_totals }} {{ __('messages.admin.common.points_abbreviation') }}</span>
                    </td>
                    <td>
                        <span class="badge bg-primary">{{ $user->punts_actuals }} {{ __('messages.admin.common.points_abbreviation') }}</span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="user" data-detail-id="{{ $user->id }}" title="{{ __('messages.admin.common.view_details') }}">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>