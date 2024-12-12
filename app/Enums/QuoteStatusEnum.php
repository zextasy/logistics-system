<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Str;

enum QuoteStatusEnum: string implements HasLabel, HasColor
{
case PENDING = 'pending';
case PROCESSING='processing';
case QUOTED = 'quoted';
case REJECTED = 'rejected';

    public function getLabel(): ?string
    {
        return Str::replace('_',' ',$this->value);
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::QUOTED=> 'success',
            self::REJECTED => 'danger',
            self::PROCESSING => 'info',
        };
    }
}
