@extends('layouts.dashboard')

@section('title', 'Products')

@section('content')

    <h1 class="mt-4">Products</h1>

    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Products</li>
    </ol>

    @if(auth()->user()->user_type === 'admin')
        <a href="{{ route('products.create') }}" class="btn btn-info mb-4">Add Product</a>
    @endif


    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Charge Tax</th>
                    <th>In Stock</th>
                    <th>Created At</th>
                    <th>Last Updated</th>
                    @if(auth()->user()->user_type === 'admin')
                    <th class="text-center">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if ($products)
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>&#8369; {{ number_format($product->price, 2) }}</td>
                            <td>
                                @if ($product->charge_tax == 1)
                                    <span class="badge rounded-pill text-bg-success">Yes</span>
                                @else
                                    <span class="badge rounded-pill text-bg-danger">No</span>
                                @endif
                            </td>
                            <td>
                                @if ($product->in_stock == 1)
                                    <span class="badge rounded-pill text-bg-success">In Stock</span>
                                @else
                                    <span class="badge rounded-pill text-bg-danger">Out of Stock</span>
                                @endif
                            </td>
                            <td>{{ $product->created_at->format('Y-m-d H:i:s') }}</td>
                            <td>{{ $product->updated_at->format('Y-m-d H:i:s') }}</td>
                            @if(auth()->user()->user_type === 'admin')
                            <td class="text-center">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

@endsection
