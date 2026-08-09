<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->order_number ?? $order->id }}</title>
    <style>
        body { font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; color: #333; }
        .invoice-box { max-w-full; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, .15); }
        .invoice-box table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
        .invoice-box table td { padding: 5px; vertical-align: top; }
        .invoice-box table tr td:nth-child(2) { text-align: right; }
        .invoice-box table tr.top table td { padding-bottom: 20px; }
        .invoice-box table tr.top table td.title { font-size: 45px; line-height: 45px; color: #333; }
        .invoice-box table tr.information table td { padding-bottom: 40px; }
        .invoice-box table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; }
        .invoice-box table tr.item td { border-bottom: 1px solid #eee; }
        .invoice-box table tr.item.last td { border-bottom: none; }
        .invoice-box table tr.total td:nth-child(2) { border-top: 2px solid #eee; font-weight: bold; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <h2>Vin Copy Print Scan</h2>
                            </td>
                            <td>
                                Invoice #: {{ $order->order_number ?? $order->id }}<br>
                                Created: {{ $order->created_at->format('M d, Y') }}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                {{ $order->shipping_address ?? 'No Address' }}
                            </td>
                            <td>
                                {{ $order->user->first_name }} {{ $order->user->last_name }}<br>
                                {{ $order->user->email }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>Item</td>
                <td>Price</td>
            </tr>
            @foreach($order->items as $item)
            <tr class="item {{ $loop->last ? 'last' : '' }}">
                <td>{{ $item->product->name }} (x{{ $item->quantity }})</td>
                <td>${{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
            <tr class="total">
                <td></td>
                <td>Subtotal: ${{ number_format($order->subtotal, 2) }}</td>
            </tr>
            <tr class="total">
                <td></td>
                <td>Shipping: ${{ number_format($order->shipping_fee, 2) }}</td>
            </tr>
            <tr class="total">
                <td></td>
                <td>Total: ${{ number_format($order->total, 2) }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
