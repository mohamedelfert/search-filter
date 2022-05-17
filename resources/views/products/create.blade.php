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

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form class="form-horizontal" method="post" action="{{ route('products.store') }}">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="title">Product Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}"
                               placeholder="Enter Product Title">
                        @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="description">Product Description</label>
                        <textarea class="form-control" id="description" name="description"
                                  placeholder="Enter Product Description">{{ old('description') }}</textarea>
                        @error('description')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="price">Product Price</label>
                        <input type="text" class="form-control" id="price" name="price" value="{{ old('price') }}"
                               placeholder="Enter Product Price">
                        @error('price')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="category_id">Product Category</label>
                        @foreach($categories as $category)
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" name="category_id" value="{{ $category->id }}"
                                           {{ old('category_id') == $category->id ? 'checked' : '' }}
                                           class="form-check-input">
                                    {{ $category->name }}
                                </label>
                            </div>
                        @endforeach
                        @error('category_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="tags">Product Tags</label>
                        @foreach($tags as $tag)
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                           {{ is_array(old('tags')) && in_array($tag->id,old('tags')) ? 'checked' : '' }}
                                           class="form-check-input">
                                    {{ $tag->name }}
                                </label>
                            </div>
                        @endforeach
                        @error('tags')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="image">Product Image Url</label>
                        <input type="text" class="form-control" id="image" name="image" value="{{ old('image') }}"
                               placeholder="Enter Product Image URL">
                        @error('image')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group pb-3">
                        <button type="submit" class="btn btn-primary btn-block" name="save">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
