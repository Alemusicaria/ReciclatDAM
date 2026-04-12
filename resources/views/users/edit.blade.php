@extends('layouts.app')

@section('content')
    @php
        $birthDateValue = old('data_naixement', optional($user->data_naixement)->format('Y-m-d'));

        if (!empty($user->foto_perfil) && str_starts_with($user->foto_perfil, 'https://')) {
            $profilePhoto = $user->foto_perfil;
        } elseif (!empty($user->foto_perfil) && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->foto_perfil)) {
            $profilePhoto = \Illuminate\Support\Facades\Storage::url($user->foto_perfil);
        } else {
            $profilePhoto = asset('images/default-profile.png');
        }
    @endphp

    <div class="edit-profile-container">
        <div class="edit-panel">
            <div class="edit-header">
                <i class="fas fa-user-edit"></i>
                <h4>{{ __('messages.admin.users.edit_title') }}: {{ e($user->nom) }} {{ e($user->cognoms) }}</h4>
            </div>

            <div class="edit-body">
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="photo-upload-container">
                        <div class="photo-preview profile-avatar-edit">
                            <img src="{{ $profilePhoto }}" alt="{{ __('messages.admin.users.current_photo') }}">
                        </div>
                        <label for="foto_perfil" class="photo-upload-btn">
                            <i class="fas fa-camera"></i>{{ __('messages.admin.users.profile_photo') }}
                        </label>
                        <input type="file" id="foto_perfil" name="foto_perfil" class="d-none" accept="image/jpeg,image/png,image/jpg,image/gif">
                        <small id="selectedPhotoName" class="text-muted mt-1 d-block" data-default="{{ __('messages.admin.users.no_file_selected') }}">{{ __('messages.admin.users.no_file_selected') }}</small>
                        <small class="text-muted mt-2">{{ __('messages.admin.users.photo_help') }}</small>
                        @error('foto_perfil')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6 input-group">
                            <label for="nom">{{ __('messages.admin.users.name') }}</label>
                            <input type="text" class="@error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $user->nom) }}" maxlength="255" required>
                            @error('nom')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 input-group">
                            <label for="cognoms">{{ __('messages.admin.users.surname') }}</label>
                            <input type="text" class="@error('cognoms') is-invalid @enderror" id="cognoms" name="cognoms" value="{{ old('cognoms', $user->cognoms) }}" maxlength="255" required>
                            @error('cognoms')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 input-group">
                            <label for="email">{{ __('messages.admin.users.email') }}</label>
                            <input type="email" class="@error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" maxlength="255" required>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 input-group">
                            <label for="data_naixement">{{ __('messages.admin.users.birth_date') }}</label>
                            <input type="date" class="@error('data_naixement') is-invalid @enderror" id="data_naixement" name="data_naixement" value="{{ $birthDateValue }}">
                            @error('data_naixement')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 input-group">
                            <label for="telefon">{{ __('messages.admin.users.phone') }}</label>
                            <input type="text" class="@error('telefon') is-invalid @enderror" id="telefon" name="telefon" value="{{ old('telefon', $user->telefon) }}" maxlength="15">
                            @error('telefon')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 input-group">
                            <label for="ubicacio">{{ __('messages.admin.users.location') }}</label>
                            <input type="text" class="@error('ubicacio') is-invalid @enderror" id="ubicacio" name="ubicacio" value="{{ old('ubicacio', $user->ubicacio) }}" maxlength="255" placeholder="{{ __('messages.admin.users.location_placeholder') }}">
                            @error('ubicacio')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 input-group">
                            <label for="password">{{ __('messages.admin.users.password') }}</label>
                            <input type="password" class="@error('password') is-invalid @enderror" id="password" name="password" minlength="8" autocomplete="new-password">
                            <small class="text-muted">{{ __('messages.admin.users.password_help') }}</small>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 input-group">
                            <label for="password_confirmation">{{ __('messages.admin.users.confirm_password') }}</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" minlength="8" autocomplete="new-password">
                        </div>
                    </div>

                    <div class="actions">
                        <a href="{{ route('users.show', $user->id) }}" class="btn-cancel">{{ __('messages.profile_page.cancel') }}</a>
                        <button type="submit" class="btn-save">{{ __('messages.admin.users.update_button') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@vite(['resources/css/profile.css'])

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('foto_perfil');
        const selectedPhotoName = document.getElementById('selectedPhotoName');

        if (!fileInput || !selectedPhotoName) {
            return;
        }

        fileInput.addEventListener('change', function () {
            const fileName = fileInput.files && fileInput.files.length > 0
                ? fileInput.files[0].name
                : selectedPhotoName.dataset.default;

            selectedPhotoName.textContent = fileName;
        });
    });
</script>