@extends('layouts.app')

@section('content')
<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h3>{{ __('Perfil de l\'usuari') }}</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        @if(Auth::user()->foto_perfil)
                            @if(str_starts_with(Auth::user()->foto_perfil, 'https://'))
                                <img src="{{ Auth::user()->foto_perfil }}" alt="Profile Photo" class="rounded-circle"
                                    style="width: 100px; height: 100px; margin-right: 20px;">
                            @elseif(file_exists(public_path('storage/' . Auth::user()->foto_perfil)))
                                <img src="{{ asset('storage/' . Auth::user()->foto_perfil) }}" alt="Profile Photo"
                                    class="rounded-circle" style="width: 100px; height: 100px; margin-right: 20px;">
                            @else
                                <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile Photo"
                                    class="rounded-circle" style="width: 100px; height: 100px; margin-right: 20px;">
                            @endif
                        @else
                            <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile Photo"
                                class="rounded-circle" style="width: 100px; height: 100px; margin-right: 20px;">
                        @endif
                        <div>
                            <h4><a href="#" class="editable" data-name="nom" data-type="text" data-pk="{{ Auth::user()->id }}" data-url="{{ route('users.update', Auth::user()->id) }}" data-title="Enter name">{{ Auth::user()->nom }}</a> <a href="#" class="editable" data-name="cognoms" data-type="text" data-pk="{{ Auth::user()->id }}" data-url="{{ route('users.update', Auth::user()->id) }}" data-title="Enter surname">{{ Auth::user()->cognoms }}</a></h4>
                            <p><a href="#" class="editable" data-name="email" data-type="text" data-pk="{{ Auth::user()->id }}" data-url="{{ route('users.update', Auth::user()->id) }}" data-title="Enter email">{{ Auth::user()->email }}</a></p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <h5>{{ __('Informació personal') }}</h5>
                        <p><strong>{{ __('Data de naixement:') }}</strong> <a href="#" class="editable" data-name="data_naieixement" data-type="date" data-pk="{{ Auth::user()->id }}" data-url="{{ route('users.update', Auth::user()->id) }}" data-title="Enter birth date">{{ Auth::user()->data_naieixement }}</a></p>
                        <p><strong>{{ __('Telèfon:') }}</strong> <a href="#" class="editable" data-name="telefon" data-type="text" data-pk="{{ Auth::user()->id }}" data-url="{{ route('users.update', Auth::user()->id) }}" data-title="Enter phone">{{ Auth::user()->telefon }}</a></p>
                        <p><strong>{{ __('Ubicació:') }}</strong> <a href="#" class="editable" data-name="ubicacio" data-type="text" data-pk="{{ Auth::user()->id }}" data-url="{{ route('users.update', Auth::user()->id) }}" data-title="Enter location">{{ Auth::user()->ubicacio }}</a></p>
                    </div>
                    <div class="mb-3">
                        <h5>{{ __('Punts') }}</h5>
                        <p><strong>{{ __('Punts totals:') }}</strong> {{ Auth::user()->punts_totals }}</p>
                        <p><strong>{{ __('Punts actuals:') }}</strong> {{ Auth::user()->punts_actuals }}</p>
                        <p><strong>{{ __('Punts gastats:') }}</strong> {{ Auth::user()->punts_gastats }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script>
    $(document).ready(function() {
        $.fn.editable.defaults.mode = 'inline';
        $('.editable').editable();
    });
</script>
@endpush

<style>
    .container {
        margin-top: 2rem;
    }

    .card {
        background-color: var(--bs-card-bg);
        color: var(--bs-card-color);
    }

    .btn-primary {
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
    }

    .btn-primary:hover {
        background-color: var(--bs-primary-hover);
        border-color: var(--bs-primary-hover);
    }
</style>