<?php

namespace App\Filament\Resources\StudyMaterialPageResource\Pages;

use App\Filament\Resources\StudyMaterialPageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudyMaterialPages extends ListRecords
{
    protected static string $resource = StudyMaterialPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
