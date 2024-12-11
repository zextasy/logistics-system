<?php

namespace App\Helpers\Filament\Forms;

use App\Enums\ShipmentRouteStatusEnum;
use Filament\Forms\Components\DateTimePicker;
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
            ...$this->getRequiredFields(),
            ...$this->getActualDateFields(),
            ...$this->getOptionalFields(),
        ];

    }

    private function getRequiredFields()
    {
        return [
            TextInput::make('location')
                ->required(),
            Select::make('status')
                ->options(ShipmentRouteStatusEnum::class)
                ->required(),
            Fieldset::make('Expected Dates')->schema([
                DateTimePicker::make('arrival_date')
                    ->required(),
                DateTimePicker::make('departure_date'),
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

    private function getActualDateFields()
    {
        return [
            Fieldset::make('Actual Dates')->schema([
                DateTimePicker::make('actual_arrival_date'),
                DateTimePicker::make('actual_departure_date'),
            ]),
        ];
    }
}
