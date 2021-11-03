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
                <li class="breadcrumb-item"><a href="{{route('dashboard.products.index')}}">Products</a></li>
                <li class="breadcrumb-item">{{$product->name}}</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('content')

<div class="card container">

    <div class="row float-right p-5">
        <div class="col-md-8">
            <img src="{{ getImage($product->image) }}" height="200">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group"><label class="control-label">Product Name</label></div>
        </div>
        <div class="col-md-8">
            <div class="form-group"><p>{{ $product->name }}</p></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group"><label class="control-label">Description</label></div>
        </div>
        <div class="col-md-8">
            <div class="form-group"><p>{{ $product->description }}</p></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group"><label class="control-label">Price</label></div>
        </div>
        <div class="col-md-8">
            <div class="form-group"><p>{{ $product->price }}</p></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group"><label class="control-label">Status</label></div>
        </div>
        <div class="col-md-8">
            <div class="form-group"><p>{{ $product->status }} </p></div>
        </div>
    </div>

</div>

@endsection