<?php

namespace App\Filament\Resources\FeatureSectionResource\Pages;

use App\Filament\Resources\FeatureSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFeatureSection extends EditRecord
{
    protected static string $resource = FeatureSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
