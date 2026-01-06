@extends('layouts.app')

@section('content')
<div class="container flex flex-col justify-center items-center py-3 px-5 bg-white w-full rounded">
    <form method="POST" action="{{ route('form.store') }}">
        @csrf

        <input type="text" name="name" placeholder="Nama" required>

        <input type="email" name="email" placeholder="Email" required>

        <input type="text" name="phone" placeholder="No HP" required>

        <!-- WAJIB hidden -->
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">

        <div id="map"></div>

        <button type="submit">Submit</button>
    </form>
</div>

<script>
        const map = L.map('map').setView([-1.243950, 116.850816], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        let marker;

        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;

            if (marker) map.removeLayer(marker);

            marker = L.marker([lat, lng]).addTo(map);

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        });
    </script>
@endsection
