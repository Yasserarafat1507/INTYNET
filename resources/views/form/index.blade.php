@extends('layouts.app')
@section('title', 'Pendaftaran')

@section('content')
<div class="w-full max-w-4xl mx-auto bg-white rounded-3xl">

    <div class="px-6 md:px-10 pt-10 text-center">
        <h2 class="text-3xl md:text-5xl font-bold text-black">
            Mulai Berlangganan
        </h2>
    </div>

    <div class="px-6 md:px-10 pb-10">

        <form id="registerForm" action="{{ route('form.store') }}" method="POST" class="space-y-8">
            @csrf

            <div id="formSection" class="space-y-6">

                <div>
                    <input type="text" name="name" placeholder="Nama" value="{{ old('name') }}"
                        class="w-full px-4 py-4 rounded-2xl text-lg font-semibold ring-2
                        @error('name') ring-red-500 @else ring-gray-300 @enderror">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}"
                        class="w-full px-4 py-4 rounded-2xl text-lg font-semibold ring-2
                        @error('email') ring-red-500 @else ring-gray-300 @enderror">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <input type="text" name="phone" placeholder="No HP" value="{{ old('phone') }}"
                        class="w-full px-4 py-4 rounded-2xl text-lg font-semibold ring-2
                        @error('phone') ring-red-500 @else ring-gray-300 @enderror">
                    @error('phone')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div id="mapSection" class="mt-6 md:mt-0">
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

                <div class="w-full h-[300px] md:h-[400px] rounded-2xl ring-2 ring-gray-300 overflow-hidden">
                    <div id="map" class="w-full h-full"></div>
                </div>

                @error('latitude')
                    <p class="mt-3 text-center text-sm text-red-600">
                        Silakan pilih lokasi pada peta
                    </p>
                @enderror
            </div>

            <button type="submit"
                class="w-full rounded-full bg-orange-500 py-4 text-lg font-semibold text-white hover:bg-orange-400 transition">
                Daftar
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const tabForm = document.getElementById('tabForm');
    const tabMap = document.getElementById('tabMap');
    const formSection = document.getElementById('formSection');
    const mapSection = document.getElementById('mapSection');

    if (tabForm && tabMap) {
        tabForm.addEventListener('click', () => {
            formSection.classList.remove('hidden');
            mapSection.classList.add('hidden');

            tabForm.classList.add('bg-orange-500','text-white');
            tabForm.classList.remove('bg-gray-200','text-gray-700');

            tabMap.classList.add('bg-gray-200','text-gray-700');
            tabMap.classList.remove('bg-orange-500','text-white');
        });

        tabMap.addEventListener('click', () => {
            mapSection.classList.remove('hidden');
            formSection.classList.add('hidden');

            tabMap.classList.add('bg-orange-500','text-white');
            tabMap.classList.remove('bg-gray-200','text-gray-700');

            tabForm.classList.add('bg-gray-200','text-gray-700');
            tabForm.classList.remove('bg-orange-500','text-white');

            setTimeout(() => map.invalidateSize(), 200);
        });
    }

    const defaultLocation = [-1.24395, 116.850816];
    const map = L.map('map').setView(defaultLocation, 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    let marker;

    map.locate({ enableHighAccuracy: true });

    function setMarker(latlng) {
        if (marker) map.removeLayer(marker);

        marker = L.marker(latlng, { draggable: true }).addTo(map);
        document.getElementById('latitude').value = latlng.lat;
        document.getElementById('longitude').value = latlng.lng;

        marker.on('dragend', e => {
            const pos = e.target.getLatLng();
            document.getElementById('latitude').value = pos.lat;
            document.getElementById('longitude').value = pos.lng;
        });
    }

    map.on('locationfound', e => setMarker(e.latlng));
    map.on('click', e => setMarker(e.latlng));

    document.getElementById('registerForm').addEventListener('submit', function (e) {
        if (!latitude.value || !longitude.value) {
            e.preventDefault();
            alert('Silakan pilih lokasi pada peta');
        }
    });

});
</script>
@endpush
