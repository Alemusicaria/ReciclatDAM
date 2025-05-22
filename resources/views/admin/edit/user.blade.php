<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">Editar Usuari</h4>

            <!-- Div con altura máxima y scroll -->
            <div class="modal-body-scroll" style="max-height: 65vh; overflow-y: auto; padding-right: 5px;">
                <form id="editUserForm" method="POST" action="{{ route('users.update', $user->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informació Bàsica</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nom" name="nom" value="{{ $user->nom }}"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label for="cognoms" class="form-label">Cognoms <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="cognoms" name="cognoms"
                                        value="{{ $user->cognoms }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $user->email }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Contrasenya <small
                                            class="text-muted">(Deixar en blanc per mantenir)</small></label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informació Personal</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="data_naixement" class="form-label">Data de Naixement</label>
                                    <input type="date" class="form-control" id="data_naixement" name="data_naixement"
                                        value="{{ $user->data_naixement ? date('Y-m-d', strtotime($user->data_naixement)) : '' }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="telefon" class="form-label">Telèfon</label>
                                    <input type="tel" class="form-control" id="telefon" name="telefon"
                                        value="{{ $user->telefon }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="ubicacio" class="form-label">Ubicació</label>
                                    <input type="text" class="form-control" id="ubicacio" name="ubicacio"
                                        placeholder="Ciutat, país..." value="{{ $user->ubicacio }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="foto_perfil" class="form-label">Foto de Perfil</label>
                                <input type="file" class="form-control" id="foto_perfil" name="foto_perfil">
                                <div class="form-text">Formats acceptats: JPG, PNG. Mida màxima: 2MB</div>

                                @if($user->foto_perfil)
                                    <div class="mt-2">
                                        <label>Imatge actual:</label>
                                        <div>
                                            @if(str_starts_with($user->foto_perfil, 'https://'))
                                                <img src="{{ $user->foto_perfil }}" class="rounded" width="100"
                                                    alt="Foto de perfil">
                                            @else
                                                <img src="{{ asset('storage/' . $user->foto_perfil) }}" class="rounded"
                                                    width="100" alt="Foto de perfil">
                                            @endif
                                        </div>
                                    </div>
                                @endif
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
                                            <option value="{{ $rol->id }}" {{ $user->rol_id == $rol->id ? 'selected' : '' }}>
                                                {{ $rol->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="punts_actuals" class="form-label">Punts Actuals</label>
                                    <input type="number" class="form-control" id="punts_actuals" name="punts_actuals"
                                        value="{{ $user->punts_actuals }}" min="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="cancelEditBtn">Cancel·lar</button>
                        <button type="submit" class="btn btn-primary" id="updateUserBtn">Actualitzar Usuari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Función para cerrar el modal
    function closeUserModal() {
        console.log("Intentando cerrar modal desde closeUserModal...");

        // Cerrar el modal directamente por ID
        const detailModal = document.getElementById('detailModal');
        if (detailModal) {
            // Quitar clases de modal abierto
            detailModal.classList.remove('show');
            detailModal.style.display = 'none';
            detailModal.setAttribute('aria-hidden', 'true');
            detailModal.removeAttribute('aria-modal');
            detailModal.removeAttribute('role');

            // Quitar clase del body
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';

            // Eliminar todos los backdrops
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

            console.log("Modal cerrado manualmente");

            // Recargar la lista
            setTimeout(() => {
                const usersBtn = document.querySelector('[data-content-type="users"]');
                if (usersBtn) {
                    console.log("Recargando lista de usuarios");
                    usersBtn.click();
                }
            }, 300);
        }
    }

    // 2. Botón de envío del formulario (mantener el código actual)
    document.getElementById('editUserForm').addEventListener('submit', function (e) {
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
        const submitBtn = document.getElementById('updateUserBtn');
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
                    try {
                        // Cerrar modal de forma segura
                        const detailModalEl = document.getElementById('detailModal');

                        // Método compatible para cerrar el modal
                        if (typeof bootstrap !== 'undefined') {
                            try {
                                const modal = new bootstrap.Modal(detailModalEl);
                                modal.hide();
                            } catch (e) {
                                console.error('Error al cerrar modal:', e);
                                // Método alternativo
                                detailModalEl.classList.remove('show');
                                detailModalEl.style.display = 'none';
                                document.body.classList.remove('modal-open');
                            }
                        }

                        // Eliminar backdrops manualmente
                        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

                        // Recargar lista de usuarios
                        setTimeout(() => {
                            const userListBtn = document.querySelector('[data-bs-toggle="modal"][data-bs-target="#dynamicModal"][data-content-type="users"]');
                            if (userListBtn) userListBtn.click();
                        }, 500);
                    } catch (e) {
                        console.error('Error al cerrar el modal:', e);
                        alert('Usuario actualizado, pero hubo un problema al cerrar la ventana.');
                        location.reload(); // Recargar página como fallback
                    }
                } else {
                    // Restaurar botón
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Actualitzar Usuari';
                    alert('Error: ' + (data.message || 'No s\'ha pogut actualitzar l\'usuari'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Actualitzar Usuari';
                alert('Error al actualitzar l\'usuari: ' + error.message);
            });
    });
    // 3. Aplicar listeners a los botones de cierre inmediatamente
    // (sin esperar a DOMContentLoaded que podría ser muy tarde)
    document.querySelectorAll('button[data-bs-dismiss="modal"], .btn-close').forEach(button => {
        console.log("Añadiendo listener a botón:", button);
        button.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation(); // Detener propagación del evento
            closeUserModal();
        });
    });

    // 4. Asegurarse que los listeners se aplican incluso para elementos cargados dinámicamente
    document.addEventListener('click', function (e) {
        if (e.target.matches('button[data-bs-dismiss="modal"], .btn-close, .cancel-btn')) {
            console.log("Click detectado en botón de cierre");
            e.preventDefault();
            e.stopPropagation();
            closeUserModal();
        }
    });

    // 5. Añadir clase adicional visible para depuración
    document.querySelectorAll('button[data-bs-dismiss="modal"], .btn-close').forEach(btn => {
        btn.classList.add('close-handler-applied');
        btn.style.position = 'relative';
        btn.style.zIndex = '9999';
    });
</script>