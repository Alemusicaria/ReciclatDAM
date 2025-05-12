<section id="events" class="py-4">
    <div class="">
        <h1 class="mb-3 fs-3">{{ __('Calendari d\'Events') }}</h1>

        <div class="row">
            <div class="col-md-8 mx-auto"> <!-- Cambiar de col-md-10 a col-md-8 para reducir el ancho -->
                <!-- Calendario -->
                <div class="calendar-container">
                    <div id="calendar-loader" class="calendar-loader">
                        <div class="calendar-spinner"></div>
                    </div>
                    <div id="calendar" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para detalles del evento -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true"
        style="z-index: 10001;">
        <div class="modal-dialog modal-md">
            <div class="modal-content" id="event-modal">
                <!-- Asegurar que el botón de cerrar funcione correctamente en el modal -->
                <div class="modal-header py-2">
                    <h5 class="modal-title fs-5" id="eventModalLabel">{{ __('Detalls de l\'Event') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3" id="event-details-content">
                    <!-- El contenido se cargará dinámicamente -->
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-sm btn-secondary"
                        data-bs-dismiss="modal">{{ __('Tancar') }}</button>
                    <button type="button" class="btn btn-sm btn-primary"
                        id="register-event-btn">{{ __('Registrar-me') }}</button>
                </div>
            </div>
        </div>
    </div>
</section>

<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css' rel='stylesheet' />
<style>
    /* Estilos para el contenedor del calendario */
    .calendar-container {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        padding: 15px;
        margin-bottom: 20px;
    }

    body.dark .calendar-container {
        background-color: #2d3748;
        color: #e2e8f0;
    }

    /* Estilos para eventos en el calendario */
    .fc-event {
        cursor: pointer;
        border-radius: 4px;
        padding: 2px;
    }
        /* Estilo específico para el botón "avui" (today) más pequeño */
    .fc-today-button {
        padding: 2px 8px !important;
        margin-left: 5px !important; /* Espacio pequeño después de los botones prev/next */
        width: 8vh !important; /* Dejar que el ancho se ajuste al contenido */
        height: 4.3vh !important;
        min-width: 50px !important; /* Establecer un ancho mínimo */
    }
    
    /* Ajustar el contenedor de botones a la izquierda para que estén juntos */
    .fc-header-toolbar .fc-left {
        display: flex !important;
        align-items: center !important;
        gap: 1px !important; /* Espacio mínimo entre botones */
    }
        
    /* Asegurar que los botones estén en línea */
    .fc-button-group {
        display: inline-flex !important;
        margin-right: 0 !important;
    }

    /* Estilos para el modal */

    #event-modal {
        width: 100%;
        margin-top: 20vh;
    }

    .event-img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 4px;
    }

    .event-details-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .event-details-list li {
        padding: 5px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 0.9rem;
    }

    body.dark .event-details-list li {
        border-bottom-color: #4a5568;
    }

    .event-details-list i {
        width: 20px;
        text-align: center;
        margin-right: 8px;
        color: #2e7d32;
    }

    body.dark .event-details-list i {
        color: #48bb78;
    }

    /* Loader para el calendario */
    .calendar-loader {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 200px;
    }

    .calendar-spinner {
        width: 30px;
        height: 30px;
        border: 3px solid rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        border-left-color: #2e7d32;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
        /* Estilos mejorados para el modo oscuro del calendario */
    body.dark .calendar-container {
        background-color: #1a202c;
        color: #e2e8f0;
        border: 1px solid #2d3748;
    }
    
    /* Encabezado y controles en modo oscuro */
    body.dark .fc-toolbar {
        color: #e2e8f0;
    }
    
    body.dark .fc-button-primary {
        background-color: #2d3748 !important;
        border-color: #4a5568 !important;
        color: #e2e8f0 !important;
    }
    
    body.dark .fc-button-primary:hover {
        background-color: #4a5568 !important;
        border-color: #4a5568 !important;
    }
    
    body.dark .fc-button-primary:disabled {
        background-color: #2d3748 !important;
        border-color: #4a5568 !important;
        opacity: 0.7;
    }
    
    body.dark .fc-button-active {
        background-color: #38a169 !important;
        border-color: #38a169 !important;
        color: white !important;
    }
    
    /* Celdas del calendario en modo oscuro */
    body.dark .fc-daygrid-day {
        background-color: #1a202c !important;
        border-color: #2d3748 !important;
    }
    
    body.dark .fc-col-header-cell {
        background-color: #2d3748 !important;
        border-color: #4a5568 !important;
        color: #e2e8f0;
    }
    
    body.dark .fc-day-today {
        background-color: rgba(56, 161, 105, 0.1) !important;
    }
    
    body.dark .fc-day-past {
        opacity: 0.7;
    }
    
    /* Números de día en modo oscuro */
    body.dark .fc-daygrid-day-number {
        color: #e2e8f0;
    }
    
    /* Eventos en modo oscuro */
    body.dark .fc-event {
        border: none !important;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }
    
    body.dark .fc-event-title {
        font-weight: 500;
    }
    
    body.dark .fc-list-day-cushion {
        background-color: #2d3748 !important;
    }
    
    body.dark .fc-list-event:hover td {
        background-color: #4a5568 !important;
    }
    
    body.dark .fc-list-event-title {
        color: #e2e8f0;
    }
    
    /* Texto "No hay eventos" en modo oscuro */
    body.dark .fc-list-empty {
        background-color: #1a202c !important;
        color: #a0aec0;
    }
    
    /* Otros elementos como popover */
    body.dark .fc-popover {
        background-color: #2d3748 !important;
        border-color: #4a5568 !important;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
    }
    
    body.dark .fc-popover-header {
        background-color: #4a5568 !important;
        color: #e2e8f0;
    }
    
    /* Para la semana y vista de tiempo */
    body.dark .fc-timegrid-slot {
        background-color: #1a202c !important;
        border-color: #2d3748 !important;
    }
    
    body.dark .fc-timegrid-axis {
        background-color: #2d3748 !important;
        color: #a0aec0;
    }
    
    body.dark .fc-timegrid-event {
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }
    
    /* Spinner del loader en modo oscuro */
    body.dark .calendar-spinner {
        border-color: rgba(255, 255, 255, 0.1);
        border-left-color: #48bb78;
    }
</style>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/locales-all.min.js'></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Utiliza los índices de Algolia ya inicializados en app.blade.php
        const eventsIndex = window.eventsIndex;
        const tipusEventsIndex = window.tipusEventsIndex;

        // Obtener los IDs de eventos en los que el usuario está registrado
        const userRegisteredEvents = @json($userEvents ?? []);
        // Cargar eventos
        loadEvents().then(() => {
            initCalendar();
        }).catch(error => {
            console.error('Error al cargar eventos:', error);
            document.getElementById('calendar-loader').innerHTML =
                '<div class="alert alert-danger">Error cargando eventos. Intenta recargar la página.</div>';
        });

        // Función para cargar eventos desde Algolia
        async function loadEvents() {
            try {
                // Asegúrate de obtener todos los campos relevantes
                const { hits } = await eventsIndex.search('', {
                    hitsPerPage: 100,
                    attributesToRetrieve: [
                        'id', 'nom', 'descripcio', 'data_inici', 'data_fi', 'lloc',
                        'tipus_color', 'tipus_nom', 'tipus_event_id', 'capacitat',
                        'punts_disponibles', 'imatge', 'participants_count', 'user_registered'
                    ]
                });

                window.calendarEvents = hits.map(event => {
                    return {
                        id: event.id,
                        title: event.nom,
                        start: event.data_inici,
                        end: event.data_fi || null,
                        color: event.tipus_color || '#3788d8',
                        allDay: !event.data_fi,
                        extendedProps: {
                            description: event.descripcio,
                            location: event.lloc,
                            tipus: event.tipus_nom,
                            tipus_id: event.tipus_event_id,
                            capacitat: event.capacitat,
                            punts: event.punts_disponibles,
                            imatge: event.imatge,
                            participants: event.participants_count || 0,
                            userRegistered: event.user_registered || false, // Nuevo campo
                            originalEvent: event
                        }
                    };
                });

                return window.calendarEvents;
            } catch (error) {
                console.error('Error cargando eventos:', error);
                throw error;
            }
        }



        // Inicializar el calendario
        function initCalendar() {
            const calendarEl = document.getElementById('calendar');

            // Ocultar loader y mostrar calendario
            document.getElementById('calendar-loader').style.display = 'none';
            document.getElementById('calendar').style.display = 'block';

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'ca',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listMonth'
                },
                events: window.calendarEvents || [],
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false,
                    hour12: false
                },
                eventClick: function (info) {
                    showEventDetails(info.event);
                },
                height: 'auto'
            });

            calendar.render();
        }

        // Función para mostrar detalles del evento
        function showEventDetails(event) {
            // Actualizar título del modal
            document.getElementById('eventModalLabel').textContent = event.title;

            // Formatear fechas
            const startDate = formatDate(event.start);
            const startTime = formatTime(event.start);
            const endTime = event.end ? formatTime(event.end) : '';

            // Crear contenido HTML para el modal
            const modalContent = `
                <div class="row g-2">
                    <div class="col-md-5">
                        <img src="${event.extendedProps.imatge ? 'images/events/' + event.extendedProps.imatge : '/images/event-default.jpg'}" 
                             alt="${event.title}" class="event-img mb-2">
                    </div>
                    <div class="col-md-7">
                        <ul class="event-details-list">
                            <li><i class="fas fa-calendar-alt"></i> ${startDate}</li>
                            <li><i class="fas fa-clock"></i> ${startTime} ${endTime ? ' - ' + endTime : ''}</li>
                            <li><i class="fas fa-map-marker-alt"></i> ${event.extendedProps.location || 'No especificat'}</li>
                            <li>
                                <i class="fas fa-tag"></i> 
                                <span class="badge" style="background-color: ${event.backgroundColor}">
                                    ${event.extendedProps.tipus || 'General'}
                                </span>
                            </li>
                            <li><i class="fas fa-users"></i> Capacitat: ${event.extendedProps.capacitat !== null ? event.extendedProps.capacitat : 'Il·limitada'}</li>
                            <li><i class="fas fa-coins"></i> ECODAMS: ${event.extendedProps.punts || 0}</li>
                        </ul>
                    </div>
                </div>
                
                <div class="mt-2">
                    <h6 class="mb-1">Descripció:</h6>
                    <p class="small mb-0">${event.extendedProps.description || 'Sense descripció'}</p>
                </div>
                
                <!-- Añadir un loading mientras verificamos el estado -->
                <div id="registration-status-loading" class="text-center mt-3">
                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                        <span class="visually-hidden">Verificant...</span>
                    </div>
                    <span class="ms-2">Verificant l'estat del registre...</span>
                </div>
            `;

            // Actualizar contenido del modal
            document.getElementById('event-details-content').innerHTML = modalContent;

            // Mostrar el modal antes de verificar el estado
            const modal = new bootstrap.Modal(document.getElementById('eventModal'));
            modal.show();

            // Configurar botón de registro (inicialmente deshabilitado mientras verificamos)
            const registerButton = document.getElementById('register-event-btn');
            registerButton.textContent = 'Verificant...';
            registerButton.disabled = true;

            @auth
                // Verificar el estado de registro en tiempo real con el servidor
                fetch(`/events/${event.id}/check-registration`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        // Ocultar el loading
                        document.getElementById('registration-status-loading').style.display = 'none';

                        const isRegistered = data.registered;
                        const isFull = data.full;

                        // Actualizar el estado en la memoria por si acaso
                        event.extendedProps.userRegistered = isRegistered;

                        if (isRegistered) {
                            registerButton.textContent = 'Ja estàs registrat';
                            registerButton.disabled = true;

                            // Añadir mensaje indicando que ya está registrado con más estilo
                            document.getElementById('event-details-content').insertAdjacentHTML('beforeend', data.html);
                        } else if (isFull) {
                            registerButton.textContent = 'Aforament complet';
                            registerButton.disabled = true;

                            // Mostrar mensaje de aforo completo
                            if (data.html) {
                                document.getElementById('event-details-content').insertAdjacentHTML('beforeend', data.html);
                            }
                        } else {
                            registerButton.textContent = 'Registrar-me';
                            registerButton.disabled = false;
                            registerButton.onclick = function () {
                                registerForEvent(event.id);
                            };
                        }
                    })
                    .catch(error => {
                        console.error('Error al verificar el registro:', error);
                        document.getElementById('registration-status-loading').style.display = 'none';
                        registerButton.textContent = 'Registrar-me';
                        registerButton.disabled = false;
                        registerButton.onclick = function () {
                            registerForEvent(event.id);
                        };
                    });
            @else
                // Ocultar el loading
                document.getElementById('registration-status-loading').style.display = 'none';

                // Si no está autenticado, redirigir al login
                registerButton.textContent = 'Inicia sessió per registrar-te';
                registerButton.onclick = function () {
                    window.location.href = "{{ route('login') }}?redirect=events";
                };
            @endauth
        }

        // Función para registrarse en un evento
        function registerForEvent(eventId) {
            @auth
                            // Mostrar indicador de carga
                            const registerButton = document.getElementById('register-event-btn');
                registerButton.textContent = 'Registrant...';
                registerButton.disabled = true;

                // Usar fetch para hacer la petición AJAX
                fetch(`/events/${eventId}/register`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                    .then(response => {
                        if (response.redirected) {
                            window.location.href = response.url;
                            return null;
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (!data) return; // Si hubo redirección

                        // Actualizar el botón
                        registerButton.textContent = data.registered ? 'Ja estàs registrat' : 'Registrar-me';
                        registerButton.disabled = data.registered || data.full;

                        // Añadir el HTML proporcionado por el backend
                        if (data.html) {
                            document.getElementById('event-details-content').insertAdjacentHTML('beforeend', data.html);
                        }

                        // Actualizar userRegistered en los datos del evento
                        if (data.registered) {
                            // Actualizar los datos en memoria
                            window.calendarEvents.forEach(calEvent => {
                                if (calEvent.id === eventId) {
                                    calEvent.extendedProps.userRegistered = true;
                                }
                            });

                            // Opcional: recargar la página después de 2 segundos
                            setTimeout(() => {
                                // location.reload();
                            }, 2000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        registerButton.textContent = 'Registrar-me';
                        registerButton.disabled = false;

                        // Mostrar mensaje de error integrado
                        const errorHtml = `
                                    <div class="alert alert-danger mt-2 small">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <i class="fas fa-exclamation-circle fa-2x text-danger"></i>
                                            </div>
                                            <div>
                                                <strong>Error!</strong> 
                                                <p class="mb-0">Hi ha hagut un error. Torna-ho a provar més tard.</p>
                                            </div>
                                        </div>
                                    </div>`;
                        document.getElementById('event-details-content').insertAdjacentHTML('beforeend', errorHtml);
                    });
            @else
                // Redirigir al login si no está autenticado
                window.location.href = "{{ route('login') }}?redirect=events";
            @endauth
        }

        // Funciones de utilidad para formatear fechas
        function formatDate(date) {
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            return date.toLocaleDateString('ca-ES', options);
        }

        function formatTime(date) {
            const options = { hour: '2-digit', minute: '2-digit' };
            return date.toLocaleTimeString('ca-ES', options);
        }
        // Reemplazar el manejo de cierre del modal
        document.querySelector('#eventModal .btn-close').addEventListener('click', function () {
            closeEventModal();
        });

        // También arreglar el botón de "Tancar"
        document.querySelector('#eventModal .btn-secondary').addEventListener('click', function () {
            closeEventModal();
        });

        // Función auxiliar para cerrar el modal
        function closeEventModal() {
            const modalElement = document.getElementById('eventModal');

            // Intentar diferentes métodos de cierre según la versión de Bootstrap
            try {
                // Bootstrap 5
                if (typeof bootstrap !== 'undefined' && typeof bootstrap.Modal !== 'undefined') {
                    const modal = bootstrap.Modal.getInstance(modalElement);
                    if (modal) {
                        modal.hide();
                        // Esperar a que termine la animación y luego limpiar
                        setTimeout(() => {
                            cleanupModalEffects();
                        }, 300);
                        return;
                    }
                }

                // Bootstrap 4 (jQuery)
                if (typeof $ !== 'undefined') {
                    $(modalElement).modal('hide');
                    setTimeout(() => {
                        cleanupModalEffects();
                    }, 300);
                    return;
                }

                // Si llegamos aquí, hacemos la limpieza manual directamente
                cleanupModalEffects();

            } catch (e) {
                console.error('Error al cerrar el modal:', e);
                cleanupModalEffects();
            }
        }

        // Función para limpiar completamente los efectos del modal
        function cleanupModalEffects() {
            // 1. Ocultar el modal manualmente
            const modalElement = document.getElementById('eventModal');
            modalElement.style.display = 'none';
            modalElement.classList.remove('show');
            modalElement.setAttribute('aria-hidden', 'true');
            modalElement.removeAttribute('aria-modal');
            modalElement.removeAttribute('role');

            // 2. Eliminar la clase modal-open del body
            document.body.classList.remove('modal-open');

            // 3. Eliminar estilos inline que Bootstrap puede haber añadido
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';

            // 4. Eliminar TODOS los backdrops
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(backdrop => {
                backdrop.classList.remove('show');
                setTimeout(() => {
                    backdrop.remove();
                }, 150);
            });

            // 5. Si hay múltiples backdrops, eliminarlos todos usando jQuery si está disponible
            if (typeof $ !== 'undefined') {
                $('.modal-backdrop').remove();
            }

            // 6. Crear un mensaje en la consola para confirmación
            console.log('Modal y backdrop eliminados manualmente');
        }
    });
</script>