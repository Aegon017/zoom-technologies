<?php

namespace App\Filament\Resources\SingleCourseResource\Pages;

use App\Filament\Resources\SingleCourseResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateSingleCourse extends CreateRecord
{
    protected static string $resource = SingleCourseResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Enrolled Successfully!';
    }

    protected function getCreateAnotherFormAction(): Action
    {
        return parent::getCreateAnotherFormAction()
            ->label('Enroll & enroll another');
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label('Enroll');
    }
}
