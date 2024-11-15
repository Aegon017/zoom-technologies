<?php

namespace App\Filament\Resources\FreeMaterialSectionResource\Pages;

use App\Filament\Resources\FreeMaterialSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFreeMaterialSection extends EditRecord
{
    protected static string $resource = FreeMaterialSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
