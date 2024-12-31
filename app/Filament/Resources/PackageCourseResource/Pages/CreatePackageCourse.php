<?php

namespace App\Filament\Resources\PackageCourseResource\Pages;

use App\Filament\Resources\PackageCourseResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreatePackageCourse extends CreateRecord
{
    protected static string $resource = PackageCourseResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Enrolled Successfully!';
    }

    protected function getCreateAnotherFormAction(): Action
    {
        return parent::getCreateAnotherFormAction()
            ->label('Enroll & enroll anthor');
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label('Enroll');
    }
}
