<?php

// app/Services/DocumentGenerationService.php
namespace App\Services;

use App\Models\{Document, Shipment};
use Illuminate\Support\Facades\Storage;
use PDF;

class DocumentGenerationService
{
    /**
     * Generate a new document
     */
    public function generate(int $shipmentId, string $type, array $metadata = [])
    {
        $shipment = Shipment::findOrFail($shipmentId);

        // Generate reference number
        $referenceNumber = $this->generateReferenceNumber($type);

        // Get the appropriate template
        $template = $this->getDocumentTemplate($type);

        // Generate PDF
        $pdf = PDF::loadView($template, [
            'shipment' => $shipment,
            'metadata' => $metadata,
            'reference' => $referenceNumber
        ]);

        // Create file path
        $filePath = "documents/{$shipment->tracking_number}/{$referenceNumber}.pdf";

        // Store the PDF
        Storage::put("public/{$filePath}", $pdf->output());

        // Create document record
        return Document::create([
            'shipment_id' => $shipment->id,
            'type' => $type,
            'reference_number' => $referenceNumber,
            'file_path' => $filePath,
            'status' => 'active',
            'generated_at' => now(),
            'metadata' => array_merge($metadata, [
                'generated_by' => auth()->id(),
                'template_version' => config("documents.templates.{$type}.version")
            ])
        ]);
    }

    /**
     * Generate a unique reference number
     */
    private function generateReferenceNumber(string $type): string
    {
        $prefix = match($type) {
            'airway_bill' => 'AWB',
            'bill_of_lading' => 'BOL',
            'commercial_invoice' => 'INV',
            'packing_list' => 'PCK',
            default => 'DOC'
        };

        return $prefix . '-' . strtoupper(uniqid());
    }

    /**
     * Get the appropriate template for document type
     */
    private function getDocumentTemplate(string $type): string
    {
        return match($type) {
            'airway_bill' => 'documents.templates.airway_bill',
            'bill_of_lading' => 'documents.templates.bill_of_lading',
            'commercial_invoice' => 'documents.templates.commercial_invoice',
            'packing_list' => 'documents.templates.packing_list',
            default => throw new \InvalidArgumentException("Invalid document type: {$type}")
        };
    }

    /**
     * Revoke a document
     */
    public function revoke(Document $document, string $reason = null)
    {
        $document->update([
            'status' => 'revoked',
            'metadata' => array_merge($document->metadata ?? [], [
                'revoked_at' => now(),
                'revoked_by' => auth()->id(),
                'revocation_reason' => $reason
            ])
        ]);

        return $document;
    }

    /**
     * Generate replacement document
     */
    public function generateReplacement(Document $oldDocument, array $metadata = [])
    {
        $metadata = array_merge($metadata, [
            'replaces_document' => $oldDocument->reference_number,
            'replacement_reason' => $metadata['reason'] ?? null
        ]);

        // Revoke old document
        $this->revoke($oldDocument, $metadata['reason'] ?? 'Replaced by new document');

        // Generate new document
        return $this->generate(
            $oldDocument->shipment_id,
            $oldDocument->type,
            $metadata
        );
    }
}

