@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Premis</h1>
    <a href="{{ route('premis.create') }}" class="btn btn-success mb-3">Create Premi</a>
    <ul class="list-group">
        @foreach ($premis as $premi)
            <li class="list-group-item">
                <a href="{{ route('premis.show', $premi->id) }}">{{ $premi->nom }}</a>
            </li>
        @endforeach
    </ul>
</div>
@endsection