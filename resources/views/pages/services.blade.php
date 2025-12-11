<x-public-layout>
    <div class="container">
        <!-- Hero Section -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-5 fw-bold mb-3">Services & Pricing</h1>
                <p class="lead text-muted">
                    Simple, straightforward pricing to help you succeed in your renovation projects.
                </p>
            </div>
        </div>

        <!-- Pricing Section -->
        <div class="row justify-content-center mb-5">
            <div class="col-md-6 col-lg-5 mb-4">
                <div class="card h-100 border-primary shadow">
                    <div class="card-header bg-primary text-white text-center py-4 border-0">
                        <span class="badge bg-warning text-dark mb-2">Best Value</span>
                        <h4 class="mb-0">Annual Video Access</h4>
                        <p class="mb-0 small opacity-75">Complete training library</p>
                    </div>
                    <div class="card-body text-center p-4">
                        <div class="display-4 fw-bold mb-0">$29.99</div>
                        <p class="text-muted">per year</p>
                        <hr>
                        <ul class="list-unstyled text-start mb-4">
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Full access to all training videos
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Learn at your own pace
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Track your progress
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Access on any device
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                New content added regularly
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer bg-white border-0 pb-4 px-4">
                        <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-play-circle me-2"></i> Get Started
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-5 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-dark text-white text-center py-4 border-0">
                        <span class="badge bg-light text-dark mb-2">Personal Guidance</span>
                        <h4 class="mb-0">One-on-One Consultation</h4>
                        <p class="mb-0 small opacity-75">with Stephen Selby</p>
                    </div>
                    <div class="card-body text-center p-4">
                        <div class="display-4 fw-bold mb-0">$75</div>
                        <p class="text-muted">per 30 minutes</p>
                        <hr>
                        <ul class="list-unstyled text-start mb-4">
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Direct access to an expert
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Personalized advice for your project
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Get answers to your specific questions
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Video call or phone consultation
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Flexible scheduling
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer bg-white border-0 pb-4 px-4">
                        <a href="{{ route('catalog.index') }}" class="btn btn-dark btn-lg w-100">
                            <i class="bi bi-calendar-check me-2"></i> Book a Session
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Why Choose Us Section -->
        <div class="row mb-5">
            <div class="col-12 text-center mb-4">
                <h2>Why Choose Renovation Defenders?</h2>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="text-primary mb-3">
                            <i class="bi bi-shield-check" style="font-size: 3rem;"></i>
                        </div>
                        <h5>Protect Your Investment</h5>
                        <p class="text-muted mb-0">
                            Learn how to avoid costly mistakes and ensure your renovation
                            project stays on track and on budget.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="text-success mb-3">
                            <i class="bi bi-mortarboard" style="font-size: 3rem;"></i>
                        </div>
                        <h5>Expert Knowledge</h5>
                        <p class="text-muted mb-0">
                            Benefit from years of industry experience distilled into
                            easy-to-follow training materials.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="text-info mb-3">
                            <i class="bi bi-clock-history" style="font-size: 3rem;"></i>
                        </div>
                        <h5>Learn On Your Schedule</h5>
                        <p class="text-muted mb-0">
                            Access training videos anytime, anywhere. Pause, rewind,
                            and learn at your own pace.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto">
                <div class="text-center mb-4">
                    <h2>Frequently Asked Questions</h2>
                </div>
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                How do I access the training videos?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Once you purchase the annual video access, you'll have immediate access to all
                                training videos through your dashboard. Simply log in and start learning!
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                How do I schedule a consultation with Stephen Selby?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                After purchasing a consultation session, you'll receive an email with a link
                                to schedule your 30-minute call at a time that works for you.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Can I get a refund if I'm not satisfied?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Yes! We offer a 30-day money-back guarantee on our annual video access.
                                If you're not completely satisfied, contact us for a full refund.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                What payment methods do you accept?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                We accept all major credit cards including Visa, Mastercard, American Express,
                                and Discover. All payments are processed securely through Stripe.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact CTA -->
        <div class="row">
            <div class="col-12">
                <div class="card bg-dark text-white border-0">
                    <div class="card-body p-4 p-lg-5 text-center">
                        <h3 class="mb-3">Have Questions?</h3>
                        <p class="mb-4 opacity-75">
                            We're here to help. Reach out to us with any questions about our services.
                        </p>
                        <a href="mailto:info@renovationdefenders.com" class="btn btn-light btn-lg">
                            <i class="bi bi-envelope me-2"></i> Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
