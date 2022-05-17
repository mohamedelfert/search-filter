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
                <form class="form-horizontal" method="post" action="{{ route('products.index') }}">
                    @csrf
                    <h3 class="pb-2">Search</h3>
                    <div class="form-group pb-3">
                        <input type="text" name="keyword" value="{{ old('keyword',$keyword) }}" class="form-control"
                               placeholder="Keyword For Search">
                    </div>

                    <div class="form-group pb-3">
                        <h3>Price</h3>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" name="price" value="price_0_500"
                                       {{ isset($selectedPrice) && $selectedPrice == 'price_0_500' ? 'checked' : '' }}
                                       class="form-check-input"> 0 - 500
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" name="price" value="price_501_1500"
                                       {{ isset($selectedPrice) && $selectedPrice == 'price_501_1500' ? 'checked' : '' }}
                                       class="form-check-input"> 501 - 1500
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" name="price" value="price_1501_3000"
                                       {{ isset($selectedPrice) && $selectedPrice == 'price_1501_3000' ? 'checked' : '' }}
                                       class="form-check-input"> 1501 - 3000
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" name="price" value="price_3001_5000"
                                       {{ isset($selectedPrice) && $selectedPrice == 'price_3001_5000' ? 'checked' : '' }}
                                       class="form-check-input"> 3001 - 5000
                            </label>
                        </div>
                    </div>

                    <div class="form-group pb-3">
                        <h3>Category</h3>
                        @foreach($categories as $category)
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" name="category" value="{{ $category->id }}"
                                           {{ isset($selectedCategory) && $selectedCategory == $category->id ? 'checked' : '' }}
                                           class="form-check-input">
                                    {{ $category->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group pb-3">
                        <h3>Tag</h3>
                        @foreach($tags as $tag)
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                           {{ isset($selectedTag) && in_array($tag->id,$selectedTag) ? 'checked' : '' }}
                                           class="form-check-input">
                                    {{ $tag->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group pb-3">
                        <button type="submit" class="btn btn-primary btn-block">Search</button>
                        <a href="{{ route('products.index') }}" class="btn btn-danger btn-block">Reset</a>
{{--                        <a href="{{ route('reset') }}" class="btn btn-danger btn-block">Reset</a>--}}
                    </div>
                </form>
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
                                    <h5><span class="badge badge-primary">Price : EGP {{ $product->price }}</span></h5>
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
                    {{ $products->appends(request()->input())->links() }}
                </div>

            </div>

        </div>
    </div>
@endsection
