<?php

namespace App\Livewire\Tables;

use App\Enums\ShipmentRouteStatusEnum;
use App\Helpers\Filament\Forms\FilamentShipmentRouteFormHelper;
use App\Helpers\Filament\Forms\FilamentUserFormHelper;
use App\Models\Shipment;
use App\Models\ShipmentRoute;
use App\Models\User;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class ShipmentRouteIndex extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public $shipment;

    public function mount(Shipment $shipment)
    {
        $this->shipment = $shipment;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(ShipmentRoute::query()->where('shipment_id', $this->shipment->id)->orderBy('arrival_date'))
            ->columns([
                Tables\Columns\TextColumn::make('location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('arrival_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('departure_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('actual_arrival_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('actual_departure_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->sortable()
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()
                    ->form((new FilamentShipmentRouteFormHelper())->getEditFormSchema()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Add Route')
                    ->model(ShipmentRoute::class)
                    ->form((new FilamentShipmentRouteFormHelper())->getCreateFormSchema())
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['shipment_id'] = $this->shipment->id;
                        return $data;
                    }),
            ]);
    }

    public function render(): View
    {
        return view('livewire.tables.shipment-route-index');
    }
}
