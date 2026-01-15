<!DOCTYPE html>
<html>
<head>
    <title>Order Receipt</title>
</head>
<body>
    <h1>Thank you for your order!</h1>
    <p>Your order #{{ $order->id }} has been paid successfully.</p>
    
    <h2>Order Details:</h2>
    <ul>
        @foreach($order->items as $item)
            <li>{{ $item->product->brand }} {{ $item->product->model }} x {{ $item->quantity }} - ${{ number_format($item->price, 2) }}</li>
        @endforeach
    </ul>
    
    <p><strong>Total: ${{ number_format($order->total_price, 2) }}</strong></p>
    
    <p>Thank you for shopping with us!</p>
</body>
</html>
