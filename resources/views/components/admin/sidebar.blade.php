<nav class="side-nav cms-side">
    <ul>
        @php
            $currentRoute = Route::currentRouteName();
            $routeParts = explode('.', $currentRoute);
            $firstSlugPart = reset($routeParts);
        @endphp
        @foreach ($menu as $item)
            @if ($item['visible'])
                <li>
                    <a class="NN side-menu @if ($firstSlugPart == strtolower($item->get('name'))) side-menu--active @endif"
                        @if ($item->last()->count() == 0) href="{{ $item->get('link') }}" @endif>
                        <div class="side-menu__icon">
                            <i class="" data-lucide="{{ $item->get('icon') }}"></i>
                        </div>
                        <div class="side-menu__title">
                            {{ $item->get('name') }}
                            @if ($item->last()->count() > 0)
                                <div class="side-menu__sub-icon"><i data-lucide="chevron-down"></i></div>
                            @endif
                        </div>
                    </a>
                    <ul>
                        @foreach ($item->last() as $childItem)
                            <li class="">
                                <a @if ($childItem->last()->count() == 0) href="{{ $childItem->get('link') }}" @endif
                                    class="side-menu @if (Route::currentRouteName() == strtolower($childItem->get('route'))) side-menu--active @endif">
                                    <div class="side-menu__icon mx-0"><i
                                            data-lucide="{{ $childItem->get('icon') }}"></i>
                                    </div>
                                    <div class="side-menu__title">
                                        {{ $childItem->first() }}
                                        @if ($childItem->last()->count() > 0)
                                            <div class="side-menu__sub-icon"><i data-lucide="chevron-down"></i></div>
                                        @endif
                                    </div>
                                </a>
                                @if ($childItem->last()->count() > 0)
                                    <ul>
                                        @foreach ($childItem->last() as $child)
                                            <li class="">
                                                <a href="{{ $child->get('link') }}"
                                                    class="side-menu @if (Route::currentRouteName() == strtolower($child->get('route'))) side-menu--active @endif">
                                                    <div class="side-menu__icon mx-0"><i
                                                            data-lucide="{{ $child->get('icon') }}"></i></div>
                                                    <div class="side-menu__title">{{ $child->first() }}</div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
        @endforeach
    </ul>
</nav>
