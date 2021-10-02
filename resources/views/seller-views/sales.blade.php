@extends('layouts.seller')
@section('content')
    @include('includes.seller.navbar')
    <div class="container pt-5">
        <div class="row my-5 text-center justify-content-evenly">
            <div class="col-3">
                <div class="p-4 rounded-3" style="background-color: #273c75">
                    <span class="fs-1 fw-bold text-light">
                        {{ $cart_prices->sum("price") }}
                    </span>
                    <br>
                    <span class="fs-5 text-light ">
                        {{__("app.total-sales-price")}}
                    </span>
                </div>
            </div>
            <div class="col-3">
                <div class="p-4 rounded-3" style="background-color: #e84118">
                    <span class="fs-1 fw-bold text-light">
                        {{ $cart_prices->sum("qty") }}
                    </span>
                    <br>
                    <span class="fs-5 text-light">
                        {{__("app.total-sales-qty")}}
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">{{__("app.prod-name")}}</th>
                        <th scope="col">{{__("app.qty")}}</th>
                        <th scope="col">{{__("app.total")}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $id => $product)
                    <tr>
                        <th scope="row"> <a href="/seller/product/{{$id}}/"> {{$products[$id][0]->product_name}} </a> </th>
                        <td>{{$products[$id]->sum("qty")}}</td>
                        <td>{{$products[$id]->sum("price")}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection