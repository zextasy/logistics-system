{{-- resources/views/documents/show.blade.php --}}
<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <div class="mb-4">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-4">
                        <li>
                            <a href="{{ route('documents.index') }}" class="text-gray-400 hover:text-gray-500">
                                <i class="fas fa-file-alt"></i>
                                Documents
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span class="ml-4 text-sm font-medium text-gray-500">{{ $document->reference_number }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            {{-- Document Header --}}
            <div class="bg-white shadow-sm rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <div class="md:flex md:items-center md:justify-between">
                        <div class="flex-1 min-w-0">
                            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                                {{ $document->getTypeDisplayName() }}
                            </h2>
                            <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $document->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($document->status) }}
                                    </span>
                                </div>
                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                    <span>Generated: {{ $document->generated_at->format('M d, Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                            @can('download', $document)
                                <a href="{{ route('documents.download', $document) }}"
                                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <i class="fas fa-download mr-2"></i>
                                    Download
                                </a>
                            @endcan

                            @can('revoke', $document)
                                <form method="POST" action="{{ route('admin.documents.revoke', $document) }}"
                                      class="inline-block"
                                      onsubmit="return confirm('Are you sure you want to revoke this document?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <i class="fas fa-ban mr-2"></i>
                                        Revoke Access
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                {{-- Document Details --}}
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Document Details</h3>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Reference Number</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $document->reference_number }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Document Type</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $document->getTypeDisplayName() }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Generated At</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $document->generated_at->format('M d, Y H:i') }}</dd>
                            </div>

                            @if($document->expires_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Expires At</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $document->expires_at->format('M d, Y H:i') }}</dd>
                                </div>
                            @endif

                            @if($document->notes)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Notes</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $document->notes }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                {{-- Related Shipment Details --}}
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Shipment Information</h3>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tracking Number</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <a href="{{ route('tracking.track', $document->shipment->tracking_number) }}"
                                       class="text-indigo-600 hover:text-indigo-900">
                                        {{ $document->shipment->tracking_number }}
                                    </a>
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($document->shipment->status) }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Origin</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $document->shipment->origin }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Destination</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $document->shipment->destination }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Shipper</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $document->shipment->shipper_name }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Notify Party</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $document->shipment->notify_party_name }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                {{-- Document Preview (if available) --}}
                @if(Storage::exists('public/' . $document->file_path))
                    <div class="lg:col-span-2 bg-white shadow-sm rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Document Preview</h3>
                            <div class="border rounded-lg overflow-hidden">
                                <iframe src="{{ Storage::url($document->file_path) }}"
                                        class="w-full h-[800px]"
                                        title="Document Preview">
                                </iframe>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
