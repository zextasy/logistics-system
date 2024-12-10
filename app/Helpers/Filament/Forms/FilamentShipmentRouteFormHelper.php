<?php

namespace App\Helpers\Filament\Forms;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class FilamentShipmentRouteFormHelper
{

    public function getFields()
    {
        return [
            TextInput::make('location')
                ->required(),
            Fieldset::make('Dates')->schema([
                DateTimePicker::make('arrival_date')
                    ->required(),
                DateTimePicker::make('departure_date'),
            ]),
            Textarea::make('notes')
                ->columnSpanFull(),
        ];
    }
}
