@extends('layouts.seller')
@section('content')
    @include('includes.seller.navbar')
    <div class="container my-5 pt-3 pb-5">
        <div class="modal fade" id="modal{{$product->id}}" tabindex="-1" aria-labelledby="modal{{$product->id}}Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal{{$product->id}}Label"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger">{{__("app.are you sure to delete")}}</div>
                        <form action="/seller/discounts/item-value-disc/{{$discount->id}}/delete" method="post">
                            @csrf
                            <button class="btn btn-sm btn-danger" name="product" value="{{$product->id}}">{{__("app.delete")}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <form action="/seller/discount/item-value-disc/{{$discount->id}}/update" method="post">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col">
                            <div class="card mt-5" style="">
                                <img src="/images/products/sellers/{{$product->images()->get()[0]->path}}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">{{$product->name}}</h5>
                                    <p class="card-text mb-3 product-price text-decoration-line-through"> {{__("app.prod-price")}} : <span data-price="{{$product->price}}"> {{$product->price}} </span> {{__("app.EGP")}}  </p>
                                    <p class="card-text mb-3 price-after-disc"> {{__("app.prod-price-after-disc")}} : <span> {{$product->price - $discount->value }} </span> {{__("app.EGP")}}  </p>
                                    <p class="card-text mb-3 price-after-disc-percent"> {{__("app.prod-price-after-disc-percent")}} : <span> {{$product->price - (($discount->percent / 100) * $product->price) }} </span> {{__("app.EGP")}}  </p>
                                    <a href="/seller/product/{{$product->id}}" class="btn btn-primary">{{__("app.details")}}</a>

                                    <div class="d-grid gap-4 mt-5">
                                        <button class="btn btn-primary"> {{__("app.save")}} </button>
                                        
                                        <button type="button" class="float-end btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal{{$product->id}}">
                                            {{__("app.delete")}}
                                        </button>
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
                                <input type="text" class="form-control" value="{{$discount->value}}" name="item_value_disc_value" placeholder="{{__("app.value")}}">
                            </div>
                            <div class="col mt-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{$discount->percent}}" name="item_value_disc_percent" placeholder="{{__("app.percent")}}">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            <div class="col mt-4">
                                <label for="item_value_disc_starts_at" class="d-block p-2 text-center fw-bold form-label">{{__("app.starts_at")}}</label>
                                <input type="date" id="item_value_disc_starts_at" value="<?php echo date("Y-m-d" , strtotime($discount->starts_at)); ?>" class="form-control" name="item_value_disc_starts_at">
                            </div>
                            <div class="col mt-4">
                                <label for="item_value_disc_ends_at" class="d-block p-2 text-center fw-bold form-label">{{__("app.ends_at")}}</label>
                                <input type="date" id="item_value_disc_ends_at" @if($discount->ends_at) value="<?php echo date("Y-m-d" , strtotime($discount->ends_at)); ?>" @endif class="form-control" name="item_value_disc_ends_at">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection