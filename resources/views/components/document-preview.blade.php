{{-- resources/views/components/document-preview.blade.php --}}
@props(['document'])

<div class="bg-white shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $document->getTypeDisplayName() }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Reference: {{ $document->reference_number }}
                </p>
            </div>
            <div>
                @if($document->status === 'active')
                    <a href="{{ route('documents.download', $document) }}"
                       class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Download
                    </a>
                @endif
            </div>
        </div>
    </div>
    <div class="border-t border-gray-200">
        <div class="px-4 py-5 sm:px-6">
            @if($document->status === 'active')
                <div class="aspect-w-16 aspect-h-9">
                    <iframe src="{{ Storage::url($document->file_path) }}"
                            class="w-full h-full"
                            title="Document Preview">
                    </iframe>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Document not available</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        This document has been {{ $document->status }}.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
