<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Display the product catalog for users.
     */
    public function index()
    {
        $products = Product::with('defaultPrice')
            ->where('IS_ACTIVE', true)
            ->orderBy('NAME')
            ->paginate(12);

        return view('catalog.index', compact('products'));
    }

    /**
     * Display a single product.
     */
    public function show(string $id)
    {
        $product = Product::with('activePrices')
            ->where('IS_ACTIVE', true)
            ->findOrFail($id);

        return view('catalog.show', compact('product'));
    }
}
