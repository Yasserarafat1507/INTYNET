@extends('layouts.app')

@section('content')
    <div class="w-full max-w-4xl flex flex-col bg-white rounded-3xl">

        <div class="px-30 pt-10 pb-13 flex justify-center">
            <h2 class="text-5xl font-bold text-black">
                Mulai Berlangganan
            </h2>
        </div>

        <div class="px-30 pb-15">
            <form id="registerForm" action="{{ route('form.store') }}" method="POST" class="space-y-8">
                @csrf

                <input type="text" name="name" placeholder="Nama" required
                    class="block w-full px-4 pb-4 pt-5 rounded-2xl ring-2 ring-gray-300 shadow-inner shadow-gray-500/80 placeholder:font-bold placeholder:text-xl text-xl font-semibold" />

                <input type="email" name="email" placeholder="Email" required
                    class="block w-full px-4 pb-4 pt-5 rounded-2xl ring-2 ring-gray-300 shadow-inner shadow-gray-500/80 placeholder:font-bold placeholder:text-xl text-xl font-semibold" />

                <input type="text" name="phone" placeholder="No HP" required
                    class="block w-full px-4 pb-4 pt-5 rounded-2xl ring-2 ring-gray-300 shadow-inner shadow-gray-500/80  placeholder:font-bold placeholder:text-xl text-xl font-semibold" />

                <input type="hidden" name="latitude" id="latitude" required>
                <input type="hidden" name="longitude" id="longitude" required>

                <div class="mt-6 flex justify-center">
                    <div id="map" class="w-full max-w-7xl h-112.5 rounded-2xl ring-2 ring-gray-300 shadow-inner shadow-gray-500/80">
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

            const map = L.map('map').setView([-1.243950, 116.850816], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            }).addTo(map);

            setTimeout(() => {
                map.invalidateSize();
            }, 300);

            let marker;

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
