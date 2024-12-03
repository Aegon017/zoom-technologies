<?php

namespace App\Filament\Resources\ThankyouResource\Pages;

use App\Filament\Resources\ThankyouResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListThankyous extends ListRecords
{
    protected static string $resource = ThankyouResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
