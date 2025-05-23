<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Llistat d'Alertes de Punts de Recollida</h5>
    <button id="newAlertaBtn" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal"
        data-detail-type="create-alerta-punt" data-detail-title="Nova Alerta">
        <i class="fas fa-plus-circle me-1"></i> Nova Alerta
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped" id="dynamicTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Punt de Recollida</th>
                <th>Tipus</th>
                <th>Data Creació</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alertes as $alerta)
                <tr>
                    <td>{{ $alerta->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="punto-icon rounded-circle me-2 d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px; background-color: 
                                    @if($alerta->puntDeRecollida)
                                        @switch($alerta->puntDeRecollida->fraccio)
                                            @case('Groc') #f9d71c @break
                                            @case('Blau') #0057b8 @break
                                            @case('Verd') #00a651 @break
                                            @case('Marró') #8c4b00 @break
                                            @case('Gris') #6c757d @break
                                            @case('Punt Verd') #00a651 @break
                                            @default #6c757d @break
                                        @endswitch
                                    @else
                                        #6c757d
                                    @endif
                                ">
                                <i class="fas fa-recycle text-white"></i>
                            </div>
                            <span>{{ $alerta->puntDeRecollida ? $alerta->puntDeRecollida->nom : 'Desconegut' }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-warning">{{ $alerta->tipus ? $alerta->tipus->nom : 'Desconegut' }}</span>
                    </td>
                    <td>{{ $alerta->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="alerta-punt" data-detail-id="{{ $alerta->id }}" title="Veure detalls">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary editAlertaBtn" data-alerta-id="{{ $alerta->id }}"
                                title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm deleteBtn" 
                                data-item-id="{{ $alerta->id }}" 
                                data-item-name="Alerta #{{ $alerta->id }}"
                                data-item-type="alerta-punt">
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
    #newAlertaBtn {
        width: 150px;
    }
</style>