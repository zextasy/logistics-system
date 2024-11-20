<?php

namespace App\Services;

use App\Models\Quote;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Storage;

class QuoteService
{
    protected $notificationService;
    protected $shipmentService;

    public function __construct(
        NotificationService $notificationService,
        ShipmentService $shipmentService
    ) {
        $this->notificationService = $notificationService;
        $this->shipmentService = $shipmentService;
    }

    public function createQuote(array $data)
    {
        $data['reference_number'] = $this->generateReferenceNumber();
        $quote = Quote::create($data);

        $this->notificationService->sendQuoteReceivedNotification($quote);

        return $quote;
    }

    public function processQuote(Quote $quote, array $data)
    {
        $quote->update([
            'status' => 'processed',
            'quoted_price' => $data['quoted_price'],
            'pricing_details' => $data['pricing_details'] ?? null,
            'admin_notes' => $data['admin_notes'] ?? null,
            'processed_at' => now(),
            'valid_until' => now()->addDays(config('quotes.validity_days', 7)),
            'assigned_to' => auth()->id()
        ]);

        $this->notificationService->sendQuoteProcessedNotification($quote);

        return $quote;
    }

    public function rejectQuote(Quote $quote, string $reason)
    {
        $quote->update([
            'status' => 'rejected',
            'admin_notes' => $reason,
            'processed_at' => now()
        ]);

        $this->notificationService->sendQuoteRejectedNotification($quote, $reason);

        return $quote;
    }

    public function addAttachment(Quote $quote, UploadedFile $file)
    {
        $path = $file->store("quotes/{$quote->reference_number}/attachments", 'public');

        return $quote->attachments()->create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_type' => $file->getMimeType(),
            'file_size' => $file->getSize()
        ]);
    }

    public function calculateEstimate(array $data)
    {
        $baseRate = config("shipping.rates.{$data['service_type']}", 0);
        $weightRate = ($data['estimated_weight'] ?? 0) *
            config("shipping.weight_multiplier.{$data['weight_unit']}", 1);

        $distance = $this->calculateDistance(
            $data['origin_country'],
            $data['destination_country']
        );

        $estimate = ($baseRate + $weightRate) * ($distance / 1000);

        if (!empty($data['insurance_required'])) {
            $estimate *= 1.1; // 10% insurance premium
        }

        if (!empty($data['customs_clearance_required'])) {
            $estimate += config('shipping.customs_clearance_fee', 150);
        }

        return round($estimate, 2);
    }

    protected function generateReferenceNumber(): string
    {
        do {
            $reference = 'QT-' . strtoupper(Str::random(8));
        } while (Quote::where('reference_number', $reference)->exists());

        return $reference;
    }

    protected function calculateDistance($originCountry, $destinationCountry): int
    {
        // Simplified distance calculation
        $distances = config('shipping.country_distances', []);
        $key = "{$originCountry}-{$destinationCountry}";

        return $distances[$key] ?? 5000; // Default distance if not found
    }

    public function getCountries(): array
    {
        return $this->shipmentService->getCountries();
    }
}
