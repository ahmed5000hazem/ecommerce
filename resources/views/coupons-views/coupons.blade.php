@extends('layouts.seller')
@section('content')
    @include('includes.seller.navbar')
    <div class="container py-5 mt-4">
        @if (!$coupons->isEmpty())
        <div class="list-group">
            @foreach ($coupons as $coupon)
            <a href="/seller/coupons/edit/{{$coupon->id}}/" class="py-3 list-group-item list-group-item-action" aria-current="true">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{__("app.coupon")}} : {{$coupon->coupon}} - {{__("app.value")}} : {{$coupon->value}} </h5>
                    <small><?php echo date("Y-M-d" , strtotime($coupon->starts_at)); ?></small>
                </div>
                <p class="mt-3">
                    @if ($coupon->howmany_uses) 
                    {{__("app.coupon-usable")}} 
                        @if ($coupon->howmany_uses === 1)
                            <strong> {{__("app.time")}} </strong>                            
                        @elseif($coupon->howmany_uses === 2)
                            <strong> {{__("app.two-times")}} </strong>
                        @else
                            {{$coupon->howmany_uses}} <strong> {{__("app.of-times")}} </strong>
                        @endif
                    @endif
                    @if ($coupon->min_order_price) 
                    {{__("app.coupon-min-order-price")}} <strong> {{$coupon->min_order_price}} {{__("app.EGP")}} </strong>
                    @endif
                    @if ($coupon->ends_at) 
                        {{__("app.coupon-ends-at-help")}} <strong> <?php echo date("Y-M-d" , strtotime($coupon->ends_at)); ?> </strong>
                    @endif
                </p>
                <small>
                </small>
            </a>
            @endforeach
        </div>
        @else
            <div class="alert alert-warning text-center">
                <strong>
                    {{__("app.no-coupons")}}
                </strong>
            </div>
        @endif
    </div>
@endsection