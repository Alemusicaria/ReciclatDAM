<section id="premis" class="text-center py-5">
    <h2 class="section-title mb-4">{{ __('messages.awards.title') }}</h2>
    <div class="row g-4">
        <!-- Card 1: Advanced Awards Gallery -->
        <div class="col-md-6">
            <div class="card shadow h-100 container">
                <div class="card-body">
                    <h3 class="card-title">{{ __('messages.awards.collection_title') }}</h3>
                    <p class="card-text text-muted mb-4">{{ __('messages.awards.collection_description') }}</p>

                    <!-- Professional Gallery -->
                    <div id="awards-gallery" class="awards-gallery">
                        <div class="gallery-inner">
                            <!-- Awards will be generated here -->
                        </div>

                        <!-- Just indicators, no arrows -->
                        <div class="gallery-indicators-container mt-4">
                            <div class="gallery-indicators">
                                <!-- Indicators will be generated here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Award Detail -->
        <div class="col-md-6">
            <div class="card shadow h-100 container">
                <div class="card-body d-flex flex-column">
                    <h3 class="card-title">{{ __('messages.awards.detail_title') }}</h3>
                    <div id="selected-award" class="text-center flex-grow-1 d-flex flex-column justify-content-center">
                        <div class="award-image-container mb-4">
                            <img id="selected-award-image" src="" alt="{{ __('messages.awards.selected_award_alt') }}"
                                class="img-fluid selected-award-image">
                        </div>
                        <h4 id="selected-award-name" class="mb-3"></h4>
                        <p id="selected-award-description" class="card-text"></p>
                        <div id="award-action-button-container"></div>
                        <div class="d-flex justify-content-center mt-auto pt-3">
                            <button id="prev-selected-award" class="btn">&larr;</button>
                            <button id="next-selected-award" class="btn">&rarr;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .section-title {
        font-weight: 700;
        margin-bottom: 2rem;
        position: relative;
        display: inline-block;
        color: #212529;
    }

    .section-title:after {
        content: '';
        display: block;
        width: 50px;
        height: 3px;
        background: #007bff;
        margin: 12px auto 0;
    }

    /* Card styling */
    .card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-title {
        font-weight: 600;
        margin-bottom: 1rem;
    }

    /* Gallery styling */
    .awards-gallery {
        position: relative;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .gallery-inner {
        display: flex;
        transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .gallery-page {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-gap: 15px;
        flex: 0 0 100%;
        padding: 0;
    }

    .award-card {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: all 0.3s ease;
        height: 160px;
        background-color: #fff;
        border: 3px solid transparent;
        /* Contorn inicial transparent */
    }

    .award-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .award-card:hover img {
        transform: scale(1.08);
    }

    .award-card:hover {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        /* Augmenta l'ombra al passar el ratolí */
    }

    .award-card.selected {
        border: 5px solid #2e7d32;
        /* Contorn verd clar */
        box-shadow: 0 0 10px rgba(46, 125, 50, 0.5);
        /* Ombra verda */
    }

    .award-card.selected img {
        transform: scale(1.05);
        /* Lleuger augment de la imatge */
    }

    .award-card:hover .award-overlay {
        opacity: 1;
        transform: translateY(0);
    }

    .award-card.selected .award-overlay {
        opacity: 1;
        transform: translateY(0);
        background: linear-gradient(0deg, #2e7d32 0%, rgba(0, 123, 255, 0) 100%);
    }

    /* Indicators styling */
    .gallery-indicators-container {
        display: flex;
        justify-content: center;
    }

    .gallery-indicators {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .gallery-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: #dee2e6;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .gallery-indicator:hover {
        background-color: #adb5bd;
    }

    .gallery-indicator.active {
        background-color: #2e7d32;
        transform: scale(1.2);
    }

    /* Selected award styling */
    .award-image-container {
        max-width: 300px;
        margin: 0 auto;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    #selected-award-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    #selected-award-image:hover {
        transform: scale(1.03);
    }

    #selected-award-name {
        font-weight: 600;
    }

    #selected-award-description {
        color: #6c757d;
        line-height: 1.6;
    }

    /* Buttons */
    .btn-outline-primary {
        border-width: 2px;
        font-weight: 500;
        padding: 8px 20px;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
    }

    .btn:focus {
        outline: none !important;
        box-shadow: none !important;
    }

    .premi {
        transition: all 0.5s ease;
        border: 5px solid transparent;
        border-radius: 15px;
        cursor: pointer;
    }

    .premi.selected {
        border-color: blue;
    }

    .premi img {
        width: 150px;
        /* Tamaño reducido */
        height: auto;
    }

    #prev-selected-award,
    #next-selected-award {
        color: #2e7d32;
        border-color: #2e7d32;
        width: 10rem;
        margin: 0 30px;
    }

    #prev-selected-award:hover,
    #next-selected-award:hover {
        background-color: #2e7d32;
        color: white;
        border-color: #2e7d32;
    }

    button#prev-selected-award:focus,
    button#next-selected-award:focus {
        outline: 0 !important;
        box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.5) !important;
    }
