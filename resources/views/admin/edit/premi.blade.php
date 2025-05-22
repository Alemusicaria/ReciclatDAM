<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">Editar Premi</h4>

            <div class="modal-body-scroll" style="max-height: 65vh; overflow-y: auto; padding-right: 5px;">
                <form id="editPremiForm" method="POST" action="{{ route('premis.update', $premi->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informació Bàsica</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nom" name="nom" value="{{ $premi->nom }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="punts_requerits" class="form-label">Punts Requerits <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="punts_requerits" name="punts_requerits" 
                                       value="{{ $premi->punts_requerits }}" min="1" required>
                            </div>

                            <div class="mb-3">
                                <label for="descripcio" class="form-label">Descripció</label>
                                <textarea class="form-control" id="descripcio" name="descripcio" rows="3">{{ $premi->descripcio }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="imatge" class="form-label">Imatge del Premi</label>
                                <input type="file" class="form-control" id="imatge" name="imatge">
                                <div class="form-text">Formats acceptats: JPG, PNG. Mida màxima: 2MB</div>

                                @if($premi->imatge)
                                    <div class="mt-2">
                                        <label>Imatge actual:</label>
                                        <div>
                                            <img src="{{ asset($premi->imatge) }}" class="rounded" width="100"
                                                alt="Imatge del premi">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelEditBtn">Cancel·lar</button>
                        <button type="submit" class="btn btn-primary" id="updatePremiBtn">Actualitzar Premi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('editPremiForm');
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
                const submitBtn = document.getElementById('updatePremiBtn');
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
                        
                        // Recargar lista de premios
                        setTimeout(() => {
                            const premisBtn = document.querySelector('[data-content-type="premis"]');
                            if (premisBtn) premisBtn.click();
                        }, 300);
                    } else {
                        // Restaurar botón
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Actualitzar Premi';
                        alert('Error: ' + (data.message || 'No s\'ha pogut actualitzar el premi'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Actualitzar Premi';
                    alert('Error al actualitzar el premi: ' + error.message);
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