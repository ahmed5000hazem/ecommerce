@extends("layouts.supervisor")
@section("content")
@include('includes.supervisor.navbar')
<div class="container pt-5">
    <div class="row">
        <h2 class="text-muted fs-4 mb-4">{{__("app.filter")}}</h2>
        <form method="get">
            <div class="row">
                <div class="col-md-3 col-8 col-lg-4">
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrderStatus" aria-expanded="false" aria-controls="collapseOrderStatus">
                        {{__("app.order-status")}}
                    </button>
                    <div class="collapse" id="collapseOrderStatus">
                        <div class="card card-body">
                            <div class="row row-cols-1 row-cols-lg-2">
                                <div class="form-check col">
                                    <input class="form-check-input" type="checkbox" name="status[]" value="pending" id="statusPending">
                                    <label class="form-check-label" for="statusPending" style="font-size: 14px">
                                        {{__("app.pending")}}
                                    </label>
                                </div>
                                <div class="form-check col">
                                    <input class="form-check-input" type="checkbox" name="status[]" value="process" id="statusProcess">
                                    <label class="form-check-label" for="statusProcess" style="font-size: 14px">
                                        {{__("app.process")}}
                                    </label>
                                </div>
                                <div class="form-check col">
                                    <input class="form-check-input" type="checkbox" name="status[]" value="shipped" id="statusShipped">
                                    <label class="form-check-label" for="statusShipped" style="font-size: 14px">
                                        {{__("app.shipped")}}
                                    </label>
                                </div>
                                <div class="form-check col">
                                    <input class="form-check-input" type="checkbox" name="status[]" value="fullfied" id="statusFullfied">
                                    <label class="form-check-label" for="statusFullfied" style="font-size: 14px">
                                        {{__("app.fullfied")}}
                                    </label>
                                </div>
                                <div class="form-check col">
                                    <input class="form-check-input" type="checkbox" name="status[]" value="canceled" id="statusCanceled">
                                    <label class="form-check-label" for="statusCanceled" style="font-size: 14px">
                                        {{__("app.canceled")}}
                                    </label>
                                </div>
                                <div class="form-check col">
                                    <input class="form-check-input" type="checkbox" name="status[]" value="rejected" id="statusRejected">
                                    <label class="form-check-label" for="statusRejected" style="font-size: 14px">
                                        {{__("app.rejected")}}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-4 col-lg-2">
                    <select class="form-select" name="sort_by" aria-label="Default select example">
                        <option value="0" selected>{{__("app.sort-by")}}</option>
                        <option value="newOrder">{{__("app.newest")}}</option>
                        <option value="oldOrder">{{__("app.oldest")}}</option>
                        <option value="highTotal">{{__("app.total-high")}}</option>
                        <option value="lowTotal">{{__("app.total-low")}}</option>
                    </select>
                </div>
                <div class="col-md-4 col-12 mt-3 mt-md-0">
                    <div class="row">
                        <div class="col-md-7 d-flex flex-row flex-wrap">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="order_requests" value="0" id="canceledRequests" @if(request()->get('order_requests') === "0") checked @endif>
                                <label class="form-check-label" for="canceledRequests" style="font-size: 12px">
                                    {{__("app.all")}}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="order_requests" value="canceled" id="canceledRequests" @if(request()->get('order_requests') === "canceled") checked @endif>
                                <label class="form-check-label" for="canceledRequests" style="font-size: 12px">
                                    {{__("app.canceled-requests")}}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="order_requests" value="rejected" id="rejectedRequests" @if(request()->get('order_requests') === "rejected") checked @endif>
                                <label class="form-check-label" for="rejectedRequests" style="font-size: 12px">
                                    {{__("app.rejected-requests")}}
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-5 mt-3 mt-lg-0">
                            <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                {{__("app.search-order-by")}}
                            </button>
                        </div>
                    </div>
                    <div class="collapse" id="collapseExample">
                        <div class="my-3">
                            <input type="text" class="form-control" value="@if(request()->get('search_value')) {{request()->get('search_value')}} @endif" name="search_value" placeholder="{{__("app.value-to-search")}}">
                        </div>
                        <div class="card card-body">
                            <div class="row row-cols-1 row-cols-lg-2">
                                <div class="form-check col">
                                    <input class="form-check-input" type="radio" name="search_by" value="0" id="OrderIdRadio" @if(request()->get('search_by') === "0") checked @endif>
                                    <label class="form-check-label" for="OrderIdRadio"  style="font-size: 14px">
                                        {{__("app.nothing")}}
                                    </label>
                                </div>
                                <div class="form-check col">
                                    <input class="form-check-input" type="radio" name="search_by" value="order_id" id="OrderIdRadio" @if(request()->get('search_by') === "order_id") checked @endif>
                                    <label class="form-check-label" for="OrderIdRadio"  style="font-size: 14px">
                                        {{__("app.order-id")}}
                                    </label>
                                </div>
                                <div class="form-check col">
                                    <input class="form-check-input" type="radio" name="search_by" value="order_total" id="OrderTotalRadio" @if(request()->get('search_by') === "order_price") checked @endif>
                                    <label class="form-check-label" for="OrderTotalRadio"  style="font-size: 14px">
                                        {{__("app.order-total")}}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-4 mt-3 mt-md-0">
                    <div class="d-grid">
                        <button type="submit" class="btn-primary btn"> {{__("app.apply")}} </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row mt-5">
        <div class="responsive-table overflow-auto">
            <table class="table table-borderless table-hover align-middle product-show-750">
                <thead class="bg-light rounded border">
                    <tr class="rounded">
                        <th scope="col" class="col-2">#</th>
                        <th scope="col" class="col-2">{{__("app.created_at")}}</th>
                        <th scope="col" class="col-2"><span class="text-muted">{{__("app.order-status")}}</span></th>
                        @if ($orders_identefier === "all")
                        <th scope="col" class="col-2"><span class="text-muted">{{__("app.products-count")}}</span></th>
                        @endif
                        <th scope="col" class="col-2"><span class="text-muted">{{__("app.total")}}</span></th>
                        <th scope="col" class="col-2"><span class="text-muted">{{__("app.tools")}}</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr class="border-bottom">
                        <th class="py-2" scope="row">
                            {{$order->id}}
                        </th>
                        <td class="text-muted">
                            {{ date("Y M d", strtotime($order->created_at)) }} 
                            <br>
                            {{ date("g:i a", strtotime($order->created_at)) }}
                        </td>
                        <td 
                            @if ($orders_identefier === "all")
                                @if ($order->canceledOrders()->get()->isEmpty() && $order->rejectedOrders()->get()->isEmpty())
                                    @if ($order->status === "pending")
                                        class="text-info"
                                    @elseif($order->status === "process")
                                        class="text-info"
                                    @elseif($order->status === "shipped")
                                        class="text-primary"
                                    @elseif($order->status === "fullfied")
                                        class="text-success"
                                    @elseif($order->status === "canceled")
                                        class="text-danger"
                                    @elseif($order->status === "rejected")
                                        class="text-warning"
                                    @endif
                                @elseif($order->canceledOrders()->get()->isNotEmpty())
                                    class="text-danger"
                                @elseif($order->rejectedOrders()->get()->isNotEmpty())
                                    class="text-warning"
                                @endif
                            @elseif($orders_identefier === "canceled")
                                class="text-danger"
                            @elseif($orders_identefier === "rejected")
                                class="text-warning"
                            @endif
                        >
                        @if ($orders_identefier === "all")
                            @if ($order->canceledOrders()->get()->isEmpty() && $order->rejectedOrders()->get()->isEmpty())
                                {{ __("app.".$order->status) }}
                            @elseif($order->canceledOrders()->get()->isNotEmpty() && $order->status === "canceled")
                                {{ __("app.canceled") }}
                            @elseif($order->canceledOrders()->get()->isNotEmpty() && $order->status !== "canceled")
                                {{ __("app.canceled-request") }}
                            @elseif($order->rejectedOrders()->get()->isNotEmpty())
                                @if ($order->status === "rejected")
                                    {{ __("app.rejected") }}
                                @else
                                    {{ __("app.rejected-request") }}
                                @endif
                            @endif
                        @elseif($orders_identefier === "canceled")
                            {{ __("app.canceled-request") }}
                            @elseif($orders_identefier === "rejected")
                            {{ __("app.rejected-request") }}
                        @endif
                        
                        </td>
                        @if ($orders_identefier === "all")
                        <td class="text-muted"> X {{count($order->cart()->get())}} </td>
                        @endif
                        <td class="text-muted">{{ $order->total }} {{__("app.EGP")}} </td>
                        <td>
                            <button type="button" onclick="window.location='/supervisor/order/{{$order->id}}/details'" class="btn btn-info btn-sm text-light"> {{__("app.details")}} </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        {{ $orders->links() }}
    </div>
</div>
@endsection