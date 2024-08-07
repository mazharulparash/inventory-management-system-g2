<!-- resources/views/orders/index.blade.php -->

<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg">{{ __('Your Orders') }}</h3>
                    @if($orders->isNotEmpty())
                        <div class="overflow-x-auto">
                            <div class="inline-block min-w-full py-2 align-middle">
                                <div class="overflow-hidden border-b border-gray-200 dark:border-gray-700">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-800 mb-2">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Order ID') }}</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Total Amount') }}</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Status') }}</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Date') }}</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach($orders as $order)
                                                <tr>
                                                    <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">{{ $order->id }}</td>
                                                    <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">${{ $order->total_amount }}</td>
                                                    <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($order->status) }}</td>
                                                    <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">{{ $order->created_at->format('d/m/Y') }}</td>
                                                    <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">
                                                        <a href="{{ route('customer-orders.show', $order->id) }}" class="bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-800">
                                                            {{ __('View Details') }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center">
                            <p class="text-lg">{{ __('No orders found.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
