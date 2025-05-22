<div class="codi-detail-container bg-white rounded-lg shadow-sm p-4">
    <!-- Encabezado del código -->
    <div class="codi-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-start">
                    <div class="codi-icon-container me-4">
                        <div class="codi-icon bg-primary text-white d-flex align-items-center justify-content-center rounded" style="width: 70px; height: 70px; margin-right: 20px;">
                            <i class="fas fa-qrcode fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="codi-code mb-2">
                            <span class="code-label">Codi:</span>
                            <code class="bg-light px-2 py-1 rounded">{{ $codi->codi }}</code>
                        </h2>
                        <div class="codi-info mb-1">
                            <span class="badge bg-success">{{ $codi->punts }} punts</span>
                        </div>
                        <div class="codi-date">
                            <i class="fas fa-calendar-day text-muted me-2"></i>
                            <span class="text-muted">{{ $codi->data_escaneig->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                @if($codi->user)
                    <div class="codi-user-info">
                        <h5 class="mb-2">Escanejat per:</h5>
                        <div class="d-flex align-items-center justify-content-md-end">
                            @if($codi->user->foto_perfil)
                                <img src="{{ asset('storage/' . $codi->user->foto_perfil) }}" 
                                     class="rounded-circle me-2" width="50" height="50" alt="Perfil" style="margin-right: 5px;">
                            @else
                                <div class="user-icon-placeholder rounded-circle me-2 d-flex align-items-center justify-content-center bg-secondary" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            @endif
                            <div class="text-start">
                                <div class="user-name">{{ $codi->user->nom }} {{ $codi->user->cognoms }}</div>
                                <div class="user-email text-muted small">{{ $codi->user->email }}</div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-2"></i> Aquest codi encara no ha estat escanejat.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    /* Contenedor principal con scroll */
    .codi-detail-container {
        border-radius: 8px;
        overflow-y: auto;
        max-height: 70vh;
        padding: 20px;
        margin: 0;
        scrollbar-width: thin;
    }
    
    /* Estilos para la barra de desplazamiento */
    .codi-detail-container::-webkit-scrollbar {
        width: 6px;
    }
    
    .codi-detail-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .codi-detail-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    /* Código grande */
    .codi-code {
        font-size: 1.6rem;
        font-weight: 600;
    }
    
    .code-label {
        font-weight: normal;
        font-size: 1.2rem;
        color: #6c757d;
        margin-right: 8px;
    }
    
    code {
        font-family: 'Courier New', monospace;
        font-size: 1.4rem;
    }
    
    /* Modo oscuro */
    body.dark .codi-detail-container {
        background-color: #2d3748 !important;
    }
    
    body.dark code {
        background-color: #1a202c !important;
        color: #e2e8f0;
    }
    
    body.dark .code-label {
        color: #a0aec0;
    }
</style>