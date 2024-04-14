<!DOCTYPE html>
<html lang="en" class="">

<head>
    <x-admin.head title="{{ $title }}">
    </x-admin.head>
    <x-admin.styles>
        {{ $style ?? '' }}
    </x-admin.styles>
</head>

<body class="py-5 md:py-0">
    <x-admin.mobile-menu />
    <div
        class="top-bar-boxed h-[70px] md:h-[65px] z-[51] border-b border-white/[0.08] -mt-7 md:mt-0 -mx-3 sm:-mx-8 md:-mx-0 px-3 md:border-b-0 relative md:fixed md:inset-x-0 md:top-0 sm:px-8 md:px-10 md:pt-10 md:bg-gradient-to-b md:from-slate-100 md:to-transparent dark:md:from-darkmode-700">
        <div class="h-full flex items-center">

            <a href="" class="logo -intro-x hidden md:flex">
                <img alt="{{ config('app.name') }}" class="logo__image" src="{{ asset('dist/images/logo.jpg') }}">
            </a>

            <x-admin.breadcrumbs title="{{ $title }}" />

            <div class="intro-x dropdown w-8 h-8">
                <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in scale-110"
                    role="button" aria-expanded="false" data-tw-toggle="dropdown">
                    <img alt="{{ auth()->user()->full_name }}"
                        src="https://ui-avatars.com/api/?name={{ auth()->user()->full_name }}">
                </div>
                <div class="dropdown-menu w-56">
                    <ul
                        class="dropdown-content bg-primary/80 before:block before:absolute before:bg-black before:inset-0 before:rounded-md before:z-[-1] text-white">
                        <li class="p-2">
                            <div class="font-medium">
                                <a href="">
                                    {{ auth()->user()->full_name }}
                                </a>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider border-white/[0.08]">
                        </li>
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                class="dropdown-item hover:bg-white/5">
                                <i data-lucide="toggle-right" class="w-4 h-4 mr-2"></i> Logout </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <div class="flex overflow-hidden">
        <x-admin.sidebar></x-admin.sidebar>
        <div class="content" id="app">
            {{ $slot }}
        </div>
    </div>

    <x-admin.toaster />

    <x-admin.scripts>
        {{ $script ?? '' }}
    </x-admin.scripts>
</body>

</html>
