<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ShipmentStatusEnum : string implements HasLabel
{
    case PENDING = 'pending';
    case PICKED_UP = 'picked_up';
    case IN_TRANSIT = 'in_transit';
    case CUSTOMS = 'customs';
    case OUT_FOR_DELIVERY = 'out_for_delivery';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';
    case ON_HOLD = 'on_hold';

    public function getLabel(): ?string
    {
        return $this->value;
    }
}
