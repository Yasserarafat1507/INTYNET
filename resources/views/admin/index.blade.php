@extends('layouts.app')
@section('title', 'Admin')

@section('content')
    <div class="flex flex-col p-8 bg-white w-full max-w-7xl rounded-3xl">
        <div class="mb-4 flex items-center gap-3">
            <label for="filter_status" class="font-bold text-gray-700">Filter Status:</label>
            <select id="filter_status" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-orange-500 focus:border-orange-500 text-sm">
                <option value="">Semua Status</option>
                <option value="waiting">Waiting</option>
                <option value="accepted">Accepted</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>

        <div class="overflow-x-auto relative w-full">
            <table class="table table-layout: auto; " id="users-table">
                <thead class= "bg-orange-400/60">
                    <tr class="">
                        <th class="rounded-tl-3xl font-bold">No</th>
                        <th class="font-bold">Name</th>
                        <th class="font-bold">Email</th>
                        <th class="font-bold">No HP</th>
                        <th class="font-bold">Kordinat</th>
                        <th class="font-bold">Status</th>
                        <th class="rounded-tr-3xl font-bold">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div id="modalMap" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div id="modalBackdrop" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-2" id="modal-title">Lokasi Customer</h3>
                    <div id="mapContainer" class="w-full h-80 rounded-lg border border-gray-300 z-0 relative"></div>
                    <p id="textLatLong" class="mt-2 text-xs text-gray-500 text-center font-mono"></p>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="btnCloseMap" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            let table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ordering: false, 
                ajax: {
                    url: "{{ route('admin.data') }}",
                    data: function (d) {
                        d.filter_status = $('#filter_status').val();
                    }
                },
                dom: '<"flex justify-between items-center mb-6"lf>rt<"flex justify-between items-center mt-6"ip>',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'kordinat', name: 'kordinat', orderable: false, searchable: false },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            $('#filter_status').change(function() {
                table.draw();
            });

            $(document).on('click', 'button[data-status]', function() {
                let id = $(this).data('id');
                let status = $(this).data('status');
                
                $.post('/admin/customer/status', {
                    id: id, 
                    status: status, 
                    _token: '{{ csrf_token() }}'
                }, function() {
                    $('#users-table').DataTable().ajax.reload();
                });
            });

            let map = null;
            let marker = null;

            $(document).on('click', '.btn-view-map', function() {
                let lat = $(this).data('lat');
                let lng = $(this).data('lng');
                
                $('#modalMap').removeClass('hidden');
                $('#textLatLong').text('Koordinat: ' + lat + ', ' + lng);

                if (map !== null) {
                    map.setView([lat, lng], 15);
                    marker.setLatLng([lat, lng]);
                } else {
                    setTimeout(function() {
                        map = L.map('mapContainer').setView([lat, lng], 15);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { 
                            attribution: '&copy; OpenStreetMap contributors' 
                        }).addTo(map);
                        marker = L.marker([lat, lng]).addTo(map);
                    }, 100);
                }

                setTimeout(function() { 
                    if(map != null) {
                        map.invalidateSize(); 
                    }
                }, 300);
            });

            function closeModal() { 
                $('#modalMap').addClass('hidden'); 
            }
            
            $('#btnCloseMap').click(closeModal);
            $('#modalBackdrop').click(closeModal);
        });
    </script>
@endsection