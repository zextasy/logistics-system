<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum CargoTypeEnum : string implements HasLabel
{
    case GENERAL = 'general';
    case HAZARDOUS = 'hazardous';
    case PERISHABLE = 'perishable';
    case FRAGILE = 'fragile';
    case VALUABLE = 'valuable';

    public function getLabel(): ?string
    {
        return $this->value;
    }
}
