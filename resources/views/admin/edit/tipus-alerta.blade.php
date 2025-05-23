<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">Editar Tipus d'Alerta</h4>

            <div class="modal-body-scroll" style="max-height: 65vh; overflow-y: auto; padding-right: 5px;">
                <form id="editTipusAlertaForm" method="POST" action="{{ route('admin.tipus-alertes.update', $tipusAlerta->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informació del Tipus d'Alerta</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nom" name="nom" value="{{ $tipusAlerta->nom }}" required>
                                <div class="form-text">Introdueix un nom descriptiu pel tipus d'alerta (ex: Contenidor ple, Incidència, etc.)</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelEditBtn">Cancel·lar</button>
                        <button type="submit" class="btn btn-primary" id="updateTipusAlertaBtn">Actualitzar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('editTipusAlertaForm');
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
                const submitBtn = document.getElementById('updateTipusAlertaBtn');
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
                            const tipusAlertesBtn = document.querySelector('[data-content-type="tipus-alertes"]');
                            if (tipusAlertesBtn) tipusAlertesBtn.click();
                        }, 300);
                    } else {
                        // Restaurar botón
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Actualitzar';
                        alert('Error: ' + (data.message || 'No s\'ha pogut actualitzar el tipus d\'alerta'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Actualitzar';
                    alert('Error al actualitzar el tipus d\'alerta: ' + error.message);
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