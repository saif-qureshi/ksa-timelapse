<!-- BEGIN: CSS Assets-->
<link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />
@vite('resources/css/app.css')
<style>
    @media (min-width: 768px) {
        .md\:w-1\/2 {
            width: 25%;
        }

        .md\:w-1\/3 {
            width: 33.333333%;
        }

        .md\:w-1\/4 {
            width: 50%;
        }

        .md\:w-1\/5 {
            width: 75%;
        }
    }

    .dark .filepond--panel-root {
        border-color: transparent;
        --tw-bg-opacity: 1;
        background-color: rgb(var(--color-darkmode-800) / var(--tw-bg-opacity));
        transition-property: none;
    }

    .dark .vs__selected {
        border-color: transparent;
        --tw-bg-opacity: 1;
        background-color: rgb(var(--color-darkmode-800) / var(--tw-bg-opacity));
        transition-property: none;
        color: inherit;
    }

    .dark .vs__dropdown-menu {
        border-color: transparent;
        --tw-bg-opacity: 1;
        background: rgb(var(--color-darkmode-800) / var(--tw-bg-opacity));
        transition-property: none;
        color: inherit;
    }

    .dark .vs__dropdown-option--disabled {
        background: #212b4491;
        color: inherit;
    }

    .vs--searchable .vs__dropdown-toggle {
        min-height: 38px !important;
        border-radius: 0.375rem !important;
    }

    .dark .vs__dropdown-toggle {
        border-color: transparent;
        --tw-bg-opacity: 1;
        background: rgb(var(--color-darkmode-800) / var(--tw-bg-opacity));
        transition-property: none;
        color: inherit;
    }


    .dark .vs__search {
        border-color: transparent !important;
    }

    .dark .vs__dropdown-option {
        color: inherit;
    }
</style>
{{ $slot }}
