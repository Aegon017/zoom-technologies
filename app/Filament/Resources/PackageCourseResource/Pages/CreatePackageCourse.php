<?php

namespace App\Filament\Resources\PackageCourseResource\Pages;

use App\Filament\Resources\PackageCourseResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
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
            ->label('Enroll & enroll anthor')
            ->hidden(fn() => !$this->isFormValid());
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label('Enroll')
            ->hidden(fn() => !$this->isFormValid());
    }



    protected function isFormValid(): bool
    {
        $data = $this->form->getState();
        return !empty($data['user_name']) &&
            !empty($data['user_email']) &&
            !empty($data['user_phone']) &&
            !empty($data['package_id']) &&
            !empty($data['training_mode']) &&
            !empty($data['packageSchedule_id']) &&
            !empty($data['course_price']) &&
            !empty($data['cgst']) &&
            !empty($data['sgst']) &&
            !empty($data['amount']) &&
            !empty($data['payment_mode']) &&
            !empty($data['proof']);
    }
}
