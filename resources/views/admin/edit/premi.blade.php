<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">{{ __('messages.admin.premis.edit_title') }}</h4>

            <div class="modal-body-scroll">
                <form id="editPremiForm" method="POST" action="{{ route('premis.update', $premi->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card mb-3 form-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('messages.admin.premis.basic_info') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nom" class="form-label">{{ __('messages.admin.premis.name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nom" name="nom" value="{{ $premi->nom }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="punts_requerits" class="form-label">{{ __('messages.admin.premis.points_required') }} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="punts_requerits" name="punts_requerits" 
                                       value="{{ $premi->punts_requerits }}" min="1" required>
                            </div>

                            <div class="mb-3">
                                <label for="descripcio" class="form-label">{{ __('messages.admin.premis.description') }}</label>
                                <textarea class="form-control" id="descripcio" name="descripcio" rows="3">{{ $premi->descripcio }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="imatge" class="form-label">{{ __('messages.admin.premis.image') }}</label>
                                <input type="file" class="form-control" id="imatge" name="imatge">
                                <div class="form-text">{{ __('messages.admin.premis.image_help') }}</div>

                                @if($premi->imatge)
                                    <div class="mt-2">
                                        <label>{{ __('messages.admin.premis.current_image') }}:</label>
                                        <div>
                                            <img src="{{ asset($premi->imatge) }}" class="preview-image rounded" 
                                                 alt="{{ __('messages.admin.premis.prize_image') }}">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelEditBtn">{{ __('messages.common.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="updatePremiBtn">{{ __('messages.admin.premis.update_button') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>