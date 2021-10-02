@extends('layouts.seller')
@section('content')
    @include('includes.seller.navbar')
    <div class="container my-5 pt-3 pb-5">
        <form action="/seller/discount/{{$product->id}}/store" method="post">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col">
                            <div class="card mt-5" style="">
                                <img src="/images/products/sellers/{{$product->images()->get()[0]->path}}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">{{$product->name}}</h5>
                                    <p class="card-text mb-3 product-price"> {{__("app.prod-price")}} : <span data-price="{{$product->price}}"> {{$product->price}} </span> {{__("app.EGP")}}  </p>
                                    <p class="card-text mb-3 price-after-disc"> {{__("app.prod-price-after-disc")}} : <span> {{$product->price}} </span> {{__("app.EGP")}}  </p>
                                    <p class="card-text mb-3 price-after-disc-percent"> {{__("app.prod-price-after-disc-percent")}} : <span> {{$product->price}} </span> {{__("app.EGP")}}  </p>
                                    <a href="/seller/product/{{$product->id}}" class="btn btn-primary">{{__("app.details")}}</a>

                                    <div class="d-grid mt-5">
                                        <button class="btn btn-primary"> {{__("app.save")}} </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($errors->any())
                            <div class="error">
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger error-handle fs-5">
                                        {{ $error }}
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="productId" class="d-block p-2 text-center fw-bold fs-5 form-label">{{__("app.prod-id")}}</label>
                        <input type="text" class="form-control" name="product_id" readonly id="productId" value="{{$product->id}}">
                    </div>
                    <div class="my-5">
                        <div class="alert alert-info mb-5">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <p class="mt-3">
                                {{__("app.item-value-discription")}}
                            </p>
                        </div>
                        <h4> {{__("app.item-value")}} </h4>
                        <div class="row row-cols-2">
                            <div class="col mt-4">
                                <input type="text" class="form-control" name="item_value_disc_value" placeholder="{{__("app.value")}}">
                            </div>
                            <div class="col mt-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="item_value_disc_percent" placeholder="{{__("app.percent")}}">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            <div class="col mt-4">
                                <label for="item_value_disc_starts_at" class="d-block p-2 text-center fw-bold form-label">{{__("app.starts_at")}}</label>
                                <input type="date" id="item_value_disc_starts_at" class="form-control" name="item_value_disc_starts_at">
                            </div>
                            <div class="col mt-4">
                                <label for="item_value_disc_ends_at" class="d-block p-2 text-center fw-bold form-label">{{__("app.ends_at")}}</label>
                                <input type="date" id="item_value_disc_ends_at" class="form-control" name="item_value_disc_ends_at">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="my-5">
                        <div class="alert alert-info mb-5">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <p class="mt-3">
                                {{__("app.items-value-discription")}}
                            </p>
                        </div>
                        <h4> {{__("app.items-value")}} </h4>
                        <div class="row row-cols-2">
                            <div class="col mt-4">
                                <input type="text" class="form-control" name="items_value_disc_items_number" placeholder="{{__("app.prod-number")}}">
                            </div>
                            <div class="col mt-4">
                                <input type="text" class="form-control" name="items_value_disc_value" placeholder="{{__("app.value")}}">
                            </div>
                            <div class="col mt-4">
                                <label for="items_value_disc_starts_at" class="d-block p-2 text-center fw-bold form-label">{{__("app.starts_at")}}</label>
                                <input type="date" id="items_value_disc_starts_at" class="form-control" name="items_value_disc_starts_at">
                            </div>
                            <div class="col mt-4">
                                <label for="items_value_disc_ends_at" class="d-block p-2 text-center fw-bold form-label">{{__("app.ends_at")}}</label>
                                <input type="date" id="items_value_disc_ends_at" class="form-control" name="items_value_disc_ends_at">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="my-5">
                        <div class="alert alert-info mb-5">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <p class="mt-3">
                                {{__("app.items-items-discription")}}
                            </p>
                        </div>
                        <h4> {{__("app.items-items")}} </h4>
                        <div class="row row-cols-2">
                            <div class="col-12 mt-4 mb-5">
                                <label for="items_items_disc_present_product_id" class="d-block p-2 text-center fw-bold form-label">{{__("app.present-id")}}</label>
                                <input type="text" class="form-control" name="items_items_disc_present_product_id" value="{{$product->id}}" placeholder="{{__("app.present-id")}}">
                            </div>
                            <div class="col mt-4">
                                <input type="text" class="form-control" name="items_items_disc_buy_items_count" placeholder="{{__("app.prod-number")}}">
                            </div>
                            <div class="col mt-4">
                                <input type="text" class="form-control" name="items_items_disc_get_items_count" placeholder="{{__("app.prod-present-number")}}">
                            </div>
                            <div class="col mt-4">
                                <label for="items_items_disc_starts_at" class="d-block p-2 text-center fw-bold form-label">{{__("app.starts_at")}}</label>
                                <input type="date" id="items_items_disc_starts_at" class="form-control" name="items_items_disc_starts_at">
                            </div>
                            <div class="col mt-4">
                                <label for="items_items_disc_ends_at" class="d-block p-2 text-center fw-bold form-label">{{__("app.ends_at")}}</label>
                                <input type="date" id="items_items_disc_ends_at" class="form-control" name="items_items_disc_ends_at">
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </form>
    </div>
@endsection