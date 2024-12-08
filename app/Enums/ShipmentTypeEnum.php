<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ShipmentTypeEnum: string implements HasLabel
{
case AIR = 'air';
case SEA='sea';
//case ROAD ='road';
//case RAIL = 'rail';

    public function getLabel(): ?string
    {
        return $this->value;
    }
}
