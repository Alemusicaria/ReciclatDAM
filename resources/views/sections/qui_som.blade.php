<section id="qui_som" class="text-left">
    <div class="row justify-content-center align-items-stretch w-100">
        <!-- Card 1: Qui som? -->
        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card mb-4 p-4 w-100 d-flex align-items-center justify-content-center" style="background-color: transparent; box-shadow: none; border: none;">
                <div class="card-body text-center d-flex flex-column justify-content-center" style="padding: 9rem;">
                    <h2 class="text-justify">{{ __('messages.about_us.title') }}</h2>
                    <p class="lead text-left">
                        {!! __('messages.about_us.description_1') !!}
                    </p>
                    <p class="lead text-left">
                        {!! __('messages.about_us.description_2') !!}
                    </p>
                </div>
            </div>
        </div>

        <!-- Card 2: Imatge -->
        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card mb-4 p-4 w-100 d-flex align-items-center justify-content-center" style="background-color: transparent; box-shadow: none; border: none;">
                <img src="{{ asset('images/imagen-contenedor-1.png') }}" alt="{{ __('messages.about_us.image_alt') }}" class="img-fluid" style="max-width: 100%; height: auto; transform: translateX(-10vh);">
            </div>
        </div>
    </div>
</section>