</style>

<script>
    $(document).ready(function () {
        const opinionsIndex = window.opinionsIndex; // Usa la variable global

        // Definir al inicio del script
        const userLoggedIn = {{ Auth::check() ? 'true' : 'false' }};

        // DOM elements
        const galleryInner = $('.gallery-inner');
        const galleryIndicators = $('.gallery-indicators');
        const selectedAwardImage = $('#selected-award-image');
        const selectedAwardName = $('#selected-award-name');
        const selectedAwardDescription = $('#selected-award-description');

        // Variables
        let awards = [];
        let currentAwardIndex = 0;
        let currentPage = 0;
        const awardsPerPage = 4; // 2x2 grid

        // Inicializar tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Fetch awards from Algolia
        function fetchAwards(query = '') {
            // Show loading state
            galleryInner.html('<div class="text-center w-100 py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');

            premisIndex.search(query, { hitsPerPage: 100 }).then(({ hits }) => {
                awards = hits;

                if (awards.length > 0) {
                    renderGallery();
                    updateSelectedAward(0);
                } else {
                    galleryInner.html('<p class="text-center w-100 py-4">{{ __("messages.awards.no_awards_found") }}</p>');
                    selectedAwardImage.attr('src', '');
                    selectedAwardName.text('{{ __("messages.awards.no_awards_available") }}');
                    selectedAwardDescription.text('{{ __("messages.awards.no_award_to_show") }}');
                }
            }).catch(err => {
                console.error('Error fetching awards:', err);
                galleryInner.html('<p class="text-center w-100 py-4 text-danger">{{ __("messages.awards.error_loading") }}</p>');
            });
        }

        // Render gallery
        function renderGallery() {
            galleryInner.empty();
            galleryIndicators.empty();

            const totalPages = Math.ceil(awards.length / awardsPerPage);

            // Create gallery pages
            for (let i = 0; i < totalPages; i++) {
                const pageStart = i * awardsPerPage;
                const pageEnd = Math.min(pageStart + awardsPerPage, awards.length);
                const pageAwards = awards.slice(pageStart, pageEnd);

                const page = $('<div class="gallery-page"></div>');

                pageAwards.forEach((award, premisIndex) => {
                    const globalIndex = pageStart + premisIndex;
                    const awardCard = $(`
                        <div class="award-card ${globalIndex === currentAwardIndex ? 'selected' : ''}" data-index="${globalIndex}">
                            <img src="${award.imatge}" alt="${award.nom}">
                            <div class="award-overlay">
                                <div class="award-name">${award.nom}</div>
                            </div>
                        </div>
                    `);

                    awardCard.on('click', function () {
                        updateSelectedAward(globalIndex);
                    });

                    page.append(awardCard);
                });

                // Fill empty slots if needed
                for (let j = pageAwards.length; j < awardsPerPage; j++) {
                    page.append('<div class="award-card empty" style="visibility: hidden;"></div>');
                }

                galleryInner.append(page);

                // Add indicator
                const indicator = $(`<div class="gallery-indicator ${i === currentPage ? 'active' : ''}" data-page="${i}"></div>`);
                indicator.on('click', function () {
                    goToPage(i);
                });
                galleryIndicators.append(indicator);
            }

            // Update gallery position
            updateGalleryPosition();
        }

        // Update gallery position
        function updateGalleryPosition() {
            galleryInner.css('transform', `translateX(-${currentPage * 100}%)`);
            $('.gallery-indicator').removeClass('active');
            $(`.gallery-indicator[data-page="${currentPage}"]`).addClass('active');
        }

        // Go to specific page
        function goToPage(page) {
            currentPage = page;
            updateGalleryPosition();
        }

        function updateSelectedAward(premisIndex) {
            if (premisIndex < 0 || premisIndex >= awards.length) return;

            currentAwardIndex = premisIndex;
            const award = awards[currentAwardIndex];

            // Definir awardId aquí para que esté disponible en toda la función
            let awardId;
            if (typeof award.id === 'string' && award.id.includes('::')) {
                awardId = award.id.split('::').pop();
            } else {
                awardId = award.id || award.objectID;
            }

            // Animate transition
            $('#selected-award').fadeOut(200, function () {
                selectedAwardImage.attr('src', award.imatge);
                selectedAwardName.text(award.nom);
                selectedAwardDescription.text(award.descripcio);

                // Añadir botón de canje
                let actionButtonHtml = '';

                if (userLoggedIn) {
                    const userPoints = {{ Auth::check() ? Auth::user()->punts_actuals : 0 }};
                    const cost = award.cost || award.punts_requerits;

                    if (userPoints >= cost) {
                        actionButtonHtml = `
                            <button type="button" class="btn btn-success w-100 mt-3" id="open-modal-btn-${awardId}">
                                <i class="fas fa-gift me-2"></i> Bescanviar per ${cost} punts
                            </button>
                        `;
                    } else {
                        const pointsNeeded = cost - userPoints;
                        actionButtonHtml = `
                            <button type="button" class="btn btn-secondary w-100 mt-3" disabled data-bs-toggle="tooltip" 
                                    title="Necessites ${pointsNeeded} punts més per bescanviar aquest premi">
                                <i class="fas fa-lock me-2"></i> Necessites ${cost} punts
                            </button>
                            <small class="d-block text-muted mt-2 text-center">
                                Et falten ${pointsNeeded} punts més
                            </small>
                        `;
                    }
                } else {
                    actionButtonHtml = `
                        <a href="{{ route('login') }}" class="btn btn-outline-success w-100 mt-3">
                            <i class="fas fa-sign-in-alt me-2"></i> Inicia sessió per bescanviar
                        </a>
                    `;
                }

                // Añadir el botón después de la descripción
                $('#award-action-button-container').html(actionButtonHtml);

                // Mostrar el elemento que estaba oculto
                $(this).fadeIn(200);

                // Ahora es seguro añadir event listeners porque awardId está en alcance
                if (userLoggedIn) {
                    $(`#open-modal-btn-${awardId}`).on('click', function () {
                        updateCanjeModal(award, awardId);  // Pasar awardId como argumento
                        $(`#canjeModal-${awardId}`).modal('show');
                    });
                }
            });

            // Navigate to correct page in gallery
            const targetPage = Math.floor(currentAwardIndex / awardsPerPage);
            if (targetPage !== currentPage) {
                goToPage(targetPage);
            }

            // Update selected state in gallery
            $('.award-card').removeClass('selected');
            $(`.award-card[data-index="${currentAwardIndex}"]`).addClass('selected');
        }

        // Modificar también la función updateCanjeModal para recibir awardId
        function updateCanjeModal(award, awardId) {
            // Si no recibimos awardId, lo calculamos
            if (!awardId) {
                if (typeof award.id === 'string' && award.id.includes('::')) {
                    awardId = award.id.split('::').pop();
                } else {
                    awardId = award.id || award.objectID;
                }
            }
            console.log('ID limpio para el modal:', awardId);

            // Eliminar modales anteriores de forma segura
            try {
                // Eliminar todos los modales existentes
                $('[id^="canjeModal-"]').each(function () {
                    $(this).remove();
                });
            } catch (error) {
                console.error('Error al eliminar modales anteriores:', error);
            }

            // Solo crear modal si el usuario está logeado
            if (!userLoggedIn) return;

            const userPoints = {{ Auth::check() ? Auth::user()->punts_actuals : 0 }};
            const cost = award.cost || award.punts_requerits;
            const remainingPoints = userPoints - cost;

            // Obtener el token CSRF de la página
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Crear el modal COMPLETO
            const modalHtml = `
                <div class="modal fade" id="canjeModal-${awardId}" tabindex="-1" aria-labelledby="canjeModalLabel-${awardId}" aria-hidden="true" style="z-index: 10001;">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="canjeModalLabel-${awardId}">Confirmar bescanvi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="d-flex align-items-center mb-4">
                                    ${award.imatge ?
                    `<img src="${award.imatge}" alt="${award.nom}" 
                                                                class="me-3" style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px;">` :
                    `<div class="bg-light d-flex align-items-center justify-content-center me-3" 
                                                                style="width: 70px; height: 70px; border-radius: 8px;">
                                                                <i class="fas fa-gift fa-2x text-secondary"></i>
                                                            </div>`
                }
                                    <div>
                                        <h6 class="mb-1">${award.nom}</h6>
                                        <span class="badge bg-success">
                                            <i class="fas fa-coins me-1"></i> ${cost} punts
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Tens actualment <strong>${userPoints}</strong> punts.
                                    Després d'aquest bescanvi, et quedaran <strong>${remainingPoints}</strong> punts.
                                </div>
                                
                                <p>Estàs segur que vols bescanviar els teus punts per aquest premi?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel·lar</button>
                                    <form id="canje-form-${awardId}" action="{{ url('/premis') }}/${awardId}/canjear" method="POST">
                                        <input type="hidden" name="_token" value="${csrfToken}">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check me-1"></i> Confirmar bescanvi
                                        </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            $('body').append(modalHtml);

            // AÑADIR ESTA LÍNEA: Mostrar el modal después de crearlo
            $(`#canjeModal-${awardId}`).modal('show');

            // Verificar que el formulario existe y está configurado correctamente
            console.log('Formulario en modal:', $(`#canjeModal-${awardId} form`).length > 0 ? 'Encontrado' : 'No encontrado');
            // Agrega este código para manejar el envío del formulario
            $(`#canje-form-${awardId}`).on('submit', function (e) {
                e.preventDefault(); // Prevenir el envío normal del formulario

                // Deshabilitar el botón y mostrar spinner de carga
                const submitBtn = $(this).find('button[type="submit"]');
                submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Processant...');

                // Enviar la solicitud usando fetch (más moderno que $.ajax)
                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: new URLSearchParams(new FormData(this))
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la resposta del servidor');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Cerrar el modal
                        $(`#canjeModal-${awardId}`).modal('hide');

                        // Mostrar notificación de éxito
                        showNotification('success', 'Premi bescanviat amb èxit!');

                        if (data.punts_actuals !== undefined) {
                            // Buscar el elemento que contiene los puntos en el navbar
                            const userNavElement = document.querySelector('.navbar-nav .dropdown-toggle span');
                            if (userNavElement) {
                                // El formato actual es "Nombre (X ECODAMS)"
                                // Extraer ese texto y reemplazar los puntos manteniendo el formato
                                const currentText = userNavElement.textContent;
                                const newText = currentText.replace(/\(\d+/, `(${data.punts_actuals}`);
                                userNavElement.textContent = newText;
                            }
                        }

                        // Recargar los premios
                        setTimeout(() => {
                            fetchAwards(); // Recargar la galería para reflejar cambios
                        }, 500);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('error', 'Error al bescanviar el premi. Torna-ho a intentar més tard.');

                        // Reactivar el botón
                        submitBtn.prop('disabled', false).html('<i class="fas fa-check me-1"></i> Confirmar bescanvi');
                    });
            });

        }

        // Navigate to previous award
        function prevAward() {
            if (currentAwardIndex > 0) {
                updateSelectedAward(currentAwardIndex - 1);
            } else {
                updateSelectedAward(awards.length - 1); // Loop to last
            }
        }

        // Navigate to next award
        function nextAward() {
            if (currentAwardIndex < awards.length - 1) {
                updateSelectedAward(currentAwardIndex + 1);
            } else {
                updateSelectedAward(0); // Loop to first
            }
        }

        // Event handlers for indicators
        $(document).on('click', '.gallery-indicator', function () {
            const page = $(this).data('page');
            goToPage(page);
        });

        // Event handlers for navigation buttons
        $('#prev-selected-award').on('click', prevAward);
        $('#next-selected-award').on('click', nextAward);

        // Handle keyboard navigation
        $(document).keydown(function (e) {
            if (e.keyCode === 37) { // Left arrow
                prevAward();
            } else if (e.keyCode === 39) { // Right arrow
                nextAward();
            }
        });

        // Auto-rotate gallery (optional)
        let autoRotateInterval;

        function startAutoRotate() {
            stopAutoRotate();
            autoRotateInterval = setInterval(function () {
                nextAward();
            }, 5000);
        }

        function stopAutoRotate() {
            if (autoRotateInterval) {
                clearInterval(autoRotateInterval);
            }
        }

        // Stop auto-rotate on user interaction
        $('.gallery-inner, .gallery-indicators').on('mouseenter', stopAutoRotate);
        $('.gallery-inner, .gallery-indicators').on('mouseleave', startAutoRotate);

        // Initialize
        fetchAwards();
        startAutoRotate();

        // Función para mostrar notificaciones
        function showNotification(type, message) {
            // Crear el elemento de notificación
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed`;
            notification.style.top = '20px';
            notification.style.left = '50%';
            notification.style.transform = 'translateX(-50%)';
            notification.style.zIndex = '9999';
            notification.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
            notification.style.minWidth = '300px';
            notification.innerHTML = message;

            // Añadir al DOM
            document.body.appendChild(notification);

            // Eliminar después de 3 segundos
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    });
</script>