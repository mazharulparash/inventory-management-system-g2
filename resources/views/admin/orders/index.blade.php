<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <x-slot name="breadcrumb">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">{{ __('Orders') }}</li>
        </ol>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        toastr.success('{{ session('success') }}');
                    });
                </script>
            @endif

            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6 card-body">

                    <!-- Status Filter Form -->
                    <form action="{{ route('orders.index') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select id="statusFilter" name="status" class="form-control">
                                        <option value="">{{ __('All Status') }}</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>{{ __('Processing') }}</option>
                                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>{{ __('Shipped') }}</option>
                                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>{{ __('Delivered') }}</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">{{ __('Filter') }}</button>
                            </div>
                        </div>
                    </form>

                    <table id="ordersTable" class="table table-bordered table-striped w-full">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Created by</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->total_amount }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($order->status == 'pending') bg-warning 
                                            @elseif($order->status == 'processing') bg-info 
                                            @elseif($order->status == 'shipped') bg-primary 
                                            @elseif($order->status == 'delivered') bg-success 
                                            @else bg-secondary 
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">Details</a>
                                        <button class="btn btn-warning btn-sm" onclick="openUpdateModal({{ $order->id }}, '{{ $order->status }}')">Update</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No Orders found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $orders->links() }} <!-- Laravel pagination links -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Order Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateStatusForm" method="POST" action="">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="status">Order Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to handle modal logic -->
    <script>
        function openUpdateModal(orderId, currentStatus) {
            // Set the form action to the correct route
            const form = document.getElementById('updateStatusForm');
            form.action = `/admin/orders/${orderId}`;

            // Set the current status in the select dropdown
            const statusSelect = document.getElementById('status');
            statusSelect.value = currentStatus;

            // Open the modal
            const modal = new bootstrap.Modal(document.getElementById('updateModal'));
            modal.show();
        }
    </script>
</x-app-layout>
