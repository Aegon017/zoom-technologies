<?php

namespace App\Filament\Resources\ThankyouResource\Pages;

use App\Filament\Resources\ThankyouResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditThankyou extends EditRecord
{
    protected static string $resource = ThankyouResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
