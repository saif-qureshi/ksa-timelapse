<x-admin.layout title="Edit Developer">
    <div id="backend-app">
        <edit-project :developers="{{ $developers->toJson() }}" :project="{{ $project->toJson() }}"/>
    </div>
    <x-slot name="script">
        @vite('resources/js/app.js')
    </x-slot>
</x-admin.layout>
