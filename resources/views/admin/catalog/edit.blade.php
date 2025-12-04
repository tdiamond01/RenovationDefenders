@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Edit Product</h1>
    <a href="{{ route('admin.catalog.index') }}" class="btn btn-outline-secondary">Back to Catalog</a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.catalog.update', $product->ID) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h5 class="mb-3">Product Details</h5>

                    <div class="mb-3">
                        <label for="NAME" class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('NAME') is-invalid @enderror" id="NAME" name="NAME" value="{{ old('NAME', $product->NAME) }}" required>
                        @error('NAME')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="DESCRIPTION" class="form-label">Description</label>
                        <textarea class="form-control @error('DESCRIPTION') is-invalid @enderror" id="DESCRIPTION" name="DESCRIPTION" rows="4">{{ old('DESCRIPTION', $product->DESCRIPTION) }}</textarea>
                        @error('DESCRIPTION')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="SKU" class="form-label">SKU</label>
                                <input type="text" class="form-control @error('SKU') is-invalid @enderror" id="SKU" name="SKU" value="{{ old('SKU', $product->SKU) }}" placeholder="e.g., COURSE-001">
                                @error('SKU')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Optional unique identifier for the product.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="IMAGE_URL" class="form-label">Image URL</label>
                                <input type="url" class="form-control @error('IMAGE_URL') is-invalid @enderror" id="IMAGE_URL" name="IMAGE_URL" value="{{ old('IMAGE_URL', $product->IMAGE_URL) }}" placeholder="https://example.com/image.jpg">
                                @error('IMAGE_URL')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3">Default Pricing</h5>

                    @php
                        $defaultPrice = $product->prices->where('IS_ACTIVE', true)->first();
                    @endphp

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="PRICE_AMOUNT" class="form-label">Price (USD) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" min="0" class="form-control @error('PRICE_AMOUNT') is-invalid @enderror" id="PRICE_AMOUNT" name="PRICE_AMOUNT" value="{{ old('PRICE_AMOUNT', $defaultPrice ? number_format($defaultPrice->AMOUNT / 100, 2, '.', '') : '0.00') }}" required>
                                </div>
                                @error('PRICE_AMOUNT')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="PRICE_TYPE" class="form-label">Price Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('PRICE_TYPE') is-invalid @enderror" id="PRICE_TYPE" name="PRICE_TYPE" required>
                                    <option value="one_time" {{ old('PRICE_TYPE', $defaultPrice?->TYPE) === 'one_time' ? 'selected' : '' }}>One-time Payment</option>
                                    <option value="recurring" {{ old('PRICE_TYPE', $defaultPrice?->TYPE) === 'recurring' ? 'selected' : '' }}>Recurring (Subscription)</option>
                                </select>
                                @error('PRICE_TYPE')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4" id="recurring-options" style="{{ old('PRICE_TYPE', $defaultPrice?->TYPE) === 'recurring' ? '' : 'display: none;' }}">
                            <div class="mb-3">
                                <label for="PRICE_INTERVAL" class="form-label">Billing Interval</label>
                                <div class="input-group">
                                    <input type="number" min="1" class="form-control" id="PRICE_INTERVAL_COUNT" name="PRICE_INTERVAL_COUNT" value="{{ old('PRICE_INTERVAL_COUNT', $defaultPrice?->INTERVAL_COUNT ?? 1) }}" style="max-width: 80px;">
                                    <select class="form-select" id="PRICE_INTERVAL" name="PRICE_INTERVAL">
                                        <option value="month" {{ old('PRICE_INTERVAL', $defaultPrice?->INTERVAL) === 'month' ? 'selected' : '' }}>Month(s)</option>
                                        <option value="year" {{ old('PRICE_INTERVAL', $defaultPrice?->INTERVAL) === 'year' ? 'selected' : '' }}>Year(s)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <a href="{{ route('admin.catalog.prices', $product->ID) }}" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-currency-dollar me-1"></i> Manage All Prices ({{ $product->prices->count() }})
                        </a>
                    </div>

                    <hr class="my-4">

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="hidden" name="IS_ACTIVE" value="0">
                            <input class="form-check-input" type="checkbox" name="IS_ACTIVE" value="1" id="IS_ACTIVE" {{ old('IS_ACTIVE', $product->IS_ACTIVE) ? 'checked' : '' }}>
                            <label class="form-check-label" for="IS_ACTIVE">
                                Active (visible to customers)
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.catalog.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        @if($product->STRIPE_PRODUCT_ID)
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-stripe me-1"></i> Stripe Integration
                </h6>
                <p class="mb-1"><strong>Product ID:</strong></p>
                <code class="d-block mb-2">{{ $product->STRIPE_PRODUCT_ID }}</code>
                @if($defaultPrice?->STRIPE_PRICE_ID)
                    <p class="mb-1"><strong>Price ID:</strong></p>
                    <code class="d-block">{{ $defaultPrice->STRIPE_PRICE_ID }}</code>
                @endif
            </div>
        </div>
        @endif

        <div class="card bg-light border-0">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-info-circle me-1"></i> Product Info
                </h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <small class="text-muted">Created:</small><br>
                        {{ $product->created_at->format('M d, Y \a\t g:i A') }}
                    </li>
                    <li class="mb-2">
                        <small class="text-muted">Last Updated:</small><br>
                        {{ $product->updated_at->format('M d, Y \a\t g:i A') }}
                    </li>
                    <li>
                        <small class="text-muted">Total Prices:</small><br>
                        {{ $product->prices->count() }} price option(s)
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('PRICE_TYPE').addEventListener('change', function() {
    document.getElementById('recurring-options').style.display = this.value === 'recurring' ? '' : 'none';
});
</script>
@endsection
