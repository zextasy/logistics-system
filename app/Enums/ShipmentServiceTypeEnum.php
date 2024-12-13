<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Str;

enum ShipmentServiceTypeEnum : string implements HasLabel
{
    case STANDARD = 'standard';
    case EXPRESS = 'express';
    case ECONOMY = 'economy';

    public function getLabel(): string
    {
        return Str::of($this->name)->replace('_',' ')->toString();
    }
}
