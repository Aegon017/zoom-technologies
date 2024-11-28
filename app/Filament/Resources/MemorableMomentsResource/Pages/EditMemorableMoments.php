<?php

namespace App\Filament\Resources\MemorableMomentsResource\Pages;

use App\Filament\Resources\MemorableMomentsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMemorableMoments extends EditRecord
{
    protected static string $resource = MemorableMomentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
