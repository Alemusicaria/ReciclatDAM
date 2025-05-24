<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">{{ __('messages.admin.codis.create_title') }}</h4>

            <div class="modal-body-scroll">
                <form id="createCodiForm" method="POST" action="{{ route('admin.codis.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="card mb-3 form-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('messages.admin.codis.info_title') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="codi" class="form-label">{{ __('messages.admin.codis.codi') }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="codi" name="codi" required>
                                    <button type="button" class="btn btn-outline-secondary" id="generateCode">
                                        <i class="fas fa-random"></i>
                                    </button>
                                </div>
                                <div class="form-text">{{ __('messages.admin.codis.codi_help') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="producte_id" class="form-label">{{ __('messages.admin.codis.producte') }}</label>
                                <select class="form-select" id="producte_id" name="producte_id">
                                    <option value="">{{ __('messages.admin.codis.select_producte') }}</option>
                                    @foreach($productes as $producte)
                                        <option value="{{ $producte->id }}">{{ $producte->nom }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text">{{ __('messages.admin.codis.producte_help') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="punts" class="form-label">{{ __('messages.admin.codis.punts') }} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="punts" name="punts" min="0" value="10" required>
                                <div class="form-text">{{ __('messages.admin.codis.punts_help') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="data_caducitat" class="form-label">{{ __('messages.admin.codis.data_caducitat') }}</label>
                                <input type="date" class="form-control" id="data_caducitat" name="data_caducitat">
                                <div class="form-text">{{ __('messages.admin.codis.data_caducitat_help') }}</div>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="actiu" name="actiu" checked>
                                <label class="form-check-label" for="actiu">
                                    {{ __('messages.admin.codis.actiu') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3 form-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('messages.admin.codis.options_title') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label d-block">{{ __('messages.admin.codis.tipus') }}</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipus" id="tipus_unic" value="únic" checked>
                                    <label class="form-check-label" for="tipus_unic">{{ __('messages.admin.codis.tipus_unic') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipus" id="tipus_multi" value="multi">
                                    <label class="form-check-label" for="tipus_multi">{{ __('messages.admin.codis.tipus_multi') }}</label>
                                </div>
                            </div>

                            <div class="mb-3" id="multiUsesContainer" style="display: none;">
                                <label for="usos_maxims" class="form-label">{{ __('messages.admin.codis.usos_maxims') }}</label>
                                <input type="number" class="form-control" id="usos_maxims" name="usos_maxims" min="1" value="1">
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="submitCreateCodiForm">{{ __('messages.admin.codis.save_button') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>