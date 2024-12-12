<?php

namespace App\Livewire\Tables;

use App\Enums\QuoteServiceTypeEnum;
use App\Enums\QuoteStatusEnum;
use App\Models\Quote;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
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
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class QuoteIndex extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Quote::query()
                ->with(['user','country','originCountry','originCity','destinationCountry','destinationCity'])
                ->latest())
            ->columns([
                TextColumn::make('reference_number')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Customer')
                    ->searchable()
                    ->description(fn (Quote $record): string => $record->company),
                TextColumn::make('company')
                    ->searchable()->hidden(),
                TextColumn::make('service_type')
                    ->searchable()->badge(),
                TextColumn::make('origin_country_name')
                    ->label('Route')
                    ->description(fn (Quote $record): string => '-> '.$record->destination_country_name),
                TextColumn::make('status')
                    ->badge()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(QuoteStatusEnum::class),
                SelectFilter::make('service_type')
                    ->options(QuoteServiceTypeEnum::class),
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
                    ->url(fn (Quote $record): string => route('admin.quotes.show', $record))
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.tables.quote-index');
    }
}
