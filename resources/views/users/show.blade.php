@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User: {{ $user->nom }} {{ $user->cognoms }}</h1>
    @if($user->foto_perfil)
        <img src="{{ asset('storage/' . $user->foto_perfil) }}" alt="Profile Photo" class="img-thumbnail" style="width: 150px; height: 150px;">
    @else
        <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile Photo" class="img-thumbnail" style="width: 150px; height: 150px;">
    @endif
    <p>Data Naixement: {{ $user->data_naieixement }}</p>
    <p>Telefon: {{ $user->telefon }}</p>
    <p>Ubicacio: {{ $user->ubicacio }}</p>
    <p>Punts Totals: {{ $user->punts_totals }}</p>
    <p>Punts Actuals: {{ $user->punts_actuals }}</p>
    <p>Punts Gastats: {{ $user->punts_gastats }}</p>
    <p>Email: {{ $user->email }}</p>
    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
</div>
@endsection