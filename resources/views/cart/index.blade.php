<x-app-layout>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Shopping Cart</h1>
                <p class="text-muted mb-0">Review your items before checkout</p>
            </div>
            <a href="{{ route('catalog.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Continue Shopping
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

        @if(empty($cartItems))
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-cart-x text-muted d-block mb-3" style="font-size: 4rem;"></i>
                    <h4 class="text-muted">Your Cart is Empty</h4>
                    <p class="text-muted mb-4">Looks like you haven't added any items to your cart yet.</p>
                    <a href="{{ route('catalog.index') }}" class="btn btn-primary">
                        <i class="bi bi-shop me-1"></i> Browse Catalog
                    </a>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Cart Items ({{ count($cartItems) }})</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th style="width: 120px;">Quantity</th>
                                            <th class="text-end">Subtotal</th>
                                            <th style="width: 50px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cartItems as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item['product']->IMAGE_URL)
                                                        <img src="{{ $item['product']->IMAGE_URL }}" alt="{{ $item['product']->NAME }}" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                            <i class="bi bi-box text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">{{ $item['product']->NAME }}</h6>
                                                        @if($item['price']->TYPE === 'recurring')
                                                            <small class="text-info">
                                                                <i class="bi bi-arrow-repeat"></i>
                                                                Billed {{ $item['price']->INTERVAL }}ly
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $item['price']->formatted_amount }}</td>
                                            <td>
                                                @if($item['price']->TYPE === 'recurring')
                                                    <span class="text-muted">1</span>
                                                @else
                                                    <form action="{{ route('cart.update') }}" method="POST" class="d-flex">
                                                        @csrf
                                                        <input type="hidden" name="price_id" value="{{ $item['price']->ID }}">
                                                        <select name="quantity" class="form-select form-select-sm" style="width: 70px;" onchange="this.form.submit()">
                                                            @for($i = 1; $i <= 10; $i++)
                                                                <option value="{{ $i }}" {{ $item['quantity'] == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </form>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <strong>${{ number_format($item['subtotal'] / 100, 2) }}</strong>
                                            </td>
                                            <td>
                                                <form action="{{ route('cart.remove') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="price_id" value="{{ $item['price']->ID }}">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Remove">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-secondary" onclick="return confirm('Are you sure you want to clear your cart?')">
                                    <i class="bi bi-x-circle me-1"></i> Clear Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span>${{ number_format($total / 100, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax</span>
                                <span class="text-muted">Calculated at checkout</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Estimated Total</strong>
                                <strong class="text-primary">${{ number_format($total / 100, 2) }}</strong>
                            </div>
                            <a href="{{ route('cart.checkout') }}" class="btn btn-primary w-100 btn-lg">
                                <i class="bi bi-lock me-1"></i> Proceed to Checkout
                            </a>
                        </div>
                    </div>

                    <div class="card mt-3 bg-light border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-shield-check text-success me-2"></i>
                                <small>Secure checkout</small>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-credit-card text-primary me-2"></i>
                                <small>All major cards accepted</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-arrow-counterclockwise text-info me-2"></i>
                                <small>30-day money back guarantee</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
