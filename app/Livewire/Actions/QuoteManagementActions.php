<?php
namespace App\Livewire\Actions;

use App\Enums\QuoteStatusEnum;
use App\Helpers\Filament\Forms\FilamentShipmentFormHelper;
use App\Models\Quote;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Shipment;
use App\Services\DocumentGenerationService;

class QuoteManagementActions extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public $record;

    public function mount(Quote $record)
    {
        $this->record = $record;
    }

    public function editQuoteStatusAction(): Action
    {
        return EditAction::make('editQuoteStatus')
            ->label('Edit Quote Status')
            ->record($this->record)
            ->form([
                Select::make('status')
                    ->options(QuoteStatusEnum::class)
                    ->required()
            ])
            ->successRedirectUrl(route('admin.quotes.show', $this->record));
    }

    public function render()
    {
        return view('livewire.actions.quote-management-actions');
    }

}
