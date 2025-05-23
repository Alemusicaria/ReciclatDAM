<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Llistat de Tipus d'Alertes</h5>
    <button id="newTipusAlertaBtn" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal"
        data-detail-type="create-tipus-alerta" data-detail-title="Nou Tipus d'Alerta">
        <i class="fas fa-plus-circle me-1"></i> Nova Alerta
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped" id="dynamicTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Data Creació</th>
                <th>Alertes Actives</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tipusAlertes as $tipusAlerta)
                <tr>
                    <td>{{ $tipusAlerta->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="alert-icon rounded-circle me-2 d-flex align-items-center justify-content-center" 
                                style="width: 40px; height: 40px; background-color: #ffc107;">
                                <i class="fas fa-bell text-white"></i>
                            </div>
                            <span>{{ $tipusAlerta->nom }}</span>
                        </div>
                    </td>
                    <td>{{ $tipusAlerta->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <span class="badge bg-info">
                            {{ $tipusAlerta->alertes()->count() }} alertes
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="tipus-alerta" data-detail-id="{{ $tipusAlerta->id }}" title="Veure detalls">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary editTipusAlertaBtn" data-tipus-alerta-id="{{ $tipusAlerta->id }}"
                                title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm deleteBtn" 
                                data-item-id="{{ $tipusAlerta->id }}" 
                                data-item-name="{{ $tipusAlerta->nom }}"
                                data-item-type="tipus-alerta"
                                @if($tipusAlerta->alertes()->count() > 0) disabled @endif
                                title="@if($tipusAlerta->alertes()->count() > 0) No es pot eliminar perquè té alertes associades @else Eliminar @endif">
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
    #newTipusAlertaBtn {
        width: 150px;
    }
</style>