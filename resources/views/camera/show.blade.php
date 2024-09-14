<x-admin.layout title="View camera">
    <div id="backend-app">
        @if (auth()->user()->is_active)
        <view-camera :camera="{{ $camera->toJson() }}" :user="{{ auth()->user()->toJson() }}" />
            @else
            <div class="mt-10">
                <img src="{{ asset('dist/images/service-disabled.jpg') }}" alt="sadas"
                    class="w-full h-full object-cover">
            </div>
        @endif
    </div>
    <x-slot name="script">
        <script src="https://scripts.sirv.com/sirvjs/v3/sirv.js"></script>
        @vite('resources/js/app.js')
    </x-slot>
</x-admin.layout>
