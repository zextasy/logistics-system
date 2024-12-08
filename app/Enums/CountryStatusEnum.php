<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Str;

enum CountryStatusEnum : int implements HasLabel
{
    case ACTIVE = 1;
    case INACTIVE = 99;

    public function getLabel(): ?string
    {
        return Str::title($this->name);
    }
}
