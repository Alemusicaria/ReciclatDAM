<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Historial d'Activitat</h5>
</div>

<div class="table-responsive">
    <table class="table table-striped" id="dynamicTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuari</th>
                <th>Acció</th>
                <th>Data</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activitats as $activitat)
                <tr>
                    <td>{{ $activitat->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ ($activitat->user && $activitat->user->foto_perfil) ?
                                (Str::startsWith($activitat->user->foto_perfil, ['http://', 'https://']) ?
                                    $activitat->user->foto_perfil :
                                    (file_exists(public_path('storage/' . $activitat->user->foto_perfil)) ?
                                        asset('storage/' . $activitat->user->foto_perfil) :
                                        asset('images/default-profile.png')
                                    )
                                ) :
                                asset('images/default-profile.png') 
                            }}" alt="Foto perfil" class="rounded-circle me-2" width="40" height="40">
                            <div>
                                <span class="d-block">{{ $activitat->user->nom ?? 'Usuari' }} {{ $activitat->user->cognoms ?? '' }}</span>
                                <small class="text-muted">{{ $activitat->user->email ?? 'sense email' }}</small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $activitat->action }}</td>
                    <td>{{ $activitat->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info view-activity-details" 
                                data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="activitat" data-detail-id="{{ $activitat->id }}" 
                                title="Veure detalls">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>