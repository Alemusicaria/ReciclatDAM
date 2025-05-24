<div class="detail-container producte-detail-container">
    <!-- Encabezado del producto -->
    <div class="detail-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-start">
                    <div class="detail-image-container me-4">
                        @if($producte->imatge)
                            <img src="{{ asset($producte->imatge) }}" class="detail-image rounded" alt="{{ __('messages.admin.products.product_image') }}">
                        @else
                            <div class="detail-icon producte-icon d-flex align-items-center justify-content-center rounded">
                                <i class="fas fa-box fa-3x"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h2 class="detail-name mb-1">{{ $producte->nom }}</h2>
                        <div class="producte-category mb-2">
                            <span class="badge bg-primary py-1 px-2">
                                <i class="fas fa-tag me-1"></i>{{ $producte->categoria }}
                            </span>
                        </div>
                        <div class="product-info mt-3">
                            <div class="text-muted">
                                <i class="fas fa-info-circle me-2"></i>
                                {{ __('messages.admin.products.category_description', ['category' => $producte->categoria]) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>