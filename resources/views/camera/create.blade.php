<x-admin.layout title="Add Camera">
    <div id="backend-app">
        <add-camera :developers="{{ $developers->toJson() }}" :timezones="{{ $timezones->toJson() }}" />
    </div>
    <x-slot name="script">
        @vite('resources/js/app.js')
    </x-slot>
</x-admin.layout>
