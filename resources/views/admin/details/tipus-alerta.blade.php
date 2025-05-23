<div class="tipus-alerta-detail-container bg-white rounded-lg shadow-sm p-4">
    <div class="tipus-alerta-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-start">
                    <div class="tipus-alerta-icon-container me-4">
                        <div class="tipus-alerta-icon text-white d-flex align-items-center justify-content-center rounded" 
                            style="width: 80px; height: 80px; background-color: #ffc107;">
                            <i class="fas fa-bell fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="tipus-alerta-name mb-1">{{ $tipusAlerta->nom }}</h2>
                        <div class="tipus-alerta-date">
                            <i class="fas fa-calendar-day text-muted me-2"></i>
                            <span class="text-muted">Creat el {{ $tipusAlerta->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($tipusAlerta->updated_at && $tipusAlerta->updated_at != $tipusAlerta->created_at)
                            <div class="tipus-alerta-update">
                                <i class="fas fa-edit text-muted me-2"></i>
                                <span class="text-muted">Última actualització: {{ $tipusAlerta->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="alert-info">
                    <h5 class="alert-count-title mb-2">Estadístiques</h5>
                    <div class="alert-count p-3 rounded-3 shadow-sm" style="background-color: #f8f9fa;">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span>Total d'alertes:</span>
                            <span class="badge bg-primary">{{ $tipusAlerta->alertes()->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Historial d'alertes -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="info-card bg-light p-4 rounded-3 shadow-sm mb-4">
                <h4 class="card-title mb-3">
                    <i class="fas fa-history text-primary me-2"></i>Historial d'Alertes
                </h4>
                
                @if($tipusAlerta->alertes()->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Punt de Recollida</th>
                                    <th>Data Alerta</th>
                                    <th>Estat</th>
                                    <th>Descripció</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tipusAlerta->alertes()->latest()->take(10)->get() as $alerta)
                                    <tr>
                                        <td>
                                            @if($alerta->puntDeRecollida)
                                                {{ $alerta->puntDeRecollida->nom }}
                                            @else
                                                Eliminat
                                            @endif
                                        </td>
                                        <td>{{ $alerta->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge {{ $alerta->estat == 'activa' ? 'bg-danger' : 'bg-success' }}">
                                                {{ $alerta->estat }}
                                            </span>
                                        </td>
                                        <td>{{ $alerta->descripcio }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        @if($tipusAlerta->alertes()->count() > 10)
                            <div class="text-center mt-3">
                                <span class="text-muted">Mostrant 10 de {{ $tipusAlerta->alertes()->count() }} alertes</span>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-2"></i>No hi ha alertes d'aquest tipus registrades.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    /* Contenedor principal con scroll */
    .tipus-alerta-detail-container {
        border-radius: 8px;
        overflow-y: auto;
        max-height: 70vh;
        padding: 20px;
        margin: 0;
        scrollbar-width: thin;
    }
    
    /* Estilos para la barra de desplazamiento */
    .tipus-alerta-detail-container::-webkit-scrollbar {
        width: 6px;
    }
    
    .tipus-alerta-detail-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .tipus-alerta-detail-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    /* Modo oscuro */
    body.dark .tipus-alerta-detail-container {
        background-color: #2d3748 !important;
    }
    
    body.dark .info-card {
        background-color: #3f4a5c !important;
    }
</style>