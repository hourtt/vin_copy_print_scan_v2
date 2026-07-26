<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
