@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Users</h1>
    <a href="{{ route('users.create') }}" class="btn btn-success mb-3">Create User</a>
    <ul class="list-group">
        @foreach ($users as $user)
            <li class="list-group-item">
                <a href="{{ route('users.show', $user->id) }}">{{ $user->nom }} {{ $user->cognoms }}</a>
            </li>
        @endforeach
    </ul>
</div>
@endsection