@extends('layouts.admin')
@section('content')
@include("includes.admin.navbar")
<div class="container">
    <div class="row mt-5 justify-content-end">
        <div class="col-3">
            <a href="/admin/category/create" class="btn btn-secondary float-end">Create</a>
        </div>
    </div>
    <form action="/admin/category/{{$category->id}}/update" method="POST">
        @csrf
        <div class="row mt-3 justify-content-center">
            <div class="fs-1 text-center col-6">
                <small class="fs-6 text-primary">
                    @if (!$category->is_parent)
                        Sub Category
                    @else
                        Main Category
                    @endif
                    <span class="fs-6 text-muted mt-2 ms-3">
                        {{ date("Y-M-d", strToTime($category->created_at)) }}
                    </span>
                </small>
                @if (!$category->is_parent)
                    <a class="fs-5 fw-bold text-decoration-none" href="/admin/category/{{$category->parent()->first()->id}}/show">{{$category->parent()->first()->name}}</a>
                @endif
                <div class="mb-3">
                    <input type="text" class="fs-3 form-control" name="name" value="{{$category->name}}" placeholder="Category Name">
                </div>
            </div>
            <div class="col-12"></div>
            <div class="col-6 mt-3">
                @if ($category->is_parent && $category->children()->get()->isNotEmpty())
                    <ul class="list-group list-group-horizontal justify-content-center">
                        @foreach ($category->children()->get() as $cat)
                            <li class="list-group-item"><a class="text-decoration-none" href="/admin/category/{{$cat->id}}/show"> {{$cat->name}} </a> </li>
                        @endforeach
                    </ul>
                @elseif($category->is_parent && $category->children()->get()->isEmpty())
                    <div class="alert alert-warning fs-3 fw-bold">
                        No  Sub Categories In This Category
                    </div>
                @endif
                
                <select class="my-3 form-select" name="parent_id" aria-label="Default select example">
                    <option @if($category->is_parent) selected @endif> Parent Category </option>
                    @foreach ($parents as $parent)
                        <option @if($parent->id === $category->parent_id) selected @endif value="{{$parent->id}}">{{$parent->name}}</option>
                    @endforeach
                </select>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_parent" value="1" id="flexCheckDefault" @if ($category->is_parent) checked @endif>
                    <label class="form-check-label" for="flexCheckDefault">Main Category</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_parent" value="0" id="flexCheckChecked" @if (!$category->is_parent) checked @endif>
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