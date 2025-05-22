<div class="producte-detail-container bg-white rounded-lg shadow-sm p-4">
    <!-- Encabezado del producto -->
    <div class="producte-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-start">
                    <div class="producte-image-container me-4">
                        @if($producte->imatge)
                            <img src="{{ asset($producte->imatge) }}" class="producte-image rounded" alt="Imatge producte" style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="producte-placeholder rounded d-flex align-items-center justify-content-center" 
                                style="width: 120px; height: 120px; background-color: #4caf50;">
                                <i class="fas fa-box fa-3x text-white"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h2 class="producte-name mb-1">{{ $producte->nom }}</h2>
                        <div class="producte-category mb-2">
                            <span class="badge bg-primary py-1 px-2">
                                <i class="fas fa-tag me-1"></i>{{ $producte->categoria }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Contenedor principal con scroll */
    .producte-detail-container {
        border-radius: 8px;
        overflow-y: auto;
        max-height: 70vh;
        padding: 20px;
        margin: 0;
        scrollbar-width: thin;
    }
    
    /* Estilos para la barra de desplazamiento */
    .producte-detail-container::-webkit-scrollbar {
        width: 6px;
    }
    
    .producte-detail-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .producte-detail-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    /* Modo oscuro */
    body.dark .producte-detail-container {
        background-color: #2d3748 !important;
    }
    
    body.dark .producte-name {
        color: #f1f5f9;
    }
</style>