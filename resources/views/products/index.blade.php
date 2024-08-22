<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <x-slot name="breadcrumb">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">{{ __('Products') }}</li>
        </ol>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Search and Category Filter -->
                    <div class="mb-6 flex justify-between items-center">
                        <form method="GET" action="{{ route('customer-products.index') }}" class="flex items-center w-full">
                            <!-- Search Bar -->
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}" 
                                placeholder="Search Products..." 
                                class="border border-gray-300 p-2 rounded-lg flex-grow"
                            />

                            <!-- Category Filter -->
                            <select name="category" class="border border-gray-300 p-2 rounded-lg ml-4" style="min-width: 200px;">
                                <option value="">{{ __('All Categories') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Submit Button -->
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 ml-4">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Products Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover mb-4">
                                <h2 class="text-xl font-semibold mb-2">{{ $product->name }}</h2>
                                <p class="text-gray-600 mb-4">${{ $product->price }}</p>
                                <div class="flex justify-between items-center">
                                    <a href="{{ route('customer-product.show', $product->id) }}" class="text-blue-500 hover:underline">View Details</a>
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
