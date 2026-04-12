@extends('layouts.app')

@section('content')
    <?php
        $locale = app()->getLocale();
        $summaryLevel = $user->nivell();
        $summaryUpdatedAt = \App\Support\LocalizedDate::format($user->updated_at, $locale, 'd M Y H:i', '-');
    ?>
    <div class="container profile-container page-offset-profile">
        <div class="row">
            <div class="col-lg-4">
                <!-- Tarjeta de perfil principal -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body text-center">
                        <div class="position-relative mb-4">
                            <!-- Imagen de perfil -->
                            <img src="{{ $user->profilePhotoUrl() }}" alt="{{ __('messages.profile_page.profile_photo_alt') }}"
                                class="rounded-circle img-thumbnail shadow js-user-avatar profile-avatar-lg" id="profile-image-main"
                                onerror="this.onerror=null;this.src='{{ asset('images/default-profile.png') }}';">

                            <!-- Icono para editar foto -->
                            <div class="position-relative bottom-0 start-0">
                                <label for="photo-upload" class="btn btn-sm btn-success rounded-circle change-photo-btn profile-edit-button"
                                    title="{{ __('messages.profile_page.change_photo') }}">
                                    <i class="fas fa-camera"></i>
                                </label>
                                <input type="file" id="photo-upload" name="foto_perfil" accept="image/*"
                                    style="display: none;">
                            </div>
                        </div>

                        <h3 class="mb-1">{{ $user->nom }} {{ $user->cognoms }}</h3>
                        <p class="text-muted mb-3">{{ $user->email }}</p>

                        <!-- Contador de puntos destacado -->
                        <div class="d-flex justify-content-center mb-3">
                            <div class="points-badge bg-opacity-10 text-success">
                                <i class="fas fa-coins" style="margin-right: 5px;"></i>
                                <span class="fw-bold" style="margin-right: 5px;">{{ $user->punts_actuals }}</span> {{ __('messages.profile_page.ecodams_unit') }}
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <a href="{{ route('users.edit', $user->id) }}" class="btn-modern btn-edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn-modern btn-delete" data-bs-toggle="modal"
                                data-bs-target="#deleteModal">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>

                               <!-- Sistema de niveles -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-trophy me-2 text-primary" style="margin-right: 5px;"></i>{{ __('messages.profile_page.current_level') }}
                        </h5>
                        
                        <?php
                            $currentLevel = $user->nivell();
                            $nextLevel = null;
                            $pointsToNextLevel = 0;
                            $progress = 0;

                            if ($currentLevel) {
                                $nextLevel = App\Models\Nivell::where('punts_requerits', '>', $currentLevel->punts_requerits)
                                    ->orderBy('punts_requerits', 'asc')
                                    ->first();

                                if ($nextLevel) {
                                    $pointsToNextLevel = $nextLevel->punts_requerits - $user->punts_totals;
                                    $progress = ($user->punts_totals - $currentLevel->punts_requerits) /
                                            ($nextLevel->punts_requerits - $currentLevel->punts_requerits) * 100;
                                    $progress = max(0, min(100, $progress));
                                }
                            }
                        ?>

                        @if($currentLevel)
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3 p-3 rounded-circle level-badge" style="background-color: {{ $currentLevel->color }};">
                                    <i class="{{ $currentLevel->icona }} fa-2x text-white"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">{{ $currentLevel->displayName() }}</h5>
                                    <p class="mb-0 text-muted">{{ $currentLevel->displayDescription() }}</p>
                                </div>
                            </div>
                        @endif

                        @if($currentLevel && $nextLevel)
                            <div class="mt-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>{{ __('messages.profile_page.level_progress', ['current' => $currentLevel->id, 'current_name' => $currentLevel->displayName()]) }}</span>
                                    <span>{{ __('messages.profile_page.next_level', ['next' => $nextLevel->id, 'next_name' => $nextLevel->displayName()]) }}</span>
                                </div>
                                <div class="progress progress-bar-height">
                                    <div class="progress-bar" role="progressbar" 
                                        style="width: {{ $progress }}%; background-color: {{ $currentLevel->color }};" 
                                        aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="text-center mt-2">
                                    <span class="badge bg-primary">
                                        {{ __('messages.profile_page.points_to_next_level', ['points' => $pointsToNextLevel]) }}
                                    </span>
                                </div>
                            </div>
                        @elseif($currentLevel)
                            <div class="alert alert-success mt-3">
                                <i class="fas fa-trophy me-2"></i>
                                {{ __('messages.profile_page.max_level_reached') }}
                            </div>
                        @else
                            <div class="alert alert-secondary mt-3">
                                {{ __('messages.profile_page.not_specified') }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tarjeta de estadísticas visuales -->
                <div class="card mb-4 stats-card stats-card-responsive">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="fas fa-chart-pie me-2" style="margin-right: 5px;"></i>{{ __('messages.profile_page.points_distribution') }}
                        </h5>
                        <div id="pointsDistributionChart" class="chart-container"></div>
                    </div>
                </div>

                <!-- Historial de premios reclamados -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-gift me-2 text-success" style="margin-right: 5px;"></i>{{ __('messages.profile_page.claimed_prizes') }}
                        </h5>

                        @if($user->premisReclamats->count() > 0)
                            <div class="table-responsive stats-card-responsive-table">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.profile_page.prize') }}</th>
                                            <th>{{ __('messages.profile_page.points') }}</th>
                                            <th>{{ __('messages.profile_page.date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->premisReclamats->sortByDesc('data_reclamacio') as $premi)
                                            @php
                                                $claimDateShort = \App\Support\LocalizedDate::format($premi->data_reclamacio, $locale, 'd/m/Y');
                                                $claimDateFull = \App\Support\LocalizedDate::format($premi->data_reclamacio, $locale, 'd/m/Y H:i');
                                                $statusLabel = match($premi->estat) {
                                                    'pendent' => __('messages.profile_page.status_pendent'),
                                                    'procesant' => __('messages.profile_page.status_procesant'),
                                                    'entregat' => __('messages.profile_page.status_entregat'),
                                                    'cancelat' => __('messages.profile_page.status_cancelat'),
                                                    default => $premi->estat,
                                                };
                                                $statusClass = match($premi->estat) {
                                                    'pendent' => 'bg-warning text-dark',
                                                    'procesant' => 'bg-info',
                                                    'entregat' => 'bg-success',
                                                    'cancelat' => 'bg-danger',
                                                    default => 'bg-secondary',
                                                };
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($premi->premi->imatge)
                                                            <img src="{{ asset($premi->premi->imatge) }}"
                                                                alt="{{ $premi->premi->displayName() }}"
                                                                class="me-2" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; margin-right: 10px;">
                                                        @else
                                                            <div class="me-2 bg-light d-flex align-items-center justify-content-center"
                                                                style="width: 40px; height: 40px; border-radius: 4px; margin-right: 10px;">
                                                                <i class="fas fa-gift text-secondary"></i>
                                                            </div>
                                                        @endif
                                                        <div class="text-truncate" style="max-width: 150px;">
                                                            <div class="fw-bold text-truncate">{{ $premi->premi->displayName() }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-coins me-1"></i> {{ $premi->punts_gastats }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center justify-content-between gap-2">
                                                        <span>{{ $claimDateShort }}</span>
                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-outline-secondary"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#claim-details-{{ $premi->id }}"
                                                            aria-expanded="false"
                                                            aria-controls="claim-details-{{ $premi->id }}"
                                                            aria-label="{{ __('messages.profile_page.claim_details') }}"
                                                        >
                                                            <i class="fas fa-chevron-down" aria-hidden="true"></i>
                                                            <span class="ms-1">{{ __('messages.profile_page.claim_details') }}</span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="collapse" id="claim-details-{{ $premi->id }}">
                                                <td colspan="3" class="bg-light-subtle">
                                                    <div class="p-3">
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <div class="small text-muted">{{ __('messages.profile_page.claim_date') }}</div>
                                                                <div class="fw-semibold">{{ $claimDateFull }}</div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="small text-muted">{{ __('messages.profile_page.status') }}</div>
                                                                <div><span class="badge {{ $statusClass }}">{{ $statusLabel }}</span></div>
                                                            </div>
                                                            @if(!empty($premi->codi_seguiment))
                                                                <div class="col-md-6">
                                                                    <div class="small text-muted">{{ __('messages.profile_page.tracking_code') }}</div>
                                                                    <div><code>{{ $premi->codi_seguiment }}</code></div>
                                                                </div>
                                                            @endif
                                                            @if(!empty($premi->comentaris))
                                                                <div class="col-md-12">
                                                                    <div class="small text-muted">{{ __('messages.profile_page.comments') }}</div>
                                                                    <div>{{ $premi->comentaris }}</div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-gift fa-3x text-muted mb-3"></i>
                                <p class="text-muted">{{ __('messages.profile_page.no_claimed_prizes') }}</p>
                                <a href="{{ route('premis.index') }}" class="btn btn-sm btn-success">{{ __('messages.profile_page.explore_available_prizes') }}</a>
                            </div>
                        @endif

                    </div>
                </div>                
            </div>

            <div class="col-lg-8">
                <!-- Contadores de estadísticas -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="stats-counter text-center">
                            <div class="mb-2">
                                <i class="fas fa-trophy fa-2x text-warning"></i>
                            </div>
                            <h3>{{ $user->punts_totals ?? 0 }}</h3>
                            <p class="text-muted mb-0">{{ __('messages.profile_page.total_points') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="stats-counter text-center">
                            <div class="mb-2">
                                <i class="fas fa-wallet fa-2x text-success"></i>
                            </div>
                            <h3>{{ $user->punts_actuals ?? 0 }}</h3>
                            <p class="text-muted mb-0">{{ __('messages.profile_page.current_points') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="stats-counter text-center">
                            <div class="mb-2">
                                <i class="fas fa-shopping-cart fa-2x text-danger"></i>
                            </div>
                            <h3>{{ $user->punts_gastats ?? 0 }}</h3>
                            <p class="text-muted mb-0">{{ __('messages.profile_page.spent_points') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de actividad -->
                <div class="card mb-4 stats-card stats-card-responsive">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-chart-line me-2" style="margin-right: 5px;"></i>{{ __('messages.profile_page.recent_activity') }}
                        </h5>
                        <div id="activityChart" class="chart-container"></div>
                    </div>
                </div>

                <!-- Tarjeta de información personal -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-user me-2" style="margin-right: 5px;"></i>{{ __('messages.profile_page.personal_information') }}
                        </h5>
                        <hr>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <p class="mb-0 text-muted">{{ __('messages.profile_page.full_name') }}</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-0">{{ $user->nom }} {{ $user->cognoms }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <p class="mb-0 text-muted">{{ __('messages.profile_page.email') }}</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-0">{{ $user->email }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <p class="mb-0 text-muted">{{ __('messages.profile_page.phone') }}</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-0">{{ $user->telefon ?? __('messages.profile_page.not_specified') }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <p class="mb-0 text-muted">{{ __('messages.profile_page.birth_date') }}</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-0">{{ \App\Support\LocalizedDate::format($user->data_naixement, $locale, 'd F Y', __('messages.profile_page.not_specified')) }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0 text-muted">{{ __('messages.profile_page.location') }}</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-0">{{ $user->ubicacio ?? __('messages.profile_page.not_specified') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                                <!-- Historial de eventos -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-calendar-check me-2 text-success" style="margin-right: 5px;"></i>{{ __('messages.profile_page.my_events') }}
                        </h5>
                        
                        <ul class="nav nav-tabs mb-3" id="eventsTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming" 
                                        type="button" role="tab" aria-controls="upcoming" aria-selected="true">{{ __('messages.profile_page.upcoming') }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="past-tab" data-bs-toggle="tab" data-bs-target="#past" 
                                        type="button" role="tab" aria-controls="past" aria-selected="false">{{ __('messages.profile_page.past') }}</button>
                            </li>
                        </ul>
                        
                        <div class="tab-content" id="eventsTabsContent">
                            <!-- Próximos eventos -->
                            <div class="tab-pane fade show active" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
                                @if($user->events->where('data_inici', '>=', now())->count() > 0)
                                    <div class="row">
                                        @foreach($user->events->where('data_inici', '>=', now())->sortBy('data_inici') as $event)
                                            <div class="col-md-6 mb-3">
                                                <div class="event-card p-3 h-100">
                                                    <div class="d-flex">
                                                        <div class="event-date text-center me-3" style="margin-right: 5px;">
                                                            <div class="month">{{ \App\Support\LocalizedDate::format($event->data_inici, $locale, 'M') }}</div>
                                                            <div class="day">{{ \App\Support\LocalizedDate::format($event->data_inici, $locale, 'd') }}</div>
                                                        </div>
                                                        <div class="event-details">
                                                            <h6 class="mb-1">{{ $event->displayName() }}</h6>
                                                            <p class="text-muted mb-1 small">
                                                                <i class="fas fa-map-marker-alt me-1"></i> {{ $event->lloc }}
                                                            </p>
                                                            <p class="text-muted mb-1 small">
                                                                <i class="fas fa-clock me-1"></i> {{ \App\Support\LocalizedDate::format($event->data_inici, $locale, 'H:i') }}
                                                            </p>
                                                            <div class="mt-2">
                                                                <span class="badge bg-primary">
                                                                    <i class="fas fa-calendar-day me-1"></i>
                                                                    {{ \App\Support\LocalizedDate::human($event->data_inici, $locale) }}
                                                                </span> 
                                                                <br>
                                                                @if($event->tipus)
                                                                    <span class="badge" style="background-color: {{ $event->tipus->color }}; margin-top: 5px;">
                                                                        {{ $event->displayTypeName() }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-calendar-day fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">{{ __('messages.profile_page.no_upcoming_events') }}</p>
                                        <a href="{{ route('events') }}" class="btn btn-sm btn-success">{{ __('messages.profile_page.explore_available_events') }}</a>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Eventos pasados -->
                            <div class="tab-pane fade" id="past" role="tabpanel" aria-labelledby="past-tab">
                                @if($user->events->where('data_inici', '<', now())->count() > 0)
                                    <div class="row">
                                        @foreach($user->events->where('data_inici', '<', now())->sortByDesc('data_inici') as $event)
                                            <div class="col-md-6 mb-3">
                                                <div class="event-card p-3 h-100">
                                                    <div class="d-flex">
                                                        <div class="event-date text-center me-3" style="margin-right: 5px;">
                                                            <div class="month">{{ \App\Support\LocalizedDate::format($event->data_inici, $locale, 'M') }}</div>
                                                            <div class="day">{{ \App\Support\LocalizedDate::format($event->data_inici, $locale, 'd') }}</div>
                                                        </div>
                                                        <div class="event-details">
                                                            <h6 class="mb-1">{{ $event->displayName() }}</h6>
                                                            <p class="text-muted mb-1 small">
                                                                <i class="fas fa-map-marker-alt me-1"></i> {{ $event->lloc }}
                                                            </p>
                                                            <p class="text-muted mb-1 small">
                                                                <i class="fas fa-calendar me-1"></i> {{ \App\Support\LocalizedDate::format($event->data_inici, $locale, 'd M Y') }} - {{ \App\Support\LocalizedDate::format($event->data_inici, $locale, 'H:i') }}
                                                            </p>
                                                            @if($event->pivot->punts > 0)
                                                                <div class="text-success mb-1 small">
                                                                    <i class="fas fa-coins me-1"></i> {{ __('messages.profile_page.points_earned', ['points' => $event->pivot->punts]) }}
                                                                </div>
                                                            @endif
                                                            
                                                            @if($event->pivot->producte_id)
                                                                <div class="text-info small">
                                                                    <i class="fas fa-box me-1"></i> 
                                                                    <a href="{{ route('productes.show', $event->pivot->producte_id) }}" class="text-decoration-none">
                                                                        {{ __('messages.profile_page.view_related_product') }}
                                                                    </a>
                                                                </div>
                                                            @endif
                                                            
                                                            <div class="mt-2">
                                                            <span class="badge bg-primary">
                                                                    <i class="fas fa-calendar-day me-1"></i>
                                                                    {{ \App\Support\LocalizedDate::human($event->data_inici, $locale) }}
                                                                </span> 
                                                                <br>
                                                                @if($event->tipus)
                                                                    <span class="badge" style="background-color: {{ $event->tipus->color }}; margin-top: 5px;">
                                                                        {{ $event->displayTypeName() }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">{{ __('messages.profile_page.no_past_events') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación para eliminar cuenta -->
    <div class="modal fade" id="deleteModal" tabindex="-1" data-bs-backdrop="true" data-bs-keyboard="true" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">{{ __('messages.profile_page.confirm_delete_title') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('messages.profile_page.close') }}"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('messages.profile_page.confirm_delete_message') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.profile_page.cancel') }}</button>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ __('messages.profile_page.delete_account') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@vite(['resources/css/profile.css'])
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.35.3/dist/apexcharts.min.css">

<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.35.3/dist/apexcharts.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () { 
        const i18nProfile = {
            server_response_error: @json(__('messages.profile_page.server_response_error')),
            points_current_label: @json(__('messages.profile_page.points_current_label')),
            points_spent_label: @json(__('messages.profile_page.points_spent_label')),
            total_label: @json(__('messages.profile_page.total_label')),
            claim_date: @json(__('messages.profile_page.claim_date')),
            status: @json(__('messages.profile_page.status')),
            tracking_code: @json(__('messages.profile_page.tracking_code')),
            comments: @json(__('messages.profile_page.comments')),
            timeline_claimed: @json(__('messages.profile_page.timeline_claimed')),
            timeline_processing: @json(__('messages.profile_page.timeline_processing')),
            timeline_delivered: @json(__('messages.profile_page.timeline_delivered')),
            status_pendent: @json(__('messages.profile_page.status_pendent')),
            status_procesant: @json(__('messages.profile_page.status_procesant')),
            status_entregat: @json(__('messages.profile_page.status_entregat')),
            status_cancelat: @json(__('messages.profile_page.status_cancelat')),
            month_jan: @json(__('messages.profile_page.month_jan')),
            month_feb: @json(__('messages.profile_page.month_feb')),
            month_mar: @json(__('messages.profile_page.month_mar')),
            month_apr: @json(__('messages.profile_page.month_apr')),
            month_may: @json(__('messages.profile_page.month_may')),
            month_jun: @json(__('messages.profile_page.month_jun')),
            month_jul: @json(__('messages.profile_page.month_jul')),
            month_aug: @json(__('messages.profile_page.month_aug')),
            month_sep: @json(__('messages.profile_page.month_sep')),
            month_oct: @json(__('messages.profile_page.month_oct')),
            month_nov: @json(__('messages.profile_page.month_nov')),
            month_dec: @json(__('messages.profile_page.month_dec')),
            accumulated_points: @json(__('messages.profile_page.accumulated_points')),
            points: @json(__('messages.profile_page.points')),
            valid_image_error: @json(__('messages.profile_page.valid_image_error')),
            image_too_large_error: @json(__('messages.profile_page.image_too_large_error')),
            photo_updated_success: @json(__('messages.profile_page.photo_updated_success')),
            update_photo_error: @json(__('messages.profile_page.update_photo_error')),
            upload_image_error: @json(__('messages.profile_page.upload_image_error')),
            not_specified: @json(__('messages.profile_page.not_specified'))
        };

        function cleanupModalArtifacts() {
            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('padding-right');
            document.body.style.removeProperty('overflow');
        }

        // Force cleanup after any modal closes to avoid stuck backdrop overlays.
        document.querySelectorAll('.modal').forEach((modalEl) => {
            modalEl.addEventListener('hidden.bs.modal', () => {
                window.setTimeout(cleanupModalArtifacts, 0);
            });
        });

        const parseJsonResponse = async (response, defaultMessage = i18nProfile.server_response_error) => {
            const payload = await response.json().catch(() => null);

            if (!response.ok) {
                throw new Error((payload && payload.message) || `${defaultMessage}: ${response.statusText}`);
            }

            return payload;
        };

        // Variables con datos del usuario
        const puntsActuals = {{ $user->punts_actuals ?? 0 }};
        const puntsGastats = {{ $user->punts_gastats ?? 0 }};
        const puntsTotals = {{ $user->punts_totals ?? 0 }};
        const userId = {{ $user->id }};

        // Configurar el tema de ApexCharts según el modo oscuro/claro
        const isDarkMode = document.body.classList.contains('dark');
        const textColor = isDarkMode ? '#e2e8f0' : '#111111';
        const gridColor = isDarkMode ? '#4a5568' : '#e9e9e9';

        // Gráfico de distribución de puntos (donut chart)
        const pointsDistributionOptions = {
            series: [puntsActuals, puntsGastats],
            chart: {
                type: 'donut',
                height: 250,
                fontFamily: 'Roboto, sans-serif',
                foreColor: textColor,
                background: 'transparent'
            },
            theme: {
                mode: isDarkMode ? 'dark' : 'light'
            },
            labels: [i18nProfile.points_current_label, i18nProfile.points_spent_label],
            colors: ['#2e7d32', '#d32f2f'],
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '14px',
                                fontWeight: 600,
                                color: textColor
                            },
                            value: {
                                show: true,
                                fontSize: '20px',
                                fontWeight: 600,
                                color: textColor,
                                formatter: function (val) {
                                    return val;
                                }
                            },
                            total: {
                                show: true,
                                label: i18nProfile.total_label,
                                color: textColor,
                                formatter: function (w) {
                                    return puntsTotals;
                                }
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                position: 'bottom',
                fontSize: '14px',
                labels: {
                    colors: textColor
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 300
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        // Obtener datos de actividad del usuario usando el índice Algolia de códigos
        // Obtener datos de actividad del usuario usando el índice Algolia de códigos
        async function loadActivityData() {
            // Verificar si existe el índice de códigos
            if (!window.codisIndex) {
                console.error('El índice codisIndex no está definido en window');
                return []; // Retornar array vacío en lugar de datos falsos
            }


            // Define los meses en catalán
            const localizedMonths = [
                i18nProfile.month_jan,
                i18nProfile.month_feb,
                i18nProfile.month_mar,
                i18nProfile.month_apr,
                i18nProfile.month_may,
                i18nProfile.month_jun,
                i18nProfile.month_jul,
                i18nProfile.month_aug,
                i18nProfile.month_sep,
                i18nProfile.month_oct,
                i18nProfile.month_nov,
                i18nProfile.month_dec
            ];

            // Inicializa datos para últimos 6 meses con valor 0
            let activityData = {};
            for (let i = 5; i >= 0; i--) {
                const date = new Date();
                date.setMonth(date.getMonth() - i);
                const monthIndex = date.getMonth(); // 0-11
                const monthName = localizedMonths[monthIndex];
                activityData[monthName] = 0;
            }


            try {
                // Obtener TODOS los códigos sin filtro
                const searchResults = await window.codisIndex.search('', {
                    hitsPerPage: 1000
                });

                const allHits = searchResults.hits;

                // Filtrar manualmente por user_id
                const hits = allHits.filter(codi => {
                    // Comprobar todas las posibles variantes del campo user_id
                    const possibleFields = ['user_id', 'userId', 'user', 'userID', 'userid'];

                    for (const field of possibleFields) {
                        if (codi[field] !== undefined &&
                            (codi[field] === userId || codi[field] === userId.toString())) {
                            return true;
                        }
                    }

                    // Si no encontramos coincidencia con ningún campo estándar,
                    // revisar todos los campos del código por si acaso
                    for (const [key, value] of Object.entries(codi)) {
                        if (key.toLowerCase().includes('user') &&
                            (value === userId || value === userId.toString())) {
                            return true;
                        }
                    }

                    return false;
                });


                if (hits.length === 0) {
                    // Simplemente convertir y retornar los datos inicializados (con valores en cero)
                    const emptyData = Object.keys(activityData).map(month => ({
                        x: month,
                        y: activityData[month] // Que será 0 para todos los meses
                    }));
                    return emptyData;
                }

                // Procesar los resultados y sumar puntos por mes
                hits.forEach(codi => {
                    // Extraer mes de data_escaneig
                    const date = new Date(codi.data_escaneig);
                    const monthIndex = date.getMonth(); // 0-11

                    // Solo considerar códigos de los últimos 6 meses
                    const sixMonthsAgo = new Date();
                    sixMonthsAgo.setMonth(sixMonthsAgo.getMonth() - 6);

                    if (date >= sixMonthsAgo) {
                        const monthName = localizedMonths[monthIndex];

                        if (monthName in activityData) {
                            activityData[monthName] += codi.punts;
                        }
                    }
                });

                // Convertir a formato para el gráfico
                const formattedData = Object.keys(activityData).map(month => ({
                    x: month,
                    y: activityData[month]
                }));

                return formattedData;
            } catch (error) {
                console.error('Error al cargar datos de actividad:', error);
                // Retornar datos vacíos en caso de error
                return Object.keys(activityData).map(month => ({
                    x: month,
                    y: 0
                }));
            }
        }

        // Verificar si el elemento del gráfico existe
        async function initCharts() {
            try {
                // Verificar si existen los contenedores de los gráficos
                const pointsChartEl = document.querySelector("#pointsDistributionChart");
                const activityChartEl = document.querySelector("#activityChart");

                // Cargar datos de actividad
                const activityData = await loadActivityData();

                // Gráfico de actividad (área)
                const activityChartOptions = {
                    series: [{
                        name: i18nProfile.accumulated_points,
                        data: activityData.map(item => item.y)
                    }],
                    chart: {
                        type: 'area',
                        height: 250,
                        fontFamily: 'Roboto, sans-serif',
                        foreColor: textColor,
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: false
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    colors: ['#2e7d32'],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.7,
                            opacityTo: 0.2,
                            stops: [0, 90, 100]
                        }
                    },
                    xaxis: {
                        categories: activityData.map(item => item.x),
                        labels: {
                            style: {
                                fontSize: '12px',
                                colors: textColor
                            }
                        }
                    },
                    yaxis: {
                        title: {
                            text: i18nProfile.points,
                            style: {
                                fontSize: '14px',
                                color: textColor
                            }
                        },
                        labels: {
                            style: {
                                colors: textColor
                            }
                        }
                    },
                    grid: {
                        borderColor: gridColor,
                        strokeDashArray: 5
                    },
                    tooltip: {
                        theme: isDarkMode ? 'dark' : 'light',
                        y: {
                            formatter: function (value) {
                                return `${value} ${i18nProfile.points.toLowerCase()}`;
                            }
                        }
                    }
                };

                // Renderizar gráficos
                if (pointsChartEl) {
                    const pointsDistributionChart = new ApexCharts(pointsChartEl, pointsDistributionOptions);
                    pointsDistributionChart.render();
                }

                if (activityChartEl) {
                    const activityChart = new ApexCharts(activityChartEl, activityChartOptions);
                    activityChart.render();
                }
            } catch (error) {
                console.error("Error detallado al inicializar los gráficos:", error);
                console.error("Stack trace:", error.stack);
            }
        }



        // Función para manejar el cambio de foto de perfil
        function setupPhotoUpload() {
            const photoUpload = document.getElementById('photo-upload');
            const profileImage = document.getElementById('profile-image-main');
            const changePhotoBtn = document.querySelector('.change-photo-btn');

            const syncUserAvatars = (src) => {
                if (!src) return;

                const finalSrc = src.startsWith('data:')
                    ? src
                    : `${src}${src.includes('?') ? '&' : '?'}t=${Date.now()}`;

                document.querySelectorAll('#profile-image-main, #navbar-profile-image, .js-user-avatar').forEach((img) => {
                    img.src = finalSrc;
                });
            };

            if (!photoUpload || !profileImage) {
                console.error('Elementos de foto de perfil no encontrados');
                return;
            }

            // Configurar evento para cuando se selecciona una nueva foto
            photoUpload.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;

                // Validar tipo de archivo
                const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
                if (!validTypes.includes(file.type)) {
                    alert(i18nProfile.valid_image_error);
                    return;
                }

                // Validar tamaño (máximo 5 MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert(i18nProfile.image_too_large_error);
                    return;
                }

                // Mostrar vista previa
                const reader = new FileReader();
                reader.onload = function (e) {
                    syncUserAvatars(e.target.result);
                };
                reader.readAsDataURL(file);

                // Mostrar indicador de carga
                const loadingOverlay = document.createElement('div');
                loadingOverlay.style.position = 'absolute';
                loadingOverlay.style.top = '0';
                loadingOverlay.style.left = '0';
                loadingOverlay.style.width = '100%';
                loadingOverlay.style.height = '100%';
                loadingOverlay.style.backgroundColor = 'rgba(0,0,0,0.5)';
                loadingOverlay.style.borderRadius = '50%';
                loadingOverlay.style.display = 'flex';
                loadingOverlay.style.justifyContent = 'center';
                loadingOverlay.style.alignItems = 'center';
                loadingOverlay.innerHTML = '<i class="fas fa-spinner fa-spin text-white fa-2x"></i>';
                profileImage.parentElement.appendChild(loadingOverlay);

                // Subir la imagen
                const formData = new FormData();
                formData.append('foto_perfil', file);
                formData.append('_token', '{{ csrf_token() }}');

                // Deshabilitar botón durante la carga
                changePhotoBtn.disabled = true;

                fetch('{{ route('users.update.photo', $user->id) }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' // Añadir esta cabecera para identificar peticiones AJAX
                    }
                })
                    .then(response => parseJsonResponse(response, i18nProfile.server_response_error))
                    .then(data => {
                        // Eliminar indicador de carga
                        loadingOverlay.remove();

                        // Habilitar botón nuevamente
                        changePhotoBtn.disabled = false;

                        if (data.success) {
                            // Actualizar imagen del perfil con la URL proporcionada por el servidor
                            if (data.path) {
                                syncUserAvatars(data.path);
                            }

                            // Mostrar mensaje de éxito
                            showNotification('success', i18nProfile.photo_updated_success);
                        } else {
                            // Mostrar mensaje de error
                            showNotification('error', data.message || i18nProfile.update_photo_error);
                        }
                    })
                    .catch(error => {
                        console.error('Error detallado:', error);

                        // Eliminar indicador de carga
                        loadingOverlay.remove();

                        // Habilitar botón nuevamente
                        changePhotoBtn.disabled = false;

                        // Mostrar mensaje de error
                        showNotification('error', error.message || i18nProfile.upload_image_error);
                    });
            });
        }

        // Función para mostrar notificaciones perfectamente centradas
        function showNotification(type, message) {
            // Primero, eliminar notificaciones anteriores si existen
            const existingNotifications = document.querySelectorAll('.notification-toast');
            existingNotifications.forEach(el => el.remove());

            // Crear overlay semitransparente
            const overlay = document.createElement('div');
            overlay.className = 'notification-overlay';
            overlay.style.position = 'fixed';
            overlay.style.top = '0';
            overlay.style.left = '0';
            overlay.style.width = '100%';
            overlay.style.height = '100%';
            overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.3)';
            overlay.style.zIndex = '9998';
            overlay.style.display = 'flex';
            overlay.style.justifyContent = 'center';
            overlay.style.alignItems = 'center';
            overlay.style.opacity = '0';
            overlay.style.transition = 'opacity 0.3s ease';

            // Crear elemento de notificación
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} notification-toast`;

            // Usar flexbox para centrar perfectamente el contenido interno
            notification.style.display = 'flex';
            notification.style.alignItems = 'center';
            notification.style.justifyContent = 'center';
            notification.style.textAlign = 'center';
            notification.style.minWidth = '300px';
            notification.style.maxWidth = '80%';
            notification.style.padding = '20px 30px';
            notification.style.borderRadius = '12px';
            notification.style.boxShadow = '0 5px 20px rgba(0,0,0,0.3)';
            notification.style.transform = 'scale(0.9)';
            notification.style.transition = 'transform 0.3s ease';

            // Contenido con iconos más grandes
            notification.innerHTML = `
                <div style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mb-3 fa-3x"></i>
                    <span class="fs-4">${message}</span>
                </div>
            `;

            // Añadir notificación al overlay
            overlay.appendChild(notification);

            // Añadir overlay al DOM
            document.body.appendChild(overlay);

            // Animar entrada
            requestAnimationFrame(() => {
                overlay.style.opacity = '1';
                notification.style.transform = 'scale(1)';
            });

            // Eliminar después de 2.5 segundos
            setTimeout(() => {
                overlay.style.opacity = '0';
                notification.style.transform = 'scale(0.9)';

                // Eliminar del DOM después de la animación
                setTimeout(() => {
                    document.body.removeChild(overlay);
                }, 300);
            }, 2500);
        }

        // Iniciar
        initCharts();
        setupPhotoUpload();

        // Activar las pestañas de Bootstrap
        var triggerTabList = [].slice.call(document.querySelectorAll('#eventsTabs button'))
        triggerTabList.forEach(function (triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)
            
            triggerEl.addEventListener('click', function (event) {
                event.preventDefault()
                tabTrigger.show()
            })
        })
    });
</script>

