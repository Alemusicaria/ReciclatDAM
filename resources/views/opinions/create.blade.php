@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nova Opinió</h1>
    <form action="{{ route('opinions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="autor" class="form-label">Autor</label>
            <input type="text" name="autor" id="autor" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="comentari" class="form-label">Comentari</label>
            <textarea name="comentari" id="comentari" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="estrelles" class="form-label">Estrelles</label>
            <input type="number" name="estrelles" id="estrelles" class="form-control" step="0.1" min="1" max="5" required>
        </div>
        <button type="submit" class="btn btn-primary">Desa</button>
    </form>
</div>
@endsection