@extends('layouts.app')
@section('title', 'Admin')

@section('content')
    <div class="container flex flex-col justify-center items-center py-3 px-5 bg-white w-full rounded">
        <table class="table" id="users-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Kordinat</th>
                    <th>Status</th>
                    <th>Action</th>
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
