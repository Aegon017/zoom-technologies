<?php

namespace App\Filament\Resources\FreeStudentResource\Pages;

use App\Filament\Resources\FreeStudentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFreeStudents extends ListRecords
{
    protected static string $resource = FreeStudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
