@extends('layouts.admin')
@section('content')
@include("includes.admin.navbar")
<div class="container pt-5">
    <div class="row mb-5 justify-content-center justify-content-md-start">
        <div class="col-8 mt-3 mt-md-0 col-md-3">
            <div class="p-4 rounded-3 text-light" style="background-color: #130f40;">
                <h3 class="fs-1">
                    {{$countUsers}}
                </h3>
                <span class="fs-6">
                    Users
                </span>
            </div>
        </div>
        <div class="col-8 mt-3 mt-md-0 col-md-3">
            <div class="p-4 text-light rounded-3" style="background-color: #22a6b3;">
                <h3 class="fs-1">
                    {{$totalEarnings}}
                </h3>
                <span class="fs-6">
                    Total Earnings
                </span>
            </div>
        </div>
        <div class="col-8 mt-3 mt-md-0 col-md-3">
            <div class="p-4 text-light rounded-3" style="background-color: #B53471;">
                <h3 class="fs-1">
                    {{$totalQty}}
                </h3>
                <span class="fs-6">
                    Total QTY
                </span>
            </div>
        </div>
        <div class="col-8 mt-3 mt-md-0 col-md-3">
            <div class="p-4 text-light rounded-3" style="background-color: #006266;">
                <h3 class="fs-1">
                    {{$countProducts}}
                </h3>
                <span class="fs-6">
                    Total Products QTY
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <table class="table">
                <thead>
                  <tr>
                    <th class="col-3" scope="col"> Name </th>
                    <th class="col-3" scope="col"> Price </th>
                    <th class="col-3" scope="col"> Seller </th>
                    <th class="col-3" scope="col"> Controls </th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($lastAddedProducts as $lastAddedProduct)
                    <tr>
                        <th scope="row">
                            <a href="/admin/product/{{$lastAddedProduct->id}}/show"> {{$lastAddedProduct->name}} </a>
                        </th>
                        <td>{{$lastAddedProduct->price}}</td>
                        <td>
                            <a href="/admin/user/{{$lastAddedProduct->supervisor_id}}/show">
                                {{$lastAddedProduct->fname}}
                            </a>
                        </td>
                        <td>
                            <div class="d-flex justify-content-between">
                                <a href="/admin/product/{{$lastAddedProduct->id}}/edit" class="btn btn-info btn-sm ">Edit</a>
                                
                                <form class="" action="/admin/product/{{$lastAddedProduct->id}}/activate" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Activate</button>
                                </form>
                                
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#Modal{{$lastAddedProduct->id}}">Delete</button>
                            </div>
                            <!-- Button trigger modal -->
    
                            <!-- Modal -->
                            <div class="modal fade" id="Modal{{$lastAddedProduct->id}}" tabindex="-1" aria-labelledby="Modal{{$lastAddedProduct->id}}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="Modal{{$lastAddedProduct->id}}Label">Delete User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="/admin/product/{{$lastAddedProduct->id}}/delete" method="POST">
                                                @csrf
                                                <div class="col-md-12 mb-4">
                                                    <label class="fs-6 mb-1" for="admin_password{{$lastAddedProduct->id}}">Admin Password<span class="text-danger ms-1">*</span></label>
                                                    <input type="password" autocomplete="off" class="form-control" name="admin_password" id="admin_password{{$lastAddedProduct->id}}">
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
            @if ($lastAddedProducts->isEmpty())
                <div class="alert alert-info text-center">No Recent Products</div>
            @endif
        </div>
        <div class="col-md-6">
            <table class="table">
                <thead>
                  <tr>
                    <th class="col-3" scope="col"> # </th>
                    <th class="col-3" scope="col"> Total </th>
                    <th class="col-3" scope="col"> Supervisor </th>
                    <th class="col-3" scope="col"> Controls </th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($lastAddedOrders as $lastAddedOrder)
                    <tr>
                        <th scope="row">
                            <a href="/admin/order/{{$lastAddedOrder->id}}/show"> {{$lastAddedOrder->id}} </a>
                        </th>
                        <td>{{$lastAddedOrder->total}} EGP</td>
                        <td>
                            <a href="/admin/user/{{$lastAddedOrder->supervisor_id}}/show">
                                {{$lastAddedOrder->fname}}
                            </a>
                        </td>
                        <td>
                            <div class="d-flex justify-content-between">
                                <form class="" action="/admin/order/{{$lastAddedOrder->id}}/change-order-status" method="post">
                                    @csrf
                                    <input type="hidden" name="order_status" value="canceled">
                                    <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($lastAddedOrders->isEmpty())
                <div class="alert alert-info text-center">No Recent Orders</div>
            @endif
        </div>
    </div>
</div>
@endsection