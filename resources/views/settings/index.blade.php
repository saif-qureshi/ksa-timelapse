<x-admin.layout title="Settings">
    <div id="backend-app">
        <settings :settings="{{ json_encode($settings ?? []) }}" />
    </div>
    <x-slot name="script">
        @vite('resources/js/app.js')
    </x-slot>
</x-admin.layout>
