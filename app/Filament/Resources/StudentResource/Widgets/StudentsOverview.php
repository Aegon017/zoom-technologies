<?php

namespace App\Filament\Resources\StudentResource\Widgets;

use App\Filament\Resources\StudentResource\Pages\ListStudents;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StudentsOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListStudents::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('No. of students', 'orders')
                ->value($this->getPageTableRecords()?->count())
                ->description('Total number of students')
                ->chart([5, 10, 15, 20, 25, 30])
                ->color('primary')
                ->icon('heroicon-o-user'),

            // Stat::make('Total Payments in Rs', 'payments_rs')
            //     ->value('Rs ' . $this->getPageTableRecords()?->where('payment.currency', 'Rs')->sum('payment.amount'))
            //     ->description('Total payments in Indian Rupees')
            //     ->chart([1000, 2000, 3000, 4000, 5000])
            //     ->color('success')
            //     ->icon('heroicon-o-currency-rupee'),

            // Stat::make('Total Payments in USD', 'payments_usd')
            //     ->value('USD ' . $this->getPageTableRecords()?->where('payment.currency', 'USD')->sum('payment.amount'))
            //     ->description('Total payments in US Dollars')
            //     ->chart([500, 1000, 1500, 2000, 2500])
            //     ->color('warning')
            //     ->icon('heroicon-o-currency-dollar'),
        ];
    }
}
