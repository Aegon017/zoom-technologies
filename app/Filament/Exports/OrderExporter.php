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
            ExportColumn::make('order_number')->enabledByDefault(false),
            ExportColumn::make('payment.payment_id')->label('Payment ID')->enabledByDefault(false),
            ExportColumn::make('payment.mode')->label('Payment mode')->enabledByDefault(false),
            ExportColumn::make('payment.date')->label('Payment date')->enabledByDefault(false),
            ExportColumn::make('payment.time')->label('Payment time')->enabledByDefault(false),
            ExportColumn::make('payment.description')->label('Payment description')->enabledByDefault(false),
            ExportColumn::make('Payment.status')->label('Payment status')->enabledByDefault(false),
            ExportColumn::make('course.name')->label('Course name')->enabledByDefault(false),
            ExportColumn::make('schedule.duration')->label('Duration')->enabledByDefault(false),
            ExportColumn::make('schedule.duration_type')->label('Duration type')->enabledByDefault(false),
            ExportColumn::make('schedule.start_date')->label('Batch date')->enabledByDefault(false),
            ExportColumn::make('schedule.time')->label('Batch date')->enabledByDefault(false),
            ExportColumn::make('schedule.training_mode')->label('Training mode')->enabledByDefault(false),
            ExportColumn::make('courseOrPackage_price')->label('Course price')->enabledByDefault(false),
            ExportColumn::make('sgst')->enabledByDefault(false),
            ExportColumn::make('cgst')->enabledByDefault(false),
            ExportColumn::make('payment.amount')->label('Payment amount')->enabledByDefault(false),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your order export has completed and '.number_format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
