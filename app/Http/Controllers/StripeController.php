<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public function checkout(Order $order)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'pending') {
            abort(403);
        }

        //  Eager-load items.product to prevent N+1 inside the foreach loop
        $order->load('items.product');

        Stripe::setApiKey(config('payments.stripe.secret'));
        $lineItems = [];
        foreach ($order->items as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item->product->name,
                    ],
                    'unit_amount' => intval($item->unit_price * 100),
                ],
                'quantity' => $item->quantity,
            ];
        }

        if ($order->shipping_fee > 0) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Shipping Fee',
                    ],
                    'unit_amount' => intval($order->shipping_fee * 100),
                ],
                'quantity' => 1,
            ];
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', ['order' => $order->id]) . '&session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel', ['order' => $order->id]),
            'metadata' => [
                'order_id' => $order->id,
            ],
        ]);

        return redirect($session->url);
    }

    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('payments.stripe.webhook_secret');

        // If secret is not set, just mock validation (for local testing without CLI)
        if (!$endpoint_secret) {
            $event = json_decode($payload);
        } else {
            try {
                $event = \Stripe\Webhook::constructEvent(
                    $payload, $sig_header, $endpoint_secret
                );
            } catch (\Exception $e) {
                return response('Webhook Error: ' . $e->getMessage(), 400);
            }
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $orderId = $session->metadata->order_id ?? null;

            if ($orderId) {
                //  Eager-load items.product to prevent N+1 inside the foreach loop
                $order = Order::with('items.product')->find($orderId);
                if ($order && $order->status === 'pending') {
                    $order->update(['status' => 'processing']);
                    
                    // Decrement stock
                    foreach ($order->items as $orderItem) {
                        $orderItem->product->decrement('stock', $orderItem->quantity);
                    }
                }
            }
        }

        return response('Webhook Handled', 200);
    }
}
