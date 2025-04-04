@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Llista de Productes</h1>
    <a href="{{ route('productes.create') }}" class="btn btn-primary mb-3">Crear Nou Producte</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Categoria</th>
                <th>Imatge</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productes as $producte)
            <tr>
                <td>{{ $producte->id }}</td>
                <td>{{ $producte->nom }}</td>
                <td>{{ $producte->categoria }}</td>
                <td>
                    @if ($producte->imatge)
                    <img src="{{ asset($producte->imatge) }}" alt="{{ $producte->nom }}" style="width: 50px; height: 50px; object-fit: cover;">
                    @else
                    Sense imatge
                    @endif
                </td>
                <td>
                    <a href="{{ route('productes.edit', $producte->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('productes.destroy', $producte->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Estàs segur que vols eliminar aquest producte?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection