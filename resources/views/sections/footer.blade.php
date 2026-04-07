<section id="footer" class="py-5 mt-4">
    <div class="container">
        <div class="footer-top row g-4 align-items-start">
            <div class="col-lg-4 col-md-6">
                <h4 class="footer-heading">{{ __('messages.footer.contact') }}</h4>
                <ul class="list-unstyled footer-contact mb-4">
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ __('messages.footer.address') }}</span>
                    </li>
                    <li>
                        <i class="fas fa-phone"></i>
                        <span>{{ __('messages.footer.phone') }}</span>
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <span>{{ __('messages.footer.email') }}</span>
                    </li>
                </ul>

                <h5 class="footer-subheading">{{ __('messages.footer.follow_us') }}</h5>
                <div class="social-icons" aria-label="{{ __('messages.footer.social_aria') }}">
                    <a href="#" class="social-icon" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <h4 class="footer-heading">{{ __('messages.footer.quick_links') }}</h4>
                <ul class="list-unstyled footer-links-grid">
                    <li><a href="#inici">{{ __('messages.footer.home') }}</a></li>
                    <li><a href="#funcionament">{{ __('messages.footer.how_it_works') }}</a></li>
                    <li><a href="#qui_som">{{ __('messages.footer.about_us') }}</a></li>
                    <li><a href="#reciclatge">{{ __('messages.footer.recycling') }}</a></li>
                    <li><a href="#premis">{{ __('messages.footer.rewards') }}</a></li>
                    <li><a href="#opinions">{{ __('messages.footer.opinions') }}</a></li>
                </ul>
            </div>

            <div class="col-lg-4">
                <h4 class="footer-heading">{{ __('messages.footer.location') }}</h4>
                <div class="map-container">
                    <iframe
                        src="https://maps.google.com/maps?q=Placa%20Major%201%2C%2025200%20Cervera%2C%20Lleida&t=&z=15&ie=UTF8&iwloc=&output=embed"
                        width="100%"
                        height="220"
                        style="border:0; border-radius: 12px;"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>

        <div class="footer-bottom mt-5 pt-3">
            <div class="row align-items-center gy-3">
                <div class="col-lg-5 text-center text-lg-start">
                    <p class="mb-0 footer-copy">{{ __('messages.footer.copyright_dynamic', ['years' => now()->year > 2025 ? '2025-' . now()->year : '2025']) }}</p>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="footer-legal">
                        <a href="#">{{ __('messages.footer.privacy_policy') }}</a>
                        <span class="legal-dot">·</span>
                        <a href="#">{{ __('messages.footer.terms') }}</a>
                        <span class="legal-dot">·</span>
                        <a href="#">{{ __('messages.footer.legal_notice') }}</a>
                    </div>
                </div>
                <div class="col-lg-1 text-center text-lg-end">
                    <a href="#inici" class="back-to-top" id="back-to-top" aria-label="{{ __('messages.footer.back_to_top_aria') }}">
                        <i class="fas fa-arrow-up"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>