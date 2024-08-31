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
    <div class="flex overflow-hidden">
        <x-admin.sidebar>
        </x-admin.sidebar>
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
