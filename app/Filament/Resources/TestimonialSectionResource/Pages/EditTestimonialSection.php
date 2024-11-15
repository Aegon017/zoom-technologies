<?php

namespace App\Filament\Resources\TestimonialSectionResource\Pages;

use App\Filament\Resources\TestimonialSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTestimonialSection extends EditRecord
{
    protected static string $resource = TestimonialSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
