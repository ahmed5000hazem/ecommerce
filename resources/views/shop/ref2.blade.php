@extends("layouts.app")
@section("content")
    @include("includes.shop.header")

    <!-- ##### Shop Grid Area Start ##### -->
    <section class="shop_grid_area section-padding-80">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3 border-0 border-end">
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

                        <form action="/category/{{$category->id}}" class="w-75">
                            <!-- ##### Single Widget ##### -->
                            <div class="widget price mb-20">
                                <!-- Widget Title -->
                                <h6 class="widget-title fw-bold mb-30">{{__("app.filter-by")}}</h6>
                                <!-- Widget Title 2 -->
                                <p class="widget-title2" style="font-size: 15px">{{__("app.prod-price")}} :</p>

                                <div class="widget-desc">
                                    <div class="form-control border-0">
                                        <label for="minPriceRange" id="minPriceLable" class="form-label" style="font-size: 14px"> {{__("app.min-price")}} <small class="ms-1 min-price-lable"> {{$products->min("price")}} </small> </label>
                                        <input type="range" name="min_price" step="5" class="form-range" min="0" value="{{$products->min("price")}}" max="1000" id="minPriceRange">
                                    </div>
                                    <div class="form-control border-0">
                                        <label for="maxPriceRange" id="maxPriceLable" class="form-label" style="font-size: 14px"> {{__("app.max-price")}} <small class="ms-1 min-price-lable"> {{$products->max("price")}} </small> </label>
                                        <input type="range" name="max_price" min="0" step="5" value="{{$products->max("price")}}" max="1000" class="form-range" id="maxPriceRange">
                                    </div>
                                </div>
                            </div>
                            <!-- ##### Single Widget ##### -->
                            <div class="widget price mb-30">
                                <!-- Widget Title 2 -->
                                <p class="widget-title2 mb-3" style="font-size: 15px">{{__("app.size")}} :</p>

                                <div class="widget-desc">
                                    <select class="d-block border-0 border-bottom form-select select-size-filter" name="size">
                                        <option selected>{{__("app.size")}}</option>
                                        @foreach ($sizes as $size)
                                            <option value="{{$size->id}}">{{$size->size}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- ##### Single Widget ##### -->
                            <div class="widget price mb-20">
                                <div class="widget-desc">
                                    <select class="d-block border-0 border-bottom form-select select-size-filter" name="sort_by">
                                        <option selected>{{__("app.sort-by")}}</option>
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
                                            @if ($products->total() > 2)
                                                <span>
                                                    {{$products->total()}}
                                                </span>
                                                {{__("app.totalProducts")}}
                                            @elseif($products->total() === 2)
                                                {{__("app.tow-products")}}
                                            @else
                                                <span>
                                                    {{$products->total()}}
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
                                    <div class="single-product-wrapper">
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
                                        <div class="product-description">
                                            <a href="/product/{{$product->id}}/show">
                                                <h6>{{$product->name}}</h6>
                                            </a>
                                            <p class="product-price">{{$product->price}} {{__("app.EGP")}}</p>

                                            <!-- Hover Content -->
                                            <div class="hover-content">
                                                <!-- Add to Cart -->
                                                <div class="add-to-cart-btn">
                                                    <a href="#" class="btn essence-btn">{{__('app.add-to-cart')}}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Pagination -->
                    <nav aria-label="navigation">
                        {{ $products->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Shop Grid Area End ##### -->
    @include("includes.shop.footer")
@endsection