<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum DistanceUnitEnum : string implements HasLabel
{
    case CM = 'cm';
    case INCH = 'inches';

    public function getLabel(): ?string
    {
        return $this->value;
    }
}
