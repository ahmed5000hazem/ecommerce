@extends('layouts.admin')
@section('content')
    @include('includes.admin.navbar')
    <div class="container my-5 pt-3 pb-5">
        <div class="row">
            <div class="col-12">
                <h4 class="float-start col-md-8 d-block justify-content-between col-sm-4">
                    Name : 
                    <small class="text-muted">{{$product->name}}</small>
                </h4>
            </div>
        </div>
        <hr>
        <div class="row mt-4 mb-5 justify-content-between">
            <div class="col-md-5">
                <div class="prod-controls float-end d-block mb-4 col-12">
                    <a href="/admin/product/{{$product->id}}/edit" style="margin: 0!important" class="btn me-4 float-start text-light btn-info">Edit</a>

                    <button type="button" class="btn float-end btn-danger" data-bs-toggle="modal" data-bs-target="#Modal{{$product->id}}">Delete</button>
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
                                            <label class="fs-6 mb-1" for="admin_password">Admin Password<span class="text-danger ms-1">*</span></label>
                                            <input type="password" autocomplete="off" class="form-control" name="admin_password" id="admin_password">
                                        </div>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="prod-category mb-3">
                    <h4 class="">
                        Category : 
                        <small class="text-muted">
                            <a class="text-decoration-none" href="/admin/category/{{$product->category()->first()->id}}/show">
                                {{$product->category()->first()->name}}
                            </a>
                        </small>
                    </h4>
                </div>
                <div class="prod-category mb-3">
                    <h4>
                        Price : 
                        <small class="text-muted">
                            {{$product->price}} EGP
                        </small>
                    </h4>
                </div>
                <div class="prod-discription mb-3">
                    <h4 class="mb-4">Description : </h4>
                    <p class="lh-base fw-bold">
                        {{$product->description}}
                    </p>
                </div>
                
                <div class="row fw-bold">
                    <div class="col-4">
                        @if ($product->active)
                            <span class="text-success">
                                Active
                            </span> 
                        @else
                            <span class="text-danger">
                                Not Active
                            </span>
                        @endif
                    </div>
                    <div class="col-4">
                        @if ($product->is_avilable)
                            <span class="text-success">
                                Avilable
                            </span>
                        @else
                            <span class="text-warning">
                                Not Avilable
                            </span>
                        @endif
                    </div>
                    <div class="col-4">
                        @if ($product->is_featured)
                            <span class="text-success">
                                Featured
                            </span>
                        @else
                            <span class="text-warning">
                                Not Featured
                            </span>
                        @endif
                    </div>
                </div>
                <div class="prod-colors">
                    <h4 class="my-5">Colors : </h4>
                    <div class="row row-cols-6">
                        @foreach ($colors as $color)
                            <div class="color col mb-4" title="">
                                <span>{{$color->color_name}}</span>
                                <label class="select-product-color active" style="background-color: {{$color->color}};" for="{{$color->color}}"></label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="prod-sizes">
                    <h4 class="my-5">Sizes : </h4>
                    <div class="row row-cols-6">
                        @foreach ($sizes as $size)
                            <div class="color col mb-4" title="">
                                <label class="select-product-color active text-center" for="{{$size->size}}">{{$size->size}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6 product-show">
                <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @for ($i = 0; $i < count($product_images); $i++)
                            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="{{$i}}" class="<?php if($i == 0){echo 'active';}?>" aria-current="<?php if($i == 0) echo 'true'; else echo 'false';?>" aria-label="Slide {{$i + 1}}"></button>
                        @endfor
                    </div>
                    <div class="carousel-inner">
                        @for ($i = 0; $i < count($product_images); $i++)
                            <div style="margin-right: 0;" class="carousel-item <?php if($i == 0) echo 'active'; ?>" data-bs-interval="3000">
                                <img style="" class="img-fluid" src="/images/products/sellers{{$product_images[$i]->path}}" class="d-block w-100" alt="...">
                                <div class="carousel-caption d-md-block">
                                    <h5>{{$product_images[$i]->img}}</h5>
                                </div>
                            </div>
                        @endfor
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="row" dir="rtl">
            <h3 class="text-center mb-4">
                {{__("app.offers")}}
            </h3>
            <hr>
            <div class="mt-2">
                <div class="clearfix mb-4">
                    <a href="/admin/discount/{{$product->id}}/create" class="btn btn-primary float-end"> {{__("app.add")}} {{__("app.offer")}} </a>
                </div>
                @if ($product->item_value_discount + $product->items_value_discount + $product->items_items_discount)
                <div class="list-group">
                    @foreach ($product->item_value_discounts()->get() as $item_value_discount)
                        <a href="/admin/discount/item-value-disc/{{$item_value_discount->id}}/edit" class="list-group-item list-group-item-action" title="click to edit" aria-current="true">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1"> {{__("app.discount")}} @if($item_value_discount->value) {{$item_value_discount->value}} {{__("app.EGP")}} @endif @if($item_value_discount->percent) | {{$item_value_discount->percent}}% {{__("app.from-price")}} @endif </h5>
                                <small> {{__("app.starts_at")}} | <?php echo date("Y-M-d", strtotime($item_value_discount->starts_at)); ?> </small>
                            </div>
                            <p class="my-3">
                                {{ __("app.the-offer")}} : {{__("app.buy")}} {{__("app.at-price")}} 
                                @if ($item_value_discount->value)
                                    {{ $product->price - $item_value_discount->value }} {{__("app.EGP")}}
                                @else
                                    {{ $product->price - (($item_value_discount->percent / 100) * $product->price) }} {{__("app.EGP")}}
                                @endif
                                {{__("app.instead-of")}} <span class="text-decoration-line-through"> {{ $product->price }}  {{__("app.EGP")}} </span>
                            </p>
                        </a>
                    @endforeach
                    @foreach ($product->items_value_discounts()->get() as $items_value_discount)
                        <a href="/admin/discount/items-value-disc/{{$items_value_discount->id}}/edit" class="list-group-item list-group-item-action" title="click to edit" aria-current="true">
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
                        </a>
                    @endforeach
                    @foreach ($product->items_items_discounts()->get() as $items_items_discount)
                        <a href="/admin/discount/items-items-disc/{{$items_items_discount->id}}/edit" class="list-group-item list-group-item-action">
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
                        </a>
                    @endforeach
                </div>
                @else
                    <div class="alert alert-warning text-center fs-5 fw-bold">
                        {{__("app.no-offers")}}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection