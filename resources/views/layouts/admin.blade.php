<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{url("lib/css/bootstrap.min.css")}}">
    <link rel="stylesheet" href="{{url("css/admin/style.css")}}">
    @yield('styles')
    <title>@yield('pageTitle')</title>
</head>
<body>
    @yield('content')
    <script src="{{url("js/frontend/jquery/jquery-2.2.4.min.js")}}"></script>
    <script src="{{url("lib/js/bootstrap.bundle.min.js")}}"></script>
    <script src="{{url("js/admin/script.js")}}"></script>
    @yield('scripts')
</body>
</html>