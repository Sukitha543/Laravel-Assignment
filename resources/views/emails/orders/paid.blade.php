<!DOCTYPE html>
<html>
<head>
    <title>Order Receipt</title>
</head>
<body>
    <h1>Payment Successful!</h1>
    <p>Thank you for your purchase. Your order #{{ $order->id }} has been confirmed.</p>
    <h3>Order Summary</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->brand }} {{ $item->product->model }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->price, 2) }}</td>
                <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" align="right"><strong>Total Cost:</strong></td>
                <td><strong>${{ number_format($order->total_price, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>
    <p>
        <strong>Need more details about your order?</strong><br>
        Call to +94 11 2335787<br>
        Email to info@TimeBridge.lk
    </p>
    <p>&copy; {{ date('Y') }} TimeBridge Inc. All rights reserved.</p>
</body>
</html>
