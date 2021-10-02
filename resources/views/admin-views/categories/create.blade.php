@extends('layouts.admin')
@section('content')
@include("includes.admin.navbar")
<div class="container">
    <div class="row mt-5 justify-content-between">
        <div class="col-3">
            <h2>
                Create Category
            </h2>
        </div>
    </div>
    <form action="/admin/category/store" method="POST">
        @csrf
        <div class="row mt-3 justify-content-center">
            <div class="col-6 mt-3">
                <div class="mb-3">
                    <label for="categoryName" class="form-label text-muted fw-bold fs-5">Category Name</label>
                    <input type="text" class="form-control" name="name" id="categoryName">
                </div>
                <select class="my-3 form-select" name="parent_id" aria-label="Default select example">
                    <option selected> Parent Category </option>
                    @foreach ($parents as $parent)
                        <option value="{{$parent->id}}">{{$parent->name}}</option>
                    @endforeach
                </select>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_parent" value="1" id="flexCheckDefault" checked>
                    <label class="form-check-label" for="flexCheckDefault">Main Category</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_parent" value="0" id="flexCheckChecked" >
                    <label class="form-check-label" for="flexCheckChecked">Sub Category</label>
                </div>

            </div>
            <div class="col-12"></div>
            <div class="d-grid mt-5 col-6">
                <button class="btn btn-primary" type="submit">save</button>
            </div>
        </div>
    </form>
</div>
@endsection