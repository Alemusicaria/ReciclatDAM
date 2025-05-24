<section id="reciclatge" class="mt-3">
    <div class="container" style="align-items: center;">
        <h2 class="text-center mb-3">{{ __('messages.recycling.title') }}</h2>

        <!-- Cerca -->
        <div class="d-flex flex-column justify-content-center align-items-center mb-3 position-relative">
            <div class="search-container">
                <input id="product-search" type="text" class="form-control"
                    placeholder="{{ __('messages.recycling.search_placeholder') }}">
                <button id="clear-search" type="button">&times;</button>
                <ul id="product-results" class="list-group"></ul>
            </div>
        </div>

        <!-- Fraccions -->
        <h3 class="text-center mb-3">{{ __('messages.recycling.fractions_title') }}</h3>
        <div class="row row-16 justify-content-center">
            @php
                $categories = [
                    ['slug' => __('messages.categories.slug.paper'), 'nom' => __('messages.categories.nom.paper'), 'color' => '#2859bc', 'foto' => 'Paper'], // Blau
                    ['slug' => __('messages.categories.slug.packaging'), 'nom' => __('messages.categories.nom.packaging'), 'color' => '#fddd19', 'foto' => 'Envasos'], // Groc
                    ['slug' => __('messages.categories.slug.organic'), 'nom' => __('messages.categories.nom.organic'), 'color' => '#9e6831', 'foto' => 'Organica'], // Marro
                    ['slug' => __('messages.categories.slug.glass'), 'nom' => __('messages.categories.nom.glass'), 'color' => '#3fd055', 'foto' => 'Vidre'], // Verd
                    ['slug' => __('messages.categories.slug.rest'), 'nom' => __('messages.categories.nom.rest'), 'color' => '#6d7878', 'foto' => 'Resta'], // Gris
                    ['slug' => __('messages.categories.slug.waste_collection'), 'nom' => __('messages.categories.nom.waste_collection'), 'color' => '#d62c2d', 'foto' => 'Deixalleria'], // Vermell, // Vermell
                    ['slug' => __('messages.categories.slug.medication'), 'nom' => __('messages.categories.nom.medication'), 'color' => '#b7e53b', 'foto' => 'Medicaments'], // Verd clar
                    ['slug' => __('messages.categories.slug.batteries'), 'nom' => __('messages.categories.nom.batteries'), 'color' => '#fca614', 'foto' => 'Piles'], // Taronja
                    ['slug' => __('messages.categories.slug.special'), 'nom' => __('messages.categories.nom.special'), 'color' => '#2f3939', 'foto' => 'Especial'], // Gris fosc
                    ['slug' => __('messages.categories.slug.raee'), 'nom' => __('messages.categories.nom.raee'), 'color' => '#006f3f', 'tooltip' => __('messages.categories.nom.raee_tooltip'), 'foto' => 'RAEE'] // Verd fosc
                ];

                $recyclingInfo = [
                    'Paper' => [
                        'descripcion' => __('messages.fractions.paper.description'),
                        'instruccions' => __('messages.fractions.paper.instructions'),
                        'beneficis' => __('messages.fractions.paper.benefits'),
                        'consells' => __('messages.fractions.paper.tips')
                    ],
                    'Envasos' => [
                        'descripcion' => __('messages.fractions.packaging.description'),
                        'instruccions' => __('messages.fractions.packaging.instructions'),
                        'beneficis' => __('messages.fractions.packaging.benefits'),
                        'consells' => __('messages.fractions.packaging.tips')
                    ],
                    'Organica' => [
                        'descripcion' => __('messages.fractions.organic.description'),
                        'instruccions' => __('messages.fractions.organic.instructions'),
                        'beneficis' => __('messages.fractions.organic.benefits'),
                        'consells' => __('messages.fractions.organic.tips')
                    ],
                    'Vidre' => [
                        'descripcion' => __('messages.fractions.glass.description'),
                        'instruccions' => __('messages.fractions.glass.instructions'),
                        'beneficis' => __('messages.fractions.glass.benefits'),
                        'consells' => __('messages.fractions.glass.tips')
                    ],
                    'Resta' => [
                        'descripcion' => __('messages.fractions.rest.description'),
                        'instruccions' => __('messages.fractions.rest.instructions'),
                        'beneficis' => __('messages.fractions.rest.benefits'),
                        'consells' => __('messages.fractions.rest.tips')
                    ],
                    'Deixalleria' => [
                        'descripcion' => __('messages.fractions.waste_collection.description'),
                        'instruccions' => __('messages.fractions.waste_collection.instructions'),
                        'beneficis' => __('messages.fractions.waste_collection.benefits'),
                        'consells' => __('messages.fractions.waste_collection.tips')
                    ],
                    'Medicaments' => [
                        'descripcion' => __('messages.fractions.medicines.description'),
                        'instruccions' => __('messages.fractions.medicines.instructions'),
                        'beneficis' => __('messages.fractions.medicines.benefits'),
                        'consells' => __('messages.fractions.medicines.tips')
                    ],
                    'Piles' => [
                        'descripcion' => __('messages.fractions.batteries.description'),
                        'instruccions' => __('messages.fractions.batteries.instructions'),
                        'beneficis' => __('messages.fractions.batteries.benefits'),
                        'consells' => __('messages.fractions.batteries.tips')
                    ],
                    'Especial' => [
                        'descripcion' => __('messages.fractions.special.description'),
                        'instruccions' => __('messages.fractions.special.instructions'),
                        'beneficis' => __('messages.fractions.special.benefits'),
                        'consells' => __('messages.fractions.special.tips')
                    ],
                    'RAEE' => [
                        'descripcion' => __('messages.fractions.raee.description'),
                        'instruccions' => __('messages.fractions.raee.instructions'),
                        'beneficis' => __('messages.fractions.raee.benefits'),
                        'consells' => __('messages.fractions.raee.tips')
                    ]
                ];
            @endphp

            <!-- Mostra les categories -->
            @foreach ($categories as $categoria)
                <div class="col-6 col-md-2">
                    <div class="card text-center category-card"
                        style="height: 200px; background-size: cover; background-position: center; background-image: url('{{ asset("images/Reciclatge/{$categoria['foto']}/{$categoria['foto']}_portada.png") }}');"
                        data-color="{{ $categoria['color'] }}" data-category="{{ $categoria['foto'] }}">
                        <!-- Superposició -->
                        <div class="overlay"></div>
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <div class="icon-background">
                                @if ($categoria['slug'] === 'RAEE')
                                    <svg class="category-icon" xmlns="http://www.w3.org/2000/svg" width="27.963" height="29.131"
                                        viewBox="0 0 27.963 29.131" fill="{{ $categoria['color'] }}">
                                        <path id="Union_4" data-name="Union 4"
                                            d="M7.076 28.565a.919.919 0 01.489-1.2l.247-.1A14.211 14.211 0 01.59 10.523 14.04 14.04 0 0114.251.447a.916.916 0 01-.017 1.832h-.258a12.314 12.314 0 00-10.7 18.138A12.137 12.137 0 008.57 25.6l-.142-.345a.92.92 0 01.49-1.2.9.9 0 011.185.494l.961 2.336v.006a.927.927 0 01.051.17 1.014 1.014 0 01.017.174.955.955 0 01-.016.175c-.005.028-.013.055-.021.083s-.013.034-.02.052-.005.023-.011.034l-.012.023a.861.861 0 01-.056.107c-.008.013-.014.026-.023.039a.906.906 0 01-.1.129l-.005.005a.889.889 0 01-.119.1c-.014.01-.029.018-.044.027a.9.9 0 01-.1.055c-.009 0-.017.01-.026.013l-2.316.973a.879.879 0 01-.347.071.906.906 0 01-.84-.556zm6.527-.627a2.813 2.813 0 01-.946-2.09l-.014-2.32a8.79 8.79 0 01-5.119-2.333A8.974 8.974 0 014.7 15.366a1.092 1.092 0 01.279-.824 1.066 1.066 0 01.788-.35h15.548a1.068 1.068 0 01.789.35 1.092 1.092 0 01.279.824 8.977 8.977 0 01-2.82 5.829 8.794 8.794 0 01-5.107 2.332l.013 2.309a.977.977 0 00.327.722.912.912 0 00.728.226 12.224 12.224 0 0010.112-8.672 12.366 12.366 0 00-6.243-14.544l.171.416a.919.919 0 01-.489 1.2.882.882 0 01-.347.071.907.907 0 01-.838-.565l-.99-2.413v-.012a1.05 1.05 0 01-.025-.073l-.008-.032-.014-.056c-.004-.019 0-.026-.006-.04s0-.032-.006-.049 0-.029 0-.043v-.136c0-.014 0-.035.007-.052l.005-.037c0-.022.011-.043.016-.065l.005-.022c.008-.027.017-.053.027-.079s.019-.042.03-.063l.01-.023.033-.056a.154.154 0 00.012-.021l.035-.048.018-.024.033-.039.026-.029.031-.029c.012-.011.023-.022.035-.031l.03-.023.041-.031c.013-.009.027-.016.041-.024l.035-.022c.013-.007.053-.027.08-.039l2.389-1a.9.9 0 011.185.5.92.92 0 01-.49 1.2l-.32.135a14.211 14.211 0 017.222 16.74A14.045 14.045 0 0115.755 28.6a2.635 2.635 0 01-.347.022 2.732 2.732 0 01-1.808-.684zm-.058-6.529a6.787 6.787 0 006.5-5.051h-13a6.789 6.789 0 006.499 5.051zm-5.162-9.84V7.413a1.072 1.072 0 112.143 0v4.156a1.072 1.072 0 11-2.143 0zm8.059-.062V7.413a1.072 1.072 0 112.143 0v4.094a1.072 1.072 0 11-2.143 0z" />
                                    </svg>
                                @else
                                    <svg class="category-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="{{ $categoria['color'] }}">
                                        <path
                                            d="M17,4V2a2,2,0,0,0-2-2H9A2,2,0,0,0,7,2V4H2V6H4V21a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V6h2V4ZM11,17H9V11h2Zm4,0H13V11h2ZM15,4H9V2h6Z" />
                                    </svg>
                                @endif
                            </div>
                        </div>
                    </div>
                    <h5 class="text-center category-title mt-2">
                        {{ $categoria['nom'] }}
                        @if ($categoria['slug'] === 'RAEE')
                            <span class="info-icon" data-bs-toggle="tooltip"
                                title="{{ __('messages.fractions.raee.name') }}">i</span>
                        @endif
                    </h5>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Modal per mostrar productes de la fracció -->
    <div id="fraction-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3 id="fraction-title"></h3>
            <div id="fraction-list" class="mt-3"></div>
        </div>
    </div>

    <!-- Modal per mostrar detalls d'un producte -->
    <div id="product-detail-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3 id="product-detail-title"></h3>
            <div id="product-detail-content" class="mt-3"></div>
        </div>
    </div>

