@extends('layouts.app')

@section('content')
    <div class="container-fluid h-100 mt-5 pt-5">
        <h1>Perfil de l'usuari: {{ $user->nom }} {{ $user->cognoms }}</h1>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Data de naixement:</strong> {{ $user->data_naieixement }}</p>
        <p><strong>Telèfon:</strong> {{ $user->telefon }}</p>
        <p><strong>Ubicació:</strong> {{ $user->ubicacio }}</p>
        <p><strong>Punts Actuals:</strong> {{ $user->punts_actuals }}</p>
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
        <div class="mt-3">
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edita</a>
            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Elimina</button>
            </form>
        </div>
    </div>
@endsection