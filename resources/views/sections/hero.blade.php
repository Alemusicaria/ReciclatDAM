<section id="inici" class="hero text-left">
    <div class="row justify-content-center align-items-center h-100 w-100">
        <!-- Text i Cerca -->
        <div class="col-lg-5 d-flex align-items-center justify-content-center">
            <div class="card mb-4 p-4 w-100">
                <div class="card-body text-left">
                    <h1 class="display-4 fw-bold text-left">{{ __('messages.hero.title') }} <br>
                        {{ __('messages.hero.subtitle') }}</h1>
                    <p class="lead text-left">{{ __('messages.hero.description') }}</p>

                    <div class="hero-search-container">
                        <input type="text" id="search-input" class="form-control"
                            placeholder="{{ __('messages.hero.search_placeholder') }}">
                        <button id="clear-hero-search" type="button">&times;</button>
                        <ul id="search-results" class="list-group" style="display: none;"></ul>
                    </div>

                    <div class="mt-4 d-flex justify-content-center gap-3">
                        <img src="" alt="{{ __('messages.hero.apple_store') }}" style="max-width: 180px;"
                            id="apple-store">
                        <img src="" alt="{{ __('messages.hero.google_play') }}" style="max-width: 180px;"
                            id="google-play">
                    </div>
                </div>
            </div>
        </div>

        <!-- Imatge del mòbil -->
        <div class="col-lg-5 d-flex align-items-center justify-content-center">
            <div class="card mb-4 p-3 d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/mobil.png') }}" class="img-fluid"
                    alt="{{ __('messages.hero.hero_image_alt') }}" style="max-width: 350px; height: auto;">
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const puntsIndex = window.puntsIndex; // Usa la variable global

        const searchInput = document.getElementById('search-input');
        const searchResults = document.getElementById('search-results');
        const clearSearchBtn = document.getElementById('clear-hero-search');

        const GOOGLE_MAPS_API_KEY = "{{ config('services.google_maps.key') }}";

        const fraccioColors = {
            'Paper': '#2859bc',
            'Envasos': '#fddd19',
            'Orgànica': '#9e6831',
            'Vidre': '#3fd055',
            'Resta': '#6d7878',
            'Deixalleria': '#d62c2d',
            'Medicaments': '#b7e53b',
            'Piles': '#fca614',
            'Especial': '#2f3939',
            'RAEE': '#006f3f'
        };

        // Funció per mostrar resultats amb animació
        function showResults() {
            searchResults.style.display = 'block';
            searchResults.style.opacity = '0';
            searchResults.style.transform = 'translateY(-10px)';

            setTimeout(() => {
                searchResults.style.transition = 'opacity 0.3s, transform 0.3s';
                searchResults.style.opacity = '1';
                searchResults.style.transform = 'translateY(0)';
            }, 10);
        }

        // Funció per amagar resultats amb animació
        function hideResults() {
            searchResults.style.transition = 'opacity 0.3s, transform 0.3s';
            searchResults.style.opacity = '0';
            searchResults.style.transform = 'translateY(-10px)';

            setTimeout(() => {
                searchResults.style.display = 'none';
            }, 300);
        }

        // Event de cerca
        searchInput.addEventListener('input', function () {
            const query = searchInput.value.trim();

            if (query === '') {
                hideResults();
                clearSearchBtn.style.display = 'none';
                return;
            }

            clearSearchBtn.style.display = 'block';

            puntsIndex.search(query, {
                hitsPerPage: 10
            }).then(({ hits }) => {
                searchResults.innerHTML = '';

                if (hits.length === 0) {
                    searchResults.innerHTML = '<li class="list-group-item">{{ __("messages.hero.no_results") }}</li>';
                } else {
                    hits.forEach(hit => {
                        const listItem = document.createElement('li');
                        listItem.className = 'list-group-item d-flex align-items-center';

                        // Establir un color de fons lleuger segons la fracció
                        const fraccioColor = fraccioColors[hit.fraccio] || '#ffffff';
                        const backgroundColor = document.body.classList.contains('dark')
                            ? '#333'
                            : 'white';

                        listItem.style.borderLeft = `4px solid ${fraccioColor}`;
                        listItem.style.backgroundColor = backgroundColor;
                        listItem.style.position = 'relative';

                        listItem.innerHTML = `
                            <div style="flex: 1; position: relative; z-index: 2; padding: 10px; border-radius: 5px; color: ${document.body.classList.contains('dark') ? '#f3f4f6' : 'black'};">
                                <strong>${hit.nom}</strong><br>
                                <span>${hit.ciutat}, ${hit.adreca}</span><br>
                                <small><strong>{{ __("messages.hero.fraction") }}</strong> ${hit.fraccio}</small>
                            </div>
                            <div style="margin-left: 10px; z-index: 1;">
                                <img src="https://maps.googleapis.com/maps/api/staticmap?center=${hit.latitud},${hit.longitud}&zoom=15&size=150x100&scale=2&markers=color:red%7C${hit.latitud},${hit.longitud}&key=${GOOGLE_MAPS_API_KEY}" alt="{{ __("messages.hero.static_map_alt") }}" style="width: 150px; height: 100px; border-radius: 5px;">
                            </div>
                        `;

                        searchResults.appendChild(listItem);
                    });
                }

                showResults();
            }).catch(err => {
                console.error('Error de cerca:', err);
                searchResults.innerHTML = '<li class="list-group-item text-danger">{{ __("messages.hero.search_error") }}</li>';
                showResults();
            });
        });

        // Botó per esborrar la cerca
        clearSearchBtn.addEventListener('click', function () {
            searchInput.value = '';
            hideResults();
            clearSearchBtn.style.display = 'none';
            searchInput.focus();
        });

        // Detectar clics fora del cercador
        document.addEventListener('click', function (event) {
            if (!event.target.closest('.hero-search-container')) {
                hideResults();
                if (searchInput.value.trim() === '') {
                    clearSearchBtn.style.display = 'none';
                }
            }
        });

        // Tecla Escape per amagar resultats
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                hideResults();
                if (searchInput.value.trim() === '') {
                    clearSearchBtn.style.display = 'none';
                }
            }
        });

        // Mostrar resultats en tornar al focus
        searchInput.addEventListener('focus', function () {
            const query = searchInput.value.trim();
            if (query) {
                clearSearchBtn.style.display = 'block';
                if (searchResults.childNodes.length > 0) {
                    showResults();
                } else {
                    // Dispara una nova cerca
                    const event = new Event('input');
                    searchInput.dispatchEvent(event);
                }
            }
        });
    });
</script>