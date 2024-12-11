<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ShipmentRouteLocationTypeEnum : string implements HasLabel
{
    case AIRPORT = 'airport';
    case SEAPORT = 'seaport';
    case WAREHOUSE = 'warehouse';
    case CUSTOMS = 'customs';
    case DISTRIBUTION_CENTER = 'distribution_center';
    public function getLabel(): ?string
    {
        return $this->value;
    }
}
