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
            ExportColumn::make('transaction_id'),
            ExportColumn::make('payu_id'),
            ExportColumn::make('payment_mode'),
            ExportColumn::make('payment_time'),
            ExportColumn::make('payment_desc'),
            ExportColumn::make('amount'),
            ExportColumn::make('status'),
            ExportColumn::make('invoice'),
            ExportColumn::make('course_name'),
            ExportColumn::make('course_duration'),
            ExportColumn::make('course_duration_type'),
            ExportColumn::make('course_schedule'),
            ExportColumn::make('course_price'),
            ExportColumn::make('sgst'),
            ExportColumn::make('cgst'),
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
