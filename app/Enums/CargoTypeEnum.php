<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Str;

enum CargoTypeEnum : string implements HasLabel
{
    case GENERAL = 'general';
    case HAZARDOUS = 'hazardous';
    case PERISHABLE = 'perishable';
    case FRAGILE = 'fragile';
    case VALUABLE = 'valuable';

    public function getLabel(): string
    {
        return Str::of($this->name)->replace('_',' ')->toString();
    }
}
