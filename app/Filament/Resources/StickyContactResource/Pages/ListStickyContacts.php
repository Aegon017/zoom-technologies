<?php

namespace App\Filament\Resources\StickyContactResource\Pages;

use App\Filament\Resources\StickyContactResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStickyContacts extends ListRecords
{
    protected static string $resource = StickyContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
