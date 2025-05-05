<section id="inici" class="hero text-left">
    <div class="row justify-content-center align-items-center h-100 w-100">
        <!-- Text i Cerca -->
        <div class="col-lg-5 d-flex align-items-center justify-content-center">
            <div class="card mb-4 p-4 w-100">
                <div class="card-body text-left">
                    <h1 class="display-4 fw-bold text-left">Ajuda a Reciclar <br> Guanya Recompenses</h1>
                    <p class="lead text-left">Transforma el teu reciclatge en beneficis per a la comunitat.</p>

                    <div class="search-container mt-4">
                        <h3 class="search-title text-left">Cerca la teva ciutat o carrer</h3>
                        <div class="position-relative">
                            <input id="search-input" class="form-control search-input pl-5" type="search"
                                placeholder="Escriu el nom de la teva ciutat o carrer..." aria-label="Search">
                            <i class="fas fa-search position-absolute"
                                style="top: 50%; left: 15px; transform: translateY(-50%); color: #888;"></i>
                        </div>
                        <ul id="search-results" class="list-group mt-2" style="display: none;"></ul>
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

<script src="https://cdn.jsdelivr.net/npm/algoliasearch@4"></script>
<script>
        document.addEventListener('DOMContentLoaded', function () {
        // Inicialitza el client d'Algolia
        const client = algoliasearch("4JU9PG98CF", "d37ffd358dca40447584fb2ffdc28e03");
        const index = client.initIndex('punts_de_recollida'); // Nom de l'índex a Algolia
    
        const searchInput = document.getElementById('search-input');
        const searchResults = document.getElementById('search-results');
    
        // Definim els colors per a cada fracció
        const fraccioColors = {
            'Paper': '#2859bc', // Blau
            'Envasos': '#fddd19', // Groc
            'Organica': '#9e6831', // Marró
            'Vidre': '#3fd055', // Verd
            'Resta': '#6d7878', // Gris
            'Deixalleria': '#d62c2d', // Vermell
            'Medicaments': '#b7e53b', // Verd clar
            'Piles': '#fca614', // Taronja
            'Especial': '#2f3939', // Gris fosc
            'RAEE': '#006f3f' // Verd fosc
        };
    
        // Cerca en temps real
        searchInput.addEventListener('input', function () {
            const query = searchInput.value.trim();
    
            if (query === '') {
                searchResults.style.display = 'none';
                searchResults.innerHTML = '';
                return;
            }
    
            // Cerca a Algolia
            index.search(query, {
                hitsPerPage: 10 // Limita el nombre de resultats
            }).then(({ hits }) => {
                searchResults.innerHTML = ''; // Esborra els resultats anteriors
    
                if (hits.length === 0) {
                    searchResults.innerHTML = '<li class="list-group-item">No s\'han trobat punts de recollida.</li>';
                } else {
                    hits.forEach(hit => {
                        const listItem = document.createElement('li');
                        listItem.className = 'list-group-item d-flex align-items-center';
                        listItem.style.backgroundColor = fraccioColors[hit.fracció] || '#ffffff'; // Assigna el color de fons segons la fracció
                        listItem.style.position = 'relative'; // Per al fons blanc translúcid
    
                        // Genera el contingut del resultat amb un mapa estàtic petit
                        listItem.innerHTML = `
                            <div style="flex: 1; position: relative; z-index: 2; padding: 10px; background: rgba(255, 255, 255, 0.8); border-radius: 5px; color: black;">
                                <strong>${hit.nom}</strong><br>
                                <span>${hit.ciutat}, ${hit.adreca}</span><br>
                                <small><strong>Fracció:</strong> ${hit.fraccio}</small>
                            </div>
                            <div style="margin-left: 10px; z-index: 1;">
                                <img src="https://maps.googleapis.com/maps/api/staticmap?center=${hit.latitud},${hit.longitud}&zoom=15&size=150x100&scale=2&markers=color:red%7C${hit.latitud},${hit.longitud}&key=AIzaSyA_P805QMSihuKi7XQAK7KMnoPcZa8YEas" alt="Mapa estàtic" style="width: 150px; height: 100px; border-radius: 5px;">
                            </div>
                        `;
    
                        listItem.addEventListener('click', function () {
                            // Centra el mapa en el punt seleccionat
                            map.setView([hit.latitud, hit.longitud], 15);
    
                            // Afegeix un marcador al mapa
                            const marker = L.marker([hit.latitud, hit.longitud]).addTo(map);
                            marker.bindPopup(`
                                <strong>${hit.nom}</strong><br>
                                <strong>Ciutat:</strong> ${hit.ciutat}<br>
                                <strong>Adreça:</strong> ${hit.adreça}<br>
                                <strong>Fracció:</strong> ${hit.fracció}<br>
                                <strong>Disponibilitat:</strong> ${hit.disponible ? 'Disponible' : 'No disponible'}
                            `).openPopup();
                        });
    
                        searchResults.appendChild(listItem);
                    });
                }
    
                searchResults.style.display = 'block'; // Mostra els resultats
            }).catch(err => {
                console.error('Error en la cerca:', err);
            });
        });
    });
</script>