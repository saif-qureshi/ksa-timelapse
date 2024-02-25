<x-admin.layout title="Create Project">
    <div id="backend-app">
        <add-project :developers="{{ $developers->toJson() }}" />
    </div>
    <x-slot name="script">
        @vite('resources/js/app.js')
    </x-slot>
</x-admin.layout>
