<?php

namespace App\Filament\Resources\PackageCourseResource\Pages;

use App\Filament\Resources\PackageCourseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ListPackageCourses extends ListRecords
{
    protected static string $resource = PackageCourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

}
