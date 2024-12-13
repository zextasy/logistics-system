<?php

namespace App\Livewire\Forms;

use App\Enums\ContainerSizeEnum;
use App\Enums\DistanceUnitEnum;
use App\Helpers\Filament\Forms\FilamentShipmentFormHelper;
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
        $helper = new FilamentShipmentFormHelper();
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Shipment')
                        ->schema($helper->getShipmentFields()),
                    Wizard\Step::make('Origin and Destination')
                        ->schema($helper->getOriginAndDestinationFields()),
                    Wizard\Step::make('Contacts')
                        ->schema($helper->getContactFields()),
                    Wizard\Step::make('Extra Information')
                        ->schema($helper->getExtraInformationFields()),
                ])->columns(2)->submitAction(view('filament.wizard.submit-button'))
            ])
            ->statePath('data')
            ->model(Shipment::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();
        $data['user_id'] = auth()->id();
        $documentService = new DocumentGenerationService();
         $record = (new ShipmentService($documentService))->createShipment($data);

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
