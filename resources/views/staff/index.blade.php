@extends('layouts.app')

@section('title', '| Users')

@section('styles')

@endsection

@section('breadcrumb')

<div class="row page-title align-items-center">
    <div class="col-md-12 col-xl-12">
        <nav aria-label="breadcrumb" class="mt-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard.')}}">Home</a></li>
                <li class="breadcrumb-item">Staff</li>
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
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>City</th>
                                    <th>Country</th>
                                    <th>Type</th>
                                    <th>Status</th>
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
                    url : '{{ route("dashboard.staff-dt") }}',
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
                    {data: 'email', name: 'email'},
                    {data: 'phone', name: 'phone'},
                    {data: 'city', name: 'city'},
                    {data: 'country', name: 'country'},
                    {data: 'user_type', name: 'user_type'},
                    {data: 'status', name: 'status'},                ]
            });
        });
</script>
@endpush