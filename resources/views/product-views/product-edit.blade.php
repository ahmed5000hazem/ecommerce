@extends('layouts.seller')
@include('product-views.modal')
@section('content')
    @include('includes.seller.navbar')
    <div class="container mt-5">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class=" btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="mx-5">
                <strong>{{__("app.becareful")}}</strong>{{__("app.edit-prod-image-warning-text")}}
            </div>
        </div>
        <form action="{{route("seller_update_prod")}}" method="post">
            <div class="row">
                <div class="col-md-8 my-5">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                    <div class="mb-3">
                        <label for="name" class="form-label fs-3 mb-3">{{ __("app.prod-name") }}</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ $product->name }}">
                        <div id="emailHelp" class="form-text">{{ __("app.prod-name-hint") }}</div>
                    </div>
                    <div class="form-floating my-5">
                        <textarea class="form-control" name="description" style="height:180px;" placeholder="Leave a comment here" id="description">{{ $product->description }}</textarea>
                        <label for="description">{{ __("app.prod-disc") }}</label>
                        <div id="emailHelp" class="form-text">{{ __("app.prod-disc-hint") }}</div>
                    </div>
                    
                    <div class="my-5 col-md-4">
                        <label for="price" class="form-label fs-3 mb-3">{{ __("app.prod-price") }}</label>
                        <input type="number" name="price" class="form-control" id="price" value="{{ $product->price }}">
                    </div>
                    <div class="my-5 col-md-4">
                        <select class="form-select" name="category" aria-label="Default select example">
                            <option selected value="0">{{ __("app.prod-category") }}</option>
                            @isset($categories)
                                @foreach ($categories as $category)
                                    <option value="{{$category["id"]}}" <?php if ($category["id"] === $product->category_id) echo "selected"; ?> >{{$category["name"]}}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="my-5 mb-3">
                        <label for="material" class="form-label fs-3 mb-3">{{ __("app.prod-material") }}</label>
                        <input type="text" name="material" value="{{ $product->material }}" class="form-control" id="material">
                        <div id="emailHelp" class="form-text">{{ __("app.prod-material-hint") }}</div>
                    </div>
                    <div class="my-5 mb-3">
                        <label for="printing-type" class="form-label fs-3 mb-3">{{ __("app.prod-printing_type") }}</label>
                        <input type="text" name="printingType" value="{{ $product->printing_type }}" class="form-control" id="printing-type">
                        <div id="emailHelp" class="form-text">{{ __("app.prod-printing_type-hint") }}</div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="avilable" value="1" id="productAvilable" @if($product->is_avilable) checked @endif>
                                <label class="form-check-label" for="productAvilable">
                                    Avilable
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="avilable" value="0" id="productNotAvilable" @if(!$product->is_avilable) checked @endif>
                                <label class="form-check-label" for="productNotAvilable">
                                    Not Avilable
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="mt-5 btn btn-primary">{{__("app.save")}}</button>
                    
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
                        <button type="button" class="select-product-image btn" data-bs-toggle="modal" data-bs-target="#select-product-images">
                            
                            <div class="card select-product-images text-center my-5" style="width: 18rem;">
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
                            @isset($product_colors)
                                @foreach ($product_colors as $color)
                                    <div class="color col mb-4" title="">
                                        <span>{{$color->color_name}}</span>
                                        <label class="select-product-color active" style="background-color: {{$color->color}};" for="{{$color->color}}"></label>
                                        <input class="form-check-input" checked type="checkbox" name="colors[]" id="{{$color->color}}" value="{{$color->id}}">
                                    </div>
                                @endforeach
                            @endisset
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
                            @isset($product_sizes)
                                @foreach ($product_sizes as $size)
                                    <div class="color col mb-4" title="">
                                        <label class="select-product-color text-center active" for="{{$size->size}}">{{$size->size}}</label>
                                        <input class="form-check-input" checked type="checkbox" name="sizes[]" id="{{$size->size}}" value="{{$size->id}}">
                                    </div>
                                @endforeach
                            @endisset
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