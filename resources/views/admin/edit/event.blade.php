<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">Editar Event</h4>

            <!-- Div con altura máxima y scroll -->
            <div class="modal-body-scroll" style="max-height: 65vh; overflow-y: auto; padding-right: 5px;">
                <form id="editEventForm" method="POST" action="{{ route('events.update', $event->id) }}"
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
                                    <input type="text" class="form-control" id="nom" name="nom"
                                        value="{{ $event->nom }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="tipus_event_id" class="form-label">Tipus <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="tipus_event_id" name="tipus_event_id" required>
                                        <option value="">Selecciona un tipus</option>
                                        @foreach(\App\Models\TipusEvent::all() as $tipus)
                                            <option value="{{ $tipus->id }}" {{ $event->tipus_event_id == $tipus->id ? 'selected' : '' }}>
                                                {{ $tipus->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="data_inici" class="form-label">Data Inici <span
                                            class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" id="data_inici" name="data_inici"
                                        value="{{ date('Y-m-d\TH:i', strtotime($event->data_inici)) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="data_fi" class="form-label">Data Fi <span
                                            class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" id="data_fi" name="data_fi"
                                        value="{{ $event->data_fi ? date('Y-m-d\TH:i', strtotime($event->data_fi)) : '' }}"
                                        required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="descripcio" class="form-label">Descripció</label>
                                <textarea class="form-control" id="descripcio" name="descripcio"
                                    rows="3">{{ $event->descripcio }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Detalls i Capacitat</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="lloc" class="form-label">Lloc</label>
                                    <input type="text" class="form-control" id="lloc" name="lloc"
                                        value="{{ $event->lloc }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="capacitat" class="form-label">Capacitat</label>
                                    <input type="number" class="form-control" id="capacitat" name="capacitat" min="0"
                                        value="{{ $event->capacitat }}"
                                        placeholder="Deixar en blanc per no tenir límit">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="punts_disponibles" class="form-label">Punts Disponibles</label>
                                    <input type="number" class="form-control" id="punts_disponibles"
                                        name="punts_disponibles" min="0" value="{{ $event->punts_disponibles ?? 0 }}">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="actiu" name="actiu"
                                            value="1" {{ $event->actiu ? 'checked' : '' }}>
                                        <label class="form-check-label" for="actiu">
                                            Event Actiu
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="imatge" class="form-label">Imatge de l'Event</label>
                                <input type="file" class="form-control" id="imatge" name="imatge">
                                <div class="form-text">Formats acceptats: JPG, PNG. Mida màxima: 2MB</div>

                                @if($event->imatge)
                                    <div class="mt-2">
                                        <label>Imatge actual:</label>
                                        <div>
                                            <img src="{{ asset('storage/' . $event->imatge) }}" class="rounded" width="100"
                                                alt="Imatge de l'event">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="cancelEditBtn">Cancel·lar</button>
                        <button type="submit" class="btn btn-primary" id="updateEventBtn">Actualitzar Event</button>
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
    document.getElementById('editEventForm').addEventListener('submit', function (e) {
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
        const submitBtn = document.getElementById('updateEventBtn');
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
                    const detailModal = document.getElementById('detailModal');
                    detailModal.classList.remove('show');
                    detailModal.style.display = 'none';
                    document.body.classList.remove('modal-open');
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

                    // Recargar lista de eventos
                    setTimeout(() => {
                        document.querySelector('[data-content-type="events"]').click();
                    }, 500);
                } else {
                    // Restaurar botón
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Actualitzar Event';
                    alert('Error: ' + (data.message || 'No s\'ha pogut actualitzar l\'event'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Actualitzar Event';
                alert('Error al actualitzar l\'event: ' + error.message);
            });
    });

    // Botón cancelar
    document.getElementById('cancelEditBtn').addEventListener('click', function () {
        const detailModal = document.getElementById('detailModal');
        detailModal.classList.remove('show');
        detailModal.style.display = 'none';
        document.body.classList.remove('modal-open');
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

        setTimeout(() => {
            document.querySelector('[data-content-type="events"]').click();
        }, 300);
    });
</script>