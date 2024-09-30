@extends('layouts.dashboard')

@section('title', 'POS')

@section('content')

    <div class="row mt-4">
        <!-- Left column: Product List with Search -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    Products
                </div>
                <div class="card-body">
                    <!-- Search form -->
                    <form action="{{ route('pos.index') }}" method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search for products..."
                                value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </div>
                    </form>

                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-md-6">
                                <div class="card mb-4 bg-dark text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text">&#8369; {{ number_format($product->price, 2) }}</p>
                                        <p class="card-text">Description: {{ $product->description }}</p>
                                        <form action="{{ route('pos.addToCart') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <div class="form-group">
                                                <input type="number" name="quantity" class="form-control" value="1"
                                                    min="1">
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary mt-2">Add to Cart</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Right column: Cart -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    Your Cart
                </div>
                <div class="card-body">
                    @if (!empty($cart))
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Product</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0; @endphp
                                    @foreach ($cart as $item)
                                        @php
                                            $itemTotal = $item['product']->price * $item['quantity'];
                                            $total += $itemTotal;
                                        @endphp
                                        <tr>
                                            <td>{{ $item['product']->name }}</td>
                                            <td>{{ $item['quantity'] }}</td>
                                            <td>&#8369; {{ number_format($itemTotal, 2) }}</td>
                                            <td>
                                                <form action="{{ route('pos.removeFromCart') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <h3>Total: &#8369; {{ number_format($total, 2) }}</h3>

                        <!-- Checkout Button -->
                        <form action="{{ route('pos.checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Checkout</button>
                        </form>
                    @else
                        <p>Your cart is empty.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>

@endsection
