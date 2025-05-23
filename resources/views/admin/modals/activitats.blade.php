<div class="table-responsive">
    <table class="table table-striped" id="activitatsTable">
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
                        @if($activitat->user)
                            <div class="d-flex align-items-center">
                                @if($activitat->user->foto_perfil)
                                    <img src="{{ ($activitat->user && $activitat->user->foto_perfil) ?
                                        (Str::startsWith($activitat->user->foto_perfil, ['http://', 'https://']) ?
                                            $activitat->user->foto_perfil :
                                            (file_exists(public_path('storage/' . $activitat->user->foto_perfil)) ?
                                                asset('storage/' . $activitat->user->foto_perfil) :
                                                asset('images/default-profile.png')
                                            )
                                        ) :
                                        asset('images/default-profile.png') 
                                    }}" class="rounded-circle me-2" width="30" height="30" alt="Perfil">
                                @else
                                    <div class="user-icon-placeholder rounded-circle me-2 d-flex align-items-center justify-content-center bg-secondary" style="width: 30px; height: 30px;">
                                        <i class="fas fa-user text-white small"></i>
                                    </div>
                                @endif
                                {{ $activitat->user->nom }} {{ $activitat->user->cognoms }}
                            </div>
                        @else
                            <span class="text-muted">Usuari desconegut</span>
                        @endif
                    </td>
                    <td>{{ $activitat->action }}</td>
                    <td>{{ $activitat->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info view-activity-details" 
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

<script>
// Función para inicializar DataTables
function initActivitatsDataTable() {
    // Comprobar si DataTables ya está inicializado
    if ($.fn.DataTable.isDataTable('#activitatsTable')) {
        // Si ya está inicializado, destruirlo primero
        $('#activitatsTable').DataTable().destroy();
    }
    
    // Reinicializar DataTables
    $('#activitatsTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/ca.json'
        },
        order: [[0, 'desc']], // Ordenar por ID descendente por defecto
        pageLength: 10,        // Elementos por página
        responsive: true,
        dom: '<"top"f>rt<"bottom"lp><"clear">',
        columnDefs: [
            { orderable: false, targets: 4 } // La columna de acciones no es ordenable
        ]
    });
}

// Inicializar DataTables cuando el DOM esté listo
$(document).ready(function() {
    // Esperar un poco para asegurar que la tabla se ha renderizado completamente
    setTimeout(function() {
        initActivitatsDataTable();
    }, 100);
});

// Delegación de eventos para botones de detalle
$(document).on('click', '.view-activity-details', function(e) {
    e.preventDefault();
    const activityId = $(this).data('detail-id');
    
    // Cerrar modal dinámico si está abierto
    if ($('#dynamicModal').hasClass('show')) {
        $('#dynamicModal').modal('hide');
    }
    
    // Configurar y abrir modal de detalles
    const detailModal = $('#detailModal');
    const modalTitle = $('#detailModalLabel');
    const modalLoader = $('#detail-modal-loader');
    const detailContent = $('#detail-content');
    
    modalTitle.text("Detalls de l'Activitat");
    modalLoader.removeClass('d-none');
    detailContent.addClass('d-none');
    
    detailModal.modal('show');
    
    // Cargar contenido
    fetch(`/admin/detail/activitat/${activityId}`)
        .then(response => {
            if (!response.ok) throw new Error('Error al cargar los detalles');
            return response.text();
        })
        .then(html => {
            modalLoader.addClass('d-none');
            detailContent.html(html).removeClass('d-none');
        })
        .catch(error => {
            console.error('Error:', error);
            modalLoader.addClass('d-none');
            detailContent.html(`
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error al cargar los detalles: ${error.message}
                </div>
            `).removeClass('d-none');
        });
});
</script>