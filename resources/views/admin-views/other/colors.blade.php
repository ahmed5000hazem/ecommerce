@extends('layouts.admin')
@section('content')
    @include('includes.admin.navbar')
    <div class="container pt-5">
        <div class="row mb-5 justify-content-between">
            <div class="col-md-4">
                <h3>Create Color</h3>
                <form action="/admin/color/store" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="colorName" class="form-label">Color Name</label>
                        <input type="text" class="form-control" name="color_name" id="colorName" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="colorHex" class="form-label">Color Hex</label>
                        <input type="color" name="color" class="form-control" id="colorHex">
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
            <div class="col-md-6">
                <ul class="list-group">
                    @foreach ($colors as $color)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-4">Display Name : {{$color->color_name}}</div>
                                <div class="col-6 d-flex align-middle">
                                    <span class="d-block"> Color :  {{$color->color}}</span>
                                    <span class="border ms-3 d-block" style="width: 22px; height: 22px; background-color: {{$color->color}};"></span>
                                </div>
                                <div class="col-2">
                                    <form action="/admin/color/{{$color->id}}/delete" method="post">
                                        @csrf
                                        <button class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection