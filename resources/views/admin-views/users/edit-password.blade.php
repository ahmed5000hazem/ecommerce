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
                    @if (session("error"))
                        <div class="alert fs-6 fw-bold alert-danger">
                            {{session("error")}}
                        </div>
                    @endif
                </div>
                <div class="col-md-6 ps-4">
                    <form method="POST" action="/admin/user/{{$user->id}}/update-password" class="password-edit">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="fs-6 mb-1" for="first_name">Admin Password<span class="text-danger ms-1">*</span></label>
                                <input type="password" autocomplete="off" class="form-control" name="admin_password" id="first_name">
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="fs-6 mb-1" for="last_name">Password<span class="text-danger ms-1">*</span></label>
                                <input type="password" autocomplete="off" class="form-control" name="password" value="{{old("password")}}" id="last_name">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="fs-6 mb-1" for="phone_number">Password Confirmation<span class="text-danger ms-1">*</span></label>
                                <input type="password" autocomplete="off" class="form-control" name="password_confirmation" value="{{old("password_confirmation")}}" id="phone_number" min="0">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-secondary fs-6 mt-2">Save</button>
                    </form>
                </div>
                <div class="col-3">
                    <ul class="list-group list-group-flush mt-0 mt-md-5 text-center">
                        <li class="list-group-item">
                            <a class="text-decoration-none" href="/admin/user/{{$user->id}}/edit-password">Change Password</a>
                        </li>
                        <li class="list-group-item">
                            <a class="text-decoration-none" href="/admin/user/{{$user->id}}/">User Details</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection