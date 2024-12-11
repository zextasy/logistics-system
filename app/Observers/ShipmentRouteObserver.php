<?php

namespace App\Observers;

use App\Models\ShipmentRoute;
use App\Services\DocumentGenerationService;
use App\Services\NotificationService;
use App\Services\ShipmentService;

class ShipmentRouteObserver
{
    public function saving(ShipmentRoute $shipmentRoute): void
    {
        $shipmentRoute->calculateStatus();
    }

    public function saved(ShipmentRoute $shipmentRoute): void
    {
        $notificationService = new NotificationService();
        $documentService = new DocumentGenerationService();
        (new ShipmentService($notificationService, $documentService))->updateShipmentStatusViaRoutes($shipmentRoute->shipment);
    }
    /**
     * Handle the ShipmentRoute "created" event.
     */
    public function created(ShipmentRoute $shipmentRoute): void
    {
        //
    }

    /**
     * Handle the ShipmentRoute "updated" event.
     */
    public function updated(ShipmentRoute $shipmentRoute): void
    {
        //
    }

    /**
     * Handle the ShipmentRoute "deleted" event.
     */
    public function deleted(ShipmentRoute $shipmentRoute): void
    {
        //
    }

    /**
     * Handle the ShipmentRoute "restored" event.
     */
    public function restored(ShipmentRoute $shipmentRoute): void
    {
        //
    }

    /**
     * Handle the ShipmentRoute "force deleted" event.
     */
    public function forceDeleted(ShipmentRoute $shipmentRoute): void
    {
        //
    }

}
