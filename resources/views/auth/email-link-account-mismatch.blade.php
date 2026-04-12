@extends('layouts.app')

@section('content')
<div class="container page-offset-profile" style="max-width: 760px;">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h1 class="h4 mb-3">Compte diferent detectat</h1>
            <p class="mb-2">
                Aquest enllac de correu es per al compte:
                <strong>{{ $recipientUser?->email ?? ('#' . request('recipient')) }}</strong>
            </p>
            <p class="mb-4">
                Ara mateix tens sessio iniciada com:
                <strong>{{ $currentUser->email }}</strong>
            </p>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ $switchUrl }}" class="btn btn-primary">
                    Tancar sessio i continuar
                </a>
                <a href="{{ $targetUrl }}" class="btn btn-outline-secondary">
                    Continuar amb aquest compte
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
