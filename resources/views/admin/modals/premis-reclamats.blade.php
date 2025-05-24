<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Premis Reclamats</h5>
    <div>
        <div class="btn-group me-2">
            <button class="btn btn-sm btn-outline-primary" id="filterAllBtn">Tots</button>
            <button class="btn btn-sm btn-outline-warning" id="filterPendingBtn">Pendents</button>
            <button class="btn btn-sm btn-outline-info" id="filterProcessingBtn">Processant</button>
            <button class="btn btn-sm btn-outline-success" id="filterDeliveredBtn">Entregats</button>
            <button class="btn btn-sm btn-outline-danger" id="filterCanceledBtn">Cancel·lats</button>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped" id="premisReclamatsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuari</th>
                <th>Premi</th>
                <th>Punts</th>
                <th>Estat</th>
                <th>Data</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($premisReclamats as $premiReclamat)
                <tr data-status="{{ $premiReclamat->estat }}">
                    <td>{{ $premiReclamat->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($premiReclamat->user && $premiReclamat->user->foto_perfil)
                                            <img src="{{ Str::startsWith($premiReclamat->user->foto_perfil, ['http://', 'https://']) ?
                                $premiReclamat->user->foto_perfil :
                                asset('storage/' . $premiReclamat->user->foto_perfil) }}" class="rounded-circle me-2"
                                                width="30" height="30" alt="Perfil">
                            @else
                                <div class="user-icon-placeholder rounded-circle me-2 d-flex align-items-center justify-content-center bg-secondary"
                                    style="width: 30px; height: 30px;">
                                    <i class="fas fa-user text-white small"></i>
                                </div>
                            @endif
                            {{ $premiReclamat->user ? $premiReclamat->user->nom . ' ' . $premiReclamat->user->cognoms : 'Usuari desconegut' }}
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($premiReclamat->premi && $premiReclamat->premi->imatge)
                                <img src="{{ asset($premiReclamat->premi->imatge) }}" class="rounded me-2" width="30"
                                    height="30" alt="Premi">
                            @else
                                <div class="prize-icon-placeholder rounded me-2 d-flex align-items-center justify-content-center"
                                    style="width: 30px; height: 30px; background-color: #ff9800;">
                                    <i class="fas fa-gift text-white small"></i>
                                </div>
                            @endif
                            {{ $premiReclamat->premi ? $premiReclamat->premi->nom : 'Premi desconegut' }}
                        </div>
                    </td>
                    <td><span class="badge bg-primary">{{ $premiReclamat->punts_gastats }} pts</span></td>
                    <td>
                        @if($premiReclamat->estat == 'pendent')
                            <span class="badge bg-warning text-dark">Pendent</span>
                        @elseif($premiReclamat->estat == 'procesant')
                            <span class="badge bg-info">Processant</span>
                        @elseif($premiReclamat->estat == 'entregat')
                            <span class="badge bg-success">Entregat</span>
                        @elseif($premiReclamat->estat == 'cancelat')
                            <span class="badge bg-danger">Cancel·lat</span>
                        @endif
                    </td>
                    <td>{{ $premiReclamat->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="premi-reclamat" data-detail-id="{{ $premiReclamat->id }}"
                                title="Veure detalls">
                                <i class="fas fa-eye"></i>
                            </button>

                            @if($premiReclamat->estat == 'pendent')
                                <form method="POST" action="{{ route('admin.premis-reclamats.approve', $premiReclamat->id) }}"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success"
                                        onclick="return confirm('Estàs segur que vols aprovar aquesta sol·licitud?');">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('admin.premis-reclamats.reject', $premiReclamat->id) }}"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Estàs segur que vols rebutjar aquesta sol·licitud?');">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @endif

                            @if($premiReclamat->estat != 'entregat')
                                <button class="btn btn-sm btn-primary editPremiReclamatBtn" data-id="{{ $premiReclamat->id }}"
                                    title="Actualitzar estat">
                                    <i class="fas fa-edit"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inicializar DataTables
        const table = $('#premisReclamatsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/ca.json'
            },
            order: [[5, 'desc']], // Ordenar por fecha descendente
            responsive: true,
            dom: '<"top"f>rt<"bottom"lp><"clear">'
        });

        // Filtros de estado
        $('#filterAllBtn').on('click', function () {
            table.search('').columns().search('').draw();
            setActiveFilter(this);
        });

        $('#filterPendingBtn').on('click', function () {
            table.column(4).search('Pendent').draw();
            setActiveFilter(this);
        });

        $('#filterProcessingBtn').on('click', function () {
            table.column(4).search('Processant').draw();
            setActiveFilter(this);
        });

        $('#filterDeliveredBtn').on('click', function () {
            table.column(4).search('Entregat').draw();
            setActiveFilter(this);
        });

        $('#filterCanceledBtn').on('click', function () {
            table.column(4).search('Cancel·lat').draw();
            setActiveFilter(this);
        });

        function setActiveFilter(button) {
            $('.btn-outline-primary, .btn-outline-warning, .btn-outline-info, .btn-outline-success, .btn-outline-danger')
                .removeClass('active');
            $(button).addClass('active');
        }

        // Activar por defecto el botón de pendientes
        $('#filterPendingBtn').click();

        $('.approveBtn').on('click', function () {
            const id = $(this).data('id');
            if (confirm('Estàs segur que vols aprovar aquesta sol·licitud?')) {
                $.ajax({
                    url: "{{ route('admin.premis-reclamats.approve', '') }}/" + id,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success('Sol·licitud aprovada correctament');
                            // Recargar la tabla
                            window.location.reload();
                        }
                    },
                    error: function (xhr) {
                        toastr.error('Error al aprovar la sol·licitud');
                        console.error(xhr.responseText);
                    }
                });
            }
        });

        $('.rejectBtn').on('click', function () {
            const id = $(this).data('id');
            if (confirm('Estàs segur que vols rebutjar aquesta sol·licitud?')) {
                $.ajax({
                    url: "{{ route('admin.premis-reclamats.reject', '') }}/" + id,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success('Sol·licitud rebutjada correctament');
                            // Recargar la tabla
                            window.location.reload();
                        }
                    },
                    error: function (xhr) {
                        toastr.error('Error al rebutjar la sol·licitud');
                        console.error(xhr.responseText);
                    }
                });
            }
        });

        $('.editStatusBtn').on('click', function () {
            const id = $(this).data('id');

            // Obtener el estado actual para pre-seleccionarlo
            const currentStatus = $(this).closest('tr').data('status');

            // Crear el modal
            const modal = $(`
                <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Actualitzar estat</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="updateStatusForm">
                                    <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                    <div class="mb-3">
                                        <label for="estatSelect" class="form-label">Estat</label>
                                        <select class="form-select" id="estatSelect" name="estat">
                                            <option value="pendent" ${currentStatus === 'pendent' ? 'selected' : ''}>Pendent</option>
                                            <option value="procesant" ${currentStatus === 'procesant' ? 'selected' : ''}>Processant</option>
                                            <option value="entregat" ${currentStatus === 'entregat' ? 'selected' : ''}>Entregat</option>
                                            <option value="cancelat" ${currentStatus === 'cancelat' ? 'selected' : ''}>Cancel·lat</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="codiSeguiment" class="form-label">Codi de seguiment</label>
                                        <input type="text" class="form-control" id="codiSeguiment" name="codi_seguiment">
                                    </div>
                                    <div class="mb-3">
                                        <label for="comentaris" class="form-label">Comentaris</label>
                                        <textarea class="form-control" id="comentaris" name="comentaris" rows="3"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel·lar</button>
                                <button type="button" class="btn btn-primary" id="saveStatusBtn">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            `);

            // Añadir a la página y mostrar
            $('body').append(modal);
            const modalInstance = new bootstrap.Modal(document.getElementById('updateStatusModal'));
            modalInstance.show();

            // Manejar el guardado
            $('#saveStatusBtn').on('click', function () {
                const btn = $(this);
                btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardant...');
                btn.prop('disabled', true);

                $.ajax({
                    url: `/admin/premis-reclamats/${id}`,
                    type: 'POST',
                    data: {
                        _method: 'PUT',
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        estat: $('#estatSelect').val(),
                        codi_seguiment: $('#codiSeguiment').val(),
                        comentaris: $('#comentaris').val(),
                    },
                    success: function (response) {
                        alert('Estat actualitzat correctament');
                        modalInstance.hide();
                        // Recargar el modal
                        const contentTypeBtn = document.querySelector('[data-content-type="premis-reclamats"]');
                        if (contentTypeBtn) contentTypeBtn.click();
                        else window.location.reload();
                    },
                    error: function (xhr) {
                        alert('Error al actualitzar l\'estat');
                        console.error(xhr.responseText);
                        btn.html('Guardar');
                        btn.prop('disabled', false);
                    }
                });
            });

            // Limpiar modal al cerrar
            document.getElementById('updateStatusModal').addEventListener('hidden.bs.modal', function () {
                modal.remove();
            });
        });
    });
</script>