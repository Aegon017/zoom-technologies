<?php

namespace App\Filament\Pages;

use App\Models\Order;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group as ComponentsGroup;
use Filament\Pages\Page;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SummaryReports extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.summary-reports';

    public static function table(Table $table): Table
    {
        return $table
            ->query(Order::whereHas('payment', fn(Builder $query) => $query->where('status', 'success')))
            ->defaultGroup('course.name')
            ->columns([
                TextColumn::make('#')->rowIndex(),
                TextColumn::make('schedule.start_date'),
                TextColumn::make('schedule.time'),
            ])
            ->filters([
                Filter::make('order_date_range')
                    ->label('Order Date Range')
                    ->form([
                        ComponentsGroup::make()->schema([
                            DatePicker::make('start_date')->maxDate(today())->label('Start Date')->required(),
                            DatePicker::make('end_date')->label('End Date')->default(today())->required(),
                        ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['start_date'] && $data['end_date'],
                            fn(Builder $query): Builder => $query->whereHas(
                                'payment',
                                fn(Builder $query): Builder => $query->whereBetween(
                                    'payments.date',
                                    [$data['start_date'], $data['end_date']]
                                )
                            )
                        );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['start_date'] && $data['end_date']) {
                            $indicators[] = Indicator::make('From: ' . $data['start_date'] . ' To: ' . $data['end_date'])
                                ->removeField('start_date')
                                ->removeField('end_date');
                        }

                        return $indicators;
                    }),
                SelectFilter::make('enrolled_by')
                    ->options(Order::pluck('enrolled_by', 'enrolled_by'))
                    ->searchable()
                    ->columnSpan(2),
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }
}
