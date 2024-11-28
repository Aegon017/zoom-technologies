<?php

namespace App\Filament\Resources\SingleCourseResource\Pages;

use App\Filament\Resources\SingleCourseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSingleCourses extends ListRecords
{
    protected static string $resource = SingleCourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
