@extends('layouts.seller')
@section('content')
    @include('includes.seller.navbar')
    <div class="container-fluid py-3">
        <div class="row d-flex justify-content-md-between flex-wrap">
            <div class="col-md-4 col-xs-6 d-flex justify-content-start  align-items-center">
                <h3 class="fs-5"> {{__("app.prod-category")}} : <span class="text-info fs-6"> {{$category->name}} </span> </h3>
            </div>
            <div class=" col-md-4 col-xs-6 d-flex justify-content-md-center justify-content-start align-items-center">
                <p class="fs-6 text-center mb-0"> {{__("app.products-found")}}
                    @if ($products->total() > 2)
                        <span class="text-primary">
                            {{$products->total()}}
                        </span>
                        {{__("app.totalProducts")}}
                    @elseif($products->total() === 2)
                        {{__("app.tow-products")}}
                    @else
                        <span class="text-primary">
                            {{$products->total()}}
                        </span>
                        {{__("app.product")}}    
                    @endif
                </p>
            </div>
            <div class="col-md-4 mt-2 mt-md-1 col-xs-12 d-flex pt-2 justify-content-center justify-content-md-end">
                {{$products->links()}}
            </div>
        </div>
    </div>
    <div class="table-responsive overflow-auto">
        <table class="table table-bordered product-show table-hover text-center">
            <thead class="table-dark">
                <tr class="row row-cols-5">
                    <th class="col" scope="col">#</th>
                    <th class="col" scope="col">{{ __("app.prod-name") }} </th>
                    <th class="col" scope="col">{{ __("app.image") }}</th>
                    <th class="col" scope="col">{{ __("app.prod-price") }}</th>
                    <th class="col" scope="col">{{ __("app.control") }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="row row-cols-5">
                        <th class="col lh-base" scope="row">
                            <a href="/seller/product/{{$product->id}}"> {{$product->id}} </a>
                            @if (!$product->active)
                                <p class="text-warning ps-2 d-inline" > - {{__("app.un-activated-prod")}}</p>
                            @endif 
                        </th>
                        <td class="col lh-base">
                            @if ($product->item_value_discount || $product->items_value_discount || $product->items_items_discount)
                                <p class="ms-2 ms-md-4 d-inline text-warning" style="height: 30px"> {{__("app.discount")}} </p>
                            @endif
                            {{$product->name}}
                        </td>
                        <td class="col lh-base"><img width="64" height="64" src="/images/products/sellers/{{$product->images()->first()->path}}" alt=""></td>
                        <td class="col lh-base">{{$product->price}}</td>
                        <td class="col lh-base">

                            <!-- Button trigger modal -->
                            <button type="button" class="btn mt-sm-1 mt-s-1 btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal{{$product->id}}">
                                {{__("app.delete")}}
                            </button>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="modal{{$product->id}}" tabindex="-1" aria-labelledby="modal{{$product->id}}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modal{{$product->id}}Label">Modal title</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-danger">{{__("app.are you sure to delete")}}</div>
                                            <form action="/seller/product/delete/" method="post">
                                                @csrf
                                                <button class="btn btn-sm btn-danger" name="product" value="{{$product->id}}">{{__("app.delete")}}</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="/seller/product/{{$product->id}}" class="btn btn-sm mt-sm-1 mt-xs-1 text-light btn-info">{{__("app.details")}}</a>
                            <a href="/seller/product/edit/{{$product->id}}" class="btn btn-sm mt-sm-1 mt-xs-1 text-light btn-info">{{__("app.edit")}}</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="container">
        <div class="row my-3 justify-content-center">
            {{$products->links()}}
        </div>
    </div>
@endsection