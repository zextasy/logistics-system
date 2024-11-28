{{-- resources/views/components/shipment-map.blade.php --}}
@props(['shipment', 'routes'])

<div x-data="shipmentMap()" x-init="initMap()" class="bg-white rounded-lg shadow">
    <div class="p-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Shipment Route Map</h3>
    </div>
    <div class="aspect-w-16 aspect-h-9">
        <div id="shipment-map" class="w-full h-full rounded-b-lg"></div>
    </div>
</div>

<script>
    function shipmentMap() {
        return {
            map: null,
            markers: [],
            path: null,

            initMap() {
                // Initialize the map
                this.map = new google.maps.Map(document.getElementById('shipment-map'), {
                    zoom: 2,
                    center: { lat: 0, lng: 0 }
                });

                const routes = @json($routes);
                const bounds = new google.maps.LatLngBounds();
                const coordinates = [];

                // Add markers for each route point
                routes.forEach((route, index) => {
                    const position = { lat: route.latitude, lng: route.longitude };
                    coordinates.push(position);
                    bounds.extend(position);

                    const marker = new google.maps.Marker({
                        position: position,
                        map: this.map,
                        title: route.location,
                        label: (index + 1).toString()
                    });

                    this.markers.push(marker);
                });

                // Draw path between points
                this.path = new google.maps.Polyline({
                    path: coordinates,
                    geodesic: true,
                    strokeColor: '#4F46E5',
                    strokeOpacity: 1.0,
                    strokeWeight: 2
                });
                this.path.setMap(this.map);

                // Fit map to bounds
                this.map.fitBounds(bounds);
            }
        }
    }
</script>






