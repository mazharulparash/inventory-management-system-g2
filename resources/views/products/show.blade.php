<!-- resources/views/products/show.blade.php -->
<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Product Details') }}
        </h2>
    </x-slot>

    <x-slot name="breadcrumb">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('customer-products.index') }}">{{ __('Products') }}</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-col md:flex-row items-center">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full md:w-1/2 h-70 object-cover mb-4 md:mb-0 md:mr-8 rounded-lg shadow-md">
                        <div class="md:w-1/2">
                            <h2 class="text-3xl font-semibold mb-2">{{ $product->name }}</h2>
                            <p class="text-gray-600 mb-4">{{ $product->description }}</p>
                            <p class="text-lg font-bold mb-4">${{ $product->price }}</p>
                            <p class="text-gray-600 mb-4">SKU: {{ $product->sku }}</p>
                            <p class="text-gray-600 mb-4">Category: {{ $product->category->name ?? 'N/A' }}</p>
                            <p class="text-gray-600 mb-4">Quantity Available: {{ $product->quantity }}</p>
                            <form method="POST">
                                @csrf
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Add to Cart</button>
                            </form>
                            <div class="mt-4">
                                <a href="{{ route('customer-products.index') }}" class="text-blue-500 hover:underline">Go Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
