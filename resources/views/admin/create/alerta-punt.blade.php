<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">{{ __('messages.admin.alertes.create_title') }}</h4>

            <div class="modal-body-scroll">
                <form id="createAlertaForm" method="POST" action="{{ route('admin.alertes-punts.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="card mb-3 form-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('messages.admin.alertes.info_title') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="punt_de_recollida_id" class="form-label">{{ __('messages.admin.alertes.punt_recollida') }} <span class="text-danger">*</span></label>
                                <select class="form-select" id="punt_de_recollida_id" name="punt_de_recollida_id" required>
                                    <option value="">{{ __('messages.admin.alertes.select_punt') }}</option>
                                    @foreach($puntsDeRecollida as $punt)
                                        <option value="{{ $punt->id }}">{{ $punt->nom }} ({{ $punt->fraccio }}) - {{ $punt->adreca }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="tipus_alerta_id" class="form-label">{{ __('messages.admin.alertes.tipus_alerta') }} <span class="text-danger">*</span></label>
                                <select class="form-select" id="tipus_alerta_id" name="tipus_alerta_id" required>
                                    <option value="">{{ __('messages.admin.alertes.select_tipus') }}</option>
                                    @foreach($tipusAlertes as $tipus)
                                        <option value="{{ $tipus->id }}">{{ $tipus->nom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="descripció" class="form-label">{{ __('messages.admin.alertes.descripcio') }} <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="descripció" name="descripció" rows="4" required></textarea>
                                <div class="form-text">{{ __('messages.admin.alertes.descripcio_help') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="imatge" class="form-label">{{ __('messages.admin.alertes.imatge') }}</label>
                                <input type="file" class="form-control" id="imatge" name="imatge">
                                <div class="form-text">{{ __('messages.admin.alertes.imatge_help') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="submitCreateAlertaForm">{{ __('messages.admin.alertes.save_button') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>