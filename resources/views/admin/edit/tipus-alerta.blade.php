<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">{{ __('messages.admin.tipus_alertes.edit_title') }}</h4>

            <div class="modal-body-scroll">
                <form id="editTipusAlertaForm" method="POST" action="{{ route('admin.tipus-alertes.update', $tipusAlerta->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="card mb-3 form-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('messages.admin.tipus_alertes.info_title') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nom" class="form-label">{{ __('messages.admin.tipus_alertes.name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nom" name="nom" value="{{ $tipusAlerta->nom }}" required>
                                <div class="form-text">{{ __('messages.admin.tipus_alertes.name_help') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelEditBtn">{{ __('messages.common.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="updateTipusAlertaBtn">{{ __('messages.admin.tipus_alertes.update_button') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>