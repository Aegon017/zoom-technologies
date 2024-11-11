<?php

namespace App\Filament\Resources\PageSchemaResource\Pages;

use App\Filament\Resources\PageSchemaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPageSchemas extends ListRecords
{
    protected static string $resource = PageSchemaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
