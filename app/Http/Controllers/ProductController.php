<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AdminMiddleware;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware(AdminMiddleware::class, except: ['index']),
        ];
    }

    public function __construct() {}

    public function index(Request $request)
    {
        $search = $request->input('search');
        $products = Product::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]);
        return view('dashboard.product.index', ['products' => $products, 'search' => $search]);
    }

    public function create()
    {
        return view('dashboard.product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        $product = new Product([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'in_stock' => $request->has('in_stock') ? 1 : 0,
            'charge_tax' => $request->has('charge_tax') ? 1 : 0, // Checkbox for charge tax
        ]);

        // Save the product to the database
        $product->save();

        // Redirect back to the product listing page with a success message
        return redirect()->route('products.edit', $product)->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('dashboard.product.edit', ['product' => $product]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        $data['in_stock'] = $request->has('in_stock') ? 1 : 0;
        $data['charge_tax'] = $request->has('charge_tax') ? 1 : 0;

        $product->update($data);

        return back()->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
