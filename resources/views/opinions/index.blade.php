@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Opinions</h1>
    <a href="{{ route('opinions.create') }}" class="btn btn-primary mb-3">Nova Opinió</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Autor</th>
                <th>Comentari</th>
                <th>Estrelles</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($opinions as $opinion)
                <tr>
                    <td>{{ $opinion->autor }}</td>
                    <td>{{ $opinion->comentari }}</td>
                    <td>{{ $opinion->estrelles }}</td>
                    <td>
                        <a href="{{ route('opinions.edit', $opinion) }}" class="btn btn-sm btn-warning">Edita</a>
                        <form action="{{ route('opinions.destroy', $opinion) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Elimina</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection