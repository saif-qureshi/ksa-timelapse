<x-admin.layout title="Create Developer">
    <div id="backend-app">
        <add-developer />
    </div>
    <x-slot name="script">
        @vite('resources/js/app.js')
    </x-slot>
</x-admin.layout>
