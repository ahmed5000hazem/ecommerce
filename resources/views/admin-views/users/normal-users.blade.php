@extends('layouts.admin')
@section('content')
@include("includes.admin.navbar")
<div class="container">
    <div class="row mt-5 justify-content-between">
        <div class="col-3">
            <form method="get">
                <div class="d-flex">
                    <div class="mb-3">
                        <input type="text" name="search" class="form-control rounded-0" id="exampleFormControlInput1" placeholder="Search Users">
                    </div>
                    <div class="mb-3">
                        <button class="btn rounded-0 btn-primary">search</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-3">
            <h2>
                @if (request()->route("role"))
                {{request()->route("role")}}s
                @else
                    Normal Users
                @endif
            </h2>
        </div>

        <div class="col-3">
            <a href="/admin/user/create" class="btn btn-secondary float-end">Create</a>
        </div>
    </div>
    <div class="row mt-4">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Controls</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <th scope="row"><a href="/admin/user/{{$user->id}}/show">{{$user->id}}</a></th>
                    <td>
                        @if ($user->fname)
                        {{$user->fname}}
                        @else
                        null
                        @endif
                    </td>
                    <td>
                        @if ($user->lname)
                        {{$user->lname}}
                        @else
                        null
                        @endif
                    </td>
                    <td>
                        @if ($user->email)
                        {{$user->email}}
                        @else
                        null
                        @endif
                    </td>
                    <td>{{$user->phone}}</td>
                    <td>{{ date("Y-M-d", strtotime($user->created_at))}}</td>
                    <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#Modal{{$user->id}}">
                            Delete
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="Modal{{$user->id}}" tabindex="-1" aria-labelledby="Modal{{$user->id}}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="Modal{{$user->id}}Label">Delete User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/admin/user/{{$user->id}}/delete" method="POST">
                                            @csrf
                                            <div class="col-md-12 mb-4">
                                                <label class="fs-6 mb-1" for="first_name">Admin Password<span class="text-danger ms-1">*</span></label>
                                                <input type="password" autocomplete="off" class="form-control" name="admin_password" id="first_name">
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
    <div class="row justify-content-center">
        @if (!request()->query("search"))
        {{$users->links()}}
        @endif
    </div>
</div>
@endsection