@extends('layouts.admin')
@section('content')
@include("includes.admin.navbar")
@include("admin-views.products.modal")
    <div class="container mt-5">
        <div class="row mb-4">
            <h2 class="text-center">Create Product</h2>
        </div>
        <form action="/admin/product/store" method="post">
            <div class="row">
                <div class="col-md-8 mb-5">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="{{ old('name') }}">
                    </div>
                    <div class="form-floating my-5">
                        <textarea class="form-control" name="description" style="height:180px;" placeholder="Leave a comment here" id="description">{{ old('description') }}</textarea>
                        <label for="description">Description</label>
                    </div>
                    
                    <div class="my-5 col-md-4">
                        <label for="price" class="form-label fs-3 mb-3">Price</label>
                        <input type="number" name="price" class="form-control" id="price" value="{{ old('price') }}">
                    </div>
                    <div class="my-5 col-md-4">
                        <select class="form-select" name="category" aria-label="Default select example">
                            <option selected value="0">Category</option>
                            @isset($categories)
                                @foreach ($categories as $category)
                                    <option value="{{$category["id"]}}">{{$category["name"]}}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="my-5 mb-3">
                        <label for="material" class="form-label fs-3 mb-3">Material</label>
                        <input type="text" name="material" value="{{ old('material') }}" class="form-control" id="material">
                    </div>
                    <div class="my-5 mb-3">
                        <label for="printing-type" class="form-label fs-3 mb-3">Printing Type</label>
                        <input type="text" name="printingType" value="{{ old('printingType') }}" class="form-control" id="printing-type">
                    </div>

                    <div class="row mt-5">
                        <div class="col-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="avilable" value="1" id="productAvilable" checked>
                                <label class="form-check-label" for="productAvilable">
                                    Avilable
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="avilable" value="0" id="productNotAvilable">
                                <label class="form-check-label" for="productNotAvilable">
                                    Not Avilable
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="featured" value="1" id="productAvilable">
                                <label class="form-check-label" for="productAvilable">
                                    Featured
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="featured" value="0" id="productNotAvilable" checked>
                                <label class="form-check-label" for="productNotAvilable">
                                    Not Featured
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="active" value="1" id="productAvilable" checked>
                                <label class="form-check-label" for="productAvilable">
                                    Active
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="active" value="0" id="productNotAvilable">
                                <label class="form-check-label" for="productNotAvilable">
                                    Not Active
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="mt-5 btn btn-primary">save</button>
                    
                </div>
                <div class="col-md-4">
                    @yield('modal')
                    @if($errors->any())
                        <div class="error">
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger error-handle fs-5">
                                    {{ $error }}
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div>
                        <button type="button" class="select-product-image pt-0 btn" data-bs-toggle="modal" data-bs-target="#select-product-images">
                            <div class="card select-product-images text-center mb-5" style="width: 18rem;">
                                <i class="bi bi-file-plus text-primary" style="font-size: 128px"></i>
                                <div class="card-body">
                                    <h5 class="card-title">{{ __("app.prod-images") }}</h5>
                                </div>
                            </div>
                        </button>
                    </div>

                    <div class="container">
                        <h3 class="mb-4">{{__("app.avilable-colors")}}</h3>
                        <div class="row row-cols-4">
                            @isset($colors)
                                @foreach ($colors as $color)
                                    <div class="color col mb-4" title="">
                                        <span>{{$color->color_name}}</span>
                                        <label class="select-product-color" style="background-color: {{$color->color}};" for="{{$color->color}}"></label>
                                        <input class="form-check-input" type="checkbox" name="colors[]" id="{{$color->color}}" value="{{$color->id}}">
                                    </div>
                                @endforeach
                            @endisset
                        </div>
                    </div>

                    <div class="container">
                        <h3 class="mb-4">{{__("app.avilable-sizes")}}</h3>
                        <div class="row row-cols-4">
                            @isset($sizes)
                                @foreach ($sizes as $size)
                                    <div class="color col mb-4" title="">
                                        <label class="select-product-color text-center" for="{{$size->size}}">{{$size->size}}</label>
                                        <input class="form-check-input" type="checkbox" name="sizes[]" id="{{$size->size}}" value="{{$size->id}}">
                                    </div>
                                @endforeach
                            @endisset
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection