@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Resultats de la Cerca</h1>
    <p class="text-center">Cerca: <strong>{{ $query }}</strong></p>

    <div class="row">
        @forelse ($premis as $premi)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if ($premi->imatge)
                        <img src="{{ asset($premi->imatge) }}" class="card-img-top" alt="{{ $premi->nom }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $premi->nom }}</h5>
                        <p class="card-text">{{ $premi->descripcio }}</p>
                        <p class="card-text"><strong>Punts Requerits:</strong> {{ $premi->punts_requerits }}</p>
                        <a href="{{ route('premis.show', $premi->id) }}" class="btn btn-primary">Veure Detalls</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">No s'han trobat premis per a la cerca "{{ $query }}".</p>
        @endforelse
    </div>
</div>
@endsection