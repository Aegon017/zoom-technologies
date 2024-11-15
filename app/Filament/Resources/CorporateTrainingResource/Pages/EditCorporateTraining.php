<?php

namespace App\Filament\Resources\CorporateTrainingResource\Pages;

use App\Filament\Resources\CorporateTrainingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCorporateTraining extends EditRecord
{
    protected static string $resource = CorporateTrainingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
