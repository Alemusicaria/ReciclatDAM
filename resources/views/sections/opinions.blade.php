<section id="opinions" class="text-center py-5">
    <div class="container">
        <h2 class="section-title mb-4">Opinions</h2>
        <div class="d-flex justify-content-center align-items-center">
            <!-- Fletxa esquerra -->
            <button id="prev-opinion" class="btn btn-outline-primary btn-sm mx-2">
                &larr;
            </button>

            <!-- Carrusel d'opinions -->
            <div id="opinion-carousel" class="opinion-card text-center p-3 shadow-sm">
                <p id="opinion-text" class="mb-2">"Aquesta és una opinió d'exemple."</p>
                <h6 id="opinion-author" class="mb-0">- Autor Exemple</h6>
            </div>

            <!-- Fletxa dreta -->
            <button id="next-opinion" class="btn btn-outline-primary btn-sm mx-2">
                &rarr;
            </button>
        </div>
    </div>
</section>

<style>
    #opinions {
        background-color: #f8f9fa;
    }

    .section-title {
        font-weight: 700;
        margin-bottom: 2rem;
        color: #212529;
    }

    #opinion-carousel {
        width: 100%;
        max-width: 400px;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, opacity 0.3s ease;
    }

    .btn {
        font-size: 12px;
        width: 40px;
        padding: 4px 8px;
    }

    .btn-sm {
        font-size: 12px;
        padding: 4px 8px;
    }
</style>

<script>
    $(document).ready(function () {
        const opinions = [
            { text: "Aquesta és una opinió d'exemple.", author: "Autor Exemple" },
            { text: "M'encanta aquest servei, és increïble!", author: "Maria P." },
            { text: "Un servei excel·lent, molt recomanable.", author: "Joan G." },
            { text: "La millor experiència que he tingut mai!", author: "Anna R." }
        ];

        let currentOpinionIndex = 0;

        // Actualitza el contingut del card
        function updateOpinion(index) {
            const opinion = opinions[index];
            $('#opinion-text').fadeOut(200, function () {
                $(this).text(`"${opinion.text}"`).fadeIn(200);
            });
            $('#opinion-author').fadeOut(200, function () {
                $(this).text(`- ${opinion.author}`).fadeIn(200);
            });
        }

        // Navegació amb les fletxes
        $('#prev-opinion').on('click', function () {
            currentOpinionIndex = (currentOpinionIndex - 1 + opinions.length) % opinions.length;
            updateOpinion(currentOpinionIndex);
        });

        $('#next-opinion').on('click', function () {
            currentOpinionIndex = (currentOpinionIndex + 1) % opinions.length;
            updateOpinion(currentOpinionIndex);
        });

        // Inicialitza amb la primera opinió
        updateOpinion(currentOpinionIndex);
    });
</script>