<?php

namespace App\Observers;

use App\Models\Shipment;
use App\Enums\ShipmentStatusEnum;

class ShipmentObserver
{
    /**
     * Handle the Shipment "creating" event.
     */
    public function creating(Shipment $shipment): void
    {
        if (empty($shipment->status)){
            $shipment->status = ShipmentStatusEnum::PENDING;
        }
    }

    /**
     * Handle the Shipment "created" event.
     */
    public function created(Shipment $shipment): void
    {
        //
    }

    /**
     * Handle the Shipment "updated" event.
     */
    public function updated(Shipment $shipment): void
    {
        //
    }

    /**
     * Handle the Shipment "deleted" event.
     */
    public function deleted(Shipment $shipment): void
    {
        //
    }

    /**
     * Handle the Shipment "restored" event.
     */
    public function restored(Shipment $shipment): void
    {
        //
    }

    /**
     * Handle the Shipment "force deleted" event.
     */
    public function forceDeleted(Shipment $shipment): void
    {
        //
    }
}
