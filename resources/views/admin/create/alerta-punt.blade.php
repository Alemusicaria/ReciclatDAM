<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">Crear Nova Alerta</h4>

            <div class="modal-body-scroll" style="max-height: 65vh; overflow-y: auto; padding-right: 5px;">
                <form id="createAlertaForm" method="POST" action="{{ route('admin.alertes-punts.store') }}" enctype="multipart/form-data">
                    @csrf

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
                                        <option value="{{ $punt->id }}">{{ $punt->nom }} ({{ $punt->fraccio }}) - {{ $punt->adreca }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="tipus_alerta_id" class="form-label">Tipus d'Alerta <span class="text-danger">*</span></label>
                                <select class="form-select" id="tipus_alerta_id" name="tipus_alerta_id" required>
                                    <option value="">Selecciona un tipus d'alerta</option>
                                    @foreach($tipusAlertes as $tipus)
                                        <option value="{{ $tipus->id }}">{{ $tipus->nom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="descripció" class="form-label">Descripció <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="descripció" name="descripció" rows="4" required></textarea>
                                <div class="form-text">Descriu el problema o l'alerta en detall.</div>
                            </div>

                            <div class="mb-3">
                                <label for="imatge" class="form-label">Imatge (opcional)</label>
                                <input type="file" class="form-control" id="imatge" name="imatge">
                                <div class="form-text">Formats acceptats: JPG, PNG. Mida màxima: 2MB</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel·lar</button>
                        <button type="submit" class="btn btn-primary" id="submitCreateAlertaForm">Guardar Alerta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('createAlertaForm');
        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                console.log('Formulario enviado');

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

                if (!isValid) {
                    console.log('Formulario no válido');
                    return;
                }

                // Mostrar indicador de carga
                const submitBtn = document.getElementById('submitCreateAlertaForm');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardant...';

                // Enviar formulario via AJAX
                const formData = new FormData(form);

                fetch('/admin/alertes-punts', {
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
                        submitBtn.innerHTML = 'Guardar Alerta';

                        // Mostrar error
                        alert('Error: ' + (data.message || 'No s\'ha pogut crear l\'alerta'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    
                    // Restaurar botón
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Guardar Alerta';
                    
                    // Mostrar error
                    alert('Error al crear l\'alerta: ' + error.message);
                });
            });
        } else {
            console.error('No se encontró el formulario createAlertaForm');
        }
    });
</script>