<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">Editar Alerta</h4>

            <div class="modal-body-scroll" style="max-height: 65vh; overflow-y: auto; padding-right: 5px;">
                <form id="editAlertaForm" method="POST" action="{{ route('admin.alertes-punts.update', $alerta->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informació de l'Alerta</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="punt_de_recollida_id" class="form-label">Punt de Recollida <span class="text-danger">*</span></label>
                                <select class="form-select" id="punt_de_recollida_id" name="punt_de_recollida_id" required>
                                    <option value="">Selecciona un punt de recollida</option>
                                    @foreach($puntsDeRecollida as $punt)
                                        <option value="{{ $punt->id }}" {{ $punt->id == $alerta->punt_de_recollida_id ? 'selected' : '' }}>
                                            {{ $punt->nom }} ({{ $punt->fraccio }}) - {{ $punt->adreca }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="tipus_alerta_id" class="form-label">Tipus d'Alerta <span class="text-danger">*</span></label>
                                <select class="form-select" id="tipus_alerta_id" name="tipus_alerta_id" required>
                                    <option value="">Selecciona un tipus d'alerta</option>
                                    @foreach($tipusAlertes as $tipus)
                                        <option value="{{ $tipus->id }}" {{ $tipus->id == $alerta->tipus_alerta_id ? 'selected' : '' }}>
                                            {{ $tipus->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="descripció" class="form-label">Descripció <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="descripció" name="descripció" rows="4" required>{{ $alerta->descripció }}</textarea>
                                <div class="form-text">Descriu el problema o l'alerta en detall.</div>
                            </div>

                            <div class="mb-3">
                                <label for="imatge" class="form-label">Imatge (opcional)</label>
                                <input type="file" class="form-control" id="imatge" name="imatge">
                                <div class="form-text">Formats acceptats: JPG, PNG. Mida màxima: 2MB</div>
                                
                                @if($alerta->imatge)
                                    <div class="mt-2">
                                        <p>Imatge actual:</p>
                                        <img src="{{ asset($alerta->imatge) }}" alt="Imatge actual" class="img-thumbnail" style="max-height: 150px">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="eliminar_imatge" name="eliminar_imatge" value="1">
                                            <label class="form-check-label" for="eliminar_imatge">
                                                Eliminar imatge actual
                                            </label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelEditBtn">Cancel·lar</button>
                        <button type="submit" class="btn btn-primary" id="updateAlertaBtn">Actualitzar Alerta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('editAlertaForm');
        if (form) {
            form.addEventListener('submit', function (e) {
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
                const submitBtn = document.getElementById('updateAlertaBtn');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Actualitzant...';

                // Enviar formulario mediante AJAX
                const formData = new FormData(form);

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
                        
                        // Recargar lista
                        setTimeout(() => {
                            const alertesBtn = document.querySelector('[data-content-type="alertes-punts"]');
                            if (alertesBtn) alertesBtn.click();
                        }, 300);
                    } else {
                        // Restaurar botón
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Actualitzar Alerta';
                        alert('Error: ' + (data.message || 'No s\'ha pogut actualitzar l\'alerta'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Actualitzar Alerta';
                    alert('Error al actualitzar l\'alerta: ' + error.message);
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