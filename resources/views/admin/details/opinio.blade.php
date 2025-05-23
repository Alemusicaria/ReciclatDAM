<div class="opinio-detail-container bg-white rounded-lg shadow-sm p-4">
    <div class="opinio-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-start">
                    <div class="opinio-icon-container me-4">
                        <div class="opinio-icon text-white d-flex align-items-center justify-content-center rounded" 
                            style="width: 80px; height: 80px; background-color: #3f51b5;">
                            <i class="fas fa-comment-dots fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="opinio-title mb-1">Opinió #{{ $opinio->id }}</h2>
                        <div class="stars mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $opinio->estrelles ? 'text-warning' : 'text-muted' }} fa-lg"></i>
                            @endfor
                            <span class="ms-2 fw-bold">{{ $opinio->estrelles }}/5</span>
                        </div>
                        <div class="opinio-date">
                            <i class="fas fa-calendar-day text-muted me-2"></i>
                            <span class="text-muted">Publicada el {{ $opinio->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($opinio->updated_at->ne($opinio->created_at))
                            <div class="opinio-update mt-1">
                                <i class="fas fa-edit text-muted me-2"></i>
                                <span class="text-muted">Actualitzada el {{ $opinio->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="autor-info">
                    <div class="autor-card p-3 rounded-3 shadow-sm bg-light d-inline-block text-start">
                        <div class="d-flex align-items-center">
                            <div class="autor-icon rounded-circle me-2 d-flex align-items-center justify-content-center bg-primary text-white" style="width: 50px; height: 50px; font-size: 20px;">
                                {{ substr($opinio->autor, 0, 1) }}
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $opinio->autor }}</h6>
                                <small class="text-muted">Autor</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido de la opinión -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="info-card bg-light p-4 rounded-3 shadow-sm mb-4">
                <h4 class="card-title mb-3">
                    <i class="fas fa-comment text-primary me-2"></i>Comentari
                </h4>
                <div class="opinio-text">
                    <p class="mb-0">{{ $opinio->comentari ?: 'No hi ha comentari disponible.' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .opinio-detail-container {
        border-radius: 8px;
        overflow-y: auto;
        max-height: 70vh;
        padding: 20px;
        margin: 0;
        scrollbar-width: thin;
    }
    
    .opinio-detail-container::-webkit-scrollbar {
        width: 6px;
    }
    
    .opinio-detail-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .opinio-detail-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    body.dark .opinio-detail-container {
        background-color: #2d3748 !important;
    }
    
    body.dark .info-card {
        background-color: #3f4a5c !important;
    }
</style>