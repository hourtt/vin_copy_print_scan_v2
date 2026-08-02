<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    /**
     * Get all items in the cart (as a Collection of CartItem models with product relation).
     */
    public function getCartItems()
    {
        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            return $cart->items()->with('product')->get();
        }

        $sessionCart = Session::get('cart', []);
        $items = collect();

        if (!empty($sessionCart)) {
            // Single query: fetch all products at once instead of N individual finds
            $products = Product::whereIn('id', array_keys($sessionCart))->get()->keyBy('id');

            foreach ($sessionCart as $productId => $details) {
                $product = $products->get($productId);
                if ($product) {
                    $item = new CartItem([
                        'product_id' => $productId,
                        'quantity'   => $details['quantity'],
                    ]);
                    $item->setRelation('product', $product);
                    $items->push($item);
                }
            }
        }

        return $items;
    }

    /**
     * Add a product to the cart.
     */
    public function add($productId, $quantity = 1)
    {
        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $item = $cart->items()->where('product_id', $productId)->first();
            if ($item) {
                $item->quantity += $quantity;
                $item->save();
            } else {
                $cart->items()->create([
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $quantity;
            } else {
                $cart[$productId] = [
                    'quantity' => $quantity,
                ];
            }
            Session::put('cart', $cart);
        }
    }

    /**
     * Update cart item quantity.
     */
    public function update($productId, $quantity)
    {
        if ($quantity <= 0) {
            $this->remove($productId);
            return;
        }

        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $item = $cart->items()->where('product_id', $productId)->first();
            if ($item) {
                $item->quantity = $quantity;
                $item->save();
            }
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $quantity;
                Session::put('cart', $cart);
            }
        }
    }

    /**
     * Remove an item from the cart.
     */
    public function remove($productId)
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            if ($cart) {
                $cart->items()->where('product_id', $productId)->delete();
            }
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$productId])) {
                unset($cart[$productId]);
                Session::put('cart', $cart);
            }
        }
    }

    /**
     * Empty the cart entirely.
     */
    public function clear()
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            if ($cart) {
                $cart->items()->delete();
            }
        } else {
            Session::forget('cart');
        }
    }

    /**
     * Merge session cart to DB cart upon user login.
     */
    public function mergeSessionToDb()
    {
        if (!Auth::check()) return;

        $sessionCart = Session::get('cart', []);
        if (empty($sessionCart)) return;

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        foreach ($sessionCart as $productId => $details) {
            $item = $cart->items()->where('product_id', $productId)->first();
            if ($item) {
                $item->quantity += $details['quantity'];
                $item->save();
            } else {
                $cart->items()->create([
                    'product_id' => $productId,
                    'quantity' => $details['quantity'],
                ]);
            }
        }

        Session::forget('cart');
    }

    /**
     * Get the subtotal cost of the cart.
     */
    public function getSubtotal()
    {
        $items = $this->getCartItems();
        return $items->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }

    /**
     * Get the total item count.
     */
    public function getItemCount()
    {
        $items = $this->getCartItems();
        return $items->sum('quantity');
    }
}
