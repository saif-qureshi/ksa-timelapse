<div class="flex gap-5">
    <img src="{{ $project->getImagePath('logo') }}" alt="" class="w-10">
    <div class="flex flex-col text-left ">
        <p class="mb-0 font-semibold">{{ $project->name }}</p>
        {{-- <span class="text-xs">{{ $project->cameras->count() }} cameras</span> --}}
    </div>
</div>