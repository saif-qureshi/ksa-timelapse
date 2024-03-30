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
                                       
                                        @if($header['key'] == 'user_id')
                                            {{ $value->user->full_name ?? '' }}
                                        @elseif($header['key'] == 'camera_id')
                                            {{ $value->camera->developer->name ?? '' }}<br/>
                                            {{ $value->camera->project->name ?? '' }}<br/>
                                            {{ $value->camera->name ?? '' }}
                                        @else
                                            {{ $value->{$header['key']} ?? @$header['default'] }} 
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

           
        </div>
    </div>
  
</div>
