<div class="rol-detail-container bg-white rounded-lg shadow-sm p-4">
    <div class="rol-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <div class="rol-icon me-3">
                        <span class="rol-badge rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background-color: 
                            @if($rol->id == 1) #dc3545 @elseif($rol->id == 2) #fd7e14 @else #28a745 @endif; color: white;">
                            <i class="fas fa-user-tag fa-2x"></i>
                        </span>
                    </div>
                    <div>
                        <h2 class="mb-1">{{ $rol->nom }}</h2>
                        <div class="mt-2">
                            <span class="badge bg-info">
                                <i class="fas fa-users me-1"></i> {{ $rol->users()->count() }} usuaris amb aquest rol
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="info-card bg-light p-4 rounded-3 shadow-sm">
                <h4 class="card-title mb-3">
                    <i class="fas fa-users text-success me-2"></i>Usuaris amb aquest rol
                </h4>
                
                @if($rol->users()->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless">
                            <thead class="table-light">
                                <tr>
                                    <th>Usuari</th>
                                    <th>Email</th>
                                    <th>Data registre</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rol->users()->take(10)->get() as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($user->foto_perfil)
                                                    <img src="{{ asset('storage/' . $user->foto_perfil) }}" class="rounded-circle me-2" width="40" height="40" alt="Perfil">
                                                @else
                                                    <div class="user-icon-placeholder rounded-circle me-2 d-flex align-items-center justify-content-center bg-secondary" style="width: 40px; height: 40px;">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                @endif
                                                {{ $user->nom }} {{ $user->cognoms }}
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        @if($rol->users()->count() > 10)
                            <div class="text-center mt-3">
                                <span class="text-muted">Mostrant 10 de {{ $rol->users()->count() }} usuaris</span>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="empty-state text-center py-4">
                        <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                        <p class="lead">No hi ha usuaris assignats a aquest rol</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .rol-detail-container {
        border-radius: 8px;
        overflow-y: auto;
        max-height: 70vh;
        padding: 20px;
        margin: 0;
        scrollbar-width: thin;
    }
    
    .rol-detail-container::-webkit-scrollbar {
        width: 6px;
    }
    
    .rol-detail-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .rol-detail-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    body.dark .rol-detail-container {
        background-color: #2d3748 !important;
    }
    
    body.dark .info-card {
        background-color: #3f4a5c !important;
    }
</style>