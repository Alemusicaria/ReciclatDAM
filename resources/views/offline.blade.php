@extends('layouts.app')

@section('content')
<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-4">¡Sin conexión!</h1>
            <p class="lead">Parece que no tienes conexión a internet en este momento.</p>
            <img src="{{ asset('images/offline.svg') }}" alt="Sin conexión" class="img-fluid my-4" style="max-width: 300px;">
            <p>Para acceder a todas las funcionalidades de ReciclatDAM necesitas una conexión a internet.</p>
            <button class="btn btn-primary mt-3" onclick="window.location.reload()">Intentar nuevamente</button>
        </div>
    </div>
</div>
@endsection