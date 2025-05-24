<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">{{ __('messages.admin.productes.list_title') }}</h5>
    <button id="newProducteBtn" class="btn btn-success btn-sm admin-action-btn" data-bs-toggle="modal" data-bs-target="#detailModal"
        data-detail-type="create-producte" data-detail-title="{{ __('messages.admin.productes.new_product') }}">
        <i class="fas fa-plus-circle me-1"></i> {{ __('messages.admin.productes.new_product') }}
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped admin-table" id="dynamicTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('messages.admin.productes.name') }}</th>
                <th>{{ __('messages.admin.productes.category') }}</th>
                <th>{{ __('messages.admin.common.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productes as $producte)
                <tr>
                    <td>{{ $producte->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($producte->imatge)
                                <img src="{{ asset($producte->imatge) }}" class="product-image rounded me-2" alt="{{ __('messages.admin.productes.product_image') }}">
                            @else
                                <div class="product-icon-placeholder rounded me-2 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-box text-white"></i>
                                </div>
                            @endif
                            <span>{{ $producte->nom }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge category-badge category-{{ strtolower($producte->categoria) }}">
                            {{ $producte->categoria }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="producte" data-detail-id="{{ $producte->id }}" title="{{ __('messages.admin.common.view_details') }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary editProducteBtn" data-producte-id="{{ $producte->id }}"
                                title="{{ __('messages.admin.common.edit') }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm deleteBtn" data-item-id="{{ $producte->id }}"
                                data-item-name="{{ $producte->nom }}" data-item-type="producte"
                                title="{{ __('messages.admin.common.delete') }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>