<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    <meta charset="utf-8">
    <link href="dist/images/logo.svg" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="LEFT4CODE">
    <title>{{ config('app.name', 'Timelapse Masterworks') }} | @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />
    <style>
        .login::after {
            background: url('{{ asset('storage/' . settings('login_bg_image')) }}') center top / cover;
        }

        @media (max-width: 450px) {
            .login {
                background-image: url('{{ asset('storage/' . settings('mobile_login_bg_image')) }}');
                background-position: center;
                background-size: cover;
            }
        }
    </style>
</head>

<body class="login">
    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">
            <div class="hidden xl:flex flex-col min-h-screen text-white" style="max-width: 450px">
                <h2 style="z-index: 999;font-size: 28px;margin-top: 2rem; font-weight: 600;">Timelapse
                    Masterworks</h2>
                <h3 style="z-index: 999; font-size: 18px;font-weight: 600; text-transform: uppercase">Others
                    promise, We deliver.</h3>
            </div>
            <div class="h-screen xl:h-auto flex py-5 xl:py-0">
                @yield('content')
            </div>
        </div>
    </div>
    <div class="hidden md:flex absolute right-0 bottom-0 w-full"
        style="height: 100px; background-color:#2b2b2b; align-items:center">
        <img alt="illustration" class="mx-auto h-auto" width="150px" src="{{ asset('dist/images/logo.png') }}">
    </div>
    @vite('resources/js/app.js')
</body>

</html>
