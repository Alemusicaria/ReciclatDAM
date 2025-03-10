@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Codi</h1>
    <form action="{{ route('codis.store') }}" method="POST">
        @csrf
        <input type="text" name="codi" placeholder="Codi">
        <input type="number" name="punts" placeholder="Punts">
        <input type="datetime-local" name="data_escaneig" placeholder="Data Escaneig">
        <button type="submit" class="btn btn-success">Create</button>
    </form>
</div>
@endsection