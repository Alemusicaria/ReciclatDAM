<div class="event-detail-container bg-white rounded-lg shadow-sm p-4">
    <!-- Encabezado del evento -->
    <div class="event-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="event-image-container me-4">
                        @if($event->imatge)
                            <img src="{{ asset('storage/' . $event->imatge) }}" class="event-image rounded" alt="Imatge event" style="width: 120px; height: 120px; object-fit: cover; margin-right: 10px;">
                        @else
                            <div class="event-placeholder rounded d-flex align-items-center justify-content-center" 
                                style="width: 120px; height: 120px; background-color: {{ $event->tipus ? $event->tipus->color : '#3f51b5' }};">
                                <i class="fas fa-calendar-alt fa-3x text-white"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h2 class="event-name mb-1">{{ $event->nom }}</h2>
                        <div class="event-type mb-2">
                            <span class="badge py-1 px-2" style="background-color: {{ $event->tipus ? $event->tipus->color : '#3f51b5' }};">
                                <i class="fas fa-tag me-1"></i>{{ $event->tipus ? $event->tipus->nom : 'Sense tipus' }}
                            </span>
                        </div>
                        <div class="event-dates">
                            <i class="fas fa-calendar-day text-muted me-2"></i>
                            <span class="text-muted">{{ $event->data_inici->format('d/m/Y H:i') }} - {{ $event->data_fi ? $event->data_fi->format('d/m/Y H:i') : 'Indefinit' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="event-stats">
                    <div class="stats-card bg-primary-subtle p-3 rounded-3 shadow-sm mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Participants</h6>
                                <small class="text-muted">Persones registrades</small>
                            </div>
                            <div class="stats-value">
                                <span class="fs-4 fw-bold text-primary">{{ $event->participants()->count() }} / {{ $event->capacitat ?: '∞' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="stats-card bg-success-subtle p-3 rounded-3 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Punts Assignats</h6>
                                <small class="text-muted">Per aquest event</small>
                            </div>
                            <div class="stats-value">
                                <span class="fs-4 fw-bold text-success">{{ $event->punts_disponibles ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información detallada -->
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="info-card bg-light p-4 rounded-3 shadow-sm mb-4">
                <h4 class="card-title mb-3">
                    <i class="fas fa-info-circle text-primary me-2" style="margin-right: 10px;"></i>Informació de l'Event
                </h4>
                <div class="event-info-list">
                    <div class="info-item d-flex mb-3">
                        <div class="info-label me-2 text-muted" style="width: 140px;">
                            <i class="fas fa-map-marker-alt me-2" style="margin-right: 5px;"></i>Lloc:
                        </div>
                        <div class="info-value fw-medium">
                            {{ $event->lloc ?: 'No especificat' }}
                        </div>
                    </div>
                    <div class="info-item d-flex mb-3">
                        <div class="info-label me-2 text-muted" style="width: 140px;">
                            <i class="fas fa-users me-2" style="margin-right: 5px;"></i>Capacitat:
                        </div>
                        <div class="info-value fw-medium">
                            {{ $event->capacitat ?: 'Sense límit' }}
                        </div>
                    </div>
                    <div class="info-item d-flex mb-3">
                        <div class="info-label me-2 text-muted" style="width: 140px;">
                            <i class="fas fa-calendar-plus me-2" style="margin-right: 5px;"></i>Creat:
                        </div>
                        <div class="info-value fw-medium">
                            {{ date('d/m/Y', strtotime($event->created_at)) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="info-card bg-light p-4 rounded-3 shadow-sm mb-4">
                <h4 class="card-title mb-3">
                    <i class="fas fa-align-left text-success me-2" style="margin-right: 10px;"></i>Descripció
                </h4>
                <div class="event-description">
                    <p class="mb-0">{{ $event->descripcio ?: 'Sense descripció' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de participantes -->
    <div class="row mt-2">
        <div class="col-12">
            <div class="info-card bg-light p-4 rounded-3 shadow-sm">
                <h4 class="card-title mb-3">
                    <i class="fas fa-users text-warning me-2" style="margin-right: 10px;"></i>Participants
                </h4>
                
                @if($event->participants->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Usuari</th>
                                    <th scope="col">Data Registre</th>
                                    <th scope="col">Punts</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($event->participants as $participant)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($participant->foto_perfil)
                                                    <img src="{{ asset('storage/' . $participant->foto_perfil) }}" 
                                                         alt="{{ $participant->nom }}" 
                                                         class="me-2 rounded-circle" style="width: 40px; height: 40px; object-fit: cover; margin-right: 5px;">
                                                @else
                                                    <span class="user-placeholder me-2 bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                                          style="width: 40px; height: 40px;">
                                                        <i class="fas fa-user text-white"></i>
                                                    </span>
                                                @endif
                                                <span>{{ $participant->nom }} {{ $participant->cognoms }}</span>
                                            </div>
                                        </td>
                                        <td>{{ date('d/m/Y', strtotime($participant->pivot->created_at)) }}</td>
                                        <td>
                                            <span class="badge bg-success">{{ $participant->pivot->punts ?? 0 }} pts</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state text-center p-4">
                        <i class="fas fa-users text-muted fa-3x mb-3"></i>
                        <p class="lead">Encara no hi ha participants registrats en aquest event</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    /* Contenedor principal con un único scroll */
    .event-detail-container {
        border-radius: 8px;
        overflow-y: auto;
        max-height: 70vh;
        padding: 20px;
        margin: 0;
        scrollbar-width: thin;
    }
    
    /* Estilos para la barra de desplazamiento */
    .event-detail-container::-webkit-scrollbar {
        width: 6px;
    }
    
    .event-detail-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .event-detail-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    /* Modo oscuro */
    body.dark .event-detail-container {
        background-color: #2d3748 !important;
    }
    
    body.dark .info-card {
        background-color: #3f4a5c !important;
    }
    
    body.dark .event-name {
        color: #f1f5f9;
    }
    
    body.dark .card-title {
        color: #e2e8f0;
    }
    .btn-close {
        background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
        opacity: 0.5;
    }

    .btn-close:hover {
        opacity: 0.75;
    }

</style>