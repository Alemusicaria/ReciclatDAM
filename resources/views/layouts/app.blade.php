<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reciclat DAM</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script src="{{ asset('js/theme.js') }}" defer></script>
    <script src="{{ asset('js/language.js') }}" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="light">
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="/">Reciclat DAM</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('premis.index') }}">Premis</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('codis.index') }}">Codis</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.index') }}">Users</a>
                </li>
            </ul>
            <button id="theme-toggle" class="btn btn-secondary btn-sm">Toggle Theme</button>
            <div class="dropdown ml-2">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="languageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Language
                </button>
                <div class="dropdown-menu" aria-labelledby="languageDropdown">
                    <a class="dropdown-item" href="#" data-lang="ca">Català</a>
                    <a class="dropdown-item" href="#" data-lang="en">English</a>
                    <a class="dropdown-item" href="#" data-lang="es">Español</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container mt-5 pt-5">
        @yield('content')
    </div>
</body>
</html>