@extends('layouts.app')

@section('content')
<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">Detalls de l'alerta</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="fw-bold">Punt de recollida:</h6>
                        <p>{{ $alertaPuntDeRecollida->puntDeRecollida->nom }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="fw-bold">Tipus de problema:</h6>
                        <p>{{ $alertaPuntDeRecollida->tipus->nom }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="fw-bold">Descripció:</h6>
                        <p>{{ $alertaPuntDeRecollida->descripció }}</p>
                    </div>
                    
                    @if($alertaPuntDeRecollida->imatge)
                    <div class="mb-4">
                        <h6 class="fw-bold">Imatge:</h6>
                        <img src="{{ asset($alertaPuntDeRecollida->imatge) }}" alt="Imatge del problema" class="img-fluid rounded">
                    </div>
                    @endif
                    
                    <div class="mb-4">
                        <h6 class="fw-bold">Data de creació:</h6>
                        <p>{{ $alertaPuntDeRecollida->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    @if($alertaPuntDeRecollida->user)
                    <div class="mb-4">
                        <h6 class="fw-bold">Reportat per:</h6>
                        <p>{{ $alertaPuntDeRecollida->user->name }}</p>
                    </div>
                    @endif
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('scanner') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Tornar
                        </a>
                        @if(auth()->check() && (auth()->user()->rol_id == 1 || (auth()->user()->id == $alertaPuntDeRecollida->user_id)))
                        <div>
                            <a href="{{ route('alertes_punts_de_recollida.edit', $alertaPuntDeRecollida->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit me-1"></i> Editar
                            </a>
                            <form method="POST" action="{{ route('alertes_punts_de_recollida.destroy', $alertaPuntDeRecollida->id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Estàs segur que vols eliminar aquesta alerta?')">
                                    <i class="fas fa-trash me-1"></i> Eliminar
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection