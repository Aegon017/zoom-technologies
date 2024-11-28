<?php

namespace App\Filament\Resources\SingleCourseResource\Pages;

use App\Filament\Resources\SingleCourseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSingleCourse extends EditRecord
{
    protected static string $resource = SingleCourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
