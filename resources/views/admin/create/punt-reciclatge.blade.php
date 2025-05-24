<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">{{ __('messages.admin.punts.create_title') }}</h4>

            <div class="modal-body-scroll">
                <form id="createPuntForm" method="POST" action="{{ route('admin.punts.store') }}">
                    @csrf

                    <div class="card mb-3 form-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('messages.admin.punts.basic_info') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nom" class="form-label">{{ __('messages.admin.punts.name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nom" name="nom" required>
                            </div>

                            <div class="mb-3">
                                <label for="fraccio" class="form-label">{{ __('messages.admin.punts.fraction') }} <span class="text-danger">*</span></label>
                                <select class="form-select" id="fraccio" name="fraccio" required>
                                    <option value="">{{ __('messages.admin.punts.select_fraction') }}</option>
                                    <option value="Groc">{{ __('messages.admin.punts.fraction_yellow') }}</option>
                                    <option value="Blau">{{ __('messages.admin.punts.fraction_blue') }}</option>
                                    <option value="Verd">{{ __('messages.admin.punts.fraction_green') }}</option>
                                    <option value="Marró">{{ __('messages.admin.punts.fraction_brown') }}</option>
                                    <option value="Gris">{{ __('messages.admin.punts.fraction_gray') }}</option>
                                    <option value="Punt Verd">{{ __('messages.admin.punts.fraction_green_point') }}</option>
                                </select>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="disponible" name="disponible" value="1" checked>
                                <label class="form-check-label" for="disponible">
                                    {{ __('messages.admin.punts.available') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3 form-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('messages.admin.punts.location') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="ciutat" class="form-label">{{ __('messages.admin.punts.city') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="ciutat" name="ciutat" required>
                            </div>

                            <div class="mb-3">
                                <label for="adreca" class="form-label">{{ __('messages.admin.punts.address') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="adreca" name="adreca" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="latitud" class="form-label">{{ __('messages.admin.punts.latitude') }} <span class="text-danger">*</span></label>
                                    <input type="number" step="any" class="form-control" id="latitud" name="latitud" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="longitud" class="form-label">{{ __('messages.admin.punts.longitude') }} <span class="text-danger">*</span></label>
                                    <input type="number" step="any" class="form-control" id="longitud" name="longitud" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="submitCreatePuntForm">{{ __('messages.admin.punts.save_button') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>