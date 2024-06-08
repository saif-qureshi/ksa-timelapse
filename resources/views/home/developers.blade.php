<x-admin.layout title="My Project">
    <div class="bg-white p-5 rounded-md mt-12">
        <div class="grid grid-cols-12 gap-5">
            @foreach ($developers as $developer)
                <a href="{{ route('home.developer', $developer->id) }}"
                    class="project-card col-span-12 md:col-span-4 bg-slate-50 rounded-md cursor-pointer hover:shadow-md transition-shadow">
                    <div class="header flex items-center bg-slate-100 p-2 rounded-md">
                        <img src="{{ $developer->getImagePath('logo') }}" alt="project-img"
                            class="w-10 h-10 rounded-full mr-3">
                        <h3 class="mb-0">{{ $developer->name }}</h3>
                    </div>
                    <div class="card-body p-0 min-h-40">
                        <img src="{{ $developer->getImagePath('cover_photo') }}" alt="project-cover-img"
                            class="w-full h-56 object-cover">
                    </div>
                    <div class="card-body p-4">
                        {{ Str::limit($developer->description, 300)}}
                    </div>
                </a>
            @endforeach

            {{ $developers->links() }}
        </div>
    </div>
</x-admin.layout>
