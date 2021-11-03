@extends('layouts.app')

@section('title', '| Products')

@section('styles')

@endsection

@section('breadcrumb')

<div class="row page-title align-items-center">
    <div class="col-md-12 col-xl-12">
        @hasrole('staff|admin')
            <div class="dropdown float-right">
                <a href="javascript:void(0);" class="btn btn-primary btn-sm" data-toggle="dropdown" aria-expanded="false">
                    <i class="uil-layers"></i> Actions
                    <i class="uil uil-angle-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right top-right-action-btn" x-placement="bottom-end">
                    <a href="javascript:void(0);" class="dropdown-item text-success" data-act="ajax-modal" data-method="get"
                        data-action-url="{{ route('dashboard.products.create') }}" data-title="Add New Product">
                        <i class="uil uil-plus mr-1"></i> Add New Product
                    </a>
                </div>
            </div>
        @endhasrole
        <nav aria-label="breadcrumb" class="mt-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard.')}}">Home</a></li>
                <li class="breadcrumb-item">Products</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col table-responsive">
                        <table id="stores-table" class="table dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    @hasrole('admin|staff')
                                    <th>Action</th>
                                    @endhasrole
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
            $('#stores-table').DataTable({
                ajax: {
                    url : '{{ route("dashboard.products-dt") }}',
                    type : 'get',
                },
                processing: true,
                serverSide: true,
                scrollX: false,
                autoWidth: true,
                stateSave: true,
                language: {
                    paginate: {
                        next: 'Next',
                        previous: 'Previous'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'id', orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'description', name: 'description'},
                    {data: 'price', name: 'price'},
                    {data: 'status', name: 'status'},
                    @hasrole('admin|staff')
                        {data: 'actions', name: 'actions', orderable: false, searchable: false},
                    @endhasrole
                ]
            });
        });
</script>
@endpush