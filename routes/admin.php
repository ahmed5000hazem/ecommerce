<?php

use Illuminate\Support\Facades\Route;

Route::get("/", "AdminController@index");
// Route::get("/products/datatable", "AdminController@productDatatable");

Route::get('/users/{role?}', "UserController@getUsers");
Route::get('/user/{id}/show', "UserController@userDetails");
Route::get('/user/create', "UserController@createUser");
Route::get('/user/{id}/edit-password', "UserController@editPassword");
Route::post('/user/{id}/update-password', "UserController@updatePassword");
Route::post('/user/{id}/update', "UserController@updateUser");
Route::post('/user/{id}/delete', "UserController@deleteUser");
Route::post('/users/store', "UserController@storeUser");

Route::get('/categories/{type?}', "CategoriesController@getCategories");
Route::get('/category/{id}/show', "CategoriesController@categoryDetails");
Route::get('/category/create', "CategoriesController@create");
Route::get('/category/{id}/edit-password', "CategoriesController@editPassword");
Route::post('/category/{id}/update-password', "CategoriesController@updatePassword");
Route::post('/category/{id}/update', "CategoriesController@update");
Route::post('/category/{id}/delete', "CategoriesController@destroy");
Route::post('/category/store', "CategoriesController@store");

Route::get('/products', "ProductController@index");
Route::get('/products/getImages', "ProductController@getImages");
Route::get('/product/create', "ProductController@create");
Route::get('/product/{id}/show', "ProductController@show");
Route::get('/product/{id}/edit', "ProductController@edit");
Route::post('product/store', "ProductController@store");
Route::post('product/{id}/update', "ProductController@update");
Route::post('product/{id}/activate', "ProductController@activate");
Route::post('product/{id}/delete', "ProductController@destroy");

Route::get('/discount/{id}/create', "DiscountController@create");
Route::post('/discount/{id}/store', "DiscountController@store");

Route::get('/discount/{discount_type}/{discount_id}/edit', "DiscountController@edit");
Route::post('/discount/{discount_type}/{discount_id}/update', "DiscountController@update");
Route::post('/discounts/{discount_type}/{discount_id}/delete', "DiscountController@delete");    
Route::get('/discounts/{discount_type}/show', "DiscountController@show");

Route::get("/coupons","CouponController@index");
Route::get("/coupon/{coupon_id}/show","CouponController@show");
Route::get("/coupons/create","CouponController@create");
Route::post("/coupons/store","CouponController@store");
Route::get("/coupons/edit/{coupon_id}","CouponController@edit");
Route::post("/coupons/update/{coupon_id}","CouponController@update");
Route::post("/coupons/{coupon_id}/delete","CouponController@destroy");

Route::get("/orders/all/show", "OrderController@index");
Route::get("/orders/cancel-requests", "OrderController@cancelRequsets");
Route::get("/orders/reject-requests", "OrderController@rejectRequsets");
Route::get('/order/{order_id}/show', "OrderController@getOrderDetails");
Route::post('order/{id}/change-order-status', "OrderController@changeOrderStatus");

Route::get('/sales/total', "SalesController@index");

Route::get('/colors', "GeneralController@getColors");
Route::post('/color/store', "GeneralController@storeColor");
Route::post('/color/{id}/delete', "GeneralController@deleteColor");

Route::get('/reasons', "GeneralController@getReasons");
Route::post('/reason/store', "GeneralController@storeReason");
Route::post('/reason/{id}/delete', "GeneralController@deleteReason");

Route::get('/sizes', "GeneralController@getSizes");
Route::post('/size/store', "GeneralController@storeSize");
Route::post('/size/{id}/delete', "GeneralController@deleteSize");