<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum UserRoleEnum : string implements HasLabel
{
    case CLIENT = 'client';
    case USER = 'user';

    case ADMIN = 'admin';

    public function getLabel(): string
    {
        return $this->name;
    }
}
