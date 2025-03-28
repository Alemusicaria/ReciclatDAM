@extends('layouts.app')

@section('content')
    <div>
        <!-- Hero Section -->
        <section id="inici" class="hero text-left">
            <div class="row justify-content-center align-items-center h-100 w-100">
                <!-- Text i Cerca -->
                <div class="col-lg-5 d-flex align-items-center justify-content-center">
                    <div class="card mb-4 p-4 w-100">
                        <div class="card-body text-left">
                            <h1 class="display-4 fw-bold text-left">Ajuda a Reciclar i Guanya Recompenses</h1>
                            <p class="lead text-left">Transforma el teu reciclatge en beneficis per a la comunitat.</p>

                            <div class="search-container mt-4">
                                <h3 class="search-title text-left">Cerca la teva ciutat</h3>
                                <div class="position-relative">
                                    <input class="form-control search-input pl-5" type="search"
                                        placeholder="Escriu el nom de la teva ciutat..." aria-label="Search">
                                    <i class="fas fa-search position-absolute"
                                        style="top: 50%; left: 15px; transform: translateY(-50%); color: #888;"></i>
                                </div>
                            </div>

                            <div class="mt-4 d-flex justify-content-center gap-3">
                                <img src="" alt="Descarrega a l'Apple Store" style="max-width: 180px;" id="apple-store">
                                <img src="" alt="Descarrega a Google Play" style="max-width: 180px;" id="google-play">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Imatge del mòbil -->
                <div class="col-lg-5 d-flex align-items-center justify-content-center">
                    <div class="card mb-4 p-3 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('images/mobil.png') }}" class="img-fluid" alt="Hero Image"
                            style="max-width: 350px; height: auto;">
                    </div>
                </div>
            </div>
        </section>


        <!-- Beneficis -->
        <section id="com-funciona" class="text-center">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm w-100">
                        <img src="{{ asset('images/slide1.jpg') }}" class="img-fluid" alt="Recicla fàcilment">
                        <div class="card-body">
                            <h3>Recicla Fàcilment</h3>
                            <p>Segueix passos senzills per reciclar correctament.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm w-100">
                        <img src="{{ asset('images/slide2.jpg') }}" class="img-fluid" alt="Guanya punts">
                        <div class="card-body">
                            <h3>Guanya Punts</h3>
                            <p>Acumula punts i canvia'ls per premis.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm w-100">
                        <img src="{{ asset('images/slide3.jpg') }}" class="img-fluid" alt="Ajuda el planeta">
                        <div class="card-body">
                            <h3>Ajuda el Planeta</h3>
                            <p>Redueix la contaminació reciclant millor.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Altres Seccions -->
        <section id="qui-som" class="text-center">
            <div class="h-100 d-flex flex-column justify-content-center align-items-center">
                <h2>Com Funciona?</h2>
                <p>Segueix aquests passos senzills per començar a reciclar amb nosaltres.</p>
                <img src="{{ asset('images/slide3.jpg') }}" class="img-fluid small-image" alt="Procés de reciclatge">
            </div>
        </section>

        <section id="reciclatge" class="text-center">
            <div class="h-100 d-flex flex-column justify-content-center align-items-center">
                <h2>Qui Som?</h2>
                <p>Som una organització dedicada a promoure el reciclatge i la sostenibilitat.</p>
                <img src="{{ asset('images/bg-01.jpg') }}" class="img-fluid small-image" alt="Qui Som">
            </div>
        </section>

        <section id="premis" class="text-center">
            <div class="h-100 d-flex flex-column justify-content-center align-items-center">
                <h2>El Reciclatge</h2>
                <p>Descobreix com reciclar correctament i els beneficis que aporta.</p>
                <img src="{{ asset('images/bg-01.jpg') }}" class="img-fluid small-image" alt="Reciclatge">
            </div>
        </section>

        <section id="opinions" class="text-center">
            <div class="h-100 d-flex flex-column justify-content-center align-items-center">
                <h2>Premis</h2>
                <p>Acumula punts i canvia'ls per premis increïbles.</p>
                <img src="{{ asset('images/bg-01.jpg') }}" class="img-fluid small-image" alt="Premis">
            </div>
        </section>

        <footer class="text-center py-4">
            <p>&copy; 2023 Reciclat DAM. Tots els drets reservats.</p>
        </footer>
    </div>
@endsection