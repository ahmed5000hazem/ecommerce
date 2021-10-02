@extends('layouts.admin')
@section('content')
    @include('includes.admin.navbar')
    <div class="container py-5 mt-5" dir="rtl">
        <div class="modal fade" id="modal{{$coupon->id}}" tabindex="-1" aria-labelledby="modal{{$coupon->id}}Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal{{$coupon->id}}Label"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger">{{__("app.are you sure to delete")}}</div>
                        <form action="/admin/coupons/{{$coupon->id}}/delete" method="post">
                            @csrf
                            <button class="btn btn-sm btn-danger" name="coupon" value="{{$coupon->id}}">{{__("app.delete")}}</button>
                        </form>
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
        <form action="/admin/coupons/update/{{$coupon->id}}" method="post">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-8 col-sm-12">
                    <div class="row row-cols-2">
                        <div class="mb-3 col">
                            <label for="coupon" class="form-label">{{__("app.coupon")}}</label>
                            <input type="text" name="coupon" class="form-control" id="coupon" value="{{ $coupon->coupon }}" aria-describedby="couponHelp">
                            <div id="couponHelp" class="form-text">{{__("app.coupon-help")}}</div>
                        </div>
                        <div class="mb-3 col">
                            <label for="couponValue" class="form-label">{{__("app.value")}}</label>
                            <div class="input-group">
                                <input type="text" name="coupon_value" value="{{ $coupon->value }}" class="form-control" id="couponValue">
                                <span class="input-group-text" id="couponValueAdon">{{__("app.EGP")}}</span>
                            </div>
                            <div id="couponHelp" class="form-text">{{__("app.coupon-value-help")}}</div>
                        </div>
                    </div>
                    <div class="row row-cols-2">
                        <div class="mb-3 col">
                            <label for="couponProdId" class="form-label">{{__("app.prod-id")}}</label>
                            <input type="text" class="form-control" value="{{ $coupon->product_id }}" name="coupon_product_id" id="couponProdId" aria-describedby="couponProdIdHelp">
                            <div id="couponProdIdHelp" class="form-text text-warning"> <strong>!!</strong> {{__("app.coupon-prod-id-help")}}</div>
                        </div>
                        <div class="mb-3 col">
                            <label for="couponHowmanyUses" class="form-label">{{__("app.coupon-howmany-uses")}}</label>
                            <input type="number" name="coupon_howmany_uses" value="{{ $coupon->howmany_uses }}" class="form-control" id="couponHowmanyUses" aria-describedby="couponHowmanyUsesHelp">
                            <div id="couponHowmanyUsesHelp" class="form-text">{{__("app.coupon-howmany-uses-help")}}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col">
                            <label for="minOrderPrice" class="form-label">{{__("app.coupon-min-order-price")}}</label>
                            <input type="number" class="form-control" value="{{ $coupon->min_order_price }}" name="coupon_min_order_price" id="minOrderPrice" aria-describedby="couponMinOrderPriceHelp">
                            <div id="couponMinOrderPriceHelp" class="form-text">{{__("app.coupon-min-order-price-help")}}</div>
                        </div>
                    </div>
                    <div class="row row-cols-2">
                        <div class="col mt-4">
                            <label for="couponStartsAt" class="d-block p-2 text-center form-label">{{__("app.starts_at")}}</label>
                            <input type="date" id="couponStartsAt" class="form-control" value="<?php echo date("Y-m-d" , strtotime($coupon->starts_at)); ?>" name="coupon_starts_at" aria-describedby="couponStartsAtHelp">
                            <div id="couponStartsAtHelp" class="form-text">{{__("app.coupon-starts-at-help")}}</div>
                        </div>
                        <div class="col mt-4">
                            <label for="couponEndsAt" class="d-block p-2 text-center form-label">{{__("app.ends_at")}}</label>
                            <input type="date" id="couponEndsAt" @if($coupon->ends_at) value="<?php echo date("Y-m-d" , strtotime($coupon->ends_at)); ?>" @endif class="form-control" name="coupon_ends_at" aria-describedby="couponEndsAtHelp">
                            <div id="couponEndsAtHelp" class="form-text">{{__("app.coupon-ends-at-help")}}</div>
                        </div>
                    </div>
                    <div class="mt-5 pt-3">
                        <button class="btn btn-primary">
                            {{__("app.save")}}
                        </button>
                        <button type="button" class="float-start btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal{{$coupon->id}}">
                            {{__("app.delete")}}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection