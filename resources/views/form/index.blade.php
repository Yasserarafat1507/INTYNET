@extends('layouts.app')
@section('title', 'Pendaftaran')

@section('content')
<div class="container flex flex-col items-center py-6 px-5 bg-white w-full rounded">

    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <h2 class="mt-6 text-center text-2xl font-bold tracking-tight text-black">
            Mulai Berlangganan
        </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-sm">
        <form id="registerForm" action="{{ route('form.store') }}" method="POST" class="space-y-6">
            @csrf

            <input type="text" name="name" placeholder="Nama" required
                class="block w-full rounded-md bg-white px-3 py-2 text-black
                border border-black placeholder:text-gray-500
                focus:outline-none focus:ring-2 focus:ring-black" />

            <input type="email" name="email" placeholder="Email" required
                class="block w-full rounded-md bg-white px-3 py-2 text-black
                border border-black placeholder:text-gray-500
                focus:outline-none focus:ring-2 focus:ring-black" />

            <input type="text" name="phone" placeholder="No HP" required
                class="block w-full rounded-md bg-white px-3 py-2 text-black
                border border-black placeholder:text-gray-500
                focus:outline-none focus:ring-2 focus:ring-black" />

            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <div class="mt-6 flex justify-center">
                <div id="map" class="w-full h-80 rounded-lg border border-black shadow"></div>
            </div>

            <button type="submit"
                class="mt-6 flex w-full justify-center rounded-md
                bg-orange-500 px-4 py-2 text-sm font-semibold text-white
                hover:bg-orange-400 focus:outline-none focus:ring-2
                focus:ring-black">
                Daftar
            </button>
        </form>
    </div>
</div>

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    });
</script>
@endif

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        toastr.success("{{ session('success') }}");
    });
</script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {

    const map = L.map('map').setView([-1.243950, 116.850816], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    setTimeout(() => map.invalidateSize(), 300);

    let marker = null;

    map.on('click', function (e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;

        if (marker) map.removeLayer(marker);

        marker = L.marker([lat, lng], { draggable: true }).addTo(map);

        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        marker.on('dragend', function (ev) {
            const pos = ev.target.getLatLng();
            document.getElementById('latitude').value = pos.lat;
            document.getElementById('longitude').value = pos.lng;
        });
    });

    document.getElementById('registerForm').addEventListener('submit', function (e) {
        const lat = document.getElementById('latitude').value;
        const lng = document.getElementById('longitude').value;

        if (!lat || !lng) {
            e.preventDefault();
            toastr.error('Silakan pilih lokasi pada peta terlebih dahulu');
        }
    });

});
</script>
@endsection
