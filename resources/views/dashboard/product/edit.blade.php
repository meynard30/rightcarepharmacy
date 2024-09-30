@extends('layouts.dashboard')

@section('title', 'Add Product')

@section('content')

<h1 class="mt-4">Edit {{ $product->name }}</h1>

<ol class="breadcrumb mb-3">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
    <li class="breadcrumb-item active">Edit Product</li>
</ol>

<a href="{{ route('products.create') }}" class="btn btn-info mb-4">Add Product</a>

<form action="{{ route('products.update', $product) }}" method="post">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    Product Information
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="f-name" class="form-label">Name</label>
                        <input type="text" name="name" id="f-name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}"/>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="f-description" class="form-label">Description</label>
                        <textarea name="description" id="f-description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" />
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    Organize
                </div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input name="charge_tax" class="form-check-input" type="checkbox" role="switch" id="f-charge-tax" @if($product->charge_tax == 1) checked @endif>
                        <label class="form-check-label" for="f-charge-tax">Charge Tax</label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input name="in_stock" class="form-check-input" type="checkbox" role="switch" id="f-in-stock"  @if($product->in_stock == 1) checked @endif>
                        <label class="form-check-label" for="f-in-stock">In Stock</label>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Save Product</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
