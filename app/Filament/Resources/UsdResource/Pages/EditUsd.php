<?php

namespace App\Filament\Resources\UsdResource\Pages;

use App\Filament\Resources\UsdResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUsd extends EditRecord
{
    protected static string $resource = UsdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
