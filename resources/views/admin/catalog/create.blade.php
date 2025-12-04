@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Add New Product</h1>
    <a href="{{ route('admin.catalog.index') }}" class="btn btn-outline-secondary">Back to Catalog</a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.catalog.store') }}" method="POST">
                    @csrf

                    <h5 class="mb-3">Product Details</h5>

                    <div class="mb-3">
                        <label for="NAME" class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('NAME') is-invalid @enderror" id="NAME" name="NAME" value="{{ old('NAME') }}" required>
                        @error('NAME')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="DESCRIPTION" class="form-label">Description</label>
                        <textarea class="form-control @error('DESCRIPTION') is-invalid @enderror" id="DESCRIPTION" name="DESCRIPTION" rows="4">{{ old('DESCRIPTION') }}</textarea>
                        @error('DESCRIPTION')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="SKU" class="form-label">SKU</label>
                                <input type="text" class="form-control @error('SKU') is-invalid @enderror" id="SKU" name="SKU" value="{{ old('SKU') }}" placeholder="e.g., COURSE-001">
                                @error('SKU')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Optional unique identifier for the product.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="IMAGE_URL" class="form-label">Image URL</label>
                                <input type="url" class="form-control @error('IMAGE_URL') is-invalid @enderror" id="IMAGE_URL" name="IMAGE_URL" value="{{ old('IMAGE_URL') }}" placeholder="https://example.com/image.jpg">
                                @error('IMAGE_URL')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3">Pricing</h5>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="PRICE_AMOUNT" class="form-label">Price (USD) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" min="0" class="form-control @error('PRICE_AMOUNT') is-invalid @enderror" id="PRICE_AMOUNT" name="PRICE_AMOUNT" value="{{ old('PRICE_AMOUNT', '0.00') }}" required>
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
                                    <option value="one_time" {{ old('PRICE_TYPE', 'one_time') === 'one_time' ? 'selected' : '' }}>One-time Payment</option>
                                    <option value="recurring" {{ old('PRICE_TYPE') === 'recurring' ? 'selected' : '' }}>Recurring (Subscription)</option>
                                </select>
                                @error('PRICE_TYPE')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4" id="recurring-options" style="{{ old('PRICE_TYPE') === 'recurring' ? '' : 'display: none;' }}">
                            <div class="mb-3">
                                <label for="PRICE_INTERVAL" class="form-label">Billing Interval</label>
                                <div class="input-group">
                                    <input type="number" min="1" class="form-control" id="PRICE_INTERVAL_COUNT" name="PRICE_INTERVAL_COUNT" value="{{ old('PRICE_INTERVAL_COUNT', 1) }}" style="max-width: 80px;">
                                    <select class="form-select" id="PRICE_INTERVAL" name="PRICE_INTERVAL">
                                        <option value="month" {{ old('PRICE_INTERVAL', 'month') === 'month' ? 'selected' : '' }}>Month(s)</option>
                                        <option value="year" {{ old('PRICE_INTERVAL') === 'year' ? 'selected' : '' }}>Year(s)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="hidden" name="IS_ACTIVE" value="0">
                            <input class="form-check-input" type="checkbox" name="IS_ACTIVE" value="1" id="IS_ACTIVE" {{ old('IS_ACTIVE', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="IS_ACTIVE">
                                Active (visible to customers)
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.catalog.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-light border-0">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-lightbulb me-1"></i> Tips
                </h6>
                <ul class="mb-0 ps-3">
                    <li class="mb-2">Use a clear, descriptive product name that customers will understand.</li>
                    <li class="mb-2">SKU is optional but helpful for tracking products in your system.</li>
                    <li class="mb-2">For subscriptions, choose the billing interval that matches your service.</li>
                    <li>You can add additional price options later from the product edit page.</li>
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
