<section id="premis" class="py-5">
    <div class="container">
        <h2 class="section-title mb-5 text-center">{{ __('messages.awards.title') }}</h2>
        
        <!-- RECOMENDACIONS PERSONALITZADES -->
        <div id="recommended-section" class="mb-5">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-star text-warning me-2" style="font-size: 1.5rem;"></i>
                <h3 class="mb-0">{{ __('messages.awards_ui.recommended_title') }}</h3>
                <span class="badge bg-warning text-dark ms-2">{{ __('messages.awards_ui.recommended_badge') }}</span>
            </div>
            <div id="recommended-awards" class="row g-3">
                <!-- Recommended awards loaded here -->
            </div>
        </div>

        <!-- FILTRES I CATEGORIAS -->
        <div class="awards-controls mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold">{{ __('messages.awards_ui.filter_by_type') }}</label>
                    <select id="category-filter" class="form-select">
                        <option value="">{{ __('messages.awards_ui.all_types') }}</option>
                        <option value="electrònica">{{ __('messages.awards_ui.category_electronics') }}</option>
                        <option value="esports">{{ __('messages.awards_ui.category_sports') }}</option>
                        <option value="casa">{{ __('messages.awards_ui.category_home') }}</option>
                        <option value="transport">{{ __('messages.awards_ui.category_transport') }}</option>
                        <option value="accessoris">{{ __('messages.awards_ui.category_accessories') }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">{{ __('messages.awards_ui.points_range') }}</label>
                    <div class="d-flex gap-2">
                        <input type="number" id="points-min" placeholder="{{ __('messages.awards_ui.min') }}" class="form-control form-control-sm" min="0">
                        <span class="text-muted">-</span>
                        <input type="number" id="points-max" placeholder="{{ __('messages.awards_ui.max') }}" class="form-control form-control-sm" min="0">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">{{ __('messages.awards_ui.sort_by') }}</label>
                    <select id="sort-filter" class="form-select">
                        <option value="name">{{ __('messages.awards_ui.sort_name') }}</option>
                        <option value="points-asc">{{ __('messages.awards_ui.sort_points_asc') }}</option>
                        <option value="points-desc">{{ __('messages.awards_ui.sort_points_desc') }}</option>
                        <option value="popular">{{ __('messages.awards_ui.sort_popular') }}</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- GALERIA DE PREMIS (GRID CON SCROLL) -->
        <div class="awards-gallery-new">
            <div id="awards-grid" class="row g-3 awards-grid-container">
                <!-- Awards loaded here -->
            </div>
        </div>

        <!-- PAGINACION (si es necesaria) -->
        <div id="awards-pagination" class="mt-4 d-flex justify-content-center"></div>
    </div>
</section>

<!-- MODAL DETALLE PREMI (simplificado, integrado en card) -->

<style>
    /* PREMIOS SECTION STYLING */
    #premis {
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

    /* CONTROLS */
    .awards-controls {
        background: white;
        padding: 1.5rem;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }

    .awards-controls .form-label {
        color: #2c3e50;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .awards-controls .form-select,
    .awards-controls .form-control {
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        padding: 0.6rem 0.8rem;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .awards-controls .form-select:focus,
    .awards-controls .form-control:focus {
        border-color: #1abc9c;
        box-shadow: 0 0 0 3px rgba(26, 188, 156, 0.1);
    }

    /* GALLERY CONTAINER WITH SCROLL */
    .awards-gallery-new {
        background: white;
        border-radius: 10px;
        padding: 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .awards-grid-container {
        max-height: 55vh;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 1rem;
    }

    /* Custom scrollbar styling */
    .awards-grid-container::-webkit-scrollbar {
        width: 8px;
    }

    .awards-grid-container::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .awards-grid-container::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #1abc9c, #16a085);
        border-radius: 4px;
    }

    .awards-grid-container::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #16a085, #0d8368);
    }

    /* Firefox scrollbar */
    .awards-grid-container {
        scrollbar-color: #1abc9c #f1f1f1;
        scrollbar-width: thin;
    }

    /* AWARD CARD COMPACT */
    .award-card-compact {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.25s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
        min-height: 320px;
    }

    .award-card-compact:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
    }

    .award-card-compact.recommended {
        border: 2px solid #f39c12;
    }

    .badge-star {
        position: absolute;
        top: 8px;
        right: 8px;
        font-size: 1.2rem;
        z-index: 10;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
    }

    .award-img-box {
        position: relative;
        width: 100%;
        height: 130px;
        background: #f0f0f0;
        overflow: hidden;
    }

    .award-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .award-card-compact:hover .award-img {
        transform: scale(1.08);
    }

    .category-tag {
        position: absolute;
        bottom: 8px;
        left: 8px;
        background: rgba(255, 255, 255, 0.9);
        color: #1abc9c;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 0.9rem;
        backdrop-filter: blur(10px);
    }

    .award-content {
        padding: 1rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .award-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .award-name {
        font-size: 0.95rem;
        font-weight: 700;
        color: #2c3e50;
        line-height: 1.2;
        flex: 1;
    }

    .points-badge {
        background: linear-gradient(135deg, #1abc9c, #16a085);
        color: white;
        padding: 0.25rem 0.6rem;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .award-desc {
        font-size: 0.8rem;
        color: #7f8c8d;
        line-height: 1.3;
        margin-bottom: 0.75rem;
    }

    .award-stats {
        display: flex;
        justify-content: space-around;
        padding: 0.6rem;
        background: #f8f9fa;
        border-radius: 6px;
        margin-bottom: 0.75rem;
        font-size: 0.75rem;
    }

    .stat-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        color: #7f8c8d;
        gap: 0.2rem;
    }

    .stat-item i {
        color: #1abc9c;
        font-size: 0.85rem;
    }

    .award-difficulty {
        margin-bottom: 0.75rem;
        display: flex;
        justify-content: center;
    }

    .diff-badge {
        font-size: 0.75rem !important;
        padding: 0.3rem 0.6rem !important;
        font-weight: 600;
    }

    .award-card-compact .btn {
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.5rem;
        transition: all 0.2s ease;
        border: none;
    }

    .award-card-compact .btn-success {
        background: linear-gradient(135deg, #1abc9c, #16a085);
    }

    .award-card-compact .btn-success:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(26, 188, 156, 0.3);
    }

    /* RECOMENDACIONES */
    #recommended-section {
        background: white;
        padding: 1.5rem;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
        border-left: 4px solid #f39c12;
    }

    #recommended-section h3 {
        color: #2c3e50;
        font-weight: 700;
        font-size: 1.3rem;
    }

    #recommended-section .d-flex {
        align-items: center;
    }

    /* PAGINACION */
    #awards-pagination {
        padding: 1.5rem 0;
    }

    #awards-pagination .btn {
        min-width: 36px;
        height: 36px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s ease;
        margin: 0 0.25rem;
    }

    #awards-pagination .btn:not(.btn-primary) {
        border-color: #1abc9c;
        color: #1abc9c;
        background: transparent;
    }

    #awards-pagination .btn-primary {
        background: linear-gradient(135deg, #1abc9c, #16a085);
        border: none;
        color: white;
    }

    #awards-pagination .btn:hover:not(.btn-primary) {
        background: #f0f9f8;
    }

    /* MODAL */
    .modal-content {
        border-radius: 10px;
        border: none;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        background: linear-gradient(135deg, #1abc9c, #16a085);
        color: white;
        border: none;
        border-radius: 10px 10px 0 0;
        padding: 1.25rem;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .modal-title {
        font-weight: 700;
        font-size: 1.1rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-body .alert {
        border-radius: 6px;
        border: none;
        margin-bottom: 1rem;
    }

    .modal-footer {
        border-top: 1px solid #ecf0f1;
        padding: 1rem 1.5rem;
        gap: 0.5rem;
    }

    .modal-footer .btn {
        border-radius: 6px;
        font-weight: 600;
        padding: 0.6rem 1.2rem;
        font-size: 0.9rem;
    }

    /* RESPONSIVE */
    /* 1400px+ Desktop XL - 6 columnas */
    .col-xxl-2 {
        flex: 0 0 calc(16.666% - 0.75rem);
        max-width: calc(16.666% - 0.75rem);
    }

    /* 1200-1399px Desktop Large - 5 columnas */
    @media (max-width: 1399px) {
        .col-xxl-2 {
            flex: 0 0 calc(20% - 0.75rem);
            max-width: calc(20% - 0.75rem);
        }
    }

    /* 1024-1199px Laptop - 4 columnas */
    @media (max-width: 1200px) {
        .col-xxl-2 {
            flex: 0 0 calc(25% - 0.75rem);
            max-width: calc(25% - 0.75rem);
        }
        
        .col-xl-3 {
            flex: 0 0 calc(25% - 0.75rem);
            max-width: calc(25% - 0.75rem);
        }
    }

    /* 768-1023px Tablet - 3 columnas */
    @media (max-width: 992px) {
        .col-xxl-2,
        .col-xl-3 {
            flex: 0 0 calc(33.333% - 0.7rem);
            max-width: calc(33.333% - 0.7rem);
        }
        
        .col-lg-4 {
            flex: 0 0 calc(33.333% - 0.7rem);
            max-width: calc(33.333% - 0.7rem);
        }

        .awards-grid-container {
            max-height: 50vh;
        }
    }

    /* 576-767px Small Tablet - 2 columnas */
    @media (max-width: 768px) {
        #premis {
            padding: 2rem 0;
        }

        .section-title {
            font-size: 1.8rem;
        }

        .awards-controls {
            padding: 1rem;
        }

        .col-xxl-2,
        .col-xl-3,
        .col-lg-4,
        .col-md-6 {
            flex: 0 0 calc(50% - 0.6rem) !important;
            max-width: calc(50% - 0.6rem) !important;
        }

        .award-card-compact {
            margin-bottom: 0.5rem;
        }

        #recommended-section {
            margin-bottom: 1.5rem;
        }

        .awards-grid-container {
            max-height: 65vh;
            padding: 0.75rem;
        }
    }

    /* <576px Mobile - 2 columnas (más compacto) */
    @media (max-width: 576px) {
        #premis {
            padding: 1rem 0;
        }

        .section-title {
            font-size: 1.5rem;
            text-align: center;
        }

        .section-title:after {
            margin-left: auto;
            margin-right: auto;
        }

        .col-xxl-2,
        .col-xl-3,
        .col-lg-4,
        .col-md-6,
        .col-sm-6,
        .col-6 {
            flex: 0 0 calc(50% - 0.3rem) !important;
            max-width: calc(50% - 0.3rem) !important;
        }

        .award-content {
            padding: 0.6rem;
        }

        .award-img-box {
            height: 100px;
        }

        .award-name {
            font-size: 0.8rem;
        }

        .award-desc {
            font-size: 0.7rem;
            margin-bottom: 0.4rem;
        }

        .award-stats {
            font-size: 0.65rem;
            padding: 0.25rem;
            margin-bottom: 0.5rem;
        }

        .stat-item {
            gap: 0.1rem;
        }

        .points-badge {
            font-size: 0.7rem;
            padding: 0.2rem 0.4rem;
        }

        .award-card-compact .btn {
            font-size: 0.75rem;
            padding: 0.4rem;
        }

        #recommended-section h3 {
            font-size: 1.1rem;
        }

        .awards-controls .row {
            flex-direction: column;
        }

        .col-md-4 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }

        .awards-grid-container {
            max-height: 70vh;
            padding: 0.5rem;
        }
    }

    /* DARK MODE */
    .dark #premis {
        background: linear-gradient(135deg, #1a1a1a, #2d3436);
    }

    .dark .section-title {
        color: #ecf0f1;
    }

    .dark .award-card-compact,
    .dark .awards-controls,
    .dark #recommended-section {
        background: #2d3436;
        color: #ecf0f1;
    }

    .dark .award-name {
        color: #ecf0f1;
    }

    .dark .award-desc,
    .dark .stat-item {
        color: #bdc3c7;
    }

    .dark .award-stats {
        background: #34495e;
    }

    .dark .category-tag {
        background: rgba(44, 62, 80, 0.9);
    }

    .dark .modal-content {
        background: #2d3436;
        color: #ecf0f1;
    }

    .dark .modal-body {
        color: #ecf0f1;
    }

    .dark .modal-footer {
        border-top-color: #34495e;
    }

    .dark .awards-controls .form-select,
    .dark .awards-controls .form-control {
        background: #34495e;
        color: #ecf0f1;
        border-color: #34495e;
    }
