@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Manage Prices</h1>
        <p class="text-muted mb-0">{{ $product->NAME }}</p>
    </div>
    <a href="{{ route('admin.catalog.edit', $product->ID) }}" class="btn btn-outline-secondary">Back to Product</a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Existing Prices</h5>
            </div>
            <div class="card-body">
                @if($product->prices->isEmpty())
                    <p class="text-muted text-center py-4 mb-0">
                        <i class="bi bi-currency-dollar d-block mb-2" style="font-size: 2rem;"></i>
                        No prices configured yet. Add a price below.
                    </p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Interval</th>
                                    <th>Status</th>
                                    <th>Stripe ID</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->prices as $price)
                                <tr>
                                    <td><strong>{{ $price->formatted_amount }}</strong></td>
                                    <td>
                                        @if($price->TYPE === 'recurring')
                                            <span class="badge bg-info">
                                                <i class="bi bi-arrow-repeat me-1"></i> Recurring
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">One-time</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($price->TYPE === 'recurring')
                                            {{ $price->INTERVAL_COUNT }} {{ ucfirst($price->INTERVAL) }}(s)
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $price->IS_ACTIVE ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $price->IS_ACTIVE ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($price->STRIPE_PRICE_ID)
                                            <code class="small">{{ Str::limit($price->STRIPE_PRICE_ID, 20) }}</code>
                                        @else
                                            <span class="text-muted">Not synced</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.catalog.delete-price', [$product->ID, $price->ID]) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this price?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Add New Price</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.catalog.add-price', $product->ID) }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="AMOUNT" class="form-label">Price (USD) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" min="0" class="form-control @error('AMOUNT') is-invalid @enderror" id="AMOUNT" name="AMOUNT" value="{{ old('AMOUNT', '0.00') }}" required>
                                </div>
                                @error('AMOUNT')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="TYPE" class="form-label">Price Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('TYPE') is-invalid @enderror" id="TYPE" name="TYPE" required>
                                    <option value="one_time" {{ old('TYPE', 'one_time') === 'one_time' ? 'selected' : '' }}>One-time Payment</option>
                                    <option value="recurring" {{ old('TYPE') === 'recurring' ? 'selected' : '' }}>Recurring (Subscription)</option>
                                </select>
                                @error('TYPE')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4" id="add-recurring-options" style="{{ old('TYPE') === 'recurring' ? '' : 'display: none;' }}">
                            <div class="mb-3">
                                <label for="INTERVAL" class="form-label">Billing Interval</label>
                                <div class="input-group">
                                    <input type="number" min="1" class="form-control" id="INTERVAL_COUNT" name="INTERVAL_COUNT" value="{{ old('INTERVAL_COUNT', 1) }}" style="max-width: 80px;">
                                    <select class="form-select" id="INTERVAL" name="INTERVAL">
                                        <option value="month" {{ old('INTERVAL', 'month') === 'month' ? 'selected' : '' }}>Month(s)</option>
                                        <option value="year" {{ old('INTERVAL') === 'year' ? 'selected' : '' }}>Year(s)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="hidden" name="IS_ACTIVE" value="0">
                            <input class="form-check-input" type="checkbox" name="IS_ACTIVE" value="1" id="IS_ACTIVE" {{ old('IS_ACTIVE', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="IS_ACTIVE">
                                Active
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Add Price
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-light border-0">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-lightbulb me-1"></i> About Multiple Prices
                </h6>
                <p class="card-text text-muted small">
                    You can add multiple prices to offer different payment options:
                </p>
                <ul class="small text-muted ps-3 mb-0">
                    <li class="mb-2"><strong>Monthly subscription</strong> for ongoing access</li>
                    <li class="mb-2"><strong>Annual subscription</strong> at a discounted rate</li>
                    <li class="mb-2"><strong>One-time purchase</strong> for lifetime access</li>
                    <li><strong>Team pricing</strong> at different price points</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('TYPE').addEventListener('change', function() {
    document.getElementById('add-recurring-options').style.display = this.value === 'recurring' ? '' : 'none';
});
</script>
@endsection
