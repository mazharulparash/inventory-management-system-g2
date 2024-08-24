<?php

namespace App\Services;

use App\Models\Product;

class CartService
{
    /**
     * Get the cart items from session.
     */
    public function getCart()
    {
        return session()->get('cart', []);
    }

    /**
     * Add a product to the cart.
     */
    public function addToCart($productId, $quantity = 1)
    {
        $product = Product::findOrFail($productId);
        $cart = $this->getCart();

        // Check if the product is out of stock
        if ($product->quantity == 0) {
            throw new \Exception('Product is out of stock!');
        }

        if (isset($cart[$productId])) {
            // Check if the requested quantity exceeds stock
            if ($cart[$productId]['quantity'] + $quantity > $product->quantity) {
                $cart[$productId]['quantity'] = $product->quantity;
                session()->put('cart', $cart);
                throw new \Exception('Requested quantity exceeds stock available!');
            }
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
    }

    /**
     * Remove a product from the cart.
     */
    public function removeFromCart($productId)
    {
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }
    }

    /**
     * Update the quantity of a product in the cart.
     */
    public function updateCartItem($productId, $quantity)
    {
        $cart = $this->getCart();
        $product = Product::findOrFail($productId);

        // Check if the updated quantity is available in stock
        if ($quantity == 0) {
            throw new \Exception('Product out of stock!');
        } elseif ($quantity > $product->quantity) {
            $cart[$productId]['quantity'] = $product->quantity;
            session()->put('cart', $cart);
            throw new \Exception('Requested quantity exceeds stock available!');
        } else {
            $cart[$productId]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }
    }

    /**
     * Get total item count in the cart.
     */
    public function getCartItemCount()
    {
        $cart = $this->getCart();
        return array_sum(array_column($cart, 'quantity'));
    }

    /**
     * Calculate total amount in the cart.
     */
    public function calculateTotalAmount($cart)
    {
        return array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));
    }

    /**
     * Clear the cart.
     */
    public function clearCart()
    {
        session()->forget('cart');
    }
}
