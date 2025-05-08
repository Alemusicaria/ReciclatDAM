<section id="opinions" class="text-center py-5">
    <div class="w-100">
        <h2 class="section-title mb-4">{{ __('messages.opinions.title') }}</h2>
        <div class="d-flex justify-content-center align-items-center">
            <!-- Fletxa esquerra -->
            <button id="prev-opinion" class="opinion-arrow mx-3">
                <i class="fas fa-chevron-left"></i>
            </button>

            <!-- Carrusel d'opinions -->
            <div id="opinion-carousel " class="opinion-card text-center p-3 shadow-sm container" style="width: 40%;">
                <p id="opinion-text" class="mb-2">{{ __('messages.opinions.loading') }}</p>
                <div id="opinion-stars" class="mb-2">
                    <!-- Estrelles es generaran aquí -->
                </div>
                <h6 id="opinion-author" class="mb-0">-</h6>
            </div>

            <!-- Fletxa dreta -->
            <button id="next-opinion" class="opinion-arrow mx-3">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>

<style>
    .section-title {
        font-weight: 700;
        margin-bottom: 2rem;
        color: #212529;
        position: relative;
        display: inline-block;
    }

    .section-title:after {
        content: '';
        display: block;
        width: 50px;
        height: 3px;
        background-color: #2e7d32;
        /* Verd */
        margin: 12px auto 0;
    }

    #opinion-carousel {
        width: 40%;
        max-width: 400px;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, opacity 0.3s ease;
    }

    .opinion-arrow {
        width: 40px;
        height: 40px;
        background-color: #2e7d32;
        /* Blau professional */
        color: #fff;
        border: none;
        border-radius: 50%;
        /* Forma rodona */
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        /* Ombra */
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .opinion-arrow:hover {
        background-color: #215924;
        /* Blau més fosc al passar el ratolí */
        transform: scale(1.1);
        /* Augment lleuger al passar el ratolí */
    }

    .opinion-arrow:focus {
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.5) !important;
    }

    .opinion-arrow i {
        font-size: 16px;
        /* Mida de la icona */
    }

    .star {
        font-size: 20px;
        color: #ffc107;
        /* Color groc per a les estrelles */
    }

    .star.empty {
        color: #e4e5e9;
        /* Color gris per a les estrelles buides */
    }

    .star.half {
        background: linear-gradient(90deg, #ffc107 50%, #e4e5e9 50%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>

<script>
    $(document).ready(function () {
        const opinionsIndex = window.opinionsIndex; // Usa la variable global

        const opinionText = $('#opinion-text');
        const opinionAuthor = $('#opinion-author');
        const opinionStars = $('#opinion-stars');
        let opinions = [];
        let currentOpinionIndex = 0;

        // Obté les opinions d'Algolia
        function fetchOpinions() {
            opinionsIndex.search('', { hitsPerPage: 100 }).then(({ hits }) => {
                opinions = hits.filter(opinion => opinion.estrelles >= 3.5 && opinion.estrelles <= 5);

                if (opinions.length > 0) {
                    updateOpinion(0); // Mostra la primera opinió
                } else {
                    opinionText.text("{{ __('messages.opinions.no_opinions') }}");
                    opinionAuthor.text("-");
                    opinionStars.empty();
                }
            }).catch(err => {
                console.error('Error carregant opinions:', err);
                opinionText.text("{{ __('messages.opinions.error_loading') }}");
                opinionAuthor.text("-");
                opinionStars.empty();
            });
        }

        // Actualitza el contingut del card
        function updateOpinion(opinionsIndex) {
            const opinion = opinions[opinionsIndex];
            opinionText.fadeOut(200, function () {
                $(this).text(`"${opinion.comentari}"`).fadeIn(200);
            });
            opinionAuthor.fadeOut(200, function () {
                $(this).text(`- ${opinion.autor}`).fadeIn(200);
            });
            updateStars(opinion.estrelles);
        }

        // Actualitza les estrelles
        function updateStars(rating) {
            opinionStars.empty(); // Neteja les estrelles anteriors
            for (let i = 1; i <= 5; i++) {
                if (i <= Math.floor(rating)) {
                    // Estrella plena
                    opinionStars.append('<span class="star">&#9733;</span>');
                } else if (i - rating <= 0.5) {
                    // Estrella mitja (per decimals com 4.5)
                    opinionStars.append('<span class="star half">&#9733;</span>');
                } else {
                    // Estrella buida
                    opinionStars.append('<span class="star empty">&#9733;</span>');
                }
            }
        }

        // Navegació amb les fletxes
        $('#prev-opinion').on('click', function () {
            if (opinions.length > 0) {
                currentOpinionIndex = (currentOpinionIndex - 1 + opinions.length) % opinions.length;
                updateOpinion(currentOpinionIndex);
            }
        });

        $('#next-opinion').on('click', function () {
            if (opinions.length > 0) {
                currentOpinionIndex = (currentOpinionIndex + 1) % opinions.length;
                updateOpinion(currentOpinionIndex);
            }
        });

        // Carrega les opinions d'Algolia
        fetchOpinions();
    });
</script>