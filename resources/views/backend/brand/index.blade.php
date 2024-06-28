@extends('backend.layouts.app')
@section('title', 'Brand')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}">

@endsection
@section('content')
    <ol class="breadcrumb breadcrumb-style1">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Brands</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Brands</h5>
                    <a href="{{route('brands.create')}}" class="btn btn-primary">Add Brand</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="brandTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--                            @foreach($brands as $key => $brand)--}}
                            {{--                                <tr>--}}
                            {{--                                    <td>{{ $key+1 }}</td>--}}
                            {{--                                    <td>{{ $brand->name }}</td>--}}
                            {{--                                    <td>{{ $brand->slug }}</td>--}}
                            {{--                                    <td>--}}
                            {{--                                        <img src="{{ asset('uploads/brands/'.$brand->image) }}" alt="{{ $brand->name }}" width="50">--}}
                            {{--                                    </td>--}}
                            {{--                                    <td>--}}
                            {{--                                        @if($brand->status == 1)--}}
                            {{--                                            <span class="badge bg-success">Active</span>--}}
                            {{--                                        @else--}}
                            {{--                                            <span class="badge bg-warning">Inactive</span>--}}
                            {{--                                        @endif--}}
                            {{--                                    </td>--}}
                            {{--                                    <td>{{ $brand->created_at->format('d-m-Y') }}</td>--}}
                            {{--                                    <td>--}}
                            {{--                                        <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-primary btn-sm">--}}
                            {{--                                            <i class="ti ti-pencil"></i>--}}
                            {{--                                        </a>--}}
                            {{--                                        <button class="btn btn-danger btn-sm" onclick="deleteBrand({{ $brand->id }})"><i class="ti ti-trash"></i></button>--}}
                            {{--                                    </td>--}}
                            {{--                                </tr>--}}
                            {{--                            @endforeach--}}
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
    <script>
        $(document).ready(function () {
            let table = $('#brandTable').DataTable(
                {
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('brands.index') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'name', name: 'name'},
                        {data: 'slug', name: 'slug'},
                        {data: 'image', name: 'image'},
                        {data: 'status', name: 'status'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                }
            );
            $('body').on('click', '.deleteBrand', function () {
                const id = $(this).data('id');
                let url = "{{route('brands.destroy', ':id')}}";
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
                                setTimeout(function () {
                                    location.reload();
                                }, 1000);
                            }
                        })
                    }
                })
            })
        });



    </script>
@endsection
