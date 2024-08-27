<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display the cart items.
     */
    public function index()
    {
        $cart = $this->cartService->getCart();
        return view('cart.index', compact('cart'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request, $id)
    {
        try {
            $this->cartService->addToCart($id);
            return redirect()->route('cart.index')->with('success', 'Product added to cart!');
        } catch (\Exception $e) {
            return redirect()->route('customer-products.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove a product from the cart.
     */
    public function remove(Request $request, $id)
    {
        $this->cartService->removeFromCart($id);
        return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
    }

    /**
     * Update the quantity of a product in the cart.
     */
    public function update(Request $request, $id)
    {
        $quantity = $request->input('quantity');

        try {
            $this->cartService->updateCartItem($id, $quantity);
            return redirect()->route('cart.index')->with('success', 'Cart updated!');
        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Counts total items in the cart.
     */
    public function getCartItemCount()
    {
        return $this->cartService->getCartItemCount();
    }

    /**
     * Clear items in the cart.
     */
    public function clear()
    {
        $this->cartService->clearCart();
        return redirect()->route('cart.index')->with('success', 'Cart has been cleared!');
    }

}
