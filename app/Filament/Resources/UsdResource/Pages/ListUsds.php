<?php

namespace App\Filament\Resources\UsdResource\Pages;

use App\Filament\Resources\UsdResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsds extends ListRecords
{
    protected static string $resource = UsdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
