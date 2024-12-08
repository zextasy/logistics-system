<?php

namespace App\Livewire\Forms;

use App\Enums\ContainerSizeEnum;
use App\Enums\DistanceUnitEnum;
use App\Models\City;
use App\Models\Country;
use App\Models\Shipment;
use App\Services\DocumentGenerationService;
use App\Services\NotificationService;
use App\Services\ShipmentService;
use App\Enums\ShipmentServiceTypeEnum;
use App\Enums\ShipmentTypeEnum;
use App\Enums\WeightUnitEnum;
use Filament\Forms;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Nnjeim\World\Models\Currency;

class CreateShipment extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Shipment')
                        ->schema([
                            Select::make('type')
                                ->options(ShipmentTypeEnum::class)
                                ->required(),
                            Select::make('service_type')
                                ->options(ShipmentServiceTypeEnum::class)
                                ->required(),
                            Textarea::make('description')
                                ->required()
                                ->columnSpanFull(),
                            TextInput::make('weight')
                                ->required()
                                ->numeric(),
                            Select::make('weight_unit')
                                ->options(WeightUnitEnum::class)
                                ->required(),
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
                                ]),
                            Select::make('container_size')->options(ContainerSizeEnum::class),
                            TextInput::make('vessel'),
                            DateTimePicker::make('estimated_delivery')
                                ->required(),
                        ]),
                    Wizard\Step::make('Origin and Destination')
                        ->schema([
                            Fieldset::make('Origin')
                                ->schema([
                                    Select::make('origin_country_id')
                                        ->label('Origin Country')
                                        ->options(Country::all()->pluck('name','id'))
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
                                        ->options(Country::all()->pluck('name','id'))
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
                                ]),
                            Repeater::make('routes')
                                ->schema([
                                    TextInput::make('location')
                                        ->required(),
                                    TextInput::make('location_type'),
                                    DateTimePicker::make('arrival_date')
                                        ->required(),
                                    DateTimePicker::make('departure_date'),
                                    TextInput::make('carrier'),
                                    TextInput::make('vessel_number'),
                                    TextInput::make('container_number'),
                                    Textarea::make('notes')
                                        ->columnSpanFull(),
                                ])
                                ->columns(2)
                                ->defaultItems(0)
                        ]),
                    Wizard\Step::make('Contacts')
                        ->schema([
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
                            Fieldset::make('Receiver')
                                ->schema([
                                    TextInput::make('receiver_name')
                                        ->required(),
                                    TextInput::make('receiver_phone')
                                        ->tel(),
                                    TextInput::make('receiver_email')
                                        ->email(),
                                    TextArea::make('receiver_address'),
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
                        ]),
                    Wizard\Step::make('Extra Information')
                        ->schema([
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
                        ]),
                ])->columns(2)->submitAction(view('filament.wizard.submit-button'))
            ])
            ->statePath('data')
            ->model(Shipment::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();
        $data['user_id'] = auth()->id();
        $notificationService = new NotificationService();
        $documentService = new DocumentGenerationService();
         $record = (new ShipmentService($notificationService, $documentService))->createShipment($data);

        $this->form->model($record)->saveRelationships();
        Notification::make()
            ->title('Success!')
            ->success()
            ->send();
        $this->redirect(route('admin.shipments.index'));
    }

    public function render(): View
    {
        return view('livewire.forms.create-shipment');
    }
}
