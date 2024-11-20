<?php

// app/Services/DocumentGenerationService.php
namespace App\Services;

use App\Models\{Document, Shipment};
use Illuminate\Support\Str;
use PDF;
use Storage;
use Carbon\Carbon;

class DocumentGenerationService
{
    public function generate(Shipment $shipment, string $type, array $metadata = [])
    {
        $template = $this->getTemplate($type);
        $referenceNumber = $this->generateReferenceNumber($type);

        $pdf = PDF::loadView($template, [
            'shipment' => $shipment,
            'reference' => $referenceNumber,
            'metadata' => $metadata
        ]);

        $filePath = "documents/{$shipment->tracking_number}/{$referenceNumber}.pdf";
        Storage::put("public/{$filePath}", $pdf->output());

        return Document::create([
            'shipment_id' => $shipment->id,
            'type' => $type,
            'reference_number' => $referenceNumber,
            'file_path' => $filePath,
            'status' => 'active',
            'generated_at' => now(),
            'expires_at' => $this->calculateExpiryDate($type),
            'metadata' => array_merge($metadata, [
                'generated_by' => auth()->id(),
                'template_version' => config("documents.templates.{$type}.version")
            ])
        ]);
    }

    public function generateInitialDocuments(Shipment $shipment)
    {
        $documents = [];

        // Generate Airway Bill or Bill of Lading based on shipment type
        $documents[] = $this->generate(
            $shipment,
            $shipment->type === 'air' ? 'airway_bill' : 'bill_of_lading'
        );

        // Generate Commercial Invoice
        $documents[] = $this->generate($shipment, 'commercial_invoice');

        // Generate Packing List
        $documents[] = $this->generate($shipment, 'packing_list');

        return $documents;
    }

    public function revoke(Document $document, string $reason)
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

    public function regenerate(Document $document)
    {
        // Revoke old document
        $this->revoke($document, 'Document regenerated');

        // Generate new document
        return $this->generate(
            $document->shipment,
            $document->type,
            array_merge($document->metadata ?? [], [
                'regenerated_from' => $document->reference_number
            ])
        );
    }

    protected function getTemplate(string $type): string
    {
        return match($type) {
            'airway_bill' => 'documents.templates.airway_bill',
            'bill_of_lading' => 'documents.templates.bill_of_lading',
            'commercial_invoice' => 'documents.templates.commercial_invoice',
            'packing_list' => 'documents.templates.packing_list',
            'certificate_of_origin' => 'documents.templates.certificate_of_origin',
            default => throw new \InvalidArgumentException("Invalid document type: {$type}")
        };
    }

    protected function generateReferenceNumber(string $type): string
    {
        $prefix = match($type) {
            'airway_bill' => 'AWB',
            'bill_of_lading' => 'BOL',
            'commercial_invoice' => 'INV',
            'packing_list' => 'PCK',
            'certificate_of_origin' => 'COO',
            default => 'DOC'
        };

        return $prefix . '-' . strtoupper(Str::random(8));
    }

    protected function calculateExpiryDate(string $type): ?Carbon
    {
        $validityDays = config("documents.validity.{$type}");
        return $validityDays ? now()->addDays($validityDays) : null;
    }
}

// app/Services/QuoteService.php
