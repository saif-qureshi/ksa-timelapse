<x-admin.layout title="My Project">

    <div class="mt-7">
        <a href="{{ route('home.developers') }}" class="btn btn-outline-secondary">
            <i data-lucide="arrow-left"></i>
        </a>
        <div class="bg-white p-5 rounded-md mt-5">
            <div class="grid grid-cols-12 gap-5">
                @foreach ($projects as $project)
                    <a href="{{ route('home.project', $project->id) }}"
                        class="project-card col-span-12 md:col-span-4 bg-slate-50 rounded-md cursor-pointer hover:shadow-md transition-shadow">
                        <div class="header flex items-center bg-slate-100 p-2 rounded-md">
                            <img src="{{ $project->getImagePath('logo') }}" alt="project-img"
                                class="w-10 h-10 rounded-full mr-3">
                            <h3 class="mb-0">{{ $project->name }}</h3>
                        </div>
                        <div class="card-body p-4 min-h-40">
                            {{ $project->description }}
                        </div>
                    </a>
                @endforeach
                {{ $projects->links() }}
            </div>
        </div>
    </div>

</x-admin.layout>
