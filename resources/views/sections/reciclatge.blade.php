<section id="reciclatge" class="mt-3">
    <div class="container" style="align-items: center;">
        <h2 class="text-center mb-3">Cerca un producte o selecciona una fracció</h2>

        <!-- Cerca -->
        <div class="d-flex flex-column justify-content-center align-items-center mb-3 position-relative">
            <div class="search-container">
                <input id="product-search" type="text" class="form-control" placeholder="Cerca un producte...">
                <button id="clear-search" type="button">&times;</button>
                <ul id="product-results" class="list-group"></ul>
            </div>
        </div>

        <!-- Fraccions -->
        <h3 class="text-center mb-3">Fraccions</h3>
        <div class="row row-16 justify-content-center">
            @php
                $categories = [
                    ['slug' => 'Paper', 'nom' => 'Paper i Cartró', 'color' => '#2859bc'], // Blau
                    ['slug' => 'Envasos', 'nom' => 'Envàs lleuger', 'color' => '#fddd19'], // Groc
                    ['slug' => 'Organica', 'nom' => 'Fracció Orgànica', 'color' => '#9e6831'], // Marro
                    ['slug' => 'Vidre', 'nom' => 'Envàs vidre', 'color' => '#3fd055'], // Verd
                    ['slug' => 'Resta', 'nom' => 'Fracció Resta', 'color' => '#6d7878'], // Gris
                    ['slug' => 'Deixalleria', 'nom' => 'Deixalleria / Punt verd', 'color' => '#d62c2d'], // Vermell
                    ['slug' => 'Medicaments', 'nom' => 'Medicaments', 'color' => '#b7e53b'], // Verd clar
                    ['slug' => 'Piles', 'nom' => 'Piles i Acumuladors', 'color' => '#fca614'], // Taronja
                    ['slug' => 'Especial', 'nom' => 'Especial', 'color' => '#2f3939'], // Gris fosc
                    ['slug' => 'RAEE', 'nom' => 'RAEE', 'color' => '#006f3f', 'tooltip' => 'Residus Aparells Elèctrics i Electrònics'] // Verd fosc
                ];

                $recyclingInfo = [
                    'Paper' => [
                        'descripcion' => "El paper i el cartró són materials biodegradables que provenen d'una font renovable i es poden reciclar fins a 6 vegades.",
                        'instruccions' => "Plega les caixes de cartró per reduir el seu volum. Assegura't que el paper estigui net i sec. No barregis paper brut amb oli, menjar o altres líquids.",
                        'beneficis' => "Reciclar una tona de paper salva 17 arbres i estalvia fins a 26.000 litres d'aigua.",
                        'consells' => "Els papers enfilmats, parafinats o plastificats no es poden reciclar al contenidor blau. Paper de cuina i tovallons usats van al contenidor d'orgànica."
                    ],
                    'Envasos' => [
                        'descripcion' => "Els envasos lleugers inclouen ampolles de plàstic, llaunes, brics, safates de porexpan i embolcalls de plàstic.",
                        'instruccions' => "Buida completament els envasos i aixafa'ls si és possible per reduir el volum. No és necessari rentar-los, però sí eliminar restes de menjar.",
                        'beneficis' => "Reciclar plàstic estalvia un 80% de l'energia necessària per fabricar nous productes i redueix l'abocament al medi ambient.",
                        'consells' => "Reutilitza les bosses de plàstic o utilitza bosses de tela. Recorda que els utensilis de plàstic d'un sol ús no són envasos i van al contenidor gris."
                    ],
                    'Organica' => [

                        'descripcion' => "La fracció orgànica inclou restes de menjar, petits residus vegetals i altres materials compostables.",
                        'instruccions' => "Utilitza bosses compostables i assegura't que no hi hagi materials impropis com plàstics o metalls. Evita tirar líquids.",
                        'beneficis' => "Els residus orgànics correctament separats es converteixen en compost d'alta qualitat per a l'agricultura i jardineria.",
                        'consells' => "Els taps de suro, escuradents de fusta i tovallons de paper usats també van al contenidor marró. Evita tirar ossos grans o clofolles de marisc."
                    ],
                    'Vidre' => [
                        'descripcion' => "El vidre és 100% reciclable i pot ser reutilitzat infinites vegades sense perdre qualitat.",
                        'instruccions' => "Buida completament els envasos i treu-ne els taps i tapes. No cal rentar-los. No barregis vidre pla, ceràmica o vaixelles.",
                        'beneficis' => "Reciclar vidre estalvia un 30% d'energia comparada amb fabricar vidre nou i redueix les emissions de CO₂.",
                        'consells' => "Els miralls, finestres, gots, plats de vidre o ceràmica no van al contenidor verd, sinó a la deixalleria o al gris."
                    ],
                    'Resta' => [
                        'descripcion' => "La fracció resta inclou tots aquells residus que no es poden reciclar o que no tenen un sistema de recollida selectiva específic.",
                        'instruccions' => "Utilitza el contenidor gris només quan el residu no es pugui llençar a cap altre contenidor específic.",
                        'beneficis' => "Separar correctament redueix la quantitat de residus que acaben en abocadors, allargant la seva vida útil.",
                        'consells' => "Abans de llençar un objecte al contenidor gris, pregunta't si podria reciclar-se en algun dels altres contenidors o a la deixalleria."
                    ],
                    'Deixalleria' => [
                        'descripcion' => "Les deixalleries o punts verds són instal·lacions on es recullen de forma selectiva aquells residus que no tenen un contenidor específic al carrer.",
                        'instruccions' => "Porta els residus separats per tipus i segueix les indicacions del personal. Consulta els horaris i normes de la deixalleria del teu municipi.",
                        'beneficis' => "L'ús de deixalleries permet recuperar materials valuosos i evita que substàncies perilloses contaminin el medi ambient.",
                        'consells' => "Molts municipis ofereixen deixalleries mòbils que visiten regularment els barris. Alguns residus especials com pintures o dissolvents mai s'han de llençar pels desguassos."
                    ],
                    'Medicaments' => [
                        'descripcion' => "Els medicaments caducats o en desús s'han de gestionar correctament per evitar riscos per a la salut i el medi ambient.",
                        'instruccions' => "Porta els medicaments caducats, restes de medicaments i els seus envasos als punts SIGRE de les farmàcies. No els llencis mai a les escombraries o al vàter.",
                        'beneficis' => "La correcta gestió evita la contaminació del sòl i l'aigua, prevenint riscos per a la salut pública i els ecosistemes.",
                        'consells' => "Revisa periòdicament la farmaciola i elimina els medicaments caducats. No acumulis medicaments innecessàriament."
                    ],
                    'Piles' => [
                        'descripcion' => "Les piles i acumuladors contenen metalls pesants i substàncies tòxiques que poden ser molt contaminants si no es gestionen adequadament.",
                        'instruccions' => "Diposita-les als contenidors específics que trobaràs a botigues d'electrònica, grans superfícies o punts verds.",
                        'beneficis' => "Reciclar piles permet recuperar metalls valuosos com zinc, manganès i ferro, evitant la contaminació del sòl i l'aigua.",
                        'consells' => "Considera utilitzar piles recarregables, que poden substituir fins a 1.000 piles d'un sol ús al llarg de la seva vida útil."
                    ],
                    'Especial' => [
                        'descripcion' => "Els residus especials són aquells que per les seves característiques poden ser perillosos per al medi ambient o requereixen un tractament específic.",
                        'instruccions' => "Mai barregis residus especials amb altres tipus de residus. Porta'ls a la deixalleria en el seu envàs original si és possible.",
                        'beneficis' => "La gestió adequada d'aquests residus prevé greus problemes de contaminació i protegeix la salut pública.",
                        'consells' => "Olis de cuina, pintures, dissolvents, termòmetres, radiografies o bateries pertanyen a aquesta categoria. Consulta amb el teu ajuntament quins altres residus es consideren especials."
                    ],
                    'RAEE' => [
                        'descripcion' => "Els Residus d'Aparells Elèctrics i Electrònics (RAEE) contenen materials valuosos i també components potencialment tòxics.",
                        'instruccions' => "Porta'ls a la deixalleria, o si compres un aparell nou, la botiga està obligada a recollir el vell. No els desmuntis per la teva compte.",
                        'beneficis' => "El 90% dels components dels RAEE es poden recuperar i reciclar, incloent metalls preciosos com or, plata, coure i terres rares.",
                        'consells' => "Intenta reparar els aparells abans de rebutjar-los. Si funcionen però ja no els necessites, considera donar-los a organitzacions socials."
                    ]
                ];
            @endphp

            <!-- Mostra les categories -->
            @foreach ($categories as $categoria)
                <div class="col-6 col-md-2">
                    <div class="card text-center category-card"
                        style="height: 200px; background-size: cover; background-position: center; background-image: url('{{ asset("images/Reciclatge/{$categoria['slug']}/{$categoria['slug']}_portada.png") }}');"
                        data-color="{{ $categoria['color'] }}" data-category="{{ $categoria['slug'] }}">
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
                        @if ($categoria['slug'] === 'raee')
                            <span class="info-icon" data-bs-toggle="tooltip" title="{{ $categoria['tooltip'] }}">i</span>
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

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

