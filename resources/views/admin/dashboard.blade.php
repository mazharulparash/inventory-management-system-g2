<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-slot name="breadcrumb">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">{{ __('Dashboard') }}</li>
        </ol>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <!-- Sales Chart -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Sales Overview</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="salesChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Monthly Sales Trend -->
                <div class="col-md-6">
                    <div class="card mt-4 mt-md-0">
                        <div class="card-header">
                            <h3 class="card-title">Monthly Sales Trend</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="monthlySalesChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- Script to generate the charts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sales Overview Chart
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            new Chart(salesCtx, {
                type: 'bar', // Change to 'line', 'pie', etc. if needed
                data: {
                    labels: {!! json_encode($salesDataArray['labels']) !!},
                    datasets: [{
                        label: 'Sales',
                        data: {!! json_encode($salesDataArray['data']) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Monthly Sales Trend Chart
            const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
            new Chart(monthlySalesCtx, {
                type: 'line', // Change to 'bar', 'pie', etc. if needed
                data: {
                    labels: {!! json_encode($monthlySalesArray['labels']) !!},
                    datasets: [{
                        label: 'Total Quantity Sold',
                        data: {!! json_encode($monthlySalesArray['data']) !!},
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
