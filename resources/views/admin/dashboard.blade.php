@extends('layouts.app')

@section('content')
    <div class="admin-dashboard py-4">
        <div class="container-fluid" style="margin-top: 13vh;">
            <!-- Sección 1: Encabezado -->
            <div class="header-card mb-4">
                <div class="row g-0 align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center">
                            <div class="header-icon-container me-3" style="margin-right: 20px;">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            <div>
                                <h1 class="admin-title mb-1">Panell d'Administració</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <div class="admin-date-container">
                            <div class="date-item">
                                <span class="date-label"><i class="far fa-calendar-alt me-1"></i> Data d'entrada:</span>
                                <span class="date-value">{{ now()->setTimezone('Europe/Madrid')->format('d M, Y') }}</span>
                            </div>
                            <div class="date-item">
                                <span class="date-label"><i class="far fa-clock me-1"></i> Hora d'entrada:</span>
                                <span class="date-value">{{ now()->setTimezone('Europe/Madrid')->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección 2: Métricas Principales -->
            <div class="section-header mb-3">
                <h2 class="section-title"><i class="fas fa-chart-pie me-2"></i>Mètriques Principals</h2>
                <hr class="section-divider">
            </div>

            <div class="row stats-cards mb-4">
                <!-- Tarjetas de usuarios, eventos, premios y códigos -->
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="stat-card users cursor-pointer" data-bs-toggle="modal" data-bs-target="#dynamicModal"
                        data-content-type="users">
                        <div class="stat-card-body">
                            <div class="stat-card-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-card-info">
                                <h3 class="stat-card-number">{{ $totalUsers }}</h3>
                                <p class="stat-card-title">Usuaris</p>
                                <div class="stat-card-percent">
                                    <i
                                        class="fas {{ $newUsersPercent > 0 ? 'fa-arrow-up text-success' : 'fa-arrow-down text-danger' }}"></i>
                                    <span>{{ $newUsersPercent }}%</span> des del mes anterior
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="stat-card events cursor-pointer" data-bs-toggle="modal" data-bs-target="#dynamicModal"
                        data-content-type="events">
                        <div class="stat-card-body">
                            <div class="stat-card-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="stat-card-info">
                                <h3 class="stat-card-number">{{ $totalEvents }}</h3>
                                <p class="stat-card-title">Events</p>
                                <div class="stat-card-badge">
                                    <span class="badge">{{ $activeEvents }} actius</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="stat-card prizes cursor-pointer" data-bs-toggle="modal" data-bs-target="#dynamicModal"
                        data-content-type="premis">
                        <div class="stat-card-body">
                            <div class="stat-card-icon">
                                <i class="fas fa-gift"></i>
                            </div>
                            <div class="stat-card-info">
                                <h3 class="stat-card-number">{{ $totalPremis }}</h3>
                                <p class="stat-card-title">Premis</p>
                                <div class="stat-card-badge">
                                    <span class="badge">{{ $pendingRewards }} pendents</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="stat-card codes cursor-pointer" data-bs-toggle="modal" data-bs-target="#dynamicModal"
                        data-content-type="codis">
                        <div class="stat-card-body">
                            <div class="stat-card-icon">
                                <i class="fas fa-recycle"></i>
                            </div>
                            <div class="stat-card-info">
                                <h3 class="stat-card-number">{{ $totalCodis }}</h3>
                                <p class="stat-card-title">Codis</p>
                                <div class="stat-card-percent">
                                    <i
                                        class="fas {{ $newCodisPercent > 0 ? 'fa-arrow-up text-success' : 'fa-arrow-down text-danger' }}"></i>
                                    <span>{{ $newCodisPercent }}%</span> des del mes anterior
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección 3: Análisis y Gráficos -->
            <div class="section-header mb-3">
                <h2 class="section-title"><i class="fas fa-chart-line me-2"></i>Anàlisi i Gràfics</h2>
                <hr class="section-divider">
            </div>

            <div class="row charts-row mb-4">
                <!-- Gràfic d'activitat -->
                <div class="col-xl-8 col-lg-7 mb-4">
                    <div class="chart-card h-100">
                        <div class="chart-card-header">
                            <h4 class="chart-card-title">Activitat Usuaris</h4>
                            <div class="chart-card-actions">
                                <select class="form-select form-select-sm" id="activityPeriodSelect">
                                    <option selected>Últims 6 mesos</option>
                                    <option>Últim any</option>
                                    <option>Aquest any</option>
                                </select>
                            </div>
                        </div>
                        <div class="chart-card-body">
                            <canvas id="activityChart" height="300"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-5 mb-4">
                    <div class="chart-card h-100">
                        <div class="chart-card-header">
                            <h4 class="chart-card-title">Distribució Punts</h4>
                        </div>
                        <div class="chart-card-body">
                            <div class="points-distribution-container">
                                <div class="chart-container">
                                    <canvas id="distributionChart" height="200"></canvas>
                                </div>
                                <div class="chart-legend">
                                    <div class="chart-legend-item">
                                        <span class="legend-color" style="background-color: rgba(54, 162, 235, 0.8)"></span>
                                        <span class="legend-text">Punts Actius: {{ $totalActivePoints }}</span>
                                    </div>
                                    <div class="chart-legend-item">
                                        <span class="legend-color" style="background-color: rgba(255, 99, 132, 0.8)"></span>
                                        <span class="legend-text">Punts Gastats: {{ $totalSpentPoints }}</span>
                                    </div>
                                    <div class="chart-legend-item">
                                        <span class="legend-color" style="background-color: rgba(75, 192, 192, 0.8)"></span>
                                        <span class="legend-text">Punts per Events: {{ $totalEventPoints }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección 4: Gestión del Sistema -->
            <div class="section-header mb-3">
                <h2 class="section-title"><i class="fas fa-cogs me-2"></i>Gestió del Sistema</h2>
                <hr class="section-divider">
            </div>

            <div class="row stats-cards mb-4">
                <!-- Tarjetas de administración -->
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="stat-card products cursor-pointer" data-bs-toggle="modal" data-bs-target="#dynamicModal"
                        data-content-type="productes">
                        <div class="stat-card-body">
                            <div class="stat-card-icon">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="stat-card-info">
                                <h3 class="stat-card-number">{{ \App\Models\Producte::count() }}</h3>
                                <p class="stat-card-title">Productes</p>
                                <div class="stat-card-badge">
                                    <span class="badge">Gestió de productes</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="stat-card recycling-points cursor-pointer" data-bs-toggle="modal"
                        data-bs-target="#dynamicModal" data-content-type="punt-reciclatge">
                        <div class="stat-card-body">
                            <div class="stat-card-icon">
                                <i class="fas fa-dumpster"></i>
                            </div>
                            <div class="stat-card-info">
                                <h3 class="stat-card-number">{{ \App\Models\PuntDeRecollida::count() }}</h3>
                                <p class="stat-card-title">Punts de Recollida</p>
                                <div class="stat-card-badge">
                                    <span class="badge">
                                        {{ \App\Models\PuntDeRecollida::where('disponible', 1)->count() }} disponibles
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="stat-card roles cursor-pointer" data-bs-toggle="modal" data-bs-target="#dynamicModal"
                        data-content-type="rols">
                        <div class="stat-card-body">
                            <div class="stat-card-icon">
                                <i class="fas fa-user-tag"></i>
                            </div>
                            <div class="stat-card-info">
                                <h3 class="stat-card-number">{{ \App\Models\Rol::count() }}</h3>
                                <p class="stat-card-title">Rols</p>
                                <div class="stat-card-badge">
                                    <span class="badge">
                                        Gestió de rols i permisos
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="stat-card alerts cursor-pointer" data-bs-toggle="modal" data-bs-target="#dynamicModal"
                        data-content-type="tipus-alertes">
                        <div class="stat-card-body">
                            <div class="stat-card-icon">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div class="stat-card-info">
                                <h3 class="stat-card-number">{{ \App\Models\TipusAlerta::count() }}</h3>
                                <p class="stat-card-title">Tipus d'Alertes</p>
                                <div class="stat-card-badge">
                                    <span class="badge">
                                        Gestió d'alertes
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row stats-cards mb-4">
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="stat-card collection-alerts cursor-pointer" data-bs-toggle="modal"
                        data-bs-target="#dynamicModal" data-content-type="alertes-punts">
                        <div class="stat-card-body">
                            <div class="stat-card-icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="stat-card-info">
                                <h3 class="stat-card-number">{{ \App\Models\AlertaPuntDeRecollida::count() }}</h3>
                                <p class="stat-card-title">Alertes Punts</p>
                                <div class="stat-card-badge">
                                    <span class="badge">
                                        {{ \App\Models\AlertaPuntDeRecollida::where('created_at', '>=', \Carbon\Carbon::now()->subDays(7))->count() }}
                                        noves aquesta setmana
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="stat-card event-types cursor-pointer" data-bs-toggle="modal" data-bs-target="#dynamicModal"
                        data-content-type="tipus-events">
                        <div class="stat-card-body">
                            <div class="stat-card-icon">
                                <i class="fas fa-tags"></i>
                            </div>
                            <div class="stat-card-info">
                                <h3 class="stat-card-number">{{ \App\Models\TipusEvent::count() }}</h3>
                                <p class="stat-card-title">Tipus d'Events</p>
                                <div class="stat-card-badge">
                                    <span class="badge">
                                        Gestió de categories
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="stat-card opinions cursor-pointer" data-bs-toggle="modal" data-bs-target="#dynamicModal"
                        data-content-type="opinions">
                        <div class="stat-card-body">
                            <div class="stat-card-icon">
                                <i class="fas fa-comment-dots"></i>
                            </div>
                            <div class="stat-card-info">
                                <h3 class="stat-card-number">{{ \App\Models\Opinions::count() }}</h3>
                                <p class="stat-card-title">Opinions</p>
                                <div class="stat-card-badge">
                                    <span class="badge">
                                        {{ \App\Models\Opinions::where('created_at', '>=', \Carbon\Carbon::now()->subDays(30))->count() }}
                                        noves aquest mes
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="stat-card claimed-prizes cursor-pointer" data-bs-toggle="modal"
                        data-bs-target="#dynamicModal" data-content-type="premis-reclamats">
                        <div class="stat-card-body">
                            <div class="stat-card-icon">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div class="stat-card-info">
                                <h3 class="stat-card-number">{{ \App\Models\PremiReclamat::count() }}</h3>
                                <p class="stat-card-title">Premis Reclamats</p>
                                <div class="stat-card-badge">
                                    <span class="badge">
                                        {{ \App\Models\PremiReclamat::where('estat', 'pendent')->count() }} pendents
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección 5: Estadísticas Avanzadas -->
            <div class="section-header mb-3">
                <h2 class="section-title"><i class="fas fa-chart-bar me-2"></i>Estadístiques Avançades</h2>
                <hr class="section-divider">
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <a href="{{ route('admin.navigator-stats') }}" class="stat-card-link">
                        <div class="stat-card advanced-stats">
                            <div class="stat-card-body">
                                <div class="stat-card-icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <div class="stat-card-info">
                                    <h3 class="stat-card-number">Estadístiques de Navegació</h3>
                                    <p class="stat-card-title">Anàlisi de dispositius i comportament dels usuaris</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Sección 6: Actividad y Ranking -->
            <div class="section-header mb-3">
                <h2 class="section-title"><i class="fas fa-history me-2"></i>Activitat i Rànking</h2>
                <hr class="section-divider">
            </div>

            <div class="row content-row mb-4">
                <!-- Activitat recent -->
                <div class="col-xl-8 col-lg-7 mb-4">
                    <div class="content-card h-100">
                        <div class="content-card-header">
                            <h4 class="content-card-title">
                                <i class="fas fa-history me-2"></i>Activitat Recent
                            </h4>
                            <a href="#" class="btn-sm btn-view-all" id="viewAllActivitiesBtn">Veure Tot</a>
                        </div>
                        <div class="content-card-body p-0">
                            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                <table class="table table-activity">
                                    <thead>
                                        <tr>
                                            <th>Usuari</th>
                                            <th>Acció</th>
                                            <th>Data</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentActivities as $activity)
                                                                        <tr>
                                                                            <td>
                                                                                <div class="activity-user">
                                                                                    <img src="{{ ($activity->user && $activity->user->foto_perfil) ?
                                            (Str::startsWith($activity->user->foto_perfil, ['http://', 'https://']) ?
                                                $activity->user->foto_perfil :
                                                (file_exists(public_path('storage/' . $activity->user->foto_perfil)) ?
                                                    asset('storage/' . $activity->user->foto_perfil) :
                                                    asset('images/default-profile.png')
                                                )
                                            ) :
                                            asset('images/default-profile.png') 
                                                                                                                                                                                                                                                                            }}"
                                                                                        alt="Foto perfil" class="activity-avatar">

                                                                                    <div class="activity-user-info">
                                                                                        <h6 class="activity-user-name">
                                                                                            {{ $activity->user->nom ?? 'Usuari' }}
                                                                                            {{ $activity->user->cognoms ?? '' }}
                                                                                        </h6>
                                                                                        <span
                                                                                            class="activity-user-email">{{ $activity->user->email ?? 'sense email' }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>{{ $activity->action }}</td>
                                                                            <td>{{ $activity->created_at->format('d/m/Y H:i') }}</td>
                                                                            <td>
                                                                                <button class="btn-icon view-activity-details" data-detail-type="activitat"
                                                                                    data-detail-id="{{ $activity->id }}"
                                                                                    title="{{ __('messages.admin.common.view_details') }}">
                                                                                    <i class="fas fa-eye"></i>
                                                                                </button>
                                                                            </td>

                                                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4">
                                                    <div class="empty-state">
                                                        <i class="fas fa-history fa-3x mb-3"></i>
                                                        <p>No hi ha activitat recent</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top usuaris -->
                <div class="col-xl-4 col-lg-5 mb-4">
                    <div class="content-card h-100">
                        <div class="content-card-header">
                            <h4 class="content-card-title">
                                <i class="fas fa-trophy me-2"></i>Millors Usuaris
                            </h4>
                            <a href="#" class="btn-sm btn-view-all" id="viewAllUsersBtn">Veure Tot</a>
                        </div>
                        <div class="content-card-body p-0">
                            <ul class="user-ranking-list">
                                @forelse($topUsers->take(6) as $key => $user)
                                                        <?php    $nivellInfo = $user->nivell(); ?>
                                                        <li class="user-ranking-item">
                                                            <div class="ranking-position {{ $key < 3 ? 'top-' . ($key + 1) : '' }}">{{ $key + 1 }}
                                                            </div>
                                                            <div class="ranking-user">
                                                                <img src="{{ $user->foto_perfil ?
                                    (Str::startsWith($user->foto_perfil, ['http://', 'https://']) ?
                                        $user->foto_perfil :
                                        (file_exists(public_path('storage/' . $user->foto_perfil)) ?
                                            asset('storage/' . $user->foto_perfil) :
                                            asset('images/default-profile.png')
                                        )
                                    ) :
                                    asset('images/default-profile.png') 
                                                                                                                                                                                                                }}"
                                                                    alt="Foto perfil" class="ranking-avatar">
                                                                <div class="ranking-user-info">
                                                                    <h6 class="ranking-user-name">{{ $user->nom }} {{ $user->cognoms }}</h6>
                                                                    <span
                                                                        class="ranking-user-level">{{ $nivellInfo ? $nivellInfo->nom : 'Usuari' }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="ranking-points">
                                                                <span class="badge-points">{{ $user->punts_actuals }} pts</span>
                                                            </div>
                                                        </li>
                                @empty
                                    <li class="user-ranking-item empty-item">
                                        <div class="empty-state">
                                            <i class="fas fa-users fa-3x mb-3"></i>
                                            <p>No hi ha usuaris per mostrar</p>
                                        </div>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Al final del dashboard pero antes de los scripts, añade este modal genérico -->
    <div class="modal fade" id="dynamicModal" tabindex="-1" aria-labelledby="dynamicModalLabel" aria-hidden="true"
        data-bs-backdrop="true" data-bs-keyboard="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dynamicModalLabel">Cargando ...</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center py-5" id="modal-loader">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="mt-2">Cargando contenido...</p>
                    </div>
                    <div id="dynamic-content" class="d-none"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para detalles -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true"
        data-bs-backdrop="true" data-bs-keyboard="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detalls</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center py-3" id="detail-modal-loader">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="mt-2">Carregant informació...</p>
                    </div>
                    <div id="detail-content" class="d-none">
                        <!-- El contenido se cargará dinámicamente aquí -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary d-none" id="toggleEditBtn">Editar</button>
                    <button type="button" class="btn btn-success d-none" id="saveChangesBtn">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mini modal de confirmación para eliminar -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Confirmar eliminació</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="confirmDeleteText">Estàs segur que vols eliminar aquest element?</p>
                    <input type="hidden" id="deleteItemId">
                    <input type="hidden" id="deleteItemType">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel·lar</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash me-1"></i> Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Cargar la biblioteca de gráficos ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.35.3/dist/apexcharts.min.js"></script>
    <script>
        // Script para el gráfico de usuarios por niveles
        document.addEventListener('DOMContentLoaded', function () {
            // Datos para el gráfico (necesitas añadir estos datos en tu controlador)
            const usersLevelData = {
                labels: {!! json_encode($usersByLevel ? array_keys($usersByLevel->toArray()) : []) !!},
                data: {!! json_encode($usersByLevel ? array_values($usersByLevel->toArray()) : []) !!},
                backgroundColor: [
                    '#4CAF50', '#2196F3', '#FF9800', '#F44336',
                    '#9C27B0', '#673AB7', '#3F51B5', '#009688'
                ]
            };

            // Crear el gráfico
            const usersLevelCtx = document.getElementById('usersLevelChart');
            if (usersLevelCtx) {
                new Chart(usersLevelCtx, {
                    type: 'doughnut',
                    data: {
                        labels: usersLevelData.labels,
                        datasets: [{
                            data: usersLevelData.data,
                            backgroundColor: usersLevelData.backgroundColor,
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        let label = context.label || '';
                                        let value = context.raw || 0;
                                        let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        let percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // =======================================
            // SISTEMA UNIFICADO: GRÁFICOS, MODALES Y COMPONENTES DINÁMICOS
            // =======================================

            // -----------------------------------------
            // 1. INICIALIZACIÓN Y CONFIGURACIÓN DE GRÁFICOS
            // -----------------------------------------

            // Detectar modo oscuro/claro
            const isDarkMode = document.body.classList.contains('dark');
            const textColor = isDarkMode ? '#f7fafc' : '#2d3748';
            const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';

            // Configuración global de Chart.js
            Chart.defaults.color = textColor;
            Chart.defaults.borderColor = gridColor;

            // Gráfico de actividad
            const activityChart = new Chart(
                document.getElementById('activityChart').getContext('2d'),
                {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($activityChartLabels) !!},
                        datasets: [
                            {
                                label: 'Usuaris Nous',
                                data: {!! json_encode($newUsersData) !!},
                                borderColor: '#3182ce',
                                backgroundColor: 'rgba(49, 130, 206, 0.1)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Codis Escanejats',
                                data: {!! json_encode($codisScannedData) !!},
                                borderColor: '#38a169',
                                backgroundColor: 'rgba(56, 161, 105, 0.1)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Premis Reclamats',
                                data: {!! json_encode($premisClaimedData) !!},
                                borderColor: '#d69e2e',
                                backgroundColor: 'rgba(214, 158, 46, 0.1)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: true
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                backgroundColor: isDarkMode ? '#4a5568' : 'white',
                                titleColor: isDarkMode ? '#fff' : '#2d3748',
                                bodyColor: isDarkMode ? '#e2e8f0' : '#4a5568',
                                borderColor: isDarkMode ? '#718096' : '#e2e8f0',
                                borderWidth: 1,
                                padding: 12,
                                boxPadding: 6,
                                usePointStyle: true,
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: gridColor
                                },
                                ticks: {
                                    color: textColor
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: textColor
                                }
                            }
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        }
                    }
                }
            );

            // Gráfico de distribución
            const distributionChart = new Chart(
                document.getElementById('distributionChart').getContext('2d'),
                {
                    type: 'doughnut',
                    data: {
                        labels: ['Punts Actius', 'Punts Gastats', 'Punts per Events'],
                        datasets: [{
                            data: [{{ $totalActivePoints }}, {{ $totalSpentPoints }}, {{ $totalEventPoints }}],
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(255, 99, 132, 0.8)',
                                'rgba(75, 192, 192, 0.8)'
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 99, 132, 1)',
                                'rgba(75, 192, 192, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: isDarkMode ? '#4a5568' : 'white',
                                titleColor: isDarkMode ? '#fff' : '#2d3748',
                                bodyColor: isDarkMode ? '#e2e8f0' : '#4a5568',
                                borderColor: isDarkMode ? '#718096' : '#e2e8f0',
                                borderWidth: 1,
                                padding: 12,
                                boxPadding: 6,
                                usePointStyle: true,
                            }
                        },
                        cutout: '70%'
                    }
                }
            );

            // Actualizar gráficos cuando cambia el tema
            document.getElementById('theme-toggle')?.addEventListener('click', function () {
                setTimeout(() => {
                    const isDarkMode = document.body.classList.contains('dark');
                    const textColor = isDarkMode ? '#f7fafc' : '#2d3748';
                    const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';

                    // Actualizar defaults
                    Chart.defaults.color = textColor;
                    Chart.defaults.borderColor = gridColor;

                    // Actualizar colores en los gráficos
                    [activityChart, distributionChart].forEach(chart => {
                        if (chart.options.scales) {
                            for (const key in chart.options.scales) {
                                if (chart.options.scales[key].grid) {
                                    chart.options.scales[key].grid.color = gridColor;
                                }
                                if (chart.options.scales[key].ticks) {
                                    chart.options.scales[key].ticks.color = textColor;
                                }
                            }
                        }

                        // Actualizar tooltips
                        if (chart.options.plugins && chart.options.plugins.tooltip) {
                            chart.options.plugins.tooltip.backgroundColor = isDarkMode ? '#4a5568' : 'white';
                            chart.options.plugins.tooltip.titleColor = isDarkMode ? '#fff' : '#2d3748';
                            chart.options.plugins.tooltip.bodyColor = isDarkMode ? '#e2e8f0' : '#4a5568';
                            chart.options.plugins.tooltip.borderColor = isDarkMode ? '#718096' : '#e2e8f0';
                        }

                        chart.update();
                    });
                }, 200);
            });

            // -----------------------------------------
            // 2. SISTEMA UNIFICADO DE GESTIÓN DE MODALES
            // -----------------------------------------

            const modalSystem = {
                // Estado compartido
                activeModals: 0,
                modalInstances: {},

                // Inicialización del sistema
                init: function () {
                    this.setupDynamicModal();
                    this.setupDetailModal();
                    this.setupGlobalListeners();

                    // Exponer función global para inicializar componentes dinámicos
                    window.initDynamicComponents = this.initDynamicComponents.bind(this);

                },

                // -----------------------------------------
                // 2.1 MODAL DINÁMICO (PRINCIPAL)
                // -----------------------------------------

                setupDynamicModal: function () {
                    const self = this;
                    const dynamicModal = document.getElementById('dynamicModal');

                    if (!dynamicModal) return;

                    // Referencias a elementos del modal
                    const modalTitle = dynamicModal.querySelector('.modal-title');
                    const modalLoader = dynamicModal.querySelector('#modal-loader');
                    const dynamicContent = dynamicModal.querySelector('#dynamic-content');

                    document.querySelectorAll('.stat-card').forEach(card => {
                        card.addEventListener('click', function () {
                            // Solo permitir clic si no hay modal abierto
                            if (document.querySelector('.modal.show')) {
                                console.log('Ya hay un modal abierto, ignorando clic');
                                return;
                            }

                            const contentType = this.getAttribute('data-content-type');

                            // Quitar clases específicas de tipo anteriores
                            dynamicModal.className = dynamicModal.className.replace(/modal-\w+/g, '');

                            // Añadir clase específica según el tipo
                            if (contentType) {
                                dynamicModal.classList.add(`modal-${contentType}`);
                            }
                        });
                    });

                    // Cuando se va a mostrar el modal
                    dynamicModal.addEventListener('show.bs.modal', function (event) {
                        // Obtener el botón que activó el modal
                        const button = event.relatedTarget;

                        // No continuar si no hay botón (por ejemplo, si se abrió programáticamente)
                        if (!button) return;

                        // Extraer el tipo de contenido del botón
                        const contentType = button.getAttribute('data-content-type');

                        // Reiniciar contenido
                        dynamicContent.classList.add('d-none');
                        modalLoader.classList.remove('d-none');

                        // Establecer título según el tipo
                        switch (contentType) {
                            case 'users': modalTitle.textContent = 'Gestió d\'Usuaris'; break;
                            case 'events': modalTitle.textContent = 'Gestió d\'Events'; break;
                            case 'premis': modalTitle.textContent = 'Gestió de Premis'; break;
                            case 'premis-pendents': modalTitle.textContent = 'Premis Pendents'; break;
                            default: modalTitle.textContent = 'Contingut'; break;
                        }

                        // Cargar contenido via AJAX
                        fetch(`/admin/modal-content/${contentType}`)
                            .then(response => {
                                if (!response.ok) throw new Error('Error en la respuesta del servidor');
                                return response.text();
                            })
                            .then(html => {
                                // Ocultar cargador y mostrar contenido
                                modalLoader.classList.add('d-none');
                                dynamicContent.innerHTML = html;
                                dynamicContent.classList.remove('d-none');

                                // Inicializar componentes dinámicos
                                self.initDynamicComponents();
                            })
                            .catch(error => {
                                console.error('Error cargando contenido:', error);
                                dynamicContent.innerHTML = `
                                                                                                                <div class="alert alert-danger">
                                                                                                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                                                                                                    Error cargando el contenido: ${error.message}
                                                                                                                </div>
                                                                                                            `;
                                modalLoader.classList.add('d-none');
                                dynamicContent.classList.remove('d-none');
                            });
                    });

                    // Cuando se ha mostrado completamente el modal
                    dynamicModal.addEventListener('shown.bs.modal', function () {
                        self.activeModals++;
                        console.log('Modal dinámico mostrado, activos:', self.activeModals);
                        self.cleanupExtraBackdrops();
                    });

                    // Para el modal dinámico
                    dynamicModal.addEventListener('hidden.bs.modal', function () {
                        // Limpiar contenido
                        this.querySelector('#dynamic-content').innerHTML = '';

                        // Restaurar overflow del body
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';
                        document.body.classList.remove('modal-open');
                    });
                },

                // -----------------------------------------
                // 2.2 MODAL DE DETALLES (SECUNDARIO)
                // -----------------------------------------

                // Busca esta función en tu archivo dashboard.blade.php
                setupDetailModal: function () {
                    const self = this;
                    const detailModal = document.getElementById('detailModal');
                    if (!detailModal) return;

                    // Referencias a elementos del modal
                    const modalTitle = document.getElementById('detailModalLabel');
                    const modalLoader = document.getElementById('detail-modal-loader');
                    const detailContent = document.getElementById('detail-content');
                    const toggleEditBtn = document.getElementById('toggleEditBtn');
                    const saveChangesBtn = document.getElementById('saveChangesBtn');

                    detailModal.addEventListener('show.bs.modal', function (event) {
                        // Obtener el botón que activó el modal
                        const button = event.relatedTarget;
                        if (!button) return;

                        // Extraer los atributos data del botón
                        const type = button.getAttribute('data-detail-type');
                        const id = button.getAttribute('data-detail-id');
                        const title = button.getAttribute('data-detail-title') || 'Detalls';

                        console.log('Abriendo modal con tipo:', type, 'id:', id, 'título:', title);
                        // Configurar el título correctamente
                        modalTitle.textContent = title;

                        // Ocultar botones de edición para create-user
                        if (type === 'create-user') {
                            toggleEditBtn.classList.add('d-none');
                            saveChangesBtn.classList.add('d-none');
                        } else {
                            const editable = button.getAttribute('data-detail-editable') === 'true';
                            toggleEditBtn.classList.toggle('d-none', !editable);
                            saveChangesBtn.classList.add('d-none');
                        }
                    });


                    // Para el modal de detalles
                    detailModal.addEventListener('hidden.bs.modal', function () {
                        // Limpiar contenido
                        document.getElementById('detail-content').innerHTML = '';

                        // Restaurar botones
                        const toggleEditBtn = document.getElementById('toggleEditBtn');
                        const saveChangesBtn = document.getElementById('saveChangesBtn');
                        if (toggleEditBtn) toggleEditBtn.classList.add('d-none');
                        if (saveChangesBtn) saveChangesBtn.classList.add('d-none');

                        // Restaurar overflow del body
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';
                        document.body.classList.remove('modal-open');
                    });

                    document.addEventListener('click', function (e) {
                        const btn = e.target.closest('[data-detail-type]');
                        if (!btn) return;

                        e.preventDefault();
                        e.stopPropagation();

                        // Obtener datos del botón
                        const type = btn.getAttribute('data-detail-type');
                        const id = btn.getAttribute('data-detail-id') || '';  // Puede ser undefined/null para create-user
                        const title = btn.getAttribute('data-detail-title') || 'Detalls';
                        const editable = btn.getAttribute('data-detail-editable') === 'true';

                        console.log('Cargando modal tipo:', type, 'id:', id, 'título:', title);

                        // Configurar modal
                        modalTitle.textContent = title;
                        if (toggleEditBtn) toggleEditBtn.classList.toggle('d-none', !editable);
                        if (saveChangesBtn) saveChangesBtn.classList.add('d-none');

                        // Mostrar loader, ocultar contenido
                        modalLoader.classList.remove('d-none');
                        detailContent.classList.add('d-none');

                        // Mostrar modal
                        const detailsModal = new bootstrap.Modal(detailModal);
                        detailsModal.show();

                        // Cargar contenido
                        // Cargar contenido según el tipo
                        let url;
                        if (type === 'create-user') {
                            url = '/admin/create-form/user'; // Usa la ruta para crear usuarios
                        } else if (type === 'create-form') {
                            const param = btn.getAttribute('data-detail-param');
                            url = `/admin/create-form/${param}`; // Usa la ruta para formularios generales
                        } else {
                            url = `/admin/detail/${type}/${id}`; // Ruta normal para detalles
                        }

                        console.log('Cargando URL:', url);

                        fetch(url).then(response => {
                            console.log('Respuesta del servidor:', response.status);
                            if (!response.ok) throw new Error('Error al cargar los detalles');
                            return response.text();
                        })
                            .then(html => {
                                console.log('Contenido HTML recibido');
                                // Ocultar loader, mostrar contenido
                                modalLoader.classList.add('d-none');
                                detailContent.innerHTML = html;
                                detailContent.classList.remove('d-none');
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                modalLoader.classList.add('d-none');
                                detailContent.innerHTML = `
                                                                                                                <div class="alert alert-danger">
                                                                                                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                                                                                                    Error al cargar los detalles: ${error.message}
                                                                                                                </div>
                                                                                                            `;
                                detailContent.classList.remove('d-none');
                            });
                    });
                },

                // -----------------------------------------
                // 2.3 COMPONENTES DINÁMICOS Y EDICIÓN
                // -----------------------------------------

                // Inicializar componentes dinámicos
                initDynamicComponents: function () {
                    // Inicializar DataTables
                    if (typeof $.fn !== 'undefined' && $.fn.DataTable && document.querySelector('#dynamicTable')) {
                        if (!$.fn.DataTable.isDataTable('#dynamicTable')) {
                            $('#dynamicTable').DataTable({
                                language: {
                                    search: "Cerca:",
                                    lengthMenu: "Mostrar _MENU_ elements",
                                    info: "Mostrant _START_ a _END_ de _TOTAL_ elements",
                                    paginate: {
                                        first: "Primer",
                                        previous: "Anterior",
                                        next: "Següent",
                                        last: "Últim"
                                    },
                                    emptyTable: "No hi ha dades disponibles"
                                },
                                pageLength: 5,
                                lengthMenu: [5, 10, 25, 50, 100], // Agregar opción de 5 elementos
                                responsive: true
                            });
                        }
                    }

                    // Inicializar tooltips
                    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    tooltipTriggerList.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                },

                // Configurar funcionalidad de edición
                setupEditFeatures: function (type, id) {
                    const toggleEditBtn = document.getElementById('toggleEditBtn');
                    const saveChangesBtn = document.getElementById('saveChangesBtn');
                    const form = document.getElementById('detail-content').querySelector('form');

                    if (!form || !toggleEditBtn || !saveChangesBtn) return;

                    // Limpiar listeners previos
                    const newToggleBtn = toggleEditBtn.cloneNode(true);
                    const newSaveBtn = saveChangesBtn.cloneNode(true);
                    toggleEditBtn.parentNode.replaceChild(newToggleBtn, toggleEditBtn);
                    saveChangesBtn.parentNode.replaceChild(newSaveBtn, saveChangesBtn);

                    // Editar
                    newToggleBtn.addEventListener('click', function () {
                        // Habilitar campos editables
                        form.querySelectorAll('.editable-field').forEach(field => {
                            field.readOnly = false;
                            field.classList.add('editable-active');
                        });

                        // Cambiar botones
                        newToggleBtn.classList.add('d-none');
                        newSaveBtn.classList.remove('d-none');
                    });

                    // Guardar
                    newSaveBtn.addEventListener('click', function () {
                        // Mostrar cargador
                        this.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Guardant...';
                        this.disabled = true;

                        // Enviar datos
                        const formData = new FormData(form);
                        fetch(`/admin/update/${type}/${id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: formData
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Volver a modo visualización
                                    form.querySelectorAll('.editable-field').forEach(field => {
                                        field.readOnly = true;
                                        field.classList.remove('editable-active');
                                    });

                                    // Mostrar mensaje
                                    const alertDiv = document.createElement('div');
                                    alertDiv.className = 'alert alert-success mt-3';
                                    alertDiv.innerHTML = `<i class="fas fa-check-circle me-2"></i> ${data.message || 'Canvis guardats correctament'}`;
                                    form.prepend(alertDiv);
                                    setTimeout(() => alertDiv.remove(), 3000);

                                    // Restaurar botones
                                    newToggleBtn.classList.remove('d-none');
                                    newSaveBtn.classList.add('d-none');
                                } else {
                                    throw new Error(data.message || 'Error al guardar');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);

                                // Mostrar error
                                const alertDiv = document.createElement('div');
                                alertDiv.className = 'alert alert-danger mt-3';
                                alertDiv.innerHTML = `<i class="fas fa-exclamation-triangle me-2"></i> ${error.message || 'Error al guardar els canvis'}`;
                                form.prepend(alertDiv);
                                setTimeout(() => alertDiv.remove(), 5000);
                            })
                            .finally(() => {
                                // Restaurar botón
                                this.innerHTML = 'Guardar';
                                this.disabled = false;
                            });
                    });
                },

                // -----------------------------------------
                // 2.4 LIMPIEZA Y GESTIÓN DE MODALES
                // -----------------------------------------

                // Configurar listeners globales
                setupGlobalListeners: function () {
                    // Limpiar modales desde la consola si es necesario
                    window.fixModals = this.cleanupModalEffects.bind(this);
                },

                // Limpiar backdrops extras
                cleanupExtraBackdrops: function () {
                    const backdrops = document.querySelectorAll('.modal-backdrop');
                    if (backdrops.length > 1) {
                        // Mantener solo un backdrop
                        for (let i = 0; i < backdrops.length - 1; i++) {
                            backdrops[i].remove();
                        }
                    }
                },

                // Limpiar todos los efectos de modales
                cleanupModalEffects: function () {
                    this.activeModals = 0;

                    // Eliminar todos los backdrops
                    document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
                        backdrop.remove();
                    });

                    // Restaurar el scroll del body
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';

                    console.log('Limpieza completa de efectos de modales');
                }
            };
            // Limpiar cualquier backdrop existente
            document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());

            // Añadir esta función para asegurar que no se crean nuevos backdrops
            window.addEventListener('shown.bs.modal', function () {
                // Eliminar cualquier backdrop que se haya creado
                document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
            });
            // Inicializar el sistema de modales
            modalSystem.init();
        });
    </script>
    <script>
        // Al cargar la página, inicializar handlers para modales de usuarios
        document.addEventListener('DOMContentLoaded', function () {
            // Deshabilitar FocusTrap de Bootstrap
            window.addEventListener('load', function () {
                // Sobrescribir el manejador de focus que causa el error
                if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    const originalProto = bootstrap.Modal.prototype;
                    const originalShow = originalProto.show;

                    bootstrap.Modal.prototype.show = function (...args) {
                        // Crear una instancia temporal
                        const tempInstance = Object.create(this);

                        // Sobrescribir el _enforceFocus para evitar los bucles infinitos
                        tempInstance._enforceFocus = function () { };

                        // Llamar al método original con el contexto modificado
                        return originalShow.apply(tempInstance, args);
                    };

                }
            });
            // Delegación de eventos para manejar clics en botones
            document.addEventListener('click', function (e) {
                // Evento para el botón de editar usuario
                if (e.target.closest('.editUserBtn')) {
                    const userId = e.target.closest('.editUserBtn').getAttribute('data-user-id');

                    // IMPORTANTE: Cerrar el modal dinámico primero
                    const dynamicModal = document.getElementById('dynamicModal');
                    if (dynamicModal) {
                        // Cerrar modal manualmente
                        dynamicModal.classList.remove('show');
                        dynamicModal.style.display = 'none';
                        document.body.classList.remove('modal-open');
                        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

                        // Pequeña pausa para asegurar que se completa la animación
                        setTimeout(() => {
                            // Ahora abrimos el modal de detalle
                            const detailModal = document.getElementById('detailModal');
                            const modalTitle = document.getElementById('detailModalLabel');
                            const modalLoader = document.getElementById('detail-modal-loader');
                            const detailContent = document.getElementById('detail-content');

                            // Configurar modal
                            modalTitle.textContent = "Editar Usuari";
                            modalLoader.classList.remove('d-none');
                            detailContent.classList.add('d-none');

                            // Limpiar cualquier backdrop residual
                            document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());

                            // Mostrar modal
                            detailModal.classList.add('show');
                            detailModal.style.display = 'block';
                            document.body.classList.add('modal-open');

                            // Cargar contenido
                            fetch(`/admin/edit-form/user/${userId}`)
                                .then(response => {
                                    if (!response.ok) throw new Error('Error al cargar el formulario');
                                    return response.text();
                                })
                                .then(html => {
                                    modalLoader.classList.add('d-none');
                                    detailContent.innerHTML = html;
                                    detailContent.classList.remove('d-none');
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    modalLoader.classList.add('d-none');
                                    detailContent.innerHTML = `
                                                                                                                    <div class="alert alert-danger">
                                                                                                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                                                                                                        Error al cargar el formulario: ${error.message}
                                                                                                                    </div>
                                                                                                                `;
                                    detailContent.classList.remove('d-none');
                                });
                        }, 300); // Esperar 300ms
                    }
                }

                // Evento para guardar usuario
                if (e.target.closest('#saveUserBtn')) {
                    handleSaveUserBtn();
                }
            });


            // Función para manejar el botón Editar Usuario
            function handleEditUserBtn(btn) {
                const userId = btn.getAttribute('data-user-id');
                document.getElementById('userFormModalLabel').textContent = "Editar Usuari";
                document.getElementById('userId').value = userId;

                // Cargar datos del usuario
                fetch(`/admin/users/${userId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('nom').value = data.nom || '';
                        document.getElementById('cognoms').value = data.cognoms || '';
                        document.getElementById('email').value = data.email || '';
                        document.getElementById('rol_id').value = data.rol_id || '';
                        document.getElementById('punts_actuals').value = data.punts_actuals || 0;

                        const userModal = new bootstrap.Modal(document.getElementById('userFormModal'));
                        userModal.show();
                    })
                    .catch(error => {
                        console.error('Error al cargar datos:', error);
                        alert('No se pudieron cargar los datos del usuario');
                    });
            }
            // Función para guardar el usuario (crear o actualizar)
            function handleSaveUserBtn() {
                const userId = document.getElementById('userId').value;
                const formData = new FormData(document.getElementById('userForm'));

                // Determinar URL y método según sea crear o actualizar
                const url = userId ? `/admin/users/${userId}` : '/admin/users';
                const method = userId ? 'PUT' : 'POST';

                if (method === 'PUT') {
                    formData.append('_method', 'PUT');
                }

                fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Cerrar modal de formulario
                            bootstrap.Modal.getInstance(document.getElementById('userFormModal')).hide();

                            // Recargar contenido del modal principal
                            setTimeout(() => {
                                document.querySelector('[data-bs-toggle="modal"][data-bs-target="#dynamicModal"][data-content-type="users"]').click();
                            }, 500);
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al guardar: ' + (error.message || 'Error desconocido'));
                    });
            }
        });
    </script>
    <script>
        // Función global para cerrar modales de forma segura (disponible en toda la aplicación)
        window.closeAnyModal = function (modalId) {
            console.log("Cerrando modal: " + modalId);

            const modal = document.getElementById(modalId);
            if (modal) {
                // Método manual de cierre
                modal.classList.remove('show');
                modal.style.display = 'none';
                modal.setAttribute('aria-hidden', 'true');
                modal.removeAttribute('aria-modal');
                modal.removeAttribute('role');

                // Limpiar el body
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';

                // Eliminar todos los backdrops
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

                console.log("Modal cerrado correctamente");

                // Recargar lista si es necesario
                if (modalId === 'detailModal') {
                    setTimeout(() => {
                        const usersBtn = document.querySelector('[data-content-type="users"]');
                        if (usersBtn) {
                            console.log("Recargando lista de usuarios");
                            usersBtn.click();
                        }
                    }, 300);
                }
            }
        };

        // Agregar listener a todos los botones de cierre en todos los modales
        document.addEventListener('click', function (event) {
            // Botones con cierre explícito
            if (event.target.matches('.btn-close, [data-bs-dismiss="modal"], #cancelUpdateUserBtn, .cancel-btn')) {
                event.preventDefault();

                // Determinar a qué modal pertenece este botón
                const modal = event.target.closest('.modal');
                if (modal) {
                    closeAnyModal(modal.id);
                } else {
                    // Si no podemos determinar el modal, intentamos cerrar los dos modales principales
                    closeAnyModal('detailModal');
                    closeAnyModal('dynamicModal');
                }
            }
        });
        // Añadir evento al botón cancelar - Con verificación de existencia
        const cancelEditBtn = document.getElementById('cancelEditBtn');
        if (cancelEditBtn) {
            cancelEditBtn.addEventListener('click', function () {
                // Cerrar modal de forma segura
                const detailModalEl = document.getElementById('detailModal');

                if (!detailModalEl) {
                    console.warn('Modal element not found');
                    return;
                }

                try {
                    // Método compatible para cerrar el modal
                    if (typeof bootstrap !== 'undefined') {
                        try {
                            const modal = bootstrap.Modal.getInstance(detailModalEl) || new bootstrap.Modal(detailModalEl);
                            modal.hide();
                        } catch (e) {
                            console.error('Error al cerrar modal:', e);
                            // Método alternativo
                            detailModalEl.classList.remove('show');
                            detailModalEl.style.display = 'none';
                            document.body.classList.remove('modal-open');
                        }
                    }

                    // Eliminar backdrops manualmente
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';

                    // Recargar lista de usuarios después de cerrar
                    setTimeout(() => {
                        const userListBtn = document.querySelector('[data-bs-toggle="modal"][data-bs-target="#dynamicModal"][data-content-type="users"]');
                        if (userListBtn) userListBtn.click();
                    }, 300);
                } catch (e) {
                    console.error('Error al cerrar el modal:', e);
                }
            });
        } else {

            // Opción alternativa: delegación de eventos si el botón se crea dinámicamente
            document.addEventListener('click', function (event) {
                if (event.target && event.target.id === 'cancelEditBtn') {
                    // Código del manejador de eventos aquí (puedes copiar el mismo código de arriba)
                    console.log('Cancel button clicked through delegation');
                    // ...
                }
            });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // =======================================
            // FUNCIONES AUXILIARES PARA ELEMENTOS DOM
            // =======================================

            // Función segura para trabajar con elementos DOM que podría no existir
            window.safeDOM = function (selector, callback) {
                if (typeof selector === 'string') {
                    const element = document.querySelector(selector);
                    if (element) {
                        callback(element);
                        return true;
                    }
                } else if (selector) {
                    callback(selector);
                    return true;
                }
                return false;
            };

            // Función global para cerrar modales
            window.closeAnyModal = function (modalId) {
                console.log("Cerrando modal: " + modalId);

                safeDOM('#' + modalId, function (modal) {
                    modal.classList.remove('show');
                    modal.style.display = 'none';
                    document.body.classList.remove('modal-open');
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

                    if (modalId === 'detailModal') {
                        setTimeout(() => {
                            const usersBtn = document.querySelector('[data-content-type="users"]');
                            if (usersBtn) usersBtn.click();
                        }, 300);
                    }
                });
            };

            // =======================================
            // MANEJADORES DE EVENTOS GLOBALES
            // =======================================

            // Eliminar backdrops existentes
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

            // Controlador global de clics
            document.addEventListener('click', function (e) {
                // Botones de cierre de modal
                if (e.target.matches('.btn-close, [data-bs-dismiss="modal"], .cancel-btn')) {
                    e.preventDefault();
                    const modal = e.target.closest('.modal');
                    if (modal) closeAnyModal(modal.id);
                }

                // Botones editar usuario
                if (e.target.closest('.editUserBtn')) {
                    const btn = e.target.closest('.editUserBtn');
                    const userId = btn.dataset.userId;

                    closeAnyModal('dynamicModal');
                    setTimeout(() => {
                        safeDOM('#detailModal', function (modal) {
                            safeDOM('#detailModalLabel', el => el.textContent = "Editar Usuari");
                            safeDOM('#detail-modal-loader', el => el.classList.remove('d-none'));
                            safeDOM('#detail-content', el => el.classList.add('d-none'));

                            modal.classList.add('show');
                            modal.style.display = 'block';
                            document.body.classList.add('modal-open');

                            fetch(`/admin/edit-form/user/${userId}`)
                                .then(response => response.text())
                                .then(html => {
                                    safeDOM('#detail-modal-loader', el => el.classList.add('d-none'));
                                    safeDOM('#detail-content', el => {
                                        el.innerHTML = html;
                                        el.classList.remove('d-none');
                                    });
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    safeDOM('#detail-content', el => {
                                        el.innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
                                        el.classList.remove('d-none');
                                    });
                                    safeDOM('#detail-modal-loader', el => el.classList.add('d-none'));
                                });
                        });
                    }, 300);
                }

                // Botones eliminar
                // Botones eliminar con bonita interfaz
                if (e.target.closest('.deleteBtn')) {
                    const btn = e.target.closest('.deleteBtn');
                    const itemId = btn.dataset.itemId;
                    const itemName = btn.dataset.itemName || 'aquest element';
                    const itemType = btn.dataset.itemType;

                    // Usar SweetAlert2 para una confirmación bonita
                    Swal.fire({
                        title: 'Estàs segur?',
                        html: `Vols eliminar a <strong>${itemName}</strong>?<br><br><span class="text-danger">Aquesta acció no es pot desfer.</span>`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: '<i class="fas fa-trash me-1"></i> Sí, eliminar',
                        cancelButtonText: 'Cancel·lar',
                        backdrop: true,
                        focusCancel: true,
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Mostrar estado de carga
                            Swal.fire({
                                title: 'Eliminant...',
                                html: `S'està eliminant <strong>${itemName}</strong>`,
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            // URL
                            const url = `/admin/destroy/${itemType}/${itemId}`;

                            // Enviar solicitud
                            fetch(url, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json'
                                }
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Mostrar éxito
                                        Swal.fire({
                                            title: 'Eliminat!',
                                            html: `S'ha eliminat <strong>${itemName}</strong> correctament`,
                                            icon: 'success',
                                            timer: 2000,
                                            timerProgressBar: true,
                                            showConfirmButton: false
                                        });

                                        // Recargar tabla
                                        setTimeout(() => {
                                            const contentType = itemType + 's';
                                            const reloadBtn = document.querySelector(`[data-content-type="${contentType}"]`);
                                            if (reloadBtn) reloadBtn.click();
                                            else location.reload();
                                        }, 1000);
                                    } else {
                                        // Mostrar error
                                        Swal.fire({
                                            title: 'Error!',
                                            html: data.message || 'No s\'ha pogut eliminar l\'element',
                                            icon: 'error',
                                            confirmButtonColor: '#3085d6'
                                        });
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Error al eliminar: ' + error.message,
                                        icon: 'error',
                                        confirmButtonColor: '#3085d6'
                                    });
                                });
                        }
                    });
                }
                if (e.target.closest('.editEventBtn')) {
                    e.preventDefault();
                    const btn = e.target.closest('.editEventBtn');
                    const eventId = btn.getAttribute('data-event-id');

                    console.log('Editando evento:', eventId);

                    // Cerrar el modal dinámico primero si está abierto
                    const dynamicModal = document.getElementById('dynamicModal');
                    if (dynamicModal) {
                        dynamicModal.classList.remove('show');
                        dynamicModal.style.display = 'none';
                        document.body.classList.remove('modal-open');
                        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                    }

                    // Pequeña pausa para asegurar que se completa la animación
                    setTimeout(() => {
                        // Configurar y mostrar el modal de detalle
                        const detailModal = document.getElementById('detailModal');
                        if (detailModal) {
                            const modalTitle = document.getElementById('detailModalLabel');
                            const modalLoader = document.getElementById('detail-modal-loader');
                            const detailContent = document.getElementById('detail-content');

                            if (modalTitle) modalTitle.textContent = "Editar Event";
                            if (modalLoader) modalLoader.classList.remove('d-none');
                            if (detailContent) detailContent.classList.add('d-none');

                            // Limpiar cualquier backdrop residual
                            document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());

                            // Mostrar modal
                            detailModal.classList.add('show');
                            detailModal.style.display = 'block';
                            document.body.classList.add('modal-open');

                            // Cargar contenido del formulario de edición
                            fetch(`/admin/edit-form/event/${eventId}`)
                                .then(response => {
                                    if (!response.ok) throw new Error('Error al cargar el formulario');
                                    return response.text();
                                })
                                .then(html => {
                                    if (modalLoader) modalLoader.classList.add('d-none');
                                    if (detailContent) {
                                        detailContent.innerHTML = html;
                                        detailContent.classList.remove('d-none');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    if (modalLoader) modalLoader.classList.add('d-none');
                                    if (detailContent) {
                                        detailContent.innerHTML = `
                                                                                                                        <div class="alert alert-danger">
                                                                                                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                                                                                                            Error al cargar el formulario: ${error.message}
                                                                                                                        </div>
                                                                                                                    `;
                                        detailContent.classList.remove('d-none');
                                    }
                                });
                        } else {
                            console.error('Modal de detalle no encontrado');
                        }
                    }, 300); // Esperar 300ms para evitar conflictos de animación
                }
                if (e.target.closest('.editPremiBtn')) {
                    e.preventDefault();
                    const btn = e.target.closest('.editPremiBtn');
                    const premiId = btn.getAttribute('data-premi-id');

                    console.log('Editando premio:', premiId);

                    // Cerrar el modal dinámico primero si está abierto
                    closeAnyModal('dynamicModal');

                    // Pequeña pausa para asegurar que se completa la animación
                    setTimeout(() => {
                        // Configurar y mostrar el modal de detalle
                        const detailModal = document.getElementById('detailModal');
                        if (detailModal) {
                            const modalTitle = document.getElementById('detailModalLabel');
                            const modalLoader = document.getElementById('detail-modal-loader');
                            const detailContent = document.getElementById('detail-content');

                            if (modalTitle) modalTitle.textContent = "Editar Premi";
                            if (modalLoader) modalLoader.classList.remove('d-none');
                            if (detailContent) detailContent.classList.add('d-none');

                            // Limpiar cualquier backdrop residual
                            document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());

                            // Mostrar modal
                            detailModal.classList.add('show');
                            detailModal.style.display = 'block';
                            document.body.classList.add('modal-open');

                            // Cargar contenido del formulario de edición
                            fetch(`/admin/edit-form/premi/${premiId}`)
                                .then(response => {
                                    if (!response.ok) throw new Error('Error al cargar el formulario');
                                    return response.text();
                                })
                                .then(html => {
                                    if (modalLoader) modalLoader.classList.add('d-none');
                                    if (detailContent) {
                                        detailContent.innerHTML = html;
                                        detailContent.classList.remove('d-none');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    if (modalLoader) modalLoader.classList.add('d-none');
                                    if (detailContent) {
                                        detailContent.innerHTML = `
                                                                                                                        <div class="alert alert-danger">
                                                                                                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                                                                                                            Error al cargar el formulario: ${error.message}
                                                                                                                        </div>
                                                                                                                    `;
                                        detailContent.classList.remove('d-none');
                                    }
                                });
                        }
                    }, 300);
                }
                // Botones editar código
                if (e.target.closest('.editCodiBtn')) {
                    e.preventDefault();
                    const btn = e.target.closest('.editCodiBtn');
                    const codiId = btn.getAttribute('data-codi-id');

                    console.log('Editando código:', codiId);

                    // Cerrar el modal dinámico primero si está abierto
                    closeAnyModal('dynamicModal');

                    // Pequeña pausa para asegurar que se completa la animación
                    setTimeout(() => {
                        // Configurar y mostrar el modal de detalle
                        const detailModal = document.getElementById('detailModal');
                        if (detailModal) {
                            const modalTitle = document.getElementById('detailModalLabel');
                            const modalLoader = document.getElementById('detail-modal-loader');
                            const detailContent = document.getElementById('detail-content');

                            if (modalTitle) modalTitle.textContent = "Editar Codi";
                            if (modalLoader) modalLoader.classList.remove('d-none');
                            if (detailContent) detailContent.classList.add('d-none');

                            // Limpiar cualquier backdrop residual
                            document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());

                            // Mostrar modal
                            detailModal.classList.add('show');
                            detailModal.style.display = 'block';
                            document.body.classList.add('modal-open');

                            // Cargar contenido del formulario de edición
                            fetch(`/admin/edit-form/codi/${codiId}`)
                                .then(response => {
                                    if (!response.ok) throw new Error('Error al cargar el formulario');
                                    return response.text();
                                })
                                .then(html => {
                                    if (modalLoader) modalLoader.classList.add('d-none');
                                    if (detailContent) {
                                        detailContent.innerHTML = html;
                                        detailContent.classList.remove('d-none');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    if (modalLoader) modalLoader.classList.add('d-none');
                                    if (detailContent) {
                                        detailContent.innerHTML = `
                                                                                                                        <div class="alert alert-danger">
                                                                                                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                                                                                                            Error al cargar el formulario: ${error.message}
                                                                                                                        </div>
                                                                                                                    `;
                                        detailContent.classList.remove('d-none');
                                    }
                                });
                        }
                    }, 300);
                }
                // Botones editar producto
                if (e.target.closest('.editProducteBtn')) {
                    e.preventDefault();
                    const btn = e.target.closest('.editProducteBtn');
                    const producteId = btn.getAttribute('data-producte-id');

                    closeAnyModal('dynamicModal');

                    setTimeout(() => {
                        const detailModal = document.getElementById('detailModal');
                        if (detailModal) {
                            const modalTitle = document.getElementById('detailModalLabel');
                            const modalLoader = document.getElementById('detail-modal-loader');
                            const detailContent = document.getElementById('detail-content');

                            if (modalTitle) modalTitle.textContent = "Editar Producte";
                            if (modalLoader) modalLoader.classList.remove('d-none');
                            if (detailContent) detailContent.classList.add('d-none');

                            detailModal.classList.add('show');
                            detailModal.style.display = 'block';
                            document.body.classList.add('modal-open');

                            fetch(`/admin/edit-form/producte/${producteId}`)
                                .then(response => {
                                    if (!response.ok) throw new Error('Error al cargar el formulario');
                                    return response.text();
                                })
                                .then(html => {
                                    if (modalLoader) modalLoader.classList.add('d-none');
                                    if (detailContent) {
                                        detailContent.innerHTML = html;
                                        detailContent.classList.remove('d-none');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    if (modalLoader) modalLoader.classList.add('d-none');
                                    if (detailContent) {
                                        detailContent.innerHTML = `
                                                                                                                        <div class="alert alert-danger">
                                                                                                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                                                                                                            Error al cargar el formulario: ${error.message}
                                                                                                                        </div>
                                                                                                                    `;
                                        detailContent.classList.remove('d-none');
                                    }
                                });
                        }
                    }, 300);
                }
                // Botones editar punto de recogida
                if (e.target.closest('.editPuntBtn')) {
                    e.preventDefault();
                    const btn = e.target.closest('.editPuntBtn');
                    const puntId = btn.getAttribute('data-punt-id');

                    closeAnyModal('dynamicModal');

                    setTimeout(() => {
                        const detailModal = document.getElementById('detailModal');
                        if (detailModal) {
                            const modalTitle = document.getElementById('detailModalLabel');
                            const modalLoader = document.getElementById('detail-modal-loader');
                            const detailContent = document.getElementById('detail-content');

                            if (modalTitle) modalTitle.textContent = "Editar Punt de Recollida";
                            if (modalLoader) modalLoader.classList.remove('d-none');
                            if (detailContent) detailContent.classList.add('d-none');

                            detailModal.classList.add('show');
                            detailModal.style.display = 'block';
                            document.body.classList.add('modal-open');

                            fetch(`/admin/edit-form/punt-reciclatge/${puntId}`)
                                .then(response => {
                                    if (!response.ok) throw new Error('Error al cargar el formulario');
                                    return response.text();
                                })
                                .then(html => {
                                    if (modalLoader) modalLoader.classList.add('d-none');
                                    if (detailContent) {
                                        detailContent.innerHTML = html;
                                        detailContent.classList.remove('d-none');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    if (modalLoader) modalLoader.classList.add('d-none');
                                    if (detailContent) {
                                        detailContent.innerHTML = `
                                                                                                                        <div class="alert alert-danger">
                                                                                                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                                                                                                            Error al cargar el formulario: ${error.message}
                                                                                                                        </div>
                                                                                                                    `;
                                        detailContent.classList.remove('d-none');
                                    }
                                });
                        }
                    }, 300);
                }
                // Botones editar rol
                if (e.target.closest('.editRolBtn')) {
                    e.preventDefault();
                    const btn = e.target.closest('.editRolBtn');
                    const rolId = btn.getAttribute('data-rol-id');

                    closeAnyModal('dynamicModal');

                    setTimeout(() => {
                        const detailModal = document.getElementById('detailModal');
                        if (detailModal) {
                            const modalTitle = document.getElementById('detailModalLabel');
                            const modalLoader = document.getElementById('detail-modal-loader');
                            const detailContent = document.getElementById('detail-content');

                            if (modalTitle) modalTitle.textContent = "Editar Rol";
                            if (modalLoader) modalLoader.classList.remove('d-none');
                            if (detailContent) detailContent.classList.add('d-none');

                            detailModal.classList.add('show');
                            detailModal.style.display = 'block';
                            document.body.classList.add('modal-open');

                            fetch(`/admin/edit-form/rol/${rolId}`)
                                .then(response => {
                                    if (!response.ok) throw new Error('Error al cargar el formulario');
                                    return response.text();
                                })
                                .then(html => {
                                    if (modalLoader) modalLoader.classList.add('d-none');
                                    if (detailContent) {
                                        detailContent.innerHTML = html;
                                        detailContent.classList.remove('d-none');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    if (modalLoader) modalLoader.classList.add('d-none');
                                    if (detailContent) {
                                        detailContent.innerHTML = `
                                                                                                                        <div class="alert alert-danger">
                                                                                                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                                                                                                            Error al cargar el formulario: ${error.message}
                                                                                                                        </div>
                                                                                                                    `;
                                        detailContent.classList.remove('d-none');
                                    }
                                });
                        }
                    }, 300);
                }
                // Botones editar tipo de alerta
                if (e.target.closest('.editTipusAlertaBtn')) {
                    e.preventDefault();
                    const btn = e.target.closest('.editTipusAlertaBtn');
                    const tipusAlertaId = btn.getAttribute('data-tipus-alerta-id');

                    console.log('Editando tipo de alerta:', tipusAlertaId);

                    closeAnyModal('dynamicModal');

                    setTimeout(() => {
                        const detailModal = document.getElementById('detailModal');
                        if (detailModal) {
                            const modalTitle = document.getElementById('detailModalLabel');
                            const modalLoader = document.getElementById('detail-modal-loader');
                            const detailContent = document.getElementById('detail-content');

                            if (modalTitle) modalTitle.textContent = "Editar Tipus d'Alerta";
                            if (modalLoader) modalLoader.classList.remove('d-none');
                            if (detailContent) detailContent.classList.add('d-none');

                            detailModal.classList.add('show');
                            detailModal.style.display = 'block';
                            document.body.classList.add('modal-open');

                            fetch(`/admin/edit-form/tipus-alerta/${tipusAlertaId}`)
                                .then(response => {
                                    if (!response.ok) throw new Error('Error al cargar el formulario');
                                    return response.text();
                                })
                                .then(html => {
                                    if (modalLoader) modalLoader.classList.add('d-none');
                                    if (detailContent) {
                                        detailContent.innerHTML = html;
                                        detailContent.classList.remove('d-none');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    if (modalLoader) modalLoader.classList.add('d-none');
                                    if (detailContent) {
                                        detailContent.innerHTML = `
                                                                                                                        <div class="alert alert-danger">
                                                                                                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                                                                                                            Error al cargar el formulario: ${error.message}
                                                                                                                        </div>
                                                                                                                    `;
                                        detailContent.classList.remove('d-none');
                                    }
                                });
                        }
                    }, 300);
                }
                // Botones editar alerta de punto de recogida
                if (e.target.closest('.editAlertaBtn')) {
                    e.preventDefault();
                    const btn = e.target.closest('.editAlertaBtn');
                    const alertaId = btn.getAttribute('data-alerta-id');

                    closeAnyModal('dynamicModal');

                    setTimeout(() => {
                        const detailModal = document.getElementById('detailModal');
                        if (detailModal) {
                            const modalTitle = document.getElementById('detailModalLabel');
                            const modalLoader = document.getElementById('detail-modal-loader');
                            const detailContent = document.getElementById('detail-content');

                            if (modalTitle) modalTitle.textContent = "Editar Alerta";
                            if (modalLoader) modalLoader.classList.remove('d-none');
                            if (detailContent) detailContent.classList.add('d-none');

                            detailModal.classList.add('show');
                            detailModal.style.display = 'block';
                            document.body.classList.add('modal-open');

                            fetch(`/admin/edit-form/alerta-punt/${alertaId}`)
                                .then(response => {
                                    if (!response.ok) throw new Error('Error al cargar el formulario');
                                    return response.text();
                                })
                                .then(html => {
                                    if (modalLoader) modalLoader.classList.add('d-none');
                                    if (detailContent) {
                                        detailContent.innerHTML = html;
                                        detailContent.classList.remove('d-none');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    if (modalLoader) modalLoader.classList.add('d-none');
                                    if (detailContent) {
                                        detailContent.innerHTML = `
                                                                                                                        <div class="alert alert-danger">
                                                                                                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                                                                                                            Error al cargar el formulario: ${error.message}
                                                                                                                        </div>
                                                                                                                    `;
                                        detailContent.classList.remove('d-none');
                                    }
                                });
                        }
                    }, 300);
                }
                // Botones editar tipo de evento
                if (e.target.closest('.editTipusEventBtn')) {
                    e.preventDefault();
                    const btn = e.target.closest('.editTipusEventBtn');
                    const tipusEventId = btn.getAttribute('data-tipus-event-id');

                    closeAnyModal('dynamicModal');

                    setTimeout(() => {
                        const detailModal = document.getElementById('detailModal');
                        if (detailModal) {
                            const modalTitle = document.getElementById('detailModalLabel');
                            const modalLoader = document.getElementById('detail-modal-loader');
                            const detailContent = document.getElementById('detail-content');

                            if (modalTitle) modalTitle.textContent = "Editar Tipus d'Event";
                            if (modalLoader) modalLoader.classList.remove('d-none');
                            if (detailContent) detailContent.classList.add('d-none');

                            detailModal.classList.add('show');
                            detailModal.style.display = 'block';
                            document.body.classList.add('modal-open');

                            fetch(`/admin/edit-form/tipus-event/${tipusEventId}`)
                                .then(response => {
                                    if (!response.ok) throw new Error('Error al cargar el formulario');
                                    return response.text();
                                })
                                .then(html => {
                                    if (modalLoader) modalLoader.classList.add('d-none');
                                    if (detailContent) {
                                        detailContent.innerHTML = html;
                                        detailContent.classList.remove('d-none');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    if (modalLoader) modalLoader.classList.add('d-none');
                                    if (detailContent) {
                                        detailContent.innerHTML = `
                                                                                                                        <div class="alert alert-danger">
                                                                                                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                                                                                                            Error al cargar el formulario: ${error.message}
                                                                                                                        </div>
                                                                                                                    `;
                                        detailContent.classList.remove('d-none');
                                    }
                                });
                        }
                    }, 300);
                }
            });
        });
    </script>
    <script>
        // Variable global para recordar la última vista activa
        window.lastActiveContentType = 'users'; // Valor predeterminado

        // Función mejorada para cerrar modales
        window.closeAnyModal = function (modalId) {
            console.log("Cerrando modal: " + modalId);

            const modal = document.getElementById(modalId);
            if (modal) {
                // Método manual de cierre
                modal.classList.remove('show');
                modal.style.display = 'none';
                modal.setAttribute('aria-hidden', 'true');
                modal.removeAttribute('aria-modal');
                modal.removeAttribute('role');

                // Limpiar el body
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';

                // Eliminar todos los backdrops
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

                // Recargar la última vista activa después de cerrar
                if (modalId === 'detailModal') {
                    setTimeout(() => {
                        console.log("Recargando última vista activa:", window.lastActiveContentType);
                        const contentBtn = document.querySelector(`[data-content-type="${window.lastActiveContentType}"]`);
                        if (contentBtn) contentBtn.click();
                    }, 300);
                }
            }
        };

        // Interceptar los clics en los botones de contenido para recordar la última vista activa
        document.addEventListener('click', function (e) {
            const contentTypeBtn = e.target.closest('[data-content-type]');
            if (contentTypeBtn) {
                const contentType = contentTypeBtn.getAttribute('data-content-type');
                if (contentType) {
                    console.log("Guardando última vista activa:", contentType);
                    window.lastActiveContentType = contentType;
                }
            }
        });

        // Modificación específica para eventos
        document.addEventListener('click', function (e) {

            // Al hacer clic en cualquier botón relacionado con usuarios, recordar que estamos en la vista de usuarios
            if (e.target.closest('#newUserBtn') || e.target.closest('.editUserBtn') ||
                e.target.closest('[data-detail-type="user"]')) {
                window.lastActiveContentType = 'users';
            }

            // Al hacer clic en cualquier botón relacionado con eventos, recordar que estamos en la vista de eventos
            if (e.target.closest('#newEventBtn') || e.target.closest('.editEventBtn') ||
                e.target.closest('[data-detail-type="event"]')) {
                window.lastActiveContentType = 'events';
            }
            // Al hacer clic en cualquier botón relacionado con premios, recordar que estamos en la vista de premios
            if (e.target.closest('#newPremiBtn') || e.target.closest('.editPremiBtn') ||
                e.target.closest('[data-detail-type="premi"]')) {
                window.lastActiveContentType = 'premis';
            }
            // Al hacer clic en cualquier botón relacionado con códigos, recordar que estamos en la vista de códigos
            if (e.target.closest('#newCodiBtn') || e.target.closest('.editCodiBtn') ||
                e.target.closest('[data-detail-type="codi"]')) {
                window.lastActiveContentType = 'codis';
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Botón "Ver Todo" para actividades
            const viewAllActivitiesBtn = document.getElementById('viewAllActivitiesBtn');
            if (viewAllActivitiesBtn) {
                viewAllActivitiesBtn.addEventListener('click', function (e) {
                    e.preventDefault();

                    const dynamicModal = document.getElementById('dynamicModal');
                    if (dynamicModal) {
                        const modalTitle = document.getElementById('dynamicModalLabel');
                        const modalLoader = document.getElementById('modal-loader');
                        const modalContent = document.getElementById('dynamic-content');

                        if (modalTitle) modalTitle.textContent = "Historial d'Activitat";
                        if (modalLoader) modalLoader.classList.remove('d-none');
                        if (modalContent) modalContent.classList.add('d-none');

                        dynamicModal.classList.add('show');
                        dynamicModal.style.display = 'block';
                        document.body.classList.add('modal-open');

                        fetch('/admin/modal-content/activitats')
                            .then(response => {
                                if (!response.ok) throw new Error('Error al cargar el historial de actividad');
                                return response.text();
                            })
                            .then(html => {
                                if (modalLoader) modalLoader.classList.add('d-none');
                                if (modalContent) {
                                    modalContent.innerHTML = html;
                                    modalContent.classList.remove('d-none');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                if (modalLoader) modalLoader.classList.add('d-none');
                                if (modalContent) {
                                    modalContent.innerHTML = `
                                                    <div class="alert alert-danger">
                                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                                        Error al cargar el historial: ${error.message}
                                                    </div>
                                                `;
                                    modalContent.classList.remove('d-none');
                                }
                            });
                    }
                });
            }

            // Botones para ver detalles de actividad
            document.querySelectorAll('.view-activity-details').forEach(button => {
                button.addEventListener('click', function () {
                    const activityId = this.getAttribute('data-activity-id');

                    const detailModal = document.getElementById('detailModal');
                    if (detailModal) {
                        const modalTitle = document.getElementById('detailModalLabel');
                        const modalLoader = document.getElementById('detail-modal-loader');
                        const detailContent = document.getElementById('detail-content');

                        if (modalTitle) modalTitle.textContent = "Detalls de l'Activitat";
                        if (modalLoader) modalLoader.classList.remove('d-none');
                        if (detailContent) detailContent.classList.add('d-none');

                        detailModal.classList.add('show');
                        detailModal.style.display = 'block';
                        document.body.classList.add('modal-open');

                        fetch(`/admin/detail/activitat/${activityId}`)
                            .then(response => {
                                if (!response.ok) throw new Error('Error al cargar los detalles');
                                return response.text();
                            })
                            .then(html => {
                                if (modalLoader) modalLoader.classList.add('d-none');
                                if (detailContent) {
                                    detailContent.innerHTML = html;
                                    detailContent.classList.remove('d-none');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                if (modalLoader) modalLoader.classList.add('d-none');
                                if (detailContent) {
                                    detailContent.innerHTML = `
                                                    <div class="alert alert-danger">
                                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                                        Error al cargar los detalles: ${error.message}
                                                    </div>
                                                `;
                                    detailContent.classList.remove('d-none');
                                }
                            });
                    }
                });
            });
        });
    </script>
    <script>
        // Inicializar todos los modales con las opciones correctas
        document.addEventListener('DOMContentLoaded', function () {
            // Configurar todos los modales para cerrarse al hacer clic fuera
            var modals = document.querySelectorAll('.modal');
            modals.forEach(function (modal) {
                var modalInstance = new bootstrap.Modal(modal, {
                    backdrop: true,
                    keyboard: true
                });

                // Añadir atributo de backdrop si no existe
                if (!modal.hasAttribute('data-bs-backdrop')) {
                    modal.setAttribute('data-bs-backdrop', 'true');
                }
            });

            // Para modal dinámico
            const dynamicModal = document.getElementById('dynamicModal');
            if (dynamicModal) {
                // Añadir manejo para cerrar al hacer clic fuera
                dynamicModal.addEventListener('click', function (e) {
                    if (e.target === dynamicModal) {
                        closeAnyModal('dynamicModal');
                    }
                });
            }

            // Para modal de detalles
            const detailModal = document.getElementById('detailModal');
            if (detailModal) {
                // Añadir manejo para cerrar al hacer clic fuera
                detailModal.addEventListener('click', function (e) {
                    if (e.target === detailModal) {
                        closeAnyModal('detailModal');
                    }
                });
            }
        });
        // Botón "Ver Todo" para el ranking de usuarios
        document.getElementById('viewAllUsersBtn').addEventListener('click', function (e) {
            e.preventDefault();

            const dynamicModal = document.getElementById('dynamicModal');
            if (dynamicModal) {
                const modalTitle = document.getElementById('dynamicModalLabel');
                const modalLoader = document.getElementById('modal-loader');
                const modalContent = document.getElementById('dynamic-content');

                if (modalTitle) modalTitle.textContent = "Classificació d'Usuaris";
                if (modalLoader) modalLoader.classList.remove('d-none');
                if (modalContent) modalContent.classList.add('d-none');

                dynamicModal.classList.add('show');
                dynamicModal.style.display = 'block';
                document.body.classList.add('modal-open');

                fetch('/admin/modal-content/users-ranking')
                    .then(response => {
                        if (!response.ok) throw new Error('Error al cargar el ranking');
                        return response.text();
                    })
                    .then(html => {
                        if (modalLoader) modalLoader.classList.add('d-none');
                        if (modalContent) {
                            modalContent.innerHTML = html;
                            modalContent.classList.remove('d-none');

                            // Inicializar DataTables después de cargar el contenido
                            if (typeof $ !== 'undefined' && $.fn.DataTable) {
                                setTimeout(function () {
                                    if ($.fn.DataTable.isDataTable('#usersRankingTable')) {
                                        $('#usersRankingTable').DataTable().destroy();
                                    }
                                    $('#usersRankingTable').DataTable({
                                        language: {
                                            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/ca.json'
                                        },
                                        order: [[3, 'desc']], // Ordenar por puntos totales
                                        pageLength: 10,
                                        responsive: true,
                                        dom: '<"top"f>rt<"bottom"lp><"clear">',
                                        columnDefs: [
                                            { orderable: false, targets: 5 }
                                        ]
                                    });
                                }, 100);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        if (modalLoader) modalLoader.classList.add('d-none');
                        if (modalContent) {
                            modalContent.innerHTML = `
                                                                                                <div class="alert alert-danger">
                                                                                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                                                                                    Error al cargar el ranking: ${error.message}
                                                                                                </div>
                                                                                            `;
                            modalContent.classList.remove('d-none');
                        }
                    });
            }
        });
        // Manejador para botones de acción en premios reclamados
        document.addEventListener('click', function (e) {
            if (e.target.closest('.actionBtn')) {
                e.preventDefault();

                const btn = e.target.closest('.actionBtn');
                const itemId = btn.getAttribute('data-item-id');
                const itemName = btn.getAttribute('data-item-name');
                const itemType = btn.getAttribute('data-item-type');
                const action = btn.getAttribute('data-action');

                // Crear mensajes personalizados según la acción
                let confirmMessage = '¿Estás segur?';
                let successMessage = 'Operació completada amb èxit';
                let route = '';

                if (action === 'approve') {
                    confirmMessage = `Estàs segur que vols aprovar la sol·licitud de "${itemName}"?`;
                    successMessage = 'Sol·licitud aprovada correctament';
                    route = `/admin/premis-reclamats/${itemId}/approve`;
                } else if (action === 'reject') {
                    confirmMessage = `Estàs segur que vols rebutjar la sol·licitud de "${itemName}"?`;
                    successMessage = 'Sol·licitud rebutjada correctament';
                    route = `/admin/premis-reclamats/${itemId}/reject`;
                }

                if (confirm(confirmMessage)) {
                    // Mostrar indicador de carga
                    btn.disabled = true;
                    const originalHtml = btn.innerHTML;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

                    // Realizar la acción mediante AJAX
                    fetch(route, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => {
                            if (!response.ok) throw new Error('Error en la respuesta del servidor');
                            return response.json();
                        })
                        .then(data => {
                            // Mostrar mensaje de éxito
                            alert(successMessage);

                            // Recargar contenido
                            if (detailModal && detailModal.classList.contains('show')) {
                                // Si estamos en detalle, cerrar modal y recargar lista
                                closeAnyModal('detailModal');
                            }

                            // Recargar lista de premios reclamados
                            setTimeout(() => {
                                const premisReclamatsBtn = document.querySelector('[data-content-type="premis-reclamats"]');
                                if (premisReclamatsBtn) {
                                    premisReclamatsBtn.click();
                                } else {
                                    window.location.reload();
                                }
                            }, 300);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error al processar la sol·licitud: ' + error.message);
                            btn.disabled = false;
                            btn.innerHTML = originalHtml;
                        });
                }
            }
        });
        // Botones para editar premios reclamados
        document.addEventListener('click', function (e) {
            const editBtn = e.target.closest('.editStatusBtn, .editPremiReclamatBtn');
            if (editBtn) {
                e.preventDefault();
                const premiId = editBtn.getAttribute('data-id');

                // Cerrar modal dinámico si está abierto
                closeAnyModal('dynamicModal');

                // Configurar y abrir modal de detalles para edición
                const detailModal = document.getElementById('detailModal');
                const modalTitle = document.getElementById('detailModalLabel');
                const modalLoader = document.getElementById('detail-modal-loader');
                const modalContent = document.getElementById('detail-content');

                if (modalTitle) modalTitle.textContent = "Actualitzar Premi Reclamat";
                if (modalLoader) modalLoader.classList.remove('d-none');
                if (modalContent) modalContent.classList.add('d-none');

                // Mostrar modal
                if (detailModal) {
                    detailModal.classList.add('show');
                    detailModal.style.display = 'block';
                    document.body.classList.add('modal-open');

                    // Crear backdrop si no existe
                    if (!document.querySelector('.modal-backdrop')) {
                        const backdrop = document.createElement('div');
                        backdrop.className = 'modal-backdrop fade show';
                        document.body.appendChild(backdrop);
                    }
                }

                // Cargar contenido mediante AJAX
                fetch(`/admin/edit-form/premi-reclamat/${premiId}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Error al cargar el formulario');
                        return response.text();
                    })
                    .then(html => {
                        if (modalLoader) modalLoader.classList.add('d-none');
                        if (modalContent) {
                            modalContent.innerHTML = html;
                            modalContent.classList.remove('d-none');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        if (modalLoader) modalLoader.classList.add('d-none');
                        if (modalContent) {
                            modalContent.innerHTML = `
                                                                        <div class="alert alert-danger">
                                                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                                                            Error al cargar el formulario: ${error.message}
                                                                        </div>
                                                                    `;
                            modalContent.classList.remove('d-none');
                        }
                    });
            }
        });
    </script>

@endsection