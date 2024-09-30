@extends('layouts.dashboard')

@section('title', 'Order Details')

@section('content')

    <h1 class="mt-4">Order Details</h1>

    <h3>Order ID: {{ $order->id }}</h3>
    <h2>Total Price: &#8369;{{ number_format($order->total_price, 2) }}</h2>
    <h5>Ordered On: {{ $order->created_at->format('Y-m-d H:i:s') }}</h5>

    <h2 class="mt-4">Items</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>&#8369;{{ number_format($item->price, 2) }}</td>
                        <td>&#8369;{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
