@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Estadístiques de Navegació</h1>
    <p class="text-muted">
        Anàlisi de {{ number_format($totalRecords) }} registres.
        @if($totalRecords > $limit)
            <span class="badge bg-info">Mostra estadística basada en {{ number_format($limit) }} registres ({{ $samplingPercentage }}%)</span>
        @endif
    </p>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="display-4">{{ number_format($totalRecords) }}</h3>
                            <div class="text-white-50">Total de Registres</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-database fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="display-4">{{ $deviceData['Mobile'] ?? 0 }}</h3>
                            <div class="text-white-50">Dispositius Mòbils</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-mobile-alt fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="display-4">{{ $deviceData['Desktop'] ?? 0 }}</h3>
                            <div class="text-white-50">Dispositius Desktop</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-desktop fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="display-4">{{ round($avgConcurrency, 1) }}</h3>
                            <div class="text-white-50">Mitjana de Nuclis CPU</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-microchip fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Gráfico de Plataformas -->
        <div class="col-xl-6 col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-laptop me-1"></i>
                    Sistemes Operatius
                </div>
                <div class="card-body">
                    <canvas id="platformChart" width="100%" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Gráfico de Navegadores -->
        <div class="col-xl-6 col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-globe me-1"></i>
                    Navegadors
                </div>
                <div class="card-body">
                    <canvas id="browserChart" width="100%" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-4">
        <!-- Gráfico de Dispositivos -->
        <div class="col-xl-4 col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-mobile-alt me-1"></i>
                    Tipus de Dispositius
                </div>
                <div class="card-body">
                    <canvas id="deviceChart" width="100%" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Gráfico de Cookies -->
        <div class="col-xl-4 col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-cookie me-1"></i>
                    Suport de Cookies
                </div>
                <div class="card-body">
                    <canvas id="cookieChart" width="100%" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Gráfico de Idiomas -->
        <div class="col-xl-4 col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-language me-1"></i>
                    Idiomes
                </div>
                <div class="card-body">
                    <canvas id="languageChart" width="100%" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Tabla de Resoluciones -->
        <div class="col-xl-6 col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-tv me-1"></i>
                    Resolucions de Pantalla més Comunes
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Resolució</th>
                                <th>Usuaris</th>
                                <th>Percentatge</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($resolutionData as $resolution => $count)
                                <tr>
                                    <td>{{ $resolution }}</td>
                                    <td>{{ $count }}</td>
                                    <td>{{ round(($count / $limit) * 100, 1) }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Metadatos Técnicos -->
        <div class="col-xl-6 col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Dades Tècniques
                </div>
                <div class="card-body">
                    <p>Aquesta informació pot ajudar a entendre millor els dispositius dels teus usuaris i optimitzar la teva aplicació per a ells.</p>
                    
                    <h5 class="mt-4">Hardware i Capacitats</h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Mitjana de Nuclis CPU
                            <span class="badge bg-primary rounded-pill">{{ round($avgConcurrency, 1) }}</span>
                        </li>
                    </ul>
                    
                    <h5 class="mt-4">Anàlisi de Compatibilitat</h5>
                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb me-2"></i>
                        Es recomana optimitzar per a dispositius mòbils, ja que representen 
                        {{ $deviceData['Mobile'] ?? 0 }} dels teus usuaris 
                        ({{ round((($deviceData['Mobile'] ?? 0) / $limit) * 100, 1) }}%).
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuración de colores
    const colorPalette = [
        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
        '#5a5c69', '#6f42c1', '#fd7e14', '#20c997', '#6610f2'
    ];

    // Función para crear gráficos
    function createChart(element, type, labels, data, title) {
        return new Chart(document.getElementById(element), {
            type: type,
            data: {
                labels: labels,
                datasets: [{
                    label: title,
                    data: data,
                    backgroundColor: colorPalette.slice(0, labels.length),
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: type === 'pie' ? 'right' : 'top',
                    },
                }
            }
        });
    }

    // Gráfico de plataformas
    createChart(
        'platformChart', 
        'bar', 
        {!! json_encode($platformData->keys()) !!},
        {!! json_encode($platformData->values()) !!},
        'Sistemas Operativos'
    );
    
    // Gráfico de navegadores
    createChart(
        'browserChart', 
        'pie', 
        {!! json_encode($browserData->keys()) !!},
        {!! json_encode($browserData->values()) !!},
        'Navegadores'
    );
    
    // Gráfico de dispositivos
    createChart(
        'deviceChart', 
        'doughnut', 
        {!! json_encode($deviceData->keys()) !!},
        {!! json_encode($deviceData->values()) !!},
        'Tipos de Dispositivo'
    );
    
    // Gráfico de cookies
    createChart(
        'cookieChart', 
        'pie', 
        ['Habilitadas', 'Deshabilitadas'],
        [{{ $cookiesEnabled }}, {{ $cookiesDisabled }}],
        'Soporte de Cookies'
    );
    
    // Gráfico de idiomas
    createChart(
        'languageChart', 
        'bar', 
        {!! json_encode($languageData->keys()) !!},
        {!! json_encode($languageData->values()) !!},
        'Idiomas'
    );
});
</script>
<script>
// Auto-refresh variable
let autoRefreshEnabled = true;
let refreshTimer;

