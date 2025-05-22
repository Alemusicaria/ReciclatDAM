<div class="user-detail-container bg-white rounded-lg shadow-sm p-4">
    <!-- Encabezado del perfil -->
    <div class="profile-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="user-avatar-container me-4">
                        @if($user->foto_perfil)
                            @if(str_starts_with($user->foto_perfil, 'https://'))
                                <img src="{{ $user->foto_perfil }}" class="user-avatar rounded-circle" alt="Foto perfil" style="margin-right: 10px;">
                            @elseif(file_exists(public_path('storage/' . $user->foto_perfil)))
                                <img src="{{ asset('storage/' . $user->foto_perfil) }}" class="user-avatar rounded-circle" alt="Foto perfil" style="margin-right: 10px;">
                            @else
                                <img src="{{ asset('images/default-profile.png') }}" class="user-avatar rounded-circle" alt="Foto perfil" style="margin-right: 10px;">
                            @endif
                        @else
                            <img src="{{ asset('images/default-profile.png') }}" class="user-avatar rounded-circle" alt="Foto perfil" style="margin-right: 10px;">
                        @endif
                    </div>
                    <div>
                        <h2 class="user-name mb-1" style="text-align: left">{{ $user->nom }} {{ $user->cognoms }}</h2>
                        <div class="user-email mb-2">
                            <i class="fas fa-envelope text-muted me-2" style="margin-right: 10px;"></i>{{ $user->email }}
                        </div>
                        <div class="user-status">
                            <span class="badge {{ $user->rol->nom === 'Administrador' ? 'bg-danger' : ($user->rol->nom === 'Gestor' ? 'bg-warning' : 'bg-success') }} py-1 px-2">
                                <i class="fas fa-user-shield me-1" style="margin-right: 5px;"></i>{{ $user->rol->nom }}
                            </span>
                            @if($user->nivell())
                                <span class="badge bg-info py-1 px-2 ms-2">
                                    <i class="fas fa-trophy me-1" style="margin-right: 5px;"></i>{{ $user->nivell()->nom }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="user-points-summary">
                    <div class="points-card bg-primary-subtle p-3 rounded-3 shadow-sm mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Punts Actuals</h6>
                                <small class="text-muted">Disponibles per utilitzar</small>
                            </div>
                            <div class="points-value">
                                <span class="fs-4 fw-bold text-primary">{{ $user->punts_actuals }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="points-card bg-success-subtle p-3 rounded-3 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Punts Totals</h6>
                                <small class="text-muted">Acumulats històricament</small>
                            </div>
                            <div class="points-value">
                                <span class="fs-4 fw-bold text-success">{{ $user->punts_totals }}</span>
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
                    <i class="fas fa-user-circle text-primary me-2" style="margin-right: 10px;"></i>Informació Personal
                </h4>
                <div class="user-info-list">
                    <div class="info-item d-flex mb-3">
                        <div class="info-label me-2 text-muted" style="width: 140px;">
                            <i class="fas fa-calendar-day me-2" style="margin-right: 10px;"></i>Data Naixement:
                        </div>
                        <div class="info-value fw-medium">
                            {{ $user->data_naixement ? date('d/m/Y', strtotime($user->data_naixement)) : 'No especificada' }}
                        </div>
                    </div>
                    <div class="info-item d-flex mb-3">
                        <div class="info-label me-2 text-muted" style="width: 140px;">
                            <i class="fas fa-phone me-2" style="margin-right: 10px;"></i>Telèfon:
                        </div>
                        <div class="info-value fw-medium">
                            {{ $user->telefon ?: 'No especificat' }}
                        </div>
                    </div>
                    <div class="info-item d-flex mb-3">
                        <div class="info-label me-2 text-muted" style="width: 140px;">
                            <i class="fas fa-map-marker-alt me-2" style="margin-right: 10px;"></i>Ubicació:
                        </div>
                        <div class="info-value fw-medium">
                            {{ $user->ubicacio ?: 'No especificada' }}
                        </div>
                    </div>
                    <div class="info-item d-flex mb-3">
                        <div class="info-label me-2 text-muted" style="width: 140px;">
                            <i class="fas fa-calendar-check me-2" style="margin-right: 10px;"></i>Data Registre:
                        </div>
                        <div class="info-value fw-medium">
                            {{ date('d/m/Y', strtotime($user->created_at)) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="info-card bg-light p-4 rounded-3 shadow-sm mb-4">
                <h4 class="card-title mb-3">
                    <i class="fas fa-recycle text-success me-2" style="margin-right: 10px;"></i>Activitat de Reciclatge
                </h4>
                <div class="recycling-summary">
                    <!-- Resumen de puntos en tarjetas de colores -->
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="mini-stat-card bg-warning-subtle p-3 rounded-3">
                                <h6 class="mini-stat-title mb-1">Punts Gastats</h6>
                                <div class="mini-stat-value fs-5 fw-bold text-warning">
                                    {{ $user->punts_gastats }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mini-stat-card bg-info-subtle p-3 rounded-3">
                                <h6 class="mini-stat-title mb-1">Codis Escanejats</h6>
                                <div class="mini-stat-value fs-5 fw-bold text-info">
                                    {{ $user->codis()->count() }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mt-2">
                            <div class="mini-stat-card bg-success-subtle p-3 rounded-3">
                                <h6 class="mini-stat-title mb-1">Premis Obtinguts</h6>
                                <div class="mini-stat-value fs-5 fw-bold text-success">
                                    {{ $user->premisReclamats()->count() }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mt-2">
                            <div class="mini-stat-card bg-danger-subtle p-3 rounded-3">
                                <h6 class="mini-stat-title mb-1">Events Assistits</h6>
                                <div class="mini-stat-value fs-5 fw-bold text-danger">
                                    {{ $user->events()->count() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de premios reclamados -->
    <div class="row mt-2">
        <div class="col-12">
            <div class="info-card bg-light p-4 rounded-3 shadow-sm">
                <h4 class="card-title mb-3">
                    <i class="fas fa-gift text-warning me-2"></i>Premis Reclamats
                </h4>
                
                @if($user->premisReclamats->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Premi</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Estat</th>
                                    <th scope="col">Punts</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->premisReclamats as $reclamat)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($reclamat->premi && $reclamat->premi->imatge)
                                                    <img src="{{ asset($reclamat->premi->imatge) }}" 
                                                         alt="{{ $reclamat->premi->nom }}" 
                                                         class="me-2 rounded" style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">
                                                @else
                                                    <span class="prize-placeholder me-2 bg-secondary rounded d-flex align-items-center justify-content-center" 
                                                          style="width: 40px; height: 40px; margin-right: 10px;">
                                                        <i class="fas fa-gift text-white"></i>
                                                    </span>
                                                @endif
                                                <span>{{ $reclamat->premi ? $reclamat->premi->nom : 'Premi eliminat' }}</span>
                                            </div>
                                        </td>
                                        <td>{{ date('d/m/Y', strtotime($reclamat->data_reclamacio)) }}</td>
                                        <td>
                                            <span class="badge {{ $reclamat->estat === 'Entregat' ? 'bg-success' : 
                                                           ($reclamat->estat === 'Pendent' ? 'bg-warning' : 'bg-secondary') }}">
                                                {{ $reclamat->estat }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $reclamat->premi ? $reclamat->premi->punts_requerits : 'N/A' }} pts</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state text-center p-4">
                        <i class="fas fa-gift text-muted fa-3x mb-3"></i>
                        <p class="lead">Aquest usuari encara no ha reclamat cap premi</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<style>
    /* Ajuste del modal y scrolling */
    .modal-body {
        padding: 0 !important; /* Eliminar padding extra */
        overflow: hidden !important; /* Prevenir scroll en el modal-body */
    }
    
    /* Contenedor principal con un único scroll */
    .user-detail-container {
        border-radius: 8px;
        overflow-y: auto;
        max-height: 70vh; /* Altura máxima reducida */
        padding: 20px;
        margin: 0;
        scrollbar-width: thin;
    }
    
    /* Estilos para la barra de desplazamiento */
    .user-detail-container::-webkit-scrollbar {
        width: 6px;
    }
    
    .user-detail-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .user-detail-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    .user-detail-container::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
    
    /* Modo oscuro para scrollbar */
    body.dark .user-detail-container::-webkit-scrollbar-track {
        background: #2d3748;
    }
    
    body.dark .user-detail-container::-webkit-scrollbar-thumb {
        background: #4a5568;
    }
    
    body.dark .user-detail-container::-webkit-scrollbar-thumb:hover {
        background: #718096;
    }
    
    /* Ajustes al modal de detalle */
    #detailModal .modal-dialog {
        max-width: 100vh !important; /* Ancho fijo más razonable */
        margin: 1.75rem auto;
    }
    
    #detailModal .modal-content {
        height: auto !important;
        max-height: 80vh;
    }
    
    /* Hacer que el encabezado se quede fijo */
    .profile-header {
        position: sticky;
        top: 0;
        background-color: inherit;
        z-index: 5;
        padding: 10px 0;
        margin-bottom: 15px;
        border-bottom: 1px solid rgba(0,0,0,0.1);
    }
    
    body.dark .profile-header {
        border-bottom-color: rgba(255,255,255,0.05);
    }
    
    .user-avatar {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border: 3px solid white;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    
    .user-name {
        font-size: 1.6rem;
        font-weight: 700;
        color: #333;
    }
    
    .user-email {
        color: #6c757d;
        font-size: 0.95rem;
    }
    
    .info-card {
        transition: all 0.3s ease;
        margin-bottom: 15px;
    }
    
    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1) !important;
    }
    
    .card-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #495057;
    }
    
    .info-label {
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .mini-stat-card {
        transition: all 0.3s ease;
    }
    
    .mini-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .mini-stat-title {
        font-size: 0.85rem;
        color: #6c757d;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0,0,0,0.02);
    }
    
    /* Modo oscuro */
    body.dark .user-detail-container {
        background-color: #2d3748 !important;
    }
    
    body.dark .info-card {
        background-color: #3f4a5c !important;
    }
    
    body.dark .user-name {
        color: #f1f5f9;
    }
    
    body.dark .card-title {
        color: #e2e8f0;
    }
    
    body.dark .table-hover tbody tr:hover {
        background-color: rgba(255,255,255,0.05);
    }
    
    body.dark .table-light {
        background-color: #4a5568;
        color: #e2e8f0;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .user-avatar {
            width: 70px;
            height: 70px;
        }
        
        .user-name {
            font-size: 1.4rem;
        }
        
        #detailModal .modal-dialog {
            max-width: 95% !important;
            margin: 1rem auto;
        }
        
        .user-detail-container {
            max-height: 75vh;
        }
    }
</style>