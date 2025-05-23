<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">Crear Nou Rol</h4>

            <div class="modal-body-scroll" style="max-height: 65vh; overflow-y: auto; padding-right: 5px;">
                <form id="createRolForm" method="POST" action="{{ route('admin.rols.store') }}">
                    @csrf

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informació del Rol</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nom" name="nom" required>
                                <div class="invalid-feedback">El nom és obligatori</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel·lar</button>
                        <button type="submit" class="btn btn-primary" id="submitCreateRolForm">Guardar Rol</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('createRolForm');
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
                const submitBtn = document.getElementById('submitCreateRolForm');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardant...';

                // Obtener los datos del formulario
                const formData = new FormData(form);
                
                // Log para debug
                console.log('Datos del formulario:', Object.fromEntries(formData));

                // Enviar formulario via AJAX
                fetch('/admin/rols', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    console.log('Respuesta del servidor:', response);
                    return response.json();
                })
                .then(data => {
                    console.log('Datos recibidos:', data);
                    
                    if (data.success) {
                        // Cerrar modal
                        closeAnyModal('detailModal');
                        
                        // Recargar lista de roles
                        setTimeout(() => {
                            const rolsBtn = document.querySelector('[data-content-type="rols"]');
                            if (rolsBtn) {
                                rolsBtn.click();
                                console.log('Recargando lista de roles');
                            } else {
                                console.error('No se encontró el botón para recargar roles');
                            }
                        }, 300);
                    } else {
                        // Restaurar botón
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Guardar Rol';

                        // Mostrar error
                        alert('Error: ' + (data.message || 'No s\'ha pogut crear el rol'));
                    }
                })
                .catch(error => {
                    console.error('Error en la petición:', error);
                    
                    // Restaurar botón
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Guardar Rol';
                    
                    // Mostrar error
                    alert('Error al crear el rol: ' + error.message);
                });
            });
        } else {
            console.error('No se encontró el formulario createRolForm');
        }
    });
</script>