<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Str;

enum ShipmentStatusEnum : string implements HasLabel, HasColor
{
    case PENDING = 'pending';
    case PICKED_UP = 'picked_up';
    case ON_TRANSIT = 'on_transit';
    case CUSTOMS = 'customs';
    case OUT_FOR_DELIVERY = 'out_for_delivery';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';
    case ON_HOLD = 'on_hold';

    public function getLabel(): string
    {
        return Str::of($this->name)->replace('_',' ')->toString();
    }

    public function getColor(): string
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::DELIVERED => 'success',
            self::ON_TRANSIT => 'info',
            self::CANCELLED, self::ON_HOLD => 'danger',
            default => 'gray',
        };
    }
    public function hasDeparted(): bool
    {
        return match ($this){
            self::ON_TRANSIT, self::CUSTOMS, self::DELIVERED, self::OUT_FOR_DELIVERY, self::PICKED_UP => true,
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

    public function isOptionDisabled(): bool
    {
        return match ($this){
            self::DELIVERED, self::ON_TRANSIT, self::PENDING => false,
            default => true
        };
    }
}
