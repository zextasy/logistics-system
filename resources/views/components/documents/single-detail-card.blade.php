@props([
    'title',
    'titleHint',
    'text',
])
<div class="bg-white overflow-hidden mt-0 border text-center">
<div class="bg-gray-100 px-4 py-0.5">
    <h2 class="text-sm font-semibold text-gray-800">
        {{$title}}
        <span class="text-xs">{{$titleHint ?? ''}}</span>
    </h2>
</div>
<div class="px-4 py-0.5">
    <div class="flex flex-col">
        <span class="text-sm font-medium text-gray-800">{{ $text }}</span>
    </div>
</div>
</div>
