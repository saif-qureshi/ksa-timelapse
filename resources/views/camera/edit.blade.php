<x-admin.layout title="Edit camera">
    <div id="backend-app">
        <edit-camera :developers="{{ $developers->toJson() }}" :camera="{{ $camera->toJson() }}" :timezones="{{ $timezones->toJson() }}"/>
    </div>
    <x-slot name="script">
        @vite('resources/js/app.js')
    </x-slot>
</x-admin.layout>
