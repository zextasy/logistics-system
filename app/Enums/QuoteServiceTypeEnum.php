<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Str;

enum QuoteServiceTypeEnum: string implements HasLabel, HasColor
{
case AIR = 'air_freight';
case SEA='sea_freight';
//case ROAD ='road_freight';
//case RAIL = 'rail_freight';
//case MULTI = 'multimodal';

    public function getLabel(): string
    {
        return Str::of($this->value)->replace('_',' ')->upper()->toString();
    }

    public function getColor(): string
    {
        return match ($this) {
            self::SEA => 'success',
            self::AIR => 'info',
        };
    }
}
