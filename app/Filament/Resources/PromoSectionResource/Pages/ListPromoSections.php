<?php

namespace App\Filament\Resources\PromoSectionResource\Pages;

use App\Filament\Resources\PromoSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPromoSections extends ListRecords
{
    protected static string $resource = PromoSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
