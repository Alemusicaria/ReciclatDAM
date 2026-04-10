<section id="opinions" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title mb-4">{{ __('messages.opinions.title') }}</h2>
            
            <!-- STATS -->
            <div id="opinions-stats" class="opinions-stats mb-4">
                <div class="stat-box">
                    <h6 class="stat-label">{{ __('messages.opinions_ui.avg_rating') }}</h6>
                    <div class="stat-value">
                        <span id="avg-rating" class="rating-number">4.8</span>
                        <span id="avg-stars" class="stars-display"></span>
                    </div>
                </div>
                <div class="stat-box">
                    <h6 class="stat-label">{{ __('messages.opinions_ui.total_opinions') }}</h6>
                    <div class="stat-value">
                        <span id="opinions-count" class="rating-number">0</span>
                    </div>
                </div>
            </div>

            <!-- FILTRES -->
            <div class="opinions-filters mb-4">
                <button class="filter-btn active" data-filter="all">{{ __('messages.opinions_ui.all') }} <span class="filter-count">(0)</span></button>
                <button class="filter-btn" data-filter="5">⭐⭐⭐⭐⭐ <span class="filter-count">(0)</span></button>
                <button class="filter-btn" data-filter="4">⭐⭐⭐⭐ <span class="filter-count">(0)</span></button>
                <button class="filter-btn" data-filter="3">⭐⭐⭐ <span class="filter-count">(0)</span></button>
            </div>
        </div>

        <!-- GRID DE OPINIONS -->
        <div class="opinions-gallery">
            <div id="opinions-grid" class="row g-3 opinions-grid-container">
                <!-- Opiniones loaded here -->
            </div>
        </div>

        <!-- PAGINACION -->
        <div id="opinions-pagination" class="mt-4 d-flex justify-content-center"></div>

        <!-- INDICATORS -->
        <div id="opinions-indicators" class="opinions-indicators mt-4">
            <!-- Dots will be generated here -->
        </div>
    </div>
</section>

