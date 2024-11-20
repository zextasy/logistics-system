<?php

namespace App\Services;

use App\Models\{Shipment, Quote, Document, User};
use App\Notifications\{
    ShipmentStatusUpdated,
    QuoteProcessed,
    DocumentGenerated,
    DocumentRevoked
};
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    public function sendStatusUpdateNotification(Shipment $shipment, string $oldStatus)
    {
        $notification = new ShipmentStatusUpdated($shipment, $oldStatus);

        // Notify shipment owner
        if ($shipment->user) {
            $shipment->user->notify($notification);
        }

        // Notify via email if provided
        if ($shipment->shipper_email) {
            Notification::route('mail', $shipment->shipper_email)
                ->notify($notification);
        }

        if ($shipment->receiver_email) {
            Notification::route('mail', $shipment->receiver_email)
                ->notify($notification);
        }
    }

    public function sendQuoteProcessedNotification(Quote $quote)
    {
        $notification = new QuoteProcessed($quote);

        if ($quote->user) {
            $quote->user->notify($notification);
        }

        Notification::route('mail', $quote->email)
            ->notify($notification);
    }

    public function sendDocumentGeneratedNotification(Document $document)
    {
        $notification = new DocumentGenerated($document);
        $shipment = $document->shipment;

        if ($shipment->user) {
            $shipment->user->notify($notification);
        }

        if ($shipment->shipper_email) {
            Notification::route('mail', $shipment->shipper_email)
                ->notify($notification);
        }
    }

    public function sendDocumentRevokedNotification(Document $document, string $reason)
    {
        $notification = new DocumentRevoked($document, $reason);
        $shipment = $document->shipment;

        if ($shipment->user) {
            $shipment->user->notify($notification);
        }

        if ($shipment->shipper_email) {
            Notification::route('mail', $shipment->shipper_email)
                ->notify($notification);
        }
    }

    // Additional notification methods...
}
