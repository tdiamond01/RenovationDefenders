<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Price;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $priceId => $quantity) {
            $price = Price::with('product')->find($priceId);
            if ($price && $price->product && $price->product->IS_ACTIVE) {
                $subtotal = $price->AMOUNT * $quantity;
                $cartItems[] = [
                    'price' => $price,
                    'product' => $price->product,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ];
                $total += $subtotal;
            }
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'price_id' => 'required|exists:PRICES,ID',
            'quantity' => 'integer|min:1|max:10',
        ]);

        $priceId = $request->price_id;
        $quantity = $request->input('quantity', 1);

        // Verify price is active and product is active
        $price = Price::with('product')->findOrFail($priceId);
        if (!$price->IS_ACTIVE || !$price->product->IS_ACTIVE) {
            return back()->with('error', 'This product is no longer available.');
        }

        $cart = session()->get('cart', []);

        // For recurring items, only allow quantity of 1
        if ($price->TYPE === 'recurring') {
            $cart[$priceId] = 1;
        } else {
            if (isset($cart[$priceId])) {
                $cart[$priceId] += $quantity;
            } else {
                $cart[$priceId] = $quantity;
            }
        }

        session()->put('cart', $cart);

        return back()->with('success', $price->product->NAME . ' added to cart!');
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request)
    {
        $request->validate([
            'price_id' => 'required|exists:PRICES,ID',
            'quantity' => 'required|integer|min:0|max:10',
        ]);

        $priceId = $request->price_id;
        $quantity = $request->quantity;

        $cart = session()->get('cart', []);

        if ($quantity <= 0) {
            unset($cart[$priceId]);
        } else {
            $cart[$priceId] = $quantity;
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Cart updated.');
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(Request $request)
    {
        $request->validate([
            'price_id' => 'required|exists:PRICES,ID',
        ]);

        $cart = session()->get('cart', []);
        unset($cart[$request->price_id]);
        session()->put('cart', $cart);

        return back()->with('success', 'Item removed from cart.');
    }

    /**
     * Clear the entire cart.
     */
    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared.');
    }

    /**
     * Checkout page (coming soon).
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        return view('cart.checkout');
    }

    /**
     * Get cart count for navigation badge.
     */
    public static function getCartCount(): int
    {
        $cart = session()->get('cart', []);
        return array_sum($cart);
    }
}
