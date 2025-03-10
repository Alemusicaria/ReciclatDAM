@extends('layouts.app')

@section('content')
    <h1>Codi: {{ $codi->codi }}</h1>
    <p>Punts: {{ $codi->punts }}</p>
    <p>Data Escaneig: {{ $codi->data_escaneig }}</p>
    <a href="{{ route('codis.edit', $codi->id) }}">Edit</a>
    <form action="{{ route('codis.destroy', $codi->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
@endsection