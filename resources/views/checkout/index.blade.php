<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg">{{ __('Order Summary') }}</h3>
                    @if(!empty($cart))
                        <table class="table-auto w-full mt-4">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">{{ __('Name') }}</th>
                                    <th class="px-4 py-2">{{ __('Price') }}</th>
                                    <th class="px-4 py-2">{{ __('Quantity') }}</th>
                                    <th class="px-4 py-2">{{ __('Total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $id => $details)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $details['name'] }}</td>
                                        <td class="border px-4 py-2">${{ $details['price'] }}</td>
                                        <td class="border px-4 py-2">{{ $details['quantity'] }}</td>
                                        <td class="border px-4 py-2">${{ $details['price'] * $details['quantity'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Display Total Amount -->
                        <div class="mt-4 text-lg font-semibold">
                            {{ __('Total Amount: $') . number_format(array_sum(array_map(function ($item) {
                                return $item['price'] * $item['quantity'];
                            }, $cart)), 2) }}
                        </div>

                        <!-- Go Back Button -->
                        <div class="mt-4">
                            <a href="{{ route('cart.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-800">
                                {{ __('Go Back') }}
                            </a>
                        </div>

                        <div class="mt-4">
                            <h3 class="text-lg">{{ __('Shipping Information') }}</h3>
                            <form id="payment-form" action="{{ route('checkout.store') }}" method="POST" class="mt-4">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="name" class="block text-sm">{{ __('Name') }}</label>
                                        <input type="text" name="name" id="name" class="w-full border rounded px-2 py-1" required>
                                    </div>
                                    <div>
                                        <label for="address" class="block text-sm">{{ __('Address') }}</label>
                                        <input type="text" name="address" id="address" class="w-full border rounded px-2 py-1" required>
                                    </div>
                                    <div>
                                        <label for="city" class="block text-sm">{{ __('City') }}</label>
                                        <input type="text" name="city" id="city" class="w-full border rounded px-2 py-1" required>
                                    </div>
                                    <div>
                                        <label for="postal_code" class="block text-sm">{{ __('Postal Code') }}</label>
                                        <input type="text" name="postal_code" id="postal_code" class="w-full border rounded px-2 py-1" required>
                                    </div>
                                    <div>
                                        <label for="country" class="block text-sm">{{ __('Country') }}</label>
                                        <input type="text" name="country" id="country" class="w-full border rounded px-2 py-1" required>
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm">{{ __('Email') }}</label>
                                        <input type="email" name="email" id="email" class="w-full border rounded px-2 py-1" required>
                                    </div>
                                    <div>
                                        <label for="phone" class="block text-sm">{{ __('Phone') }}</label>
                                        <input type="text" name="phone" id="phone" class="w-full border rounded px-2 py-1" required>
                                    </div>
                                </div>

                                <!-- Payment Element -->
                                <div class="mt-4">
                                    <label for="card-element" class="block text-sm">{{ __('Credit or Debit Card') }}</label>
                                    <div id="card-element" class="border rounded px-2 py-1"></div>
                                    <div id="card-errors" role="alert" class="text-red-500 mt-2"></div>
                                </div>

                                <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-800">
                                    {{ __('Place Order') }}
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-center">
                            <p class="text-lg">{{ __('Your cart is empty!') }}</p>
                            <a href="{{ route('customer-products.index') }}" class="text-blue-500 hover:underline">{{ __('Continue Shopping') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Include Stripe.js -->
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var stripe = Stripe('{{ config('services.stripe.key') }}'); // Use the public key from config
            var elements = stripe.elements();
            var cardElement = elements.create('card');
            cardElement.mount('#card-element');

            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                stripe.createPaymentMethod({
                    type: 'card',
                    card: cardElement,
                }).then(function(result) {
                    if (result.error) {
                        // Display error in the card element
                        var cardErrors = document.getElementById('card-errors');
                        cardErrors.textContent = result.error.message;
                    } else {
                        // Append the payment method ID to the form and submit
                        var paymentMethodInput = document.createElement('input');
                        paymentMethodInput.setAttribute('type', 'hidden');
                        paymentMethodInput.setAttribute('name', 'payment_method_id');
                        paymentMethodInput.setAttribute('value', result.paymentMethod.id);
                        form.appendChild(paymentMethodInput);

                        form.submit();
                    }
                });
            });
        });
    </script>
</x-customer-layout>
