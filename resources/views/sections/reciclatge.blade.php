<section id="reciclatge" class="mt-5">
    <div class="container">
        <h2 class="text-center mb-4">Cerca un producte o selecciona una fracció</h2>
        
        <!-- Cerca -->
        <div class="d-flex flex-column justify-content-center align-items-center mb-5">
            <input id="product-search" type="text" class="form-control" style="max-width: 400px;" placeholder="Cerca un producte...">
            <!-- Resultats de cerca -->
            <ul id="product-results" class="list-group mt-3" style="max-width: 400px;"></ul>
        </div>

        <!-- Fraccions -->
        <h3 class="text-center mb-4">Fraccions</h3>
        <div class="row row-16 justify-content-center">
            @php
                $categories = [
                    ['slug' => 'paper', 'nom' => 'Paper i Cartró', 'color' => '#2859bc'], // Blau
                    ['slug' => 'envasos', 'nom' => 'Envàs lleuger', 'color' => '#fddd19'], // Groc
                    ['slug' => 'organica', 'nom' => 'Fracció Orgànica', 'color' => '#9e6831'], // Marro
                    ['slug' => 'vidre', 'nom' => 'Envàs vidre', 'color' => '#3fd055'], // Verd
                    ['slug' => 'resta', 'nom' => 'Fracció Resta', 'color' => '#6d7878'], // Gris
                    ['slug' => 'deixalleria', 'nom' => 'Deixalleria / Punt verd', 'color' => '#d62c2d'], // Vermell
                    ['slug' => 'medicaments', 'nom' => 'Medicaments', 'color' => '#b7e53b'], // Verd clar
                    ['slug' => 'piles', 'nom' => 'Piles i Acumuladors', 'color' => '#fca614'], // Taronja
                    ['slug' => 'especial', 'nom' => 'Especial', 'color' => '#2f3939'], // Gris fosc
                    ['slug' => 'raee', 'nom' => 'Residus Aparells Elèctrics i Electrònics (RAEE)', 'color' => '#006f3f'] // Verd fosc
                ];
            @endphp

            <!-- Mostra les categories -->
            @foreach ($categories as $categoria)
                <div class="col-6 col-md-2 mb-4">
                    <div class="card text-center category-card"
                        style="height: 200px; background-size: cover; background-position: center; background-image: url('{{ asset("images/Reciclatge/{$categoria['slug']}/{$categoria['slug']}_portada.png") }}');"
                        data-color="{{ $categoria['color'] }}">
                        <!-- Superposició -->
                        <div class="overlay"></div>
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <div class="icon-background">
                                @if ($categoria['slug'] === 'raee')
                                    <svg class="category-icon" xmlns="http://www.w3.org/2000/svg" width="27.963" height="29.131" viewBox="0 0 27.963 29.131" fill="{{ $categoria['color'] }}">
                                        <path id="Union_4" data-name="Union 4" d="M7.076 28.565a.919.919 0 01.489-1.2l.247-.1A14.211 14.211 0 01.59 10.523 14.04 14.04 0 0114.251.447a.916.916 0 01-.017 1.832h-.258a12.314 12.314 0 00-10.7 18.138A12.137 12.137 0 008.57 25.6l-.142-.345a.92.92 0 01.49-1.2.9.9 0 011.185.494l.961 2.336v.006a.927.927 0 01.051.17 1.014 1.014 0 01.017.174.955.955 0 01-.016.175c-.005.028-.013.055-.021.083s-.013.034-.02.052-.005.023-.011.034l-.012.023a.861.861 0 01-.056.107c-.008.013-.014.026-.023.039a.906.906 0 01-.1.129l-.005.005a.889.889 0 01-.119.1c-.014.01-.029.018-.044.027a.9.9 0 01-.1.055c-.009 0-.017.01-.026.013l-2.316.973a.879.879 0 01-.347.071.906.906 0 01-.84-.556zm6.527-.627a2.813 2.813 0 01-.946-2.09l-.014-2.32a8.79 8.79 0 01-5.119-2.333A8.974 8.974 0 014.7 15.366a1.092 1.092 0 01.279-.824 1.066 1.066 0 01.788-.35h15.548a1.068 1.068 0 01.789.35 1.092 1.092 0 01.279.824 8.977 8.977 0 01-2.82 5.829 8.794 8.794 0 01-5.107 2.332l.013 2.309a.977.977 0 00.327.722.912.912 0 00.728.226 12.224 12.224 0 0010.112-8.672 12.366 12.366 0 00-6.243-14.544l.171.416a.919.919 0 01-.489 1.2.882.882 0 01-.347.071.907.907 0 01-.838-.565l-.99-2.413v-.012a1.05 1.05 0 01-.025-.073l-.008-.032-.014-.056c-.004-.019 0-.026-.006-.04s0-.032-.006-.049 0-.029 0-.043v-.136c0-.014 0-.035.007-.052l.005-.037c0-.022.011-.043.016-.065l.005-.022c.008-.027.017-.053.027-.079s.019-.042.03-.063l.01-.023.033-.056a.154.154 0 00.012-.021l.035-.048.018-.024.033-.039.026-.029.031-.029c.012-.011.023-.022.035-.031l.03-.023.041-.031c.013-.009.027-.016.041-.024l.035-.022c.013-.007.053-.027.08-.039l2.389-1a.9.9 0 011.185.5.92.92 0 01-.49 1.2l-.32.135a14.211 14.211 0 017.222 16.74A14.045 14.045 0 0115.755 28.6a2.635 2.635 0 01-.347.022 2.732 2.732 0 01-1.808-.684zm-.058-6.529a6.787 6.787 0 006.5-5.051h-13a6.789 6.789 0 006.499 5.051zm-5.162-9.84V7.413a1.072 1.072 0 112.143 0v4.156a1.072 1.072 0 11-2.143 0zm8.059-.062V7.413a1.072 1.072 0 112.143 0v4.094a1.072 1.072 0 11-2.143 0z" />
                                    </svg>
                                @else
                                    <svg class="category-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ $categoria['color'] }}">
                                        <path d="M17,4V2a2,2,0,0,0-2-2H9A2,2,0,0,0,7,2V4H2V6H4V21a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V6h2V4ZM11,17H9V11h2Zm4,0H13V11h2ZM15,4H9V2h6Z" />
                                    </svg>
                                @endif
                            </div>
                        </div>
                    </div>
                    <h5 class="text-center category-title mt-2">{{ $categoria['nom'] }}</h5>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Modal per mostrar informació del producte -->
