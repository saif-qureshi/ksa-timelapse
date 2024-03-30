<x-admin.layout title=" Comments">
    <x-slot name="style">
        <livewire:styles key="{{ str()->uuid() }}" />
    </x-slot>
    <livewire:comment-list />
    <x-slot name="script">
        <livewire:scripts />
    </x-slot>

</x-admin.layout>
