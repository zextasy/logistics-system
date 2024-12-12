
{{-- Charts --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    {{-- Shipments Chart --}}
    <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Shipments Overview</h3>
        <div class="h-72">
            <canvas id="shipmentsChart"></canvas>
        </div>
    </div>

    {{-- Revenue Chart --}}
    <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Revenue Trend</h3>
        <div class="h-72">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Shipments Chart
        const shipmentsCtx = document.getElementById('shipmentsChart').getContext('2d');
        new Chart(shipmentsCtx, {
            type: 'line',
            data: {
                labels: @json($chartData['shipments']->pluck('date')),
                datasets: [{
                    label: 'Shipments',
                    data: @json($chartData['shipments']->pluck('total')),
                    borderColor: 'rgb(79, 70, 229)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: @json($chartData['revenue']->pluck('date')),
                datasets: [{
                    label: 'Revenue',
                    data: @json($chartData['revenue']->pluck('total')),
                    backgroundColor: 'rgba(79, 70, 229, 0.2)',
                    borderColor: 'rgb(79, 70, 229)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
