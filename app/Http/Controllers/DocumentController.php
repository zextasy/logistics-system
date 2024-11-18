<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;
use Carbon\Carbon;

class DocumentController extends Controller
{
    /**
     * Display a listing of the documents.
     */
    public function index(Request $request)
    {
        $documents = Document::with('shipment')
            ->when($request->search, function ($query, $search) {
                $query->whereHas('shipment', function ($q) use ($search) {
                    $q->where('tracking_number', 'like', "%{$search}%");
                })->orWhere('reference_number', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('documents.index', compact('documents'));
    }

    /**
     * Display the specified document.
     */
    public function show(Document $document)
    {
        $this->authorize('view', $document);
        return view('documents.show', compact('document'));
    }

    /**
     * Generate a new document.
     */
    public function generate(Request $request)
    {
        $request->validate([
            'shipment_id' => 'required|exists:shipments,id',
            'type' => 'required|in:airway_bill,bill_of_lading,commercial_invoice,packing_list',
            'expires_after_days' => 'nullable|integer|min:1'
        ]);

        $shipment = Shipment::findOrFail($request->shipment_id);

// Generate PDF based on document type
        $view = match ($request->type) {
            'airway_bill' => 'documents.templates.airway_bill',
            'bill_of_lading' => 'documents.templates.bill_of_lading',
            'commercial_invoice' => 'documents.templates.commercial_invoice',
            'packing_list' => 'documents.templates.packing_list',
        };

        $pdf = PDF::loadView($view, compact('shipment'));

// Generate unique reference number and file path
        $referenceNumber = Document::generateReferenceNumber();
        $filePath = "documents/{$shipment->tracking_number}/{$referenceNumber}.pdf";

// Store the PDF
        Storage::put("public/{$filePath}", $pdf->output());

// Create document record
        $document = Document::create([
            'shipment_id' => $shipment->id,
            'type' => $request->type,
            'file_path' => $filePath,
            'reference_number' => $referenceNumber,
            'generated_at' => now(),
            'expires_at' => $request->expires_after_days
                ? now()->addDays($request->expires_after_days)
                : null,
            'status' => 'active'
        ]);

        return redirect()
            ->route('admin.documents.show', $document)
            ->with('success', 'Document generated successfully');
    }

    /**
     * Download the specified document.
     */
    public function download(Document $document)
    {
        $this->authorize('download', $document);

        if ($document->hasExpired()) {
            return back()->with('error', 'This document has expired.');
        }

        $path = storage_path("app/public/{$document->file_path}");

        return response()->download(
            $path,
            "{$document->reference_number}_{$document->type}.pdf"
        );
    }

    /**
     * Revoke access to a document.
     */
    public function revoke(Document $document)
    {
        $this->authorize('revoke', $document);

        $document->update([
            'status' => 'revoked',
            'expires_at' => now()
        ]);

        return back()->with('success', 'Document access has been revoked.');
    }
}
