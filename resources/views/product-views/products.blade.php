@extends('layouts.seller')
@section('content')
    @include('includes.seller.navbar')
    <div class="container-fluid pt-2">
        <div class="row d-flex justify-content-between">
            <div class="col-6"></div>
            <div class="col-6 d-flex justify-content-end">
                {{$products->links()}}
            </div>
        </div>
    </div>
    <div class="table-responsive overflow-auto">
        <table class="table table-bordered table-hover text-center product-show-750">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ __("app.prod-name") }}</th>
                    <th scope="col">{{ __("app.prod-price") }}</th>
                    <th scope="col">{{ __("app.prod-category") }}</th>
                    <th scope="col">{{ __("app.control") }}</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($products as $product)
                    <tr>
                        <th scope="row">
                            <a href="/seller/product/{{$product->id}}"> {{$product->id}}</a>
                            @if (!$product->active)
                                <p class="text-warning ps-2 d-inline" > - {{__("app.un-activated-prod")}}</p>
                            @endif 
                        </th>
                        <td class="position-relative">
                            @if ($product->item_value_discount || $product->items_value_discount || $product->items_items_discount)
                                <p class="ms-2 ms-md-4 d-inline text-warning" style="height: 30px"> {{__("app.discount")}} </p>
                            @endif
                            {{$product->name}}
                        </td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->category_name}}</td>
                        <td>

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal{{$product->id}}">
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
                            <a href="/seller/product/{{$product->id}}" class="btn btn-sm text-light btn-info">{{__("app.details")}}</a>
                            <a href="/seller/product/edit/{{$product->id}}" class="btn btn-sm text-light btn-info">{{__("app.edit")}}</a>
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