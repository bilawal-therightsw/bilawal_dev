@extends('layouts.app')

@section('title', '| Products')

@section('styles')

@endsection

@section('breadcrumb')

<div class="row page-title align-items-center">
    <div class="col-md-12 col-xl-12">

        <nav aria-label="breadcrumb" class="mt-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard.')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('dashboard.users.index')}}">Products</a></li>
                <li class="breadcrumb-item">{{$user->name}}</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('content')

<div class="card container px-4">

    <div class="row pt-5">
        <div class="col-md-4">
            <div class="form-group"><label class="control-label">User Name</label></div>
        </div>
        <div class="col-md-8">
            <div class="form-group"><p>{{ ucwords($user->name) }}</p></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group"><label class="control-label">Email</label></div>
        </div>
        <div class="col-md-8">
            <div class="form-group"><p>{{ $user->email }}</p></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group"><label class="control-label">Phone</label></div>
        </div>
        <div class="col-md-8">
            <div class="form-group"><p>{{ $user->phone }}</p></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group"><label class="control-label">City</label></div>
        </div>
        <div class="col-md-8">
            <div class="form-group"><p>{{ ucwords($user->city )}}</p></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group"><label class="control-label">Country</label></div>
        </div>
        <div class="col-md-8">
            <div class="form-group"><p>{{ ucwords($user->country )}}</p></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group"><label class="control-label">Role</label></div>
        </div>
        <div class="col-md-8">
            <div class="form-group"><p>{{ ucwords($user->user_type) }}</p></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group"><label class="control-label">Status</label></div>
        </div>
        <div class="col-md-8">
            <div class="form-group"><p>{{ ucfirst($user->status ? 'active' : 'inactive') }} </p></div>
        </div>
    </div>

</div>

@endsection