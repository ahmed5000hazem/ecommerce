@extends('layouts.seller')
@section('content')
    @include('includes.seller.navbar')
    <div class="container py-5">
        <div class="row mt-4 justify-content-between">
            <div class="col-md-6 mb-5">
                <div class="row mb-5 pb-4">
                    <h3 class="d-flex justify-content-md-between flex-column flex-lg-row fs-4 mb-5">
                        <div>
                            {{__("app.order-id")}}
                            <span>
                                ORD-{{$order->id}}
                            </span>
                        </div>
                        <div class="text-muted fs-6 pt-2">
                            {{__("app.created_at")}} :
                            <small class="ms-2">{{date("Y-M-d" , strtotime($order->created_at))}}</small>
                        </div>
                    </h3>
                    <div>
                        <h4> {{__("app.order-status")}} 
                            <span class="fs-6 ms-3 
                                @if ($order->status === "pending")
                                    text-info
                                @elseif($order->status === "process")
                                    text-info
                                @elseif($order->status === "shipped")
                                    text-primary
                                @elseif($order->status === "fullfied")
                                    text-success
                                @elseif($order->status === "canceled")
                                    text-danger
                                @elseif($order->status === "rejected")
                                    text-danger
                                @endif"> 
                                {{__("app.".$order->status)}} 
                            </span> 
                        </h4> 
                        <div class="position-relative">
                            <div class="position-absolute top-50 bg-secondary" style="width: 100%; height: 2px; z-index: -1"></div>
                            <div class="d-flex justify-content-between">
                                @for ($i = 0; $i < 3; $i++)
                                    <button 
                                        class="btn p-0 border-0 rounded-pill text-light 
                                            @if ($order->status === 'process' && $i === 0) 
                                                bg-success 
                                            @elseif($order->status === 'shipped' && $i <= 1 ) 
                                                bg-success 
                                            @elseif($order->status === 'fullfied') 
                                                bg-success 
                                            @elseif($order->status === 'canceled' && $i === 0) 
                                                bg-danger 
                                            @else 
                                                bg-secondary 
                                            @endif  
                                            text-center align-middle" 
                                        style="height: 32px; width: 32px; line-height: 28px">
                                        
                                        @if ($order->status === "canceled")
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                            </svg>
                                        @endif
            
                                    </button>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-4">
                    <h3 class="text-start mb-4"> {{__("app.presentes")}}  
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-primary ms-3 bi bi-gift" viewBox="0 0 16 16">
                            <path d="M3 2.5a2.5 2.5 0 0 1 5 0 2.5 2.5 0 0 1 5 0v.006c0 .07 0 .27-.038.494H15a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 1 14.5V7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h2.038A2.968 2.968 0 0 1 3 2.506V2.5zm1.068.5H7v-.5a1.5 1.5 0 1 0-3 0c0 .085.002.274.045.43a.522.522 0 0 0 .023.07zM9 3h2.932a.56.56 0 0 0 .023-.07c.043-.156.045-.345.045-.43a1.5 1.5 0 0 0-3 0V3zM1 4v2h6V4H1zm8 0v2h6V4H9zm5 3H9v8h4.5a.5.5 0 0 0 .5-.5V7zm-7 8V7H2v7.5a.5.5 0 0 0 .5.5H7z"/>
                        </svg>
                    </h3>
                    <table class="table">
                        <thead >
                            <tr>
                                <th scope="col">{{__("app.prod-name")}}</th>
                                <th scope="col">{{__("app.qty")}}</th>
                                <th scope="col">{{__("app.size")}}</th>
                                <th scope="col">{{__("app.color")}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($presents as $present)
                            <tr>
                                <th class="py-2" scope="row">
                                    <a href="/product/{{ $present->product_id }}/show" class="text-primary fw-bold fs-6">
                                        {{ $present->name }}
                                    </a>
                                </th>
                                <td class="py-2">{{ $present->presents_count }}</td>
                                <td class="py-2">{{ $present->color()->first()->color_name }}</td>
                                <td class="py-2">{{ $present->size()->first()->size }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-5">
                <div class="col-12">
                    <h3 class="text-start mb-4"> {{__("app.products")}} 
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-tags" viewBox="0 0 16 16">
                            <path d="M3 2v4.586l7 7L14.586 9l-7-7H3zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2z"/>
                            <path d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zM1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1v5.086z"/>
                        </svg>
                    </h3>
                    {{-- <hr> --}}
                    <table class="table">
                        <thead >
                            <tr>
                                <th class="" scope="col">{{__("app.prod-name")}}</th>
                                <th scope="col">{{__("app.qty")}}</th>
                                <th scope="col">{{__("app.size")}}</th>
                                <th scope="col">{{__("app.color")}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $item)
                            <tr>
                                <th class="py-2" scope="row">
                                    <a href="/product/{{ $item->product_id }}/show" class="text-primary fw-bold fs-6">
                                        {{ $item->name }}
                                    </a>
                                </th>
                                <td class="py-2">{{ $item->qty }}</td>
                                <td class="py-2">{{ $item->color()->first()->color_name }}</td>
                                <td class="py-2">{{ $item->size()->first()->size }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-12 mt-3">
                    <div class="order-details-confirmation border-1 rounded-3">
                        <div class="cart-page-heading">
                            <h5>{{__("app.the-order")}}</h5>
                            <p>{{__("app.order-details")}}</p>
                        </div>
                        <ul class="order-details-form mb-4 p-3 p-md-0">
                            <li class="fs-5"><span>{{__("app.product")}}</span> <span>{{__("app.total")}}</span></li>
                            @foreach ($cart_prices as $cart_price)
                            <li>
                                <span>
                                    <a href="/product/{{ $cart_price->product_id }}/show" class="text-primary fw-bold">
                                        {{ $cart_price->name }}
                                    </a> 
                                    <span class="ms-2" dir="ltr">{{ $cart_price->qty }} X </span> 
                                </span> 
                                <span>{{ $cart_price->price }} {{__("app.EGP")}} </span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection