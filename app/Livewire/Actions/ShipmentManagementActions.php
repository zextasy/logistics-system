<?php
namespace App\Livewire\Actions;

use App\Helpers\Filament\Forms\FilamentShipmentFormHelper;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Shipment;
use App\Services\DocumentGenerationService;

class ShipmentManagementActions extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public $shipment;

    public function mount(Shipment $shipment)
    {
        $this->shipment = $shipment;
    }

    public function confirmShipmentDateAction(): Action
    {
        return Action::make('confirmShipmentDate')
            ->form([
                DatePicker::make('date_of_shipment')
                    ->default(now()),
            ])
            ->icon('heroicon-m-calendar-date-range')
            ->action(function (array $data) {
                try {
                    $this->shipment->update($data);
                    $this->notifySuccess();
                    redirect()->route('admin.shipments.show', $this->shipment);
                } catch (\Exception $e){
                    Log::error($e->getMessage());
                    $this->notifyFailure();
                }
            });
    }
    public function editShipmentDetailsAction(): Action
    {
        $helper = new FilamentShipmentFormHelper();
        return EditAction::make('editShipmentDetails')
            ->label('Edit Shipment Details')
            ->record($this->shipment)
            ->form($helper->getShipmentFields(false,true))
            ->successRedirectUrl(route('admin.shipments.show', $this->shipment));
    }

    public function editOriginAndDestinationDetailsAction(): Action
    {
        $helper = new FilamentShipmentFormHelper();
        return EditAction::make('editOriginAndDestinationDetails')
            ->label('Edit Origin And Destination Details')
            ->record($this->shipment)
            ->form($helper->getOriginAndDestinationFields(false,true))
            ->successRedirectUrl(route('admin.shipments.show', $this->shipment));
    }
    public function editContactDetailsAction(): Action
    {
        $helper = new FilamentShipmentFormHelper();
        return EditAction::make('editContactDetails')
            ->label('Edit Contact Details')
            ->record($this->shipment)
            ->form($helper->getContactFields(false,true))
            ->successRedirectUrl(route('admin.shipments.show', $this->shipment));
    }
    public function editExtraDetailsAction(): Action
    {
        $helper = new FilamentShipmentFormHelper();
        return EditAction::make('editExtraDetails')
            ->label('Edit Extra Details')
            ->record($this->shipment)
            ->form($helper->getExtraInformationFields(false,true))
            ->successRedirectUrl(route('admin.shipments.show', $this->shipment));
    }

    public function previewInitialDocumentAction()
    {
        return Action::make('previewInitialDocument')
            ->label('Preview')
            ->icon('heroicon-m-eye')
            ->url(route('bvdh.documents.preview', $this->shipment->initialDocument))
            ->openUrlInNewTab();
    }

    public function previewInitialPdfAction()
    {
        return Action::make('previewInitialPdf')
            ->label('Preview PDF')
            ->icon('heroicon-m-document-text')
            ->url(route('bvdh.documents.preview-pdf', $this->shipment->initialDocument))
            ->openUrlInNewTab();
    }

    public function downloadInitialDocumentAction()
    {
        return Action::make('downloadInitialDocument')
            ->label('Download PDF')
            ->icon('heroicon-m-document-arrow-down')
            ->url(route('bvdh.documents.download', $this->shipment->initialDocument))
            ->openUrlInNewTab();
    }
    public function render()
    {
        return view('livewire.actions.shipment-management-actions');
    }

    private function notifySuccess()
    {
        Notification::make()
            ->title('Success!')
            ->success()
            ->send();
    }

    private function notifyFailure()
    {
        Notification::make()
            ->title('Something went wrong')
            ->danger()
            ->send();
    }
}
