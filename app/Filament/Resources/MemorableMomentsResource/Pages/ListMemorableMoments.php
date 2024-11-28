<?php

namespace App\Filament\Resources\MemorableMomentsResource\Pages;

use App\Filament\Resources\MemorableMomentsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMemorableMoments extends ListRecords
{
    protected static string $resource = MemorableMomentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
