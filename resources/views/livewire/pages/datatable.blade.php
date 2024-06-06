<div class="mt-10">
    <div class="flex justify-between my-5 pl-2">
        <div class="flex gap-x-3">
            <i class="" data-lucide="{{$icon}}"></i>
            <h2 class="text-xl font-semibold">{{ Str::of($this->table->getModel())->replace('App\\Models\\','')->plural() }}</h2>
        </div>
        @if (@$createUrl)
            <a href="{{ route($createUrl) }}" class="btn btn-primary shadow-md mr-2">Create {{ Str::of($this->table->getModel())->replace('App\\Models\\','') }}</a>
        @endif
    </div>
    {{ $this->table }}
</div>