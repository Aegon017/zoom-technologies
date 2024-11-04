<?php

namespace App\Filament\Resources\ContactLocationResource\Pages;

use App\Filament\Resources\ContactLocationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactLocations extends ListRecords
{
    protected static string $resource = ContactLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
