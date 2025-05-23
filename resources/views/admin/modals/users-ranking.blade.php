<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Classificació d'Usuaris</h5>
</div>

<div class="table-responsive">
    <table class="table table-striped" id="usersRankingTable">
        <thead>
            <tr>
                <th>Posició</th>
                <th>Usuari</th>
                <th>Nivell</th>
                <th>Punts Totals</th>
                <th>Punts Actuals</th>
                <th>Detalls</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $key => $user)
                    <tr>
                        <td>
                            <div class="ranking-position {{ $key < 3 ? 'top-' . ($key + 1) : '' }}">{{ $key + 1 }}</div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $user->foto_perfil ?
                (Str::startsWith($user->foto_perfil, ['http://', 'https://']) ?
                    $user->foto_perfil :
                    (file_exists(public_path('storage/' . $user->foto_perfil)) ?
                        asset('storage/' . $user->foto_perfil) :
                        asset('images/default-profile.png')
                    )
                ) :
                asset('images/default-profile.png') 
                                    }}" class="rounded-circle me-2" width="40" height="40" alt="Perfil">
                                <div>
                                    <span class="d-block fw-medium">{{ $user->nom }} {{ $user->cognoms }}</span>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php    $nivellInfo = $user->nivell(); ?>
                            <span class="badge bg-info">{{ $nivellInfo ? $nivellInfo->nom : 'Usuari' }}</span>
                        </td>
                        <td>
                            <span class="badge bg-success">{{ $user->punts_totals }} pts</span>
                        </td>
                        <td>
                            <span class="badge bg-primary">{{ $user->punts_actuals }} pts</span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                    data-detail-type="user" data-detail-id="{{ $user->id }}" title="Veure detalls">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
            @endforeach
        </tbody>
    </table>
</div>

<style>
    .ranking-position {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #6c757d;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .ranking-position.top-1 {
        background-color: gold;
        color: #000;
    }

    .ranking-position.top-2 {
        background-color: silver;
        color: #000;
    }

    .ranking-position.top-3 {
        background-color: #cd7f32;
        /* bronce */
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inicializar DataTables
        $('#usersRankingTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/ca.json'
            },
            order: [[4, 'desc']], // Cambiar a ordenar por puntos actuales (columna 4)
            pageLength: 10,
            responsive: true,
            dom: '<"top"f>rt<"bottom"lp><"clear">',
            columnDefs: [
                { orderable: false, targets: 5 } // La columna de acciones no es ordenable
            ]
        });
    });
</script>