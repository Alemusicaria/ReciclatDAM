@extends('layouts.app')

@section('content')
    <div class="admin-dashboard py-4">
        <div class="container-fluid" style="margin-top: 13vh;">
            <!-- Encabezado -->
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
            <!-- Targetes d'estadística -->
            <div class="row stats-cards mb-4">
                <!-- Para la tarjeta de Usuarios -->
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

                <!-- Para la tarjeta de Eventos -->
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

                <!-- Para la tarjeta de Premios -->
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

                <!-- Para la tarjeta de Reciclaje -->
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="stat-card recycling cursor-pointer" data-bs-toggle="modal" data-bs-target="#dynamicModal"
                        data-content-type="recycling-detail">
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

            <!-- Gràfics i Distribució -->
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

            <!-- Activitat recent i Top usuaris -->
            <div class="row content-row mb-4">
                <!-- Activitat recent -->
                <div class="col-xl-8 col-lg-7 mb-4">
                    <div class="content-card h-100">
                        <div class="content-card-header">
                            <h4 class="content-card-title">
                                <i class="fas fa-history me-2" style="margin-right: 10px;"></i>Activitat Recent
                            </h4>
                            <a href="#" class="btn-sm btn-view-all">Veure Tot</a>
                        </div>
                        <div class="content-card-body p-0">
                            <div class="table-responsive">
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
                                                                                    <!-- Para la sección de actividad reciente -->
                                                                                    <img src="{{ 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ($activity->user && $activity->user->foto_perfil) ?
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
                                                                                <button class="btn-icon" data-bs-toggle="tooltip" title="Veure detalls">
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
                                <i class="fas fa-trophy me-2" style="margin-right: 10px;"></i>Millors Usuaris
                            </h4>
                            <a href="#" class="btn-sm btn-view-all">Veure Tot</a>
                        </div>
                        <div class="content-card-body p-0">
                            <ul class="user-ranking-list">
                                @forelse($topUsers as $key => $user)
                                                        <?php    $nivellInfo = $user->nivell(); ?>
                                                        <li class="user-ranking-item">
                                                            <div class="ranking-position">{{ $key + 1 }}</div>
                                                            <div class="ranking-user">
                                                                <!-- Para la sección de mejores usuarios -->
                                                                <img src="{{                                                                                                                                                                                                                                                                                                 $user->foto_perfil ?
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
                                                                <span class="badge-points">{{ $user->punts_totals }} pts</span>
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

            <!-- Gestió ràpida -->
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="content-card">
                        <div class="content-card-header">
                            <h4 class="content-card-title">
                                <i class="fas fa-tools me-2" style="margin-right: 10px;"></i>Gestió Ràpida
                            </h4>
                        </div>
                        <div class="content-card-body">
                            <div class="row management-options">
                                <div class="col-md-3 col-sm-6 mb-4">
                                    <a href="#" class="management-card" data-bs-toggle="modal"
                                        data-bs-target="#dynamicModal" data-content-type="users">
                                        <div class="management-icon">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <h5 class="management-title">Gestió d'Usuaris</h5>
                                        <p class="management-subtitle">Administra els usuaris de la plataforma</p>
                                    </a>
                                </div>

                                <div class="col-md-3 col-sm-6 mb-4">
                                    <a href="#" class="management-card" data-bs-toggle="modal"
                                        data-bs-target="#dynamicModal" data-content-type="events">
                                        <div class="management-icon">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                        <h5 class="management-title">Gestió d'Events</h5>
                                        <p class="management-subtitle">Administra els events i participants</p>
                                    </a>
                                </div>

                                <div class="col-md-3 col-sm-6 mb-4">
                                    <a href="#" class="management-card" data-bs-toggle="modal"
                                        data-bs-target="#dynamicModal" data-content-type="premis">
                                        <div class="management-icon">
                                            <i class="fas fa-gift"></i>
                                        </div>
                                        <h5 class="management-title">Gestió de Premis</h5>
                                        <p class="management-subtitle">Administra els premis disponibles</p>
                                    </a>
                                </div>

                                <div class="col-md-3 col-sm-6 mb-4">
                                    <a href="#" class="management-card" data-bs-toggle="modal"
                                        data-bs-target="#dynamicModal" data-content-type="premis-pendents">
                                        <div class="management-icon">
                                            <i class="fas fa-tasks"></i>
                                        </div>
                                        <h5 class="management-title">Premis Pendents</h5>
                                        <p class="management-subtitle">Gestiona les sol·licituds de premis</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Al final del dashboard pero antes de los scripts, añade este modal genérico -->
        <div class="modal fade" id="dynamicModal" tabindex="-1" aria-labelledby="dynamicModalLabel" aria-hidden="true">
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
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
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
    </div>

    <style>
        /* Variables per a mode clar/fosc */
        :root {
            --admin-bg: #f5f7fa;
            --card-bg: #fff;
            --card-border: rgba(0, 0, 0, 0.05);
            --card-shadow: rgba(0, 0, 0, 0.05);
            --text-primary: #2d3748;
            --text-secondary: #718096;
            --border-color: #e2e8f0;
            --icon-bg: #f7fafc;
        }

        body.dark {
            --admin-bg: #1a202c;
            --card-bg: #2d3748;
            --card-border: rgba(255, 255, 255, 0.05);
            --card-shadow: rgba(0, 0, 0, 0.2);
            --text-primary: #f7fafc;
            --text-secondary: #a0aec0;
            --border-color: #4a5568;
            --icon-bg: #4a5568;
        }

        /* Estils generals */
        .admin-dashboard {
            background-color: var(--admin-bg);
            min-height: 100vh;
            padding-top: 60px;
        }

        .header-card,
        .stat-card,
        .chart-card,
        .content-card,
        .management-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 4px 16px var(--card-shadow);
            border: 1px solid var(--card-border);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .admin-title {
            color: var(--text-primary);
            font-size: 1.8rem;
            font-weight: 700;
        }

        .admin-subtitle,
        .admin-date {
            color: var(--text-secondary);
            font-size: 1rem;
        }

        /* Targetes d'estadística */
        .stat-card {
            height: 100%;
            position: relative;
        }

        .stat-card-body {
            padding: 20px;
            display: flex;
            align-items: center;
        }

        .stat-card-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-right: 16px;
            background-color: var(--icon-bg);
        }

        .stat-card.users .stat-card-icon {
            color: #3182ce;
        }

        .stat-card.events .stat-card-icon {
            color: #38a169;
        }

        .stat-card.prizes .stat-card-icon {
            color: #d69e2e;
        }

        .stat-card.recycling .stat-card-icon {
            color: #3182ce;
        }

        .stat-card-number {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0;
            color: var(--text-primary);
        }

        .stat-card-title {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-bottom: 8px;
        }

        .stat-card-percent {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        .stat-card-badge .badge {
            background-color: rgba(56, 161, 105, 0.1);
            color: #38a169;
            font-weight: 500;
            font-size: 0.8rem;
            padding: 5px 10px;
            border-radius: 20px;
        }

        /* Targetes de gràfics */
        .chart-card-header,
        .content-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .chart-card-title,
        .content-card-title {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .chart-card-body,
        .content-card-body {
            padding: 20px;
        }

        .chart-legend {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        .chart-legend-item {
            display: flex;
            align-items: center;
            margin-right: 15px;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 2px;
            margin-right: 5px;
        }

        .legend-text {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        /* Taula d'activitat */
        .table-activity {
            margin-bottom: 0;
        }

        .table-activity thead th {
            background-color: rgba(0, 0, 0, 0.02);
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 0.85rem;
            padding: 12px 20px;
            border-color: var(--border-color);
        }

        body.dark .table-activity thead th {
            background-color: rgba(255, 255, 255, 0.02);
        }

        .table-activity tbody td {
            padding: 12px 20px;
            vertical-align: middle;
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        .activity-user {
            display: flex;
            align-items: center;
        }

        .activity-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 12px;
        }

        .activity-user-name {
            margin-bottom: 2px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .activity-user-email {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        .btn-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: var(--icon-bg);
            color: var(--text-secondary);
            border: none;
            transition: all 0.2s ease;
        }

        .btn-icon:hover {
            background-color: #3182ce;
            color: white;
        }

        /* Llista d'usuaris destacats */
        .user-ranking-list {
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .user-ranking-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .user-ranking-item:last-child {
            border-bottom: none;
        }

        .ranking-position {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: var(--icon-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-weight: 600;
            font-size: 0.8rem;
            color: var(--text-primary);
        }

        .ranking-user {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .ranking-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 12px;
        }

        .ranking-user-name {
            margin-bottom: 2px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .ranking-user-level {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        .badge-points {
            background-color: rgba(49, 130, 206, 0.1);
            color: #3182ce;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* Targetes de gestió */
        .management-options {
            padding: 10px;
        }

        .management-card {
            display: block;
            padding: 20px;
            height: 100%;
            text-align: center;
            color: var(--text-primary);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
        }

        .management-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .management-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 16px;
            background-color: var(--icon-bg);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .management-card:nth-child(1) .management-icon {
            color: #3182ce;
        }

        .management-card:nth-child(2) .management-icon {
            color: #38a169;
        }

        .management-card:nth-child(3) .management-icon {
            color: #d69e2e;
        }

        .management-card:nth-child(4) .management-icon {
            color: #e53e3e;
        }

        .management-title {
            margin-bottom: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .management-subtitle {
            color: var(--text-secondary);
            font-size: 0.85rem;
            margin-bottom: 0;
        }

        .btn-view-all {
            padding: 5px 12px;
            background-color: var(--icon-bg);
            color: var(--text-secondary);
            border-radius: 20px;
            font-size: 0.8rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-view-all:hover {
            background-color: #3182ce;
            color: white;
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: var(--text-secondary);
        }

        /* Selectors i formularis */
        .form-select {
            background-color: var(--card-bg);
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .admin-date {
                margin-top: 10px;
            }
        }

        //* Arreglo para el problema del gráfico que baja sin parar */
        .chart-card {
            height: 400px;
            /* Altura fija */
        }

        .chart-card-body {
            height: calc(100% - 56px);
            /* Altura del contenedor restando el header */
            position: relative;
            overflow: hidden;
            /* Importante: oculta cualquier contenido que sobrepase */
            display: flex;
            /* Usar flexbox para centrar y controlar el tamaño */
            justify-content: center;
            align-items: center;
        }

        .chart-card-body canvas {
            max-width: 100%;
            max-height: 100%;
            width: 100% !important;
            /* Importante para Chart.js */
            height: 100% !important;
            /* Importante para Chart.js */
            display: block;
            /* Elimina espacio extra debajo de los canvas */
        }

        canvas {
            max-height: 100%;
        }

        /* Asegura que los contenedores principales tengan altura adecuada */
        .admin-dashboard {
            background-color: var(--admin-bg);
            min-height: 100vh;
            padding-top: 60px;
            overflow-x: hidden;
            /* Evita scroll horizontal */
        }

        .container-fluid {
            overflow-x: hidden;
            /* Previene scroll horizontal */
        }

        /* Estilos para el encabezado mejorado */
        .header-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 4px 16px var(--card-shadow);
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .header-icon-container {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            background: linear-gradient(135deg, #3182ce, #4299e1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: white;
        }

        .admin-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0;
        }

        .dashboard-breadcrumb {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .dashboard-breadcrumb .separator {
            margin: 0 5px;
            color: var(--text-secondary);
        }

        .dashboard-breadcrumb .active {
            color: #3182ce;
            font-weight: 500;
        }

        .admin-header-right {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 20px;
        }

        .admin-date-container {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .date-item {
            font-size: 0.85rem;
            margin-bottom: 5px;
        }

        .date-label {
            color: var(--text-secondary);
            margin-right: 5px;
        }

        .date-value {
            font-weight: 600;
            color: var(--text-primary);
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-profile-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .admin-profile-name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        .admin-profile-role {
            font-size: 0.8rem;
            color: #3182ce;
        }

        .admin-profile-avatar {
            width: 48px;
            height: 48px;
            overflow: hidden;
            border-radius: 50%;
            border: 2px solid #3182ce;
        }

        .admin-profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        @media (max-width: 992px) {
            .admin-header-right {
                margin-top: 15px;
                justify-content: flex-start;
            }

            .admin-date-container,
            .admin-profile-info {
                align-items: flex-start;
            }
        }

        /* Estilos para la distribución de puntos - Optimizados */
        .points-distribution-container {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .chart-container {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            height: 200px;
        }

        .chart-legend {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        .chart-legend-item {
            display: flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 8px;
            background-color: var(--card-bg);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--border-color);
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 3px;
            margin-right: 8px;
        }

        .legend-text {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-primary);
            white-space: nowrap;
        }

        /* Estilos para DataTables */
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 15px;
        }

        .dataTables_wrapper .dataTables_filter input {
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            background-color: var(--card-bg);
            color: var(--text-primary);
        }

        .dataTables_wrapper .dataTables_length select {
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            background-color: var(--card-bg);
            color: var(--text-primary);
        }

        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 15px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 5px 10px;
            margin: 0 3px;
            border-radius: 5px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #3182ce;
            border-color: #3182ce;
            color: white !important;
        }

        /* Modo oscuro para DataTables */
        body.dark .dataTables_wrapper .dataTables_filter input,
        body.dark .dataTables_wrapper .dataTables_length select {
            background-color: var(--card-bg);
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        body.dark .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #4299e1;
            border-color: #4299e1;
        }

        body.dark .dataTables_wrapper .dataTables_paginate .paginate_button:not(.current) {
            color: var(--text-primary) !important;
        }

        /* Elementos que abren modal */
        .cursor-pointer {
            cursor: pointer;
        }

        .stat-card.cursor-pointer:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .user-ranking-item.cursor-pointer:hover {
            background-color: var(--icon-bg);
            transform: translateX(5px);
        }

        /* Tooltip para indicar acción de clic */
        .cursor-pointer::after {
            content: '';
            position: absolute;
            top: 10px;
            right: 10px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: rgba(49, 130, 206, 0.6);
            transition: all 0.3s ease;
        }

        .cursor-pointer:hover::after {
            background-color: rgba(49, 130, 206, 1);
            transform: scale(1.2);
        }

        /* Estilos para campos editables */
        .editable-field {
            background-color: var(--card-bg);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .editable-field[readonly] {
            background-color: var(--card-bg);
            opacity: 0.8;
            cursor: default;
        }

        .editable-field.editable-active {
            background-color: rgba(49, 130, 206, 0.05);
            border-color: #3182ce;
        }

        /* Indicador visual para campos editables */
        .form-group.has-edit-icon {
            position: relative;
        }

        .form-group.has-edit-icon::after {
            content: '\f044';
            font-family: 'Font Awesome 5 Free';
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0;
            transition: opacity 0.3s ease;
            color: #3182ce;
        }

        .form-group.has-edit-icon:hover::after {
            opacity: 0.7;
        }

        /* Estilos base para todos los modales */
        .modal-dialog {
            position: relative;
        }

        .modal-body {
            overflow-y: auto;
        }

        .modal-content {
            border-radius: 12px;
            overflow: hidden;
        }

        /* Botón de cierre de modales */
        .btn-close {
            font-size: 0.75rem;
            padding: 0.5rem;
            opacity: 0.7;
            width: 30px;
            height: 30px;
        }

        .btn-close:hover {
            opacity: 1;
        }

        /* Estilos específicos por tipo de modal */
        /* Modal dinámico */
        #dynamicModal.modal-users .modal-dialog {
            max-width: 60%;
            max-height: 80vh;
            margin-top: 120px;
        }

        /* Modal de detalles */
        #detailModal .modal-dialog {
            max-width: 80%;
            max-height: 80vh;
            margin-top: 120px;
        }

        #detailModal .modal-content {
            width: 100%;
            margin: 0 auto;
        }

        /* Contenido dentro de modales */
        .user-detail-container {
            padding: 15px;
        }

        .table {
            width: 100%;
            margin-bottom: 0;
        }

        /* Contenido con scroll */
        .modal-body-scroll {
            max-height: calc(80vh - 180px);
            overflow-y: auto;
            padding-right: 5px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            #dynamicModal.modal-users .modal-dialog {
                max-width: 90%;
            }

            #detailModal .modal-dialog {
                max-width: 95%;
                margin: 80px auto;
            }
        }

        /* Quitar los backdrops predeterminados de Bootstrap */
        .modal-backdrop {
            display: none !important;
        }

        /* Modificar los modales para tener fondo semitransparente propio */
        .modal {
            background-color: rgba(0, 0, 0, 0.5) !important;
            /* Fondo oscuro con 50% de opacidad */
            padding-right: 0 !important;
            /* Quitar padding automático */
        }

        /* Asegurar que los modales se muestren correctamente */
        .modal.show {
            display: block !important;
        }

        /* Hacer los modales más visibles con sombras */
        .modal-content {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5) !important;
        }

        /* Ajustes para la jerarquía de modales */
        #dynamicModal {
            z-index: 1050;
        }

        #detailModal {
            z-index: 1060 !important;
            /* Mayor que dynamicModal */
        }

        .modal-backdrop {
            z-index: 1040 !important;
            /* Menor que ambos modales */
        }

        .modal-backdrop+.modal-backdrop {
            z-index: 1055 !important;
            /* Para cuando hay múltiples backdrops */
        }

        /* Asegurar que los campos son accesibles */
        #detailModal input,
        #detailModal select,
        #detailModal textarea,
        #detailModal button {
            z-index: 1070 !important;
            position: relative;
        }

        /* Añade estos estilos a tu CSS */
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
        }

        /* Efecto para botones de eliminar */
        .deleteBtn {
            position: relative;
            overflow: hidden;
        }

        .deleteBtn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }

        .deleteBtn:hover::after {
            animation: ripple 1s ease-out;
        }

        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }

            100% {
                transform: scale(20, 20);
                opacity: 0;
            }
        }

        .btn-close {
            background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
            opacity: 0.5;
        }

        .btn-close:hover {
            opacity: 0.75;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Cargar la biblioteca de gráficos ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.35.3/dist/apexcharts.min.js"></script>
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

                    console.log('Sistema de modales inicializado');
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

                    console.log('Se ha modificado el comportamiento de Modal para prevenir errores de recursión');
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
        // Añadir evento al botón cancelar
        document.getElementById('cancelEditBtn').addEventListener('click', function () {
            // Cerrar modal de forma segura
            const detailModalEl = document.getElementById('detailModal');

            try {
                // Método compatible para cerrar el modal
                if (typeof bootstrap !== 'undefined') {
                    try {
                        const modal = new bootstrap.Modal(detailModalEl);
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
            });
            console.log('Sistema global de eventos inicializado');
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
        });
    </script>
@endsection