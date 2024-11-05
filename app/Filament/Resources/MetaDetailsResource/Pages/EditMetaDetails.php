<?php

namespace App\Filament\Resources\MetaDetailsResource\Pages;

use App\Filament\Resources\MetaDetailsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMetaDetails extends EditRecord
{
    protected static string $resource = MetaDetailsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
