<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">Crear Nou Tipus d'Event</h4>

            <div class="modal-body-scroll" style="max-height: 65vh; overflow-y: auto; padding-right: 5px;">
                <form id="createTipusEventForm" method="POST" action="{{ route('admin.tipus-events.store') }}">
                    @csrf

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informació del Tipus d'Event</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nom" name="nom" required>
                                <div class="form-text">Introdueix un nom descriptiu pel tipus d'event (ex: Taller, Exposició, etc.)</div>
                            </div>

                            <div class="mb-3">
                                <label for="color" class="form-label">Color <span class="text-danger">*</span></label>
                                <input type="color" class="form-control form-control-color" id="color" name="color" value="#0d6efd" required>
                                <div class="form-text">Selecciona un color per identificar aquest tipus d'event al calendari</div>
                            </div>

                            <div class="mb-3">
                                <label for="descripcio" class="form-label">Descripció</label>
                                <textarea class="form-control" id="descripcio" name="descripcio" rows="3"></textarea>
                                <div class="form-text">Descripció opcional del tipus d'event</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel·lar</button>
                        <button type="submit" class="btn btn-primary" id="submitCreateTipusEventForm">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('createTipusEventForm');
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
                const submitBtn = document.getElementById('submitCreateTipusEventForm');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardant...';

                // Obtener los datos del formulario
                const formData = new FormData(form);

                // Enviar formulario via AJAX
                fetch('/admin/tipus-events', {
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
                        
                        // Recargar lista
                        setTimeout(() => {
                            const tipusEventsBtn = document.querySelector('[data-content-type="tipus-events"]');
                            if (tipusEventsBtn) {
                                tipusEventsBtn.click();
                                console.log('Recargando lista de tipos de eventos');
                            } else {
                                console.error('No se encontró el botón para recargar tipos de eventos');
                            }
                        }, 300);
                    } else {
                        // Restaurar botón
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Guardar';

                        // Mostrar error
                        alert('Error: ' + (data.message || 'No s\'ha pogut crear el tipus d\'event'));
                    }
                })
                .catch(error => {
                    console.error('Error en la petición:', error);
                    
                    // Restaurar botón
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Guardar';
                    
                    // Mostrar error
                    alert('Error al crear el tipus d\'event: ' + error.message);
                });
            });
        } else {
            console.error('No se encontró el formulario createTipusEventForm');
        }
    });
</script>