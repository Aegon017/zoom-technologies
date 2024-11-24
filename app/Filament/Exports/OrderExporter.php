<?php

namespace App\Filament\Exports;

use App\Models\Order;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class OrderExporter extends Exporter
{
    protected static ?string $model = Order::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('user.name')->label('User name'),
            ExportColumn::make('user.email')->label('User email'),
            ExportColumn::make('user.phone')->label('User phone'),
            ExportColumn::make('order_number'),
            ExportColumn::make('payment.payment_id')->label('Payment ID'),
            ExportColumn::make('payment.mode')->label('Payment mode'),
            ExportColumn::make('payment.date')->label('Payment date'),
            ExportColumn::make('payment.time')->label('Payment time'),
            ExportColumn::make('payment.description')->label('Payment description'),
            ExportColumn::make('Payment.status')->label('Payment status'),
            ExportColumn::make('course.name')->label('Course name'),
            ExportColumn::make('schedule.duration')->label('Duration'),
            ExportColumn::make('schedule.duration_type')->label('Duration type'),
            ExportColumn::make('schedule.start_date')->label('Batch date'),
            ExportColumn::make('schedule.time')->label('Batch date'),
            ExportColumn::make('schedule.training_mode')->label('Training mode'),
            ExportColumn::make('courseOrPackage_price')->label('Course price'),
            ExportColumn::make('sgst'),
            ExportColumn::make('cgst'),
            ExportColumn::make('payment.amount')->label('Payment amount'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your order export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
