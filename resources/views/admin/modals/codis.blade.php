<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Llistat de Codis</h5>
    <button id="newCodiBtn" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal"
        data-detail-type="create-codi" data-detail-title="Nou Codi">
        <i class="fas fa-plus-circle me-1"></i> Nou Codi
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped" id="dynamicTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Codi</th>
                <th>Usuari</th>
                <th>Punts</th>
                <th>Data Escaneig</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($codis as $codi)
                <tr>
                    <td>{{ $codi->id }}</td>
                    <td><code>{{ $codi->codi }}</code></td>
                    <td>
                        @if($codi->user)
                            <div class="d-flex align-items-center">
                                @if($codi->user->foto_perfil)
                                    <img src="{{ asset('storage/' . $codi->user->foto_perfil) }}" class="rounded-circle me-2" width="30" height="30" alt="Perfil">
                                @else
                                    <div class="user-icon-placeholder rounded-circle me-2 d-flex align-items-center justify-content-center bg-secondary" style="width: 30px; height: 30px;">
                                        <i class="fas fa-user text-white small"></i>
                                    </div>
                                @endif
                                {{ $codi->user->nom }} {{ $codi->user->cognoms }}
                            </div>
                        @else
                            <span class="text-muted">No assignat</span>
                        @endif
                    </td>
                    <td><span class="badge bg-success">{{ $codi->punts }} pts</span></td>
                    <td>{{ $codi->data_escaneig->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="codi" data-detail-id="{{ $codi->id }}" title="Veure detalls">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary editCodiBtn" data-codi-id="{{ $codi->id }}"
                                title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm deleteBtn" 
                                data-item-id="{{ $codi->id }}" 
                                data-item-name="Codi #{{ $codi->id }}"
                                data-item-type="codi">
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
    #newCodiBtn {
        width: 150px;
    }
</style>