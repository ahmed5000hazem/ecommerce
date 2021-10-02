@extends('layouts.admin')
@section('content')
@include("includes.admin.navbar")
<div class="container">
    <div class="row mt-5 justify-content-between">
        <div class="col-4">
            <h2>
                @if (request()->route("type"))
                    <span class="text-capitalize"> {{request()->route("type")}} categories </span> {{count($categories)}}
                @else
                    All Categories {{count($categories)}}
                @endif
            </h2>
        </div>

        <div class="col-3">
            <a href="/admin/category/create" class="btn btn-secondary float-end">Create</a>
        </div>
    </div>
    <div class="row mt-4">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="col-1" scope="col">#</th>
                    <th class="col-3" scope="col">Name</th>
                    <th class="col-2" scope="col">Type</th>
                    @if(request()->route("type") !== "main")
                    <th class="col-3" scope="col">Main Category</th>
                    @endif
                    @if (request()->route("type") === "sub")
                    <th class="col-2" scope="col">Products</th>
                    @endif
                    <th class="col-3" scope="col">Controles</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <th scope="row"><a href="/admin/category/{{$category->id}}/show">{{$category->id}}</a></th>
                    <td class="text-muted fw-bold">
                        {{$category->name}}
                    </td>
                    @if ($category->is_parent)
                        <td class="text-info">Main</td>
                        @if (request()->route("type") !== "main")
                        <td class="text-warning"> Null </td>
                        @endif
                    @else
                        <td class="text-primary">Sub</td>
                        <td> <a class="text-info" href="/admin/category/{{$category->parent()->first()->id}}/show"> {{$category->parent()->first()->name}} </a> </td>
                    @endif
                    
                    @if (request()->route("type") === "sub")
                        <td class="text-primary">{{$category->product_count}}</td>
                    @endif
                    
                    <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#Modal{{$category->id}}">
                            Delete
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="Modal{{$category->id}}" tabindex="-1" aria-labelledby="Modal{{$category->id}}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="Modal{{$category->id}}Label">Delete User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/admin/category/{{$category->id}}/delete" method="POST">
                                            @csrf
                                            <div class="col-md-12 mb-4">
                                                <label class="fs-6 mb-1" for="first_name">Admin Password<span class="text-danger ms-1">*</span></label>
                                                <input type="password" autocomplete="off" class="form-control" name="admin_password">
                                            </div>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection