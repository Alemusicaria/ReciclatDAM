@extends('layouts.app')

@section('content')
    <div class="container-fluid stats-container px-4 mt-5 pt-5">
        <div class="stats-header">
            <h1 class="mt-4">{{ __('messages.admin.stats.navigation_title') }}</h1>
            <p class="text-muted">
                {{ __('messages.admin.stats.analysis_records', ['total' => number_format($totalRecords)]) }}
                @if($totalRecords > $limit)
                    <span class="badge bg-info">{{ __('messages.admin.stats.sample_info', [
                        'limit' => number_format($limit),
                        'percentage' => $samplingPercentage
                    ]) }}</span>
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
                                <div class="text-white-50">{{ __('messages.admin.stats.total_records') }}</div>
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
                                <div class="text-white-50">{{ __('messages.admin.stats.mobile_devices') }}</div>
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
                                <div class="text-white-50">{{ __('messages.admin.stats.desktop_devices') }}</div>
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
                                <div class="text-white-50">{{ __('messages.admin.stats.avg_cpu_cores') }}</div>
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
                        {{ __('messages.admin.stats.operating_systems') }}
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
                        {{ __('messages.admin.stats.browsers') }}
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
                        {{ __('messages.admin.stats.device_types') }}
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
                        {{ __('messages.admin.stats.cookie_support') }}
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
                        {{ __('messages.admin.stats.languages') }}
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
                        {{ __('messages.admin.stats.screen_resolutions') }}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="resolutionTable">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.admin.stats.resolution') }}</th>
                                        <th>{{ __('messages.admin.stats.users') }}</th>
                                        <th>{{ __('messages.admin.stats.percentage') }}</th>
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
                        {{ __('messages.admin.stats.technical_data') }}
                    </div>
                    <div class="card-body">
                        <p>{{ __('messages.admin.stats.technical_help') }}</p>

                        <h5 class="mt-4">{{ __('messages.admin.stats.hardware_capabilities') }}</h5>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('messages.admin.stats.avg_cpu_cores') }}
                                <span class="badge bg-primary rounded-pill">{{ round($avgConcurrency, 1) }}</span>
                            </li>
                        </ul>

                        <h5 class="mt-4">{{ __('messages.admin.stats.compatibility_analysis') }}</h5>
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-lightbulb me-2"></i>
                            {{ __('messages.admin.stats.mobile_optimization_tip', [
                                'count' => $deviceData['Mobile'] ?? 0,
                                'percentage' => round((($deviceData['Mobile'] ?? 0) / $limit) * 100, 1)
                            ]) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="stats-fixed-actions">
            <button class="btn btn-primary mb-2" id="exportDataBtn">
                <i class="fas fa-file-export me-1"></i> {{ __('messages.admin.stats.export_data') }}
            </button>
            <button class="btn btn-primary" id="toggleAutoRefreshBtn">
                <i class="fas fa-sync-alt me-1"></i> {{ __('messages.admin.stats.auto_refresh_on') }}
            </button>
        </div>
    </div>

    <div id="update-notification" class="update-toast">
        <div class="update-toast-content">
            <i class="fas fa-sync-alt me-2"></i>
            {{ __('messages.admin.stats.data_updated') }}
        </div>
    </div>

    <!-- Pasar los datos a JavaScript -->
    <script>
        window.chartData = {
            platformLabels: {!! json_encode($platformData->keys()) !!},
            platformValues: {!! json_encode($platformData->values()) !!},
            browserLabels: {!! json_encode($browserData->keys()) !!},
            browserValues: {!! json_encode($browserData->values()) !!},
            deviceLabels: {!! json_encode($deviceData->keys()) !!},
            deviceValues: {!! json_encode($deviceData->values()) !!},
            languageLabels: {!! json_encode($languageData->keys()) !!},
            languageValues: {!! json_encode($languageData->values()) !!},
            cookiesEnabled: {{ $cookiesEnabled }},
            cookiesDisabled: {{ $cookiesDisabled }},
            resolutionData: {!! json_encode($resolutionData) !!},
            limit: {{ $limit }},
            totalRecords: {{ $totalRecords }},
            avgConcurrency: {{ round($avgConcurrency, 1) }},
            translations: {
                exportingData: "{{ __('messages.admin.stats.exporting_data') }}",
                autoRefreshOn: "{{ __('messages.admin.stats.auto_refresh_on') }}",
                autoRefreshOff: "{{ __('messages.admin.stats.auto_refresh_off') }}",
                operatingSystems: "{{ __('messages.admin.stats.operating_systems') }}",
                browsers: "{{ __('messages.admin.stats.browsers') }}",
                deviceTypes: "{{ __('messages.admin.stats.device_types') }}",
                cookieSupport: "{{ __('messages.admin.stats.cookie_support') }}",
                languages: "{{ __('messages.admin.stats.languages') }}",
                cookiesEnabled: "{{ __('messages.admin.stats.cookies_enabled') }}",
                cookiesDisabled: "{{ __('messages.admin.stats.cookies_disabled') }}"
            }
        };
    </script>
    
    <!-- Cargar Chart.js y nuestro script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="{{ asset('js/navigation-stats.js') }}"></script>
@endsection