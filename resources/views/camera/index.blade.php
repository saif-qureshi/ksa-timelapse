<x-admin.layout title=" Camera">
    <x-slot name="style">
        <livewire:styles key="{{ str()->uuid() }}"/>
    </x-slot>
    <livewire:camera-list/>
    <x-slot name="script">
        <livewire:scripts/>
    </x-slot>
</x-admin.layout>