<style>
    /* OPINIONS SECTION */
    #opinions {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        padding: 3rem 0;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        position: relative;
        display: inline-block;
    }

    .section-title:after {
        content: '';
        display: block;
        width: 60px;
        height: 5px;
        background: linear-gradient(90deg, #1abc9c, #16a085);
        margin-top: 0.5rem;
    }

    /* STATS */
    .opinions-stats {
        display: flex;
        justify-content: center;
        gap: 3rem;
        flex-wrap: wrap;
    }

    .stat-box {
        background: white;
        padding: 1.5rem 2.5rem;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        min-width: 180px;
    }

    .stat-label {
        color: #7f8c8d;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .stat-value {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .rating-number {
        font-size: 2rem;
        font-weight: 700;
        color: #1abc9c;
    }

    .stars-display {
        display: inline-flex;
        gap: 0.2rem;
    }

    .stars-display .star {
        font-size: 1.2rem;
        color: #f39c12;
    }

    /* FILTRES */
    .opinions-filters {
        display: flex;
        justify-content: center;
        gap: 0.4rem;
        flex-wrap: nowrap;
        overflow-x: auto;
        overflow-y: hidden;
        padding-bottom: 0.2rem;
        scrollbar-width: thin;
    }

    #opinions .filter-btn {
        background: white;
        border: 1px solid #e0e0e0;
        padding: 0.24rem 0.4rem !important;
        border-radius: 50px;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.7rem !important;
        line-height: 1.1;
        white-space: nowrap;
        flex: 0 0 auto;
        width: auto;
        min-width: 0;
        transition: all 0.3s ease;
        color: #2c3e50;
    }

    #opinions .filter-btn:hover {
        border-color: #1abc9c;
        color: #1abc9c;
    }

    #opinions .filter-btn.active {
        background: linear-gradient(135deg, #1abc9c, #16a085);
        color: white;
        border-color: #1abc9c;
    }

    #opinions .filter-count {
        opacity: 0.7;
        font-size: 0.62rem !important;
        margin-left: 0.1rem;
    }

    /* GALLERY CONTAINER */
    .opinions-gallery {
        background: white;
        border-radius: 10px;
        padding: 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .opinions-grid-container {
        max-height: 55vh;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 1rem;
    }

    .opinions-grid-container::-webkit-scrollbar {
        width: 8px;
    }

    .opinions-grid-container::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .opinions-grid-container::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #1abc9c, #16a085);
        border-radius: 4px;
    }

    .opinions-grid-container::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #16a085, #0d8368);
    }

    .opinions-grid-container {
        scrollbar-color: #1abc9c #f1f1f1;
        scrollbar-width: thin;
    }

    /* OPINION CARD */
    .opinion-card-new {
        background: white;
        border-radius: 10px;
        border: 1px solid #ecf0f1;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow: hidden;
        position: relative;
    }

    .opinion-card-new:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        border-color: #1abc9c;
    }

    .opinion-header {
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        border-bottom: 1px solid #ecf0f1;
    }

    .opinion-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1abc9c, #16a085);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .opinion-meta {
        flex: 1;
    }

    .opinion-author {
        font-weight: 700;
        color: #2c3e50;
        font-size: 0.95rem;
        margin-bottom: 0.2rem;
    }

    .opinion-date {
        font-size: 0.75rem;
        color: #95a5a6;
    }

    .opinion-rating {
        display: flex;
        gap: 0.3rem;
        margin-bottom: 0.5rem;
    }

    .opinion-rating .star {
        color: #f39c12;
        font-size: 0.95rem;
    }

    .opinion-rating .star.empty {
        color: #ecf0f1;
    }

    .opinion-body {
        padding: 1rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .opinion-text {
        color: #2c3e50;
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 0;
        font-style: italic;
        flex: 1;
    }

    /* INDICATORS */
    .opinions-indicators {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .indicator-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #bdc3c7;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .indicator-dot.active {
        background: #1abc9c;
        width: 24px;
        border-radius: 50px;
    }

    .indicator-dot:hover {
        background: #1abc9c;
    }

    /* PAGINATION */
    #opinions-pagination {
        padding: 1.5rem 0;
    }

    #opinions-pagination .btn {
        min-width: 36px;
        height: 36px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s ease;
        margin: 0 0.25rem;
    }

    #opinions-pagination .btn:not(.btn-primary) {
        border-color: #1abc9c;
        color: #1abc9c;
        background: transparent;
    }

    #opinions-pagination .btn-primary {
        background: linear-gradient(135deg, #1abc9c, #16a085);
        border: none;
        color: white;
    }

    #opinions-pagination .btn:hover:not(.btn-primary) {
        background: #f0f9f8;
    }

    /* RESPONSIVE */
    @media (max-width: 1200px) {
        .col-lg-4 {
            flex: 0 0 calc(33.333% - 0.7rem);
            max-width: calc(33.333% - 0.7rem);
        }

        .opinions-grid-container {
            max-height: 50vh;
        }
    }

    @media (max-width: 992px) {
        .col-lg-4 {
            flex: 0 0 calc(50% - 0.6rem);
            max-width: calc(50% - 0.6rem);
        }

        .opinions-grid-container {
            max-height: 45vh;
        }

        .stat-box {
            min-width: 150px;
            padding: 1rem 1.5rem;
        }

        .opinions-stats {
            gap: 2rem;
        }
    }

    @media (max-width: 768px) {
        #opinions {
            padding: 2rem 0;
        }

        .section-title {
            font-size: 1.8rem;
        }

        .col-lg-4,
        .col-md-6 {
            flex: 0 0 calc(50% - 0.6rem) !important;
            max-width: calc(50% - 0.6rem) !important;
        }

        .opinions-grid-container {
            max-height: 65vh;
            padding: 0.75rem;
        }

        .stat-box {
            min-width: 140px;
            padding: 0.75rem 1rem;
        }

        .rating-number {
            font-size: 1.5rem;
        }

        .opinion-header {
            padding: 0.75rem;
        }

        .opinion-body {
            padding: 0.75rem;
        }

        .opinion-text {
            font-size: 0.85rem;
        }
    }

    @media (max-width: 576px) {
        #opinions {
            padding: 1rem 0;
        }

        .section-title {
            font-size: 1.5rem;
            text-align: center;
        }

        .col-sm-6,
        .col-md-6 {
            flex: 0 0 calc(50% - 0.3rem) !important;
            max-width: calc(50% - 0.3rem) !important;
        }

        .opinions-grid-container {
            max-height: 70vh;
            padding: 0.5rem;
        }

        .opinions-stats {
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .stat-box {
            min-width: 120px;
            padding: 0.6rem 0.8rem;
        }

        .stat-label {
            font-size: 0.75rem;
        }

        .rating-number {
            font-size: 1.2rem;
        }

        .opinion-card-new {
            min-height: 280px;
        }

        .opinion-header {
            padding: 0.6rem;
        }

        .opinion-avatar {
            width: 38px;
            height: 38px;
            font-size: 0.9rem;
        }

        .opinion-author {
            font-size: 0.85rem;
        }

        .opinion-body {
            padding: 0.6rem;
        }

        .opinion-text {
            font-size: 0.8rem;
        }

        .opinion-rating .star {
            font-size: 0.85rem;
        }

        .opinions-filters {
            gap: 0.35rem;
            justify-content: flex-start;
            flex-wrap: nowrap;
            overflow-x: auto;
        }

        #opinions .filter-btn {
            font-size: 0.66rem !important;
            padding: 0.22rem 0.34rem !important;
        }
    }

    /* DARK MODE */
    .dark #opinions {
        background: linear-gradient(135deg, #1a1a1a, #2d3436);
    }

    .dark .section-title {
        color: #ecf0f1;
    }

    .dark .stat-box,
    .dark .opinion-card-new,
    .dark .opinions-gallery,
    .dark .filter-btn {
        background: #2d3436;
        color: #ecf0f1;
        border-color: #34495e;
    }

    .dark .opinion-author,
    .dark .opinion-text {
        color: #ecf0f1;
    }

    .dark .opinion-date,
    .dark .stat-label,
    .dark .filter-count {
        color: #bdc3c7;
    }

    .dark .filter-btn:hover {
        color: #1abc9c;
        border-color: #1abc9c;
    }

    .dark .filter-btn.active {
        background: linear-gradient(135deg, #1abc9c, #16a085);
        color: white;
    }

    .dark .opinion-header {
        border-bottom-color: #34495e;
    }
</style>

<script>
    $(document).ready(function () {
        const opinionsIndex = window.opinionsIndex;
        const opinionsI18n = {
            justNow: @json(__('messages.opinions_ui.just_now')),
            today: @json(__('messages.opinions_ui.today')),
            oneDay: @json(__('messages.opinions_ui.one_day')),
            daysAgoTemplate: @json(__('messages.opinions_ui.days_ago')),
            monthsAgoTemplate: @json(__('messages.opinions_ui.months_ago')),
            oneYear: @json(__('messages.opinions_ui.one_year')),
            yearsAgoTemplate: @json(__('messages.opinions_ui.years_ago')),
            loading: @json(__('messages.opinions_ui.loading')),
            noAvailable: @json(__('messages.opinions_ui.no_available')),
            errorLoading: @json(__('messages.opinions_ui.error_loading')),
            noCategoryOpinions: @json(__('messages.opinions_ui.no_category_opinions')),
        };
        
        let allOpinions = [];
        let filteredOpinions = [];
        let currentFilter = 'all';
        let currentPage = 1;
        const itemsPerPage = 9;
        let autoRotateInterval;

        // Helper: Obtener iniciales del autor
        function getInitials(name) {
            return name
                .split(' ')
                .map(n => n[0])
                .join('')
                .toUpperCase()
                .slice(0, 2);
        }

        // Helper: Formatear fecha
        function formatDate(dateStr) {
            if (!dateStr) return opinionsI18n.justNow;
            
            try {
                // Parsear múltiples formatos
                let date;
                if (typeof dateStr === 'string') {
                    // Limpiar el string
                    dateStr = dateStr.trim();
                    // Intentar parsear ISO 8601 o MySQL datetime
                    date = new Date(dateStr);
                } else {
                    date = new Date(dateStr);
                }
                
                // Verificar si la fecha es válida
                if (isNaN(date.getTime())) {
                    return opinionsI18n.justNow;
                }
                
                const now = new Date();
                const diff = Math.floor((now - date) / (1000 * 60 * 60 * 24));
                
                if (diff === 0) return opinionsI18n.today;
                if (diff === 1) return opinionsI18n.oneDay;
                if (diff < 30) return opinionsI18n.daysAgoTemplate.replace(':count', diff);
                if (diff < 365) return opinionsI18n.monthsAgoTemplate.replace(':count', Math.floor(diff / 30));
                
                const years = Math.floor(diff / 365);
                if (years === 1) return opinionsI18n.oneYear;
                return opinionsI18n.yearsAgoTemplate.replace(':count', years);
            } catch (e) {
                console.warn('Error parsing date:', dateStr, e);
                return opinionsI18n.justNow;
            }
        }

        // Helper: Renders stars
        function renderStars(rating) {
            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= Math.floor(rating)) {
                    starsHtml += '<span class="star">★</span>';
                } else if (i - rating < 1 && i - rating > 0) {
                    starsHtml += '<span class="star">★</span>';
                } else {
                    starsHtml += '<span class="star empty">★</span>';
                }
            }
            return starsHtml;
        }

        // Cargar opiniones
        function loadOpinions() {
            $('#opinions-grid').html(`<div class="col-12 text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">${opinionsI18n.loading}</span></div></div>`);

            if (!opinionsIndex || typeof opinionsIndex.search !== 'function') {
                $('#opinions-grid').html(`<div class="col-12 text-center text-danger py-5">${opinionsI18n.errorLoading}</div>`);
                return;
            }

            opinionsIndex.search('', { hitsPerPage: 100 }).then(({ hits }) => {
                // Filtrar opiniones con rating >= 3 y limitar a máximo 15
                allOpinions = hits
                    .filter(o => parseFloat(o.estrelles) >= 3)
                    .map(o => ({
                        ...o,
                        estrelles: parseFloat(o.estrelles) || 3,
                        created_at: o.created_at || new Date().toISOString()
                    }))
                    .sort((a, b) => parseFloat(b.estrelles) - parseFloat(a.estrelles))
                    .slice(0, 15);

                if (allOpinions.length === 0) {
                    $('#opinions-grid').html(`<div class="col-12 text-center text-muted py-5">${opinionsI18n.noAvailable}</div>`);
                    return;
                }

                updateStats();
                applyFilter('all');
                renderIndicators();
                startAutoRotate();
            }).catch(err => {
                console.error('Error:', err);
                $('#opinions-grid').html(`<div class="col-12 text-center text-danger py-5">${opinionsI18n.errorLoading}</div>`);
            });
        }

        // Actualizar stats
        function updateStats() {
            const count = allOpinions.length;
            const avgRating = (allOpinions.reduce((sum, o) => sum + o.estrelles, 0) / count).toFixed(1);
            
            $('#opinions-count').text(count);
            $('#avg-rating').text(avgRating);
            $('#avg-stars').html(renderStars(avgRating));

            // Actualizar filtros
            const counts = {
                all: allOpinions.length,
                5: allOpinions.filter(o => o.estrelles >= 4.5).length,
                4: allOpinions.filter(o => o.estrelles >= 3.5 && o.estrelles < 4.5).length,
                3: allOpinions.filter(o => o.estrelles >= 3 && o.estrelles < 3.5).length
            };

            $.each(counts, (filter, count) => {
                $(`.filter-btn[data-filter="${filter}"] .filter-count`).text(`(${count})`);
            });
        }

        // Aplicar filtro
        function applyFilter(filter) {
            currentFilter = filter;
            currentPage = 1;

            if (filter === 'all') {
                filteredOpinions = allOpinions;
            } else if (filter === '5') {
                filteredOpinions = allOpinions.filter(o => o.estrelles >= 4.5);
            } else if (filter === '4') {
                filteredOpinions = allOpinions.filter(o => o.estrelles >= 3.5 && o.estrelles < 4.5);
            } else if (filter === '3') {
                filteredOpinions = allOpinions.filter(o => o.estrelles >= 3 && o.estrelles < 3.5);
            }

            $('.filter-btn').removeClass('active');
            $(`.filter-btn[data-filter="${filter}"]`).addClass('active');

            renderOpinions();
            renderPagination();
            renderIndicators();
        }

        // Renderizar opiniones
        function renderOpinions() {
            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const pageOpinions = filteredOpinions.slice(start, end);

            if (pageOpinions.length === 0) {
                $('#opinions-grid').html(`<div class="col-12 text-center text-muted py-5">${opinionsI18n.noCategoryOpinions}</div>`);
                return;
            }

            const html = pageOpinions.map(opinion => `
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="opinion-card-new">
                        <div class="opinion-header">
                            <div class="opinion-avatar">${getInitials(opinion.autor)}</div>
                            <div class="opinion-meta">
                                <div class="opinion-author">${opinion.autor}</div>
                                <div class="opinion-date">${formatDate(opinion.created_at)}</div>
                                <div class="opinion-rating">
                                    ${renderStars(opinion.estrelles)}
                                </div>
                            </div>
                        </div>
                        <div class="opinion-body">
                            <p class="opinion-text">"${opinion.comentari}"</p>
                        </div>
                    </div>
                </div>
            `).join('');

            $('#opinions-grid').html(html);
        }

        // Renderizar paginación
        function renderPagination() {
            const totalPages = Math.ceil(filteredOpinions.length / itemsPerPage);
            if (totalPages <= 1) {
                $('#opinions-pagination').html('');
                return;
            }

            let html = '';
            if (currentPage > 1) {
                html += `<button class="btn btn-outline-primary" onclick="goToOpinionPage(${currentPage - 1})"><i class="fas fa-chevron-left"></i></button>`;
            }

            for (let i = 1; i <= totalPages; i++) {
                if (i === currentPage) {
                    html += `<button class="btn btn-primary">${i}</button>`;
                } else if (i <= 3 || i >= totalPages - 2 || Math.abs(i - currentPage) <= 1) {
                    html += `<button class="btn btn-outline-primary" onclick="goToOpinionPage(${i})">${i}</button>`;
                } else if (i === 4 || i === totalPages - 3) {
                    html += '<span class="mx-1">...</span>';
                }
            }

            if (currentPage < totalPages) {
                html += `<button class="btn btn-outline-primary" onclick="goToOpinionPage(${currentPage + 1})"><i class="fas fa-chevron-right"></i></button>`;
            }

            $('#opinions-pagination').html(html);
        }

        // Ir a página
        window.goToOpinionPage = function(page) {
            currentPage = page;
            renderOpinions();
            renderPagination();
            renderIndicators();
            document.getElementById('opinions-grid').scrollIntoView({ behavior: 'smooth' });
            restartAutoRotate();
        };

        // Renderizar indicadores
        function renderIndicators() {
            const totalPages = Math.ceil(filteredOpinions.length / itemsPerPage);
            let html = '';
            for (let i = 1; i <= totalPages; i++) {
                html += `<div class="indicator-dot ${i === currentPage ? 'active' : ''}" onclick="goToOpinionPage(${i})"></div>`;
            }
            $('#opinions-indicators').html(html);
        }

        // Auto-rotate
        function startAutoRotate() {
            autoRotateInterval = setInterval(() => {
                const totalPages = Math.ceil(filteredOpinions.length / itemsPerPage);
                if (totalPages > 1) {
                    const nextPage = currentPage < totalPages ? currentPage + 1 : 1;
                    goToOpinionPage(nextPage);
                }
            }, 5000);
        }

        function restartAutoRotate() {
            clearInterval(autoRotateInterval);
            startAutoRotate();
        }

        // Event listeners
        $('.filter-btn').on('click', function() {
            const filter = $(this).data('filter');
            applyFilter(filter);
            restartAutoRotate();
        });

        // Cargar opiniones al iniciar
        loadOpinions();
    });
</script>