<section id="mapa" class="mapa-section mt-5">
    <div class="container">
        <h2 class="text-center mb-4">Mapa Interactiu de Punts de Recollida</h2>
        <div class="d-flex justify-content-center mb-3">
            @foreach ($categories as $categoria)

                @if ($categoria['slug'] === 'Organica')
                    <button class="btn btn-primary mx-2 filter-button" data-fraccio="{{ $categoria['slug'] }}"
                        style="background-color: {{ $categoria['color'] }};">
                        Orgànica
                    </button>

                @else
                    <button class="btn btn-primary mx-2 filter-button" data-fraccio="{{ $categoria['slug'] }}"
                        style="background-color: {{ $categoria['color'] }};">
                        {{ $categoria['slug'] }}
                    </button>
                @endif
            @endforeach
            <button class="btn btn-outline-secondary mx-2 clear-filter-button">Esborra Filtre</button>
        </div>
        <div id="map" style="height: 500px; width: 100%;"></div>
    </div>
</section>

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
        display: flex;
        /* Col·loca el nom i la icona en línia */
        align-items: center;
        /* Centra verticalment la icona amb el text */
        justify-content: center;
        /* Centra el contingut horitzontalment */
        gap: 5px;
        /* Espai entre el nom i la icona */
    }

    body.dark-mode .category-title {
        color: white;
    }

    body.dark-mode .category-card:hover .category-title {
        color: white;
    }

    .info-icon {
        font-size: 0.5rem;
        /* Redueix la mida de la icona */
        color: white;
        background-color: gray;
        /* Fons circular gris */
        border-radius: 50%;
        /* Fons circular */
        width: 15px;
        /* Amplada del cercle */
        height: 15px;
        /* Alçada del cercle */
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        margin-left: 5px;
        margin-bottom: 10px;
    }

    .info-icon:hover {
        background-color: black;
        /* Canvia el fons a negre quan es passa el ratolí */
    }

    .search {
        position: relative;
        /* Permet posicionar els resultats de cerca absolutament dins d'aquest contenidor */
        width: 100%;
        /* Amplada completa del contenidor */
        max-width: 400px;
    }

    #product-results {
        display: none;
        position: absolute;
        /* Fa que la llista es mostri per sobre del contingut */
        top: calc(100% + 5px);
        /* Es col·loca just a sota de l'input amb un petit espai */
        left: 50%;
        /* Centra la llista horitzontalment */
        transform: translateX(-50%);
        /* Ajusta la posició per centrar-la completament */
        width: 100%;
        /* Amplada completa del contenidor */
        max-width: 400px;
        /* Limita l'amplada màxima */
        z-index: 5;
        /* Es mostra per sobre de les fraccions */
        background-color: white;
        /* Fons blanc per destacar els resultats */
        border: 1px solid #ddd;
        /* Afegim un contorn per separar els resultats */
        max-height: 300px;
        /* Limitem l'alçada màxima per evitar que ocupi massa espai */
        overflow-y: auto;
        /* Permet desplaçament vertical si hi ha molts resultats */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        /* Ombra per donar un efecte de flotació */
    }

    #product-results .list-group-item {
        cursor: pointer;
        /* Canvia el cursor per indicar que és clicable */
    }

    #product-results .list-group-item:hover {
        background-color: #f8f9fa;
        /* Canvia el fons quan es passa el ratolí */
    }

    .position-relative {
        position: relative;
        /* Assegura que els resultats es posicionin correctament respecte al contenidor */
    }

    #clear-search {
        position: absolute;
        right: 0;
        width: 40px;
        padding: 4px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        color: gray;
        display: none;
        z-index: 2;
        /* Assegura que el botó estigui per sobre del camp d'entrada */
    }

    #clear-search:hover {
        color: black;
    }


    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: 10;
    }

    /* Modal más grande */
    .modal-content {
        background-color: #fff;
        margin: 7% auto auto auto;
        padding: 25px;
        max-width: 800px;
        width: 80%;
        border-radius: 8px;
        position: relative;
        max-height: 80vh;
        overflow-y: auto;
    }

    /* Estilo para las tarjetas de productos */
    .product-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        cursor: pointer;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .product-card img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }

    .product-card-body {
        padding: 15px;
        text-align: center;
    }

    /* Estilo para modal de producto */
    .product-info-container {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .product-image {
        flex: 0 0 200px;
    }

    .product-image img {
        width: 100%;
        border-radius: 8px;
    }

    .product-details {
        flex: 1;
    }

    .recycling-tips {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-top: 20px;
    }

    .category-banner {
        background-color: var(--category-color);
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .category-banner svg {
        width: 30px;
        height: 30px;
        fill: white;
    }

    .back-button {
        color: #666;
        cursor: pointer;
        margin-bottom: 15px;
        display: inline-block;
    }

    .back-button:hover {
        color: #333;
        text-decoration: underline;
    }

    .leaflet-top.leaflet-right .alert {
        font-size: 1.2rem;
        padding: 10px 15px;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        background-color: #fff3cd;
        border: 1px solid #ffeeba;
        color: #856404;
        max-width: 250px;
        text-align: center;
    }

    body.dark-mode .modal-content {
        background-color: #2c2c2c;
        /* Fons fosc */
        color: #ffffff;
        /* Text blanc */
        border: 1px solid #444;
        /* Contorn subtil */
    }

    body.dark-mode .modal-content h3,
    body.dark-mode .modal-content h4,
    body.dark-mode .modal-content p {
        color: #ffffff;
        /* Text blanc */
    }

    body.dark-mode .product-info-container {
        background-color: #3a3a3a;
        /* Fons més fosc per a la informació del producte */
        border-radius: 8px;
        padding: 15px;
    }

    body.dark-mode .recycling-tips {
        background-color: #444;
        /* Fons fosc per a les recomanacions */
        color: #ddd;
        /* Text gris clar */
        border: 1px solid #555;
        /* Contorn subtil */
    }

    body.dark-mode .category-banner {
        background-color: #444;
        /* Fons fosc per al banner */
        color: #ffffff;
        /* Text blanc */
    }

    body.dark-mode .btn-primary {
        background-color: #555;
        /* Botons primaris en mode fosc */
        border-color: #666;
        color: #ffffff;
    }

    body.dark-mode .btn-primary:hover {
        background-color: #666;
        /* Canvi de color en passar el ratolí */
        border-color: #777;
    }
</style>
<!-- Add this hidden element to store the recycling info JSON data -->
<script type="application/json" id="recycling-info-data">
    @json($recyclingInfo)
</script>

<!-- Replace the multiple script blocks with a single script tag -->
<script src="https://cdn.jsdelivr.net/npm/algoliasearch@4"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>

    document.addEventListener('DOMContentLoaded', function () {
        // Initialize category cards
        const cards = document.querySelectorAll('.category-card');
        cards.forEach(card => {
            const color = card.getAttribute('data-color');
            card.style.setProperty('--hover-color', color);
        });

        // Initialize tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();

        // Initialize Algolia client
        const client = algoliasearch("4JU9PG98CF", "d37ffd358dca40447584fb2ffdc28e03");
        const productIndex = client.initIndex('productes');
        const puntsIndex = client.initIndex('punts_de_recollida');

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
                        div.innerHTML = `No s\'han trobat punts per a <strong>${fraccio}</strong>`;
                        return div;
                    };
                    noResultsControl.addTo(map);
                } else {
                    hits.forEach(punt => {
                        const marker = L.marker([punt.latitud, punt.longitud]).addTo(map);
                        marker.bindPopup(`
                        <strong>${punt.nom}</strong><br>
                        <strong>Ciutat:</strong> ${punt.ciutat}<br>
                        <strong>Adreça:</strong> ${punt.adreca}<br>
                        <strong>Fracció:</strong> ${punt.fraccio}<br>
                        <strong>Disponible:</strong> ${punt.disponible ? 'Disponible' : 'No disponible'}
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
                    productResults.append('<li class="list-group-item">No s\'ha trobat cap producte.</li>');
                } else {
                    // Show results
                    hits.forEach(hit => {
                        productResults.append(`
                            <li class="list-group-item d-flex align-items-center product-result" 
                                data-product-id="${hit.id}" 
                                data-product-name="${hit.nom}" 
                                data-product-category="${hit.categoria}" 
                                data-product-image="${hit.imatge}">
                                <div class="me-3">
                                    <img src="/${hit.imatge}" alt="${hit.nom}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                </div>
                                <div class="product-info">
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
                productResults.append('<li class="list-group-item text-danger">Error en la cerca. Torna-ho a intentar.</li>');
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
                $('#product-title').text(`Error searching for products in ${categoria}`);
                $('#product-list').html(`<p>There was an error searching for products. Details: ${err.message}</p>`);
                $('#product-modal').fadeIn();
            });
        });

        // Function to show products
        function showProducts(products, categoria, color, info) {
            $('#product-title').text(`Products in the ${categoria} fraction`);
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
                <h5>Recycling information</h5>
                <p><strong>What it is:</strong> ${info.descripcion}</p>
                <p><strong>How to recycle it:</strong> ${info.instruccions}</p>
                <p><strong>Benefits:</strong> ${info.beneficis}</p>
                <p><strong>Tips:</strong> ${info.consells}</p>
            </div>
            
            <h5>Products in this fraction</h5>
        `);

            if (products.length === 0) {
                productList.append('<p>No products found in this fraction.</p>');
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
            const recyclingText = info.instruccions || 'No hi ha informació disponible per aquesta fracció.';

            // Update the modal title with the product name
            $('#product-title').text("Descripció del producte").css('text-align', 'center');

            // Show detailed product information
            $('#product-list').html(`
                <div class="product-info-container">
                    <div class="product-image">
                        <img src="${productImage}" alt="${productName}" class="product-img">
                    </div>
                    <div class="product-details">
                        <h4>${productName}</h4>
                        <p><strong>Fracció:</strong> ${productCategory}</p>
                        <p><strong>Com reciclar-ho:</strong> ${recyclingText}</p>
                    </div>
                </div>
                <div id="product-map"></div>
                <button class="btn btn-primary mt-3 back-button">Tancar</button>
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
                            div.innerHTML = `No s\'han trobat punts per a <strong>${productCategory}</strong>`;
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