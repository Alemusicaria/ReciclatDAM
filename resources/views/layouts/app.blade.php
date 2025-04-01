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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
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
                @can('admin')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="crudDropdown" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            CRUD
                        </a>
                        <div class="mt-3 d-flex flex-column align-items-center download-buttons">
                            <a href="#" class="">
                                <img id="apple-store" src="{{ asset('images/icons/apple_light.png') }}"
                                    alt="Descarrega a l'Apple Store" style="max-width: 200px;">
                                <img id="google-play" src="{{ asset('images/icons/google_light.png') }}"
                                    alt="Descarrega a Google Play" style="max-width: 200px;">
                            </a>
                        </div>
                    </li>
                @endcan

            </ul>
            <ul class="navbar-nav ml-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown"
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if(Auth::user()->foto_perfil)
                                @if(str_starts_with(Auth::user()->foto_perfil, 'https://'))
                                    <img src="{{ Auth::user()->foto_perfil }}" alt="Profile Photo" class="rounded-circle"
                                        style="width: 30px; height: 30px; margin-right: 10px;">
                                @elseif(file_exists(public_path('storage/' . Auth::user()->foto_perfil)))
                                    <img src="{{ asset('storage/' . Auth::user()->foto_perfil) }}" alt="Profile Photo"
                                        class="rounded-circle" style="width: 30px; height: 30px; margin-right: 10px;">
                                @else
                                    <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile Photo"
                                        class="rounded-circle" style="width: 30px; height: 30px; margin-right: 10px;">
                                @endif
                            @else
                                <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile Photo"
                                    class="rounded-circle" style="width: 30px; height: 30px; margin-right: 10px;">
                            @endif
                            <span>{{ Auth::user()->nom }} ({{ Auth::user()->punts_actuals }} ECODAMS)</span>
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
                <button id="theme-toggle" class="dropdown-item">
                    <i id="theme-icon" class="fas"></i> {{ __('Toggle Theme') }}
                </button>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" id="lang-ca" href="{{ url('/ca') }}" data-lang="ca">
                    <img src="{{ asset('images/flags/ca.svg') }}" alt="Català" style="width: 20px; margin-right: 10px;">
                    {{ __('Català') }}
                </a>                
                <a class="dropdown-item" id="lang-es" href="{{ url('/es') }}" data-lang="es">
                    <img src="{{ asset('images/flags/es.svg') }}" alt="Español"
                        style="width: 20px; margin-right: 10px;">
                    {{ __('Español') }}
                </a>
                <a class="dropdown-item" id="lang-en" href="{{ url('/en') }}" data-lang="en">
                    <img src="{{ asset('images/flags/en.svg') }}" alt="English"
                        style="width: 20px; margin-right: 10px;">
                    {{ __('English') }}
                </a>
            </div>
        </div>
    </div>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)").matches;
            const currentTheme = localStorage.getItem('theme') || (prefersDarkScheme ? 'dark' : 'light');
            const themeIcon = document.getElementById('theme-icon');
            const themeToggle = document.getElementById('theme-toggle');

            // Funció per actualitzar l'icona del tema
            function updateThemeIcon(theme) {
                if (theme === 'dark') {
                    themeIcon.classList.remove('fa-sun');
                    themeIcon.classList.add('fa-moon');
                } else {
                    themeIcon.classList.remove('fa-moon');
                    themeIcon.classList.add('fa-sun');
                }
            }

            // Inicialitza el tema i la icona
            document.body.classList.add(currentTheme);
            updateThemeIcon(currentTheme);

            const appleStoreImg = document.getElementById('apple-store');
            const googlePlayImg = document.getElementById('google-play');

            function updateImagesBasedOnTheme() {
                const isDarkMode = document.body.classList.contains('dark');
                if (appleStoreImg && googlePlayImg) {
                    appleStoreImg.src = isDarkMode
                        ? "{{ asset('images/icons/apple_dark.png') }}"
                        : "{{ asset('images/icons/apple_light.png') }}";
                    googlePlayImg.src = isDarkMode
                        ? "{{ asset('images/icons/google_dark.png') }}"
                        : "{{ asset('images/icons/google_light.png') }}";
                }
            }

            // Actualitza les imatges inicialment
            updateImagesBasedOnTheme();

            // Escolta els canvis de tema
            themeToggle.addEventListener('click', function () {
                const isDarkMode = document.body.classList.contains('dark');
                const newTheme = isDarkMode ? 'light' : 'dark';
                document.body.classList.toggle('dark', !isDarkMode);
                document.body.classList.toggle('light', isDarkMode);
                localStorage.setItem('theme', newTheme);
                updateImagesBasedOnTheme();
                updateThemeIcon(newTheme);
            });

            // Obtenir informació del navegador i la finestra
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
                    throw new Error(`Error: ${response.status} ${response.statusText}`);
                }
                return response.json();
            }).then(data => console.log('Success:', data))
                .catch((error) => console.error('Error:', error));

        });
    </script>
</body>

</html>