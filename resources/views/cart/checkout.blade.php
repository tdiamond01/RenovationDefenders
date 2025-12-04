<x-app-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <span class="bg-warning bg-opacity-25 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                <i class="bi bi-tools text-warning" style="font-size: 3rem;"></i>
                            </span>
                        </div>

                        <h2 class="mb-3">Checkout Coming Soon!</h2>

                        <p class="text-muted mb-4">
                            We're working hard to bring you a seamless checkout experience.
                            Our secure payment system powered by Stripe will be available shortly.
                        </p>

                        <div class="alert alert-info mb-4">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Want to be notified?</strong><br>
                            <small>Contact us to get early access when checkout goes live.</small>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Back to Cart
                            </a>
                            <a href="{{ route('catalog.index') }}" class="btn btn-primary">
                                <i class="bi bi-shop me-1"></i> Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card mt-4 bg-light border-0">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                            <i class="bi bi-lightning-charge me-1"></i> What to Expect
                        </h6>
                        <div class="row text-center">
                            <div class="col-4">
                                <i class="bi bi-credit-card text-primary d-block mb-2" style="font-size: 1.5rem;"></i>
                                <small>Secure Payments</small>
                            </div>
                            <div class="col-4">
                                <i class="bi bi-receipt text-success d-block mb-2" style="font-size: 1.5rem;"></i>
                                <small>Instant Access</small>
                            </div>
                            <div class="col-4">
                                <i class="bi bi-shield-check text-info d-block mb-2" style="font-size: 1.5rem;"></i>
                                <small>SSL Encrypted</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
