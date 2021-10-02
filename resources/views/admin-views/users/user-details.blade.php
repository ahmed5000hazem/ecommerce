@extends('layouts.admin')
@section('content')
@include("includes.admin.navbar")
<div class="container">
    <div class="row">
        <div class="container pt-3">
            <h2 class="text-center mb-4">User {{$user->id}} Details</h2>
            <div class="row justify-content-start py-5">
                <div class="col-md-3">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert fs-6 fw-bold alert-danger">
                                {{$error}}
                            </div>
                        @endforeach
                    @endif
                    @if (session("success"))
                        <div class="alert fs-6 fw-bold alert-success">
                            {{session("success")}}
                        </div>
                    @endif
                </div>
                <div class="col-md-6 ps-4">
                    <form method="POST" action="/admin/user/{{$user->id}}/update" class="details-form">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-4">
                                <button type="submit" class="d-none btn btn-primary">Edit User</button>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fs-6 mb-1" for="first_name">First Name</label>
                                <input readonly type="text" class="form-control" name="fname" id="first_name" value="{{$user->fname}}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fs-6 mb-1" for="last_name">Last Name</label>
                                <input readonly type="text" class="form-control" name="lname" id="last_name" value="{{$user->lname}}">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="fs-6 mb-1" for="country">Role</label>
                                <select disabled class="w-100 form-select" id="role" name="role_id">
                                    @foreach ($roles as $role) 
                                        <option value="{{$role->id}}" @if($role->id === $user->roles()->first()->id) selected @endif >{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="fs-6 mb-1" for="country">Governorate</label>
                                <select disabled class="w-100 form-select" id="country" name="governorate">
                                    <option value="">{{__("app.governorate")}}</option>
                                    <option value="cairo" @if($user->city === 'cairo') selected @endif>Cairo</option>
                                    <option value="giza" @if($user->city === 'giza') selected @endif>Giza</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="fs-6 mb-1" for="street_address">Address</label>
                                <input readonly type="text" class="form-control mb-3" name="address_one" id="street_address" value="{{$user->address_one}}">
                                <input readonly type="text" class="form-control" name="address_two" id="street_address2" value="{{$user->address_two}}">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="fs-6 mb-1" for="phone_number">Phone<span class="text-danger ms-1">*</span></label>
                                <input readonly type="text" class="form-control" name="phone" id="phone_number" min="0" value="{{$user->phone}}">
                            </div>
                            <div class="col-12 mb-4">
                                <label class="fs-6 mb-1" for="email_address">E-mail</label>
                                <input readonly type="email" class="form-control" name="email" id="email_address" value="{{$user->email}}">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-3">
                    <ul class="list-group list-group-flush mt-0 mt-md-5 text-center">
                        <li class="list-group-item">
                            <a class="text-decoration-none" href="/admin/user/{{$user->id}}/edit-password">Change Password</a>
                        </li>
                        <li class="list-group-item">
                            <div class="d-grid">
                                <button class="edit-user btn btn-primary btn-sm">Edit User</button>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-grid">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#Modal{{$user->id}}">
                                    Delete
                                </button>
                            </div>
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
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection