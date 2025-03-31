@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create User</h1>
    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="nom" placeholder="Nom">
        <input type="text" name="cognoms" placeholder="Cognoms">
        <input type="date" name="data_naixement" placeholder="Data Naixement">
        <input type="text" name="telefon" placeholder="Telefon">
        <textarea name="ubicacio" placeholder="Ubicacio"></textarea>
        <input type="number" name="punts_totals" placeholder="Punts Totals">
        <input type="number" name="punts_actuals" placeholder="Punts Actuals">
        <input type="number" name="punts_gastats" placeholder="Punts Gastats">
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="password_confirmation" placeholder="Confirm Password">
        <input type="file" name="foto_perfil">
        <button type="submit" class="btn btn-success">Create</button>
    </form>
</div>
@endsection