<?php

namespace App\Filament\Resources\PromoSectionResource\Pages;

use App\Filament\Resources\PromoSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPromoSection extends EditRecord
{
    protected static string $resource = PromoSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
