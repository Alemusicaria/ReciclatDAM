<section id="reciclatge" class="text-center">
    <div class="h-100 d-flex flex-column justify-content-center align-items-center">
        <h2>Cerca un producte</h2>
        <!-- Camp de cerca -->
        <input id="product-search" type="text" class="form-control" style="max-width: 400px;"
            placeholder="Cerca un producte...">
        <!-- Resultats de cerca -->
        <ul id="product-results" class="list-group mt-3" style="max-width: 400px;"></ul>
    </div>
</section>

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
                hitsPerPage: 10
            }).then(({ hits }) => {
                // Esborra els resultats anteriors
                $('#product-results').empty();

                // Mostra els resultats
                hits.forEach(hit => {
                    $('#product-results').append(`
                        <li class="list-group-item">
                            <strong>${hit.nom}</strong> - ${hit.categoria}
                        </li>
                    `);
                });
            }).catch(err => {
                console.error(err);
            });
        });
    });
</script>