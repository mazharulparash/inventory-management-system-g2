<?php

namespace App\Services;

use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createPaymentIntent($totalAmount, $paymentMethodId)
    {
        return PaymentIntent::create([
            'amount' => $totalAmount * 100, // Amount in cents
            'currency' => 'usd',
            'payment_method' => $paymentMethodId,
            'confirmation_method' => 'manual',
            'confirm' => true,
            'return_url' => route('checkout.confirmation', ['order' => 'PLACEHOLDER']), // Placeholder
        ]);
    }
}
