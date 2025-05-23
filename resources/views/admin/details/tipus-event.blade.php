<div class="tipus-event-detail-container bg-white rounded-lg shadow-sm p-4">
    <div class="tipus-event-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-start">
                    <div class="tipus-event-icon-container me-4">
                        <div class="tipus-event-icon text-white d-flex align-items-center justify-content-center rounded" 
                            style="width: 80px; height: 80px; background-color: {{ $tipusEvent->color }}">
                            <i class="fas fa-calendar-day fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="tipus-event-name mb-1">{{ $tipusEvent->nom }}</h2>
                        <div class="tipus-event-color mb-2">
                            <span class="badge py-1 px-2" style="background-color: {{ $tipusEvent->color }}">
                                {{ $tipusEvent->color }}
                            </span>
                        </div>
                        <div class="tipus-event-date">
                            <i class="fas fa-calendar-day text-muted me-2"></i>
                            <span class="text-muted">Creat el {{ $tipusEvent->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($tipusEvent->updated_at && $tipusEvent->updated_at->ne($tipusEvent->created_at))
                            <div class="tipus-event-update">
                                <i class="fas fa-edit text-muted me-2"></i>
                                <span class="text-muted">Actualitzat el {{ $tipusEvent->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="event-count">
                    <h5 class="event-count-title mb-2">Estadístiques</h5>
                    <div class="event-count p-3 rounded-3 shadow-sm" style="background-color: #f8f9fa;">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span>Total d'events:</span>
                            <span class="badge bg-primary">{{ $tipusEvent->events()->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Descripción del tipo de evento -->
    @if($tipusEvent->descripcio)
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="info-card bg-light p-4 rounded-3 shadow-sm mb-4">
                <h4 class="card-title mb-3">
                    <i class="fas fa-align-left text-primary me-2"></i>Descripció
                </h4>
                <div class="tipus-event-description">
                    <p class="mb-0">{{ $tipusEvent->descripcio ?: 'No hi ha descripció disponible.' }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Eventos de este tipo -->
    <div class="row mt-2">
        <div class="col-lg-12">
            <div class="info-card bg-light p-4 rounded-3 shadow-sm mb-4">
                <h4 class="card-title mb-3">
                    <i class="fas fa-calendar-alt text-success me-2"></i>Events d'aquest tipus
                </h4>
                
                @if($tipusEvent->events()->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Data Inici</th>
                                    <th>Data Fi</th>
                                    <th>Participants</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tipusEvent->events()->take(10)->get() as $event)
                                    <tr>
                                        <td>{{ $event->nom }}</td>
                                        <td>{{ $event->data_inici->format('d/m/Y H:i') }}</td>
                                        <td>{{ $event->data_fi->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ $event->participants()->count() }} participants
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        @if($tipusEvent->events()->count() > 10)
                            <div class="text-center mt-3">
                                <span class="text-muted">Mostrant 10 de {{ $tipusEvent->events()->count() }} events</span>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-2"></i>No hi ha events d'aquest tipus registrats.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    /* Contenedor principal con scroll */
    .tipus-event-detail-container {
        border-radius: 8px;
        overflow-y: auto;
        max-height: 70vh;
        padding: 20px;
        margin: 0;
        scrollbar-width: thin;
    }
    
    /* Estilos para la barra de desplazamiento */
    .tipus-event-detail-container::-webkit-scrollbar {
        width: 6px;
    }
    
    .tipus-event-detail-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .tipus-event-detail-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    /* Modo oscuro */
    body.dark .tipus-event-detail-container {
        background-color: #2d3748 !important;
    }
    
    body.dark .info-card {
        background-color: #3f4a5c !important;
    }
</style>