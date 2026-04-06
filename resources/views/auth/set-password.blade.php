@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 9rem; max-width: 520px;">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h1 class="h4 mb-3">Establir contrasenya</h1>
                <p class="text-muted mb-4">Defineix una contrasenya per completar l'accés amb compte social.</p>

                <form method="POST" action="{{ route('set-password') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="password" class="form-label">Contrasenya</label>
                        <input id="password" type="password" class="form-control" name="password" required minlength="8">
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirma contrasenya</label>
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required minlength="8">
                    </div>

                    <button type="submit" class="btn btn-success w-100">Guardar contrasenya</button>
                </form>
            </div>
        </div>
    </div>
@endsection
