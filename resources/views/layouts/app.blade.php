<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.brand') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.getCsrfToken = function () {
            const meta = document.querySelector('meta[name="csrf-token"]');
            return meta ? meta.getAttribute('content') : null;
        };

        (function () {
            if (window.__safeCsrfQuerySelectorPatched) {
                return;
            }

            const originalQuerySelector = Document.prototype.querySelector;

            Document.prototype.querySelector = function (selector) {
                if (selector === 'meta[name="csrf-token"]') {
                    const meta = originalQuerySelector.call(this, selector);
                    if (meta) {
                        return meta;
                    }

                    return {
                        getAttribute: function () {
                            return null;
                        }
                    };
                }

                return originalQuerySelector.call(this, selector);
            };

            window.__safeCsrfQuerySelectorPatched = true;
        })();
    </script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- CSS Libraries - Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <!-- En la sección head de app.blade.php o crear una nueva vista -->
    <script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2/dist/quagga.min.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <!-- PWA -->
    @laravelPWA
</head>

<body class="{{ session('theme', 'light') }}">
    <!-- Navbar con clases de Bootstrap 5 -->
    <nav class="navbar navbar-expand-lg fixed-top light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">{{ __('messages.brand') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Enlaces de navegación a la izquierda -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 flex-nowrap">
                    @php $isHomePage = request()->path() === '/' || request()->path() === app()->getLocale(); @endphp

                    <li class="nav-item">
                        <a class="nav-link" href="{{ $isHomePage ? '#inici' : url('/#inici') }}"
                            data-section="inici">{{ __('messages.footer.home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $isHomePage ? '#funcionament' : url('/#funcionament') }}"
                            data-section="funcionament">{{ __('messages.footer.how_it_works') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $isHomePage ? '#sponsors' : url('/#sponsors') }}"
                            data-section="sponsors">{{ __('messages.sponsors.title') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $isHomePage ? '#qui_som' : url('/#qui_som') }}"
                            data-section="qui_som">{{ __('messages.footer.about_us') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $isHomePage ? '#reciclatge' : url('/#reciclatge') }}"
                            data-section="reciclatge">{{ __('messages.footer.recycling') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $isHomePage ? '#mapa' : url('/#mapa') }}"
                            data-section="mapa">{{ __('messages.footer.location') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $isHomePage ? '#events' : url('/#events') }}"
                            data-section="events">{{ __('messages.admin.events.list_title') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $isHomePage ? '#premis' : url('/#premis') }}"
                            data-section="premis">{{ __('messages.footer.rewards') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $isHomePage ? '#opinions' : url('/#opinions') }}"
                            data-section="opinions">{{ __('messages.footer.opinions') }}</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link btn btn-success text-white" href="{{ route('scanner') }}">
                                <i class="fas fa-qrcode me-1"></i> Escanejar Codi
                            </a>
                        </li>
                    @endauth
                </ul>

                <!-- Usuario/Login a la derecha -->
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ Auth::user()->profilePhotoUrl() }}" alt="Foto de perfil"
                                    class="rounded-circle js-user-avatar" id="navbar-profile-image"
                                    onerror="this.onerror=null;this.src='{{ asset('images/default-profile.png') }}';"
                                    style="width: 30px; height: 30px; object-fit: cover; margin-right: 5px; ">
                                <span>{{ Auth::user()->nom }} ({{ Auth::user()->punts_actuals }} ECODAMS)</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @if(Auth::user()->isAdmin())
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/admin') }}">
                                            <i class="fas fa-cogs me-1"></i> {{ __('messages.admin.dashboard.title') }}
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                @endif
                                <li><a class="dropdown-item"
                                        href="{{ route('users.show', Auth::user()->id) }}">{{ __('messages.admin.users.profile') }}</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="dropdown-item">{{ __('messages.admin.users.logout') }}</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary text-white"
                                href="{{ route('login') }}">{{ __('messages.admin.users.login') }}</a>
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
                aria-expanded="false" aria-label="Settings" title="Settings">
                <i class="fas fa-cog"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" id="settingsDropdownMenu" aria-labelledby="settingsDropdown">
                <li>
                    <button id="theme-toggle" class="dropdown-item" aria-pressed="false" aria-label="{{ __('Toggle Theme') }}">
                        <i id="theme-icon" class="fas"></i> {{ __('Toggle Theme') }}
                    </button>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item" id="lang-ca"
                        href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL('ca', null, [], true) }}"
                        data-lang="ca">
                        <img src="{{ asset('images/flags/ca.svg') }}" alt="Català"
                            style="width: 20px; margin-right: 10px;">
                        {{ __('Català') }}
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" id="lang-es"
                        href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL('es', null, [], true) }}"
                        data-lang="es">
                        <img src="{{ asset('images/flags/es.svg') }}" alt="Español"
                            style="width: 20px; margin-right: 10px;">
                        {{ __('Español') }}
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" id="lang-en"
                        href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL('en', null, [], true) }}"
                        data-lang="en">
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

    @php
        $catalogTranslations = [
            'products' => \App\Models\Producte::all()->mapWithKeys(function ($producte) {
                return [(string) $producte->id => [
                    'nom' => $producte->displayName(),
                    'categoria' => $producte->displayCategory(),
                ]];
            })->all(),
            'premis' => \App\Models\Premi::all()->mapWithKeys(function ($premi) {
                return [(string) $premi->id => [
                    'nom' => $premi->displayName(),
                    'descripcio' => $premi->displayDescription(),
                    'categoria' => $premi->displayCategory(),
                ]];
            })->all(),
            'punts' => \App\Models\PuntDeRecollida::all()->mapWithKeys(function ($punt) {
                return [(string) $punt->id => [
                    'nom' => $punt->displayName(),
                    'fraccio' => $punt->displayWasteFraction(),
                ]];
            })->all(),
            'nivells' => \App\Models\Nivell::all()->mapWithKeys(function ($nivell) {
                return [(string) $nivell->id => [
                    'nom' => $nivell->displayName(),
                    'descripcio' => $nivell->displayDescription(),
                ]];
            })->all(),
            'rols' => \App\Models\Rol::all()->mapWithKeys(function ($rol) {
                return [(string) $rol->id => [
                    'nom' => $rol->displayName(),
                ]];
            })->all(),
            'tipus_alertes' => \App\Models\TipusAlerta::all()->mapWithKeys(function ($tipusAlerta) {
                return [(string) $tipusAlerta->id => [
                    'nom' => $tipusAlerta->displayName(),
                ]];
            })->all(),
        ];
    @endphp

    <!-- Scripts específicos para la sección de administración -->
    @if(Request::is('admin*') || Request::is('*/admin*'))
        <script src="{{ asset('js/admin.js') }}"></script>
    @endif

    <script>
        const createFallbackIndex = () => ({
            search: async () => ({ hits: [] })
        });

        const ensureFallbackIndexes = () => {
            window.productIndex = window.productIndex || createFallbackIndex();
            window.puntsIndex = window.puntsIndex || createFallbackIndex();
            window.opinionsIndex = window.opinionsIndex || createFallbackIndex();
            window.premisIndex = window.premisIndex || createFallbackIndex();
            window.eventsIndex = window.eventsIndex || createFallbackIndex();
            window.tipusEventsIndex = window.tipusEventsIndex || createFallbackIndex();
            window.codisIndex = window.codisIndex || createFallbackIndex();
            window.catalogTranslations = window.catalogTranslations || @json($catalogTranslations);
        };

        // Inicializar cliente Algolia primero
        try {
            const algoliaAppId = @json(config('services.algolia.app_id'));
            const algoliaSearchKey = @json(config('services.algolia.search_key'));

            if (!algoliaAppId || !algoliaSearchKey) {
                throw new Error('Missing Algolia client configuration');
            }

            window.algoliaClient = algoliasearch(algoliaAppId, algoliaSearchKey, {
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
            window.catalogTranslations = @json($catalogTranslations);

            // Señal de que Algolia está listo
            window.algoliaReady = true;

            // Disparar evento personalizado para notificar que Algolia está listo
            document.dispatchEvent(new Event('algoliaReady'));
        } catch (e) {
            console.error("Error inicializando Algolia:", e);
            ensureFallbackIndexes();
            window.algoliaReady = false;
        }

        document.addEventListener('DOMContentLoaded', function () {
            const settingsDropdownTrigger = document.getElementById('settingsDropdown');
            const settingsDropdownMenu = document.getElementById('settingsDropdownMenu');

            if (settingsDropdownTrigger && settingsDropdownMenu) {
                settingsDropdownMenu.style.top = 'auto';
                settingsDropdownMenu.style.bottom = 'calc(100% + 8px)';
                settingsDropdownMenu.style.right = '0';
                settingsDropdownMenu.style.left = 'auto';

                settingsDropdownTrigger.addEventListener('click', function (event) {
                    event.preventDefault();
                    event.stopPropagation();

                    const isOpen = settingsDropdownMenu.classList.contains('show');
                    settingsDropdownMenu.style.top = 'auto';
                    settingsDropdownMenu.style.bottom = 'calc(100% + 8px)';
                    settingsDropdownMenu.classList.toggle('show', !isOpen);
                    settingsDropdownTrigger.setAttribute('aria-expanded', (!isOpen).toString());
                });

                settingsDropdownMenu.addEventListener('click', function (event) {
                    event.stopPropagation();
                });

                document.addEventListener('click', function () {
                    settingsDropdownMenu.classList.remove('show');
                    settingsDropdownTrigger.setAttribute('aria-expanded', 'false');
                });
            }

            // Inicialización del tema
            const prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)").matches;
            const currentTheme = localStorage.getItem('theme') || (prefersDarkScheme ? 'dark' : 'light');
            const themeIcon = document.getElementById('theme-icon');
            const themeToggle = document.getElementById('theme-toggle');
            const navElement = document.querySelector('nav.navbar');

            // Inicializar navegación suave por secciones
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link[data-section]');
            const sectionIds = Array.from(navLinks)
                .map(link => link.dataset.section)
                .filter(Boolean);
            let navSyncLockUntil = 0;

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
            document.body.classList.remove('light', 'dark');
            document.body.classList.add(currentTheme);
            if (navElement) {
                navElement.classList.remove('light', 'dark');
                navElement.classList.add(currentTheme);
            }
            updateThemeIcon(currentTheme);
            if (themeToggle) {
                themeToggle.setAttribute('aria-pressed', (currentTheme === 'dark').toString());
            }

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
            if (themeToggle) {
                themeToggle.addEventListener('click', function () {
                    const isDarkMode = document.body.classList.contains('dark');
                    const newTheme = isDarkMode ? 'light' : 'dark';
                    document.body.classList.remove('light', 'dark');
                    document.body.classList.add(newTheme);
                    if (navElement) {
                        navElement.classList.remove('light', 'dark');
                        navElement.classList.add(newTheme);
                    }
                    localStorage.setItem('theme', newTheme);
                    updateImagesBasedOnTheme();
                    updateThemeIcon(newTheme);
                    themeToggle.setAttribute('aria-pressed', (newTheme === 'dark').toString());
                    applyActiveStyles(); // Actualizar estilos activos cuando cambia el tema
                });
            }

            // Manejo de enlace activo en la navegación
            function applyActiveStyles() {
                // Obtener todos los enlaces de navegación
                const navLinks = document.querySelectorAll('.navbar-nav .nav-link[href^="#"]');

                // Eliminar cualquier línea existente y limpiar estilos
                navLinks.forEach(link => {
                    const existingLine = link.querySelector('.nav-underline');
                    if (existingLine) {
                        existingLine.remove();
                    }
                    link.style.fontWeight = '';
                    link.style.position = '';
                    link.style.transform = '';
                });

                // Encontrar el enlace activo
                const activeLink = document.querySelector('.navbar-nav .nav-link.active');
                if (!activeLink) return;

                // Aplicar estilos directamente al enlace activo
                activeLink.style.fontWeight = '600';
                activeLink.style.position = 'relative';
                activeLink.style.transform = 'scale(1.05)';

                // Crear un elemento para el subrayado
                const line = document.createElement('span');
                line.className = 'nav-underline';

                // Aplicar estilos al subrayado
                line.style.position = 'absolute';
                line.style.bottom = '5px';
                line.style.left = '25%';
                line.style.width = '50%';
                line.style.height = '3px';
                line.style.backgroundColor = document.body.classList.contains('dark') ? '#66bb6a' : '#000';
                line.style.borderRadius = '4px';
                line.style.display = 'block';

                // Añadir el subrayado al enlace activo
                activeLink.appendChild(line);
            }

            function setActiveNavBySection(sectionId) {
                if (!sectionId) return;

                let hasMatch = false;
                navLinks.forEach(link => {
                    const isMatch = link.dataset.section === sectionId;
                    link.classList.toggle('active', isMatch);
                    if (isMatch) {
                        hasMatch = true;
                    }
                });

                if (hasMatch) {
                    applyActiveStyles();
                }
            }

            // Navegación entre secciones
            navLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    const href = this.getAttribute('href') || '';
                    if (!href.startsWith('#')) {
                        return;
                    }

                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);

                    if (targetId === '') return;


                    const targetElement = document.getElementById(targetId);

                    if (targetElement) {
                        // Bloquejar la sincronització automàtica uns instants durant el scroll suau.
                        navSyncLockUntil = Date.now() + 900;

                        // Quitar active de todos los enlaces
                        setActiveNavBySection(targetId);

                        // MÉTODO ALTERNATIVO: Usar scrollIntoView
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });

                        // Ajustar por la altura del navbar después del scroll
                        const navbarHeight = document.querySelector('.navbar').offsetHeight;
                        setTimeout(() => {
                            window.scrollBy(0, -navbarHeight);
                        }, 10);
                    } else {
                        console.warn(`La sección con ID "${targetId}" no se encontró en el documento.`);
                    }
                });
            });

            // Detectar sección visible al hacer scroll
            function updateActiveNavLink() {
                if (Date.now() < navSyncLockUntil) {
                    return;
                }

                const sections = sectionIds
                    .map(id => document.getElementById(id))
                    .filter(Boolean);

                if (sections.length === 0) {
                    return;
                }

                const navbarHeight = document.querySelector('.navbar').offsetHeight;
                const threshold = window.scrollY + navbarHeight + 120;

                // Sección activa = la última cuyo top ya ha quedado por encima del umbral.
                let currentSection = sections[0];
                sections.forEach(section => {
                    if (section.offsetTop <= threshold) {
                        currentSection = section;
                    }
                });

                if (currentSection) {
                    const sectionId = currentSection.getAttribute('id');
                    setActiveNavBySection(sectionId);
                }
            }

            // Inicializar estado activo
            updateActiveNavLink();

            // Actualizar al hacer scroll
            window.addEventListener('scroll', updateActiveNavLink);

            // Actualizar enlace activo cuando cambia el hash (incluye clicks desde footer)
            window.addEventListener('hashchange', function () {
                const targetId = window.location.hash.replace('#', '');
                if (!targetId) return;

                const targetLink = document.querySelector(`.navbar-nav .nav-link[data-section="${targetId}"]`);
                if (!targetLink) return;

                setActiveNavBySection(targetId);
            });

            // Marcar menú automáticamente al pasar el cursor por cada sección.
            sectionIds.forEach(sectionId => {
                const sectionEl = document.getElementById(sectionId);
                if (!sectionEl) return;

                sectionEl.addEventListener('mouseenter', function () {
                    if (Date.now() < navSyncLockUntil) {
                        return;
                    }
                    setActiveNavBySection(sectionId);
                });
            });

            // Si hay un hash en la URL al cargar
            if (window.location.hash) {
                const targetId = window.location.hash.substring(1);
                const targetElement = document.getElementById(targetId);
                const targetLink = document.querySelector(`.navbar-nav .nav-link[data-section="${targetId}"]`);

                if (targetElement && targetLink) {
                    setTimeout(() => {
                        setActiveNavBySection(targetId);

                        const navbarHeight = document.querySelector('.navbar').offsetHeight;
                        const targetPosition = targetElement.getBoundingClientRect().top + window.scrollY - navbarHeight;

                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                    }, 300);
                }
            }
            // Si hay un hash en la URL al cargar una página que no es el dashboard,
            // guardarlo en localStorage y redirigir al dashboard
            if (window.location.hash && window.location.pathname !== '/') {
                const targetSection = window.location.hash.substring(1);
                localStorage.setItem('scrollToSection', targetSection);
                window.location.href = "/";
            }

            // Al cargar el dashboard, verificar si hay una sección a la que navegar
            if (window.location.pathname === '/' || window.location.pathname === '/ca' ||
                window.location.pathname === '/es' || window.location.pathname === '/en') {
                const scrollToSection = localStorage.getItem('scrollToSection');

                if (scrollToSection) {
                    // Limpiar localStorage
                    localStorage.removeItem('scrollToSection');

                    // Pequeño retraso para asegurar que el DOM está completamente cargado
                    setTimeout(() => {
                        const targetElement = document.getElementById(scrollToSection);
                        if (targetElement) {
                            const navbarHeight = document.querySelector('.navbar').offsetHeight;
                            const targetPosition = targetElement.getBoundingClientRect().top + window.scrollY - navbarHeight;

                            window.scrollTo({
                                top: targetPosition,
                                behavior: 'smooth'
                            });

                            // Actualizar enlace activo
                            const targetLink = document.querySelector(`.navbar-nav .nav-link[href="#${scrollToSection}"]`);
                            if (targetLink) {
                                document.querySelectorAll('.navbar-nav .nav-link').forEach(l => l.classList.remove('active'));
                                targetLink.classList.add('active');
                                if (typeof applyActiveStyles === 'function') {
                                    applyActiveStyles();
                                }
                            }
                        }
                    }, 500);
                }
            }
            // Bootstrap gestiona los backdrops de los modales de forma nativa.
            // Aplicar estilos iniciales
            applyActiveStyles();

        });
    </script>
    <script>
        // Código para asegurar que los dropdowns funcionen en todas las páginas
        window.addEventListener('load', function () { // Usar load en lugar de DOMContentLoaded
            // Primero: método directo con jQuery que suele funcionar siempre
            if (typeof $ !== 'undefined') {
                // Inicializar con jQuery
                $('#navbarDropdown').dropdown();

                // Manejar los clics de forma manual
                $(document).on('click', '#navbarDropdown', function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    // Alternar el dropdown manualmente
                    $(this).next('.dropdown-menu').toggleClass('show');

                    // Asegurar z-index alto
                    $(this).next('.dropdown-menu').css('z-index', '9999');
                });

                // Cerrar al hacer clic fuera
                $(document).on('click', function (e) {
                    if (!$(e.target).closest('.dropdown').length) {
                        $('.dropdown-menu').removeClass('show');
                    }
                });
            } else {
                // Método alternativo usando JavaScript vanilla
                const dropdownElementList = document.querySelectorAll('.dropdown-toggle');

                dropdownElementList.forEach(function (dropdownToggleEl) {
                    // Método manual por si Bootstrap no está disponible o falla
                    dropdownToggleEl.addEventListener('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();

                        const menu = this.nextElementSibling;
                        if (menu && menu.classList.contains('dropdown-menu')) {
                            menu.classList.toggle('show');
                            menu.style.zIndex = '9999';
                        }
                    });
                });

                // Cerrar dropdowns al hacer clic fuera
                document.addEventListener('click', function (e) {
                    if (!e.target.closest('.dropdown')) {
                        document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                            menu.classList.remove('show');
                        });
                    }
                });
            }
        });
    </script>

    <script>
        (function () {
            const baseTitle = @json(__('messages.brand')) || 'Reciclat DAM';
            let rafId = null;

            function normalize(text) {
                return String(text || '').replace(/\s+/g, ' ').trim();
            }

            function composeTitle(part) {
                const cleanPart = normalize(part);
                return cleanPart ? cleanPart + ' | ' + baseTitle : baseTitle;
            }

            function getModalTitle() {
                const openModals = Array.from(document.querySelectorAll('.modal.show'));
                if (openModals.length === 0) {
                    return '';
                }

                const latest = openModals[openModals.length - 1];
                const modalTitle = latest.querySelector('.modal-title, [data-modal-title], h1, h2, h3');
                return normalize(modalTitle ? modalTitle.textContent : '');
            }

            function getActiveTabTitle() {
                const activeTab = document.querySelector('.nav-tabs .nav-link.active, .nav-pills .nav-link.active, [role="tab"].active');
                return normalize(activeTab ? activeTab.textContent : '');
            }

            function getHashTitle() {
                const hash = normalize(window.location.hash.replace('#', ''));
                if (!hash) {
                    return '';
                }

                const navByData = document.querySelector('.navbar-nav .nav-link[data-section="' + CSS.escape(hash) + '"]');
                if (navByData) {
                    return normalize(navByData.textContent);
                }

                const sectionEl = document.getElementById(hash);
                if (!sectionEl) {
                    return '';
                }

                const heading = sectionEl.querySelector('h1, h2, h3, [data-section-title]');
                return normalize(heading ? heading.textContent : '');
            }

            function getPageTitle() {
                const explicit = document.querySelector('[data-page-title]');
                if (explicit) {
                    const explicitTitle = normalize(explicit.getAttribute('data-page-title') || explicit.textContent);
                    if (explicitTitle) {
                        return explicitTitle;
                    }
                }

                const firstHeading = document.querySelector('main h1, .container h1, .container-fluid h1, h1');
                if (firstHeading) {
                    const headingText = normalize(firstHeading.textContent);
                    if (headingText) {
                        return headingText;
                    }
                }

                const activeNav = document.querySelector('.navbar-nav .nav-link.active');
                if (activeNav) {
                    const navText = normalize(activeNav.textContent);
                    if (navText) {
                        return navText;
                    }
                }

                const path = normalize(window.location.pathname.toLowerCase());
                if (!path || path === '/' || path === '/ca' || path === '/es' || path === '/en') {
                    return '';
                }

                const fallbackMap = {
                    '/login': 'Login',
                    '/register': 'Register',
                    '/scanner': 'Scanner',
                    '/admin': 'Admin',
                    '/events': 'Events',
                    '/users': 'Profile'
                };

                const matched = Object.keys(fallbackMap).find(function (prefix) {
                    return path.endsWith(prefix) || path.indexOf('/ca' + prefix) !== -1 || path.indexOf('/es' + prefix) !== -1 || path.indexOf('/en' + prefix) !== -1;
                });

                return matched ? fallbackMap[matched] : '';
            }

            function updateDocumentTitleNow() {
                const modalTitle = getModalTitle();
                const tabTitle = getActiveTabTitle();
                const hashTitle = getHashTitle();
                const pageTitle = getPageTitle();
                const titlePart = modalTitle || tabTitle || hashTitle || pageTitle;
                document.title = composeTitle(titlePart);
            }

            function scheduleTitleUpdate() {
                if (rafId !== null) {
                    cancelAnimationFrame(rafId);
                }

                rafId = requestAnimationFrame(function () {
                    updateDocumentTitleNow();
                    rafId = null;
                });
            }

            window.addEventListener('DOMContentLoaded', scheduleTitleUpdate);
            window.addEventListener('load', scheduleTitleUpdate);
            window.addEventListener('hashchange', scheduleTitleUpdate);
            window.addEventListener('popstate', scheduleTitleUpdate);

            document.addEventListener('shown.bs.modal', scheduleTitleUpdate);
            document.addEventListener('hidden.bs.modal', scheduleTitleUpdate);
            document.addEventListener('shown.bs.tab', scheduleTitleUpdate);
            document.addEventListener('shown.bs.pill', scheduleTitleUpdate);

            const observer = new MutationObserver(scheduleTitleUpdate);
            observer.observe(document.body, {
                subtree: true,
                childList: true,
                attributes: true,
                attributeFilter: ['class', 'aria-selected']
            });
        })();
    </script>

</body>

</html>