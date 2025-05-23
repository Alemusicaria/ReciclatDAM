<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Llistat de Rols</h5>
    <button id="newRolBtn" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal"
        data-detail-type="create-rol" data-detail-title="Nou Rol">
        <i class="fas fa-plus-circle me-1"></i> Nou Rol
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped" id="dynamicTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Usuaris</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rols as $rol)
                <tr>
                    <td>{{ $rol->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="rol-icon-container me-2">
                                <span class="rol-badge badge" style="background-color: 
                                    @if($rol->id == 1) #dc3545 @elseif($rol->id == 2) #fd7e14 @else #28a745 @endif
                                ">
                                    <i class="fas fa-user-tag"></i>
                                </span>
                            </div>
                            <span>{{ $rol->nom }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-info">
                            {{ $rol->users_count ?? $rol->users()->count() }} usuaris
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="rol" data-detail-id="{{ $rol->id }}" title="Veure detalls">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary editRolBtn" data-rol-id="{{ $rol->id }}"
                                title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm deleteBtn" 
                                data-item-id="{{ $rol->id }}" 
                                data-item-name="{{ $rol->nom }}"
                                data-item-type="rol"
                                @if($rol->users()->count() > 0) disabled @endif
                                title="@if($rol->users()->count() > 0) No es pot eliminar perquè té usuaris assignats @else Eliminar @endif">
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
    #newRolBtn {
        width: 150px;
    }
    
    .rol-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        color: white;
    }
</style>