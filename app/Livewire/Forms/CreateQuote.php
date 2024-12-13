<?php

namespace App\Livewire\Forms;

use App\Enums\CargoTypeEnum;
use App\Enums\ContainerSizeEnum;
use App\Enums\QuoteServiceTypeEnum;
use App\Enums\ShipmentServiceTypeEnum;
use App\Enums\ShipmentTypeEnum;
use App\Enums\WeightUnitEnum;
use App\Models\City;
use App\Models\Country;
use App\Models\Quote;
use App\Services\DocumentGenerationService;
use App\Services\NotificationService;
use App\Services\QuoteService;
use App\Services\ShipmentService;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class CreateQuote extends Component implements HasForms
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
                Fieldset::make('Contact Information')
                    ->schema([
                        TextInput::make('name')
                            ->label('Full Name')
                            ->required(),
                        TextInput::make('company')
                            ->label('Company Name')
                            ->required(),
                        TextInput::make('email')
                            ->email()
                            ->required(),
                        TextInput::make('phone')
                            ->tel(),
                        Select::make('country_id')
                            ->label('Country')
                            ->options(Country::all()->pluck('name','id'))
                            ->searchable()
                            ->required(),
                    ]),
                Fieldset::make('Shipment Details')
                    ->schema([
                        Select::make('service_type')
                            ->options(QuoteServiceTypeEnum::class)
                            ->required(),
                        Select::make('cargo_type')
                            ->options(CargoTypeEnum::class)
                            ->required(),
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
                            ->searchable(),
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
                    ]),
                Fieldset::make('Cargo Details')
                    ->schema([
                        Textarea::make('description')->label('Cargo Description')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('estimated_weight')
                            ->required()
                            ->numeric(),
                        Select::make('weight_unit')
                            ->options(WeightUnitEnum::class)
                            ->required(),
                        TextInput::make('pieces_count')
                            ->label('Number of Pieces')
                            ->numeric(),
                        Select::make('container_size')
                            ->options(ContainerSizeEnum::class),
                    ])->columns(4),
                Fieldset::make('Additional Services')
                    ->schema([
                        Toggle::make('insurance_required')
                            ->required(),
                        Toggle::make('customs_clearance_required')
                            ->required(),
                        Toggle::make('pickup_required')
                            ->required(),
                        Toggle::make('packing_required')
                            ->required(),
                        Textarea::make('special_requirements')
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data')
            ->model(Quote::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $documentService = new DocumentGenerationService();
        $shipmentService = new ShipmentService($documentService);

        $record = (new QuoteService($shipmentService))->createQuote($data);

        $this->form->model($record)->saveRelationships();
        Notification::make()
            ->title('Success!')
            ->success()
            ->send();
        $this->redirect(route('home'));
    }

    public function render(): View
    {
        return view('livewire.forms.create-quote');
    }
}
