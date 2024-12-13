<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Str;

enum ContainerSizeEnum : string implements HasLabel
{
    case LCL = 'LCL';
    case TWENTY_FT = '20ft';
    case FORTY_FT = '40ft';
    case FORTY_FT_HC = '40ft_HC';

    public function getLabel(): string
    {
        return Str::of($this->value)->replace('_',' ')->toString();
    }
}
