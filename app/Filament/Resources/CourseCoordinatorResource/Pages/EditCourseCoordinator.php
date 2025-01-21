<?php

namespace App\Filament\Resources\CourseCoordinatorResource\Pages;

use App\Filament\Resources\CourseCoordinatorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCourseCoordinator extends EditRecord
{
    protected static string $resource = CourseCoordinatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
