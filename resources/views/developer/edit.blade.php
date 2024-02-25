<x-admin.layout title="Edit Developer">
    <div id="backend-app">
        <edit-developer :developer="{{ $developer->toJson() }}"/>
    </div>
    <x-slot name="script">
        @vite('resources/js/app.js')
    </x-slot>
</x-admin.layout>