<div id="product-modal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3 id="product-title"></h3>
        <p id="product-description"></p>
    </div>
</div>

<!-- Estils personalitzats -->
<style>
    .category-card {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    /* Superposició inicial */
    .category-card .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: transparent;
        /* Inicialment transparent */
        z-index: 1;
        /* Es col·loca per sobre de la imatge de fons */
        transition: all 0.3s ease;
    }

    /* Quan es passa el ratolí, el fons del card canvia al color de la categoria */
    .category-card:hover .overlay {
        background-color: var(--hover-color);
        /* Canvia al color de la categoria */
        opacity: 0.8;
        /* Difuminat */
    }

    /* L'icona es torna blanca */
    .category-card:hover .category-icon {
        fill: white;
        /* Canvia l'icona a blanc */
    }

    /* El fons de l'icona desapareix */
    .category-card:hover .icon-background {
        background-color: transparent;
        /* Elimina el fons del contenidor de l'icona */
    }

    /* El text canvia al color blanc */
    .category-card:hover .category-title {
        color: white;
    }

    .icon-background {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        /* Fons rodó */
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: white;
        /* Fons blanc inicial */
        z-index: 2;
        /* Es col·loca per sobre de la superposició */
        transition: all 0.3s ease;
    }

    .category-icon {
        width: 40px;
        height: 40px;
        transition: all 0.3s ease;
        z-index: 3;
        /* Es col·loca per sobre de la superposició */
    }

    .category-title {
        color: black;
        transition: all 0.3s ease;
    }

    body.dark-mode .category-title {
        color: white;
    }

    body.dark-mode .category-card:hover .category-title {
        color: white;
    }
</style>

<!-- Script per gestionar els colors -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cards = document.querySelectorAll('.category-card');
        cards.forEach(card => {
            const color = card.getAttribute('data-color');
            card.style.setProperty('--hover-color', color);
        });
    });
</script>
<!-- Inclou les llibreries d'Algolia i jQuery -->
<script src="https://cdn.jsdelivr.net/npm/algoliasearch@4"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        // Inicialitza el client d'Algolia
        const client = algoliasearch("4JU9PG98CF", "d37ffd358dca40447584fb2ffdc28e03");
        const index = client.initIndex('productes'); // Nom de l'índex a Algolia

        // Cerca en temps real
        $('#product-search').on('input', function () {
            const query = $(this).val();

            // Si el camp està buit, esborra els resultats
            if (!query) {
                $('#product-results').empty();
                return;
            }

            // Cerca a Algolia
            index.search(query, {
                hitsPerPage: 4
            }).then(({ hits }) => {
                // Esborra els resultats anteriors
                $('#product-results').empty();

                // Mostra els resultats
                hits.forEach(hit => {
                    $('#product-results').append(`
                        <li class="list-group-item d-flex align-items-center">
                            <img src="/${hit.imatge}" alt="${hit.nom}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                            <div>
                                <strong>${hit.nom}</strong><br>
                                <span style="color: gray;">${hit.categoria}</span>
                            </div>
                        </li>
                    `);
                });
            }).catch(err => {
                console.error(err);
            });
        });
    });
</script>