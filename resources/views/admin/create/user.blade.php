<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">Crear Nou Usuari</h4>

            <!-- Div con altura máxima y scroll -->
            <div class="modal-body-scroll" style="max-height: 65vh; overflow-y: auto; padding-right: 5px;">
                <form id="createUserForm" method="POST" action="{{ route('users.store') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informació Bàsica</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nom" name="nom" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="cognoms" class="form-label">Cognoms <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="cognoms" name="cognoms" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Contrasenya <span
                                            class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informació Personal (Opcional)</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="data_naixement" class="form-label">Data de Naixement</label>
                                    <input type="date" class="form-control" id="data_naixement" name="data_naixement">
                                </div>
                                <div class="col-md-4">
                                    <label for="telefon" class="form-label">Telèfon</label>
                                    <input type="tel" class="form-control" id="telefon" name="telefon">
                                </div>
                                <div class="col-md-4">
                                    <label for="ubicacio" class="form-label">Ubicació</label>
                                    <input type="text" class="form-control" id="ubicacio" name="ubicacio"
                                        placeholder="Ciutat, país...">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="foto_perfil" class="form-label">Foto de Perfil</label>
                                <input type="file" class="form-control" id="foto_perfil" name="foto_perfil">
                                <div class="form-text">Formats acceptats: JPG, PNG. Mida màxima: 2MB</div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Configuració del Compte</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="rol_id" class="form-label">Rol <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="rol_id" name="rol_id" required>
                                        <option value="">Selecciona un rol</option>
                                        @foreach(\App\Models\Rol::all() as $rol)
                                            <option value="{{ $rol->id }}">{{ $rol->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="punts_actuals" class="form-label">Punts Inicials</label>
                                    <input type="number" class="form-control" id="punts_actuals" name="punts_actuals"
                                        value="0" min="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel·lar</button>
                        <button type="submit" class="btn btn-primary" id="submitCreateUserForm">Guardar Usuari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-close {
        background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
        opacity: 0.5;
    }

    .btn-close:hover {
        opacity: 0.75;
    }
</style>
<script>
    document.getElementById('createUserForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const form = this;

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
        const submitBtn = document.getElementById('submitCreateUserForm');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardant...';

        // Crear solicitud XMLHttpRequest tradicional para mejor manejo de FormData
        const xhr = new XMLHttpRequest();
        xhr.open('POST', form.action, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                try {
                    const data = JSON.parse(xhr.responseText);
                    if (data.success) {
                        // Cerrar modal
                        bootstrap.Modal.getInstance(document.getElementById('detailModal')).hide();

                        // Recargar lista de usuarios
                        setTimeout(() => {
                            document.querySelector('[data-bs-toggle="modal"][data-bs-target="#dynamicModal"][data-content-type="users"]').click();
                        }, 500);
                    } else {
                        // Restaurar botón
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Guardar Usuari';

                        // Mostrar error
                        alert('Error: ' + (data.message || 'No s\'ha pogut crear l\'usuari'));
                    }
                } catch (e) {
                    console.error("Error al parsear respuesta:", e);
                    alert('Error en el formato de respuesta del servidor');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Guardar Usuari';
                }
            } else {
                // Restaurar botón
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Guardar Usuari';

                // Mostrar error
                alert('Error: ' + xhr.statusText);
            }
        };

        xhr.onerror = function () {
            // Restaurar botón
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Guardar Usuari';

            // Mostrar error
            alert('Error en la solicitud');
        };

        const formData = new FormData(form);
        xhr.send(formData);
    });
</script>