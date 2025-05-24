<div class="premi-reclamat-detail-container bg-white rounded-lg shadow-sm p-4">
    <div class="premi-reclamat-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="d-flex align-items-start">
                    <div class="premi-icon-container me-4">
                        @if($premiReclamat->premi && $premiReclamat->premi->imatge)
                            <img src="{{ asset($premiReclamat->premi->imatge) }}" alt="Premi" class="rounded" width="80"
                                height="80" style="object-fit: cover;">
                        @else
                            <div class="premi-icon text-white d-flex align-items-center justify-content-center rounded"
                                style="width: 80px; height: 80px; background-color: #ff9800;">
                                <i class="fas fa-gift fa-2x"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h2 class="premi-name mb-1">
                            {{ $premiReclamat->premi ? $premiReclamat->premi->nom : 'Premi desconegut' }}
                        </h2>
                        <div class="premi-info mb-2">
                            <span class="badge bg-primary">{{ $premiReclamat->punts_gastats }} punts</span>
                            @if($premiReclamat->estat == 'pendent')
                                <span class="badge bg-warning text-dark ms-2">Pendent</span>
                            @elseif($premiReclamat->estat == 'procesant')
                                <span class="badge bg-info ms-2">Processant</span>
                            @elseif($premiReclamat->estat == 'entregat')
                                <span class="badge bg-success ms-2">Entregat</span>
                            @elseif($premiReclamat->estat == 'cancelat')
                                <span class="badge bg-danger ms-2">Cancel·lat</span>
                            @endif
                        </div>
                        <div class="premi-date">
                            <i class="fas fa-calendar-day text-muted me-2"></i>
                            <span class="text-muted">Reclamat el
                                {{ $premiReclamat->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="d-flex justify-content-md-end">
                    @if($premiReclamat->estat == 'pendent')
                        <div class="d-flex justify-content-md-end">
                            <form method="POST" action="{{ route('admin.premis-reclamats.approve', $premiReclamat->id) }}"
                                style="margin-right: 10px;">
                                @csrf
                                <button type="submit" class="btn btn-success"
                                    onclick="return confirm('Estàs segur que vols aprovar aquesta sol·licitud?');">
                                    <i class="fas fa-check me-2"></i>Aprovar Sol·licitud
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.premis-reclamats.reject', $premiReclamat->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Estàs segur que vols rebutjar aquesta sol·licitud?');">
                                    <i class="fas fa-times me-2"></i>Rebutjar Sol·licitud
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Información del usuario -->
        <div class="col-md-6 mb-4">
            <div class="info-card bg-light p-4 rounded-3 shadow-sm">
                <h4 class="card-title mb-3">
                    <i class="fas fa-user text-primary me-2"></i>Informació de l'Usuari
                </h4>

                @if($premiReclamat->user)
                    <div class="user-info-container">
                        <div class="d-flex align-items-center mb-3">
                            @if($premiReclamat->user->foto_perfil)
                                            <img src="{{ Str::startsWith($premiReclamat->user->foto_perfil, ['http://', 'https://']) ?
                                $premiReclamat->user->foto_perfil :
                                asset('storage/' . $premiReclamat->user->foto_perfil) }}" class="rounded-circle me-3"
                                                width="60" height="60" alt="Perfil">
                            @else
                                <div class="user-icon-placeholder rounded-circle me-3 d-flex align-items-center justify-content-center bg-secondary"
                                    style="width: 60px; height: 60px;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            @endif

                            <div>
                                <h5 class="mb-1">{{ $premiReclamat->user->nom }} {{ $premiReclamat->user->cognoms }}</h5>
                                <p class="mb-0 text-muted">{{ $premiReclamat->user->email }}</p>
                            </div>
                        </div>

                        <div class="user-details mb-3">
                            <div class="row mb-2">
                                <div class="col-md-4 fw-bold">Punts actuals:</div>
                                <div class="col-md-8">{{ $premiReclamat->user->punts_actuals }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4 fw-bold">Punts totals:</div>
                                <div class="col-md-8">{{ $premiReclamat->user->punts_totals }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4 fw-bold">Punts gastats:</div>
                                <div class="col-md-8">{{ $premiReclamat->user->punts_gastats }}</div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>L'usuari ja no existeix a la base de dades
                    </div>
                @endif
            </div>
        </div>

        <!-- Información de envío -->
        <div class="col-md-6 mb-4">
            <div class="info-card bg-light p-4 rounded-3 shadow-sm">
                <h4 class="card-title mb-3">
                    <i class="fas fa-shipping-fast text-success me-2"></i>Informació d'Enviament
                </h4>

                @if($premiReclamat->codi_seguiment)
                    <div class="shipping-info mb-3">
                        <div class="row mb-2">
                            <div class="col-md-5 fw-bold">Codi de seguiment:</div>
                            <div class="col-md-7">{{ $premiReclamat->codi_seguiment }}</div>
                        </div>
                    </div>
                @else
                    <p>No s'ha assignat cap codi de seguiment encara.</p>
                @endif

                @if($premiReclamat->estat != 'entregat' && $premiReclamat->estat != 'cancelat')
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button class="btn btn-primary editPremiReclamatBtn" data-id="{{ $premiReclamat->id }}">
                                    <i class="fas fa-edit me-2"></i>Actualitzar Estat
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Comentarios -->
    @if($premiReclamat->comentaris)
        <div class="row">
            <div class="col-12">
                <div class="info-card bg-light p-4 rounded-3 shadow-sm mb-4">
                    <h4 class="card-title mb-3">
                        <i class="fas fa-comment-alt text-info me-2"></i>Comentaris
                    </h4>
                    <div class="comentaris">
                        <p class="mb-0">{{ $premiReclamat->comentaris }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($premiReclamat->estat != 'entregat' && $premiReclamat->estat != 'cancelat')
        <div class="row mt-3">
            <div class="col-12">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-primary editStatusBtn" data-id="{{ $premiReclamat->id }}">
                        <i class="fas fa-edit me-2"></i>Actualitzar Estat
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function handleAction(action, id) {
            const confirmMsg = action === 'approve' ? 'aprovar' : 'rebutjar';

            if (confirm(`Estàs segur que vols ${confirmMsg} aquesta sol·licitud?`)) {
                const url = action === 'approve'
                    ? "{{ route('admin.premis-reclamats.approve', '') }}/" + id
                    : "{{ route('admin.premis-reclamats.reject', '') }}/" + id;

                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            alert(`Sol·licitud ${confirmMsg}ada correctament`);
                            window.location.reload();
                        }
                    },
                    error: function (xhr) {
                        alert(`Error al ${confirmMsg} la sol·licitud`);
                        console.error(xhr.responseText);
                    }
                });
            }
        }

        // Conectar los botones a la función
        document.querySelectorAll('.approveBtn').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                handleAction('approve', id);
            });
        });

        document.querySelectorAll('.rejectBtn').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                handleAction('reject', id);
            });
        });
        document.querySelectorAll('.editStatusBtn').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.getAttribute('data-id');

                // Crear el modal
                const modalHtml = `
                    <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Actualitzar estat</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="updateStatusForm">
                                        <div class="mb-3">
                                            <label for="estatSelect" class="form-label">Estat</label>
                                            <select class="form-select" id="estatSelect" name="estat">
                                                <option value="pendent">Pendent</option>
                                                <option value="procesant">Processant</option>
                                                <option value="entregat">Entregat</option>
                                                <option value="cancelat">Cancel·lat</option>
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
                `;

                const modalContainer = document.createElement('div');
                modalContainer.innerHTML = modalHtml;
                document.body.appendChild(modalContainer);

                const modal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
                modal.show();

                document.getElementById('saveStatusBtn').addEventListener('click', function () {
                    // Creamos un FormData con el formulario
                    const formData = new FormData(document.getElementById('updateStatusForm'));
                    formData.append('_method', 'PUT'); // Para emular PUT
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content')); // Token CSRF

                    // Mostrar indicador de carga
                    this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardant...';
                    this.disabled = true;

                    // Realizar la petición AJAX
                    fetch(`/admin/premis-reclamats/${id}`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Error en la resposta del servidor');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Mostrar mensaje de éxito
                            alert('Estat actualitzat correctament');

                            // Cerrar modal y recargar
                            modal.hide();
                            closeAnyModal('detailModal');
                            setTimeout(() => {
                                const contentTypeBtn = document.querySelector('[data-content-type="premis-reclamats"]');
                                if (contentTypeBtn) contentTypeBtn.click();
                                else window.location.reload();
                            }, 300);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error al actualitzar l\'estat: ' + error.message);
                            this.innerHTML = 'Guardar';
                            this.disabled = false;
                        });
                });

                document.getElementById('updateStatusModal').addEventListener('hidden.bs.modal', function () {
                    document.body.removeChild(modalContainer);
                });
            });
        });
    });
</script>

<style>
    .premi-reclamat-detail-container {
        border-radius: 8px;
        overflow-y: auto;
        max-height: 70vh;
        padding: 20px;
        scrollbar-width: thin;
    }

    .premi-reclamat-detail-container::-webkit-scrollbar {
        width: 6px;
    }

    .premi-reclamat-detail-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .premi-reclamat-detail-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    body.dark .premi-reclamat-detail-container {
        background-color: #2d3748 !important;
    }

    body.dark .info-card {
        background-color: #3f4a5c !important;
    }
</style>