@extends('layouts.seller')
@section('content')
    @include('includes.seller.navbar')
<div class="container py-5">
    @if (!$products->isEmpty())
        @foreach ($products as $product)
            <div class="list-group">
                @if (!($product->item_value_discounts()->get()->isEmpty()))
                @if ( $all || $item_value )
                    @foreach ($product->item_value_discounts()->get() as $item_value_discount)
                        <a href="/seller/discount/item-value-disc/{{$item_value_discount->id}}/edit" class="list-group-item list-group-item-action" title="click to edit" aria-current="true">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1"> {{__("app.discount")}} @if($item_value_discount->value) {{$item_value_discount->value}} {{__("app.EGP")}} @endif | @if($item_value_discount->percent) {{$item_value_discount->percent}}% @endif {{__("app.from-price")}} </h5>
                                <small> {{__("app.starts_at")}} | <?php echo date("Y-M-d", strtotime($item_value_discount->starts_at)); ?> </small>
                            </div>
                            <p class="my-3">
                                {{ __("app.the-offer")}} : {{__("app.buy")}} {{__("app.at-price")}} 
                                @if ($item_value_discount->value !== null)
                                    {{ $product->price - $item_value_discount->value }} {{__("app.EGP")}}
                                @else
                                    {{ $product->price - (($item_value_discount->percent / 100) * $product->price) }} {{__("app.EGP")}}
                                @endif
                                {{__("app.instead-of")}} <span class="text-decoration-line-through"> {{ $product->price }}  {{__("app.EGP")}} </span>
                            </p>
                            <small class="text-muted">{{$product->name}}</small>
                        </a>
                    @endforeach
                @endif
                @endif
                @if (!($product->items_value_discounts()->get()->isEmpty()))
                @if ( $all || $items_value )
                    @foreach ($product->items_value_discounts()->get() as $items_value_discount)
                        <a href="/seller/discount/items-value-disc/{{$items_value_discount->id}}/edit" class="list-group-item list-group-item-action" title="click to edit" aria-current="true">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1"> 
                                    {{__("app.offer")}}  
                                    @if ($items_value_discount->items_count === 2) 
                                        {{__("app.two-peices")}} 
                                    @elseif($items_value_discount->items_count !== 2)
                                        {{$items_value_discount->items_count}}
                                        {{__("app.peices")}}
                                    @endif / {{$items_value_discount->items_value}} {{__("app.EGP")}} 
                                </h5>
                                <small> {{__("app.starts_at")}} | <?php echo date("Y-M-d", strtotime($items_value_discount->starts_at)); ?> </small>
                            </div>
                            <p class="my-3">
                                {{ __("app.the-offer")}} : {{__("app.buy")}}
                                @if ($items_value_discount->items_count === 2) 
                                        {{__("app.two-peices")}} 
                                @elseif($items_value_discount->items_count !== 2)
                                    {{$items_value_discount->items_count}}
                                    {{__("app.peices")}}
                                @endif 
                                {{__("app.at-price")}}
                                {{$items_value_discount->items_value}} {{__("app.EGP")}}
                                {{__("app.instead-of")}} <span class="text-decoration-line-through"> {{ $product->price * $items_value_discount->items_count }}  {{__("app.EGP")}} </span>
                            </p>
                            <small class="text-muted">{{$product->name}}</small>
                        </a>
                    @endforeach
                @endif
                @endif
                @if (!($product->items_items_discounts()->get()->isEmpty())) 
                @if ( $all || $items_items )
                    @foreach ($product->items_items_discounts()->get() as $items_items_discount)
                        <a href="/seller/discount/items-items-disc/{{$items_items_discount->id}}/edit" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">
                                    {{__("app.offer")}}
                                    @if ($items_items_discount->buy_items_count === 2) 
                                        {{__("app.two-peices")}} 
                                    @elseif($items_items_discount->buy_items_count !== 2)
                                        {{$items_items_discount->buy_items_count}}
                                        {{__("app.peices")}}
                                    @endif / {{$items_items_discount->get_items_count}} {{__("app.present")}}
                                </h5>
                                <small> {{__("app.starts_at")}} | <?php echo date("Y-M-d", strtotime($items_items_discount->starts_at)); ?> </small>
                            </div>
                            <p class="my-3">
                                {{__("app.the-offer")}} : {{__("app.buy")}}
                                @if ($items_items_discount->buy_items_count === 2) 
                                    {{__("app.two-peices")}} 
                                @elseif($items_items_discount->buy_items_count !== 2)
                                    {{$items_items_discount->buy_items_count}}
                                    {{__("app.peices")}}
                                @endif {{__("app.get")}} {{$items_items_discount->get_items_count}} 
                                <strong class="text-primary">
                                    {{$items_items_discount->present()->get()[0]->name}}
                                </strong>
                                {{__("app.present")}}
                            </p>
                            <small class="text-muted">{{$product->name}}</small>
                        </a>
                    @endforeach
                @endif
                @endif
            </div>
        @endforeach
    @else
        <div class="alert alert-warning text-center fs-5 fw-bold">
            {{__("app.no-offers-genral")}}
        </div>
    @endif
</div>
@endsection