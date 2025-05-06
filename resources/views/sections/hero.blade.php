<section id="inici" class="hero text-left">
    <div class="row justify-content-center align-items-center h-100 w-100">
        <!-- Text i Cerca -->
        <div class="col-lg-5 d-flex align-items-center justify-content-center">
            <div class="card mb-4 p-4 w-100">
                <div class="card-body text-left">
                    <h1 class="display-4 fw-bold text-left">Ajuda a Reciclar <br> Guanya Recompenses</h1>
                    <p class="lead text-left">Transforma el teu reciclatge en beneficis per a la comunitat.</p>

                    <div class="hero-search-container">
                        <input type="text" id="search-input" class="form-control"
                            placeholder="Cerca un punt de recollida...">
                        <button id="clear-hero-search" type="button">&times;</button>
                        <ul id="search-results" class="list-group" style="display: none;"></ul>
                    </div>

                    <div class="mt-4 d-flex justify-content-center gap-3">
                        <img src="" alt="Descarrega a l'Apple Store" style="max-width: 180px;" id="apple-store">
                        <img src="" alt="Descarrega a Google Play" style="max-width: 180px;" id="google-play">
                    </div>
                </div>
            </div>
        </div>

        <!-- Imatge del mòbil -->
        <div class="col-lg-5 d-flex align-items-center justify-content-center">
            <div class="card mb-4 p-3 d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/mobil.png') }}" class="img-fluid" alt="Hero Image"
                    style="max-width: 350px; height: auto;">
            </div>
        </div>
    </div>
</section>
<style>
    card-body {
        overflow: visible !important;
        position: relative;
    }

    .card {
        overflow: visible !important;
    }

    /* Estil específic per al contenidor de cerca */
    .hero-search-container {
        position: relative;
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
        z-index: 1050;
        /* Valor alt per assegurar que és per sobre d'altres elements */
    }

    #search-input {
        width: 100%;
        padding: 12px 40px 12px 15px;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    body.light #search-input {
        background-color: white;
        border: 1px solid #ced4da;
        color: #333;
    }

    body.dark #search-input {
        background-color: #333;
        border: 1px solid #444;
        color: #f3f4f6;
    }

    #clear-hero-search {
        position: absolute;
        right: 12px;
        width: 5%;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        font-size: 18px;
        cursor: pointer;
        display: none;
        z-index: 10;
    }

    body.light #clear-hero-search {
        color: #666;
    }

    body.dark #clear-hero-search {
        color: #aaa;
    }

    #search-results {
        position: absolute;
        width: 100%;
        max-height: 450px;
        overflow-y: auto;
        border-radius: 8px;
        margin-top: 5px;
        z-index: 1050;
        /* Mateix valor alt que el contenidor */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        /* Ombra més pronunciada per destacar */
        left: 0;
        right: 0;
    }

    /* Quan es mostra, assegura que tingui altura */
    #search-results.show {
        display: block !important;
        min-height: 100px;
        /* Força una alçada mínima */
    }

    body.light #search-results {
        background-color: white;
        border: 1px solid #dee2e6;
    }

    body.dark #search-results {
        background-color: #333;
        border: 1px solid #444;
    }

    #search-results .list-group-item {
        padding: 8px 12px;
        /* Reduir el padding per fer-ho més compacte */
        transition: background-color 0.2s;
        border-bottom-width: 1px;
        font-size: 0.9rem;
        /* Reduir la mida de la font */
    }

    /* Per fer que el text no ocupi tant espai */
    #search-results .list-group-item small {
        font-size: 0.8rem;
        color: #888;
    }

    body.dark #search-results .list-group-item small {
        color: #aaa;
    }

    body.light #search-results .list-group-item {
        border-color: #dee2e6;
    }

    body.dark #search-results .list-group-item {
        border-color: #444;
        background-color: #333;
    }

    #search-results .list-group-item:last-child {
        border-bottom: none;
    }

    body.light #search-results .list-group-item:hover {
        background-color: #f8f9fa;
    }

    body.dark #search-results .list-group-item:hover {
        background-color: #444;
    }

    /* Estil per a la barra de desplaçament */
    #search-results::-webkit-scrollbar {
        width: 8px;
    }

    #search-results::-webkit-scrollbar-track {
        background: transparent;
    }

    body.light #search-results::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 20px;
    }

    body.dark #search-results::-webkit-scrollbar-thumb {
        background-color: #555;
        border-radius: 20px;
    }

    #search-results::-webkit-scrollbar-thumb:hover {
        background: #888;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/algoliasearch@4"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const client = algoliasearch("4JU9PG98CF", "d37ffd358dca40447584fb2ffdc28e03");
        const index = client.initIndex('punts_de_recollida');

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

            index.search(query, {
                hitsPerPage: 10
            }).then(({ hits }) => {
                searchResults.innerHTML = '';

                if (hits.length === 0) {
                    searchResults.innerHTML = '<li class="list-group-item">No s\'han trobat punts de recollida.</li>';
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
                                <small><strong>Fracció:</strong> ${hit.fraccio}</small>
                            </div>
                            <div style="margin-left: 10px; z-index: 1;">
                                <img src="https://maps.googleapis.com/maps/api/staticmap?center=${hit.latitud},${hit.longitud}&zoom=15&size=150x100&scale=2&markers=color:red%7C${hit.latitud},${hit.longitud}&key=${GOOGLE_MAPS_API_KEY}" alt="Mapa estàtic" style="width: 150px; height: 100px; border-radius: 5px;">
                            </div>
                        `;

                        searchResults.appendChild(listItem);
                    });
                }

                showResults();
            }).catch(err => {
                console.error('Error de cerca:', err);
                searchResults.innerHTML = '<li class="list-group-item text-danger">Error en la cerca. Torna-ho a intentar.</li>';
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