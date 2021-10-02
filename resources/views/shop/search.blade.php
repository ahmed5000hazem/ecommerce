@extends("layouts.app")
@section("content")
    @include("includes.shop.header")

    <!-- ##### Shop Grid Area Start ##### -->
    <section class="shop_grid_area section-padding-80">
        <div class="container">
            <button class="btn d-block d-md-none " type="button" data-bs-toggle="collapse" data-bs-target="#responsiveProductFilter" aria-expanded="false" aria-controls="responsiveProductFilter">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-filter-right" viewBox="0 0 16 16">
                    <path d="M14 10.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 .5-.5zm0-3a.5.5 0 0 0-.5-.5h-7a.5.5 0 0 0 0 1h7a.5.5 0 0 0 .5-.5zm0-3a.5.5 0 0 0-.5-.5h-11a.5.5 0 0 0 0 1h11a.5.5 0 0 0 .5-.5z"/>
                </svg>
            </button>

            <div class="row justify-content-center">
                <div class="col-10 d-block d-md-none">
                    <div class="collapse mt-3" id="responsiveProductFilter">
                        <div class="card card-body">
                            <form>
                                <div class="row justify-content-center">
                                    <div class="col-10">
                                        <div class="form-control border-0">
                                            <label for="minPriceRange" id="minPriceLable" class="form-label" style="font-size: 14px"> {{__("app.min-price")}} <small class="ms-1 min-price-lable"> @if(request()->query("min_price")){{request()->query("min_price")}}@else{{$min_price}}@endif </small> {{__("app.EGP")}} </label>
                                            <input type="range" name="min_price" step="5" class="form-range" min="{{$min_price}}" value="@if(request()->query("min_price")){{request()->query("min_price")}}@else{{$min_price}}@endif" max="{{$max_price}}" id="minPriceRange">
                                        </div>
                                        <div class="form-control border-0">
                                            <label for="maxPriceRange" id="maxPriceLable" class="form-label" style="font-size: 14px"> {{__("app.max-price")}} <small class="ms-1 min-price-lable"> @if(request()->query("max_price")){{request()->query("max_price")}}@else{{$max_price}}@endif </small> {{__("app.EGP")}} </label>
                                            <input type="range" name="max_price" min="{{$min_price}}" step="5" value="@if(request()->query("max_price")){{request()->query("max_price")}}@else{{$max_price}}@endif" max="{{$max_price}}" class="form-range" id="maxPriceRange">
                                        </div>
                                    </div>
                                    <div class="col-10 mt-4">
                                        <select class="d-block border-0 border-bottom form-select select-size-filter" name="sort_by">
                                            <option selected value="">{{__("app.sort-by")}}</option>
                                            <option value="created_at-DESC">{{__("app.newest")}}</option>
                                            <option value="created_at-ASC">{{__("app.oldest")}}</option>
                                            <option value="price-DESC">{{__("app.higher-price")}}</option>
                                            <option value="price-ASC">{{__("app.lower-price")}}</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mt-3 d-grid">
                                        <button type="submit" class="essence-btn">{{__("app.apply")}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4 col-lg-3 border-0 border-end d-none d-md-block">
                    <div class="shop_sidebar_area">
                        <!-- ##### Single Widget ##### -->
                        <div class="widget catagory mb-50">
                            <!-- Widget Title -->
                            <h6 class="widget-title mb-30">{{__("app.categories")}}</h6>

                            <!--  Catagories  -->
                            <div class="catagories-menu">
                                <ul id="menu-content2" class="menu-content collapse show">
                                    <!-- Single Item -->
                                    @foreach ($categories[1] as $mainCategory)
                                    <li class="sidebar-menu" data-toggle="collapse" data-target="#category{{$mainCategory->id}}">
                                        <a class="fs-6 fw-bold" href="#">{{$mainCategory->name}}</a>
                                        <ul class="sub-menu collapse @if($loop->first)show @endif" id="category{{$mainCategory->id}}">
                                            @foreach ($categories[0] as $category)
                                                @if ($category->parent_id === $mainCategory->id)
                                                    <li><a class="fs-6" href="/category/{{$category->id}}">{{$category->name}}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                    @endforeach
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <form action="" class="w-75">
                            <!-- ##### Single Widget ##### -->
                            <div class="widget price mb-20">
                                <!-- Widget Title -->
                                <h6 class="widget-title fw-bold mb-30">{{__("app.filter-by")}}</h6>
                                <!-- Widget Title 2 -->
                                <p class="widget-title2" style="font-size: 15px">{{__("app.prod-price")}} :</p>
                                <input type="hidden" name="s" value="{{request()->query("s")}}">
                                <div class="widget-desc">
                                    <div class="form-control border-0">
                                        <label for="minPriceRange" id="minPriceLable" class="form-label" style="font-size: 14px"> {{__("app.min-price")}} <small class="ms-1 min-price-lable"> @if(request()->query("min_price")){{request()->query("min_price")}}@else{{$min_price}}@endif </small> {{__("app.EGP")}} </label>
                                        <input type="range" name="min_price" step="5" class="form-range" min="{{$min_price}}" value="@if(request()->query("min_price")){{request()->query("min_price")}}@else{{$min_price}}@endif" max="{{$max_price}}" id="minPriceRange">
                                    </div>
                                    <div class="form-control border-0">
                                        <label for="maxPriceRange" id="maxPriceLable" class="form-label" style="font-size: 14px"> {{__("app.max-price")}} <small class="ms-1 min-price-lable"> @if(request()->query("max_price")){{request()->query("max_price")}}@else{{$max_price}}@endif </small> {{__("app.EGP")}} </label>
                                        <input type="range" name="max_price" min="{{$min_price}}" step="5" value="@if(request()->query("max_price")){{request()->query("max_price")}}@else{{$max_price}}@endif" max="{{$max_price}}" class="form-range" id="maxPriceRange">
                                    </div>
                                </div>
                            </div>
                            <!-- ##### Single Widget ##### -->
                            <div class="widget price mb-20">
                                <div class="widget-desc">
                                    <select class="d-block border-0 border-bottom form-select select-size-filter" name="sort_by">
                                        <option selected value="">{{__("app.sort-by")}}</option>
                                        <option value="created_at-DESC">{{__("app.newest")}}</option>
                                        <option value="created_at-ASC">{{__("app.oldest")}}</option>
                                        <option value="price-DESC">{{__("app.higher-price")}}</option>
                                        <option value="price-ASC">{{__("app.lower-price")}}</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="mt-5 essence-btn">{{__("app.apply")}}</button>
                        </form>
                        
                    </div>
                </div>

                <div class="col-12 col-md-8 col-lg-9">
                    <div class="shop_grid_product_area">
                        <div class="row">
                            <div class="col-12">
                                <div class="product-topbar d-flex align-items-center justify-content-between">
                                    <!-- Total Products -->
                                    <div class="total-products">
                                        <p class="fs-lg-6"> {{__("app.products-found")}}
                                            @if (count($products) > 2)
                                                <span>
                                                    {{count($products)}}
                                                </span>
                                                {{__("app.totalProducts")}}
                                            @elseif(count($products) === 2)
                                                {{__("app.tow-products")}}
                                            @else
                                                <span>
                                                    {{count($products)}}
                                                </span>
                                                {{__("app.totalProducts")}}    
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($products as $product)
                                    <!-- Single Product -->
                                <div class="col-12 col-sm-6 col-lg-4">
                                    <a href="/product/{{$product->id}}/show">
                                        <div class="single-product-wrapper border">
                                            <!-- Product Image -->
                                            <div class="product-img">
                                                @if ($product->item_value_discount || $product->items_value_discount || $product->items_items_discount)
                                                    <div class="product-badge offer-badge">
                                                        <span>
                                                            {{__("app.sale")}}
                                                        </span>
                                                    </div>
                                                @endif

                                                @foreach ($product->images()->get() as $image)
                                                    @if ($loop->index === 0)
                                                        <img src="/images/products/sellers/{{$image->path}}" alt="">
                                                        
                                                    @elseif($loop->index === 1)
                                                        <img class="hover-img" src="/images/products/sellers/{{$image->path}}" alt="">
                                                        @break
                                                    @endif
                                                @endforeach
                                                <!-- Hover Thumb -->

                                            </div>
                                            <!-- Product Description -->
                                            <div class="product-description ps-3 mb-2">
                                                <a href="/product/{{$product->id}}/show">
                                                    <h6>{{$product->name}}</h6>
                                                </a>
                                                <p class="product-price">{{$product->price}} {{__("app.EGP")}}</p>

                                                <!-- Hover Content -->
                                                <div class="hover-content">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                            @if($products->isEmpty())
                                <div class="alert alert-info text-center fw-bold fs-5">{{__("app.no-products-filter-message")}}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Shop Grid Area End ##### -->
    @include("includes.shop.footer")
@endsection