<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Llistat d'Usuaris</h5>
    <button id="newUserBtn" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal"
        data-detail-type="create-user" data-detail-title="Nou Usuari">
        <i class="fas fa-plus-circle me-1"></i> Nou Usuari
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped" id="dynamicTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Punts</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($user->foto_perfil)
                                @if(str_starts_with($user->foto_perfil, 'https://'))
                                    <img src="{{ $user->foto_perfil }}" class="rounded-circle me-2" width="30" height="30"
                                        alt="Perfil" style="margin-right: 10px;">
                                @elseif(file_exists(public_path('storage/' . $user->foto_perfil)))
                                    <img src="{{ asset('storage/' . $user->foto_perfil) }}" class="rounded-circle me-2" width="30"
                                        height="30" alt="Perfil" style="margin-right: 10px;">
                                @else
                                    <img src="{{ asset('images/default-profile.png') }}" class="rounded-circle me-2" width="30"
                                        height="30" alt="Perfil" style="margin-right: 10px;">
                                @endif
                            @else
                                <img src="{{ asset('images/default-profile.png') }}" class="rounded-circle me-2" width="30"
                                    height="30" alt="Perfil" style="margin-right: 10px;">
                            @endif
                            {{ $user->nom }} {{ $user->cognoms }}
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->punts_actuals }}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="user" data-detail-id="{{ $user->id }}" title="Veure detalls">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary editUserBtn" data-user-id="{{ $user->id }}"
                                title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <!-- Botón eliminar actualizado con el nuevo formato -->
                            <button class="btn btn-danger btn-sm deleteBtn" 
                                data-item-id="{{ $user->id }}" 
                                data-item-name="{{ $user->nom }} {{ $user->cognoms }}"
                                data-item-type="user">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Estilo adicional para asegurar que el botón de cerrar se muestra correctamente -->
<style>
    .btn-close {
        background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
        opacity: 0.5;
    }

    .btn-close:hover {
        opacity: 0.75;
    }

    .modal-header .btn-close {
        padding: 0.5rem 0.5rem;
        margin: -0.5rem -0.5rem -0.5rem auto;
    }

    #newUserBtn {
        width: 150px;
    }
</style>