</style>

<script>
    $(document).ready(function () {
        const userLoggedIn = @json(Auth::check());
        const userPoints = @json(Auth::check() ? Auth::user()->punts_actuals : 0);
        const awardsI18n = {
            easy: @json(__('messages.awards_ui.difficulty_easy')),
            medium: @json(__('messages.awards_ui.difficulty_medium')),
            hard: @json(__('messages.awards_ui.difficulty_hard')),
            redeem: @json(__('messages.awards_ui.redeem')),
            login: @json(__('messages.awards_ui.login')),
            stock: @json(__('messages.awards_ui.stock')),
            loading: @json(__('messages.awards_ui.loading')),
            errorLoading: @json(__('messages.awards_ui.error_loading')),
            noFilteredAwards: @json(__('messages.awards_ui.no_filtered_awards')),
            confirmRedeemTitle: @json(__('messages.awards_ui.confirm_redeem_title')),
            points: @json(__('messages.awards_ui.points')),
            youHavePointsTemplate: @json(__('messages.awards_ui.you_have_points')),
            afterRedeemTemplate: @json(__('messages.awards_ui.after_redeem')),
            confirmRedeemQuestion: @json(__('messages.awards_ui.confirm_redeem_question')),
            cancel: @json(__('messages.awards_ui.cancel')),
            confirm: @json(__('messages.awards_ui.confirm')),
            processing: @json(__('messages.awards_ui.processing')),
            redeemSuccess: @json(__('messages.awards_ui.redeem_success')),
            redeemError: @json(__('messages.awards_ui.redeem_error')),
        };
        
        // Helper function to safely escape HTML
        function escapeHtml(text) {
            if (!text) return '';
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;',
                '/': '&#x2F;'
            };
            return String(text).replace(/[&<>"'/]/g, char => map[char]);
        }

        // Mapeo de categorías
        const categoryMap = {
            11: 'electrònica',  // Tablet
            12: 'transport',     // Moto
            13: 'transport',     // Patinet
            14: 'transport',     // Bicicleta
            15: 'accessoris',    // Motxilla
            16: 'casa',          // Prova
            17: 'accessoris'     // Holas
        };

        // Variables
        let allAwards = [];
        let filteredAwards = [];
        const itemsPerPage = 12;
        let currentPage = 1;

        // Obtener categoría del premi
        function getAwardCategory(award) {
            // Usar directamente el campo categoria de la BD si existe
            if (award.categoria) {
                return award.categoria;
            }
            // Fallback al mapa hardcodeado para compatibilidad
            return categoryMap[award.id || award.objectID] || 'accessories';
        }

        // Obtener categoría icono
        function getCategoryIcon(category) {
            const icons = {
                'electrònica': 'fa-microchip',
                'esports': 'fa-dumbbell',
                'casa': 'fa-home',
                'transport': 'fa-bicycle',
                'accessoris': 'fa-shopping-bag'
            };
            return icons[category] || 'fa-gift';
        }

        // Calcular dificultad
        function getDifficulty(cost) {
            if (cost < 500) return { label: awardsI18n.easy, color: 'success', icon: '⭐' };
            if (cost < 2000) return { label: awardsI18n.medium, color: 'warning', icon: '⭐⭐' };
            return { label: awardsI18n.hard, color: 'danger', icon: '⭐⭐⭐' };
        }

        // Renderizar tarjeta de premi
        function renderAwardCard(award, isRecommended = false) {
            const awardId = award.id || award.objectID;
            const cost = award.cost || award.punts_requerits || 0;
            const category = getAwardCategory(award);
            const difficulty = getDifficulty(cost);
            const canBuy = userPoints >= cost;
            const pointsNeeded = Math.max(0, cost - userPoints);

            let actionHtml = '';
            if (userLoggedIn) {
                if (canBuy) {
                    actionHtml = `
                        <button type="button" class="btn btn-sm btn-success open-canje-btn" data-award='${JSON.stringify(award).replace(/'/g, "&apos;")}' style="width: 100%;">
                            <i class="fas fa-gift me-1"></i> ${escapeHtml(awardsI18n.redeem)}
                        </button>
                    `;
                } else {
                    actionHtml = `
                        <button type="button" class="btn btn-sm btn-secondary" disabled style="width: 100%;">
                            <i class="fas fa-lock me-1"></i> -${pointsNeeded}
                        </button>
                    `;
                }
            } else {
                actionHtml = `
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-success" style="width: 100%;">
                        <i class="fas fa-sign-in-alt me-1"></i> ${escapeHtml(awardsI18n.login)}
                    </a>
                `;
            }

            return `
                <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-sm-6 col-6">
                    <div class="award-card-compact ${isRecommended ? 'recommended' : ''}">
                        ${isRecommended ? '<span class="badge-star">⭐</span>' : ''}
                        
                        <div class="award-img-box">
                            <img src="${escapeHtml(award.imatge)}" alt="${escapeHtml(award.nom)}" class="award-img" onerror="this.src='https://via.placeholder.com/150?text=${encodeURIComponent(award.nom)}'">
                            <span class="category-tag"><i class="fas ${getCategoryIcon(category)}"></i></span>
                        </div>

                        <div class="award-content">
                            <div class="award-header">
                                <h6 class="award-name">${escapeHtml(award.nom)}</h6>
                                <span class="points-badge">${cost}</span>
                            </div>

                            <p class="award-desc">${escapeHtml(award.descripcio || '').substring(0, 45)}...</p>

                            <div class="award-stats">
                                <div class="stat-item">
                                    <i class="fas fa-box-open"></i>
                                    <span>${escapeHtml(awardsI18n.stock)}: ${award.stock || 10}</span>
                                </div>
                                <div class="stat-item">
                                    <i class="fas fa-hourglass-end"></i>
                                    <span>${award.temps_enviament || '3-5d'}</span>
                                </div>
                            </div>

                            <div class="award-difficulty">
                                <span class="diff-badge badge bg-${difficulty.color}">${difficulty.label}</span>
                            </div>

                            ${actionHtml}
                        </div>
                    </div>
                </div>
            `;
        }

        // Cargar premios desde Algolia
        function loadAllAwards() {
            $('#awards-grid').html(`<div class="col-12 text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">${escapeHtml(awardsI18n.loading)}</span></div></div>`);

            premisIndex.search('', { hitsPerPage: 100 }).then(({ hits }) => {
                allAwards = hits.map(h => ({
                    ...h,
                    // Asegurar que estos campos existan y tengan valor
                    stock: parseInt(h.stock) || 10,
                    temps_enviament: h.temps_enviament || '3-5 dies',
                    categoria: h.categoria || 'accessories',
                    rating: parseFloat(h.rating) || 4.5
                }));
                filteredAwards = [...allAwards];
                
                renderRecommendedAwards();
                applyFilters();
            }).catch(err => {
                console.error('Error loading awards:', err);
                $('#awards-grid').html(`<div class="col-12 text-center text-danger py-5">${escapeHtml(awardsI18n.errorLoading)}</div>`);
            });
        }

        // Renderizar premios recomendados
        function renderRecommendedAwards() {
            if (!userLoggedIn) {
                $('#recommended-section').hide();
                return;
            }

            // Obtener premios que el usuario puede comprar pronto (60-80% del coste)
            const recommended = allAwards
                .filter(a => {
                    const cost = a.cost || a.punts_requerits || 0;
                    return cost > userPoints && cost <= userPoints * 1.5;
                })
                .sort((a, b) => (a.cost || a.punts_requerits) - (b.cost || b.punts_requerits))
                .slice(0, 4);

            if (recommended.length === 0) {
                $('#recommended-section').hide();
                return;
            }

            $('#recommended-section').show();
            const html = recommended.map(award => renderAwardCard(award, true)).join('');
            $('#recommended-awards').html(`<div class="row g-3">${html}</div>`);
        }

        // Aplicar filtros
        function applyFilters() {
            const category = $('#category-filter').val();
            const minPoints = parseInt($('#points-min').val()) || 0;
            const maxPoints = parseInt($('#points-max').val()) || Infinity;
            const sort = $('#sort-filter').val();

            // Filtrar
            filteredAwards = allAwards.filter(award => {
                const cost = award.cost || award.punts_requerits || 0;
                const awardCategory = getAwardCategory(award);
                
                if (category && awardCategory !== category) return false;
                if (cost < minPoints || cost > maxPoints) return false;
                
                return true;
            });

            // Ordenar
            filteredAwards.sort((a, b) => {
                const costA = a.cost || a.punts_requerits || 0;
                const costB = b.cost || b.punts_requerits || 0;

                switch(sort) {
                    case 'name':
                        return (a.nom || '').localeCompare(b.nom || '');
                    case 'points-asc':
                        return costA - costB;
                    case 'points-desc':
                        return costB - costA;
                    case 'popular':
                        return (b.objectID || 0) - (a.objectID || 0);
                    default:
                        return 0;
                }
            });

            currentPage = 1;
            renderPaginatedAwards();
        }

        // Renderizar premios paginados
        function renderPaginatedAwards() {
            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const pageAwards = filteredAwards.slice(start, end);

            if (pageAwards.length === 0) {
                $('#awards-grid').html(`<div class="col-12 text-center py-5 text-muted">${escapeHtml(awardsI18n.noFilteredAwards)}</div>`);
                $('#awards-pagination').html('');
                return;
            }

            const html = pageAwards.map(award => renderAwardCard(award)).join('');
            $('#awards-grid').html(html);

            // Renderizar paginación
            const totalPages = Math.ceil(filteredAwards.length / itemsPerPage);
            if (totalPages > 1) {
                let paginationHtml = '';
                
                // Botón anterior
                if (currentPage > 1) {
                    paginationHtml += `<button class="btn btn-sm btn-outline-primary me-2" onclick="goToPage(${currentPage - 1})"><i class="fas fa-chevron-left"></i></button>`;
                }

                // Números de página
                for (let i = 1; i <= totalPages; i++) {
                    if (i === currentPage) {
                        paginationHtml += `<button class="btn btn-sm btn-primary me-2">${i}</button>`;
                    } else if (i <= 3 || i >= totalPages - 2 || Math.abs(i - currentPage) <= 1) {
                        paginationHtml += `<button class="btn btn-sm btn-outline-primary me-2" onclick="goToPage(${i})">${i}</button>`;
                    } else if (i === 4 || i === totalPages - 3) {
                        paginationHtml += `<span class="me-2">...</span>`;
                    }
                }

                // Botón siguiente
                if (currentPage < totalPages) {
                    paginationHtml += `<button class="btn btn-sm btn-outline-primary" onclick="goToPage(${currentPage + 1})"><i class="fas fa-chevron-right"></i></button>`;
                }

                $('#awards-pagination').html(paginationHtml);
            }

            // Reattach event listeners
            attachAwardCardListeners();
        }

        // Ir a página
        window.goToPage = function(page) {
            currentPage = page;
            renderPaginatedAwards();
            document.getElementById('awards-grid').scrollIntoView({ behavior: 'smooth' });
        };

        // Adjuntar event listeners a tarjetas
        function attachAwardCardListeners() {
            $('.open-canje-btn').off('click').on('click', function() {
                const awardData = $(this).data('award');
                openCanjeModal(awardData);
            });
        }

        // Abrir modal de canje
        function openCanjeModal(award) {
            const awardId = award.id || award.objectID;
            const cost = award.cost || award.punts_requerits;
            const remainingPoints = userPoints - cost;

            const csrfToken = window.getCsrfToken ? window.getCsrfToken() : '';
            const modalHtml = `
                <div class="modal fade" id="canjeModal-${awardId}" tabindex="-1" aria-hidden="true" style="z-index: 10001;">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">${escapeHtml(awardsI18n.confirmRedeemTitle)}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="d-flex align-items-center mb-4">
                                    <img src="${escapeHtml(award.imatge)}" alt="" style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px;" class="me-3">
                                    <div>
                                        <h6 class="mb-1">${escapeHtml(award.nom)}</h6>
                                        <span class="badge bg-success"><i class="fas fa-coins me-1"></i> ${cost} ${escapeHtml(awardsI18n.points)}</span>
                                    </div>
                                </div>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    ${escapeHtml(awardsI18n.youHavePointsTemplate.replace(':points', userPoints))} ${escapeHtml(awardsI18n.afterRedeemTemplate.replace(':points', remainingPoints))}
                                </div>
                                <p>${escapeHtml(awardsI18n.confirmRedeemQuestion)}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">${escapeHtml(awardsI18n.cancel)}</button>
                                <form id="canje-form-${awardId}" action="{{ url('/premis') }}/${awardId}/canjear" method="POST" style="display:inline;">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check me-1"></i>${escapeHtml(awardsI18n.confirm)}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            $('body').append(modalHtml);
            const modal = new bootstrap.Modal(document.getElementById(`canjeModal-${awardId}`), { backdrop: false });
            modal.show();

            $(`#canjeModal-${awardId}`).on('hidden.bs.modal', function() {
                $(this).remove();
            });

            $(`#canje-form-${awardId}`).on('submit', function(e) {
                e.preventDefault();
                const btn = $(this).find('button[type="submit"]');
                btn.prop('disabled', true).html(`<span class="spinner-border spinner-border-sm me-2" role="status"></span> ${escapeHtml(awardsI18n.processing)}`);

                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: new URLSearchParams(new FormData(this))
                })
                .then(r => r.json())
                .then(data => {
                    modal.hide();
                    showNotification('success', awardsI18n.redeemSuccess);
                    setTimeout(() => location.reload(), 1500);
                })
                .catch(error => {
                    showNotification('error', awardsI18n.redeemError);
                    btn.prop('disabled', false).html(`<i class="fas fa-check me-1"></i>${escapeHtml(awardsI18n.confirm)}`);
                });
            });
        }

        // Mostrar notificación
        function showNotification(type, message) {
            const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
            const notifyHtml = `
                <div class="alert ${bgClass} text-white position-fixed" style="top: 20px; left: 50%; transform: translateX(-50%); z-index: 10000; min-width: 300px;">
                    ${message}
                </div>
            `;
            $('body').append(notifyHtml);
            setTimeout(() => $('.alert.position-fixed').fadeOut().remove(), 3000);
        }

        // Event handlers para filtros
        $('#category-filter, #points-min, #points-max, #sort-filter').on('change', applyFilters);

        // Inicializar
        loadAllAwards();
    });
</script>