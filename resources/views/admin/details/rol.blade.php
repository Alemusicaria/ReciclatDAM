<div class="detail-container rol-detail-container">
    <div class="detail-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <div class="detail-icon-container me-3">
                        <div class="detail-icon rol-icon-{{ $rol->id }} d-flex align-items-center justify-content-center rounded-circle">
                            <i class="fas fa-user-tag fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="detail-name mb-1">{{ $rol->nom }}</h2>
                        <div class="mt-2">
                            <span class="badge bg-info">
                                <i class="fas fa-users me-1"></i> {{ __('messages.admin.roles.users_with_role', ['count' => $rol->users()->count()]) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="info-card">
                <h4 class="card-title mb-3">
                    <i class="fas fa-users text-success me-2"></i>{{ __('messages.admin.roles.users_list') }}
                </h4>
                
                @if($rol->users()->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.admin.roles.user') }}</th>
                                    <th>{{ __('messages.admin.roles.email') }}</th>
                                    <th>{{ __('messages.admin.roles.registration_date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rol->users()->take(10)->get() as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($user->foto_perfil)
                                                    <img src="{{ asset('storage/' . $user->foto_perfil) }}" class="user-avatar rounded-circle me-2" alt="{{ __('messages.admin.profile_photo') }}">
                                                @else
                                                    <div class="user-icon-placeholder rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                @endif
                                                {{ $user->nom }} {{ $user->cognoms }}
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        @if($rol->users()->count() > 10)
                            <div class="text-center mt-3">
                                <span class="text-muted">{{ __('messages.admin.roles.showing_users', ['showing' => 10, 'total' => $rol->users()->count()]) }}</span>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="empty-state text-center py-4">
                        <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                        <p class="lead">{{ __('messages.admin.roles.no_users') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>