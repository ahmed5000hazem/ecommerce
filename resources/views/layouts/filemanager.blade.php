<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <link rel="stylesheet" href="{{url("lib/css/bootstrap.min.css")}}">
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
    <title>@yield('pageTitle')</title>
</head>
<body>
    <div style="height: 600px;">
        <div id="fm"></div>
    </div>
    <script src="{{url("lib/js/bootstrap.bundle.min.js")}}"></script>
    <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
    <script src="{{ url('js/custom.js') }}"></script>
</body>
</html>