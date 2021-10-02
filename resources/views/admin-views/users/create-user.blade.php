@extends('layouts.admin')
@section('content')
@include("includes.admin.navbar")
<div class="container">
    <div class="row">
        <div class="container pt-3">
            <h2 class="text-center mb-4">Create New User</h2>
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
                    <form method="POST" action="/admin/users/store" class="account-form">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-4">
                                <button type="submit" class="btn btn-primary">create</button>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fs-6 mb-1" for="first_name">First Name</label>
                                <input type="text" class="form-control" name="fname" id="first_name" value="{{old("fname")}}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fs-6 mb-1" for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="lname" id="last_name" value="{{old("lname")}}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fs-6 mb-1" for="first_name">Password<span class="text-danger ms-1">*</span></label>
                                <input type="password" class="form-control" name="password" id="password" value="{{old("password")}}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fs-6 mb-1" for="last_name">Password Confirmation<span class="text-danger ms-1">*</span></label>
                                <input type="password" class="form-control" name="password_confirmation" id="password" value="{{old("password_confirmation")}}">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="fs-6 mb-1" for="country">Role</label>
                                <select class="w-100 form-select" id="country" name="role_id">
                                    @foreach ($roles as $role) 
                                        <option value="{{$role->id}}" @if($role->name === "normal_user") selected @endif >{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="fs-6 mb-1" for="country">Governorate</label>
                                <select class="w-100 form-select" id="country" name="governorate">
                                    <option value="">{{__("app.governorate")}}</option>
                                    <option value="cairo" >Cairo</option>
                                    <option value="giza" >Giza</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="fs-6 mb-1" for="street_address">Address</label>
                                <input type="text" class="form-control mb-3" name="address_one" id="street_address" value="{{old("address_one")}}">
                                <input type="text" class="form-control" name="address_two" id="street_address2" value="{{old("address_two")}}">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="fs-6 mb-1" for="phone_number">Phone<span class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control" name="phone" id="phone_number" min="0" value="{{old("phone")}}">
                            </div>
                            <div class="col-12 mb-4">
                                <label class="fs-6 mb-1" for="email_address">E-mail</label>
                                <input type="email" class="form-control" name="email" id="email_address" value="{{old("email")}}">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection