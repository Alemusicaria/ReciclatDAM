<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Reciclat DAM')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="light">
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
    <div class="container mt-5 pt-5">
        @yield('content')
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/theme.js') }}" defer></script>
    <script src="{{ asset('js/language.js') }}" defer></script>
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
            }).then(data => {/* Datos recibidos correctamente */ })
                .catch((error) => {
                    // Manejo silencioso de errores o usa un log solo en desarrollo
                    if (process.env.NODE_ENV === 'development') {
                        console.error('Error:', error);
                    }
                });

            // Adaptar el disseny segons la mida de la pantalla
            if (info.screenWidth < 768) {
                document.body.classList.add('mobile');
            } else if (info.screenWidth < 1024) {
                document.body.classList.add('tablet');
            } else {
                document.body.classList.add('desktop');
            }
        });
    </script>
</body>

</html>