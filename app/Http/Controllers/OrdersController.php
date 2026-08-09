<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
class OrdersController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index(Request $request)
    {
        $orders = Order::whereBelongsTo($request->user())
            ->with(['items.product', 'shippingMethod'])
            ->latest('order_date')
            ->paginate(10);

        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('dashboard')],
            ['label' => 'My Orders'],
        ];

        return view('orders.index', compact('orders', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified orders.
     */
    public function show(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403, 'Unauthorized access to this order.');

        $order->load([
            'items.product.images',
            'shippingMethod',
        ]);

        return view('orders.show', compact('order'));
    }

    /**
     * Generate and download the order invoice.
     */
    public function invoice(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403, 'Unauthorized access to this order.');

        $order->load(['items.product', 'shippingMethod']);

        $pdf = PDF::loadView('orders.invoice', compact('order'));
        return $pdf->download('invoice-'.$order->order_number.'.pdf');
    }

    /**
     * Reorder items from a previous order.
     */
    public function reorder(Order $order, CartService $cartService)
    {
        abort_if($order->user_id !== auth()->id(), 403, 'Unauthorized access to this order.');

        $order->load('items');

        foreach ($order->items as $item) {
            $cartService->add($item->product_id, $item->quantity);
        }

        return redirect()->route('cart.index')->with('success', 'Items added to your cart.');
    }

    /**
     * Cancel an order within 24 hours.
     */
    public function cancel(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403, 'Unauthorized access to this order.');

        if (!in_array($order->status, ['pending', 'processing'])) {
            return back()->with('error', 'This order cannot be cancelled as it is already being processed or shipped.');
        }

        if (now()->diffInHours($order->created_at) > 24) {
            return back()->with('error', 'Orders can only be cancelled within 24 hours of placement.');
        }

        DB::transaction(function () use ($order) {
            $order->update(['status' => 'cancelled']);

            // Restore stock
            $order->load('items.product');
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
        });

        return back()->with('success', 'Order has been successfully cancelled.');
    }
}
