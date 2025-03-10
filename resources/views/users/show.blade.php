@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User: {{ $user->nom }} {{ $user->cognoms }}</h1>
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