<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reciclat DAM - {{ __('messages.language') }}</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}" />
</head>

<body class="light">
    <nav class="navbar navbar-expand-lg fixed-top">
        <a class="navbar-brand" href="{{ url(app()->getLocale()) }}">Reciclat DAM</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                
                @can('admin')
                    <li class="nav-item dropdown"></li>
                        <a class="nav-link dropdown-toggle" href="#" id="crudDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            CRUD
                        </a>
                        <div class="dropdown-menu" aria-labelledby="crudDropdown"></div>
                            <a class="dropdown-item" href="{{ route('premis.index', app()->getLocale()) }}">Premis</a>
                            <a class="dropdown-item" href="{{ route('codis.index', app()->getLocale()) }}">Codis</a>
                            <a class="dropdown-item" href="{{ route('users.index', app()->getLocale()) }}">Users</a>
                        </div>
                    </li>
                @endcan
            </ul>
            <ul class="navbar-nav ml-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if(Auth::user()->foto_perfil)
                                <img src="{{ asset('storage/' . Auth::user()->foto_perfil) }}" alt="Profile Photo" class="rounded-circle" style="width: 30px; height: 30px; margin-right: 10px;">
                            @else
                                <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile Photo" class="rounded-circle" style="width: 30px; height: 30px; margin-right: 10px;">
                            @endif
                            <span>{{ Auth::user()->nom }} ({{ Auth::user()->punts_actuals }} pts)</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('users.show', Auth::user()->id) }}">Perfil</a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Tanca sessió</button>
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-white" href="{{ route('login') }}">Iniciar sessió</a>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>
    <div class="container-fluid h-100">
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Detectar el mode de color del sistema
            const prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)").matches;
            const currentTheme = localStorage.getItem('theme') || (prefersDarkScheme ? 'dark' : 'light');
            document.body.classList.add(currentTheme);

            // Obtenir informació del navigator i window
            const info = {
                appCodeName: navigator.appCodeName,
                appName: navigator.appName,
                appVersion: navigator.appVersion,
                cookieEnabled: navigator.cookieEnabled,
                hardwareConcurrency: navigator.hardwareConcurrency,
                language: navigator.language,
                languages: navigator.languages,
                maxTouchPoints: navigator.maxTouchPoints,
                platform: navigator.platform,
                product: navigator.product,
                productSub: navigator.productSub,
                userAgent: navigator.userAgent,
                vendor: navigator.vendor,
                vendorSub: navigator.vendorSub,
                screenWidth: window.innerWidth,
                screenHeight: window.innerHeight,
                screenAvailWidth: window.screen.availWidth,
                screenAvailHeight: window.screen.availHeight,
                screenColorDepth: window.screen.colorDepth,
                screenPixelDepth: window.screen.pixelDepth
            };

            console.log('Navigator and Window Info:', info);

            // Enviar les dades al servidor
            fetch('/save-navigator-info', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(info)
            }).then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            }).then(data => console.log('Success:', data))
                .catch((error) => console.error('Error:', error));

            // Adaptar el disseny segons la mida de la pantalla
            // if (info.screenWidth < 768) {
            //     document.body.classList.add('mobile');
            // } else if (info.screenWidth < 1024) {
            //     document.body.classList.add('tablet');
            // } else {
            //     document.body.classList.add('desktop');
            // }
        });
    </script>
</body>

</html>