@extends('layouts.app')

@section('content')
    <div class="container profile-container" style="margin-top: 8rem !important;">
        <div class="row">
            <div class="col-lg-4">
                <!-- Tarjeta de perfil principal -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body text-center">
                        <div class="position-relative mb-4">
                            <!-- Imagen de perfil -->
                            @if(Auth::user()->foto_perfil)
                                @if(str_starts_with(Auth::user()->foto_perfil, 'https://'))
                                    <img src="{{ Auth::user()->foto_perfil }}" alt="Foto de perfil"
                                        class="rounded-circle img-thumbnail shadow" id="profile-image"
                                        style="width: 150px; height: 150px; object-fit: cover;">
                                @elseif(file_exists(public_path('storage/' . Auth::user()->foto_perfil)))
                                    <img src="{{ asset('storage/' . Auth::user()->foto_perfil) }}" alt="Foto de perfil"
                                        class="rounded-circle img-thumbnail shadow" id="profile-image"
                                        style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('images/default-profile.png') }}" alt="Foto de perfil"
                                        class="rounded-circle img-thumbnail shadow" id="profile-image"
                                        style="width: 150px; height: 150px; object-fit: cover;">
                                @endif
                            @else
                                <img src="{{ asset('images/default-profile.png') }}" alt="Foto de perfil"
                                    class="rounded-circle img-thumbnail shadow" id="profile-image"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                            @endif

                            <!-- Icono para editar foto -->
                            <div class="position-relative bottom-0 start-0">
                                <label for="photo-upload" class="btn btn-sm btn-success rounded-circle change-photo-btn"
                                    style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; margin: auto; margin-top: 1vh;"
                                    title="Canviar foto">
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
                                <span class="fw-bold" style="margin-right: 5px;">{{ $user->punts_actuals }}</span> ECODAMS
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <a href="{{ route('users.edit', $user->id) }}" class="btn-modern btn-edit">
                                <i class="fas fa-edit me-2"></i>
                            </a>
                            <button type="button" class="btn-modern btn-delete" data-bs-toggle="modal"
                                data-bs-target="#deleteModal">
                                <i class="fas fa-trash-alt me-2"></i>
                            </button>
                        </div>
                    </div>
                </div>

                               <!-- Sistema de niveles -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-trophy me-2 text-primary" style="margin-right: 5px;"></i>Nivell actual
                        </h5>
                        
                        @php
                            $currentLevel = $user->nivell();
                            $nextLevel = App\Models\Nivell::where('punts_requerits', '>', $currentLevel->punts_requerits)
                                ->orderBy('punts_requerits', 'asc')
                                ->first();
                            
                            if ($nextLevel) {
                                $pointsToNextLevel = $nextLevel->punts_requerits - $user->punts_totals;
                                $progress = ($user->punts_totals - $currentLevel->punts_requerits) / 
                                        ($nextLevel->punts_requerits - $currentLevel->punts_requerits) * 100;
                                $progress = max(0, min(100, $progress));
                            }
                        @endphp
                        
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3 p-3 rounded-circle" style="background-color: {{ $currentLevel->color }}; width: 70px; height: 70px; display: flex; justify-content: center; align-items: center; margin-right: 20px;">
                                <i class="{{ $currentLevel->icona }} fa-2x text-white"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">{{ $currentLevel->nom }}</h5>
                                <p class="mb-0 text-muted">{{ $currentLevel->descripcio }}</p>
                            </div>
                        </div>
                        
                        @if($nextLevel)
                            <div class="mt-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Nivell {{ $currentLevel->id }}: {{ $currentLevel->nom }}</span>
                                    <span>Nivell {{ $nextLevel->id }}: {{ $nextLevel->nom }}</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar" role="progressbar" 
                                        style="width: {{ $progress }}%; background-color: {{ $currentLevel->color }};" 
                                        aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="text-center mt-2">
                                    <span class="badge bg-primary">
                                        Falten {{ $pointsToNextLevel }} punts per al següent nivell
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-success mt-3">
                                <i class="fas fa-trophy me-2"></i>
                                Felicitats! Has assolit el nivell màxim!
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tarjeta de estadísticas visuales -->
                <div class="card mb-4 stats-card" style="height: 45vh;">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="fas fa-chart-pie me-2" style="margin-right: 5px;"></i>Distribució de Punts
                        </h5>
                        <div id="pointsDistributionChart" class="chart-container"></div>
                    </div>
                </div>

                <!-- Historial de premios reclamados -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-gift me-2 text-success" style="margin-right: 5px;"></i>Premis reclamats
                        </h5>
                        
                        @if($user->premisReclamats->count() > 0)
                            <div class="table-responsive" style="max-height: none; overflow-y: visible;">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th>Premi</th>
                                            <th>Punts</th>
                                            <th>Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->premisReclamats->sortByDesc('data_reclamacio') as $premi)
                                            <tr style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#premiModal-{{ $premi->id }}">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($premi->premi->imatge)
                                                            <img src="{{ asset($premi->premi->imatge) }}" 
                                                                alt="{{ $premi->premi->nom }}" 
                                                                class="me-2" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; margin-right: 10px;">
                                                        @else
                                                            <div class="me-2 bg-light d-flex align-items-center justify-content-center" 
                                                                style="width: 40px; height: 40px; border-radius: 4px; margin-right: 10px;">
                                                                <i class="fas fa-gift text-secondary"></i>
                                                            </div>
                                                        @endif
                                                        <div class="text-truncate" style="max-width: 150px;">
                                                            <div class="fw-bold text-truncate">{{ $premi->premi->nom }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-coins me-1"></i> {{ $premi->punts_gastats }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    {{ $premi->data_reclamacio->format('d/m/Y') }}
                                                </td>
                                            </tr>

                                            <!-- Modal para este premio -->
                                            <div class="modal fade" id="premiModal-{{ $premi->id }}" tabindex="-1" aria-labelledby="premiModalLabel-{{ $premi->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                                <h5 class="modal-title" id="premiModalLabel-{{ $premi->id }}">
                                                                    {{ $premi->premi->nom }}
                                                                </h5>
                                                                <button type="button" class="btn btn-sm rounded-circle boto-modal" data-bs-dismiss="modal" aria-label="Close" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-weight: bold;">X</button>                                                       
                                                            </div>
                                                                <div class="modal-body">
                                                                    <div class="d-flex mb-4">
                                                                        @if($premi->premi->imatge)
                                                                            <img src="{{ asset($premi->premi->imatge) }}" 
                                                                                alt="{{ $premi->premi->nom }}" 
                                                                                class="me-3" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; margin-right: 15px;">
                                                                        @else
                                                                            <div class="me-3 bg-light d-flex align-items-center justify-content-center" 
                                                                                style="width: 100px; height: 100px; border-radius: 8px;">
                                                                                <i class="fas fa-gift fa-3x text-secondary"></i>
                                                                            </div>
                                                                        @endif
                                                                        <div>
                                                                            <h6 class="fw-bold mb-2">{{ $premi->premi->nom }}</h6>
                                                                            <p class="text-muted">{{ $premi->premi->descripcio }}</p>
                                                                            <div class="badge bg-success mb-2">
                                                                                <i class="fas fa-coins me-1"></i> {{ $premi->punts_gastats }} punts
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="card mb-3">
                                                                        <div class="card-header bg-light">
                                                                            <i class="fas fa-info-circle me-2" style="margin-right: 5px;"></i>Detalls de la reclamació
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="row mb-2">
                                                                                <div class="col-5 text-muted">Data de reclamació:</div>
                                                                                <div class="col-7 fw-bold">{{ $premi->data_reclamacio->format('d/m/Y H:i') }}</div>
                                                                            </div>
                                                                            
                                                                            <div class="row mb-2">
                                                                                <div class="col-5 text-muted">Estat:</div>
                                                                                <div class="col-7">
                                                                                    @php
                                                                                        $estatClasses = [
                                                                                            'pendent' => 'bg-warning',
                                                                                            'procesant' => 'bg-info',
                                                                                            'entregat' => 'bg-success',
                                                                                            'cancelat' => 'bg-danger'
                                                                                        ];
                                                                                        $estatIcons = [
                                                                                            'pendent' => 'fa-clock',
                                                                                            'procesant' => 'fa-cog',
                                                                                            'entregat' => 'fa-check-circle',
                                                                                            'cancelat' => 'fa-times-circle'
                                                                                        ];
                                                                                    @endphp
                                                                                    
                                                                                    <span class="badge {{ $estatClasses[$premi->estat] }}">
                                                                                        <i class="fas {{ $estatIcons[$premi->estat] }} me-1"></i>
                                                                                        {{ ucfirst($premi->estat) }}
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            @if($premi->codi_seguiment)
                                                                            <div class="row mb-2">
                                                                                <div class="col-5 text-muted">Codi de seguiment:</div>
                                                                                <div class="col-7">
                                                                                    <code>{{ $premi->codi_seguiment }}</code>
                                                                                </div>
                                                                            </div>
                                                                            @endif
                                                                            
                                                                            @if($premi->comentaris)
                                                                            <div class="row mb-2">
                                                                                <div class="col-5 text-muted">Comentaris:</div>
                                                                                <div class="col-7">{{ $premi->comentaris }}</div>
                                                                            </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <!-- Timeline del estado del premio -->
                                                                <div class="timeline mt-4">
                                                                    <div class="timeline-item {{ $premi->estat == 'pendent' || $premi->estat == 'procesant' || $premi->estat == 'entregat' ? 'done' : '' }}">
                                                                        <div class="timeline-marker {{ $premi->estat == 'pendent' || $premi->estat == 'procesant' || $premi->estat == 'entregat' ? 'bg-success' : 'bg-light' }}" style="margin-top: 2px;"></div>
                                                                        <div class="timeline-content">
                                                                            <h6 class="mb-0">Reclamat</h6>
                                                                            <small>{{ $premi->created_at->format('d/m/Y') }}</small>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="timeline-item {{ $premi->estat == 'procesant' || $premi->estat == 'entregat' ? 'done' : '' }}">
                                                                        <div class="timeline-marker {{ $premi->estat == 'procesant' || $premi->estat == 'entregat' ? 'bg-success' : 'bg-light' }}" style="margin-top: 1px;"></div>
                                                                        <div class="timeline-content">
                                                                            <h6 class="mb-0">En procés</h6>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="timeline-item {{ $premi->estat == 'entregat' ? 'done' : '' }}">
                                                                        <div class="timeline-marker {{ $premi->estat == 'entregat' ? 'bg-success' : 'bg-light' }}" style="margin-top: 1px;"></div>
                                                                        <div class="timeline-content">
                                                                            <h6 class="mb-0">Entregat</h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tancar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-gift fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No has reclamat cap premi encara.</p>
                                <a href="{{ route('premis.index') }}" class="btn btn-sm btn-success">Explora els premis disponibles</a>
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
                            <p class="text-muted mb-0">Punts totals</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="stats-counter text-center">
                            <div class="mb-2">
                                <i class="fas fa-wallet fa-2x text-success"></i>
                            </div>
                            <h3>{{ $user->punts_actuals ?? 0 }}</h3>
                            <p class="text-muted mb-0">Punts actuals</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="stats-counter text-center">
                            <div class="mb-2">
                                <i class="fas fa-shopping-cart fa-2x text-danger"></i>
                            </div>
                            <h3>{{ $user->punts_gastats ?? 0 }}</h3>
                            <p class="text-muted mb-0">Punts gastats</p>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de actividad -->
                <div class="card mb-4 stats-card" style="height: 45vh;">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-chart-line me-2" style="margin-right: 5px;"></i>Activitat recent
                        </h5>
                        <div id="activityChart" class="chart-container"></div>
                    </div>
                </div>

                <!-- Tarjeta de información personal -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-user me-2" style="margin-right: 5px;"></i>Informació personal
                        </h5>
                        <hr>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <p class="mb-0 text-muted">Nom complet</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-0">{{ $user->nom }} {{ $user->cognoms }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <p class="mb-0 text-muted">Email</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-0">{{ $user->email }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <p class="mb-0 text-muted">Telèfon</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-0">{{ $user->telefon ?? 'No especificat' }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <p class="mb-0 text-muted">Data de naixement</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-0">{{ $user->data_naixement ?? 'No especificada' }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0 text-muted">Ubicació</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-0">{{ $user->ubicacio ?? 'No especificada' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                                <!-- Historial de eventos -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-calendar-check me-2 text-success" style="margin-right: 5px;"></i>Els meus events
                        </h5>
                        
                        <ul class="nav nav-tabs mb-3" id="eventsTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming" 
                                        type="button" role="tab" aria-controls="upcoming" aria-selected="true">Propers</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="past-tab" data-bs-toggle="tab" data-bs-target="#past" 
                                        type="button" role="tab" aria-controls="past" aria-selected="false">Anteriors</button>
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
                                                            <div class="month">{{ $event->data_inici->format('M') }}</div>
                                                            <div class="day">{{ $event->data_inici->format('d') }}</div>
                                                        </div>
                                                        <div class="event-details">
                                                            <h6 class="mb-1">{{ $event->nom }}</h6>
                                                            <p class="text-muted mb-1 small">
                                                                <i class="fas fa-map-marker-alt me-1"></i> {{ $event->lloc }}
                                                            </p>
                                                            <p class="text-muted mb-1 small">
                                                                <i class="fas fa-clock me-1"></i> {{ $event->data_inici->format('H:i') }}
                                                            </p>
                                                            <div class="mt-2">
                                                                <span class="badge bg-primary">
                                                                    <i class="fas fa-calendar-day me-1"></i>
                                                                    {{ $event->data_inici->diffForHumans() }}
                                                                </span> 
                                                                <br>
                                                                @if($event->tipus)
                                                                    <span class="badge" style="background-color: {{ $event->tipus->color }}; margin-top: 5px;">
                                                                        {{ $event->tipus->nom }}
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
                                        <p class="text-muted">No tens cap event proper.</p>
                                        <a href="{{ route('events') }}" class="btn btn-sm btn-success">Explora els events disponibles</a>
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
                                                            <div class="month">{{ $event->data_inici->format('M') }}</div>
                                                            <div class="day">{{ $event->data_inici->format('d') }}</div>
                                                        </div>
                                                        <div class="event-details">
                                                            <h6 class="mb-1">{{ $event->nom }}</h6>
                                                            <p class="text-muted mb-1 small">
                                                                <i class="fas fa-map-marker-alt me-1"></i> {{ $event->lloc }}
                                                            </p>
                                                            <p class="text-muted mb-1 small">
                                                                <i class="fas fa-calendar me-1"></i> {{ $event->data_inici->format('d/m/Y') }} - {{ $event->data_inici->format('H:i') }}
                                                            </p>
                                                            @if($event->pivot->punts > 0)
                                                                <div class="text-success mb-1 small">
                                                                    <i class="fas fa-coins me-1"></i> {{ $event->pivot->punts }} punts obtinguts
                                                                </div>
                                                            @endif
                                                            
                                                            @if($event->pivot->producte_id)
                                                                <div class="text-info small">
                                                                    <i class="fas fa-box me-1"></i> 
                                                                    <a href="{{ route('productes.show', $event->pivot->producte_id) }}" class="text-decoration-none">
                                                                        Veure producte relacionat
                                                                    </a>
                                                                </div>
                                                            @endif
                                                            
                                                            <div class="mt-2">
                                                            <span class="badge bg-primary">
                                                                    <i class="fas fa-calendar-day me-1"></i>
                                                                    {{ $event->data_inici->diffForHumans() }}
                                                                </span> 
                                                                <br>
                                                                @if($event->tipus)
                                                                    <span class="badge" style="background-color: {{ $event->tipus->color }}; margin-top: 5px;">
                                                                        {{ $event->tipus->nom }}
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
                                        <p class="text-muted">No has participat en cap event encara.</p>
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
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar eliminació</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Estàs segur que vols eliminar el teu compte? Aquesta acció no es pot desfer.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel·lar</button>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar compte</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.35.3/dist/apexcharts.min.css">
<style>
    .profile-container {
        max-width: 1000px;
        margin: 0 auto !important;
    }

    .stats-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
    }

    .chart-container {
        height: 250px;
        margin-bottom: 1rem;
    }

    .points-badge {
        padding: 8px 16px;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 3px 10px rgba(46, 125, 50, 0.2);
    }

    .stats-counter {
        padding: 1.5rem;
        border-radius: 12px;
        background: linear-gradient(145deg, #f8f9fa, #e9ecef);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .stats-counter:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    body.dark .stats-counter {
        background: linear-gradient(145deg, #2d3748, #1a202c);
    }

    .edit-profile-container {
        max-width: 1000px;
        margin: 5rem auto 0 auto !important;
        padding: 2rem;
    }

    .edit-panel {
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }

    .edit-panel:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }

    body.dark .edit-panel {
        background-color: #2d3748;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
    }

    .edit-header {
        padding: 25px 30px;
        border-bottom: 1px solid #f1f1f1;
        display: flex;
        align-items: center;
    }

    body.dark .edit-header {
        border-color: #444;
    }

    .edit-header i {
        margin-right: 15px;
        font-size: 24px;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background-color: rgba(56, 142, 60, 0.1);
        color: #388e3c;
    }

    body.dark .edit-header i {
        background-color: rgba(56, 142, 60, 0.2);
        color: #4caf50;
    }

    .edit-header h4 {
        margin: 0;
        font-weight: 600;
    }

    .edit-body {
        padding: 30px;
    }

    .input-group {
        margin-bottom: 25px;
        position: relative;
        transition: all 0.3s ease;
    }

    .input-group:last-child {
        margin-bottom: 0;
    }

    .input-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #555;
        transition: all 0.3s ease;
    }

    body.dark .input-group label {
        color: #e2e8f0;
    }

    .input-group input,
    .input-group textarea,
    .input-group select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        font-size: 16px;
        transition: all 0.3s ease;
        background-color: #fff;
        color: #333;
    }

    .input-group input:focus,
    .input-group textarea:focus,
    .input-group select:focus {
        border-color: #388e3c;
        box-shadow: 0 0 0 3px rgba(56, 142, 60, 0.2);
        outline: none;
    }

    body.dark .input-group input,
    body.dark .input-group textarea,
    body.dark .input-group select {
        background-color: #384151;
        border-color: #4a5568;
        color: #e2e8f0;
    }

    body.dark .input-group input:focus,
    body.dark .input-group textarea:focus,
    body.dark .input-group select:focus {
        border-color: #4caf50;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.2);
    }

    .photo-upload-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 30px;
    }

    .photo-preview {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        overflow: hidden;
        margin-bottom: 15px;
        border: 4px solid #fff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    body.dark .photo-preview {
        border-color: #2d3748;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    .photo-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .photo-upload-btn {
        background-color: #388e3c;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        font-size: 14px;
    }

    .photo-upload-btn:hover {
        background-color: #2e7d32;
        transform: translateY(-2px);
    }

    .photo-upload-btn i {
        margin-right: 8px;
    }

    .actions {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        margin-top: 20px;
    }

    .btn-cancel {
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        background-color: transparent;
        border: 2px solid #e9ecef;
        color: #666;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background-color: #f8f9fa;
    }

    body.dark .btn-cancel {
        border-color: #4a5568;
        color: #e2e8f0;
    }

    body.dark .btn-cancel:hover {
        background-color: #384151;
    }

    .btn-save {
        padding: 10px 25px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        background-color: #388e3c;
        border: none;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-save:hover {
        background-color: #2e7d32;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(46, 125, 50, 0.3);
    }

    /* Estilos para input file oculto */
    #photo-upload {
        display: none;
    }

    /* Animaciones para cambios de estado */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .edit-panel {
        animation: slideIn 0.3s ease-out;
    }

    .btn-modern {
        width: 40px;
        border-radius: 50px;
        margin-left: 15px;
        margin-right: 15px;
        font-weight: 500;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-decoration: none;
    }

    .btn-edit {
        background-color: #3498db;
        color: white;
    }

    .btn-edit:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(52, 152, 219, 0.2);
        text-decoration: none;
        color: white;
    }

    .btn-delete {
        background-color: e74c3c;
        color: #white;
        border: 1px solid #e74c3c;
    }

    .btn-delete:hover {
        background-color: #e74c3c;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(231, 76, 60, 0.2);
        text-decoration: none;

    }

    body.dark .btn-delete {
        background-color: #e74c3c;
        border-color: #e74c3c;
    }

    body.dark .btn-delete:hover {
        background-color: #e74c3c;
    }

    /* Estilos para tarjetas de eventos */
    .event-card {
        border-radius: 10px;
        background-color: white;
        border: 1px solid rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .event-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }

    body.dark .event-card {
        background-color: #2d3748;
        border-color: #4a5568;
    }

    .event-date {
        width: 50px;
        border-radius: 8px;
        overflow: hidden;
    }

    .event-date .month {
        background-color: #2e7d32;
        color: white;
        font-size: 0.8rem;
        padding: 2px 0;
        text-transform: uppercase;
        font-weight: bold;
    }

    .event-date .day {
        background-color: white;
        color: #333;
        font-size: 1.2rem;
        padding: 5px 0;
        font-weight: bold;
    }

    body.dark .event-date .day {
        background-color: #1a202c;
        color: #e2e8f0;
    }

    /* Estilos para pestañas */
    .nav-tabs .nav-link {
        color: #666;
        font-weight: 500;
        border: none;
        padding: 8px 16px;
    }

    .nav-tabs .nav-link.active {
        color: #2e7d32;
        border-bottom: 2px solid #2e7d32;
        background: transparent;
    }

    body.dark .nav-tabs .nav-link {
        color: #aaa;
    }

    body.dark .nav-tabs .nav-link.active {
        color: #4caf50;
        border-bottom-color: #4caf50;
    }

    /* Estilos para el timeline */
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline:before {
        content: '';
        position: absolute;
        top: -5px;
        left: 21px;
        height: 100%;
        width: 2px;
        background-color: #e9ecef;
    }
    
    body.dark .timeline:before {
        background-color: #4a5568;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    
    .timeline-marker {
        position: absolute;
        left: -30px;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #e9ecef;
    }
    
    body.dark .timeline-marker {
        border-color: #2d3748;
        box-shadow: 0 0 0 2px #4a5568;
    }
    
    .timeline-marker.bg-success {
        background-color: #28a745 !important;
        box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.3);
    }
    
    .timeline-content {
        padding-bottom: 5px;
    }
    
    /* Efectos en filas clickeables */
    .table tr[data-bs-toggle="modal"]:hover {
        background-color: rgba(0,0,0,0.03);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        transition: all 0.2s ease;
    }
    
    body.dark .table tr[data-bs-toggle="modal"]:hover {
        background-color: rgba(255,255,255,0.05);
    }
    .modal-dialog {
        margin-top: 8rem !important;
    }

    /* Estilos para el sistema de niveles */
    .progress {
        height: 10px;
        border-radius: 5px;
        background-color: #e9ecef;
    }
    
    body.dark .progress {
        background-color: #4a5568;
    }

        /* Estilos modo oscuro para el perfil de usuario */
    
    /* Fondo y colores base */
    body.dark {
        --bg-primary: #1a202c;
        --bg-secondary: #2d3748;
        --bg-tertiary: #374151;
        --text-primary: #e2e8f0;
        --text-secondary: #a0aec0;
        --border-color: #4a5568;
        --accent-color: #68d391;
        --accent-hover: #48bb78;
        --shadow-color: rgba(0, 0, 0, 0.3);
    }
    
    /* Contenedor principal */
    body.dark .profile-container {
        background-color: var(--bg-primary);
        box-shadow: 0 4px 12px var(--shadow-color);
    }
    
    /* Tarjetas del perfil */
    body.dark .card {
        background-color: var(--bg-secondary);
        border-color: var(--border-color);
        color: var(--text-primary);
    }
    
    /* Estadísticas en modo oscuro */
    body.dark .stats-card {
        background-color: var(--bg-secondary);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    body.dark .stats-counter {
        background: linear-gradient(145deg, #2d3748, #1a202c);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }
    
    /* Gráfico de distribución */
    body.dark .chart-container {
        filter: brightness(0.9);
    }
    
    body.dark #pointsDistributionChart {
        background-color: var(--bg-secondary);
    }
    
    /* Insignias de puntos */
    body.dark .points-badge {
        background-color: var(--bg-tertiary);
        color: var(--accent-color);
        box-shadow: 0 3px 10px rgba(104, 211, 145, 0.2);
    }
    
    /* Sistema de niveles */
    body.dark .progress-bar {
        box-shadow: 0 0 10px rgba(104, 211, 145, 0.3);
    }
    
    body.dark .badge.bg-primary {
        background-color: var(--accent-color) !important;
        color: #1a202c;
    }
    
    /* Alertas */
    body.dark .alert-success {
        background-color: rgba(72, 187, 120, 0.2);
        color: var(--accent-color);
        border-color: rgba(72, 187, 120, 0.3);
    }
    
    body.dark .alert-info {
        background-color: rgba(66, 153, 225, 0.2);
        color: #90cdf4;
        border-color: rgba(66, 153, 225, 0.3);
    }
    
    /* Tablas */
    body.dark .table {
        color: var(--text-primary);
        border-color: var(--border-color);
    }
    
    body.dark .table thead th {
        border-bottom-color: var(--border-color);
        color: var(--accent-color);
    }
    
    body.dark .table td {
        border-color: var(--border-color);
    }
    
    /* Formularios */
    body.dark input,
    body.dark select,
    body.dark textarea {
        background-color: var(--bg-tertiary);
        border-color: var(--border-color);
        color: var(--text-primary);
    }
    
    body.dark input:focus,
    body.dark select:focus,
    body.dark textarea:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 0.2rem rgba(104, 211, 145, 0.25);
    }
    
    /* Modales */
    body.dark .modal-content {
        background-color: var(--bg-secondary);
        border-color: var(--border-color);
    }
    
    body.dark .modal-header,
    body.dark .modal-footer {
        border-color: var(--border-color);
    }
    
    /* Botones */
    body.dark .btn-primary {
        background-color: var(--accent-color);
        border-color: var(--accent-color);
    }
    
    body.dark .btn-primary:hover {
        background-color: var(--accent-hover);
        border-color: var(--accent-hover);
    }
    
    body.dark .btn-outline-primary {
        color: var(--accent-color);
        border-color: var(--accent-color);
    }
    
    body.dark .btn-outline-primary:hover {
        background-color: var(--accent-color);
        color: var(--bg-primary);
    }
    
    /* Pestañas de navegación */
    body.dark .nav-tabs {
        border-bottom-color: var(--border-color);
    }
    
    body.dark .nav-tabs .nav-link {
        color: var(--text-secondary);
    }
    
    body.dark .nav-tabs .nav-link.active {
        color: var(--accent-color);
        background-color: transparent;
        border-color: transparent transparent var(--accent-color);
    }
    
    /* Iconos */
    body.dark i.fas,
    body.dark i.fab {
        color: var(--text-secondary);
    }
    
    body.dark .text-primary i.fas,
    body.dark .text-primary i.fab {
        color: var(--accent-color);
    }

    body.dark .apexcharts-legend-text {
        color: var(--text-primary) !important;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.35.3/dist/apexcharts.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () { 
        // Variables con datos del usuario
        const puntsActuals = {{ Auth::user()->punts_actuals ?? 0 }};
        const puntsGastats = {{ Auth::user()->punts_gastats ?? 0 }};
        const puntsTotals = {{ Auth::user()->punts_totals ?? 0 }};
        const userId = {{ Auth::user()->id }};

        // Configurar el tema de ApexCharts según el modo oscuro/claro
        const isDarkMode = document.body.classList.contains('dark');
        const textColor = isDarkMode ? '#e2e8f0' : '#e2e8f0';
        const gridColor = isDarkMode ? '#4a5568' : '#e9e9e9';

        // Gráfico de distribución de puntos (donut chart)
        const pointsDistributionOptions = {
            series: [puntsActuals, puntsGastats],
            chart: {
                type: 'donut',
                height: 250,
                fontFamily: 'Roboto, sans-serif',
                foreColor: textColor
            },
            labels: ['Punts Actuals', 'Punts Gastats'],
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
                                fontWeight: 500
                            },
                            value: {
                                show: true,
                                fontSize: '20px',
                                fontWeight: 600,
                                formatter: function (val) {
                                    return val;
                                }
                            },
                            total: {
                                show: true,
                                label: 'Total',
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
                fontSize: '14px'
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
            const mesesCatalanes = ['Gen', 'Feb', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Oct', 'Nov', 'Des'];

            // Inicializa datos para últimos 6 meses con valor 0
            let activityData = {};
            for (let i = 5; i >= 0; i--) {
                const date = new Date();
                date.setMonth(date.getMonth() - i);
                const monthIndex = date.getMonth(); // 0-11
                const monthName = mesesCatalanes[monthIndex];
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
                        const monthName = mesesCatalanes[monthIndex];

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
                        name: 'Punts acumulats',
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
                            text: 'Punts',
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
                                return value + ' punts';
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
            const profileImage = document.getElementById('profile-image');
            const changePhotoBtn = document.querySelector('.change-photo-btn');

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
                    alert('Por favor selecciona una imagen válida (JPG, PNG o GIF)');
                    return;
                }

                // Validar tamaño (máximo 5 MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('La imagen es demasiado grande. El tamaño máximo es 5 MB.');
                    return;
                }

                // Mostrar vista previa
                const reader = new FileReader();
                reader.onload = function (e) {
                    profileImage.src = e.target.result;
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
                formData.append('_method', 'PUT');

                // Deshabilitar botón durante la carga
                changePhotoBtn.disabled = true;

                // En show.blade.php - en la función photoUpload.addEventListener('change', ...)
                fetch('{{ route('users.update', Auth::user()->id) }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' // Añadir esta cabecera para identificar peticiones AJAX
                    }
                })
                    .then(response => {
                        // Si la respuesta no es OK, vamos a intentar analizar el mensaje de error
                        if (!response.ok) {
                            return response.json().then(errorData => {
                                throw new Error(errorData.message || 'Error del servidor: ' + response.status);
                            }).catch(e => {
                                // Si no podemos parsear JSON, lanzamos el error genérico
                                throw new Error('Error en la respuesta del servidor: ' + response.statusText);
                            });
                        }

                        return response.json();
                    })
                    .then(data => {
                        // Eliminar indicador de carga
                        loadingOverlay.remove();

                        // Habilitar botón nuevamente
                        changePhotoBtn.disabled = false;

                        if (data.success) {
                            // Actualizar imagen del perfil con la URL proporcionada por el servidor
                            if (data.path) {
                                profileImage.src = data.path;

                                // Actualizar también la imagen en la barra de navegación
                                const navbarProfileImg = document.querySelector('.navbar-nav .nav-link.dropdown-toggle img.rounded-circle');
                                if (navbarProfileImg) {
                                    navbarProfileImg.src = data.path;
                                } else {
                                    console.warn('No se encontró la imagen del perfil en el navbar');
                                }
                            }

                            // Mostrar mensaje de éxito
                            showNotification('success', 'Foto actualizada correctamente');
                        } else {
                            // Mostrar mensaje de error
                            showNotification('error', data.message || 'Error al actualizar la foto');
                        }
                    })
                    .catch(error => {
                        console.error('Error detallado:', error);

                        // Eliminar indicador de carga
                        loadingOverlay.remove();

                        // Habilitar botón nuevamente
                        changePhotoBtn.disabled = false;

                        // Mostrar mensaje de error
                        showNotification('error', error.message || 'Error al subir la imagen. Inténtalo de nuevo.');
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