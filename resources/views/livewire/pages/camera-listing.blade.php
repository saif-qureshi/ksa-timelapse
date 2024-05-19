<div>
    <h2 class="intro-y text-lg font-medium mt-10">
        {{ $this->getTableName() }}
    </h2>

    @if (session()->has('success'))
        <div class="flex p-4 my-4 text-sm border border-green-300  text-green-800 rounded-lg bg-blue-50" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>

            <div class="ml-1.5">
                {{ session()->get('success') }}
            </div>
        </div>
    @endif
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2"
            style="justify-content: space-between">

            @if (@$createUrlHasView)
                @include($createUrl)
            @else
                <div class="col-12 text-right">
                    <div class="flex">
                        @if (@$createUrl)
                            <a href="{{ route($createUrl) }}" class="btn btn-primary shadow-md mr-2">Create</a>
                        @endif
                        @if (@$exportUrl)
                            <form action="{{ route($exportUrl) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary shadow-md mr-2">Export</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif

            @if ($this->canSearch())
                <div class="w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0 relative">
                    @include('vendor.icons.search')
                    <input type="text" class="form-control w-full sm:w-64 box px-10"
                        wire:model.live.debounce.1000ms="search"
                        placeholder="{{ $this->getSearchValue('placeholder') }}">
                    @if (count($filters))
                        <div class="inbox-filter dropdown absolute inset-y-0 right-0 flex items-center"
                            data-tw-placement="bottom-start">
                            <span class="dropdown-toggle mr-3">
                                @include('vendor.icons.chevron-down')
                            </span>
                            <div class="inbox-filter__dropdown-menu dropdown-menu pt-2">
                                <div class="dropdown-content">
                                    <div class="grid grid-cols-12 gap-4 gap-y-3">
                                        @foreach ($filters as $filter)
                                            <div class="col-span-6">
                                                <label for="input-filter-1"
                                                    class="form-label text-xs">{{ $filter['name'] }}</label>
                                                @if ($filter['type'] == 'text')
                                                    <input id="input-filter-1" type="text"
                                                        class="form-control flex-1"
                                                        wire:model.defer="{{ $filter['wireModel'] }}"
                                                        placeholder="Type the file name">
                                                @elseif($filter['type'] == 'select')
                                                    <select id="input-filter-4" class="form-select flex-1"
                                                        wire:model.defer="{{ $filter['wireModel'] }}">
                                                        <option value="">Select</option>
                                                        @foreach ($filter['options'] as $optionKey => $optionValue)
                                                            <option value="{{ $optionKey }}">{{ $optionValue }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                        @endforeach
                                        <div class="col-span-12 flex items-center mt-3 justify-end">
                                            <button class="btn btn-primary w-32 ml-2" wire:click="onSearch">Search
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

        </div>
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        @foreach ($table as $index => $header)
                            <th style="cursor: pointer"
                                class="text-center whitespace-nowrap relative @if ($sortField !== @$header['key']) {{ @$header['sort'] ? 'sorting' : '' }} @else {{ $sortAsc === 'asc' ? 'sorting_asc' : 'sorting_desc' }} @endif"
                                rowspan="1" colspan="1"
                                @if (@$header['sort']) wire:click="sortBy('{{ @$header['key'] }}')" @endif>
                                {{ $header['name'] }}
                                @if (isset($header['sort']))
                                    @include('livewire.partials.sort_icons', [
                                        'sortField' => $sortField,
                                        'field' => @$header['key'],
                                        'sortAsc' => $sortAsc,
                                    ])
                                @endif
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $value)
                        <tr class="intro-x relative" wire:key="{{ Str::uuid() }}">
                            @foreach ($table as $header)
                                <td wire:key="{{ Str::uuid() }}"
                                    class="text-center {{ @$header['class'] }} {{ isset($header['actions']) ? 'table-report__action w-auto' : '' }}">
                                    @if (isset($header['key']))
                                        @if (@$header['dot'])
                                            {{ Arr::get($value, $header['key']) }}
                                        @else
                                            {{ $value->{$header['key']} ?? @$header['default'] }}
                                        @endif
                                    @elseif(isset($header['default']))
                                        {{ $header['default'] }}
                                    @elseif(isset($header['cb']))
                                        @if (isset($header['html']))
                                            {!! $header['cb']($value) !!}
                                        @else
                                            {{ $header['cb']($value) }}
                                        @endif
                                    @elseif(isset($header['image']))
                                        <div class="w-10 h-10 image-fit zoom-in mx-auto">
                                            <img class="rounded-full"
                                                src="{{ asset(Storage::url($value->{$header['image']})) }}">
                                        </div>
                                    @elseif(isset($header['imagesCb']))
                                        @php $images = $header['imagesCb']($value) @endphp
                                        @if (gettype($images) == 'string')
                                            <div class="w-10 h-10 image-fit zoom-in mx-auto">
                                                <img class="rounded-full" src="{{ $images }}">
                                            </div>
                                        @else
                                            <div class="flex">
                                                @foreach ($images as $key => $img)
                                                    <div
                                                        class="w-10 h-10 image-fit zoom-in @if ($key > 0) -ml-5 @endif">
                                                        <img class="tooltip rounded-full" src="{{ $img }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @elseif(isset($header['checkActive']))
                                        @if ($value->{$header['checkActive']})
                                            <div class="flex items-center justify-center text-success">
                                                @include('vendor.icons.tick')
                                                Active
                                            </div>
                                        @else
                                            <div class="flex items-center justify-center text-danger">
                                                @include('vendor.icons.tick')
                                                Inactive
                                            </div>
                                        @endif
                                    @elseif(isset($header['actions']))
                                        <div data-tw-merge data-tw-placement="bottom-end" class="dropdown relative">
                                            <button data-tw-merge data-tw-toggle="dropdown" aria-expanded="false"
                                                class="transition duration-200 border shadow-sm inline-flex items-center justify-center p-2 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none bg-white">
                                                <i data-lucide="more-vertical" class="w-4 h-4"></i>
                                            </button>
                                            <div data-transition data-selector=".show"
                                                data-enter="transition-all ease-linear duration-150"
                                                data-enter-from="absolute !mt-5 invisible opacity-0 translate-y-1"
                                                data-enter-to="!mt-1 visible opacity-100 translate-y-0"
                                                data-leave="transition-all ease-linear duration-150"
                                                data-leave-from="!mt-1 visible opacity-100 translate-y-0"
                                                data-leave-to="absolute !mt-5 invisible opacity-0 translate-y-1"
                                                class="dropdown-menu absolute z-[9999] hidden">
                                                <div data-tw-merge
                                                    class="dropdown-content rounded-md border-transparent bg-white p-2 shadow-[0px_3px_10px_#00000017] w-[150px]">
                                                    @foreach ($header['actions'] as $action)
                                                        @continue(isset($action['visible']) && !$action['visible']($value))
                                                        <a href="{{ isset($action['route']) ? $action['route']($value) : '' }}"
                                                            title="{{ $action['tooltip'] ?? '' }}"
                                                            @if (isset($action['onclick'])) onclick="{{ $action['onclick']($value)['name'] }}(event,'{{ $action['onclick']($value)['params'] }}')" @endif
                                                            class="cursor-pointer flex items-center p-2 gap-x-1 transition duration-300 ease-in-out rounded-md hover:bg-slate-200/60 dropdown-item {{ @$action['class'] }}">
                                                            @include('vendor.icons.' . $action['icon'])
                                                            @if ($action['name'] instanceof Closure)
                                                                {{ $action['name']($value) }}
                                                            @else
                                                                {{ $action['name'] }}
                                                            @endif
                                                        </a>
                                                    @endforeach
                                                    <button href="javascript:void(0)"
                                                        data-access-token="{{ $value['access_token'] }}"
                                                        class="copy-access_token cursor-pointer flex items-center p-2 gap-x-1 transition duration-300 ease-in-out rounded-md hover:bg-slate-200/60 dropdown-item">
                                                        <i data-lucide="clipboard-check"
                                                            class="h-4 w-4 text-blue-500"></i>
                                                        Copy
                                                    </button>
                                                    {{-- <button data-camera-id="{{ $value['id'] }}"
                                                        title="Refresh api token for this camera"
                                                        class="regenerate-access_token cursor-pointer flex items-center p-2 gap-x-1 transition duration-300 ease-in-out rounded-md hover:bg-slate-200/60 dropdown-item">
                                                        <i data-lucide="refresh-ccw"
                                                            class="h-4 w-4 text-green-500"></i>
                                                        Regenerate
                                                    </button> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @elseif(isset($header['anchor']))
                                        @if ($this->is_multi_array($header['anchor']))
                                            <a href="{{ isset($header['anchor']['route']) ? $header['anchor']['route']($value) : '' }}"
                                                class="">
                                                @if ($header['anchor']['name'] instanceof Closure)
                                                    {{ $header['anchor']['name']($value) }}
                                                @else
                                                    {{ $header['anchor']['name'] }}
                                                @endif
                                            </a>
                                        @else
                                            @foreach ($header['anchor'] as $anchor)
                                                @continue(isset($anchor['visible']) && !$anchor['visible']($value))

                                                <a href="{{ isset($anchor['route']) ? $anchor['route']($value) : '' }}"
                                                    @if (isset($anchor['onclick'])) onclick="{{ $anchor['onclick'] }}(event)" @endif
                                                    class="{{ @$anchor['class'] }}">
                                                    @if ($anchor['name'] instanceof Closure)
                                                        {{ $anchor['name']($value) }}
                                                    @else
                                                        {{ $anchor['name'] }}
                                                    @endif
                                                </a>
                                                @if (!$loop->last)
                                                    |
                                                @endif
                                            @endforeach
                                        @endif
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach

                    @if (count($data) === 0)
                        <tr class="intro-x">
                            <td valign="top" colspan="{{ count($table) }}" class="text-center">No data available
                                in
                                table
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-3">
            @if ($this->hasPagination())
                {{ $data->links('vendor.livewire.tailwind') }}
            @endif

            @if ($this->getPerPageValue('enabled'))
                <select class="w-20 form-select box mt-3 sm:mt-0" wire:model="perPage">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="35">35</option>
                    <option value="50">50</option>
                </select>
            @endif
        </div>
    </div>
    <div id="delete-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-slate-500 mt-2">Do you really want to delete these records? <br>
                            This process cannot be undone.
                        </div>
                    </div>
                    <form action="" id="deleteForm" method="post">
                        @csrf
                        @method('DELETE')
                        <div class="px-5 pb-8 text-center">
                            <button type="button" data-tw-dismiss="modal"
                                class="btn btn-outline-secondary w-24 mr-1">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-danger w-24">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.regenerate-access_token').forEach(function(element) {
        element.addEventListener('click', function(e) {
            e.preventDefault();
            if (window.confirm('Are you sure. You want to refresh this access token ?')) {
                const id = this.getAttribute('data-camera-id');
                const path = "{{ route('camera.refresh-token', 0) }}".replace(0, id);
                window.location.href = path;
            }
        });
    });

    document.querySelectorAll('.copy-access_token').forEach(function(element) {
        element.addEventListener('click', function(e) {
            e.preventDefault();
            const token = this.getAttribute('data-access-token');
            element.blur();
            alert('Token Copied Successfully')
            navigator.clipboard.writeText(token).then(function() {
            }).catch(function(err) {
                console.error('Failed to copy token: ', err);
            });
        });
    });
</script>
