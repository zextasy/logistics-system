<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum WeightUnitEnum : string implements HasLabel
{
    case KG = 'kg';
    case LBS = 'lbs';

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
