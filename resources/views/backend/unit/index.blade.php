@extends('backend.layouts.app')
@section('title', 'Units')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}">
@endsection
@section('content')
    <ol class="breadcrumb breadcrumb-style1">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Units</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Units</h5>
                    <div class="d-flex align-items-center gap-2">
                        <div>
                            <select name="status" id="status" class="form-control">
                                <option value="">All</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <a href="{{route('units.create')}}" class="btn btn-primary">Add Unit</a>
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="unitTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/toastr/toastr.js')}}"></script>
    <script>
        $(document).ready(function () {

            let table = $('#unitTable').DataTable(
                {
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('units.index') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'name', name: 'name'},
                        {data: 'slug', name: 'slug'},
                        {data: 'status', name: 'status'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                }
            );

            $('body').on('click', '.deleteUnit', function () {
                const id = $(this).data('id');
                let url = "{{route('units.destroy', ':id')}}";
                url = url.replace(':id', id);
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: '{{csrf_token()}}'
                            },
                            success: function () {
                                toastr.success('Unit deleted successfully', 'Success');
                                table.ajax.reload();
                            }
                        })
                    }
                })
            })

            $('#status').change(function () {
                let status = $(this).val();
                console.log(status)
                let url = "{{route('units.index')}}";
                url = url + "?status=" + status;
                table.ajax.url(url).load();
            })

            $("body").on("click", ".changeStatus", function () {
                let id = $(this).data('id');
                let url = "{{route('units.status', ':id')}}";
                url = url.replace(':id', id);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function () {
                        toastr.success('Status changed successfully', 'Success');
                        table.ajax.reload();
                    }
                })
            })

        });


    </script>
@endsection
