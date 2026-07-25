<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

use App\Services\BreadcrumbTrail;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request, BreadcrumbTrail $breadcrumbTrail)
    {
        $cartItems = $this->cartService->getCartItems();
        $subtotal = $this->cartService->getSubtotal();
        $breadcrumbs = $breadcrumbTrail->resolveForCart();

        return view('cart.index', compact('cartItems', 'subtotal', 'breadcrumbs'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1',
        ]);

        $quantity = $request->input('quantity', 1);
        $this->cartService->add($product->getKey(), $quantity);

        if ($request->expectsJson()) {
            $cartCount = $this->cartService->getCartItems()->sum('quantity');
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'count' => $cartCount
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $this->cartService->update($product->getKey(), $request->input('quantity'));

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }

    public function remove(Product $product)
    {
        $this->cartService->remove($product->getKey());

        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }

    public function clear()
    {
        $this->cartService->clear();

        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully.');
    }
}
