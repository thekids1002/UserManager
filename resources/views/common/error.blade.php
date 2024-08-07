<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title>Commom -màn hình lỗi chung</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- CSS Files -->
    <link href="{{ asset('css/lib/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet" />
    @vite(['resources/css/common.css'], 'build')
</head>

<body class="container">
    <div class="container-fluid m-5 h-100" style="padding :10% 5% 20% 5%">
        <div class="text-start">
            申し訳ございません。
        </div>
        <div class="text-start">
            お客様がアクセスしようとしたページが見つかりませんでした。
        </div>
        <div class="text-start">
            サイト更新などによってURLが変更になったか、URLが正しく入力されていない可能性があります。
        </div>
    </div>
    <div class="m-5">
        <div class="d-flex align-items-center justify-content-center">
            <a href="{{ route('logout') }}"><button class="btn btn-secondary">Back to Login</button></a>
        </div>
    </div>
    @vite([
        'resources/js/common.js',
        'resources/js/lib/jquery-validation/additional-setting.js',
        'resources/js/nocache.js',
    ], 'build')
    @stack('scripts')
</body>

</html>
