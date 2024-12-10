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

    public function hasDeparted(): bool
    {
        return match ($this){
            self::IN_TRANSIT, self::CUSTOMS, self::DELIVERED, self::OUT_FOR_DELIVERY, self::PICKED_UP => true,
            default => false
        };
    }

    public function hasArrived(): bool
    {
        return match ($this){
            self::DELIVERED, self::PICKED_UP => true,
            default => false
        };
    }
}
