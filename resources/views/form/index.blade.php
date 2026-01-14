@extends('layouts.app')
@section('title', 'Pendaftaran')

@section('content')
    <div class="w-full max-w-4xl flex flex-col bg-white rounded-3xl">

        <div class="pt-4 pb-8 flex justify-center sm:pt-10 sm:pb-12">
            <h2 class="text-xl font-bold text-black sm:text-5xl whitespace-nowrap">
                Mulai Berlangganan
            </h2>
        </div>

        <div class="px-10 pb-8 sm:px-30 sm:pb-15">
            <form id="registerForm" action="{{ route('form.store') }}" method="POST" class="space-y-8">
                @csrf

                <input type="text" name="name" placeholder="Nama" required
                    class="block w-full px-1 pb-1 pt-1 rounded-2xl ring-2 ring-gray-300 shadow-inner shadow-gray-500/80 placeholder:font-bold placeholder:text-xl text-xl font-semibold sm:px-4 sm:pb-4 sm:pt-5" />

                <input type="email" name="email" placeholder="Email" required
                    class="block w-full px-4 pb-4 pt-5 rounded-2xl ring-2 ring-gray-300 shadow-inner shadow-gray-500/80 placeholder:font-bold placeholder:text-xl text-xl font-semibold" />

                <input type="text" name="phone" placeholder="No HP" required
                    class="block w-full px-4 pb-4 pt-5 rounded-2xl ring-2 ring-gray-300 shadow-inner shadow-gray-500/80  placeholder:font-bold placeholder:text-xl text-xl font-semibold" />

                <input type="hidden" name="latitude" id="latitude" required>
                <input type="hidden" name="longitude" id="longitude" required>

                <div class="mt-6 flex justify-center">
                    <div id="map"
                        class="w-full max-w-7xl h-112.5 rounded-2xl ring-2 ring-gray-300 shadow-inner shadow-gray-500/80 z-0">
                    </div>
                </div>

                <button type="submit"
                    class="w-full justify-center rounded-full bg-orange-500 px-4 py-4 text-xl font-semibold text-white hover:bg-orange-400 focus:outline-none focus:ring-2 focus:ring-black">
                    Daftar
                </button>
            </form>
        </div>
    </div>

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
@endsection
