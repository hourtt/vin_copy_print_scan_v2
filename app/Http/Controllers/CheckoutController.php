<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ShippingMethod;
use App\Http\Requests\StoreCheckoutRequest;

class CheckoutController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display the checkout page.
     */
    public function index()
    {
        $cartItems = $this->cartService->getCartItems();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $this->cartService->getSubtotal();
        // Get all active shipping methods
        $shippingMethods = ShippingMethod::where('is_active', true)->get();
        // default to first shipping method fee if exists
        $shippingFee = $shippingMethods->first() ? $shippingMethods->first()->fee : 0;
        $total = $subtotal + $shippingFee;

        // Pass user's saved addresses
        $addresses = auth()->user()->addresses;

        return view('checkout.index', compact('cartItems', 'subtotal', 'shippingMethods', 'shippingFee', 'total', 'addresses'));
    }

    /**
     * Handle the checkout submission.
     */
    public function store(StoreCheckoutRequest $request)
    {
        $validated = $request->validated();

        //  Single fetch with product eager-loaded — reused throughout the entire method
        $cartItems = $this->cartService->getCartItems()->loadMissing('product');
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        //  Compute subtotal in PHP from the already-loaded collection (no extra DB call)
        $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);
        $shippingMethod = ShippingMethod::find($request->shipping_method_id);
        $shippingFee = $shippingMethod ? $shippingMethod->fee : 0;
        $total = $subtotal + $shippingFee;

        // In a real app we might validate voucher code here and deduct discount

        DB::beginTransaction();

        try {
            if ($request->has('save_address')) {
                $user = $request->user();
                $isFirst = $user->addresses()->count() === 0;
                $user->addresses()->create([
                    'phone_number' => $request->phone_number,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state_province,
                    'zip_code' => $request->zip_code,
                    'is_default' => $isFirst
                ]);
            }

            $order = Order::create([
                'user_id' => $request->user()->id,
                'order_date' => now(),
                'subtotal' => $subtotal,
                'shipping_method_id' => $request->shipping_method_id,
                'shipping_fee' => $shippingFee,
                'shipping_address' => "Name: {$request->first_name} {$request->name}\nPhone: {$request->phone_number}\nAddress: {$request->address}\nCity: {$request->city}\nState: {$request->state_province}\nZip: {$request->zip_code}",
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'city' => $request->city,
                'state_province' => $request->state_province,
                'zip_code' => $request->zip_code,
                'order_notes' => $request->order_notes,
                'total' => $total,
                'status' => 'pending', // Pending payment
            ]);

            //  Reuse the already-loaded $cartItems collection — no third DB call
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product->price,
                    'subtotal' => $item->quantity * $item->product->price,
                ]);
            }

            // Clear the cart
            $this->cartService->clear();
            app(\App\Services\BreadcrumbTrail::class)->reset();

            DB::commit();

            // Handle payment method
            if ($request->payment_method === 'cod') {
                //  Eager-load items.product before the loop — prevents N+1 on decrement
                $order->load('items.product');
                foreach ($order->items as $orderItem) {
                    $orderItem->product->decrement('stock', $orderItem->quantity);
                }

                $order->update(['status' => 'processing']);
                return redirect()->route('checkout.success', ['order' => $order->id])->with('success', 'Order placed successfully.');
            } elseif ($request->payment_method === 'stripe') {
                // Redirect to Stripe Checkout Controller
                return redirect()->route('checkout.stripe', ['order' => $order->id]);
            } elseif ($request->payment_method === 'aba') {
                // Redirect to ABA PayWay Checkout Controller
                return redirect()->route('checkout.aba', ['order' => $order->id]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred while creating your order. Please try again.');
        }
    }

    /**
     * Display the success page.
     */
    public function success(Request $request)
    {
        $order = Order::where('user_id', $request->user()->id)
            ->where('id', $request->query('order'))
            ->with('items.product')
            ->firstOrFail();

        return view('checkout.success', compact('order'));
    }

    /**
     * Display the cancel page.
     */
    public function cancel(Request $request)
    {
        $order = Order::where('user_id', $request->user()->id)
            ->where('id', $request->query('order'))
            ->firstOrFail();

        return view('checkout.cancel', compact('order'));
    }
}
