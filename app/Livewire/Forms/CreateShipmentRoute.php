<?php

namespace App\Livewire\Forms;

use App\Enums\ShipmentRouteStatusEnum;
use App\Models\ShipmentRoute;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class CreateShipmentRoute extends Component implements HasForms
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
                Forms\Components\TextInput::make('shipment_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('location')
                    ->required(),
                Forms\Components\TextInput::make('location_type'),
                Forms\Components\DateTimePicker::make('arrival_date')
                    ->required(),
                Forms\Components\DateTimePicker::make('departure_date'),
                Forms\Components\DateTimePicker::make('actual_arrival_date'),
                Forms\Components\DateTimePicker::make('actual_departure_date'),
                Forms\Components\Select::make('status')
                    ->options(ShipmentRouteStatusEnum::class)
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ])
            ->statePath('data')
            ->model(ShipmentRoute::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = ShipmentRoute::create($data);

        $this->form->model($record)->saveRelationships();
    }

    public function render(): View
    {
        return view('livewire.forms.create-shipment-route');
    }
}
