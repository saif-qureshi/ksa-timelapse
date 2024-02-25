<x-admin.layout title="Create User">
    <div id="backend-app">
        <add-user :developers="{{ $developers->toJson() }}" :roles="{{ $roles->toJson() }}" />
    </div>
    <x-slot name="script">
        @vite('resources/js/app.js')
    </x-slot>
</x-admin.layout>
