<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{url("lib/css/bootstrap.min.css")}}">
    @if (config("app.locale") == "ar")
    <link rel="stylesheet" href="{{url("lib/css/bootstrap.rtl.min.css")}}">
    @endif
    <link rel="stylesheet" href="{{url('/css/frontend/core-style.css')}}">
    <link rel="stylesheet" href="{{url('/css/style.css')}}">
    <link rel="stylesheet" href="{{url('/css/frontend/main.css')}}">
    <title>@yield('pageTitle')</title>
</head>
<body>
    @yield('content')
    <script src="{{url('/js/frontend/jquery/jquery-2.2.4.min.js')}}"></script>
    <!-- bootstrap -->
    <script src="{{url("lib/js/bootstrap.bundle.min.js")}}"></script>
    <!-- Plugins js -->
    <script src="{{url('/js/frontend/plugins.js')}}"></script>
    <!-- Classy Nav js -->
    <script src="{{url('/js/frontend/classy-nav.min.js')}}"></script>
    <!-- Active js -->
    <script src="{{url('/js/frontend/active.js')}}"></script>
    <script src="{{url('/js/frontend/main.js')}}"></script>
</body>
</html>