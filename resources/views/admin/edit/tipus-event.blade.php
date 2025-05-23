<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">Editar Tipus d'Event</h4>

            <div class="modal-body-scroll" style="max-height: 65vh; overflow-y: auto; padding-right: 5px;">
                <form id="editTipusEventForm" method="POST" action="{{ route('admin.tipus-events.update', $tipusEvent->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informació del Tipus d'Event</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nom" name="nom" value="{{ $tipusEvent->nom }}" required>
                                <div class="form-text">Introdueix un nom descriptiu pel tipus d'event (ex: Taller, Exposició, etc.)</div>
                            </div>

                            <div class="mb-3">
                                <label for="color" class="form-label">Color <span class="text-danger">*</span></label>
                                <input type="color" class="form-control form-control-color" id="color" name="color" value="{{ $tipusEvent->color }}" required>
                                <div class="form-text">Selecciona un color per identificar aquest tipus d'event al calendari</div>
                            </div>

                            <div class="mb-3">
                                <label for="descripcio" class="form-label">Descripció</label>
                                <textarea class="form-control" id="descripcio" name="descripcio" rows="3">{{ $tipusEvent->descripcio }}</textarea>
                                <div class="form-text">Descripció opcional del tipus d'event</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelEditBtn">Cancel·lar</button>
                        <button type="submit" class="btn btn-primary" id="updateTipusEventBtn">Actualitzar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('editTipusEventForm');
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
                const submitBtn = document.getElementById('updateTipusEventBtn');
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
                        
                        // Recargar lista
                        setTimeout(() => {
                            const tipusEventsBtn = document.querySelector('[data-content-type="tipus-events"]');
                            if (tipusEventsBtn) tipusEventsBtn.click();
                        }, 300);
                    } else {
                        // Restaurar botón
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Actualitzar';
                        alert('Error: ' + (data.message || 'No s\'ha pogut actualitzar el tipus d\'event'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Actualitzar';
                    alert('Error al actualitzar el tipus d\'event: ' + error.message);
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