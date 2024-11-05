<?php

namespace App\Filament\Resources\PageMetaDetailsResource\Pages;

use App\Filament\Resources\PageMetaDetailsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPageMetaDetails extends ListRecords
{
    protected static string $resource = PageMetaDetailsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
