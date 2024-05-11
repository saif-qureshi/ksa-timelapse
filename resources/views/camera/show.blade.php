<x-admin.layout title="View camera">
    <div id="backend-app">
        <view-camera :camera="{{ $camera->toJson() }}" />
    </div>
    <x-slot name="script">
        <script src="https://scripts.sirv.com/sirvjs/v3/sirv.js"></script>
        @vite('resources/js/app.js')
    </x-slot>
</x-admin.layout>
