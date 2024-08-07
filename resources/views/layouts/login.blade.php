<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>

    <!-- Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- CSS Files -->
    <link href="{{ asset('css/lib/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet" />
    @vite(['resources/css/common.css'], 'build')
    @stack('styles')
</head>

<body class="container-fluid m-0 p-0">
    <div class="bg-white border" style="height: 100px">
        <div class="h-50 p-3"></div>
        <div class="d-flex align-items-center justify-content-center"> <h3>Login</h3></div>
    </div>
    {{ $slot }}
    <x-loading />
    <!-- JS Files -->
    <script src="{{ asset('js/lib/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/lib/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/lib/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/lib/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('js/adminlte.min.js') }}"></script>
    @vite([
        'resources/js/common.js',
        'resources/js/lib/jquery-validation/additional-setting.js',
        'resources/js/nocache.js',
    ], 'build')
    @stack('scripts')
</body>

</html>
