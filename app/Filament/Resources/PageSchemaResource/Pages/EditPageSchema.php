<?php

namespace App\Filament\Resources\PageSchemaResource\Pages;

use App\Filament\Resources\PageSchemaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPageSchema extends EditRecord
{
    protected static string $resource = PageSchemaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
