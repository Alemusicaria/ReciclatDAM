@extends('layouts.app')

@section('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css' rel='stylesheet' />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Estilos para el contenedor del calendario */
    .calendar-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 30px;
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
    
    /* Estilo para tooltips */
    .event-tooltip {
        max-width: 300px;
        padding: 10px;
        background-color: white;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }
    
    body.dark .event-tooltip {
        background-color: #2d3748;
        color: #e2e8f0;
    }
    
    .event-tooltip-title {
        font-weight: bold;
        margin-bottom: 5px;
        font-size: 16px;
    }
    
    .event-tooltip-info {
        font-size: 14px;
        margin-bottom: 3px;
    }
    
    /* Loader */
    .calendar-loader {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 400px;
    }
    
    .calendar-spinner {
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 2s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endsection

@section('content')
<div class="container mt-5 pt-5">
    <h1 class="mb-4">{{ __('Calendari d\'Events') }}</h1>
    
    <div class="row">
        <div class="col-md-3">
            <!-- Filtro de tipos de eventos -->
            <div class="card mb-4">
                <div class="card-header">{{ __('Filtrar per Tipus d\'Event') }}</div>
                <div class="card-body">
                    <div id="event-type-filters">
                        <div class="form-check">
                            <input class="form-check-input event-type-filter" type="checkbox" id="filter-all" value="all" checked>
                            <label class="form-check-label" for="filter-all">
                                {{ __('Tots els Tipus') }}
                            </label>
                        </div>
                        <!-- Los tipos de eventos se cargarán dinámicamente aquí -->
                        <div id="event-type-checkboxes"></div>
                    </div>
                </div>
            </div>
            
            <!-- Estadísticas -->
            <div class="card">
                <div class="card-header">{{ __('Estadístiques') }}</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('Events Totals') }}
                            <span class="badge bg-primary rounded-pill" id="total-events">0</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('Events Propers') }}
                            <span class="badge bg-success rounded-pill" id="upcoming-events">0</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('Els Meus Events') }}
                            <span class="badge bg-info rounded-pill" id="my-events">0</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">{{ __('Detalls de l\'Event') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="event-details-content">
                <!-- El contenido se cargará dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Tancar') }}</button>
                <button type="button" class="btn btn-primary" id="register-event-btn">{{ __('Registrar-me') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/locales-all.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/algoliasearch@4/dist/algoliasearch-lite.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tippy.js@6/dist/tippy-bundle.umd.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const eventsIndex = window.eventsIndex; // Usa la variable global
        const tipusEventsIndex = window.tipusEventsIndex; // Usa la variable global

        // Variables para almacenar datos
        let allEvents = [];
        let eventTypes = [];
        let activeFilters = ['all'];
        
        // Cargar tipos de eventos
        loadEventTypes().then(() => {
            // Cargar eventos una vez que tengamos los tipos
            loadEvents().then(() => {
                // Inicializar el calendario cuando tengamos los datos
                initializeCalendar();
                
                // Actualizar estadísticas
                updateStatistics();
                
                // Ocultar loader y mostrar calendario
                document.getElementById('calendar-loader').style.display = 'none';
                document.getElementById('calendar').style.display = 'block';
            });
        });
        
        // Función para cargar tipos de eventos desde Algolia
        async function loadEventTypes() {
            try {
                const { hits } = await window.tipusEventsIndex.search('', {
                    hitsPerPage: 100
                });
                
                eventTypes = hits;
                renderEventTypeFilters(eventTypes);
                return hits;
            } catch (error) {
                console.error('Error al cargar tipos de eventos:', error);
                return [];
            }
        }
        
        // Función para cargar eventos desde Algolia
        async function loadEvents() {
            try {
                const { hits } = await window.eventsIndex.search('', {
                    hitsPerPage: 1000
                });
                
                allEvents = hits.map(event => {
                    // Encontrar el tipo de evento para obtener el color
                    const eventType = eventTypes.find(type => type.id === event.tipus_event_id);
                    const color = eventType ? eventType.color : '#3788d8';
                    
                    return {
                        id: event.id,
                        title: event.nom,
                        start: event.data_inici,
                        end: event.data_fi,
                        color: color,
                        extendedProps: {
                            description: event.descripcio,
                            location: event.lloc,
                            capacity: event.capacitat,
                            participants: event.participants_count || 0,
                            tipus: eventType ? eventType.nom : 'General',
                            tipus_id: event.tipus_event_id,
                            imatge: event.imatge,
                            punts_disponibles: event.punts_disponibles || 0
                        }
                    };
                });
                
                return allEvents;
            } catch (error) {
                console.error('Error al cargar eventos:', error);
                return [];
            }
        }
        
        // Renderizar filtros de tipos de eventos
        function renderEventTypeFilters(types) {
            const container = document.getElementById('event-type-checkboxes');
            container.innerHTML = '';
            
            types.forEach(type => {
                const filterHtml = `
                    <div class="form-check">
                        <input class="form-check-input event-type-filter" type="checkbox" id="filter-${type.id}" value="${type.id}">
                        <label class="form-check-label" for="filter-${type.id}" style="color: ${type.color}">
                            ${type.nom}
                        </label>
                    </div>
                `;
                
                container.innerHTML += filterHtml;
            });
            
            // Añadir eventos a los checkboxes
            document.querySelectorAll('.event-type-filter').forEach(checkbox => {
                checkbox.addEventListener('change', handleFilterChange);
            });
        }
        
        // Manejar cambios en los filtros
        function handleFilterChange(e) {
            const allCheckbox = document.getElementById('filter-all');
            
            if (e.target.value === 'all') {
                // Si "Todos" está marcado, desmarcar los demás
                if (e.target.checked) {
                    document.querySelectorAll('.event-type-filter:not(#filter-all)').forEach(cb => {
                        cb.checked = false;
                    });
                    activeFilters = ['all'];
                } else {
                    // No permitir desmarcar "Todos" sin seleccionar otra opción
                    e.target.checked = true;
                }
            } else {
                // Si se marca un tipo específico, desmarcar "Todos"
                if (e.target.checked) {
                    allCheckbox.checked = false;
                    
                    // Añadir a filtros activos
                    if (activeFilters.includes('all')) {
                        activeFilters = [e.target.value];
                    } else {
                        activeFilters.push(e.target.value);
                    }
                } else {
                    // Eliminar de filtros activos
                    activeFilters = activeFilters.filter(id => id !== e.target.value);
                    
                    // Si no hay filtros activos, marcar "Todos"
                    if (activeFilters.length === 0) {
                        allCheckbox.checked = true;
                        activeFilters = ['all'];
                    }
                }
            }
            
            // Actualizar eventos mostrados
            updateCalendarEvents();
        }
        
        // Inicializar calendario FullCalendar
        function initializeCalendar() {
            const calendarEl = document.getElementById('calendar');
            
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'ca',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listMonth'
                },
                events: getFilteredEvents(),
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false,
                    hour12: false
                },
                eventClick: function(info) {
                    showEventDetails(info.event);
                },
                eventDidMount: function(info) {
                    // Crear tooltips para eventos
                    tippy(info.el, {
                        content: createEventTooltip(info.event),
                        allowHTML: true,
                        theme: document.body.classList.contains('dark') ? 'dark' : 'light',
                        placement: 'top',
                        arrow: true,
                        duration: [200, 200]
                    });
                },
                loading: function(isLoading) {
                    if (isLoading) {
                        document.getElementById('calendar-loader').style.display = 'flex';
                        document.getElementById('calendar').style.display = 'none';
                    } else {
                        document.getElementById('calendar-loader').style.display = 'none';
                        document.getElementById('calendar').style.display = 'block';
                    }
                }
            });
            
            calendar.render();
            
            // Guardar referencia al calendario para actualizarlo
            window.eventCalendar = calendar;
        }
        
        // Obtener eventos filtrados según selección
        function getFilteredEvents() {
            if (activeFilters.includes('all')) {
                return allEvents;
            } else {
                return allEvents.filter(event => 
                    activeFilters.includes(event.extendedProps.tipus_id.toString())
                );
            }
        }
        
        // Actualizar eventos mostrados en el calendario
        function updateCalendarEvents() {
            if (window.eventCalendar) {
                // Eliminar todos los eventos
                window.eventCalendar.getEvents().forEach(event => event.remove());
                
                // Añadir eventos filtrados
                const filteredEvents = getFilteredEvents();
                filteredEvents.forEach(event => {
                    window.eventCalendar.addEvent(event);
                });
                
                // Actualizar estadísticas
                updateStatistics();
            }
        }
        
        // Crear HTML para tooltip de evento
        function createEventTooltip(event) {
            return `
                <div class="event-tooltip">
                    <div class="event-tooltip-title">${event.title}</div>
                    <div class="event-tooltip-info">
                        <i class="fas fa-calendar-alt"></i> ${formatDate(event.start)}
                    </div>
                    <div class="event-tooltip-info">
                        <i class="fas fa-clock"></i> ${formatTime(event.start)} ${event.end ? ' - ' + formatTime(event.end) : ''}
                    </div>
                    <div class="event-tooltip-info">
                        <i class="fas fa-map-marker-alt"></i> ${event.extendedProps.location || 'No especificat'}
                    </div>
                    <div class="event-tooltip-info">
                        <i class="fas fa-users"></i> ${event.extendedProps.participants}/${event.extendedProps.capacity || '∞'}
                    </div>
                </div>
            `;
        }
        
        // Mostrar detalles del evento en modal
        function showEventDetails(event) {
            const modal = new bootstrap.Modal(document.getElementById('eventModal'));
            const contentEl = document.getElementById('event-details-content');
            
            // Actualizar título del modal
            document.getElementById('eventModalLabel').textContent = event.title;
            
            // Formatear fechas y horas
            const startDate = formatDate(event.start);
            const startTime = formatTime(event.start);
            const endTime = event.end ? formatTime(event.end) : '';
            
            // Preparar el contenido
            const htmlContent = `
                <div class="row">
                    <div class="col-md-5">
                        <img src="${event.extendedProps.imatge ? '/' + event.extendedProps.imatge : '/images/default-event.jpg'}" 
                             class="img-fluid rounded mb-3" alt="${event.title}">
                    </div>
                    <div class="col-md-7">
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item">
                                <i class="fas fa-calendar-alt text-primary"></i> <strong>Data:</strong> ${startDate}
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-clock text-primary"></i> <strong>Hora:</strong> ${startTime} ${endTime ? ' - ' + endTime : ''}
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-map-marker-alt text-primary"></i> <strong>Lloc:</strong> ${event.extendedProps.location || 'No especificat'}
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-tag text-primary"></i> <strong>Tipus:</strong> 
                                <span class="badge" style="background-color: ${event.backgroundColor}">${event.extendedProps.tipus}</span>
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-users text-primary"></i> <strong>Participants:</strong> 
                                ${event.extendedProps.participants}/${event.extendedProps.capacity || '∞'}
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-coins text-primary"></i> <strong>ECODAMS:</strong> 
                                ${event.extendedProps.punts_disponibles}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <h5>Descripció</h5>
                        <p>${event.extendedProps.description || 'Sense descripció disponible.'}</p>
                    </div>
                </div>
            `;
            
            contentEl.innerHTML = htmlContent;
            
            // Configurar el botón de registro
            const registerBtn = document.getElementById('register-event-btn');
            registerBtn.dataset.eventId = event.id;
            
            // Verificar si el usuario ya está registrado o el evento está lleno
            const isFull = event.extendedProps.capacity && 
                           parseInt(event.extendedProps.participants) >= parseInt(event.extendedProps.capacity);
            
            // Comprobar si el usuario está registrado (aquí necesitarías implementar la lógica real)
            const isRegistered = false; // Placeholder - integrar con tu lógica real
            
            if (isRegistered) {
                registerBtn.textContent = 'Ja estàs registrat';
                registerBtn.disabled = true;
                registerBtn.classList.remove('btn-primary');
                registerBtn.classList.add('btn-success');
            } else if (isFull) {
                registerBtn.textContent = 'Aforament complet';
                registerBtn.disabled = true;
                registerBtn.classList.remove('btn-primary');
                registerBtn.classList.add('btn-danger');
            } else {
                registerBtn.textContent = 'Registrar-me';
                registerBtn.disabled = false;
                registerBtn.classList.remove('btn-success', 'btn-danger');
                registerBtn.classList.add('btn-primary');
            }
            
            // Evento de clic para el botón de registro
            registerBtn.onclick = function() {
                registerForEvent(event.id);
            };
            
            modal.show();
        }
        
        // Función para registrarse en un evento
        function registerForEvent(eventId) {
            // Aquí implementarías la lógica para registrar al usuario
            // Por ejemplo, una petición AJAX al servidor
            
            fetch(`/events/${eventId}/register`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Actualizar visual del botón
                    const registerBtn = document.getElementById('register-event-btn');
                    registerBtn.textContent = 'Ja estàs registrat';
                    registerBtn.disabled = true;
                    registerBtn.classList.remove('btn-primary');
                    registerBtn.classList.add('btn-success');
                    
                    // Actualizar contador de participantes
                    // Esto requeriría recargar los eventos o actualizar el evento específico
                    loadEvents().then(() => {
                        updateCalendarEvents();
                    });
                    
                    // Mostrar mensaje de éxito
                    alert('T\'has registrat correctament a l\'event!');
                } else {
                    alert(data.message || 'Hi ha hagut un error en el registre.');
                }
            })
            .catch(error => {
                console.error('Error al registrar-se:', error);
                alert('Hi ha hagut un error en el registre. Intenta-ho més tard.');
            });
        }
        
        // Actualizar estadísticas de eventos
        function updateStatistics() {
            const now = new Date();
            
            // Total de eventos
            document.getElementById('total-events').textContent = allEvents.length;
            
            // Eventos próximos (que no han pasado)
            const upcomingEventsCount = allEvents.filter(event => 
                new Date(event.start) > now
            ).length;
            document.getElementById('upcoming-events').textContent = upcomingEventsCount;
            
            // Mis eventos (necesitarías implementar la lógica real)
            // Aquí deberías obtener los eventos en los que está registrado el usuario actual
            const myEventsCount = 0; // Placeholder
            document.getElementById('my-events').textContent = myEventsCount;
        }
        
        // Funciones de utilidad para formatear fechas
        function formatDate(date) {
            if (!date) return '';
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(date).toLocaleDateString('ca-ES', options);
        }
        
        function formatTime(date) {
            if (!date) return '';
            return new Date(date).toLocaleTimeString('ca-ES', { hour: '2-digit', minute: '2-digit' });
        }
    });
</script>
@endsection