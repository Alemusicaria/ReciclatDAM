<section id="premis" class="text-center mt-5">
    <div class="container">
        <div class="row">
            <!-- Card 1: Explicació i llista de premis -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title">Premis Disponibles</h3>
                        <p class="card-text">Descobreix els premis disponibles i selecciona el que més t'agradi per veure'n més detalls.</p>
                        <div class="position-relative">
                            <div id="award-list-container" class="overflow-hidden" style="width: 100%; position: relative;">
                                <div id="award-list" class="d-flex flex-column gap-3" style="transition: transform 0.3s ease; width: max-content;">
                                    <!-- Aquí es generaran les files amb premis -->
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <button id="prev-award" class="btn-nav btn-sm">&larr;</button>
                                <button id="next-award" class="btn-nav btn-sm">&rarr;</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Detall del premi seleccionat -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title">Detall del Premi</h3>
                        <div id="selected-award" class="text-center">
                            <img id="selected-award-image" src="" alt="Premi seleccionat" class="img-fluid mb-3 selected-award-image">
                            <p id="selected-award-description" class="card-text"></p>
                            <div class="d-flex justify-content-between mt-3">
                                <button id="prev-selected-award" class="btn-nav btn-sm">&larr;</button>
                                <button id="next-selected-award" class="btn-nav btn-sm">&rarr;</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    #award-list-container {
        height: 300px; /* Ajusta l'alçada per mostrar 2 files */
    }

    #award-list .award-row {
        display: flex;
        justify-content: center;
        gap: 15px; /* Espai entre les targetes */
    }

    #award-list .award-card {
        width: 150px; /* Amplada més gran */
        height: 150px; /* Alçada més gran */
        border: 2px solid transparent;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    #award-list .award-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    #award-list .award-card.selected {
        border-color: #007bff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    #selected-award img {
        width: 300px; /* Amplada fixa més gran per a les imatges del Card 2 */
        height: 300px; /* Alçada fixa més gran per a les imatges del Card 2 */
        object-fit: cover; /* Manté la proporció de la imatge */
        border-radius: 8px;
    }

    .btn-nav {
        background-color: #6c757d;
        border: none;
        color: white;
        padding: 4px 8px; /* Botons més petits */
        font-size: 12px; /* Text més petit */
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    .btn-nav:hover {
        background-color: #5a6268;
    }
</style>

<script>
    $(document).ready(function () {
        // Inicialitza el client d'Algolia
        const client = algoliasearch("4JU9PG98CF", "d37ffd358dca40447584fb2ffdc28e03");
        const index = client.initIndex('premis'); // Nom de l'índex a Algolia

        const awardList = $('#award-list');
        const selectedAwardImage = $('#selected-award-image');
        const selectedAwardDescription = $('#selected-award-description');
        let currentAwardIndex = 0;
        let awards = [];
        const itemsPerPage = 4; // Mostra 4 premis (2 a dalt i 2 a baix)

        // Cerca els premis a Algolia
        function fetchAwards(query = '') {
            index.search(query, { hitsPerPage: 100 }).then(({ hits }) => {
                awards = hits;
                renderAwards();
                if (awards.length > 0) {
                    updateSelectedAward(0);
                } else {
                    selectedAwardImage.attr('src', '');
                    selectedAwardDescription.text('No s\'han trobat premis.');
                }
            }).catch(err => {
                console.error(err);
            });
        }

        // Renderitza les files amb premis
        function renderAwards() {
            awardList.empty();
            const start = Math.floor(currentAwardIndex / itemsPerPage) * itemsPerPage;
            const end = start + itemsPerPage;
            const visibleAwards = awards.slice(start, end);

            // Divideix els premis en 2 files
            const row1 = visibleAwards.slice(0, 2);
            const row2 = visibleAwards.slice(2, 4);

            const row1Element = $('<div class="award-row"></div>');
            row1.forEach((award, index) => {
                const awardCard = $(`
                    <div class="award-card ${start + index === currentAwardIndex ? 'selected' : ''}">
                        <img src="${award.imatge}" alt="${award.nom}">
                    </div>
                `);
                awardCard.on('click', () => updateSelectedAward(start + index));
                row1Element.append(awardCard);
            });

            const row2Element = $('<div class="award-row"></div>');
            row2.forEach((award, index) => {
                const awardCard = $(`
                    <div class="award-card ${start + index + 2 === currentAwardIndex ? 'selected' : ''}">
                        <img src="${award.imatge}" alt="${award.nom}">
                    </div>
                `);
                awardCard.on('click', () => updateSelectedAward(start + index + 2));
                row2Element.append(awardCard);
            });

            awardList.append(row1Element);
            awardList.append(row2Element);
        }

        // Actualitza el detall del premi seleccionat
        function updateSelectedAward(index) {
            currentAwardIndex = index;
            const award = awards[currentAwardIndex];
            selectedAwardImage.attr('src', award.imatge);
            selectedAwardDescription.text(award.descripcio);
            renderAwards();
        }

        // Navegació amb les fletxes
        $('#prev-award').on('click', function () {
            if (currentAwardIndex > 0) {
                currentAwardIndex--;
            } else {
                currentAwardIndex = awards.length - 1; // Torna a l'últim premi
            }
            updateSelectedAward(currentAwardIndex);
        });

        $('#next-award').on('click', function () {
            if (currentAwardIndex < awards.length - 1) {
                currentAwardIndex++;
            } else {
                currentAwardIndex = 0; // Torna al primer premi
            }
            updateSelectedAward(currentAwardIndex);
        });

        // Inicialitza la cerca
        fetchAwards();
    });
</script>