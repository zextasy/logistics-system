{{-- resources/views/components/shipment-stats-chart.blade.php --}}
@props(['data'])

<div class="bg-white rounded-lg shadow">
    <div class="p-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Shipment Statistics</h3>
    </div>
    <div class="p-4">
        <canvas id="shipmentStatsChart" height="300"></canvas>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('shipmentStatsChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($data->pluck('date')),
                datasets: [{
                    label: 'Shipments',
                    data: @json($data->pluck('count')),
                    borderColor: '#4F46E5',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
