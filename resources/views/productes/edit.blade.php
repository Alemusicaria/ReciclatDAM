@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Editar Producte</h1>
    <form action="{{ route('productes.update', $producte->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" value="{{ $producte->nom }}" required>
        </div>
        <div class="form-group">
            <label for="categoria">Categoria</label>
            <select name="categoria" id="categoria" class="form-control" required>
                <option value="Deixalleria" {{ $producte->categoria == 'Deixalleria' ? 'selected' : '' }}>Deixalleria</option>
                <option value="Envasos" {{ $producte->categoria == 'Envasos' ? 'selected' : '' }}>Envasos</option>
                <option value="Especial" {{ $producte->categoria == 'Especial' ? 'selected' : '' }}>Especial</option>
                <option value="Medicaments" {{ $producte->categoria == 'Medicaments' ? 'selected' : '' }}>Medicaments</option>
                <option value="Organica" {{ $producte->categoria == 'Organica' ? 'selected' : '' }}>Organica</option>
                <option value="Paper" {{ $producte->categoria == 'Paper' ? 'selected' : '' }}>Paper</option>
                <option value="Piles" {{ $producte->categoria == 'Piles' ? 'selected' : '' }}>Piles</option>
                <option value="RAEE" {{ $producte->categoria == 'RAEE' ? 'selected' : '' }}>RAEE</option>
                <option value="Resta" {{ $producte->categoria == 'Resta' ? 'selected' : '' }}>Resta</option>
                <option value="Vidre" {{ $producte->categoria == 'Vidre' ? 'selected' : '' }}>Vidre</option>
            </select>
        </div>
        <div class="form-group">
            <label for="imatge">Imatge</label>
            <input type="file" name="imatge" id="imatge" class="form-control">
            @if ($producte->imatge)
            <p>Imatge actual:</p>
            <img src="{{ asset($producte->imatge) }}" alt="{{ $producte->nom }}" style="width: 100px; height: 100px; object-fit: cover;">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Actualitzar</button>
    </form>
</div>
@endsection