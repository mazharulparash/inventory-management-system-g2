<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show Order') }}
        </h2>
    </x-slot>

    <x-slot name="breadcrumb">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders</a></li>
            <li class="breadcrumb-item active">{{ __('Show Order') }}</li>
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
                    <div class="form-group">
                        <label for="created_by">Created by</label>
                        <input type="text" name="created_by" class="form-control" value="{{ $order->user->name }}" readonly>
                    </div>

                    <h4 class="mt-4" style="font-weight: bold;">Order Items</h4>
                    <table class="table table-bordered mt-2 w-full">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>${{ $item->price }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ $item->price * $item->quantity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('orders.index') }}" class="btn btn-primary">Back to List</a>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>
