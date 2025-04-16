@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Resultats de la Cerca</h1>
    <form action="{{ route('opinions.search') }}" method="GET" class="mb-4">
        <input type="text" name="query" class="form-control" placeholder="Cerca opinions..." value="{{ request('query') }}">
    </form>

    @if ($opinions->isEmpty())
        <p>No s'han trobat resultats per "{{ $query }}".</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Autor</th>
                    <th>Comentari</th>
                    <th>Estrelles</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($opinions as $opinion)
                    <tr>
                        <td>{{ $opinion->autor }}</td>
                        <td>{{ $opinion->comentari }}</td>
                        <td>{{ $opinion->estrelles }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection