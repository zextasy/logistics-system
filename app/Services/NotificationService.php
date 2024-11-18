<?php

namespace App\Services;

use App\Models\{Document, Quote, Shipment};
use App\Notifications\{
    QuoteProcessed,
    DocumentGenerated,
    ShipmentStatusUpdated
};
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    /**
     * Send quote processed notification
     */
    public function sendQuoteProcessedNotification(Quote $quote)
    {
        if ($quote->email) {
            Notification::route('mail', $quote->email)
                ->notify(new QuoteProcessed($quote));
        }

        if ($quote->user_id) {
            $quote->user->notify(new QuoteProcessed($quote));
        }
    }

    /**
     * Send document generated notification
     */
    public function sendDocumentGeneratedNotification(Document $document)
    {
        $shipment = $document->shipment;

        // Notify shipper
        if ($shipment->shipper_email) {
            Notification::route('mail', $shipment->shipper_email)
                ->notify(new DocumentGenerated($document));
        }

        // Notify receiver
        if ($shipment->receiver_email) {
            Notification::route('mail', $shipment->receiver_email)
                ->notify(new DocumentGenerated($document));
        }

        // Notify associated user
        if ($shipment->user_id) {
            $shipment->user->notify(new DocumentGenerated($document));
        }
    }

    /**
     * Send shipment status update notification
     */
    public function sendShipmentStatusNotification(Shipment $shipment, string $oldStatus)
    {
        $notification = new ShipmentStatusUpdated($shipment, $oldStatus);

        // Notify shipper
        if ($shipment->shipper_email) {
            Notification::route('mail', $shipment->shipper_email)
                ->notify($notification);
        }

        // Notify receiver
        if ($shipment->receiver_email) {
            Notification::route('mail', $shipment->receiver_email)
                ->notify($notification);
        }

        // Notify associated user
        if ($shipment->user_id) {
            $shipment->user->notify($notification);
        }

        // Notify subscribers
        foreach ($shipment->subscribers as $subscriber) {
            Notification::route('mail', $subscriber->email)
                ->notify($notification);
        }
    }

    /**
     * Send reminder notifications
     */
    public function sendReminders()
    {
        // Send quote expiry reminders
        Quote::where('status', 'processed')
            ->where('valid_until', '>', now())
            ->where('valid_until', '<', now()->addDays(3))
            ->each(function ($quote) {
                if ($quote->email) {
                    Notification::route('mail', $quote->email)
                        ->notify(new QuoteExpiryReminder($quote));
                }
            });

        // Send document expiry reminders
        Document::where('status', 'active')
            ->where('expires_at', '>', now())
            ->where('expires_at', '<', now()->addDays(7))
            ->each(function ($document) {
                $this->sendDocumentExpiryReminder($document);
            });
    }

    /**
     * Send document expiry reminder
     */
    private function sendDocumentExpiryReminder(Document $document)
    {
        $shipment = $document->shipment;

        if ($shipment->user_id) {
            $shipment->user->notify(new DocumentExpiryReminder($document));
        }

        if ($shipment->shipper_email) {
            Notification::route('mail', $shipment->shipper_email)
                ->notify(new DocumentExpiryReminder($document));
        }
    }
}
