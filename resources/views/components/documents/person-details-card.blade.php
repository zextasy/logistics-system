@props([
    'title',
    'titleHint',
    'name',
    'address',
    'phone',
    'email',
])
<div class="bg-white overflow-hidden mt-0 border p-0">
<div class="bg-gray-100 px-4 py-1 mt-0">
    <h2 class="text-sm font-semibold text-gray-800 bg-gray-100">
        {{strtoupper($title)}}
        <span class="text-xs">{{$titleHint ?? ''}}</span>
    </h2>
</div>
<div class="px-4">
    <div class="flex flex-col items-start justify-between">
        <span class="text-sm font-medium text-gray-800">{{ strtoupper($name) }}</span><br>
        <span class="text-sm font-medium text-gray-800">{{ strtoupper($address) }}</span><br>
        <span class="text-sm font-medium text-gray-800">{{ $phone }}</span><br>
        <span class="text-sm font-medium text-gray-800">{{ $email }}</span><br>
    </div>
</div>
</div>
