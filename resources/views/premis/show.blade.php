@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Premi: {{ $premi->nom }}</h1>
    <p>Descripcio: {{ $premi->descripcio }}</p>
    <p>Punts Requerits: {{ $premi->punts_requerits }}</p>
    <a href="{{ route('premis.edit', $premi->id) }}" class="btn btn-primary">Edit</a>
    <form action="{{ route('premis.destroy', $premi->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
</div>
@endsection