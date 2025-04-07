@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Premi</h1>
        <form action="{{ route('premis.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="nom" placeholder="Nom">
        <textarea name="descripcio" placeholder="Descripcio"></textarea>
        <input type="number" name="punts_requerits" placeholder="Punts Requerits">
        <input type="file" name="imatge">
        <button type="submit" class="btn btn-success">Create</button>
    </form>
</div>
@endsection