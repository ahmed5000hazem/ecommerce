<!-- ##### Header Area Start ##### -->
<header class="header_area w-100"> 
    <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
        <!-- Classy Menu -->
        <nav class="classy-navbar" id="essenceNav" style="height: 50px">
            <!-- Logo -->
            <a class="nav-brand" style="width: 110px" href="/"><img src="/images/products/admin/general/lotus-b.png" class="img-fluid" alt=""></a>
            <!-- Navbar Toggler -->
            <div class="classy-navbar-toggler ms-4">
                <span class="navbarToggler"><span></span><span></span><span></span></span>
            </div>
            <!-- Menu -->
            <div class="classy-menu">
                <!-- close btn -->
                <div class="classycloseIcon">
                    <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                </div>
                <!-- Nav Start -->
                <div class="classynav">
                    <ul>
                        <li class="menu-navigator"><a class="shop-link fw-bold" href="#">{{__("app.shop")}}</a>
                            <div class="megamenu">
                                @foreach($categories[1] as $mainCategory)
                                <ul class="single-mega mb-4 mt-3 cn-co l-3 col-lg-3  float-start">
                                    <li class="title fs-6 text-dark fw-bold">{{$mainCategory->name}}</li>
                                    @foreach ($categories[0] as $category)
                                        @if ($category->parent_id === $mainCategory->id)
                                            <li><a class="nav-link" href="/category/{{$category->id}}">{{$category->name}}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                                @endforeach
                            </div>
                        </li>
                        {{-- <li class="ms-3"><a href="/leatest">{{__("app.new")}}</a></li> --}}
                    </ul>
                </div>
                <!-- Nav End -->
            </div>
        </nav>

        <!-- Header Meta Data -->
        <div class="header-meta d-flex clearfix justify-content-end">
            <!-- Search Area -->
            <div class="search-area">
                <form action="/search" method="get">
                    <input type="search" name="s" id="headerSearch" placeholder="{{__("app.search")}}">
                    <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
            </div>
            <!-- User Login Info -->
            <div class="user-login-info">
                {{-- <a href="#"><img src="/img/core-img/user.svg" alt=""></a> --}}
                <div class="dropdown text-muted">
                    <button class="btn dropdown-toggle border-end border-start-0" style="height: 100%;width: 100%" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" style="margin-top: -5px;margin-left: -13px;" width="25" height="25"  fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                        </svg>
                    </button>
                    <ul class="dropdown-menu fw-bold text-muted overflow-auto" aria-labelledby="dropdownMenuButton1">
                        @if (!(auth()->check()))
                            <li><a class="dropdown-item fw-bold text-muted" href="/auth/login">{{__("app.login")}}</a></li>
                            <li><a class="dropdown-item fw-bold text-muted" href="/auth/register">{{__("app.reg")}}</a></li>
                        @endif
                        @if ((auth()->check()))
                            <li><a class="dropdown-item fw-bold text-muted" href="/account">{{__("app.account")}}</a></li>
                            <li><a class="dropdown-item fw-bold text-muted" href="/orders">{{__("app.your-orders")}}</a></li>
                        @endif
                        @if (auth()->check())
                            <li><a class="border-0 dropdown-item fw-bold text-muted" href="/auth/logout">{{__("app.logout")}}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <!-- Cart Area -->
            <div class="cart-area">
                <a href="/cart" id="essenceCartBtn"><img src="/img/core-img/bag.svg" alt="">
                    <span>
                        @if (session("cart") && is_array(session("cart")))
                            {{ count(session("cart")) }}
                        @else
                            0
                        @endif
                    </span>
                </a>
            </div>
        </div>

    </div>
</header>
<!-- ##### Header Area End ##### -->