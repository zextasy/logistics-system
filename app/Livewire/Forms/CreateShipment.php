<?php

namespace App\Livewire\Forms;

use App\Helpers\Filament\Forms\FilamentShipmentFormHelper;
use App\Models\Shipment;
use App\Services\DocumentGenerationService;
use App\Services\ShipmentService;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Component;

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
