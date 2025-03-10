@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="nom" placeholder="Nom" value="{{ $user->nom }}">
        <input type="text" name="cognoms" placeholder="Cognoms" value="{{ $user->cognoms }}">
        <input type="date" name="data_naieixement" placeholder="Data Naixement" value="{{ $user->data_naieixement }}">
        <input type="text" name="telefon" placeholder="Telefon" value="{{ $user->telefon }}">
        <textarea name="ubicacio" placeholder="Ubicacio">{{ $user->ubicacio }}</textarea>
        <input type="number" name="punts_totals" placeholder="Punts Totals" value="{{ $user->punts_totals }}">
        <input type="number" name="punts_actuals" placeholder="Punts Actuals" value="{{ $user->punts_actuals }}">
        <input type="number" name="punts_gastats" placeholder="Punts Gastats" value="{{ $user->punts_gastats }}">
        <input type="email" name="email" placeholder="Email" value="{{ $user->email }}">
        <input type="password" name="password" placeholder="Password">
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection