<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Str;

enum ShipmentTypeEnum: string implements HasLabel
{
case AIR = 'air';
case SEA='sea';
//case ROAD ='road';
//case RAIL = 'rail';

    public function getLabel(): ?string
    {
        return Str::of($this->name)->replace('_',' ');
    }
}
