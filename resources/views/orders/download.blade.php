<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .card {
        background-color: #fff;
        color: #333;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .content {
        padding: 24px;
        color: #333;
    }

    .header {
        font-size: 1.25rem;
        margin-bottom: 16px;
    }

    .subheader {
        margin-top: 24px;
        font-size: 1.25rem;
    }

    .table {
        width: 100%;
        margin-top: 16px;
        border-collapse: collapse;
    }

    .cell {
        border: 1px solid #ddd;
        padding: 8px;
    }
</style>

<div class="container">
    <div class="card">
        <div class="content">
            <h3 class="header">{{ __('Order Confirmation') }}</h3>
            <p>{{ __('Below are the details for your order:') }}</p>

            <h4 class="subheader">{{ __('Order Details') }}</h4>
            <table class="table">
                <tbody>
                    <tr>
                        <td class="cell">{{ __('Name') }}</td>
                        <td class="cell">{{ $order->name }}</td>
                    </tr>
                    <tr>
                        <td class="cell">{{ __('Address') }}</td>
                        <td class="cell">
                            {{ $order->address }}, {{ $order->city }}, {{ $order->postal_code }}, {{ $order->country }}
                        </td>
                    </tr>
                    <tr>
                        <td class="cell">{{ __('Email') }}</td>
                        <td class="cell">{{ $order->email }}</td>
                    </tr>
                    <tr>
                        <td class="cell">{{ __('Phone') }}</td>
                        <td class="cell">{{ $order->phone }}</td>
                    </tr>
                    <tr>
                        <td class="cell">{{ __('Total Amount') }}</td>
                        <td class="cell">${{ $order->total_amount }}</td>
                    </tr>
                    <tr>
                        <td class="cell">{{ __('Status') }}</td>
                        <td class="cell">{{ ucfirst($order->status) }}</td>
                    </tr>
                </tbody>
            </table>

            <h4 class="subheader">{{ __('Order Items') }}</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th class="cell">{{ __('Product') }}</th>
                        <th class="cell">{{ __('Price') }}</th>
                        <th class="cell">{{ __('Quantity') }}</th>
                        <th class="cell">{{ __('Total') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                        <tr>
                            <td class="cell">{{ $item->name }}</td>
                            <td class="cell">${{ $item->price }}</td>
                            <td class="cell">{{ $item->quantity }}</td>
                            <td class="cell">${{ $item->price * $item->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
