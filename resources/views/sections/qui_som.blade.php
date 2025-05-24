<section id="qui_som" class="text-left">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <!-- Card 1: Qui som? -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <h2 class="text-justify mb-4">{{ __('messages.about_us.title') }}</h2>
                        <div class="about-text">
                            <p class="lead">
                                {!! __('messages.about_us.description_1') !!}
                            </p>
                            <p class="lead">
                                {!! __('messages.about_us.description_2') !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Imatge -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="image-container">
                        <img src="{{ asset('images/imagen-contenedor-1.png') }}" alt="{{ __('messages.about_us.image_alt') }}" class="img-fluid about-image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>