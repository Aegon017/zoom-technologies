<?php

namespace App\Filament\Pages;

use App\Models\Order;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group as ComponentsGroup;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SummaryReports extends Page
{
    use HasPageShield;
    public $orders;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.summary-reports';

    public function mount()
    {
        $this->orders = Order::with(['schedule.course', 'user', 'payment'])
            ->whereHas('payment', fn($query) => $query->where('status', 'success'))
            ->get();
        dd($this->orders);
    }
}
