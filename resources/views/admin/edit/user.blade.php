<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">{{ __('messages.admin.users.edit_title') }}</h4>

            <div class="modal-body-scroll">
                <form id="editUserForm" method="POST" action="{{ route('users.update', $user->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card mb-3 form-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('messages.admin.users.basic_info') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nom" class="form-label">{{ __('messages.admin.users.name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nom" name="nom" value="{{ $user->nom }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="cognoms" class="form-label">{{ __('messages.admin.users.surname') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="cognoms" name="cognoms" value="{{ $user->cognoms }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">{{ __('messages.admin.users.email') }} <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label">{{ __('messages.admin.users.password') }} 
                                        <small class="text-muted">({{ __('messages.admin.users.password_help') }})</small>
                                    </label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3 form-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('messages.admin.users.personal_info') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="data_naixement" class="form-label">{{ __('messages.admin.users.birth_date') }}</label>
                                    <input type="date" class="form-control" id="data_naixement" name="data_naixement"
                                        value="{{ $user->data_naixement ? date('Y-m-d', strtotime($user->data_naixement)) : '' }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="telefon" class="form-label">{{ __('messages.admin.users.phone') }}</label>
                                    <input type="tel" class="form-control" id="telefon" name="telefon" value="{{ $user->telefon }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="ubicacio" class="form-label">{{ __('messages.admin.users.location') }}</label>
                                    <input type="text" class="form-control" id="ubicacio" name="ubicacio"
                                        placeholder="{{ __('messages.admin.users.location_placeholder') }}" value="{{ $user->ubicacio }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="foto_perfil" class="form-label">{{ __('messages.admin.users.profile_photo') }}</label>
                                <input type="file" class="form-control" id="foto_perfil" name="foto_perfil">
                                <div class="form-text">{{ __('messages.admin.users.photo_help') }}</div>

                                @if($user->foto_perfil)
                                    <div class="mt-2">
                                        <label>{{ __('messages.admin.users.current_photo') }}:</label>
                                        <div>
                                            @if(str_starts_with($user->foto_perfil, 'https://'))
                                                <img src="{{ $user->foto_perfil }}" class="preview-image rounded" alt="{{ __('messages.admin.profile_photo') }}">
                                            @else
                                                <img src="{{ asset('storage/' . $user->foto_perfil) }}" class="preview-image rounded" alt="{{ __('messages.admin.profile_photo') }}">
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3 form-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('messages.admin.users.account_settings') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="rol_id" class="form-label">{{ __('messages.admin.users.role') }} <span class="text-danger">*</span></label>
                                    <select class="form-select" id="rol_id" name="rol_id" required>
                                        <option value="">{{ __('messages.admin.users.select_role') }}</option>
                                        @foreach(\App\Models\Rol::all() as $rol)
                                            <option value="{{ $rol->id }}" {{ $user->rol_id == $rol->id ? 'selected' : '' }}>
                                                {{ $rol->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="punts_actuals" class="form-label">{{ __('messages.admin.users.current_points') }}</label>
                                    <input type="number" class="form-control" id="punts_actuals" name="punts_actuals"
                                        value="{{ $user->punts_actuals }}" min="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelEditBtn">{{ __('messages.common.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="updateUserBtn">{{ __('messages.admin.users.update_button') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>