// Simple refresh function - reloads the entire page
function setupAutoRefresh() {
    if (autoRefreshEnabled) {
        refreshTimer = setTimeout(function() {
            // Show loading indicator before refresh
            const loadingOverlay = document.createElement('div');
            loadingOverlay.className = 'loading-overlay';
            loadingOverlay.innerHTML = `
                <div class="loading-spinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Carregant...</span>
                    </div>
                    <div class="mt-2">Actualitzant dades...</div>
                </div>
            `;
            document.body.appendChild(loadingOverlay);
            
            // Add current timestamp to URL to prevent caching
            const timestamp = new Date().getTime();
            const url = new URL(window.location.href);
            url.searchParams.set('t', timestamp);
            
            // Reload the page
            window.location.href = url.toString();
        }, 5000); // 5 seconds
    }
}

// Initial setup
document.addEventListener('DOMContentLoaded', function() {
    // Setup auto-refresh
    setupAutoRefresh();
    
    // Create toggle button
    const toggleBtn = document.createElement('button');
    toggleBtn.className = 'btn btn-sm btn-outline-primary position-fixed';
    toggleBtn.style.bottom = '20px';
    toggleBtn.style.right = '20px';
    toggleBtn.style.zIndex = '1050';
    toggleBtn.innerHTML = '<i class="fas fa-sync-alt"></i> Auto-refresc: Activat';
    
    toggleBtn.onclick = function() {
        autoRefreshEnabled = !autoRefreshEnabled;
        
        if (autoRefreshEnabled) {
            setupAutoRefresh();
            this.innerHTML = '<i class="fas fa-sync-alt"></i> Auto-refresc: Activat';
            this.classList.replace('btn-outline-danger', 'btn-outline-primary');
        } else {
            clearTimeout(refreshTimer);
            this.innerHTML = '<i class="fas fa-sync"></i> Auto-refresc: Desactivat';
            this.classList.replace('btn-outline-primary', 'btn-outline-danger');
        }
    };
    
    document.body.appendChild(toggleBtn);
    
    // Show notification that page was refreshed
    if (performance.navigation.type !== 1) { // Only if not a manual refresh
        const notification = document.createElement('div');
        notification.className = 'update-toast show';
        notification.innerHTML = `
            <div class="update-toast-content">
                <i class="fas fa-sync-alt me-2"></i>
                Dades actualitzades
            </div>
        `;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 2000);
    }
});
</script>

<style>
/* Estilos para la notificación y overlay */
.update-toast {
    position: fixed;
    bottom: -60px;
    left: 50%;
    transform: translateX(-50%);
    background-color: rgba(25, 135, 84, 0.9);
    color: white;
    padding: 10px 20px;
    border-radius: 4px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    z-index: 1060;
    transition: bottom 0.3s ease-in-out;
}

.update-toast.show {
    bottom: 20px;
}

.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.loading-spinner {
    background-color: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    text-align: center;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
@endsection