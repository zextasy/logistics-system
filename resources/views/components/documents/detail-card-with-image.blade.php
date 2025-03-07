@props([
    'title',
    'titleHint',
    'image',
    'textHeading',
    'text',
])
<div class="bg-white overflow-hidden mt-0 border">
    <div class="bg-gray-100 px-4 py-1">
        <h2 class="text-sm font-semibold text-gray-800">
            {{$title}}
            <span class="text-xs">{{$titleHint ?? ''}}</span>
        </h2>
    </div>
    <div class="px-4">
        <div class="flex flex-col items-start justify-between">
            {{$image ?? ''}}
            <span class="text-sm font-medium text-gray-800"><strong>{{ $textHeading ?? '' }}</strong>{{ $text }}</span>
        </div>
    </div>
</div>
