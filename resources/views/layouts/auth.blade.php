<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('styles')
    @livewireStyles
    <title>@yield('pageTitle')</title>
</head>
<body style="padding : 0;">
    @yield('content')
    @yield('scripts')
    @livewireScripts
</body>
</html>