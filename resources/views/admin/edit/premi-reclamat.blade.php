<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">Actualitzar Premi Reclamat</h4>

            <div class="modal-body-scroll" style="max-height: 65vh; overflow-y: auto; padding-right: 5px;">
                <form id="editPremiReclamatForm" method="POST" 
                      action="{{ route('admin.premis-reclamats.update', $premiReclamat->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informació del Premi Reclamat</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-7">
                                    <label class="form-label fw-bold">Usuari:</label>
                                    <div class="d-flex align-items-center">
                                        @if($premiReclamat->user && $premiReclamat->user->foto_perfil)
                                            <img src="{{ Str::startsWith($premiReclamat->user->foto_perfil, ['http://', 'https://']) ?
                                                $premiReclamat->user->foto_perfil :
                                                asset('storage/' . $premiReclamat->user->foto_perfil) }}" 
                                                class="rounded-circle me-2" width="40" height="40" alt="Perfil">
                                        @else
                                            <div class="user-icon-placeholder rounded-circle me-2 d-flex align-items-center justify-content-center bg-secondary"
                                                style="width: 40px; height: 40px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <span>{{ $premiReclamat->user ? $premiReclamat->user->nom . ' ' . $premiReclamat->user->cognoms : 'Usuari desconegut' }}</span>
                                            @if($premiReclamat->user)
                                                <small class="d-block text-muted">{{ $premiReclamat->user->email }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label fw-bold">Premi:</label>
                                    <div>{{ $premiReclamat->premi ? $premiReclamat->premi->nom : 'Premi desconegut' }}</div>
                                    <div><span class="badge bg-primary">{{ $premiReclamat->punts_gastats }} pts</span></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="estat" class="form-label">Estat <span class="text-danger">*</span></label>
                                <select class="form-select" id="estat" name="estat" required>
                                    <option value="pendent" {{ $premiReclamat->estat == 'pendent' ? 'selected' : '' }}>Pendent</option>
                                    <option value="procesant" {{ $premiReclamat->estat == 'procesant' ? 'selected' : '' }}>Processant</option>
                                    <option value="entregat" {{ $premiReclamat->estat == 'entregat' ? 'selected' : '' }}>Entregat</option>
                                    <option value="cancelat" {{ $premiReclamat->estat == 'cancelat' ? 'selected' : '' }}>Cancel·lat</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="codi_seguiment" class="form-label">Codi de seguiment</label>
                                <input type="text" class="form-control" id="codi_seguiment" name="codi_seguiment" 
                                       value="{{ $premiReclamat->codi_seguiment }}">
                                <div class="form-text">Deixa-ho en blanc per generar automàticament un codi de seguiment</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="comentaris" class="form-label">Comentaris</label>
                                <textarea class="form-control" id="comentaris" name="comentaris" rows="3">{{ $premiReclamat->comentaris }}</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Data de reclamació:</label>
                                <div>{{ $premiReclamat->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" 
                                id="cancelEditBtn">Cancel·lar</button>
                        <button type="submit" class="btn btn-primary" 
                                id="updatePremiReclamatBtn">Actualitzar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('editPremiReclamatForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Validación básica
                let isValid = true;
                form.querySelectorAll('[required]').forEach(input => {
                    if (!input.value.trim()) {
                        input.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });

                if (!isValid) return;

                // Mostrar indicador de carga
                const submitBtn = document.getElementById('updatePremiReclamatBtn');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Actualitzant...';

                // Enviar formulario mediante AJAX
                const formData = new FormData(form);
                formData.append('_method', 'PUT');

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Cerrar modal
                        closeAnyModal('detailModal');
                        
                        // Recargar lista de premios reclamados
                        setTimeout(() => {
                            const premisReclamatsBtn = document.querySelector('[data-content-type="premis-reclamats"]');
                            if (premisReclamatsBtn) premisReclamatsBtn.click();
                        }, 300);
                    } else {
                        // Restaurar botón
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Actualitzar';
                        alert('Error: ' + (data.message || 'No s\'ha pogut actualitzar el premi reclamat'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Actualitzar';
                    alert('Error al actualitzar el premi reclamat: ' + error.message);
                });
            });
        }

        // Botón cancelar
        const cancelBtn = document.getElementById('cancelEditBtn');
        if (cancelBtn) {
            cancelBtn.addEventListener('click', function() {
                closeAnyModal('detailModal');
            });
        }
    });
</script>