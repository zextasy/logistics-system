<?php

namespace App\Helpers\Filament\Forms;

use App\Enums\ShipmentRouteStatusEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class FilamentShipmentRouteFormHelper
{

    public function getCreateFormSchema(): array
    {
        return [
            ...$this->getRequiredFields(),
            ...$this->getOptionalFields(),
        ];

    }

    public function getEditFormSchema(): array
    {
        return [
            ...$this->getStatusFields(),
            ...$this->getRequiredFields(),
            ...$this->getActualDateFields(),
            ...$this->getOptionalFields(),
        ];

    }

    private function getRequiredFields(): array
    {
        return [
            TextInput::make('location')
                ->required(),
            Fieldset::make('Expected Dates')->schema([
                DatePicker::make('arrival_date')
                    ->required(),
                DatePicker::make('departure_date'),
            ]),
        ];
    }

    private function getOptionalFields(): array
    {
        return [
            Textarea::make('notes')
                ->columnSpanFull(),
        ];
    }

    private function getActualDateFields(): array
    {
        return [
            Fieldset::make('Actual Dates')->schema([
                DatePicker::make('actual_arrival_date'),
                DatePicker::make('actual_departure_date'),
            ]),
        ];
    }

    private function getStatusFields(): array
    {
        return [
            Select::make('status')
                ->options(ShipmentRouteStatusEnum::class)
                ->required(),
        ];
    }
}
