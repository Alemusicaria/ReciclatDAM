@extends('layouts.app')

@section('content')
<div class="container-fluid h-100 mt-5 pt-5">
    <!-- Hero Section -->
    <section id="inici" class="hero text-center py-5" style="margin-top: 50px;">
        <div class="row justify-content-center">
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <div class="card mb-4 shadow-sm w-100">
                    <div class="card-body d-flex flex-column align-items-center">
                        <h1 class="display-4">Ajuda a Reciclar i Guanya Recompenses</h1>
                        <p class="lead">Transforma el teu reciclatge en beneficis per a la comunitat.</p>
                        <form class="form-inline my-2 my-lg-0">
                            <input class="form-control mr-sm-2" type="search" placeholder="La teva ciutat" aria-label="Search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Cerca</button>
                        </form>
                        <div class="mt-3 d-flex flex-column align-items-center">
                            <a href="#" class="">
                                <img src="{{ asset('images/icons/apple_light.png') }}" alt="Descarrega a l'Apple Store" style="max-width: 200px;">
                            </a>
                            <a href="#" class="">
                                <img src="{{ asset('images/icons/google_light.png') }}" alt="Descarrega a Google Play" style="max-width: 200px;">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center justify-content-center">
                <div class="card mb-4 shadow-sm w-100 d-flex align-items-center justify-content-center">
                    <img src="{{ asset('images/mobil.png') }}" class="img-fluid" alt="Hero Image" style="max-width: 300px; height: auto;">
                </div>
            </div>
        </div>
    </section>

    <!-- Beneficis -->
    <section id="com-funciona" class="row text-center my-5 justify-content-center">
        <div class="col-md-4 d-flex align-items-center justify-content-center">
            <div class="card mb-4 shadow-sm w-100">
                <img src="{{ asset('images/slide1.jpg') }}" class="img-fluid" alt="Recicla fàcilment">
                <div class="card-body">
                    <h3>Recicla Fàcilment</h3>
                    <p>Segueix passos senzills per reciclar correctament.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 d-flex align-items-center justify-content-center">
            <div class="card mb-4 shadow-sm w-100">
                <img src="{{ asset('images/slide2.jpg') }}" class="img-fluid" alt="Guanya punts">
                <div class="card-body">
                    <h3>Guanya Punts</h3>
                    <p>Acumula punts i canvia'ls per premis.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 d-flex align-items-center justify-content-center">
            <div class="card mb-4 shadow-sm w-100">
                <img src="{{ asset('images/slide3.jpg') }}" class="img-fluid" alt="Ajuda el planeta">
                <div class="card-body">
                    <h3>Ajuda el Planeta</h3>
                    <p>Redueix la contaminació reciclant millor.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Secció Com Funciona -->
    <section id="qui-som" class="text-center my-5">
        <h2>Com Funciona?</h2>
        <p>Segueix aquests passos senzills per començar a reciclar amb nosaltres.</p>
        <img src="{{ asset('images/slide3.jpg') }}" class="img-fluid" alt="Procés de reciclatge">
    </section>

    <!-- Secció Qui Som -->
    <section id="reciclatge" class="text-center my-5">
        <h2>Qui Som?</h2>
        <p>Som una organització dedicada a promoure el reciclatge i la sostenibilitat.</p>
        <img src="{{ asset('images/bg-01.jpg') }}" class="img-fluid" alt="Qui Som">
    </section>

    <!-- Secció Reciclatge -->
    <section id="premis" class="text-center my-5">
        <h2>El Reciclatge</h2>
        <p>Descobreix com reciclar correctament i els beneficis que aporta.</p>
        <img src="{{ asset('images/bg-01.jpg') }}" class="img-fluid" alt="Reciclatge">
    </section>

    <!-- Secció Premis -->
    <section id="opinions" class="text-center my-5">
        <h2>Premis</h2>
        <p>Acumula punts i canvia'ls per premis increïbles.</p>
        <img src="{{ asset('images/bg-01.jpg') }}" class="img-fluid" alt="Premis">
    </section>

    <!-- Secció Opinions -->
    <section class="text-center my-5">
        <h2>Opinions</h2>
        <p>Descobreix què diuen els nostres usuaris sobre nosaltres.</p>
        <img src="{{ asset('images/bg-01.jpg') }}" class="img-fluid" alt="Opinions">
    </section>

    <!-- Footer -->
    <footer class="text-center py-4">
        <p>&copy; 2023 Reciclat DAM. Tots els drets reservats.</p>
    </footer>
</div>
@endsection