<?php

namespace App\Filament\Resources\OtherStudyMaterialResource\Pages;

use App\Filament\Resources\OtherStudyMaterialResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOtherStudyMaterials extends ListRecords
{
    protected static string $resource = OtherStudyMaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
