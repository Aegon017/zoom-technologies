<?php

namespace App\Filament\Resources\FeatureSectionResource\Pages;

use App\Filament\Resources\FeatureSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFeatureSections extends ListRecords
{
    protected static string $resource = FeatureSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
