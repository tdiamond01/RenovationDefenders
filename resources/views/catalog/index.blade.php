<x-app-layout>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Product Catalog</h1>
                <p class="text-muted mb-0">Browse our available courses and training materials</p>
            </div>
            <a href="{{ route('cart.index') }}" class="btn btn-outline-primary position-relative">
                <i class="bi bi-cart3"></i> View Cart
                @if(App\Http\Controllers\CartController::getCartCount() > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ App\Http\Controllers\CartController::getCartCount() }}
                    </span>
                @endif
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($products->isEmpty())
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-box-seam text-muted d-block mb-3" style="font-size: 4rem;"></i>
                    <h4 class="text-muted">No Products Available</h4>
                    <p class="text-muted mb-0">Check back soon for new courses and training materials.</p>
                </div>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($products as $product)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        @if($product->IMAGE_URL)
                            <img src="{{ $product->IMAGE_URL }}" class="card-img-top" alt="{{ $product->NAME }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="bi bi-box-seam text-muted" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->NAME }}</h5>
                            @if($product->DESCRIPTION)
                                <p class="card-text text-muted flex-grow-1">
                                    {{ Str::limit($product->DESCRIPTION, 100) }}
                                </p>
                            @endif
                            <div class="mt-auto">
                                @if($product->defaultPrice)
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="h4 mb-0 text-primary">{{ $product->defaultPrice->formatted_amount }}</span>
                                        @if($product->defaultPrice->TYPE === 'recurring')
                                            <span class="badge bg-info">
                                                / {{ $product->defaultPrice->INTERVAL }}
                                            </span>
                                        @endif
                                    </div>
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="price_id" value="{{ $product->defaultPrice->ID }}">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="bi bi-cart-plus me-1"></i> Add to Cart
                                        </button>
                                    </form>
                                @else
                                    <p class="text-muted mb-0">Price not available</p>
                                @endif
                            </div>
                        </div>
                        @if($product->SKU)
                            <div class="card-footer bg-transparent">
                                <small class="text-muted">SKU: {{ $product->SKU }}</small>
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
