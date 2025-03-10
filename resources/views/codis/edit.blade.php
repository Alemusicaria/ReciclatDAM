@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Codi</h1>
    <form action="{{ route('codis.update', $codi->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="codi" placeholder="Codi" value="{{ $codi->codi }}">
        <input type="number" name="punts" placeholder="Punts" value="{{ $codi->punts }}">
        <input type="datetime-local" name="data_escaneig" placeholder="Data Escaneig" value="{{ $codi->data_escaneig }}">
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection