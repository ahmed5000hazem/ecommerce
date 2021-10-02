<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid  ">
        <a class="navbar-brand mb-0 h1" href="/seller">{{__("app.seller")}}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-2">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="productsNavigation" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{__("app.products")}}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="productsNavigation">
                        <li><a class="dropdown-item" href="/seller/products">{{__("app.show-products")}}</a></li>
                        <li><a class="dropdown-item" href="/seller/products/create">{{__("app.add-product")}}</a></li>
                    </ul>
                </li>

                <x-categories-navbar/>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="productsNavigation" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{__("app.orders")}}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="productsNavigation" style="width: fit-content;">
                        <li><a class="dropdown-item" href="/seller/orders/all/show">{{__("app.all")}}</a></li>
                        <li><a class="dropdown-item" href="/seller/orders/canceled/show">{{__("app.canceled-orders")}}</a></li>
                        <li><a class="dropdown-item" href="/seller/orders/rejected/show">{{__("app.rejected-orders")}}</a></li>
                    </ul>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="productsNavigation" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{__("app.discounts")}}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="productsNavigation" style="width: fit-content;">
                        <li><a class="dropdown-item" href="/seller/discounts/all/show">{{__("app.all")}}</a></li>
                        <li><a class="dropdown-item" href="/seller/discounts/item-value/show">{{__("app.item-value")}}</a></li>
                        <li><a class="dropdown-item" href="/seller/discounts/items-value/show">{{__("app.items-value")}}</a></li>
                        <li><a class="dropdown-item" href="/seller/discounts/items-items/show">{{__("app.items-items")}}</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="productsNavigation" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{__("app.coupons")}}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="productsNavigation" style="width: fit-content;">
                        <li><a class="dropdown-item" href="/seller/coupons">{{__("app.all")}}</a></li>
                        <li><a class="dropdown-item" href="/seller/coupons/create">{{__("app.coupons-create")}}</a></li>
                    </ul>
                </li>
                
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="productsNavigation" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{__("app.sales")}}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="productsNavigation" style="width: fit-content;">
                        <li><a class="dropdown-item" href="/seller/coupons">{{__("app.all")}}</a></li>
                        <li><a class="dropdown-item" href="/seller/coupons/create">{{__("app.coupons-create")}}</a></li>
                    </ul>
                </li> --}}
                <a class="nav-link ms-2 active" href="/seller/sales">{{__("app.sales")}}</a>
                
                <a class="nav-link ms-2 active" href="{{route("filemanager")}}">{{__("app.filemanager")}}</a>
            </div>
        </div>
    </div>
</nav>