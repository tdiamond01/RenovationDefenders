<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Price;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::with('defaultPrice')
            ->withCount('prices')
            ->orderBy('ID', 'desc')
            ->paginate(20);

        return view('admin.catalog.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('admin.catalog.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'NAME' => 'required|string|max:255',
            'DESCRIPTION' => 'nullable|string',
            'SKU' => 'nullable|string|max:255|unique:PRODUCTS,SKU',
            'IMAGE_URL' => 'nullable|url|max:500',
            'IS_ACTIVE' => 'boolean',
            'PRICE_AMOUNT' => 'required|numeric|min:0',
            'PRICE_TYPE' => 'required|in:one_time,recurring',
            'PRICE_INTERVAL' => 'nullable|in:month,year',
            'PRICE_INTERVAL_COUNT' => 'nullable|integer|min:1',
        ]);

        // Create the product
        $product = Product::create([
            'NAME' => $validated['NAME'],
            'DESCRIPTION' => $validated['DESCRIPTION'] ?? null,
            'SKU' => $validated['SKU'] ?? null,
            'IMAGE_URL' => $validated['IMAGE_URL'] ?? null,
            'IS_ACTIVE' => $request->boolean('IS_ACTIVE', true),
        ]);

        // Create the default price
        $priceData = [
            'PRODUCT_ID' => $product->ID,
            'AMOUNT' => (int) ($validated['PRICE_AMOUNT'] * 100), // Convert to cents
            'CURRENCY' => 'USD',
            'TYPE' => $validated['PRICE_TYPE'],
            'IS_ACTIVE' => true,
        ];

        if ($validated['PRICE_TYPE'] === 'recurring') {
            $priceData['INTERVAL'] = $validated['PRICE_INTERVAL'] ?? 'month';
            $priceData['INTERVAL_COUNT'] = $validated['PRICE_INTERVAL_COUNT'] ?? 1;
        }

        Price::create($priceData);

        return redirect()->route('admin.catalog.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     */
    public function show(string $id)
    {
        $product = Product::with('prices')->findOrFail($id);
        return view('admin.catalog.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(string $id)
    {
        $product = Product::with('prices')->findOrFail($id);
        return view('admin.catalog.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'NAME' => 'required|string|max:255',
            'DESCRIPTION' => 'nullable|string',
            'SKU' => 'nullable|string|max:255|unique:PRODUCTS,SKU,' . $id . ',ID',
            'IMAGE_URL' => 'nullable|url|max:500',
            'IS_ACTIVE' => 'boolean',
            'PRICE_AMOUNT' => 'required|numeric|min:0',
            'PRICE_TYPE' => 'required|in:one_time,recurring',
            'PRICE_INTERVAL' => 'nullable|in:month,year',
            'PRICE_INTERVAL_COUNT' => 'nullable|integer|min:1',
        ]);

        // Update the product
        $product->update([
            'NAME' => $validated['NAME'],
            'DESCRIPTION' => $validated['DESCRIPTION'] ?? null,
            'SKU' => $validated['SKU'] ?? null,
            'IMAGE_URL' => $validated['IMAGE_URL'] ?? null,
            'IS_ACTIVE' => $request->boolean('IS_ACTIVE', true),
        ]);

        // Update or create the default price
        $defaultPrice = $product->prices()->where('IS_ACTIVE', true)->first();

        $priceData = [
            'AMOUNT' => (int) ($validated['PRICE_AMOUNT'] * 100), // Convert to cents
            'TYPE' => $validated['PRICE_TYPE'],
            'INTERVAL' => $validated['PRICE_TYPE'] === 'recurring' ? ($validated['PRICE_INTERVAL'] ?? 'month') : null,
            'INTERVAL_COUNT' => $validated['PRICE_TYPE'] === 'recurring' ? ($validated['PRICE_INTERVAL_COUNT'] ?? 1) : null,
        ];

        if ($defaultPrice) {
            $defaultPrice->update($priceData);
        } else {
            $priceData['PRODUCT_ID'] = $product->ID;
            $priceData['CURRENCY'] = 'USD';
            $priceData['IS_ACTIVE'] = true;
            Price::create($priceData);
        }

        return redirect()->route('admin.catalog.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete(); // Prices will be cascade deleted

        return redirect()->route('admin.catalog.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Manage prices for a specific product.
     */
    public function prices(string $id)
    {
        $product = Product::with('prices')->findOrFail($id);
        return view('admin.catalog.prices', compact('product'));
    }

    /**
     * Add a new price to a product.
     */
    public function addPrice(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'AMOUNT' => 'required|numeric|min:0',
            'TYPE' => 'required|in:one_time,recurring',
            'INTERVAL' => 'nullable|in:month,year',
            'INTERVAL_COUNT' => 'nullable|integer|min:1',
            'IS_ACTIVE' => 'boolean',
        ]);

        $priceData = [
            'PRODUCT_ID' => $product->ID,
            'AMOUNT' => (int) ($validated['AMOUNT'] * 100),
            'CURRENCY' => 'USD',
            'TYPE' => $validated['TYPE'],
            'IS_ACTIVE' => $request->boolean('IS_ACTIVE', true),
        ];

        if ($validated['TYPE'] === 'recurring') {
            $priceData['INTERVAL'] = $validated['INTERVAL'] ?? 'month';
            $priceData['INTERVAL_COUNT'] = $validated['INTERVAL_COUNT'] ?? 1;
        }

        Price::create($priceData);

        return redirect()->route('admin.catalog.prices', $id)
            ->with('success', 'Price added successfully.');
    }

    /**
     * Delete a price from a product.
     */
    public function deletePrice(string $productId, string $priceId)
    {
        $price = Price::where('ID', $priceId)
            ->where('PRODUCT_ID', $productId)
            ->firstOrFail();

        $price->delete();

        return redirect()->route('admin.catalog.prices', $productId)
            ->with('success', 'Price deleted successfully.');
    }
}
