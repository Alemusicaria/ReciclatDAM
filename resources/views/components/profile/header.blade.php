@props(['user'])

<div class="card mb-4 shadow-sm">
    <div class="card-body text-center">
        <div class="position-relative mb-4">
            <!-- Imagen de perfil -->
            @if($user->foto_perfil)
                @if(str_starts_with($user->foto_perfil, 'https://'))
                    <img src="{{ e($user->foto_perfil) }}" alt="{{ __('messages.profile_page.profile_photo_alt') }}"
                        class="rounded-circle img-thumbnail shadow" id="profile-image"
                        style="width: 150px; height: 150px; object-fit: cover;">
                @elseif(file_exists(public_path('storage/' . e($user->foto_perfil))))
                    <img src="{{ asset('storage/' . e($user->foto_perfil)) }}" alt="{{ __('messages.profile_page.profile_photo_alt') }}"
                        class="rounded-circle img-thumbnail shadow" id="profile-image"
                        style="width: 150px; height: 150px; object-fit: cover;">
                @else
                    <img src="{{ asset('images/default-profile.png') }}" alt="{{ __('messages.profile_page.profile_photo_alt') }}"
                        class="rounded-circle img-thumbnail shadow" id="profile-image"
                        style="width: 150px; height: 150px; object-fit: cover;">
                @endif
            @else
                <img src="{{ asset('images/default-profile.png') }}" alt="{{ __('messages.profile_page.profile_photo_alt') }}"
                    class="rounded-circle img-thumbnail shadow" id="profile-image"
                    style="width: 150px; height: 150px; object-fit: cover;">
            @endif

            <!-- Botón para editar foto -->
            <div class="position-relative bottom-0 start-0">
                <label for="photo-upload" class="btn btn-sm btn-success rounded-circle change-photo-btn"
                    style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; margin: auto; margin-top: 1vh;"
                    title="{{ __('messages.profile_page.change_photo') }}">
                    <i class="fas fa-camera"></i>
                </label>
                <input type="file" id="photo-upload" name="foto_perfil" accept="image/*"
                    style="display: none;">
            </div>
        </div>

        <h3 class="mb-1">{{ $user->nom }} {{ $user->cognoms }}</h3>
        <p class="text-muted mb-3">{{ $user->email }}</p>

        @if($user->rol)
            <span class="badge bg-success mb-3">{{ $user->rol->nom ?? 'N/A' }}</span>
        @endif

        <!-- ECODAMS Points Display -->
        <div class="alert alert-info d-flex align-items-center gap-3" role="alert">
            <i class="fas fa-coins fa-2x"></i>
            <div class="text-start">
                <small class="d-block text-muted">{{ __('messages.profile_page.ecodams_points') }}</small>
                <strong class="d-block fs-5">{{ $user->punts_actuals ?? 0 }}</strong>
            </div>
        </div>
    </div>
</div>
