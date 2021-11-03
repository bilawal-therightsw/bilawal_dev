@extends('layouts.app')

@section('title', '| Dasboard')

@section('styles')
<style>
    .admin-chart-card{
        max-height:370px;
    }
    a.card-body{
        color:rgba(46, 46, 46, 0.933);
    }
</style>
@endsection

@section('breadcrumb')

<div class="row page-title">
    <div class="col-md-6">
        <h5 class="dashboardHeading mb-1 mt-0">Dashboard</h5>
    </div>    
</div>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <a href="{{ route('dashboard.products.index') }}" class="card-body p-0">
                    <div class="media p-3">
                        <div class="media-body">
                            <span class="text-muted text-uppercase font-size-12 font-weight-bold">
                                {{$product_count}}</span>
                            <h2 class="mb-0">Products</h2>
                        </div>
                        <div class="align-self-center">
                            <span class="font-weight-bold" style="font-size:50px;"><i class='uil-shopping-basket'></i></span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @hasrole('admin|staff')
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <a href="{{ route('dashboard.users.index') }}" class="card-body p-0">
                        <div class="media p-3">
                            <div class="media-body">
                                <span class="text-muted text-uppercase font-size-12 font-weight-bold">{{$user_count}}</span>
                                <h2 class="mb-0">Users</h2>
                            </div>
                            <div class="align-self-center">
                                <span class="font-weight-bold" style="font-size:50px;"><i class='uil-user'></i></span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endhasrole
        @hasrole('admin')
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <a href="{{ route('dashboard.staff.index') }}" class="card-body p-0">
                        <div class="media p-3">
                            <div class="media-body">
                                <span class="text-muted text-uppercase font-size-12 font-weight-bold">{{$staff_count}}</span>
                                <h2 class="mb-0">Staff</h2>
                            </div>
                            <div class="align-self-center">
                                <span class="font-weight-bold" style="font-size:50px;"><i class='uil-user-plus'></i></span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endhasrole
    </div>

@endsection

@push('scripts')  

@endpush