</section>

<!-- Modal per mostrar productes de la fracció -->
<div id="product-modal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3 id="product-title"></h3>
        <div id="product-list" class="mt-3"></div>
    </div>
</div>

<section id="mapa" class="mapa-section mt-5">
    <div class="container">
        <h2 class="text-center mb-4">{{ __('messages.recycling.map_title') }}</h2>
        <div class="d-flex justify-content-center mb-3">
            @foreach ($categories as $categoria)
                @if ($categoria['foto'] === 'Organica')
                    <button class="btn btn-primary mx-2 filter-button" data-fraccio="{{ $categoria['foto'] }}"
                        style="background-color: {{ $categoria['color'] }};">
                        {{ $categoria['slug'] }}
                    </button>
                @else
                    <button class="btn btn-primary mx-2 filter-button" data-fraccio="{{ $categoria['foto'] }}"
                        style="background-color: {{ $categoria['color'] }};">
                        {{ $categoria['slug'] }}
                    </button>
                @endif
            @endforeach
            <button
                class="btn btn-outline-secondary mx-2 clear-filter-button">{{ __('messages.recycling.clear_filter') }}</button>
        </div>
        <div id="map" style="height: 500px; width: 100%;"></div>
    </div>
</section>

<!-- Add this hidden element to store the recycling info JSON data -->
<script type="application/json" id="recycling-info-data">
    @json($recyclingInfo)
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize category cards
        const cards = document.querySelectorAll('.category-card');
        cards.forEach(card => {
            const color = card.getAttribute('data-color');
            card.style.setProperty('--hover-color', color);
        });

        // Método 1: Usando la API de Bootstrap 5
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        const productIndex = window.productIndex; // Usa la variable global
        const puntsIndex = window.puntsIndex; // Usa la variable global

        // Get recycling info from PHP
        const recyclingInfo = JSON.parse(document.getElementById('recycling-info-data').textContent);

        // Search elements
        const searchInput = $('#product-search');
        const clearButton = $('#clear-search');
        const productResults = $('#product-results');
        let originalProductListContent = '';

        // MAP FUNCTIONALITY
        // Initialize map centered on Catalonia
        const map = L.map('map');
        const catalunyaBounds = [
            [40.5, 0.15], // Southwest (approximately)
            [42.85, 3.35] // Northeast (approximately)
        ];

        // Adjust the map to show all of Catalonia
        map.fitBounds(catalunyaBounds);

        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Variable to store markers
        let markers = [];
        let noResultsControl = null; // Control for visual message

        // Function to normalize fractions (remove accents and convert to lowercase)
        function normalizeFraccio(fraccio) {
            return fraccio.normalize('NFD').replace(/[\u0300-\u036f]/g, "").toLowerCase();
        }

        // Function to load collection points on the map
        function loadPuntsDeRecollida(fraccio = '') {
            // Delete previous markers
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];

            // If there's already a "Not found" message, delete it
            if (noResultsControl) {
                map.removeControl(noResultsControl);
                noResultsControl = null;
            }

            puntsIndex.search('', {
                hitsPerPage: 100
            }).then(({ hits }) => {

                if (fraccio) {
                    const fraccioNormalitzada = normalizeFraccio(fraccio);
                    hits = hits.filter(punt => normalizeFraccio(punt.fraccio) === fraccioNormalitzada);
                }

                if (hits.length === 0) {
                    console.warn('No s\'han trobat punts de recollida per a la fracció:', fraccio);

                    // Add visual message
                    noResultsControl = L.control({ position: 'topright' });
                    noResultsControl.onAdd = function (map) {
                        let div = L.DomUtil.create('div', 'alert alert-warning');
                        div.innerHTML = `{{ __('messages.recycling.no_collection_points') }}`;
                        return div;
                    };
                    noResultsControl.addTo(map);
                } else {
                    hits.forEach(punt => {
                        const marker = L.marker([punt.latitud, punt.longitud]).addTo(map);
                        marker.bindPopup(`
                        <strong>${punt.nom}</strong><br>
                        <strong>{{ __('messages.hero.city') }}:</strong> ${punt.ciutat}<br>
                        <strong>{{ __('messages.hero.address') }}:</strong> ${punt.adreca}<br>
                        <strong>{{ __('messages.hero.fraction') }}:</strong> ${punt.fraccio}<br>
                        <strong>{{ __('messages.recycling.available') }}:</strong> ${punt.disponible ? '{{ __("messages.recycling.yes") }}' : '{{ __("messages.recycling.no") }}'}
                    `);
                        markers.push(marker);
                    });
                }
            }).catch(err => {
                console.error('Error loading collection points:', err);
            });
        }

        // Initially load all collection points
        loadPuntsDeRecollida();

        // Handle clicks on filter buttons
        document.querySelectorAll('.filter-button').forEach(button => {
            button.addEventListener('click', function () {
                const fraccio = this.getAttribute('data-fraccio');
                loadPuntsDeRecollida(fraccio);
            });
        });

        // Handle click on clear filter button
        document.querySelector('.clear-filter-button').addEventListener('click', function () {
            loadPuntsDeRecollida();
        });

        // SEARCH FUNCTIONALITY
        // Show or hide the cross button and results list
        searchInput.on('input', function () {
            if ($(this).val().trim() !== '') {
                clearButton.show();
                showResults();
            } else {
                clearButton.hide();
                hideResults();
            }
        });

        // Clear the search field text
        clearButton.on('click', function () {
            searchInput.val('');
            clearButton.hide();
            hideResults();
        });

        // Real-time search
        searchInput.on('input', function () {
            const query = $(this).val().trim();

            // If the field is empty, clear the results
            if (!query) {
                productResults.empty();
                hideResults();
                clearButton.hide();
                return;
            }

            clearButton.show();

            // Search Algolia
            productIndex.search(query, {
                hitsPerPage: 10
            }).then(({ hits }) => {
                // Clear previous results
                productResults.empty();

                if (hits.length === 0) {
                    // If there are no results, show a message
                    productResults.append(`<li class="list-group-item">{{ __('messages.products.no_results') }}</li>`);
                } else {
                    // Show results
                    hits.forEach(hit => {
                        productResults.append(`
                            <li class="list-group-item d-flex align-items-center product-result" 
                                data-product-id="${hit.id}" 
                                data-product-name="${hit.nom}" 
                                data-product-category="${hit.categoria}" 
                                data-product-image="${hit.imatge}">
                                <div class="flex-shrink-0 me-3">
                                    <img src="/${hit.imatge}" alt="${hit.nom}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                </div>
                                <div class="flex-grow-1 ms-3 text-start">
                                    <strong>${hit.nom}</strong><br>
                                    <span>${hit.categoria}</span>
                                </div>
                            </li>
                        `);
                    });
                }

                showResults();
            }).catch(err => {
                console.error("Error in search:", err);
                productResults.empty();
                productResults.append(`<li class="list-group-item text-danger">{{ __('messages.products.error_search') }}</li>`);
                showResults();
            });
        });

        // Show search results with a smooth animation
        function showResults() {
            productResults.slideDown(200);
        }

        // Hide search results with a smooth animation
        function hideResults() {
            productResults.slideUp(200);
        }

        // Add keyboard navigation for search results
        searchInput.on('keydown', function (e) {
            if (!productResults.is(':visible')) return;

            const items = productResults.find('.list-group-item');
            let selected = productResults.find('.selected');

            // Down arrow
            if (e.keyCode === 40) {
                e.preventDefault();
                if (selected.length === 0) {
                    items.first().addClass('selected');
                } else {
                    selected.removeClass('selected');
                    selected.next().addClass('selected');
                }
            }

            // Up arrow
            else if (e.keyCode === 38) {
                e.preventDefault();
                if (selected.length === 0) {
                    items.last().addClass('selected');
                } else {
                    selected.removeClass('selected');
                    selected.prev().addClass('selected');
                }
            }

            // Enter key
            else if (e.keyCode === 13) {
                e.preventDefault();
                if (selected.length > 0) {
                    selected.click();
                }
            }
        });


        // CATEGORY MODAL FUNCTIONALITY
        // Open modal with products for a category
        $('.category-card').on('click', function () {
            const categoria = $(this).data('category');
            const color = $(this).data('color');
            const info = recyclingInfo[categoria];

            // Query products for the category
            productIndex.search('', {
                hitsPerPage: 1000
            }).then(({ hits }) => {
                const categoriaNormalitzada = normalizeFraccio(categoria);
                const matchingProducts = hits.filter(product =>
                    normalizeFraccio(product.categoria) === categoriaNormalitzada
                );

                showProducts(matchingProducts, categoria, color, info);
            }).catch(err => {
                console.error("Error searching for products:", err);
                $('#product-title').text(`{{ __('messages.recycling.error_search') }} ${categoria}`);
                $('#product-list').html(`<p>{{ __('messages.recycling.error_details') }}: ${err.message}</p>`);
                $('#product-modal').fadeIn();
            });
        });

        // Function to show products
        function showProducts(products, categoria, color, info) {
            $('#product-title').text(`{{ __('messages.recycling.products_title') }}`);
            const productList = $('#product-list');
            productList.empty();

            // Add banner with category information
            productList.append(`
            <div class="category-banner" style="background-color: ${color}">
                <svg class="category-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white">
                    <path d="M17,4V2a2,2,0,0,0-2-2H9A2,2,0,0,0,7,2V4H2V6H4V21a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V6h2V4ZM11,17H9V11h2Zm4,0H13V11h2ZM15,4H9V2h6Z" />
                </svg>
                <h4 class="mb-0">${categoria}</h4>
            </div>
            
            <div class="recycling-tips mb-4">
                <h5>{{ __('messages.recycling.recycling_info') }}</h5>
                <p><strong>{{ __('messages.recycling.what_is') }}</strong> ${info.descripcion}</p>
                <p><strong>{{ __('messages.recycling.how_to') }}</strong> ${info.instruccions}</p>
                <p><strong>{{ __('messages.recycling.benefits') }}</strong> ${info.beneficis}</p>
                <p><strong>{{ __('messages.recycling.tips') }}</strong> ${info.consells}</p>
            </div>
            
            <h5>{{ __('messages.recycling.products_title') }}</h5>
        `);

            if (products.length === 0) {
                productList.append(`<p>{{ __('messages.recycling.no_products') }}</p>`);
            } else {
                // Create a row for the cards
                let row = $('<div class="row g-3" id="product-row"></div>');
                productList.append(row);

                products.forEach(product => {
                    row.append(`
                    <div class="col-6 col-md-3 mb-3 product-row-item">
                        <div class="product-card" 
                            data-product-id="${product.id}" 
                            data-product-name="${product.nom}" 
                            data-product-category="${product.categoria}" 
                            data-product-image="${product.imatge}">
                            <img src="/${product.imatge}" alt="${product.nom}" class="card-img-top">
                            <div class="product-card-body">
                                <h6>${product.nom}</h6>
                                <p class="text-muted">${product.categoria}</p>
                            </div>
                        </div>
                    </div>
                `);
                });
            }

            $('#product-modal').fadeIn();
        }

        // Function to show a modal with product information and map
        function showProductModal(productName, productCategory, productImage) {
            // Get recycling text for the fraction
            const info = recyclingInfo[productCategory] || {};
            const recyclingText = info.instruccions || "{{ __('messages.recycling.no_info') }}";

            // Update the modal title with the product name
            $('#product-title').text(productName).css('text-align', 'center');

            // Show detailed product information
            $('#product-list').html(`
                <div class="product-info-container">
                    <div class="product-image">
                        <img src="${productImage}" alt="${productName}" class="product-img">
                    </div>
                    <div class="product-details">
                        <h4>${productName}</h4>
                        <p><strong>{{ __('messages.hero.fraction') }}</strong> ${productCategory}</p>
                        <p><strong>{{ __('messages.recycling.how_to') }}</strong> ${recyclingText}</p>
                    </div>
                </div>
                <div id="product-map"></div>
                <button class="btn btn-primary mt-3 back-button">{{ __('messages.recycling.close') }}</button>
            `);

            // First show the modal
            $('#product-modal').fadeIn(function () {
                // Initialize map centered on Catalonia AFTER the modal is visible
                const productMap = L.map('product-map');

                // Define Catalunya bounds
                const catalunyaBounds = [
                    [40.5, 0.15], // Southwest (approximately)
                    [42.85, 3.35]  // Northeast (approximately)
                ];

                // Adjust the map to show all of Catalonia
                productMap.fitBounds(catalunyaBounds);

                // Set maximum zoom level to ensure we don't zoom in too much
                productMap.setMaxZoom(9);

                // Add OpenStreetMap tile layer
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(productMap);

                // Force map redraw immediately after initialization
                productMap.invalidateSize();

                // Variable to store markers and control
                let markersCategory = [];
                let productNoResultsControl = null;

                // Search for collection points in Algolia filtering by fraction
                puntsIndex.search('', {
                    hitsPerPage: 100
                }).then(({ hits: puntsDeRecollida }) => {
                    if (productCategory) {
                        const productCategoryNormalitzada = normalizeFraccio(productCategory);
                        puntsDeRecollida = puntsDeRecollida.filter(punt =>
                            normalizeFraccio(punt.fraccio) === productCategoryNormalitzada
                        );
                    }

                    if (puntsDeRecollida.length === 0) {
                        console.warn('No s\'han trobat punts de recollida per a la fracció:', productCategory);

                        // Add visual message
                        productNoResultsControl = L.control({ position: 'topright' });
                        productNoResultsControl.onAdd = function (map) {
                            let div = L.DomUtil.create('div', 'alert alert-warning');
                            div.innerHTML = `{{ __('messages.recycling.no_collection_points') }} <strong>${productCategory}</strong>`;
                            return div;
                        };
                        productNoResultsControl.addTo(productMap);
                    } else {
                        puntsDeRecollida.forEach(punt => {
                            const marker = L.marker([punt.latitud, punt.longitud]).addTo(productMap);
                            marker.bindPopup(`
                                        <strong>${punt.nom}</strong><br>
                                        ${punt.ciutat}, ${punt.adreca}
                                    `);
                            markersCategory.push(marker);
                        });

                        // ELIMINA AQUESTA SECCIÓ o comenta-la per mantenir el zoom original
                        // if (markersCategory.length > 0) {
                        //     const markerGroup = L.featureGroup(markersCategory);
                        //     productMap.fitBounds(markerGroup.getBounds().pad(0.2));
                        // }
                    }
                }).catch(err => {
                    console.error('Error loading collection points:', err);
                });
            });
        }

        // Open modal when clicking on a search result
        $(document).on('click', '#product-results .list-group-item', function () {
            const productName = $(this).data('product-name');
            const productCategory = $(this).data('product-category');
            const productImage = $(this).data('product-image');

            showProductModal(productName, productCategory, `/${productImage}`);

            // Clear search after selection
            searchInput.val('');
            clearButton.hide();
            hideResults();
        });

        // Open modal when clicking on a product in the category product list
        $(document).on('click', '#product-row .product-card', function () {
            const productName = $(this).data('product-name');
            const productCategory = $(this).data('product-category');
            const productImage = $(this).data('product-image');

            showProductModal(productName, productCategory, `/${productImage}`);
        });

        // Handle back button in product detail view
        $(document).on('click', '.back-button', function () {
            // Go back to the previous view in the modal
            const productId = $(this).data('product-id');
            if (productId) {
                // If we have a product ID, go back to that product's category
                const productCategory = $(this).data('product-category');

                // Trigger a click on the category card to show all products in that category
                $(`.category-card[data-category="${productCategory}"]`).click();
            } else {
                // Otherwise just close the modal
                $('#product-modal').fadeOut();
            }
        });

        // Close modal
        $('.close').on('click', function () {
            originalProductListContent = '';
            $('#product-modal').fadeOut();
        });

        // Also close the modal if clicking outside the content
        $('#product-modal').on('click', function (e) {
            if (e.target === this) {
                originalProductListContent = '';
                $(this).fadeOut();
            }
        });

        // Afegir aquest codi després de la inicialització del cercador
        $(document).on('click', function (event) {
            // Comprova si el clic va ser fora del contenidor de cerca i de la llista de resultats
            if (!$(event.target).closest('.search-container').length) {
                hideResults();
                clearButton.hide();
            }
        });

        // També pots afegir un event per quan l'usuari prem la tecla Escape
        $(document).on('keydown', function (e) {
            if (e.key === 'Escape') {
                hideResults();
                clearButton.hide();
            }
        });

        // Afegir event blur per detectar quan l'usuari surt del camp de cerca
        // Però necessitem un timeout per permetre clics als resultats
        searchInput.on('blur', function () {
            setTimeout(function () {
                if (!$('.product-result:hover').length) {
                    hideResults();
                    clearButton.hide();
                }
            }, 200);
        });

        // Show results again when focusing back on the search input
        searchInput.on('focus', function () {
            const query = $(this).val().trim();
            if (query) {
                // If there's text in the input, show the clear button and results
                clearButton.show();

                // Only show results if we have any
                if (productResults.children().length > 0) {
                    showResults();
                } else {
                    // If no results, trigger a search
                    $(this).trigger('input');
                }
            }
        });
    });
</script>