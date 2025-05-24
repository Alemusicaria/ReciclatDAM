<div class="detail-container activitat-detail-container">
    <div class="detail-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="d-flex align-items-start">
                    <div class="detail-icon-container me-4">
                        <div class="detail-icon activitat-icon d-flex align-items-center justify-content-center rounded">
                            <i class="fas fa-history fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="mb-1">{{ __('messages.admin.activities.detail_title', ['id' => $activitat->id]) }}</h4>
                        <div class="detail-date">
                            <i class="fas fa-calendar-day text-muted me-2"></i>
                            <span class="text-muted">{{ __('messages.admin.activities.registered_on') }} {{ $activitat->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="info-card mb-4">
                <h4 class="card-title mb-3">
                    <i class="fas fa-info-circle text-primary me-2"></i>{{ __('messages.admin.activities.details') }}
                </h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="fw-bold">{{ __('messages.admin.activities.action') }}:</label>
                            <p>{{ $activitat->action }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="fw-bold">{{ __('messages.admin.activities.date_time') }}:</label>
                            <p>{{ $activitat->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($activitat->user)
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="info-card">
                <h4 class="card-title mb-3">
                    <i class="fas fa-user text-success me-2"></i>{{ __('messages.admin.activities.user') }}
                </h4>
                <div class="row align-items-center">
                    <div class="col-md-2">
                        <img src="{{ $activitat->user->foto_perfil ? 
                            (Str::startsWith($activitat->user->foto_perfil, ['http://', 'https://']) ?
                                $activitat->user->foto_perfil :
                                (file_exists(public_path('storage/' . $activitat->user->foto_perfil)) ?
                                    asset('storage/' . $activitat->user->foto_perfil) :
                                    asset('images/default-profile.png')
                                )
                            ) :
                            asset('images/default-profile.png') 
                        }}" alt="{{ __('messages.admin.profile_photo') }}" class="img-fluid rounded-circle user-profile-image">
                    </div>
                    <div class="col-md-10">
                        <table class="table table-borderless">
                            <tr>
                                <th>{{ __('messages.admin.users.name') }}:</th>
                                <td>{{ $activitat->user->nom }} {{ $activitat->user->cognoms }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('messages.admin.users.email') }}:</th>
                                <td>{{ $activitat->user->email }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('messages.admin.users.role') }}:</th>
                                <td>{{ $activitat->user->rol->nom ?? __('messages.admin.users.not_assigned') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>