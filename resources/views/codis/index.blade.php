@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Codis</h1>
    <a href="{{ route('codis.create') }}" class="btn btn-success mb-3">Create Codi</a>
    <ul class="list-group">
        @foreach ($codis as $codi)
            <li class="list-group-item">
                <a href="{{ route('codis.show', $codi->id) }}">{{ $codi->codi }}</a>
            </li>
        @endforeach
    </ul>
</div>
@endsection