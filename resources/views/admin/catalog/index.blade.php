@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Product Catalog</h1>
    <a href="{{ route('admin.catalog.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Add New Product
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>SKU</th>
                        <th>Price</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr style="cursor: pointer;" onclick="window.location='{{ route('admin.catalog.edit', $product->ID) }}';">
                        <td>{{ $product->ID }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($product->IMAGE_URL)
                                    <img src="{{ $product->IMAGE_URL }}" alt="{{ $product->NAME }}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="bi bi-box text-white"></i>
                                    </div>
                                @endif
                                <span>{{ $product->NAME }}</span>
                            </div>
                        </td>
                        <td>
                            @if($product->SKU)
                                <code>{{ $product->SKU }}</code>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($product->defaultPrice)
                                <strong>{{ $product->defaultPrice->formatted_amount }}</strong>
                            @else
                                <span class="text-muted">No price</span>
                            @endif
                        </td>
                        <td>
                            @if($product->defaultPrice)
                                @if($product->defaultPrice->TYPE === 'recurring')
                                    <span class="badge bg-info">
                                        <i class="bi bi-arrow-repeat me-1"></i>
                                        {{ ucfirst($product->defaultPrice->INTERVAL) }}ly
                                    </span>
                                @else
                                    <span class="badge bg-secondary">One-time</span>
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $product->IS_ACTIVE ? 'bg-success' : 'bg-secondary' }}">
                                {{ $product->IS_ACTIVE ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>{{ $product->created_at ? $product->created_at->format('M d, Y') : '-' }}</td>
                        <td onclick="event.stopPropagation();">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.catalog.edit', $product->ID) }}" class="btn btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="{{ route('admin.catalog.prices', $product->ID) }}" class="btn btn-outline-info" title="Manage Prices">
                                    <i class="bi bi-currency-dollar"></i>
                                </a>
                                <form action="{{ route('admin.catalog.destroy', $product->ID) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-box-seam d-block mb-2" style="font-size: 2rem;"></i>
                            No products found. <a href="{{ route('admin.catalog.create') }}">Add your first product</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $products->links() }}
</div>

<div class="card mt-4 bg-light border-0">
    <div class="card-body">
        <h6 class="card-title">
            <i class="bi bi-info-circle me-1"></i> Stripe Integration (Coming Soon)
        </h6>
        <p class="card-text text-muted mb-0">
            Products created here will be synced with Stripe when the integration is configured.
            The <code>STRIPE_PRODUCT_ID</code> and <code>STRIPE_PRICE_ID</code> fields will be populated automatically.
        </p>
    </div>
</div>
@endsection
