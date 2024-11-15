<?php

namespace App\Filament\Resources\FaqsSectionResource\Pages;

use App\Filament\Resources\FaqsSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFaqsSections extends ListRecords
{
    protected static string $resource = FaqsSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
