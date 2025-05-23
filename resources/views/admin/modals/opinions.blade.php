<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Llistat d'Opinions</h5>
</div>

<div class="table-responsive">
    <table class="table table-striped" id="opinionsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Autor</th>
                <th>Valoració</th>
                <th>Comentari</th>
                <th>Data</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($opinions as $opinio)
                <tr>
                    <td>{{ $opinio->id }}</td>
                    <td>{{ $opinio->autor }}</td>
                    <td>
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $opinio->estrelles ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                        </div>
                    </td>
                    <td>{{ \Illuminate\Support\Str::limit($opinio->comentari, 50) }}</td>
                    <td>{{ $opinio->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="opinio" data-detail-id="{{ $opinio->id }}" title="Veure detalls">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-danger btn-sm deleteBtn" 
                                data-item-id="{{ $opinio->id }}" 
                                data-item-name="Opinió #{{ $opinio->id }}"
                                data-item-type="opinio">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar DataTables
        $('#opinionsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/ca.json'
            },
            order: [[4, 'desc']], // Ordenar por fecha descendente
            pageLength: 10,
            responsive: true,
            dom: '<"top"f>rt<"bottom"lp><"clear">',
            columnDefs: [
                { orderable: false, targets: 5 } // La columna de acciones no es ordenable
            ]
        });
    });
</script>