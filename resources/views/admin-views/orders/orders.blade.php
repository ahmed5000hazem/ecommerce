@extends('layouts.admin')
@section('content')
@include("includes.admin.navbar")
<div class="container-fluid">
    <div class="row mt-5 justify-content-between">
        <div class="col-12 col-md-3">
            <h2>
                @if (request()->query("order_type"))
                    {{request()->query("order_type")}} Orders
                @else
                    All Orders 
                    @if (request()->query("search"))
                    {{count($orders)}}
                    @else
                    {{$orders->total()}}
                    @endif
                @endif
            </h2>
        </div>
        <div class="col-md-3 col-12 mt-3 mt-md-0">
            <form method="get" class="w-100">
                <div class="d-flex">
                    <div class="mb-3">
                        <input type="text" name="search" class="form-control rounded-0" id="exampleFormControlInput1" placeholder="Search Orders">
                    </div>
                    <div class="mb-3">
                        <button class="btn rounded-0 btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <form>
        <div class="row mt-3 justify-content-between">
            <div class="col-9 col-md-3 d-flex">
                <select class="form-select form-select-lg py-0" name="order_type" aria-label="Default select example">
                    <option selected value="0">Order Type</option>
                    <option value="pending">Pending</option>
                    <option value="process">Process</option>
                    <option value="shipped">Shipped</option>
                    <option value="fullfied">Fullfied</option>
                    <option value="canceled">Canceled</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <div class="col-3 col-md-2 d-grid">
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
                        <th class="col" scope="col">Owner</th>
                        <th scope="col">Status</th>
                        <th scope="col">Total</th>
                        <th class="col" scope="col">Supervisor</th>
                        <th scope="col">Cart Count</th>
                        <th scope="col">Cancel Req</th>
                        <th scope="col">reject Req</th>
                        <th scope="col">Created At</th>
                        <th class="col" scope="col">Controls</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <th scope="row"><a href="/admin/order/{{$order->id}}/show">{{$order->id}}</a></th>
                        <td>
                            <a href="/admin/user/{{$order->user_id}}/show">
                                {{$order->owner()->first()->fname}}
                            </a>
                        </td>
                        @if ($order->status === "fullfied")
                            <td class="text-success">Fullfied</td>

                        @elseif ($order->status === "pending")
                            <td class="text-primary">Pending</td>

                        @elseif ($order->status === "process")
                            <td class="text-primary">Pending</td>

                        @elseif ($order->status === "shipped")
                            <td class="text-info">Shipped</td>

                        @elseif ($order->status === "canceled")
                            <td class="text-danger">Canceled</td>

                        @elseif ($order->status === "rejected")
                            <td class="text-warning">Rejected</td>

                        @endif
                        <td> {{$order->total}} EGP </td>
                        <td>
                            <a class="fw-bold text-decoration-none" href='/admin/category/{{$order->supervisor()->first()->id}}/show'>
                                {{$order->supervisor()->first()->fname}}
                            </a>
                        </td>
                        <td>{{$order->cart()->get()->sum("qty")}}</td>
                        
                        <td class="text-danger">
                            @if ($order->canceledOrders()->get()->isNotEmpty())
                                Cancel Requested
                            @else
                                <span class="text-info">
                                    Null
                                </span>
                            @endif
                        </td>
                        <td class="text-warning">
                            @if ($order->rejectedOrders()->get()->isNotEmpty())
                                reject Requested
                            @else
                                <span class="text-info">
                                    Null
                                </span>
                            @endif
                        </td>
                        <td>{{ date("Y-M-d", strtotime($order->created_at))}}</td>
                        <td>
                            <div class="d-flex justify-content-between">
                                @if ($order->status !== "canceled")
                                <form class="" action="/admin/order/{{$order->id}}/change-order-status" method="post">
                                    @csrf
                                    <input type="hidden" name="order_status" value="canceled">
                                    <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                                </form>
                                @endif
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
        {{$orders->links()}}
        @endif
    </div>
</div>
@endsection