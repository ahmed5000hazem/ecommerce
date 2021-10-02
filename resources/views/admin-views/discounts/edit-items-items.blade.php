@extends('layouts.admin')
@section('content')
    @include('includes.admin.navbar')
    <div class="container my-5 pt-3 pb-5" dir="rtl">
        <div class="modal fade" id="modal{{$product->id}}" tabindex="-1" aria-labelledby="modal{{$product->id}}Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal{{$product->id}}Label"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger">{{__("app.are you sure to delete")}}</div>
                        <form action="/admin/discounts/items-items-disc/{{$discount->id}}/delete" method="post">
                            @csrf
                            <button class="btn btn-sm btn-danger" name="product" value="{{$product->id}}">{{__("app.delete")}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <form action="/admin/discount/items-items-disc/{{$discount->id}}/update" method="post">
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
                                    <a href="/admin/product/{{$product->id}}/show" class="btn mt-4 btn-primary">{{__("app.details")}}</a>
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
                        <input type="text" class="form-control" name="product_id" id="productId" value="{{$product->id}}">
                    </div>
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
                                <input type="text" class="form-control" name="items_items_disc_present_product_id" value="{{$discount->present_product_id}}" placeholder="{{__("app.present-id")}}">
                            </div>
                            <div class="col mt-4">
                                <input type="text" class="form-control" name="items_items_disc_buy_items_count" value="{{$discount->buy_items_count}}" placeholder="{{__("app.prod-number")}}">
                            </div>
                            <div class="col mt-4">
                                <input type="text" class="form-control" name="items_items_disc_get_items_count" value="{{$discount->get_items_count}}" placeholder="{{__("app.prod-present-number")}}">
                            </div>
                            <div class="col mt-4">
                                <label for="items_items_disc_starts_at" class="d-block p-2 text-center fw-bold form-label">{{__("app.starts_at")}}</label>
                                <input type="date" id="items_items_disc_starts_at" class="form-control" value="<?php echo date("Y-m-d" , strtotime($discount->starts_at)); ?>" name="items_items_disc_starts_at">
                            </div>
                            <div class="col mt-4">
                                <label for="items_items_disc_ends_at" class="d-block p-2 text-center fw-bold form-label">{{__("app.ends_at")}}</label>
                                <input type="date" id="items_items_disc_ends_at" class="form-control" @if($discount->ends_at) value="<?php echo date("Y-m-d" , strtotime($discount->ends_at)); ?>" @endif name="items_items_disc_ends_at">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <h3 class="text-center">
                        {{__("app.the-present")}}
                    </h3>
                    <div class="card mt-5" style="">
                        <img src="/images/products/sellers/{{$present->images()->get()[0]->path}}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title mb-3">{{$present->name}}</h5>
                            <p class="card-text mb-3 product-price"> {{__("app.prod-price")}} : <span data-price="{{$present->price}}"> {{$present->price}} </span> {{__("app.EGP")}}  </p>
                            <a href="/seller/product/{{$present->id}}" class="btn mt-4 btn-primary">{{__("app.details")}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection