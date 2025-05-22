<div class="premi-detail-container bg-white rounded-lg shadow-sm p-4">
    <!-- Encabezado del premio -->
    <div class="premi-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="premi-image-container me-4">
                        @if($premi->imatge)
                            <img src="{{ asset($premi->imatge) }}" class="premi-image rounded" alt="Imatge premi" style="width: 120px; height: 120px; object-fit: cover; margin-right: 10px;">
                        @else
                            <div class="premi-placeholder rounded d-flex align-items-center justify-content-center" 
                                style="width: 120px; height: 120px; background-color: #ff9800;">
                                <i class="fas fa-gift fa-3x text-white"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h2 class="premi-name mb-1">{{ $premi->nom }}</h2>
                        <div class="premi-points mb-2">
                            <span class="badge bg-primary py-1 px-2">
                                <i class="fas fa-coins me-1"></i>{{ $premi->punts_requerits }} punts
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="premi-stats">
                    <div class="stats-card bg-success-subtle p-3 rounded-3 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Reclamacions</h6>
                                <small class="text-muted">Total històric</small>
                            </div>
                            <div class="stats-value">
                                <span class="fs-4 fw-bold text-success">{{ $premi->premiReclamats()->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información detallada -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="info-card bg-light p-4 rounded-3 shadow-sm mb-4">
                <h4 class="card-title mb-3">
                    <i class="fas fa-align-left text-success me-2" style="margin-right: 10px;"></i>Descripció
                </h4>
                <div class="premi-description">
                    <p class="mb-0">{{ $premi->descripcio ?: 'Sense descripció' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de usuarios que han reclamado el premio -->
    <div class="row mt-2">
        <div class="col-12">
            <div class="info-card bg-light p-4 rounded-3 shadow-sm">
                <h4 class="card-title mb-3">
                    <i class="fas fa-users text-warning me-2" style="margin-right: 10px;"></i>Reclamacions d'aquest premi
                </h4>
                
                @if($premi->premiReclamats->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Usuari</th>
                                    <th scope="col">Data Reclamació</th>
                                    <th scope="col">Estat</th>
                                    <th scope="col">Punts</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($premi->premiReclamats as $reclamat)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($reclamat->user && $reclamat->user->foto_perfil)
                                                    <img src="{{ asset('storage/' . $reclamat->user->foto_perfil) }}" 
                                                         alt="{{ $reclamat->user->nom }}" 
                                                         class="me-2 rounded-circle" style="width: 40px; height: 40px; object-fit: cover; margin-right: 5px;">
                                                @else
                                                    <span class="user-placeholder me-2 bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                                          style="width: 40px; height: 40px;">
                                                        <i class="fas fa-user text-white"></i>
                                                    </span>
                                                @endif
                                                <span>{{ $reclamat->user ? $reclamat->user->nom . ' ' . $reclamat->user->cognoms : 'Usuari no disponible' }}</span>
                                            </div>
                                        </td>
                                        <td>{{ date('d/m/Y', strtotime($reclamat->data_reclamacio)) }}</td>
                                        <td>
                                            <span class="badge {{ $reclamat->estat === 'entregat' ? 'bg-success' : 
                                                           ($reclamat->estat === 'pendent' ? 'bg-warning' : 'bg-secondary') }}">
                                                {{ ucfirst($reclamat->estat) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $reclamat->punts_gastats }} pts</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state text-center p-4">
                        <i class="fas fa-gift text-muted fa-3x mb-3"></i>
                        <p class="lead">Aquest premi encara no ha estat reclamat per cap usuari</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    /* Contenedor principal con un único scroll */
    .premi-detail-container {
        border-radius: 8px;
        overflow-y: auto;
        max-height: 70vh;
        padding: 20px;
        margin: 0;
        scrollbar-width: thin;
    }
    
    /* Estilos para la barra de desplazamiento */
    .premi-detail-container::-webkit-scrollbar {
        width: 6px;
    }
    
    .premi-detail-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .premi-detail-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    /* Modo oscuro */
    body.dark .premi-detail-container {
        background-color: #2d3748 !important;
    }
    
    body.dark .info-card {
        background-color: #3f4a5c !important;
    }
    
    body.dark .premi-name {
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