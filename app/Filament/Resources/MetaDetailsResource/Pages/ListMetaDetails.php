<?php

namespace App\Filament\Resources\MetaDetailsResource\Pages;

use App\Filament\Resources\MetaDetailsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMetaDetails extends ListRecords
{
    protected static string $resource = MetaDetailsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
