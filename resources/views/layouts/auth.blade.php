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
                <a href="{{ route('login') }}" class="-intro-x flex items-center pt-5 mt-5">
                    <img alt="logo" class="w-auto h-12" src="{{ asset('dist/images/logo.jpg') }}">
                </a>
                <div class="my-auto">
                    <img alt="illustration" class="-intro-x w-1/2 -mt-18"
                        src="{{ asset('dist/images/illustration.svg') }}">
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
    @vite('resources/js/app.js')
</body>

</html>
