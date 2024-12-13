<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Str;

enum DistanceUnitEnum : string implements HasLabel
{
    case CM = 'cm';
    case INCHES = 'inches';

    public function getLabel(): string
    {
        return Str::of($this->name)->replace('_',' ')->toString();
    }
}
