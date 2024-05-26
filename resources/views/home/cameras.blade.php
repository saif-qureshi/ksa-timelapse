<x-admin.layout title="Cameras">
    <x-admin.styles>
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css" />
        <style>
            .slick-arrow {
                position: absolute;
                z-index: 99;
                background: #ffffff90;
                top: 50%;
                transform: translateY(-50%);
                border-radius: 5px;
            }

            .prev-arrow {
                left: 10px;
            }

            .next-arrow {
                right: 10px;
            }

            .grdient-color {
                background: linear-gradient(90deg, #84a2e5 0%, #7499ea 35%, rgba(213, 225, 227, 1) 100%);
            }

            .grdient-color2 {
                background: linear-gradient(90deg, #87a7ed 0%, #88a7ea 100%, rgba(213, 225, 227, 1) 100%);
            }

            .txt-white {
                color: white;
            }
        </style>

    </x-admin.styles>
    <div class="mt-7">
        <a href="{{ route('home.developers') }}" class="btn btn-outline-secondary">
            <i data-lucide="arrow-left"></i>
        </a>
        <div class="bg-white p-5 rounded-md mt-5">
            <div class="grid grid-cols-12 gap-5">
                @if ($cameras->count() <= 0)
                    No Camera found
                @else

                @foreach ($cameras as $camera)
                    <div
                        class="project-card col-span-12 md:col-span-4 bg-slate-50 rounded-md cursor-pointer hover:shadow-md transition-shadow">
                        <div class="grdient-color header flex items-center bg-slate-100 px-4 py-3 rounded-md">
                            <i data-lucide="cctv" class="mr-2"></i>
                            <h3 class="mb-0">{{ $camera->name }}</h3>
                        </div>
                        <div class="card-body min-h-40">
                            <ul class="slider">
                                @forelse ($camera->photos as $photo)
                                    <li>
                                        <a href="{{ route('camera.show', $camera) }}">
                                            <img src="{{ $photo->getImagePath('image') }}" alt="{{ $photo->image }}"
                                                class="w-full h-56 object-cover">
                                        </a>
                                    </li>
                                @empty
                                    <li>
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png"
                                            alt="sadas" class="w-full h-56 object-cover">
                                    </li>
                                @endforelse
                            </ul>
                        </div>

                        <a href="{{ route('camera.show', $camera) }}"
                            class="grdient-color2 p-3 inline-block text-base text-left  w-full">
                            <p class="text-sm txt-white text-white mb-1">Started:
                                {{ $camera->created_at->format('d-M-Y h:i A') }} (Arabian Standard Time)</p>
                            <p class="text-sm txt-white text-white">Last Update:
                                {{ $camera->updated_at->format('d-M-Y h:i A') }} (Arabian Standard Time)</p>
                        </a>
                    </div>
                @endforeach

                {{ $cameras->links() }}
                    
                @endif
            </div>
        </div>
    </div>

    <x-admin.scripts>
        <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
        <script>
            $('.slider').slick({
                nextArrow: '<button class="next-arrow"><i data-lucide="chevron-right" /></button>',
                prevArrow: '<button class="prev-arrow"><i data-lucide="chevron-left" /></button',
                autoplay: true
            });
        </script>
    </x-admin.scripts>
</x-admin.layout>
