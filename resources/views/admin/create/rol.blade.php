<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">{{ __('messages.admin.rols.create_title') }}</h4>

            <div class="modal-body-scroll">
                <form id="createRolForm" method="POST" action="{{ route('admin.rols.store') }}">
                    @csrf

                    <div class="card mb-3 form-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('messages.admin.rols.info_title') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nom" class="form-label">{{ __('messages.admin.rols.name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nom" name="nom" required>
                                <div class="form-text">{{ __('messages.admin.rols.name_help') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="submitCreateRolForm">{{ __('messages.admin.rols.save_button') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>