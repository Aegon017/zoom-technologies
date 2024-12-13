<?php

namespace App\Filament\Resources;

use App\Filament\Exports\OrderExporter;
use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\Schedule;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action as ActionsAction;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use ZipArchive;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Course Orders';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Fieldset::make('User Details')->schema([
                    TextEntry::make('user.name'),
                    TextEntry::make('user.email')->label('Email'),
                    TextEntry::make('user.phone')->label('Phone'),
                ]),
                Fieldset::make('Course Details')->schema([
                    TextEntry::make('course.name'),
                    TextEntry::make('courseOrPackage_price')
                        ->formatStateUsing(fn($state, $record) => $record->payment->currency . ' ' . $state),
                ]),
                Fieldset::make('Batches')->schema([
                    TextEntry::make('orderSchedule')
                        ->label('')
                        ->listWithLineBreaks()
                        ->getStateUsing(
                            fn($record) => $record->orderSchedule->isEmpty()
                                ? ['🚫 No Schedules Available']
                                : $record->orderSchedule
                                ->map(function ($os) {
                                    $s = $os->schedule;

                                    return $s ? [
                                        '📚 Course: ' . ($s->course?->name ?? 'N/A'),
                                        '📅 Date: ' . (
                                            $s->start_date
                                            ? \Carbon\Carbon::parse($s->start_date)->format('d M Y')
                                            : 'Unscheduled'
                                        ),
                                        '⏰ Time: ' . (
                                            $s->time
                                            ? \Carbon\Carbon::parse($s->time)->format('h:i A')
                                            : 'TBD'
                                        ),
                                        '🌐 Mode: ' . ($s->training_mode ?? 'Unspecified'),
                                    ] : ['⚠️ Invalid Schedule'];
                                })
                                ->flatten()
                                ->filter()
                                ->toArray()
                        )
                        ->placeholder('No schedule information'),
                ]),
                Fieldset::make('Payment Details')->schema([
                    TextEntry::make('order_number'),
                    TextEntry::make('payment.payment_id')->label('Payment ID'),
                    TextEntry::make('payment.method')->label('Method'),
                    TextEntry::make('payment.mode')->label('Mode')->default('N/A'),
                    TextEntry::make('payment.date')->label('Date')->date(),
                    TextEntry::make('payment.time')->label('Time')->time('h:i A'),
                    TextEntry::make('payment.description')->label('Description'),
                    TextEntry::make('cgst')
                        ->formatStateUsing(fn($state, $record) => $record->payment->currency . ' ' . $state)
                        ->label('C.GST'),
                    TextEntry::make('sgst')
                        ->formatStateUsing(fn($state, $record) => $record->payment->currency . ' ' . $state)
                        ->label('S.GST'),
                    TextEntry::make('payment.amount')
                        ->formatStateUsing(fn($state, $record) => $record->payment->currency . ' ' . $state)
                        ->label('Order Amount'),
                    TextEntry::make('payment.status'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ExportAction::make()->exporter(OrderExporter::class),
            ])
            ->columns([
                TextColumn::make('#')->rowIndex(),
                TextColumn::make('order_number')->searchable(),
                TextColumn::make('user.name')->searchable(),
                TextColumn::make('combined')
                    ->label('Course and Package Name')
                    ->getStateUsing(function ($record) {
                        $course = $record->course->name ?? $record->package->name;

                        return $course;
                    }),
                TextColumn::make('payment.amount')
                    ->label('Order Amount')
                    ->formatStateUsing(fn($state, $record) => $record->payment->currency . ' ' . $state),
                TextColumn::make('payment.date')->label('Payment date'),
                TextColumn::make('payment.time')->label('Payment time'),
                TextColumn::make('payment.status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'success' => 'success',
                        'failure' => 'danger',
                    }),
            ])
            ->filters([
                SelectFilter::make('course.name')
                    ->label('Single course')
                    ->relationship('course', 'name')
                    ->searchable()
                    ->preload()->columnSpan(2),
                SelectFilter::make('package.name')
                    ->label('Package course')
                    ->relationship('package', 'name')
                    ->searchable()
                    ->preload()->columnSpan(2),
                SelectFilter::make('training_mode')
                    ->label('Training mode')
                    ->options(
                        Schedule::distinct('training_mode')->pluck('training_mode')->toArray()
                    )
                    ->searchable()
                    ->query(fn(Builder $query, $data) => $query->when($data['value'] ?? null, fn(Builder $query, $value) => $query->whereHas('schedule', fn($query) => $query->where('training_mode', $value)))),
                SelectFilter::make('schedule.start_date')
                    ->label('Batch Date')
                    ->options(
                        Schedule::distinct('start_date')->pluck('start_date')->toArray()
                    )
                    ->searchable()
                    ->query(fn(Builder $query, $data) => $query->when($data['value'] ?? null, fn(Builder $query, $value) => $query->whereHas('schedule', fn($query) => $query->where('start_date', $value))))
                    ->preload()
                    ->columnSpan(2),
                SelectFilter::make('schedule.time')
                    ->label('Batch time')
                    ->options(
                        Schedule::distinct('time')->pluck('time')->toArray()
                    )
                    ->searchable()
                    ->query(fn(Builder $query, $data) => $query->when($data['value'] ?? null, fn(Builder $query, $value) => $query->whereHas('schedule', fn($query) => $query->where('time', $value))))
                    ->preload(),
                Filter::make('order_date_range')
                    ->label('Order Date Range')
                    ->form([
                        DatePicker::make('start_date')->label('Start Date'),
                        DatePicker::make('end_date')->label('End Date'),
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
                    })->columns(2)->columnSpanFull(),

            ], layout: FiltersLayout::AboveContentCollapsible)->filtersFormColumns(4)
            ->actions([
                ActionsAction::make('invoice')
                    ->label('Download Invoice')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($record) {
                        return response()->download(public_path($record->invoice));
                    }),
                ViewAction::make(),
            ])
            ->bulkActions([
                BulkAction::make('invoice')
                    ->label('Download Invoices')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($records) {
                        $zip = new ZipArchive;
                        $zipFileName = storage_path('app/public/invoices.zip');
                        if (file_exists($zipFileName)) {
                            unlink($zipFileName);
                        }
                        if ($zip->open($zipFileName, ZipArchive::CREATE) === true) {
                            foreach ($records as $record) {
                                $filePath = public_path($record->invoice);
                                if (file_exists($filePath) && is_file($filePath)) {
                                    $zip->addFile($filePath, basename($filePath));
                                }
                            }
                            $zip->close();

                            return response()->download($zipFileName)->deleteFileAfterSend(true);
                        } else {
                            return back()->with('error', 'Unable to create the ZIP file.');
                        }
                    }),
            ])->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
        ];
    }
}
