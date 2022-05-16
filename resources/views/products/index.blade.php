@extends('layouts.app')

@section('content')
    <div class="container">

        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session()->get('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row justify-content-center">

            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                Sidebar
            </div>

            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mb-5">
                            <div class="card h-100">
                                <div class="card-head">
                                    <a href="#">
                                        <img src="{{ $product->image }}" class="card-img-top"
                                             alt="{{ $product->title }}"/>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title">{{ $product->title }}</h4>
                                    <h5 class="badge badge-primary">Price : $ {{ $product->price }}</h5>
                                    <p class="card-text">{{ $product->description }}</p>
                                    @foreach($product->tags as $tag)
                                        <label class="badge badge-success">{{ $tag->name }}</label>
                                    @endforeach
                                    <hr>
                                    <label class="badge badge-info">{{ $product->category->name }}</label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center">
                    {{ $products->links() }}
                </div>

            </div>

        </div>
    </div>
@endsection
