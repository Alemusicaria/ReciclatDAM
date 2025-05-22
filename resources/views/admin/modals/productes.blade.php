<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Llistat de Productes</h5>
    <button id="newProducteBtn" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal"
        data-detail-type="create-producte" data-detail-title="Nou Producte">
        <i class="fas fa-plus-circle me-1"></i> Nou Producte
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped" id="dynamicTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Categoria</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productes as $producte)
                <tr>
                    <td>{{ $producte->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($producte->imatge)
                                <img src="{{ asset($producte->imatge) }}" class="rounded me-2" width="40"
                                    height="40" alt="Producte" style="object-fit: cover; margin-right: 10px;">
                            @else
                                <div class="product-icon-placeholder rounded me-2 d-flex align-items-center justify-content-center" 
                                    style="width: 40px; height: 40px; background-color: #4caf50;">
                                    <i class="fas fa-box text-white"></i>
                                </div>
                            @endif
                            <span>{{ $producte->nom }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-primary">{{ $producte->categoria }}</span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="producte" data-detail-id="{{ $producte->id }}" title="Veure detalls">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary editProducteBtn" data-producte-id="{{ $producte->id }}"
                                title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm deleteBtn" 
                                data-item-id="{{ $producte->id }}" 
                                data-item-name="{{ $producte->nom }}"
                                data-item-type="producte">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<style>
    #newProducteBtn {
        width: 150px;
    }
</style>