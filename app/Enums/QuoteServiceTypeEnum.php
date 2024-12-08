<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Str;

enum QuoteServiceTypeEnum: string implements HasLabel
{
case AIR = 'air_freight';
case SEA='sea_freight';
//case ROAD ='road';
//case RAIL = 'rail';

    public function getLabel(): ?string
    {
        return Str::replace('_',' ',$this->value);
    }
}
