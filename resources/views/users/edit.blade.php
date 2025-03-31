@extends('layouts.app')

@section('content')
    <div class="container-fluid h-100 mt-5 pt-5">
        <h1>Edita el perfil de l'usuari: {{ $user->nom }} {{ $user->cognoms }}</h1>
        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="{{ $user->nom }}">
            </div>

            <div class="form-group">
                <label for="cognoms">Cognoms</label>
                <input type="text" class="form-control" id="cognoms" name="cognoms" value="{{ $user->cognoms }}">
            </div>

            <div class="form-group">
                <label for="data_naixement">Data de Naixement</label>
                <input type="date" class="form-control" id="data_naixement" name="data_naixement"
                    value="{{ $user->data_naixement }}">
            </div>

            <div class="form-group">
                <label for="telefon">Telèfon</label>
                <input type="text" class="form-control" id="telefon" name="telefon" value="{{ $user->telefon }}">
            </div>

            <div class="form-group">
                <label for="ubicacio">Ubicació</label>
                <textarea class="form-control" id="ubicacio" name="ubicacio">{{ $user->ubicacio }}</textarea>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
            </div>

            <div class="form-group">
                <label for="password">Contrasenya</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirma Contrasenya</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>

            <div class="form-group">
                <label for="foto_perfil">Foto de Perfil</label>
                <input type="file" class="form-control-file" id="foto_perfil" name="foto_perfil">
                @if(Auth::user()->foto_perfil)
                    @if(str_starts_with(Auth::user()->foto_perfil, 'https://'))
                        <img src="{{ Auth::user()->foto_perfil }}" alt="Profile Photo" class="rounded-circle"
                            style="width: 30px; height: 30px; margin-right: 10px;">
                    @elseif(file_exists(public_path('storage/' . Auth::user()->foto_perfil)))
                        <img src="{{ asset('storage/' . Auth::user()->foto_perfil) }}" alt="Profile Photo" class="rounded-circle"
                            style="width: 30px; height: 30px; margin-right: 10px;">
                    @else
                        <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile Photo" class="rounded-circle"
                            style="width: 30px; height: 30px; margin-right: 10px;">
                    @endif
                @else
                    <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile Photo" class="rounded-circle"
                        style="width: 30px; height: 30px; margin-right: 10px;">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Actualitza</button>
        </form>
    </div>
@endsection