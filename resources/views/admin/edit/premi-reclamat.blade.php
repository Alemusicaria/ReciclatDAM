<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">{{ __('messages.admin.claimed_prizes.edit_title') }}</h4>

            <div class="modal-body-scroll">
                <form id="editPremiReclamatForm" method="POST" 
                      action="{{ route('admin.premis-reclamats.update', $premiReclamat->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="card mb-3 form-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('messages.admin.claimed_prizes.info_title') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-7">
                                    <label class="form-label fw-bold">{{ __('messages.admin.claimed_prizes.user') }}:</label>
                                    <div class="d-flex align-items-center">
                                        @if($premiReclamat->user && $premiReclamat->user->foto_perfil)
                                            <img src="{{ Str::startsWith($premiReclamat->user->foto_perfil, ['http://', 'https://']) ?
                                                $premiReclamat->user->foto_perfil :
                                                asset('storage/' . $premiReclamat->user->foto_perfil) }}" 
                                                class="user-avatar rounded-circle me-2" alt="{{ __('messages.admin.profile_photo') }}">
                                        @else
                                            <div class="user-icon-placeholder rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <span>{{ $premiReclamat->user ? $premiReclamat->user->nom . ' ' . $premiReclamat->user->cognoms : __('messages.admin.claimed_prizes.unknown_user') }}</span>
                                            @if($premiReclamat->user)
                                                <small class="d-block text-muted">{{ $premiReclamat->user->email }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label fw-bold">{{ __('messages.admin.claimed_prizes.prize') }}:</label>
                                    <div>{{ $premiReclamat->premi ? $premiReclamat->premi->nom : __('messages.admin.claimed_prizes.unknown_prize') }}</div>
                                    <div><span class="badge bg-primary">{{ $premiReclamat->punts_gastats }} {{ __('messages.admin.claimed_prizes.points') }}</span></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="estat" class="form-label">{{ __('messages.admin.claimed_prizes.status') }} <span class="text-danger">*</span></label>
                                <select class="form-select" id="estat" name="estat" required>
                                    <option value="pendent" {{ $premiReclamat->estat == 'pendent' ? 'selected' : '' }}>{{ __('messages.admin.claimed_prizes.pending') }}</option>
                                    <option value="procesant" {{ $premiReclamat->estat == 'procesant' ? 'selected' : '' }}>{{ __('messages.admin.claimed_prizes.processing') }}</option>
                                    <option value="entregat" {{ $premiReclamat->estat == 'entregat' ? 'selected' : '' }}>{{ __('messages.admin.claimed_prizes.delivered') }}</option>
                                    <option value="cancelat" {{ $premiReclamat->estat == 'cancelat' ? 'selected' : '' }}>{{ __('messages.admin.claimed_prizes.canceled') }}</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="codi_seguiment" class="form-label">{{ __('messages.admin.claimed_prizes.tracking_code') }}</label>
                                <input type="text" class="form-control" id="codi_seguiment" name="codi_seguiment" 
                                       value="{{ $premiReclamat->codi_seguiment }}">
                                <div class="form-text">{{ __('messages.admin.claimed_prizes.tracking_code_help') }}</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="comentaris" class="form-label">{{ __('messages.admin.claimed_prizes.comments') }}</label>
                                <textarea class="form-control" id="comentaris" name="comentaris" rows="3">{{ $premiReclamat->comentaris }}</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('messages.admin.claimed_prizes.claim_date') }}:</label>
                                <div>{{ $premiReclamat->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" 
                                id="cancelEditBtn">{{ __('messages.common.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" 
                                id="updatePremiReclamatBtn">{{ __('messages.admin.claimed_prizes.update_button') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>