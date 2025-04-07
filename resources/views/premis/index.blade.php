@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Premis</h1>
        <form action="{{ route('premis.search') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="query" class="form-control" placeholder="Cerca un premi..."
                    value="{{ request('query') }}">
                <button type="submit" class="btn btn-primary">Cerca</button>
            </div>
        </form>
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