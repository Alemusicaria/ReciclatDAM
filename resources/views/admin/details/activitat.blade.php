<div class="activitat-detail-container bg-white rounded-lg shadow-sm p-4">
    <div class="activitat-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="d-flex align-items-start">
                    <div class="activitat-icon-container me-4">
                        <div class="activitat-icon text-white d-flex align-items-center justify-content-center rounded" 
                            style="width: 80px; height: 80px; background-color: #3f51b5;">
                            <i class="fas fa-history fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="mb-1">Activitat #{{ $activitat->id }}</h4>
                        <div class="activitat-date">
                            <i class="fas fa-calendar-day text-muted me-2"></i>
                            <span class="text-muted">Registrada el {{ $activitat->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="info-card bg-light p-4 rounded-3 shadow-sm mb-4">
                <h4 class="card-title mb-3">
                    <i class="fas fa-info-circle text-primary me-2"></i>Detalls de l'Activitat
                </h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="fw-bold">Acció realitzada:</label>
                            <p>{{ $activitat->action }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="fw-bold">Data i hora:</label>
                            <p>{{ $activitat->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($activitat->user)
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="info-card bg-light p-4 rounded-3 shadow-sm">
                <h4 class="card-title mb-3">
                    <i class="fas fa-user text-success me-2"></i>Usuari
                </h4>
                <div class="row align-items-center">
                    <div class="col-md-2">
                        <img src="{{ $activitat->user->foto_perfil ? 
                            (Str::startsWith($activitat->user->foto_perfil, ['http://', 'https://']) ?
                                $activitat->user->foto_perfil :
                                (file_exists(public_path('storage/' . $activitat->user->foto_perfil)) ?
                                    asset('storage/' . $activitat->user->foto_perfil) :
                                    asset('images/default-profile.png')
                                )
                            ) :
                            asset('images/default-profile.png') 
                        }}" alt="Foto perfil" class="img-fluid rounded-circle" style="max-width: 100px;">
                    </div>
                    <div class="col-md-10">
                        <table class="table table-borderless">
                            <tr>
                                <th style="width: 150px;">Nom:</th>
                                <td>{{ $activitat->user->nom }} {{ $activitat->user->cognoms }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $activitat->user->email }}</td>
                            </tr>
                            <tr>
                                <th>Rol:</th>
                                <td>{{ $activitat->user->rol->nom ?? 'No assignat' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
    .activitat-detail-container {
        border-radius: 8px;
        overflow-y: auto;
        max-height: 70vh;
        padding: 20px;
        margin: 0;
        scrollbar-width: thin;
    }
    
    .activitat-detail-container::-webkit-scrollbar {
        width: 6px;
    }
    
    .activitat-detail-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .activitat-detail-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    body.dark .activitat-detail-container {
        background-color: #2d3748 !important;
    }
    
    body.dark .info-card {
        background-color: #3f4a5c !important;
    }
</style>