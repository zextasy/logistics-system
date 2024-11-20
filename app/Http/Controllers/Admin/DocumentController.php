<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DocumentRequest;
use App\Models\Document;
use App\Services\{DocumentGenerationService, NotificationService};
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    protected $documentService;
    protected $notificationService;

    public function __construct(
        DocumentGenerationService $documentService,
        NotificationService $notificationService
    ) {
        $this->documentService = $documentService;
        $this->notificationService = $notificationService;
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

        if ($request->notify_customer) {
            $this->notificationService->sendDocumentGeneratedNotification($document);
        }

        return redirect()
            ->route('admin.documents.show', $document)
            ->with('success', 'Document generated successfully');
    }

    public function show(Document $document)
    {
        $document->load(['shipment', 'shipment.user']);
        return view('admin.documents.show', compact('document'));
    }

    public function revoke(Request $request, Document $document)
    {
        $request->validate(['reason' => 'required|string']);

        $this->documentService->revoke($document, $request->reason);
        $this->notificationService->sendDocumentRevokedNotification($document, $request->reason);

        return back()->with('success', 'Document revoked successfully');
    }

    public function regenerate(Document $document)
    {
        $newDocument = $this->documentService->regenerate($document);
        $this->notificationService->sendDocumentRegeneratedNotification($newDocument);

        return redirect()
            ->route('admin.documents.show', $newDocument)
            ->with('success', 'Document regenerated successfully');
    }
}
