<?php

namespace App\Helpers\Filament\Forms;

use App\Enums\UserRoleEnum;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class FilamentUserFormHelper
{


    public function getCreateFormSchema(): array
    {
        return [
            ...$this->getRequiredFields(),
            ...$this->getSensitiveFields(),
            ...$this->getOptionalFields(),
        ];
    }

    public function getEditFormSchema(): array
    {
        return [
            ...$this->getRequiredFields(),
            ...$this->getOptionalFields(),
        ];
    }
    private function getRequiredFields(): array
    {
        return [
            Fieldset::make('Details')
                ->schema([
                    Select::make('role')
                        ->options(UserRoleEnum::class)
                        ->disableOptionWhen(fn (string $value): bool => $value === UserRoleEnum::CLIENT)
                        ->required(),
                    TextInput::make('name')
                        ->required(),
                    TextInput::make('email')
                        ->email()
                        ->required(),
                ])->columns(3),
        ];
    }

    private function getSensitiveFields(): array
    {
        return [
            Fieldset::make('Password')
                ->schema([
                    TextInput::make('password')
                        ->password()
                        ->required(),
                ]),

        ];
    }

    private function getOptionalFields(): array
    {
        return [
            Fieldset::make('Contact')
                ->schema([
                    TextInput::make('phone')
                        ->tel(),
                    TextInput::make('company'),
                    Textarea::make('address')
                        ->columnSpanFull(),
                ]),
        ];
    }
}
