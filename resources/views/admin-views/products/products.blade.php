@extends('layouts.admin')
@section('content')
@include("includes.admin.navbar")
<div class="container-fluid">
    <div class="row mt-5 justify-content-between">
        <div class="col-12 col-md-3 mb-3 mb-md-0">
            <h2>
                @if (request()->query("product_type"))
                    {{request()->query("product_type")}} Products
                @else
                    All Products 
                    @if (request()->query("search"))
                    {{count($products)}}
                    @else
                    {{$products->total()}}
                    @endif
                @endif
            </h2>
        </div>
        <div class="col-8 col-md-6">
            <form method="get">
                <div class="d-flex">
                    <div class="mb-3">
                        <input type="text" name="search" class="form-control rounded-0" id="exampleFormControlInput1" placeholder="Search Users">
                    </div>
                    <div class="mb-3">
                        <button class="btn rounded-0 btn-primary">search</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-3">
            <a href="/admin/product/create" class="btn btn-secondary float-end">Create</a>
        </div>
    </div>
    <form>
        <div class="row mt-3 justify-content-between">
            <div class="col-6 col-md-3 d-flex">
                <select class="form-select form-select-lg py-0" name="product_type" aria-label="Default select example">
                    <option selected value="0">Product Type</option>
                    <option value="avilable">Avillable</option>
                    <option value="not_avilable">Not Avillable</option>
                    <option value="featured">featured</option>
                    <option value="not_featured">Not Featured</option>
                    <option value="active">active</option>
                    <option value="not_active">Not Active</option>
                </select>
            </div>
            <div class="col-6 col-md-3 d-flex">
                <select class="form-select form-select-lg py-0" name="category_id" aria-label="Default select example">
                    <option selected value="0">Category</option>
                    @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-2 mt-3 mt-md-0 d-grid">
                <button class="btn btn-primary py-1" type="submit">Filter</button>
            </div>
        </div>
    </form>
    <div class="row mt-4">
        <div class="table-resposive overflow-auto">
            <table class="table table-hover product-show">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th class="col-2" scope="col">Name</th>
                        <th scope="col">Seller</th>
                        <th scope="col">Is Active</th>
                        <th scope="col">Is Avilable</th>
                        <th scope="col">Category</th>
                        <th scope="col">Price</th>
                        <th scope="col">Created At</th>
                        <th class="col-2" scope="col">Controls</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <th scope="row"><a href="/admin/product/{{$product->id}}/show">{{$product->id}}</a></th>
                        <td>
                            @if ($product->items_items_dicount + $product->item_value_discount + $product->items_value_discount)
                            <span class="text-warning">
                                sale
                            </span>
                            @endif
                            {{$product->name}}
                        </td>
                        <td>
                            <a href="/admin/user/{{$product->user_id}}/show">
                                {{$product->fname}}
                            </a>
                        </td>
                        @if ($product->active)
                            <td class="text-success">
                                Active
                            </td>
                        @else
                            <td class="text-danger fw-bold">
                                Not Active
                            </td>
                        @endif
                        @if ($product->is_avilable)
                            <td class="text-success">
                                Avilable
                            </td>
                        @else
                            <td class="text-warning">
                                Not Avilable
                            </td>
                        @endif
                        <td>
                            <a class="fw-bold text-decoration-none" href='/admin/category/{{$product->category()->first()->id}}/show'>
                                {{$product->category()->first()->name}}
                            </a>
                        </td>
                        <td>{{$product->price}}</td>
                        <td>{{ date("Y-M-d", strtotime($product->created_at))}}</td>
                        <td>
                            <div class="d-flex justify-content-between">
                                <a href="/admin/product/{{$product->id}}/edit" class="btn btn-info btn-sm ">Edit</a>
                                @if (!$product->active)
                                <form class="" action="/admin/product/{{$product->id}}/activate" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Activate</button>
                                </form>
                                @endif
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#Modal{{$product->id}}">Delete</button>
                            </div>
                            <!-- Button trigger modal -->
    
                            <!-- Modal -->
                            <div class="modal fade" id="Modal{{$product->id}}" tabindex="-1" aria-labelledby="Modal{{$product->id}}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="Modal{{$product->id}}Label">Delete User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="/admin/product/{{$product->id}}/delete" method="POST">
                                                @csrf
                                                <div class="col-md-12 mb-4">
                                                    <label class="fs-6 mb-1" for="admin_password{{$product->id}}">Admin Password<span class="text-danger ms-1">*</span></label>
                                                    <input type="password" autocomplete="off" class="form-control" name="admin_password" id="admin_password{{$product->id}}">
                                                </div>
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row justify-content-center">
        @if (!request()->query("search"))
        {{$products->links()}}
        @endif
    </div>
</div>
@endsection