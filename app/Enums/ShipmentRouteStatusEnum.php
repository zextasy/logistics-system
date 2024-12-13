<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Str;

enum ShipmentRouteStatusEnum : string implements HasLabel
{
    case PENDING = 'pending';
    case ARRIVED = 'arrived';
    case DEPARTED = 'departed';
    case SKIPPED = 'skipped';

    public function getLabel(): string
    {
        return Str::of($this->name)->replace('_',' ')->toString();
    }

    public function hasDeparted(): bool
    {
        return match ($this){
            self::DEPARTED => true,
            default => false
        };
    }

    public function hasArrived(): bool
    {
        return match ($this){
            self::ARRIVED, self::DEPARTED => true,
            default => false
        };
    }
}
