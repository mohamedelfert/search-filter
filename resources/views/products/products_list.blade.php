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
                <form class="form-horizontal" method="post" action="{{ route('products.list') }}">
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
                    <h2 class="pb-2">All Products</h2>
                    <div class="table-responsive">
                        @if(count($products))
                            <table id="datatable" class="table table-striped table-bordered p-0">
                                <thead class="text-center">
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>Tags</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody class="text-center">
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->title }}</td>
                                        <td>EGP {{ $product->price }}</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td>
                                            @foreach($product->tags as $tag)
                                                <label class="badge badge-primary">{{ $tag->name }}</label>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="{{ route('products.edit',$product->id) }}">
                                                Edit
                                            </a>
                                            <a class="modal-effect btn btn-danger btn-sm" data-effect="effect-scale"
                                               data-toggle="modal" href="#delete{{ $product->id }}">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Delete -->
                                    <div class="modal fade" id="delete{{ $product->id }}">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content modal-content-demo">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">Delete Product</h6>
                                                    <button aria-label="Close" class="close" data-dismiss="modal"
                                                            type="button"><span
                                                            aria-hidden="true">&times;</span></button>
                                                </div>
                                                <form action="{{ route('products.destroy','test') }}" method="post">
                                                    {{ method_field('delete') }}
                                                    {{ csrf_field() }}
                                                    <div class="modal-body">
                                                        <p>Are You Sure About Delete This Product ?</p><br>
                                                        <input type="hidden" name="id" id="id"
                                                               value="{{ $product->id }}">
                                                        <input class="form-control" name="title" id="title" type="text"
                                                               value="{{ $product->title }}" readonly>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close
                                                        </button>
                                                        <button type="submit"
                                                                class="btn btn-danger">Confirm
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Delete -->

                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <table id="datatable" class="table table-striped table-bordered p-0">
                                <thead class="text-center">
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>Tags</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody class="text-center">
                                <tr>
                                    <td colspan="6" class="text-center text-danger">
                                        There are no products at this time.
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        @endif
                    </div>

                </div>

                <div class="d-flex justify-content-center">
                    {{ $products->appends(request()->input())->links() }}
                </div>

            </div>

        </div>
    </div>
@endsection
