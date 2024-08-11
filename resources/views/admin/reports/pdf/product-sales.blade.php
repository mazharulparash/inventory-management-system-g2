<!DOCTYPE html>
<html>
<head>
    <title>Product Sales Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f4f4f4; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <h1>Product Sales Report</h1>
    <p>From: {{ $startDate }} To: {{ $endDate }}</p>

    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Total Quantity Sold</th>
                <th>Total Sales</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productSales as $sale)
                <tr>
                    <td>{{ $sale->name }}</td>
                    <td>{{ $sale->total_quantity }}</td>
                    <td>${{ number_format($sale->total_sales, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total">
                <td>Grand Total</td>
                <td>{{ $grandTotalQuantity }}</td>
                <td>${{ number_format($grandTotalSales, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
