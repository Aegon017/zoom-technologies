<?php

namespace App\Filament\Resources\OtherStudyMaterialResource\Pages;

use App\Filament\Resources\OtherStudyMaterialResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOtherStudyMaterial extends EditRecord
{
    protected static string $resource = OtherStudyMaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
