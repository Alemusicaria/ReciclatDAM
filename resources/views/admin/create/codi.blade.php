<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">Crear Nou Codi</h4>

            <div class="modal-body-scroll" style="max-height: 65vh; overflow-y: auto; padding-right: 5px;">
                <form id="createCodiForm" method="POST" action="{{ route('admin.codis.store') }}">
                    @csrf

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informació del Codi</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="codi" class="form-label">Codi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="codi" name="codi" required>
                                <div class="form-text">Introdueix un codi únic. Es recomana utilitzar un format alfanumèric.</div>
                            </div>

                            <div class="mb-3">
                                <label for="punts" class="form-label">Punts <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="punts" name="punts" min="1" value="10" required>
                            </div>

                            <div class="mb-3">
                                <label for="user_id" class="form-label">Usuari (opcional)</label>
                                <select class="form-select" id="user_id" name="user_id">
                                    <option value="">No assignat</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->nom }} {{ $user->cognoms }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="data_escaneig" class="form-label">Data Escaneig <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" id="data_escaneig" name="data_escaneig" value="{{ date('Y-m-d\TH:i') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel·lar</button>
                        <button type="submit" class="btn btn-primary" id="submitCreateCodiForm">Guardar Codi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('createCodiForm');
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
                const submitBtn = document.getElementById('submitCreateCodiForm');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardant...';

                // Enviar formulario via AJAX
                const formData = new FormData(form);

                fetch('/admin/codis', {
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
                        submitBtn.innerHTML = 'Guardar Codi';

                        // Mostrar error
                        alert('Error: ' + (data.message || 'No s\'ha pogut crear el codi'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    
                    // Restaurar botón
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Guardar Codi';
                    
                    // Mostrar error
                    alert('Error al crear el codi: ' + error.message);
                });
            });
        }
    });
</script>