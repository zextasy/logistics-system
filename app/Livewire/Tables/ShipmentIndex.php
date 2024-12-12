<?php

namespace App\Livewire\Tables;

use App\Models\Shipment;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class ShipmentIndex extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Shipment::query())
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tracking_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('originCountry.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('originCity.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('loading_port')
                    ->searchable(),
                Tables\Columns\TextColumn::make('origin_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('origin_postal_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('destinationCountry.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('destinationCity.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discharge_port')
                    ->searchable(),
                Tables\Columns\TextColumn::make('destination_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('destination_postal_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('final_place_for_delivery')
                    ->searchable(),
                Tables\Columns\TextColumn::make('weight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('weight_unit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('container_size')
                    ->searchable(),
                Tables\Columns\TextColumn::make('service_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('shipper_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('shipper_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('shipper_email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('shipper_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('receiver_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('receiver_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('receiver_email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('receiver_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('consignee_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('consignee_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('consignee_email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('consignee_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vessel')
                    ->searchable(),
                Tables\Columns\TextColumn::make('current_location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('estimated_delivery')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('actual_delivery')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_of_shipment')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customs_status')
                    ->searchable(),
                Tables\Columns\IconColumn::make('customs_cleared')
                    ->boolean(),
                Tables\Columns\TextColumn::make('declared_value')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency')
                    ->searchable(),
                Tables\Columns\IconColumn::make('insurance_required')
                    ->boolean(),
                Tables\Columns\TextColumn::make('insurance_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.tables.shipment-index');
    }
}
