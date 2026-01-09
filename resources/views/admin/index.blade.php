@extends('layouts.app')
@section('title', 'Admin')

@section('content')
    <div class="flex flex-col justify-center p-8 bg-white w-full max-w-7xl rounded-3xl">
        <table class="table table-layout: auto;" id="users-table">
            <thead class= "bg-orange-400/60">
                <tr class="">
                    <th class="rounded-l-3xl font-bold">No</th>
                    <th class="font-bold">Name</th>
                    <th class="font-bold">Email</th>
                    <th class="font-bold">No HP</th>
                    <th class="font-bold">Kordinat</th>
                    <th class="font-bold">Status</th>
                    <th class="rounded-r-3xl font-bold">Action</th>
                </tr>
            </thead>
        </table>

        <script>
            $(function() {
                $('#users-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.data') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'kordinat',
                            name: 'kordinat',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
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
        </script>
    </div>
@endsection
