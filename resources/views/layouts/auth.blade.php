<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    <meta charset="utf-8">
    <link href="dist/images/logo.svg" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="LEFT4CODE">
    <title>{{ config('app.name', 'Timelapse Masterworks') }} | @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />
</head>

<body class="login">
    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">
            <div class="hidden xl:flex flex-col min-h-screen">
                <h2 style="z-index: 999;font-size: 28px;margin-top: 2rem;margin-left: 3rem; font-weight: 600;">Timelapse Master Works</h2>
                <h3 style="z-index: 999; font-size: 16px;margin-top: 0rem;margin-left: 4rem;font-weight: 500;">In the fusion of quality and perfection</h3>
                <div class="my-auto" style="display:none">
                    <img alt="illustration" class="-intro-x w-1/2 -mt-18 bg-img"
                        src="{{ asset('dist/images/bgm.jpg') }}">
                    <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                        A few more clicks to
                        <br>
                        sign in to your account.
                    </div>
                </div>
            </div>
            <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                @yield('content')
            </div>
        </div>
    </div>
    <img alt="illustration" class="-intro-x w-1/2 -mt-18 bg-img" src="{{ asset('dist/images/bottom.jpeg') }}" style="
    margin: -7rem 32rem;
    width: 69%;
    height: 100px;
    z-index: 0;">
    @vite('resources/js/app.js')
</body>

</html>
