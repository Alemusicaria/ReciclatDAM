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
                    @php $isHomePage = request()->path() === '/' || request()->path() === app()->getLocale(); @endphp

                    <li class="nav-item">
                        <a class="nav-link" href="{{ $isHomePage ? '#inici' : url('/#inici') }}"
                            data-section="inici">Inici</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $isHomePage ? '#funcionament' : url('/#funcionament') }}"
                            data-section="funcionament">Com funciona</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $isHomePage ? '#sponsors' : url('/#sponsors') }}"
                            data-section="sponsors">Sponsors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $isHomePage ? '#qui_som' : url('/#qui_som') }}"
                            data-section="qui_som">Qui som</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $isHomePage ? '#reciclatge' : url('/#reciclatge') }}"
                            data-section="reciclatge">Reciclatge</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $isHomePage ? '#mapa' : url('/#mapa') }}"
                            data-section="mapa">Mapa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $isHomePage ? '#events' : url('/#events') }}"
                            data-section="events">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $isHomePage ? '#premis' : url('/#premis') }}"
                            data-section="premis">Premis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $isHomePage ? '#opinions' : url('/#opinions') }}"
                            data-section="opinions">Opinions</a>
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
        // Inicializar cliente Algolia primero
        try {
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

            // Señal de que Algolia está listo
            window.algoliaReady = true;

            // Disparar evento personalizado para notificar que Algolia está listo
            document.dispatchEvent(new Event('algoliaReady'));
        } catch (e) {
            console.error("Error inicializando Algolia:", e);
            window.algoliaReady = false;
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Inicialización del tema
            const prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)").matches;
            const currentTheme = localStorage.getItem('theme') || (prefersDarkScheme ? 'dark' : 'light');
            const themeIcon = document.getElementById('theme-icon');
            const themeToggle = document.getElementById('theme-toggle');

            // Inicializar navegación suave por secciones
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link[href^="#"]');

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
                applyActiveStyles(); // Actualizar estilos activos cuando cambia el tema
            });

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

            // Navegación entre secciones
            navLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);

                    if (targetId === '') return;


                    const targetElement = document.getElementById(targetId);

                    if (targetElement) {
                        // Quitar active de todos los enlaces
                        navLinks.forEach(l => l.classList.remove('active'));

                        // Añadir active al enlace clickeado
                        this.classList.add('active');

                        // Aplicar estilos al enlace activo
                        applyActiveStyles();

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
                const sections = document.querySelectorAll('section[id]');
                if (sections.length === 0) return;

                const navbarHeight = document.querySelector('.navbar').offsetHeight;
                const scrollPosition = window.scrollY + navbarHeight + 50;

                let currentSection = null;
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.offsetHeight;
                    const sectionBottom = sectionTop + sectionHeight;

                    if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) {
                        currentSection = section;
                    }
                });

                // Si no encontramos sección y estamos cerca del inicio, usar la primera
                if (!currentSection && window.scrollY < sections[0].offsetTop) {
                    currentSection = sections[0];
                }

                if (currentSection) {
                    const sectionId = currentSection.getAttribute('id');

                    // Actualizar enlaces activos
                    navLinks.forEach(link => {
                        link.classList.remove('active');
                        const linkHref = link.getAttribute('href');

                        if (linkHref === `#${sectionId}`) {
                            link.classList.add('active');
                        }
                    });

                    // Aplicar estilos al enlace activo
                    applyActiveStyles();
                }
            }

            // Inicializar estado activo
            updateActiveNavLink();

            // Actualizar al hacer scroll
            window.addEventListener('scroll', updateActiveNavLink);

            // Si hay un hash en la URL al cargar
            if (window.location.hash) {
                const targetId = window.location.hash.substring(1);
                const targetElement = document.getElementById(targetId);
                const targetLink = document.querySelector(`.navbar-nav .nav-link[href="#${targetId}"]`);

                if (targetElement && targetLink) {
                    setTimeout(() => {
                        navLinks.forEach(l => l.classList.remove('active'));
                        targetLink.classList.add('active');
                        applyActiveStyles();

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
            function cleanupModalBackdrops() {
                // Eliminar todos los backdrops
                document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
                    backdrop.remove();
                });

                // Restaurar el estado del body
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';

            }

            // Limpiar backdrops cuando se cierra cualquier modal
            document.addEventListener('hidden.bs.modal', function (event) {
                setTimeout(cleanupModalBackdrops, 100);
            });

            // Añadir función a window para llamarla desde la consola en caso de emergencia
            window.fixModals = cleanupModalBackdrops;

            // Ejecutar limpieza al cargar la página (por si hay residuos)
            document.addEventListener('DOMContentLoaded', cleanupModalBackdrops);

            // Añadir manejador de tecla Escape para limpiar modales
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    setTimeout(cleanupModalBackdrops, 100);
                }
            });
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

</body>

</html>