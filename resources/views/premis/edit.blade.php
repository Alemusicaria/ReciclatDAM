@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Premi</h1>
    <form action="{{ route('premis.update', $premi->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="nom" placeholder="Nom" value="{{ $premi->nom }}">
        <textarea name="descripcio" placeholder="Descripcio">{{ $premi->descripcio }}</textarea>
        <input type="number" name="punts_requerits" placeholder="Punts Requerits" value="{{ $premi->punts_requerits }}">
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection