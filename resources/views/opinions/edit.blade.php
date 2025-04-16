@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edita Opinió</h1>
    <form action="{{ route('opinions.update', $opinion) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="autor" class="form-label">Autor</label>
            <input type="text" name="autor" id="autor" class="form-control" value="{{ $opinion->autor }}" required>
        </div>
        <div class="mb-3">
            <label for="comentari" class="form-label">Comentari</label>
            <textarea name="comentari" id="comentari" class="form-control" rows="3" required>{{ $opinion->comentari }}</textarea>
        </div>
        <div class="mb-3">
            <label for="estrelles" class="form-label">Estrelles</label>
            <input type="number" name="estrelles" id="estrelles" class="form-control" step="0.1" min="1" max="5" value="{{ $opinion->estrelles }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualitza</button>
    </form>
</div>
@endsection