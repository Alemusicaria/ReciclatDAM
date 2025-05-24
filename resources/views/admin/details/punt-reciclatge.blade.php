<div class="detail-container punt-detail-container">
    <div class="detail-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-start">
                    <div class="detail-icon-container me-4">
                        <div class="detail-icon punto-{{ strtolower(str_replace(' ', '-', $punt->fraccio)) }} d-flex align-items-center justify-content-center rounded">
                            <i class="fas fa-recycle fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="detail-name mb-1">{{ $punt->nom }}</h2>
                        <div class="punt-fraccio mb-2">
                            <span class="badge fraccio-badge punto-{{ strtolower(str_replace(' ', '-', $punt->fraccio)) }}">
                                <i class="fas fa-tag me-1"></i>{{ $punt->fraccio }}
                            </span>
                            
                            @if($punt->disponible)
                                <span class="badge bg-success ms-2">{{ __('messages.admin.collection_points.available') }}</span>
                            @else
                                <span class="badge bg-danger ms-2">{{ __('messages.admin.collection_points.not_available') }}</span>
                            @endif
                        </div>
                        <div class="punt-address">
                            <i class="fas fa-map-marker-alt text-muted me-2"></i>
                            <span class="text-muted">{{ $punt->adreca }}, {{ $punt->ciutat }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="map-thumbnail">
                    <img src="https://api.mapbox.com/styles/v1/mapbox/streets-v11/static/pin-l+f74e4e({{ $punt->longitud }},{{ $punt->latitud }})/{{ $punt->longitud }},{{ $punt->latitud }},15,0/300x200?access_token=pk.eyJ1IjoibGF1dG9yaW5vIiwiYSI6ImNscDg0cGZmeTBreGsyaW1ubzJxeGpkdmgifQ.S3sLvRUHOE3p4JKdTLnU2A" 
                         class="img-fluid rounded shadow-sm" alt="{{ __('messages.admin.collection_points.map') }}">
                </div>
            </div>
        </div>
    </div>

    <!-- Coordenadas -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="info-card mb-4">
                <h4 class="card-title mb-3">
                    <i class="fas fa-map-pin text-primary me-2"></i>{{ __('messages.admin.collection_points.coordinates') }}
                </h4>
                <div class="coord-info d-flex flex-wrap">
                    <div class="me-4 mb-2">
                        <span class="text-muted">{{ __('messages.admin.collection_points.latitude') }}:</span>
                        <code class="ms-2">{{ $punt->latitud }}</code>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted">{{ __('messages.admin.collection_points.longitude') }}:</span>
                        <code class="ms-2">{{ $punt->longitud }}</code>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>