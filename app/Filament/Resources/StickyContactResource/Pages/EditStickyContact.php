<?php

namespace App\Filament\Resources\StickyContactResource\Pages;

use App\Filament\Resources\StickyContactResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStickyContact extends EditRecord
{
    protected static string $resource = StickyContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
