@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Crear Nou Producte</h1>
    <form action="{{ route('productes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="categoria">Categoria</label>
            <select name="categoria" id="categoria" class="form-control" required>
                <option value="Deixalleria">Deixalleria</option>
                <option value="Envasos">Envasos</option>
                <option value="Especial">Especial</option>
                <option value="Medicaments">Medicaments</option>
                <option value="Organica">Organica</option>
                <option value="Paper">Paper</option>
                <option value="Piles">Piles</option>
                <option value="RAEE">RAEE</option>
                <option value="Resta">Resta</option>
                <option value="Vidre">Vidre</option>
            </select>
        </div>
        <div class="form-group">
            <label for="imatge">Imatge</label>
            <input type="file" name="imatge" id="imatge" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Crear</button>
    </form>
</div>
@endsection