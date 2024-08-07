<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the cart items.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // Check if product is out of stock
        if ($product->quantity == 0) {
            return redirect()->route('customer-products.index')->with('error', 'Product is out of stock!');
        }

        if(isset($cart[$id])) {
            if ($cart[$id]['quantity'] + 1 > $product->quantity) {
                // If requested quantity exceeds stock, show an error message
                // Update the cart item quantity
                $cart[$id]['quantity'] = $product->quantity;
                session()->put('cart', $cart);
                return redirect()->route('customer-products.index')->with('error', 'Requested quantity exceeds stock available!');
            }
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    /**
     * Remove a product from the cart.
     */
    public function remove(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
    }

    /**
     * Update the quantity of a product in the cart.
     */
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        $quantity = $request->input('quantity');

        // Check if product exists in the cart
        if(isset($cart[$id])) {
            $product = Product::findOrFail($id);

            // Check if the updated quantity is available in stock
            if ($quantity == 0) {
                return redirect()->route('cart.index')->with('error', 'Product out of stock!');
            } elseif ($quantity > $product->quantity) {
                // If requested quantity exceeds stock, show an error message
                // Update the cart item quantity
                $cart[$id]['quantity'] = $product->quantity;
                session()->put('cart', $cart);
                return redirect()->route('cart.index')->with('error', 'Requested quantity exceeds stock available!');
            } else {
                // Update the cart item quantity
                $cart[$id]['quantity'] = $quantity;
                session()->put('cart', $cart);
                return redirect()->route('cart.index')->with('success', 'Cart updated!');
            }
        }

        // If item not found in cart, handle appropriately
        return redirect()->route('cart.index')->with('error', 'Product not found in cart!');
    }

    /**
     * Counts total items in the cart.
     */
    public function getCartItemCount()
    {
        $cart = session()->get('cart', []);
        return array_sum(array_column($cart, 'quantity'));
    }

    /**
     * Clear items in the cart.
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart has been cleared!');
    }

}
