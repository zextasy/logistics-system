<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ShipmentRouteStatusEnum : string implements HasLabel
{
    case PENDING = 'pending';
    case ARRIVED = 'arrived';
    case DEPARTED = 'departed';
    case SKIPPED = 'skipped';

    public function getLabel(): ?string
    {
        return $this->value;
    }
}
