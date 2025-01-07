<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Documents</h2>

                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.documents.create') }}"
                               class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                Generate New Document
                            </a>
                        @endif
                    </div>

                    {{-- Search Form --}}
                    <form method="GET" action="{{ route('documents.index') }}" class="mb-6">
                        <div class="flex gap-4">
                            <input type="text"
                                   name="search"
                                   placeholder="Search by tracking or reference number"
                                   value="{{ request('search') }}"
                                   class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <button type="submit"
                                    class="bg-gray-100 px-4 py-2 rounded-md hover:bg-gray-200">
                                Search
                            </button>
                        </div>
                    </form>

                    {{-- Documents Table --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Reference
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Shipment
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Generated
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($documents as $document)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $document->reference_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $document->getTypeDisplayName() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $document->shipment->tracking_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $document->generated_at->format('M d, Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $document->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($document->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-3">
                                            <a href="{{ route('documents.show', $document) }}"
                                               class="text-indigo-600 hover:text-indigo-900">View</a>

                                            @can('download', $document)
                                                <a href="{{ route('documents.download', $document) }}"
                                                   class="text-green-600 hover:text-green-900">Download</a>
                                            @endcan

                                            @can('revoke', $document)
                                                <form method="POST" action="{{ route('admin.documents.revoke', $document) }}"
                                                      onsubmit="return confirm('Are you sure you want to revoke this document?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                            class="text-red-600 hover:text-red-900">Revoke</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $documents->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
