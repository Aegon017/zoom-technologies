<?php

namespace App\Filament\Resources\SingleCourseResource\Pages;

use App\Filament\Resources\SingleCourseResource;
use App\Models\ManualOrder;
use App\Models\User;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\Actions\Action as ActionsAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;

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
            !empty(User::where('email', $data['user_email'])->exists() ? '' : 'email') &&
            !empty(User::where('phone', $data['user_phone'])->exists() ? '' : 'phone') &&
            !empty($data['course_id']) &&
            !empty($data['training_mode']) &&
            !empty($data['schedule_id']) &&
            !empty($data['course_price']) &&
            !empty($data['cgst']) &&
            !empty($data['sgst']) &&
            !empty($data['amount']) &&
            !empty($data['payment_mode']) &&
            !empty($data['proof']);
    }
}
