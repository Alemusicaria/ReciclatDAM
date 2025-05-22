<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Llistat de Premis</h5>
    <button id="newPremiBtn" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal"
        data-detail-type="create-premi" data-detail-title="Nou Premi">
        <i class="fas fa-plus-circle me-1"></i> Nou Premi
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped" id="dynamicTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Punts Requerits</th>
                <th>Reclamats</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($premis as $premi)
                <tr>
                    <td>{{ $premi->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($premi->imatge)
                                <img src="{{ asset($premi->imatge) }}" class="rounded me-2" width="40"
                                    height="40" alt="Premi" style="object-fit: cover; margin-right: 10px;">
                            @else
                                <div class="premi-icon-placeholder rounded me-2 d-flex align-items-center justify-content-center" 
                                    style="width: 40px; height: 40px; background-color: #ff9800;">
                                    <i class="fas fa-gift text-white"></i>
                                </div>
                            @endif
                            <span>{{ $premi->nom }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-primary">
                            {{ $premi->punts_requerits }} pts
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-info">
                            {{ $premi->premiReclamats()->count() }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="premi" data-detail-id="{{ $premi->id }}" title="Veure detalls">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary editPremiBtn" data-premi-id="{{ $premi->id }}"
                                title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm deleteBtn" 
                                data-item-id="{{ $premi->id }}" 
                                data-item-name="{{ $premi->nom }}"
                                data-item-type="premi">
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
    #newPremiBtn {
        width: 150px;
    }
</style>