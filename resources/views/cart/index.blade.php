<!-- resources/views/cart/index.blade.php -->
<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(!empty($cart))
                        <table class="table-auto w-full">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">{{ __('Image') }}</th>
                                    <th class="px-4 py-2">{{ __('Name') }}</th>
                                    <th class="px-4 py-2">{{ __('Price') }}</th>
                                    <th class="px-4 py-2">{{ __('Quantity') }}</th>
                                    <th class="px-4 py-2">{{ __('Total') }}</th>
                                    <th class="px-4 py-2">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $id => $details)
                                    <tr>
                                        <td class="border px-4 py-2"><img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" class="w-20 h-20 object-cover"></td>
                                        <td class="border px-4 py-2">{{ $details['name'] }}</td>
                                        <td class="border px-4 py-2">${{ $details['price'] }}</td>
                                        <td class="border px-4 py-2">
                                            <form action="{{ route('cart.update', $id) }}" method="POST" class="quantity-form">
                                                @csrf
                                                <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" class="w-16 border rounded px-2 py-1 quantity-input" data-id="{{ $id }}">
                                            </form>
                                        </td>
                                        <td class="border px-4 py-2">${{ $details['price'] * $details['quantity'] }}</td>
                                        <td class="border px-4 py-2">
                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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

    <!-- SweetAlert2 Toast -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: "{{ session('success') }}",
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
            @endif
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const quantityInputs = document.querySelectorAll('.quantity-input');

            quantityInputs.forEach(input => {
                input.addEventListener('change', function () {
                    const form = this.closest('form.quantity-form');
                    form.submit();
                });
            });
        });
    </script>
</x-customer-layout>
