<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('change-lang/{lang}', ["as" => "frontend_change_locale" , "uses" => "GeneralController@changeLang"]);

Route::get('filemanager', function () {
    return view("layouts.filemanager");
})->name("filemanager");

Route::prefix('auth')->namespace("Auth")->group(function () {
    Route::get('login', "LoginController@login")->middleware("guest")->name("login");
    Route::post('login', "LoginController@authenticate")->middleware("guest");
    Route::get('register', "RegisterController@register")->middleware("guest");
    Route::post('register', "RegisterController@signup")->middleware("guest");
    Route::get('logout', "LogoutController@logout");
    // Route::get('login/facebook', 'LoginController@redirectToFacebook');
    // Route::get('login/facebook/callback', 'LoginController@handlefacebookCallback');
});

Route::prefix('seller')
->middleware(["auth", "role:seller", "checkAuthority"])
->group(function () {
    Route::get('/', "SellerController@index");
    Route::get('/products', "ProductController@getSellerProducts")->name("sellerProdcut");
    Route::get('/products/create', "ProductController@create")->name("seller_add_prod");
    Route::post('/products/store', "ProductController@store")->name("seller_store_prod");
    Route::post('/product/delete', "ProductController@destroy");
    Route::get('/product/{id}', "ProductController@show")->name("seller_show_prod");
    Route::get('/product/edit/{id}', "ProductController@edit")->name("seller_edit_prod");
    Route::post('/product/update/', "ProductController@update")->name("seller_update_prod");
    Route::get('/products/getImages', "ProductController@getSellerImages")->name("sellerImages");

    Route::get('/category/{category_id}', "CategoryController@getSellerProduct");
    
    Route::get('/discount/{product_id}/create', "DiscountController@create");
    Route::get('/discount/{discount_type}/{discount_id}/edit', "DiscountController@edit");
    Route::post('/discount/{discount_type}/{discount_id}/update', "DiscountController@update");
    Route::post('/discounts/{discount_type}/{discount_id}/delete', "DiscountController@delete");    
    Route::get('/discounts/{discount_type}/show', "DiscountController@show");
    Route::post('/discount/{product_id}/store', "DiscountController@store");
    
    Route::get("/orders/all/show", "OrderController@getSellerOrders");
    Route::get("/orders/canceled/show", "OrderController@getSellerCanceledOrders");
    Route::get("/orders/rejected/show", "OrderController@getSellerRejectedOrders");
    Route::get('/order/{order_id}', "OrderController@getSellerOrderDetails");

    Route::get("/coupons","CouponController@index");
    Route::get("/coupon/{coupon_id}/show","CouponController@show");
    Route::get("/coupons/create","CouponController@create");
    Route::post("/coupons/store","CouponController@store");
    Route::get("/coupons/edit/{coupon_id}","CouponController@edit");
    Route::post("/coupons/update/{coupon_id}","CouponController@update");
    Route::post("/coupons/{coupon_id}/delete","CouponController@destroy");

    Route::get('sales', "ProductController@sales");

});
Route::middleware(["initializeCart"])->group(function () {
    Route::post('/cart/store', "CartController@store");
    Route::middleware(['role:normal_user', "auth"])->group(function () {
        Route::post('/cart/{cart_id}/destroy', "CartController@destroy");
        Route::get('/cart/', "CartController@show");
        Route::get('/checkout/', "ShopController@checkout")->middleware("auth");
        Route::get('/checkout/getPresents', "ShopController@getPresents")->middleware("auth");
        Route::post('/cart/{cartRowId}/decrease', "CartController@decreaseCartItem");
        Route::post('/cart/{cartRowId}/increase', "CartController@increaseCartItem");
        Route::get('/account', "UserController@index");
        Route::get('/account/edit-password', "UserController@editPassword");
        Route::post('/account/update-password', "UserController@updatePassword");
        Route::post('/account/update', "UserController@update");
        Route::get("/orders", "OrderController@getUserOrders");
        Route::get("/order/{id}/details", "OrderController@getUserOrderDetails");
        Route::post("/order/{id}/cancel", "OrderController@cancelOrderRequest");
        Route::post("/order/{id}/reject", "OrderController@rejectOrderRequest");
    });
    Route::get("/", "ShopController@index");
    Route::get("/categories/{id}", "ShopController@categories");
    Route::get("/category/{id}", "ShopController@category");
    Route::get("/product/{id}/show", "ShopController@getProduct");
    Route::get("/product/{id}/add-to-cart", "ShopController@index");
    Route::get("/search", "ShopController@search");
    Route::post('orders/place-order', "OrderController@placeOrder");
});

Route::prefix('supervisor')->middleware(["role:supervisor", "auth"])->group(function () {
    Route::get('/', "SupervisorController@home");
    Route::get("/order/{id}/details", "OrderController@getSupervisorOrderDetails");
    Route::post('/{id}/change-order-status', "OrderController@changeOrderStatus");
    Route::post('/{id}/reject-order', "OrderController@rejectOrder");
    Route::post('/{id}/cancel-order', "OrderController@cancelOrder");
});