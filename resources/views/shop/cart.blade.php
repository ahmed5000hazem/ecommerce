@extends('layouts.app')
@section('content')
@include("includes.shop.header")
<div class="site-section mb-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-6">          
                <button class="btn essence-btn fs-6 btn-lg btn-block" onclick="window.location='/checkout'">{{__("app.proceed-to-checkout")}}</button>    
            </div>
        </div>
        <div class="row mb-5">
            <form class="col-md-12" method="post">
                <div class="site-blocks-table">
                    <div class="table-responsive">
                        @if (!$cartItems->isEmpty())
                        <table class="table text-center align-middle table-bordered cart-table">
                            <thead>
                                <tr>
                                <th class="p-4 product-thumbnail">{{__("app.image")}}</th>
                                <th class="p-4 product-name">{{__("app.product")}}</th>
                                <th class="p-4 product-price">{{__("app.prod-price")}}</th>
                                <th class="p-4 product-color">{{__("app.color")}}</th>
                                <th class="p-4 product-size">{{__("app.size")}}</th>
                                <th class="p-4 product-quantity">{{__("app.qty")}}</th>
                                <th class="p-4 product-remove">{{__("app.delete")}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $itemKey => $item)
                                    <tr>
                                        <td class="product-thumbnail">
                                            <img src="/images/products/sellers/{{$item["product_image"]->path}}" width="128" height="128" alt="Image" class="img-fluid">
                                        </td>
                                        <td class="p-3 product-name">
                                            <h2 class="text-black"><a class="fs-6" href="/product/{{$item["product_id"]}}/show">{{$item["product_name"]}}</a> </h2>
                                        </td>
                                        <td class="p-3 fw-bold"><strong> {{$item["price"]}} {{__("app.EGP")}} </strong></td>
                                        <td> {{ App\Models\Color::find($item["color"])->color_name }} </td>
                                        <td>{{ App\Models\Size::find($item["size"])->size }}</td>
                                        <td class="p-3 position-relative">
                                            <div class="input-group position-absolute top-50 start-50 translate-middle" style="max-width: 120px;">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-outline-primary rounded-0 js-btn-minus" data-cart="{{ $itemKey }}" type="button">&minus;</button>
                                                </div>
                                                <input type="text" class="form-control text-center" readonly value="{{$item["qty"]}}" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-primary rounded-0 js-btn-plus" data-cart="{{ $itemKey }}" type="button">&plus;</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-3"><a href="/cart/{{$item['product_id']}}-{{$item['size']}}-{{$item['color']}}/destroy" class="p-3 btn delete-from-cart btn-danger rounded-0 height-auto btn-sm">X</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            <div class="alert alert-info fs-5 fw-bold text-center"> {{__("app.no-items-in-cart")}} <a href="/" class="text-primary fs-6">{{__("app.go-to-shop")}}</a> </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

  @endsection