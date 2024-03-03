<x-admin.layout title="View camera">
    <div id="backend-app">
        <view-camera :camera="{{ $camera->toJson() }}" />
    </div>
    <x-slot name="script">
        @vite('resources/js/app.js')
    </x-slot>
</x-admin.layout>
