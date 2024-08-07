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
    <link href="{{ asset('css/lib/font-awesome/css/all.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet" />
    <link href=
    'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css'
        rel='stylesheet'>
    @vite(['resources/css/common.css','resources/css/list-user.css','resources/css/list-group.css'], 'build')
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini m-0 p-0">
    <x-partials.header :title="$title"/>
    <div class="wrapper">
        <x-partials.menu />
        <div class="content-wrapper bg-white">
            <section class="content">
                <div class="container-fluid">
                    
                    {{ $slot }}
                </div>
            </section>
        </div>
    </div>
    {{-- <x-partials.footer /> --}}
    <x-loading />
    <!-- JS Files -->
    <script src="{{ asset('js/lib/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/lib/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/lib/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/lib/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('js/adminlte.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
    @vite(['resources/js/common.js', 
    'resources/js/lib/jquery-validation/my-validation.js',
            'resources/js/lib/jquery-validation/my-validate-message.js',
           'resources/js/lib/jquery-validation/additional-setting.js',
           ], 'build')
    @stack('scripts')
</body>

</html>
