<?php

namespace App\Filament\Resources\BatchResource\Pages;

use App\Filament\Resources\BatchResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListBatches extends ListRecords
{
    protected static string $resource = BatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            false => Tab::make('Past schedules')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', false)),
            true => Tab::make('Upcoming schedules')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', true)),
        ];
    }
}
