<?php

namespace App\Helpers\Filament\Forms;

use App\Enums\ContainerSizeEnum;
use App\Enums\DistanceUnitEnum;
use App\Enums\ShipmentServiceTypeEnum;
use App\Enums\ShipmentTypeEnum;
use App\Enums\UserRoleEnum;
use App\Enums\WeightUnitEnum;
use App\Models\City;
use App\Models\Country;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Nnjeim\World\Models\Currency;

class FilamentShipmentFormHelper
{


    public function getCreateFormSchema(): array
    {
        return [
            ...$this->getShipmentFields(),
            ...$this->getContactFields(),
            ...$this->getOriginAndDestinationFields(),
        ];
    }

    public function getEditFormSchema(): array
    {
        return [
            ...$this->getShipmentFields(),
            ...$this->getOriginAndDestinationFields(),
        ];
    }
    public function getShipmentFields(bool $creating = true, bool $editing = true): array
    {
        return [
            Fieldset::make('Shipment')
                ->schema([
                    Select::make('type')
                        ->options(ShipmentTypeEnum::class)
                        ->required()->visible($creating),
                    Select::make('service_type')
                        ->options(ShipmentServiceTypeEnum::class)
                        ->required(),
                    Textarea::make('description')
                        ->required()
                        ->columnSpanFull(),
                    Select::make('container_size')->options(ContainerSizeEnum::class),
                    TextInput::make('vessel'),
                ]),
            Fieldset::make('Weight')
                ->schema([
                    TextInput::make('weight')
                        ->required()
                        ->numeric(),
                    Select::make('weight_unit')
                        ->options(WeightUnitEnum::class)
                        ->required(),
                ]),
            Fieldset::make('Dimensions')
                ->schema([
                    TextInput::make('dimensions.length')
                        ->numeric(),
                    TextInput::make('dimensions.width')
                        ->numeric(),
                    TextInput::make('dimensions.height')
                        ->numeric(),
                    Select::make('dimensions.unit')
                        ->options(DistanceUnitEnum::class),
                ])
                ->columns(4),
            Fieldset::make('Dates')
                ->schema([
                    DatePicker::make('date_of_shipment'),
                    DatePicker::make('estimated_delivery')
                        ->required(),
                    DatePicker::make('actual_delivery'),
                ])
                ->columns(3),
        ];
    }

    public function getOriginAndDestinationFields(bool $creating = true, bool $editing = true): array
    {
        $helper = new FilamentShipmentRouteFormHelper();
        return [
            Fieldset::make('Origin')
                ->schema([
                    Select::make('origin_country_id')
                        ->label('Origin Country')
                        ->options(Country::query()->active()->pluck('name','id'))
                        ->searchable()
                        ->required()
                        ->live(),
                    Select::make('origin_city_id')
                        ->label('Origin City')
                        ->options(fn (Get $get) => City::query()
                            ->where('country_id', $get('origin_country_id'))
                            ->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                    TextInput::make('loading_port'),
                    TextInput::make('origin_address'),
                    TextInput::make('origin_postal_code'),
                ]),
            Fieldset::make('Destination')
                ->schema([
                    Select::make('destination_country_id')
                        ->label('Destination Country')
                        ->options(Country::query()->active()->pluck('name','id'))
                        ->searchable()
                        ->required()
                        ->live(),
                    Select::make('destination_city_id')
                        ->label('Destination City')
                        ->options(fn (Get $get) => City::query()
                            ->where('country_id', $get('destination_country_id'))
                            ->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                    TextInput::make('discharge_port'),
                    TextInput::make('destination_address'),
                    TextInput::make('destination_postal_code'),
                    TextInput::make('final_place_for_delivery'),
                ]),
            Repeater::make('routes')
                ->schema($helper->getCreateFormSchema())
                ->columns(2)
                ->defaultItems(0)
                ->visible($creating)
        ];
    }


    public function getContactFields(bool $creating = true, bool $editing = true): array
    {
        return [
            Fieldset::make('Shipper')
                ->schema([
                    TextInput::make('shipper_name')
                        ->required(),
                    TextInput::make('shipper_phone')
                        ->tel(),
                    TextInput::make('shipper_email')
                        ->email(),
                    TextArea::make('shipper_address'),
                ]),
            Fieldset::make('Notify Party')
                ->schema([
                    TextInput::make('notify_party_name')
                        ->required(),
                    TextInput::make('notify_party_phone')
                        ->tel(),
                    TextInput::make('notify_party_email')
                        ->email(),
                    TextArea::make('notify_party_address'),
                ]),
            Fieldset::make('Consignee')
                ->schema([
                    TextInput::make('consignee_name')
                        ->required(),
                    TextInput::make('consignee_phone')
                        ->tel(),
                    TextInput::make('consignee_email')
                        ->email(),
                    TextArea::make('consignee_address'),
                ]),
        ];
    }

    public function getExtraInformationFields(bool $creating = true, bool $editing = true)
    {
        return[
            Textarea::make('special_instructions')
                ->columnSpanFull(),
            TextInput::make('declared_value')
                ->numeric(),
            Select::make('currency')
                ->options(Currency::all()->pluck('symbol')),
            Toggle::make('insurance_required')
                ->required(),
            TextInput::make('insurance_amount')
                ->numeric(),
        ];
    }
}
