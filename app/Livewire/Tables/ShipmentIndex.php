<?php

namespace App\Livewire\Tables;

use App\Enums\QuoteServiceTypeEnum;
use App\Enums\QuoteStatusEnum;
use App\Enums\ShipmentServiceTypeEnum;
use App\Enums\ShipmentStatusEnum;
use App\Enums\ShipmentTypeEnum;
use App\Models\Quote;
use App\Models\Shipment;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
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
            ->query(Shipment::query()
            ->with(['user', 'routes', 'documents','originCountry','originCity','destinationCountry','destinationCity'])
            ->latest()
            )
            ->columns([
                TextColumn::make('tracking_number')
                    ->searchable()
                    ->description(fn (Shipment $record): string => $record->type->getLabel()),
                TextColumn::make('origin_country_name')
                    ->label('Route')
                    ->description(fn (Shipment $record): string => '-> '.$record->destination_country_name),
                TextColumn::make('shipper_name')
                    ->label('Customer')
                    ->searchable()
                    ->description(fn (Shipment $record): string => $record->consignee_name),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('loading_port')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('discharge_port')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('estimated_delivery')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('actual_delivery')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('date_of_shipment')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        ShipmentStatusEnum::PENDING->value => ShipmentStatusEnum::PENDING->getLabel(),
                        ShipmentStatusEnum::ON_TRANSIT->value => ShipmentStatusEnum::ON_TRANSIT->getLabel(),
                        ShipmentStatusEnum::DELIVERED->value => ShipmentStatusEnum::DELIVERED->getLabel(),
                    ]),
                SelectFilter::make('type')
                    ->options(ShipmentTypeEnum::class),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])->columns(2)
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ], layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(3)
            ->actions([
                Action::make('view')
                    ->url(fn (Shipment $record): string => route('admin.shipments.show', $record))
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
