<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">Editar Codi</h4>

            <div class="modal-body-scroll" style="max-height: 65vh; overflow-y: auto; padding-right: 5px;">
                <form id="editCodiForm" method="POST" action="{{ route('admin.codis.update', $codi->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informació del Codi</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="codi" class="form-label">Codi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="codi" name="codi" value="{{ $codi->codi }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="punts" class="form-label">Punts <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="punts" name="punts" min="1" value="{{ $codi->punts }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="user_id" class="form-label">Usuari (opcional)</label>
                                <select class="form-select" id="user_id" name="user_id">
                                    <option value="">No assignat</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ $codi->user_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->nom }} {{ $user->cognoms }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="data_escaneig" class="form-label">Data Escaneig <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" id="data_escaneig" name="data_escaneig" 
                                       value="{{ $codi->data_escaneig ? $codi->data_escaneig->format('Y-m-d\TH:i') : '' }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelEditBtn">Cancel·lar</button>
                        <button type="submit" class="btn btn-primary" id="updateCodiBtn">Actualitzar Codi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('editCodiForm');
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
                const submitBtn = document.getElementById('updateCodiBtn');
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
                        
                        // Recargar lista de códigos
                        setTimeout(() => {
                            const codisBtn = document.querySelector('[data-content-type="codis"]');
                            if (codisBtn) codisBtn.click();
                        }, 300);
                    } else {
                        // Restaurar botón
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Actualitzar Codi';
                        alert('Error: ' + (data.message || 'No s\'ha pogut actualitzar el codi'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Actualitzar Codi';
                    alert('Error al actualitzar el codi: ' + error.message);
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