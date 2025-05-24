<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">{{ __('messages.admin.events.edit_title') }}</h4>

            <div class="modal-body-scroll">
                <form id="editEventForm" method="POST" action="{{ route('events.update', $event->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card mb-3 form-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('messages.admin.events.basic_info') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nom" class="form-label">{{ __('messages.admin.events.name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nom" name="nom" value="{{ $event->nom }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="tipus_event_id" class="form-label">{{ __('messages.admin.events.type') }} <span class="text-danger">*</span></label>
                                    <select class="form-select" id="tipus_event_id" name="tipus_event_id" required>
                                        <option value="">{{ __('messages.admin.events.select_type') }}</option>
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
                                    <label for="data_inici" class="form-label">{{ __('messages.admin.events.start_date') }} <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" id="data_inici" name="data_inici"
                                        value="{{ date('Y-m-d\TH:i', strtotime($event->data_inici)) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="data_fi" class="form-label">{{ __('messages.admin.events.end_date') }} <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" id="data_fi" name="data_fi"
                                        value="{{ $event->data_fi ? date('Y-m-d\TH:i', strtotime($event->data_fi)) : '' }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="descripcio" class="form-label">{{ __('messages.admin.events.description') }}</label>
                                <textarea class="form-control" id="descripcio" name="descripcio" rows="3">{{ $event->descripcio }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3 form-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('messages.admin.events.details_capacity') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="lloc" class="form-label">{{ __('messages.admin.events.location') }}</label>
                                    <input type="text" class="form-control" id="lloc" name="lloc" value="{{ $event->lloc }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="capacitat" class="form-label">{{ __('messages.admin.events.capacity') }}</label>
                                    <input type="number" class="form-control" id="capacitat" name="capacitat" min="0"
                                        value="{{ $event->capacitat }}" placeholder="{{ __('messages.admin.events.capacity_placeholder') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="punts_disponibles" class="form-label">{{ __('messages.admin.events.available_points') }}</label>
                                    <input type="number" class="form-control" id="punts_disponibles" name="punts_disponibles" 
                                           min="0" value="{{ $event->punts_disponibles ?? 0 }}">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="actiu" name="actiu"
                                            value="1" {{ $event->actiu ? 'checked' : '' }}>
                                        <label class="form-check-label" for="actiu">
                                            {{ __('messages.admin.events.active') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="imatge" class="form-label">{{ __('messages.admin.events.image') }}</label>
                                <input type="file" class="form-control" id="imatge" name="imatge">
                                <div class="form-text">{{ __('messages.admin.events.image_help') }}</div>

                                @if($event->imatge)
                                    <div class="mt-2">
                                        <label>{{ __('messages.admin.events.current_image') }}:</label>
                                        <div>
                                            <img src="{{ asset('storage/' . $event->imatge) }}" class="preview-image rounded" alt="{{ __('messages.admin.events.event_image') }}">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelEditBtn">{{ __('messages.common.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="updateEventBtn">{{ __('messages.admin.events.update_button') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>