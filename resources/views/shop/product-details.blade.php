@extends("layouts.app")
@section("content")
    @include("includes.shop.header")
    
<div class="container-fluid pb-5">
    <div class="toast-container position-absolute mt-4" style="z-index: 800" dir="ltr">
        <div class="toast top-50 end-0 hide" style="margin-top: 50%;" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-danger">
                <strong class="me-auto text-light fs-6">Error</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body"></div>
        </div>
    </div>
    <!-- ##### Single Product Details Area Start ##### -->
    <section class="single_product_details_area row justify-content-center">
        
        <div class="row justify-content-center py-4">
            <div class="col-10">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb align-items-center text-danger">
                        <li class="breadcrumb-item"><a href="#" class="fs-5">{{ $category->parent()->first()->name }}</a></li>
                        <li class="breadcrumb-item"><a href="/category/{{ $category->id }}" class="fs-6">{{ $category->name }}</a></li>
                        <li class="breadcrumb-item" aria-current="page">{{ $product->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        
        <div class="col-lg-4 col-sm-8 col-md-8">
            <div id="productDetailsShow" class="carousel position-relative carousel-dark slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($product->images()->get() as $image)
                        <div style="margin-right: 0;" class="carousel-item @if($loop->first) active @endif" data-bs-interval="2000000">
                            <img class="img-fluid d-block w-100" src="/images/products/sellers/{{$image->path}}" alt="">
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#productDetailsShow" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next position-absolute top-50 end-0 translate-middle-y" type="button" data-bs-target="#productDetailsShow" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <div class="discounts-info mt-4 mb-4">
                @if ($product->item_value_discount + $product->items_items_discount + $product->items_value_discount || $product->coupons()->first())
                <h4 class="text-center"> {{__("app.offers")}} </h4>
                @endif
                <ul class="list-group list-group-flush">
                    @if ($product->items_value_discount)
                        @foreach ($product->getActiveItemsValueDiscount() as $items_value_discount)
                            <li class="list-group-item"> 
                                {{__("app.buy")}} 
                                @if ($items_value_discount->items_count === 1)
                                {{__("app.peice")}}
                                @elseif($items_value_discount->items_count === 2)
                                {{__("app.two-peices")}}
                                @else
                                {{$items_value_discount->items_count}}
                                {{__("app.peices")}}
                                @endif
                                <strong class="text-danger">
                                    {{__("app.at-price")}} {{$items_value_discount->items_value}}
                                    {{__("app.EGP")}}
                                </strong>
                                {{__("app.instead-of")}}
                                <span class="text-decoration-line-through">
                                    {{ $items_value_discount->items_count * $product->price }} {{__("app.EGP")}}
                                </span>
                            </li>    
                        @endforeach
                    @endif
                    @if ($product->items_items_discount)
                        @foreach ($product->getActiveItemsItemsDiscount() as $items_items_discount)
                            <li class="list-group-item">
                                {{__("app.buy")}}
                                @if ($items_items_discount->buy_items_count === 1)
                                    {{__("app.peice")}}
                                @elseif($items_items_discount->buy_items_count === 2)
                                    {{__("app.two-peices")}}
                                @else
                                    {{$items_items_discount->buy_items_count}}
                                    {{__("app.peices")}}
                                @endif
                                <strong class="text-danger">
                                    {{__("app.get")}}
                                    <a  class="text-danger fs-6 ps-1" href="/product/{{$items_items_discount->present()->first()->id}}/show">
                                        {{$items_items_discount->get_items_count}} {{$items_items_discount->present()->first()->name}}
                                    </a>
                                </strong>
                                {{__("app.present")}}
                            </li>
                        @endforeach
                    @endif
                    @if (!$product->coupons()->get()->isEmpty())
                        @foreach ($product->coupons()->get() as $coupon)
                            @if ($coupon->user_id === auth()->user()->id || $coupon->user_id === null)
                            <li class="list-group-item">
                                {{__("app.dont-forget-to")}} {{__("app.use")}} {{__("app.coupon")}}
                                <input type="text" class="form-control my-3" readonly value="{{$coupon->coupon}}">
                                {{__("app.and")}} {{__("app.get")}} 
                                <strong class="text-danger">
                                    {{$coupon->value}} {{__("app.EGP")}}
                                    {{__("app.discount")}}
                                </strong>
                                @if ($coupon->min_order_price)
                                    <strong>
                                        {{__("app.when-buy")}}
                                        {{$coupon->min_order_price}} {{__("app.EGP")}}
                                    </strong>
                                @endif
                            </li>
                            @endif
                        @endforeach
                    @endif
                </ul>
            </div>

        </div>

        <!-- Single Product Description -->
        <div class="single_product_desc pt-1 col-lg-6 clearfix">
            
            
            <h4 class="mb-4">{{$product->name}}</h4>

            @if ($product->item_value_discount)
                <p class="product-price fs-5 ps-3">
                    {{__("app.prod-price")}} 
                    {{$product->afterDiscountPrice()}} {{__("app.EGP")}}
                    <span class="old-price fs-6">{{$product->price}} {{__("app.EGP")}}</span>
                </p>
            @else
                <p class="product-price fs-6 my-3 ps-3">{{__("app.prod-price")}}  {{$product->price}} {{__("app.EGP")}} </p>
            @endif

            
            <div class="list-group pt-3 list-group-flush">
                <a href="#" class="list-group-item list-group-item-action" aria-current="true">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">{{__("app.prod-disc")}}</h6>
                    </div>
                    <p class="product-desc fs-6">
                        {{ $product->description }}
                    </p>
                </a>
                @if ($product->material)
                <a href="#" class="list-group-item list-group-item-action" aria-current="true">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">{{__("app.main-material")}}</h6>
                    </div>
                    <p class="my-2 fs-6">{{$product->material}}</p>
                </a>
                @endif
                @if ($product->printing_type)
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">{{__("app.prod-printing_type")}}</h6>
                    </div>
                    <p class="my-2">{{$product->printing_type}}</p>
                </a>
                @endif
            </div>
            
            <!-- Form -->
            <form class="add-to-cart-form clearfix" action="/cart/store" method="post">
                <!-- Select Box -->
                @csrf
                <input type="hidden" name="product_id" value="{{$product->id}}">
                <div class="select-box d-flex mt-50 mb-30">
                    <select name="size" class="col" id="productSize" class="mr-5">
                        <option value="0">{{__("app.size")}}</option>
                        @foreach ($product->sizes()->get() as $size)
                            <option value="{{$size->id}}">{{$size->size}}</option>
                        @endforeach
                    </select>
                    <select name="color" class="col" id="productColor">
                        <option value="0">{{__("app.color")}}</option>
                        @foreach ($product->colors()->get() as $color)
                            <option value="{{$color->id}}">{{$color->color_name}}</option>
                        @endforeach
                    </select>
                    <input type="number" class="form-control col rounded-0 border border-1" name="qty" value="1" min="1" max="12">
                </div>
                <!-- Cart & Favourite Box -->
                <div class="cart-fav-box d-flex align-items-center">
                    <!-- Cart -->
                    <button type="submit" name="addtocart" value="5" class="btn essence-btn">{{__("app.add-to-cart")}}</button>
                </div>
            </form>
        </div>
    </section>
    <!-- ##### Single Product Details Area End ##### -->

    <!-- ##### New Arrivals Area Start ##### -->
    <section class="new_arrivals_area section-padding-80 clearfix">
        @if (!$featuredProducts->isEmpty())
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading text-center">
                        <h2>{{__("app.popular-products")}}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div dir="ltr" class="popular-products-slides owl-carousel">

                        @foreach ($featuredProducts as $featured)
                        <div class="single-product-wrapper" dir="rtl">
                            <!-- Product Image -->
                            <div class="product-img">
                                @foreach ($featured->images()->get() as $image)
                                    @if ($loop->index === 0)
                                        <a href="/product/{{$featured->id}}/show">
                                            <img src="/images/products/sellers/{{$image->path}}" alt="">
                                        </a>
                                        
                                    @elseif($loop->index === 1)
                                        <img class="hover-img" src="/images/products/sellers/{{$image->path}}" alt="">
                                        @break
                                    @endif
                                @endforeach
                                <!-- Hover Thumb -->
                                @if ($featured->item_value_discount + $featured->items_value_discount + $featured->items_items_discount)
                                    <!-- Product Badge -->
                                    <div class="product-badge offer-badge">
                                        <span>{{__("app.discount")}}</span>
                                    </div>
                                @endif
                            </div>
                            <!-- Product Description -->
                            <div class="product-description">
                                <a href="/product/{{$featured->id}}/show">
                                    <h6>{{$featured->name}}</h6>
                                </a>

                                @if ($featured->item_value_discount)
                                    <p class="product-price"><span class="old-price">{{$featured->price}} {{__("app.EGP")}}</span> {{$featured->afterDiscountPrice()}} {{__("app.EGP")}}
                                @else
                                    <p class="product-price">{{$featured->price}} {{__("app.EGP")}}</p> 
                                @endif

                                <!-- Hover Content -->
                                <div class="hover-content">
                                    
                                </div>
                            </div>
                        </div>
                        @endforeach

                        
                    </div>
                </div>
            </div>
        </div>
        @endif
    </section>
</div>
@include('includes.shop.footer')
@endsection
