<?php
namespace App\Livewire\Admin;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Shipment;
use App\Services\DocumentGenerationService;

class ShipmentDocumentGenerator extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public $shipment;
    public $documentType = 'airway_bill';
    public $success = false;
    public $error = null;

    protected $rules = [
        'documentType' => 'required|in:airway_bill,bill_of_lading',
    ];

    public function mount(Shipment $shipment)
    {
        $this->shipment = $shipment;
    }

    public function getDocumentAction(): Action
    {
        return Action::make('getDocument')
            ->link()
            ->action(function () {
                try {
                    $generator = new DocumentGenerationService();
                    $generator->generateInitialDocuments($this->shipment);
                    Notification::make()
                        ->title('Success!')
                        ->success()
                        ->send();
                    redirect()->route('admin.shipments.show', $this->shipment);
                } catch (\Exception $e){
                    Log::error($e->getMessage());
                    Notification::make()
                        ->title('Something went wrong')
                        ->danger()
                        ->send();
                }
            });
    }
    public function render()
    {
        return view('livewire.admin.shipment-document-generator');
    }
}
