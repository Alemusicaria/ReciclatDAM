@extends('layouts.app')

@section('content')
    <div class="dashboard-container">
        <div class="header text-center mb-4">
            <h1>{{ __('messages.welcome') }}</h1>
            <p>{{ __('messages.welcome') }}</p>            
        </div>
        <div id="introCarousel" class="carousel slide mb-4" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('images/slide1.jpg') }}" class="d-block w-100" alt="Slide 1">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Solucions Innovadores de Reciclatge</h5>
                        <p>Capdavanters en pràctiques sostenibles.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/slide2.jpg') }}" class="d-block w-100" alt="Slide 2">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Responsabilitat Ambiental</h5>
                        <p>Uneix-te a nosaltres per tenir un impacte positiu en el planeta.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/slide3.jpg') }}" class="d-block w-100" alt="Slide 3">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Compromís Comunitari</h5>
                        <p>Treballant junts per un futur més verd.</p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#introCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
            </a>
            <a class="carousel-control-next" href="#introCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Següent</span>
            </a>
        </div>
        <div class="intro mb-4">
            <h2>Sobre Nosaltres</h2>
            <p>Reciclat DAM es dedica a proporcionar solucions de reciclatge innovadores i sostenibles. La nostra missió és
                reduir els residus i promoure la responsabilitat ambiental a través de pràctiques de reciclatge eficients.
                Uneix-te a nosaltres per tenir un impacte positiu en el planeta.</p>
        </div>
        <div class="stats">
            <h2>Tauler</h2>
            <p>Benvingut al teu tauler! Aquí pots gestionar les teves activitats de reciclatge, fer un seguiment del teu
                progrés i estar al dia amb les últimes notícies i informació de Reciclat DAM.</p>
        </div>
    </div>
@endsection