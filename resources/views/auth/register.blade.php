@extends('layouts.auth')
@section('pageTitle') @lang('app.reg') @endsection
@section('content')
<div class="main">
    <section class="signup">
        @if($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger error-handle fs-5">
                        {{ $error }}
                    </div>
                @endforeach
            </div>
        @endif
        <div class="container">
            <div class="signup-content">
                <form method="post" action="/auth/register" id="signup-form" class="signup-form">
                    @csrf
                    <h2 class="form-title fs-2">@lang('app.reg')</h2>
                    <div class="form-group fs-4">
                        <input type="text" class="form-input" name="phone" id="name" placeholder="@lang('app.phone')"/>
                    </div>
                    <div class="form-group fs-4">
                        <input type="text" class="form-input" name="password" id="password" placeholder="@lang('app.password')"/>
                    </div>
                    <div class="form-group fs-4">
                        <input type="password" class="form-input" name="password_confirmation" id="re_password" placeholder="@lang('app.password_confirm')"/>
                    </div>
                    <div class="form-group fs-4">
                        <input type="submit" style="cursor: pointer; font-size:20px;" name="submit" id="submit" class="form-submit" value="@lang('app.signup')"/>
                    </div>
                </form>
                <p class="loginhere fs-5">
                    @lang('app.already_have_account')<a href="login" class="loginhere-link">@lang('app.login')</a>
                </p>
            </div>
        </div>
    </section>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{url("fonts/material-design-iconic-font/css/material-design-iconic-font.min.css")}}">
<link rel="stylesheet" href="{{url("lib/css/bootstrap.min.css")}}">
<link rel="stylesheet" href="{{url("css/reg-style.css")}}">
<link rel="stylesheet" href="{{url("css/custom.css")}}">
@endsection
@section('scripts')
<script src="{{url("vendor/jquery/jquery-3.2.1.min.js")}}"></script>
<script src="{{url("js/reg-main.js")}}"></script>
<script src="{{url("js/custom.js")}}"></script>
@endsection