@extends('layouts.seller')
@section('content')
    @include('includes.seller.navbar')
    <div class="container pt-5">
        <div class="row justify-content-evenly mt-5">
            <div class="col-3">
                <div class="rounded-3 p-4 text-center text-light fw-bold" style="background-color: #4cd137">
                    <span class="fs-1">
                        {{count($sold_products)}}
                    </span>
                    <h3 class="fs-5">{{__("app.sold-prod")}}</h3>
                </div>
            </div>
            <div class="col-3">
                <div class="rounded-3 p-4 text-center text-light fw-bold" style="background-color: #00a8ff">
                    <span class="fs-1">
                        {{$sold_products->sum("price")}}
                    </span>
                    <h3 class="fs-5">{{__("app.sales")}}/{{__("app.EGP")}}</h3>
                </div>
            </div>
            <div class="col-3">
                <div class="rounded-3 p-4 text-center text-light fw-bold" style="background-color: #9c88ff">
                    <span class="fs-1">
                        {{count($ordered_products)}}
                    </span>
                    <h3 class="fs-5">{{__("app.new-orders")}}</h3>
                </div>
            </div>
        </div>
        <div class="row">
            @if ($ordered_products->isNotEmpty())
            <h3 class="my-5 text-center">{{__("app.last-6-hours-orders")}}</h3>
            {{-- {{$ordered_products}} --}}
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="col-1" scope="col">#</th>
                            <th class="col-3" scope="col">{{__("app.prod-name")}}</th>
                            <th class="col-1" scope="col">{{__("app.size")}}</th>
                            <th class="col-2" scope="col">{{__("app.color")}}</th>
                            <th class="col-3" scope="col">{{__("app.order-status")}}</th>
                            <th class="col-2" scope="col">{{__("app.created_at")}}</th>
                        </tr>
                    </thead>

                    <tbody class="text-muted fw-bold">
                        @foreach ($ordered_products as $ordered_product)
                            <tr>
                                <th scope="row" class="fw-normal"> <a class="text-muted text-decoration-underline" href="/seller/order/{{$ordered_product->order_id}}"> {{$ordered_product->order_id}} </a> </th>
                                <td>
                                    <a href="seller/product/{{$ordered_product->product_id}}"> {{$ordered_product->name}}
                                </td>
                                <td>{{$ordered_product->size}}</td>
                                <td>
                                    <div class="d-flex align-center">
                                        <span class="ms-2">{{$ordered_product->color_name}}</span>
                                        <span class="d-inline-block border" style="width: 24px; height: 24px; background-color: {{$ordered_product->color}}"></span>
                                    </div>
                                </td>
                                <td>
                                    @if ($ordered_product->status === "canceled") 
                                        <span class="text-danger">{{__("app.".$ordered_product->status)}}</span>
                                    @elseif($ordered_product->status === "pending")
                                        <span class="text-primary">{{__("app.waiting-".$ordered_product->status)}}</span>
                                    @elseif($ordered_product->status === "process")
                                        <span class="text-info">{{__("app.".$ordered_product->status)}}</span>
                                    @endif
                                </td>
                                <td><small dir="ltr">
                                    {{date("F j, Y,", strtotime($ordered_product->created_at))}}
                                    <br>
                                        {{date(" g:i a", strtotime($ordered_product->created_at))}}
                                    </small></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>                
            @else
            <div class="alert alert-warning fs-3 text-center mt-5">
                <strong>
                    {{__("app.no-orders")}}
                </strong>
            </div>
            @endif
        </div>
    </div>
@endsection