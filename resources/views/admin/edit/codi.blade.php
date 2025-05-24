<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">{{ __('messages.admin.codis.edit_title') }}</h4>

            <div class="modal-body-scroll">
                <form id="editCodiForm" method="POST" action="{{ route('admin.codis.update', $codi->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="card mb-3 form-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('messages.admin.codis.info_title') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="codi" class="form-label">{{ __('messages.admin.codis.codi') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="codi" name="codi" value="{{ $codi->codi }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="punts" class="form-label">{{ __('messages.admin.codis.punts') }} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="punts" name="punts" min="1" value="{{ $codi->punts }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="user_id" class="form-label">{{ __('messages.admin.codis.user') }}</label>
                                <select class="form-select" id="user_id" name="user_id">
                                    <option value="">{{ __('messages.admin.codis.no_user') }}</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ $codi->user_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->nom }} {{ $user->cognoms }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="data_escaneig" class="form-label">{{ __('messages.admin.codis.scan_date') }}</label>
                                <input type="datetime-local" class="form-control" id="data_escaneig" name="data_escaneig" 
                                       value="{{ $codi->data_escaneig ? $codi->data_escaneig->format('Y-m-d\TH:i') : '' }}">
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelEditBtn">{{ __('messages.common.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="updateCodiBtn">{{ __('messages.admin.codis.update_button') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>