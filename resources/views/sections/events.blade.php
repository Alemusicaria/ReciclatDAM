<section id="events" class="py-4">
    <div class="">
        <h1 class="mb-3 fs-3">{{ __('Calendari d\'Events') }}</h1>

        <div class="row">
            <div class="col-md-8 mx-auto">
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
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
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

            console.log('Modal y backdrop eliminados manualmente');
        }
    });
</script>