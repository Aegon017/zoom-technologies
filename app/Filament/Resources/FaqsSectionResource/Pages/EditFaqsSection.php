<?php

namespace App\Filament\Resources\FaqsSectionResource\Pages;

use App\Filament\Resources\FaqsSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFaqsSection extends EditRecord
{
    protected static string $resource = FaqsSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
