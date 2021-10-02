@extends('layouts.app')
@section('content')
@include("includes.shop.header")
<!-- ##### Checkout Area Start ##### -->
<div class="checkout_area section-padding-80">
    <div class="container">
        <div class="toast-container mt-5 pt-5 position-absolute top-0 end-0 p-3" style="right: unset!important">
            @if ($errors->any())
                @foreach($errors->all() as $error)
                    <div class="toast d-block" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" dir="ltr">
                        <div class="toast-header bg-danger">
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            {{$error}}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <form action="/orders/place-order" method="post">
            @csrf
            <div class="row justify-content-between">
                <div class="col-12 col-md-6">
                    <div class="checkout_details_area clearfix">

                        <!-- Button trigger modal -->
                        @if ($presents->isNotEmpty())
                        <button type="button" id="presents_modal_btn" data-clicked="false" class="btn essence-btn fs-6 mb-5" data-bs-toggle="modal" data-bs-target="#presents_modal">
                            {{__("app.presentes")}}
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="presents_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-fullscreen">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{__("app.customise-presentes")}}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row pt-4 justify-content-evenly">
                                            <div class="card mb-4 col-6 col-lg-3 d-none" style="width: 18rem;">
                                                <img src="" class="card-img-top" alt="">
                                                <div class="card-body">
                                                    <h5 class="card-title"> <a href="" class="fs-5"> </a> </h5>
                                                    <div class="row justify-content-between row-cols-2">
                                                        <div class="col">
                                                            <select class="form-select select-size" name="presents_sizes" aria-label="Default select example">
                                                                <option value="0">{{__("app.size")}}</option>
                                                            </select>
                                                        </div>
                                                        <div class="col">
                                                            <select class="form-select select-color" name="presents_colors" aria-label="Default select example">
                                                                <option value="0">{{__("app.color")}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif


                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="fs-6 mb-1" for="first_name">{{__("app.fname")}}<span class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control" name="fname" id="first_name" value="{{auth()->user()->fname}}" >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fs-6 mb-1" for="last_name">{{__("app.lname")}}<span class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control" name="lname" id="last_name" value="{{auth()->user()->lname}}" >
                            </div>
                            <div class="col-12 mb-3">
                                <label class="fs-6 mb-1" for="country">{{__("app.governorate")}}<span class="text-danger ms-1">*</span></label>
                                <select class="w-100" id="country" name="governorate">
                                    <option value="">{{__("app.governorate")}}</option>
                                    <option value="cairo" @if(auth()->user()->city === "cairo") selected @endif >Cairo</option>
                                    <option value="giza" @if(auth()->user()->city === "giza") selected @endif >Giza</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="fs-6 mb-1" for="street_address">{{__("app.address")}} <span class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control mb-3" name="address_one" id="street_address" value="{{auth()->user()->address_one}}">
                                <input type="text" class="form-control" name="address_two" id="street_address2" value="{{auth()->user()->address_two}}">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="fs-6 mb-1" for="phone_number">{{__("app.phone")}}<span class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control" name="phone" id="phone_number" min="0" value="{{auth()->user()->phone}}">
                            </div>
                            <div class="col-12 mb-4">
                                <label class="fs-6 mb-1" for="email_address">{{__("app.email")}}</label>
                                <input type="email" class="form-control" name="email" id="email_address" value="{{auth()->user()->email}}">
                            </div>
                            <div class="col-5 mb-4">
                                <label class="fs-6 text-danger mb-1" for="coupon">{{__("app.coupon")}}</label>
                                <input type="text" class="form-control" name="coupon" id="coupon" value="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-5 ml-lg-auto">
                    <div class="order-details-confirmation">
                        <div class="cart-page-heading">
                            <h5>{{__("app.your-order")}}</h5>
                            <p>{{__("app.order-details")}}</p>
                        </div>
                        <ul class="order-details-form mb-4">
                            <li class="fs-5"><span>{{__("app.product")}}</span> <span>{{__("app.total")}}</span></li>
                            @foreach ($totals as $total)
                            <li>
                                <span>
                                    <a href="/product/{{ $total["product_id"] }}/show" class="text-primary fw-bold">
                                        {{ $total["product_name"] }}
                                    </a> 
                                    <span class="ms-2" dir="ltr">{{ $total["qty"] }} X </span> 
                                </span> 
                                <span>{{ $total["price"] }} {{__("app.EGP")}} </span>
                            </li>
                            @endforeach
                            <li><span>{{__("app.sub-total")}}</span> <span> {{$totals->sum("price")}} {{__("app.EGP")}}</span></li>
                            <li><span>{{__("app.shipping")}}</span> <span> @if($totals->sum("price")) 45 @else 0 @endif {{__("app.EGP")}}</span></li>
                            <li><span>{{__("app.total")}}</span> <span> @if($totals->sum("price")) {{ $totals->sum("price")+45 }} @else 0 @endif {{__("app.EGP")}} </span></li>
                        </ul>
                        @if ($totals->sum("price"))
                        <button type="submit" class="btn mt-3 essence-btn">{{__("app.place-order")}}</button>
                        @endif
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
<!-- ##### Checkout Area End ##### -->
@endsection