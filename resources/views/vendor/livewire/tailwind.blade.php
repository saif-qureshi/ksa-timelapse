@if ($paginator->hasPages())
    <nav class="w-full sm:w-auto sm:mr-auto">
        <ul class="pagination">
            @if ( ! $paginator->onFirstPage())
                <li class="page-item">
                    <a class="page-link" wire:click="gotoPage(1)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-chevrons-left w-4 h-4">
                            <polyline points="11 17 6 12 11 7"></polyline>
                            <polyline points="18 17 13 12 18 7"></polyline>
                        </svg>
                    </a>
                </li>
                @if($paginator->currentPage() > 2)
                    <li class="page-item">
                        <a class="page-link" wire:click="previousPage">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-chevron-left w-4 h-4">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                        </a>
                    </li>
                @endif
            @endif

            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)

                        @if ($paginator->currentPage() > 3 && $page === 2)
                            <li class="page-item"><a class="page-link">...</a></li>
                        @endif

                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <a class="page-link">{{$page}}</a>
                            </li>
                        @else
                            <li class="page-item">

                                <a wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}"
                                   class="page-link" wire:click="gotoPage({{$page}})">{{$page}}</a>
                            </li>
                        @endif

                        @if ($paginator->currentPage() < $paginator->lastPage() - 2  && $page === $paginator->lastPage() - 1)
                            <li class="page-item"><a class="page-link">...</a></li>
                        @endif

                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                @if($paginator->lastPage() - $paginator->currentPage() >= 2)
                    <li class="page-item">
                        <a class="page-link" wire:click="nextPage">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-chevron-right w-4 h-4">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </a>
                    </li>
                @endif
                <li class="page-item">
                    <a class="page-link" wire:click="gotoPage({{ $paginator->lastPage() }})">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-chevrons-right w-4 h-4">
                            <polyline points="13 17 18 12 13 7"></polyline>
                            <polyline points="6 17 11 12 6 7"></polyline>
                        </svg>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
@endif

