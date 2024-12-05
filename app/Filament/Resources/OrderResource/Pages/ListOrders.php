<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'success' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas('payment', fn($query) => $query->where('status', 'success'))),
            'failure' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas('payment', fn($query) => $query->where('status', 'failure'))),
        ];
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return "success";
    }
}
