@extends('layouts.auth')
@section('pageTitle') @lang('app.login') @endsection
<div class="limiter">
    <div class="container-login100" style="background-image: url('/images/register/signup-bg.jpg');">
        @section('content')
        @if ( session()->has('logErrors') )
            <div class="error">
                <div class="alert alert-danger error-handle fs-5">
                    {{ session()->get('logErrors') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger error-handle fs-5">
                        {{ $error }}
                    </div>
                @endforeach
            </div>
        @endif

        <div class="wrap-login100 p-l-110 p-r-110 p-t-62 p-b-33"> 
            <form class="login100-form validate-form flex-sb flex-w" action="/auth/login" method="post">
                @csrf
                <span class="login100-form-title p-b-53">
                    @lang("app.login")
                </span>
                
                <div class="p-t-31 p-b-9">
                    <span class="txt1 fs-4">
                        @lang("app.phone")
                    </span>
                </div>
                <div class="wrap-input100 " data-validate = "Username is required">
                    <input class="input100" type="text" name="phone" >
                    <span class="focus-input100"></span>
                </div>
                
                <div class="p-t-13 p-b-9">
                    <span class="txt1 fs-4">
                        @lang("app.password")
                    </span>

                    {{-- <a href="#" class="txt2 bo1 m-l-5">
                        Forgot?
                    </a> --}}
                </div>
                <div class="wrap-input100 validate-input" data-validate = "Password is required">
                    <input class="input100" type="password" name="password" >
                    <span class="focus-input100"></span>
                </div>

                <div class="container-login100-form-btn m-t-17">
                    <button class="login100-form-btn  fs-4">
                        @lang("app.signin")
                    </button>
                </div>

                <div class="w-full text-center p-t-55">
                    <span class="txt2 fs-5">
                        @lang("app.not_a_member")
                    </span>

                    <a href="/auth/register" class="txt2 bo1 fs-5">
                        @lang("app.reg_now")
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="dropDownSelect1"></div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{url("lib/css/bootstrap.min.css")}}">
<link rel="stylesheet" href="{{url("fonts/font-awesome-4.7.0/css/font-awesome.min.css")}}">
<link rel="stylesheet" href="{{url("fonts/Linearicons-Free-v1.0.0/icon-font.min.css")}}">
<link rel="stylesheet" href="{{url("vendor/animate/animate.css")}}"/>
<link rel="stylesheet" href="{{url("vendor/css-hamburgers/hamburgers.min.css")}}">
<link rel="stylesheet" href="{{url("vendor/animsition/css/animsition.min.css")}}">
<link rel="stylesheet" href="{{url("vendor/select2/select2.min.css")}}"/>
<link rel="stylesheet" href="{{url("vendor/daterangepicker/daterangepicker.css")}}">
<link rel="stylesheet" href="{{url("css/util.css")}}">
<link rel="stylesheet" href="{{url("css/log-style.css")}}">
<link rel="stylesheet" href="{{url("css/custom.css")}}">
@endsection

@section('scripts')
<script src="{{url("vendor/jquery/jquery-3.2.1.min.js")}}"></script>
<script src="{{url("lib/js/bootstrap.bundle.min.js")}}"></script>
<script src="{{url("vendor/animsition/js/animsition.min.js")}}"></script>
<script src="{{url("vendor/select2/select2.min.js")}}"></script>
<script src="{{url("vendor/daterangepicker/moment.min.js")}}"></script>
<script src="{{url("vendor/daterangepicker/daterangepicker.js")}}"></script>
<script src="{{url("vendor/countdowntime/countdowntime.js")}}"></script>
<script src="{{url("js/login-main.js")}}"></script>
<script src="{{url("js/custom.js")}}"></script>
@endsection