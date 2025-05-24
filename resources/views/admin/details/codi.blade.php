<div class="detail-container codi-detail-container">
    <div class="detail-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-start">
                    <div class="detail-icon-container me-4">
                        <div class="detail-icon codi-icon d-flex align-items-center justify-content-center rounded">
                            <i class="fas fa-qrcode fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="codi-code mb-2">
                            <span class="code-label">{{ __('messages.admin.codes.code_label') }}:</span>
                            <code class="code-value rounded">{{ $codi->codi }}</code>
                        </h2>
                        <div class="codi-info mb-1">
                            <span class="badge bg-success">{{ $codi->punts }} {{ __('messages.admin.codes.points') }}</span>
                            @if($codi->tipus)
                                <span class="badge bg-info ms-2">{{ $codi->tipus === 'únic' ? __('messages.admin.codes.single_use') : __('messages.admin.codes.multi_use') }}</span>
                            @endif
                        </div>
                        <div class="detail-date">
                            <i class="fas fa-calendar-day text-muted me-2"></i>
                            <span class="text-muted">{{ __('messages.admin.codes.scanned_date') }} {{ $codi->data_escaneig ? $codi->data_escaneig->format('d/m/Y H:i') : __('messages.admin.codes.not_scanned') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                @if($codi->user)
                    <div class="codi-user-info">
                        <h5 class="mb-2">{{ __('messages.admin.codes.scanned_by') }}:</h5>
                        <div class="d-flex align-items-center justify-content-md-end">
                            @if($codi->user->foto_perfil)
                                <img src="{{ asset('storage/' . $codi->user->foto_perfil) }}" class="user-avatar rounded-circle me-2" alt="{{ __('messages.admin.profile_photo') }}">
                            @else
                                <div class="user-icon-placeholder rounded-circle me-2 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                            <div class="text-start">
                                <div class="user-name">{{ $codi->user->nom }} {{ $codi->user->cognoms }}</div>
                                <div class="user-email text-muted small">{{ $codi->user->email }}</div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-2"></i> {{ __('messages.admin.codes.not_scanned_yet') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>