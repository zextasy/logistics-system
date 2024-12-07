<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ContainerSizeEnum : string implements HasLabel
{
    case LCL = 'LCL';
    case TWENTY_FT = '20ft';
    case FORTY_FT = '40ft';
    case FORTY_FT_HC = '40ft_hc';

    public function getLabel(): ?string
    {
        return $this->value;
    }
}
