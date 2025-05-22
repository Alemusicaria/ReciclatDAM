<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">Crear Nou Punt de Recollida</h4>

            <div class="modal-body-scroll" style="max-height: 65vh; overflow-y: auto; padding-right: 5px;">
                <form id="createPuntForm" method="POST" action="{{ route('admin.punts.store') }}">
                    @csrf

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informació Bàsica</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nom" name="nom" required>
                            </div>

                            <div class="mb-3">
                                <label for="fraccio" class="form-label">Fracció <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="fraccio" name="fraccio" required>
                                    <option value="">Selecciona una fracció</option>
                                    <option value="Groc">Groc - Envasos</option>
                                    <option value="Blau">Blau - Paper i cartró</option>
                                    <option value="Verd">Verd - Vidre</option>
                                    <option value="Marró">Marró - Orgànic</option>
                                    <option value="Gris">Gris - Resta</option>
                                    <option value="Punt Verd">Punt Verd</option>
                                </select>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="disponible" name="disponible"
                                    value="1" checked>
                                <label class="form-check-label" for="disponible">
                                    Disponible
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Ubicació</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="ciutat" class="form-label">Ciutat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="ciutat" name="ciutat" required>
                            </div>

                            <div class="mb-3">
                                <label for="adreca" class="form-label">Adreça <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="adreca" name="adreca" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="latitud" class="form-label">Latitud <span
                                            class="text-danger">*</span></label>
                                    <input type="number" step="any" class="form-control" id="latitud" name="latitud"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="longitud" class="form-label">Longitud <span
                                            class="text-danger">*</span></label>
                                    <input type="number" step="any" class="form-control" id="longitud" name="longitud"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel·lar</button>
                        <button type="submit" class="btn btn-primary" id="submitCreatePuntForm">Guardar Punt</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('createPuntForm');
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
                const submitBtn = document.getElementById('submitCreatePuntForm');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardant...';

                // Enviar formulario via AJAX
                const formData = new FormData(form);

                // IMPORTANTE: Usar la URL correcta
                fetch('/admin/punts', {
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
                                const puntsBtn = document.querySelector('[data-content-type="punt-reciclatge"]');
                                if (puntsBtn) puntsBtn.click();
                            }, 300);
                        } else {
                            // Restaurar botón
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = 'Guardar Punt';

                            // Mostrar error
                            alert('Error: ' + (data.message || 'No s\'ha pogut crear el punt de recollida'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Guardar Punt';
                        alert('Error al crear el punt: ' + error.message);
                    });
            });
        }
    });
</script>