<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Confirmation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg">{{ __('Thank you for your order!') }}</h3>
                    <p>{{ __('Your order has been placed successfully. Below are your order details:') }}</p>

                    <h4 class="mt-4 text-lg">{{ __('Order Details') }}</h4>
                    <table class="table-auto w-full mt-4">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">{{ __('Name') }}</th>
                                <th class="px-4 py-2">{{ __('Value') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border px-4 py-2">{{ __('Name') }}</td>
                                <td class="border px-4 py-2">{{ $order->name }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">{{ __('Address') }}</td>
                                <td class="border px-4 py-2">{{ $order->address }}, {{ $order->city }}, {{ $order->postal_code }}, {{ $order->country }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">{{ __('Email') }}</td>
                                <td class="border px-4 py-2">{{ $order->email }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">{{ __('Phone') }}</td>
                                <td class="border px-4 py-2">{{ $order->phone }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">{{ __('Total Amount') }}</td>
                                <td class="border px-4 py-2">${{ $order->total_amount }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">{{ __('Status') }}</td>
                                <td class="border px-4 py-2">{{ ucfirst($order->status) }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h4 class="mt-4 text-lg">{{ __('Order Items') }}</h4>
                    <table class="table-auto w-full mt-4">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">{{ __('Product') }}</th>
                                <th class="px-4 py-2">{{ __('Price') }}</th>
                                <th class="px-4 py-2">{{ __('Quantity') }}</th>
                                <th class="px-4 py-2">{{ __('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td class="border px-4 py-2">{{ $item->name }}</td>
                                    <td class="border px-4 py-2">${{ $item->price }}</td>
                                    <td class="border px-4 py-2">{{ $item->quantity }}</td>
                                    <td class="border px-4 py-2">${{ $item->price * $item->quantity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Go Back Button -->
                    <div class="mt-4">
                        <a href="{{ route('customer-products.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-800">
                            {{ __('Go Back to Shop') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
