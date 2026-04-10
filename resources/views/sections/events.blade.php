<section id="events" class="py-4">
    <div class="">
        <h1 class="mb-3 fs-3">{{ __('messages.events_ui.calendar_title') }}</h1>

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
    <div class="modal" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content" id="event-modal">
                <!-- Asegurar que el botón de cerrar funcione correctamente en el modal -->
                <div class="modal-header py-2">
                    <h5 class="modal-title fs-5" id="eventModalLabel">{{ __('messages.events_ui.details_title') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3" id="event-details-content">
                    <!-- El contenido se cargará dinámicamente -->
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-sm btn-secondary"
                        data-bs-dismiss="modal">{{ __('messages.events_ui.close') }}</button>
                    <button type="button" class="btn btn-sm btn-primary"
                        id="register-event-btn">{{ __('messages.events_ui.register') }}</button>
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
        const appLocale = @json(app()->getLocale());
        const eventCheckRegistrationUrlTemplate = @json(route('events.checkRegistration', ['id' => '__EVENT_ID__']));
        const eventRegisterUrlTemplate = @json(route('events.register', ['id' => '__EVENT_ID__']));
        const calendarLocaleMap = { ca: 'ca', es: 'es', en: 'en' };
        const dateLocaleMap = { ca: 'ca-ES', es: 'es-ES', en: 'en-GB' };
        const calendarLocale = calendarLocaleMap[appLocale] || 'en';
        const browserLocale = dateLocaleMap[calendarLocale] || 'en-GB';

        const i18n = {
            serverResponseError: @json(__('messages.events_ui.server_response_error')),
            loadError: @json(__('messages.events_ui.load_error')),
            notSpecified: @json(__('messages.events_ui.not_specified')),
            general: @json(__('messages.events_ui.general')),
            capacity: @json(__('messages.events_ui.capacity')),
            unlimited: @json(__('messages.events_ui.unlimited')),
            description: @json(__('messages.events_ui.description')),
            noDescription: @json(__('messages.events_ui.no_description')),
            checking: @json(__('messages.events_ui.checking')),
            checkingRegistration: @json(__('messages.events_ui.checking_registration')),
            eventFinished: @json(__('messages.events_ui.event_finished')),
            eventFinishedMessage: @json(__('messages.events_ui.event_finished_message')),
            alreadyRegistered: @json(__('messages.events_ui.already_registered')),
            fullCapacity: @json(__('messages.events_ui.full_capacity')),
            loginToRegister: @json(__('messages.events_ui.login_to_register')),
            register: @json(__('messages.events_ui.register')),
            registering: @json(__('messages.events_ui.registering')),
            retryLaterError: @json(__('messages.events_ui.retry_later_error')),
            today: @json(__('messages.events_ui.today')),
            month: @json(__('messages.events_ui.month')),
            googleCalendar: @json(__('messages.events_ui.google_calendar')),
            iphoneCalendar: @json(__('messages.events_ui.iphone_calendar'))
        };

        function buildEventUrl(template, eventId) {
            return template.replace('__EVENT_ID__', encodeURIComponent(String(eventId)));
        }

        // Helper function to safely escape HTML in JavaScript
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

        function buildEventPlaceholderImage(title, tipus) {
            const safeTitle = String(title || 'Event').trim();
            const safeTipus = String(tipus || i18n.general).trim();
            const initials = safeTitle
                .split(/\s+/)
                .slice(0, 2)
                .map(word => (word[0] || '').toUpperCase())
                .join('') || 'EV';

            const splitLines = (text, maxCharsPerLine = 24, maxLines = 4) => {
                const words = String(text || '').split(/\s+/).filter(Boolean);
                const lines = [];
                let currentLine = '';

                words.forEach(word => {
                    const candidate = currentLine ? `${currentLine} ${word}` : word;
                    if (candidate.length <= maxCharsPerLine) {
                        currentLine = candidate;
                        return;
                    }

                    if (currentLine) {
                        lines.push(currentLine);
                    }

                    currentLine = word;
                });

                if (currentLine) {
                    lines.push(currentLine);
                }

                if (lines.length > maxLines) {
                    const trimmed = lines.slice(0, maxLines);
                    const last = trimmed[maxLines - 1];
                    trimmed[maxLines - 1] = `${last.slice(0, Math.max(0, maxCharsPerLine - 1))}…`;
                    return trimmed;
                }

                return lines;
            };

            const titleLines = splitLines(safeTitle, 24, 4);
            const baseY = 620;
            const lineHeight = 80;
            const titleSvg = titleLines
                .map((line, i) => `<text x="90" y="${baseY + (i * lineHeight)}" fill="#ffffffee" font-family="Arial, sans-serif" font-size="68" font-weight="600">${escapeHtml(line)}</text>`)
                .join('');

            const svg = `
                <svg xmlns="http://www.w3.org/2000/svg" width="1080" height="1080" viewBox="0 0 1080 1080">
                    <defs>
                        <linearGradient id="g" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0%" stop-color="#1b5e20"/>
                            <stop offset="100%" stop-color="#2e7d32"/>
                        </linearGradient>
                    </defs>
                    <rect width="1080" height="1080" fill="url(#g)"/>
                    <circle cx="950" cy="130" r="170" fill="#ffffff22"/>
                    <circle cx="120" cy="980" r="220" fill="#ffffff18"/>
                    <text x="90" y="140" fill="#ffffffcc" font-family="Arial, sans-serif" font-size="66" font-weight="700">${escapeHtml(safeTipus)}</text>
                    <text x="90" y="340" fill="#ffffff" font-family="Arial, sans-serif" font-size="220" font-weight="800">${escapeHtml(initials)}</text>
                    ${titleSvg}
                </svg>`;

            return `data:image/svg+xml;charset=UTF-8,${encodeURIComponent(svg)}`;
        }

        // Obtener los IDs de eventos en los que el usuario está registrado
        const userRegisteredEvents = @json($userEvents ?? []);
        // Inicializar calendario (los eventos se cargan dinámicamente por rango)
        initCalendar();
            const parseJsonResponse = async (response, defaultMessage = i18n.serverResponseError) => {
                const payload = await response.json().catch(() => null);

                if (!response.ok) {
                    throw new Error((payload && payload.message) || defaultMessage);
                }

                return payload;
            };

        function getCalendarEventById(eventId) {
            const numericId = Number(eventId);
            return (window.calendarEvents || []).find(calEvent => Number(calEvent.id) === numericId) || null;
        }

        function toCalendarUtc(date) {
            if (!date) return '';
            return new Date(date).toISOString().replace(/[-:]/g, '').replace(/\.\d{3}Z$/, 'Z');
        }

        function escapeIcsText(text) {
            return String(text || '')
                .replace(/\\/g, '\\\\')
                .replace(/;/g, '\\;')
                .replace(/,/g, '\\,')
                .replace(/\r?\n/g, '\\n');
        }

        function slugifyFileName(text) {
            return String(text || 'event')
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '')
                .slice(0, 80) || 'event';
        }

        function formatFileDate(date) {
            if (!date) return 'sense-data';
            const d = new Date(date);
            const y = d.getFullYear();
            const m = String(d.getMonth() + 1).padStart(2, '0');
            const day = String(d.getDate()).padStart(2, '0');
            return `${y}-${m}-${day}`;
        }

        function getEventRangeForCalendar(calendarEvent) {
            const start = calendarEvent && calendarEvent.start ? new Date(calendarEvent.start) : null;
            if (!start) return { start: null, end: null };

            const end = calendarEvent.end
                ? new Date(calendarEvent.end)
                : new Date(start.getTime() + (60 * 60 * 1000));

            return { start, end };
        }

        function buildGoogleCalendarUrl(calendarEvent) {
            const { start, end } = getEventRangeForCalendar(calendarEvent);
            if (!start || !end) return '';

            const params = new URLSearchParams({
                action: 'TEMPLATE',
                text: calendarEvent.title || 'Event',
                dates: `${toCalendarUtc(start)}/${toCalendarUtc(end)}`,
                details: calendarEvent.extendedProps?.description || '',
                location: calendarEvent.extendedProps?.location || ''
            });

            return `https://calendar.google.com/calendar/render?${params.toString()}`;
        }

        function downloadIcs(calendarEvent) {
            const { start, end } = getEventRangeForCalendar(calendarEvent);
            if (!start || !end) return;

            const ics = [
                'BEGIN:VCALENDAR',
                'VERSION:2.0',
                'PRODID:-//ReciclatDAM//Events//CA',
                'CALSCALE:GREGORIAN',
                'BEGIN:VEVENT',
                `UID:event-${calendarEvent.id || Date.now()}@reciclatdam`,
                `DTSTAMP:${toCalendarUtc(new Date())}`,
                `DTSTART:${toCalendarUtc(start)}`,
                `DTEND:${toCalendarUtc(end)}`,
                `SUMMARY:${escapeIcsText(calendarEvent.title || 'Event')}`,
                `DESCRIPTION:${escapeIcsText(calendarEvent.extendedProps?.description || '')}`,
                `LOCATION:${escapeIcsText(calendarEvent.extendedProps?.location || '')}`,
                'END:VEVENT',
                'END:VCALENDAR'
            ].join('\r\n');

            const blob = new Blob([ics], { type: 'text/calendar;charset=utf-8' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            const fileName = `${slugifyFileName(calendarEvent.title)}-${formatFileDate(start)}.ics`;
            link.download = fileName;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
        }

        function renderCalendarButtons(eventId) {
            const calendarEvent = getCalendarEventById(eventId);
            if (!calendarEvent) return;

            const detailsContainer = document.getElementById('event-details-content');
            if (!detailsContainer) return;

            const previousContainer = document.getElementById('calendar-actions-container');
            if (previousContainer) {
                previousContainer.remove();
            }

            detailsContainer.insertAdjacentHTML('beforeend', `
                <div id="calendar-actions-container" class="calendar-actions-container mt-3">
                    <a href="${buildGoogleCalendarUrl(calendarEvent)}" target="_blank" rel="noopener noreferrer" class="btn btn-sm calendar-action-btn calendar-action-btn-google text-nowrap">
                        <i class="fas fa-calendar-plus me-1"></i>${escapeHtml(i18n.googleCalendar)}
                    </a>
                    <button type="button" id="iphone-calendar-btn" class="btn btn-sm calendar-action-btn calendar-action-btn-iphone text-nowrap">
                        <i class="fas fa-mobile-alt me-1"></i>${escapeHtml(i18n.iphoneCalendar)}
                    </button>
                </div>
            `);

            const iphoneButton = document.getElementById('iphone-calendar-btn');
            if (iphoneButton) {
                iphoneButton.addEventListener('click', function () {
                    downloadIcs(calendarEvent);
                });
            }
        }

        // Cargar eventos des de backend per evitar desajustos amb l'index extern
        async function loadEvents(startDate = null, endDate = null, limit = null, upcoming = false) {
            try {
                const params = new URLSearchParams();
                if (upcoming) {
                    params.set('upcoming', '1');
                } else {
                    if (startDate) params.set('start', startDate);
                    if (endDate) params.set('end', endDate);
                }
                if (limit && Number(limit) > 0) params.set('limit', String(limit));

                const response = await fetch(`{{ route('events.getEvents') }}?${params.toString()}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const events = await parseJsonResponse(response, i18n.loadError);

                window.calendarEvents = events.map(event => {
                    const ext = event.extendedProps || {};
                    return {
                        id: event.id,
                        title: event.title,
                        start: event.start,
                        end: event.end || null,
                        color: event.color || '#3788d8',
                        allDay: !event.end,
                        extendedProps: {
                            description: event.description,
                            location: event.location,
                            tipus: ext.tipus,
                            capacitat: ext.capacitat,
                            punts: ext.punts_disponibles,
                            imatge: ext.imatge,
                            participants: ext.participants || 0,
                            userRegistered: Array.isArray(userRegisteredEvents)
                                ? userRegisteredEvents.includes(Number(event.id))
                                : false
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
            let calendar;

            const syncMonthReferenceHeight = () => {
                requestAnimationFrame(() => {
                    const harness = calendarEl.querySelector('.fc-view-harness');
                    if (!harness) {
                        return;
                    }

                    const currentHeight = Math.ceil(harness.getBoundingClientRect().height);
                    const currentCalendarHeight = Math.ceil(calendarEl.getBoundingClientRect().height);
                    if (!currentHeight) {
                        return;
                    }

                    if (calendar.view.type === 'dayGridMonth') {
                        calendarEl.style.setProperty('--month-view-height', `${currentHeight}px`);
                        if (currentCalendarHeight) {
                            calendarEl.style.setProperty('--month-calendar-height', `${currentCalendarHeight}px`);
                        }
                        return;
                    }

                    const savedHeight = getComputedStyle(calendarEl).getPropertyValue('--month-view-height').trim();
                    const savedCalendarHeight = getComputedStyle(calendarEl).getPropertyValue('--month-calendar-height').trim();
                    if (!savedHeight) {
                        calendarEl.style.setProperty('--month-view-height', `${currentHeight}px`);
                    }
                    if (!savedCalendarHeight && currentCalendarHeight) {
                        calendarEl.style.setProperty('--month-calendar-height', `${currentCalendarHeight}px`);
                    }
                });
            };

            // Ocultar loader y mostrar calendario
            document.getElementById('calendar-loader').style.display = 'none';
            document.getElementById('calendar').style.display = 'block';

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: calendarLocale,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth'
                },
                buttonText: {
                    today: i18n.today,
                    month: i18n.month
                },
                events: function (fetchInfo, successCallback, failureCallback) {
                    loadEvents(fetchInfo.startStr, fetchInfo.endStr)
                        .then(events => successCallback(events))
                        .catch(error => {
                            console.error('Error cargando eventos del calendario:', error);
                            failureCallback(error);
                        });
                },
                nowIndicator: true,
                height: 'auto',
                expandRows: true,
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false,
                    hour12: false
                },
                eventClick: function (info) {
                    showEventDetails(info.event);
                },
                datesSet: function () {
                    syncMonthReferenceHeight();
                    requestAnimationFrame(() => calendar.updateSize());
                }
            });

            calendar.render();
            syncMonthReferenceHeight();

            window.addEventListener('resize', function () {
                if (calendar && calendar.view && calendar.view.type === 'dayGridMonth') {
                    syncMonthReferenceHeight();
                }
            });
        }

        // Función para mostrar detalles del evento
        function showEventDetails(event) {
            // Actualizar título del modal
            document.getElementById('eventModalLabel').textContent = event.title;

            const imagePath = event.extendedProps.imatge
                ? `images/events/${event.extendedProps.imatge}`
                : '';
            const placeholderImage = buildEventPlaceholderImage(event.title, event.extendedProps.tipus || 'General');
            const imageSrc = imagePath || placeholderImage;
            const isPlaceholder = !imagePath;
            const imageStyle = isPlaceholder ? 'object-fit: contain; background-color: #1b5e20; padding: 6px;' : '';

            // Formatear fechas
            const startDate = formatDate(event.start);
            const startTime = formatTime(event.start);
            const endTime = event.end ? formatTime(event.end) : '';

            // Crear contenido HTML para el modal
            const modalContent = `
                <div class="row g-2">
                    <div class="col-md-5">
                            <img src="${imageSrc}"
                                style="${imageStyle}"
                                onerror="this.onerror=null;this.src='${placeholderImage}';this.style.objectFit='contain';this.style.backgroundColor='#1b5e20';this.style.padding='6px';"
                             alt="${escapeHtml(event.title)}" class="event-img mb-2">
                    </div>
                    <div class="col-md-7">
                        <ul class="event-details-list">
                            <li><i class="fas fa-calendar-alt"></i> ${startDate}</li>
                            <li><i class="fas fa-clock"></i> ${startTime} ${endTime ? ' - ' + endTime : ''}</li>
                            <li><i class="fas fa-map-marker-alt"></i> ${event.extendedProps.location || i18n.notSpecified}</li>
                            <li>
                                <i class="fas fa-tag"></i> 
                                <span class="badge" style="background-color: ${event.backgroundColor}">
                                    ${escapeHtml(event.extendedProps.tipus || i18n.general)}
                                </span>
                            </li>
                            <li><i class="fas fa-users"></i> ${i18n.capacity}: ${event.extendedProps.capacitat !== null ? event.extendedProps.capacitat : i18n.unlimited}</li>
                            <li><i class="fas fa-coins"></i> ECODAMS: ${event.extendedProps.punts || 0}</li>
                        </ul>
                    </div>
                </div>
                
                <div class="mt-2">
                    <h6 class="mb-1">${i18n.description}:</h6>
                    <p class="small mb-0">${escapeHtml(event.extendedProps.description || i18n.noDescription)}</p>
                </div>
                
                <!-- Añadir un loading mientras verificamos el estado -->
                <div id="registration-status-loading" class="text-center mt-3">
                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                        <span class="visually-hidden">${i18n.checking}</span>
                    </div>
                    <span class="ms-2">${i18n.checkingRegistration}</span>
                </div>
            `;

            // Actualizar contenido del modal
            document.getElementById('event-details-content').innerHTML = modalContent;

            // Mostrar el modal antes de verificar el estado
            const eventModalElement = document.getElementById('eventModal');
            const modal = new bootstrap.Modal(eventModalElement, {
                backdrop: false
            });
            modal.show();

            // Permitir cerrar el modal al hacer clic fuera de él
            eventModalElement.addEventListener('click', function (e) {
                // Si el clic es en el modal mismo (no en el contenido), cerrar
                if (e.target === eventModalElement) {
                    modal.hide();
                }
            });

            // Configurar botón de registro (inicialmente deshabilitado mientras verificamos)
            const registerButton = document.getElementById('register-event-btn');
            registerButton.textContent = i18n.checking;
            registerButton.disabled = true;

            const eventStart = event.start ? new Date(event.start) : null;
            const now = new Date();
            const isPastEvent = eventStart ? eventStart < now : false;

            if (isPastEvent) {
                document.getElementById('registration-status-loading').style.display = 'none';
                registerButton.textContent = i18n.eventFinished;
                registerButton.disabled = true;
                document.getElementById('event-details-content').insertAdjacentHTML('beforeend', `
                    <div class="alert alert-info mt-2 small mb-0">
                        ${i18n.eventFinishedMessage}
                    </div>
                `);
                return;
            }

            @auth
                // Verificar el estado de registro en tiempo real con el servidor
                fetch(buildEventUrl(eventCheckRegistrationUrlTemplate, event.id), {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                    .then(response => {
                        if (response.redirected || response.status === 401) {
                            window.location.href = "{{ route('login') }}?redirect=events";
                            return null;
                        }

                            return parseJsonResponse(response);
                    })
                    .then(data => {
                        if (!data) {
                            return;
                        }

                        // Ocultar el loading
                        document.getElementById('registration-status-loading').style.display = 'none';

                        const isRegistered = data.registered;
                        const isFull = data.full;
                        const isPast = data.past;

                        // Actualizar el estado en la memoria por si acaso
                        event.extendedProps.userRegistered = isRegistered;

                        if (isPast) {
                            registerButton.textContent = i18n.eventFinished;
                            registerButton.disabled = true;

                            if (data.html) {
                                document.getElementById('event-details-content').insertAdjacentHTML('beforeend', data.html);
                            }
                        } else if (isRegistered) {
                            registerButton.textContent = i18n.alreadyRegistered;
                            registerButton.disabled = true;

                            // Añadir mensaje indicando que ya está registrado con más estilo
                            document.getElementById('event-details-content').insertAdjacentHTML('beforeend', data.html);
                            renderCalendarButtons(event.id);
                        } else if (isFull) {
                            registerButton.textContent = i18n.fullCapacity;
                            registerButton.disabled = true;

                            // Mostrar mensaje de aforo completo
                            if (data.html) {
                                document.getElementById('event-details-content').insertAdjacentHTML('beforeend', data.html);
                            }
                        } else {
                            registerButton.textContent = i18n.register;
                            registerButton.disabled = false;
                            registerButton.onclick = function () {
                                registerForEvent(event.id);
                            };
                        }
                    })
                    .catch(error => {
                        console.error('Error al verificar el registro:', error);
                        document.getElementById('registration-status-loading').style.display = 'none';
                        registerButton.textContent = i18n.register;
                        registerButton.disabled = false;
                        registerButton.onclick = function () {
                            registerForEvent(event.id);
                        };
                    });
            @else
                // Ocultar el loading
                document.getElementById('registration-status-loading').style.display = 'none';

                // Si no está autenticado, redirigir al login
                registerButton.textContent = i18n.loginToRegister;
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
                registerButton.textContent = i18n.registering;
                registerButton.disabled = true;

                // Usar fetch para hacer la petición AJAX
                fetch(buildEventUrl(eventRegisterUrlTemplate, eventId), {
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
                            return parseJsonResponse(response);
                    })
                    .then(data => {
                        if (!data) return; // Si hubo redirección

                        // Actualizar el botón
                        registerButton.textContent = data.registered ? i18n.alreadyRegistered : i18n.register;
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

                            renderCalendarButtons(eventId);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        registerButton.textContent = i18n.register;
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
                                                <p class="mb-0">${i18n.retryLaterError}</p>
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
            return date.toLocaleDateString(browserLocale, options);
        }

        function formatTime(date) {
            const options = { hour: '2-digit', minute: '2-digit' };
            return date.toLocaleTimeString(browserLocale, options);
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
                    const modal = bootstrap.Modal.getInstance(modalElement) || bootstrap.Modal.getOrCreateInstance(modalElement);
                    if (modal) {
                        modalElement.addEventListener('hidden.bs.modal', cleanupModalEffects, { once: true });
                        modal.hide();
                        return;
                    }
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

        }
    });
</script>