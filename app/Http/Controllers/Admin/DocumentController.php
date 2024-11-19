<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentRequest;
use App\Models\Document;
use App\Services\DocumentGenerationService;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    protected $documentService;

    public function __construct(DocumentGenerationService $documentService)
    {
        $this->documentService = $documentService;
    }

    public function index(Request $request)
    {
        $documents = Document::with(['shipment', 'shipment.user'])
            ->when($request->type, function($query, $type) {
                $query->where('type', $type);
            })
            ->when($request->status, function($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(15);

        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.documents.create');
    }

    public function store(DocumentRequest $request)
    {
        $document = $this->documentService->generate(
            $request->shipment_id,
            $request->type,
            $request->metadata ?? []
        );

        return redirect()
            ->route('admin.documents.show', $document)
            ->with('success', 'Document generated successfully');
    }

    public function show(Document $document)
    {
        $document->load(['shipment', 'shipment.user']);
        return view('admin.documents.show', compact('document'));
    }

    public function revoke(Document $document)
    {
        $this->documentService->revoke($document);

        return back()->with('success', 'Document revoked successfully');
    }
}
