@extends('layouts.seller')
@section('content')
    @include('includes.seller.navbar')
    <div class="container">
        <div class="row">
            @if ($orders->isNotEmpty())
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="col-1" scope="col">#</th>
                            <th class="col-2" scope="col">{{__("app.created_at")}}</th>
                            <th class="col-3" scope="col">{{__("app.order-status")}}</th>
                            <th class="col-1" scope="col">{{__("app.prod-number")}}</th>
                            <th class="col-2" scope="col">{{__("app.total")}}</th>
                            <th class="col-2" scope="col">{{__("app.prod-present-number")}}</th>
                        </tr>
                    </thead>
        
                    <tbody class="text-muted fw-bold">
                        @foreach ($orders as $order)
                            <tr>
                                <th scope="row" class="fw-normal"> <a class="text-muted text-decoration-underline" href="/seller/order/{{$order->id}}"> {{$order->id}} </a> </th>
                                <td>
                                    <small dir="ltr">
                                    {{date("F j, Y,", strtotime($order->created_at))}}
                                    <br>
                                        {{date(" g:i a", strtotime($order->created_at))}}
                                    </small>
                                </td>
                                <td>
                                    @if ($order->status === "canceled") 
                                        <span class="text-danger">{{__("app.".$order->status)}}</span>
                                    @elseif($order->status === "pending")
                                        <span class="text-primary">{{__("app.waiting-".$order->status)}}</span>
                                    @elseif($order->status === "process")
                                        <span class="text-info">{{__("app.".$order->status)}}</span>
                                    @elseif($order->status === "rejected")
                                        <span class="text-warning">{{__("app.".$order->status)}}</span>
                                    @endif
                                </td>
                                <td>{{$order->orderPrices()->get()->sum("qty")}}</td>
                                <td>{{$order->orderPrices()->get()->sum("price")}} {{__("app.EGP")}} </td>
                                <td> {{ count($order->presents()->get()) }} </td>
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
        <div class="row">
            {{$orders->links()}}
        </div>
    </div>
@endsection