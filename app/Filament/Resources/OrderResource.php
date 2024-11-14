<?php

namespace App\Filament\Resources;

use App\Filament\Exports\OrderExporter;
use App\Filament\Resources\OrderResource\Pages;
use App\Models\Course;
use App\Models\Order;
use App\Models\Package;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\ExportAction as ActionsExportAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action as ActionsAction;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Filament\Tables\Filters\DateFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use OpenSpout\Writer\AutoFilter;
use App\Models\OrderSchedule;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?int $navigationSort = 2;
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
                    TextEntry::make('course_name'),
                    TextEntry::make('course_price')->prefix('Rs. ')->suffix('/-'),
                    TextEntry::make('course_schedule')->label('Course Schedule')->getStateUsing(fn($record) => is_array($courseSchedule = json_decode(html_entity_decode($record->course_schedule), true)) && !empty($courseSchedule) ? collect($courseSchedule)->map(fn($item) => count($courseDetails = explode(',', $item)) === 2 ? "<strong>{$courseDetails[0]}</strong> - " . Carbon::parse(preg_replace('/\s+Online$|\s+Classroom$/', '', trim($courseDetails[1])))->format('l, F j, Y g:i A') : 'Invalid date')->implode('<br>') : (is_string($record->course_schedule) && !empty($record->course_schedule) ? htmlspecialchars($record->course_schedule) : 'No course schedule available.'))->html()
                ]),
                Fieldset::make('Payment Details')->schema([
                    TextEntry::make('order_number'),
                    TextEntry::make('transaction_id'),
                    TextEntry::make('payu_id'),
                    TextEntry::make('payment_time')->getStateUsing(fn($record) => Carbon::parse($record->payment_time)->format('F j, Y g:i A')),
                    TextEntry::make('cgst')->label('C.GST')->prefix('Rs. ')->suffix('/-'),
                    TextEntry::make('amount')->label('Order Amount')->prefix('Rs. ')->suffix('/-'),
                    TextEntry::make('status'),
                    TextEntry::make('payment_desc'),
                    TextEntry::make('payment_mode')->default('-'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ExportAction::make()->exporter(OrderExporter::class)
            ])
            ->columns([
                TextColumn::make('#')->rowIndex(),
                TextColumn::make('order_number')->searchable(),
                TextColumn::make('user.name')->searchable(),
                TextColumn::make('course_name'),
                TextColumn::make('amount')->label('Order Amount')->prefix('Rs. ')->suffix('/-'),
                TextColumn::make('payment_time')->getStateUsing(fn($record) => Carbon::parse($record->payment_time)->format('F j, Y g:i A')),
                TextColumn::make('status'),
            ])->defaultSort('payment_time', 'desc')
            ->filters([
                SelectFilter::make('course_name')
                    ->options(
                        array_merge(
                            Course::pluck('name', 'name')->toArray(),
                            Package::pluck('name', 'name')->toArray()
                        )
                    )
                    ->searchable(),
                SelectFilter::make('training_mode')
                    ->relationship('orderSchedule', 'training_mode')
                    ->preload(),
                SelectFilter::make('status')
                    ->options([
                        'success' => 'Success',
                        'failure' => 'Failure',
                    ]),
                Filter::make('order_date_range')
                    ->label('Order Date Range')
                    ->form([
                        DatePicker::make('start_date')->label('Start Date'),
                        DatePicker::make('end_date')->label('End Date'),
                    ])
                    ->query(function ($query, $data) {
                        if (isset($data['start_date']) && isset($data['end_date'])) {
                            $query->whereDate('payment_time', '>=', $data['start_date'])
                                ->whereDate('payment_time', '<=', $data['end_date']);
                        }
                    }),
            ])
            ->actions([
                // ExportAction::make()->exporter(OrderExporter::class),
                ActionsAction::make('invoice')
                    ->label('Download Invoice')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($record) {
                        return response()->download(public_path($record->invoice));
                    }),
                ViewAction::make()
            ])
            ->bulkActions([
                // ExportBulkAction::make(OrderExporter::class),
                BulkAction::make('invoice')
                    ->label('Download Invoices')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($records) {
                        $zip = new ZipArchive;
                        $zipFileName = storage_path('app/public/invoices.zip');
                        if (file_exists($zipFileName)) {
                            unlink($zipFileName);
                        }
                        if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
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
                    })
            ]);
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
