@extends('layouts.admin')
@section('content')
    @include('includes.admin.navbar')
    <div class="container pt-5">
        <div class="row mb-5 justify-content-center justify-content-md-start">
            <div class="col-8 mt-3 mt-md-0 col-md-3">
                <div class="p-4 text-light rounded-3" style="background-color: #130f40;">
                    <h3 class="fs-1">
                        {{$reports->sum("qty")}}
                    </h3>
                    <span class="fs-6">
                        Products Sold
                    </span>
                </div>
            </div>
            <div class="col-8 mt-3 mt-md-0 col-md-3">
                <div class="p-4 text-light rounded-3" style="background-color: #22a6b3;">
                    <h3 class="fs-1">
                        {{$reports->sum("price")}}
                    </h3>
                    <span class="fs-6">
                        Total Earnings
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive overflow-auto">
                <table class="table text-center table-hover product-show">
                    <thead>
                        <tr>
                            <th class="col-2" scope="col">Order</th>
                            <th class="col-2" scope="col">Product</th>
                            <th class="col-2" scope="col">QTY</th>
                            <th class="col-2" scope="col">Price</th>
                            <th class="col-2" scope="col">Order Status</th>
                            <th class="col-2" scope="col">Ordered At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                            <tr>
                                <th scope="row"><a href="/admin/order/{{$report->order_id}}/show"> {{$report->order_id}} </a> </th>
                                <td> <a href="/admin/product/{{$report->product_id}}/show"> {{$report->product_name}} </a> </td>
                                <td> {{$report->qty}} </td>
                                <td> {{$report->price}} </td>

                                @if ($report->status === "fullfied")
                                <td class="text-success">Fullfied</td>

                                @elseif ($report->status === "pending")
                                    <td class="text-primary">Pending</td>

                                @elseif ($report->status === "process")
                                    <td class="text-primary">Pending</td>

                                @elseif ($report->status === "shipped")
                                    <td class="text-info">Shipped</td>

                                @elseif ($report->status === "canceled")
                                    <td class="text-danger">Canceled</td>

                                @elseif ($report->status === "rejected")
                                    <td class="text-warning">Rejected</td>

                                @endif

                                <td> {{ date("Y-M-d" , strtotime($report->created_at)) }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection