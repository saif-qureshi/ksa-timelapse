<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar">
        <a href="" class="flex mr-auto">
            <img class="w-full h-14 object-cover object-left rounded-md" src="{{ asset('dist/images/logo.png') }}">
        </a>
        <a href="javascript:;" id="mobile-menu-toggler"> <i data-lucide="bar-chart-2"
                class="w-8 h-8 text-white transform -rotate-90"></i> </a>
    </div>
    <ul class="border-t border-white/[0.08] py-5 hidden">
        @php
            $currentRoute = Route::currentRouteName();
            $routeParts = explode('.', $currentRoute);
            $firstSlugPart = reset($routeParts);
        @endphp
        @foreach ($menu as $item)
            @if ($item['visible'])
                <li>
                    <a @if ($item->last()->count() == 0) href="{{ $item->get('link') }}" @endif
                        class="menu @if ($firstSlugPart == strtolower($item->get('name'))) menu--active @endif">
                        <div class="menu__icon">
                            <i class="" data-lucide="{{ $item->get('icon') }}"></i>
                        </div>
                        <div class="menu__title">
                            {{ $item->get('name') }}
                            @if ($item->last()->count() > 0)
                                <i data-lucide="chevron-down" class="menu__sub-icon transform rotate-180"></i>
                            @endif
                        </div>
                    </a>
                    <ul class="menu__sub-open">
                        @foreach ($item->last() as $childItem)
                            <li>
                                <a href="side-menu-dark-dashboard-overview-1.html" class="menu menu--active">
                                    <div class="menu__icon"><i data-lucide="activity"></i></div>
                                    <div class="menu__title"> Overview 1</div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
        @endforeach
    </ul>
</div>
