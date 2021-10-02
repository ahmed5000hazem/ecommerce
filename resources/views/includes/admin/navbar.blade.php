<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/admin">Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Users
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="/admin/users/seller">sellers</a></li>
                        <li><a class="dropdown-item" href="/admin/users/supervisor">supervisor</a></li>
                        <li><a class="dropdown-item" href="/admin/users/">users</a></li>
                        <li><a class="dropdown-item" href="/admin/user/create">create user</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="/admin/categories/">All</a></li>
                        <li><a class="dropdown-item" href="/admin/categories/main">Main Categories</a></li>
                        <li><a class="dropdown-item" href="/admin/categories/sub">Sub Categories</a></li>
                        <li><a class="dropdown-item" href="/admin/category/create">Create Category</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Products
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="/admin/products/">All Products</a></li>
                        <li><a class="dropdown-item" href="/admin/category/create">Create Category</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="productsNavigation" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Discounts
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="productsNavigation" style="width: fit-content;">
                        <li><a class="dropdown-item" href="/admin/discounts/all/show">All</a></li>
                        <li><a class="dropdown-item" href="/admin/discounts/item-value/show">Item Value</a></li>
                        <li><a class="dropdown-item" href="/admin/discounts/items-value/show">Items Value</a></li>
                        <li><a class="dropdown-item" href="/admin/discounts/items-items/show">Items Items</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="productsNavigation" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Coupons
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="productsNavigation" style="width: fit-content;">
                        <li><a class="dropdown-item" href="/admin/coupons">All</a></li>
                        <li><a class="dropdown-item" href="/admin/coupons/create">Coupon Create</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="productsNavigation" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Orders
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="productsNavigation" style="width: fit-content;">
                        <li><a class="dropdown-item" href="/admin/orders/all/show">All</a></li>
                        <li><a class="dropdown-item" href="/admin/orders/cancel-requests">Canceling Request</a></li>
                        <li><a class="dropdown-item" href="/admin/orders/reject-requests">rejecting Request</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="productsNavigation" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Sales
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="productsNavigation" style="width: fit-content;">
                        <li><a class="dropdown-item" href="/admin/sales/total">Total</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="productsNavigation" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Other
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="productsNavigation" style="width: fit-content;">
                        <li><a class="dropdown-item" href="/admin/colors">Colors</a></li>
                        <li><a class="dropdown-item" href="/admin/sizes">Sizes</a></li>
                        <li><a class="dropdown-item" href="/admin/reasons">Reasons</a></li>
                        <li><a class="dropdown-item" href="{{route("filemanager")}}">Filemanager</a></li>
                        <hr>
                        <li><a class="dropdown-item" href="/auth/logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>