<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show Product') }}
        </h2>
    </x-slot>

    <x-slot name="breadcrumb">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Products</a></li>
            <li class="breadcrumb-item active">{{ __('Show Product') }}</li>
        </ol>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $order->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" class="form-control" value="{{ $order->address }}, {{ $order->city }}, {{ $order->postal_code }}, {{ $order->country }}" readonly>
                    </div>
                    <!-- <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" name="city" class="form-control" value="{{ $order->city }}" readonly>
                    </div> -->
                    <!-- <div class="form-group">
                        <label for="postalCode">Postal Code</label>
                        <input type="text" name="postalCode" class="form-control" value="{{ $order->postalCode }}" readonly>
                    </div> -->
                    <!-- <div class="form-group">
                        <label for="country">Country</label>
                        <input type="text" name="country" class="form-control" value="{{ $order->country }}" readonly>
                    </div> -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $order->email }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" name="phone" class="form-control" value="{{ $order->phone }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="totalAmount">Total Amount</label>
                        <input type="text" name="totalAmount" class="form-control" value="{{ $order->total_amount }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <input type="text" name="status" class="form-control" value="{{ $order->status }}" readonly>
                    </div>
                    <a href="{{ route('orders.index') }}" class="btn btn-primary">Back to List</a>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>
