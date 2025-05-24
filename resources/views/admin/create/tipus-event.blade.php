<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">{{ __('messages.admin.tipus_events.create_title') }}</h4>

            <div class="modal-body-scroll">
                <form id="createTipusEventForm" method="POST" action="{{ route('admin.tipus-events.store') }}">
                    @csrf

                    <div class="card mb-3 form-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('messages.admin.tipus_events.info_title') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nom" class="form-label">{{ __('messages.admin.tipus_events.name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nom" name="nom" required>
                                <div class="form-text">{{ __('messages.admin.tipus_events.name_help') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="color" class="form-label">{{ __('messages.admin.tipus_events.color') }} <span class="text-danger">*</span></label>
                                <input type="color" class="form-control form-control-color" id="color" name="color" value="#0d6efd" required>
                                <div class="form-text">{{ __('messages.admin.tipus_events.color_help') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="descripcio" class="form-label">{{ __('messages.admin.tipus_events.description') }}</label>
                                <textarea class="form-control" id="descripcio" name="descripcio" rows="3"></textarea>
                                <div class="form-text">{{ __('messages.admin.tipus_events.description_help') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="submitCreateTipusEventForm">{{ __('messages.admin.tipus_events.save_button') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>