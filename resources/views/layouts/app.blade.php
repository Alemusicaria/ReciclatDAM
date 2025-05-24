<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reciclat DAM - {{ __('messages.language') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- CSS Libraries - Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body class="{{ session('theme', 'light') }}">
    <!-- Navbar con clases de Bootstrap 5 -->
    <nav class="navbar navbar-expand-lg fixed-top light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">Reciclat DAM</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Enlaces de navegación a la izquierda -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#inici" data-section="inici">Inici</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#funcionament" data-section="funcionament">Com funciona</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sponsors" data-section="sponsors">Sponsors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#qui_som" data-section="qui_som">Qui som</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#reciclatge" data-section="reciclatge">Reciclatge</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#mapa" data-section="mapa">Mapa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#events" data-section="events">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#premis" data-section="premis">Premis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#opinions" data-section="opinions">Opinions</a>
                    </li>
                    @if(Auth::check() && Auth::user()->rol_id == 1)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/admin') }}">
                                <i class="fas fa-cogs"></i> Administració
                            </a>
                        </li>
                    @endif
                </ul>

                <!-- Usuario/Login a la derecha -->
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('users.show', Auth::user()->id) }}">Perfil</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Tanca sessió</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary text-white" href="{{ route('login') }}">Iniciar sessió</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container-fluid h-100">
        @yield('content')
    </div>

    <!-- Botón de configuración flotante -->
    <div class="fixed-bottom-right">
        <div class="dropdown">
            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="settingsDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-cog"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="settingsDropdown">
                <li>
                    <button id="theme-toggle" class="dropdown-item">
                        <i id="theme-icon" class="fas"></i> {{ __('Toggle Theme') }}
                    </button>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item" id="lang-ca" href="{{ url('/ca') }}" data-lang="ca">
                        <img src="{{ asset('images/flags/ca.svg') }}" alt="Català"
                            style="width: 20px; margin-right: 10px;">
                        {{ __('Català') }}
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" id="lang-es" href="{{ url('/es') }}" data-lang="es">
                        <img src="{{ asset('images/flags/es.svg') }}" alt="Español"
                            style="width: 20px; margin-right: 10px;">
                        {{ __('Español') }}
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" id="lang-en" href="{{ url('/en') }}" data-lang="en">
                        <img src="{{ asset('images/flags/en.svg') }}" alt="English"
                            style="width: 20px; margin-right: 10px;">
                        {{ __('English') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Scripts JS (optimizados, sin duplicados) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/algoliasearch@4.17.2/dist/algoliasearch-lite.umd.js"></script>

    <!-- Scripts específicos para la sección de administración -->
    @if(Request::is('admin*'))
        <script src="{{ asset('js/admin.js') }}"></script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inicialización del tema
            const prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)").matches;
            const currentTheme = localStorage.getItem('theme') || (prefersDarkScheme ? 'dark' : 'light');
            const themeIcon = document.getElementById('theme-icon');
            const themeToggle = document.getElementById('theme-toggle');

            // Inicializar navegación suave por secciones
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link[href^="#"]');
            console.log("Enlaces de navegación encontrados:", navLinks.length);

            // Función para actualizar el icono del tema
            function updateThemeIcon(theme) {
                if (theme === 'dark') {
                    themeIcon.classList.remove('fa-sun');
                    themeIcon.classList.add('fa-moon');
                } else {
                    themeIcon.classList.remove('fa-moon');
                    themeIcon.classList.add('fa-sun');
                }
            }

            // Inicializa el tema y la icona
            document.body.classList.add(currentTheme);
            updateThemeIcon(currentTheme);

            // Actualizar imágenes de tiendas según el tema
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

            // Actualiza las imágenes inicialmente
            updateImagesBasedOnTheme();

            // Cambio de tema
            themeToggle.addEventListener('click', function () {
                const isDarkMode = document.body.classList.contains('dark');
                const newTheme = isDarkMode ? 'light' : 'dark';
                document.body.classList.toggle('dark', !isDarkMode);
                document.body.classList.toggle('light', isDarkMode);
                localStorage.setItem('theme', newTheme);
                updateImagesBasedOnTheme();
                updateThemeIcon(newTheme);
            });

            const navigatorInfo = {
                appCodeName: navigator.appCodeName,
                appName: navigator.appName,
                appVersion: navigator.appVersion,
                cookieEnabled: navigator.cookieEnabled,
                hardwareConcurrency: navigator.hardwareConcurrency || 0,
                language: navigator.language,
                languages: navigator.languages ? Array.from(navigator.languages) : [],
                maxTouchPoints: navigator.maxTouchPoints || 0,
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

            // Enviar los datos al servidor
            fetch('/save-navigator-info', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(navigatorInfo)
            }).then(response => {
                return response.json();
            }).catch(error => {
                // Manejo de error silencioso
                console.error("Error al guardar información del navegador:", error);
            });
            // Añadir listener a cada enlace
            navLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);

                    if (targetId === '') return;

                    const targetElement = document.getElementById(targetId);

                    if (targetElement) {
                        // Usar scrollIntoView en lugar de window.scrollTo
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });

                        // Ajuste para la altura del navbar
                        const navbarHeight = document.querySelector('.navbar').offsetHeight;
                        window.scrollBy(0, -navbarHeight);
                    } else {
                        console.warn(`La sección con ID "${targetId}" no se encontró en el documento.`);
                    }
                });
            });

            // Si hay un hash en la URL al cargar la página, desplazarse a la sección correspondiente
            if (window.location.hash) {
                const targetId = window.location.hash.substring(1);
                const targetElement = document.getElementById(targetId);

                if (targetElement) {
                    setTimeout(() => {
                        const navbarHeight = document.querySelector('.navbar').offsetHeight;
                        const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - navbarHeight;

                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                    }, 300); // Pequeño retraso para asegurar que todo está cargado
                }
            }

            // Función unificada para resaltar enlaces de navegación activos
            function updateActiveNavLink() {
                const sections = document.querySelectorAll('section[id]');
                const navbarHeight = document.querySelector('.navbar').offsetHeight;
                let currentSectionId = '';

                sections.forEach(section => {
                    const sectionTop = section.offsetTop - navbarHeight - 50;
                    const sectionBottom = sectionTop + section.offsetHeight;

                    if (window.scrollY >= sectionTop && window.scrollY < sectionBottom) {
                        currentSectionId = section.getAttribute('id');
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove('active');
                    const linkSection = link.getAttribute('href').substring(1);

                    if (linkSection === currentSectionId) {
                        link.classList.add('active');
                    }
                });
            }

            // Ejecutar al cargar y al hacer scroll
            updateActiveNavLink();
            window.addEventListener('scroll', updateActiveNavLink);
        });

        // Inicializar cliente Algolia una vez para toda la aplicación
        window.algoliaClient = algoliasearch("4JU9PG98CF", "d37ffd358dca40447584fb2ffdc28e03", {
            _useRequestCache: true,
            logLevel: 'error'
        });

        // Inicializar índices para uso en toda la aplicación
        window.productIndex = window.algoliaClient.initIndex('productes');
        window.puntsIndex = window.algoliaClient.initIndex('punts_de_recollida');
        window.opinionsIndex = window.algoliaClient.initIndex('opinions');
        window.premisIndex = window.algoliaClient.initIndex('premis');
        window.eventsIndex = window.algoliaClient.initIndex('events');
        window.tipusEventsIndex = window.algoliaClient.initIndex('tipus_events');
        window.codisIndex = window.algoliaClient.initIndex('codis');
    </script>
</body>

</html>