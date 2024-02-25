<x-admin.layout title="Edit User">
    <div id="backend-app">
        <edit-user 
            :developers="{{ $developers->toJson() }}" 
            :roles="{{ $roles->toJson() }}"
            :user="{{ $user->toJson() }}" 
        />
    </div>
    <x-slot name="script">
        @vite('resources/js/app.js')
    </x-slot>
</x-admin.layout>
