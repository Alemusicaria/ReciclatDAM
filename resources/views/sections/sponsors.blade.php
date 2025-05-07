<section id="sponsors" class="text-center" style="height: 45vh">
    <div class="container">
        <h2>{{ __('messages.sponsors.title') }}</h2>
        <div class="row justify-content-center">
            <!-- Primera fila: 5 sponsors -->
            <div class="col-md-2 col-4">
                {!! file_get_contents(public_path('images/sponsors/svg/la_salle.svg')) !!}
            </div>
            <div class="col-md-2 col-4">
                {!! file_get_contents(public_path('images/sponsors/svg/ecoembes.svg')) !!}
            </div>
            <div class="col-md-2 col-4">
                {!! file_get_contents(public_path('images/sponsors/svg/repsol.svg')) !!}
            </div>
            <div class="col-md-2 col-4">
                {!! file_get_contents(public_path('images/sponsors/svg/generalitat_de_catalunya.svg')) !!}
            </div>
            <div class="col-md-2 col-4 logo-alsa">
                {!! file_get_contents(public_path('images/sponsors/svg/alsa.svg')) !!}
            </div>
        </div>
        <div class="row justify-content-center">
            <!-- Segunda fila: 6 sponsors -->
            <div class="col-md-2 col-4">
                {!! file_get_contents(public_path('images/sponsors/svg/ferrovial.svg')) !!}
            </div>
            <div class="col-md-2 col-4">
                {!! file_get_contents(public_path('images/sponsors/svg/nestle.svg')) !!}
            </div>
            <div class="col-md-2 col-4">
                {!! file_get_contents(public_path('images/sponsors/svg/caixabank.svg')) !!}
            </div>
            <div class="col-md-2 col-4">
                {!! file_get_contents(public_path('images/sponsors/svg/tetra_pak.svg')) !!}
            </div>
            <div class="col-md-2 col-4">
                {!! file_get_contents(public_path('images/sponsors/svg/endesa.svg')) !!}
            </div>
            <div class="col-md-2 col-4 logo-mercadona">
                {!! file_get_contents(public_path('images/sponsors/svg/mercadona.svg')) !!}
            </div>
        </div>
    </div>
</section>