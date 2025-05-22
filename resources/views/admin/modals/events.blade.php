<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Llistat d'Events</h5>
    <button id="newEventBtn" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal"
        data-detail-type="create-event" data-detail-title="Nou Event">
        <i class="fas fa-plus-circle me-1"></i> Nou Event
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped" id="dynamicTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Data Inici</th>
                <th>Tipus</th>
                <th>Participants</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
                <tr>
                    <td>{{ $event->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($event->imatge)
                                <img src="{{ asset('storage/' . $event->imatge) }}" class="rounded me-2" width="40" height="40"
                                    alt="Event" style="object-fit: cover; margin-right: 10px;">
                            @else
                                <div class="event-icon-placeholder rounded me-2 d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px; background-color: {{ $event->tipus ? $event->tipus->color : '#3f51b5' }};">
                                    <i class="fas fa-calendar-alt text-white"></i>
                                </div>
                            @endif
                            <span>{{ $event->nom }}</span>
                        </div>
                    </td>
                    <td>{{ $event->data_inici->format('d/m/Y H:i') }}</td>
                    <td>
                        <span class="badge"
                            style="background-color: {{ $event->tipus ? $event->tipus->color : '#3f51b5' }};">
                            {{ $event->tipus ? $event->tipus->nom : 'Sense tipus' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-info">
                            {{ $event->participants()->count() }} / {{ $event->capacitat ?: '∞' }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="event" data-detail-id="{{ $event->id }}" title="Veure detalls">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary editEventBtn" data-event-id="{{ $event->id }}"
                                title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm deleteBtn" data-item-id="{{ $event->id }}"
                                data-item-name="{{ $event->nom }}" data-item-type="event">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<style>
    .btn-close {
        background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
        opacity: 0.5;
    }

    .btn-close:hover {
        opacity: 0.75;
    }

    #newEventBtn {
        width: 150px;
    }
</style>