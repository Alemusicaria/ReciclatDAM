<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reciclat DAM</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="light">
    <nav class="navbar navbar-expand-lg fixed-top light">
        <a class="navbar-brand" href="{{ url(app()->getLocale()) }}">Reciclat DAM</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('premis.index', app()->getLocale()) }}">Premis</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('codis.index', app()->getLocale()) }}">Codis</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.index', app()->getLocale()) }}">Users</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5 pt-5">
        @yield('content')
    </div>
    <div class="fixed-bottom-right">
        <div class="dropdown">
            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="settingsDropdown"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-cog"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="settingsDropdown">
                <button id="theme-toggle" class="dropdown-item">Toggle Theme</button>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" id="lang-ca" href="{{ url('/ca') }}" data-lang="ca">{{ __('Català') }}</a>
                <a class="dropdown-item" id="lang-en" href="{{ url('/en') }}" data-lang="en">{{ __('English') }}</a>
                <a class="dropdown-item" id="lang-es" href="{{ url('/es') }}" data-lang="es">{{ __('Español') }}</a>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="{{ asset('js/theme.js') }}" defer></script>
    <script src="{{ asset('js/language.js') }}" defer></script>
    <script>
        document.getElementById('lang-ca').addEventListener('click', function () {
            window.location.href = '{{ url('/ca') }}';
        });
        document.getElementById('lang-en').addEventListener('click', function () {
            window.location.href = '{{ url('/en') }}';
        });
        document.getElementById('lang-es').addEventListener('click', function () {
            window.location.href = '{{ url('/es') }}';
        });
    </script>
</body>

</html>