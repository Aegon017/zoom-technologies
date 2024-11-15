<?php

namespace App\Filament\Resources\CorporateTrainingResource\Pages;

use App\Filament\Resources\CorporateTrainingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCorporateTrainings extends ListRecords
{
    protected static string $resource = CorporateTrainingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
