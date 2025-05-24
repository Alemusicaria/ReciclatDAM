<section id="footer" class="py-5 mt-4">
    <div class="container">
        <div class="row">
            <!-- Columna d'informació de contacte -->
            <div class="col-md-4 mb-4">
                <h4 class="mb-4">{{ __('messages.footer.contact') }}</h4>
                <ul class="list-unstyled footer-contact">
                    <li class="mb-3">
                        <i class="fas fa-map-marker-alt mr-2"></i> {{ __('messages.footer.address') }}
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-phone mr-2"></i> {{ __('messages.footer.phone') }}
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-envelope mr-2"></i> {{ __('messages.footer.email') }}
                    </li>
                </ul>
                <div class="mt-4">
                    <h5 class="mb-3">{{ __('messages.footer.follow_us') }}</h5>
                    <div class="social-icons">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            
            <!-- Columna de navegació ràpida -->
            <div class="col-md-4 mb-4">
                <h4 class="mb-4">{{ __('messages.footer.quick_links') }}</h4>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#inici">{{ __('messages.footer.home') }}</a></li>
                    <li class="mb-2"><a href="#funcionament">{{ __('messages.footer.how_it_works') }}</a></li>
                    <li class="mb-2"><a href="#qui_som">{{ __('messages.footer.about_us') }}</a></li>
                    <li class="mb-2"><a href="#reciclatge">{{ __('messages.footer.recycling') }}</a></li>
                    <li class="mb-2"><a href="#premis">{{ __('messages.footer.rewards') }}</a></li>
                    <li class="mb-2"><a href="#opinions">{{ __('messages.footer.opinions') }}</a></li>
                </ul>
            </div>
            
            <!-- Columna de mapa -->
            <div class="col-md-4 mb-4">
                <h4 class="mb-4">{{ __('messages.footer.location') }}</h4>
                <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2982.2393918018135!2d1.2721169!3d41.6729809!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a69f60ede9d671%3A0x8a696d8b8d5c2b0d!2sPl.%20Major%2C%201%2C%2025200%20Cervera%2C%20Lleida!5e0!3m2!1sca!2ses!4v1657789456789!5m2!1sca!2ses" 
                        width="100%" 
                        height="200" 
                        style="border:0; border-radius: 8px;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
        
        <hr class="my-4">
        
        <!-- Copyright i política de privacitat -->
        <div class="row">
            <div class="col-md-6 text-center text-md-left mb-3 mb-md-0">
                <p class="mb-0">{{ __('messages.footer.copyright') }}</p>
            </div>
            <div class="col-md-6 text-center text-md-right">
                <a href="#" class="mr-3">{{ __('messages.footer.privacy_policy') }}</a>
                <a href="#" class="mr-3">{{ __('messages.footer.terms') }}</a>
                <a href="#">{{ __('messages.footer.legal_notice') }}</a>
            </div>
        </div>
    </div>
</section>