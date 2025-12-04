<div class="top-ribbon bg-dark text-white py-1">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('about') }}" class="text-white text-decoration-none small">
                    <i class="bi bi-info-circle me-1"></i> About Us
                </a>
                <a href="{{ route('services') }}" class="text-white text-decoration-none small">
                    <i class="bi bi-briefcase me-1"></i> Services & Pricing
                </a>
            </div>
            <div class="d-none d-md-flex align-items-center gap-3">
                <span class="small">
                    <i class="bi bi-envelope me-1"></i> info@renovationdefenders.com
                </span>
                <span class="small">
                    <i class="bi bi-telephone me-1"></i> (555) 123-4567
                </span>
            </div>
        </div>
    </div>
</div>

<style>
.top-ribbon {
    font-size: 0.85rem;
}
.top-ribbon a:hover {
    text-decoration: underline !important;
}
</style>
