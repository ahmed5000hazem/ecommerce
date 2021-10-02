@extends('layouts.app')
@section('content')
    
    @include('includes.shop.header')
    

    <!-- ##### Welcome Area Start ##### -->
    <section class="welcome_area bg-img background-overlay" style="background-image: url(images/products/admin/bg-img/bg-1.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-end">
                <div class="col-4">
                    <div class="hero-content">
                        <h2 dir="ltr">Welcome To Lotus</h2>
                        {{-- <a href="#" class="btn essence-btn">view collection</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Welcome Area End ##### -->

    <!-- ##### Top Catagory Area Start ##### -->
    <div class="top_catagory_area section-padding-80 clearfix">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Single Catagory -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img" style="background-image: url(images/products/admin/bg-img/bg-2.jpg);background-size: cover">
                        <div class="catagory-content">
                            <a href="#">تيشيرت</a>
                        </div>
                    </div>
                </div>
                <!-- Single Catagory -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img" style="background-image: url(images/products/admin/bg-img/bg-3.jpg);">
                        <div class="catagory-content">
                            <a href="#">قميص</a>
                        </div>
                    </div>
                </div>
                <!-- Single Catagory -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img" style="background-image: url(images/products/admin/bg-img/bg-4.jpg);">
                        <div class="catagory-content">
                            <a href="#">بنطالون</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Top Catagory Area End ##### -->

    <!-- ##### CTA Area Start ##### -->
    <div class="cta-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="cta-content bg-img background-overlay" style="background-image: url(images/products/admin/bg-img/bg-5.jpg);">
                        <div class="h-100 d-flex align-items-center justify-content-start">
                            <div class="cta--text">
                                <h6>جودة عالية</h6>
                                <h3 class="fs-1">خدمة مابعد البيع</h3>
                                <h3 class="fs-3 mt-3 text-primary">اسعار مميزة</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### CTA Area End ##### -->
    @if ($featuredProducts->isNotEmpty())
    <!-- ##### New Arrivals Area Start ##### -->
    <section class="new_arrivals_area section-padding-80 clearfix">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading text-center">
                        <h2>منتجات مميزة</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="popular-products-slides owl-carousel" dir="ltr">
                        @foreach ($featuredProducts as $featured)
                        <div class="single-product-wrapper" dir="rtl">
                            <!-- Product Image -->
                                <a href="/product/{{$featured->id}}/show">
                                    <div class="product-img">
                                        @foreach ($featured->images()->get() as $image)
                                            @if ($loop->index === 0)
                                                <img src="/images/products/sellers/{{$image->path}}" alt="">
                                                
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
                                </a>
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
    </section>
    <!-- ##### New Arrivals Area End ##### -->
    @endif
    @include('includes.shop.footer')
@endsection