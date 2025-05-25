@extends('layouts.app')

@section('content')
    <div class="container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h5 class="mb-0">Reportar problema en punt de recollida</h5>
                    </div>
                    <div class="card-body">
                        <div id="loading-container" class="text-center">
                            <div class="spinner-border text-warning" role="status"></div>
                            <p class="mt-2">Cercant punts de recollida propers...</p>
                        </div>

                        <div id="no-points-found" class="alert alert-warning d-none">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            No s'han trobat punts de recollida propers a la teva ubicació (1km).
                            <div class="mt-3">
                                <a href="{{ route('scanner') }}" class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-2"></i> Tornar a l'escàner
                                </a>
                            </div>
                        </div>

                        <form id="alerta-form" action="{{ route('alertes_punts_de_recollida.store') }}" method="POST"
                            enctype="multipart/form-data" class="d-none">
                            @csrf
                            <input type="hidden" name="lat" id="lat" value="{{ request()->get('lat') }}">
                            <input type="hidden" name="lng" id="lng" value="{{ request()->get('lng') }}">

                            <div class="mb-3">
                                <label for="punt_de_recollida_id" class="form-label">Punt de recollida:</label>
                                <select class="form-select" id="punt_de_recollida_id" name="punt_de_recollida_id" required>
                                    <option value="">Selecciona un punt de recollida...</option>
                                </select>
                                <small class="form-text text-muted">Es mostren els punts de recollida a menys d'1km de la
                                    teva ubicació.</small>
                            </div>

                            <div class="mb-3">
                                <label for="tipus_alerta_id" class="form-label">Tipus de problema:</label>
                                <select class="form-select" id="tipus_alerta_id" name="tipus_alerta_id" required>
                                    <option value="">Selecciona el tipus de problema...</option>
                                    @foreach($tipusAlertes as $tipus)
                                        <option value="{{ $tipus->id }}">{{ $tipus->nom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="descripcio" class="form-label">Descripció:</label>
                                <textarea class="form-control" id="descripcio" name="descripció" rows="3"
                                    placeholder="Explica breument el problema que has detectat" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="imatge" class="form-label">Imatge (opcional):</label>
                                <input type="file" class="form-control" id="imatge" name="imatge" accept="image/*">
                                <small class="form-text text-muted">Puja una imatge del problema si és possible.</small>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('scanner') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i> Cancel·lar
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-paper-plane me-1"></i> Enviar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const lat = document.getElementById('lat').value;
            const lng = document.getElementById('lng').value;
            const loadingContainer = document.getElementById('loading-container');
            const noPointsFound = document.getElementById('no-points-found');
            const alertaForm = document.getElementById('alerta-form');
            const puntRecollida = document.getElementById('punt_de_recollida_id');

            if (lat && lng) {
                // Cargar puntos de recogida cercanos
                fetch(`/punts-recollida/nearby?lat=${lat}&lng=${lng}&distance=100`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Error del servidor: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        loadingContainer.classList.add('d-none');

                        if (!Array.isArray(data) || data.length === 0) {
                            noPointsFound.classList.remove('d-none');
                            return;
                        }

                        // Llenar el select con los puntos cercanos
                        data.forEach(point => {
                            const option = document.createElement('option');
                            option.value = point.id;

                            // Calcular distancia
                            const distance = calculateDistance(lat, lng, point.latitud, point.longitud);

                            option.textContent = `${point.nom} (${distance.toFixed(2)} km)`;
                            puntRecollida.appendChild(option);
                        });

                        // Mostrar el formulario
                        alertaForm.classList.remove('d-none');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        loadingContainer.classList.add('d-none');
                        noPointsFound.classList.remove('d-none');
                        noPointsFound.innerHTML = `
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Error al carregar els punts de recollida: ${error.message}
                                <div class="mt-3">
                                    <a href="{{ route('scanner') }}" class="btn btn-primary">
                                        <i class="fas fa-arrow-left me-2"></i> Tornar a l'escàner
                                    </a>
                                </div>
                            `;
                    });
            } else {
                loadingContainer.classList.add('d-none');
                noPointsFound.classList.remove('d-none');
                noPointsFound.innerHTML = `
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        No s'han proporcionat coordenades de ubicació.
                        <div class="mt-3">
                            <a href="{{ route('scanner') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left me-2"></i> Tornar a l'escàner
                            </a>
                        </div>
                    `;
            }

            // Función para calcular distancia entre dos puntos
            function calculateDistance(lat1, lon1, lat2, lon2) {
                const R = 6371; // Radio de la Tierra en km
                const dLat = deg2rad(lat2 - lat1);
                const dLon = deg2rad(lon2 - lon1);
                const a =
                    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                    Math.sin(dLon / 2) * Math.sin(dLon / 2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                return R * c; // Distancia en km
            }

            function deg2rad(deg) {
                return deg * (Math.PI / 180);
            }
        });
    </script>
@endsection