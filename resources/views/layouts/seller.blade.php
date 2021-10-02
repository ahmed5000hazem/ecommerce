<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{url("lib/css/bootstrap.min.css")}}">
    <link rel="stylesheet" href="{{url("lib/bootstrap-icons/bootstrap-icons.css")}}">
    @if (config("app.locale") == "ar")
    <link rel="stylesheet" href="{{url("lib/css/bootstrap.rtl.min.css")}}">
    @endif
    <link rel="stylesheet" href="{{url("/css/custom.css")}}">
    @livewireStyles
    <title>seller</title>
</head>
<body>
    @yield('content')
    <script src="{{url("lib/js/bootstrap.bundle.min.js")}}"></script>
    <script src="{{url("/js/custom.js")}}"></script>
    @livewireScripts
</body>
</html>