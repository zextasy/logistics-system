<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ShipmentServiceTypeEnum : string implements HasLabel
{
    case STANDARD = 'standard';
    case EXPRESS = 'express';
    case ECONOMY = 'economy';

    public function getLabel(): ?string
    {
        return $this->value;
    }
}
