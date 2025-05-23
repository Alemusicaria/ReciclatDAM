<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Llistat de Tipus d'Events</h5>
    <button id="newTipusEventBtn" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal"
        data-detail-type="create-tipus-event" data-detail-title="Nou Tipus d'Event">
        <i class="fas fa-plus-circle me-1"></i> Nou Tipus
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped" id="dynamicTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Color</th>
                <th>Events</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tipusEvents as $tipus)
                <tr>
                    <td>{{ $tipus->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="tipus-icon rounded-circle me-2 d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px; background-color: {{ $tipus->color }}">
                                <i class="fas fa-calendar-day text-white"></i>
                            </div>
                            <span>{{ $tipus->nom }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge" style="background-color: {{ $tipus->color }}">
                            {{ $tipus->color }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-info">
                            {{ $tipus->events_count ?? $tipus->events()->count() }} events
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="tipus-event" data-detail-id="{{ $tipus->id }}" title="Veure detalls">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary editTipusEventBtn" data-tipus-event-id="{{ $tipus->id }}"
                                title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm deleteBtn" 
                                data-item-id="{{ $tipus->id }}" 
                                data-item-name="{{ $tipus->nom }}"
                                data-item-type="tipus-event"
                                @if($tipus->events()->count() > 0) disabled @endif
                                title="@if($tipus->events()->count() > 0) No es pot eliminar perquè té events associats @else Eliminar @endif">
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
    #newTipusEventBtn {
        width: 150px;
    }
</style>