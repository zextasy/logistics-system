{{-- resources/views/components/weather-widget.blade.php --}}
@props(['location'])

<div x-data="weatherWidget()"
     x-init="fetchWeather()"
     class="bg-white rounded-lg shadow p-4">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-medium text-gray-900">Weather at Location</h3>
        <button @click="fetchWeather()" class="text-gray-400 hover:text-gray-600">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
        </button>
    </div>

    <template x-if="weather">
        <div class="text-center">
            <div class="flex items-center justify-center">
                <img :src="weather.icon" :alt="weather.description" class="w-16 h-16">
                <div class="ml-4">
                    <div class="text-3xl font-bold" x-text="`${weather.temperature}°C`"></div>
                    <div class="text-gray-500" x-text="weather.description"></div>
                </div>
            </div>
            <div class="mt-4 grid grid-cols-3 gap-2 text-sm">
                <div>
                    <div class="text-gray-500">Humidity</div>
                    <div class="font-medium" x-text="`${weather.humidity}%`"></div>
                </div>
                <div>
                    <div class="text-gray-500">Wind</div>
                    <div class="font-medium" x-text="`${weather.wind_speed} km/h`"></div>
                </div>
                <div>
                    <div class="text-gray-500">Visibility</div>
                    <div class="font-medium" x-text="`${weather.visibility} km`"></div>
                </div>
            </div>
        </div>
    </template>

    <template x-if="error">
        <div class="text-center text-gray-500">
            Unable to fetch weather information
        </div>
    </template>
</div>

<script>
    function weatherWidget() {
        return {
            weather: null,
            error: null,

            async fetchWeather() {
                try {
                    const response = await fetch(`/api/weather?location={{ urlencode($location) }}`);
                    if (!response.ok) throw new Error('Failed to fetch weather data');
                    this.weather = await response.json();
                    this.error = null;
                } catch (error) {
                    console.error('Weather fetch error:', error);
                    this.error = error.message;
                    this.weather = null;
                }
            }
        }
    }
</script>
