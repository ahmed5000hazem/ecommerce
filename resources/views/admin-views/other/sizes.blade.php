@extends('layouts.admin')
@section('content')
    @include('includes.admin.navbar')
    <div class="container pt-5">
        <div class="row mb-5 justify-content-between">
            <div class="col-md-4">
                <h3>Create Size</h3>
                <form action="/admin/size/store" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="size" class="form-label">Size</label>
                                <input type="text" class="form-control" name="size" id="size" aria-describedby="emailHelp">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="size_ordering" class="form-label">Size Order</label>
                                <input type="number" name="size_ordering" class="form-control" id="size_ordering">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="weight_min" class="form-label">Min Weight</label>
                                <input type="number" class="form-control" name="weight_min" id="weight_min" aria-describedby="emailHelp">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="weight_max" class="form-label">Max Weight</label>
                                <input type="number" name="weight_max" class="form-control" id="weight_max">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Size</th>
                        <th scope="col">Min Weight</th>
                        <th scope="col">Max Weight</th>
                        <th scope="col">Size Order</th>
                        <th scope="col">Controls</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($sizes as $size)
                        <tr>
                            <th scope="row">{{$size->size}}</th>
                            <td>{{$size->weight_min}}</td>
                            <td>{{$size->weight_max}}</td>
                            <td>{{$size->size_ordering}}</td>
                            <td>
                                <form action="/admin/size/{{$size->id}}/delete" method="POST">
                                    @csrf
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection