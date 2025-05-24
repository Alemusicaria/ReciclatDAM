@extends('layouts.app')

@section('content')
    <div class="container-fluid stats-container px-4 mt-5 pt-5">
        <div class="stats-header">
            <h1 class="mt-4">Estadístiques de Navegació</h1>
            <p class="text-muted">
                Anàlisi de {{ number_format($totalRecords) }} registres.
                @if($totalRecords > $limit)
                    <span class="badge bg-info">Mostra estadística basada en {{ number_format($limit) }} registres
                        ({{ $samplingPercentage }}%)</span>
                @endif
            </p>
        </div>

        <div class="row mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4 stats-card">
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
                <div class="card bg-success text-white mb-4 stats-card">
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
                <div class="card bg-info text-white mb-4 stats-card">
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
                <div class="card bg-warning text-white mb-4 stats-card">
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
                <div class="chart-container card mb-4">
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
                <div class="chart-container card mb-4">
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
                <div class="chart-container card mb-4">
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
                <div class="chart-container card mb-4">
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
                <div class="chart-container card mb-4">
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
                <div class="stats-table card mb-4">
                    <div class="card-header">
                        <i class="fas fa-tv me-1"></i>
                        Resolucions de Pantalla més Comunes
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="resolutionTable">
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
            </div>

            <!-- Metadatos Técnicos -->
            <div class="col-xl-6 col-lg-6">
                <div class="stats-table card mb-4">
                    <div class="card-header">
                        <i class="fas fa-info-circle me-1"></i>
                        Dades Tècniques
                    </div>
                    <div class="card-body">
                        <p>Aquesta informació pot ajudar a entendre millor els dispositius dels teus usuaris i optimitzar la
                            teva aplicació per a ells.</p>

                        <h5 class="mt-4">Hardware i Capacitats</h5>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Mitjana de Nuclis CPU
                                <span class="badge bg-primary rounded-pill">{{ round($avgConcurrency, 1) }}</span>
                            </li>
                        </ul>

                        <h5 class="mt-4">Anàlisi de Compatibilitat</h5>
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-lightbulb me-2"></i>
                            Es recomana optimitzar per a dispositius mòbils, ja que representen
                            {{ $deviceData['Mobile'] ?? 0 }} dels teus usuaris
                            ({{ round((($deviceData['Mobile'] ?? 0) / $limit) * 100, 1) }}%).
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reemplaza el div de stats-actions actual con este -->
        <div class="stats-fixed-actions">
            <button class="btn btn-primary mb-2" id="exportDataBtn">
                <i class="fas fa-file-export me-1"></i> Exportar Dades
            </button>
            <button class="btn btn-primary" id="toggleAutoRefreshBtn">
                <i class="fas fa-sync-alt me-1"></i> Auto-actualització: ON
            </button>
        </div>
    </div>

    <div id="update-notification" class="update-toast">
        <div class="update-toast-content">
            <i class="fas fa-sync-alt me-2"></i>
            Dades actualitzades
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Configuración de colores
            const colorPalette = [
                '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                '#5a5c69', '#6f42c1', '#fd7e14', '#20c997', '#6610f2'
            ];

            // Detectar modo oscuro para ajustar colores
            const isDarkMode = document.body.classList.contains('dark');
            const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
            const textColor = isDarkMode ? '#f7fafc' : '#2d3748';

            // Configuración común para gráficos
            Chart.defaults.color = textColor;
            Chart.defaults.borderColor = gridColor;

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

                                // Configurar el botón de exportación
                    document.getElementById('exportDataBtn').addEventListener('click', function() {
                        // Crear contenido del CSV
                        let csvContent = "data:text/csv;charset=utf-8,";
                        
                        // Añadir encabezado
                        csvContent += "Categoría,Elemento,Cantidad,Porcentaje\n";
                        
                        // Añadir datos de plataformas
                        const platformLabels = {!! json_encode($platformData->keys()) !!};
                        const platformValues = {!! json_encode($platformData->values()) !!};
                        platformLabels.forEach((label, i) => {
                            const percentage = ((platformValues[i] / {{ $limit }}) * 100).toFixed(1);
                            csvContent += `Sistemas Operativos,${label},${platformValues[i]},${percentage}%\n`;
                        });
                        
                        // Añadir datos de navegadores
                        const browserLabels = {!! json_encode($browserData->keys()) !!};
                        const browserValues = {!! json_encode($browserData->values()) !!};
                        browserLabels.forEach((label, i) => {
                            const percentage = ((browserValues[i] / {{ $limit }}) * 100).toFixed(1);
                            csvContent += `Navegadores,${label},${browserValues[i]},${percentage}%\n`;
                        });
                        
                        // Añadir datos de dispositivos
                        const deviceLabels = {!! json_encode($deviceData->keys()) !!};
                        const deviceValues = {!! json_encode($deviceData->values()) !!};
                        deviceLabels.forEach((label, i) => {
                            const percentage = ((deviceValues[i] / {{ $limit }}) * 100).toFixed(1);
                            csvContent += `Dispositivos,${label},${deviceValues[i]},${percentage}%\n`;
                        });
                        
                        // Añadir datos de resoluciones
                        const resolutions = {!! json_encode($resolutionData) !!};
                        Object.entries(resolutions).forEach(([resolution, count]) => {
                            const percentage = ((count / {{ $limit }}) * 100).toFixed(1);
                            csvContent += `Resoluciones,${resolution},${count},${percentage}%\n`;
                        });
                        
                        // Añadir datos de idiomas
                        const languageLabels = {!! json_encode($languageData->keys()) !!};
                        const languageValues = {!! json_encode($languageData->values()) !!};
                        languageLabels.forEach((label, i) => {
                            const percentage = ((languageValues[i] / {{ $limit }}) * 100).toFixed(1);
                            csvContent += `Idiomas,${label},${languageValues[i]},${percentage}%\n`;
                        });
                        
                        // Añadir datos de cookies - CORREGIR AQUÍ
                        // Primero crear variables JavaScript para almacenar los valores de PHP
                        const cookiesEnabled = {{ $cookiesEnabled }};
                        const cookiesDisabled = {{ $cookiesDisabled }};
                        const totalRecords = {{ $totalRecords }};
                        
                        const cookiesEnabledPerc = ((cookiesEnabled / totalRecords) * 100).toFixed(1);
                        const cookiesDisabledPerc = ((cookiesDisabled / totalRecords) * 100).toFixed(1);
                        
                        csvContent += `Cookies,Habilitadas,${cookiesEnabled},${cookiesEnabledPerc}%\n`;
                        csvContent += `Cookies,Deshabilitadas,${cookiesDisabled},${cookiesDisabledPerc}%\n`;
                        
                        // Añadir datos técnicos
                        const avgConcurrency = {{ round($avgConcurrency, 1) }};
                        csvContent += `Datos Técnicos,Promedio Núcleos CPU,${avgConcurrency},N/A\n`;
                        csvContent += `Datos Técnicos,Total Registros,${totalRecords},100%\n`;
                        
                        // Añadir metadatos
                        const timestamp = new Date().toISOString().replace(/[:.]/g, '-');
                        csvContent += `\nInforme generado el,${new Date().toLocaleString()}\n`;
                        
                        // Crear el enlace para la descarga
                        const encodedUri = encodeURI(csvContent);
                        const link = document.createElement("a");
                        link.setAttribute("href", encodedUri);
                        link.setAttribute("download", `estadistiques-navegacio-${timestamp}.csv`);
                        document.body.appendChild(link); // Necesario para Firefox
                        
                        // Mostrar notificación
                        const toast = document.getElementById('update-notification');
                        toast.innerHTML = '<div class="update-toast-content"><i class="fas fa-file-download me-2"></i>Descarregant dades...</div>';
                        toast.classList.add('show');
                        
                        // Hacer clic en el enlace
                        link.click();
                        
                        // Eliminar el enlace
                        setTimeout(() => {
                            document.body.removeChild(link);
                            
                            // Ocultar la notificación después de 2 segundos
                            setTimeout(() => {
                                toast.classList.remove('show');
                            }, 2000);
                        }, 100);
                    });

            // Configurar el toggle de auto-refresh
            let refreshInterval;
            const toggleBtn = document.getElementById('toggleAutoRefreshBtn');

            function startAutoRefresh() {
                refreshInterval = setInterval(function () {
                    // Mostrar indicador de carga durante la recarga
                    const toast = document.getElementById('update-notification');
                    toast.classList.add('show');

                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }, 10000); // Actualizar cada 10 segundos
            }

            // Establecer estado y estilo inicial
            startAutoRefresh();
            toggleBtn.innerHTML = '<i class="fas fa-sync-alt"></i> Auto-actualització: ON';
            toggleBtn.classList.add('btn-primary');
            toggleBtn.classList.remove('btn-danger');
            // Usar el toggleBtn directamente, no this
            toggleBtn.style.backgroundColor = '#0069d9';

            toggleBtn.addEventListener('click', function () {
                if (refreshInterval) {
                    clearInterval(refreshInterval);
                    refreshInterval = null;
                    this.innerHTML = '<i class="fas fa-sync"></i> Auto-actualització: OFF';
                    this.classList.remove('btn-primary');
                    this.classList.add('btn-danger');
                    this.style.backgroundColor = '#dc3545';
                } else {
                    startAutoRefresh();
                    this.innerHTML = '<i class="fas fa-sync-alt"></i> Auto-actualització: ON';
                    this.classList.remove('btn-danger');
                    this.classList.add('btn-primary');
                    this.style.backgroundColor = '#0069d9';
                }
            });
        });
    </script>
@endsection