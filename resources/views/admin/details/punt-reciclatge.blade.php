<div class="punt-detail-container bg-white rounded-lg shadow-sm p-4">
    <!-- Encabezado del punto de recogida -->
    <div class="punt-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-start">
                    <div class="punt-icon-container me-4">
                        <div class="punt-icon text-white d-flex align-items-center justify-content-center rounded" 
                            style="width: 80px; height: 80px; background-color: 
                                @switch($punt->fraccio)
                                    @case('Groc') #f9d71c @break
                                    @case('Blau') #0057b8 @break
                                    @case('Verd') #00a651 @break
                                    @case('Marró') #8c4b00 @break
                                    @case('Gris') #6c757d @break
                                    @case('Punt Verd') #00a651 @break
                                    @default #6c757d @break
                                @endswitch
                            ">
                            <i class="fas fa-recycle fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="punt-name mb-1">{{ $punt->nom }}</h2>
                        <div class="punt-fraccio mb-2">
                            <span class="badge py-1 px-2" style="background-color: 
                                @switch($punt->fraccio)
                                    @case('Groc') #f9d71c; color: #000 @break
                                    @case('Blau') #0057b8 @break
                                    @case('Verd') #00a651 @break
                                    @case('Marró') #8c4b00 @break
                                    @case('Gris') #6c757d @break
                                    @case('Punt Verd') #00a651 @break
                                    @default #6c757d @break
                                @endswitch
                            ">
                                <i class="fas fa-tag me-1"></i>{{ $punt->fraccio }}
                            </span>
                            
                            @if($punt->disponible)
                                <span class="badge bg-success ms-2">Disponible</span>
                            @else
                                <span class="badge bg-danger ms-2">No disponible</span>
                            @endif
                        </div>
                        <div class="punt-address">
                            <i class="fas fa-map-marker-alt text-muted me-2"></i>
                            <span class="text-muted">{{ $punt->adreca }}, {{ $punt->ciutat }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="map-thumbnail">
                    <img src="https://api.mapbox.com/styles/v1/mapbox/streets-v11/static/pin-l+f74e4e({{ $punt->longitud }},{{ $punt->latitud }})/{{ $punt->longitud }},{{ $punt->latitud }},15,0/300x200?access_token=pk.eyJ1IjoibGF1dG9yaW5vIiwiYSI6ImNscDg0cGZmeTBreGsyaW1ubzJxeGpkdmgifQ.S3sLvRUHOE3p4JKdTLnU2A" 
                         class="img-fluid rounded shadow-sm" alt="Mapa">
                </div>
            </div>
        </div>
    </div>

    <!-- Coordenadas -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="info-card bg-light p-4 rounded-3 shadow-sm mb-4">
                <h4 class="card-title mb-3">
                    <i class="fas fa-map-pin text-primary me-2"></i>Coordenades
                </h4>
                <div class="coord-info d-flex">
                    <div class="me-4">
                        <span class="text-muted">Latitud:</span>
                        <code class="ms-2">{{ $punt->latitud }}</code>
                    </div>
                    <div>
                        <span class="text-muted">Longitud:</span>
                        <code class="ms-2">{{ $punt->longitud }}</code>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Contenedor principal con scroll */
    .punt-detail-container {
        border-radius: 8px;
        overflow-y: auto;
        max-height: 70vh;
        padding: 20px;
        margin: 0;
        scrollbar-width: thin;
    }
    
    /* Estilos para la barra de desplazamiento */
    .punt-detail-container::-webkit-scrollbar {
        width: 6px;
    }
    
    .punt-detail-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .punt-detail-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    /* Modo oscuro */
    body.dark .punt-detail-container {
        background-color: #2d3748 !important;
    }
    
    body.dark .info-card {
        background-color: #3f4a5c !important;
    }
    
    body.dark .punt-name {
        color: #f1f5f9;
    }
    
    body.dark .card-title {
        color: #e2e8f0;
    }
    
    code {
        background-color: #f8f9fa;
        padding: 2px 4px;
        border-radius: 4px;
        color: #e83e8c;
    }
    
    body.dark code {
        background-color: #2d3748;
        color: #f8f9fa;
    }
</style>