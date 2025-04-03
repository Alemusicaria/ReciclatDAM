<section id="reciclatge" class="text-center">
    <div class="h-100 d-flex flex-column justify-content-center align-items-center">
        <select id="product-search" class="form-control" style="max-width: 400px;">
            <option value="Envasos">Ampolla de plàstic</option>
            <option value="Paper">Diari</option>
            <option value="Envasos">Llauna</option>
            <option value="Paper">Cartró</option>
            <option value="Orgànic">Pell de plàtan</option>
        </select>
    </div>
</section>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#product-search').select2({
            placeholder: "Cerca un producte...",
            allowClear: true
        });
    });
</script>