<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">{{ __('messages.admin.events.create_title') }}</h4>

            <div class="modal-body-scroll">
                <form id="createEventForm" method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="card mb-3 form-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('messages.admin.events.basic_info') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nom" class="form-label">{{ __('messages.admin.events.name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nom" name="nom" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="tipus_event_id" class="form-label">{{ __('messages.admin.events.type') }} <span class="text-danger">*</span></label>
                                    <select class="form-select" id="tipus_event_id" name="tipus_event_id" required>
                                        <option value="">{{ __('messages.admin.events.select_type') }}</option>
                                        @foreach(\App\Models\TipusEvent::all() as $tipus)
                                            <option value="{{ $tipus->id }}">{{ $tipus->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="data_inici" class="form-label">{{ __('messages.admin.events.start_date') }} <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" id="data_inici" name="data_inici" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="data_fi" class="form-label">{{ __('messages.admin.events.end_date') }} <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" id="data_fi" name="data_fi" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="descripcio" class="form-label">{{ __('messages.admin.events.description') }}</label>
                                <textarea class="form-control" id="descripcio" name="descripcio" rows="3"></textarea>
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
                                    <input type="text" class="form-control" id="lloc" name="lloc">
                                </div>
                                <div class="col-md-6">
                                    <label for="capacitat" class="form-label">{{ __('messages.admin.events.capacity') }}</label>
                                    <input type="number" class="form-control" id="capacitat" name="capacitat" min="0" 
                                        placeholder="{{ __('messages.admin.events.capacity_placeholder') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="punts_disponibles" class="form-label">{{ __('messages.admin.events.available_points') }}</label>
                                    <input type="number" class="form-control" id="punts_disponibles" name="punts_disponibles" min="0" value="0">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="actiu" name="actiu" value="1" checked>
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
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="submitCreateEventForm">{{ __('messages.admin.events.save_button') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>