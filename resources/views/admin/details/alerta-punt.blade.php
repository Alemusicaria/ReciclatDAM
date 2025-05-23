<div class="alerta-detail-container bg-white rounded-lg shadow-sm p-4">
    <div class="alerta-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-start">
                    <div class="alerta-icon-container me-4">
                        <div class="alerta-icon text-white d-flex align-items-center justify-content-center rounded" 
                            style="width: 80px; height: 80px; background-color: #ffc107;">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="alerta-name mb-1">
                            Alerta en {{ $alerta->puntDeRecollida ? $alerta->puntDeRecollida->nom : 'Punt desconegut' }}
                        </h2>
                        <div class="alerta-tipus mb-2">
                            <span class="badge bg-warning py-1 px-2">
                                <i class="fas fa-bell me-1"></i>{{ $alerta->tipus ? $alerta->tipus->nom : 'Tipus desconegut' }}
                            </span>
                        </div>
                        <div class="alerta-date">
                            <i class="fas fa-calendar-day text-muted me-2"></i>
                            <span class="text-muted">Creada el {{ $alerta->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($alerta->updated_at && $alerta->updated_at->ne($alerta->created_at))
                            <div class="alerta-update">
                                <i class="fas fa-edit text-muted me-2"></i>
                                <span class="text-muted">Actualitzada el {{ $alerta->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="punt-info">
                    <h5 class="punt-title mb-2">Punt de Recollida</h5>
                    <div class="punt-details p-3 rounded-3 shadow-sm" style="background-color: #f8f9fa;">
                        @if($alerta->puntDeRecollida)
                            <div class="d-flex align-items-center mb-2">
                                <div class="punto-icon rounded-circle me-2 d-flex align-items-center justify-content-center"
                                    style="width: 30px; height: 30px; background-color: 
                                        @switch($alerta->puntDeRecollida->fraccio)
                                            @case('Groc') #f9d71c @break
                                            @case('Blau') #0057b8 @break
                                            @case('Verd') #00a651 @break
                                            @case('Marró') #8c4b00 @break
                                            @case('Gris') #6c757d @break
                                            @case('Punt Verd') #00a651 @break
                                            @default #6c757d @break
                                        @endswitch
                                    ">
                                    <i class="fas fa-recycle text-white small"></i>
                                </div>
                                <span class="ms-1 fw-medium">{{ $alerta->puntDeRecollida->nom }}</span>
                            </div>
                            <div class="punt-location small text-muted">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                {{ $alerta->puntDeRecollida->adreca }}, {{ $alerta->puntDeRecollida->ciutat }}
                            </div>
                        @else
                            <div class="text-muted">El punt de recollida ja no existeix</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Descripción de la alerta -->
    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="info-card bg-light p-4 rounded-3 shadow-sm mb-4">
                <h4 class="card-title mb-3">
                    <i class="fas fa-align-left text-primary me-2"></i>Descripció
                </h4>
                <div class="alerta-description">
                    <p class="mb-0">{{ $alerta->descripció ?: 'No hi ha descripció disponible.' }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            @if($alerta->imatge)
                <div class="info-card bg-light p-4 rounded-3 shadow-sm mb-4">
                    <h4 class="card-title mb-3">
                        <i class="fas fa-image text-success me-2"></i>Imatge
                    </h4>
                    <div class="alerta-image">
                        <img src="{{ asset($alerta->imatge) }}" alt="Imatge de l'alerta" class="img-fluid rounded">
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Contenedor principal con scroll */
    .alerta-detail-container {
        border-radius: 8px;
        overflow-y: auto;
        max-height: 70vh;
        padding: 20px;
        margin: 0;
        scrollbar-width: thin;
    }
    
    /* Estilos para la barra de desplazamiento */
    .alerta-detail-container::-webkit-scrollbar {
        width: 6px;
    }
    
    .alerta-detail-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .alerta-detail-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    /* Modo oscuro */
    body.dark .alerta-detail-container {
        background-color: #2d3748 !important;
    }
    
    body.dark .info-card {
        background-color: #3f4a5c !important;
    }
</style>