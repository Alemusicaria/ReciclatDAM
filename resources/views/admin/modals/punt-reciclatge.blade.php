<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Llistat de Punts de Recollida</h5>
    <button id="newPuntBtn" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal"
        data-detail-type="create-punt-reciclatge" data-detail-title="Nou Punt de Recollida">
        <i class="fas fa-plus-circle me-1"></i> Nou Punt
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped" id="dynamicTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Fracció</th>
                <th>Ubicació</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($punts as $punt)
                <tr>
                    <td>{{ $punt->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="punto-icon rounded-circle me-2 d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px; background-color: 
                                    @switch($punt->fraccio)
                                        @case('Groc') #f9d71c @break
                                        @case('Blau') #0057b8 @break
                                        @case('Verd') #00a651 @break
                                        @case('Marró') #8c4b00 @break
                                        @case('Gris') #6c757d @break
                                        @case('Punt Verd') #00a651 @break
                                        @default #6c757d @break
                                    @endswitch
                                ">
                                <i class="fas fa-recycle text-white"></i>
                            </div>
                            <span>{{ $punt->nom }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge" style="background-color: 
                            @switch($punt->fraccio)
                                @case('Groc') #f9d71c; color: #000 @break
                                @case('Blau') #0057b8 @break
                                @case('Verd') #00a651 @break
                                @case('Marró') #8c4b00 @break
                                @case('Gris') #6c757d @break
                                @case('Punt Verd') #00a651 @break
                                @default #6c757d @break
                            @endswitch
                        ">
                            {{ $punt->fraccio }}
                        </span>
                    </td>
                    <td>{{ $punt->ciutat }}, {{ $punt->adreca }}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="punt-reciclatge" data-detail-id="{{ $punt->id }}" title="Veure detalls">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary editPuntBtn" data-punt-id="{{ $punt->id }}"
                                title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm deleteBtn" 
                                data-item-id="{{ $punt->id }}" 
                                data-item-name="{{ $punt->nom }}"
                                data-item-type="punt-reciclatge">
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
    #newPuntBtn {
        width: 150px;
    }
</style>