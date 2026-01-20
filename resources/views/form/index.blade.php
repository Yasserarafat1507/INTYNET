@extends('layouts.app')
@section('title', 'Pendaftaran')

@section('content')
    <div class="w-full max-w-4xl flex flex-col bg-white rounded-3xl">

        <div class="px-10 pt-10 pb-10 flex justify-center">
            <h2 class="text-5xl font-bold text-black">
                Mulai Berlangganan
            </h2>
        </div>

        <div class="px-10 pb-10">
            <form id="registerForm" action="{{ route('form.store') }}" method="POST" class="space-y-8">
                @csrf

                <div>
                    <input type="text" name="name" placeholder="Nama" value="{{ old('name') }}"
                        class="block w-full px-4 py-4 rounded-2xl text-xl font-semibold ring-2
                            @error('name') ring-red-500 @else ring-gray-300 @enderror" />

                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                <div>
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}"
                        class="block w-full px-4 py-4 rounded-2xl text-xl font-semibold
        ring-2
        @error('email') ring-red-500 @else ring-gray-300 @enderror" />

                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                <div>
                    <input type="text" name="phone" placeholder="No HP" value="{{ old('phone') }}"
                        class="block w-full px-4 py-4 rounded-2xl text-xl font-semibold
        ring-2
        @error('phone') ring-red-500 @else ring-gray-300 @enderror" />

                    @error('phone')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

                <div class="mt-6 flex justify-center">
                    <div id="map" class="w-full h-[400px] rounded-2xl ring-2 ring-gray-300 shadow-inner z-0">
                    </div>
                </div>

                @error('latitude')
                    <p class="mt-3 text-center text-sm text-red-600">
                        Silakan pilih lokasi pada peta
                    </p>
                @enderror

                <button type="submit"
                    class="w-full rounded-full bg-orange-500 py-4 text-xl font-semibold text-white hover:bg-orange-400">
                    Daftar
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const defaultLocation = [-1.243950, 116.850816];

            const map = L.map('map').setView(defaultLocation, 20);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            setTimeout(() => {
                map.invalidateSize();
            }, 300);

            let marker;

            map.locate({
                setView: false,
                maxZoom: 16,
                enableHighAccuracy: true,
            });

            map.on('locationfound', function(e) {
                if (marker) map.removeLayer(marker);

                marker = L.marker(e.latlng, {
                        draggable: true
                    })
                    .addTo(map)
                    .bindPopup("Lokasi kamu sekarang")
                    .openPopup();

                document.getElementById('latitude').value = e.latlng.lat;
                document.getElementById('longitude').value = e.latlng.lng;

                marker.on('dragend', function(ev) {
                    const pos = ev.target.getLatLng();
                    document.getElementById('latitude').value = pos.lat;
                    document.getElementById('longitude').value = pos.lng;
                });
            });

            map.on('locationerror', function() {
                console.log('User menolak akses lokasi, pakai default location');
            });

            map.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                if (marker) map.removeLayer(marker);

                marker = L.marker([lat, lng], {
                    draggable: true
                }).addTo(map);

                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;

                marker.on('dragend', function(ev) {
                    const pos = ev.target.getLatLng();
                    document.getElementById('latitude').value = pos.lat;
                    document.getElementById('longitude').value = pos.lng;
                });
            });

            document.getElementById('registerForm').addEventListener('submit', function(e) {
                const lat = document.getElementById('latitude').value;
                const lng = document.getElementById('longitude').value;

                if (!lat || !lng) {
                    e.preventDefault();
                    alert('Silakan pilih lokasi pada peta terlebih dahulu');
                }
            });

        });
    </script>
@endpush
