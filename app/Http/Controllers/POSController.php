<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class POSController extends Controller
{
    public function index(Request $request)
    {
        // Fetch the search term if available
        $search = $request->input('search');

        // Query products based on the search term
        $products = Product::where('in_stock', 1)
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->get();

        // Get current cart items from the session
        $cart = Session::get('cart', []);

        return view('pos.index', compact('products', 'cart'));
    }

    // Add product to the cart
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        // Get the product by ID
        $product = Product::find($productId);

        // Get the cart from the session
        $cart = Session::get('cart', []);

        // If the product is already in the cart, increment the quantity
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            // Otherwise, add the product to the cart
            $cart[$productId] = [
                'product' => $product,
                'quantity' => $quantity,
            ];
        }

        // Update the cart in the session
        Session::put('cart', $cart);

        return redirect()->route('pos.index')->with('success', 'Product added to cart.');
    }

    // Remove product from the cart
    public function removeFromCart(Request $request)
    {
        $productId = $request->input('product_id');

        // Get the cart from the session
        $cart = Session::get('cart', []);

        // Remove the product from the cart
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }

        // Update the cart in the session
        Session::put('cart', $cart);

        return redirect()->route('pos.index')->with('success', 'Product removed from cart.');
    }

    // Checkout and process the payment
    public function checkout(Request $request)
    {
        // Get the current cart
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('pos.index')->with('error', 'Cart is empty.');
        }

        // Calculate the total price
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['product']->price * $item['quantity'];
        }

        // Create a new order and associate it with the logged-in user
        $order = Order::create([
            'user_id' => auth()->id(), // Get the currently authenticated user
            'total_price' => $totalPrice,
        ]);

        // Save each item in the cart as an order item
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'quantity' => $item['quantity'],
                'price' => $item['product']->price, // Store the price at the time of checkout
            ]);
        }

        // Clear the cart after checkout
        Session::forget('cart');

        return redirect()->route('pos.index')->with('success', 'Checkout successful. Order ID: ' . $order->id);
    }
}
