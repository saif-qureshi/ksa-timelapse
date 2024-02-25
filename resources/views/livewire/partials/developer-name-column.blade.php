<div class="flex gap-5">
    <img src="{{ $developer->getImagePath('logo') }}" alt="" class="w-10">
    <div class="flex flex-col text-left ">
        <p class="mb-0 font-semibold">{{ $developer->name }}</p>
        <span class="text-xs">{{ $developer->projects->count() }} projects</span>
    </div>
</div>