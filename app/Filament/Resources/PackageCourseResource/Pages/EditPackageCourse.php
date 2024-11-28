<?php

namespace App\Filament\Resources\PackageCourseResource\Pages;

use App\Filament\Resources\PackageCourseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPackageCourse extends EditRecord
{
    protected static string $resource = PackageCourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
