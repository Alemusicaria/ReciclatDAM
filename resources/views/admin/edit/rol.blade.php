<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">{{ __('messages.admin.roles.edit_title') }}</h4>

            <div class="modal-body-scroll">
                <form id="editRolForm" method="POST" action="{{ route('admin.rols.update', $rol->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="card mb-3 form-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('messages.admin.roles.info_title') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nom" class="form-label">{{ __('messages.admin.roles.name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nom" name="nom" value="{{ $rol->nom }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelEditBtn">{{ __('messages.common.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="updateRolBtn">{{ __('messages.admin.roles.update_button') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>